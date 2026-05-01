<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManualTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'jenis',
        'deskripsi',
        'account_id',
        'jumlah',
        'jurnal_dibuat',
    ];

    protected $casts = [
        'tanggal'       => 'date',
        'jumlah'        => 'float',
        'jurnal_dibuat' => 'boolean',
    ];

    // ====================================================
    // Relationships
    // ====================================================

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function journalEntry()
    {
        return $this->hasOne(JournalEntry::class, 'referensi_id')
                    ->where('referensi_tipe', 'manual');
    }

    // ====================================================
    // Scopes
    // ====================================================

    public function scopePendapatan($query)
    {
        return $query->where('jenis', 'pendapatan');
    }

    public function scopePengeluaran($query)
    {
        return $query->where('jenis', 'pengeluaran');
    }

    public function scopeBelumDijurnal($query)
    {
        return $query->where('jurnal_dibuat', false);
    }
}
