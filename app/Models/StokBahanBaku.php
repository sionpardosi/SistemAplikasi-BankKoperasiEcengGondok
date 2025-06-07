<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokBahanBaku extends Model
{
    protected $fillable = [
        'tanggal',
        'jumlah_kg',
        'sumber',
        'request_id',
        'keterangan'
    ];

    public function request()
    {
        return $this->belongsTo(SupplierRequest::class);
    }

    // Tambahkan method helper
    public function getJenisTransaksiAttribute()
    {
        if ($this->jumlah_kg > 0) {
            return 'Masuk';
        } else {
            return 'Keluar';
        }
    }

    public function getJumlahAbsAttribute()
    {
        return abs($this->jumlah_kg);
    }

    public function getWarnaTransaksiAttribute()
    {
        return $this->jumlah_kg > 0 ? 'success' : 'danger';
    }

    // Scope untuk filter
    public function scopeMasuk($query)
    {
        return $query->where('jumlah_kg', '>', 0);
    }

    public function scopeKeluar($query)
    {
        return $query->where('jumlah_kg', '<', 0);
    }
}
