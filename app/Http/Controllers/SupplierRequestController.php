<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Support\Str;
use App\Models\RelatedVideo;
use App\Models\SupplierInfo;
use Illuminate\Http\Request;
use App\Models\StokBahanBaku;
use App\Models\SupplierRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\PenjadwalanPenjemputan;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SupplierRequestController extends Controller
{
    // Existing methods remain unchanged
    public function index(Request $request)
    {
        $query = SupplierRequest::query();
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', 'like', '%' . $request->kecamatan . '%');
        }

        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        if ($request->filled('tanggal_dari') && $request->filled('tanggal_sampai')) {
            $query->whereBetween('created_at', [$request->tanggal_dari, $request->tanggal_sampai]);
        }

        $requests = $query->latest()->paginate(10);
        return view('admin.adminsupplier.index', compact('requests'));
    }

    public function create()
    {
        $kupons = Coupon::all(); // sesuaikan jika nama model berbeda
        return view('admin.adminsupplier.create', compact('kupons'));
    }

    public function edit($id)
    {
        $request = SupplierRequest::findOrFail($id);
        $kupons = Coupon::all(); // sesuaikan jika nama model berbeda
        return view('admin.adminsupplier.edit', compact('request', 'kupons'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,disetujui,ditolak',
            'catatan_admin' => 'nullable',
            'kupon_id' => 'nullable',
        ]);
        $sr = SupplierRequest::findOrFail($id);

        // Cek perubahan status
        $oldStatus = $sr->status;
        $newStatus = $data['status'];

        // Update stok bahan baku sesuai perubahan status
        if ($oldStatus == 'disetujui' && $newStatus != 'disetujui') {
            // Jika sebelumnya disetujui lalu diubah, hapus stok bahan baku terkait
            StokBahanBaku::where('request_id', $sr->id)->delete();
        } elseif ($oldStatus != 'disetujui' && $newStatus == 'disetujui') {
            // Jika sebelumnya bukan disetujui, sekarang disetujui, tambahkan stok baru
            StokBahanBaku::create([
                'tanggal' => now(),
                'jumlah_kg' => $sr->estimasi_kg,
                'sumber' => 'Request Pemasok',
                'request_id' => $sr->id,
                'keterangan' => 'Otomatis dari permintaan disetujui'
            ]);
        }

        if ($sr->insentif === 'diskon' && $data['status'] === 'disetujui') {
            $sr->coupon_id = $data['kupon_id'];
            $sr->catatan_admin = "Diskon ditetapkan sebesar per kg. " . $data['catatan_admin'];
        } else {
            $sr->catatan_admin = $data['catatan_admin'];
        }

        $sr->status = $data['status'];
        $sr->save();

        // Notifikasi email ke user
        Mail::raw("Permintaan Anda telah " . strtoupper($sr->status) . ". Catatan: " . $sr->catatan_admin, function ($msg) use ($sr) {
            $msg->to($sr->email)->subject('Status Permintaan Anda');
        });

        return redirect()->route('admin.supplier.index')->with('success', 'Status berhasil diperbarui.');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required',
                'email' => 'required|email',
                'kontak' => 'required',
                'lokasi' => 'nullable',
                'estimasi_kg' => 'required|numeric|min:1',
                'insentif' => 'required|in:diskon,uang_tunai',
                'status' => 'nullable|in:pending,disetujui,ditolak',
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'catatan' => 'nullable|string',
                'catatan_admin' => 'nullable',
                'kupon_id' => 'nullable',
                'kecamatan' => 'required',
                'desa' => 'required',
                'detail_lokasi' => 'required',
            ]);

            // Handling foto upload to public/uploads/bukti_pemasok
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
                // Move to public/uploads/bukti_pemasok
                $file->move(public_path('uploads/bukti_pemasok'), $filename);
                // Save relative path for asset()
                $fotoPath = 'uploads/bukti_pemasok/' . $filename;
            }

            SupplierRequest::create([
                'user_id' => Auth::user()->id,
                'nama' => $request->nama,
                'email' => $request->email,
                'no_hp' => $request->kontak,
                'no_wa' => $request->kontak,
                'lokasi' => $request->lokasi,
                'estimasi_kg' => $request->estimasi_kg,
                'insentif' => $request->insentif,
                'status' => $request->status || 'pending',
                'catatan_admin' => $request->catatan_admin,
                'coupon_id' => $request->kupon_id,
                'foto' => $fotoPath,
                'catatan' => $request->catatan,
                'kecamatan' => $request->kecamatan,
                'desa' => $request->desa,
                'detail_lokasi' => $request->detail_lokasi,
            ]);

            // Kirim notifikasi email ke user
            Mail::raw("Permintaan Anda telah berhasil dikirim dan sedang kami proses. Terima kasih telah berpartisipasi!", function ($msg) use ($request) {
                $msg->to($request->email)->subject('Konfirmasi Request Pemasok');
            });

            if (Auth::user()->utype == 'ADM') {
                return to_route('admin.supplier.index')->with('success', 'Permintaan berhasil dikirim!');
            } else {
                return to_route('user.account.supplier.request')->with('success', 'Permintaan berhasil dikirim!');
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $request = SupplierRequest::findOrFail($id);
        $request->delete();

        return redirect()->route('admin.supplier.index')->with('success', 'Permintaan berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $query = SupplierRequest::query();
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }

        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        if ($request->filled('tanggal_dari') && $request->filled('tanggal_sampai')) {
            $query->whereBetween('created_at', [$request->tanggal_dari, $request->tanggal_sampai]);
        }

        $requests = $query->latest()->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Request Pemasok');

        // Header
        $sheet->fromArray([
            'No',
            'Tanggal',
            'Nama',
            'Kecamatan',
            'Desa',
            'Detail Lokasi',
            'Lokasi',
            'Jumlah (kg)',
            'Insentif',
            'Status',
            'Kupon',
            'Catatan Admin',
            'Total Insentif (Rp)'
        ], NULL, 'A1');

        // Data
        $row = 2;
        foreach ($requests as $i => $req) {
            $sheet->fromArray([
                $i + 1,
                $req->created_at->format('d-m-Y'),
                $req->nama,
                $req->kecamatan ?? '-',
                $req->desa ?? '-',
                $req->detail_lokasi ?? '-',
                $req->lokasi ?? '-', // lokasi lama
                $req->estimasi_kg,
                $req->insentif === 'diskon' ? 'Diskon' : 'Uang Tunai',
                ucfirst($req->status),
                $req->kupon?->kode ?? '-',
                $req->catatan_admin ?? '-',
                $req->status === 'disetujui' ? number_format($req->estimasi_kg * 60000, 0, ',', '.') : '-', // total insentif
            ], NULL, "A{$row}");
            $row++;
        }

        // Output
        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan_request_pemasok_' . now()->format('Ymd_His') . '.xlsx';

        // Kirim ke browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function supplierDashboard(Request $request)
    {
        $status = $request->input('status'); // optional
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $filteredQuery = SupplierRequest::query();

        $dashboardSupplier = [
            'total_request' => SupplierRequest::count(),
            'total_stok' => StokBahanBaku::sum('jumlah_kg'),
            'total_jadwal' => PenjadwalanPenjemputan::count(),
            'total_jemput' => PenjadwalanPenjemputan::where('status_jemput', 'dijemput')->count(),
            'total_batal' => PenjadwalanPenjemputan::where('status_jemput', 'dibatalkan')->count(),
            'total_pending' => PenjadwalanPenjemputan::where('status_jemput', 'terjadwal')->count(),
        ];

        $recentRequests = SupplierRequest::latest()->take(10)->get();

        // Untuk Grafik
        $dataChart = SupplierRequest::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Buat array 12 bulan (biar grafik tetap full Januari-Desember)
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $dataChart[$i] ?? 0;
        }

        return view('admin.dashboard-supplier', compact('dashboardSupplier', 'recentRequests', 'chartData', 'status', 'startDate', 'endDate'));
    }


    // ====================================================================================================
    // Halaman Informasi Permintaan Pemasok - CRUD for Supplier Info
    // ====================================================================================================

    // Index page for supplier information
    public function indexInformationSupplier()
    {
        $supplierInfos = SupplierInfo::orderBy('order')->get();
        $relatedVideos = RelatedVideo::orderBy('order')->get();
        return view('admin.adminsupplier.informasi_supplier.index', compact('supplierInfos', 'relatedVideos'));
    }

    // Create form for supplier information
    public function createInformationSupplier()
    {
        // Check if we already have info records to prevent duplicates
        $infoCount = SupplierInfo::count();

        if ($infoCount > 0) {
            return redirect()->route('admin.adminsupplier.informasi_supplier.index')
                ->with('error', 'Informasi pemasok utama sudah ada. Silakan edit informasi yang sudah ada.');
        }

        return view('admin.adminsupplier.informasi_supplier.create');
    }

    // Store new supplier information
    public function storeInformationSupplier(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_type' => 'nullable|in:local,instagram',
            'video_file' => 'nullable|file|mimes:mp4,mov,avi|max:102400', // 100MB max for videos
            'instagram_url' => 'nullable|string|url',
            'video_caption' => 'nullable|string',
            'video_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_duration' => 'nullable|string|max:10',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/supplier_info'), $filename);
            $imagePath = 'uploads/supplier_info/' . $filename;
        }

        // Handle video upload or URL
        $videoUrl = null;
        $videoType = $request->video_type;

        if ($videoType === 'local' && $request->hasFile('video_file')) {
            $file = $request->file('video_file');
            $filename = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/supplier_videos'), $filename);
            $videoUrl = 'uploads/supplier_videos/' . $filename;
        } elseif ($videoType === 'instagram' && $request->instagram_url) {
            $videoUrl = $request->instagram_url;
        }

        // Handle video thumbnail if provided
        $thumbnailPath = null;
        if ($request->hasFile('video_thumbnail')) {
            $file = $request->file('video_thumbnail');
            $filename = time() . '_thumb_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/supplier_thumbnails'), $filename);
            $thumbnailPath = 'uploads/supplier_thumbnails/' . $filename;
        }

        // Create supplier info
        SupplierInfo::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'video_type' => $videoType,
            'video_url' => $videoUrl,
            'video_caption' => $request->video_caption,
            'video_thumbnail' => $thumbnailPath,
            'video_duration' => $request->video_duration,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.adminsupplier.informasi_supplier.index')
            ->with('success', 'Informasi pemasok berhasil ditambahkan');
    }

    // Edit form for supplier information
    public function editInformationSupplier($id)
    {
        $supplierInfo = SupplierInfo::findOrFail($id);
        return view('admin.adminsupplier.informasi_supplier.edit', compact('supplierInfo'));
    }

    // Update supplier information
    public function updateInformationSupplier(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_type' => 'nullable|in:local,instagram',
            'video_file' => 'nullable|file|mimes:mp4,mov,avi|max:102400', // 100MB max for videos
            'instagram_url' => 'nullable|string|url',
            'video_caption' => 'nullable|string',
            'video_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_duration' => 'nullable|string|max:10',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $supplierInfo = SupplierInfo::findOrFail($id);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($supplierInfo->image && file_exists(public_path($supplierInfo->image))) {
                unlink(public_path($supplierInfo->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/supplier_info'), $filename);
            $supplierInfo->image = 'uploads/supplier_info/' . $filename;
        }

        // Handle video changes
        $videoType = $request->video_type;

        // Update video based on type selection
        if ($videoType === 'local' && $request->hasFile('video_file')) {
            // Delete old video if exists
            if ($supplierInfo->video_type === 'local' && $supplierInfo->video_url && file_exists(public_path($supplierInfo->video_url))) {
                unlink(public_path($supplierInfo->video_url));
            }

            $file = $request->file('video_file');
            $filename = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/supplier_videos'), $filename);
            $supplierInfo->video_url = 'uploads/supplier_videos/' . $filename;
            $supplierInfo->video_type = 'local';
        } elseif ($videoType === 'instagram' && $request->instagram_url) {
            // If changing from local to instagram, remove the old local file
            if ($supplierInfo->video_type === 'local' && $supplierInfo->video_url && file_exists(public_path($supplierInfo->video_url))) {
                unlink(public_path($supplierInfo->video_url));
            }

            $supplierInfo->video_url = $request->instagram_url;
            $supplierInfo->video_type = 'instagram';
        }

        // Handle video thumbnail if provided
        if ($request->hasFile('video_thumbnail')) {
            // Delete old thumbnail if exists
            if ($supplierInfo->video_thumbnail && file_exists(public_path($supplierInfo->video_thumbnail))) {
                unlink(public_path($supplierInfo->video_thumbnail));
            }

            $file = $request->file('video_thumbnail');
            $filename = time() . '_thumb_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/supplier_thumbnails'), $filename);
            $supplierInfo->video_thumbnail = 'uploads/supplier_thumbnails/' . $filename;
        }

        // Update other fields
        $supplierInfo->title = $request->title;
        $supplierInfo->description = $request->description;
        $supplierInfo->video_caption = $request->video_caption;
        $supplierInfo->video_duration = $request->video_duration;
        $supplierInfo->order = $request->order ?? 0;
        $supplierInfo->is_active = $request->has('is_active');
        $supplierInfo->save();

        return redirect()->route('admin.adminsupplier.informasi_supplier.index')
            ->with('success', 'Informasi pemasok berhasil diperbarui');
    }

    // Delete supplier information
    public function destroyInformationSupplier($id)
    {
        $supplierInfo = SupplierInfo::findOrFail($id);

        // Delete image if exists
        if ($supplierInfo->image && file_exists(public_path($supplierInfo->image))) {
            unlink(public_path($supplierInfo->image));
        }

        // Delete local video if exists
        if ($supplierInfo->video_type === 'local' && $supplierInfo->video_url && file_exists(public_path($supplierInfo->video_url))) {
            unlink(public_path($supplierInfo->video_url));
        }

        // Delete thumbnail if exists
        if ($supplierInfo->video_thumbnail && file_exists(public_path($supplierInfo->video_thumbnail))) {
            unlink(public_path($supplierInfo->video_thumbnail));
        }

        $supplierInfo->delete();

        return redirect()->route('admin.adminsupplier.informasi_supplier.index')
            ->with('success', 'Informasi pemasok berhasil dihapus');
    }

    // ====================================================================================================
    // CRUD for Related Videos
    // ====================================================================================================

    // Create form for related videos
    public function createRelatedVideo()
    {
        return view('admin.adminsupplier.informasi_supplier.related_video_create');
    }

    // Store new related video
    public function storeRelatedVideo(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_type' => 'required|in:local,instagram',
            'video_file' => 'required_if:video_type,local|file|mimes:mp4,mov,avi|max:102400', // 100MB max for videos
            'instagram_url' => 'required_if:video_type,instagram|string|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle video upload or URL
        $videoUrl = null;
        $videoType = $request->video_type;

        if ($videoType === 'local' && $request->hasFile('video_file')) {
            $file = $request->file('video_file');
            $filename = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/related_videos'), $filename);
            $videoUrl = 'uploads/related_videos/' . $filename;
        } elseif ($videoType === 'instagram' && $request->instagram_url) {
            $videoUrl = $request->instagram_url;
        }

        // Handle thumbnail if provided
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_thumb_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/related_thumbnails'), $filename);
            $thumbnailPath = 'uploads/related_thumbnails/' . $filename;
        }

        // Create related video
        RelatedVideo::create([
            'title' => $request->title,
            'description' => $request->description,
            'video_type' => $videoType,
            'video_url' => $videoUrl,
            'thumbnail' => $thumbnailPath,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.adminsupplier.informasi_supplier.index')
            ->with('success', 'Video terkait berhasil ditambahkan');
    }

    // Edit form for related video
    public function editRelatedVideo($id)
    {
        $relatedVideo = RelatedVideo::findOrFail($id);
        return view('admin.adminsupplier.informasi_supplier.related_video_edit', compact('relatedVideo'));
    }

    // Update related video
    public function updateRelatedVideo(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_type' => 'required|in:local,instagram',
            'video_file' => 'nullable|file|mimes:mp4,mov,avi|max:102400', // 100MB max for videos
            'instagram_url' => 'nullable|string|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $relatedVideo = RelatedVideo::findOrFail($id);

        // Handle video changes
        $videoType = $request->video_type;

        // Update video based on type selection
        if ($videoType === 'local' && $request->hasFile('video_file')) {
            // Delete old video if exists
            if ($relatedVideo->video_type === 'local' && $relatedVideo->video_url && file_exists(public_path($relatedVideo->video_url))) {
                unlink(public_path($relatedVideo->video_url));
            }

            $file = $request->file('video_file');
            $filename = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/related_videos'), $filename);
            $relatedVideo->video_url = 'uploads/related_videos/' . $filename;
            $relatedVideo->video_type = 'local';
        } elseif ($videoType === 'instagram' && $request->instagram_url) {
            // If changing from local to instagram, remove the old local file
            if ($relatedVideo->video_type === 'local' && $relatedVideo->video_url && file_exists(public_path($relatedVideo->video_url))) {
                unlink(public_path($relatedVideo->video_url));
            }

            $relatedVideo->video_url = $request->instagram_url;
            $relatedVideo->video_type = 'instagram';
        }

        // Handle thumbnail if provided
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($relatedVideo->thumbnail && file_exists(public_path($relatedVideo->thumbnail))) {
                unlink(public_path($relatedVideo->thumbnail));
            }

            $file = $request->file('thumbnail');
            $filename = time() . '_thumb_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/related_thumbnails'), $filename);
            $relatedVideo->thumbnail = 'uploads/related_thumbnails/' . $filename;
        }

        // Update other fields
        $relatedVideo->title = $request->title;
        $relatedVideo->description = $request->description;
        $relatedVideo->order = $request->order ?? 0;
        $relatedVideo->is_active = $request->has('is_active');
        $relatedVideo->save();

        return redirect()->route('admin.adminsupplier.informasi_supplier.index')
            ->with('success', 'Video terkait berhasil diperbarui');
    }

    // Delete related video
    public function destroyRelatedVideo($id)
    {
        $relatedVideo = RelatedVideo::findOrFail($id);

        // Delete local video if exists
        if ($relatedVideo->video_type === 'local' && $relatedVideo->video_url && file_exists(public_path($relatedVideo->video_url))) {
            unlink(public_path($relatedVideo->video_url));
        }

        // Delete thumbnail if exists
        if ($relatedVideo->thumbnail && file_exists(public_path($relatedVideo->thumbnail))) {
            unlink(public_path($relatedVideo->thumbnail));
        }

        $relatedVideo->delete();

        return redirect()->route('admin.adminsupplier.informasi_supplier.index')
            ->with('success', 'Video terkait berhasil dihapus');
    }

    // Get supplier information for public display
    public function getSupplierInfo()
    {
        $totalPenjemputan = PenjadwalanPenjemputan::count();
        $totalPermintaanPemasok = SupplierRequest::count();

        // Hitung total rupiah disalurkan untuk semua permintaan yang disetujui
        $totalRupiahDisalurkan = SupplierRequest::where('status', 'disetujui')
            ->sum('estimasi_kg') * 60000;

        // Get supplier info and related videos
        $supplierInfo = SupplierInfo::where('is_active', true)->orderBy('order')->first();
        $relatedVideos = RelatedVideo::where('is_active', true)->orderBy('order')->take(3)->get();

        return view('user.supplier.index', compact(
            'totalPenjemputan',
            'totalPermintaanPemasok',
            'totalRupiahDisalurkan',
            'supplierInfo',
            'relatedVideos'
        ));
    }
}
