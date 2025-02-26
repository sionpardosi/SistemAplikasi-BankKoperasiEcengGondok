-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Waktu pembuatan: 23 Feb 2025 pada 08.03
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

USE DATABASE bankecenggongok

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bankecenggondok`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `brands`
--

CREATE TABLE `brands` (
  `id` BIGINT(20) UNSIGNED NOT NULL,
  `name` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `image`, `created_at`, `updated_at`) VALUES
(2, 'Sionasas', 'sionasas', '1740065616.png', '2025-02-20 08:33:37', '2025-02-20 08:33:37'),
(4, 'parhata1', 'parhata1', '1740210393.png', '2025-02-22 00:46:34', '2025-02-22 00:46:34'),
(5, 'Sendal', 'sendal', '1740291735.jpg', '2025-02-22 23:22:15', '2025-02-22 23:22:15'),
(6, 'sendalhotel', 'sendalhotel', '1740292105.jpg', '2025-02-22 23:28:25', '2025-02-22 23:28:25');

DELETE FROM brands;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` MEDIUMTEXT COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` INT(11) NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` INT(11) NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` BIGINT(20) UNSIGNED NOT NULL,
  `name` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Topi Premium1', 'topi-premium1', '1740112371.png', NULL, '2025-02-20 21:05:30', '2025-02-20 21:32:51'),
(3, 'sendal premium', 'sendal-premium', '1740292148.jpg', NULL, '2025-02-22 23:29:08', '2025-02-22 23:29:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` BIGINT(20) UNSIGNED NOT NULL,
  `uuid` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` TEXT COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` TEXT COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` LONGTEXT COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` LONGTEXT COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` BIGINT(20) UNSIGNED NOT NULL,
  `queue` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` LONGTEXT COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` TINYINT(3) UNSIGNED NOT NULL,
  `reserved_at` INT(10) UNSIGNED DEFAULT NULL,
  `available_at` INT(10) UNSIGNED NOT NULL,
  `created_at` INT(10) UNSIGNED NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(13, '0001_01_01_000000_create_users_table', 1),
(14, '0001_01_01_000001_create_cache_table', 1),
(15, '0001_01_01_000002_create_jobs_table', 1),
(16, '2025_02_20_125325_create_brands_table', 2),
(17, '2025_02_21_015419_create_categories_table', 3),
(18, '2025_02_21_072635_create_products_table', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `regular_price` decimal(8,2) NOT NULL,
  `sale_price` decimal(8,2) DEFAULT NULL,
  `SKU` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock_status` enum('instock','outofstock') COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 10,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `short_description`, `description`, `regular_price`, `sale_price`, `SKU`, `stock_status`, `featured`, `quantity`, `image`, `images`, `category_id`, `brand_id`, `created_at`, `updated_at`) VALUES
(3, 'sadasd', 'sadasd', 'sdas', 'asdasd', '323.00', '213.00', 'sa32434', 'instock', 0, 123, '1740222711.jpg', '1740222711-1.jpg', 1, 2, '2025-02-22 04:11:51', '2025-02-22 04:11:51'),
(4, 'asas', 'asas', 'asaS', 'AsASa', '123.00', '1234.00', '23123asd', 'instock', 0, 23, '1740223141.jpg', '1740223141-1.jpg,1740223141-2.jpg', 1, 2, '2025-02-22 04:19:01', '2025-02-22 04:19:01'),
(5, 'Topi Keren', 'topi-keren', 'asdawdwewqeqwe', 'wqeqweqweqweqwe', '23213.00', '32312.00', '213sdas', 'instock', 0, 23, '1740230819.jpg', '1740230819-1.jpg,1740230819-2.jpg', 1, 2, '2025-02-22 06:26:59', '2025-02-22 06:26:59'),
(6, 'csasdsad', 'csasdsad', 'sASAS', 'addwqdwqd', '12.00', '131.00', 'ASDE23', 'instock', 0, 31, '1740230845.jpg', '1740230845-1.jpg,1740230845-2.jpg', 1, 4, '2025-02-22 06:27:25', '2025-02-22 06:27:25'),
(7, 'daDSADWQRQR', 'dadsadwqrqr', 'ASDASDASDadAdfdsfdfsafasfasASDASDASDadAdfdsfdfsafasfasASDASDASDadAdfdsfdfsafasfasASDASDASDadAdfdsfdfsafasfasASDASDASDadAdfdsfdfsafasfas', 'ASDASDASDadAdfdsfdfsafasfasASDASDASDadAdfdsfdfsafasfasASDASDASDadAdfdsfdfsafasfasASDASDASDadAdfdsfdfsafasfasASDASDASDadAdfdsfdfsafasfasASDASDASDadAdfdsfdfsafasfas', '12212.00', '12.00', 'adasad343', 'instock', 0, 12, '1740230877.jpg', '1740230877-1.jpg,1740230877-2.jpg,1740230877-3.jpg,1740230877-4.jpg', 1, 4, '2025-02-22 06:27:58', '2025-02-22 06:27:58'),
(8, 'Tas Eceng Gondok', 'tas-eceng-gondok', 'Tas Eceng GondokTas Eceng GondokTas Eceng Gondok', 'Tas Eceng GondokTas Eceng GondokTas Eceng GondokTas Eceng GondokTas Eceng GondokTas Eceng Gondok', '12.00', '12.00', 'xqeqe121', 'instock', 0, 1, '1740240177.jpg', '1740240177-1.jpg', 1, 2, '2025-02-22 09:02:58', '2025-02-22 09:02:58'),
(9, 'Eceng Gondok', 'eceng-gondok', 'asaS', 'SsasAS', '12.00', '1.00', 'QSQW23', 'instock', 0, 0, '1740240277.jpg', '1740240277-1.jpg', 1, 2, '2025-02-22 09:04:37', '2025-02-22 09:04:37'),
(10, 'SION', 'sion', 'asa', 'asa', '1.00', '1.00', 'asAS12', 'instock', 0, 1, '1740240346.jpg', '1740240346-1.jpg', 3, 2, '2025-02-22 09:05:46', '2025-02-22 23:29:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('AMI2vAEj88XMB4NwVRZV9FrwaapxMpMknsiG3UbS', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiYklSdU11QWZkanMxT3BJcVpxSlREQ3V4R2xBMHVNdlc3UEk4dUhvYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NDoiY2FydCI7YToxOntzOjQ6ImNhcnQiO086Mjk6IklsbHVtaW5hdGVcU3VwcG9ydFxDb2xsZWN0aW9uIjoyOntzOjg6IgAqAGl0ZW1zIjthOjA6e31zOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTc0MDI5MTcxNjt9fQ==', 1740291716),
('rbGlaNycyvSvwwaCkwXa7Vt6J0KV9sZXITu1OvAW', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNU9HeGVKYklxWjl2TEU2RDB5UTM5aWhwbW92dXRrWmFWbEhYaERDTyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zaG9wP2JyYW5kcz0mY2F0ZWdvcmllcz0mbWF4PTQ1MTYmbWluPTEmbmFtZT0xJm9yZGVyPS0xJnNpemU9MTIiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTc0MDI5MTcyMzt9fQ==', 1740293757);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `utype` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USR' COMMENT 'ADM for Admin and USR for User or Customer',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile`, `email_verified_at`, `password`, `utype`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@ecenggondok.com', '082278900178', NULL, '$2y$12$d75h9zRWpX0ySHNLeumHuOjw6HpV9j43KQNolMCv5QvbA57ps2dge', 'ADM', NULL, '2025-02-20 05:42:20', '2025-02-20 05:42:20');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_slug_unique` (`slug`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_mobile_unique` (`mobile`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
