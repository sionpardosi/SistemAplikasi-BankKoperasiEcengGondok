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

    public function getStatusBadgeAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return '<span class="badge bg-warning">Menunggu</span>';
            case 'disetujui':
                return '<span class="badge bg-success">Disetujui</span>';
            case 'ditolak':
                return '<span class="badge bg-danger">Ditolak</span>';
            default:
                return '<span class="badge bg-secondary">' . ucfirst($this->status) . '</span>';
        }
    }

    public function getInsentifTextAttribute()
    {
        return $this->insentif == 'diskon' ? 'Diskon Produk' : 'Uang Tunai';
    }

    public function getLokasiLengkapAttribute()
    {
        $lokasi = [];

        if ($this->kecamatan) {
            $lokasi[] = "Kec. {$this->kecamatan}";
        }

        if ($this->desa) {
            $lokasi[] = "Desa {$this->desa}";
        }

        if ($this->detail_lokasi) {
            $lokasi[] = $this->detail_lokasi;
        }

        return implode(', ', $lokasi) ?: ($this->lokasi ?? '-');
    }

    public function getPerkiraaanInsentifAttribute()
    {
        if ($this->insentif == 'uang_tunai') {
            return $this->estimasi_kg * 60000;
        }

        return 0;
    }

    public function getFormattedPerkiraaanInsentifAttribute()
    {
        if ($this->insentif == 'uang_tunai') {
            return 'Rp ' . number_format($this->perkiraan_insentif, 0, ',', '.');
        }

        return '-';
    }
}
