<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    // Daftar kolom yang boleh di-mass-assignment
    protected $fillable = [
        'name',
        'email',
        'phone',
        'comment',
    ];
}
