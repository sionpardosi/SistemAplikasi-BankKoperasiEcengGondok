<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use App\Models\Product;
use App\Models\User;
use App\Models\WishlistItem;
use Illuminate\Support\Facades\Auth;

class WishlistController extends BaseController
{
    // Menampilkan wishlist
    public function index()
    {
        try {
            $user_login = Auth::guard('sanctum')->user();
            $user = User::find($user_login->id);

            $wishlistItems = WishlistItem::where('user_id', $user->id)->get();

            return $this->sendResponse($wishlistItems, 'Wishlist retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve wishlist', ['error' => $e->getMessage()], 500);
        }
    }

    // Menambahkan item ke wishlist
    public function addToWishlist(Request $request)
    {
        try {
            $user_login = Auth::guard('sanctum')->user();
            $user = User::find($user_login->id);

            $request->validate([
                'id'       => 'required|integer|exists:products,id',
                'name'     => 'required|string',
                'quantity' => 'required|integer|min:1',
                'price'    => 'required|numeric|min:0',
            ]);

            // Cek apakah produk sudah ada di wishlist
            $wishlistItem = WishlistItem::where('user_id', $user->id)
                ->where('product_id', $request->id)
                ->first();

            if (!$wishlistItem) {
                WishlistItem::create([
                    'user_id'    => $user->id,
                    'product_id' => $request->id,
                    'name'       => $request->name,
                    'quantity'   => $request->quantity,
                    'price'      => $request->price,
                ]);
            }

            return $this->sendResponse([], 'Item added to wishlist successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to add item to wishlist', ['error' => $e->getMessage()], 500);
        }
    }

    // Menghapus item dari wishlist
    public function removeItemFromWishlist($productId)
    {
        try {
            $user_login = Auth::guard('sanctum')->user();
            $user = User::find($user_login->id);
            // Hapus item dari wishlist berdasarkan product_id
            $deleted = WishlistItem::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->delete();

            if (!$deleted) {
                return $this->sendError('Item not found in wishlist', [], 404);
            }
            return $this->sendResponse([], 'Item removed from wishlist');
        } catch (\Exception $e) {
            return $this->sendError('Failed to remove item from wishlist', ['error' => $e->getMessage()], 500);
        }
    }

    // Mengosongkan wishlist
    public function emptyWishlist()
    {
        try {
            $user_login = Auth::guard('sanctum')->user();
            $user = User::find($user_login->id);
            // Hapus semua item dari wishlist berdasarkan user_id
            WishlistItem::where('user_id', $user->id)->delete();
            return $this->sendResponse([], 'Wishlist emptied');
        } catch (\Exception $e) {
            return $this->sendError('Failed to empty wishlist', ['error' => $e->getMessage()], 500);
        }
    }

    // Memindahkan item dari wishlist ke keranjang
    public function moveToCart($productId)
    {
        try {
            $user_login = Auth::guard('sanctum')->user();
            $user = User::find($user_login->id);
            // Ambil item dari wishlist berdasarkan product_id
            $wishlistItem = WishlistItem::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->first();

            if (!$wishlistItem) {
                return $this->sendError('Item not found in wishlist', [], 404);
            }

            // Cek apakah produk sudah ada di keranjang
            $cartItem = CartItem::where('user_id', $user->id)
                ->where('product_id', $wishlistItem->product_id)
                ->first();

            if (!$cartItem) {
                // Pindahkan ke cart (gunakan CartItem model)
                CartItem::create([
                    'user_id'    => $user->id,
                    'product_id' => $wishlistItem->product_id,
                    'name'       => $wishlistItem->name,
                    'quantity'   => $wishlistItem->quantity,
                    'price'      => $wishlistItem->price,
                ]);
            } else {
                // Update quantity jika sudah ada di keranjang
                $cartItem->quantity += $wishlistItem->quantity;
                $cartItem->save();
            }

            // Hapus dari wishlist
            $wishlistItem->delete();

            return $this->sendResponse([], 'Item moved to cart successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to move item to cart', ['error' => $e->getMessage()], 500);
        }
    }
}
