<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'productCountBySize'
        ));
    }

    // Halaman Detail Produk
    // public function product_details($product_slug)
    // {
    //     $product = Product::where('slug', $product_slug)->first();

    //     // Find previous product
    //     $prevProduct = Product::where('id', '<', $product->id)
    //         ->orderBy('id', 'desc')
    //         ->first();

    //     // Find next product
    //     $nextProduct = Product::where('id', '>', $product->id)
    //         ->orderBy('id', 'asc')
    //         ->first();

    //     $rproducts = Product::where('slug', "<>", $product_slug)->get()->take(8);
    //     $product = Product::with(['reviews.reviewMedia', 'reviews.user'])->where('slug', $product_slug)->first();
    //     $product = Product::with(['reviews.user', 'reviews.reviewMedia'])->where('slug', $product_slug)->first();



    //     return view('details', compact("product", "rproducts", "prevProduct", "nextProduct"));
    // }

    public function product_details($product_slug)
    {
        $product = Product::with(['sizes', 'reviews.user', 'reviews.reviewMedia'])
            ->where('slug', $product_slug)
            ->firstOrFail();

        $prevProduct = Product::where('id', '<', $product->id)->orderBy('id', 'desc')->first();
        $nextProduct = Product::where('id', '>', $product->id)->orderBy('id', 'asc')->first();
        $rproducts = Product::where('slug', '<>', $product_slug)->take(8)->get();

        return view('details', compact('product', 'rproducts', 'prevProduct', 'nextProduct'));
    }
}
