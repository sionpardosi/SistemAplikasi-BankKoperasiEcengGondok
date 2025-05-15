<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class About extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'story',
        'vision',
        'mission',
        'founder',
        'established_date',
        'address',
        'contact_info',
        'map_embed',
        'image1',
        'image1_caption',
        'image1_alt',
        'image2',
        'image2_caption',
        'image2_alt',
        'is_active',
    ];

    // Otomatis generate slug dari title
    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            if (empty($model->slug) && !empty($model->title)) {
                $model->slug = Str::slug($model->title);
            }
        });
    }
}
