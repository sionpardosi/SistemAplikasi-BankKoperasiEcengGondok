<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class WishlistController extends Controller
{
    // Show wishlist
    public function index()
    {
        $cartItems = Cart::instance('wishlist')->content();
        return view('wishlist', compact('cartItems'));
    }
    // Add to wishlist
    public function add_to_wishlist(Request $request)
    {
        Cart::instance('wishlist')->add($request->id, $request->name, $request->quantity, $request->price)->associate('App\Models\Product');
        return redirect()->back();
    }
}
