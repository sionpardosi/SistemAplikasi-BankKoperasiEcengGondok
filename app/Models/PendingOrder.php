<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PendingOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'subtotal', 'discount', 'tax', 'total', 'ongkir', 'kurir',
        'name', 'phone', 'locality', 'address', 'city', 'state', 'country',
        'landmark', 'zip', 'status', 'expires_at', 'converted_to_order_id'
    ];

    protected $casts = [
        'expires_at' => 'datetime'
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

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function isExpired()
    {
        return Carbon::now()->greaterThan($this->expires_at);
    }

    public function convertToOrder()
    {
        DB::beginTransaction();
        try {
            // Buat order baru
            $order = Order::create([
                'user_id' => $this->user_id,
                'subtotal' => $this->subtotal,
                'discount' => $this->discount,
                'tax' => $this->tax,
                'total' => $this->total,
                'ongkir' => $this->ongkir,
                'kurir' => $this->kurir,
                'name' => $this->name,
                'phone' => $this->phone,
                'locality' => $this->locality,
                'address' => $this->address,
                'city' => $this->city,
                'state' => $this->state,
                'country' => $this->country,
                'landmark' => $this->landmark,
                'zip' => $this->zip,
                'status' => 'confirmed',
                'confirmed_date' => now()
            ]);

            // Pindahkan items
            foreach ($this->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'options' => $item->options
                ]);
            }

            // Update referensi
            $this->converted_to_order_id = $order->id;
            $this->status = 'converted';
            $this->save();

            // Convert reservasi menjadi pengurangan stok permanen
            foreach ($this->stockReservations()->where('status', 'active')->get() as $reservation) {
                $product = Product::lockForUpdate()->find($reservation->product_id);
                $product->quantity -= $reservation->reserved_quantity;
                $product->reserved_quantity -= $reservation->reserved_quantity;
                if ($product->reserved_quantity < 0) {
                    $product->reserved_quantity = 0;
                }
                $product->save();

                $reservation->status = 'converted';
                $reservation->save();
            }

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
