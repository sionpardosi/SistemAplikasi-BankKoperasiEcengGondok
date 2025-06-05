<?php
// if (!function_exists('formatRupiah')) {
//     function formatRupiah($angka) {
//         // Menggunakan titik sebagai pemisah ribuan dan koma untuk desimal (jika ada)
//         return 'Rp ' . number_format($angka, 0, ',', '.');
//     }
// }
if (!function_exists('formatRupiah')) {
    function formatRupiah($angka) {
        return 'Rp ' . number_format((float)$angka, 0, ',', '.');
    }
}

if (!function_exists('formatRupiah')) {
    /**
     * Format angka menjadi format mata uang Rupiah
     *
     * @param float|int $amount
     * @return string
     */
    function formatRupiah($amount)
    {
        if ($amount == 0 || $amount == null) {
            return 'Rp 0';
        }

        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('formatRupiahShort')) {
    /**
     * Format angka menjadi format mata uang Rupiah dengan singkatan
     *
     * @param float|int $amount
     * @return string
     */
    function formatRupiahShort($amount)
    {
        if ($amount == 0 || $amount == null) {
            return 'Rp 0';
        }

        if ($amount >= 1000000000) {
            return 'Rp ' . number_format($amount / 1000000000, 1, ',', '.') . 'M';
        } elseif ($amount >= 1000000) {
            return 'Rp ' . number_format($amount / 1000000, 1, ',', '.') . 'Jt';
        } elseif ($amount >= 1000) {
            return 'Rp ' . number_format($amount / 1000, 1, ',', '.') . 'rb';
        }

        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('parseRupiah')) {
    /**
     * Parse string Rupiah menjadi angka
     *
     * @param string $rupiah
     * @return float
     */
    function parseRupiah($rupiah)
    {
        // Hapus 'Rp', spasi, dan titik
        $cleaned = str_replace(['Rp', ' ', '.'], '', $rupiah);

        // Ganti koma dengan titik untuk desimal
        $cleaned = str_replace(',', '.', $cleaned);

        return floatval($cleaned);
    }
}
