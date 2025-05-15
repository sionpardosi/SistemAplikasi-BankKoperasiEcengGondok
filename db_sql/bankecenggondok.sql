-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Waktu pembuatan: 07 Bulan Mei 2025 pada 03.06
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bankecenggondok`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `abouts`
--

CREATE TABLE `abouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `story` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vision` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mission` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `founder` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `established_date` date DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_info` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `map_embed` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image1_caption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image1_alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image2_caption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image2_alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `abouts`
--

INSERT INTO `abouts` (`id`, `title`, `slug`, `story`, `vision`, `mission`, `founder`, `established_date`, `address`, `contact_info`, `map_embed`, `image1`, `image1_caption`, `image1_alt`, `image2`, `image2_caption`, `image2_alt`, `is_active`, `created_at`, `updated_at`) VALUES
(4, 'Tentang Bank Koperasi Eceng Gondok Samosir', 'tentang-bank-koperasi-eceng-gondok-samosir', 'Di pesisir Danau Toba, pertumbuhan Eceng Gondok yang tak terkendali menutupi perairan dan meresahkan masyarakat setempat. Bank Koperasi Eceng Gondok Samosir hadir sebagai inisiatif inovatif untuk mengatasi masalah lingkungan sekaligus memberdayakan masyarakat lokal. Koperasi ini didirikan oleh Sumondang Tabita Nainggolan pada akhir tahun 2023 di Sitanggang Bau, Pangururan. Melalui kolaborasi dan semangat gotong-royong, kami mengubah Eceng Gondok yang selama ini dianggap gulma menjadi produk kerajinan bernilai tinggi, menciptakan lapangan usaha baru bagi komunitas sekitar.\r\nSejumlah pengrajin lokal Bank Koperasi Eceng Gondok Samosir menunjukkan hasil kerajinan dari Eceng Gondok dengan bangga. Pada awalnya, proses pembuatan sandal, tas, dan kerajinan lain masih dilakukan secara manual menggunakan teknik anyaman tradisional. Melalui pelatihan dan kerja sama, kami meningkatkan kemampuan anggota sehingga kapasitas produksi pun bertambah. Setiap helai Eceng Gondok dikeringkan, dihaluskan, dan dianyam dengan tangan sesuai kearifan lokal, menghasilkan produk kerajinan berkualitas tinggi. Kini, produk kami tidak hanya dipasarkan secara lokal, tetapi juga melalui platform daring, menjangkau konsumen yang lebih luas.\r\nMenjawab tantangan pengelolaan usaha yang masih dilakukan secara manual, kami mengembangkan sistem koperasi digital terintegrasi. Dengan sistem daring ini, proses pendaftaran anggota, transaksi, dan pengelolaan usaha dilakukan lebih mudah dan efisien. Langkah ini tidak hanya meningkatkan efisiensi operasional, tetapi juga transparansi, sehingga setiap anggota dapat memantau pembukuan dan distribusi produk secara terbuka. Melalui platform digital, kami mengajak masyarakat lebih aktif berpartisipasi dan menjangkau pasar yang lebih luas bagi produk Eceng Gondok Samosir.', 'Menjadi koperasi terdepan yang memberdayakan ekonomi masyarakat lokal melalui pemanfaatan Eceng Gondok secara berkelanjutan untuk menjaga lingkungan Danau Toba, serta mendukung inovasi sistem digital dan pelestarian budaya serta kerajinan lokal.', 'Meningkatkan kesejahteraan ekonomi masyarakat lokal melalui pelatihan dan pendampingan kewirausahaan berbasis Eceng Gondok.\r\nMengelola Eceng Gondok secara berkelanjutan untuk menjaga kelestarian lingkungan Danau Toba.\r\nMengembangkan sistem koperasi digital yang transparan dan efisien untuk mempermudah administrasi dan pemasaran produk.\r\nMelestarikan budaya lokal melalui inovasi kerajinan Eceng Gondok yang khas Samosir.', 'Sumondang', '2025-04-29', 'Jl. Sitanggang No. 1, Desa Sitanggang Bau, Kec. Pangururan, Kab. Samosir, Sumatera Utara', 'Telepon: +62 812 3456 7890\r\nEmail: info@bkecg-samosir.id\r\nWebsite: www.bkecg-samosir.coop', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4966.45620991171!2d98.69318757585994!3d2.628665756129755!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3031c5ca7c7e07f9%3A0x2c25b5a19a80edae!2skoperasibank%20Eceng%20Gondok!5e1!3m2!1sid!2sid!4v1745930060331!5m2!1sid!2sid\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'uploads/abouts/1746107323_QR2rOB.jpg', 'Tentang Bank Koperasi Eceng Gondok Samosir', 'Tentang Bank Koperasi Eceng Gondok Samosir', 'uploads/abouts/1745932433_5GTdqd.jpg', 'Tentang Bank Koperasi Eceng Gondok Samosir', 'Tentang Bank Koperasi Eceng Gondok Samosir', 1, '2025-04-29 13:13:53', '2025-05-05 01:59:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locality` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `landmark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'home',
  `isdefault` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `name`, `phone`, `locality`, `address`, `city`, `state`, `country`, `landmark`, `zip`, `type`, `isdefault`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sion pardosi', '1234563535', 'b', 'b', 'b', 'b', '', 'b', '223123', 'home', 1, '2025-04-28 03:58:28', '2025-05-03 17:54:22'),
(2, 1, 'saut', '12121212121212', 'balige', 'balige', 'balige', 'balige', 'Indonesia', 'balige', '123456', 'home', 0, '2025-05-03 15:12:17', '2025-05-03 17:54:22'),
(3, 3, 'Listra', '0822790182', 'Balige', 'Balige', 'Balige', 'Balige', 'Indonesia', 'Balige', '123456', 'home', 1, '2025-05-05 07:55:26', '2025-05-05 07:55:26'),
(4, 15, 'Efran Lumbantoruan', '081802248805', 'Sumatera utara,Toba,Balige', 'Indonesia', 'Toba Samosir', 'Sumatera Utara', 'Indonesia', '12', '123', 'home', 1, '2025-05-06 12:21:37', '2025-05-06 12:21:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `image`, `created_at`, `updated_at`) VALUES
(6, 'Eceng Gondok Samosir', 'eceng-gondok-samosir', '1745403749.png', '2025-04-23 03:22:29', '2025-04-23 03:22:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('sumondang12@gmail.com|127.0.0.1', 'i:1;', 1746536223),
('sumondang12@gmail.com|127.0.0.1:timer', 'i:1746536223;', 1746536223);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `parent_id`, `created_at`, `updated_at`) VALUES
(11, 'Topi', 'topi', '1745403070.avif', NULL, '2025-04-23 03:11:11', '2025-04-23 03:11:11'),
(12, 'Kotak Tissue', 'kotak-tissue', '1745403101.webp', NULL, '2025-04-23 03:11:42', '2025-04-23 03:11:42'),
(13, 'Karpet', 'karpet', '1745403132.jpg', NULL, '2025-04-23 03:12:12', '2025-04-23 03:12:12'),
(14, 'Wadah', 'wadah', '1745403148.jpg', NULL, '2025-04-23 03:12:28', '2025-04-23 03:12:28'),
(15, 'Keranjang', 'keranjang', '1745403164.jpg', NULL, '2025-04-23 03:12:44', '2025-04-23 03:12:44'),
(16, 'Sendal', 'sendal', '1745403179.webp', NULL, '2025-04-23 03:12:59', '2025-04-23 03:12:59'),
(17, 'Bantal', 'bantal', '1745403192.jpg', NULL, '2025-04-23 03:13:13', '2025-04-23 03:13:13'),
(18, 'Tas', 'tas', '1745403217.jpg', NULL, '2025-04-23 03:13:37', '2025-04-23 03:13:37'),
(19, 'Vas Bunga', 'vas-bunga', '1745403246.jpg', NULL, '2025-04-23 03:14:06', '2025-04-23 03:14:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `comment`, `created_at`, `updated_at`) VALUES
(1, 'asas', 'sas@gmail.com', '1234567892', 'asas', '2025-04-28 07:17:21', '2025-04-28 07:17:21'),
(2, 'sion pardosi', 'spardosi@gmail.com', '1234567892', 'asas', '2025-04-28 08:29:20', '2025-04-28 08:29:20'),
(3, 'Si', 'spardosi12@gmail.com', '1234567892', 'sa', '2025-04-28 08:31:10', '2025-04-28 08:31:10'),
(4, 'Si', 'spardosi12@gmail.com', '1234567891', 'asas', '2025-04-28 09:13:50', '2025-04-28 09:13:50'),
(5, 'Si', 'spardosi12@gmail.com', '1234567891', 'asas', '2025-04-28 09:14:18', '2025-04-28 09:14:18'),
(7, 'Si', 'spardosi12@gmail.com', '1234567892', 'sasasa', '2025-04-28 09:16:28', '2025-04-28 09:16:28'),
(8, 'Si', 'spardosi12@gmail.com', '12827362938', 'asas', '2025-04-28 09:20:39', '2025-04-28 09:20:39'),
(9, 'Si', 'spardosi12@gmail.com', '12827362938', 'asas', '2025-04-28 09:21:10', '2025-04-28 09:21:10'),
(10, 'Si', 'spardosi12@gmail.com', '12827362938', 'asas', '2025-04-28 09:21:10', '2025-04-28 09:21:10'),
(11, 'Si', 'spardosi12@gmail.com', '12827362938', 'asas', '2025-04-28 09:21:16', '2025-04-28 09:21:16'),
(12, 'Si', 'spardosi12@gmail.com', '12827362938', 'asas', '2025-04-28 09:21:16', '2025-04-28 09:21:16'),
(13, 'Si', 'spardosi12@gmail.com', '12827362938', 'asas', '2025-04-28 09:21:17', '2025-04-28 09:21:17'),
(14, 'Si', 'spardosi12@gmail.com', '12827362938', 'asas', '2025-04-28 09:21:17', '2025-04-28 09:21:17'),
(15, 'Si', 'spardosi12@gmail.com', '12423827362', 'aku cinta kamu samosir', '2025-04-28 09:25:57', '2025-04-28 09:25:57'),
(16, 'Si', 'spardosi12@gmail.com', '12423827362', 'aku cinta kamu samosir', '2025-04-28 09:25:57', '2025-04-28 09:25:57'),
(17, 'Siasas', 'spardosi12@gmail.com', '1242457423', 'au ma na ra ta', '2025-04-28 09:28:50', '2025-04-28 09:28:50'),
(18, 'Siasas', 'spardosi12@gmail.com', '1242457423', 'au ma na ra ta', '2025-04-28 09:28:50', '2025-04-28 09:28:50'),
(19, 'Si', 'spardosi12@gmail.com', '082278900178', 'asasasas', '2025-04-28 12:12:06', '2025-04-28 12:12:06'),
(20, 'Si', 'spardosi12@gmail.com', '082278900178', 'asasasas', '2025-04-28 12:12:06', '2025-04-28 12:12:06'),
(21, 'Si', 'spardosi12@gmail.com', '1234524574', 'asas', '2025-04-28 12:58:49', '2025-04-28 12:58:49'),
(22, 'Si', 'spardosi12@gmail.com', '1234524574', 'asas', '2025-04-28 12:58:49', '2025-04-28 12:58:49'),
(23, 'sumondang', 'sumondang@gmail.com', '1234573246', 'sas', '2025-04-28 13:00:53', '2025-04-28 13:00:53'),
(24, 'sumondang', 'sumondang@gmail.com', '1234573246', 'sas', '2025-04-28 13:00:53', '2025-04-28 13:00:53'),
(25, 'sumondang', 'sumondang@gmail.com', '12342436363', 'asas', '2025-04-28 13:12:29', '2025-04-28 13:12:29'),
(26, 'asas', 'assas@gmail.com', '1235247954', 'asa', '2025-04-28 13:21:00', '2025-04-28 13:21:00'),
(27, 'asa', 'sumondang@gmail.com', '1234235213', 'asas', '2025-04-28 13:26:22', '2025-04-28 13:26:22'),
(28, 'sumondang', 'sumondang@gmail.com', '1234235213', 'asas', '2025-04-28 13:27:40', '2025-04-28 13:27:40'),
(29, 'sumondang', 'sumondang@gmail.com', '1234235213', 'asas', '2025-04-28 13:28:09', '2025-04-28 13:28:09'),
(30, 'sumondangasas', 'sumondang@gmail.com', '1234235213', 'asas', '2025-04-28 13:29:00', '2025-04-28 13:29:00'),
(31, 'sumondang', 'sumondang@gmail.com', '123456227381', 'asasas', '2025-04-28 13:38:35', '2025-04-28 13:38:35'),
(32, 'sumondang', 'sumondang@gmail.com', '082278900178', 'sasas', '2025-04-28 13:42:01', '2025-04-28 13:42:01'),
(33, 'Si', 'spardosi12@gmail.com', '123353623636', 'ada', '2025-04-28 14:16:11', '2025-04-28 14:16:11'),
(34, 'Sion pARODIS', 'sumondang@gmail.com', '082278900178', 'ASAS', '2025-04-28 15:20:28', '2025-04-28 15:20:28'),
(35, 'sumondang', 'sumondang@gmail.com', '082278900786', 'aku suka sama monyetmu', '2025-04-28 15:21:52', '2025-04-28 15:21:52'),
(36, 'sumondang', 'sumondang@gmail.com', '2323232323232', 'asas', '2025-04-28 15:24:00', '2025-04-28 15:24:00'),
(37, 'sumondang', 'sumondang@gmail.com', '122442424242', 'ada', '2025-04-28 15:31:51', '2025-04-28 15:31:51'),
(38, 'Si', 'spardosi12@gmail.com', '1212121212', 'sqs', '2025-04-28 15:38:33', '2025-04-28 15:38:33'),
(39, 'Si', 'spardosi12@gmail.com', '423142', 'wew', '2025-04-28 15:38:45', '2025-04-28 15:38:45'),
(40, 'sas', 'sasa@gmail.com', '1235', 'adadsa', '2025-04-28 15:38:56', '2025-04-28 15:38:56'),
(41, 'Si', 'spardosi12@gmail.com', '3231434', 'asa', '2025-04-28 15:40:39', '2025-04-28 15:40:39'),
(42, 'Si', 'spardosi12@gmail.com', '3423523', 'dsd', '2025-04-28 15:42:14', '2025-04-28 15:42:14'),
(43, 'Si', 'spardosi12@gmail.com', '121212', 'as', '2025-04-28 15:56:38', '2025-04-28 15:56:38'),
(44, 'Si', 'spardosi12@gmail.com', '11313', 'as', '2025-04-28 15:57:43', '2025-04-28 15:57:43'),
(45, 'Si', 'spardosi12@gmail.com', '1313', '1313', '2025-04-28 16:00:54', '2025-04-28 16:00:54'),
(46, 'Si', 'spardosi12@gmail.com', '2323', '23', '2025-04-28 16:01:19', '2025-04-28 16:01:19'),
(47, 'Si', 'spardosi12@gmail.com', '323', 'qwq', '2025-04-28 16:01:54', '2025-04-28 16:01:54'),
(48, 'Si', 'spardosi12@gmail.com', '3232', 'asas', '2025-04-28 16:02:17', '2025-04-28 16:02:17'),
(49, 'Si', 'spardosi12@gmail.com', '082278900178', 'soasasas', '2025-04-28 16:08:41', '2025-04-28 16:08:41'),
(50, 'Si', 'spardosi12@gmail.com', '082278454545', 'kjgiug', '2025-04-28 16:17:40', '2025-04-28 16:17:40'),
(51, 'Si', 'spardosi12@gmail.com', '082278900178', 'adad', '2025-04-28 16:18:12', '2025-04-28 16:18:12'),
(52, 'Si', 'spardosi12@gmail.com', '0822678121212', 'asas', '2025-04-29 12:41:25', '2025-04-29 12:41:25'),
(53, 'Si', 'spardosi12@gmail.com', '0822789012', 'asas', '2025-04-30 09:25:27', '2025-04-30 09:25:27'),
(54, 'sumondang', 'sumondang@gmail.com', '082278900178', 'saya perlu mengirimkan uang ke listra jelek', '2025-05-05 02:01:58', '2025-05-05 02:01:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('fixed','percent') COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` decimal(15,2) NOT NULL,
  `cart_value` decimal(15,2) NOT NULL,
  `expiry_date` date NOT NULL DEFAULT cast(current_timestamp() as date),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `value`, `cart_value`, `expiry_date`, `created_at`, `updated_at`) VALUES
(1, 'aasasa', 'fixed', '1333.00', '1222.00', '2025-04-30', '2025-04-27 15:31:55', '2025-04-27 15:31:55'),
(2, '12sa', 'fixed', '30.00', '35.00', '2025-04-29', '2025-04-28 07:25:46', '2025-04-28 07:25:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `email_verifications`
--

CREATE TABLE `email_verifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_applications`
--

CREATE TABLE `job_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `cv` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover_letter` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `education_level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `experience` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expected_salary` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skills` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `additional_info` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Diterima','Ditolak','Diproses') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Diproses',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Struktur dari tabel `job_lists`
--

CREATE TABLE `job_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('Full-time','Part-time','Freelance') COLLATE utf8mb4_unicode_ci NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `salary_type` enum('Per Jam','Per Hari','Per Bulan','Proyek') COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requirements` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `benefits` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `status` enum('Dibuka','Ditutup','Selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Dibuka',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `job_lists`
--

INSERT INTO `job_lists` (`id`, `title`, `description`, `category`, `salary`, `salary_type`, `duration`, `target`, `location`, `image`, `requirements`, `benefits`, `deadline`, `status`, `created_at`, `updated_at`) VALUES
(1, 'pencari orang jelek', 'pencari orang jelekpencari orang jelek', 'Part-time', '3000000.00', 'Per Hari', '5 minggu', 'mencari listra jelek', 'samosir', NULL, NULL, NULL, NULL, 'Dibuka', '2025-05-05 04:25:35', '2025-05-05 04:25:35'),
(2, 'Dicari Listra Orang Jelek (ODP)', 'pencarian orang jelek', 'Full-time', '2999998.00', 'Per Jam', '30 hari', 'mencari listra jelek', 'samosir', NULL, NULL, NULL, NULL, 'Dibuka', '2025-05-05 04:30:00', '2025-05-05 04:30:00');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_02_20_125325_create_brands_table', 1),
(5, '2025_02_21_015419_create_categories_table', 1),
(6, '2025_02_21_072635_create_products_table', 1),
(7, '2025_02_27_014009_create_coupons_table', 1),
(8, '2025_02_27_080901_create_orders_table', 1),
(9, '2025_02_27_080912_create_order_items_table', 1),
(10, '2025_02_27_080927_create_addresses_table', 1),
(11, '2025_02_27_081005_create_transactions_table', 1),
(12, '2025_02_28_065150_create_slides_table', 1),
(13, '2025_03_01_173133_create_month_names_table', 1),
(14, '2025_03_02_075927_create_contacts_table', 1),
(15, '2025_03_04_071131_modify_price_columns_in_products_table', 1),
(16, '2025_03_04_084756_modify_order_decimal_columns', 1),
(17, '2025_03_04_084957_modify_price_column_in_order_items_table', 1),
(18, '2025_03_04_091822_modify_coupon_columns', 1),
(19, '2025_03_04_134922_modify_coupon_decimal_columns', 1),
(20, '2025_03_07_145957_create_personal_access_tokens_table', 1),
(23, '2025_03_10_143430_google_social_auth_id', 1),
(24, '2025_03_11_135543_add_cart_data_to_users_table', 1),
(25, '2025_03_11_141644_remove_cart_data_from_users_table', 1),
(26, '2025_03_11_141818_user_cart_items', 1),
(27, '2025_03_11_145827_add_coupon_data_to_users_table', 1),
(28, '2025_03_11_152056_create_wishlist_items_table', 1),
(29, '2025_04_24_152621_create_supplier_requests_table', 1),
(30, '2025_04_26_011804_create_stok_bahan_bakus_table', 1),
(31, '2025_04_26_123252_create_penjadwalan_penjemputans_table', 1),
(32, '2025_04_26_173020_add_lokasi_fields_to_supplier_requests_and_penjadwalan_penjemputan', 1),
(33, '2025_04_28_103938_create_tentangs_table', 2),
(34, '2025_04_29_140435_create_pages_table', 3),
(35, '2025_04_29_140452_create_page_sections_table', 3),
(36, '2025_04_29_142120_create_abouts_table', 4),
(37, '2025_04_29_200705_add_map_embed_to_abouts_table', 5),
(38, '2025_05_04_023708_add_mobile_to_users_table', 6),
(39, '2025_05_04_031350_create_email_verifications_table', 7),
(40, '2025_03_09_200243_create_job_lists_table', 8),
(41, '2025_03_09_200308_create_job_applications_table', 9),
(42, '2025_05_06_095857_create_supplier_infos_table', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `month_names`
--

CREATE TABLE `month_names` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `month_names`
--

INSERT INTO `month_names` (`id`, `name`) VALUES
(1, 'January'),
(2, 'February'),
(3, 'March'),
(4, 'April'),
(5, 'May'),
(6, 'June'),
(7, 'July'),
(8, 'August'),
(9, 'September'),
(10, 'October'),
(11, 'November'),
(12, 'December');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `idnotification` int(11) NOT NULL,
  `pesan` text NOT NULL,
  `waktu` datetime NOT NULL,
  `status` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `notifications`
--

INSERT INTO `notifications` (`idnotification`, `pesan`, `waktu`, `status`) VALUES
(0, 'Pesanan Baru Dari Sion dengan Invoice ORDER-5-ea86c004-2945-4735-8a5d-304ca582bbc4 dengan status pending', '2025-04-28 11:03:57', 'read'),
(0, 'Pesanan Baru Dari Sion dengan Invoice ORDER-6-dbdb6006-d6af-4c60-bdb8-ac90d4a414b8 dengan status pending', '2025-04-28 19:50:19', 'read'),
(0, 'Pesanan Baru Dari Sion dengan Invoice ORDER-7-7505b3a6-f61a-47cf-80d0-74c79b7746d5 dengan status pending', '2025-05-02 13:49:32', 'read'),
(0, 'Pesanan Baru Dari Sion dengan Invoice ORDER-8-09d3d72e-7ff1-43ae-b435-497b2eda14be dengan status pending', '2025-05-03 00:28:16', 'read'),
(0, 'Pesanan Baru Dari Sion dengan Invoice ORDER-9-bfcd5ec7-20ea-4186-a4e4-5db36fc31d1e dengan status pending', '2025-05-03 00:40:58', 'read'),
(0, 'Pesanan Baru Dari Sion dengan Invoice ORDER-10-c0adabab-6c4d-45d6-b05e-08f62128a055 dengan status pending', '2025-05-03 00:42:43', 'read'),
(0, 'Pesanan Baru Dari Sion dengan Invoice ORDER-11-1730be52-f4a7-4c8a-8225-a7f41c5dfc0a dengan status pending', '2025-05-03 00:43:58', 'read'),
(0, 'Pesanan Baru Dari Sion dengan Invoice ORDER-12-79d27403-7281-44fc-ab65-6fe94c9a1981 dengan status pending', '2025-05-03 00:51:46', 'read'),
(0, 'Pesanan Baru Dari Sion dengan Invoice ORDER-13-c4ee920e-ee20-4b9e-a010-925c394a9fba dengan status pending', '2025-05-03 01:01:51', 'read'),
(0, 'Pesanan Baru Dari Sion dengan Invoice ORDER-14-8e0594ce-23c8-4f8e-954d-a6690bcf9445 dengan status pending', '2025-05-03 01:04:04', 'read'),
(0, 'Pesanan Baru Dari Sion dengan Invoice ORDER-15-59021a2b-26f9-45eb-a210-082195ca389c dengan status pending', '2025-05-03 01:05:57', 'read'),
(0, 'Pesanan Baru Dari Sion pardosi dengan Invoice ORDER-16-72d6d34b-8a04-41b6-bcc6-efa0299c3ac3 dengan status pending', '2025-05-03 22:13:46', 'read'),
(0, 'Pesanan Baru Dari saut dengan Invoice ORDER-17-0e9fce49-d7f0-4f96-8a88-f96fdea5c1c7 dengan status pending', '2025-05-03 23:01:12', 'read'),
(0, 'Pesanan Baru Dari Sion pardosi dengan Invoice ORDER-18-ec00b894-afd2-422a-9a37-aae4ef189a67 dengan status pending', '2025-05-05 08:44:21', 'read'),
(0, 'Pesanan Baru Dari Listra dengan Invoice ORDER-19-c39a4383-4b7f-4260-bb1f-cf04f41d6948 dengan status pending', '2025-05-05 14:55:27', 'read'),
(0, 'Pesanan Baru Dari Listra dengan Invoice ORDER-20-144fa78d-80c0-42c8-9717-181d4bc56116 dengan status pending', '2025-05-05 15:02:49', 'read'),
(0, 'Pesanan Baru Dari Listra dengan Invoice ORDER-21-4014db14-0765-40dd-bf72-00b8c8c63675 dengan status pending', '2025-05-06 00:13:47', 'read'),
(0, 'Pesanan Baru Dari Listra dengan Invoice ORDER-22-5d84d234-b109-497b-bcc0-bfec0edf853c dengan status pending', '2025-05-06 14:16:48', 'read'),
(0, 'Pesanan Baru Dari Efran Lumbantoruan dengan Invoice ORDER-23-d770f4e2-17a3-41e5-8925-7c8ea9b4836d dengan status pending', '2025-05-06 19:21:39', 'unread');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `discount` decimal(15,2) NOT NULL,
  `tax` decimal(15,2) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locality` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `landmark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'home',
  `status` enum('ordered','delivered','canceled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ordered',
  `is_shipping_different` tinyint(1) NOT NULL DEFAULT 0,
  `delivered_date` date DEFAULT NULL,
  `canceled_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `subtotal`, `discount`, `tax`, `total`, `name`, `phone`, `locality`, `address`, `city`, `state`, `country`, `landmark`, `zip`, `type`, `status`, `is_shipping_different`, `delivered_date`, `canceled_date`, `created_at`, `updated_at`) VALUES
(1, 1, '119000.00', '0.00', '24990.00', '143990.00', 'Sion', '1234563535', 'b', 'b', 'b', 'b', '', 'b', '223123', 'home', 'ordered', 0, NULL, NULL, '2025-04-28 03:58:28', '2025-04-28 03:58:28'),
(2, 1, '119000.00', '0.00', '24990.00', '143990.00', 'Sion', '1234563535', 'b', 'b', 'b', 'b', '', 'b', '223123', 'home', 'ordered', 0, NULL, NULL, '2025-04-28 03:59:13', '2025-04-28 03:59:13'),
(3, 1, '119000.00', '0.00', '24990.00', '143990.00', 'Sion', '1234563535', 'b', 'b', 'b', 'b', '', 'b', '223123', 'home', 'ordered', 0, NULL, NULL, '2025-04-28 04:02:25', '2025-04-28 04:02:25'),
(4, 1, '119000.00', '0.00', '24990.00', '143990.00', 'Sion', '1234563535', 'b', 'b', 'b', 'b', '', 'b', '223123', 'home', 'ordered', 0, NULL, NULL, '2025-04-28 04:02:42', '2025-04-28 04:02:42'),
(5, 1, '119000.00', '0.00', '24990.00', '143990.00', 'Sion', '1234563535', 'b', 'b', 'b', 'b', '', 'b', '223123', 'home', 'ordered', 0, NULL, NULL, '2025-04-28 04:03:56', '2025-04-28 04:03:56'),
(6, 1, '30000.00', '0.00', '6300.00', '36300.00', 'Sion', '1234563535', 'b', 'b', 'b', 'b', '', 'b', '223123', 'home', 'ordered', 0, NULL, NULL, '2025-04-28 12:50:17', '2025-04-28 12:50:17'),
(7, 1, '422000.00', '0.00', '88620.00', '510620.00', 'Sion', '1234563535', 'b', 'b', 'b', 'b', '', 'b', '223123', 'home', 'ordered', 0, NULL, NULL, '2025-05-02 06:49:30', '2025-05-02 06:49:30'),
(8, 1, '150000.00', '0.00', '31500.00', '181500.00', 'Sion', '1234563535', 'b', 'b', 'b', 'b', '', 'b', '223123', 'home', 'ordered', 0, NULL, NULL, '2025-05-02 17:28:14', '2025-05-02 17:28:14'),
(9, 1, '150000.00', '0.00', '31500.00', '181500.00', 'Sion', '1234563535', 'b', 'b', 'b', 'b', '', 'b', '223123', 'home', 'ordered', 0, NULL, NULL, '2025-05-02 17:40:57', '2025-05-02 17:40:57'),
(10, 1, '89000.00', '0.00', '18690.00', '107690.00', 'Sion', '1234563535', 'b', 'b', 'b', 'b', '', 'b', '223123', 'home', 'ordered', 0, NULL, NULL, '2025-05-02 17:42:41', '2025-05-02 17:42:41'),
(11, 1, '150000.00', '0.00', '31500.00', '181500.00', 'Sion', '1234563535', 'b', 'b', 'b', 'b', '', 'b', '223123', 'home', 'ordered', 0, NULL, NULL, '2025-05-02 17:43:57', '2025-05-02 17:43:57'),
(12, 1, '150000.00', '0.00', '31500.00', '181500.00', 'Sion', '1234563535', 'b', 'b', 'b', 'b', '', 'b', '223123', 'home', 'ordered', 0, NULL, NULL, '2025-05-02 17:51:45', '2025-05-02 17:51:45'),
(13, 1, '89000.00', '0.00', '18690.00', '107690.00', 'Sion', '1234563535', 'b', 'b', 'b', 'b', '', 'b', '223123', 'home', 'ordered', 0, NULL, NULL, '2025-05-02 18:01:50', '2025-05-02 18:01:50'),
(14, 1, '89000.00', '0.00', '18690.00', '107690.00', 'Sion', '1234563535', 'b', 'b', 'b', 'b', '', 'b', '223123', 'home', 'ordered', 0, NULL, NULL, '2025-05-02 18:04:02', '2025-05-02 18:04:02'),
(15, 1, '89000.00', '0.00', '18690.00', '107690.00', 'Sion', '1234563535', 'b', 'b', 'b', 'b', '', 'b', '223123', 'home', 'ordered', 0, NULL, NULL, '2025-05-02 18:05:56', '2025-05-02 18:05:56'),
(16, 1, '150000.00', '0.00', '31500.00', '181500.00', 'Sion pardosi', '1234563535', 'b', 'b', 'b', 'b', '', 'b', '223123', 'home', 'ordered', 0, NULL, NULL, '2025-05-03 15:13:44', '2025-05-03 15:13:44'),
(17, 1, '150000.00', '0.00', '31500.00', '181500.00', 'saut', '12121212121212', 'balige', 'balige', 'balige', 'balige', 'Indonesia', 'balige', '123456', 'home', 'ordered', 0, NULL, NULL, '2025-05-03 16:01:12', '2025-05-03 16:01:12'),
(18, 1, '150000.00', '0.00', '31500.00', '181500.00', 'Sion pardosi', '1234563535', 'b', 'b', 'b', 'b', '', 'b', '223123', 'home', 'ordered', 0, NULL, NULL, '2025-05-05 01:44:20', '2025-05-05 01:44:20'),
(19, 3, '900000.00', '0.00', '189000.00', '1089000.00', 'Listra', '0822790182', 'Balige', 'Balige', 'Balige', 'Balige', 'Indonesia', 'Balige', '123456', 'home', 'ordered', 0, NULL, NULL, '2025-05-05 07:55:26', '2025-05-05 07:55:26'),
(20, 3, '6450000.00', '0.00', '1354500.00', '7804500.00', 'Listra', '0822790182', 'Balige', 'Balige', 'Balige', 'Balige', 'Indonesia', 'Balige', '123456', 'home', 'ordered', 0, NULL, NULL, '2025-05-05 08:02:48', '2025-05-05 08:02:48'),
(21, 3, '360000.00', '0.00', '75600.00', '435600.00', 'Listra', '0822790182', 'Balige', 'Balige', 'Balige', 'Balige', 'Indonesia', 'Balige', '123456', 'home', 'ordered', 0, NULL, NULL, '2025-05-05 17:13:46', '2025-05-05 17:13:46'),
(22, 3, '171000.00', '0.00', '35910.00', '206910.00', 'Listra', '0822790182', 'Balige', 'Balige', 'Balige', 'Balige', 'Indonesia', 'Balige', '123456', 'home', 'ordered', 0, NULL, NULL, '2025-05-06 07:16:46', '2025-05-06 07:16:46'),
(23, 15, '150000.00', '0.00', '31500.00', '181500.00', 'Efran Lumbantoruan', '081802248805', 'Sumatera utara,Toba,Balige', 'Indonesia', 'Toba Samosir', 'Sumatera Utara', 'Indonesia', '12', '123', 'home', 'ordered', 0, NULL, NULL, '2025-05-06 12:21:37', '2025-05-06 12:21:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `options` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rstatus` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `order_items`
--

INSERT INTO `order_items` (`id`, `product_id`, `order_id`, `price`, `quantity`, `options`, `rstatus`, `created_at`, `updated_at`) VALUES
(1, 23, 1, '89000.00', 1, NULL, 0, '2025-04-28 03:58:28', '2025-04-28 03:58:28'),
(2, 22, 1, '30000.00', 1, NULL, 0, '2025-04-28 03:58:28', '2025-04-28 03:58:28'),
(3, 23, 2, '89000.00', 1, NULL, 0, '2025-04-28 03:59:13', '2025-04-28 03:59:13'),
(4, 22, 2, '30000.00', 1, NULL, 0, '2025-04-28 03:59:13', '2025-04-28 03:59:13'),
(5, 23, 3, '89000.00', 1, NULL, 0, '2025-04-28 04:02:25', '2025-04-28 04:02:25'),
(6, 22, 3, '30000.00', 1, NULL, 0, '2025-04-28 04:02:25', '2025-04-28 04:02:25'),
(7, 23, 4, '89000.00', 1, NULL, 0, '2025-04-28 04:02:42', '2025-04-28 04:02:42'),
(8, 22, 4, '30000.00', 1, NULL, 0, '2025-04-28 04:02:42', '2025-04-28 04:02:42'),
(9, 23, 5, '89000.00', 1, NULL, 0, '2025-04-28 04:03:56', '2025-04-28 04:03:56'),
(10, 22, 5, '30000.00', 1, NULL, 0, '2025-04-28 04:03:56', '2025-04-28 04:03:56'),
(11, 22, 6, '30000.00', 1, NULL, 0, '2025-04-28 12:50:17', '2025-04-28 12:50:17'),
(12, 18, 7, '11000.00', 3, NULL, 0, '2025-05-02 06:49:30', '2025-05-02 06:49:30'),
(13, 23, 7, '89000.00', 1, NULL, 0, '2025-05-02 06:49:30', '2025-05-02 06:49:30'),
(14, 24, 7, '150000.00', 2, NULL, 0, '2025-05-02 06:49:30', '2025-05-02 06:49:30'),
(15, 24, 8, '150000.00', 1, NULL, 0, '2025-05-02 17:28:14', '2025-05-02 17:28:14'),
(16, 24, 9, '150000.00', 1, NULL, 0, '2025-05-02 17:40:57', '2025-05-02 17:40:57'),
(17, 23, 10, '89000.00', 1, NULL, 0, '2025-05-02 17:42:41', '2025-05-02 17:42:41'),
(18, 24, 11, '150000.00', 1, NULL, 0, '2025-05-02 17:43:57', '2025-05-02 17:43:57'),
(19, 24, 12, '150000.00', 1, NULL, 0, '2025-05-02 17:51:45', '2025-05-02 17:51:45'),
(20, 23, 13, '89000.00', 1, NULL, 0, '2025-05-02 18:01:50', '2025-05-02 18:01:50'),
(21, 23, 14, '89000.00', 1, NULL, 0, '2025-05-02 18:04:02', '2025-05-02 18:04:02'),
(22, 23, 15, '89000.00', 1, NULL, 0, '2025-05-02 18:05:56', '2025-05-02 18:05:56'),
(23, 24, 16, '150000.00', 1, NULL, 0, '2025-05-03 15:13:44', '2025-05-03 15:13:44'),
(24, 24, 17, '150000.00', 1, NULL, 0, '2025-05-03 16:01:12', '2025-05-03 16:01:12'),
(25, 24, 18, '150000.00', 1, NULL, 0, '2025-05-05 01:44:20', '2025-05-05 01:44:20'),
(26, 24, 19, '150000.00', 6, NULL, 0, '2025-05-05 07:55:26', '2025-05-05 07:55:26'),
(27, 24, 20, '150000.00', 43, NULL, 0, '2025-05-05 08:02:48', '2025-05-05 08:02:48'),
(28, 22, 21, '30000.00', 12, NULL, 0, '2025-05-05 17:13:46', '2025-05-05 17:13:46'),
(29, 24, 22, '150000.00', 1, NULL, 0, '2025-05-06 07:16:46', '2025-05-06 07:16:46'),
(30, 21, 22, '21000.00', 1, NULL, 0, '2025-05-06 07:16:46', '2025-05-06 07:16:46'),
(31, 24, 23, '150000.00', 1, NULL, 0, '2025-05-06 12:21:37', '2025-05-06 12:21:37');

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
-- Struktur dari tabel `penjadwalan_penjemputans`
--

CREATE TABLE `penjadwalan_penjemputans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_request_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_jemput` date NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estimasi_kg` double NOT NULL,
  `status_jemput` enum('terjadwal','dijemput','dibatalkan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'terjadwal',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kecamatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail_lokasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `penjadwalan_penjemputans`
--

INSERT INTO `penjadwalan_penjemputans` (`id`, `supplier_request_id`, `tanggal_jemput`, `lokasi`, `estimasi_kg`, `status_jemput`, `created_at`, `updated_at`, `kecamatan`, `desa`, `detail_lokasi`) VALUES
(2, 12, '2025-05-10', NULL, 11, 'terjadwal', '2025-05-01 04:38:13', '2025-05-01 04:38:13', 'Onan Runggu', 'Huta Hotang', 'dsd'),
(3, 31, '2025-05-03', NULL, 1, 'terjadwal', '2025-05-01 17:01:59', '2025-05-01 17:01:59', 'Nainggolan', 'Toguan Galung', 'asas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 2, 'auth_token', 'f47ac60f4997de0b3efc51e7655c3c199b051de479afdf416e80c2cfb513c114', '[\"*\"]', NULL, NULL, '2025-04-27 15:21:07', '2025-04-27 15:21:07'),
(2, 'App\\Models\\User', 2, 'auth_token', '155f6964f2a53c1b65fa24ff78340e1d71f7d126f48d06efe059c484357d650f', '[\"*\"]', NULL, NULL, '2025-04-27 15:30:27', '2025-04-27 15:30:27'),
(3, 'App\\Models\\User', 3, 'auth_token', '551bbd5ed25034d875d51d72f72773045b5d51dd524bcbddecc7744caf1f9b67', '[\"*\"]', NULL, NULL, '2025-04-28 00:47:32', '2025-04-28 00:47:32'),
(4, 'App\\Models\\User', 3, 'auth_token', '780cb1468671101b59c64c9115cb8010206b4e4dda988b18caa2dca7d708a6c9', '[\"*\"]', NULL, NULL, '2025-04-28 00:47:32', '2025-04-28 00:47:32'),
(5, 'App\\Models\\User', 3, 'auth_token', '05e462ffca509590595dc897cd262f3634437d6a8c8422b67eb8963b92869cae', '[\"*\"]', NULL, NULL, '2025-04-28 00:53:13', '2025-04-28 00:53:13'),
(6, 'App\\Models\\User', 3, 'auth_token', '70861b31ca5cf69a91a29c6ea507865e5a39ea50aa4fe951765043dbbcbf89b1', '[\"*\"]', NULL, NULL, '2025-04-28 00:53:13', '2025-04-28 00:53:13'),
(7, 'App\\Models\\User', 2, 'auth_token', 'cb9964b22fb4065f4f55c5b9dd070d941b3e6503b833dda23a1e1c19e57e1141', '[\"*\"]', NULL, NULL, '2025-04-28 01:03:38', '2025-04-28 01:03:38'),
(8, 'App\\Models\\User', 3, 'auth_token', 'a8adb120c60c156860e556e620b5ec80a7bc2730f61e6f556fb814c130f075fb', '[\"*\"]', NULL, NULL, '2025-04-28 03:22:40', '2025-04-28 03:22:40'),
(9, 'App\\Models\\User', 3, 'auth_token', '20770787d63e0aaa64e2087721fc0d04f369003835022650aa5c7ca847823709', '[\"*\"]', NULL, NULL, '2025-04-28 03:22:40', '2025-04-28 03:22:40'),
(10, 'App\\Models\\User', 3, 'auth_token', 'f30f96cc47e6581d2d8848117a51c95d57e1747cfd1dc893095de417a83858cf', '[\"*\"]', NULL, NULL, '2025-04-28 03:29:10', '2025-04-28 03:29:10'),
(11, 'App\\Models\\User', 3, 'auth_token', '63a2a5de8f8764a7881bcee4b3c1bdbfc30cc1e9028630f7df3a9ad4da5e975c', '[\"*\"]', NULL, NULL, '2025-04-28 03:29:10', '2025-04-28 03:29:10'),
(12, 'App\\Models\\User', 3, 'auth_token', '800fa5c09e23caa8948886999b49b6c0d1af30fc8b6995024c7c53a5b1fb8eb2', '[\"*\"]', NULL, NULL, '2025-04-28 03:29:52', '2025-04-28 03:29:52'),
(13, 'App\\Models\\User', 3, 'auth_token', '3d6cba737e72159e7bb32a418ea7ae203be546cb6bd20659e3e0eb544a09e9ec', '[\"*\"]', NULL, NULL, '2025-04-28 03:29:52', '2025-04-28 03:29:52'),
(14, 'App\\Models\\User', 3, 'auth_token', 'cd274d1694656002b37e99e974835475c003cf204873b1d7cc7343046d28d93d', '[\"*\"]', NULL, NULL, '2025-04-28 03:30:08', '2025-04-28 03:30:08'),
(15, 'App\\Models\\User', 3, 'auth_token', 'a53bc506e724bb27f14596e4b1baba6dba3ff2cea3ca1c4c634cb7d8224a4300', '[\"*\"]', NULL, NULL, '2025-04-28 03:30:08', '2025-04-28 03:30:08'),
(16, 'App\\Models\\User', 3, 'auth_token', 'f860499a1ae18e6f2dcaf35c417dc8e8fc20ae8b4809bd73130f3b8060a03084', '[\"*\"]', NULL, NULL, '2025-04-28 03:30:25', '2025-04-28 03:30:25'),
(17, 'App\\Models\\User', 3, 'auth_token', 'f7b6dc0d445711304915038bca52cacb03c01f2a5698ed883cd40bc9dec4ecdb', '[\"*\"]', NULL, NULL, '2025-04-28 03:30:25', '2025-04-28 03:30:25'),
(18, 'App\\Models\\User', 3, 'auth_token', '6be61c05242657425bb3f2c45d83448c76a1255d662ddc8bc45b1a2e1b86a253', '[\"*\"]', NULL, NULL, '2025-04-28 03:30:38', '2025-04-28 03:30:38'),
(19, 'App\\Models\\User', 3, 'auth_token', 'f667a1ea0710477355e714b6a4d76f782b562665dc9f4c82d331f38e4302b7da', '[\"*\"]', NULL, NULL, '2025-04-28 03:30:38', '2025-04-28 03:30:38'),
(20, 'App\\Models\\User', 3, 'auth_token', '31bade1f857bb3ab7de1e2c2882567e540534a5b74bdbe74e16b83a29986cce6', '[\"*\"]', NULL, NULL, '2025-04-28 03:30:39', '2025-04-28 03:30:39'),
(21, 'App\\Models\\User', 3, 'auth_token', 'bb66acb017f7607d57683fb14069b8aa73c3d53a7352e7020c428f799987021e', '[\"*\"]', NULL, NULL, '2025-04-28 03:30:39', '2025-04-28 03:30:39'),
(22, 'App\\Models\\User', 3, 'auth_token', '956396d6b6c36b9040f59e7b9abd2632ed6e7efed87a1aa7e8072088c92ceb2f', '[\"*\"]', NULL, NULL, '2025-04-28 03:30:41', '2025-04-28 03:30:41'),
(23, 'App\\Models\\User', 3, 'auth_token', 'be27aa09871c1196f208d69a0648cfeef0e813d37976c6d569a094aab0b11f65', '[\"*\"]', NULL, NULL, '2025-04-28 03:30:41', '2025-04-28 03:30:41'),
(24, 'App\\Models\\User', 3, 'auth_token', 'f7369eeb26b16f39c06dff68aefd137f438bc94c74e193d3bd57101afb4b6769', '[\"*\"]', NULL, NULL, '2025-04-28 03:30:42', '2025-04-28 03:30:42'),
(25, 'App\\Models\\User', 3, 'auth_token', '83bf431e602d761ef47cc0b78382c5eb5e70858d0e87de64682ad63d0b2fbb76', '[\"*\"]', NULL, NULL, '2025-04-28 03:30:42', '2025-04-28 03:30:42'),
(26, 'App\\Models\\User', 3, 'auth_token', 'dd1d7168969da96f8545e5d1fd234c0fe1e6a4c9d049535d7ee214595e482c19', '[\"*\"]', NULL, NULL, '2025-04-28 03:30:42', '2025-04-28 03:30:42'),
(27, 'App\\Models\\User', 3, 'auth_token', 'dab3cb0c1134429ae4c60c5d900d6220c60ce7906350a97451f92941ec50f3f5', '[\"*\"]', NULL, NULL, '2025-04-28 03:30:42', '2025-04-28 03:30:42'),
(28, 'App\\Models\\User', 3, 'auth_token', 'b3c32774b7c3346ab39cff4d574c19ce92db066d658dd25d11a3019cc65b57b1', '[\"*\"]', NULL, NULL, '2025-04-28 03:30:43', '2025-04-28 03:30:43'),
(29, 'App\\Models\\User', 3, 'auth_token', '283e127f0f0224b7627a139672221916c792379d8d032a54ae66521c06679aef', '[\"*\"]', NULL, NULL, '2025-04-28 03:30:43', '2025-04-28 03:30:43'),
(30, 'App\\Models\\User', 3, 'auth_token', '1d414031b793d8f2a0171bdabee955abf8c1e2059101514cf0e148ab1d0f25bb', '[\"*\"]', NULL, NULL, '2025-04-28 03:30:44', '2025-04-28 03:30:44'),
(31, 'App\\Models\\User', 3, 'auth_token', '972cdda3d4799f5fa03cd0c3c13ef6e14491605092556ca2e554626d8e3b6428', '[\"*\"]', NULL, NULL, '2025-04-28 03:30:44', '2025-04-28 03:30:44'),
(32, 'App\\Models\\User', 3, 'auth_token', '1cc12f58edf8451ce3e74822964feb653e09df381627a139e3ae19837f41a0dd', '[\"*\"]', NULL, NULL, '2025-04-28 03:32:01', '2025-04-28 03:32:01'),
(33, 'App\\Models\\User', 3, 'auth_token', '8f6af61f893a9a5354ec7352cc5a6a030599579014c3b7e855cfb56bccb2efcc', '[\"*\"]', NULL, NULL, '2025-04-28 03:32:01', '2025-04-28 03:32:01'),
(34, 'App\\Models\\User', 2, 'auth_token', 'd0102318d52195b846999583a5887439b4f3866c4bdd72fcda9afbaed689a77d', '[\"*\"]', NULL, NULL, '2025-04-28 07:20:57', '2025-04-28 07:20:57'),
(35, 'App\\Models\\User', 2, 'auth_token', '0e2e1e7a24283469d43901e49775599401b516519fe0ac87004b9e0860329e34', '[\"*\"]', NULL, NULL, '2025-04-28 07:23:39', '2025-04-28 07:23:39'),
(36, 'App\\Models\\User', 2, 'auth_token', '52088c6cdbdbd3607a3f88c36c169b35ecdb72a91e1d0b6d44e630437f3e37f1', '[\"*\"]', NULL, NULL, '2025-04-28 07:26:47', '2025-04-28 07:26:47'),
(37, 'App\\Models\\User', 2, 'auth_token', '5adc985931804c89cfc6f47dca9d89070f7fd1824ce349192b33d44a41585a62', '[\"*\"]', NULL, NULL, '2025-04-28 07:30:03', '2025-04-28 07:30:03'),
(38, 'App\\Models\\User', 2, 'auth_token', '55d9ff1536a276f3bb7aa2dd851294f35e40fba3fe8a64e025fed908cc28f8c0', '[\"*\"]', NULL, NULL, '2025-04-28 16:22:04', '2025-04-28 16:22:04'),
(39, 'App\\Models\\User', 2, 'auth_token', '09872443c41ccc6273517f2c88de7c982d0699c0387e3a84db65eda872048e52', '[\"*\"]', NULL, NULL, '2025-04-28 16:22:28', '2025-04-28 16:22:28'),
(40, 'App\\Models\\User', 2, 'auth_token', 'cca25b3b0626c11f336047d5b64e9432322863c6ad899c5b134b86fcb8352775', '[\"*\"]', NULL, NULL, '2025-05-01 14:17:20', '2025-05-01 14:17:20'),
(41, 'App\\Models\\User', 2, 'auth_token', 'be6e95d544fe27e8716d834dc4eb650e39b9a46433bb6578d1bbf1249c829c63', '[\"*\"]', NULL, NULL, '2025-05-01 14:39:53', '2025-05-01 14:39:53'),
(42, 'App\\Models\\User', 2, 'auth_token', '3b429b4ca9ccab0b67bf0f725930e0ca93f04892b0d1375d035770a26614ad12', '[\"*\"]', NULL, NULL, '2025-05-01 14:50:09', '2025-05-01 14:50:09'),
(43, 'App\\Models\\User', 2, 'auth_token', 'a53673846e351827b69ac1ba236d5613fd2bd30acbe266d07a8967664bc5ed78', '[\"*\"]', NULL, NULL, '2025-05-01 14:52:25', '2025-05-01 14:52:25'),
(44, 'App\\Models\\User', 2, 'auth_token', 'ab910977d385b79991908188e9c24fcbd44d71853ad4784f5633e3435b09f934', '[\"*\"]', NULL, NULL, '2025-05-01 15:49:10', '2025-05-01 15:49:10'),
(45, 'App\\Models\\User', 2, 'auth_token', '83bc08662c0777dcb4bcc76ffdf30d077f4b0560eeebd52fce2564bcf8118393', '[\"*\"]', NULL, NULL, '2025-05-01 16:08:23', '2025-05-01 16:08:23'),
(46, 'App\\Models\\User', 2, 'auth_token', '9ffeced609966ea63178bb2c61eb5179e55df5d490020cf4ba7166eec2c87127', '[\"*\"]', NULL, NULL, '2025-05-01 16:35:47', '2025-05-01 16:35:47'),
(47, 'App\\Models\\User', 3, 'auth_token', '34b008c27d25445e40e7be2380603ec9a15d5a13ce10a6bc6f10973d40832892', '[\"*\"]', NULL, NULL, '2025-05-05 06:08:33', '2025-05-05 06:08:33'),
(48, 'App\\Models\\User', 3, 'auth_token', '96dbb8d239ecba6ad68b02f08a337f62b7c3a0967ddd294703a8e8c9b05cfcd6', '[\"*\"]', NULL, NULL, '2025-05-05 06:08:33', '2025-05-05 06:08:33'),
(49, 'App\\Models\\User', 3, 'auth_token', '471f5dea9e8777f971d9045ad518438cc9bf0caec45844709a428612ed0e8cb2', '[\"*\"]', NULL, NULL, '2025-05-05 06:24:57', '2025-05-05 06:24:57'),
(50, 'App\\Models\\User', 3, 'auth_token', '01f73c3a4ccee00a2f2806720ee94a2382e5deca46a7ab3cf3e45bf345f0b9cd', '[\"*\"]', NULL, NULL, '2025-05-05 06:24:57', '2025-05-05 06:24:57'),
(51, 'App\\Models\\User', 3, 'auth_token', 'd1a29450fae929027346ecb5168bd1f3e367ad6ad975088e2e3b3fc199431dc5', '[\"*\"]', NULL, NULL, '2025-05-05 06:25:04', '2025-05-05 06:25:04'),
(52, 'App\\Models\\User', 3, 'auth_token', '77102cbb81d9fb56986a141791df363532a5a17b8a7b1904efee3907e8d2aa91', '[\"*\"]', NULL, NULL, '2025-05-05 06:25:04', '2025-05-05 06:25:04'),
(53, 'App\\Models\\User', 3, 'auth_token', '7940fe6eedf815655f96ac16f2c27d900604339abfb9eefe5ed6bb95a9c28c20', '[\"*\"]', NULL, NULL, '2025-05-05 06:25:46', '2025-05-05 06:25:46'),
(54, 'App\\Models\\User', 3, 'auth_token', '6997b98b2b494a2ec1d56b9f86a5725b89333b7c0449a2d7d4fc05d017d94c63', '[\"*\"]', NULL, NULL, '2025-05-05 06:25:46', '2025-05-05 06:25:46'),
(55, 'App\\Models\\User', 3, 'auth_token', '635796975aa20cb3b0aa91e5f906ed9c83f2aa5627a5de68d2e484f9789f1ef7', '[\"*\"]', NULL, NULL, '2025-05-05 06:41:28', '2025-05-05 06:41:28'),
(56, 'App\\Models\\User', 3, 'auth_token', 'd3079802ae65f2e4b441d9b2b935d41e16fc3888854df691500c89222d6160bd', '[\"*\"]', NULL, NULL, '2025-05-05 06:41:28', '2025-05-05 06:41:28');

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
  `regular_price` decimal(15,2) NOT NULL,
  `sale_price` decimal(15,2) NOT NULL,
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
(17, 'Sendal Anyaman Eceng Gondok', 'sendal-anyaman-eceng-gondok', 'Sendal Anyaman Eceng Gondok Samosir', 'Sendal Anyaman Eceng Gondok Samosir', '25000.00', '25000.00', 'sendal000001', 'instock', 1, 30, '1745404000.jpg', '1745404000-1.png,1745404000-2.png,1745404000-3.png', 16, 6, '2025-04-23 03:26:42', '2025-04-23 03:26:42'),
(18, 'Karpet Anyaman Eceng Gondok', 'karpet-anyaman-eceng-gondok', 'Karpet Anyaman Eceng Gondok Samosir', 'Karpet Anyaman Eceng Gondok Samosir', '12000.00', '11000.00', 'karpet0000001', 'instock', 1, 16, '1745404380.jpg', '1745404380-1.jpg', 13, 6, '2025-04-23 03:33:00', '2025-04-23 03:33:00'),
(19, 'Tas Enceng Gondok Anyaman Samosir', 'tas-enceng-gondok-anyaman-samosir', 'Tas Enceng Gondok Anyaman Samosir', 'Tas Enceng Gondok Anyaman Samosir', '94000.00', '49000.00', 'tas0000001', 'instock', 1, 7, '1745404445.jpg', '1745404445-1.jpg,1745404445-2.jpg', 18, 6, '2025-04-23 03:34:06', '2025-04-23 03:34:06'),
(20, 'Cover dan Bantal Anyaman Eceng Gondok', 'cover-dan-bantal-anyaman-eceng-gondok', 'Cover dan Bantal Anyaman Eceng Gondok', 'Cover dan Bantal Anyaman Eceng Gondok', '50000.00', '49000.00', 'bantal0000001', 'instock', 1, 90, '1745404545.jpg', '1745404545-1.jpg,1745404545-2.jpg', 17, 6, '2025-04-23 03:35:46', '2025-04-23 03:35:46'),
(21, 'Topi Anyaman Eceng Gondok Samosir', 'topi-anyaman-eceng-gondok-samosir', 'Topi Anyaman Eceng Gondok Samosir', 'Topi Anyaman Eceng Gondok Samosir', '59000.00', '21000.00', 'topi00001', 'instock', 1, 40, '1745404704.avif', '1745404704-1.jpg', 11, 6, '2025-04-23 03:38:29', '2025-04-23 03:41:13'),
(22, 'Kotak Cover Tissue Anyaman Eceng Gondok', 'kotak-cover-tissue-anyaman-eceng-gondok', 'Kotak Cover Tissue Anyaman Eceng Gondok Samosir', 'Kotak Cover Tissue Anyaman Eceng Gondok', '30000.00', '30000.00', 'kotaktissue000001', 'instock', 1, 12, '1745404943.webp', '1745404943-1.jpg', 12, 6, '2025-04-23 03:42:23', '2025-04-23 03:42:23'),
(23, 'Kotak Keranjang Anyaman Eceng Gondok', 'kotak-keranjang-anyaman-eceng-gondok', 'Kotak Keranjang Anyaman Eceng Gondok Samosir', 'Kotak Keranjang Anyaman Eceng Gondok Samosir', '90000.00', '89000.00', 'keranjang000001', 'instock', 1, 50, '1745405025.jpg', '1745405025-1.jpg,1745405025-2.jpg', 15, 6, '2025-04-23 03:43:46', '2025-04-23 03:43:46'),
(24, 'Cover Vas Bunga Anyaman Eceng Gondok', 'cover-vas-bunga-anyaman-eceng-gondok', 'Cover Vas Bunga Anyaman Eceng Gondok Samosir', 'Cover Vas Bunga Anyaman Eceng Gondok Samosir', '150000.00', '150000.00', 'vasbunga000001', 'instock', 1, 16, '1745405097.jpg', '1745405097-1.jpg', 19, 6, '2025-04-23 03:44:57', '2025-04-23 03:44:57');

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
('aCBuIHb2RMlXpVVrpPWeF69nUItGNg1Ejr64bKyo', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiV3RkWVZMOWhjSUlCMW5uVFJOUnZ4cjV1VFpzRzdQb3g2dnhQazVEcSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdXBwbGllciI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzQ2NTUzMDQwO31zOjQ6ImNhcnQiO2E6MTp7czo0OiJjYXJ0IjtPOjI5OiJJbGx1bWluYXRlXFN1cHBvcnRcQ29sbGVjdGlvbiI6Mjp7czo4OiIAKgBpdGVtcyI7YToxOntzOjMyOiJiYTAyYjBkZGRiMDAwYjI1NDQ1MTY4MzAwYzY1Mzg2ZCI7TzozNToiU3VyZnNpZGVtZWRpYVxTaG9wcGluZ2NhcnRcQ2FydEl0ZW0iOjk6e3M6NToicm93SWQiO3M6MzI6ImJhMDJiMGRkZGIwMDBiMjU0NDUxNjgzMDBjNjUzODZkIjtzOjI6ImlkIjtpOjIzO3M6MzoicXR5IjtpOjE7czo0OiJuYW1lIjtzOjM2OiJLb3RhayBLZXJhbmphbmcgQW55YW1hbiBFY2VuZyBHb25kb2siO3M6NToicHJpY2UiO2Q6ODkwMDA7czo3OiJvcHRpb25zIjtPOjQyOiJTdXJmc2lkZW1lZGlhXFNob3BwaW5nY2FydFxDYXJ0SXRlbU9wdGlvbnMiOjI6e3M6ODoiACoAaXRlbXMiO2E6MDp7fXM6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDt9czo1MjoiAFN1cmZzaWRlbWVkaWFcU2hvcHBpbmdjYXJ0XENhcnRJdGVtAGFzc29jaWF0ZWRNb2RlbCI7czoxODoiQXBwXE1vZGVsc1xQcm9kdWN0IjtzOjQ0OiIAU3VyZnNpZGVtZWRpYVxTaG9wcGluZ2NhcnRcQ2FydEl0ZW0AdGF4UmF0ZSI7aToyMTtzOjQ0OiIAU3VyZnNpZGVtZWRpYVxTaG9wcGluZ2NhcnRcQ2FydEl0ZW0AaXNTYXZlZCI7YjowO319czoyODoiACoAZXNjYXBlV2hlbkNhc3RpbmdUb1N0cmluZyI7YjowO319fQ==', 1746557544),
('babLFwHbi6m3I157ryskAZbuGuxOsVL8ZUeR8xDo', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiY2RadE5HNHBMejFZUExESmpBaG1oR3I2dFRrbkM1SnZyQ213VkJQdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzQ2NTUwMDY5O319', 1746550069),
('C0Qu63LLPyjOf2OUeQEqdrWJRjxQ5zs1SpQDQTcQ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSGw3TmNCTHRBcFlCc0FHdlZoa2IxNEpiY05LdUFldEJPakdMcjlreCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1746549866),
('nEzyGzVqUFboeVm7FNBo9cLt8NKc6oxRleOmTtra', NULL, '127.0.0.1', 'WhatsApp/2.2517.4 W', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibGZpNnRuS1Y2ZnZPeGxsTWVGdG5rNHROTktubTRyWkplY1pnQ1NUVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1746579866),
('nZ7rJXzweH2Bn59WElB61qHmLiZWbbxr4i8wNOAH', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQlg1QXdNWlJoT2hPR25qWlNFa2Iwb3pRWjVkYWZ3OEZwVHFWS2F1ayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1746549897),
('Puzvf6xTul2qBsIkdLANdTBMwmSEBZkmk9oUrGTz', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSWIwSVhCUm1kcE1vRzY0S2pkTXNWUmdnSmZKWDBCNXFscUpPY2NwUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zaG9wIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1746579930),
('rrRlQbQtdXgQeoRkWiIDq5l8afghGY8OGKFXlt0l', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVm53RkRWaHpZQ2w4ZjV4a3NHdWlMN2h3aWFOYk5ON2Y4VHNTZGFNeCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzQ2NTUwMDk1O319', 1746550095),
('uxxL2OYoTNN7xI9XHjPRHMf2Axv9m00vdMGRqVjS', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWTVreTJWNU1walVVTGhZWno0elBpYUhBR3pDUUU4Zlc3d3JZS3BTbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1746579858),
('Wj2pwoklsIWj3WNBo2esl2rxOnZnyBAlLszb2YA3', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSFUzM1dTOHE0ejdsZDlsM0RzanRQS1JybGNUdDlTejNUN2RXZW95RCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzQ2NTUwMDY0O319', 1746550064),
('WvCXlRM0pwZWH7CJahNhNqQYD5UnkOSClRYDwLEK', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic041OWpoS3dGMUlEdjVlc29ENnlvaFNHaHdDMmZrNXV4VVdVUUJLciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdXBwbGllciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1746579922);

-- --------------------------------------------------------

--
-- Struktur dari tabel `slides`
--

CREATE TABLE `slides` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tagline` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `slides`
--

INSERT INTO `slides` (`id`, `tagline`, `title`, `subtitle`, `link`, `image`, `status`, `created_at`, `updated_at`) VALUES
(5, 'Topi', 'Bank Koperasi', 'ECENG GONDOK', '/shop', '1745404301.png', 1, '2025-04-23 03:31:41', '2025-04-23 03:31:41'),
(6, 'Cover Kotak Tissue', 'Bank Koperasi', 'ECENG GONDOK', 'http://127.0.0.1:8000/shop?name=1&size=12&order=-1&brands=&categories=18&min=1&max=10000000', '1745859368.png', 1, '2025-04-28 16:53:16', '2025-04-28 16:56:40'),
(7, 'Bantal', 'Bank Koperasi', 'ECENG GONDOK', 'http://127.0.0.1:8000/shop?name=1&size=12&order=-1&brands=&categories=17&min=1&max=10000000', '1745859562.png', 1, '2025-04-28 16:59:23', '2025-04-28 16:59:23'),
(8, 'Vas Guci', 'Bank Koperasi', 'ECENG GONDOK', 'a', '1745859628.png', 1, '2025-04-28 17:00:29', '2025-04-28 17:00:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok_bahan_bakus`
--

CREATE TABLE `stok_bahan_bakus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah_kg` double NOT NULL,
  `sumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `request_id` bigint(20) UNSIGNED DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `stok_bahan_bakus`
--

INSERT INTO `stok_bahan_bakus` (`id`, `tanggal`, `jumlah_kg`, `sumber`, `request_id`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, '2025-04-27', 0, 'Request Pemasok', NULL, 'Otomatis dari permintaan disetujui', '2025-04-27 15:22:41', '2025-05-01 04:39:32'),
(2, '2025-04-27', 23, 'Request Pemasok', 2, 'Otomatis dari permintaan disetujui', '2025-04-27 15:32:18', '2025-04-27 15:32:18'),
(3, '2025-04-29', 12, 'Manual Input', NULL, 'qqw', '2025-04-27 15:37:09', '2025-04-27 15:37:09'),
(4, '2025-04-27', 23, 'Request Pemasok', 3, 'Otomatis dari permintaan disetujui', '2025-04-27 15:39:30', '2025-04-27 15:39:30'),
(5, '2025-04-28', 3, 'Request Pemasok', 4, 'Otomatis dari permintaan disetujui', '2025-04-28 07:26:21', '2025-04-28 07:26:21'),
(6, '2025-05-01', 11, 'Request Pemasok', 12, 'Otomatis dari permintaan disetujui', '2025-05-01 04:36:35', '2025-05-01 04:36:35'),
(7, '2025-05-02', 1, 'Request Pemasok', 31, 'Otomatis dari permintaan disetujui', '2025-05-01 17:01:09', '2025-05-01 17:01:09'),
(8, '2025-05-02', 1, 'Request Pemasok', 33, 'Otomatis dari permintaan disetujui', '2025-05-02 08:19:10', '2025-05-02 08:19:10'),
(9, '2025-05-06', 30, 'Request Pemasok', 43, 'Otomatis dari permintaan disetujui', '2025-05-06 16:49:56', '2025-05-06 16:49:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier_infos`
--

CREATE TABLE `supplier_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `supplier_infos`
--

INSERT INTO `supplier_infos` (`id`, `title`, `description`, `image`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Jadi Pemasok Eceng Gondok dan Dapatkan uang!', 'Jadi Pemasok Eceng Gondok dan Dapatkan WOW!Jadi Pemasok Eceng Gondok dan Dapatkan WOW!\r\n\r\n\r\nJadi Pemasok Eceng Gondok dan Dapatkan WOW!Jadi Pemasok Eceng Gondok dan Dapatkan WOW!\r\n\r\nJadi Pemasok Eceng Gondok dan Dapatkan WOW!Jadi Pemasok Eceng Gondok dan Dapatkan WOW!\r\n\r\nJadi Pemasok Eceng Gondok dan Dapatkan WOW!Jadi Pemasok Eceng Gondok dan Dapatkan WOW!', 'uploads/supplier_info/1746500646_Y80Gte.jpg', 2, 1, '2025-05-06 03:04:06', '2025-05-06 03:31:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier_requests`
--

CREATE TABLE `supplier_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_wa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Samosir',
  `estimasi_kg` double NOT NULL,
  `insentif` enum('diskon','uang_tunai') COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `coupon_id` bigint(20) UNSIGNED DEFAULT NULL,
  `catatan_admin` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kecamatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail_lokasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `supplier_requests`
--

INSERT INTO `supplier_requests` (`id`, `user_id`, `nama`, `email`, `no_hp`, `no_wa`, `lokasi`, `estimasi_kg`, `insentif`, `foto`, `catatan`, `status`, `coupon_id`, `catatan_admin`, `created_at`, `updated_at`, `kecamatan`, `desa`, `detail_lokasi`) VALUES
(2, 2, 'sion pardosi', 'sionpardosi12@gmail.com', '08227891213', '08227891213', NULL, 23, 'diskon', 'storage/foto_request/aw5NdAcUL0wX16WsAnPIhNzzOHXfsflq79Vky7RV.jpg', 'as', 'disetujui', 1, 'Diskon ditetapkan sebesar per kg. Diskon ditetapkan sebesar per kg. Diskon ditetapkan sebesar per kg. sasasasasasas', '2025-04-27 15:30:46', '2025-04-27 15:34:18', 'Onan Runggu', 'Janji Matogu', 'asas'),
(3, 1, 'Si', 'spardosi12@gmail.com', '12342455757', '12342455757', NULL, 23, 'uang_tunai', 'storage/foto_request/mrpMJYjnLyjwSYxDRX2kG3EGR7hwla3r1HXgqG3n.jpg', 'asas', 'disetujui', NULL, 'akan dihubungi melalui WA', '2025-04-27 15:35:20', '2025-04-27 15:39:30', 'Onan Runggu', 'Onan Runggu', 'asasas'),
(4, 2, 'sion pardosi', 'sionpardosi12@gmail.com', '082278900178', '082278900178', NULL, 3, 'diskon', 'storage/foto_request/PvJILMNDBDzxi1RrxbxPcew9YVaTc8XWFdgToe0U.jpg', 'simpang', 'disetujui', 2, 'Diskon ditetapkan sebesar per kg. sudah, jika ada yang ingin dihubungi silangkah hubungi', '2025-04-28 07:24:13', '2025-04-28 07:26:21', 'Onan Runggu', 'Huta Hotang', 'simpang'),
(5, 3, 'sumondang', 'sumondang@gmail.com', '121212121', '121212121', NULL, 1, 'uang_tunai', 'storage/foto_request/oj5VdcXUPngMbfwTzennicZ2gCPfBHdZxWUvNJEu.png', 'as', 'pending', NULL, NULL, '2025-04-30 09:02:12', '2025-04-30 09:02:12', 'Nainggolan', 'Sipinggan Lumban Siantar', 'asas'),
(6, 1, 'Si', 'spardosi12@gmail.com', '1121', '1121', NULL, 1, 'uang_tunai', 'storage/foto_request/TReS3wT9KOb9syNouxxIY1hTOT7Ag2EKcraSwVKs.png', 'qw', 'pending', NULL, NULL, '2025-04-30 09:02:57', '2025-04-30 09:02:57', 'Sianjur Mulamula', 'Sari Marihit', 'qwq'),
(7, 1, 'Si', 'spardosi12@gmail.com', '1212', '1212', NULL, 1, 'uang_tunai', 'storage/foto_request/PPvxlTSiSKxlXLbbk2PQzl8R4NZbhkFtl37ZF59i.png', 'qw', 'ditolak', NULL, 'maaf kami tidak menerima lagi', '2025-04-30 09:05:16', '2025-04-30 09:33:58', 'Ronggur Nihuta', 'Paraduan', '121'),
(9, 3, 'sumondang', 'sumondang@gmail.com', '24124124213', '24124124213', NULL, 2, 'uang_tunai', 'storage/foto_request/Iwf53dht1xLYqCSZxSbgHlY3cbERYFaffWRcoEsy.png', 'sdsd', 'pending', NULL, NULL, '2025-04-30 13:51:56', '2025-04-30 13:51:56', 'Nainggolan', 'Toguan Galung', 'wewd'),
(10, 1, 'Si', 'spardosi12@gmail.com', '1524123', '1524123', NULL, 23, 'uang_tunai', 'storage/foto_request/eO6nTvHKBZTLUzFg1dc2Z5iEmK62NyPw8xDFi4A9.png', 'we', 'pending', NULL, NULL, '2025-04-30 13:52:57', '2025-04-30 13:52:57', 'Nainggolan', 'Toguan Galung', 'wewe'),
(11, 1, 'Si', 'spardosi12@gmail.com', '1213123423', '1213123423', NULL, 2, 'uang_tunai', 'storage/foto_request/dLRhMwSwhvKlglXACgvyfe9ZbuOEB8j5tPKiiS2f.jpg', 'sdsd', 'pending', NULL, NULL, '2025-05-01 04:17:54', '2025-05-01 04:17:54', 'Sianjur Mulamula', 'Sari Marihit', 'sdad'),
(12, 1, 'Si', 'spardosi12@gmail.com', '08232323', '08232323', NULL, 11, 'uang_tunai', 'storage/foto_request/ojeBIPa3m8TLjFvjLUC3AMWtUFv2kiEmf5ap361h.png', 'asa', 'disetujui', NULL, 'baik akan segera meluncur', '2025-05-01 04:33:31', '2025-05-01 04:36:35', 'Nainggolan', 'Toguan Galung', 'asas'),
(13, 1, 'Si', 'spardosi12@gmail.com', '123', '123', NULL, 1, 'uang_tunai', 'storage/foto_request/NNwAxuZEDwnZW5ay0VtN87XcQNgWcRkAETuIs4mF.png', 'sd', 'pending', NULL, NULL, '2025-05-01 12:38:41', '2025-05-01 12:38:41', 'Harian', 'Turpuk Sagala', 'das'),
(14, 1, 'Si', 'spardosi12@gmail.com', '05635', '05635', NULL, 1, 'uang_tunai', 'storage/foto_request/Qzo3hWnbHRKHrbCiW8lpFv2pJw9NlXA5uMuZzrsJ.jpg', 'qw', 'pending', NULL, NULL, '2025-05-01 12:56:34', '2025-05-01 12:56:34', 'Harian', 'Turpuk Sagala', 'qwq'),
(15, 1, 'Si', 'spardosi12@gmail.com', '12122213', '12122213', NULL, 1, 'uang_tunai', 'storage/foto_request/S4a2LzLAJ8eTaDoZZqsNHffcw9FksSB6GhXgaQp7.jpg', 'qw', 'pending', NULL, NULL, '2025-05-01 13:00:11', '2025-05-01 13:00:11', 'Palipi', 'Suhut Nihuta Pardomuan', 'qw'),
(16, 1, 'Si', 'spardosi12@gmail.com', '1212', '1212', NULL, 12, 'uang_tunai', 'storage/foto_request/1r5Ni5mnQ1rPWTWqyFkWigEyZeW82ZSEcBeG2KIt.png', 'qw', 'pending', NULL, NULL, '2025-05-01 13:01:48', '2025-05-01 13:01:48', 'Harian', 'Turpuk Malau', 'qwq'),
(17, 1, 'Si', 'spardosi12@gmail.com', '12121', '12121', NULL, 2, 'uang_tunai', 'storage/foto_request/v1X92XhMNRr8BJXmEE7MNXIlSOutz4KfaEMFanKA.png', 'asas', 'pending', NULL, NULL, '2025-05-01 13:08:25', '2025-05-01 13:08:25', 'Pangururan', 'Rianiate', 'adsada'),
(18, 1, 'Si', 'spardosi12@gmail.com', '11212', '11212', NULL, 1, 'uang_tunai', 'storage/foto_request/CTFtTRlu6Zh2roQgiCP4ymNFOKcU847QIHHrYUY9.png', 'qw', 'pending', NULL, NULL, '2025-05-01 13:11:55', '2025-05-01 13:11:55', 'Nainggolan', 'Toguan Galung', 'qwq'),
(19, 1, 'Si', 'spardosi12@gmail.com', '1212', '1212', NULL, 1, 'uang_tunai', 'storage/foto_request/B8pFgqypTmBKv4F4X0PeRRJ4UvXgokaIbyHHMac2.png', 'as', 'pending', NULL, NULL, '2025-05-01 13:16:19', '2025-05-01 13:16:19', 'Harian', 'Turpuk Malau', 'sas'),
(20, 1, 'Si', 'spardosi12@gmail.com', '12', '12', NULL, 1, 'uang_tunai', 'storage/foto_request/avjcJCNEkpxIr0tMroU4Yr3zOgVBZAMd0xN6YkJ3.png', 'as', 'pending', NULL, NULL, '2025-05-01 13:17:54', '2025-05-01 13:17:54', 'Harian', 'Turpuk Sagala', 'asas'),
(21, 3, 'sumondang', 'sumondang@gmail.com', '121', '121', NULL, 2, 'uang_tunai', 'storage/foto_request/wGY6Zg57ZBl1PGdkhLTsfSpeWOp4J0N3GoO3gIuA.png', 'as', 'pending', NULL, NULL, '2025-05-01 16:32:48', '2025-05-01 16:32:48', 'Nainggolan', 'Pananggangan', 'asas'),
(22, 1, 'Si', 'spardosi12@gmail.com', '1212', '1212', NULL, 1, 'uang_tunai', 'storage/foto_request/fm79NW1cye1TlznVNV4oCTGs2WIOLJd7uOhNK8K9.png', 'as', 'pending', NULL, NULL, '2025-05-01 16:33:29', '2025-05-01 16:33:29', 'Nainggolan', 'Nainggolan', 'asas'),
(23, 2, 'sion pardosi', 'sionpardosi12@gmail.com', '12', '12', NULL, 1, 'uang_tunai', 'storage/foto_request/G8gaXJ9L74bemhi0Kbw9GpLbdyyj8thkiHGoWvzY.png', 'as', 'pending', NULL, NULL, '2025-05-01 16:36:00', '2025-05-01 16:36:00', 'Nainggolan', 'Pananggangan', 'sas'),
(24, 1, 'Si', 'spardosi12@gmail.com', '12', '12', NULL, 1, 'uang_tunai', 'storage/foto_request/iJfs7zh1uVip0frGApLF6zNMxtdwLRkNWZueauBM.png', 'sasa', 'pending', NULL, NULL, '2025-05-01 16:45:39', '2025-05-01 16:45:39', 'Palipi', 'Urat II', 'asa'),
(25, 1, 'Si', 'spardosi12@gmail.com', '1213', '1213', NULL, 12, 'uang_tunai', 'storage/foto_request/x2OwFf3CapfCICc83zQrMgJOtshnRmVXQheAFIlx.png', 'sas', 'pending', NULL, NULL, '2025-05-01 16:47:13', '2025-05-01 16:47:13', 'Onan Runggu', 'Janji Matogu', 'asa'),
(26, 1, 'Si', 'spardosi12@gmail.com', '1213', '1213', NULL, 12, 'uang_tunai', 'storage/foto_request/BDQVF24dlkHtVyBrq7cUPo9EgMAHcGKjxYLNJvem.png', 'sas', 'pending', NULL, NULL, '2025-05-01 16:47:25', '2025-05-01 16:47:25', 'Onan Runggu', 'Janji Matogu', 'asa'),
(27, 1, 'Si', 'spardosi12@gmail.com', '1221', '1221', NULL, 12, 'uang_tunai', 'storage/foto_request/RVWL696m3UbS3ppSWyisoG5iF8EPMIvC6lLpvCNt.png', 'asasa', 'pending', NULL, NULL, '2025-05-01 16:47:57', '2025-05-01 16:47:57', 'Nainggolan', 'Sipinggan Lumban Siantar', 'asas'),
(28, 1, 'Si', 'spardosi12@gmail.com', '1221', '1221', NULL, 12, 'uang_tunai', 'storage/foto_request/YaqijCiW6U8VksA5e6CgLydOgthdZYbPdqVty8py.png', 'asasa', 'pending', NULL, NULL, '2025-05-01 16:48:07', '2025-05-01 16:48:07', 'Nainggolan', 'Sipinggan Lumban Siantar', 'asas'),
(29, 1, 'Si', 'spardosi12@gmail.com', '121', '121', NULL, 12, 'uang_tunai', 'storage/foto_request/Ap3TChre9YH2yNmE7ZY3FHFRChySMhwqCEBX76E7.png', 'asa', 'pending', NULL, NULL, '2025-05-01 16:48:45', '2025-05-01 16:48:45', 'Onan Runggu', 'Huta Hotang', 'sas'),
(30, 1, 'Si', 'spardosi12@gmail.com', '1212', '1212', NULL, 21, 'uang_tunai', 'storage/foto_request/4cukflaL4YKrX6ocimTS5beTOuG4MTIdPfKSLWsC.png', 'sasa', 'pending', NULL, NULL, '2025-05-01 16:50:49', '2025-05-01 16:50:49', 'Sianjur Mulamula', 'Aek Sipitudai', 'asa'),
(31, 1, 'Si', 'spardosi12@gmail.com', '1212', '1212', NULL, 1, 'uang_tunai', 'storage/foto_request/iBZHWi7tn1J6KNX9OLx9FVooS89KHPDw87mRz6yZ.png', 'sas', 'disetujui', NULL, 'akan dijemput', '2025-05-01 16:53:39', '2025-05-01 17:01:09', 'Nainggolan', 'Toguan Galung', 'asa'),
(32, 1, 'Si', 'spardosi12@gmail.com', '12121', '12121', NULL, 1, 'uang_tunai', 'uploads/bukti_pemasok/1746160424_KLRBcv.png', 'sas', 'ditolak', NULL, NULL, '2025-05-02 04:33:44', '2025-05-02 08:19:32', 'Nainggolan', 'Sipinggan', 'asa'),
(33, 1, 'Si', 'spardosi12@gmail.com', '08226789012', '08226789012', NULL, 1, 'uang_tunai', 'uploads/bukti_pemasok/1746168665_TSpD9A.png', 'sf', 'disetujui', NULL, 'oke', '2025-05-02 06:51:05', '2025-05-02 08:19:10', 'Onan Runggu', 'Silima Lombu', 'sfs'),
(34, 1, 'Si', 'spardosi12@gmail.com', '1212', '1212', NULL, 1, 'uang_tunai', 'uploads/bukti_pemasok/1746279487_8SIks4.png', 'as', 'pending', NULL, NULL, '2025-05-03 13:38:07', '2025-05-03 13:38:07', 'Nainggolan', 'Sipinggan Lumban Siantar', 'as'),
(35, 3, 'sumondang', 'sumondang@gmail.com', '0827632323453', '0827632323453', NULL, 2, 'uang_tunai', 'uploads/bukti_pemasok/1746410677_ou8hM7.jpg', 'sasa', 'pending', NULL, NULL, '2025-05-05 02:04:37', '2025-05-05 02:04:37', 'Nainggolan', 'Nainggolan', 'asasa'),
(36, 1, 'Saut parulian', 'spardosi12@gmail.com', '082278900178', '082278900178', NULL, 2, 'uang_tunai', 'uploads/bukti_pemasok/1746410893_gPNzJU.png', 'balige', 'pending', NULL, NULL, '2025-05-05 02:08:13', '2025-05-05 02:08:13', 'Sianjur Mulamula', 'Sianjur Mulamula', 'balige'),
(37, 3, 'sumondang', 'sumondang@gmail.com', '1234252535', '1234252535', NULL, 2, 'uang_tunai', 'uploads/bukti_pemasok/1746502012_WzCH2a.jpg', 'sdsd', 'pending', NULL, NULL, '2025-05-06 03:26:52', '2025-05-06 03:26:52', 'Onan Runggu', 'Sipira', 'sdsd'),
(38, 3, 'sumondang', 'sumondang@gmail.com', '1234252535', '1234252535', NULL, 2, 'uang_tunai', 'uploads/bukti_pemasok/1746502017_yhwbWp.jpg', 'sdsd', 'pending', NULL, NULL, '2025-05-06 03:26:57', '2025-05-06 03:26:57', 'Onan Runggu', 'Sipira', 'sdsd'),
(39, 3, 'sumondang', 'sumondang@gmail.com', '122424224', '122424224', NULL, 2, 'uang_tunai', 'uploads/bukti_pemasok/1746502415_rVwFP0.jpg', 'asa', 'pending', NULL, NULL, '2025-05-06 03:33:35', '2025-05-06 03:33:35', 'Sianjur Mulamula', 'Sianjur Mulamula', 'as'),
(40, 3, 'sumondang', 'sumondang@gmail.com', '122424224', '122424224', NULL, 2, 'uang_tunai', 'uploads/bukti_pemasok/1746502419_Xbn9P5.jpg', 'asa', 'pending', NULL, NULL, '2025-05-06 03:33:39', '2025-05-06 03:33:39', 'Sianjur Mulamula', 'Sianjur Mulamula', 'as'),
(41, 1, 'Saut parulian', 'spardosi12@gmail.com', '12121212124', '12121212124', NULL, 3, 'uang_tunai', 'uploads/bukti_pemasok/1746502482_UQE4Hj.jpg', 'as', 'pending', NULL, NULL, '2025-05-06 03:34:42', '2025-05-06 03:34:42', 'Ronggur Nihuta', 'Sabungan Nihuta', 'asa'),
(42, 3, 'sumondang', 'sumondang@gmail.com', '1212434233', '1212434233', NULL, 2, 'uang_tunai', 'uploads/bukti_pemasok/1746502540_dF2DlV.jpeg', 'asa', 'pending', NULL, NULL, '2025-05-06 03:35:40', '2025-05-06 03:35:40', 'Sianjur Mulamula', 'Huta Gurgur', 'asa'),
(43, 17, 'Listra Sidabutar', 'lalistramanoban27@gmail.com', '082164080661', '082164080661', NULL, 30, 'uang_tunai', 'uploads/bukti_pemasok/1746537616_7zwtvg.jpg', 'tolong sifat jelek sion dikurangi', 'disetujui', NULL, NULL, '2025-05-06 13:20:16', '2025-05-06 16:49:56', 'Simanindo', 'Tomok Parsaoran', 'Lagunboti'),
(44, 3, 'sumondang', 'sumondang@gmail.com', '1234634634', '1234634634', NULL, 23, 'uang_tunai', 'uploads/bukti_pemasok/1746550547_E8CsfL.png', 'as', 'pending', NULL, NULL, '2025-05-06 16:55:47', '2025-05-06 16:55:47', 'Sianjur Mulamula', 'Huta Gurgur', 'sas'),
(45, 3, 'sumondang', 'sumondang@gmail.com', '1243434234', '1243434234', NULL, 2, 'uang_tunai', 'uploads/bukti_pemasok/1746557499_j00HOm.png', 'asa', 'pending', NULL, NULL, '2025-05-06 18:51:39', '2025-05-06 18:51:39', 'Nainggolan', 'Janji Marapot', 'asa'),
(46, 3, 'sumondang', 'sumondang@gmail.com', '1243434234', '1243434234', NULL, 2, 'uang_tunai', 'uploads/bukti_pemasok/1746557506_W9BR18.png', 'asa', 'pending', NULL, NULL, '2025-05-06 18:51:46', '2025-05-06 18:51:46', 'Nainggolan', 'Janji Marapot', 'asa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `mode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `snap_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `order_id`, `mode`, `status`, `created_at`, `updated_at`, `snap_token`, `invoice`) VALUES
(0, 1, 5, 'card', 'pending', '2025-04-28 04:03:57', '2025-04-28 04:03:57', '61fe7506-285c-48c2-8a01-2607a84743f5', 'ORDER-5-ea86c004-2945-4735-8a5d-304ca582bbc4'),
(0, 1, 6, 'card', 'pending', '2025-04-28 12:50:19', '2025-04-28 12:50:19', '85f6fe6e-9b8c-4745-8ed9-00fb4e42c011', 'ORDER-6-dbdb6006-d6af-4c60-bdb8-ac90d4a414b8'),
(0, 1, 7, 'card', 'pending', '2025-05-02 06:49:32', '2025-05-02 06:49:32', '17a6940c-53c6-4f7e-a663-565945066c56', 'ORDER-7-7505b3a6-f61a-47cf-80d0-74c79b7746d5'),
(0, 1, 8, 'card', 'pending', '2025-05-02 17:28:16', '2025-05-02 17:28:16', '2cd60fd9-aacf-40f3-ad9c-f6ef9e729358', 'ORDER-8-09d3d72e-7ff1-43ae-b435-497b2eda14be'),
(0, 1, 9, 'card', 'pending', '2025-05-02 17:40:58', '2025-05-02 17:40:58', '682a0cff-38e5-4d47-a871-16712c61afc1', 'ORDER-9-bfcd5ec7-20ea-4186-a4e4-5db36fc31d1e'),
(0, 1, 10, 'card', 'pending', '2025-05-02 17:42:43', '2025-05-02 17:42:43', 'c7715628-4403-44aa-9b29-d3348b37bde6', 'ORDER-10-c0adabab-6c4d-45d6-b05e-08f62128a055'),
(0, 1, 11, 'card', 'pending', '2025-05-02 17:43:58', '2025-05-02 17:43:58', 'c1953b4c-61a0-4f6e-872b-cf8b35d8a693', 'ORDER-11-1730be52-f4a7-4c8a-8225-a7f41c5dfc0a'),
(0, 1, 12, 'card', 'pending', '2025-05-02 17:51:46', '2025-05-02 17:51:46', '65077225-ea67-45b0-8b79-9648ee502ff9', 'ORDER-12-79d27403-7281-44fc-ab65-6fe94c9a1981'),
(0, 1, 13, 'card', 'pending', '2025-05-02 18:01:51', '2025-05-02 18:01:51', 'e6436c32-6289-4e54-b2a0-6a983790a9de', 'ORDER-13-c4ee920e-ee20-4b9e-a010-925c394a9fba'),
(0, 1, 14, 'card', 'pending', '2025-05-02 18:04:04', '2025-05-02 18:04:04', 'e8483e52-f236-4a9f-ad60-2f2a19ac95e0', 'ORDER-14-8e0594ce-23c8-4f8e-954d-a6690bcf9445'),
(0, 1, 15, 'card', 'pending', '2025-05-02 18:05:57', '2025-05-02 18:05:57', '9bb09730-c7e3-435b-987c-b59d70bec266', 'ORDER-15-59021a2b-26f9-45eb-a210-082195ca389c'),
(0, 1, 16, 'card', 'pending', '2025-05-03 15:13:46', '2025-05-03 15:13:46', 'd96f0bfc-1632-46b4-866a-df52aa654270', 'ORDER-16-72d6d34b-8a04-41b6-bcc6-efa0299c3ac3'),
(0, 1, 17, 'card', 'pending', '2025-05-03 16:01:12', '2025-05-03 16:01:12', 'b218e713-26a6-4a75-9c6a-366bed7899ef', 'ORDER-17-0e9fce49-d7f0-4f96-8a88-f96fdea5c1c7'),
(0, 1, 18, 'card', 'pending', '2025-05-05 01:44:21', '2025-05-05 01:44:21', 'ad252c89-1447-4881-bb8d-89621d152f83', 'ORDER-18-ec00b894-afd2-422a-9a37-aae4ef189a67'),
(0, 3, 19, 'card', 'pending', '2025-05-05 07:55:27', '2025-05-05 07:55:27', '451c7e06-da91-471f-a5bb-1dc2ad8c9791', 'ORDER-19-c39a4383-4b7f-4260-bb1f-cf04f41d6948'),
(0, 3, 20, 'card', 'pending', '2025-05-05 08:02:49', '2025-05-05 08:02:49', '197cc47d-e850-4930-b91f-99a5ecd0910f', 'ORDER-20-144fa78d-80c0-42c8-9717-181d4bc56116'),
(0, 3, 21, 'card', 'pending', '2025-05-05 17:13:47', '2025-05-05 17:13:47', '28ad869d-6bfa-4618-acfe-5a5d0300b9cd', 'ORDER-21-4014db14-0765-40dd-bf72-00b8c8c63675'),
(0, 3, 22, 'card', 'pending', '2025-05-06 07:16:48', '2025-05-06 07:16:48', '28d9fba4-f78d-4c33-8c62-0260e60fd2f4', 'ORDER-22-5d84d234-b109-497b-bcc0-bfec0edf853c'),
(0, 15, 23, 'card', 'pending', '2025-05-06 12:21:39', '2025-05-06 12:21:39', '0b7cad52-4e30-4c63-a9d3-e94d66e2165c', 'ORDER-23-d770f4e2-17a3-41e5-8925-7c8ea9b4836d');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `utype` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USR' COMMENT 'ADM for Admin and USR for User or Customer',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `gauth_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gauth_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`coupon_data`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile`, `email_verified_at`, `phone_verified_at`, `password`, `profile_picture`, `bio`, `utype`, `remember_token`, `last_login_at`, `created_at`, `updated_at`, `gauth_id`, `gauth_type`, `coupon_data`) VALUES
(1, 'Saut parulian', 'spardosi12@gmail.com', '1234567891', NULL, NULL, '$2y$12$eFadTaVUP9.3T0fQLUNPreqxbyZJCovJiWAH4X4ksKkzfKcPawjta', NULL, NULL, 'USR', NULL, NULL, '2025-04-27 15:19:43', '2025-05-03 19:39:38', NULL, NULL, NULL),
(2, 'sion pardosi', 'sionpardosi12@gmail.com', NULL, NULL, NULL, '$2y$12$AlIwHHsoxHhCwzQd4vVFGOE3gq50VjLYcgWEe7UzquMmDVpdO.e1y', NULL, NULL, 'USR', NULL, NULL, '2025-04-27 15:21:07', '2025-04-27 15:21:07', '110133539037532788097', 'google', NULL),
(3, 'sumondang', 'sumondang@gmail.com', '1234235213', NULL, NULL, '$2y$12$RUS0v4ZsBLOzFvBocDgH2e95WXJprG/M/AoOSyZ2fe/swdLHU68Pm', NULL, NULL, 'ADM', NULL, NULL, '2025-04-27 15:23:31', '2025-04-27 15:23:31', NULL, NULL, NULL),
(4, 'Sion Saut Parulian Pardosi', 'spardosi@gmail.com', '12121212121', NULL, NULL, '$2y$12$8BCGeYeaAIMatMjCVMX/kOqlNyxrTcGTfmhna3Hql7Fl4mzFzyVHS', NULL, NULL, 'USR', NULL, NULL, '2025-04-28 16:23:02', '2025-04-28 16:23:02', NULL, NULL, NULL),
(5, 'Sion Pardosi', 'spardosi122@gmail.com', '082278900189', NULL, NULL, '$2y$12$mu2Kl2uqZf49ajSsB47dJ.6y4WanV6WTEN3/w81v9JUt79/3BGyhW', NULL, NULL, 'USR', NULL, NULL, '2025-04-28 16:39:32', '2025-04-28 16:39:32', NULL, NULL, NULL),
(7, 'Sion Saut Parulian Pardosi Sianipar Paasaribu Sipahutar', 'asas1a@gmail.com', '0173628237828', NULL, NULL, '$2y$12$pNCjrlM1Ofa.PgD/CEsqUOYX01NG9yNVxgQX9VRYnNWWlVN5Owvsy', NULL, NULL, 'USR', NULL, NULL, '2025-05-01 14:18:12', '2025-05-01 14:18:12', NULL, NULL, NULL),
(8, 'aldosetting', 'aldosetting@gmail.com', '123425353523', NULL, NULL, '$2y$12$CGnC8OxbYQRm5Az3OwbbL.xEPG9h4RFe2mAGWkFWW2zWk8YI.2206', NULL, NULL, 'USR', NULL, NULL, '2025-05-03 14:35:04', '2025-05-03 14:35:04', NULL, NULL, NULL),
(13, 'Listra Jelek', 'mc114d5y1919@student.devacademy.id', '1235789678', NULL, NULL, '$2y$12$JXf/oW0JgdKjPYirpHXOi.sKnHgFisdoxjbwM3U1YG5YtEReqrSHa', NULL, NULL, 'USR', NULL, NULL, '2025-05-03 21:16:02', '2025-05-03 21:16:02', NULL, NULL, NULL),
(14, 'Listra sangat Jelek', 'listra.sidabutar@gmail.com', '1218783178631', NULL, NULL, '$2y$12$QfgkQHd/9cOC8sYX2QNf6.Ro./Q0FD0p5VcFW0jRZn7hH9PDt.RCu', NULL, NULL, 'USR', NULL, NULL, '2025-05-05 07:42:07', '2025-05-05 07:42:07', NULL, NULL, NULL),
(15, 'Efran Lumbantoruan', 'efranlumbantoruan83@gmail.com', '08226452495', NULL, NULL, '$2y$12$xXbHl1xjx/51NmKDU5P9weN3C5usymBMdJ8YH9bC5RzwBVyrwWLii', NULL, NULL, 'ADM', NULL, NULL, '2025-05-06 12:19:24', '2025-05-06 12:19:24', NULL, NULL, NULL),
(16, 'sionsautparulianpardosi', 'liadilanku@gmail.com', '12342325474', NULL, NULL, '$2y$12$jRzICtjVf5FvXmsL7BlSrOst2pVfdFxSQKoPyKBEq.y3/ncQEeYT2', NULL, NULL, 'USR', NULL, NULL, '2025-05-06 12:34:28', '2025-05-06 12:34:28', NULL, NULL, NULL),
(17, 'Listra Sidabutar', 'lalistramanoban27@gmail.com', '082164080661', NULL, NULL, '$2y$12$ikSa50orqXZbMrx7tFl/IOp9IyXZg92D6f8AitujW/rRF9RkGJove', NULL, NULL, 'USR', NULL, NULL, '2025-05-06 13:06:46', '2025-05-06 13:06:46', NULL, NULL, NULL),
(18, 'Asri yohana Sirait', 'asrisirait2004@gmail.com', '082364638046', NULL, NULL, '$2y$12$MuyEXOkI8mD5ZadpMoc/3utL5sR1Keu.RKvJExVtfOnglVb4W00Z2', NULL, NULL, 'USR', NULL, NULL, '2025-05-06 14:05:12', '2025-05-06 14:05:12', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_cart_items`
--

CREATE TABLE `user_cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user_cart_items`
--

INSERT INTO `user_cart_items` (`id`, `user_id`, `product_id`, `name`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(11, 2, 24, 'Cover Vas Bunga Anyaman Eceng Gondok', 1, '150000.00', '2025-05-01 16:07:51', '2025-05-01 16:07:51'),
(14, 8, 24, 'Cover Vas Bunga Anyaman Eceng Gondok', 1, '150000.00', '2025-05-03 14:57:11', '2025-05-03 14:57:11'),
(17, 1, 24, 'Cover Vas Bunga Anyaman Eceng Gondok', 16, '150000.00', '2025-05-06 13:53:08', '2025-05-06 13:53:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `wishlist_items`
--

CREATE TABLE `wishlist_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `wishlist_items`
--

INSERT INTO `wishlist_items` (`id`, `user_id`, `product_id`, `name`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(7, 1, 24, 'Cover Vas Bunga Anyaman Eceng Gondok', 1, '150000.00', '2025-05-04 10:15:55', '2025-05-04 10:15:55');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `abouts`
--
ALTER TABLE `abouts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `abouts_slug_unique` (`slug`);

--
-- Indeks untuk tabel `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

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
-- Indeks untuk tabel `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Indeks untuk tabel `email_verifications`
--
ALTER TABLE `email_verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_verifications_email_index` (`email`);

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
-- Indeks untuk tabel `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_applications_job_id_foreign` (`job_id`),
  ADD KEY `job_applications_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `job_lists`
--
ALTER TABLE `job_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `month_names`
--
ALTER TABLE `month_names`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `penjadwalan_penjemputans`
--
ALTER TABLE `penjadwalan_penjemputans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penjadwalan_penjemputans_supplier_request_id_foreign` (`supplier_request_id`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

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
-- Indeks untuk tabel `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `stok_bahan_bakus`
--
ALTER TABLE `stok_bahan_bakus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stok_bahan_bakus_request_id_foreign` (`request_id`);

--
-- Indeks untuk tabel `supplier_infos`
--
ALTER TABLE `supplier_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `supplier_requests`
--
ALTER TABLE `supplier_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_requests_user_id_foreign` (`user_id`),
  ADD KEY `supplier_requests_coupon_id_foreign` (`coupon_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_mobile_unique` (`mobile`);

--
-- Indeks untuk tabel `user_cart_items`
--
ALTER TABLE `user_cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_cart_items_user_id_foreign` (`user_id`),
  ADD KEY `user_cart_items_product_id_foreign` (`product_id`);

--
-- Indeks untuk tabel `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlist_items_user_id_foreign` (`user_id`),
  ADD KEY `wishlist_items_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `abouts`
--
ALTER TABLE `abouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT untuk tabel `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `email_verifications`
--
ALTER TABLE `email_verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
-- AUTO_INCREMENT untuk tabel `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `job_lists`
--
ALTER TABLE `job_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `month_names`
--
ALTER TABLE `month_names`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `penjadwalan_penjemputans`
--
ALTER TABLE `penjadwalan_penjemputans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `slides`
--
ALTER TABLE `slides`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `stok_bahan_bakus`
--
ALTER TABLE `stok_bahan_bakus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `supplier_infos`
--
ALTER TABLE `supplier_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `supplier_requests`
--
ALTER TABLE `supplier_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `user_cart_items`
--
ALTER TABLE `user_cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `wishlist_items`
--
ALTER TABLE `wishlist_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `job_applications`
--
ALTER TABLE `job_applications`
  ADD CONSTRAINT `job_applications_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `job_lists` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penjadwalan_penjemputans`
--
ALTER TABLE `penjadwalan_penjemputans`
  ADD CONSTRAINT `penjadwalan_penjemputans_supplier_request_id_foreign` FOREIGN KEY (`supplier_request_id`) REFERENCES `supplier_requests` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `stok_bahan_bakus`
--
ALTER TABLE `stok_bahan_bakus`
  ADD CONSTRAINT `stok_bahan_bakus_request_id_foreign` FOREIGN KEY (`request_id`) REFERENCES `supplier_requests` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `supplier_requests`
--
ALTER TABLE `supplier_requests`
  ADD CONSTRAINT `supplier_requests_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `supplier_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_cart_items`
--
ALTER TABLE `user_cart_items`
  ADD CONSTRAINT `user_cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD CONSTRAINT `wishlist_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
