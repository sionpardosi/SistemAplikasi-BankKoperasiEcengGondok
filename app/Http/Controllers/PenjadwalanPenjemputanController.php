<?php

namespace App\Http\Controllers;

use App\Models\PenjadwalanPenjemputan;
use App\Models\SupplierRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PenjadwalanPenjemputanController extends Controller
{
    /**
     * Display a listing of the pickup schedules with filtering
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

        return view('admin.penjadwalan.index', compact('jadwals'));
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

    public function update(Request $request, $id)
    {
        $jadwal = PenjadwalanPenjemputan::findOrFail($id);

        $request->validate([
            'supplier_request_id' => 'required|exists:supplier_requests,id',
            'tanggal_jemput' => 'required|date',
            'lokasi' => 'required',
            'estimasi_kg' => 'required|numeric|min:1',
            'status_jemput' => 'required|in:terjadwal,dijemput,dibatalkan',
        ]);

        $jadwal->update($request->all());

        return redirect()->route('admin.penjadwalan.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = PenjadwalanPenjemputan::findOrFail($id);
        $jadwal->delete();

        return back()->with('success', 'Jadwal berhasil dihapus.');
    }

    public function export()
    {
        $jadwals = PenjadwalanPenjemputan::with('request')->latest()->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Jadwal Penjemputan');

        $sheet->fromArray([
            'No',
            'Tanggal Penjemputan',
            'Nama Pemasok',
            'Kecamatan',
            'Desa',
            'Detail Lokasi',
            'Lokasi',
            'Estimasi Berat (kg)',
            'Status Penjemputan'
        ], NULL, 'A1');

        $row = 2;
        foreach ($jadwals as $i => $jadwal) {
            $sheet->fromArray([
                $i + 1,
                $jadwal->tanggal_jemput,
                $jadwal->request->nama ?? '-',
                $jadwal->kecamatan ?? '-',
                $jadwal->desa ?? '-',
                $jadwal->detail_lokasi ?? '-',
                $jadwal->lokasi ?? '-', // lokasi lama
                $jadwal->estimasi_kg,
                ucfirst($jadwal->status_jemput),
            ], NULL, "A{$row}");
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'jadwal_penjemputan_' . now()->format('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
