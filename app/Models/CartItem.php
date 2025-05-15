<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'user_cart_items';

    protected $fillable = ['user_id', 'product_id', 'name', 'quantity', 'price'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
