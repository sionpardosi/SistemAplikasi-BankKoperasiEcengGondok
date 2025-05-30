<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

class PendingOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'shipping_cost',
        'payment_method',
        'shipping_address',
        'expires_at',
        'status'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'total_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(PendingOrderItem::class);
    }

    public function stockReservations()
    {
        return $this->hasMany(StockReservation::class);
    }

    public function isExpired()
    {
        return $this->expires_at < now();
    }

    public function convertToOrder()
    {
        DB::beginTransaction();
        try {
            // Buat order baru
            $order = Order::create([
                'user_id' => $this->user_id,
                'order_number' => str_replace('PO-', 'ORD-', $this->order_number),
                'total_amount' => $this->total_amount,
                'shipping_cost' => $this->shipping_cost,
                'payment_method' => $this->payment_method,
                'shipping_address' => $this->shipping_address,
                'status' => 'pending' // Status awal setelah pembayaran
            ]);

            // Transfer items
            foreach ($this->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price
                ]);

                // Kurangi stok permanen
                $product = Product::find($item->product_id);
                $product->decrement('stock', $item->quantity);
                $product->decrement('reserved_stock', $item->quantity);
            }

            // Hapus reservasi
            $this->stockReservations()->delete();

            // Hapus pending order
            $this->delete();

            DB::commit();
            return $order;

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
