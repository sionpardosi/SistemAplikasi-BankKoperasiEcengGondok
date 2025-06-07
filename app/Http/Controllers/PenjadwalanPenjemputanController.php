<?php

namespace App\Http\Controllers;

use App\Models\PenjadwalanPenjemputan;
use App\Models\SupplierRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;

class PenjadwalanPenjemputanController extends Controller
{
    /**
     * Display a listing of the pickup schedules with filtering
     */
    /**
     * Display a listing of the pickup schedules with filtering and statistics
     */
    public function index(Request $request)
    {
        $query = PenjadwalanPenjemputan::with(['request']);

        // Apply filters
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->whereHas('request', function ($q) use ($searchTerm) {
                $q->where('nama', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status_jemput', $request->status);
        }

        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', 'like', '%' . $request->kecamatan . '%');
        }

        if ($request->filled('tanggal_dari') && $request->filled('tanggal_sampai')) {
            $query->whereBetween('tanggal_jemput', [$request->tanggal_dari, $request->tanggal_sampai]);
        } elseif ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_jemput', '>=', $request->tanggal_dari);
        } elseif ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_jemput', '<=', $request->tanggal_sampai);
        }

        // Get paginated results
        $jadwals = $query->latest('tanggal_jemput')->paginate(15);

        // Append query parameters to pagination links
        $jadwals->appends($request->query());

        // Calculate statistics for dashboard
        $today = now()->format('Y-m-d');
        $thisWeek = now()->startOfWeek()->format('Y-m-d');
        $thisMonth = now()->startOfMonth()->format('Y-m-d');
        $nextWeek = now()->addWeek()->format('Y-m-d');

        $statistics = [
            'today_total' => PenjadwalanPenjemputan::whereDate('tanggal_jemput', $today)->count(),
            'week_total' => PenjadwalanPenjemputan::where('tanggal_jemput', '>=', $thisWeek)->count(),
            'month_total' => PenjadwalanPenjemputan::where('tanggal_jemput', '>=', $thisMonth)->count(),
            'week_weight' => PenjadwalanPenjemputan::where('status_jemput', 'dijemput')
                ->where('tanggal_jemput', '>=', $thisWeek)
                ->sum('estimasi_kg'),

            // Alert counts
            'overdue_count' => PenjadwalanPenjemputan::where('status_jemput', 'terjadwal')
                ->where('tanggal_jemput', '<', $today)
                ->count(),
            'upcoming_count' => PenjadwalanPenjemputan::where('status_jemput', 'terjadwal')
                ->whereBetween('tanggal_jemput', [$today, $nextWeek])
                ->count(),

            // Status breakdown
            'total_schedules' => PenjadwalanPenjemputan::count(),
            'scheduled_count' => PenjadwalanPenjemputan::where('status_jemput', 'terjadwal')->count(),
            'completed_count' => PenjadwalanPenjemputan::where('status_jemput', 'dijemput')->count(),
            'cancelled_count' => PenjadwalanPenjemputan::where('status_jemput', 'dibatalkan')->count(),

            // Revenue calculation
            'month_revenue' => PenjadwalanPenjemputan::join('supplier_requests', 'penjadwalan_penjemputans.supplier_request_id', '=', 'supplier_requests.id')
                ->where('penjadwalan_penjemputans.tanggal_jemput', '>=', $thisMonth)
                ->where('penjadwalan_penjemputans.status_jemput', 'dijemput')
                ->where('supplier_requests.insentif', 'uang_tunai')
                ->sum(\Illuminate\Support\Facades\DB::raw('penjadwalan_penjemputans.estimasi_kg * 60000')),
        ];

        // Get upcoming schedules for timeline
        $upcomingSchedules = PenjadwalanPenjemputan::with('request')
            ->where('status_jemput', 'terjadwal')
            ->where('tanggal_jemput', '>=', $today)
            ->orderBy('tanggal_jemput')
            ->limit(6)
            ->get();

        return view('admin.penjadwalan.index', compact('jadwals', 'statistics', 'upcomingSchedules'));
    }

    /**
     * Show the form for creating a new pickup schedule
     */
    public function create()
    {
        // Only get approved requests that don't already have a schedule
        $requests = SupplierRequest::where('status', 'disetujui')
            ->whereDoesntHave('penjadwalan')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.penjadwalan.create', compact('requests'));
    }

    /**
     * Store a newly created pickup schedule
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'supplier_request_id' => 'required|exists:supplier_requests,id',
                'tanggal_jemput' => 'required|date|after_or_equal:today',
                'kecamatan' => 'required|string|max:255',
                'desa' => 'required|string|max:255',
                'detail_lokasi' => 'required|string|max:500',
                'estimasi_kg' => 'required|numeric|min:1',
            ]);

            // Check if this request already has a schedule
            $existingSchedule = PenjadwalanPenjemputan::where('supplier_request_id', $validatedData['supplier_request_id'])->first();
            if ($existingSchedule) {
                return back()->withErrors(['supplier_request_id' => 'Permintaan pemasok ini sudah memiliki jadwal penjemputan.'])
                    ->withInput();
            }

            DB::beginTransaction();

            // Get supplier request data
            $supplierRequest = SupplierRequest::findOrFail($validatedData['supplier_request_id']);

            // Create the schedule
            $jadwal = PenjadwalanPenjemputan::create([
                'supplier_request_id' => $validatedData['supplier_request_id'],
                'tanggal_jemput' => $validatedData['tanggal_jemput'],
                'kecamatan' => $validatedData['kecamatan'],
                'desa' => $validatedData['desa'],
                'detail_lokasi' => $validatedData['detail_lokasi'],
                'estimasi_kg' => $validatedData['estimasi_kg'],
                'status_jemput' => 'terjadwal',
            ]);

            // Send notification email to supplier
            $this->sendScheduleNotification($supplierRequest, $jadwal, 'created');

            // Log the activity
            Log::info("Pickup schedule created for supplier request {$supplierRequest->id} by admin", [
                'schedule_id' => $jadwal->id,
                'pickup_date' => $validatedData['tanggal_jemput'],
                'supplier_name' => $supplierRequest->nama,
            ]);

            DB::commit();

            return redirect()->route('admin.penjadwalan.index')
                ->with('success', 'Jadwal penjemputan berhasil dibuat dan notifikasi telah dikirim ke pemasok.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating pickup schedule: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Terjadi kesalahan saat membuat jadwal: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified pickup schedule
     */
    public function edit($id)
    {
        $jadwal = PenjadwalanPenjemputan::with('request')->findOrFail($id);

        // Get all approved requests (for reference, though we won't allow changing the request)
        $requests = SupplierRequest::where('status', 'disetujui')->get();

        return view('admin.penjadwalan.edit', compact('jadwal', 'requests'));
    }

    /**
     * Update the specified pickup schedule
     */
    public function update(Request $request, $id)
    {
        try {
            $jadwal = PenjadwalanPenjemputan::with('request')->findOrFail($id);
            $oldStatus = $jadwal->status_jemput;

            $validatedData = $request->validate([
                'supplier_request_id' => 'required|exists:supplier_requests,id',
                'tanggal_jemput' => 'required|date',
                'kecamatan' => 'required|string|max:255',
                'desa' => 'required|string|max:255',
                'detail_lokasi' => 'required|string|max:500',
                'estimasi_kg' => 'required|numeric|min:1',
                'status_jemput' => 'required|in:terjadwal,dijemput,dibatalkan',
            ]);

            // Prevent changing the supplier request
            if ($validatedData['supplier_request_id'] != $jadwal->supplier_request_id) {
                return back()->withErrors(['supplier_request_id' => 'Permintaan pemasok tidak dapat diubah.'])
                    ->withInput();
            }

            DB::beginTransaction();

            // Update the schedule
            $jadwal->update([
                'tanggal_jemput' => $validatedData['tanggal_jemput'],
                'kecamatan' => $validatedData['kecamatan'],
                'desa' => $validatedData['desa'],
                'detail_lokasi' => $validatedData['detail_lokasi'],
                'estimasi_kg' => $validatedData['estimasi_kg'],
                'status_jemput' => $validatedData['status_jemput'],
            ]);

            // Send notification if status changed
            if ($oldStatus != $validatedData['status_jemput']) {
                $this->sendScheduleNotification($jadwal->request, $jadwal, 'status_updated', $oldStatus);
            }

            // Log the activity
            Log::info("Pickup schedule {$jadwal->id} updated by admin", [
                'old_status' => $oldStatus,
                'new_status' => $validatedData['status_jemput'],
                'pickup_date' => $validatedData['tanggal_jemput'],
                'supplier_name' => $jadwal->request->nama ?? 'Unknown',
            ]);

            DB::commit();

            return redirect()->route('admin.penjadwalan.index')
                ->with('success', 'Jadwal penjemputan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating pickup schedule: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui jadwal: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified pickup schedule
     */
    public function destroy($id)
    {
        try {
            $jadwal = PenjadwalanPenjemputan::with('request')->findOrFail($id);
            $supplierName = $jadwal->request->nama ?? 'Unknown';

            DB::beginTransaction();

            // Send cancellation notification
            if ($jadwal->request && $jadwal->request->email) {
                $this->sendScheduleNotification($jadwal->request, $jadwal, 'cancelled');
            }

            // Delete the schedule
            $jadwal->delete();

            // Log the activity
            Log::info("Pickup schedule {$id} deleted by admin", [
                'supplier_name' => $supplierName,
                'pickup_date' => $jadwal->tanggal_jemput,
            ]);

            DB::commit();

            return back()->with('success', 'Jadwal penjemputan berhasil dihapus dan notifikasi pembatalan telah dikirim.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error deleting pickup schedule: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat menghapus jadwal: ' . $e->getMessage());
        }
    }

    /**
     * Export pickup schedules to Excel
     */
    public function export(Request $request)
    {
        try {
            $query = PenjadwalanPenjemputan::with(['request']);

            // Apply the same filters as in index
            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $query->whereHas('request', function ($q) use ($searchTerm) {
                    $q->where('nama', 'like', '%' . $searchTerm . '%')
                        ->orWhere('email', 'like', '%' . $searchTerm . '%');
                });
            }

            if ($request->filled('status')) {
                $query->where('status_jemput', $request->status);
            }

            if ($request->filled('kecamatan')) {
                $query->where('kecamatan', 'like', '%' . $request->kecamatan . '%');
            }

            if ($request->filled('tanggal_dari') && $request->filled('tanggal_sampai')) {
                $query->whereBetween('tanggal_jemput', [$request->tanggal_dari, $request->tanggal_sampai]);
            } elseif ($request->filled('tanggal_dari')) {
                $query->whereDate('tanggal_jemput', '>=', $request->tanggal_dari);
            } elseif ($request->filled('tanggal_sampai')) {
                $query->whereDate('tanggal_jemput', '<=', $request->tanggal_sampai);
            }

            $jadwals = $query->latest('tanggal_jemput')->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Jadwal Penjemputan');

            // Set headers with styling
            $headers = [
                'A1' => 'No',
                'B1' => 'Tanggal Penjemputan',
                'C1' => 'Nama Pemasok',
                'D1' => 'Email Pemasok',
                'E1' => 'No. HP',
                'F1' => 'Kecamatan',
                'G1' => 'Desa',
                'H1' => 'Detail Lokasi',
                'I1' => 'Estimasi Berat (kg)',
                'J1' => 'Status Penjemputan',
                'K1' => 'Jenis Insentif',
                'L1' => 'Estimasi Nilai Insentif',
                'M1' => 'Tanggal Dibuat',
                'N1' => 'Terakhir Diupdate'
            ];

            foreach ($headers as $cell => $value) {
                $sheet->setCellValue($cell, $value);
                $sheet->getStyle($cell)->getFont()->setBold(true);
                $sheet->getStyle($cell)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('E3F2FD');
            }

            // Auto-size columns
            foreach (range('A', 'N') as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }

            // Add data
            $row = 2;
            foreach ($jadwals as $i => $jadwal) {
                $estimasiNilai = '-';
                if ($jadwal->request && $jadwal->request->insentif == 'uang_tunai') {
                    $estimasiNilai = 'Rp ' . number_format($jadwal->estimasi_kg * 60000, 0, ',', '.');
                } elseif ($jadwal->request && $jadwal->request->kupon) {
                    $estimasiNilai = 'Kupon: ' . $jadwal->request->kupon->code;
                }

                $data = [
                    $i + 1,
                    \Carbon\Carbon::parse($jadwal->tanggal_jemput)->format('d-m-Y'),
                    $jadwal->request->nama ?? '-',
                    $jadwal->request->email ?? '-',
                    $jadwal->request->no_hp ?? '-',
                    $jadwal->kecamatan ?? '-',
                    $jadwal->desa ?? '-',
                    $jadwal->detail_lokasi ?? '-',
                    $jadwal->estimasi_kg,
                    ucfirst($jadwal->status_jemput),
                    $jadwal->request ? ($jadwal->request->insentif === 'diskon' ? 'Diskon' : 'Uang Tunai') : '-',
                    $estimasiNilai,
                    $jadwal->created_at->format('d-m-Y H:i'),
                    $jadwal->updated_at->format('d-m-Y H:i'),
                ];

                $sheet->fromArray($data, NULL, "A{$row}");

                // Color code status
                $statusCell = "J{$row}";
                switch ($jadwal->status_jemput) {
                    case 'terjadwal':
                        $sheet->getStyle($statusCell)->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('FFF3CD');
                        break;
                    case 'dijemput':
                        $sheet->getStyle($statusCell)->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('D1F2EB');
                        break;
                    case 'dibatalkan':
                        $sheet->getStyle($statusCell)->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('F8D7DA');
                        break;
                }

                $row++;
            }

            // Add summary at the bottom
            $summaryRow = $row + 2;
            $sheet->setCellValue("A{$summaryRow}", 'RINGKASAN:');
            $sheet->getStyle("A{$summaryRow}")->getFont()->setBold(true);

            $totalJadwal = $jadwals->count();
            $totalTerjadwal = $jadwals->where('status_jemput', 'terjadwal')->count();
            $totalDijemput = $jadwals->where('status_jemput', 'dijemput')->count();
            $totalDibatalkan = $jadwals->where('status_jemput', 'dibatalkan')->count();
            $totalBeratEstimasi = $jadwals->sum('estimasi_kg');

            $sheet->setCellValue("A" . ($summaryRow + 1), "Total Jadwal: {$totalJadwal}");
            $sheet->setCellValue("A" . ($summaryRow + 2), "Terjadwal: {$totalTerjadwal}");
            $sheet->setCellValue("A" . ($summaryRow + 3), "Dijemput: {$totalDijemput}");
            $sheet->setCellValue("A" . ($summaryRow + 4), "Dibatalkan: {$totalDibatalkan}");
            $sheet->setCellValue("A" . ($summaryRow + 5), "Total Estimasi Berat: {$totalBeratEstimasi} kg");

            $writer = new Xlsx($spreadsheet);
            $filename = 'laporan_jadwal_penjemputan_' . now()->format('Ymd_His') . '.xlsx';

            // Set headers for download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment;filename=\"$filename\"");
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
            exit;
        } catch (\Exception $e) {
            Log::error('Error exporting pickup schedules: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengexport data: ' . $e->getMessage());
        }
    }

    /**
     * Send notification email to supplier
     */
    private function sendScheduleNotification($supplierRequest, $jadwal, $type, $oldStatus = null)
    {
        if (!$supplierRequest || !$supplierRequest->email) {
            return;
        }

        try {
            $subject = $this->getEmailSubject($type);
            $content = $this->buildEmailContent($supplierRequest, $jadwal, $type, $oldStatus);

            Mail::raw($content, function ($message) use ($supplierRequest, $subject) {
                $message->to($supplierRequest->email, $supplierRequest->nama)
                    ->subject($subject)
                    ->from(
                        config('mail.from.address', 'noreply@bankecenggondok.com'),
                        config('mail.from.name', 'Bank Koperasi Eceng Gondok')
                    );
            });

            Log::info("Schedule notification email sent to {$supplierRequest->email} for type: {$type}");
        } catch (\Exception $e) {
            Log::error("Failed to send schedule notification email: " . $e->getMessage());
        }
    }

    /**
     * Get email subject based on notification type
     */
    private function getEmailSubject($type)
    {
        switch ($type) {
            case 'created':
                return 'Jadwal Penjemputan Eceng Gondok Telah Dibuat';
            case 'status_updated':
                return 'Update Status Penjemputan Eceng Gondok';
            case 'cancelled':
                return 'Pembatalan Jadwal Penjemputan Eceng Gondok';
            default:
                return 'Notifikasi Jadwal Penjemputan Eceng Gondok';
        }
    }

    /**
     * Build email content based on notification type
     */
    private function buildEmailContent($supplierRequest, $jadwal, $type, $oldStatus = null)
    {
        $greeting = "Yth. {$supplierRequest->nama},\n\n";

        switch ($type) {
            case 'created':
                $content = "Kami dengan senang hati memberitahukan bahwa jadwal penjemputan untuk permintaan eceng gondok Anda telah dibuat.\n\n";
                $content .= "DETAIL JADWAL PENJEMPUTAN:\n";
                $content .= "📅 Tanggal Penjemputan: " . \Carbon\Carbon::parse($jadwal->tanggal_jemput)->format('d F Y (l)') . "\n";
                $content .= "📍 Lokasi: {$jadwal->kecamatan}, {$jadwal->desa}\n";
                $content .= "🏠 Detail Lokasi: {$jadwal->detail_lokasi}\n";
                $content .= "⚖️ Estimasi Berat: {$jadwal->estimasi_kg} kg\n";
                $content .= "📋 Status: Terjadwal\n\n";

                $content .= "YANG PERLU ANDA PERSIAPKAN:\n";
                $content .= "✅ Pastikan eceng gondok dalam kondisi bersih dan kering\n";
                $content .= "✅ Siapkan dokumen identitas (KTP/SIM)\n";
                $content .= "✅ Pastikan akses lokasi mudah dijangkau tim penjemputan\n";
                $content .= "✅ Harap berada di lokasi pada jadwal yang telah ditentukan\n\n";

                $content .= "Tim kami akan menghubungi Anda 1 hari sebelum penjemputan untuk konfirmasi.\n\n";
                break;

            case 'status_updated':
                $content = "Kami informasikan bahwa status penjemputan eceng gondok Anda telah diperbarui.\n\n";
                $content .= "DETAIL PERUBAHAN:\n";
                $content .= "📅 Tanggal Penjemputan: " . \Carbon\Carbon::parse($jadwal->tanggal_jemput)->format('d F Y (l)') . "\n";
                $content .= "📍 Lokasi: {$jadwal->kecamatan}, {$jadwal->desa}\n";

                if ($oldStatus) {
                    $statusText = [
                        'terjadwal' => 'Terjadwal',
                        'dijemput' => 'Dijemput',
                        'dibatalkan' => 'Dibatalkan'
                    ];
                    $content .= "📋 Status Sebelumnya: {$statusText[$oldStatus]}\n";
                }

                $content .= "📋 Status Terbaru: " . ucfirst($jadwal->status_jemput) . "\n\n";

                if ($jadwal->status_jemput == 'dijemput') {
                    $content .= "🎉 SELAMAT! Penjemputan telah berhasil diselesaikan.\n\n";

                    if ($supplierRequest->insentif == 'uang_tunai') {
                        $estimatedValue = $jadwal->estimasi_kg * 60000;
                        $content .= "💰 INSENTIF ANDA:\n";
                        $content .= "Jenis: Uang Tunai\n";
                        $content .= "Estimasi: Rp " . number_format($estimatedValue, 0, ',', '.') . "\n";
                        $content .= "Pembayaran akan diproses dalam 3-5 hari kerja.\n\n";
                    } elseif ($supplierRequest->kupon) {
                        $content .= "🎟️ KUPON DISKON ANDA:\n";
                        $content .= "Kode: {$supplierRequest->kupon->code}\n";
                        $content .= "Nilai: Rp " . number_format($supplierRequest->kupon->discount_amount, 0, ',', '.') . "\n";
                        $content .= "Berlaku sampai: " . $supplierRequest->kupon->expiry_date->format('d F Y') . "\n\n";
                    }

                    $content .= "Terima kasih atas kontribusi Anda dalam program ramah lingkungan ini!\n\n";
                } elseif ($jadwal->status_jemput == 'dibatalkan') {
                    $content .= "😔 Mohon maaf, penjemputan telah dibatalkan.\n\n";
                    $content .= "Anda dapat mengajukan permintaan baru untuk dijadwalkan kembali.\n\n";
                }
                break;

            case 'cancelled':
                $content = "Kami mohon maaf untuk memberitahukan bahwa jadwal penjemputan eceng gondok Anda telah dibatalkan.\n\n";
                $content .= "DETAIL JADWAL YANG DIBATALKAN:\n";
                $content .= "📅 Tanggal: " . \Carbon\Carbon::parse($jadwal->tanggal_jemput)->format('d F Y (l)') . "\n";
                $content .= "📍 Lokasi: {$jadwal->kecamatan}, {$jadwal->desa}\n";
                $content .= "⚖️ Estimasi Berat: {$jadwal->estimasi_kg} kg\n\n";
                $content .= "Anda dapat mengajukan permintaan penjemputan baru melalui sistem kami.\n\n";
                break;

            default:
                $content = "Terdapat update terkait jadwal penjemputan eceng gondok Anda.\n\n";
        }

        $content .= "Jika ada pertanyaan atau memerlukan bantuan, silakan hubungi kami:\n";
        $content .= "📧 Email: admin@bankecenggondok.com\n";
        $content .= "📱 WhatsApp: +62 812-3456-7890\n";
        $content .= "⏰ Jam Operasional: Senin-Jumat, 08:00-17:00 WIB\n\n";

        $content .= "Terima kasih atas partisipasi Anda dalam program pelestarian lingkungan!\n\n";
        $content .= "Salam hijau,\n";
        $content .= "Tim Bank Koperasi Eceng Gondok";

        return $greeting . $content;
    }


    /**
     * Handle bulk actions for multiple schedules
     */
    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|in:update_status,reschedule,delete',
            'schedule_ids' => 'required|array',
            'schedule_ids.*' => 'exists:penjadwalan_penjemputans,id',
            'new_status' => 'required_if:action,update_status|in:terjadwal,dijemput,dibatalkan',
            'new_date' => 'required_if:action,reschedule|date|after_or_equal:today',
        ]);

        try {
            DB::beginTransaction();

            $schedules = PenjadwalanPenjemputan::with('request')
                ->whereIn('id', $request->schedule_ids)
                ->get();

            $results = [];

            foreach ($schedules as $schedule) {
                switch ($request->action) {
                    case 'update_status':
                        $oldStatus = $schedule->status_jemput;
                        $schedule->update(['status_jemput' => $request->new_status]);

                        $results[] = "Status {$schedule->request->nama} berhasil diubah dari {$oldStatus} ke {$request->new_status}";
                        break;

                    case 'reschedule':
                        $oldDate = $schedule->tanggal_jemput;
                        $schedule->update(['tanggal_jemput' => $request->new_date]);
                        $results[] = "Jadwal {$schedule->request->nama} berhasil diubah dari {$oldDate} ke {$request->new_date}";
                        break;

                    case 'delete':
                        $supplierName = $schedule->request->nama;
                        $schedule->delete();
                        $results[] = "Jadwal {$supplierName} berhasil dihapus";
                        break;
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Operasi bulk berhasil dilakukan pada ' . count($request->schedule_ids) . ' jadwal',
                'results' => $results
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Bulk action error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Smart scheduling - suggest optimal schedule
     */
    public function smartScheduling(Request $request)
    {
        $request->validate([
            'supplier_request_ids' => 'required|array',
            'supplier_request_ids.*' => 'exists:supplier_requests,id',
            'preferred_date_range' => 'required|array',
            'preferred_date_range.start' => 'required|date|after_or_equal:today',
            'preferred_date_range.end' => 'required|date|after:preferred_date_range.start',
        ]);

        try {
            $supplierRequests = SupplierRequest::whereIn('id', $request->supplier_request_ids)
                ->where('status', 'disetujui')
                ->get();

            // Group by location to optimize routes
            $locationGroups = $supplierRequests->groupBy(function ($item) {
                return ($item->kecamatan ?? 'Unknown') . '_' . ($item->desa ?? 'Unknown');
            });

            $suggestions = [];
            $currentDate = Carbon::parse($request->preferred_date_range['start']);
            $endDate = Carbon::parse($request->preferred_date_range['end']);

            foreach ($locationGroups as $location => $requests) {
                // Calculate optimal pickup date based on location and quantity
                $totalWeight = $requests->sum('estimasi_kg');
                $requestCount = $requests->count();

                // Smart logic: group nearby locations on same day if total weight > 100kg
                $suggestedDate = $this->calculateOptimalDate($currentDate, $endDate, $totalWeight, $location);

                $suggestions[] = [
                    'location' => str_replace('_', ', ', $location),
                    'suggested_date' => $suggestedDate->format('Y-m-d'),
                    'requests' => $requests->map(function ($req) use ($suggestedDate) {
                        return [
                            'id' => $req->id,
                            'nama' => $req->nama,
                            'estimasi_kg' => $req->estimasi_kg,
                            'suggested_date' => $suggestedDate->format('Y-m-d'),
                            'priority_score' => $this->calculatePriorityScore($req),
                        ];
                    }),
                    'total_weight' => $totalWeight,
                    'efficiency_score' => $this->calculateEfficiencyScore($totalWeight, $requestCount),
                ];

                // Move to next available date
                $currentDate = $suggestedDate->copy()->addDay();
            }

            return response()->json([
                'success' => true,
                'suggestions' => $suggestions,
                'summary' => [
                    'total_requests' => $supplierRequests->count(),
                    'total_weight' => $supplierRequests->sum('estimasi_kg'),
                    'location_groups' => count($locationGroups),
                    'date_range' => [
                        'start' => $request->preferred_date_range['start'],
                        'end' => $request->preferred_date_range['end'],
                    ],
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Smart scheduling error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Route optimization for pickup schedules
     */
    public function optimizeRoute(Request $request)
    {
        $date = $request->get('date', now()->format('Y-m-d'));

        try {
            $schedules = PenjadwalanPenjemputan::with('request')
                ->whereDate('tanggal_jemput', $date)
                ->where('status_jemput', 'terjadwal')
                ->get();

            if ($schedules->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tidak ada jadwal untuk tanggal tersebut',
                    'optimized_route' => [],
                    'summary' => [
                        'total_stops' => 0,
                        'total_weight' => 0,
                        'estimated_total_time' => 0,
                        'estimated_distance' => 0,
                        'efficiency_score' => 0,
                    ]
                ]);
            }

            // Group by kecamatan for route optimization
            $routeGroups = $schedules->groupBy('kecamatan');
            $optimizedRoute = [];
            $totalDistance = 0;
            $totalTime = 0;

            foreach ($routeGroups as $kecamatan => $groupSchedules) {
                $subRoute = $groupSchedules->sortBy('desa')->values();

                foreach ($subRoute as $index => $schedule) {
                    $estimatedTime = $this->calculatePickupTime($schedule->estimasi_kg);
                    $travelTime = $index > 0 ? $this->calculateTravelTime($subRoute[$index - 1], $schedule) : 0;

                    $optimizedRoute[] = [
                        'id' => $schedule->id,
                        'sequence' => count($optimizedRoute) + 1,
                        'supplier_name' => $schedule->request->nama ?? 'Unknown',
                        'location' => ($schedule->kecamatan ?? '') . ', ' . ($schedule->desa ?? ''),
                        'detail_location' => $schedule->detail_lokasi ?? '',
                        'estimasi_kg' => $schedule->estimasi_kg,
                        'estimated_pickup_time' => $estimatedTime,
                        'travel_time_from_previous' => $travelTime,
                        'arrival_time' => $this->calculateArrivalTime($totalTime + $travelTime),
                        'departure_time' => $this->calculateArrivalTime($totalTime + $travelTime + $estimatedTime),
                        'phone' => $schedule->request->no_hp ?? '-',
                    ];

                    $totalTime += $travelTime + $estimatedTime;
                    $totalDistance += $this->calculateDistance($index > 0 ? $subRoute[$index - 1] : null, $schedule);
                }
            }

            return response()->json([
                'success' => true,
                'date' => $date,
                'optimized_route' => $optimizedRoute,
                'summary' => [
                    'total_stops' => count($optimizedRoute),
                    'total_weight' => $schedules->sum('estimasi_kg'),
                    'estimated_total_time' => $totalTime,
                    'estimated_distance' => $totalDistance,
                    'efficiency_score' => $this->calculateRouteEfficiency($schedules->count(), $totalTime, $totalDistance),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Route optimization error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Helper methods untuk calculations
    private function calculateOptimalDate($startDate, $endDate, $totalWeight, $location)
    {
        // Logic untuk menentukan tanggal optimal berdasarkan:
        // 1. Total berat (prioritas tinggi untuk berat besar)
        // 2. Lokasi (group lokasi terdekat)
        // 3. Kapasitas harian (max 5 penjemputan per hari)

        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $dailySchedules = PenjadwalanPenjemputan::whereDate('tanggal_jemput', $currentDate)->count();

            if ($dailySchedules < 5) { // Max 5 pickups per day
                return $currentDate;
            }

            $currentDate->addDay();
        }

        return $startDate; // Fallback
    }

    private function calculatePriorityScore($request)
    {
        $score = 0;

        // Weight factor
        $score += $request->estimasi_kg * 0.1;

        // Age factor (older requests get higher priority)
        $daysSinceRequest = $request->created_at->diffInDays(now());
        $score += $daysSinceRequest * 0.5;

        // Incentive type factor
        if ($request->insentif === 'uang_tunai') {
            $score += 10;
        }

        return round($score, 2);
    }

    private function calculateEfficiencyScore($totalWeight, $requestCount)
    {
        // Higher score for higher weight concentration
        return $requestCount > 0 ? round($totalWeight / $requestCount, 2) : 0;
    }

    private function calculatePickupTime($weight)
    {
        // Base time 15 minutes + 2 minutes per 10kg
        return 15 + ceil($weight / 10) * 2;
    }

    private function calculateTravelTime($fromSchedule, $toSchedule)
    {
        // Simplified calculation - in real world, use Google Maps API
        if (!$fromSchedule) return 0;

        if ($fromSchedule->kecamatan === $toSchedule->kecamatan) {
            if ($fromSchedule->desa === $toSchedule->desa) {
                return 10; // Same village
            }
            return 20; // Same district
        }

        return 45; // Different district
    }

    private function calculateDistance($fromSchedule, $toSchedule)
    {
        // Simplified calculation in km
        if (!$fromSchedule) return 0;

        if ($fromSchedule->kecamatan === $toSchedule->kecamatan) {
            if ($fromSchedule->desa === $toSchedule->desa) {
                return 2;
            }
            return 8;
        }

        return 25;
    }

    private function calculateArrivalTime($minutesFromStart)
    {
        return now()->startOfDay()->addHours(8)->addMinutes($minutesFromStart)->format('H:i');
    }

    private function calculateRouteEfficiency($stops, $totalTime, $totalDistance)
    {
        // Higher score is better
        $timePerStop = $stops > 0 ? $totalTime / $stops : 0;
        $distancePerStop = $stops > 0 ? $totalDistance / $stops : 0;

        // Efficiency score: lower time and distance per stop is better
        return $stops > 0 ? round(100 - ($timePerStop + $distancePerStop), 2) : 0;
    }

    /**
     * Update status via API (untuk quick status buttons)
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:terjadwal,dijemput,dibatalkan'
            ]);

            $schedule = PenjadwalanPenjemputan::findOrFail($id);
            $oldStatus = $schedule->status_jemput;

            $schedule->update(['status_jemput' => $request->status]);

            // Create status badge HTML
            $statusBadge = '';
            switch ($request->status) {
                case 'terjadwal':
                    $statusBadge = '<span class="status-badge status-terjadwal"><i class="icon-clock"></i> Terjadwal</span>';
                    break;
                case 'dijemput':
                    $statusBadge = '<span class="status-badge status-dijemput"><i class="icon-check"></i> Dijemput</span>';
                    break;
                case 'dibatalkan':
                    $statusBadge = '<span class="status-badge status-dibatalkan"><i class="icon-close"></i> Dibatalkan</span>';
                    break;
            }

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui',
                'schedule' => [
                    'id' => $schedule->id,
                    'status' => ucfirst($schedule->status_jemput),
                    'status_badge' => $statusBadge,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search schedules via API
     */
    public function searchSchedules(Request $request)
    {
        try {
            $query = PenjadwalanPenjemputan::with('request');

            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $query->whereHas('request', function ($q) use ($searchTerm) {
                    $q->where('nama', 'like', '%' . $searchTerm . '%')
                        ->orWhere('email', 'like', '%' . $searchTerm . '%');
                });
            }

            $schedules = $query->latest('tanggal_jemput')
                ->limit(50)
                ->get()
                ->map(function ($schedule) {
                    return [
                        'id' => $schedule->id,
                        'tanggal_jemput' => $schedule->tanggal_jemput->format('d F Y'),
                        'supplier_name' => $schedule->request->nama ?? '-',
                        'location' => ($schedule->kecamatan ?? '') . ', ' . ($schedule->desa ?? ''),
                        'estimasi_kg' => $schedule->estimasi_kg,
                        'status' => ucfirst($schedule->status_jemput),
                        'status_color' => $schedule->status_jemput == 'terjadwal' ? 'warning' : ($schedule->status_jemput == 'dijemput' ? 'success' : 'danger'),
                    ];
                });

            return response()->json($schedules);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get calendar events for FullCalendar
     */
    public function getCalendarEvents(Request $request)
    {
        try {
            $start = $request->get('start', now()->startOfMonth()->format('Y-m-d'));
            $end = $request->get('end', now()->endOfMonth()->format('Y-m-d'));

            $schedules = PenjadwalanPenjemputan::with('request')
                ->whereBetween('tanggal_jemput', [$start, $end])
                ->get()
                ->map(function ($schedule) {
                    $color = match ($schedule->status_jemput) {
                        'terjadwal' => '#ffc107',
                        'dijemput' => '#28a745',
                        'dibatalkan' => '#dc3545',
                        default => '#6c757d'
                    };

                    return [
                        'id' => $schedule->id,
                        'title' => ($schedule->request->nama ?? 'Unknown') . ' (' . $schedule->estimasi_kg . 'kg)',
                        'start' => $schedule->tanggal_jemput->format('Y-m-d'),
                        'backgroundColor' => $color,
                        'borderColor' => $color,
                        'textColor' => '#ffffff',
                        'extendedProps' => [
                            'supplier_name' => $schedule->request->nama ?? '-',
                            'location' => ($schedule->kecamatan ?? '') . ', ' . ($schedule->desa ?? ''),
                            'weight' => $schedule->estimasi_kg . ' kg',
                            'status' => ucfirst($schedule->status_jemput),
                            'phone' => $schedule->request->no_hp ?? '-',
                            'email' => $schedule->request->email ?? '-',
                        ]
                    ];
                });

            return response()->json($schedules);
        } catch (\Exception $e) {
            Log::error('Calendar events error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
