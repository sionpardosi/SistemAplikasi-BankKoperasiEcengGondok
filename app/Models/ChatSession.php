<?php

namespace App\Models;

use App\Models\ChatMessage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'status',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
