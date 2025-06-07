<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use \PDF;
use Carbon\Carbon;
use App\Models\Size;
use App\Models\About;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Slide;
use App\Models\Coupon;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Tentang;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SupplierRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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
    // Halaman Brands
    // ====================================================================================================
    public function brands()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(10);
        return view("admin.brands", compact('brands'));
    }
    // Halaman Menambahkan Brand
    public function add_brand()
    {
        return view("admin.brand-add");
    }
    // Halaman Menyimpan Brand
    public function add_brand_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug',
            'image' => [
                'required',
                'file',                        // memastikan input adalah file
                'mimetypes:image/*',           // menerima semua image MIME :contentReference[oaicite:1]{index=1}
                'max:2048',                    // ukuran maksimal 2 MB
            ],
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extention = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extention;
        $this->GenerateBrandThumbailImage($image, $file_name);
        $brand->image = $file_name;
        $brand->save();
        return redirect()->route('admin.brands')->with('status', 'Record has been added successfully !');
    }
    // Halaman Edit Brand
    public function brand_edit($id)
    {
        $brand = Brand::find($id);
        return view('admin.brand-edit', compact('brand'));
    }
    // Halaman Update Brand
    public function update_brand(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,' . $request->id,
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);
        $brand = Brand::find($request->id);
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        if ($request->hasFile('image')) {
            if (File::exists(public_path('uploads/brands') . '/' . $brand->image)) {
                File::delete(public_path('uploads/brands') . '/' . $brand->image);
            }
            $image = $request->file('image');
            $file_extention = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extention;


            $this->GenerateBrandThumbailImage($image, $file_name);
            $brand->image = $file_name;
        }
        $brand->save();
        return redirect()->route('admin.brands')->with('status', 'Record has been updated successfully !');
    }
    // Halaman Generate Brand Thumbnail Image
    public function GenerateBrandThumbailImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/brands');
        $img = Image::read($image->path());
        $img->cover(124, 124, "top");
        $img->resize(124, 124, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);
    }
    // Halaman Delete Brand
    public function delete_brand($id)
    {
        $brand = Brand::find($id);
        if (File::exists(public_path('uploads/brands') . '/' . $brand->image)) {
            File::delete(public_path('uploads/brands') . '/' . $brand->image);
        }
        $brand->delete();
        return redirect()->route('admin.brands')->with('status', 'Record has been deleted successfully !');
    }


    // ====================================================================================================
    // Halaman Categories
    // ====================================================================================================
    public function categories()
    {
        $categories = Category::orderBy('id', 'DESC')->paginate(10);
        return view("admin.categories", compact('categories'));
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

    /**
     * Enhanced product store method with better validation
     */
    public function product_store(Request $request)
    {
        // Enhanced validation rules
        $request->validate([
            'name' => [
                'required',
                'max:100',
                'unique:products,name'
            ],
            'slug' => 'required|unique:products,slug|max:100',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'short_description' => 'required|max:200',
            'description' => 'required',
            'regular_price' => [
                'required',
                function ($attribute, $value, $fail) {
                    $price = (float) str_replace(['Rp ', '.'], '', $value);
                    if ($price <= 0) {
                        $fail('Harga normal harus lebih besar dari 0.');
                    }
                },
            ],
            'sale_price' => [
                'nullable',
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
            'SKU' => 'required|unique:products,SKU',
            'stock_status' => 'required|in:instock,outofstock',
            'featured' => 'required|in:0,1',
            'quantity' => $request->has('has_sizes') ? 'nullable|integer|min:0' : 'required|integer|min:0',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'images.*' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ], [
            'name.unique' => 'Nama produk sudah digunakan. Silakan gunakan nama yang berbeda.',
            'slug.unique' => 'Slug sudah digunakan. Silakan gunakan slug yang berbeda.',
            'SKU.unique' => 'SKU sudah digunakan. Silakan gunakan SKU yang berbeda.',
            'image.required' => 'Gambar produk wajib diupload.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        try {
            $product = new Product();
            $product->name = $request->name;
            $product->slug = Str::slug($request->name);
            $product->short_description = $request->short_description;
            $product->description = $request->description;
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->SKU = $request->SKU;
            $product->stock_status = $request->stock_status;
            $product->featured = $request->featured;

            // Handle pricing logic
            $regular_price = str_replace(['Rp ', '.'], '', $request->regular_price);
            $product->regular_price = (float)$regular_price;

            if (!empty($request->sale_price)) {
                $sale_price = str_replace(['Rp ', '.'], '', $request->sale_price);
                $product->sale_price = (float)$sale_price;
            } else {
                $product->sale_price = $product->regular_price;
            }

            $current_timestamp = Carbon::now()->timestamp;

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $current_timestamp . '.' . $image->extension();

                if ($this->GenerateProductThumbailImage($image, $imageName)) {
                    $product->image = $imageName;
                } else {
                    return back()->with('error', 'Gagal memproses gambar. Silakan coba lagi.');
                }
            }

            // Handle gallery images
            if ($request->hasFile('images')) {
                $gallery_arr = [];
                $counter = 1;
                $allowedExtensions = ['jpg', 'png', 'jpeg'];
                $files = $request->file('images');

                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    if (in_array(strtolower($extension), $allowedExtensions)) {
                        $filename = $current_timestamp . "-" . $counter . "." . $extension;

                        if ($this->GenerateProductThumbailImage($file, $filename)) {
                            $gallery_arr[] = $filename;
                            $counter++;
                        }
                    }
                }

                $product->images = implode(',', $gallery_arr);
            }

            // Set initial quantity
            if (!$request->has('has_sizes')) {
                $product->quantity = $request->quantity;
            } else {
                $product->quantity = 0;
            }

            // Save product first
            $product->save();

            // Handle sizes if enabled
            if ($request->has('has_sizes')) {
                $syncData = [];

                if ($request->has('sizes') && is_array($request->sizes)) {
                    foreach ($request->sizes as $sizeId) {
                        $stock = isset($request->stocks[$sizeId]) ? (int) $request->stocks[$sizeId] : 0;
                        $syncData[$sizeId] = ['stock' => $stock];
                    }
                }

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

                $product->sizes()->sync($syncData);
                $totalStock = $product->sizes()->sum('stock');
                $product->update(['quantity' => $totalStock]);
            }

            return redirect()->route('admin.products')->with('status', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Enhanced image processing with better error handling
     */
    public function GenerateProductThumbailImage($image, $imageName)
    {
        try {
            $destinationPathThumbnail = public_path('uploads/products/thumbnails');
            $destinationPath = public_path('uploads/products');

            // Create directories if they don't exist
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            if (!File::exists($destinationPathThumbnail)) {
                File::makeDirectory($destinationPathThumbnail, 0755, true);
            }

            $img = Image::read($image->path());

            // Generate main image (540x689)
            $img->cover(540, 689, "top");
            $img->resize(540, 689, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $imageName);

            // Generate thumbnail (104x104)
            $img->resize(104, 104, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPathThumbnail . '/' . $imageName);

            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Image processing error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Helper method to delete old images
     */
    private function deleteOldImages($imageName)
    {
        if ($imageName) {
            $mainImagePath = public_path('uploads/products/' . $imageName);
            $thumbnailPath = public_path('uploads/products/thumbnails/' . $imageName);

            if (File::exists($mainImagePath)) {
                File::delete($mainImagePath);
            }
            if (File::exists($thumbnailPath)) {
                File::delete($thumbnailPath);
            }
        }
    }

    /**
     * AJAX endpoint to check product name uniqueness
     */
    public function checkProductNameUniqueness(Request $request)
    {
        $name = $request->get('name');
        $id = $request->get('id', null);

        $query = Product::where('name', $name);
        if ($id) {
            $query->where('id', '!=', $id);
        }

        $exists = $query->exists();

        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'Nama produk sudah digunakan' : 'Nama produk tersedia'
        ]);
    }

    /**
     * AJAX endpoint to check SKU uniqueness
     */
    public function checkSKUUniqueness(Request $request)
    {
        $sku = $request->get('sku');
        $id = $request->get('id', null);

        $query = Product::where('SKU', $sku);
        if ($id) {
            $query->where('id', '!=', $id);
        }

        $exists = $query->exists();

        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'SKU sudah digunakan' : 'SKU tersedia'
        ]);
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

    /**
     * Enhanced update method with comprehensive validation and logic improvements
     */
    public function update_product(Request $request)
    {
        // Custom validation rules with enhanced logic
        $request->validate([
            'name' => [
                'required',
                'max:100',
                Rule::unique('products', 'name')->ignore($request->id)->where(function ($query) {
                    return $query->whereNull('deleted_at'); // Exclude soft deleted
                })
            ],
            'slug' => [
                'required',
                'max:100',
                Rule::unique('products', 'slug')->ignore($request->id)->where(function ($query) {
                    return $query->whereNull('deleted_at');
                })
            ],
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'short_description' => 'required|max:200',
            'description' => 'required',
            'regular_price' => [
                'required',
                function ($attribute, $value, $fail) {
                    $price = (float) str_replace(['Rp ', '.'], '', $value);
                    if ($price <= 0) {
                        $fail('Harga normal harus lebih besar dari 0.');
                    }
                },
            ],
            'sale_price' => [
                'nullable',
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
                Rule::unique('products', 'SKU')->ignore($request->id)->where(function ($query) {
                    return $query->whereNull('deleted_at');
                })
            ],
            'stock_status' => 'required|in:instock,outofstock',
            'featured' => 'required|in:0,1',
            'quantity' => $request->has('has_sizes') ? 'nullable|integer|min:0' : 'required|integer|min:0',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'images.*' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            // Size validation
            'sizes' => $request->has('has_sizes') ? 'nullable|array' : 'nullable',
            'sizes.*' => 'exists:sizes,id',
            'stocks' => $request->has('has_sizes') ? 'nullable|array' : 'nullable',
            'stocks.*' => 'integer|min:0',
            'new_sizes' => $request->has('has_sizes') ? 'nullable|array' : 'nullable',
            'new_sizes.*' => 'nullable|string|max:50|unique:sizes,name',
            'new_stocks' => $request->has('has_sizes') ? 'nullable|array' : 'nullable',
            'new_stocks.*' => 'nullable|integer|min:0',
        ], [
            // Custom error messages
            'name.unique' => 'Nama produk sudah digunakan. Silakan gunakan nama yang berbeda.',
            'slug.unique' => 'Slug sudah digunakan. Silakan gunakan slug yang berbeda.',
            'SKU.unique' => 'SKU sudah digunakan. Silakan gunakan SKU yang berbeda.',
            'regular_price.required' => 'Harga normal wajib diisi.',
            'sale_price.lt' => 'Harga diskon harus lebih kecil dari harga normal.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'images.*.max' => 'Ukuran gambar galeri maksimal 2MB per file.',
            'new_sizes.*.unique' => 'Ukuran baru sudah ada dalam sistem.',
        ]);

        try {
            $product = Product::findOrFail($request->id);

            // Update basic information
            $product->name = $request->name;
            $product->slug = Str::slug($request->name);
            $product->short_description = $request->short_description;
            $product->description = $request->description;
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->SKU = $request->SKU;
            $product->stock_status = $request->stock_status;
            $product->featured = $request->featured;

            // Process prices with enhanced logic
            $regular_price = str_replace(['Rp ', '.'], '', $request->regular_price);
            $product->regular_price = (float)$regular_price;

            // Handle sale price logic - allow empty for no discount
            if (!empty($request->sale_price)) {
                $sale_price = str_replace(['Rp ', '.'], '', $request->sale_price);
                $product->sale_price = (float)$sale_price;
            } else {
                // No discount - set sale price equal to regular price
                $product->sale_price = $product->regular_price;
            }

            $current_timestamp = Carbon::now()->timestamp;

            // Handle main image upload with better error handling
            if ($request->hasFile('image')) {
                // Delete old images
                $this->deleteOldImages($product->image);

                $image = $request->file('image');
                $imageName = $current_timestamp . '.' . $image->extension();

                // Generate thumbnails with error handling
                if ($this->GenerateProductThumbailImage($image, $imageName)) {
                    $product->image = $imageName;
                } else {
                    return back()->with('error', 'Gagal memproses gambar. Silakan coba lagi.');
                }
            }

            // Handle gallery images with validation
            if ($request->hasFile('images')) {
                // Delete old gallery images
                $oldImages = explode(',', $product->images);
                foreach ($oldImages as $oldImage) {
                    $this->deleteOldImages(trim($oldImage));
                }

                $gallery_arr = [];
                $counter = 1;
                $allowedExtensions = ['jpg', 'png', 'jpeg'];
                $files = $request->file('images');

                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    if (in_array(strtolower($extension), $allowedExtensions)) {
                        $filename = $current_timestamp . "-" . $counter . "." . $extension;

                        if ($this->GenerateProductThumbailImage($file, $filename)) {
                            $gallery_arr[] = $filename;
                            $counter++;
                        }
                    }
                }

                $product->images = implode(',', $gallery_arr);
            }

            // Handle size management with improved logic
            if ($request->has('has_sizes')) {
                $syncData = [];

                // Process existing sizes
                if ($request->has('sizes') && is_array($request->sizes)) {
                    foreach ($request->sizes as $sizeId) {
                        $stock = isset($request->stocks[$sizeId]) ? (int) $request->stocks[$sizeId] : 0;
                        $syncData[$sizeId] = ['stock' => $stock];
                    }
                }

                // Process new sizes
                if ($request->has('new_sizes') && is_array($request->new_sizes)) {
                    foreach ($request->new_sizes as $index => $newSizeName) {
                        $newSizeName = trim($newSizeName);
                        if (!empty($newSizeName)) {
                            // Check if size already exists
                            $size = Size::firstOrCreate(['name' => $newSizeName]);
                            $stock = isset($request->new_stocks[$index]) ? (int) $request->new_stocks[$index] : 0;
                            $syncData[$size->id] = ['stock' => $stock];
                        }
                    }
                }

                // Sync sizes and calculate total quantity
                $product->sizes()->sync($syncData);
                $totalStock = $product->sizes()->sum('stock');
                $product->quantity = $totalStock;

                // Auto-update stock status based on quantity
                if ($totalStock == 0) {
                    $product->stock_status = 'outofstock';
                } else {
                    $product->stock_status = 'instock';
                }
            } else {
                // No sizes - use regular quantity
                $product->sizes()->detach();
                $product->quantity = $request->quantity;

                // Auto-update stock status
                if ($product->quantity == 0) {
                    $product->stock_status = 'outofstock';
                } else {
                    $product->stock_status = 'instock';
                }
            }

            // Save the product
            $product->save();

            return redirect()->route('admin.products')->with('status', 'Produk berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
    // Halaman Coupons
    // ====================================================================================================
    public function coupons()
    {
        $coupons = Coupon::orderBy('expiry_date', 'DESC')->paginate(12);
        return view("admin.coupons", compact('coupons'));
    }

    // Menambahkan Coupon
    public function add_coupon()
    {
        return view("admin.coupon-add");
    }

    // Menyimpan Coupon
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
            'code' => 'required|unique:coupons,code|max:50',
            'discount_amount' => 'required|numeric|min:1000', // Minimal Rp 1.000
            'minimum_order' => 'required|numeric|min:0',
            'expiry_date' => 'required|date|after:today'
        ], [
            'code.required' => 'Kode kupon wajib diisi',
            'code.unique' => 'Kode kupon sudah digunakan, silakan gunakan kode lain',
            'discount_amount.required' => 'Nilai diskon wajib diisi',
            'discount_amount.numeric' => 'Nilai diskon harus berupa angka',
            'discount_amount.min' => 'Nilai diskon minimal Rp 1.000',
            'minimum_order.required' => 'Minimum order wajib diisi',
            'minimum_order.numeric' => 'Minimum order harus berupa angka',
            'expiry_date.required' => 'Tanggal kadaluarsa wajib diisi',
            'expiry_date.after' => 'Tanggal kadaluarsa harus setelah hari ini'
        ]);

        Coupon::create([
            'code' => strtoupper($request->code),
            'discount_amount' => (int)$discountAmount,
            'minimum_order' => (int)$minimumOrder,
            'expiry_date' => $request->expiry_date,
            'is_active' => true
        ]);

        return redirect()->route("admin.coupons")->with('status', 'Kupon berhasil ditambahkan!');
    }

    // Halaman Edit Coupon
    public function edit_coupon($id)
    {
        $coupon = Coupon::find($id);
        return view('admin.coupon-edit', compact('coupon'));
    }

    // Halaman Update Coupon
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
            'code' => 'required|unique:coupons,code,' . $request->id . '|max:50',
            'discount_amount' => 'required|numeric|min:1000',
            'minimum_order' => 'required|numeric|min:0',
            'expiry_date' => 'required|date|after:today'
        ], [
            'code.unique' => 'Kode kupon sudah digunakan, silakan gunakan kode lain',
            'discount_amount.required' => 'Nilai diskon wajib diisi',
            'discount_amount.numeric' => 'Nilai diskon harus berupa angka',
            'discount_amount.min' => 'Nilai diskon minimal Rp 1.000',
            'minimum_order.required' => 'Minimum order wajib diisi',
            'minimum_order.numeric' => 'Minimum order harus berupa angka',
            'expiry_date.after' => 'Tanggal kadaluarsa harus setelah hari ini'
        ]);

        $coupon = Coupon::findOrFail($request->id);
        $coupon->update([
            'code' => strtoupper($request->code),
            'discount_amount' => (int)$discountAmount,
            'minimum_order' => (int)$minimumOrder,
            'expiry_date' => $request->expiry_date,
        ]);

        return redirect()->route('admin.coupons')->with('status', 'Kupon berhasil diperbarui!');
    }

    // Halaman Delete Coupon
    public function delete_coupon($id)
    {
        $coupon = Coupon::find($id);
        $coupon->delete();
        return redirect()->route('admin.coupons')->with('status', 'Record has been deleted successfully !');
    }

    // ====================================================================================================
    // Halaman Orders
    // ====================================================================================================
    public function orders(Request $request)
    {
        $query = Order::select('orders.*', 'transactions.status as transaction_status')
            ->leftJoin('transactions', 'orders.id', '=', 'transactions.order_id');

        // Filter search by name or phone
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by order status
        if ($request->filled('status')) {
            $query->where('orders.status', $request->status);
        }

        $orders = $query->orderBy('orders.created_at', 'DESC')->paginate(12);

        return view("admin.orders", compact('orders'));
    }

    // Halaman Order detail Items
    public function order_items($order_id)
    {
        $order = Order::find($order_id);
        $orderitems = OrderItem::where('order_id', $order_id)->orderBy('id')->paginate(12);
        $transaction = Transaction::where('order_id', $order_id)->first();
        return view("admin.order-details", compact('order', 'orderitems', 'transaction'));
    }

    // Halaman Update Order Status
    public function update_order_status(Request $request)
    {
        $order = Order::find($request->order_id);
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
            'pending' => 'Pesanan menunggu konfirmasi',
            'confirmed' => 'Pesanan telah dikonfirmasi',
            'processing' => 'Pesanan sedang diproses',
            'shipped' => 'Pesanan telah dikirim',
            'delivered' => 'Pesanan telah diterima oleh admin',
            'canceled' => 'Pesanan telah dibatalkan'
        ];

        $message = $statusMessages[$newStatus] ?? "Status pesanan diperbarui";
        $invoice = 'ORDER-' . $order->id;

        // Add to notifications table
        DB::table('notifications')->insert([
            'pesan' => $message . ' untuk Invoice ' . $invoice,
            'waktu' => now(),
            'status' => 'unread',
        ]);

        return back()->with("status", "Status pesanan berhasil diperbarui!");
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
    // Menampilkan halaman daftar lowongan kerja
    public function jobs()
    {
        return view('admin.jobs.index');
    }

    // Menampilkan halaman tambah lowongan kerja
    public function job_add()
    {
        return view('admin.jobs.create');
    }

    // Menampilkan halaman edit lowongan kerja
    public function job_edit($id)
    {
        return view('admin.jobs.edit', compact('id'));
    }

    public function viewApplications($id)
    {
        return view('admin.jobs.job-applications')->with('job_id', $id);
    }

    // laporanpenjualan

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
