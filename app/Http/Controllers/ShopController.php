<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    // Halaman User Produk
    public function index(Request $request)
    {
        // Ubah nama variabel $size menjadi $pageSize untuk menghindari konflik
        $pageSize = $request->query('size') ? $request->query('size') : 12;
        $order = $request->query('order') ? $request->query('order') : -1;
        $f_brands = $request->query('brands');
        $f_categories = $request->query('categories');
        $f_sizes = $request->query('sizes'); // Untuk filter ukuran
        $min_price = $request->query('min') ? $request->query('min') : 1;
        $max_price = $request->query('max') ? $request->query('max') : 10000000;
        $search = $request->query('search');
        $ratings = $request->query('ratings');
        $shipping_courier = $request->query('shipping_courier');
        $shipping_cost = $request->query('shipping_cost');
        $shipping_time = $request->query('shipping_time');
        $shipping_cost_min = $request->query('shipping_cost_min') ? $request->query('shipping_cost_min') : 0;
        $shipping_cost_max = $request->query('shipping_cost_max') ? $request->query('shipping_cost_max') : 100000;


        // Definisikan ordering
        switch ($order) {
            case 1:
                $o_column = 'created_at';
                $o_order = 'DESC';
                break;
            case 2:
                $o_column = 'created_at';
                $o_order = 'ASC';
                break;
            case 3:
                $o_column = 'sale_price';
                $o_order = 'ASC';
                break;
            case 4:
                $o_column = 'sale_price';
                $o_order = 'DESC';
                break;
            default:
                $o_column = 'id';
                $o_order = 'DESC';
        }

        $brands = Brand::orderBy('name', 'ASC')->get();
        $categories = Category::orderBy('name', 'ASC')->get();
        $sizes = Size::orderBy('name', 'ASC')->get(); // Ambil semua ukuran dari database

        $query = Product::where(function ($query) use ($f_brands) {
            $query->whereIn('brand_id', explode(',', $f_brands))->orWhereRaw("'" . $f_brands . "' = ''");
        })
            ->where(function ($query) use ($f_categories) {
                $query->whereIn('category_id', explode(',', $f_categories))->orWhereRaw("'" . $f_categories . "' = ''");
            })
            ->where(function ($query) use ($min_price, $max_price) {
                $query->whereBetween('regular_price', [$min_price, $max_price])
                    ->orWhereBetween('sale_price', [$min_price, $max_price]);
            });

        // Filter ukuran jika ada
        if (!empty($f_sizes)) {
            $sizeIds = explode(',', $f_sizes);
            $query->whereHas('sizes', function ($q) use ($sizeIds) {
                $q->whereIn('sizes.id', $sizeIds);
            });
        }

        // Filter berdasarkan rating jika ada
        if (!empty($ratings)) {
            $ratingArray = explode(',', $ratings);
            $query->whereHas('reviews', function ($q) use ($ratingArray) {
                $q->whereIn(DB::raw('FLOOR(rating)'), $ratingArray);
            });
        }

        // Add search filter if search parameter exists
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhere('short_description', 'LIKE', "%{$search}%");
            });
        }

        $products = $query->orderBy($o_column, $o_order)->paginate($pageSize);

        // Prepare rating filter counts
        $productCountByRating = [];
        for ($i = 1; $i <= 5; $i++) {
            $productCountByRating[$i] = Product::whereHas('reviews', function ($query) use ($i) {
                $query->where(DB::raw('FLOOR(rating)'), $i);
            })->count();
        }

        // Count products by size for displaying in filter
        $productCountBySize = [];
        foreach ($sizes as $size) {
            $productCountBySize[$size->id] = Product::whereHas('sizes', function ($q) use ($size) {
                $q->where('sizes.id', $size->id);
            })->count();
        }

        // Pass search parameter to view
        $search_query = $search;

        return view('shop', compact(
            'products',
            'pageSize', // Ubah dari 'size' menjadi 'pageSize'
            'order',
            'brands',
            'f_brands',
            'categories',
            'f_categories',
            'min_price',
            'max_price',
            'search_query',
            'productCountByRating',
            'ratings',
            'sizes',
            'f_sizes',
            'productCountBySize',
        ));
    }

    public function product_details($product_slug)
    {
        $product = Product::with(['sizes', 'reviews.user', 'reviews.reviewMedia'])
            ->where('slug', $product_slug)
            ->firstOrFail();

        // Pastikan quantity produk sesuai dengan total stok sizes jika ada
        if ($product->sizes->count() > 0) {
            $totalSizeStock = $product->sizes->sum('pivot.stock');
            // Update quantity jika tidak sesuai
            if ($product->quantity != $totalSizeStock) {
                $product->update(['quantity' => $totalSizeStock]);
                $product->refresh(); // Refresh model setelah update
            }
        }

        $prevProduct = Product::where('id', '<', $product->id)->orderBy('id', 'desc')->first();
        $nextProduct = Product::where('id', '>', $product->id)->orderBy('id', 'asc')->first();
        $rproducts = Product::where('slug', '<>', $product_slug)->take(8)->get();

        return view('details', compact('product', 'rproducts', 'prevProduct', 'nextProduct'));
    }

    // Tambahkan method ini di ShopController.php
    public function getProductStock($id)
    {
        try {
            $product = Product::with(['sizes'])->findOrFail($id);

            Log::info("API Stock check for product {$id}");

            $stockData = [
                'product_id' => $product->id,
                'total_stock' => $product->quantity,
                'reserved_stock' => $product->reserved_quantity ?? 0,
                'available_stock' => 0,
                'sizes' => []
            ];

            // ✅ PERBAIKAN: Hitung available_stock berdasarkan apakah ada ukuran atau tidak
            if ($product->sizes->count() > 0) {
                // Untuk produk dengan ukuran
                foreach ($product->sizes as $size) {
                    $stockData['sizes'][] = [
                        'id' => $size->id,
                        'name' => $size->name,
                        'stock' => $size->pivot->stock
                    ];
                }

                // Total stok = jumlah stok semua ukuran
                $stockData['available_stock'] = $product->sizes->sum('pivot.stock');

                Log::info("Product {$id} has sizes. Total available stock: {$stockData['available_stock']}");
            } else {
                // Untuk produk tanpa ukuran
                $stockData['available_stock'] = $product->quantity - ($product->reserved_quantity ?? 0);

                \Illuminate\Support\Facades\Log::info("Product {$id} has no sizes. Available stock: {$stockData['available_stock']} (quantity: {$product->quantity}, reserved: {$product->reserved_quantity})");
            }

            return response()->json($stockData);
        } catch (\Exception $e) {
            Log::error("Error getting stock for product {$id}: " . $e->getMessage());
            return response()->json([
                'error' => 'Product not found',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    // Tambahkan juga method untuk check stock sebelum add to cart
    public function checkProductStock(Request $request, $id)
    {
        try {
            $product = Product::with(['sizes'])->findOrFail($id);
            $sizeId = $request->query('size_id');
            $requestedQty = $request->query('quantity', 1);

            $availableStock = 0;

            if ($product->sizes->count() > 0 && $sizeId) {
                // Untuk produk dengan ukuran
                $size = $product->sizes()->where('size_id', $sizeId)->first();
                if ($size) {
                    $availableStock = $size->pivot->stock;
                }

                Log::info("Stock check for product {$id} size {$sizeId}: {$availableStock}");
            } else {
                // Untuk produk tanpa ukuran
                $availableStock = $product->quantity - ($product->reserved_quantity ?? 0);

                Log::info("Stock check for product {$id} (no size): {$availableStock}");
            }

            $isAvailable = $availableStock >= $requestedQty;

            return response()->json([
                'product_id' => $product->id,
                'available_stock' => $availableStock,
                'requested_quantity' => $requestedQty,
                'is_available' => $isAvailable,
                'has_sizes' => $product->sizes->count() > 0,
                'message' => $isAvailable ? 'Stock available' : 'Insufficient stock'
            ]);
        } catch (\Exception $e) {
            Log::error("Error checking stock for product {$id}: " . $e->getMessage());
            return response()->json([
                'error' => 'Product not found',
                'message' => $e->getMessage()
            ], 404);
        }
    }
}
