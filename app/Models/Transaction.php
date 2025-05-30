<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'pending_order_id', // TAMBAHKAN INI
        'invoice',
        'mode',
        'bank_code',
        'payment_proof',
        'status',
        'snap_token',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'approved', 'paid' => '<span class="badge bg-success">Dibayar</span>',
            'pending' => '<span class="badge bg-warning">Menunggu</span>',
            'declined' => '<span class="badge bg-danger">Ditolak</span>',
            'refunded' => '<span class="badge bg-secondary">Dikembalikan</span>',
            default => '<span class="badge bg-secondary">Unknown</span>'
        };
    }

    public function getModeDisplayAttribute()
    {
        return match ($this->mode) {
            'card' => 'E-Wallet | Pembayaran Online',
            'Transfer Bank' => 'Transfer Bank | Manual',
            default => $this->mode
        };
    }

    public function getBankNameAttribute()
    {
        return match ($this->bank_code) {
            'bri' => 'Bank BRI',
            'bni' => 'Bank BNI',
            default => $this->bank_code
        };
    }

    public function pendingOrder()
    {
        return $this->belongsTo(PendingOrder::class);
    }
}
