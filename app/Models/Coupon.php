<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    // Tambahkan di app/Models/Coupon.php
    protected $fillable = [
        'code',
        'discount_amount',
        'minimum_order',
        'expiry_date',
        'is_active',
        'usage_count',
        'usage_limit',
        'per_customer_limit'  // Tambahan
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'is_active' => 'boolean',
        'usage_log' => 'array'  // Tambahan
    ];

    protected $hidden = ['created_at', 'updated_at'];

    // Scope untuk kupon yang masih aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('expiry_date', '>=', Carbon::today());
    }

    // Check apakah kupon masih valid
    public function isValid()
    {
        return $this->is_active && $this->expiry_date >= Carbon::today();
    }

    // Check apakah order memenuhi minimum
    public function isEligibleForOrder($orderAmount)
    {
        return $orderAmount >= $this->minimum_order;
    }

    public function getStatusBadgeAttribute()
    {
        if (!$this->is_active) {
            return '<span class="badge bg-secondary">Tidak Aktif</span>';
        }

        if ($this->expiry_date < now()) {
            return '<span class="badge bg-danger">Expired</span>';
        }

        return '<span class="badge bg-success">Aktif</span>';
    }

    public function getFormattedDiscountAttribute()
    {
        return 'Rp ' . number_format($this->discount_amount, 0, ',', '.');
    }

    public function getFormattedMinimumOrderAttribute()
    {
        return 'Rp ' . number_format($this->minimum_order, 0, ',', '.');
    }
}
