<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class StockReservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'pending_order_id', 'reserved_quantity',
        'expires_at', 'status'
    ];

    protected $casts = [
        'expires_at' => 'datetime'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function pendingOrder()
    {
        return $this->belongsTo(PendingOrder::class);
    }

    public function release()
    {
        DB::beginTransaction();
        try {
            $product = Product::lockForUpdate()->find($this->product_id);
            $product->reserved_quantity -= $this->reserved_quantity;
            if ($product->reserved_quantity < 0) {
                $product->reserved_quantity = 0;
            }
            $product->save();

            $this->status = 'released';
            $this->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
