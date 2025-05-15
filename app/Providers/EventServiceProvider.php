<?php

namespace App\Providers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Auth;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();
        Event::listen(Logout::class, function () {
            if (Auth::check()) {
                $user = Auth::user();
                foreach (Cart::instance('cart')->content() as $item) {
                    $existingItem = CartItem::where('user_id', $user->id)
                        ->where('product_id', $item->id)
                        ->first();

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
                        ]);
                    }
                }
                Cart::instance('cart')->destroy();
            }
        });

        Event::listen(Login::class, function ($event) {
            $user = $event->user;

            // Hapus data cart dari session sebelum load dari DB
            Cart::instance('cart')->destroy();

            $userCartItems = CartItem::where('user_id', $user->id)->get();

            foreach ($userCartItems as $item) {
                Cart::instance('cart')->add(
                    $item->product_id,
                    $item->name,
                    $item->quantity,
                    $item->price
                )
                    ->associate(Product::class);
            }
        });
    }
}
