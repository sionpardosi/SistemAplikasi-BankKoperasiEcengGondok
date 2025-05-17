<?php

namespace App\Http\Controllers;

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
        $orders = Order::orderBy('created_at', 'DESC')->get()->take(10);
        $dashboardDatas = DB::select("
            SELECT
                sum(total) AS TotalAmount,
                sum(if(status='ordered', total, 0)) AS TotalOrderedAmount,
                sum(if(status='delivered', total, 0)) AS TotalDeliveredAmount,
                sum(if(status='canceled', total, 0)) AS TotalCanceledAmount,
                Count(*) AS Total,
                sum(if(status='ordered', 1, 0)) AS TotalOrdered,
                sum(if(status='delivered', 1, 0)) AS TotalDelivered,
                sum(if(status='canceled', 1, 0)) AS TotalCanceled
            FROM Orders
        ");

        $monthlyDatas = DB::select("
        SELECT
            M.id AS MonthNo,
            M.name AS MonthName,
            IFNULL(D.TotalAmount, 0) AS TotalAmount,
            IFNULL(D.TotalOrderedAmount, 0) AS TotalOrderedAmount,
            IFNULL(D.TotalDeliveredAmount, 0) AS TotalDeliveredAmount,
            IFNULL(D.TotalCanceledAmount, 0) AS TotalCanceledAmount
        FROM month_names M
        LEFT JOIN (
            SELECT
                DATE_FORMAT(created_at, '%b') AS MonthName,
                MONTH(created_at) AS MonthNo,
                SUM(total) AS TotalAmount,
                SUM(if(status='ordered', total, 0)) AS TotalOrderedAmount,
                SUM(if(status='delivered', total, 0)) AS TotalDeliveredAmount,
                SUM(if(status='canceled', total, 0)) AS TotalCanceledAmount
            FROM Orders
            WHERE YEAR(created_at) = YEAR(NOW())
            GROUP BY YEAR(created_at), MONTH(created_at), DATE_FORMAT(created_at, '%b')
        ORDER BY MONTH(created_at)) D ON D.MonthNo = M.id");

        $AmountM = implode(',', collect($monthlyDatas)->pluck('TotalAmount')->toArray());
        $OrderedAmountM = implode(',', collect($monthlyDatas)->pluck('TotalOrderedAmount')->toArray());
        $DeliveredAmountM = implode(',', collect($monthlyDatas)->pluck('TotalDeliveredAmount')->toArray());
        $CanceledAmountM = implode(',', collect($monthlyDatas)->pluck('TotalCanceledAmount')->toArray());

        $TotalAmount = collect($monthlyDatas)->sum('TotalAmount');
        $TotalOrderedAmount = collect($monthlyDatas)->sum('TotalOrderedAmount');
        $TotalDeliveredAmount = collect($monthlyDatas)->sum('TotalDeliveredAmount');
        $TotalCanceledAmount = collect($monthlyDatas)->sum('TotalCanceledAmount');


        // dashboard supplier
        $recentRequests = SupplierRequest::latest()->take(10)->get();

        // Buat array 12 bulan (biar grafik tetap full Januari-Desember)
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $dataChart[$i] ?? 0;
        }

        return view('admin.index', compact('orders', 'dashboardDatas', 'AmountM', 'OrderedAmountM', 'DeliveredAmountM', 'CanceledAmountM', 'TotalAmount', 'TotalOrderedAmount', 'TotalDeliveredAmount', 'TotalCanceledAmount', 'recentRequests', 'chartData'));
    }

    public function readall()
    {
        DB::table('notifications')->update([
            'status' => 'read'
        ]);

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
    // ====================================================================================================
    public function products()
    {
        $products = Product::OrderBy('created_at', 'DESC')->paginate(10);
        return view("admin.products", compact('products'));
    }
    // Halaman Menambahkan Produk
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
        // Validasi dasar tetap sama
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
            'category_id' => 'required',
            'brand_id' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required',
            'sale_price' => 'required',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => $request->has('has_sizes') ? 'nullable' : 'required', // Jika ukuran diaktifkan, quantity boleh kosong
            'image' => [
                'required',
                'file',
                'mimetypes:image/*',
                'max:2048',
            ],
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

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;

        // Hapus format rupiah
        $regular_price = str_replace(['Rp ', '.'], '', $request->regular_price);
        $sale_price = str_replace(['Rp ', '.'], '', $request->sale_price);

        $product->regular_price = (float)$regular_price;
        $product->sale_price = (float)$sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;

        // Set quantity hanya jika produk tidak memiliki ukuran
        if (!$request->has('has_sizes')) {
            $product->quantity = $request->quantity;
        } else {
            // Jika produk memiliki ukuran, quantity diambil dari total stok ukuran
            $totalStock = 0;

            // Hitung stok dari ukuran yang ada
            if ($request->has('sizes') && is_array($request->sizes)) {
                foreach ($request->sizes as $sizeId) {
                    $totalStock += (int)($request->stocks[$sizeId] ?? 0);
                }
            }

            // Hitung stok dari ukuran baru
            if ($request->has('new_sizes') && is_array($request->new_sizes)) {
                foreach ($request->new_sizes as $index => $newSize) {
                    if (!empty($newSize) && isset($request->new_stocks[$index])) {
                        $totalStock += (int)$request->new_stocks[$index];
                    }
                }
            }

            $product->quantity = $totalStock;
        }

        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        $current_timestamp = Carbon::now()->timestamp;

        // Proses upload gambar produk (tetap sama)
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

        // Proses gambar galeri (tetap sama)
        $gallery_arr = array();
        $gallery_images = "";
        $counter = 1;

        if ($request->hasFile('images')) {
            $allowedfileExtension = ['jpg', 'png', 'jpeg'];
            $files = $request->file('images');
            foreach ($files as $file) {
                $gextension = $file->getClientOriginalExtension();
                $check = in_array($gextension, $allowedfileExtension);
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

        // Simpan produk terlebih dahulu
        $product->save();

        // Proses ukuran produk hanya jika fitur ukuran diaktifkan
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

            // Sync dengan tabel pivot
            $product->sizes()->sync($syncData);
        }

        return redirect()->route('admin.products')->with('status', 'Berhasil Menyimpan Produk!');
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
            'sale_price' => 'required',
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
            // Jika produk memiliki ukuran, quantity diambil dari total stok ukuran
            $totalStock = 0;

            // Hitung stok dari ukuran yang ada
            if ($request->has('sizes') && is_array($request->sizes)) {
                foreach ($request->sizes as $sizeId) {
                    $totalStock += (int)($request->stocks[$sizeId] ?? 0);
                }
            }

            // Hitung stok dari ukuran baru
            if ($request->has('new_sizes') && is_array($request->new_sizes)) {
                foreach ($request->new_sizes as $index => $newSize) {
                    if (!empty($newSize) && isset($request->new_stocks[$index])) {
                        $totalStock += (int)$request->new_stocks[$index];
                    }
                }
            }

            $product->quantity = $totalStock;
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
        // Bersihkan nilai input agar hanya berupa angka
        $request->merge([
            'value' => preg_replace('/[^0-9.]/', '', $request->value),
            'cart_value' => preg_replace('/[^0-9.]/', '', $request->cart_value),
        ]);

        $request->validate([
            'code' => 'required',
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required|numeric',
            'expiry_date' => 'required|date'
        ]);

        $coupon = new Coupon();
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = $request->expiry_date;
        $coupon->save();
        return redirect()->route("admin.coupons")->with('status', 'Record has been added successfully !');
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
        $request->validate([
            'code' => 'required',
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required|numeric',
            'expiry_date' => 'required|date'
        ]);

        $coupon = Coupon::find($request->id);
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = str_replace(['Rp ', '.'], '', $request->value);
        $coupon->cart_value = str_replace(['Rp ', '.'], '', $request->cart_value);
        $coupon->expiry_date = $request->expiry_date;
        $coupon->save();
        return redirect()->route('admin.coupons')->with('status', 'Record has been updated successfully !');
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
}
