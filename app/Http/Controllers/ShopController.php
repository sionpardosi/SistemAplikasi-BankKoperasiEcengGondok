<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // Halaman User Produk
    public function index(Request $request)
    {
        $size = $request->query('size') ? $request->query('size') : 12;
        $order = $request->query('order') ? $request->query('order') : -1;
        $f_brands = $request->query('brands');
        $f_categories = $request->query('categories');
        $min_price = $request->query('min') ? $request->query('min') : 1;
        $max_price = $request->query('max') ? $request->query('max') : 10000000; // 10.000.000
        $search = $request->query('search'); // Get search parameter

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
                // Misalnya, untuk default kita ingin urut berdasarkan created_at DESC
                $o_column = 'id';
                $o_order = 'DESC';
        }
        $brands = Brand::orderBy('name', 'ASC')->get();
        $categories = Category::orderBy('name', 'ASC')->get();

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

        // Add search filter if search parameter exists
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhere('short_description', 'LIKE', "%{$search}%");
            });
        }

        $products = $query->orderBy($o_column, $o_order)->paginate($size);

        // Prepare rating filter counts
        $productCountByRating = [];
        for ($i = 1; $i <= 5; $i++) {
            $productCountByRating[$i] = Product::whereHas('reviews', function ($query) use ($i) {
                $query->where('rating', $i);
            })->count();
        }

        // Pass search parameter to view
        $search_query = $search;

        return view('shop', compact(
            'products',
            'size',
            'order',
            'brands',
            'f_brands',
            'categories',
            'f_categories',
            'min_price',
            'max_price',
            'search_query',
            'productCountByRating'
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
