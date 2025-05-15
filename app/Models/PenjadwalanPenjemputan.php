<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenjadwalanPenjemputan extends Model
{
    protected $fillable = [
        'supplier_request_id',
        'tanggal_jemput',
        'lokasi',
        'estimasi_kg',
        'status_jemput',
        'kecamatan',
        'desa',
        'detail_lokasi',
    ];

    public function request()
    {
        return $this->belongsTo(SupplierRequest::class, 'supplier_request_id');
    }
}
