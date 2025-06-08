<?php

/**
 * ====================================================================================================
 * HELPER FUNCTIONS UNTUK SISTEM KUPON
 * File: app/Helpers/CouponHelper.php
 * ====================================================================================================
 */

if (!function_exists('formatRupiah')) {
    /**
     * Format angka menjadi format rupiah Indonesia
     *
     * @param int|float $amount
     * @param bool $withSymbol
     * @return string
     */
    function formatRupiah($amount, $withSymbol = true)
    {
        if (!is_numeric($amount)) {
            return $withSymbol ? 'Rp 0' : '0';
        }

        $formatted = number_format($amount, 0, ',', '.');
        return $withSymbol ? 'Rp ' . $formatted : $formatted;
    }
}

if (!function_exists('cleanRupiahFormat')) {
    /**
     * Membersihkan format rupiah dan mengambil angka saja
     *
     * @param string $rupiahString
     * @return int
     */
    function cleanRupiahFormat($rupiahString)
    {
        $cleaned = preg_replace('/[^0-9]/', '', $rupiahString);
        return (int) $cleaned;
    }
}

if (!function_exists('generateCouponCode')) {
    /**
     * Generate kode kupon otomatis
     *
     * @param string $type
     * @param int $length
     * @return string
     */
    function generateCouponCode($type = 'random', $length = 8)
    {
        switch ($type) {
            case 'discount':
                return 'DISKON' . rand(10, 99) . 'K';
            case 'save':
                return 'HEMAT' . rand(10, 99) . 'K';
            case 'welcome':
                return 'WELCOME' . rand(100, 999);
            case 'special':
                return 'SPESIAL' . strtoupper(substr(md5(time()), 0, 4));
            case 'vip':
                return 'VIP' . strtoupper(substr(md5(time()), 0, 5));
            case 'flash':
                return 'FLASH' . rand(10, 99);
            default:
                return 'KUPON' . strtoupper(substr(md5(time() . rand()), 0, $length - 5));
        }
    }
}

if (!function_exists('calculateDiscountAmount')) {
    /**
     * Hitung jumlah diskon berdasarkan kupon dan total belanja
     *
     * @param \App\Models\Coupon $coupon
     * @param float $orderAmount
     * @return array
     */
    function calculateDiscountAmount($coupon, $orderAmount)
    {
        $result = [
            'eligible' => false,
            'discount_amount' => 0,
            'final_amount' => $orderAmount,
            'message' => ''
        ];

        // Cek apakah kupon masih valid
        if (!$coupon->isValid()) {
            $result['message'] = 'Kupon sudah tidak berlaku atau kadaluarsa';
            return $result;
        }

        // Cek minimum order
        if ($orderAmount < $coupon->minimum_order) {
            $result['message'] = 'Minimum pembelian untuk kupon ini adalah ' . formatRupiah($coupon->minimum_order);
            return $result;
        }

        // Hitung diskon
        $discountAmount = min($coupon->discount_amount, $orderAmount);
        $finalAmount = $orderAmount - $discountAmount;

        $result['eligible'] = true;
        $result['discount_amount'] = $discountAmount;
        $result['final_amount'] = $finalAmount;
        $result['message'] = 'Kupon berhasil diterapkan! Anda hemat ' . formatRupiah($discountAmount);

        return $result;
    }
}

if (!function_exists('getCouponStatusBadge')) {
    /**
     * Generate badge HTML untuk status kupon
     *
     * @param \App\Models\Coupon $coupon
     * @return string
     */
    function getCouponStatusBadge($coupon)
    {
        if (!$coupon->is_active) {
            return '<span class="badge bg-secondary">Tidak Aktif</span>';
        }

        if ($coupon->expiry_date < now()) {
            return '<span class="badge bg-danger">Kadaluarsa</span>';
        }

        $daysLeft = now()->diffInDays($coupon->expiry_date, false);

        if ($daysLeft <= 3) {
            return '<span class="badge bg-warning">Segera Berakhir</span>';
        }

        return '<span class="badge bg-success">Aktif</span>';
    }
}

if (!function_exists('getCouponExpiryStatus')) {
    /**
     * Dapatkan status kadaluarsa kupon dalam format yang mudah dibaca
     *
     * @param \App\Models\Coupon $coupon
     * @return array
     */
    function getCouponExpiryStatus($coupon)
    {
        $now = now();
        $expiryDate = $coupon->expiry_date;
        $daysLeft = $now->diffInDays($expiryDate, false);

        if ($expiryDate < $now) {
            $daysAgo = abs($daysLeft);
            return [
                'status' => 'expired',
                'text' => $daysAgo === 0 ? 'Berakhir hari ini' : "{$daysAgo} hari yang lalu",
                'class' => 'text-danger',
                'urgent' => true
            ];
        }

        if ($daysLeft === 0) {
            return [
                'status' => 'today',
                'text' => 'Berakhir hari ini',
                'class' => 'text-warning',
                'urgent' => true
            ];
        }

        if ($daysLeft <= 7) {
            return [
                'status' => 'soon',
                'text' => "{$daysLeft} hari lagi",
                'class' => 'text-warning',
                'urgent' => true
            ];
        }

        return [
            'status' => 'active',
            'text' => "{$daysLeft} hari lagi",
            'class' => 'text-success',
            'urgent' => false
        ];
    }
}

if (!function_exists('validateCouponCode')) {
    /**
     * Validasi format kode kupon
     *
     * @param string $code
     * @return array
     */
    function validateCouponCode($code)
    {
        $result = [
            'valid' => false,
            'errors' => []
        ];

        // Cek panjang
        if (strlen($code) < 3) {
            $result['errors'][] = 'Kode kupon minimal 3 karakter';
        }

        if (strlen($code) > 50) {
            $result['errors'][] = 'Kode kupon maksimal 50 karakter';
        }

        // Cek format (hanya huruf besar dan angka)
        if (!preg_match('/^[A-Z0-9]+$/', $code)) {
            $result['errors'][] = 'Kode kupon hanya boleh menggunakan huruf besar dan angka';
        }

        // Cek kata-kata terlarang
        $forbiddenWords = ['ADMIN', 'TEST', 'DEBUG', 'NULL', 'UNDEFINED'];
        foreach ($forbiddenWords as $word) {
            if (strpos($code, $word) !== false) {
                $result['errors'][] = 'Kode kupon mengandung kata yang tidak diizinkan';
                break;
            }
        }

        $result['valid'] = empty($result['errors']);
        return $result;
    }
}

if (!function_exists('getCouponRecommendations')) {
    /**
     * Dapatkan rekomendasi nilai kupon berdasarkan pola yang ada
     *
     * @param float $averageOrderValue
     * @return array
     */
    function getCouponRecommendations($averageOrderValue = null)
    {
        $recommendations = [
            'starter' => [
                'name' => 'Starter',
                'discount' => 10000,
                'minimum' => 50000,
                'description' => 'Untuk menarik pelanggan baru'
            ],
            'popular' => [
                'name' => 'Popular',
                'discount' => 25000,
                'minimum' => 100000,
                'description' => 'Paling sering digunakan'
            ],
            'premium' => [
                'name' => 'Premium',
                'discount' => 50000,
                'minimum' => 200000,
                'description' => 'Untuk pembelian besar'
            ],
            'vip' => [
                'name' => 'VIP',
                'discount' => 100000,
                'minimum' => 500000,
                'description' => 'Untuk pelanggan setia'
            ]
        ];

        // Jika ada average order value, sesuaikan rekomendasi
        if ($averageOrderValue) {
            $percentage = 0.1; // 10% dari rata-rata order
            $customDiscount = round($averageOrderValue * $percentage / 5000) * 5000; // Bulatkan ke 5000

            $recommendations['custom'] = [
                'name' => 'Sesuai Rata-rata',
                'discount' => $customDiscount,
                'minimum' => $averageOrderValue * 0.8,
                'description' => 'Berdasarkan rata-rata pembelian'
            ];
        }

        return $recommendations;
    }
}

if (!function_exists('getCouponUsageStats')) {
    /**
     * Dapatkan statistik penggunaan kupon (placeholder untuk implementasi masa depan)
     *
     * @param \App\Models\Coupon $coupon
     * @return array
     */
    function getCouponUsageStats($coupon)
    {
        // TODO: Implementasi tracking penggunaan kupon
        return [
            'total_used' => 0,
            'total_saved' => 0,
            'success_rate' => 0,
            'average_order_with_coupon' => 0
        ];
    }
}

/**
 * ====================================================================================================
 * UTILITY CLASSES
 * ====================================================================================================
 */

class CouponValidator
{
    /**
     * Validasi komprehensif untuk kupon
     *
     * @param array $data
     * @return array
     */
    public static function validate($data)
    {
        $errors = [];

        // Validasi kode
        $codeValidation = validateCouponCode($data['code'] ?? '');
        if (!$codeValidation['valid']) {
            $errors['code'] = $codeValidation['errors'];
        }

        // Validasi nilai diskon
        $discount = cleanRupiahFormat($data['discount_amount'] ?? '0');
        if ($discount < 1000) {
            $errors['discount_amount'][] = 'Nilai diskon minimal Rp 1.000';
        }
        if ($discount > 10000000) {
            $errors['discount_amount'][] = 'Nilai diskon maksimal Rp 10.000.000';
        }

        // Validasi minimum order
        $minimum = cleanRupiahFormat($data['minimum_order'] ?? '0');
        if ($minimum > 0 && $discount > $minimum) {
            $errors['logic'][] = 'Nilai diskon tidak boleh lebih besar dari minimum pembelian';
        }

        // Validasi tanggal
        $expiryDate = $data['expiry_date'] ?? null;
        if ($expiryDate && strtotime($expiryDate) <= time()) {
            $errors['expiry_date'][] = 'Tanggal berakhir harus di masa depan';
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }
}

class CouponGenerator
{
    private static $patterns = [
        'discount' => ['DISKON{X}K', 'POTONGAN{X}', 'HEMAT{X}K'],
        'welcome' => ['WELCOME{X}', 'SELAMAT{X}', 'HALO{X}'],
        'special' => ['SPESIAL{X}', 'ISTIMEWA{X}', 'EKSKLUSIF{X}'],
        'event' => ['RAMADAN{X}', 'LEBARAN{X}', 'NATAL{X}', 'NEWYEAR{X}'],
        'flash' => ['FLASH{X}', 'KILAT{X}', 'CEPAT{X}'],
        'vip' => ['VIP{X}', 'PREMIUM{X}', 'PLATINUM{X}']
    ];

    /**
     * Generate kode kupon berdasarkan tipe dan parameter
     *
     * @param string $type
     * @param array $params
     * @return string
     */
    public static function generate($type = 'random', $params = [])
    {
        $patterns = self::$patterns[$type] ?? ['KUPON{X}'];
        $pattern = $patterns[array_rand($patterns)];

        $replacement = $params['value'] ?? rand(10, 99);
        $code = str_replace('{X}', $replacement, $pattern);

        // Pastikan unik
        $attempt = 0;
        $originalCode = $code;

        while (\App\Models\Coupon::where('code', $code)->exists() && $attempt < 10) {
            $code = $originalCode . strtoupper(substr(md5(time() . $attempt), 0, 2));
            $attempt++;
        }

        return $code;
    }

    /**
     * Generate multiple kode kupon sekaligus
     *
     * @param string $type
     * @param int $count
     * @param array $params
     * @return array
     */
    public static function generateBatch($type, $count, $params = [])
    {
        $codes = [];
        for ($i = 0; $i < $count; $i++) {
            $codes[] = self::generate($type, $params);
        }
        return array_unique($codes);
    }
}

/**
 * ====================================================================================================
 * CONSTANTS DAN ENUMS
 * ====================================================================================================
 */

class CouponStatus
{
    const ACTIVE = 'active';
    const INACTIVE = 'inactive';
    const EXPIRED = 'expired';
    const SOON_EXPIRE = 'soon_expire';

    public static function getAll()
    {
        return [
            self::ACTIVE => 'Aktif',
            self::INACTIVE => 'Tidak Aktif',
            self::EXPIRED => 'Kadaluarsa',
            self::SOON_EXPIRE => 'Segera Berakhir'
        ];
    }
}

class CouponType
{
    const FIXED_AMOUNT = 'fixed_amount';
    const PERCENTAGE = 'percentage';
    const FREE_SHIPPING = 'free_shipping';
    const BUY_ONE_GET_ONE = 'bogo';

    public static function getAll()
    {
        return [
            self::FIXED_AMOUNT => 'Diskon Tetap',
            self::PERCENTAGE => 'Diskon Persentase',
            self::FREE_SHIPPING => 'Gratis Ongkir',
            self::BUY_ONE_GET_ONE => 'Beli 1 Dapat 1'
        ];
    }
}

/**
 * ====================================================================================================
 * CARA PENGGUNAAN
 * ====================================================================================================
 *
 * 1. Register helper di composer.json:
 *    "autoload": {
 *        "files": ["app/Helpers/CouponHelper.php"]
 *    }
 *
 * 2. Atau load di AppServiceProvider:
 *    require_once app_path('Helpers/CouponHelper.php');
 *
 * 3. Contoh penggunaan:
 *    - formatRupiah(50000) => "Rp 50.000"
 *    - generateCouponCode('discount') => "DISKON25K"
 *    - validateCouponCode('INVALID@CODE') => ['valid' => false, 'errors' => [...]]
 *
 * ====================================================================================================
 */
