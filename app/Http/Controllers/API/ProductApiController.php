<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

// class ProductApiController extends Controller
// {
//     /**
//      * Menampilkan daftar produk.
//      */
//     public function index()
//     {
//         // Mengambil produk beserta relasi kategori dan brand
//         $products = Product::with(['category', 'brand'])
//             ->orderBy('created_at', 'DESC')
//             ->paginate(10);

//         return response()->json([
//             'success' => true,
//             'data'    => $products
//         ], 200);
//     }

//     /**
//      * Menyimpan produk baru via API.
//      */
//     public function store(Request $request)
//     {
//         // Validasi input
//         $validator = Validator::make($request->all(), [
//             'name'              => 'required|string|max:255',
//             'slug'              => 'required|unique:products,slug',
//             'category_id'       => 'required|exists:categories,id',
//             'brand_id'          => 'required|exists:brands,id',
//             'short_description' => 'required|string|max:255',
//             'description'       => 'required|string',
//             'regular_price'     => 'required',
//             'sale_price'        => 'required',
//             'SKU'               => 'required|string',
//             'stock_status'      => 'required|in:instock,outofstock',
//             'featured'          => 'required|boolean',
//             'quantity'          => 'required|integer',
//             'image'             => 'required|image|mimes:png,jpg,jpeg|max:2048',
//             'images.*'          => 'nullable|image|mimes:png,jpg,jpeg|max:2048'
//         ]);

//         if ($validator->fails()) {
//             return response()->json([
//                 'success' => false,
//                 'errors'  => $validator->errors()
//             ], 422);
//         }

//         // Bersihkan input harga dari format Rupiah jika dikirim dengan "Rp " dan pemisah ribuan
//         $regular_price = floatval(str_replace(['Rp ', '.'], '', $request->regular_price));
//         $sale_price    = floatval(str_replace(['Rp ', '.'], '', $request->sale_price));

//         $product = new Product();
//         $product->name              = $request->name;
//         $product->slug              = Str::slug($request->name);
//         $product->short_description = $request->short_description;
//         $product->description       = $request->description;
//         $product->regular_price     = $regular_price;
//         $product->sale_price        = $sale_price;
//         $product->SKU               = $request->SKU;
//         $product->stock_status      = $request->stock_status;
//         $product->featured          = $request->featured;
//         $product->quantity          = $request->quantity;
//         $product->category_id       = $request->category_id;
//         $product->brand_id          = $request->brand_id;

//         $current_timestamp = Carbon::now()->timestamp;

//         // Proses file upload untuk gambar utama
//         if ($request->hasFile('image')) {
//             $image     = $request->file('image');
//             $imageName = $current_timestamp . '.' . $image->extension();
//             $this->generateProductThumbnailImage($image, $imageName);
//             $product->image = $imageName;
//         }

//         // Proses file upload untuk gallery images (jika ada)
//         if ($request->hasFile('images')) {
//             $gallery_arr = [];
//             $counter = 1;
//             foreach ($request->file('images') as $file) {
//                 $gextension = $file->getClientOriginalExtension();
//                 if (in_array(strtolower($gextension), ['jpg', 'png', 'jpeg'])) {
//                     $gfilename = $current_timestamp . "-" . $counter . "." . $gextension;
//                     $this->generateProductThumbnailImage($file, $gfilename);
//                     $gallery_arr[] = $gfilename;
//                     $counter++;
//                 }
//             }
//             $product->images = implode(',', $gallery_arr);
//         }

//         $product->save();

//         return response()->json([
//             'success' => true,
//             'data'    => $product,
//             'message' => 'Product created successfully!'
//         ], 201);
//     }

//     /**
//      * Membuat thumbnail gambar produk menggunakan Intervention Image.
//      *
//      * @param \Illuminate\Http\UploadedFile $image
//      * @param string $imageName
//      */
//     protected function generateProductThumbnailImage($image, $imageName)
//     {
//         $destinationPathThumbnail = public_path('uploads/products/thumbnails');
//         $destinationPath = public_path('uploads/products');
//         $img = \Intervention\Image\Laravel\Facades\Image::make($image->getRealPath());

//         // Resize dan crop untuk gambar utama
//         $img->fit(540, 689, function ($constraint) {
//             $constraint->upsize();
//         })->save($destinationPath . '/' . $imageName);

//         // Resize untuk thumbnail kecil
//         $img->fit(104, 104, function ($constraint) {
//             $constraint->upsize();
//         })->save($destinationPathThumbnail . '/' . $imageName);
//     }
// }
