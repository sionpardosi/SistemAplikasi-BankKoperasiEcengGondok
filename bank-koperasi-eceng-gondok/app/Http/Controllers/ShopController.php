<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // Halaman User Produk
    public function index(Request $request)
    {
        $size = $request->query('size') ? $request->query('size') : 12;
        $order = $request->query('order') ? $request->query('order') : -1;

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
                $o_column = 'created_at';
                $o_order = 'DESC';
        }

        $products = Product::orderBy($o_column, $o_order)->paginate($size);
        return view('shop', compact('products', 'size', 'order'));
    }

    // Halaman Detail Produk
    public function product_details($product_slug)
    {
        $product = Product::where('slug', $product_slug)->first();
        $rproducts = Product::where('slug', "<>", $product_slug)->get()->take(8);
        return view('details', compact("product", "rproducts"));
    }
}



    // $categories = Category::orderBy("name","ASC")->get();
    // $brands = Brand::orderBy("name","ASC")->get();
