<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalEntryLine;
use App\Models\ManualTransaction;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exports\JurnalExport;
use Maatwebsite\Excel\Facades\Excel;

class KeuanganController extends Controller
{
    // ====================================================
    // HELPER PRIVATE — Buat Jurnal Otomatis
    // ====================================================

    /**
     * Buat jurnal dari transaksi manual (offline).
     * Pendapatan  → Kas (D) | Akun Pendapatan (K)
     * Pengeluaran → Akun Beban (D) | Kas (K)
     */
    private function buatJurnalDariManual(ManualTransaction $mt): void
    {
        // Cegah double jurnal
        if ($mt->jurnal_dibuat) return;

        $kas = Account::where('kode', '1-001')->firstOrFail();

        DB::transaction(function () use ($mt, $kas) {
            $noJurnal = JournalEntry::generateNoJurnal($mt->tanggal->toDateString());

            $entry = JournalEntry::create([
                'tanggal'        => $mt->tanggal,
                'no_jurnal'      => $noJurnal,
                'keterangan'     => $mt->deskripsi,
                'sumber'         => 'offline',
                'referensi_id'   => $mt->id,
                'referensi_tipe' => 'manual',
            ]);

            if ($mt->jenis === 'pendapatan') {
                // Debit: Kas
                JournalEntryLine::create([
                    'journal_entry_id' => $entry->id,
                    'account_id'       => $kas->id,
                    'posisi'           => 'debit',
                    'jumlah'           => $mt->jumlah,
                ]);
                // Kredit: Akun Pendapatan yang dipilih
                JournalEntryLine::create([
                    'journal_entry_id' => $entry->id,
                    'account_id'       => $mt->account_id,
                    'posisi'           => 'kredit',
                    'jumlah'           => $mt->jumlah,
                ]);
            } else {
                // Debit: Akun Beban yang dipilih
                JournalEntryLine::create([
                    'journal_entry_id' => $entry->id,
                    'account_id'       => $mt->account_id,
                    'posisi'           => 'debit',
                    'jumlah'           => $mt->jumlah,
                ]);
                // Kredit: Kas
                JournalEntryLine::create([
                    'journal_entry_id' => $entry->id,
                    'account_id'       => $kas->id,
                    'posisi'           => 'kredit',
                    'jumlah'           => $mt->jumlah,
                ]);
            }

            $mt->update(['jurnal_dibuat' => true]);
        });
    }

    /**
     * Sinkronisasi jurnal dari order online yang sudah selesai.
     * Hanya order dengan status 'completed' DAN payment 'approved'/'paid'
     * yang belum pernah dijurnal.
     */
    private function sinkronJurnalOnline(): int
    {
        $kas              = Account::where('kode', '1-001')->firstOrFail();
        $pendapatanOnline = Account::where('kode', '4-001')->firstOrFail();

        // Ambil order yang sudah selesai dan dibayar
        $orders = Order::whereIn('status', ['completed', 'delivered'])
            ->whereHas('transaction', function ($q) {
                $q->whereIn('status', ['approved', 'paid']);
            })
            ->whereNotIn('id', function ($q) {
                $q->select('referensi_id')
                    ->from('journal_entries')
                    ->where('referensi_tipe', 'order')
                    ->whereNotNull('referensi_id');
            })
            ->with('transaction')
            ->get();

        $count = 0;

        foreach ($orders as $order) {
            try {
                DB::transaction(function () use ($order, $kas, $pendapatanOnline) {
                    $tanggal  = $order->completed_date
                        ? Carbon::parse($order->completed_date)->toDateString()
                        : $order->created_at->toDateString();

                    $noJurnal = JournalEntry::generateNoJurnal($tanggal);

                    $entry = JournalEntry::create([
                        'tanggal'        => $tanggal,
                        'no_jurnal'      => $noJurnal,
                        'keterangan'     => 'Penjualan Online - Order #' . $order->id . ' (' . $order->name . ')',
                        'sumber'         => 'online',
                        'referensi_id'   => $order->id,
                        'referensi_tipe' => 'order',
                    ]);

                    // Debit: Kas
                    JournalEntryLine::create([
                        'journal_entry_id' => $entry->id,
                        'account_id'       => $kas->id,
                        'posisi'           => 'debit',
                        'jumlah'           => $order->total,
                    ]);

                    // Kredit: Pendapatan Penjualan Online
                    JournalEntryLine::create([
                        'journal_entry_id' => $entry->id,
                        'account_id'       => $pendapatanOnline->id,
                        'posisi'           => 'kredit',
                        'jumlah'           => $order->total,
                    ]);
                });

                $count++;
            } catch (\Exception $e) {
                Log::error('Gagal buat jurnal order #' . $order->id . ': ' . $e->getMessage());
            }
        }

        return $count;
    }

    /**
     * Helper — hitung saldo semua akun dalam satu query,
     * dikembalikan sebagai array ['account_id' => saldo].
     */
    private function hitungSemuaSaldo(?string $dari = null, ?string $sampai = null): array
    {
        $query = JournalEntryLine::select(
            'account_id',
            'posisi',
            DB::raw('SUM(jumlah) as total')
        )
            ->when($dari && $sampai, function ($q) use ($dari, $sampai) {
                // Untuk Laba Rugi: filter rentang tanggal
                $q->whereHas('journalEntry', fn($j) => $j->whereBetween('tanggal', [$dari, $sampai]));
            })
            ->when(!$dari && $sampai, function ($q) use ($sampai) {
                // Untuk Posisi Keuangan: kumulatif SAMPAI tanggal tertentu
                $q->whereHas('journalEntry', fn($j) => $j->where('tanggal', '<=', $sampai));
            })
            ->groupBy('account_id', 'posisi')
            ->get();

        $saldos = [];
        foreach ($query as $row) {
            if (!isset($saldos[$row->account_id])) {
                $saldos[$row->account_id] = ['debit' => 0, 'kredit' => 0];
            }
            $saldos[$row->account_id][$row->posisi] += floatval($row->total);
        }

        return $saldos;
    }

    // ====================================================
    // 1. DASHBOARD KEUANGAN
    // ====================================================

    public function dashboard()
    {
        // Auto sinkron order online setiap buka dashboard
        $this->sinkronJurnalOnline();

        $bulanIni  = now()->format('Y-m');
        $dari      = now()->startOfMonth()->toDateString();
        $sampai    = now()->endOfMonth()->toDateString();

        $dariBulanLalu   = now()->subMonth()->startOfMonth()->toDateString();
        $sampaiBulanLalu = now()->subMonth()->endOfMonth()->toDateString();

        $saldos      = $this->hitungSemuaSaldo();
        $saldosBulanIni   = $this->hitungSemuaSaldo($dari, $sampai);
        $saldosBulanLalu  = $this->hitungSemuaSaldo($dariBulanLalu, $sampaiBulanLalu);

        $accounts = Account::active()->get()->keyBy('id');

        // Kas (saldo kumulatif, bukan per bulan)
        $kasAccount = $accounts->firstWhere('kode', '1-001');
        $totalKas = 0;
        if ($kasAccount && isset($saldos[$kasAccount->id])) {
            $s = $saldos[$kasAccount->id];
            $totalKas = $s['debit'] - $s['kredit'];
        }

        // Fungsi hitung saldo akun per periode
        $hitungSaldoAkun = function ($kode, $saldosPeriode) use ($accounts) {
            $acc = $accounts->firstWhere('kode', $kode);
            if (!$acc || !isset($saldosPeriode[$acc->id])) return 0;
            $s = $saldosPeriode[$acc->id];
            return $acc->saldo_normal === 'debit'
                ? ($s['debit'] - $s['kredit'])
                : ($s['kredit'] - $s['debit']);
        };

        // Pendapatan bulan ini
        $pendOnlineBulanIni  = $hitungSaldoAkun('4-001', $saldosBulanIni);
        $pendOfflineBulanIni = $hitungSaldoAkun('4-002', $saldosBulanIni);
        $totalPendBulanIni   = $pendOnlineBulanIni + $pendOfflineBulanIni;

        // Pendapatan bulan lalu
        $pendOnlineBulanLalu  = $hitungSaldoAkun('4-001', $saldosBulanLalu);
        $pendOfflineBulanLalu = $hitungSaldoAkun('4-002', $saldosBulanLalu);
        $totalPendBulanLalu   = $pendOnlineBulanLalu + $pendOfflineBulanLalu;

        // Beban bulan ini
        $bebanKode = ['5-001', '5-002', '5-003', '5-004'];
        $totalBebanBulanIni  = 0;
        $totalBebanBulanLalu = 0;
        foreach ($bebanKode as $kode) {
            $totalBebanBulanIni  += $hitungSaldoAkun($kode, $saldosBulanIni);
            $totalBebanBulanLalu += $hitungSaldoAkun($kode, $saldosBulanLalu);
        }

        // Laba bersih bulan ini & lalu
        $labaBulanIni  = $totalPendBulanIni - $totalBebanBulanIni;
        $labaBulanLalu = $totalPendBulanLalu - $totalBebanBulanLalu;

        // Hitung persentase perubahan
        $hitungPersen = function ($sekarang, $lalu) {
            if ($lalu == 0) return $sekarang > 0 ? 100 : 0;
            return round((($sekarang - $lalu) / abs($lalu)) * 100, 1);
        };

        $persenPend  = $hitungPersen($totalPendBulanIni, $totalPendBulanLalu);
        $persenBeban = $hitungPersen($totalBebanBulanIni, $totalBebanBulanLalu);
        $persenLaba  = $hitungPersen($labaBulanIni, $labaBulanLalu);

        // Data grafik tren 6 bulan
        $trenBulan = [];
        for ($i = 5; $i >= 0; $i--) {
            $tgl    = now()->subMonths($i);
            $d      = $tgl->copy()->startOfMonth()->toDateString();
            $s      = $tgl->copy()->endOfMonth()->toDateString();
            $sb     = $this->hitungSemuaSaldo($d, $s);

            $pend  = $hitungSaldoAkun('4-001', $sb) + $hitungSaldoAkun('4-002', $sb);
            $beban = $hitungSaldoAkun('5-001', $sb)
                + $hitungSaldoAkun('5-002', $sb)
                + $hitungSaldoAkun('5-003', $sb)
                + $hitungSaldoAkun('5-004', $sb);

            $trenBulan[] = [
                'bulan'       => $tgl->translatedFormat('M Y'),
                'pendapatan'  => $pend,
                'beban'       => $beban,
                'laba'        => $pend - $beban,
            ];
        }

        // 5 Transaksi terbaru (jurnal)
        $transaksiTerbaru = JournalEntry::with(['lines.account'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        return view('admin.keuangan.dashboard', compact(
            'totalKas',
            'totalPendBulanIni',
            'pendOnlineBulanIni',
            'pendOfflineBulanIni',
            'totalBebanBulanIni',
            'labaBulanIni',
            'persenPend',
            'persenBeban',
            'persenLaba',
            'trenBulan',
            'transaksiTerbaru',
            'totalPendBulanLalu',
            'labaBulanLalu',
        ));
    }

    // ====================================================
    // 2. INPUT TRANSAKSI MANUAL
    // ====================================================

    public function transaksi(Request $request)
    {
        // Akun yang bisa dipilih untuk transaksi manual:
        // Pendapatan → hanya akun tipe 'pendapatan'
        // Pengeluaran → hanya akun tipe 'beban'
        $akunPendapatan = Account::active()
            ->byTipe('pendapatan')
            ->where('kode', '!=', '4-001')
            ->get();
        $akunBeban      = Account::active()->byTipe('beban')->get();

        // Tabel riwayat transaksi manual dengan pagination
        $transaksi = ManualTransaction::with('account')
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.keuangan.input_transaksi', compact(
            'akunPendapatan',
            'akunBeban',
            'transaksi'
        ));
    }

    public function simpanTransaksi(Request $request)
    {
        $request->validate([
            'tanggal'    => 'required|date|before_or_equal:today',
            'jenis'      => 'required|in:pendapatan,pengeluaran',
            'deskripsi'  => 'required|string|max:255',
            'account_id' => 'required|exists:accounts,id',
            'jumlah'     => 'required|numeric|min:1',
        ], [
            'tanggal.required'    => 'Tanggal wajib diisi.',
            'tanggal.before_or_equal' => 'Tanggal tidak boleh lebih dari hari ini.',
            'jenis.required'      => 'Jenis transaksi wajib dipilih.',
            'deskripsi.required'  => 'Deskripsi wajib diisi.',
            'account_id.required' => 'Akun wajib dipilih.',
            'account_id.exists'   => 'Akun tidak valid.',
            'jumlah.required'     => 'Jumlah wajib diisi.',
            'jumlah.min'          => 'Jumlah minimal Rp 1.',
        ]);

        // Validasi kesesuaian akun dengan jenis transaksi
        $account = Account::findOrFail($request->account_id);
        if ($request->jenis === 'pendapatan' && $account->tipe !== 'pendapatan') {
            return back()->withErrors(['account_id' => 'Akun tidak sesuai untuk jenis Pendapatan.'])->withInput();
        }
        if ($request->jenis === 'pengeluaran' && $account->tipe !== 'beban') {
            return back()->withErrors(['account_id' => 'Akun tidak sesuai untuk jenis Pengeluaran.'])->withInput();
        }

        try {
            DB::transaction(function () use ($request) {
                $mt = ManualTransaction::create([
                    'tanggal'    => $request->tanggal,
                    'jenis'      => $request->jenis,
                    'deskripsi'  => $request->deskripsi,
                    'account_id' => $request->account_id,
                    'jumlah'     => $request->jumlah,
                ]);

                // Langsung buat jurnal otomatis
                $this->buatJurnalDariManual($mt);
            });

            return redirect()->route('admin.keuangan.transaksi')
                ->with('success', '✅ Transaksi berhasil disimpan dan jurnal otomatis telah dibuat.');
        } catch (\Exception $e) {
            Log::error('Gagal simpan transaksi manual: ' . $e->getMessage());
            return back()
                ->with('error', '❌ Gagal menyimpan transaksi. Silakan coba lagi.')
                ->withInput();
        }
    }

    public function hapusTransaksi($id)
    {
        try {
            $mt = ManualTransaction::findOrFail($id);

            DB::transaction(function () use ($mt) {
                // Hapus jurnal terkait jika ada
                JournalEntry::where('referensi_id', $mt->id)
                    ->where('referensi_tipe', 'manual')
                    ->delete(); // lines ikut terhapus karena cascade

                $mt->delete();
            });

            return redirect()->route('admin.keuangan.transaksi')
                ->with('success', '✅ Transaksi dan jurnal terkait berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal hapus transaksi: ' . $e->getMessage());
            return back()->with('error', '❌ Gagal menghapus transaksi.');
        }
    }

    // ====================================================
    // 3. JURNAL UMUM
    // ====================================================

    public function jurnal(Request $request)
    {
        $dari   = $request->input('dari', now()->startOfMonth()->toDateString());
        $sampai = $request->input('sampai', now()->endOfMonth()->toDateString());

        $jurnals = JournalEntry::with(['lines.account'])
            ->whereBetween('tanggal', [$dari, $sampai])
            ->orderBy('tanggal', 'asc')
            ->orderBy('no_jurnal', 'asc')
            ->paginate(15)
            ->appends(['dari' => $dari, 'sampai' => $sampai]);

        // Total debit & kredit periode ini (untuk footer)
        $totalDebit = JournalEntryLine::whereHas('journalEntry', function ($q) use ($dari, $sampai) {
            $q->whereBetween('tanggal', [$dari, $sampai]);
        })->where('posisi', 'debit')->sum('jumlah');

        $totalKredit = JournalEntryLine::whereHas('journalEntry', function ($q) use ($dari, $sampai) {
            $q->whereBetween('tanggal', [$dari, $sampai]);
        })->where('posisi', 'kredit')->sum('jumlah');

        return view('admin.keuangan.jurnal_umum', compact(
            'jurnals',
            'dari',
            'sampai',
            'totalDebit',
            'totalKredit'
        ));
    }

    // ====================================================
    // 4. LAPORAN LABA RUGI
    // ====================================================

    public function labaRugi(Request $request)
    {
        $dari   = $request->input('dari', now()->startOfMonth()->toDateString());
        $sampai = $request->input('sampai', now()->endOfMonth()->toDateString());

        $saldos   = $this->hitungSemuaSaldo($dari, $sampai);
        $accounts = Account::active()->get()->keyBy('id');

        $hitungSaldo = function ($kode) use ($saldos, $accounts) {
            $acc = $accounts->firstWhere('kode', $kode);
            if (!$acc || !isset($saldos[$acc->id])) return 0;
            $s = $saldos[$acc->id];
            return $acc->saldo_normal === 'debit'
                ? ($s['debit'] - $s['kredit'])
                : ($s['kredit'] - $s['debit']);
        };

        // Pendapatan
        $pendapatanOnline  = $hitungSaldo('4-001');
        $pendapatanOffline = $hitungSaldo('4-002');
        $totalPendapatan   = $pendapatanOnline + $pendapatanOffline;

        // Beban
        $bebanBahanBaku  = $hitungSaldo('5-001');
        $bebanOperasional = $hitungSaldo('5-002');
        $bebanLainLain   = $hitungSaldo('5-003');
        $bebanGajiKaryawan = $hitungSaldo('5-004');
        $totalBeban = $bebanBahanBaku + $bebanOperasional + $bebanLainLain + $bebanGajiKaryawan;

        // Laba Bersih
        $labaBersih = $totalPendapatan - $totalBeban;

        return view('admin.keuangan.laporan_laba_rugi', compact(
            'dari',
            'sampai',
            'pendapatanOnline',
            'pendapatanOffline',
            'totalPendapatan',
            'bebanBahanBaku',
            'bebanOperasional',
            'bebanGajiKaryawan',
            'bebanLainLain',
            'totalBeban',
            'labaBersih'
        ));
    }

    // ====================================================
    // 5. LAPORAN POSISI KEUANGAN (NERACA)
    // ====================================================

    public function posisiKeuangan(Request $request)
    {
        // Posisi keuangan = kumulatif sampai tanggal tertentu
        $sampai = $request->input('sampai', now()->toDateString());

        $saldos   = $this->hitungSemuaSaldo(null, $sampai);
        $accounts = Account::active()->get()->keyBy('id');

        $hitungSaldo = function ($kode) use ($saldos, $accounts) {
            $acc = $accounts->firstWhere('kode', $kode);
            if (!$acc || !isset($saldos[$acc->id])) return 0;
            $s = $saldos[$acc->id];
            return $acc->saldo_normal === 'debit'
                ? ($s['debit'] - $s['kredit'])
                : ($s['kredit'] - $s['debit']);
        };

        // ASET
        $kas               = $hitungSaldo('1-001');
        $piutangUsaha      = $hitungSaldo('1-002');
        $persediaanBahanBaku = $hitungSaldo('1-003');
        $totalAset         = $kas + $piutangUsaha + $persediaanBahanBaku;

        // LIABILITAS
        $utangUsaha        = $hitungSaldo('2-001');
        $totalLiabilitas   = $utangUsaha;

        // EKUITAS
        $modalPemilik      = $hitungSaldo('3-001');
        $labaDitahan       = $hitungSaldo('3-002');

        // Laba berjalan (semua pendapatan - semua beban sampai tanggal ini)
        $pendAll  = $hitungSaldo('4-001') + $hitungSaldo('4-002');
        $bebanAll = $hitungSaldo('5-001') + $hitungSaldo('5-002') + $hitungSaldo('5-003') + $hitungSaldo('5-004');
        $labaBerjalan = $pendAll - $bebanAll;

        $totalEkuitas      = $modalPemilik + $labaDitahan + $labaBerjalan;
        $totalLiabilitasEkuitas = $totalLiabilitas + $totalEkuitas;

        return view('admin.keuangan.posisi_keuangan', compact(
            'sampai',
            'kas',
            'piutangUsaha',
            'persediaanBahanBaku',
            'totalAset',
            'utangUsaha',
            'totalLiabilitas',
            'modalPemilik',
            'labaDitahan',
            'labaBerjalan',
            'totalEkuitas',
            'totalLiabilitasEkuitas'
        ));
    }

    // ====================================================
    // 6. SINKRON ONLINE (AJAX)
    // ====================================================

    public function sinkronOnline()
    {
        try {
            $count = $this->sinkronJurnalOnline();
            return response()->json([
                'success' => true,
                'message' => "✅ {$count} jurnal dari order online berhasil disinkronkan.",
                'count'   => $count,
            ]);
        } catch (\Exception $e) {
            Log::error('Sinkron online error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => '❌ Gagal sinkronisasi: ' . $e->getMessage(),
            ], 500);
        }
    }

    // ====================================================
    // 7. EXPORT PDF
    // ====================================================

    public function labaRugiPdf(Request $request)
    {
        $dari   = $request->input('dari', now()->startOfMonth()->toDateString());
        $sampai = $request->input('sampai', now()->endOfMonth()->toDateString());

        // Ambil data sama seperti labaRugi()
        $saldos   = $this->hitungSemuaSaldo($dari, $sampai);
        $accounts = Account::active()->get()->keyBy('id');
        $hitungSaldo = function ($kode) use ($saldos, $accounts) {
            $acc = $accounts->firstWhere('kode', $kode);
            if (!$acc || !isset($saldos[$acc->id])) return 0;
            $s = $saldos[$acc->id];
            return $acc->saldo_normal === 'debit'
                ? ($s['debit'] - $s['kredit'])
                : ($s['kredit'] - $s['debit']);
        };

        $pendapatanOnline  = $hitungSaldo('4-001');
        $pendapatanOffline = $hitungSaldo('4-002');
        $totalPendapatan   = $pendapatanOnline + $pendapatanOffline;
        $bebanBahanBaku    = $hitungSaldo('5-001');
        $bebanOperasional  = $hitungSaldo('5-002');
        $bebanLainLain     = $hitungSaldo('5-003');
        $bebanGajiKaryawan = $hitungSaldo('5-004');
        $totalBeban = $bebanBahanBaku + $bebanOperasional + $bebanLainLain + $bebanGajiKaryawan;
        $labaBersih        = $totalPendapatan - $totalBeban;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.keuangan.pdf.laba_rugi_pdf', compact(
            'dari',
            'sampai',
            'pendapatanOnline',
            'pendapatanOffline',
            'totalPendapatan',
            'bebanBahanBaku',
            'bebanOperasional',
            'bebanLainLain',
            'totalBeban',
            'labaBersih'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('laporan_laba_rugi_' . now()->format('Ymd') . '.pdf');
    }

    public function posisiKeuanganPdf(Request $request)
    {
        $sampai = $request->input('sampai', now()->toDateString());

        $saldos   = $this->hitungSemuaSaldo(null, $sampai);
        $accounts = Account::active()->get()->keyBy('id');
        $hitungSaldo = function ($kode) use ($saldos, $accounts) {
            $acc = $accounts->firstWhere('kode', $kode);
            if (!$acc || !isset($saldos[$acc->id])) return 0;
            $s = $saldos[$acc->id];
            return $acc->saldo_normal === 'debit'
                ? ($s['debit'] - $s['kredit'])
                : ($s['kredit'] - $s['debit']);
        };

        $kas                 = $hitungSaldo('1-001');
        $piutangUsaha        = $hitungSaldo('1-002');
        $persediaanBahanBaku = $hitungSaldo('1-003');
        $totalAset           = $kas + $piutangUsaha + $persediaanBahanBaku;
        $utangUsaha          = $hitungSaldo('2-001');
        $totalLiabilitas     = $utangUsaha;
        $modalPemilik        = $hitungSaldo('3-001');
        $labaDitahan         = $hitungSaldo('3-002');
        $pendAll             = $hitungSaldo('4-001') + $hitungSaldo('4-002');
        $bebanAll = $hitungSaldo('5-001') + $hitungSaldo('5-002') + $hitungSaldo('5-003') + $hitungSaldo('5-004');
        $labaBerjalan        = $pendAll - $bebanAll;
        $totalEkuitas        = $modalPemilik + $labaDitahan + $labaBerjalan;
        $totalLiabilitasEkuitas = $totalLiabilitas + $totalEkuitas;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.keuangan.pdf.posisi_keuangan_pdf', compact(
            'sampai',
            'kas',
            'piutangUsaha',
            'persediaanBahanBaku',
            'totalAset',
            'utangUsaha',
            'totalLiabilitas',
            'modalPemilik',
            'labaDitahan',
            'labaBerjalan',
            'totalEkuitas',
            'totalLiabilitasEkuitas'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('posisi_keuangan_' . now()->format('Ymd') . '.pdf');
    }

    public function jurnalPdf(Request $request)
    {
        $dari   = $request->input('dari', now()->startOfMonth()->toDateString());
        $sampai = $request->input('sampai', now()->endOfMonth()->toDateString());

        $jurnals = JournalEntry::with(['lines.account'])
            ->whereBetween('tanggal', [$dari, $sampai])
            ->orderBy('tanggal', 'asc')
            ->orderBy('no_jurnal', 'asc')
            ->get();

        $totalDebit  = $jurnals->flatMap->lines->where('posisi', 'debit')->sum('jumlah');
        $totalKredit = $jurnals->flatMap->lines->where('posisi', 'kredit')->sum('jumlah');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.keuangan.pdf.jurnal_pdf', compact(
            'jurnals',
            'dari',
            'sampai',
            'totalDebit',
            'totalKredit'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('jurnal_umum_' . now()->format('Ymd') . '.pdf');
    }

    // ====================================================
    // 8. EXPORT EXCEL — JURNAL UMUM
    // ====================================================

    public function jurnalExcel(Request $request)
    {
        $dari   = $request->input('dari', now()->startOfMonth()->toDateString());
        $sampai = $request->input('sampai', now()->endOfMonth()->toDateString());

        $filename = 'jurnal_umum_'
            . Carbon::parse($dari)->format('Ymd')
            . '_sd_'
            . Carbon::parse($sampai)->format('Ymd')
            . '.xlsx';

        return Excel::download(new JurnalExport($dari, $sampai), $filename);
    }
}
