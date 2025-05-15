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
