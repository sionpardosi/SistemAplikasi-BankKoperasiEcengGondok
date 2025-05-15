<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Slide;
use App\Models\Coupon;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;

class AdminController extends BaseController
{
    // API Dashboard Admin
    public function index()
    {
        // ====================================================================================================
        // API Index Admin
        // ====================================================================================================
        // Mengambil 10 order terbaru
        $orders = Order::orderBy('created_at', 'DESC')->take(10)->get();

        // Mengambil data dashboard (total jumlah order dan statusnya)
        $dashboardDatas = DB::select("
            SELECT
                SUM(total) AS TotalAmount,
                SUM(IF(status='ordered', total, 0)) AS TotalOrderedAmount,
                SUM(IF(status='delivered', total, 0)) AS TotalDeliveredAmount,
                SUM(IF(status='canceled', total, 0)) AS TotalCanceledAmount,
                COUNT(*) AS Total,
                SUM(IF(status='ordered', 1, 0)) AS TotalOrdered,
                SUM(IF(status='delivered', 1, 0)) AS TotalDelivered,
                SUM(IF(status='canceled', 1, 0)) AS TotalCanceled
            FROM Orders
        ");

        // Mengambil data penjualan bulanan berdasarkan tahun berjalan
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
                    SUM(IF(status='ordered', total, 0)) AS TotalOrderedAmount,
                    SUM(IF(status='delivered', total, 0)) AS TotalDeliveredAmount,
                    SUM(IF(status='canceled', total, 0)) AS TotalCanceledAmount
                FROM Orders
                WHERE YEAR(created_at) = YEAR(NOW())
                GROUP BY YEAR(created_at), MONTH(created_at), DATE_FORMAT(created_at, '%b')
                ORDER BY MONTH(created_at)
            ) D ON D.MonthNo = M.id
        ");

        // Mengubah hasil query ke dalam format array JSON
        $data = [
            'orders' => $orders,
            'dashboard' => [
                'TotalAmount' => $dashboardDatas[0]->TotalAmount ?? 0,
                'TotalOrderedAmount' => $dashboardDatas[0]->TotalOrderedAmount ?? 0,
                'TotalDeliveredAmount' => $dashboardDatas[0]->TotalDeliveredAmount ?? 0,
                'TotalCanceledAmount' => $dashboardDatas[0]->TotalCanceledAmount ?? 0,
                'TotalOrders' => $dashboardDatas[0]->Total ?? 0,
                'TotalOrdered' => $dashboardDatas[0]->TotalOrdered ?? 0,
                'TotalDelivered' => $dashboardDatas[0]->TotalDelivered ?? 0,
                'TotalCanceled' => $dashboardDatas[0]->TotalCanceled ?? 0,
            ],
            'monthly' => [
                'months' => collect($monthlyDatas)->pluck('MonthName'),
                'amounts' => collect($monthlyDatas)->pluck('TotalAmount'),
                'orderedAmounts' => collect($monthlyDatas)->pluck('TotalOrderedAmount'),
                'deliveredAmounts' => collect($monthlyDatas)->pluck('TotalDeliveredAmount'),
                'canceledAmounts' => collect($monthlyDatas)->pluck('TotalCanceledAmount'),
                'totals' => [
                    'TotalAmount' => collect($monthlyDatas)->sum('TotalAmount'),
                    'TotalOrderedAmount' => collect($monthlyDatas)->sum('TotalOrderedAmount'),
                    'TotalDeliveredAmount' => collect($monthlyDatas)->sum('TotalDeliveredAmount'),
                    'TotalCanceledAmount' => collect($monthlyDatas)->sum('TotalCanceledAmount'),
                ]
            ]
        ];

        // $user_login = Auth::guard('sanctum')->user();
        // $user = User::find($user_login->id);

        return $this->sendResponse($data, 'Admin dashboard data retrieved successfully');
    }

    // ====================================================================================================
    // API Brands Admin
    // ====================================================================================================

    // Menampilkan daftar brand dengan pagination
    public function brands()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(10);
        return $this->sendResponse($brands, 'Brands retrieved successfully');
    }

    // Menambahkan brand baru
    public function addBrand(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'slug'  => 'required|string|unique:brands,slug',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048'
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_name = Carbon::now()->timestamp . '.' . $image->extension();
            $brand->image = $this->generateBrandThumbnailImage($image, $file_name);
        }

        $brand->save();

        return $this->sendResponse($brand, 'Brand added successfully');
    }

    // Menampilkan detail brand berdasarkan ID
    public function brandDetails($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return $this->sendError('Brand not found', [], 404);
        }

        return $this->sendResponse($brand, 'Brand details retrieved successfully');
    }

    // Mengupdate brand
    public function updateBrand(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required',
            'slug'  => 'required|string|unique:brands,slug,' . $id,
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048'
        ]);

        $brand = Brand::find($id);

        if (!$brand) {
            return $this->sendError('Brand not found', [], 404);
        }

        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($brand->image && File::exists(public_path('uploads/brands/' . $brand->image))) {
                File::delete(public_path('uploads/brands/' . $brand->image));
            }

            $image = $request->file('image');
            $file_name = Carbon::now()->timestamp . '.' . $image->extension();
            $brand->image = $this->generateBrandThumbnailImage($image, $file_name);
        }

        $brand->save();

        return $this->sendResponse($brand, 'Brand updated successfully');
    }

    // Menghapus brand berdasarkan ID
    public function deleteBrand($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return $this->sendError('Brand not found', [], 404);
        }

        // Hapus gambar jika ada
        if ($brand->image && File::exists(public_path('uploads/brands/' . $brand->image))) {
            File::delete(public_path('uploads/brands/' . $brand->image));
        }

        $brand->delete();

        return $this->sendResponse([], 'Brand deleted successfully');
    }

    // Membuat thumbnail brand
    public function generateBrandThumbnailImage($image, $imageName)
    {
        try {
            // Pastikan folder uploads/brands ada
            $destinationPath = public_path('uploads/brands');

            // Pastikan folder ada
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            // Simpan gambar asli ke public/uploads/brands/
            $image->move($destinationPath, $imageName);

            return 'uploads/brands/' . $imageName;
        } catch (\Exception $e) {
            return $this->sendError('Error generating brand thumbnail image: ' . $e->getMessage(), [], 500);
        }
    }


    // ====================================================================================================
    // API Categories
    // ====================================================================================================

    // Menampilkan daftar kategori dengan pagination
    public function categories()
    {
        $categories = Category::orderBy('id', 'DESC')->paginate(10);
        return $this->sendResponse($categories, 'Categories retrieved successfully');
    }

    // Menambahkan kategori baru
    public function addCategory(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'slug'  => 'required|string|unique:categories,slug',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_name = Carbon::now()->timestamp . '.' . $image->extension();
            $category->image = $this->generateCategoryThumbnailImage($image, $file_name);
        }

        $category->save();

        return $this->sendResponse($category, 'Category added successfully');
    }

    // Menampilkan detail kategori berdasarkan ID
    public function categoryDetails($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return $this->sendError('Category not found', [], 404);
        }

        return $this->sendResponse($category, 'Category details retrieved successfully');
    }

    // Mengupdate kategori
    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'slug'  => 'required|string|unique:categories,slug,' . $id,
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048'
        ]);

        $category = Category::find($id);
        if (!$category) {
            return $this->sendError('Category not found', [], 404);
        }

        $category->name = $request->name;
        $category->slug = $request->slug;

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($category->image && File::exists(public_path('uploads/categories/' . $category->image))) {
                File::delete(public_path('uploads/categories/' . $category->image));
            }

            $image = $request->file('image');
            $file_name = Carbon::now()->timestamp . '.' . $image->extension();

            $category->image = $this->generateCategoryThumbnailImage($image, $file_name);
        }

        $category->save();

        return $this->sendResponse($category, 'Category updated successfully');
    }

    // Menghapus kategori berdasarkan ID
    public function deleteCategory($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return $this->sendError('Category not found', [], 404);
        }

        // Hapus gambar jika ada
        if ($category->image && File::exists(public_path('uploads/categories/' . $category->image))) {
            File::delete(public_path('uploads/categories/' . $category->image));
        }

        $category->delete();

        return $this->sendResponse([], 'Category deleted successfully');
    }

    // Membuat thumbnail kategori
    private function GenerateCategoryThumbnailImage($image, $imageName)
    {
        try {
            // Pastikan folder uploads/categories ada
            $destinationPath = public_path('uploads/categories');

            // Buat folder jika belum ada
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            // Ambil informasi gambar
            list($width, $height) = getimagesize($image->getPathname());

            // Buat ukuran baru dengan aspect ratio
            $newWidth = 124;
            $newHeight = intval(($height / $width) * 124);

            // Buat resource gambar baru berdasarkan tipe file
            $imageType = exif_imagetype($image->getPathname());
            switch ($imageType) {
                case IMAGETYPE_JPEG:
                    $srcImage = imagecreatefromjpeg($image->getPathname());
                    break;
                case IMAGETYPE_PNG:
                    $srcImage = imagecreatefrompng($image->getPathname());
                    break;
                default:
                    return $this->sendError('Unsupported image type', [], 400);
            }

            // Buat canvas gambar baru untuk thumbnail
            $dstImage = imagecreatetruecolor($newWidth, $newHeight);

            // Resize dan salin gambar asli ke thumbnail
            imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

            // Simpan gambar baru ke direktori
            $savePath = $destinationPath . '/' . $imageName;
            if ($imageType == IMAGETYPE_JPEG) {
                imagejpeg($dstImage, $savePath, 90);
            } elseif ($imageType == IMAGETYPE_PNG) {
                imagepng($dstImage, $savePath);
            }

            // Hapus resource gambar dari memori
            imagedestroy($srcImage);
            imagedestroy($dstImage);

            return 'uploads/categories/' . $imageName;
        } catch (\Exception $e) {
            return $this->sendError('Error generating category thumbnail image: ' . $e->getMessage(), [], 500);
        }
    }


    // ====================================================================================================
    // API Produk
    // ====================================================================================================

    // Menampilkan daftar produk dengan pagination
    public function products()
    {
        $products = Product::orderBy('created_at', 'DESC')->paginate(10);
        return $this->sendResponse($products, 'Products retrieved successfully');
    }

    // Memberikan detail produk
    public function add_product()
    {
        $categories = Category::Select('id', 'name')->orderBy('name')->get();
        $brands = Brand::Select('id', 'name')->orderBy('name')->get();
        return $this->sendResponse([
            'categories' => $categories,
            'brands' => $brands
        ], 'Detail Product retrived successfully');
    }

    // Menambahkan produk baru
    public function addProduct(Request $request)
    {
        $request->merge([
            'category_id' => (int) $request->category_id,
            'brand_id' => (int) $request->brand_id,
            'regular_price' => (float) $request->regular_price,
            'sale_price' => (float) $request->sale_price,
            'featured' => filter_var($request->featured, FILTER_VALIDATE_BOOLEAN),
            'quantity' => (int) $request->quantity,
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug',
            'category_id' => 'required|integer|exists:categories,id',
            'brand_id' => 'required|integer|exists:brands,id',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'regular_price' => 'required',
            'sale_price' => 'required',
            'SKU' => 'required|string',
            'stock_status' => 'required|string',
            'featured' => 'required|boolean',
            'quantity' => 'required|integer',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048'
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;

        // Hapus format rupiah sehingga tersisa nilai numerik saja  & Pastikan mengonversi ke tipe numeric, misalnya (float) atau (int) jika perlu
        $product->regular_price = (float) str_replace(['Rp ', '.'], '', $request->regular_price);
        $product->sale_price = (float) str_replace(['Rp ', '.'], '', $request->sale_price);

        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        $current_timestamp = Carbon::now()->timestamp;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            // Gunakan function untuk menyimpan gambar
            $imagePath = $this->generateProductThumbnailImage($image, $imageName);
            $product->image = $imagePath;
        }

        $gallery_arr = array();
        $gallery_images = "";
        $counter = 1;

        if ($request->hasFile('images')) {
            $oldGImages = explode(",", $product->images);
            foreach ($oldGImages as $gimage) {
                if (File::exists(public_path('uploads/products') . '/' . trim($gimage))) {
                    File::delete(public_path('uploads/products') . '/' . trim($gimage));
                }

                if (File::exists(public_path('uploads/products/thumbails') . '/' . trim($gimage))) {
                    File::delete(public_path('uploads/products/thumbails') . '/' . trim($gimage));
                }
            }
            $allowedfileExtension = ['jpg', 'png', 'jpeg'];
            $files = $request->file('images');
            foreach ($files as $file) {
                $gextension = $file->getClientOriginalExtension();
                $check = in_array($gextension, $allowedfileExtension);
                if ($check) {
                    $gfilename = $current_timestamp . "-" . $counter . "." . $gextension;
                    $galleryImagePath = $this->generateProductThumbnailImage($file, $gfilename);
                    array_push($gallery_arr, $galleryImagePath);
                    $counter = $counter + 1;
                }
            }
            $gallery_images = implode(',', $gallery_arr);
        }


        $product->images = $gallery_images;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        $product->save();

        return $this->sendResponse($product, 'Product added successfully');
    }

    // Menampilkan detail produk berdasarkan ID
    public function productDetails($id)
    {
        $product = Product::find($id);
        $categories = Category::Select('id', 'name')->orderBy('name')->get();
        $brands = Brand::Select('id', 'name')->orderBy('name')->get();
        if (!$product) {
            return $this->sendError('Product not found', [], 404);
        }

        return $this->sendResponse([
            'product' => $product,
            'categories' => $categories,
            'brands' => $brands,
        ], 'Product details retrieved successfully');
    }

    // Mengupdate produk
    public function updateProduct(Request $request, $id)
    {
        $request->merge([
            'category_id' => (int) $request->category_id,
            'brand_id' => (int) $request->brand_id,
            'regular_price' => (float) $request->regular_price,
            'sale_price' => (float) $request->sale_price,
            'featured' => filter_var($request->featured, FILTER_VALIDATE_BOOLEAN),
            'quantity' => (int) $request->quantity,
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug,' . $id,
            'category_id' => 'required|integer|exists:categories,id',
            'brand_id' => 'required|integer|exists:brands,id',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'regular_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'SKU' => 'required|string',
            'stock_status' => 'required|string',
            'featured' => 'required|boolean',
            'quantity' => 'required|integer',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048'
        ]);

        $product = Product::find($id);
        if (!$product) {
            return $this->sendError('Product not found', [], 404);
        }

        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;

        // Bersihkan format rupiah dan konversi ke numeric
        $product->regular_price = (float) str_replace(['Rp ', '.'], '', $request->regular_price);
        $product->sale_price = (float) str_replace(['Rp ', '.'], '', $request->sale_price);

        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        $current_timestamp = Carbon::now()->timestamp;

        if ($request->hasFile('image')) {
            if ($product->image && File::exists(public_path('uploads/products/' . $product->image))) {
                File::delete(public_path('uploads/products/' . $product->image));
            }

            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $imagePath = $this->generateProductThumbnailImage($image, $imageName);
            $product->image = $imagePath;
        }

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
                    $galleryImagePath = $this->generateProductThumbnailImage($file, $gfilename);
                    array_push($gallery_arr, $galleryImagePath); // <-- Simpan nama file
                    $counter = $counter + 1;
                }
            }
            $gallery_images = implode(', ', $gallery_arr);
            $product->images = $gallery_images;
        }

        $product->save();

        return $this->sendResponse($product, 'Product updated successfully');
    }

    // Menghapus produk berdasarkan ID
    public function deleteProduct($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return $this->sendError('Product not found', [], 404);
        }

        if ($product->image && File::exists(public_path('uploads/products/' . $product->image))) {
            File::delete(public_path('uploads/products/' . $product->image));
        }

        if ($product->image && File::exists(public_path('uploads/products/thumbnails/' . $product->image))) {
            File::delete(public_path('uploads/products/thumbnails/' . $product->image));
        }

        foreach (explode(',', $product->images) as $ofile) {
            if (File::exists(public_path('uploads/products/') . $ofile)) {
                File::delete(public_path('uploads/products/') . $ofile);
            }
            if (File::exists(public_path('uploads/products/thumbnails/') . $ofile)) {
                File::delete(public_path('uploads/products/thumbnails/') . $ofile);
            }
        }

        $product->delete();

        return $this->sendResponse([], 'Product deleted successfully');
    }

    // Membuat thumbnail produk
    private function generateProductThumbnailImage($image, $imageName)
    {
        try {
            // Pastikan folder penyimpanan ada
            $destinationPathThumbnail = public_path('uploads/products/thumbnails');
            $destinationPath = public_path('uploads/products');

            // Buat folder jika belum ada
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }
            if (!File::exists($destinationPathThumbnail)) {
                File::makeDirectory($destinationPathThumbnail, 0777, true, true);
            }

            // Ambil informasi gambar asli
            list($width, $height) = getimagesize($image->getPathname());

            // Ukuran untuk gambar utama (540x689)
            $newWidthMain = 540;
            $newHeightMain = intval(($height / $width) * 540);

            // Ukuran untuk thumbnail (104x104)
            $newWidthThumb = 104;
            $newHeightThumb = intval(($height / $width) * 104);

            // Buat resource gambar berdasarkan tipe file
            $imageType = exif_imagetype($image->getPathname());
            switch ($imageType) {
                case IMAGETYPE_JPEG:
                    $srcImage = imagecreatefromjpeg($image->getPathname());
                    break;
                case IMAGETYPE_PNG:
                    $srcImage = imagecreatefrompng($image->getPathname());
                    break;
                default:
                    return $this->sendError('Unsupported image type', [], 400);
            }

            // **Proses Resize untuk gambar utama (540x689)**
            $dstImageMain = imagecreatetruecolor($newWidthMain, $newHeightMain);
            imagecopyresampled($dstImageMain, $srcImage, 0, 0, 0, 0, $newWidthMain, $newHeightMain, $width, $height);

            // Simpan gambar utama
            $savePathMain = $destinationPath . '/' . $imageName;
            if ($imageType == IMAGETYPE_JPEG) {
                imagejpeg($dstImageMain, $savePathMain, 90);
            } elseif ($imageType == IMAGETYPE_PNG) {
                imagepng($dstImageMain, $savePathMain);
            }

            // **Proses Resize untuk thumbnail (104x104)**
            $dstImageThumb = imagecreatetruecolor($newWidthThumb, $newHeightThumb);
            imagecopyresampled($dstImageThumb, $srcImage, 0, 0, 0, 0, $newWidthThumb, $newHeightThumb, $width, $height);

            // Simpan thumbnail
            $savePathThumb = $destinationPathThumbnail . '/' . $imageName;
            if ($imageType == IMAGETYPE_JPEG) {
                imagejpeg($dstImageThumb, $savePathThumb, 90);
            } elseif ($imageType == IMAGETYPE_PNG) {
                imagepng($dstImageThumb, $savePathThumb);
            }

            // Hapus resource gambar dari memori
            imagedestroy($srcImage);
            imagedestroy($dstImageMain);
            imagedestroy($dstImageThumb);

            return 'uploads/products/' . $imageName;
        } catch (\Exception $e) {
            return $this->sendError('Error generating product thumbnail image: ' . $e->getMessage(), [], 500);
        }
    }


    // ====================================================================================================
    // API Coupons
    // ====================================================================================================

    // Menampilkan daftar kupon dengan pagination
    public function coupons()
    {
        $coupons = Coupon::orderBy('expiry_date', 'DESC')->paginate(12);
        return $this->sendResponse($coupons, 'Coupons retrieved successfully');
    }

    // Menambahkan kupon baru
    public function addCoupon(Request $request)
    {
        // Bersihkan input agar hanya berupa angka
        $request->merge([
            'value' => preg_replace('/[^0-9.]/', '', $request->value),
            'cart_value' => preg_replace('/[^0-9.]/', '', $request->cart_value),
        ]);

        $request->validate([
            'code' => 'required|string|max:255|unique:coupons,code',
            'type' => 'required|string|in:fixed,percent',
            'value' => 'required|numeric',
            'cart_value' => 'required|numeric',
            'expiry_date' => 'required|date'
        ]);

        $coupon = new Coupon();
        $coupon->code = strtoupper($request->code);
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = Carbon::parse($request->expiry_date);
        $coupon->save();

        return $this->sendResponse($coupon, 'Coupon added successfully');
    }

    // Menampilkan detail kupon berdasarkan ID
    public function couponDetails($id)
    {
        $coupon = Coupon::find($id);
        if (!$coupon) {
            return $this->sendError('Coupon not found', [], 404);
        }

        return $this->sendResponse($coupon, 'Coupon details retrieved successfully');
    }

    // Mengupdate kupon
    public function updateCoupon(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:coupons,code,' . $id,
            'type' => 'required|string|in:fixed,percent',
            'value' => 'required|numeric',
            'cart_value' => 'required|numeric',
            'expiry_date' => 'required|date'
        ]);

        $coupon = Coupon::find($id);
        if (!$coupon) {
            return $this->sendError('Coupon not found', [], 404);
        }

        $coupon->code = strtoupper($request->code);
        $coupon->type = $request->type;
        $coupon->value = str_replace(['Rp ', '.'], '', $request->value);
        $coupon->cart_value = str_replace(['Rp ', '.'], '', $request->cart_value);
        $coupon->expiry_date = $request->expiry_date;
        $coupon->save();

        return $this->sendResponse($coupon, 'Coupon updated successfully');
    }

    // Menghapus kupon berdasarkan ID
    public function deleteCoupon($id)
    {
        $coupon = Coupon::find($id);
        if (!$coupon) {
            return $this->sendError('Coupon not found', [], 404);
        }

        $coupon->delete();
        return $this->sendResponse([], 'Coupon deleted successfully');
    }

    // ====================================================================================================
    // API Orders
    // ====================================================================================================

    // Menampilkan daftar order dengan pagination
    public function orders()
    {
        $orders = Order::orderBy('created_at', 'DESC')->paginate(12);
        return $this->sendResponse($orders, 'Orders retrieved successfully');
    }

    // Menampilkan detail order berdasarkan ID
    public function orderItems($order_id)
    {
        $order = Order::find($order_id);
        if (!$order) {
            return $this->sendError('Order not found', [], 404);
        }

        $orderItems = OrderItem::where('order_id', $order_id)->orderBy('id')->paginate(12);
        $transaction = Transaction::where('order_id', $order_id)->first();

        return $this->sendResponse([
            'order' => $order,
            'orderitems' => $orderItems,
            'transaction' => $transaction
        ], 'Order details retrieved successfully');
    }

    // Mengupdate status order
    public function updateOrderStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'order_status' => 'required|in:ordered,delivered,canceled'
        ]);

        $order = Order::find($request->order_id);
        if (!$order) {
            return $this->sendError('Order not found', [], 404);
        }

        $order->status = $request->order_status;

        if ($request->order_status == 'delivered') {
            $order->delivered_date = Carbon::now();
        } elseif ($request->order_status == 'canceled') {
            $order->canceled_date = Carbon::now();
        }

        $order->save();

        // Jika status dikirim, update transaksi terkait
        if ($request->order_status == 'delivered') {
            $transaction = Transaction::where('order_id', $request->order_id)->first();
            if ($transaction) {
                $transaction->status = "approved";
                $transaction->save();
            }
        }

        return $this->sendResponse($order, 'Order status updated successfully');
    }

    // ====================================================================================================
    // API Slides
    // ====================================================================================================

    // Menampilkan daftar slide dengan pagination
    public function slides()
    {
        $slides = Slide::orderBy('id', 'DESC')->paginate(12);
        return $this->sendResponse($slides, 'Slides retrieved successfully');
    }

    // Menambahkan slide baru
    public function addSlide(Request $request)
    {
        $request->merge([
            'status' => filter_var($request->status, FILTER_VALIDATE_BOOLEAN)
        ]);

        $request->validate([
            'tagline' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'link' => 'required|url',
            'status' => 'required|boolean',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048'
        ]);

        $slide = new Slide();
        $slide->tagline = $request->tagline;
        $slide->title = $request->title;
        $slide->subtitle = $request->subtitle;
        $slide->link = $request->link;
        $slide->status = $request->status;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_name = Carbon::now()->timestamp . '.' . $image->extension();
            $slide->image = $this->generateSlideThumbnailImage($image, $file_name);
        }

        $slide->save();
        return $this->sendResponse($slide, 'Slide added successfully');
    }

    // Menampilkan detail slide berdasarkan ID
    public function slideDetails($id)
    {
        $slide = Slide::find($id);
        if (!$slide) {
            return $this->sendError('Slide not found', [], 404);
        }

        return $this->sendResponse($slide, 'Slide details retrieved successfully');
    }

    // Mengupdate slide
    public function updateSlide(Request $request, $id)
    {
        $request->merge([
            'status' => filter_var($request->status, FILTER_VALIDATE_BOOLEAN)
        ]);

        $request->validate([
            'tagline' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'link' => 'required|url',
            'status' => 'required|boolean',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048'
        ]);

        $slide = Slide::find($id);
        if (!$slide) {
            return $this->sendError('Slide not found', [], 404);
        }

        $slide->tagline = $request->tagline;
        $slide->title = $request->title;
        $slide->subtitle = $request->subtitle;
        $slide->link = $request->link;
        $slide->status = $request->status;

        if ($request->hasFile('image')) {
            if ($slide->image && File::exists(public_path('uploads/slides/' . $slide->image))) {
                File::delete(public_path('uploads/slides/' . $slide->image));
            }

            $image = $request->file('image');
            $file_name = Carbon::now()->timestamp . '.' . $image->extension();

            $slide->image = $this->generateSlideThumbnailImage($image, $file_name);
        }

        $slide->save();
        return $this->sendResponse($slide, 'Slide updated successfully');
    }

    // Menghapus slide berdasarkan ID
    public function deleteSlide($id)
    {
        $slide = Slide::find($id);
        if (!$slide) {
            return $this->sendError('Slide not found', [], 404);
        }

        if ($slide->image && File::exists(public_path('uploads/slides/' . $slide->image))) {
            File::delete(public_path('uploads/slides/' . $slide->image));
        }

        $slide->delete();
        return $this->sendResponse([], 'Slide deleted successfully');
    }

    // Membuat thumbnail slide
    private function generateSlideThumbnailImage($image, $imageName)
    {
        try {
            // Path penyimpanan
            $destinationPath = public_path('uploads/slides');

            // Buat folder jika belum ada
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            // Ambil ukuran asli gambar
            list($width, $height) = getimagesize($image->getPathname());

            // Ukuran untuk slide (400x690)
            $newWidth = 400;
            $newHeight = intval(($height / $width) * 400);

            // Buat resource gambar dari file
            $imageType = exif_imagetype($image->getPathname());
            switch ($imageType) {
                case IMAGETYPE_JPEG:
                    $srcImage = imagecreatefromjpeg($image->getPathname());
                    break;
                case IMAGETYPE_PNG:
                    $srcImage = imagecreatefrompng($image->getPathname());
                    break;
                default:
                    return $this->sendError('Unsupported image type', [], 400);
            }

            // **Proses Resize untuk slide (400x690)**
            $dstImage = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

            // Simpan gambar slide
            $savePath = $destinationPath . '/' . $imageName;
            if ($imageType == IMAGETYPE_JPEG) {
                imagejpeg($dstImage, $savePath, 90);
            } elseif ($imageType == IMAGETYPE_PNG) {
                imagepng($dstImage, $savePath);
            }

            // Hapus resource gambar dari memori
            imagedestroy($srcImage);
            imagedestroy($dstImage);

            return 'uploads/slides/' . $imageName;
        } catch (\Exception $e) {
            return $this->sendError('Error generating slide thumbnail image: ' . $e->getMessage(), [], 500);
        }
    }


    // ====================================================================================================
    // API Contacts
    // ====================================================================================================
    public function contacts()
    {
        $contacts = Contact::orderBy('created_at', 'DESC')->paginate(10);
        return $this->sendResponse($contacts, 'Contacts retrieved successfully');
    }
    // Delete Contact
    public function contact_delete($id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        return $this->sendResponse([], 'Contact deleted successfully');
    }
}
