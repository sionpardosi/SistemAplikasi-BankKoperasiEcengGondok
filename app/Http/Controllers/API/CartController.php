<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Address;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends BaseController
{
    // Menampilkan isi keranjang
    public function index()
    {
        try {
            $user_login = Auth::guard('sanctum')->user();
            $user = User::find($user_login->id);
            $cartItems = CartItem::where('user_id', $user->id)->get();

            // Hanya ambil data yang diperlukan
            $formattedCartItems = $cartItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'name' => $item->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ];
            });

            return $this->sendResponse($formattedCartItems, 'Cart retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve cart', ['error' => $e->getMessage()], 500);
        }
    }

    // Menambahkan item ke keranjang
    public function addToCart(Request $request)
    {
        try {
            $request->validate([
                'id'       => 'required|integer|exists:products,id',
                'name'     => 'required|string',
                'quantity' => 'required|integer|min:1',
                'price'    => 'required|numeric|min:0',
            ]);

            $user_login = Auth::guard('sanctum')->user();
            $user = User::find($user_login->id);

            // Cek apakah produk sudah ada di cart user
            $cartItem = CartItem::where('user_id', $user->id)
                ->where('product_id', $request->id)
                ->first();

            if ($cartItem) {
                // Jika produk sudah ada, update quantity
                $cartItem->update(['quantity' => $cartItem->quantity + $request->quantity]);
            } else {
                // Jika belum ada, buat entri baru
                CartItem::create([
                    'user_id'    => $user->id,
                    'product_id' => $request->id,
                    'name'       => $request->name,
                    'quantity'   => $request->quantity,
                    'price'      => $request->price,
                ]);
            }

            // Hitung jumlah item dalam cart
            $cartCount = CartItem::where('user_id', $user->id)->sum('quantity');

            return $this->sendResponse(['cartCount' => $cartCount], 'Item added to cart successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to add item to cart', ['error' => $e->getMessage()], 500);
        }
    }

    // Menambah jumlah item
    public function increaseItemQuantity($productId)
    {
        try {
            $user_login = Auth::guard('sanctum')->user();
            $user = User::find($user_login->id);

            // Cari item di cart berdasarkan product_id
            $cartItem = CartItem::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->first();

            if (!$cartItem) {
                return $this->sendError('Item not found in cart', [], 404);
            }

            // Tambah quantity
            $cartItem->increment('quantity');
            return $this->sendResponse([], 'Item quantity increased');
        } catch (\Exception $e) {
            return $this->sendError('Failed to increase item quantity', ['error' => $e->getMessage()], 500);
        }
    }

    // Mengurangi jumlah item
    public function reduceItemQuantity($productId)
    {
        try {
            $user_login = Auth::guard('sanctum')->user();
            $user = User::find($user_login->id);

            // Cari item di cart berdasarkan product_id
            $cartItem = CartItem::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->first();

            if (!$cartItem) {
                return $this->sendError('Item not found in cart', [], 404);
            }

            if ($cartItem->quantity > 1) {
                // Kurangi quantity jika lebih dari 1
                $cartItem->decrement('quantity');
            } else {
                // Jika quantity == 1, hapus item dari cart
                $cartItem->delete();
            }

            return $this->sendResponse([], 'Item quantity decreased');
        } catch (\Exception $e) {
            return $this->sendError('Failed to decrease item quantity', ['error' => $e->getMessage()], 500);
        }
    }

    // Menghapus item dari keranjang
    public function removeItemFromCart($productId)
    {
        try {
            $user_login = Auth::guard('sanctum')->user();
            $user = User::find($user_login->id);

            // Hapus item dari cart berdasarkan product_id
            $deleted = CartItem::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->delete();

            if (!$deleted) {
                return $this->sendError('Item not found in cart', [], 404);
            }
            return $this->sendResponse([], 'Item removed from cart');
        } catch (\Exception $e) {
            return $this->sendError('Failed to remove item from cart', ['error' => $e->getMessage()], 500);
        }
    }

    // Mengosongkan keranjang
    public function emptyCart()
    {
        try {
            $user_login = Auth::guard('sanctum')->user();
            $user = User::find($user_login->id);

            // Hapus semua item dalam cart berdasarkan user_id
            CartItem::where('user_id', $user->id)->delete();
            return $this->sendResponse([], 'Cart emptied');
        } catch (\Exception $e) {
            return $this->sendError('Failed to empty cart', ['error' => $e->getMessage()], 500);
        }
    }

    // Menerapkan kupon
    public function applyCouponCode(Request $request)
    {
        try {
            $request->validate([
                'coupon_code' => 'required|string|exists:coupons,code'
            ]);

            $user_login = Auth::guard('sanctum')->user();
            $user = User::find($user_login->id);

            // Hitung total cart dari database
            $cartSubtotal = CartItem::where('user_id', $user->id)->sum(DB::raw('quantity * price'));

            // Cari kupon dalam database dengan cart_value
            $coupon = Coupon::where('code', $request->coupon_code)
                ->where('expiry_date', '>=', Carbon::today())
                ->where('cart_value', '<=', $cartSubtotal)
                ->first();

            if (!$coupon) {
                return $this->sendError('Invalid or expired coupon, or cart value is too low');
            }

            // Simpan kupon ke dalam database (kolom `users.coupon_data`)
            $user->update([
                'coupon_data' => json_encode([
                    'code'       => $coupon->code,
                    'type'       => $coupon->type,
                    'value'      => $coupon->value,
                    'cart_value' => $coupon->cart_value,
                ])
            ]);

            return $this->sendResponse(['coupon' => $coupon], 'Coupon applied successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to apply coupon', ['error' => $e->getMessage()], 500);
        }
    }

    // Menghitung diskon setelah kupon diterapkan
    public function calculateDiscount()
    {
        try {
            $user_login = Auth::guard('sanctum')->user();
            $user = User::find($user_login->id);

            $cartSubtotal = CartItem::where('user_id', $user->id)->sum(DB::raw('quantity * price'));
            $discount = 0;

            if ($user->coupon_data) {
                $coupon = json_decode($user->coupon_data, true);

                if ($coupon['type'] == 'fixed') {
                    $discount = floatval($coupon['value']);
                } else {
                    $discount = ($cartSubtotal * floatval($coupon['value'])) / 100;
                }
            }

            $subtotalAfterDiscount = max(0, $cartSubtotal - $discount);
            $taxRate = floatval(config('cart.tax', 10)); // 10% pajak default
            $taxAfterDiscount = ($subtotalAfterDiscount * $taxRate) / 100;
            $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;

            return $this->sendResponse([
                'discount' => number_format($discount, 2, '.', ''),
                'subtotal' => number_format($subtotalAfterDiscount, 2, '.', ''),
                'tax'      => number_format($taxAfterDiscount, 2, '.', ''),
                'total'    => number_format($totalAfterDiscount, 2, '.', ''),
            ], 'Discount calculated successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to calculate discount', ['error' => $e->getMessage()], 500);
        }
    }

    // Menghapus kupon
    public function removeCouponCode()
    {
        try {
            $user_login = Auth::guard('sanctum')->user();
            $user = User::find($user_login->id);

            // Hapus kupon dari database
            $user->update(['coupon_data' => null]);

            return $this->sendResponse([], 'Coupon removed successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to remove coupon', ['error' => $e->getMessage()], 500);
        }
    }

    // Proses checkout
    public function checkout()
    {
        try {
            $user_login = Auth::guard('sanctum')->user();
            $user = User::find($user_login->id);

            $address = Address::where('user_id', $user->id)->where('isdefault', 1)->first();
            return $this->sendResponse($address, 'Checkout address retrieved');
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve checkout address', ['error' => $e->getMessage()], 500);
        }
    }

    // Proses pemesanan
    public function placeOrder(Request $request)
    {
        try {
            $user_login = Auth::guard('sanctum')->user();
            $user = User::find($user_login->id);

            $address = Address::where('user_id', $user->id)->where('isdefault', 1)->first();
            if (!$address) {
                $request->validate([
                    'name' => 'required|max:100',
                    'phone' => 'required|numeric|digits:10',
                    'zip' => 'required|numeric|digits:6',
                    'state' => 'required',
                    'city' => 'required',
                    'address' => 'required',
                    'locality' => 'required',
                    'landmark' => 'required'
                ]);

                // Simpan alamat baru jika belum ada
                $address = Address::create([
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'zip' => $request->zip,
                    'state' => $request->state,
                    'city' => $request->city,
                    'address' => $request->address,
                    'locality' => $request->locality,
                    'landmark' => $request->landmark,
                    'country' => '',
                    'isdefault' => true
                ]);
            }

            // Ambil total harga dari database
            $totals = $this->calculateOrderTotals($user->id);

            // Simpan order ke database
            $order = Order::create([
                'user_id' => $user->id,
                'subtotal' => $totals['subtotal'],
                'discount' => $totals['discount'],
                'tax' => $totals['tax'],
                'total' => $totals['total'],
                'name' => $address->name,
                'phone' => $address->phone,
                'locality' => $address->locality,
                'address' => $address->address,
                'city' => $address->city,
                'state' => $address->state,
                'country' => $address->country,
                'landmark' => $address->landmark,
                'zip' => $address->zip
            ]);

            // Simpan item ke dalam order items
            foreach (CartItem::where('user_id', $user->id)->get() as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                ]);
            }

            if ($request->mode == 'card') {
            } elseif ($request->mode == 'paypal') {
            } elseif ($request->mode == 'cod') {
                Transaction::create([
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                    'mode' => 'cod',
                    'status' => 'pending',
                ]);
            }

            // Hapus cart setelah checkout
            CartItem::where('user_id', $user->id)->delete();

            return $this->sendResponse(['order' => $order], 'Order placed successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to place order', ['error' => $e->getMessage()], 500);
        }
    }

    public function calculateOrderTotals($user_id)
    {
        try {
            $subtotal = CartItem::where('user_id', $user_id)->sum(DB::raw('quantity * price'));

            $discount = 0;
            $user = User::find($user_id);

            if ($user->coupon_data) {
                $coupon = json_decode($user->coupon_data, true);
                if ($coupon['type'] == 'fixed') {
                    $discount = floatval($coupon['value']);
                } else {
                    $discount = ($subtotal * floatval($coupon['value'])) / 100;
                }
            }

            $subtotalAfterDiscount = max(0, $subtotal - $discount);
            $taxRate = floatval(config('cart.tax', 10)); // Pajak default 10%
            $tax = ($subtotalAfterDiscount * $taxRate) / 100;
            $total = $subtotalAfterDiscount + $tax;

            return [
                'subtotal' => number_format($subtotal, 2, '.', ''),
                'discount' => number_format($discount, 2, '.', ''),
                'tax' => number_format($tax, 2, '.', ''),
                'total' => number_format($total, 2, '.', '')
            ];
        } catch (\Exception $e) {
            return [
                'subtotal' => 0,
                'discount' => 0,
                'tax' => 0,
                'total' => 0
            ];
        }
    }

    public function confirmation()
    {
        try {
            $user = Auth::guard('sanctum')->user();

            // Ambil order terakhir berdasarkan user_id
            $order = Order::where('user_id', $user->id)
                ->orderBy('created_at', 'DESC')
                ->first();

            if (!$order) {
                return $this->sendError('No recent order found', [], 404);
            }

            return $this->sendResponse($order, 'Order confirmation retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve order confirmation', ['error' => $e->getMessage()], 500);
        }
    }
}
