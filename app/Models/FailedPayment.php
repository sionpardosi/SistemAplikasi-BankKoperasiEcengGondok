<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailedPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'pending_order_id',
        'midtrans_order_id',
        'failure_reason',
        'failed_at'
    ];

    protected $casts = [
        'failed_at' => 'datetime'
    ];

    public function pendingOrder()
    {
        return $this->belongsTo(PendingOrder::class);
    }
}
