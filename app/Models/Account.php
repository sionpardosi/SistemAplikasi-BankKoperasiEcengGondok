<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'tipe',
        'saldo_normal',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ====================================================
    // Relationships
    // ====================================================

    public function journalLines()
    {
        return $this->hasMany(JournalEntryLine::class);
    }

    public function manualTransactions()
    {
        return $this->hasMany(ManualTransaction::class);
    }

    // ====================================================
    // Scopes
    // ====================================================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByTipe($query, string $tipe)
    {
        return $query->where('tipe', $tipe);
    }

    // ====================================================
    // Helpers — Hitung saldo akun dari jurnal
    // ====================================================

    /**
     * Hitung saldo bersih akun ini dari semua journal_entry_lines.
     * Saldo = total debit - total kredit (untuk akun saldo normal debit)
     *         total kredit - total debit (untuk akun saldo normal kredit)
     */
    public function getSaldo(?string $dari = null, ?string $sampai = null): float
    {
        $query = $this->journalLines();

        if ($dari && $sampai) {
            $query->whereHas('journalEntry', function ($q) use ($dari, $sampai) {
                $q->whereBetween('tanggal', [$dari, $sampai]);
            });
        }

        $totalDebit  = (clone $query)->where('posisi', 'debit')->sum('jumlah');
        $totalKredit = (clone $query)->where('posisi', 'kredit')->sum('jumlah');

        if ($this->saldo_normal === 'debit') {
            return floatval($totalDebit - $totalKredit);
        }

        return floatval($totalKredit - $totalDebit);
    }
}
