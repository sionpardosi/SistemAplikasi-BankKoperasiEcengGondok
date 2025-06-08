<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'pending_order_id',
        'invoice',
        'mode',
        'bank_code',
        'payment_proof',
        'status',
        'snap_token',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ====================================================================================================
    // Relationships
    // ====================================================================================================

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pendingOrder()
    {
        return $this->belongsTo(PendingOrder::class);
    }

    // ====================================================================================================
    // Accessors & Mutators
    // ====================================================================================================

    /**
     * Get payment status badge with improved styling
     */
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'approved', 'paid' => '<span class="badge bg-success"><i class="icon-check"></i> Dibayar</span>',
            'pending' => '<span class="badge bg-warning"><i class="icon-clock"></i> Menunggu</span>',
            'declined' => '<span class="badge bg-danger"><i class="icon-close"></i> Ditolak</span>',
            'refunded' => '<span class="badge bg-secondary"><i class="icon-refresh"></i> Dikembalikan</span>',
            default => '<span class="badge bg-secondary">Unknown</span>'
        };
    }

    /**
     * Get payment method display name
     */
    public function getModeDisplayAttribute()
    {
        $modeMap = [
            'card' => 'Kartu Kredit/Debit',
            'midtrans' => 'E-Wallet | Pembayaran Online (Midtrans)',
            'manual_atm' => 'Transfer Bank BNI',
            'cod' => 'Cash on Delivery (COD)',
            'bank_transfer' => 'Transfer Bank',
            'e_wallet' => 'E-Wallet',
            'virtual_account' => 'Virtual Account',
            'credit_card' => 'Kartu Kredit',
        ];

        return $modeMap[$this->mode] ?? ucfirst(str_replace('_', ' ', $this->mode));
    }

    /**
     * Get bank name from bank code
     */
    public function getBankNameAttribute()
    {
        $bankMap = [
            'bri' => 'Bank BRI',
            'bni' => 'Bank BNI',
            'bca' => 'Bank BCA',
            'mandiri' => 'Bank Mandiri',
            'cimb' => 'Bank CIMB Niaga',
            'danamon' => 'Bank Danamon',
            'permata' => 'Bank Permata',
            'bsi' => 'Bank Syariah Indonesia',
            'btn' => 'Bank BTN',
        ];

        return $bankMap[$this->bank_code] ?? strtoupper($this->bank_code);
    }

    /**
     * Get payment status for filtering
     */
    public function getPaymentStatusAttribute()
    {
        return match ($this->status) {
            'approved', 'paid' => 'paid',
            'declined' => 'declined',
            default => 'pending'
        };
    }

    /**
     * Get payment status color
     */
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'approved', 'paid' => 'success',
            'pending' => 'warning',
            'declined' => 'danger',
            'refunded' => 'secondary',
            default => 'secondary'
        };
    }

    /**
     * Get payment status icon
     */
    public function getStatusIconAttribute()
    {
        return match ($this->status) {
            'approved', 'paid' => 'icon-check',
            'pending' => 'icon-clock',
            'declined' => 'icon-close',
            'refunded' => 'icon-refresh',
            default => 'icon-question'
        };
    }

    /**
     * Get formatted amount
     */
    public function getFormattedAmountAttribute()
    {
        if ($this->order) {
            return 'Rp ' . number_format($this->order->total, 0, ',', '.');
        }
        return '-';
    }

    // ====================================================================================================
    // Methods
    // ====================================================================================================

    /**
     * Check if snap token is expired (24 hours from created_at)
     */
    public function isSnapTokenExpired()
    {
        if (!$this->snap_token) {
            return true;
        }

        // Snap token Midtrans berlaku 24 jam
        return $this->created_at->addHours(24)->isPast();
    }

    /**
     * Check if payment is completed
     */
    public function isPaid()
    {
        return in_array($this->status, ['approved', 'paid']);
    }

    /**
     * Check if payment is pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if payment is declined
     */
    public function isDeclined()
    {
        return $this->status === 'declined';
    }

    /**
     * Check if payment is refunded
     */
    public function isRefunded()
    {
        return $this->status === 'refunded';
    }

    /**
     * Mark payment as paid
     */
    public function markAsPaid()
    {
        $this->update(['status' => 'approved']);

        // Update order status if still awaiting payment
        if ($this->order && $this->order->status === 'awaiting_payment') {
            $this->order->update(['status' => 'pending']);
        }
    }

    /**
     * Mark payment as declined
     */
    public function markAsDeclined()
    {
        $this->update(['status' => 'declined']);

        // Optionally update order status
        if ($this->order && in_array($this->order->status, ['awaiting_payment', 'pending'])) {
            $this->order->update(['status' => 'canceled']);
        }
    }

    /**
     * Get payment method icon
     */
    public function getModeIconAttribute()
    {
        $iconMap = [
            'card' => 'icon-credit-card',
            'midtrans' => 'icon-credit-card',
            'manual_atm' => 'icon-credit-card',
            'cod' => 'icon-dollar-sign',
            'bank_transfer' => 'icon-credit-card',
            'e_wallet' => 'icon-wallet',
            'virtual_account' => 'icon-credit-card',
            'credit_card' => 'icon-credit-card',
        ];

        return $iconMap[$this->mode] ?? 'icon-credit-card';
    }

    /**
     * Generate invoice number if not exists
     */
    public function generateInvoice()
    {
        if (!$this->invoice) {
            $this->invoice = 'INV-' . date('Ymd') . '-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
            $this->save();
        }
        return $this->invoice;
    }

    // ====================================================================================================
    // Scopes
    // ====================================================================================================

    /**
     * Scope for paid transactions
     */
    public function scopePaid($query)
    {
        return $query->whereIn('status', ['approved', 'paid']);
    }

    /**
     * Scope for pending transactions
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for declined transactions
     */
    public function scopeDeclined($query)
    {
        return $query->where('status', 'declined');
    }

    /**
     * Scope for this month transactions
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
    }

    /**
     * Scope for date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    // ====================================================================================================
    // Static Methods
    // ====================================================================================================

    /**
     * Get total revenue for paid transactions
     */
    public static function getTotalRevenue()
    {
        return self::paid()
            ->join('orders', 'transactions.order_id', '=', 'orders.id')
            ->sum('orders.total');
    }

    /**
     * Get monthly revenue
     */
    public static function getMonthlyRevenue($month = null, $year = null)
    {
        $month = $month ?? now()->month;
        $year = $year ?? now()->year;

        return self::paid()
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->join('orders', 'transactions.order_id', '=', 'orders.id')
            ->sum('orders.total');
    }

    /**
     * Get payment statistics
     */
    public static function getPaymentStatistics()
    {
        return [
            'total_transactions' => self::count(),
            'paid_transactions' => self::paid()->count(),
            'pending_transactions' => self::pending()->count(),
            'declined_transactions' => self::declined()->count(),
            'total_revenue' => self::getTotalRevenue(),
            'monthly_revenue' => self::getMonthlyRevenue(),
        ];
    }
}
