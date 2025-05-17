<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use App\Models\WishlistItem;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
{
    // Show wishlist
    public function index()
    {
        // Load wishlist from database if user is logged in
        if (Auth::check()) {
            $this->syncWishlistFromDatabase();
        }

        $cartItems = Cart::instance('wishlist')->content();
        return view('wishlist', compact('cartItems'));
    }

    // Add to wishlist
    public function add_to_wishlist(Request $request)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            // Store product info in session for later addition after login
            Session::put('pending_wishlist_item', [
                'id' => $request->id,
                'name' => $request->name,
                'quantity' => $request->quantity,
                'price' => $request->price
            ]);

            // Return JSON response for AJAX requests
            if($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan login terlebih dahulu untuk menambahkan ke favorit',
                    'redirect' => route('login')
                ], 401);
            }

            // Redirect to login page with a return URL
            return redirect()->route('login')
                ->with('message', 'Silakan login untuk menambahkan produk ke favorit Anda');
        }

        // User is logged in, add to both Cart instance and database
        $this->addToWishlistDatabase($request);

        // Add to Cart instance for current session
        $item = Cart::instance('wishlist')
            ->add($request->id, $request->name, $request->quantity, $request->price)
            ->associate('App\Models\Product');

        // Get the product
        $product = Product::find($request->id);

        // For AJAX requests, return JSON response
        if($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke favorit',
                'count' => Cart::instance('wishlist')->count(),
                'rowId' => $item->rowId,
                'removeUrl' => route('wishlist.remove', ['rowId' => $item->rowId]),
                'productId' => $product->id,
                'productName' => $product->name,
                'productPrice' => $product->sale_price ?: $product->regular_price
            ]);
        }

        return redirect()->back()->with('success_message', 'Item added to your wishlist');
    }

    // Remove item from wishlist
    public function remove_item_from_wishlist($rowId)
    {
        // Get the item information before removing it
        $item = Cart::instance('wishlist')->get($rowId);
        $productId = $item ? $item->id : null;
        $productName = $item ? $item->name : '';
        $productPrice = $item ? $item->price : 0;

        // Remove from Cart instance
        Cart::instance('wishlist')->remove($rowId);

        // If user is logged in, also remove from database
        if (Auth::check() && $productId) {
            WishlistItem::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->delete();
        }

        // For AJAX requests, return JSON response
        if(request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus dari favorit',
                'count' => Cart::instance('wishlist')->count(),
                'productId' => $productId,
                'productName' => $productName,
                'productPrice' => $productPrice
            ]);
        }

        return redirect()->back()->with('success_message', 'Item removed from wishlist');
    }

    // Empty wishlist
    public function empty_wishlist()
    {
        // Clear Cart instance
        Cart::instance('wishlist')->destroy();

        // If user is logged in, clear database entries
        if (Auth::check()) {
            WishlistItem::where('user_id', Auth::id())->delete();
        }

        // For AJAX requests, return JSON response
        if(request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Semua item telah dihapus dari favorit',
                'count' => 0
            ]);
        }

        return redirect()->back()->with('success_message', 'Wishlist cleared');
    }

    // Move to cart
    public function move_to_cart($rowId)
    {
        $item = Cart::instance('wishlist')->get($rowId);

        if (!$item) {
            // For AJAX requests
            if(request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item tidak ditemukan dalam favorit'
                ], 404);
            }
            return redirect()->back()->with('error_message', 'Item not found in wishlist');
        }

        // Remove from wishlist Cart instance
        Cart::instance('wishlist')->remove($rowId);

        // Add to cart Cart instance
        Cart::instance('cart')->add($item->id, $item->name, 1, $item->price)->associate('App\Models\Product');

        // If user is logged in, remove from wishlist database
        if (Auth::check()) {
            WishlistItem::where('user_id', Auth::id())
                ->where('product_id', $item->id)
                ->delete();
        }

        // For AJAX requests
        if(request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dipindahkan ke keranjang',
                'wishlistCount' => Cart::instance('wishlist')->count(),
                'cartCount' => Cart::instance('cart')->count()
            ]);
        }

        return redirect()->back()->with('success_message', 'Item moved to cart');
    }

    // Sync wishlist from database to Cart instance
    private function syncWishlistFromDatabase()
    {
        // Clear current Cart instance first
        Cart::instance('wishlist')->destroy();

        // Get items from database
        $wishlistItems = WishlistItem::where('user_id', Auth::id())->get();

        // Add each item to Cart instance
        foreach ($wishlistItems as $item) {
            if (!Cart::instance('wishlist')->content()->where('id', $item->product_id)->count()) {
                Cart::instance('wishlist')->add(
                    $item->product_id,
                    $item->name,
                    $item->quantity,
                    $item->price
                )->associate('App\Models\Product');
            }
        }
    }

    // Add to wishlist database
    private function addToWishlistDatabase(Request $request)
    {
        // Check if product already exists in user's wishlist
        $existingItem = WishlistItem::where('user_id', Auth::id())
            ->where('product_id', $request->id)
            ->first();

        if (!$existingItem) {
            // Create new wishlist item in database
            WishlistItem::create([
                'user_id' => Auth::id(),
                'product_id' => $request->id,
                'name' => $request->name,
                'quantity' => $request->quantity,
                'price' => $request->price
            ]);
        }
    }

    // Process any pending wishlist items saved during login redirect
    public function processPendingWishlistItem()
    {
        if (Session::has('pending_wishlist_item')) {
            $item = Session::get('pending_wishlist_item');

            // Create a request object to pass to the add method
            $request = new Request($item);

            // Add to database
            $this->addToWishlistDatabase($request);

            // Add to Cart instance
            Cart::instance('wishlist')->add($item['id'], $item['name'], $item['quantity'], $item['price'])
                ->associate('App\Models\Product');

            // Clear the session
            Session::forget('pending_wishlist_item');

            return true;
        }

        return false;
    }

    // Get wishlist count via AJAX
    public function getWishlistCount()
    {
        if (Auth::check()) {
            // Ensure wishlist is synced from database
            $this->syncWishlistFromDatabase();
        }

        $count = Cart::instance('wishlist')->count();
        return response()->json(['count' => $count]);
    }
}
