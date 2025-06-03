<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; // Optional: jika ingin implementasi soft delete penuh

class Product extends Model
{
    use HasFactory;
    // use SoftDeletes; // Uncomment jika ingin menggunakan soft delete Laravel

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
        'is_active', // Tambah field ini untuk status aktif/nonaktif
    ];

    protected $casts = [
        'featured' => 'boolean',
        'is_active' => 'boolean', // Jika menggunakan field is_active
        'regular_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
    ];

    // ====================================================================================================
    // Relationships
    // ====================================================================================================

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

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class); // Jika ada model OrderItem
    }

    // ====================================================================================================
    // Scopes untuk Query yang Sering Digunakan
    // ====================================================================================================

    /**
     * Scope untuk produk aktif
     */
    public function scopeActive($query)
    {
        return $query->where('quantity', '>', 0)->where('stock_status', 'instock');
    }

    /**
     * Scope untuk produk unggulan
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope untuk produk dengan stok habis
     */
    public function scopeOutOfStock($query)
    {
        return $query->where('stock_status', 'outofstock')->orWhere('quantity', 0);
    }

    /**
     * Scope untuk produk dengan stok rendah (kurang dari 10)
     */
    public function scopeLowStock($query)
    {
        return $query->where('quantity', '>', 0)->where('quantity', '<', 10);
    }

    /**
     * Scope untuk pencarian produk
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'LIKE', "%{$term}%")
                ->orWhere('SKU', 'LIKE', "%{$term}%")
                ->orWhere('description', 'LIKE', "%{$term}%");
        });
    }

    // ====================================================================================================
    // Accessor & Mutator
    // ====================================================================================================

    /**
     * Get formatted regular price
     */
    public function getFormattedRegularPriceAttribute()
    {
        return formatRupiah($this->regular_price);
    }

    /**
     * Get formatted sale price
     */
    public function getFormattedSalePriceAttribute()
    {
        return formatRupiah($this->sale_price);
    }

    /**
     * Get discount percentage
     */
    public function getDiscountPercentageAttribute()
    {
        if ($this->regular_price > $this->sale_price) {
            return round((($this->regular_price - $this->sale_price) / $this->regular_price) * 100);
        }
        return 0;
    }

    /**
     * Get stock status badge class
     */
    public function getStockStatusBadgeAttribute()
    {
        switch ($this->stock_status) {
            case 'instock':
                return 'badge-success';
            case 'outofstock':
                return 'badge-danger';
            default:
                return 'badge-secondary';
        }
    }

    /**
     * Get stock level indicator
     */
    public function getStockLevelAttribute()
    {
        if ($this->quantity == 0) return 'out';
        if ($this->quantity < 10) return 'low';
        return 'good';
    }

    /**
     * Get average rating
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Get total reviews count
     */
    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->count();
    }

    /**
     * Get total sold quantity (jika ada order system)
     */
    public function getTotalSoldAttribute()
    {
        // return $this->orderItems()->sum('quantity'); // Uncomment jika ada OrderItem model
        return 0; // Placeholder
    }

    /**
     * Check if product has discount
     */
    public function getHasDiscountAttribute()
    {
        return $this->regular_price > $this->sale_price;
    }

    /**
     * Get main image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('uploads/products/' . $this->image);
        }
        return asset('assets/images/default-product.jpg'); // Default image
    }

    /**
     * Get thumbnail image URL
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->image) {
            return asset('uploads/products/thumbnails/' . $this->image);
        }
        return asset('assets/images/default-product-thumb.jpg'); // Default thumbnail
    }

    // ====================================================================================================
    // Static Methods untuk Statistik Dashboard
    // ====================================================================================================

    /**
     * Get total active products
     */
    public static function getTotalActive()
    {
        return self::active()->count();
    }

    /**
     * Get total featured products
     */
    public static function getTotalFeatured()
    {
        return self::featured()->count();
    }

    /**
     * Get total out of stock products
     */
    public static function getTotalOutOfStock()
    {
        return self::outOfStock()->count();
    }

    /**
     * Get total low stock products
     */
    public static function getTotalLowStock()
    {
        return self::lowStock()->count();
    }

    /**
     * Get products with lowest stock
     */
    public static function getLowestStock($limit = 5)
    {
        return self::where('quantity', '>', 0)
            ->orderBy('quantity', 'asc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get best selling products (jika ada order system)
     */
    public static function getBestSelling($limit = 5)
    {
        // return self::withCount('orderItems')
        //            ->orderBy('order_items_count', 'desc')
        //            ->limit($limit)
        //            ->get();

        // Placeholder untuk sekarang
        return self::featured()->limit($limit)->get();
    }

    /**
     * Get recently added products
     */
    public static function getRecentlyAdded($limit = 5)
    {
        return self::orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    // ====================================================================================================
    // Helper Methods
    // ====================================================================================================

    /**
     * Check if product can be deleted
     */
    public function canBeDeleted()
    {
        // Check if product has orders or other dependencies
        // return $this->orderItems()->count() == 0;
        return true; // Placeholder
    }

    /**
     * Soft deactivate product
     */
    public function deactivate()
    {
        $this->update([
            'quantity' => 0,
            'stock_status' => 'outofstock'
        ]);
    }

    /**
     * Activate product
     */
    public function activate($quantity = 1)
    {
        $this->update([
            'quantity' => $quantity,
            'stock_status' => 'instock'
        ]);
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured()
    {
        $this->update(['featured' => !$this->featured]);
    }

    /**
     * Get available stock for specific size
     */
    public function getAvailableStockForSize($sizeId = null)
    {
        if ($sizeId) {
            $sizeStock = $this->sizes()->where('size_id', $sizeId)->first();
            return $sizeStock ? $sizeStock->pivot->stock : 0;
        }

        return $this->quantity - $this->reserved_quantity;
    }

    /**
     * Get total available stock (considering all sizes or general stock)
     */
    public function getTotalAvailableStock()
    {
        if ($this->sizes->count() > 0) {
            return $this->sizes->sum('pivot.stock');
        }

        return $this->quantity - $this->reserved_quantity;
    }
}
