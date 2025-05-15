<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'no_hp',
        'no_wa',
        'lokasi',
        'estimasi_kg',
        'insentif',
        'foto',
        'catatan',
        'status',
        'kupon_id',
        'catatan_admin',
        'kecamatan',
        'desa',
        'detail_lokasi',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Kupon
    public function kupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Relasi ke jadwal penjemputan
     */
    public function penjadwalan()
    {
        return $this->hasMany(\App\Models\PenjadwalanPenjemputan::class, 'supplier_request_id');
    }
}
