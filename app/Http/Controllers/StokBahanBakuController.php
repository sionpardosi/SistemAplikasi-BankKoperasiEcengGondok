<?php

namespace App\Http\Controllers;

use App\Models\StokBahanBaku;
use Illuminate\Http\Request;

class StokBahanBakuController extends Controller
{
    // Update method index untuk menampilkan total stok dan status
    public function index()
    {
        $stok = StokBahanBaku::latest()->paginate(10);

        // Hitung total stok saat ini
        $totalStok = StokBahanBaku::sum('jumlah_kg');

        // Hitung statistik
        $statistik = [
            'total_stok' => $totalStok,
            'total_masuk' => StokBahanBaku::where('jumlah_kg', '>', 0)->sum('jumlah_kg'),
            'total_keluar' => abs(StokBahanBaku::where('jumlah_kg', '<', 0)->sum('jumlah_kg')),
            'status_stok' => $this->getStatusStok($totalStok)
        ];

        return view('admin.stok.index', compact('stok', 'statistik'));
    }

    // Helper method untuk status stok
    private function getStatusStok($totalStok)
    {
        if ($totalStok <= 5) {
            return ['status' => 'kritis', 'warna' => 'danger', 'pesan' => 'Stok sangat rendah! Segera cari pemasok baru.'];
        } elseif ($totalStok <= 20) {
            return ['status' => 'rendah', 'warna' => 'warning', 'pesan' => 'Stok mulai menipis. Siapkan rencana pengisian stok.'];
        } elseif ($totalStok <= 50) {
            return ['status' => 'normal', 'warna' => 'info', 'pesan' => 'Stok dalam kondisi normal.'];
        } else {
            return ['status' => 'aman', 'warna' => 'success', 'pesan' => 'Stok sangat mencukupi.'];
        }
    }

    public function export(Request $request)
    {
        $query = StokBahanBaku::query();

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        $stok = $query->latest()->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Stok Bahan Baku');

        // Header
        $sheet->fromArray([
            'No',
            'Tanggal',
            'Jenis',
            'Jumlah (kg)',
            'Sumber',
            'Keterangan'
        ], NULL, 'A1');

        // Data
        $row = 2;
        foreach ($stok as $i => $s) {
            $sheet->fromArray([
                $i + 1,
                $s->tanggal,
                $s->jumlah_kg > 0 ? 'Masuk' : 'Keluar',
                $s->jumlah_kg,
                $s->sumber,
                $s->keterangan
            ], NULL, "A{$row}");
            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'laporan_stok_' . now()->format('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jumlah_kg' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        StokBahanBaku::create([
            'tanggal' => $request->tanggal,
            'jumlah_kg' => $request->jumlah_kg,
            'sumber' => 'Manual Input',
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Stok berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $stok = StokBahanBaku::findOrFail($id);
        return view('admin.stok.edit', compact('stok'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jumlah_kg' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $stok = StokBahanBaku::findOrFail($id);
        $stok->update([
            'tanggal' => $request->tanggal,
            'jumlah_kg' => $request->jumlah_kg,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.stok.index')->with('success', 'Stok berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $stok = StokBahanBaku::findOrFail($id);
        $stok->delete();

        return back()->with('success', 'Stok berhasil dihapus.');
    }

    // Tambahkan method untuk mengurangi stok (konsumsi produksi)
    public function konsumsi(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jumlah_kg' => 'required|numeric|min:0.1',
            'keterangan' => 'required|string',
        ]);

        $totalStok = StokBahanBaku::sum('jumlah_kg');

        if ($request->jumlah_kg > $totalStok) {
            return back()->with('error', 'Jumlah konsumsi melebihi stok tersedia (' . $totalStok . ' kg)');
        }

        StokBahanBaku::create([
            'tanggal' => $request->tanggal,
            'jumlah_kg' => -$request->jumlah_kg, // NEGATIF untuk pengurangan
            'sumber' => 'Konsumsi Produksi',
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Konsumsi stok berhasil dicatat. Stok berkurang ' . $request->jumlah_kg . ' kg');
    }
}
