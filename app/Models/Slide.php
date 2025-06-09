<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Slide extends Model
{
    use HasFactory;

    /**
     * Table name
     */
    protected $table = 'slides';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'tagline',
        'title',
        'subtitle',
        'link',
        'image',
        'status'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Boot method untuk event handling
     */
    protected static function boot()
    {
        parent::boot();

        // Event saat slide akan dihapus
        static::deleting(function ($slide) {
            // Hapus file gambar saat record dihapus
            $imagePath = public_path('uploads/slides/' . $slide->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        });
    }

    // ====================================================================================================
    // Accessors & Mutators
    // ====================================================================================================

    /**
     * Get the formatted created date
     */
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d M Y, H:i') . ' WIB';
    }

    /**
     * Get the formatted updated date
     */
    public function getFormattedUpdatedAtAttribute()
    {
        return $this->updated_at->format('d M Y, H:i') . ' WIB';
    }

    /**
     * Get the status text
     */
    public function getStatusTextAttribute()
    {
        return $this->status ? 'Aktif' : 'Nonaktif';
    }

    /**
     * Get the status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        return $this->status ? 'status-active' : 'status-inactive';
    }

    /**
     * Get the image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('uploads/slides/' . $this->image);
        }
        return asset('images/no-image.png'); // Default image jika tidak ada
    }

    /**
     * Get truncated title
     */
    public function getTruncatedTitleAttribute($length = 50)
    {
        return \Str::limit($this->title, $length);
    }

    /**
     * Get truncated subtitle
     */
    public function getTruncatedSubtitleAttribute($length = 100)
    {
        return \Str::limit($this->subtitle, $length);
    }

    /**
     * Get truncated link for display
     */
    public function getTruncatedLinkAttribute($length = 30)
    {
        return \Str::limit($this->link, $length);
    }

    /**
     * Mutator untuk tagline - bersihkan input
     */
    public function setTaglineAttribute($value)
    {
        $this->attributes['tagline'] = trim(strip_tags($value));
    }

    /**
     * Mutator untuk title - bersihkan input
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = trim(strip_tags($value));
    }

    /**
     * Mutator untuk subtitle - bersihkan input
     */
    public function setSubtitleAttribute($value)
    {
        $this->attributes['subtitle'] = trim(strip_tags($value));
    }

    /**
     * Mutator untuk link - bersihkan input
     */
    public function setLinkAttribute($value)
    {
        $this->attributes['link'] = trim($value);
    }

    // ====================================================================================================
    // Scopes
    // ====================================================================================================

    /**
     * Scope untuk slide yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Scope untuk slide yang nonaktif
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 0);
    }

    /**
     * Scope untuk pencarian
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%')
                  ->orWhere('tagline', 'LIKE', '%' . $search . '%')
                  ->orWhere('subtitle', 'LIKE', '%' . $search . '%');
            });
        }
        return $query;
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        if ($status !== null && $status !== '') {
            return $query->where('status', $status);
        }
        return $query;
    }

    /**
     * Scope untuk slide terbaru
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', Carbon::now()->subDays($days));
    }

    /**
     * Scope untuk ordering
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // ====================================================================================================
    // Static Methods
    // ====================================================================================================

    /**
     * Get slide statistics
     */
    public static function getStatistics()
    {
        return [
            'total' => self::count(),
            'active' => self::active()->count(),
            'inactive' => self::inactive()->count(),
            'recent' => self::recent()->count()
        ];
    }

    /**
     * Get active slides for frontend
     */
    public static function getActiveSlides($limit = null)
    {
        $query = self::active()->latest();

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Create new slide
     */
    public static function createSlide($data)
    {
        return self::create([
            'tagline' => $data['tagline'],
            'title' => $data['title'],
            'subtitle' => $data['subtitle'],
            'link' => $data['link'],
            'image' => $data['image'],
            'status' => $data['status'] ?? 1
        ]);
    }

    // ====================================================================================================
    // Instance Methods
    // ====================================================================================================

    /**
     * Check if slide is active
     */
    public function isActive()
    {
        return $this->status == 1;
    }

    /**
     * Check if slide is inactive
     */
    public function isInactive()
    {
        return $this->status == 0;
    }

    /**
     * Toggle slide status
     */
    public function toggleStatus()
    {
        $this->status = !$this->status;
        return $this->save();
    }

    /**
     * Activate slide
     */
    public function activate()
    {
        $this->status = 1;
        return $this->save();
    }

    /**
     * Deactivate slide
     */
    public function deactivate()
    {
        $this->status = 0;
        return $this->save();
    }

    /**
     * Get slide for display (with fallbacks)
     */
    public function getDisplayData()
    {
        return [
            'id' => $this->id,
            'tagline' => $this->tagline ?: 'No Tagline',
            'title' => $this->title ?: 'No Title',
            'subtitle' => $this->subtitle ?: 'No Subtitle',
            'link' => $this->link ?: '#',
            'image_url' => $this->image_url,
            'status' => $this->status,
            'status_text' => $this->status_text,
            'created_at' => $this->formatted_created_at
        ];
    }

    /**
     * Validate slide data
     */
    public function validateSlideData()
    {
        $errors = [];

        if (empty($this->tagline)) {
            $errors[] = 'Tagline is required';
        }

        if (empty($this->title)) {
            $errors[] = 'Title is required';
        }

        if (empty($this->subtitle)) {
            $errors[] = 'Subtitle is required';
        }

        if (empty($this->link) || !filter_var($this->link, FILTER_VALIDATE_URL)) {
            $errors[] = 'Valid link is required';
        }

        if (empty($this->image)) {
            $errors[] = 'Image is required';
        }

        return $errors;
    }

    /**
     * Get related/similar slides (jika ada logic untuk itu)
     */
    public function getSimilarSlides($limit = 3)
    {
        return self::where('id', '!=', $this->id)
            ->active()
            ->latest()
            ->limit($limit)
            ->get();
    }

    // ====================================================================================================
    // For API Responses (jika diperlukan)
    // ====================================================================================================

    /**
     * Convert slide to API format
     */
    public function toApiArray()
    {
        return [
            'id' => $this->id,
            'tagline' => $this->tagline,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'link' => $this->link,
            'image_url' => $this->image_url,
            'status' => $this->status,
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString()
        ];
    }
}
