<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'no_jurnal',
        'keterangan',
        'sumber',
        'referensi_id',
        'referensi_tipe',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // ====================================================
    // Relationships
    // ====================================================

    public function lines()
    {
        return $this->hasMany(JournalEntryLine::class);
    }

    // ====================================================
    // Static Helper — Generate nomor jurnal otomatis
    // Format: JRN-YYYYMMDD-XXX
    // ====================================================

    public static function generateNoJurnal(string $tanggal): string
    {
        $prefix = 'JRN-' . Carbon::parse($tanggal)->format('Ymd') . '-';

        $last = self::where('no_jurnal', 'like', $prefix . '%')
            ->orderBy('no_jurnal', 'desc')
            ->first();

        $urutan = 1;
        if ($last) {
            $lastNo  = intval(substr($last->no_jurnal, -3));
            $urutan  = $lastNo + 1;
        }

        return $prefix . str_pad($urutan, 3, '0', STR_PAD_LEFT);
    }

    // ====================================================
    // Helper — Total debit (untuk validasi balance)
    // ====================================================

    public function getTotalDebit(): float
    {
        return floatval($this->lines->where('posisi', 'debit')->sum('jumlah'));
    }

    public function getTotalKredit(): float
    {
        return floatval($this->lines->where('posisi', 'kredit')->sum('jumlah'));
    }

    public function isBalanced(): bool
    {
        return $this->getTotalDebit() === $this->getTotalKredit();
    }
}
