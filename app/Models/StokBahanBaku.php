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
}
