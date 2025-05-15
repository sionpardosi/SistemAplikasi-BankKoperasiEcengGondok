<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use App\Models\WishlistItem;

class SyncWishlistMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Only proceed if user is authenticated
        if (Auth::check()) {
            // Get wishlist count from database
            $wishlistCount = WishlistItem::where('user_id', Auth::id())->count();

            // If the Cart instance is empty or doesn't match the database count, sync it
            if (Cart::instance('wishlist')->count() != $wishlistCount) {
                $this->syncWishlistFromDatabase();
            }
        }

        return $next($request);
    }

    /**
     * Sync wishlist from database to Cart instance
     */
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
}
