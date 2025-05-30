<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendingOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'pending_order_id', 'product_id', 'price', 'quantity', 'options'
    ];

    protected $casts = [
        'options' => 'array'
    ];

    public function pendingOrder()
    {
        return $this->belongsTo(PendingOrder::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
