<?php

namespace App\Models;

use App\Models\RelatedVideo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'video_type',
        'video_url',
        'video_caption',
        'video_thumbnail',
        'video_duration',
        'order',
        'is_active',
    ];

    /**
     * Determine if this entry has a video
     *
     * @return bool
     */
    public function hasVideo()
    {
        return !empty($this->video_url) && !empty($this->video_type);
    }

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
     * Relation to related videos
     */
    public function relatedVideos()
    {
        return $this->hasMany(RelatedVideo::class);
    }
}
