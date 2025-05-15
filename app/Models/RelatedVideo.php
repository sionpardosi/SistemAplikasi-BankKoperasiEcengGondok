<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelatedVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'video_type',
        'video_url',
        'thumbnail',
        'order',
        'is_active',
    ];

    /**
     * Get the instagram video ID from a full URL
     *
     * @return string|null
     */
    public function getInstagramVideoId()
    {
        if ($this->video_type !== 'instagram' || empty($this->video_url)) {
            return null;
        }

        // Extract the ID from typical Instagram URL formats
        preg_match('/instagram.com\/(?:p|reel)\/([^\/\?]+)/', $this->video_url, $matches);
        return $matches[1] ?? null;
    }

    /**
     * Relation to supplier info
     */
    public function supplierInfo()
    {
        return $this->belongsTo(SupplierInfo::class);
    }
}
