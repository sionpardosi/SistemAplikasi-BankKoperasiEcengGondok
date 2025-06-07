<?php

namespace App\Http\Controllers;

use App\Models\PenjadwalanPenjemputan;
use App\Models\SupplierRequest;
use Illuminate\Http\Request;
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

    public function store(Request $request)
    {
        $request->validate([
            'supplier_request_id' => 'required|exists:supplier_requests,id',
            'tanggal_jemput' => 'required|date',
            'lokasi' => 'nullable',
            'estimasi_kg' => 'required|numeric|min:1',
            'kecamatan' => 'required|string',
            'desa' => 'required|string',
            'detail_lokasi' => 'required|string',
        ]);

        PenjadwalanPenjemputan::create($request->all());

        // Kirim email ke pemasok
        $supplierRequest = SupplierRequest::find($request->supplier_request_id);

        if ($supplierRequest && $supplierRequest->email) {
            Mail::raw(
                "Halo {$supplierRequest->nama},\n\nPermintaan Anda telah dijadwalkan untuk penjemputan pada tanggal {$request->tanggal_jemput}.\nLokasi: {$request->lokasi}\nEstimasi Berat: {$request->estimasi_kg} kg.\n\nTerima kasih.",
                function ($message) use ($supplierRequest) {
                    $message->to($supplierRequest->email)
                        ->subject('Penjadwalan Penjemputan Eceng Gondok');
                }
            );
        }

        return redirect()->route('admin.penjadwalan.index')->with('success', 'Jadwal berhasil dibuat.');
    }

    public function edit($id)
    {
        $jadwal = PenjadwalanPenjemputan::findOrFail($id);
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
