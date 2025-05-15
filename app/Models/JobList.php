<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobList extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'salary',
        'salary_type',
        'duration',
        'target',
        'location',
        'image',
        'requirements',
        'benefits',
        'deadline',
        'status'
    ];

    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_id');
    }
}
