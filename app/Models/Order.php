<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subtotal',
        'discount',
        'total',
        'tax',
        'name',
        'phone',
        'locality',
        'address',
        'city',
        'state',
        'country',
        'zip',
        'landmark',
        'type',
        'status',
        'is_shipping_different',
        'confirmed_date',
        'processing_date',
        'shipped_date',
        'delivered_date',
        'completed_date',
        'canceled_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => '<span class="badge bg-warning">Menunggu</span>',
            'confirmed' => '<span class="badge bg-info">Dikonfirmasi</span>',
            'processing' => '<span class="badge bg-primary">Diproses</span>',
            'shipped' => '<span class="badge bg-secondary">Dikirim</span>',
            'delivered' => '<span class="badge bg-success">Paket Telah Sampai</span>',
            'completed' => '<span class="badge bg-success">Selesai</span>',
            'canceled' => '<span class="badge bg-danger">Dibatalkan</span>',
            default => '<span class="badge bg-secondary">Unknown</span>'
        };
    }
}
