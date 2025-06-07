<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class PenjadwalanPenjemputan extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_request_id',
        'tanggal_jemput',
        'lokasi', // Keep for backward compatibility
        'estimasi_kg',
        'status_jemput',
        'kecamatan',
        'desa',
        'detail_lokasi',
    ];

    protected $casts = [
        'tanggal_jemput' => 'date',
        'estimasi_kg' => 'decimal:2',
    ];

    protected $dates = [
        'tanggal_jemput',
        'created_at',
        'updated_at',
    ];

    /**
     * Relationship with SupplierRequest
     */
    public function request()
    {
        return $this->belongsTo(SupplierRequest::class, 'supplier_request_id');
    }

    /**
     * Get the full location string
     */
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

    /**
     * Get formatted pickup date
     */
    public function getFormattedTanggalJemputAttribute()
    {
        return $this->tanggal_jemput ? $this->tanggal_jemput->format('d F Y') : '-';
    }

    /**
     * Get human readable pickup date
     */
    public function getHumanTanggalJemputAttribute()
    {
        return $this->tanggal_jemput ? $this->tanggal_jemput->diffForHumans() : '-';
    }

    /**
     * Get status badge HTML
     */
    public function getStatusBadgeAttribute()
    {
        switch ($this->status_jemput) {
            case 'terjadwal':
                return '<span class="badge bg-warning text-dark">Terjadwal</span>';
            case 'dijemput':
                return '<span class="badge bg-success">Dijemput</span>';
            case 'dibatalkan':
                return '<span class="badge bg-danger">Dibatalkan</span>';
            default:
                return '<span class="badge bg-secondary">' . ucfirst($this->status_jemput) . '</span>';
        }
    }

    /**
     * Get status color class
     */
    public function getStatusColorAttribute()
    {
        switch ($this->status_jemput) {
            case 'terjadwal':
                return 'warning';
            case 'dijemput':
                return 'success';
            case 'dibatalkan':
                return 'danger';
            default:
                return 'secondary';
        }
    }

    /**
     * Get status text in Indonesian
     */
    public function getStatusTextAttribute()
    {
        switch ($this->status_jemput) {
            case 'terjadwal':
                return 'Terjadwal';
            case 'dijemput':
                return 'Dijemput';
            case 'dibatalkan':
                return 'Dibatalkan';
            default:
                return ucfirst($this->status_jemput);
        }
    }

    /**
     * Check if pickup is overdue
     */
    public function getIsOverdueAttribute()
    {
        return $this->status_jemput === 'terjadwal' &&
               $this->tanggal_jemput &&
               $this->tanggal_jemput->isPast();
    }

    /**
     * Check if pickup is upcoming (within next 3 days)
     */
    public function getIsUpcomingAttribute()
    {
        return $this->status_jemput === 'terjadwal' &&
               $this->tanggal_jemput &&
               $this->tanggal_jemput->isFuture() &&
               $this->tanggal_jemput->diffInDays(now()) <= 3;
    }

    /**
     * Get estimated incentive value
     */
    public function getEstimasiInsentifAttribute()
    {
        if ($this->request && $this->request->insentif === 'uang_tunai') {
            return $this->estimasi_kg * 60000; // Rp 60,000 per kg
        }
        return 0;
    }

    /**
     * Get formatted estimated incentive
     */
    public function getFormattedEstimasiInsentifAttribute()
    {
        if ($this->estimasi_insentif > 0) {
            return 'Rp ' . number_format($this->estimasi_insentif, 0, ',', '.');
        }
        return '-';
    }

    /**
     * Scope for filtering by status
     */
    public function scopeByStatus($query, $status)
    {
        if ($status) {
            return $query->where('status_jemput', $status);
        }
        return $query;
    }

    /**
     * Scope for filtering by date range
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        if ($startDate && $endDate) {
            return $query->whereBetween('tanggal_jemput', [$startDate, $endDate]);
        } elseif ($startDate) {
            return $query->whereDate('tanggal_jemput', '>=', $startDate);
        } elseif ($endDate) {
            return $query->whereDate('tanggal_jemput', '<=', $endDate);
        }
        return $query;
    }

    /**
     * Scope for filtering by location
     */
    public function scopeByLocation($query, $kecamatan = null, $desa = null)
    {
        if ($kecamatan) {
            $query->where('kecamatan', 'like', '%' . $kecamatan . '%');
        }
        if ($desa) {
            $query->where('desa', 'like', '%' . $desa . '%');
        }
        return $query;
    }

    /**
     * Scope for searching by supplier info
     */
    public function scopeBySupplierSearch($query, $searchTerm)
    {
        if ($searchTerm) {
            return $query->whereHas('request', function ($q) use ($searchTerm) {
                $q->where('nama', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }
        return $query;
    }

    /**
     * Scope for upcoming pickups
     */
    public function scopeUpcoming($query)
    {
        return $query->where('status_jemput', 'terjadwal')
                    ->where('tanggal_jemput', '>=', now()->format('Y-m-d'))
                    ->orderBy('tanggal_jemput');
    }

    /**
     * Scope for overdue pickups
     */
    public function scopeOverdue($query)
    {
        return $query->where('status_jemput', 'terjadwal')
                    ->where('tanggal_jemput', '<', now()->format('Y-m-d'));
    }

    /**
     * Scope for completed pickups
     */
    public function scopeCompleted($query)
    {
        return $query->where('status_jemput', 'dijemput');
    }

    /**
     * Scope for cancelled pickups
     */
    public function scopeCancelled($query)
    {
        return $query->where('status_jemput', 'dibatalkan');
    }

    /**
     * Get pickup statistics
     */
    public static function getStatistics()
    {
        return [
            'total' => self::count(),
            'terjadwal' => self::where('status_jemput', 'terjadwal')->count(),
            'dijemput' => self::where('status_jemput', 'dijemput')->count(),
            'dibatalkan' => self::where('status_jemput', 'dibatalkan')->count(),
            'overdue' => self::overdue()->count(),
            'upcoming' => self::upcoming()->count(),
            'total_weight' => self::sum('estimasi_kg'),
            'completed_weight' => self::completed()->sum('estimasi_kg'),
        ];
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-populate location fields from supplier request when creating
        static::creating(function ($model) {
            if ($model->supplier_request_id && !$model->kecamatan && !$model->desa) {
                $supplierRequest = SupplierRequest::find($model->supplier_request_id);
                if ($supplierRequest) {
                    $model->kecamatan = $supplierRequest->kecamatan;
                    $model->desa = $supplierRequest->desa;
                    $model->detail_lokasi = $supplierRequest->detail_lokasi;
                    $model->estimasi_kg = $model->estimasi_kg ?: $supplierRequest->estimasi_kg;
                }
            }
        });
    }
}
