<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'discount_amount',
        'minimum_order',
        'expiry_date',
        'is_active'
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'is_active' => 'boolean'
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
}
