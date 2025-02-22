<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    // Cart Page
    public function index()
    {
        // $cartItems = Cart::instance('cart')->content();
        $cartItems = Cart::instance('cart')->content();
        return view('cart', compact('cartItems'));
    }
    // Add to Cart
    public function addToCart(Request $request)
    {
        Cart::instance('cart')->add($request->id, $request->name, $request->quantity, $request->price)->associate('App\Models\Product');
        // session()->flash('success', 'Product is Added to Cart Successfully !');
        // return response()->json(['status' => 200, 'message' => 'Success ! Item Successfully added to your cart.']);
        return redirect()->back();
    }
    // Remove from Cart
    public function increase_item_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }
    // Reduce Item Quantity
    public function reduce_item_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }
}
