<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'job_id',
        'user_id',
        'name',           // Tambahkan
        'email',          // Tambahkan
        'cv',
        'image',
        'cover_letter',
        'phone_number',
        'whatsapp_number', // Tambahkan
        'gender',         // Tambahkan
        'education_level',
        'experience',
        'expected_salary',
        'skills',
        'additional_info',
        'status',
    ];

    /**
     * Get the job that this application belongs to.
     */
    public function job()
    {
        return $this->belongsTo(JobList::class, 'job_id');
    }

    /**
     * Get the user that submitted this application.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
