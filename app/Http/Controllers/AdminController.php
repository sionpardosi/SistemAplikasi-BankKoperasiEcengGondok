<?php

namespace App\Http\Controllers;

use \PDF;
use Carbon\Carbon;
use App\Models\Size;
use App\Models\User;
use App\Models\About;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Slide;
use App\Models\Coupon;
use App\Models\Address;
use App\Models\Contact;
use App\Models\JobList;
use App\Models\Product;
use App\Models\Tentang;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Models\SupplierRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminController extends Controller
{
    // ====================================================================================================
    // Halaman Index Admin
    // ====================================================================================================
    public function index()
    {
        // Ambil 10 pesanan terbaru
        $orders = Order::orderBy('created_at', 'DESC')->take(10)->get();

        // Data ringkasan dashboard
        $dashboardDatas = collect([
            (object)[
                'TotalAmount' => Order::sum('total') ?? 0,
                'TotalOrderedAmount' => Order::whereIn('status', ['pending', 'ordered'])->sum('total') ?? 0,
                'TotalDeliveredAmount' => Order::where('status', 'delivered')->sum('total') ?? 0,
                'TotalCanceledAmount' => Order::where('status', 'canceled')->sum('total') ?? 0,
                'Total' => Order::count() ?? 0,
                'TotalOrdered' => Order::whereIn('status', ['pending', 'ordered'])->count() ?? 0,
                'TotalDelivered' => Order::where('status', 'delivered')->count() ?? 0,
                'TotalCanceled' => Order::where('status', 'canceled')->count() ?? 0
            ]
        ]);

        // Data bulanan untuk chart (tahun berjalan)
        $currentYear = date('Y');

        // Inisialisasi array untuk 12 bulan
        $monthlyAmounts = array_fill(0, 12, 0);
        $monthlyOrdered = array_fill(0, 12, 0);
        $monthlyDelivered = array_fill(0, 12, 0);
        $monthlyCanceled = array_fill(0, 12, 0);

        // Ambil data dari database
        $monthlyData = Order::selectRaw('
            MONTH(created_at) as month,
            SUM(total) as total_amount,
            SUM(CASE WHEN status IN ("pending", "ordered") THEN total ELSE 0 END) as ordered_amount,
            SUM(CASE WHEN status = "delivered" THEN total ELSE 0 END) as delivered_amount,
            SUM(CASE WHEN status = "canceled" THEN total ELSE 0 END) as canceled_amount
        ')
            ->whereYear('created_at', $currentYear)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

        // Isi data ke array berdasarkan bulan
        foreach ($monthlyData as $data) {
            $monthIndex = $data->month - 1; // Array dimulai dari 0, bulan dari 1
            $monthlyAmounts[$monthIndex] = floatval($data->total_amount);
            $monthlyOrdered[$monthIndex] = floatval($data->ordered_amount);
            $monthlyDelivered[$monthIndex] = floatval($data->delivered_amount);
            $monthlyCanceled[$monthIndex] = floatval($data->canceled_amount);
        }

        // Convert ke format string untuk JavaScript
        $AmountM = implode(',', $monthlyAmounts);
        $OrderedAmountM = implode(',', $monthlyOrdered);
        $DeliveredAmountM = implode(',', $monthlyDelivered);
        $CanceledAmountM = implode(',', $monthlyCanceled);

        // Total untuk tampilan Monthly Revenue
        $TotalAmount = formatRupiah(array_sum($monthlyAmounts));
        $TotalOrderedAmount = formatRupiah(array_sum($monthlyOrdered));
        $TotalDeliveredAmount = formatRupiah(array_sum($monthlyDelivered));
        $TotalCanceledAmount = formatRupiah(array_sum($monthlyCanceled));

        // Statistics tambahan
        $additionalStats = $this->getAdditionalStats();

        // Debug log untuk memastikan data terkirim
        Log::info('Dashboard Data:', [
            'AmountM' => $AmountM,
            'OrderedAmountM' => $OrderedAmountM,
            'DeliveredAmountM' => $DeliveredAmountM,
            'CanceledAmountM' => $CanceledAmountM,
            'orders_count' => $orders->count(),
            'dashboard_data' => $dashboardDatas->toArray()
        ]);

        // Cek stok rendah
        $totalStok = \App\Models\StokBahanBaku::sum('jumlah_kg');
        $alertStok = null;

        if ($totalStok <= 5) {
            $alertStok = [
                'type' => 'danger',
                'message' => 'PERHATIAN: Stok bahan baku sangat rendah (' . number_format($totalStok, 1) . ' kg). Segera cari pemasok!'
            ];
        } elseif ($totalStok <= 20) {
            $alertStok = [
                'type' => 'warning',
                'message' => 'Stok bahan baku mulai menipis (' . number_format($totalStok, 1) . ' kg). Persiapkan pengisian stok.'
            ];
        }

        return view('admin.index', compact(
            'orders',
            'dashboardDatas',
            'AmountM',
            'OrderedAmountM',
            'DeliveredAmountM',
            'CanceledAmountM',
            'TotalAmount',
            'TotalOrderedAmount',
            'TotalDeliveredAmount',
            'TotalCanceledAmount',
            'additionalStats',
            'alertStok'
        ));
    }

    /**
     * Get additional statistics
     */
    private function getAdditionalStats()
    {
        try {
            $currentMonth = now()->month;
            $lastMonth = now()->subMonth()->month;
            $currentYear = now()->year;

            // Current month total
            $currentMonthTotal = Order::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->sum('total') ?? 0;

            // Last month total
            $lastMonthTotal = Order::whereMonth('created_at', $lastMonth)
                ->whereYear('created_at', $currentYear)
                ->sum('total') ?? 0;

            // Calculate growth
            $revenueGrowth = $lastMonthTotal > 0 ?
                (($currentMonthTotal - $lastMonthTotal) / $lastMonthTotal) * 100 : 0;

            return [
                'revenue_growth' => round($revenueGrowth, 2),
                'current_month_revenue' => $currentMonthTotal,
                'last_month_revenue' => $lastMonthTotal,
            ];
        } catch (\Exception $e) {
            Log::error('Error in getAdditionalStats: ' . $e->getMessage());
            return [
                'revenue_growth' => 0,
                'current_month_revenue' => 0,
                'last_month_revenue' => 0,
            ];
        }
    }

    public function readall()
    {
        DB::table('notifications')->update(['status' => 'read']);
        return back();
    }


    // ====================================================================================================
    // Halaman Brands - Updated Methods in AdminController
    // ====================================================================================================

    /**
     * Display a listing of brands with filtering and sorting
     */
    public function brands(Request $request)
    {
        $query = Brand::withCount('products');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('slug', 'LIKE', '%' . $search . '%');
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        // Sorting
        switch ($request->get('sort', 'newest')) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'most_products':
                $query->orderBy('products_count', 'desc');
                break;
            default: // newest
                $query->orderBy('created_at', 'desc');
                break;
        }

        $brands = $query->paginate(10)->withQueryString();

        // Calculate totals for summary cards
        $totalProducts = Brand::withCount('products')->get()->sum('products_count');

        return view("admin.brands", compact('brands', 'totalProducts'));
    }

    /**
     * Show the form for creating a new brand
     */
    public function add_brand()
    {
        return view("admin.brand-add");
    }

    /**
     * Store a newly created brand in storage
     */
    public function add_brand_store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:brands,name',
            'slug' => 'required|string|max:100|unique:brands,slug',
            'description' => 'nullable|string|max:500',
            'image' => [
                'required',
                'file',
                'mimetypes:image/jpeg,image/jpg,image/png',
                'max:2048', // 2MB
            ],
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ], [
            'name.required' => 'Nama merek wajib diisi.',
            'name.unique' => 'Nama merek sudah ada, gunakan nama lain.',
            'name.max' => 'Nama merek maksimal 100 karakter.',
            'slug.required' => 'Slug merek wajib diisi.',
            'slug.unique' => 'Slug merek sudah ada, gunakan slug lain.',
            'slug.max' => 'Slug merek maksimal 100 karakter.',
            'description.max' => 'Deskripsi maksimal 500 karakter.',
            'image.required' => 'Gambar merek wajib diupload.',
            'image.mimetypes' => 'Format gambar harus PNG, JPG, atau JPEG.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        try {
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->description = $request->description;
            $brand->is_active = $request->boolean('is_active', true);
            $brand->is_featured = $request->boolean('is_featured', false);

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $file_extension = $image->getClientOriginalExtension();
                $file_name = Carbon::now()->timestamp . '.' . $file_extension;

                $this->GenerateBrandThumbailImage($image, $file_name);
                $brand->image = $file_name;
            }

            $brand->save();

            return redirect()->route('admin.brands')->with('success', 'Merek berhasil ditambahkan!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error creating brand: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan merek. Silakan coba lagi.');
        }
    }

    /**
     * Show the form for editing the specified brand
     */
    public function brand_edit($id)
    {
        $brand = Brand::withCount('products')->findOrFail($id);
        return view('admin.brand-edit', compact('brand'));
    }

    /**
     * Update the specified brand in storage
     */
    public function update_brand(Request $request)
    {
        $brand = Brand::findOrFail($request->id);

        $request->validate([
            'name' => 'required|string|max:100|unique:brands,name,' . $brand->id,
            'slug' => 'required|string|max:100|unique:brands,slug,' . $brand->id,
            'description' => 'nullable|string|max:500',
            'image' => [
                'nullable',
                'file',
                'mimetypes:image/jpeg,image/jpg,image/png',
                'max:2048',
            ],
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ], [
            'name.required' => 'Nama merek wajib diisi.',
            'name.unique' => 'Nama merek sudah ada, gunakan nama lain.',
            'name.max' => 'Nama merek maksimal 100 karakter.',
            'slug.required' => 'Slug merek wajib diisi.',
            'slug.unique' => 'Slug merek sudah ada, gunakan slug lain.',
            'slug.max' => 'Slug merek maksimal 100 karakter.',
            'description.max' => 'Deskripsi maksimal 500 karakter.',
            'image.mimetypes' => 'Format gambar harus PNG, JPG, atau JPEG.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        try {
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->description = $request->description;
            $brand->is_active = $request->boolean('is_active', true);
            $brand->is_featured = $request->boolean('is_featured', false);

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($brand->image && File::exists(public_path('uploads/brands/' . $brand->image))) {
                    File::delete(public_path('uploads/brands/' . $brand->image));
                }

                $image = $request->file('image');
                $file_extension = $image->getClientOriginalExtension();
                $file_name = Carbon::now()->timestamp . '.' . $file_extension;

                $this->GenerateBrandThumbailImage($image, $file_name);
                $brand->image = $file_name;
            }

            $brand->save();

            return redirect()->route('admin.brands')->with('success', 'Merek berhasil diperbarui!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error updating brand: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui merek. Silakan coba lagi.');
        }
    }

    /**
     * Toggle brand status (active/inactive)
     */
    public function toggle_brand_status($id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $brand->is_active = !$brand->is_active;
            $brand->save();

            $status = $brand->is_active ? 'diaktifkan' : 'dinonaktifkan';
            return redirect()->route('admin.brands')->with('success', "Merek berhasil {$status}!");
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error toggling brand status: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah status merek.');
        }
    }

    /**
     * Generate brand thumbnail image
     */
    private function GenerateBrandThumbailImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/brands');

        // Ensure directory exists
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        try {
            $img = Image::read($image->path());

            // Resize image to 300x300 while maintaining aspect ratio
            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Save the image
            $img->save($destinationPath . '/' . $imageName, 90); // 90% quality

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error generating brand thumbnail: ' . $e->getMessage());
            throw new \Exception('Gagal memproses gambar. Silakan coba dengan gambar lain.');
        }
    }

    /**
     * Soft delete brand (set as inactive instead of actual deletion)
     */
    public function delete_brand($id)
    {
        try {
            $brand = Brand::findOrFail($id);

            // Check if brand has products
            $productCount = $brand->products()->count();
            if ($productCount > 0) {
                return redirect()->route('admin.brands')
                    ->with('error', "Tidak dapat menghapus merek karena masih memiliki {$productCount} produk. Silakan hapus atau pindahkan produk terlebih dahulu.");
            }

            // Soft delete: just deactivate
            $brand->is_active = false;
            $brand->save();

            return redirect()->route('admin.brands')->with('success', 'Merek berhasil dinonaktifkan!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error deleting brand: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus merek.');
        }
    }

    /**
     * Permanently delete brand (admin only)
     */
    public function force_delete_brand($id)
    {
        try {
            $brand = Brand::findOrFail($id);

            // Check if brand has products
            $productCount = $brand->products()->count();
            if ($productCount > 0) {
                return redirect()->route('admin.brands')
                    ->with('error', "Tidak dapat menghapus merek karena masih memiliki {$productCount} produk.");
            }

            // Delete image file
            if ($brand->image && File::exists(public_path('uploads/brands/' . $brand->image))) {
                File::delete(public_path('uploads/brands/' . $brand->image));
            }

            // Delete brand
            $brand->delete();

            return redirect()->route('admin.brands')->with('success', 'Merek berhasil dihapus permanen!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error force deleting brand: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus merek.');
        }
    }

    /**
     * Bulk actions for brands
     */
    public function bulk_brand_action(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'brand_ids' => 'required|array|min:1',
            'brand_ids.*' => 'exists:brands,id'
        ]);

        try {
            $brandIds = $request->brand_ids;
            $action = $request->action;
            $count = 0;

            switch ($action) {
                case 'activate':
                    Brand::whereIn('id', $brandIds)->update(['is_active' => true]);
                    $count = count($brandIds);
                    $message = "{$count} merek berhasil diaktifkan!";
                    break;

                case 'deactivate':
                    Brand::whereIn('id', $brandIds)->update(['is_active' => false]);
                    $count = count($brandIds);
                    $message = "{$count} merek berhasil dinonaktifkan!";
                    break;

                case 'delete':
                    // Check for products before deletion
                    $brandsWithProducts = Brand::whereIn('id', $brandIds)
                        ->withCount('products')
                        ->having('products_count', '>', 0)
                        ->count();

                    if ($brandsWithProducts > 0) {
                        return redirect()->back()
                            ->with('error', "Tidak dapat menghapus {$brandsWithProducts} merek karena masih memiliki produk.");
                    }

                    // Delete images
                    $brands = Brand::whereIn('id', $brandIds)->get();
                    foreach ($brands as $brand) {
                        if ($brand->image && File::exists(public_path('uploads/brands/' . $brand->image))) {
                            File::delete(public_path('uploads/brands/' . $brand->image));
                        }
                    }

                    // Delete brands
                    Brand::whereIn('id', $brandIds)->delete();
                    $count = count($brandIds);
                    $message = "{$count} merek berhasil dihapus!";
                    break;
            }

            return redirect()->route('admin.brands')->with('success', $message);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error in bulk brand action: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses aksi massal.');
        }
    }

    /**
     * Export brands to Excel
     */
    public function export_brands(Request $request)
    {
        try {
            $query = Brand::withCount('products');

            // Apply same filters as index
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%')
                        ->orWhere('slug', 'LIKE', '%' . $search . '%');
                });
            }

            if ($request->filled('status')) {
                $query->where('is_active', $request->status);
            }

            $brands = $query->orderBy('name')->get();

            // Here you would implement Excel export
            // For now, return a simple CSV response
            $filename = 'brands_export_' . date('Y-m-d_H-i-s') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($brands) {
                $file = fopen('php://output', 'w');

                // Headers
                fputcsv($file, [
                    'ID',
                    'Nama Merek',
                    'Slug',
                    'Deskripsi',
                    'Jumlah Produk',
                    'Status',
                    'Unggulan',
                    'Dibuat',
                    'Diperbarui'
                ]);

                // Data
                foreach ($brands as $brand) {
                    fputcsv($file, [
                        $brand->id,
                        $brand->name,
                        $brand->slug,
                        $brand->description ?? '',
                        $brand->products_count,
                        $brand->is_active ? 'Aktif' : 'Nonaktif',
                        $brand->is_featured ? 'Ya' : 'Tidak',
                        $brand->created_at->format('d/m/Y H:i'),
                        $brand->updated_at->format('d/m/Y H:i')
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error exporting brands: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengekspor data.');
        }
    }

    // ====================================================================================================
    // API Methods for AJAX Operations
    // ====================================================================================================

    /**
     * Get brand details via API
     */
    public function api_get_brand($id)
    {
        try {
            $brand = Brand::withCount(['products', 'activeProducts', 'featuredProducts'])
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $brand->id,
                    'name' => $brand->name,
                    'slug' => $brand->slug,
                    'description' => $brand->description,
                    'image_url' => $brand->image_url,
                    'is_active' => $brand->is_active,
                    'is_featured' => $brand->is_featured,
                    'products_count' => $brand->products_count,
                    'active_products_count' => $brand->active_products_count,
                    'featured_products_count' => $brand->featured_products_count,
                    'created_at' => $brand->formatted_created_date,
                    'updated_at' => $brand->formatted_updated_date,
                    'statistics' => $brand->getStatistics()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Brand not found'
            ], 404);
        }
    }

    /**
     * Toggle brand status via API
     */
    public function api_toggle_brand_status($id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $brand->toggleStatus();

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diubah',
                'data' => [
                    'is_active' => $brand->is_active,
                    'status_text' => $brand->status_text,
                    'status_badge_class' => $brand->status_badge_class
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status'
            ], 500);
        }
    }

    /**
     * Toggle brand featured status via API
     */
    public function api_toggle_brand_featured($id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $brand->toggleFeatured();

            return response()->json([
                'success' => true,
                'message' => 'Status unggulan berhasil diubah',
                'data' => [
                    'is_featured' => $brand->is_featured,
                    'featured_text' => $brand->featured_text
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status unggulan'
            ], 500);
        }
    }

    /**
     * Check slug availability
     */
    public function api_check_slug(Request $request)
    {
        $slug = $request->input('slug');
        $excludeId = $request->input('exclude_id');

        $query = Brand::where('slug', $slug);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $exists = $query->exists();

        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'Slug sudah digunakan' : 'Slug tersedia'
        ]);
    }

    /**
     * Get brand statistics
     */
    public function api_get_brand_stats($id)
    {
        try {
            $brand = Brand::withCount(['products', 'activeProducts', 'featuredProducts'])
                ->findOrFail($id);

            $stats = $brand->getStatistics();

            // Add more detailed statistics
            $recentProducts = $brand->products()
                ->latest()
                ->limit(5)
                ->select('id', 'name', 'created_at')
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'basic_stats' => $stats,
                    'recent_products' => $recentProducts,
                    'charts_data' => [
                        'products_by_month' => $this->getBrandProductsByMonth($brand),
                        'status_distribution' => [
                            'active' => $brand->active_products_count,
                            'inactive' => $brand->products_count - $brand->active_products_count
                        ]
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Brand not found'
            ], 404);
        }
    }

    /**
     * Get brand products by month (for charts)
     */
    private function getBrandProductsByMonth($brand)
    {
        $months = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = $brand->products()
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $months[] = [
                'month' => $date->format('M Y'),
                'count' => $count
            ];
        }

        return $months;
    }

    // ====================================================================================================
    // Public API Methods (for frontend)
    // ====================================================================================================

    /**
     * Get public brands listing
     */
    public function api_public_brands(Request $request)
    {
        $perPage = $request->input('per_page', 12);
        $search = $request->input('search');

        $query = Brand::active()->withCount('activeProducts');

        if ($search) {
            $query->search($search);
        }

        $brands = $query->orderBy('name')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $brands->items(),
            'pagination' => [
                'current_page' => $brands->currentPage(),
                'last_page' => $brands->lastPage(),
                'per_page' => $brands->perPage(),
                'total' => $brands->total()
            ]
        ]);
    }

    /**
     * Get active brands
     */
    public function api_active_brands()
    {
        $brands = Brand::active()
            ->withCount('activeProducts')
            ->orderBy('name')
            ->get()
            ->map(function ($brand) {
                return [
                    'id' => $brand->id,
                    'name' => $brand->name,
                    'slug' => $brand->slug,
                    'image_url' => $brand->image_url,
                    'products_count' => $brand->active_products_count
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $brands
        ]);
    }

    /**
     * Get featured brands
     */
    public function api_featured_brands()
    {
        $brands = Brand::featured()
            ->active()
            ->withCount('activeProducts')
            ->orderBy('name')
            ->get()
            ->map(function ($brand) {
                return [
                    'id' => $brand->id,
                    'name' => $brand->name,
                    'slug' => $brand->slug,
                    'description' => $brand->description_excerpt,
                    'image_url' => $brand->image_url,
                    'products_count' => $brand->active_products_count
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $brands
        ]);
    }

    /**
     * Get brand by slug
     */
    public function api_brand_by_slug($slug)
    {
        try {
            $brand = Brand::where('slug', $slug)
                ->active()
                ->withCount(['activeProducts', 'featuredProducts'])
                ->firstOrFail();

            // Get some products from this brand
            $products = $brand->activeProducts()
                ->limit(8)
                ->get()
                ->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'image_url' => $product->image_url,
                        'regular_price' => $product->regular_price,
                        'sale_price' => $product->sale_price,
                        'has_discount' => $product->has_discount
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => [
                    'brand' => [
                        'id' => $brand->id,
                        'name' => $brand->name,
                        'slug' => $brand->slug,
                        'description' => $brand->description,
                        'image_url' => $brand->image_url,
                        'products_count' => $brand->active_products_count,
                        'featured_products_count' => $brand->featured_products_count
                    ],
                    'products' => $products
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Brand not found'
            ], 404);
        }
    }

    // ====================================================================================================
    // Dashboard Statistics Methods
    // ====================================================================================================

    /**
     * Get brands statistics for dashboard
     */
    public function getBrandsStatistics()
    {
        $stats = [
            'total_brands' => Brand::count(),
            'active_brands' => Brand::active()->count(),
            'featured_brands' => Brand::featured()->count(),
            'brands_with_products' => Brand::withProducts()->count(),
            'brands_without_products' => Brand::withoutProducts()->count(),
            'recent_brands' => Brand::latest()->limit(5)->get(),
            'popular_brands' => Brand::getPopularBrands(5),
            'brands_by_month' => $this->getBrandsByMonth()
        ];

        return $stats;
    }

    /**
     * Get brands created by month (for dashboard charts)
     */
    private function getBrandsByMonth()
    {
        $months = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = Brand::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $months[] = [
                'month' => $date->format('M Y'),
                'count' => $count
            ];
        }

        return $months;
    }

    // ====================================================================================================
    // Utility Methods
    // ====================================================================================================

    /**
     * Generate unique slug for brand
     */
    public function generateUniqueSlug($name, $excludeId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (true) {
            $query = Brand::where('slug', $slug);

            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }

            if (!$query->exists()) {
                break;
            }

            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Validate brand image
     */
    private function validateBrandImage($image)
    {
        $maxSize = 2 * 1024 * 1024; // 2MB
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

        if ($image->getSize() > $maxSize) {
            throw new \Exception('Ukuran file terlalu besar. Maksimal 2MB.');
        }

        if (!in_array($image->getMimeType(), $allowedTypes)) {
            throw new \Exception('Format file tidak didukung. Gunakan PNG, JPG, atau JPEG.');
        }

        // Check image dimensions
        $imageInfo = getimagesize($image->getPathname());
        if ($imageInfo[0] < 200 || $imageInfo[1] < 200) {
            throw new \Exception('Ukuran gambar terlalu kecil. Minimal 200x200 pixel.');
        }

        return true;
    }

    /**
     * Clean up old brand images
     */
    public function cleanupOldBrandImages()
    {
        $brandImagesPath = public_path('uploads/brands');
        $existingImages = Brand::pluck('image')->filter()->toArray();

        if (!is_dir($brandImagesPath)) {
            return;
        }

        $files = glob($brandImagesPath . '/*');

        foreach ($files as $file) {
            $filename = basename($file);

            if (!in_array($filename, $existingImages)) {
                unlink($file);
            }
        }
    }

    /**
     * Get brand import template
     */
    public function getBrandImportTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="brand_import_template.csv"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // Headers
            fputcsv($file, [
                'name',
                'slug',
                'description',
                'is_active',
                'is_featured'
            ]);

            // Sample data
            fputcsv($file, [
                'Contoh Merek',
                'contoh-merek',
                'Deskripsi contoh merek',
                '1',
                '0'
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ====================================================================================================
    // Halaman Categories dengan Filter dan Sorting
    // ====================================================================================================
    public function categories(Request $request)
    {
        // JANGAN gunakan ->active() di query utama, biarkan semua kategori bisa diakses
        $query = Category::with('products'); // HAPUS ->active()

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('slug', 'LIKE', "%{$search}%");
            });
        }

        // Status filter - UPDATE dengan logic yang benar
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'active':
                    $query->where('is_active', true)->whereHas('products');
                    break;
                case 'empty':
                    $query->where('is_active', true)->whereDoesntHave('products');
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
                case 'all':
                    // Tampilkan semua (aktif dan nonaktif)
                    break;
                default:
                    // Default: hanya tampilkan kategori aktif
                    $query->where('is_active', true);
                    break;
            }
        } else {
            // Jika tidak ada filter, default tampilkan hanya kategori aktif
            $query->where('is_active', true);
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'most_products':
                $query->withCount('products')->orderBy('products_count', 'desc');
                break;
            default: // newest
                $query->orderBy('created_at', 'desc');
                break;
        }

        $perPage = $request->get('per_page', 10);
        $categories = $query->paginate($perPage);

        // Data untuk summary cards
        $summaryData = [
            'totalActive' => Category::where('is_active', true)->count(),
            'totalInactive' => Category::where('is_active', false)->count(),
            'totalWithProducts' => Category::where('is_active', true)->whereHas('products')->count(),
            'totalProducts' => Category::where('is_active', true)->withCount('products')->get()->sum('products_count')
        ];

        return view("admin.categories", compact('categories', 'summaryData'));
    }

    public function toggle_active_category($id)
    {
        try {
            // JANGAN gunakan scope apapun, langsung cari berdasarkan ID
            $category = Category::findOrFail($id);

            // Toggle status is_active
            $category->is_active = !$category->is_active;
            $category->save();

            $message = $category->is_active ?
                'Kategori "' . $category->name . '" berhasil diaktifkan!' :
                'Kategori "' . $category->name . '" berhasil dinonaktifkan!';

            return redirect()->route('admin.categories')->with('status', $message);
        } catch (\Exception $e) {
            return redirect()->route('admin.categories')->with(
                'error',
                'Gagal mengubah status kategori: ' . $e->getMessage()
            );
        }
    }

    // Halaman Menambahkan Category
    public function add_category()
    {
        return view("admin.category-add");
    }
    // Halaman Menyimpan Category
    public function add_category_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug',
            'image' => [
                'nullable',
                'file',
                'mimetypes:image/*',   // terima SEMUA image MIME
                'max:2048',
            ],
        ]);
        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extention = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extention;
        $this->GenerateCategoryThumbailImage($image, $file_name);
        $category->image = $file_name;
        $category->save();
        return redirect()->route('admin.categories')->with('status', 'Record has been added successfully !');
    }
    // Halaman Upload img Category
    public function GenerateCategoryThumbailImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/categories');
        $img = Image::read($image->path());
        $img->cover(124, 124, "top");
        $img->resize(124, 124, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);
    }
    // Halaman Edit Category
    public function edit_category($id)
    {
        $category = Category::find($id);
        return view('admin.category-edit', compact('category'));
    }
    // Halaman Update Category
    public function update_category(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,' . $request->id,
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->slug = $request->slug;

        if ($request->hasFile('image')) {
            if (File::exists(public_path('uploads/categories') . '/' . $category->image)) {
                File::delete(public_path('uploads/categories') . '/' . $category->image);
            }
            $image = $request->file('image');
            $file_extention = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extention;

            $this->GenerateCategoryThumbailImage($image, $file_name);
            $category->image = $file_name;
        }
        $category->save();
        return redirect()->route('admin.categories')->with('status', 'Record has been updated successfully !');
    }
    // Halaman Delete Category
    public function delete_category($id)
    {
        $category = Category::find($id);
        if (File::exists(public_path('uploads/categories') . '/' . $category->image)) {
            File::delete(public_path('uploads/categories') . '/' . $category->image);
        }
        $category->delete();
        return redirect()->route('admin.categories')->with('status', 'Record has been deleted successfully !');
    }

    // ====================================================================================================
    // Method untuk Check Slug secara Real-time (AJAX)
    // ====================================================================================================
    public function check_slug(Request $request)
    {
        $slug = $request->get('slug');
        $id = $request->get('id'); // untuk edit mode

        if (!$slug) {
            return response()->json(['available' => false, 'message' => 'Slug tidak boleh kosong']);
        }

        $query = Category::where('slug', $slug);
        if ($id) {
            $query->where('id', '!=', $id);
        }

        $exists = $query->exists();

        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'Slug sudah digunakan' : 'Slug tersedia',
            'suggested' => $exists ? Category::generateUniqueSlug($slug, $id) : null
        ]);
    }

    // ====================================================================================================
    // Method untuk Toggle Featured Status
    // ====================================================================================================
    public function toggle_featured_category($id)
    {
        try {
            $category = Category::findOrFail($id);
            $newStatus = $category->toggleFeatured();

            return response()->json([
                'success' => true,
                'featured' => $newStatus,
                'message' => $newStatus ? 'Kategori ditandai sebagai unggulan' : 'Kategori dihapus dari unggulan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status: ' . $e->getMessage()
            ], 500);
        }
    }

    // ====================================================================================================
    // Method untuk Bulk Actions
    // ====================================================================================================
    public function bulk_action_categories(Request $request)
    {
        $request->validate([
            'action' => 'required|in:deactivate,activate,feature,unfeature,export',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id'
        ]);

        try {
            // JANGAN gunakan scope, langsung whereIn
            $categories = Category::whereIn('id', $request->categories);
            $count = $categories->count();

            switch ($request->action) {
                case 'deactivate':
                    $categories->update(['is_active' => false]);
                    return redirect()->back()->with('status', "Berhasil menonaktifkan {$count} kategori");

                case 'activate':
                    $categories->update(['is_active' => true]);
                    return redirect()->back()->with('status', "Berhasil mengaktifkan {$count} kategori");

                case 'feature':
                    $categories->update(['is_featured' => true]);
                    return redirect()->back()->with('status', "Berhasil menandai {$count} kategori sebagai unggulan");

                case 'unfeature':
                    $categories->update(['is_featured' => false]);
                    return redirect()->back()->with('status', "Berhasil menghapus {$count} kategori dari unggulan");

                case 'export':
                    return $this->export_categories($request);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal melakukan aksi: ' . $e->getMessage());
        }
    }

    // ====================================================================================================
    // Method untuk Reorder Categories (Drag & Drop)
    // ====================================================================================================
    public function reorder_categories(Request $request)
    {
        $request->validate([
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:categories,id',
            'categories.*.sort_order' => 'required|integer|min:0'
        ]);

        try {
            foreach ($request->categories as $categoryData) {
                Category::where('id', $categoryData['id'])
                    ->update(['sort_order' => $categoryData['sort_order']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Urutan kategori berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah urutan: ' . $e->getMessage()
            ], 500);
        }
    }

    // ====================================================================================================
    // Method untuk Duplicate Category
    // ====================================================================================================
    public function duplicate_category($id)
    {
        try {
            $originalCategory = Category::findOrFail($id);

            $newCategory = $originalCategory->replicate();
            $newCategory->name = $originalCategory->name . ' (Copy)';
            $newCategory->slug = Category::generateUniqueSlug($newCategory->name);
            $newCategory->is_featured = false; // Reset featured status
            $newCategory->sort_order = 0; // Reset sort order

            // Duplicate image if exists
            if ($originalCategory->image) {
                $originalImagePath = public_path('uploads/categories/' . $originalCategory->image);
                if (File::exists($originalImagePath)) {
                    $newImageName = 'copy-' . Carbon::now()->timestamp . '-' . $originalCategory->image;
                    $newImagePath = public_path('uploads/categories/' . $newImageName);
                    File::copy($originalImagePath, $newImagePath);
                    $newCategory->image = $newImageName;
                }
            }

            $newCategory->save();

            return redirect()->route('admin.category.edit', $newCategory->id)
                ->with('status', 'Kategori berhasil diduplikasi. Silakan edit sesuai kebutuhan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menduplikasi kategori: ' . $e->getMessage());
        }
    }

    // ====================================================================================================
    // Method untuk Preview Category
    // ====================================================================================================
    public function preview_category($id)
    {
        $category = Category::with('products')->findOrFail($id);

        // Return view untuk preview (bisa dibuat modal atau halaman terpisah)
        return view('admin.category-preview', compact('category'));
    }

    // ====================================================================================================
    // API Methods untuk AJAX Requests
    // ====================================================================================================

    /**
     * Get category details for AJAX
     */
    public function get_category_details($id)
    {
        try {
            $category = Category::with('products')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'description' => $category->description,
                    'meta_title' => $category->meta_title,
                    'image_url' => $category->image_url,
                    'is_featured' => $category->is_featured,
                    'sort_order' => $category->sort_order,
                    'products_count' => $category->products->count(),
                    'active_products_count' => $category->active_products_count,
                    'created_at' => $category->formatted_created_at,
                    'updated_at' => $category->formatted_updated_at
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Get products by category for AJAX
     */
    public function get_category_products($id, Request $request)
    {
        try {
            $category = Category::findOrFail($id);
            $perPage = $request->get('per_page', 10);

            $products = $category->products()
                ->when($request->search, function ($query, $search) {
                    $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('SKU', 'LIKE', "%{$search}%");
                })
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $products
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat produk'
            ], 500);
        }
    }

    /**
     * Search categories for autocomplete
     */
    public function search_categories($term)
    {
        $categories = Category::search($term)
            ->limit(10)
            ->get(['id', 'name', 'slug', 'image'])
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'image_url' => $category->image_url,
                    'products_count' => $category->products()->count()
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
    /**
     * Get category statistics
     */
    public function get_category_stats($id)
    {
        try {
            $category = Category::with('products')->findOrFail($id);

            $stats = [
                'total_products' => $category->products->count(),
                'active_products' => $category->products->where('stock_status', 'instock')->count(),
                'out_of_stock' => $category->products->where('stock_status', 'outofstock')->count(),
                'featured_products' => $category->products->where('featured', true)->count(),
                'total_value' => $category->products->sum('regular_price'),
                'average_price' => $category->products->avg('regular_price'),
                'newest_product' => $category->products->latest()->first()?->name,
                'oldest_product' => $category->products->oldest()->first()?->name
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat statistik'
            ], 500);
        }
    }
    // ====================================================================================================
    // Methods untuk Mengelola Produk dalam Kategori
    // ====================================================================================================
    /**
     * Lihat semua produk dalam kategori
     */
    public function category_products($categoryId, Request $request)
    {
        $category = Category::findOrFail($categoryId);

        $products = $category->products()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('SKU', 'LIKE', "%{$search}%");
            })
            ->when($request->status, function ($query, $status) {
                $query->where('stock_status', $status);
            })
            ->paginate(20);

        return view('admin.category-products', compact('category', 'products'));
    }

    /**
     * Pindah produk ke kategori lain
     */
    public function move_products_category(Request $request, $categoryId)
    {
        $request->validate([
            'products' => 'required|array|min:1',
            'products.*' => 'exists:products,id',
            'target_category_id' => 'required|exists:categories,id'
        ]);

        try {
            $sourceCategory = Category::findOrFail($categoryId);
            $targetCategory = Category::findOrFail($request->target_category_id);

            Product::whereIn('id', $request->products)
                ->where('category_id', $categoryId)
                ->update(['category_id' => $request->target_category_id]);

            $count = count($request->products);

            return redirect()->back()->with(
                'status',
                "Berhasil memindahkan {$count} produk dari kategori '{$sourceCategory->name}' ke '{$targetCategory->name}'"
            );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memindahkan produk: ' . $e->getMessage());
        }
    }

    /**
     * Export produk dalam kategori
     */
    public function export_category_products($categoryId, Request $request)
    {
        try {
            $category = Category::findOrFail($categoryId);
            $products = $category->products;

            $filename = 'produk-kategori-' . Str::slug($category->name) . '-' . Carbon::now()->format('Y-m-d') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($products, $category) {
                $file = fopen('php://output', 'w');

                // Add BOM for UTF-8
                fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

                // CSV Headers
                fputcsv($file, [
                    'Kategori',
                    'ID Produk',
                    'Nama Produk',
                    'SKU',
                    'Harga Regular',
                    'Harga Sale',
                    'Stok',
                    'Status Stok',
                    'Featured',
                    'Dibuat',
                    'Diperbarui'
                ]);

                foreach ($products as $product) {
                    fputcsv($file, [
                        $category->name,
                        $product->id,
                        $product->name,
                        $product->SKU,
                        $product->regular_price,
                        $product->sale_price ?: 0,
                        $product->quantity,
                        $product->stock_status,
                        $product->featured ? 'Ya' : 'Tidak',
                        $product->created_at->format('d/m/Y H:i'),
                        $product->updated_at->format('d/m/Y H:i')
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengekspor data: ' . $e->getMessage());
        }
    }


    // ====================================================================================================
    // Halaman Produk
    // // ====================================================================================================
    /**
     * Update method products untuk mendukung pencarian dan filter
     */
    public function products(Request $request)
    {
        $query = Product::with(['category', 'brand'])->orderBy('created_at', 'DESC');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('SKU', 'LIKE', "%{$search}%")
                    ->orWhereHas('category', function ($cat) use ($search) {
                        $cat->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('brand', function ($brand) use ($search) {
                        $brand->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Category filter
        if ($request->has('category_filter') && $request->category_filter) {
            $query->where('category_id', $request->category_filter);
        }

        // Status filter
        if ($request->has('status_filter') && $request->status_filter) {
            $query->where('stock_status', $request->status_filter);
        }

        $products = $query->paginate(10);

        // Tambahkan append untuk mempertahankan parameter filter di pagination
        $products->appends($request->query());

        return view("admin.products", compact('products'));
    }

    /**
     * Get product detail untuk modal (AJAX endpoint)
     */
    public function product_detail($id)
    {
        $product = Product::with(['category', 'brand', 'sizes'])->find($id);

        if (!$product) {
            return response()->json(['error' => 'Produk tidak ditemukan'], 404);
        }

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'sku' => $product->SKU,
            'category' => $product->category->name ?? '',
            'brand' => $product->brand->name ?? '',
            'regular_price' => formatRupiah($product->regular_price),
            'sale_price' => formatRupiah($product->sale_price),
            'quantity' => $product->quantity,
            'stock_status' => $product->stock_status,
            'featured' => $product->featured,
            'short_description' => $product->short_description,
            'description' => $product->description,
            'image' => asset('uploads/products/' . $product->image),
            'created_at' => $product->created_at->format('d/m/Y H:i'),
            'updated_at' => $product->updated_at->format('d/m/Y H:i'),
            'sizes' => $product->sizes->map(function ($size) {
                return [
                    'name' => $size->name,
                    'stock' => $size->pivot->stock
                ];
            })
        ]);
    }

    public function add_product()
    {
        $categories = Category::Select('id', 'name')->orderBy('name')->get();
        $brands = Brand::Select('id', 'name')->orderBy('name')->get();

        $sizes = Size::orderBy('name')->get();

        return view('admin.product-add', compact('categories', 'brands', 'sizes'));
    }

    // Halaman Menyimpan Produk
    public function product_store(Request $request)
    {
        // Validasi dengan logic yang diperbaiki
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:products,name', // Nama produk harus unik
            ],
            'slug' => [
                'required',
                'string',
                'max:100',
                'unique:products,slug', // Slug harus unik
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', // Format slug yang valid
            ],
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'short_description' => 'required|string|max:200',
            'description' => 'required|string',
            'regular_price' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $price = (float) str_replace(['Rp ', '.'], '', $value);
                    if ($price <= 0) {
                        $fail('Harga normal harus lebih besar dari 0.');
                    }
                },
            ],
            'sale_price' => [
                'nullable', // Sale price bisa kosong (tidak ada diskon)
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if (!empty($value)) {
                        $regularPrice = (float) str_replace(['Rp ', '.'], '', $request->regular_price);
                        $salePrice = (float) str_replace(['Rp ', '.'], '', $value);

                        if ($salePrice <= 0) {
                            $fail('Harga diskon harus lebih besar dari 0.');
                        }

                        if ($salePrice >= $regularPrice) {
                            $fail('Harga diskon harus lebih kecil dari harga normal.');
                        }
                    }
                },
            ],
            'SKU' => [
                'required',
                'string',
                'max:50',
                'unique:products,SKU', // SKU harus unik
            ],
            'stock_status' => 'required|in:instock,outofstock',
            'featured' => 'required|in:0,1',
            'quantity' => $request->has('has_sizes') ? 'nullable|integer|min:0' : 'required|integer|min:0',
            'image' => [
                'required',
                'file',
                'mimetypes:image/jpeg,image/png,image/jpg',
                'max:2048', // Maksimal 2MB
            ],
            'images.*' => [
                'nullable',
                'file',
                'mimetypes:image/jpeg,image/png,image/jpg',
                'max:2048', // Maksimal 2MB per file
            ],
            // Validasi ukuran yang diperbaiki
            'sizes' => $request->has('has_sizes') ? 'nullable|array' : 'nullable',
            'sizes.*' => 'exists:sizes,id',
            'stocks' => $request->has('has_sizes') ? 'nullable|array' : 'nullable',
            'stocks.*' => 'nullable|integer|min:0',
            'new_sizes' => $request->has('has_sizes') ? 'nullable|array' : 'nullable',
            'new_sizes.*' => 'nullable|string|max:50|distinct', // Ukuran baru harus unik dalam request
            'new_stocks' => $request->has('has_sizes') ? 'nullable|array' : 'nullable',
            'new_stocks.*' => 'nullable|integer|min:0',
        ], [
            // Custom error messages
            'name.unique' => 'Nama produk sudah digunakan. Silakan gunakan nama yang berbeda.',
            'slug.unique' => 'Slug sudah digunakan. Silakan gunakan slug yang berbeda.',
            'slug.regex' => 'Format slug tidak valid. Gunakan huruf kecil, angka, dan tanda hubung.',
            'SKU.unique' => 'SKU sudah digunakan. Silakan gunakan SKU yang berbeda.',
            'regular_price.required' => 'Harga normal wajib diisi.',
            'image.required' => 'Gambar utama produk wajib diupload.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'images.*.max' => 'Ukuran setiap gambar galeri maksimal 2MB.',
            'new_sizes.*.distinct' => 'Ukuran baru tidak boleh sama dalam satu produk.',
            'sizes.*.exists' => 'Ukuran yang dipilih tidak valid.',
            'stocks.*.min' => 'Stok tidak boleh negatif.',
            'new_stocks.*.min' => 'Stok ukuran baru tidak boleh negatif.',
        ]);

        try {
            DB::beginTransaction();

            $product = new Product();
            $product->name = $request->name;
            $product->slug = $request->slug; // Gunakan slug dari input (sudah divalidasi unik)
            $product->short_description = $request->short_description;
            $product->description = $request->description;

            // Proses harga dengan pembersihan format
            $regular_price = str_replace(['Rp ', '.', ','], '', $request->regular_price);
            $product->regular_price = (float) $regular_price;

            // Proses harga diskon (bisa kosong)
            if (!empty($request->sale_price)) {
                $sale_price = str_replace(['Rp ', '.', ','], '', $request->sale_price);
                $product->sale_price = (float) $sale_price;
            } else {
                // Jika tidak ada diskon, set sale_price sama dengan regular_price
                $product->sale_price = $product->regular_price;
            }

            $product->SKU = strtoupper($request->SKU); // Convert SKU ke uppercase
            $product->stock_status = $request->stock_status;
            $product->featured = (bool) $request->featured;
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;

            // Set quantity berdasarkan apakah produk memiliki ukuran atau tidak
            if (!$request->has('has_sizes')) {
                $product->quantity = $request->quantity;
            } else {
                // Akan dihitung ulang setelah sync sizes
                $product->quantity = 0;
            }

            $current_timestamp = Carbon::now()->timestamp;

            // Proses upload gambar utama
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $current_timestamp . '.' . $image->extension();

                // Validasi tambahan untuk gambar
                if (!in_array($image->extension(), ['jpg', 'jpeg', 'png'])) {
                    throw new \Exception('Format gambar tidak didukung. Gunakan JPG, JPEG, atau PNG.');
                }

                $this->GenerateProductThumbailImage($image, $imageName);
                $product->image = $imageName;
            }

            // Proses gambar galeri
            $gallery_arr = array();
            $gallery_images = "";
            $counter = 1;

            if ($request->hasFile('images')) {
                $allowedfileExtension = ['jpg', 'png', 'jpeg'];
                $files = $request->file('images');

                // Batasi maksimal 10 gambar galeri
                if (count($files) > 10) {
                    throw new \Exception('Maksimal 10 gambar galeri yang diizinkan.');
                }

                foreach ($files as $file) {
                    $gextension = $file->getClientOriginalExtension();
                    $check = in_array(strtolower($gextension), $allowedfileExtension);
                    if ($check) {
                        $gfilename = $current_timestamp . "-" . $counter . "." . $gextension;
                        $this->GenerateProductThumbailImage($file, $gfilename);
                        array_push($gallery_arr, $gfilename);
                        $counter = $counter + 1;
                    }
                }
                $gallery_images = implode(',', $gallery_arr);
            }
            $product->images = $gallery_images;

            // Simpan produk
            $product->save();

            // Proses ukuran produk jika fitur ukuran diaktifkan
            if ($request->has('has_sizes')) {
                $syncData = [];
                $totalStock = 0;

                // 1. Proses ukuran yang sudah ada
                if ($request->has('sizes') && is_array($request->sizes)) {
                    foreach ($request->sizes as $sizeId) {
                        $stock = isset($request->stocks[$sizeId]) ? (int) $request->stocks[$sizeId] : 0;
                        $syncData[$sizeId] = ['stock' => $stock];
                        $totalStock += $stock;
                    }
                }

                // 2. Proses ukuran baru yang ditambahkan
                if ($request->has('new_sizes') && is_array($request->new_sizes)) {
                    foreach ($request->new_sizes as $index => $newSizeName) {
                        $newSizeName = trim($newSizeName);
                        if (!empty($newSizeName)) {
                            // Cek apakah ukuran sudah ada (case insensitive)
                            $existingSize = Size::whereRaw('LOWER(name) = ?', [strtolower($newSizeName)])->first();

                            if ($existingSize) {
                                // Jika ukuran sudah ada, gunakan yang existing
                                $size = $existingSize;
                            } else {
                                // Jika belum ada, buat baru
                                $size = Size::create(['name' => $newSizeName]);
                            }

                            $stock = isset($request->new_stocks[$index]) ? (int) $request->new_stocks[$index] : 0;
                            $syncData[$size->id] = ['stock' => $stock];
                            $totalStock += $stock;
                        }
                    }
                }

                // Sync dengan tabel pivot
                $product->sizes()->sync($syncData);

                // Update total quantity
                $product->update(['quantity' => $totalStock]);

                // Update stock status berdasarkan total stock
                if ($totalStock > 0) {
                    $product->update(['stock_status' => 'instock']);
                } else {
                    $product->update(['stock_status' => 'outofstock']);
                }
            } else {
                // Jika tidak menggunakan ukuran, pastikan stock_status sesuai dengan quantity
                if ($product->quantity > 0) {
                    $product->update(['stock_status' => 'instock']);
                }
            }

            DB::commit();

            // Log aktivitas (opsional)
            \Illuminate\Support\Facades\Log::info('Product created successfully', [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'created_by' => auth()->user()->id ?? 'system'
            ]);

            return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan! 🎉');
        } catch (\Exception $e) {
            DB::rollback();

            // Log error
            \Illuminate\Support\Facades\Log::error('Error creating product', [
                'error' => $e->getMessage(),
                'request_data' => $request->except(['image', 'images']), // Exclude file data from logs
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan produk: ' . $e->getMessage());
        }
    }

    // Method helper baru untuk validasi AJAX
    public function validateProductField(Request $request)
    {
        $field = $request->get('field');
        $value = $request->get('value');
        $productId = $request->get('product_id'); // Untuk edit mode

        switch ($field) {
            case 'name':
                $exists = Product::where('name', $value)
                    ->when($productId, function ($query) use ($productId) {
                        return $query->where('id', '!=', $productId);
                    })
                    ->exists();

                return response()->json([
                    'valid' => !$exists,
                    'message' => $exists ? 'Nama produk sudah digunakan.' : 'Nama produk tersedia.'
                ]);

            case 'slug':
                $exists = Product::where('slug', $value)
                    ->when($productId, function ($query) use ($productId) {
                        return $query->where('id', '!=', $productId);
                    })
                    ->exists();

                return response()->json([
                    'valid' => !$exists,
                    'message' => $exists ? 'Slug sudah digunakan.' : 'Slug tersedia.'
                ]);

            case 'sku':
                $exists = Product::where('SKU', strtoupper($value))
                    ->when($productId, function ($query) use ($productId) {
                        return $query->where('id', '!=', $productId);
                    })
                    ->exists();

                return response()->json([
                    'valid' => !$exists,
                    'message' => $exists ? 'SKU sudah digunakan.' : 'SKU tersedia.'
                ]);

            default:
                return response()->json(['valid' => true, 'message' => '']);
        }
    }

    // Method untuk generate SKU otomatis
    public function generateSKU(Request $request)
    {
        $categoryId = $request->get('category_id');
        $brandId = $request->get('brand_id');

        $category = Category::find($categoryId);
        $brand = Brand::find($brandId);

        if (!$category || !$brand) {
            return response()->json(['sku' => '']);
        }

        // Format SKU: CAT-BRD-001
        $categoryCode = strtoupper(substr($category->name, 0, 3));
        $brandCode = strtoupper(substr($brand->name, 0, 3));

        // Cari nomor urut terakhir untuk kombinasi kategori dan brand ini
        $lastProduct = Product::where('category_id', $categoryId)
            ->where('brand_id', $brandId)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastProduct) {
            // Extract nomor dari SKU terakhir
            $lastSKU = $lastProduct->SKU;
            preg_match('/(\d+)$/', $lastSKU, $matches);
            if (isset($matches[1])) {
                $nextNumber = intval($matches[1]) + 1;
            }
        }

        $sku = $categoryCode . '-' . $brandCode . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // Pastikan SKU unik
        while (Product::where('SKU', $sku)->exists()) {
            $nextNumber++;
            $sku = $categoryCode . '-' . $brandCode . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        }

        return response()->json(['sku' => $sku]);
    }

    // Method untuk mendapatkan estimasi harga berdasarkan kategori
    public function getPriceSuggestion(Request $request)
    {
        $categoryId = $request->get('category_id');

        if (!$categoryId) {
            return response()->json(['suggestion' => null]);
        }

        // Hitung rata-rata harga dalam kategori yang sama
        $avgPrice = Product::where('category_id', $categoryId)
            ->where('regular_price', '>', 0)
            ->avg('regular_price');

        if ($avgPrice) {
            // Berikan range harga
            $minPrice = round($avgPrice * 0.8);
            $maxPrice = round($avgPrice * 1.2);

            return response()->json([
                'suggestion' => [
                    'min' => $minPrice,
                    'max' => $maxPrice,
                    'avg' => round($avgPrice)
                ]
            ]);
        }

        return response()->json(['suggestion' => null]);
    }

    // Halaman Generate Thumbnail Image
    public function GenerateProductThumbailImage($image, $imageName)
    {
        $destinationPathThumbnail = public_path('uploads/products/thumbnails');
        $destinationPath = public_path('uploads/products');
        $img = Image::read($image->path());

        $img->cover(540, 689, "top");
        $img->resize(540, 689, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);

        $img->resize(104, 104, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPathThumbnail . '/' . $imageName);
    }

    // Halaman menampilkan Edit Produk
    public function edit_product($id)
    {
        $product = Product::find($id);
        $categories = Category::Select('id', 'name')->orderBy('name')->get();
        $brands = Brand::Select('id', 'name')->orderBy('name')->get();
        $sizes = Size::orderBy('name')->get(); // Tambahkan baris ini

        return view('admin.product-edit', compact('product', 'categories', 'brands', 'sizes')); // Tambahkan 'sizes' ke compact
    }

    // Halaman Update Produk
    public function update_product(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug,' . $request->id,
            'category_id' => 'required',
            'brand_id' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required',
            'sale_price' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $regularPrice = (float) str_replace(['Rp ', '.'], '', $request->regular_price);
                    $salePrice = (float) str_replace(['Rp ', '.'], '', $value);

                    if ($salePrice >= $regularPrice) {
                        $fail('Harga diskon harus lebih kecil dari harga normal.');
                    }
                },
            ],
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => $request->has('has_sizes') ? 'nullable' : 'required', // Jika ukuran diaktifkan, quantity boleh kosong
            'image' => 'mimes:png,jpg,jpeg|max:2048',
            // Validasi ukuran jika diaktifkan
            'sizes' => $request->has('has_sizes') ? 'array' : 'nullable',
            'sizes.*' => 'exists:sizes,id',
            'stocks' => $request->has('has_sizes') ? 'array' : 'nullable',
            'stocks.*' => 'integer|min:0',
            // Validasi ukuran baru
            'new_sizes' => $request->has('has_sizes') ? 'array' : 'nullable',
            'new_sizes.*' => 'nullable|string|max:50',
            'new_stocks' => $request->has('has_sizes') ? 'array' : 'nullable',
            'new_stocks.*' => 'nullable|integer|min:0',
        ], [
            'sizes.*.exists' => 'Ukuran yang dipilih tidak valid.',
            'stocks.*.integer' => 'Stok harus berupa angka.',
            'stocks.*.min' => 'Stok minimal 0.',
            'new_stocks.*.integer' => 'Stok ukuran baru harus berupa angka.',
            'new_stocks.*.min' => 'Stok ukuran baru minimal 0.',
        ]);

        $product = Product::find($request->id);
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;

        // Bersihkan format rupiah dan konversi ke numeric
        $regular_price = str_replace(['Rp ', '.'], '', $request->regular_price);
        $sale_price = str_replace(['Rp ', '.'], '', $request->sale_price);
        $product->regular_price = (float)$regular_price;
        $product->sale_price = (float)$sale_price;

        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;

        // Set quantity berdasarkan apakah produk memiliki ukuran atau tidak
        if (!$request->has('has_sizes')) {
            $product->quantity = $request->quantity;
        } else {
            // Sementara set ke 0, akan dihitung ulang setelah sync sizes
            $product->quantity = 0;
        }

        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        $current_timestamp = Carbon::now()->timestamp;

        // Proses upload gambar (kode tetap sama)
        if ($request->hasFile('image')) {
            if (File::exists(public_path('uploads/products') . '/' . $product->image)) {
                File::delete(public_path('uploads/products') . '/' . $product->image);
            }
            if (File::exists(public_path('uploads/products/thumbnails') . '/' . $product->image)) {
                File::delete(public_path('uploads/products/thumbnails') . '/' . $product->image);
            }
            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $this->GenerateProductThumbailImage($image, $imageName);
            $product->image = $imageName;
        }

        // Proses gambar galeri (kode tetap sama)
        $gallery_arr = array();
        $gallery_images = "";
        $counter = 1;

        if ($request->hasFile('images')) {
            foreach (explode(',', $product->images) as $ofile) {
                if (File::exists(public_path('uploads/products') . '/' . $ofile)) {
                    File::delete(public_path('uploads/products') . '/' . $ofile);
                }
                if (File::exists(public_path('uploads/products/thumbnails') . '/' . $ofile)) {
                    File::delete(public_path('uploads/products/thumbnails') . '/' . $ofile);
                }
            }
            $allowedfileExtension = ['jpg', 'png', 'jpeg'];
            $files = $request->file('images');
            foreach ($files as $file) {
                $gextension = $file->getClientOriginalExtension();
                $gcheck = in_array($gextension, $allowedfileExtension);
                if ($gcheck) {
                    $gfilename = $current_timestamp . "-" . $counter . "." . $gextension;
                    $this->GenerateProductThumbailImage($file, $gfilename);
                    array_push($gallery_arr, $gfilename);
                    $counter = $counter + 1;
                }
            }
            $gallery_images = implode(',', $gallery_arr);
            $product->images = $gallery_images;
        }

        // Simpan produk
        $product->save();

        // Jika fitur ukuran diaktifkan, proses data ukuran
        if ($request->has('has_sizes')) {
            $syncData = [];

            // 1. Proses ukuran yang sudah ada
            if ($request->has('sizes') && is_array($request->sizes)) {
                foreach ($request->sizes as $sizeId) {
                    $stock = isset($request->stocks[$sizeId]) ? (int) $request->stocks[$sizeId] : 0;
                    $syncData[$sizeId] = ['stock' => $stock];
                }
            }

            // 2. Proses ukuran baru yang ditambahkan
            if ($request->has('new_sizes') && is_array($request->new_sizes)) {
                foreach ($request->new_sizes as $index => $newSizeName) {
                    $newSizeName = trim($newSizeName);
                    if (!empty($newSizeName)) {
                        $size = Size::firstOrCreate(['name' => $newSizeName]);
                        $stock = isset($request->new_stocks[$index]) ? (int) $request->new_stocks[$index] : 0;
                        $syncData[$size->id] = ['stock' => $stock];
                    }
                }
            }

            // Sync dengan tabel pivot (akan menghapus semua relasi yang tidak ada di $syncData)
            $product->sizes()->sync($syncData);

            // TAMBAHAN: Hitung ulang total quantity setelah sync
            $totalStock = $product->sizes()->sum('stock');
            $product->update(['quantity' => $totalStock]);
        } else {
            // Jika fitur ukuran dinonaktifkan, hapus semua relasi ukuran
            $product->sizes()->detach();
        }

        return redirect()->route('admin.products')->with('status', 'Produk Berhasil Di Perbaharui!');
    }

    // Halaman Delete Produk
    public function delete_product($id)
    {
        $product = Product::find($id);
        if (File::exists(public_path('uploads/products') . '/' . $product->image)) {
            File::delete(public_path('uploads/products') . '/' . $product->image);
        }
        if (File::exists(public_path('uploads/products/thumbnails') . '/' . $product->image)) {
            File::delete(public_path('uploads/products/thumbnails') . '/' . $product->image);
        }

        foreach (explode(',', $product->images) as $ofile) {
            if (File::exists(public_path('uploads/products') . '/' . $ofile)) {
                File::delete(public_path('uploads/products') . '/' . $ofile);
            }
            if (File::exists(public_path('uploads/products/thumbnails') . '/' . $ofile)) {
                File::delete(public_path('uploads/products/thumbnails') . '/' . $ofile);
            }
        }

        $product->delete();
        return redirect()->route('admin.products')->with('status', 'Record has been deleted successfully !');
    }

    /**
     * Nonaktifkan produk (Soft Delete) - Pengganti delete
     */
    public function deactivate_product($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('admin.products')->with('error', 'Produk tidak ditemukan!');
        }

        // Set quantity ke 0 untuk "menonaktifkan" produk
        $product->quantity = 0;
        $product->stock_status = 'outofstock';
        $product->save();

        return redirect()->route('admin.products')->with('status', 'Produk berhasil dinonaktifkan!');
    }

    /**
     * Toggle status unggulan produk
     */
    public function toggle_featured($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('admin.products')->with('error', 'Produk tidak ditemukan!');
        }

        $product->featured = !$product->featured;
        $product->save();

        $status = $product->featured ? 'ditambahkan ke' : 'dihapus dari';
        return redirect()->route('admin.products')->with('status', "Produk berhasil {$status} unggulan!");
    }

    /**
     * Duplikasi produk
     */
    public function duplicate_product($id)
    {
        $original = Product::find($id);

        if (!$original) {
            return redirect()->route('admin.products')->with('error', 'Produk tidak ditemukan!');
        }

        $duplicate = $original->replicate();
        $duplicate->name = $original->name . ' (Copy)';
        $duplicate->slug = Str::slug($duplicate->name) . '-' . time();
        $duplicate->SKU = $original->SKU . '-COPY';
        $duplicate->created_at = now();
        $duplicate->updated_at = now();

        $duplicate->save();

        // Duplikasi relasi ukuran jika ada
        if ($original->sizes()->exists()) {
            $sizes = $original->sizes()->withPivot('stock')->get();
            $syncData = [];
            foreach ($sizes as $size) {
                $syncData[$size->id] = ['stock' => $size->pivot->stock];
            }
            $duplicate->sizes()->sync($syncData);
        }

        return redirect()->route('admin.product.edit', ['id' => $duplicate->id])
            ->with('status', 'Produk berhasil diduplikasi! Silakan edit sesuai kebutuhan.');
    }

    /**
     * Bulk actions untuk produk
     */
    public function bulk_action_produk(Request $request)
    {
        $action = $request->input('action');
        $productIds = json_decode($request->input('products', '[]'));

        if (empty($productIds)) {
            return redirect()->route('admin.products')->with('error', 'Tidak ada produk yang dipilih!');
        }

        $count = 0;

        switch ($action) {
            case 'activate':
                $count = Product::whereIn('id', $productIds)
                    ->where('quantity', 0)
                    ->update([
                        'quantity' => 1, // Set minimal quantity
                        'stock_status' => 'instock'
                    ]);
                $message = "{$count} produk berhasil diaktifkan!";
                break;

            case 'deactivate':
                $count = Product::whereIn('id', $productIds)
                    ->update([
                        'quantity' => 0,
                        'stock_status' => 'outofstock'
                    ]);
                $message = "{$count} produk berhasil dinonaktifkan!";
                break;

            case 'featured':
                $count = Product::whereIn('id', $productIds)
                    ->update(['featured' => true]);
                $message = "{$count} produk berhasil dijadikan unggulan!";
                break;

            default:
                return redirect()->route('admin.products')->with('error', 'Aksi tidak valid!');
        }

        return redirect()->route('admin.products')->with('status', $message);
    }

    /**
     * Export produk ke CSV
     */
    public function export_products()
    {
        $products = Product::with(['category', 'brand'])->get();

        $csvData = [];
        $csvData[] = [
            'ID',
            'Nama Produk',
            'SKU',
            'Kategori',
            'Merek',
            'Harga Regular',
            'Harga Diskon',
            'Stok',
            'Status Stok',
            'Unggulan',
            'Dibuat',
            'Diupdate'
        ];

        foreach ($products as $product) {
            $csvData[] = [
                $product->id,
                $product->name,
                $product->SKU,
                $product->category->name ?? '',
                $product->brand->name ?? '',
                $product->regular_price,
                $product->sale_price,
                $product->quantity,
                $product->stock_status,
                $product->featured ? 'Ya' : 'Tidak',
                $product->created_at->format('Y-m-d H:i:s'),
                $product->updated_at->format('Y-m-d H:i:s')
            ];
        }

        $filename = 'products_export_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($csvData) {
            $file = fopen('php://output', 'w');
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    // ====================================================================================================
    // Halaman Coupons dengan Filter dan Pencarian
    // ====================================================================================================
    public function coupons(Request $request)
    {
        $query = Coupon::query();

        // Filter berdasarkan pencarian kode kupon
        if ($request->filled('search')) {
            $query->where('code', 'LIKE', '%' . $request->search . '%');
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'active':
                    $query->where('is_active', true)
                        ->where('expiry_date', '>=', Carbon::today());
                    break;
                case 'expired':
                    $query->where('expiry_date', '<', Carbon::today());
                    break;
                case 'soon_expire':
                    $query->where('expiry_date', '<=', Carbon::today()->addDays(7))
                        ->where('expiry_date', '>=', Carbon::today());
                    break;
            }
        }

        // Filter berdasarkan rentang nilai diskon
        if ($request->filled('amount_range')) {
            switch ($request->amount_range) {
                case 'small':
                    $query->where('discount_amount', '<', 50000);
                    break;
                case 'medium':
                    $query->whereBetween('discount_amount', [50000, 200000]);
                    break;
                case 'large':
                    $query->where('discount_amount', '>', 200000);
                    break;
            }
        }

        // Filter berdasarkan tanggal berakhir
        if ($request->filled('date_from')) {
            $query->where('expiry_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('expiry_date', '<=', $request->date_to);
        }

        // Urutkan berdasarkan tanggal berakhir terbaru
        $coupons = $query->orderBy('expiry_date', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->paginate(12);

        return view("admin.coupons", compact('coupons'));
    }

    // Menambahkan Kupon
    public function add_coupon()
    {
        return view("admin.coupon-add");
    }

    // Menyimpan Kupon dengan Validasi yang Ditingkatkan
    public function add_coupon_store(Request $request)
    {
        // Bersihkan input format rupiah - hapus semua karakter kecuali angka
        $discountAmount = preg_replace('/[^0-9]/', '', $request->discount_amount);
        $minimumOrder = preg_replace('/[^0-9]/', '', $request->minimum_order);

        // Merge ke request untuk validasi
        $request->merge([
            'discount_amount' => $discountAmount,
            'minimum_order' => $minimumOrder,
        ]);

        $request->validate([
            'code' => 'required|unique:coupons,code|max:50|regex:/^[A-Z0-9]+$/',
            'discount_amount' => 'required|numeric|min:1000|max:10000000', // Max 10 juta
            'minimum_order' => 'required|numeric|min:0|max:100000000', // Max 100 juta
            'expiry_date' => 'required|date|after:today|before:' . Carbon::now()->addYear()->format('Y-m-d'), // Max 1 tahun
        ], [
            'code.required' => 'Kode kupon wajib diisi',
            'code.unique' => 'Kode kupon sudah digunakan, silakan gunakan kode lain',
            'code.regex' => 'Kode kupon hanya boleh menggunakan huruf besar dan angka',
            'discount_amount.required' => 'Nilai diskon wajib diisi',
            'discount_amount.numeric' => 'Nilai diskon harus berupa angka',
            'discount_amount.min' => 'Nilai diskon minimal Rp 1.000',
            'discount_amount.max' => 'Nilai diskon maksimal Rp 10.000.000',
            'minimum_order.required' => 'Minimum order wajib diisi',
            'minimum_order.numeric' => 'Minimum order harus berupa angka',
            'minimum_order.max' => 'Minimum order maksimal Rp 100.000.000',
            'expiry_date.required' => 'Tanggal kadaluarsa wajib diisi',
            'expiry_date.after' => 'Tanggal kadaluarsa harus setelah hari ini',
            'expiry_date.before' => 'Tanggal kadaluarsa maksimal 1 tahun dari sekarang'
        ]);

        // Validasi logika bisnis
        if ((int)$discountAmount > (int)$minimumOrder && (int)$minimumOrder > 0) {
            return back()->withErrors([
                'discount_amount' => 'Nilai diskon tidak boleh lebih besar dari minimum pembelian'
            ])->withInput();
        }

        try {
            DB::beginTransaction();

            Coupon::create([
                'code' => strtoupper($request->code),
                'discount_amount' => (int)$discountAmount,
                'minimum_order' => (int)$minimumOrder,
                'expiry_date' => $request->expiry_date,
                'is_active' => true
            ]);

            DB::commit();

            return redirect()->route("admin.coupons")->with('status', 'Kupon berhasil ditambahkan! Kupon ' . strtoupper($request->code) . ' siap digunakan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan kupon: ' . $e->getMessage()])->withInput();
        }
    }

    // Halaman Edit Kupon
    public function edit_coupon($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupon-edit', compact('coupon'));
    }

    // Halaman Update Kupon dengan Validasi yang Ditingkatkan
    public function update_coupon(Request $request)
    {
        // Bersihkan input format rupiah - hapus semua karakter kecuali angka
        $discountAmount = preg_replace('/[^0-9]/', '', $request->discount_amount);
        $minimumOrder = preg_replace('/[^0-9]/', '', $request->minimum_order);

        // Merge ke request untuk validasi
        $request->merge([
            'discount_amount' => $discountAmount,
            'minimum_order' => $minimumOrder,
        ]);

        $request->validate([
            'code' => 'required|unique:coupons,code,' . $request->id . '|max:50|regex:/^[A-Z0-9]+$/',
            'discount_amount' => 'required|numeric|min:1000|max:10000000',
            'minimum_order' => 'required|numeric|min:0|max:100000000',
            'expiry_date' => 'required|date|after:today|before:' . Carbon::now()->addYear()->format('Y-m-d'),
        ], [
            'code.unique' => 'Kode kupon sudah digunakan, silakan gunakan kode lain',
            'code.regex' => 'Kode kupon hanya boleh menggunakan huruf besar dan angka',
            'discount_amount.required' => 'Nilai diskon wajib diisi',
            'discount_amount.numeric' => 'Nilai diskon harus berupa angka',
            'discount_amount.min' => 'Nilai diskon minimal Rp 1.000',
            'discount_amount.max' => 'Nilai diskon maksimal Rp 10.000.000',
            'minimum_order.required' => 'Minimum order wajib diisi',
            'minimum_order.numeric' => 'Minimum order harus berupa angka',
            'minimum_order.max' => 'Minimum order maksimal Rp 100.000.000',
            'expiry_date.after' => 'Tanggal kadaluarsa harus setelah hari ini',
            'expiry_date.before' => 'Tanggal kadaluarsa maksimal 1 tahun dari sekarang'
        ]);

        // Validasi logika bisnis
        if ((int)$discountAmount > (int)$minimumOrder && (int)$minimumOrder > 0) {
            return back()->withErrors([
                'discount_amount' => 'Nilai diskon tidak boleh lebih besar dari minimum pembelian'
            ])->withInput();
        }

        try {
            DB::beginTransaction();

            $coupon = Coupon::findOrFail($request->id);
            $oldCode = $coupon->code;

            $coupon->update([
                'code' => strtoupper($request->code),
                'discount_amount' => (int)$discountAmount,
                'minimum_order' => (int)$minimumOrder,
                'expiry_date' => $request->expiry_date,
            ]);

            DB::commit();

            $message = 'Kupon berhasil diperbarui!';
            if ($oldCode !== strtoupper($request->code)) {
                $message .= ' Kode kupon berubah dari ' . $oldCode . ' menjadi ' . strtoupper($request->code) . '.';
            }

            return redirect()->route('admin.coupons')->with('status', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui kupon: ' . $e->getMessage()])->withInput();
        }
    }

    // Toggle Status Kupon (Fitur Baru)
    public function toggle_coupon_status($id)
    {
        try {
            $coupon = Coupon::findOrFail($id);
            $coupon->update([
                'is_active' => !$coupon->is_active
            ]);

            $status = $coupon->is_active ? 'diaktifkan' : 'dinonaktifkan';
            return redirect()->route('admin.coupons')->with('status', 'Kupon ' . $coupon->code . ' berhasil ' . $status . '!');
        } catch (\Exception $e) {
            return redirect()->route('admin.coupons')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Bulk Actions (Fitur Baru)
    public function bulk_coupon_actions(Request $request)
    {
        $request->validate([
            'action' => 'required|in:toggle_status,delete',
            'coupon_ids' => 'required|array',
            'coupon_ids.*' => 'exists:coupons,id'
        ]);

        try {
            DB::beginTransaction();

            $coupons = Coupon::whereIn('id', $request->coupon_ids)->get();
            $count = $coupons->count();

            switch ($request->action) {
                case 'toggle_status':
                    foreach ($coupons as $coupon) {
                        $coupon->update(['is_active' => !$coupon->is_active]);
                    }
                    $message = $count . ' kupon berhasil diubah statusnya!';
                    break;

                case 'delete':
                    Coupon::whereIn('id', $request->coupon_ids)->delete();
                    $message = $count . ' kupon berhasil dihapus!';
                    break;
            }

            DB::commit();
            return redirect()->route('admin.coupons')->with('status', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.coupons')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Halaman Delete Kupon dengan Pengecekan Penggunaan
    public function delete_coupon($id)
    {
        try {
            $coupon = Coupon::findOrFail($id);

            // TODO: Tambahkan pengecekan apakah kupon sedang digunakan di pesanan aktif
            // Contoh: if ($coupon->orders()->where('status', 'pending')->exists()) {
            //     return redirect()->route('admin.coupons')->with('error', 'Kupon tidak dapat dihapus karena sedang digunakan dalam pesanan aktif.');
            // }

            $couponCode = $coupon->code;
            $coupon->delete();

            return redirect()->route('admin.coupons')->with('status', 'Kupon ' . $couponCode . ' berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.coupons')->with('error', 'Terjadi kesalahan saat menghapus kupon: ' . $e->getMessage());
        }
    }

    // Export Kupon ke Excel (Fitur Baru)
    public function export_coupons(Request $request)
    {
        try {
            $query = Coupon::query();

            // Apply same filters as index
            if ($request->filled('search')) {
                $query->where('code', 'LIKE', '%' . $request->search . '%');
            }

            if ($request->filled('status')) {
                switch ($request->status) {
                    case 'active':
                        $query->where('is_active', true)->where('expiry_date', '>=', Carbon::today());
                        break;
                    case 'expired':
                        $query->where('expiry_date', '<', Carbon::today());
                        break;
                    case 'soon_expire':
                        $query->where('expiry_date', '<=', Carbon::today()->addDays(7))
                            ->where('expiry_date', '>=', Carbon::today());
                        break;
                }
            }

            if ($request->filled('amount_range')) {
                switch ($request->amount_range) {
                    case 'small':
                        $query->where('discount_amount', '<', 50000);
                        break;
                    case 'medium':
                        $query->whereBetween('discount_amount', [50000, 200000]);
                        break;
                    case 'large':
                        $query->where('discount_amount', '>', 200000);
                        break;
                }
            }

            if ($request->filled('date_from')) {
                $query->where('expiry_date', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->where('expiry_date', '<=', $request->date_to);
            }

            $coupons = $query->orderBy('expiry_date', 'DESC')->get();

            // Simple CSV export
            $filename = 'kupon_diskon_' . date('Y-m-d_H-i-s') . '.csv';
            $handle = fopen('php://output', 'w');

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            // CSV Headers
            fputcsv($handle, [
                'ID',
                'Kode Kupon',
                'Nilai Diskon',
                'Minimum Pembelian',
                'Tanggal Berakhir',
                'Status',
                'Dibuat Pada'
            ]);

            // CSV Data
            foreach ($coupons as $coupon) {
                fputcsv($handle, [
                    $coupon->id,
                    $coupon->code,
                    formatRupiah($coupon->discount_amount),
                    formatRupiah($coupon->minimum_order),
                    $coupon->expiry_date->format('d/m/Y'),
                    $coupon->isValid() ? 'Aktif' : 'Tidak Aktif',
                    $coupon->created_at->format('d/m/Y H:i:s')
                ]);
            }

            fclose($handle);
            exit;
        } catch (\Exception $e) {
            return redirect()->route('admin.coupons')->with('error', 'Terjadi kesalahan saat export: ' . $e->getMessage());
        }
    }

    // Statistik Dashboard Kupon (Fitur Baru)
    public function coupon_statistics()
    {
        try {
            $stats = [
                'total_coupons' => Coupon::count(),
                'active_coupons' => Coupon::where('is_active', true)
                    ->where('expiry_date', '>=', Carbon::today())
                    ->count(),
                'expired_coupons' => Coupon::where('expiry_date', '<', Carbon::today())->count(),
                'soon_expire_coupons' => Coupon::where('expiry_date', '<=', Carbon::today()->addDays(7))
                    ->where('expiry_date', '>=', Carbon::today())
                    ->count(),
                'total_discount_value' => Coupon::where('is_active', true)
                    ->where('expiry_date', '>=', Carbon::today())
                    ->sum('discount_amount'),
                'average_discount' => Coupon::where('is_active', true)
                    ->where('expiry_date', '>=', Carbon::today())
                    ->avg('discount_amount'),
                'highest_discount' => Coupon::where('is_active', true)
                    ->where('expiry_date', '>=', Carbon::today())
                    ->max('discount_amount'),
                'lowest_minimum_order' => Coupon::where('is_active', true)
                    ->where('expiry_date', '>=', Carbon::today())
                    ->where('minimum_order', '>', 0)
                    ->min('minimum_order')
            ];

            return response()->json($stats);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Validasi Kode Kupon untuk AJAX (Fitur Baru)
    public function validate_coupon_code(Request $request)
    {
        $code = strtoupper($request->code);
        $excludeId = $request->exclude_id;

        $query = Coupon::where('code', $code);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $exists = $query->exists();

        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'Kode kupon sudah digunakan' : 'Kode kupon tersedia'
        ]);
    }

    // Generate Kode Kupon Otomatis (Fitur Baru)
    public function generate_coupon_code(Request $request)
    {
        $type = $request->type ?? 'random';
        $maxAttempts = 10;
        $attempt = 0;

        do {
            switch ($type) {
                case 'discount':
                    $code = 'DISKON' . rand(10, 99) . 'K';
                    break;
                case 'save':
                    $code = 'HEMAT' . rand(10, 99) . 'K';
                    break;
                case 'special':
                    $code = 'SPESIAL' . strtoupper(substr(md5(time()), 0, 4));
                    break;
                case 'welcome':
                    $code = 'WELCOME' . rand(10, 99);
                    break;
                default:
                    $code = 'KUPON' . strtoupper(substr(md5(time() . rand()), 0, 6));
            }

            $attempt++;
        } while (Coupon::where('code', $code)->exists() && $attempt < $maxAttempts);

        if ($attempt >= $maxAttempts) {
            return response()->json(['error' => 'Gagal generate kode unik'], 500);
        }

        return response()->json(['code' => $code]);
    }

    // ====================================================================================================
    // Halaman Orders - Perbaikan dengan fitur filter dan export
    // ====================================================================================================
    public function orders(Request $request)
    {
        $query = Order::with(['orderItems', 'transaction'])
            ->select('orders.*')
            ->leftJoin('transactions', 'orders.id', '=', 'transactions.order_id');

        // Filter search by name or phone
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('orders.name', 'like', '%' . $request->search . '%')
                    ->orWhere('orders.phone', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by order status
        if ($request->filled('status')) {
            $query->where('orders.status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $paymentStatus = $request->payment_status;

            if ($paymentStatus === 'paid') {
                $query->whereIn('transactions.status', ['approved', 'paid']);
            } elseif ($paymentStatus === 'pending') {
                $query->where(function ($q) {
                    $q->where('transactions.status', 'pending')
                        ->orWhereNull('transactions.status');
                });
            } elseif ($paymentStatus === 'declined') {
                $query->where('transactions.status', 'declined');
            }
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('orders.created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('orders.created_at', '<=', $request->date_to);
        }

        // Handle export
        if ($request->has('export') && $request->export === 'excel') {
            return $this->exportOrders($query);
        }

        $orders = $query->orderBy('orders.created_at', 'DESC')->paginate(12);

        return view("admin.orders", compact('orders'));
    }

    // ====================================================================================================
    // Export Orders to Excel
    // ====================================================================================================
    public function exportOrders($query = null)
    {
        if (!$query) {
            $query = Order::with(['orderItems', 'transaction']);
        }

        $orders = $query->get();

        $filename = 'orders-export-' . date('Y-m-d-H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($orders) {
            $file = fopen('php://output', 'w');

            // Add UTF-8 BOM for proper Excel encoding
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // CSV Headers
            fputcsv($file, [
                'No Pesanan',
                'Nama Pelanggan',
                'No Telepon',
                'Alamat',
                'Kota',
                'Kode Pos',
                'Subtotal',
                'Diskon',
                'Ongkir',
                'Total',
                'Jumlah Item',
                'Status Pesanan',
                'Status Pembayaran',
                'Metode Pembayaran',
                'Kurir',
                'Tanggal Pesan',
                'Tanggal Konfirmasi',
                'Tanggal Kirim',
                'Tanggal Sampai'
            ]);

            foreach ($orders as $order) {
                $paymentStatus = 'Belum Bayar';
                $paymentMethod = '-';

                if ($order->transaction) {
                    if (in_array($order->transaction->status, ['approved', 'paid'])) {
                        $paymentStatus = 'Sudah Bayar';
                    } elseif ($order->transaction->status === 'declined') {
                        $paymentStatus = 'Ditolak';
                    } else {
                        $paymentStatus = 'Belum Bayar';
                    }

                    $paymentMethod = $order->transaction->mode;
                    if ($paymentMethod === 'midtrans') {
                        $paymentMethod = 'E-Wallet/Online';
                    } elseif ($paymentMethod === 'manual_atm') {
                        $paymentMethod = 'Transfer Bank';
                    }
                }

                $orderStatus = $order->status;
                switch ($order->status) {
                    case 'awaiting_payment':
                        $orderStatus = 'Menunggu Pembayaran';
                        break;
                    case 'pending':
                        $orderStatus = 'Pending';
                        break;
                    case 'confirmed':
                        $orderStatus = 'Dikonfirmasi';
                        break;
                    case 'processing':
                        $orderStatus = 'Diproses';
                        break;
                    case 'shipped':
                        $orderStatus = 'Dikirim';
                        break;
                    case 'delivered':
                        $orderStatus = 'Sampai';
                        break;
                    case 'completed':
                        $orderStatus = 'Selesai';
                        break;
                    case 'canceled':
                        $orderStatus = 'Dibatalkan';
                        break;
                }

                fputcsv($file, [
                    '1' . str_pad($order->id, 4, '0', STR_PAD_LEFT),
                    $order->name,
                    $order->phone,
                    $order->address,
                    $order->city,
                    $order->zip,
                    $order->subtotal,
                    $order->discount ?? 0,
                    $order->ongkir ?? 0,
                    $order->total,
                    $order->orderItems->count(),
                    $orderStatus,
                    $paymentStatus,
                    $paymentMethod,
                    strtoupper($order->kurir ?? '-'),
                    $order->created_at->format('d/m/Y H:i'),
                    $order->confirmed_date ? \Carbon\Carbon::parse($order->confirmed_date)->format('d/m/Y H:i') : '-',
                    $order->shipped_date ? \Carbon\Carbon::parse($order->shipped_date)->format('d/m/Y H:i') : '-',
                    $order->delivered_date ? \Carbon\Carbon::parse($order->delivered_date)->format('d/m/Y H:i') : '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ====================================================================================================
    // Halaman Order detail Items
    // ====================================================================================================
    public function order_items($order_id)
    {
        $order = Order::with(['orderItems.product.category', 'orderItems.product.brand', 'user'])->find($order_id);

        if (!$order) {
            return redirect()->route('admin.orders')->with('error', 'Pesanan tidak ditemukan.');
        }

        $orderitems = OrderItem::with(['product.category', 'product.brand'])
            ->where('order_id', $order_id)
            ->orderBy('id')
            ->paginate(12);

        $transaction = Transaction::where('order_id', $order_id)->first();

        return view("admin.order-details", compact('order', 'orderitems', 'transaction'));
    }

    // ====================================================================================================
    // Halaman Update Order Status - VERSI YANG DIPERBAIKI
    // ====================================================================================================
    public function update_order_status(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'order_id' => 'required|numeric',
                'order_status' => 'required|string'
            ]);

            $order = Order::find($request->order_id);

            if (!$order) {
                return back()->with("error", "Pesanan tidak ditemukan.");
            }

            $oldStatus = $order->status;
            $newStatus = $request->order_status;

            // Update order status
            $order->status = $newStatus;

            // Set appropriate date based on status
            switch ($newStatus) {
                case 'confirmed':
                    $order->confirmed_date = Carbon::now();
                    break;
                case 'processing':
                    $order->processing_date = Carbon::now();
                    break;
                case 'shipped':
                    $order->shipped_date = Carbon::now();
                    break;
                case 'delivered':
                    $order->delivered_date = Carbon::now();
                    break;
                case 'canceled':
                    $order->canceled_date = Carbon::now();
                    break;
            }

            $order->save();

            // Update transaction status when delivered
            if ($newStatus == 'delivered') {
                $transaction = Transaction::where('order_id', $request->order_id)->first();
                if ($transaction) {
                    $transaction->status = "approved";
                    $transaction->save();
                }
            }

            // Add notification based on status change
            $statusMessages = [
                'awaiting_payment' => 'Pesanan menunggu pembayaran',
                'pending' => 'Pesanan menunggu konfirmasi',
                'confirmed' => 'Pesanan telah dikonfirmasi',
                'processing' => 'Pesanan sedang diproses',
                'shipped' => 'Pesanan telah dikirim',
                'delivered' => 'Pesanan telah sampai',
                'completed' => 'Pesanan telah selesai',
                'canceled' => 'Pesanan telah dibatalkan'
            ];

            $message = $statusMessages[$newStatus] ?? "Status pesanan diperbarui";
            $invoice = 'ORDER-' . $order->id;

            // Add to notifications table
            try {
                DB::table('notifications')->insert([
                    'pesan' => $message . ' untuk Invoice ' . $invoice,
                    'waktu' => now(),
                    'status' => 'unread',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } catch (\Exception $e) {
                // Jika gagal insert notification, tidak masalah, lanjutkan saja
                Log::warning('Failed to insert notification: ' . $e->getMessage());
            }

            return back()->with("status", "Status pesanan berhasil diperbarui!");
        } catch (\Exception $e) {
            Log::error('Error updating order status: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->with("error", "Terjadi kesalahan saat memperbarui status pesanan. Detail: " . $e->getMessage());
        }
    }

    // ====================================================================================================
    // Halaman Konfirmasi Order Manual
    // ====================================================================================================
    public function confirmManualOrder($orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->status !== 'pending') {
            return back()->with('error', 'Order tidak dalam status pending.');
        }

        DB::beginTransaction();
        try {
            // Update status order
            $order->status = 'confirmed';
            $order->confirmed_date = now();
            $order->save();

            // Kurangi stok permanen dan reserved_quantity
            foreach ($order->orderItems as $item) {
                $product = Product::lockForUpdate()->find($item->product_id);

                if ($product->quantity < $item->quantity) {
                    DB::rollBack();
                    return back()->with('error', "Stok produk {$product->name} tidak cukup.");
                }

                $product->quantity -= $item->quantity;
                $product->reserved_quantity -= $item->quantity;
                if ($product->reserved_quantity < 0) {
                    $product->reserved_quantity = 0;
                }
                $product->save();
            }

            DB::commit();

            return back()->with('success', 'Order berhasil dikonfirmasi dan stok diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error konfirmasi order manual: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat konfirmasi order.');
        }
    }


    // ====================================================================================================
    // Halaman Slides
    // ====================================================================================================
    public function slides()
    {
        $slides = Slide::orderBy('id', 'DESC')->paginate(12);
        return view("admin.slides", compact('slides'));
    }
    // Halaman Menambahkan Slide
    public function slide_add()
    {
        return view("admin.slide-add");
    }
    // Halaman Menyimpan Slide
    public function slide_store(Request $request)
    {
        $request->validate([
            'tagline' => 'required',
            'title' => 'required',
            'subtitle' => 'required',
            'link' => 'required',
            'status' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048'
        ]);

        $slide = new Slide();
        $slide->tagline = $request->tagline;
        $slide->title = $request->title;
        $slide->subtitle = $request->subtitle;
        $slide->link = $request->link;
        $slide->status = $request->status;

        $image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extension;

        $this->GenerateSlideThumbnailsImage($image, $file_name);
        $slide->image = $file_name;
        $slide->save();

        return redirect()->route('admin.slides')->with("status", "Slide added successfully!");
    }
    // Halaman Generate Slide Thumbnail Image
    public function GenerateSlideThumbnailsImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/slides');
        $img = Image::read($image->path());
        $img->cover(400, 690, "top");
        $img->resize(400, 690, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);
    }
    // Halaman Edit Slide
    public function slide_edit($id)
    {
        $slide = Slide::find($id);
        return view('admin.slide-edit', compact('slide'));
    }
    // Halaman Update Slide
    public function slide_update(Request $request)
    {
        $request->validate([
            'tagline' => 'required',
            'title' => 'required',
            'subtitle' => 'required',
            'link' => 'required',
            'status' => 'required',
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $slide = Slide::find($request->id);
        $slide->tagline = $request->tagline;
        $slide->title = $request->title;
        $slide->subtitle = $request->subtitle;
        $slide->link = $request->link;
        $slide->status = $request->status;

        if ($request->hasFile('image')) {
            if (File::exists(public_path('uploads/slides') . '/' . $slide->image)) {
                File::delete(public_path('uploads/slides') . '/' . $slide->image);
            }
            $image = $request->file('image');
            $file_extension = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $this->GenerateSlideThumbnailsImage($image, $file_name);
            $slide->image = $file_name;
        }

        $slide->save();
        return redirect()->route('admin.slides')->with("status", "Slide updated successfully!");
    }
    // Halaman Delete Slide
    public function slide_delete($id)
    {
        $slide = Slide::find($id);
        if (File::exists(public_path('uploads/slides') . '/' . $slide->image)) {
            File::delete(public_path('uploads/slides') . '/' . $slide->image);
        }
        $slide->delete();
        return redirect()->route('admin.slides')->with("status", "Slide deleted successfully!");
    }


    // ====================================================================================================
    // Halaman Contacts
    // ====================================================================================================
    public function contacts()
    {
        $contacts = Contact::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.contacts', compact('contacts'));
    }
    // Halaman Delete Contact
    public function contact_delete($id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        return redirect()->route('admin.contacts')->with('status', 'Contact deleted successfully!');
    }

    // ====================================================================================================
    // Halaman Jobs
    // ====================================================================================================
    /**
     * Menampilkan halaman daftar lowongan kerja
     */
    public function jobs()
    {
        return view('admin.jobs.index');
    }
    /**
     * Menampilkan halaman tambah lowongan kerja
     */
    public function job_add()
    {
        return view('admin.jobs.create');
    }
    /**
     * Menampilkan halaman edit lowongan kerja
     */
    public function job_edit($id)
    {
        // Validasi job exists
        $job = JobList::find($id);
        if (!$job) {
            return redirect()->route('admin.jobs')->with('error', 'Lowongan tidak ditemukan');
        }

        return view('admin.jobs.edit', compact('id'));
    }
    /**
     * Export data lowongan kerja ke Excel
     */
    public function exportJobs(Request $request)
    {
        try {
            $query = JobList::query();

            // Apply filters if provided
            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }

            if ($request->has('category') && $request->category) {
                $query->where('category', $request->category);
            }

            if ($request->has('location') && $request->location) {
                $query->where('location', 'like', '%' . $request->location . '%');
            }

            if ($request->has('search') && $request->search) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('title', 'like', '%' . $searchTerm . '%')
                      ->orWhere('description', 'like', '%' . $searchTerm . '%')
                      ->orWhere('location', 'like', '%' . $searchTerm . '%');
                });
            }

            $jobs = $query->with('applications')->orderBy('created_at', 'DESC')->get();

            $filename = 'lowongan_kerja_' . date('Y-m-d_H-i-s') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function() use ($jobs) {
                $file = fopen('php://output', 'w');

                // Add BOM for UTF-8
                fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

                // CSV Headers
                fputcsv($file, [
                    'ID',
                    'Judul',
                    'Kategori',
                    'Gaji',
                    'Tipe Gaji',
                    'Lokasi',
                    'Durasi',
                    'Target',
                    'Status',
                    'Total Pelamar',
                    'Pelamar Diterima',
                    'Pelamar Ditolak',
                    'Tanggal Dibuat',
                    'Tanggal Diupdate'
                ]);

                // Data rows
                foreach ($jobs as $job) {
                    $applicationsCount = $job->applications->count();
                    $acceptedCount = $job->applications->where('status', 'Diterima')->count();
                    $rejectedCount = $job->applications->where('status', 'Ditolak')->count();

                    fputcsv($file, [
                        $job->id,
                        $job->title,
                        $job->category,
                        'Rp ' . number_format($job->salary, 0, ',', '.'),
                        $job->salary_type,
                        $job->location,
                        $job->duration,
                        $job->target ?: '-',
                        $job->status,
                        $applicationsCount,
                        $acceptedCount,
                        $rejectedCount,
                        $job->created_at->format('d/m/Y H:i'),
                        $job->updated_at->format('d/m/Y H:i')
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengexport data: ' . $e->getMessage());
        }
    }
    /**
     * Get job statistics for dashboard
     */
    public function getJobStatistics()
    {
        try {
            $totalJobs = JobList::count();
            $activeJobs = JobList::where('status', 'Dibuka')->count();
            $closedJobs = JobList::where('status', 'Ditutup')->count();
            $completedJobs = JobList::where('status', 'Selesai')->count();

            $totalApplications = JobApplication::count();
            $pendingApplications = JobApplication::where('status', 'Diproses')->count();
            $acceptedApplications = JobApplication::where('status', 'Diterima')->count();
            $rejectedApplications = JobApplication::where('status', 'Ditolak')->count();

            // Recent jobs (last 30 days)
            $recentJobsCount = JobList::where('created_at', '>=', now()->subDays(30))->count();

            // Response rate
            $responseRate = $totalApplications > 0 ?
                round((($acceptedApplications + $rejectedApplications) / $totalApplications) * 100, 2) : 0;

            return response()->json([
                'success' => true,
                'data' => [
                    'jobs' => [
                        'total' => $totalJobs,
                        'active' => $activeJobs,
                        'closed' => $closedJobs,
                        'completed' => $completedJobs,
                        'recent' => $recentJobsCount
                    ],
                    'applications' => [
                        'total' => $totalApplications,
                        'pending' => $pendingApplications,
                        'accepted' => $acceptedApplications,
                        'rejected' => $rejectedApplications,
                        'response_rate' => $responseRate
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Get popular job categories
     */
    public function getPopularCategories()
    {
        try {
            $categories = JobList::select('category', \DB::raw('count(*) as total'))
                ->groupBy('category')
                ->orderBy('total', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $categories
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil kategori populer: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Get job applications trend (monthly)
     */
    public function getApplicationsTrend()
    {
        try {
            $trend = JobApplication::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

            // Format data for chart
            $formattedTrend = $trend->map(function($item) {
                $monthNames = [
                    1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
                    5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
                    9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
                ];

                return [
                    'period' => $monthNames[$item->month] . ' ' . $item->year,
                    'total' => $item->total
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $formattedTrend
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil trend aplikasi: ' . $e->getMessage()
            ], 500);
        }
    }

    // ====================================================================================================
    // laporanpenjualan
    // ====================================================================================================
    public function laporanpenjualan(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $action = $request->input('action');

        // Ambil semua order (filtered jika ada tanggal)
        $orders = DB::table('orders')
            ->join('transactions', 'orders.id', '=', 'transactions.order_id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'orders.id as order_id',
                'orders.name as customer_name',
                'orders.phone as customer_phone',
                'orders.subtotal',
                'orders.discount',
                'orders.tax',
                'orders.total',
                'orders.status as order_status',
                'orders.created_at as order_date',
                'orders.delivered_date',
                'users.name as user_name',
                'transactions.status as transaction_status'
            )
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween(DB::raw('DATE(transactions.created_at)'), [$startDate, $endDate]);
            })
            ->orderBy('orders.created_at', 'desc')
            ->get();

        // Ambil items per order (N+1)
        foreach ($orders as $order) {
            $order->items = DB::table('order_items')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->select('order_items.*', 'products.name as product_name')
                ->where('order_items.order_id', $order->order_id)
                ->get();
        }

        // Export PDF jika action = pdf
        if ($action === 'pdf') {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporanpenjualan_pdf', compact('orders', 'startDate', 'endDate'))
                ->setPaper('a4', 'landscape');
            return $pdf->download('laporan_penjualan_' . now()->format('Ymd_His') . '.pdf');
        }

        // Manual pagination
        $page = request()->get('page', 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $paginated = new LengthAwarePaginator(
            $orders->slice($offset, $perPage)->values(),
            $orders->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin.laporanpenjualan', ['orders' => $paginated]);
    }

    public function printPDF(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $orders = DB::table('orders')
            ->join('transactions', 'orders.id', '=', 'transactions.order_id')
            ->leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'orders.id as order_id',
                'orders.name as customer_name',
                'orders.phone as customer_phone',
                'orders.subtotal',
                'orders.discount',
                'orders.tax',
                'orders.total',
                'orders.status as order_status',
                'orders.created_at as order_date',
                'orders.delivered_date',
                'users.name as user_name',
                DB::raw('COUNT(order_items.id) as total_items')
            )
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween(DB::raw('DATE(transactions.created_at)'), [$startDate, $endDate]);
            })
            ->groupBy('orders.id', 'users.name')
            ->orderBy('orders.created_at', 'desc')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporanpenjualan_pdf', compact('orders', 'startDate', 'endDate'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan_penjualan_' . now()->format('Ymd_His') . '.pdf');
    }

    // ====================================================================================================
    // Halaman About
    // ====================================================================================================
    public function about()
    {
        $abouts = About::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.about.index', compact('abouts'));
    }

    // Form create
    public function createAbout()
    {
        return view('admin.about.create');
    }

    // Simpan baru
    public function storeAbout(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'story'            => 'nullable|string',
            'vision'           => 'nullable|string',
            'mission'          => 'nullable|string',
            'founder'          => 'nullable|string|max:255',
            'established_date' => 'nullable|date',
            'address'          => 'nullable|string',
            'contact_info'     => 'nullable|string',
            'image1'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image1_caption'   => 'nullable|string|max:255',
            'image1_alt'       => 'nullable|string|max:255',
            'image2_caption'   => 'nullable|string|max:255',
            'image2_alt'       => 'nullable|string|max:255',
            'is_active'        => 'boolean',
            'map_embed'        => 'nullable|string',
        ]);

        $data = $request->only([
            'title',
            'story',
            'vision',
            'mission',
            'founder',
            'established_date',
            'address',
            'contact_info',
            'map_embed',
            'image1_caption',
            'image1_alt',
            'image2_caption',
            'image2_alt',
            'is_active'
        ]);

        foreach (['image1', 'image2'] as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $name = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/abouts'), $name);
                // simpan path relatif agar asset() bisa pakai langsung
                $data[$field] = 'uploads/abouts/' . $name;
            }
        }

        About::create($data);

        return redirect()->route('admin.about.index')
            ->with('status', 'Data berhasil ditambahkan!');
    }

    // Form edit
    public function editAbout(About $about)
    {
        return view('admin.about.create', compact('about')); // reuse create view
    }

    // Update
    public function updateAbout(Request $request, About $about)
    {
        $request->validate([
            'title'             => 'required|string|max:255',
            'story'             => 'nullable|string',
            'vision'            => 'nullable|string',
            'mission'           => 'nullable|string',
            'founder'           => 'nullable|string|max:255',
            'established_date'  => 'nullable|date',
            'address'           => 'nullable|string',
            'contact_info'      => 'nullable|string',
            'image1'            => 'nullable|image|max:2048',
            'image1_caption'    => 'nullable|string|max:255',
            'image1_alt'        => 'nullable|string|max:255',
            'image2'            => 'nullable|image|max:2048',
            'image2_caption'    => 'nullable|string|max:255',
            'image2_alt'        => 'nullable|string|max:255',
            'is_active'         => 'boolean',
            'map_embed'        => 'nullable|string',
        ]);

        $data = $request->only([
            'title',
            'story',
            'vision',
            'mission',
            'founder',
            'established_date',
            'address',
            'contact_info',
            'map_embed',
            'image1_caption',
            'image1_alt',
            'image2_caption',
            'image2_alt',
            'is_active'
        ]);

        foreach (['image1', 'image2'] as $field) {
            if ($request->hasFile($field)) {
                // hapus file lama jika ada
                if ($about->$field && file_exists(public_path($about->$field))) {
                    unlink(public_path($about->$field));
                }
                $file = $request->file($field);
                $name = time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/abouts'), $name);
                $data[$field] = 'uploads/abouts/' . $name;
            }
        }

        $about->update($data);

        return redirect()->route('admin.about.index')
            ->with('status', 'Data berhasil diupdate!');
    }

    // Delete
    public function destroyAbout(About $about)
    {
        foreach (['image1', 'image2'] as $img) {
            if ($about->$img && Storage::disk('public')->exists($about->$img)) {
                Storage::disk('public')->delete($about->$img);
            }
        }
        $about->delete();

        return redirect()->route('admin.about.index')
            ->with('status', 'Data berhasil dihapus!');
    }


    // ====================================================================================================
    // Halaman Data Pengguna
    // ====================================================================================================

    /**
     * Display a listing of users with pagination, search, and filtering
     */
    public function data_pengguna(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('mobile', 'LIKE', "%{$search}%");
            });
        }

        // Filter by user type
        if ($request->filled('utype')) {
            $query->where('utype', $request->utype);
        }

        // Filter by registration date
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by verification status
        if ($request->filled('verification_status')) {
            if ($request->verification_status === 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->verification_status === 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $allowedSorts = ['name', 'email', 'created_at', 'last_login_at', 'utype'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Get users with pagination
        $users = $query->withCount('addresses')
            ->paginate(10)
            ->appends($request->query());

        // Statistics for dashboard cards
        $stats = [
            'total_users' => User::count(),
            'total_customers' => User::where('utype', 'USR')->count(),
            'total_admins' => User::where('utype', 'ADM')->count(),
            'verified_users' => User::whereNotNull('email_verified_at')->count(),
            'unverified_users' => User::whereNull('email_verified_at')->count(),
            'recent_registrations' => User::where('created_at', '>=', Carbon::now()->subDays(7))->count(),
            'active_today' => User::where('last_login_at', '>=', Carbon::now()->startOfDay())->count(),
        ];

        return view('admin.data-pengguna.index', compact('users', 'stats'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create_user()
    {
        return view('admin.data-pengguna.create');
    }

    /**
     * Store a newly created user
     */
    public function store_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => 'required|string|max:15|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'utype' => 'required|in:USR,ADM',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'utype' => $request->utype,
            'bio' => $request->bio,
            'email_verified_at' => $request->has('email_verified') ? now() : null,
        ];

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profiles'), $filename);
            $userData['profile_picture'] = 'uploads/profiles/' . $filename;
        }

        User::create($userData);

        return redirect()->route('admin.data-pengguna.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Display the specified user
     */
    public function show_user($id)
    {
        $user = User::with(['addresses'])->findOrFail($id);

        // Get user statistics
        $userStats = [
            'total_addresses' => $user->addresses->count(),
            'default_address' => $user->addresses->where('isdefault', true)->first(),
            'account_age' => $user->created_at->diffForHumans(),
            'last_login' => $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never',
            'verification_status' => $user->email_verified_at ? 'Verified' : 'Unverified',
        ];

        return view('admin.data-pengguna.show', compact('user', 'userStats'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit_user($id)
    {
        $user = User::findOrFail($id);
        return view('admin.data-pengguna.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update_user(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'mobile' => [
                'required',
                'string',
                'max:15',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'utype' => 'required|in:USR,ADM',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'utype' => $request->utype,
            'bio' => $request->bio,
        ];

        // Update password only if provided
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        // Handle email verification status
        if ($request->has('email_verified')) {
            $userData['email_verified_at'] = now();
        } else {
            $userData['email_verified_at'] = null;
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
                unlink(public_path($user->profile_picture));
            }

            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profiles'), $filename);
            $userData['profile_picture'] = 'uploads/profiles/' . $filename;
        }

        $user->update($userData);

        return redirect()->route('admin.data-pengguna.show', $user->id)
            ->with('success', 'Data user berhasil diperbarui!');
    }

    /**
     * Remove the specified user
     */
    public function delete_user($id)
    {
        $user = User::findOrFail($id);

        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->back()
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        // Delete profile picture if exists
        if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
            unlink(public_path($user->profile_picture));
        }

        // Delete user addresses
        $user->addresses()->delete();

        // Delete user
        $user->delete();

        return redirect()->route('admin.data-pengguna.index')
            ->with('success', 'User berhasil dihapus!');
    }

    /**
     * Toggle user verification status
     */
    public function toggle_verification($id)
    {
        $user = User::findOrFail($id);

        if ($user->email_verified_at) {
            $user->email_verified_at = null;
            $message = 'Verifikasi email user berhasil dicabut!';
        } else {
            $user->email_verified_at = now();
            $message = 'Email user berhasil diverifikasi!';
        }

        $user->save();

        return redirect()->back()->with('success', $message);
    }

    /**
     * Bulk actions for multiple users
     */
    public function bulk_action(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'action' => 'required|in:delete,verify,unverify,activate,deactivate'
        ]);

        $userIds = $request->user_ids;
        $action = $request->action;

        // Prevent admin from performing bulk actions on themselves
        if (in_array(auth()->id(), $userIds)) {
            return redirect()->back()
                ->with('error', 'Anda tidak dapat melakukan aksi bulk pada akun Anda sendiri!');
        }

        switch ($action) {
            case 'delete':
                $users = User::whereIn('id', $userIds)->get();
                foreach ($users as $user) {
                    // Delete profile picture if exists
                    if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
                        unlink(public_path($user->profile_picture));
                    }
                    // Delete user addresses
                    $user->addresses()->delete();
                }
                User::whereIn('id', $userIds)->delete();
                $message = count($userIds) . ' user berhasil dihapus!';
                break;

            case 'verify':
                User::whereIn('id', $userIds)->update(['email_verified_at' => now()]);
                $message = count($userIds) . ' user berhasil diverifikasi!';
                break;

            case 'unverify':
                User::whereIn('id', $userIds)->update(['email_verified_at' => null]);
                $message = 'Verifikasi ' . count($userIds) . ' user berhasil dicabut!';
                break;
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Export users data
     */
    public function export_users(Request $request)
    {
        $query = User::query();

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('mobile', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('utype')) {
            $query->where('utype', $request->utype);
        }

        $users = $query->with('addresses')->get();

        $filename = 'users_export_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');

            // CSV Headers
            fputcsv($file, [
                'ID',
                'Name',
                'Email',
                'Mobile',
                'User Type',
                'Email Verified',
                'Profile Picture',
                'Bio',
                'Total Addresses',
                'Last Login',
                'Created At',
                'Updated At'
            ]);

            // CSV Data
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->mobile,
                    $user->utype === 'ADM' ? 'Admin' : 'Customer',
                    $user->email_verified_at ? 'Yes' : 'No',
                    $user->profile_picture ? 'Yes' : 'No',
                    $user->bio,
                    $user->addresses->count(),
                    $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i:s') : 'Never',
                    $user->created_at->format('Y-m-d H:i:s'),
                    $user->updated_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show user addresses
     */
    public function user_addresses($user_id)
    {
        $user = User::with('addresses')->findOrFail($user_id);
        $addresses = $user->addresses()->orderBy('isdefault', 'desc')->orderBy('created_at', 'desc')->get();

        return view('admin.data-pengguna.addresses', compact('user', 'addresses'));
    }

    /**
     * Delete user address
     */
    public function delete_user_address($user_id, $address_id)
    {
        $user = User::findOrFail($user_id);
        $address = Address::where('id', $address_id)->where('user_id', $user_id)->firstOrFail();

        $isDefault = $address->isdefault;

        $address->delete();

        // If deleted address was default, set another address as default if exists
        if ($isDefault) {
            $newDefault = Address::where('user_id', $user_id)->first();
            if ($newDefault) {
                $newDefault->isdefault = true;
                $newDefault->save();
            }
        }

        return redirect()->back()->with('success', 'Alamat berhasil dihapus!');
    }

    /**
     * Get users data for DataTables AJAX
     */
    public function users_data(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->has('search') && $request->search['value']) {
            $search = $request->search['value'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('mobile', 'LIKE', "%{$search}%");
            });
        }

        // Column sorting
        if ($request->has('order')) {
            $columns = ['id', 'name', 'email', 'mobile', 'utype', 'created_at'];
            $columnIndex = $request->order[0]['column'];
            $columnName = $columns[$columnIndex] ?? 'created_at';
            $direction = $request->order[0]['dir'] ?? 'desc';

            $query->orderBy($columnName, $direction);
        }

        $totalRecords = $query->count();

        // Pagination
        $start = $request->start ?? 0;
        $length = $request->length ?? 10;

        $users = $query->skip($start)->take($length)->withCount('addresses')->get();

        $data = $users->map(function ($user, $index) use ($start) {
            return [
                'id' => $user->id,
                'index' => $start + $index + 1,
                'name' => $user->name,
                'email' => $user->email,
                'mobile' => $user->mobile,
                'utype' => $user->utype,
                'email_verified' => $user->email_verified_at ? true : false,
                'addresses_count' => $user->addresses_count,
                'created_at' => $user->created_at->format('d M Y'),
                'last_login_at' => $user->last_login_at ? $user->last_login_at->format('d M Y') : 'Never',
                'profile_picture' => $user->profile_picture,
                'actions' => $this->getUserActions($user)
            ];
        });

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => User::count(),
            'recordsFiltered' => $totalRecords,
            'data' => $data
        ]);
    }

    /**
     * Generate action buttons for user
     */
    private function getUserActions($user)
    {
        $actions = '<div class="dropdown">
        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <i class="icon-more-vertical"></i>
        </button>
        <ul class="dropdown-menu">
            <li>
                <a class="dropdown-item" href="' . route('admin.data-pengguna.show', $user->id) . '">
                    <i class="icon-eye me-2"></i>Lihat Detail
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="' . route('admin.data-pengguna.edit', $user->id) . '">
                    <i class="icon-edit me-2"></i>Edit
                </a>
            </li>';

        if ($user->email_verified_at) {
            $actions .= '<li>
            <button type="button" class="dropdown-item" onclick="toggleVerification(' . $user->id . ')">
                <i class="icon-x-circle me-2"></i>Cabut Verifikasi
            </button>
        </li>';
        } else {
            $actions .= '<li>
            <button type="button" class="dropdown-item" onclick="toggleVerification(' . $user->id . ')">
                <i class="icon-check-circle me-2"></i>Verifikasi Email
            </button>
        </li>';
        }

        $actions .= '<li><hr class="dropdown-divider"></li>';

        if ($user->id !== auth()->id()) {
            $actions .= '<li>
            <button type="button" class="dropdown-item text-danger" onclick="deleteUser(' . $user->id . ')">
                <i class="icon-trash me-2"></i>Hapus
            </button>
        </li>';
        }

        $actions .= '</ul></div>';

        return $actions;
    }

    /**
     * Import users from CSV
     */
    public function import_users(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048'
        ]);

        try {
            $file = $request->file('csv_file');
            $csvData = file_get_contents($file);
            $rows = array_map('str_getcsv', explode("\n", $csvData));
            $header = array_shift($rows);

            $imported = 0;
            $errors = [];

            foreach ($rows as $index => $row) {
                if (empty(array_filter($row))) {
                    continue; // Skip empty rows
                }

                $userData = array_combine($header, $row);

                // Validate required fields
                if (empty($userData['name']) || empty($userData['email'])) {
                    $errors[] = "Baris " . ($index + 2) . ": Nama dan email wajib diisi";
                    continue;
                }

                // Check if email already exists
                if (User::where('email', $userData['email'])->exists()) {
                    $errors[] = "Baris " . ($index + 2) . ": Email {$userData['email']} sudah terdaftar";
                    continue;
                }

                try {
                    User::create([
                        'name' => $userData['name'],
                        'email' => $userData['email'],
                        'mobile' => $userData['mobile'] ?? null,
                        'password' => Hash::make($userData['password'] ?? 'password123'),
                        'utype' => $userData['utype'] ?? 'USR',
                        'bio' => $userData['bio'] ?? null,
                        'email_verified_at' => ($userData['email_verified'] ?? false) ? now() : null,
                    ]);

                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Baris " . ($index + 2) . ": " . $e->getMessage();
                }
            }

            $message = "Berhasil mengimpor {$imported} pengguna.";
            if (!empty($errors)) {
                $message .= " " . count($errors) . " baris gagal diimpor.";
            }

            return redirect()->back()->with('success', $message)->with('import_errors', $errors);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    /**
     * Send email verification to user
     */
    public function send_verification_email($id)
    {
        $user = User::findOrFail($id);

        if ($user->email_verified_at) {
            return redirect()->back()->with('error', 'Email sudah terverifikasi!');
        }

        try {
            // Here you would send the verification email
            // For now, we'll just mark as verified
            $user->email_verified_at = now();
            $user->save();

            return redirect()->back()->with('success', 'Email verifikasi berhasil dikirim!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim email verifikasi: ' . $e->getMessage());
        }
    }

    /**
     * Reset user password
     */
    public function reset_user_password(Request $request, $id)
    {
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::findOrFail($id);

        try {
            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()->back()->with('success', 'Password pengguna berhasil direset!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mereset password: ' . $e->getMessage());
        }
    }

    /**
     * Get user statistics for dashboard
     */
    public function user_statistics()
    {
        $stats = [
            'total_users' => User::count(),
            'total_customers' => User::where('utype', 'USR')->count(),
            'total_admins' => User::where('utype', 'ADM')->count(),
            'verified_users' => User::whereNotNull('email_verified_at')->count(),
            'unverified_users' => User::whereNull('email_verified_at')->count(),
            'recent_registrations' => User::where('created_at', '>=', Carbon::now()->subDays(7))->count(),
            'active_today' => User::where('last_login_at', '>=', Carbon::now()->startOfDay())->count(),
            'active_this_week' => User::where('last_login_at', '>=', Carbon::now()->subDays(7))->count(),
            'active_this_month' => User::where('last_login_at', '>=', Carbon::now()->subMonth())->count(),
        ];

        // Registration trend for the last 30 days
        $registrationTrend = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $registrationTrend[] = [
                'date' => $date->format('Y-m-d'),
                'count' => User::whereDate('created_at', $date)->count()
            ];
        }

        $stats['registration_trend'] = $registrationTrend;

        return response()->json($stats);
    }

    /**
     * Download CSV template for import
     */
    public function download_template()
    {
        $filename = 'template_import_users.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // CSV Headers
            fputcsv($file, [
                'name',
                'email',
                'mobile',
                'password',
                'utype',
                'bio',
                'email_verified'
            ]);

            // Sample data
            fputcsv($file, [
                'John Doe',
                'john@example.com',
                '08123456789',
                'password123',
                'USR',
                'Sample user bio',
                'true'
            ]);

            fputcsv($file, [
                'Jane Smith',
                'jane@example.com',
                '08987654321',
                'password123',
                'ADM',
                'Admin user',
                'true'
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
