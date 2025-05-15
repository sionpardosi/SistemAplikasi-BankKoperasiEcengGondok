<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'brand_id',
        'short_description',
        'description',
        'regular_price',
        'sale_price',
        'SKU',
        'stock_status',
        'featured',
        'quantity',
        'reserved_quantity',
        'image',
        'images',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class)->withPivot('stock')->withTimestamps();
    }

    // Di dalam class Product
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
