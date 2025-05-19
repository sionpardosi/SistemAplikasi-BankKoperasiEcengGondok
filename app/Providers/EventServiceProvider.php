<?php

namespace App\Providers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        // Handle Logout - Simpan cart dari session ke database
        Event::listen(Logout::class, function () {
            if (Auth::check()) {
                $user = Auth::user();
                foreach (Cart::instance('cart')->content() as $item) {
                    $options = $item->options ? $item->options->toArray() : null;

                    $existingItem = CartItem::where('user_id', $user->id)
                        ->where('product_id', $item->id);

                    // Jika ada options, cek size_id
                    if (isset($options['size_id'])) {
                        $existingItem = $existingItem->whereJsonContains('options->size_id', $options['size_id']);
                    } else {
                        $existingItem = $existingItem->whereNull('options');
                    }

                    $existingItem = $existingItem->first();

                    if ($existingItem) {
                        $existingItem->quantity = $item->qty;
                        $existingItem->save();
                    } else {
                        CartItem::create([
                            'user_id' => $user->id,
                            'product_id' => $item->id,
                            'name' => $item->name,
                            'quantity' => $item->qty,
                            'price' => $item->price,
                            'options' => $options
                        ]);
                    }
                }
                Cart::instance('cart')->destroy();
            }
        });

        // Handle Login - Gabungkan cart dari database dengan cart dari session
        Event::listen(Login::class, function ($event) {
            $user = $event->user;

            // Simpan cart dari session sebelumnya
            $sessionCart = [];
            if (Cart::instance('cart')->count() > 0) {
                foreach (Cart::instance('cart')->content() as $item) {
                    $sessionCart[] = [
                        'id' => $item->id,
                        'name' => $item->name,
                        'qty' => $item->qty,
                        'price' => $item->price,
                        'options' => $item->options ? $item->options->toArray() : null,
                    ];
                }
            }

            // Hapus data cart dari session sebelum load dari DB
            Cart::instance('cart')->destroy();

            // Load cart dari database
            $userCartItems = CartItem::where('user_id', $user->id)->get();
            foreach ($userCartItems as $item) {
                Cart::instance('cart')->add(
                    $item->product_id,
                    $item->name,
                    $item->quantity,
                    $item->price,
                    0,
                    $item->options
                )->associate(Product::class);
            }

            // Gabungkan dengan cart dari session, hindari duplikasi
            if (!empty($sessionCart)) {
                foreach ($sessionCart as $item) {
                    $existingCartItem = Cart::instance('cart')->content()->first(function ($cartItem) use ($item) {
                        $sameProduct = $cartItem->id == $item['id'];
                        $sameSize = true;

                        // Periksa jika size_id sama
                        if (isset($item['options']['size_id'])) {
                            $sameSize = isset($cartItem->options['size_id']) &&
                                        $cartItem->options['size_id'] == $item['options']['size_id'];
                        } else {
                            $sameSize = !isset($cartItem->options['size_id']);
                        }

                        return $sameProduct && $sameSize;
                    });

                    if ($existingCartItem) {
                        // Update quantity jika sudah ada
                        Cart::instance('cart')->update(
                            $existingCartItem->rowId,
                            $existingCartItem->qty + $item['qty']
                        );
                    } else {
                        // Tambahkan item baru
                        Cart::instance('cart')->add(
                            $item['id'],
                            $item['name'],
                            $item['qty'],
                            $item['price'],
                            0,
                            $item['options']
                        )->associate(Product::class);
                    }

                    // Simpan juga ke database
                    $options = $item['options'];
                    $dbCartItem = CartItem::where('user_id', $user->id)
                        ->where('product_id', $item['id']);

                    // Jika ada options, cek size_id
                    if (isset($options['size_id'])) {
                        $dbCartItem = $dbCartItem->whereJsonContains('options->size_id', $options['size_id']);
                    } else {
                        $dbCartItem = $dbCartItem->whereNull('options');
                    }

                    $dbCartItem = $dbCartItem->first();

                    if ($dbCartItem) {
                        $dbCartItem->quantity += $item['qty'];
                        $dbCartItem->save();
                    } else {
                        CartItem::create([
                            'user_id' => $user->id,
                            'product_id' => $item['id'],
                            'name' => $item['name'],
                            'quantity' => $item['qty'],
                            'price' => $item['price'],
                            'options' => $options
                        ]);
                    }
                }
            }

            // Tambahkan redirect ke halaman keranjang
            if (!empty($sessionCart)) {
                Session::put('redirect_after_login', route('cart.index'));
            }
        });
    }
}
