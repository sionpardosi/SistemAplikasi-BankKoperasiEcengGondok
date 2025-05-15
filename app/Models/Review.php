<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_item_id',
        'product_id',
        'rating',
        'comment',
        'status' // pending, approved, rejected
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function reviewMedia()
    {
        return $this->hasMany(ReviewMedia::class);
    }
}
