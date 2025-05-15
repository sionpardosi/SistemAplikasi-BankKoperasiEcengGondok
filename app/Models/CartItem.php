<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'user_cart_items';

    protected $fillable = ['user_id', 'product_id', 'name', 'quantity', 'price', 'options'];

    protected $casts = [
        'options' => 'array'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Mendapatkan informasi ukuran produk
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|null
     */
    public function size()
    {
        if (isset($this->options['size_id'])) {
            return Size::find($this->options['size_id']);
        }

        return null;
    }
}
