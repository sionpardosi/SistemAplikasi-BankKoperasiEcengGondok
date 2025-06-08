<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
        'is_featured',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    // ====================================================================================================
    // Relationships
    // ====================================================================================================

    /**
     * Get all products for this brand
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get active products for this brand
     */
    public function activeProducts()
    {
        return $this->hasMany(Product::class)->where('is_active', true);
    }

    /**
     * Get featured products for this brand
     */
    public function featuredProducts()
    {
        return $this->hasMany(Product::class)->where('featured', true);
    }

    // ====================================================================================================
    // Scopes
    // ====================================================================================================

    /**
     * Scope a query to only include active brands
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured brands
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to search brands by name or slug
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('name', 'LIKE', "%{$term}%")
              ->orWhere('slug', 'LIKE', "%{$term}%");
        });
    }

    /**
     * Scope a query to include brands with products
     */
    public function scopeWithProducts($query)
    {
        return $query->has('products');
    }

    /**
     * Scope a query to include brands without products
     */
    public function scopeWithoutProducts($query)
    {
        return $query->doesntHave('products');
    }

    // ====================================================================================================
    // Accessors & Mutators
    // ====================================================================================================

    /**
     * Get the brand's image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('uploads/brands/' . $this->image);
        }
        return asset('assets/images/default-brand.png');
    }

    /**
     * Get the brand's thumbnail URL
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->image) {
            return asset('uploads/brands/thumbnails/' . $this->image);
        }
        return asset('assets/images/default-brand-thumb.png');
    }

    /**
     * Get the brand's status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        return $this->is_active ? 'badge-success' : 'badge-danger';
    }

    /**
     * Get the brand's status text
     */
    public function getStatusTextAttribute()
    {
        return $this->is_active ? 'Aktif' : 'Nonaktif';
    }

    /**
     * Get the brand's featured status text
     */
    public function getFeaturedTextAttribute()
    {
        return $this->is_featured ? 'Ya' : 'Tidak';
    }

    /**
     * Get formatted created date
     */
    public function getFormattedCreatedDateAttribute()
    {
        return $this->created_at->format('d M Y, H:i') . ' WIB';
    }

    /**
     * Get formatted updated date
     */
    public function getFormattedUpdatedDateAttribute()
    {
        return $this->updated_at->format('d M Y, H:i') . ' WIB';
    }

    /**
     * Get total active products count
     */
    public function getActiveProductsCountAttribute()
    {
        return $this->activeProducts()->count();
    }

    /**
     * Get total featured products count
     */
    public function getFeaturedProductsCountAttribute()
    {
        return $this->featuredProducts()->count();
    }

    /**
     * Get brand description excerpt
     */
    public function getDescriptionExcerptAttribute()
    {
        if (!$this->description) {
            return null;
        }

        return strlen($this->description) > 100
            ? substr($this->description, 0, 100) . '...'
            : $this->description;
    }

    // ====================================================================================================
    // Static Methods
    // ====================================================================================================

    /**
     * Get total active brands count
     */
    public static function getTotalActive()
    {
        return self::active()->count();
    }

    /**
     * Get total featured brands count
     */
    public static function getTotalFeatured()
    {
        return self::featured()->count();
    }

    /**
     * Get brands with most products
     */
    public static function getMostProductsBrands($limit = 5)
    {
        return self::withCount('products')
            ->orderBy('products_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get recently added brands
     */
    public static function getRecentBrands($limit = 5)
    {
        return self::latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get featured brands
     */
    public static function getFeaturedBrands($limit = null)
    {
        $query = self::featured()->active();

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Get popular brands (brands with most active products)
     */
    public static function getPopularBrands($limit = 10)
    {
        return self::active()
            ->withCount(['activeProducts'])
            ->orderBy('active_products_count', 'desc')
            ->limit($limit)
            ->get();
    }

    // ====================================================================================================
    // Helper Methods
    // ====================================================================================================

    /**
     * Check if brand can be deleted
     */
    public function canBeDeleted()
    {
        return $this->products()->count() === 0;
    }

    /**
     * Toggle brand status
     */
    public function toggleStatus()
    {
        $this->is_active = !$this->is_active;
        return $this->save();
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured()
    {
        $this->is_featured = !$this->is_featured;
        return $this->save();
    }

    /**
     * Activate brand
     */
    public function activate()
    {
        $this->is_active = true;
        return $this->save();
    }

    /**
     * Deactivate brand
     */
    public function deactivate()
    {
        $this->is_active = false;
        return $this->save();
    }

    /**
     * Set as featured
     */
    public function setFeatured()
    {
        $this->is_featured = true;
        return $this->save();
    }

    /**
     * Remove from featured
     */
    public function removeFeatured()
    {
        $this->is_featured = false;
        return $this->save();
    }

    /**
     * Get brand statistics
     */
    public function getStatistics()
    {
        return [
            'total_products' => $this->products()->count(),
            'active_products' => $this->activeProducts()->count(),
            'featured_products' => $this->featuredProducts()->count(),
            'created_days_ago' => $this->created_at->diffInDays(now()),
            'last_updated_days_ago' => $this->updated_at->diffInDays(now()),
        ];
    }

    /**
     * Search brands with advanced filters
     */
    public static function advancedSearch($filters = [])
    {
        $query = self::query();

        // Search by name or slug
        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        // Filter by status
        if (isset($filters['status'])) {
            if ($filters['status'] === 'active') {
                $query->active();
            } elseif ($filters['status'] === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Filter by featured
        if (isset($filters['featured'])) {
            if ($filters['featured'] === 'yes') {
                $query->featured();
            } elseif ($filters['featured'] === 'no') {
                $query->where('is_featured', false);
            }
        }

        // Filter by product count
        if (!empty($filters['has_products'])) {
            if ($filters['has_products'] === 'yes') {
                $query->withProducts();
            } elseif ($filters['has_products'] === 'no') {
                $query->withoutProducts();
            }
        }

        // Date range filter
        if (!empty($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to']);
        }

        // Sorting
        if (!empty($filters['sort'])) {
            switch ($filters['sort']) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                case 'most_products':
                    $query->withCount('products')->orderBy('products_count', 'desc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        return $query;
    }

    // ====================================================================================================
    // Boot Method
    // ====================================================================================================

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-set default values
        static::creating(function ($brand) {
            if (!isset($brand->is_active)) {
                $brand->is_active = true;
            }
            if (!isset($brand->is_featured)) {
                $brand->is_featured = false;
            }
        });

        // Clean up when deleting
        static::deleting(function ($brand) {
            // Delete associated image file
            if ($brand->image) {
                $imagePath = public_path('uploads/brands/' . $brand->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        });
    }
}
