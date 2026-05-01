-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Waktu pembuatan: 01 Bulan Mei 2026 pada 09.10
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
(4, 'Tentang Bank Koperasi Eceng Gondok Samosir', 'tentang-bank-koperasi-eceng-gondok-samosir', 'Di pesisir Danau Toba, pertumbuhan Eceng Gondok yang tak terkendali menutupi perairan dan meresahkan masyarakat setempat. Bank Koperasi Eceng Gondok Samosir hadir sebagai inisiatif inovatif untuk mengatasi masalah lingkungan sekaligus memberdayakan masyarakat lokal. Koperasi ini didirikan oleh Sumondang Tabita Nainggolan pada akhir tahun 2023 di Sitanggang Bau, Pangururan. Melalui kolaborasi dan semangat gotong-royong, kami mengubah Eceng Gondok yang selama ini dianggap gulma menjadi produk kerajinan bernilai tinggi, menciptakan lapangan usaha baru bagi komunitas sekitar.\r\nSejumlah pengrajin lokal Bank Koperasi Eceng Gondok Samosir menunjukkan hasil kerajinan dari Eceng Gondok dengan bangga. Pada awalnya, proses pembuatan sandal, tas, dan kerajinan lain masih dilakukan secara manual menggunakan teknik anyaman tradisional. Melalui pelatihan dan kerja sama, kami meningkatkan kemampuan anggota sehingga kapasitas produksi pun bertambah. Setiap helai Eceng Gondok dikeringkan, dihaluskan, dan dianyam dengan tangan sesuai kearifan lokal, menghasilkan produk kerajinan berkualitas tinggi. Kini, produk kami tidak hanya dipasarkan secara lokal, tetapi juga melalui platform daring, menjangkau konsumen yang lebih luas.\r\nMenjawab tantangan pengelolaan usaha yang masih dilakukan secara manual, kami mengembangkan sistem koperasi digital terintegrasi. Dengan sistem daring ini, proses pendaftaran anggota, transaksi, dan pengelolaan usaha dilakukan lebih mudah dan efisien. Langkah ini tidak hanya meningkatkan efisiensi operasional, tetapi juga transparansi, sehingga setiap anggota dapat memantau pembukuan dan distribusi produk secara terbuka. Melalui platform digital, kami mengajak masyarakat lebih aktif berpartisipasi dan menjangkau pasar yang lebih luas bagi produk Eceng Gondok Samosir.', 'Menjadi koperasi terdepan yang memberdayakan ekonomi masyarakat lokal melalui pemanfaatan Eceng Gondok secara berkelanjutan untuk menjaga lingkungan Danau Toba, serta mendukung inovasi sistem digital dan pelestarian budaya serta kerajinan lokal.', 'Meningkatkan kesejahteraan ekonomi masyarakat lokal melalui pelatihan dan pendampingan kewirausahaan berbasis Eceng Gondok.\r\nMengelola Eceng Gondok secara berkelanjutan untuk menjaga kelestarian lingkungan Danau Toba.\r\nMengembangkan sistem koperasi digital yang transparan dan efisien untuk mempermudah administrasi dan pemasaran produk.\r\nMelestarikan budaya lokal melalui inovasi kerajinan Eceng Gondok yang khas Samosir.', 'Sumondang', '2025-04-29', 'Jl. Sitanggang No. 1, Desa Sitanggang Bau, Kec. Pangururan, Kab. Samosir, Sumatera Utara', 'Telepon: +62 812 3456 7890\r\nEmail: info@bkecg-samosir.id\r\nWebsite: www.bkecg-samosir.coop', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4966.45620991171!2d98.69318757585994!3d2.628665756129755!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3031c5ca7c7e07f9%3A0x2c25b5a19a80edae!2skoperasibank%20Eceng%20Gondok!5e1!3m2!1sid!2sid!4v1745930060331!5m2!1sid!2sid\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'uploads/abouts/1749477698_XClL2k.jpeg', 'Tentang Bank Koperasi Eceng Gondok Samosir', 'Tentang Bank Koperasi Eceng Gondok Samosir', 'uploads/abouts/1749477669_KXRm3g.jpg', 'Tentang Bank Koperasi Eceng Gondok Samosir', 'Tentang Bank Koperasi Eceng Gondok Samosir', 1, '2025-04-28 16:13:53', '2025-06-09 14:01:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe` enum('aset','liabilitas','ekuitas','pendapatan','beban') COLLATE utf8mb4_unicode_ci NOT NULL,
  `saldo_normal` enum('debit','kredit') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `accounts`
--

INSERT INTO `accounts` (`id`, `kode`, `nama`, `tipe`, `saldo_normal`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '1-001', 'Kas', 'aset', 'debit', 1, '2026-04-30 22:17:46', '2026-04-30 22:17:46'),
(2, '1-002', 'Piutang Usaha', 'aset', 'debit', 1, '2026-04-30 22:17:47', '2026-04-30 22:17:47'),
(3, '1-003', 'Persediaan Bahan Baku', 'aset', 'debit', 1, '2026-04-30 22:17:47', '2026-04-30 22:17:47'),
(4, '2-001', 'Utang Usaha', 'liabilitas', 'kredit', 1, '2026-04-30 22:17:47', '2026-04-30 22:17:47'),
(5, '3-001', 'Modal Pemilik', 'ekuitas', 'kredit', 1, '2026-04-30 22:17:47', '2026-04-30 22:17:47'),
(6, '3-002', 'Laba Ditahan', 'ekuitas', 'kredit', 1, '2026-04-30 22:17:47', '2026-04-30 22:17:47'),
(7, '4-001', 'Pendapatan Penjualan Online', 'pendapatan', 'kredit', 1, '2026-04-30 22:17:47', '2026-04-30 22:17:47'),
(8, '4-002', 'Pendapatan Penjualan Offline', 'pendapatan', 'kredit', 1, '2026-04-30 22:17:47', '2026-04-30 22:17:47'),
(9, '5-001', 'Beban Bahan Baku', 'beban', 'debit', 1, '2026-04-30 22:17:47', '2026-04-30 22:17:47'),
(10, '5-002', 'Beban Operasional', 'beban', 'debit', 1, '2026-04-30 22:17:47', '2026-04-30 22:17:47'),
(11, '5-003', 'Beban Lain-lain', 'beban', 'debit', 1, '2026-04-30 22:17:47', '2026-04-30 22:17:47');

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
  `idcity` int(11) NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idstate` int(11) NOT NULL,
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

INSERT INTO `addresses` (`id`, `user_id`, `name`, `phone`, `locality`, `address`, `city`, `idcity`, `state`, `idstate`, `country`, `landmark`, `zip`, `type`, `isdefault`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sion Pardosi', '082278900178', 'Komplek PLN Balige', 'Jl.Dr.Td.Pardede Onan', 'Samosir', 389, 'Sumatera Utara', 34, 'Indonesia', 'simpang 3 masuk ke PLN', '22312', 'home', 1, '2025-06-09 13:02:00', '2025-06-09 13:02:00'),
(2, 1, 'sdsd', '082278999231', 'as', 'as', 'asa', 0, 'mknj', 0, 'Indonesia', 'as', '22312', 'home', 0, '2026-04-29 01:48:47', '2026-04-29 01:48:47'),
(3, 1, 'asa', '082267193923', 'ajans', 'simpang', 'BANJARMASIN', 236, 'KALIMANTAN SELATAN', 3, 'Indonesia', 'andan', '24122', 'home', 0, '2026-04-29 07:06:29', '2026-04-29 07:06:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `description`, `image`, `is_active`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 'Bank Eceng Gondok Samosir', 'bank-eceng-gondok-samosir', 'Bank Eceng Gondok Samosir', '1749465163.png', 1, 0, '2025-06-09 10:32:43', '2025-06-09 10:32:43');

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
('sionpardosi12@gmaill.com|127.0.0.1', 'i:4;', 1777579199),
('sionpardosi12@gmaill.com|127.0.0.1:timer', 'i:1777579199;', 1777579199);

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
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `parent_id`, `is_active`, `is_featured`, `sort_order`, `description`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES
(1, 'Sendal', 'sendal', '1749463445.jpg', NULL, 1, 0, 0, NULL, NULL, NULL, '2025-06-09 10:04:05', '2025-06-09 10:04:05'),
(2, 'Kotak Tissue', 'kotak-tissue', '1749463563.webp', NULL, 1, 0, 0, NULL, NULL, NULL, '2025-06-09 10:06:03', '2025-06-09 10:06:03'),
(3, 'Vas Bunga', 'vas-bunga', '1749463696.jpg', NULL, 1, 0, 0, NULL, NULL, NULL, '2025-06-09 10:08:16', '2025-06-09 10:08:16'),
(4, 'Keranjang', 'keranjang', '1749463760.jpg', NULL, 1, 0, 0, NULL, NULL, NULL, '2025-06-09 10:09:20', '2025-06-09 10:09:20'),
(5, 'Dompet', 'dompet', '1749463802.jpg', NULL, 1, 0, 0, NULL, NULL, NULL, '2025-06-09 10:10:02', '2025-06-09 10:10:02'),
(6, 'Alas Serbaguna', 'alas-serbaguna', '1749463967.jpg', NULL, 1, 0, 0, NULL, NULL, NULL, '2025-06-09 10:12:47', '2025-06-09 10:12:47'),
(7, 'Karpet Bulat', 'karpet-bulat', '1749464018.jpg', NULL, 1, 0, 0, NULL, NULL, NULL, '2025-06-09 10:13:38', '2025-06-09 10:13:38'),
(8, 'Topi', 'topi', '1749464228.avif', NULL, 1, 0, 0, NULL, NULL, NULL, '2025-06-09 10:17:08', '2025-06-09 10:17:08'),
(9, 'Tas', 'tas', '1749464292.jpg', NULL, 1, 0, 0, NULL, NULL, NULL, '2025-06-09 10:18:12', '2025-06-09 10:18:12'),
(10, 'Wadah Pot', 'wadah-pot', '1749464376.jpg', NULL, 1, 0, 0, NULL, NULL, NULL, '2025-06-09 10:19:37', '2025-06-09 10:19:37'),
(11, 'Bantal', 'bantal', '1749464402.jpg', NULL, 1, 0, 0, NULL, NULL, NULL, '2025-06-09 10:20:02', '2025-06-09 10:20:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `role` enum('user','assistant','system') COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `chat_sessions`
--

CREATE TABLE `chat_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Struktur dari tabel `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_amount` decimal(15,2) NOT NULL,
  `minimum_order` decimal(15,2) NOT NULL DEFAULT 0.00,
  `expiry_date` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount_amount`, `minimum_order`, `expiry_date`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'D1SK0NP3MAS0K', '50000.00', '200000.00', '2025-08-08', 1, '2025-06-09 13:29:23', '2025-06-09 13:29:23');

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
-- Struktur dari tabel `failed_payments`
--

CREATE TABLE `failed_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pending_order_id` bigint(20) UNSIGNED NOT NULL,
  `midtrans_order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `failure_reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_letter` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `whatsapp_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `education_level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `experience` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expected_salary` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skills` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_info` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Diterima','Ditolak','Diproses') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Diproses',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `job_applications`
--

INSERT INTO `job_applications` (`id`, `job_id`, `user_id`, `name`, `email`, `cv`, `image`, `cover_letter`, `phone_number`, `whatsapp_number`, `gender`, `education_level`, `experience`, `expected_salary`, `skills`, `additional_info`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Sion Pardosi', 'spardosi12@gmail.com', NULL, 'uploads/skills/1749478260_skill_Xk1I9l.jpeg', 'Lamaran melalui formulir aplikasi baru - Data lengkap tersedia di form.', '082278900178', '082278900178', 'Laki-laki', 'D4', 'saya pernah menjadi student Software Engineer at Institut Teknologi Del', 'Sesuai standar perusahaan', 'Lihat informasi tambahan: saya sangat berharap diterima', 'saya sangat berharap diterima', 'Diproses', '2025-06-09 14:11:00', '2025-06-09 14:11:00');

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
(1, 'Perakit Sendal Anyaman Eceng Gondok', 'Dicari Perakit Sendal Anyaman Eceng Gondok, sekitaran Samosir, biaya makan ditanggung sendiri dan akan mendapat upah secara full-time', 'Full-time', '400000.00', 'Per Hari', '4 Bulan', 'setiap 1 hari harus mencapai 1 lusin sendal', 'Jalan Pulo, Sait Nihuta, Kec. Pangururan, Kabupaten Samosir', 'uploads/image_job/1749475991_ELrFsF.jpeg', 'Bebas dari golongan apapun', 'Upah', '2025-06-27', 'Dibuka', '2025-06-09 13:33:11', '2025-06-09 13:33:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `journal_entries`
--

CREATE TABLE `journal_entries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `no_jurnal` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sumber` enum('online','offline') COLLATE utf8mb4_unicode_ci NOT NULL,
  `referensi_id` bigint(20) UNSIGNED DEFAULT NULL,
  `referensi_tipe` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `journal_entries`
--

INSERT INTO `journal_entries` (`id`, `tanggal`, `no_jurnal`, `keterangan`, `sumber`, `referensi_id`, `referensi_tipe`, `created_at`, `updated_at`) VALUES
(1, '2025-06-09', 'JRN-20250609-001', 'Penjualan Online - Order #1 (Sion Pardosi)', 'online', 1, 'order', '2026-04-30 22:24:46', '2026-04-30 22:24:46'),
(2, '2025-06-09', 'JRN-20250609-002', 'Penjualan Online - Order #2 (Sion Pardosi)', 'online', 2, 'order', '2026-04-30 22:24:46', '2026-04-30 22:24:46'),
(3, '2025-06-09', 'JRN-20250609-003', 'Penjualan Online - Order #4 (Sion Pardosi)', 'online', 4, 'order', '2026-04-30 22:24:46', '2026-04-30 22:24:46'),
(4, '2026-05-01', 'JRN-20260501-001', 'pembelian topi', 'offline', 1, 'manual', '2026-04-30 22:28:46', '2026-04-30 22:28:46'),
(5, '2026-05-01', 'JRN-20260501-002', 'pembelian sendal', 'offline', 2, 'manual', '2026-05-01 04:41:18', '2026-05-01 04:41:18'),
(6, '2026-04-29', 'JRN-20260429-001', 'Penjualan Online - Order #8 (asa)', 'online', 8, 'order', '2026-05-01 06:09:30', '2026-05-01 06:09:30'),
(7, '2026-05-01', 'JRN-20260501-003', 'Penjualan Online - Order #9 (asa)', 'online', 9, 'order', '2026-05-01 06:09:30', '2026-05-01 06:09:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `journal_entry_lines`
--

CREATE TABLE `journal_entry_lines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `journal_entry_id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `posisi` enum('debit','kredit') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `journal_entry_lines`
--

INSERT INTO `journal_entry_lines` (`id`, `journal_entry_id`, `account_id`, `posisi`, `jumlah`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'debit', '62000.00', '2026-04-30 22:24:46', '2026-04-30 22:24:46'),
(2, 1, 7, 'kredit', '62000.00', '2026-04-30 22:24:46', '2026-04-30 22:24:46'),
(3, 2, 1, 'debit', '180000.00', '2026-04-30 22:24:46', '2026-04-30 22:24:46'),
(4, 2, 7, 'kredit', '180000.00', '2026-04-30 22:24:46', '2026-04-30 22:24:46'),
(5, 3, 1, 'debit', '275000.00', '2026-04-30 22:24:46', '2026-04-30 22:24:46'),
(6, 3, 7, 'kredit', '275000.00', '2026-04-30 22:24:46', '2026-04-30 22:24:46'),
(7, 4, 1, 'debit', '1000000.00', '2026-04-30 22:28:46', '2026-04-30 22:28:46'),
(8, 4, 8, 'kredit', '1000000.00', '2026-04-30 22:28:46', '2026-04-30 22:28:46'),
(9, 5, 1, 'debit', '50000.00', '2026-05-01 04:41:18', '2026-05-01 04:41:18'),
(10, 5, 8, 'kredit', '50000.00', '2026-05-01 04:41:18', '2026-05-01 04:41:18'),
(11, 6, 1, 'debit', '620000.00', '2026-05-01 06:09:30', '2026-05-01 06:09:30'),
(12, 6, 7, 'kredit', '620000.00', '2026-05-01 06:09:30', '2026-05-01 06:09:30'),
(13, 7, 1, 'debit', '120000.00', '2026-05-01 06:09:30', '2026-05-01 06:09:30'),
(14, 7, 7, 'kredit', '120000.00', '2026-05-01 06:09:30', '2026-05-01 06:09:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `manual_transactions`
--

CREATE TABLE `manual_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jenis` enum('pendapatan','pengeluaran') COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `jurnal_dibuat` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `manual_transactions`
--

INSERT INTO `manual_transactions` (`id`, `tanggal`, `jenis`, `deskripsi`, `account_id`, `jumlah`, `jurnal_dibuat`, `created_at`, `updated_at`) VALUES
(1, '2026-05-01', 'pendapatan', 'pembelian topi', 7, '1000000.00', 1, '2026-04-30 22:28:46', '2026-04-30 22:28:46'),
(2, '2026-05-01', 'pendapatan', 'pembelian sendal', 8, '50000.00', 1, '2026-05-01 04:41:18', '2026-05-01 04:41:18');

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
(4, '2025_01_12_015419_create_categories_table', 1),
(5, '2025_01_13_000344_create_orders_table', 1),
(6, '2025_02_13_000550_create_transactions_table', 1),
(7, '2025_02_15_205716_add_ongkir_and_kurir_to_orders_table', 1),
(8, '2025_02_20_125325_create_brands_table', 1),
(9, '2025_02_20_125327_update_brands_table', 1),
(10, '2025_02_21_072635_create_products_table', 1),
(11, '2025_02_27_014009_create_simple_coupons_table', 1),
(12, '2025_02_27_080912_create_order_items_table', 1),
(13, '2025_02_27_080927_create_addresses_table', 1),
(14, '2025_02_28_065150_create_slides_table', 1),
(15, '2025_03_01_173133_create_month_names_table', 1),
(16, '2025_03_02_075927_create_contacts_table', 1),
(17, '2025_03_04_071131_modify_price_columns_in_products_table', 1),
(18, '2025_03_04_084756_modify_order_decimal_columns', 1),
(19, '2025_03_04_084957_modify_price_column_in_order_items_table', 1),
(20, '2025_03_07_145957_create_personal_access_tokens_table', 1),
(21, '2025_03_09_200243_create_job_lists_table', 1),
(22, '2025_03_09_200308_create_job_applications_table', 1),
(23, '2025_03_10_143430_google_social_auth_id', 1),
(24, '2025_03_11_135543_add_cart_data_to_users_table', 1),
(25, '2025_03_11_141644_remove_cart_data_from_users_table', 1),
(26, '2025_03_11_141818_user_cart_items', 1),
(27, '2025_03_11_152056_create_wishlist_items_table', 1),
(28, '2025_04_24_152621_create_supplier_requests_table', 1),
(29, '2025_04_26_011804_create_stok_bahan_bakus_table', 1),
(30, '2025_04_26_123252_create_penjadwalan_penjemputans_table', 1),
(31, '2025_04_29_142120_create_abouts_table', 1),
(32, '2025_04_29_200705_add_map_embed_to_abouts_table', 1),
(33, '2025_05_04_023708_add_mobile_to_users_table', 1),
(34, '2025_05_04_031350_create_email_verifications_table', 1),
(35, '2025_05_05_160722_create_chat_sessions_table', 1),
(36, '2025_05_05_160752_create_chat_messages_table', 1),
(37, '2025_05_06_095857_create_supplier_infos_table', 1),
(38, '2025_05_07_084334_create_threads_table', 1),
(39, '2025_05_07_084335_create_thread_messages_table', 1),
(40, '2025_05_09_081915_update_supplier_infos_and_create_related_videos', 1),
(41, '2025_05_13_105343_create_notifications_table', 1),
(42, '2025_05_13_225008_create_reviews_table', 1),
(43, '2025_05_13_225042_create_review_media_table', 1),
(44, '2025_05_14_222442_create_bank_accounts_table', 1),
(45, '2025_05_14_222727_add_bank_info_to_transactions_table', 1),
(46, '2025_05_15_012225_add_reserved_quantity_to_products_table', 1),
(47, '2025_05_15_102329_create_sizes_table', 1),
(48, '2025_05_15_102447_create_product_size_table', 1),
(49, '2025_05_15_205414_add_idcity_and_idstate_to_addresses_table', 1),
(50, '2025_05_16_054057_add_options_to_user_cart_items', 1),
(51, '2025_05_19_230412_add_awaiting_payment_status_to_orders_table', 1),
(52, '2025_05_27_084749_create_pending_orders_table', 1),
(53, '2025_05_27_084837_create_pending_order_items_table', 1),
(54, '2025_05_27_084841_create_failed_payments_table', 1),
(55, '2025_05_27_084842_create_stock_reservations_table', 1),
(56, '2025_05_27_084848_add_pending_order_id_to_transactions_table', 1),
(57, '2025_06_02_230350_enhance_products_table', 1),
(58, '2025_06_04_014905_remove_tax_column_from_orders_table', 1),
(59, '2025_06_04_202650_add_image_to_job_applications_table', 1),
(60, '2025_06_05_204245_create_month_names_table', 1),
(61, '2025_06_07_172015_update_supplier_requests_table', 1),
(62, '2025_06_09_143052_add_new_fields_to_job_applications_table', 1),
(63, '2025_06_26_173020_add_lokasi_fields_to_supplier_requests_and_penjadwalan_penjemputan', 1),
(64, '2025_06_27_003316_update_penjadwalan_table', 1),
(65, '2025_06_12_015423_add_is_active_to_categories_table', 2),
(66, '2025_06_09_143042_add_new_fields_to_job_applications_table', 3),
(67, '2026_05_01_051410_create_accounts_table', 4),
(68, '2026_05_01_051422_create_journal_entries_table', 4),
(69, '2026_05_01_051426_create_journal_entry_lines_table', 4),
(70, '2026_05_01_051430_create_manual_transactions_table', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `month_names`
--

CREATE TABLE `month_names` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `idnotification` bigint(20) UNSIGNED NOT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu` datetime NOT NULL,
  `status` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `notifications`
--

INSERT INTO `notifications` (`idnotification`, `pesan`, `waktu`, `status`) VALUES
(1, 'Pesanan Baru Dari Sion Pardosi dengan Invoice ORDER-1-f7a1c94f-2cc1-4ffa-b493-5b507e1fabdb dengan status pending', '2025-06-09 20:02:02', 'read'),
(2, 'Pesanan Baru Dari Sion Pardosi dengan Invoice ORDER-2-eb7e3ef7-233f-46c3-a2c5-1fce25e85ded dengan status pending', '2025-06-09 20:21:48', 'read'),
(3, 'Pesanan Baru Dari Sion Pardosi dengan Invoice ORDER-3-a9c1d210-bc0b-4c1f-bcd5-1a4e6e078866 dengan status pending', '2025-06-09 22:40:01', 'read'),
(4, 'Pesanan Baru Dari Sion Pardosi dengan Invoice ORDER-4-5ad79032-cac1-4b9e-8610-3205df8475c2 dengan status pending', '2025-06-09 22:45:28', 'read'),
(5, 'Pesanan Baru Dari Sion Pardosi dengan Invoice ORDER-5-45329e5b-af66-4500-b256-cf492746643a dengan status pending', '2025-06-09 22:50:55', 'read'),
(6, 'Pesanan Baru Dari Sion Pardosi dengan Invoice ORDER-6-1ad2a137-a234-4f1e-855f-086ed02d4cc9 dengan status pending', '2025-06-09 22:53:50', 'read'),
(7, 'Pesanan Baru Dari Sion Pardosi dengan Invoice ORDER-7-d5f9a42d-3be0-4245-a818-2664112d295f dengan status pending', '2025-06-09 22:56:56', 'read'),
(8, 'Pesanan Baru Dari asa dengan Invoice ORDER-8-0ef564de-41f2-41a0-894c-ad26d1c09adb dengan status pending', '2026-04-29 14:06:34', 'read'),
(9, 'Pesanan Baru Dari asa dengan Invoice ORDER-9-c1e99c94-5330-462c-a76e-d6092c6a55f4 dengan status pending', '2026-05-01 11:33:03', 'unread');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `discount` decimal(15,2) NOT NULL,
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
  `ongkir` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kurir` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'home',
  `status` enum('awaiting_payment','pending','confirmed','processing','shipped','delivered','completed','canceled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'awaiting_payment',
  `is_shipping_different` tinyint(1) NOT NULL DEFAULT 0,
  `confirmed_date` date DEFAULT NULL,
  `processing_date` date DEFAULT NULL,
  `shipped_date` date DEFAULT NULL,
  `delivered_date` date DEFAULT NULL,
  `completed_date` date DEFAULT NULL,
  `canceled_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `subtotal`, `discount`, `total`, `name`, `phone`, `locality`, `address`, `city`, `state`, `country`, `landmark`, `zip`, `ongkir`, `kurir`, `type`, `status`, `is_shipping_different`, `confirmed_date`, `processing_date`, `shipped_date`, `delivered_date`, `completed_date`, `canceled_date`, `created_at`, `updated_at`) VALUES
(1, 1, '55000.00', '0.00', '62000.00', 'Sion Pardosi', '082278900178', 'Komplek PLN Balige', 'Jl.Dr.Td.Pardede Onan', 'Samosir', 'Sumatera Utara', 'Indonesia', 'simpang 3 masuk ke PLN', '22312', '7000', 'jne', 'home', 'completed', 0, '2025-06-09', NULL, NULL, '2025-06-09', '2025-06-09', NULL, '2025-06-09 13:02:00', '2025-06-09 13:20:51'),
(2, 1, '110000.00', '0.00', '180000.00', 'Sion Pardosi', '082278900178', 'Komplek PLN Balige', 'Jl.Dr.Td.Pardede Onan', 'Samosir', 'Sumatera Utara', 'Indonesia', 'simpang 3 masuk ke PLN', '22312', '70000', 'jne', 'home', 'completed', 0, '2025-06-09', NULL, NULL, '2025-06-09', '2025-06-09', NULL, '2025-06-09 13:21:47', '2025-06-09 13:22:51'),
(3, 1, '225000.00', '0.00', '295000.00', 'Sion Pardosi', '082278900178', 'Komplek PLN Balige', 'Jl.Dr.Td.Pardede Onan', 'Samosir', 'Sumatera Utara', 'Indonesia', 'simpang 3 masuk ke PLN', '22312', '70000', 'jne', 'home', 'processing', 0, '2025-06-09', '2025-06-09', '2025-06-09', NULL, NULL, NULL, '2025-06-09 15:39:59', '2025-06-09 15:42:31'),
(4, 1, '205000.00', '0.00', '275000.00', 'Sion Pardosi', '082278900178', 'Komplek PLN Balige', 'Jl.Dr.Td.Pardede Onan', 'Samosir', 'Sumatera Utara', 'Indonesia', 'simpang 3 masuk ke PLN', '22312', '70000', 'jne', 'home', 'completed', 0, '2025-06-09', NULL, NULL, '2025-06-09', '2025-06-09', NULL, '2025-06-09 15:45:27', '2025-06-09 15:48:10'),
(5, 1, '165000.00', '0.00', '172000.00', 'Sion Pardosi', '082278900178', 'Komplek PLN Balige', 'Jl.Dr.Td.Pardede Onan', 'Samosir', 'Sumatera Utara', 'Indonesia', 'simpang 3 masuk ke PLN', '22312', '7000', 'jne', 'home', 'canceled', 0, NULL, NULL, NULL, NULL, NULL, '2025-06-09', '2025-06-09 15:50:54', '2025-06-09 15:53:04'),
(6, 1, '78000.00', '0.00', '85000.00', 'Sion Pardosi', '082278900178', 'Komplek PLN Balige', 'Jl.Dr.Td.Pardede Onan', 'Samosir', 'Sumatera Utara', 'Indonesia', 'simpang 3 masuk ke PLN', '22312', '7000', 'jne', 'home', 'awaiting_payment', 0, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-09 15:53:50', '2025-06-09 15:53:50'),
(7, 1, '165000.00', '0.00', '172000.00', 'Sion Pardosi', '082278900178', 'Komplek PLN Balige', 'Jl.Dr.Td.Pardede Onan', 'Samosir', 'Sumatera Utara', 'Indonesia', 'simpang 3 masuk ke PLN', '22312', '7000', 'jne', 'home', 'awaiting_payment', 0, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-09 15:56:55', '2025-06-09 15:56:55'),
(8, 1, '220000.00', '0.00', '620000.00', 'asa', '082267193923', 'ajans', 'simpang', 'BANJARMASIN', 'KALIMANTAN SELATAN', 'Indonesia', 'andan', '24122', '400000', 'jne', 'home', 'delivered', 0, '2026-04-30', NULL, '2026-04-30', '2026-04-30', NULL, NULL, '2026-04-29 07:06:29', '2026-04-29 17:24:15'),
(9, 1, '110000.00', '0.00', '120000.00', 'asa', '082267193923', 'ajans', 'simpang', 'BANJARMASIN', 'KALIMANTAN SELATAN', 'Indonesia', 'andan', '24122', '10000', 'jne', 'home', 'delivered', 0, '2026-05-01', NULL, '2026-05-01', '2026-05-01', '2026-05-01', NULL, '2026-05-01 04:32:59', '2026-05-01 04:37:39');

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
(1, 8, 1, '55000.00', 1, '[]', 0, '2025-06-09 13:02:00', '2025-06-09 13:02:00'),
(2, 11, 2, '110000.00', 1, '{\"size_id\":17,\"size_name\":\"43 x 30 x t15cm\"}', 0, '2025-06-09 13:21:47', '2025-06-09 13:21:47'),
(3, 10, 3, '75000.00', 3, '{\"size_id\":16,\"size_name\":\"L\"}', 0, '2025-06-09 15:39:59', '2025-06-09 15:39:59'),
(4, 7, 4, '160000.00', 1, '{\"size_id\":18,\"size_name\":\"16 Cm\"}', 0, '2025-06-09 15:45:27', '2025-06-09 15:45:27'),
(5, 6, 4, '45000.00', 1, '{\"size_id\":5,\"size_name\":\"18 Cm\"}', 0, '2025-06-09 15:45:27', '2025-06-09 15:45:27'),
(6, 9, 5, '165000.00', 1, '[]', 0, '2025-06-09 15:50:55', '2025-06-09 15:50:55'),
(7, 4, 6, '39000.00', 2, '{\"size_id\":4,\"size_name\":\"15 Cm\"}', 0, '2025-06-09 15:53:50', '2025-06-09 15:53:50'),
(8, 9, 7, '165000.00', 1, '[]', 0, '2025-06-09 15:56:55', '2025-06-09 15:56:55'),
(9, 11, 8, '110000.00', 2, '{\"size_id\":5,\"size_name\":\"18 Cm\"}', 0, '2026-04-29 07:06:30', '2026-04-29 07:06:30'),
(10, 11, 9, '110000.00', 1, '{\"size_id\":5,\"size_name\":\"18 Cm\"}', 0, '2026-05-01 04:32:59', '2026-05-01 04:32:59');

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
-- Struktur dari tabel `pending_orders`
--

CREATE TABLE `pending_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(15,2) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `ongkir` decimal(15,2) NOT NULL DEFAULT 0.00,
  `kurir` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locality` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Indonesia',
  `landmark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending_payment','expired','converted') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending_payment',
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `converted_to_order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pending_order_items`
--

CREATE TABLE `pending_order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pending_order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(1, 1, '2025-06-27', NULL, 17, 'terjadwal', '2025-06-09 13:28:03', '2025-06-09 13:28:03', 'Onan Runggu', 'Sipira', 'Onan runggu, sipira dekat kantor pln');

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
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regular_price` decimal(15,2) NOT NULL,
  `sale_price` decimal(15,2) NOT NULL,
  `handling_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `free_shipping` tinyint(1) NOT NULL DEFAULT 0,
  `SKU` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock_status` enum('instock','outofstock') COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `status` enum('draft','published','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 10,
  `view_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `sold_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `reserved_quantity` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` decimal(8,2) DEFAULT NULL,
  `dimensions` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `short_description`, `description`, `meta_title`, `meta_description`, `regular_price`, `sale_price`, `handling_fee`, `free_shipping`, `SKU`, `stock_status`, `featured`, `is_active`, `status`, `quantity`, `view_count`, `sold_count`, `reserved_quantity`, `image`, `images`, `weight`, `dimensions`, `category_id`, `brand_id`, `created_at`, `updated_at`) VALUES
(1, 'Karpet Bulat Polos Anyaman Asli Eceng Gondok', 'karpet-bulat-polos-anyaman-asli-eceng-gondok', 'Karpet eceng gondok alami dengan anyaman melingkar, diameter 1 meter. Tekstur unik, desain minimalis, dan ramah lingkungan.', 'Karpet eceng gondok alami dengan anyaman melingkar, diameter 1 meter. Tekstur unik, desain minimalis, dan ramah lingkungan. Cocok untuk interior modern maupun etnik. Harga Rp 200.000,-.\', \'Karpet handmade premium berbahan dasar serat eceng gondok alami yang diproses secara tradisional oleh pengrajin terampil. Dianyam dengan teknik melingkar yang presisi, karpet bulat ini menghadirkan tekstur alami yang menarik dan pola natural yang memukau. Dengan diameter 1 meter, karpet ini menjadi aksen sempurna untuk melengkapi berbagai ruangan di rumah Anda', NULL, NULL, '100000.00', '90000.00', '0.00', 0, '2995', 'instock', 0, 1, 'published', 100, 0, 0, 0, '1749468476.jpg', '1749468476-1.jpg', NULL, NULL, 7, 1, '2025-06-09 11:27:56', '2025-06-09 11:27:56'),
(2, 'Alas Piring Eceng Gondok', 'alas-piring-eceng-gondok', 'alas piring ini terbuat dari anyaman eceng gondok berukuran diameter 30cm dan 40cm.', 'alas piring ini terbuat dari anyaman eceng gondok berukuran diameter 30cm dan 40cm. tebal sekitar 1 cm. Bisa kuat diletakan panci / mangkok yg panas di atasnya agar tidak merusak permukaan meja makan', NULL, NULL, '45000.00', '45000.00', '0.00', 0, '9836', 'instock', 0, 1, 'published', 41, 0, 0, 0, '1749468828.jpg', '1749468828-1.jpg', NULL, NULL, 6, 1, '2025-06-09 11:33:48', '2025-06-09 11:33:48'),
(3, 'Dompet Anyaman Eceng Gondok', 'dompet-anyaman-eceng-gondok', 'Dompet Anyaman asli produk Eceng Gondok Samosir, sangat nyaman dipakai di kantong', 'Dompet Anyaman asli produk Eceng Gondok Samosir, sangat nyaman dipakai di kantong', NULL, NULL, '89000.00', '30000.00', '0.00', 0, '8600', 'instock', 0, 1, 'published', 56, 0, 0, 0, '1749469015.jpg', '1749469015-1.jpg', NULL, NULL, 5, 1, '2025-06-09 11:36:55', '2025-06-09 11:36:55'),
(4, 'Cover Pot Enceng Gondok', 'cover-pot-enceng-gondok', 'Cover Pot Enceng Gondok - Anyaman Pot Mini yg terbuat dari bahan alami Enceng gondok', 'Anyaman Pot Mini yg terbuat dari bahan alami Enceng gondok, menambah Kesan Minimalis di Ruang Tamu Kalian.\r\nYang diolah oleh para pengrajin yang terampil.\r\n\r\nProduk kami sudah di bersihkan, dan di finishing dengan baik, jadi kamu bisa langsung pakai dengan aman dan nyaman ya...\r\nTersedia 3 ukuran', NULL, NULL, '40000.00', '39000.00', '0.00', 0, '5860', 'instock', 1, 1, 'published', 51, 0, 0, 0, '1749469339.jpg', '1749469339-1.jpg,1749469339-2.jpg', NULL, NULL, 10, 1, '2025-06-09 11:42:19', '2025-06-09 11:42:19'),
(5, 'Sandal Hias Eceng Gondok', 'sandal-hias-eceng-gondok', 'Sandal eceng gondok Sandal Anyaman ini cocok digunakan untuk santai atau dijadikan sandal rumah, sandal kantor, sandal hotel, dll.', 'Sandal eceng gondok Sandal Anyaman ini cocok digunakan untuk santai atau dijadikan sandal rumah, sandal kantor, sandal hotel, dll.\r\nEstetik nilai seni unik dan Natural material.', NULL, NULL, '140000.00', '100000.00', '0.00', 0, '7816', 'instock', 1, 1, 'published', 59, 0, 0, 0, '1749469552.jpg', '1749469552-1.png', NULL, NULL, 1, 1, '2025-06-09 11:45:53', '2025-06-09 11:45:53'),
(6, 'Kotak Tissue / tissue box eceng gondok', 'kotak-tissue-tissue-box-eceng-gondok', 'Tempat tisu unik, cantik, vintage, natural dan membuat penataan tisu di meja jadi lebih rapi', 'Tempat tisu unik, cantik, vintage, natural dan membuat penataan tisu di meja jadi lebih rapi\r\n—\r\n•Warna : Natural Coklat\r\n•Bahan: Enceng Gondok\r\n•Ukuran : PxLxT=25x15x10cm\r\n•menggunakan besi sehingga lebih kokoh', NULL, NULL, '80000.00', '45000.00', '0.00', 0, '9648', 'instock', 1, 1, 'published', 43, 0, 0, 0, '1749470542.webp', '1749470542-1.jpg,1749470542-2.jpg', NULL, NULL, 2, 1, '2025-06-09 12:02:22', '2025-06-09 14:13:35'),
(7, 'Cover Vas Bunga Anyaman Eceng Gondok', 'cover-vas-bunga-anyaman-eceng-gondok', 'Cover Vas Bunga Eceng Gondok asli Anyaman Eceng Gondok dan cocok serta indah untuk di rumah', 'Size : diameter 16 cm Tinggi 37 cm\r\nBahan Eceng Gondok\r\n\r\n- Bentuk kokoh\r\n- Cocok untuk coverpot\r\n- Tangan pertama langsung dari perajin lokal', NULL, NULL, '200000.00', '160000.00', '0.00', 0, '2909', 'instock', 1, 1, 'published', 118, 0, 0, 0, '1749470847.jpg', '1749470847-1.jpg', NULL, NULL, 3, 1, '2025-06-09 12:07:27', '2025-06-24 19:20:29'),
(8, 'Cover Bantal Anyaman Eceng Gondok', 'cover-bantal-anyaman-eceng-gondok', 'Cover Bantal Anyaman Asli Eceng Gondok Samosir sangat bagus dan nyaman untuk dekorasi ruangan tamu.', 'Cover Bantal Anyaman Asli Eceng Gondok Samosir sangat bagus dan nyaman untuk dekorasi ruangan tamu.', NULL, NULL, '100000.00', '55000.00', '0.00', 0, '6759', 'instock', 1, 1, 'published', 16, 0, 0, 0, '1749470989.jpg', '1749470989-1.jpg,1749470989-2.jpg', NULL, NULL, 11, 1, '2025-06-09 12:09:50', '2025-06-09 12:09:50'),
(9, 'Tas Hias Eceng Gondok Anyaman Samosir', 'tas-hias-eceng-gondok-anyaman-samosir', 'Tas Hias Eceng Gondok Anyaman Samosir Bahan tas dari enceng gondok. Bagian dalam tas ada lapisan furing. Tutup tas pake ritsleting.', 'Bahan tas dari enceng gondok. Bagian dalam tas ada lapisan furing. Tutup tas pake ritsleting. Tidak bisa dipasang handle panjang. Size tidak persis sama, dikarenakan produk handmade.\r\nKurang lebih ukurannya seperti ini:\r\nPanjang 35 cm Lebar 10 cm Tinggi 25 cm\r\nCara perawatan:\r\n1. Jangan kena air\r\n2. Jangan diletakkan di tempat lembab\r\n3. Warna sulaman jangan terkena sinar matahari langsung\r\n4. Jika muncul jamur, segera sikat dan jemur di bawah sinar matahari, supaya kering lagi.', NULL, NULL, '200000.00', '165000.00', '0.00', 0, '1182', 'instock', 1, 1, 'published', 99, 0, 0, 0, '1749471151.jpg', '1749471151-1.jpg', NULL, NULL, 9, 1, '2025-06-09 12:12:31', '2025-06-09 12:12:31'),
(10, 'Topi Anyaman Eceng Gondok Samosir', 'topi-anyaman-eceng-gondok-samosir', 'Kerajinan Tangan Topi Terbuat dari Tanaman Eceng Gondok yang sudah di proses dibuat oleh tangan-tangan berbakat dan mempunyai nilai seni tinggi', 'Kerajinan Tangan Topi\r\nTerbuat dari Tanaman Eceng Gondok yang sudah di proses dibuat oleh tangan-tangan berbakat dan mempunyai nilai seni tinggi\r\n~LIMITED EDITON~', NULL, NULL, '100000.00', '75000.00', '0.00', 0, '134425', 'instock', 1, 1, 'published', 53, 0, 0, 0, '1749472497.png', '1749472497-1.png', NULL, NULL, 8, 1, '2025-06-09 12:34:58', '2025-06-09 15:42:59'),
(11, 'Kotak Keranjang Anyaman Eceng Gondok', 'kotak-keranjang-anyaman-eceng-gondok', 'Kotak Keranjang Anyaman Eceng Gondok Samosir sangat mudah digunakan dan bermanfaat dalam rumah tangga.', '3in1 Box merupakan keranjang dengan handle dalam dan terdiri dari 1 box besar dan 2 box kecil, berbahan dasar enceng gondok asli. Product ini sudah di finishing serta diberi anti jamur. Berfungsi sebagai wadah penyimpanan serbaguna yang cocok di gunakan di setiap sudut rumah agar tampak lebih menarik.\r\n\r\n- Ukuran :\r\nBesar : 43 x 30 x t15cm\r\nKecil : 22 x 18 x t14cm\r\n(produk handmade, terdapat perbedaan ukuran maks 2cm)\r\n\r\n- Warna :\r\nNatural (dapat terlihat berbeda pada masing-masing produk)\r\n\r\n- Material : 100% Eceng Gondok', NULL, NULL, '290000.00', '110000.00', '0.00', 0, '6853', 'instock', 1, 1, 'published', 34, 0, 0, 0, '1749472755.jpg', '1749472755-1.jpg', NULL, NULL, 4, 1, '2025-06-09 12:39:16', '2025-06-09 14:12:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_size`
--

CREATE TABLE `product_size` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `size_id` bigint(20) UNSIGNED NOT NULL,
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `product_size`
--

INSERT INTO `product_size` (`id`, `product_id`, `size_id`, `stock`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 100, '2025-06-09 11:27:56', '2025-06-09 11:27:56'),
(2, 2, 2, 27, '2025-06-09 11:33:48', '2025-06-09 11:33:48'),
(3, 2, 3, 14, '2025-06-09 11:33:48', '2025-06-09 11:33:48'),
(4, 4, 4, 15, '2025-06-09 11:42:19', '2025-06-09 11:42:19'),
(5, 4, 5, 16, '2025-06-09 11:42:19', '2025-06-09 11:42:19'),
(6, 4, 6, 20, '2025-06-09 11:42:19', '2025-06-09 11:42:19'),
(7, 5, 7, 29, '2025-06-09 11:45:53', '2025-06-09 11:45:53'),
(8, 5, 8, 5, '2025-06-09 11:45:53', '2025-06-09 11:45:53'),
(9, 5, 9, 8, '2025-06-09 11:45:53', '2025-06-09 11:45:53'),
(10, 5, 10, 17, '2025-06-09 11:45:53', '2025-06-09 11:45:53'),
(15, 10, 15, 29, '2025-06-09 12:34:58', '2025-06-09 14:16:24'),
(16, 10, 16, 24, '2025-06-09 12:34:58', '2025-06-09 14:16:24'),
(18, 11, 5, 33, '2025-06-09 14:12:54', '2025-06-09 14:12:54'),
(19, 6, 5, 42, '2025-06-09 14:13:35', '2025-06-09 14:13:35'),
(20, 7, 5, 67, '2025-06-09 14:15:28', '2025-06-09 14:15:28'),
(21, 7, 18, 23, '2025-06-09 14:15:28', '2025-06-09 14:15:28'),
(22, 7, 19, 28, '2025-06-09 14:15:28', '2025-06-09 14:15:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `related_videos`
--

CREATE TABLE `related_videos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'approved',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `order_item_id`, `product_id`, `rating`, `comment`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 8, 5, 'produknya bagus kok...', 'approved', '2025-06-09 13:21:09', '2025-06-09 13:21:09'),
(2, 1, 2, 11, 5, 'Keranjang nya nyaman dipakai, tidak berduri juga, saay merekomendasikan ini sih', 'approved', '2025-06-09 13:23:16', '2025-06-09 13:23:16'),
(3, 1, 4, 7, 5, 'cocok kok dibunga saya, tapi ga ada variasi lain?', 'approved', '2025-06-09 15:48:36', '2025-06-09 15:48:36'),
(4, 1, 5, 6, 3, 'aku kurang besar sedikit kotaknya, tapi suka dengan design nya', 'approved', '2025-06-09 15:49:05', '2025-06-09 15:49:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `review_media`
--

CREATE TABLE `review_media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `review_id` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
('abLUgZdxUY6xubTH5AtYSoYpBOFzxnPrfzGyjgBx', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiUkhzMldBRXpwR0tmMjcwZUpvNEtRS1JjYVRjQ1E4WGRFRzJRVmlTciI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FjY291bnQtb3JkZXItZGV0YWlscy85Ijt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvYWRtaW4vZGFzaGJvYXJkLXN0YXRzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjQ6ImNhcnQiO2E6MTp7czo0OiJjYXJ0IjtPOjI5OiJJbGx1bWluYXRlXFN1cHBvcnRcQ29sbGVjdGlvbiI6Mjp7czo4OiIAKgBpdGVtcyI7YToxOntzOjMyOiJmMDFkYzIxNGIyYTJkZGEyZGFkM2NkNzk3YzVhZDYwYyI7TzozNToiU3VyZnNpZGVtZWRpYVxTaG9wcGluZ2NhcnRcQ2FydEl0ZW0iOjk6e3M6NToicm93SWQiO3M6MzI6ImYwMWRjMjE0YjJhMmRkYTJkYWQzY2Q3OTdjNWFkNjBjIjtzOjI6ImlkIjtpOjExO3M6MzoicXR5IjtpOjM7czo0OiJuYW1lIjtzOjM2OiJLb3RhayBLZXJhbmphbmcgQW55YW1hbiBFY2VuZyBHb25kb2siO3M6NToicHJpY2UiO2Q6MTEwMDAwO3M6Nzoib3B0aW9ucyI7Tzo0MjoiU3VyZnNpZGVtZWRpYVxTaG9wcGluZ2NhcnRcQ2FydEl0ZW1PcHRpb25zIjoyOntzOjg6IgAqAGl0ZW1zIjthOjI6e3M6Nzoic2l6ZV9pZCI7aTo1O3M6OToic2l6ZV9uYW1lIjtzOjU6IjE4IENtIjt9czoyODoiACoAZXNjYXBlV2hlbkNhc3RpbmdUb1N0cmluZyI7YjowO31zOjUyOiIAU3VyZnNpZGVtZWRpYVxTaG9wcGluZ2NhcnRcQ2FydEl0ZW0AYXNzb2NpYXRlZE1vZGVsIjtzOjE4OiJBcHBcTW9kZWxzXFByb2R1Y3QiO3M6NDQ6IgBTdXJmc2lkZW1lZGlhXFNob3BwaW5nY2FydFxDYXJ0SXRlbQB0YXhSYXRlIjtpOjIxO3M6NDQ6IgBTdXJmc2lkZW1lZGlhXFNob3BwaW5nY2FydFxDYXJ0SXRlbQBpc1NhdmVkIjtiOjA7fX1zOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7fX1zOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3Nzc2MTAwNzU7fX0=', 1777618622),
('zUCZgUHMK6KtvsmFXBuLay0Pd11OzRyD3SH8E0Hy', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiZUhmZGZSZE0zNHFEVmU5Y2VOWmpiRDJWUlNKVVFORG5wMUNVcEtadyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzc3NjA5OTEwO31zOjQ6ImNhcnQiO2E6MDp7fXM6ODoib3JkZXJfaWQiO2k6OTt9', 1777614090);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sizes`
--

INSERT INTO `sizes` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, '1 Meter', '2025-06-09 11:27:56', '2025-06-09 11:27:56'),
(2, '30 Cm', '2025-06-09 11:33:48', '2025-06-09 11:33:48'),
(3, '40 Cm', '2025-06-09 11:33:48', '2025-06-09 11:33:48'),
(4, '15 Cm', '2025-06-09 11:42:19', '2025-06-09 11:42:19'),
(5, '18 Cm', '2025-06-09 11:42:19', '2025-06-09 11:42:19'),
(6, '20 Cm', '2025-06-09 11:42:19', '2025-06-09 11:42:19'),
(7, '39', '2025-06-09 11:45:53', '2025-06-09 11:45:53'),
(8, '40', '2025-06-09 11:45:53', '2025-06-09 11:45:53'),
(9, '41', '2025-06-09 11:45:53', '2025-06-09 11:45:53'),
(10, '42', '2025-06-09 11:45:53', '2025-06-09 11:45:53'),
(15, 'M', '2025-06-09 12:34:58', '2025-06-09 12:34:58'),
(16, 'L', '2025-06-09 12:34:58', '2025-06-09 12:34:58'),
(18, '16 Cm', '2025-06-09 14:15:28', '2025-06-09 14:15:28'),
(19, '17 Cm', '2025-06-09 14:15:28', '2025-06-09 14:15:28');

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
(1, 'Sendal', 'Bank Koperasi', 'ECENG GONDOK', 'http://127.0.0.1:8000/shop', 'slide_1749462014_6846abfe62368.png', 1, '2025-06-09 09:37:10', '2025-06-09 09:40:14'),
(2, 'Cover Kotak Tissue', 'Bank Koperasi', 'ECENG GONDOK', 'http://127.0.0.1:8000/shop?name=1&size=12&order=-1&brands=&categories=18&min=1&max=10000000', 'slide_1749462108_6846ac5c5c96d.png', 1, '2025-06-09 09:41:48', '2025-06-09 09:41:48'),
(3, 'Produk Samosir', 'Bank Koperasi', 'ECENG GONDOK', 'http://127.0.0.1:8000/shop', 'slide_1749462247_6846ace71f1d6.png', 1, '2025-06-09 09:43:11', '2025-06-09 10:27:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stock_reservations`
--

CREATE TABLE `stock_reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `pending_order_id` bigint(20) UNSIGNED NOT NULL,
  `reserved_quantity` int(10) UNSIGNED NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('active','released','converted') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '2025-06-09', 17, 'Request Pemasok', 1, 'Otomatis dari permintaan disetujui - Sion Pardosi (Onan Runggu)', '2025-06-09 13:27:11', '2025-06-09 13:27:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier_infos`
--

CREATE TABLE `supplier_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_caption` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `supplier_infos`
--

INSERT INTO `supplier_infos` (`id`, `title`, `description`, `image`, `video_type`, `video_url`, `video_caption`, `video_thumbnail`, `video_duration`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Mengapa Memberikan Pasokan?', 'Bank Koperasi Eceng Gondok membantu Anda mendapatkan penghasilan tambahan dengan mudah. Kami membayarkan insentif langsung setelah penjemputan, dan setiap pengiriman dipastikan aman dan terjadwal.', 'uploads/supplier_info/1749472994_1Cq3yl.png', 'local', 'uploads/supplier_videos/1749472994_tkVK8Q.mp4', NULL, NULL, '00:12', 0, 1, '2025-06-09 12:43:14', '2025-06-09 12:44:17');

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
  `kupon_id` bigint(20) UNSIGNED DEFAULT NULL,
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

INSERT INTO `supplier_requests` (`id`, `user_id`, `nama`, `email`, `no_hp`, `no_wa`, `lokasi`, `estimasi_kg`, `insentif`, `foto`, `catatan`, `status`, `kupon_id`, `catatan_admin`, `created_at`, `updated_at`, `kecamatan`, `desa`, `detail_lokasi`) VALUES
(1, 1, 'Sion Pardosi', 'spardosi12@gmail.com', '082278900178', '082278900178', NULL, 17, 'uang_tunai', 'uploads/bukti_pemasok/1749475554_UT7ApF.png', 'tidak ada', 'disetujui', NULL, 'baik saya terima akan saya hubungi melalui WhatsApp', '2025-06-09 13:25:54', '2025-06-09 13:27:11', 'Onan Runggu', 'Sipira', 'Onan runggu, sipira dekat kantor pln');

-- --------------------------------------------------------

--
-- Struktur dari tabel `threads`
--

CREATE TABLE `threads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remote_thread_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `thread_messages`
--

CREATE TABLE `thread_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `thread_id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `pending_order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mode` enum('midtrans','manual_atm') COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_proof` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','declined','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `snap_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `order_id`, `pending_order_id`, `invoice`, `mode`, `bank_code`, `payment_proof`, `status`, `snap_token`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, 'ORDER-1-f7a1c94f-2cc1-4ffa-b493-5b507e1fabdb', '', NULL, NULL, 'approved', 'ba93150c-8108-4c6a-bf7b-0fd8f114ed70', '2025-06-09 13:02:02', '2025-06-09 13:02:54'),
(2, 1, 2, NULL, 'ORDER-2-eb7e3ef7-233f-46c3-a2c5-1fce25e85ded', '', NULL, NULL, 'approved', '57ff5b80-7a53-472b-8af1-ad53d1592356', '2025-06-09 13:21:48', '2025-06-09 13:22:13'),
(3, 1, 3, NULL, 'ORDER-3-a9c1d210-bc0b-4c1f-bcd5-1a4e6e078866', '', NULL, NULL, 'approved', 'e32dbfe4-698b-46e1-9d13-0e93812c09ba', '2025-06-09 15:40:01', '2025-06-09 15:40:28'),
(4, 1, 4, NULL, 'ORDER-4-5ad79032-cac1-4b9e-8610-3205df8475c2', '', NULL, NULL, 'approved', '8eddf9f8-743c-4f94-92ed-31055613d0d8', '2025-06-09 15:45:28', '2025-06-09 15:45:51'),
(5, 1, 5, NULL, 'ORDER-5-45329e5b-af66-4500-b256-cf492746643a', 'manual_atm', 'BNI', NULL, 'declined', NULL, '2025-06-09 15:50:55', '2025-06-09 15:53:04'),
(6, 1, 6, NULL, 'ORDER-6-1ad2a137-a234-4f1e-855f-086ed02d4cc9', 'manual_atm', 'BNI', NULL, 'pending', NULL, '2025-06-09 15:53:50', '2025-06-09 15:53:50'),
(7, 1, 7, NULL, 'ORDER-7-d5f9a42d-3be0-4245-a818-2664112d295f', '', NULL, NULL, 'pending', 'fc9fabc5-5acf-4c60-a691-c08db8c7941e', '2025-06-09 15:56:56', '2025-06-09 15:56:56'),
(8, 1, 8, NULL, 'ORDER-8-0ef564de-41f2-41a0-894c-ad26d1c09adb', '', NULL, NULL, 'approved', 'ef6b3df8-e1fc-46a2-9845-c177bc920caf', '2026-04-29 07:06:34', '2026-04-29 17:24:15'),
(9, 1, 9, NULL, 'ORDER-9-c1e99c94-5330-462c-a76e-d6092c6a55f4', '', NULL, NULL, 'approved', '0755aca6-dc85-43e3-8ddb-202d7afee647', '2026-05-01 04:33:03', '2026-05-01 04:33:40');

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
  `gauth_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile`, `email_verified_at`, `phone_verified_at`, `password`, `profile_picture`, `bio`, `utype`, `remember_token`, `last_login_at`, `created_at`, `updated_at`, `gauth_id`, `gauth_type`) VALUES
(1, 'Sion Pardosi', 'spardosi12@gmail.com', '082278900178', NULL, NULL, '$2y$12$9wL5WY0BssVMopuxg1ORfOsXHpGQJIWqfbSTk1KAWR.S5TH1nh4Jy', 'uploads/foto_profile/1749475171_AoVJ1d.jpeg', NULL, 'USR', NULL, NULL, '2025-06-09 08:58:11', '2025-06-09 13:19:31', NULL, NULL),
(2, 'Admin', 'sionpardosi12@gmail.com', '8226232432423', NULL, NULL, '$2y$12$NAwYVfhe8jrRG4l1k1cLeu5GEAaCBm1eqK4pfhP9S/f4wo9e3fLWa', NULL, NULL, 'ADM', NULL, NULL, '2025-06-09 15:34:54', '2025-06-09 15:34:54', NULL, NULL);

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
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user_cart_items`
--

INSERT INTO `user_cart_items` (`id`, `user_id`, `product_id`, `name`, `quantity`, `price`, `options`, `created_at`, `updated_at`) VALUES
(12, 2, 11, 'Kotak Keranjang Anyaman Eceng Gondok', 3, '110000.00', '{\"size_id\":5,\"size_name\":\"18 Cm\"}', '2025-06-24 19:09:42', '2026-04-30 01:10:47');

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
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `abouts`
--
ALTER TABLE `abouts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `abouts_slug_unique` (`slug`);

--
-- Indeks untuk tabel `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `accounts_kode_unique` (`kode`);

--
-- Indeks untuk tabel `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `bank_accounts`
--
ALTER TABLE `bank_accounts`
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
-- Indeks untuk tabel `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_messages_session_id_foreign` (`session_id`);

--
-- Indeks untuk tabel `chat_sessions`
--
ALTER TABLE `chat_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chat_sessions_session_id_unique` (`session_id`),
  ADD KEY `chat_sessions_user_id_foreign` (`user_id`);

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
  ADD UNIQUE KEY `coupons_code_unique` (`code`),
  ADD KEY `coupons_code_is_active_index` (`code`,`is_active`),
  ADD KEY `coupons_expiry_date_index` (`expiry_date`);

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
-- Indeks untuk tabel `failed_payments`
--
ALTER TABLE `failed_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `failed_payments_pending_order_id_foreign` (`pending_order_id`);

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
-- Indeks untuk tabel `journal_entries`
--
ALTER TABLE `journal_entries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `journal_entries_no_jurnal_unique` (`no_jurnal`);

--
-- Indeks untuk tabel `journal_entry_lines`
--
ALTER TABLE `journal_entry_lines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `journal_entry_lines_journal_entry_id_foreign` (`journal_entry_id`),
  ADD KEY `journal_entry_lines_account_id_foreign` (`account_id`);

--
-- Indeks untuk tabel `manual_transactions`
--
ALTER TABLE `manual_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `manual_transactions_account_id_foreign` (`account_id`);

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
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`idnotification`);

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
-- Indeks untuk tabel `pending_orders`
--
ALTER TABLE `pending_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pending_orders_user_id_foreign` (`user_id`),
  ADD KEY `pending_orders_converted_to_order_id_foreign` (`converted_to_order_id`),
  ADD KEY `pending_orders_expires_at_index` (`expires_at`),
  ADD KEY `pending_orders_status_index` (`status`);

--
-- Indeks untuk tabel `pending_order_items`
--
ALTER TABLE `pending_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pending_order_items_pending_order_id_foreign` (`pending_order_id`),
  ADD KEY `pending_order_items_product_id_foreign` (`product_id`);

--
-- Indeks untuk tabel `penjadwalan_penjemputans`
--
ALTER TABLE `penjadwalan_penjemputans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penjadwalan_penjemputans_supplier_request_id_foreign` (`supplier_request_id`),
  ADD KEY `penjadwalan_penjemputans_status_jemput_index` (`status_jemput`),
  ADD KEY `penjadwalan_penjemputans_tanggal_jemput_index` (`tanggal_jemput`),
  ADD KEY `penjadwalan_penjemputans_kecamatan_desa_index` (`kecamatan`,`desa`);

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
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_is_active_status_index` (`is_active`,`status`),
  ADD KEY `products_featured_is_active_index` (`featured`,`is_active`),
  ADD KEY `products_stock_status_quantity_index` (`stock_status`,`quantity`);

--
-- Indeks untuk tabel `product_size`
--
ALTER TABLE `product_size`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_size_product_id_foreign` (`product_id`),
  ADD KEY `product_size_size_id_foreign` (`size_id`);

--
-- Indeks untuk tabel `related_videos`
--
ALTER TABLE `related_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reviews_order_item_id_unique` (`order_item_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`);

--
-- Indeks untuk tabel `review_media`
--
ALTER TABLE `review_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_media_review_id_foreign` (`review_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `stock_reservations`
--
ALTER TABLE `stock_reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_reservations_pending_order_id_foreign` (`pending_order_id`),
  ADD KEY `stock_reservations_expires_at_index` (`expires_at`),
  ADD KEY `stock_reservations_product_id_status_index` (`product_id`,`status`);

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
  ADD KEY `supplier_requests_coupon_id_foreign` (`kupon_id`);

--
-- Indeks untuk tabel `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `threads_owner_id_index` (`owner_id`),
  ADD KEY `threads_remote_thread_id_index` (`remote_thread_id`);

--
-- Indeks untuk tabel `thread_messages`
--
ALTER TABLE `thread_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `thread_messages_thread_id_foreign` (`thread_id`),
  ADD KEY `thread_messages_role_index` (`role`);

--
-- Indeks untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`),
  ADD KEY `transactions_order_id_foreign` (`order_id`),
  ADD KEY `transactions_pending_order_id_foreign` (`pending_order_id`);

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
-- AUTO_INCREMENT untuk tabel `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `chat_sessions`
--
ALTER TABLE `chat_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `email_verifications`
--
ALTER TABLE `email_verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_payments`
--
ALTER TABLE `failed_payments`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `job_lists`
--
ALTER TABLE `job_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `journal_entries`
--
ALTER TABLE `journal_entries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `journal_entry_lines`
--
ALTER TABLE `journal_entry_lines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `manual_transactions`
--
ALTER TABLE `manual_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT untuk tabel `month_names`
--
ALTER TABLE `month_names`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `notifications`
--
ALTER TABLE `notifications`
  MODIFY `idnotification` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pending_orders`
--
ALTER TABLE `pending_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pending_order_items`
--
ALTER TABLE `pending_order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `penjadwalan_penjemputans`
--
ALTER TABLE `penjadwalan_penjemputans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `product_size`
--
ALTER TABLE `product_size`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `related_videos`
--
ALTER TABLE `related_videos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `review_media`
--
ALTER TABLE `review_media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `slides`
--
ALTER TABLE `slides`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `stock_reservations`
--
ALTER TABLE `stock_reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `stok_bahan_bakus`
--
ALTER TABLE `stok_bahan_bakus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `supplier_infos`
--
ALTER TABLE `supplier_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `supplier_requests`
--
ALTER TABLE `supplier_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `threads`
--
ALTER TABLE `threads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `thread_messages`
--
ALTER TABLE `thread_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user_cart_items`
--
ALTER TABLE `user_cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `wishlist_items`
--
ALTER TABLE `wishlist_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `chat_sessions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `chat_sessions`
--
ALTER TABLE `chat_sessions`
  ADD CONSTRAINT `chat_sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `failed_payments`
--
ALTER TABLE `failed_payments`
  ADD CONSTRAINT `failed_payments_pending_order_id_foreign` FOREIGN KEY (`pending_order_id`) REFERENCES `pending_orders` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `job_applications`
--
ALTER TABLE `job_applications`
  ADD CONSTRAINT `job_applications_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `job_lists` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `journal_entry_lines`
--
ALTER TABLE `journal_entry_lines`
  ADD CONSTRAINT `journal_entry_lines_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `journal_entry_lines_journal_entry_id_foreign` FOREIGN KEY (`journal_entry_id`) REFERENCES `journal_entries` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `manual_transactions`
--
ALTER TABLE `manual_transactions`
  ADD CONSTRAINT `manual_transactions_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`);

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
-- Ketidakleluasaan untuk tabel `pending_orders`
--
ALTER TABLE `pending_orders`
  ADD CONSTRAINT `pending_orders_converted_to_order_id_foreign` FOREIGN KEY (`converted_to_order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pending_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pending_order_items`
--
ALTER TABLE `pending_order_items`
  ADD CONSTRAINT `pending_order_items_pending_order_id_foreign` FOREIGN KEY (`pending_order_id`) REFERENCES `pending_orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pending_order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

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
-- Ketidakleluasaan untuk tabel `product_size`
--
ALTER TABLE `product_size`
  ADD CONSTRAINT `product_size_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_size_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `review_media`
--
ALTER TABLE `review_media`
  ADD CONSTRAINT `review_media_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `stock_reservations`
--
ALTER TABLE `stock_reservations`
  ADD CONSTRAINT `stock_reservations_pending_order_id_foreign` FOREIGN KEY (`pending_order_id`) REFERENCES `pending_orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_reservations_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `stok_bahan_bakus`
--
ALTER TABLE `stok_bahan_bakus`
  ADD CONSTRAINT `stok_bahan_bakus_request_id_foreign` FOREIGN KEY (`request_id`) REFERENCES `supplier_requests` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `supplier_requests`
--
ALTER TABLE `supplier_requests`
  ADD CONSTRAINT `supplier_requests_coupon_id_foreign` FOREIGN KEY (`kupon_id`) REFERENCES `coupons` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `supplier_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `thread_messages`
--
ALTER TABLE `thread_messages`
  ADD CONSTRAINT `thread_messages_thread_id_foreign` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_pending_order_id_foreign` FOREIGN KEY (`pending_order_id`) REFERENCES `pending_orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
