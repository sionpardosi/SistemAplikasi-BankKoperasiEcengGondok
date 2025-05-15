<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishlistItem extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'name', 'quantity', 'price'];
    protected $hidden = ['user_id', 'created_at', 'updated_at'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
