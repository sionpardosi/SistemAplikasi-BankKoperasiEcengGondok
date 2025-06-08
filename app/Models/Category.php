<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'parent_id',
        'description',
        'meta_title',
        'sort_order',
        'is_featured',
        'is_active'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
        'is_active' => 'boolean'
    ];

    // TAMBAHKAN scope baru di akhir class Category (sebelum closing brace)
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    // TAMBAHKAN method untuk toggle active status
    public function toggleActive()
    {
        $this->update(['is_active' => !$this->is_active]);
        return $this->is_active;
    }

    // TAMBAHKAN accessor untuk status text
    public function getStatusTextAttribute()
    {
        return $this->is_active ? 'Aktif' : 'Nonaktif';
    }

    public function getStatusBadgeClassAttribute()
    {
        return $this->is_active ? 'bg-success' : 'bg-secondary';
    }

    // ====================================================================================================
    // Relationships
    // ====================================================================================================

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // ====================================================================================================
    // Scopes untuk Query yang Sering Digunakan
    // ====================================================================================================

    /**
     * Scope untuk kategori unggulan
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope untuk kategori dengan produk
     */
    public function scopeWithProducts($query)
    {
        return $query->whereHas('products');
    }

    /**
     * Scope untuk kategori kosong (tanpa produk)
     */
    public function scopeEmpty($query)
    {
        return $query->whereDoesntHave('products');
    }

    /**
     * Scope untuk kategori parent (tidak memiliki parent)
     */
    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope untuk kategori child (memiliki parent)
     */
    public function scopeChild($query)
    {
        return $query->whereNotNull('parent_id');
    }

    /**
     * Scope untuk pencarian kategori
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'LIKE', "%{$term}%")
                ->orWhere('slug', 'LIKE', "%{$term}%")
                ->orWhere('description', 'LIKE', "%{$term}%");
        });
    }

    /**
     * Scope untuk urutan tampil
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
    }

    // ====================================================================================================
    // Accessor & Mutator
    // ====================================================================================================

    /**
     * Get image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('uploads/categories/' . $this->image);
        }
        return asset('assets/images/default-category.jpg'); // Default image
    }

    /**
     * Get meta title (fallback to name if empty)
     */
    public function getMetaTitleAttribute($value)
    {
        return $value ?: $this->name;
    }

    /**
     * Get formatted creation date
     */
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d M Y, H:i') . ' WIB';
    }

    /**
     * Get formatted update date
     */
    public function getFormattedUpdatedAtAttribute()
    {
        return $this->updated_at->format('d M Y, H:i') . ' WIB';
    }

    /**
     * Get total active products
     */
    public function getActiveProductsCountAttribute()
    {
        return $this->products()->where('stock_status', 'instock')->count();
    }

    /**
     * Get total product value in this category
     */
    public function getTotalProductValueAttribute()
    {
        return $this->products()->sum('regular_price');
    }

    /**
     * Check if category has products
     */
    public function getHasProductsAttribute()
    {
        return $this->products()->count() > 0;
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute()
    {
        if ($this->products()->count() > 0) {
            return 'badge-success';
        }
        return 'badge-secondary';
    }

    /**
     * Get status text
     */
    // public function getStatusTextAttribute()
    // {
    //     if ($this->products()->count() > 0) {
    //         return 'Aktif';
    //     }
    //     return 'Kosong';
    // }

    // ====================================================================================================
    // Static Methods untuk Statistik Dashboard
    // ====================================================================================================

    /**
     * Get total categories
     */
    public static function getTotalCategories()
    {
        return self::count();
    }

    /**
     * Get total featured categories
     */
    public static function getTotalFeatured()
    {
        return self::featured()->count();
    }

    /**
     * Get total categories with products
     */
    public static function getTotalWithProducts()
    {
        return self::withProducts()->count();
    }

    /**
     * Get total empty categories
     */
    public static function getTotalEmpty()
    {
        return self::empty()->count();
    }

    /**
     * Get categories with most products
     */
    public static function getMostProductive($limit = 5)
    {
        return self::withCount('products')
            ->orderBy('products_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get recently added categories
     */
    public static function getRecentlyAdded($limit = 5)
    {
        return self::orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get featured categories for homepage
     */
    public static function getFeaturedForHomepage($limit = 8)
    {
        return self::featured()
            ->withProducts()
            ->ordered()
            ->limit($limit)
            ->get();
    }

    // ====================================================================================================
    // Helper Methods
    // ====================================================================================================

    /**
     * Check if category can be deleted
     */
    public function canBeDeleted()
    {
        // Category can be deleted if it has no products and no child categories
        return $this->products()->count() == 0 && $this->children()->count() == 0;
    }

    /**
     * Get all products recursively (including from child categories)
     */
    public function getAllProducts()
    {
        $products = $this->products;

        foreach ($this->children as $child) {
            $products = $products->merge($child->getAllProducts());
        }

        return $products;
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured()
    {
        $this->update(['is_featured' => !$this->is_featured]);
        return $this->is_featured;
    }

    /**
     * Move category to specific position
     */
    public function moveTo($position)
    {
        $this->update(['sort_order' => $position]);
        return $this;
    }

    /**
     * Get category breadcrumb
     */
    public function getBreadcrumb()
    {
        $breadcrumb = collect([$this]);

        $parent = $this->parent;
        while ($parent) {
            $breadcrumb->prepend($parent);
            $parent = $parent->parent;
        }

        return $breadcrumb;
    }

    /**
     * Get category tree (for dropdown/select)
     */
    public static function getTree($parentId = null, $prefix = '')
    {
        $categories = collect();

        $items = self::where('parent_id', $parentId)
            ->ordered()
            ->get();

        foreach ($items as $item) {
            $item->display_name = $prefix . $item->name;
            $categories->push($item);

            $children = self::getTree($item->id, $prefix . '-- ');
            $categories = $categories->merge($children);
        }

        return $categories;
    }

    /**
     * Generate unique slug
     */
    public static function generateUniqueSlug($name, $id = null)
    {
        $slug = \Illuminate\Support\Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (true) {
            $query = self::where('slug', $slug);
            if ($id) {
                $query->where('id', '!=', $id);
            }

            if (!$query->exists()) {
                break;
            }

            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Boot method for model events
     */
    protected static function boot()
    {
        parent::boot();

        // Auto generate slug if not provided
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = \Illuminate\Support\Str::slug($category->name);
            }

            // Set default is_active = true untuk kategori baru
            if (is_null($category->is_active)) {
                $category->is_active = true;
            }
        });
    }
}
