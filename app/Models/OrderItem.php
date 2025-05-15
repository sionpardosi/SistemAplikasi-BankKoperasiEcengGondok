<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'order_id',
        'price',
        'quantity',
        'options',
        'rstatus'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'order_item_id');
    }

    // Check if this order item can be reviewed (order is completed and not yet reviewed)
    public function canBeReviewed()
    {
        return $this->order->status === 'completed' && !$this->review;
    }
}
