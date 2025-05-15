-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Waktu pembuatan: 13 Bulan Mei 2025 pada 06.02
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
(4, 'Tentang Bank Koperasi Eceng Gondok Samosir', 'tentang-bank-koperasi-eceng-gondok-samosir', 'Di pesisir Danau Toba, pertumbuhan Eceng Gondok yang tak terkendali menutupi perairan dan meresahkan masyarakat setempat. Bank Koperasi Eceng Gondok Samosir hadir sebagai inisiatif inovatif untuk mengatasi masalah lingkungan sekaligus memberdayakan masyarakat lokal. Koperasi ini didirikan oleh Sumondang Tabita Nainggolan pada akhir tahun 2023 di Sitanggang Bau, Pangururan. Melalui kolaborasi dan semangat gotong-royong, kami mengubah Eceng Gondok yang selama ini dianggap gulma menjadi produk kerajinan bernilai tinggi, menciptakan lapangan usaha baru bagi komunitas sekitar.\r\nSejumlah pengrajin lokal Bank Koperasi Eceng Gondok Samosir menunjukkan hasil kerajinan dari Eceng Gondok dengan bangga. Pada awalnya, proses pembuatan sandal, tas, dan kerajinan lain masih dilakukan secara manual menggunakan teknik anyaman tradisional. Melalui pelatihan dan kerja sama, kami meningkatkan kemampuan anggota sehingga kapasitas produksi pun bertambah. Setiap helai Eceng Gondok dikeringkan, dihaluskan, dan dianyam dengan tangan sesuai kearifan lokal, menghasilkan produk kerajinan berkualitas tinggi. Kini, produk kami tidak hanya dipasarkan secara lokal, tetapi juga melalui platform daring, menjangkau konsumen yang lebih luas.\r\nMenjawab tantangan pengelolaan usaha yang masih dilakukan secara manual, kami mengembangkan sistem koperasi digital terintegrasi. Dengan sistem daring ini, proses pendaftaran anggota, transaksi, dan pengelolaan usaha dilakukan lebih mudah dan efisien. Langkah ini tidak hanya meningkatkan efisiensi operasional, tetapi juga transparansi, sehingga setiap anggota dapat memantau pembukuan dan distribusi produk secara terbuka. Melalui platform digital, kami mengajak masyarakat lebih aktif berpartisipasi dan menjangkau pasar yang lebih luas bagi produk Eceng Gondok Samosir.', 'Menjadi koperasi terdepan yang memberdayakan ekonomi masyarakat lokal melalui pemanfaatan Eceng Gondok secara berkelanjutan untuk menjaga lingkungan Danau Toba, serta mendukung inovasi sistem digital dan pelestarian budaya serta kerajinan lokal.', 'Meningkatkan kesejahteraan ekonomi masyarakat lokal melalui pelatihan dan pendampingan kewirausahaan berbasis Eceng Gondok.\r\nMengelola Eceng Gondok secara berkelanjutan untuk menjaga kelestarian lingkungan Danau Toba.\r\nMengembangkan sistem koperasi digital yang transparan dan efisien untuk mempermudah administrasi dan pemasaran produk.\r\nMelestarikan budaya lokal melalui inovasi kerajinan Eceng Gondok yang khas Samosir.', 'Sumondang', '2025-04-29', 'Jl. Sitanggang No. 1, Desa Sitanggang Bau, Kec. Pangururan, Kab. Samosir, Sumatera Utara', 'Telepon: +62 812 3456 7890\r\nEmail: info@bkecg-samosir.id\r\nWebsite: www.bkecg-samosir.coop', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4966.45620991171!2d98.69318757585994!3d2.628665756129755!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3031c5ca7c7e07f9%3A0x2c25b5a19a80edae!2skoperasibank%20Eceng%20Gondok!5e1!3m2!1sid!2sid!4v1745930060331!5m2!1sid!2sid\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'uploads/abouts/1747108708_PWREpg.jpeg', 'Tentang Bank Koperasi Eceng Gondok Samosir', 'Tentang Bank Koperasi Eceng Gondok Samosir', 'uploads/abouts/1747108708_JgL3gG.jpeg', 'Tentang Bank Koperasi Eceng Gondok Samosir', 'Tentang Bank Koperasi Eceng Gondok Samosir', 1, '2025-04-29 06:13:53', '2025-05-13 03:58:28');

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
(1, 1, 'sion', '082278900178', 'fdsf', 'sajbdsad', 'balige', 'balige', 'Indonesia', 'dsfdsf', '22312', 'home', 1, '2025-05-12 17:20:15', '2025-05-12 17:20:15');

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
(6, 'Eceng Gondok Samosir', 'eceng-gondok-samosir', '1745403749.png', '2025-04-22 20:22:29', '2025-04-22 20:22:29');

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
('efranlumbantoruan83@gmail.com|127.0.0.1', 'i:1;', 1747100912),
('efranlumbantoruan83@gmail.com|127.0.0.1:timer', 'i:1747100912;', 1747100912),
('listra.sidabutar@gmail.com|127.0.0.1', 'i:2;', 1747103531),
('listra.sidabutar@gmail.com|127.0.0.1:timer', 'i:1747103531;', 1747103531),
('sumondang@gmail.com|127.0.0.1', 'i:1;', 1747069886),
('sumondang@gmail.com|127.0.0.1:timer', 'i:1747069886;', 1747069886);

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
(11, 'Topi', 'topi', '1745403070.avif', NULL, '2025-04-22 20:11:11', '2025-04-22 20:11:11'),
(12, 'Kotak Tissue', 'kotak-tissue', '1745403101.webp', NULL, '2025-04-22 20:11:42', '2025-04-22 20:11:42'),
(13, 'Karpet', 'karpet', '1745403132.jpg', NULL, '2025-04-22 20:12:12', '2025-04-22 20:12:12'),
(14, 'Wadah', 'wadah', '1745403148.jpg', NULL, '2025-04-22 20:12:28', '2025-04-22 20:12:28'),
(15, 'Keranjang', 'keranjang', '1745403164.jpg', NULL, '2025-04-22 20:12:44', '2025-04-22 20:12:44'),
(16, 'Sendal', 'sendal', '1745403179.webp', NULL, '2025-04-22 20:12:59', '2025-04-22 20:12:59'),
(17, 'Bantal', 'bantal', '1745403192.jpg', NULL, '2025-04-22 20:13:13', '2025-04-22 20:13:13'),
(18, 'Tas', 'tas', '1745403217.jpg', NULL, '2025-04-22 20:13:37', '2025-04-22 20:13:37'),
(19, 'Vas Bunga', 'vas-bunga', '1745403246.jpg', NULL, '2025-04-22 20:14:06', '2025-04-22 20:14:06');

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
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('fixed','percent') COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` decimal(15,2) NOT NULL,
  `cart_value` decimal(15,2) NOT NULL,
  `expiry_date` date NOT NULL DEFAULT cast(current_timestamp() as date),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(4, '2025_01_13_000344_create_orders_table', 1),
(5, '2025_02_13_000550_create_transactions_table', 1),
(6, '2025_02_20_125325_create_brands_table', 1),
(7, '2025_02_21_015419_create_categories_table', 1),
(8, '2025_02_21_072635_create_products_table', 1),
(9, '2025_02_27_014009_create_coupons_table', 1),
(10, '2025_02_27_080912_create_order_items_table', 1),
(11, '2025_02_27_080927_create_addresses_table', 1),
(12, '2025_02_28_065150_create_slides_table', 1),
(13, '2025_03_01_173133_create_month_names_table', 1),
(14, '2025_03_02_075927_create_contacts_table', 1),
(15, '2025_03_04_071131_modify_price_columns_in_products_table', 1),
(16, '2025_03_04_084756_modify_order_decimal_columns', 1),
(17, '2025_03_04_084957_modify_price_column_in_order_items_table', 1),
(18, '2025_03_04_091822_modify_coupon_columns', 1),
(19, '2025_03_04_134922_modify_coupon_decimal_columns', 1),
(20, '2025_03_07_145957_create_personal_access_tokens_table', 1),
(21, '2025_03_09_200243_create_job_lists_table', 1),
(22, '2025_03_09_200308_create_job_applications_table', 1),
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
(33, '2025_04_29_142120_create_abouts_table', 1),
(34, '2025_04_29_200705_add_map_embed_to_abouts_table', 1),
(35, '2025_05_04_023708_add_mobile_to_users_table', 1),
(36, '2025_05_04_031350_create_email_verifications_table', 1),
(37, '2025_05_05_160722_create_chat_sessions_table', 1),
(38, '2025_05_05_160752_create_chat_messages_table', 1),
(39, '2025_05_06_095857_create_supplier_infos_table', 1),
(40, '2025_05_07_084334_create_threads_table', 1),
(41, '2025_05_07_084335_create_thread_messages_table', 1),
(42, '2025_05_09_081915_update_supplier_infos_and_create_related_videos', 1);

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
  `idnotification` int(11) NOT NULL,
  `pesan` text NOT NULL,
  `waktu` datetime NOT NULL,
  `status` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `notifications`
--

INSERT INTO `notifications` (`idnotification`, `pesan`, `waktu`, `status`) VALUES
(0, 'Pesanan Baru Dari sion dengan Invoice ORDER-1-81abea07-3394-4e75-b02e-b91ea6757782 dengan status pending', '2025-05-13 00:20:16', 'read'),
(0, 'Pesanan telah dikonfirmasi untuk Invoice ORDER-1', '2025-05-13 00:24:02', 'read'),
(0, 'Pesanan telah dibatalkan untuk Invoice ORDER-1', '2025-05-13 00:27:22', 'read'),
(0, 'Pesanan telah dikirim untuk Invoice ORDER-1', '2025-05-13 00:30:29', 'read'),
(0, 'Pesanan telah diterima oleh admin untuk Invoice ORDER-1', '2025-05-13 00:30:42', 'read'),
(0, 'Pesanan telah dikirim untuk Invoice ORDER-1', '2025-05-13 00:32:30', 'read'),
(0, 'Pesanan menunggu konfirmasi untuk Invoice ORDER-1', '2025-05-13 00:32:46', 'read'),
(0, 'Pesanan telah dikonfirmasi untuk Invoice ORDER-1', '2025-05-13 00:32:53', 'read'),
(0, 'Pesanan sedang diproses untuk Invoice ORDER-1', '2025-05-13 01:09:39', 'unread'),
(0, 'Pesanan telah dikirim untuk Invoice ORDER-1', '2025-05-13 01:19:11', 'unread');

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
  `status` enum('pending','confirmed','processing','shipped','delivered','completed','canceled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
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

INSERT INTO `orders` (`id`, `user_id`, `subtotal`, `discount`, `tax`, `total`, `name`, `phone`, `locality`, `address`, `city`, `state`, `country`, `landmark`, `zip`, `type`, `status`, `is_shipping_different`, `confirmed_date`, `processing_date`, `shipped_date`, `delivered_date`, `completed_date`, `canceled_date`, `created_at`, `updated_at`) VALUES
(1, 1, '300000.00', '0.00', '63000.00', '363000.00', 'sion', '082278900178', 'fdsf', 'sajbdsad', 'balige', 'balige', 'Indonesia', 'dsfdsf', '22312', 'home', 'shipped', 0, '2025-05-13', '2025-05-13', '2025-05-13', '2025-05-13', NULL, '2025-05-13', '2025-05-12 17:20:15', '2025-05-12 18:19:11');

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
(1, 24, 1, '150000.00', 2, NULL, 0, '2025-05-12 17:20:15', '2025-05-12 17:20:15');

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
(17, 'Sendal Anyaman Eceng Gondok', 'sendal-anyaman-eceng-gondok', 'Sendal Anyaman Eceng Gondok Samosir', 'Sendal Anyaman Eceng Gondok Samosir', '25000.00', '25000.00', 'sendal000001', 'instock', 1, 30, '1745404000.jpg', '1745404000-1.png,1745404000-2.png,1745404000-3.png', 16, 6, '2025-04-22 20:26:42', '2025-04-22 20:26:42'),
(18, 'Karpet Anyaman Eceng Gondok', 'karpet-anyaman-eceng-gondok', 'Karpet Anyaman Eceng Gondok Samosir', 'Karpet Anyaman Eceng Gondok Samosir', '12000.00', '11000.00', 'karpet0000001', 'instock', 1, 16, '1745404380.jpg', '1745404380-1.jpg', 13, 6, '2025-04-22 20:33:00', '2025-04-22 20:33:00'),
(19, 'Tas Enceng Gondok Anyaman Samosir', 'tas-enceng-gondok-anyaman-samosir', 'Tas Enceng Gondok Anyaman Samosir', 'Tas Enceng Gondok Anyaman Samosir', '94000.00', '49000.00', 'tas0000001', 'instock', 1, 7, '1745404445.jpg', '1745404445-1.jpg,1745404445-2.jpg', 18, 6, '2025-04-22 20:34:06', '2025-04-22 20:34:06'),
(20, 'Cover dan Bantal Anyaman Eceng Gondok', 'cover-dan-bantal-anyaman-eceng-gondok', 'Cover dan Bantal Anyaman Eceng Gondok', 'Cover dan Bantal Anyaman Eceng Gondok', '50000.00', '49000.00', 'bantal0000001', 'instock', 1, 90, '1745404545.jpg', '1745404545-1.jpg,1745404545-2.jpg', 17, 6, '2025-04-22 20:35:46', '2025-04-22 20:35:46'),
(21, 'Topi Anyaman Eceng Gondok Samosir', 'topi-anyaman-eceng-gondok-samosir', 'Topi Anyaman Eceng Gondok Samosir', 'Topi Anyaman Eceng Gondok Samosir', '59000.00', '21000.00', 'topi00001', 'instock', 1, 40, '1745404704.avif', '1745404704-1.jpg', 11, 6, '2025-04-22 20:38:29', '2025-04-22 20:41:13'),
(22, 'Kotak Cover Tissue Anyaman Eceng Gondok', 'kotak-cover-tissue-anyaman-eceng-gondok', 'Kotak Cover Tissue Anyaman Eceng Gondok Samosir', 'Kotak Cover Tissue Anyaman Eceng Gondok', '30000.00', '30000.00', 'kotaktissue000001', 'instock', 1, 12, '1745404943.webp', '1745404943-1.jpg', 12, 6, '2025-04-22 20:42:23', '2025-04-22 20:42:23'),
(23, 'Kotak Keranjang Anyaman Eceng Gondok', 'kotak-keranjang-anyaman-eceng-gondok', 'Kotak Keranjang Anyaman Eceng Gondok Samosir', 'Kotak Keranjang Anyaman Eceng Gondok Samosir', '90000.00', '89000.00', 'keranjang000001', 'instock', 1, 50, '1745405025.jpg', '1745405025-1.jpg,1745405025-2.jpg', 15, 6, '2025-04-22 20:43:46', '2025-04-22 20:43:46'),
(24, 'Cover Vas Bunga Anyaman Eceng Gondok', 'cover-vas-bunga-anyaman-eceng-gondok', 'Cover Vas Bunga Anyaman Eceng Gondok Samosir', 'Cover Vas Bunga Anyaman Eceng Gondok Samosir', '150000.00', '150000.00', 'vasbunga000001', 'instock', 1, 16, '1745405097.jpg', '1745405097-1.jpg', 19, 6, '2025-04-22 20:44:57', '2025-04-22 20:44:57');

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
('1EkO2coRTB7HxkKdD6E509Wf6YnveW0obZPMyq5P', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia1luTzNzWXhFN1cyRzVCeVdqQzBaY3BVNzVSQWU2R1BhUkhnOUdoeSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747105341),
('1HWIl5JgTN4xFpGeE2VdAjk4UAUSyqmavZP40dk4', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiREFaY282RHlHM2daVUtxYko5NEJkZWNiQ3loWFpWamQ2NjRKOWhpRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747107378),
('22gzOllDsiNarepY2OTsuCOjQpkqoTGsUxWgTE23', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSWNWTU1YM2pLZDJBRUI1aUdtUzRDTVQzTm9WQ3JjMFFoNWs1dTBFOCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747103629),
('2fGCGSaZMIumcfSY1kNbJ9pOarAljjoZa6LaEUln', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia0VpdHVKcFZrRGVGYllkM2ZaMFZOYWZVMkkwMFpneTRNT0JHMWJqdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747103240),
('2LlU51ZbbRZtMDKLauX2roa2Xa0QoAvOfw9LDQMy', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZnNjZzd0TWFaTHhjemNrdWxVSFZ4QXBzaUozTE9qSWt0NFlZYjgzdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747108288),
('2oaGvXtuHQmOEsxQy0fDlnPA154fOe4elwKfQZ1u', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRjg5cnVrT3NUMWFlQzdqUkFPckxLbVFVVkh4cW56cWh4WWdMTDVmQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747100334),
('2Tz8fyHPuXdaE7HyaOhs507p0y1jq9g6sDoBomDf', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoicHJ3c1JqanVHQTJYSG41cDhyTTc2c3NucFRGeHB4enllSEp4WXlreiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzQ3MTA4NjYyO319', 1747108664),
('429xTV4ZjgiCN9otF4R4paxC3QQkhaUKjziJwSB2', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid2dnRVdUc20yOFFlTUNkNmtDSll2RlBMVGNsVHNWU0FDbk5ZbUdVOCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747108923),
('42A9VezaNcp8JyFKvH102sgT4Vp6Hw7sEfmD4c3F', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVGZTOU5aZlpSN1MwYVVhTE43MnNSdHZkc25pc09meHRUckR1Uk8zbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747108757),
('4BqOAGZUl6zhb8oIQairKCd3STUPJG3Ne6AiLV4G', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSm1FMkR5eFd2TzlGVkF1TGRwTVgwdDN2eGMxMzNtOE1INDF6dW93MSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC92ZXJpZmljYXRpb24vZm9ybT9lbWFpbD1sYWxpc3RyYW1hbm9iYW4yNyU0MGdtYWlsLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MjI6InZlcmlmaWNhdGlvbl90aW1lc3RhbXAiO2k6MTc0NzEwNjk2ODt9', 1747107030),
('54hQ9BtQuFMgujYHD5sCplDGYsm4rAJR4Ya6bNwY', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTzRkemQyTDl0SGUwYWl1dG53WXo5VEw3dGVyem5HdGQ2YWNkQk9RSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747103689),
('5FPkx3otyWOE35dXpoqfiMszMoU26vFioUv3IO96', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibWNZRk9kMW5sZVJXTGdhRUtMd1FBUWV2RDBGWFhCcGVrQkc1RlYyZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747105901),
('5L3KsdOKxB84pEtlJmpyhyhMqfvgkqNUfAm3sgYy', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQkVCOUNheFZPTXo1TDFkMVg1OHpWRDBYNkRzRnR6RFdaS250dndHTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747106442),
('7sfh5iYEZb75bXFFJJ5YtKRcEM29c8rmcZaeZ7Qc', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZDdvbE4xVWkzNUp1ZXhwSkZGM0JNQjlNWVJ1UHZ4eFh4QzZoeVc4WiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747102653),
('8FDeGplzLIdoa4Rv4GMIyZKYeoCHZbzrq96TrAfi', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRmR5VDhZTnlaRmJrM3BrT3NLbW1lUEZtRzJodFBFSGp6d1hnVjdIeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747101841),
('8XMgQuZwPzghCD5cKs9Jv4SUiam5NTTP6RVmgji1', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVmhVOUlwMk1jbjlDbjVKYmxuc2RlQWhWc241RFF3azIxOFdhdWZHNSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747102080),
('aQmXvcAd1o6Ymve0cAMBtHUh2SpyKBG1TFRuzL09', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicHhQcXJFVDNVVlhFNVJjOVE2SkVrYWdNZEs5VENvUXB3TGN3TFVEQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747105977),
('auVHFiVultsOLWeOZmNUzo4sIFHCb65Q6PvpA88A', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidWRaRlllbURJbEU0SUJvQ1Q3Mld1czVOdm1udU9qNWNPVTFXUDNmSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747105598),
('b5E6FeBfQ3yYw7yzrWuS8VEhHdghyT0aSfR8aprO', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYW5zUGw0NUVYQ0tBYVVCOXQyTnlwU1VKYXkwc3Q2VHB5QjRNWVpidSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747107058),
('bxFEyKf9UG1gbqYDtjI5XOZRCUiL43Hwmu28iVIt', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUERDZmEwWVVnbDN1VjNhNW5La2l3RElUSzBSUkczU2luV1R3aHpjWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747104688),
('bZaJuFcTfdJZO0FQZMqdNwCWNA3Ti4Volhnq2nwL', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUUJadWE5cmJMVWpPS3pOUEppSElDY3ZORkQ4NVNUZUFHVERvb2VTMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747106321),
('FV7HMf446Yf63eOC05OEaX34no2blPAWfPkbkYQs', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQjdJTW1GSmc2RTRzR1FISVRQWGpFOUM5Y2JVZU9OMEo1aEFWWmx4USI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747106471),
('GBjYQ3TFd7sYMx8xl8FVXUasYnFL05ybZh7X0uTp', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRmV4RmY2eTlJTk4wOGlBZmtld3BoU3p5dGFEQ05YODFYZ2YxUTZWTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NDoiY2FydCI7YToxOntzOjQ6ImNhcnQiO086Mjk6IklsbHVtaW5hdGVcU3VwcG9ydFxDb2xsZWN0aW9uIjoyOntzOjg6IgAqAGl0ZW1zIjthOjE6e3M6MzI6IjhlYjc0N2I5NWI5ODYyZTlkODMwMzFiZWI5OTM4NzIwIjtPOjM1OiJTdXJmc2lkZW1lZGlhXFNob3BwaW5nY2FydFxDYXJ0SXRlbSI6OTp7czo1OiJyb3dJZCI7czozMjoiOGViNzQ3Yjk1Yjk4NjJlOWQ4MzAzMWJlYjk5Mzg3MjAiO3M6MjoiaWQiO3M6MjoiMjEiO3M6MzoicXR5IjtpOjI7czo0OiJuYW1lIjtzOjMzOiJUb3BpIEFueWFtYW4gRWNlbmcgR29uZG9rIFNhbW9zaXIiO3M6NToicHJpY2UiO2Q6MjEwMDA7czo3OiJvcHRpb25zIjtPOjQyOiJTdXJmc2lkZW1lZGlhXFNob3BwaW5nY2FydFxDYXJ0SXRlbU9wdGlvbnMiOjI6e3M6ODoiACoAaXRlbXMiO2E6MDp7fXM6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDt9czo1MjoiAFN1cmZzaWRlbWVkaWFcU2hvcHBpbmdjYXJ0XENhcnRJdGVtAGFzc29jaWF0ZWRNb2RlbCI7czoxODoiQXBwXE1vZGVsc1xQcm9kdWN0IjtzOjQ0OiIAU3VyZnNpZGVtZWRpYVxTaG9wcGluZ2NhcnRcQ2FydEl0ZW0AdGF4UmF0ZSI7aToyMTtzOjQ0OiIAU3VyZnNpZGVtZWRpYVxTaG9wcGluZ2NhcnRcQ2FydEl0ZW0AaXNTYXZlZCI7YjowO319czoyODoiACoAZXNjYXBlV2hlbkNhc3RpbmdUb1N0cmluZyI7YjowO319fQ==', 1747101605),
('GJnUpuGGDXuALNFq5bUKpEW7iPo2jpzY1S4mzk2R', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWGxJSUdFbDJ2eDU5N2M4TnJ1WFVGZzBuRTJMYVdwR1N6cDlaSTJOUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747103806),
('hEc2hVLgUqwxNyBxB9ZLHYEPeWBFtwzpiEMAnPUi', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN04zUGI1RzdubGZLQ01MZ2hJYjY1TDhkb3Z4Nkd6TzNhNlNwNE1HNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747105304),
('hlFluNVeaWmaNxLGTe5eY3Ii5B6SuRUrgBjY1i4X', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR0pRNVdVWFlYWkNpOWhmb3BxUEZJMTdEcm5tYTBwUGVEVGhqSE11RCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747100814),
('hyF3n8r9gC72lAQjaKAg6HhlfJDPX3RWaK5B29Wz', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOFJWWk1rcm44ekdzeUg4bWZ1QzkxdDVKS3FIQVh2Q2ZoUDVLVHlDbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747104311),
('iEhzJY3vPVc0OYqiMP7EdfPbBpHF1dkNN1zQhlP1', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV1VtTFF4OUNaaHpSSWVhS3djOUhXRXE2RDVRRVpBeGRQZEVGOEJ3VyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747106688),
('ISW1KwUF8sG7q3i0xZt8zH49enWnXaA3SvtcpSyR', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaE55YWhJNUU5YWFtUnhhcTZLRWh6UGtrQ1p6eWVsNUgzV1J1TGk0OCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747105188),
('JC0FGRgA9HJ6bpHFBMQp5xZPLhdIhbfATpcGknuF', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOHl1UzBnWHRiNVlzTk1KS0IyZFRFTGRyR0ZHUlJpT09jUXVKYnNOTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747103870),
('K5cE6lC5v2aeW6fY9iSDt6ddph31H0msodb5zIz5', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaGRKektEampmNFJLNFF3WXk4Q0VROGVCcnlwS1JvdENBS3NocVBycyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747102613),
('KmtlUzxxEvJKDB71pzMrll7CE33W6cyqS7Mt34Hd', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieFNaNzl4bFNGRGVZZHhpR3FTUWhMUko0ZnhPRGhCQXNhcDhlNDd4MSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747103008),
('KwwnGbjxAbdnrTNtJtr2TS7kmVWKFmpxFCBty928', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUnN6cHlsejNQUEc1d0N5bGk2QVU2dlZxQjI3c1RVVHVjaXVXbFhMWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747102700),
('LiZehmJg9TpFfYH1V1g0QhlWYyigwRvcxHjPFDcY', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTzhpMVRMemFCa3FhUnhsbEM4NkhHUnJIeWdhRzhNNmNSSnlqMmxKaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747100942),
('MwaQw98ByEP9OlGylyqa2GpUVjBGza4yAcl24EMX', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidFBXdGY2V3I5cGtkN3dYUzZ3dHhvTFB4ekhBTkNvYjBJWXBEa2drTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747106497),
('noGv7EzDuvqTEhwH9v5b16wzTCpHKCIsplD1ofzU', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMjNhVHhEQTVwVnY5NnJqQW1nR2Y2dWpjS2ZIc1N6VDBlRWdVWjFkbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747101803),
('OohJ7Y4O0AUe0X7BmgoP6zjZBD7rk01z1SRg7Lkd', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidklmU3Nxd0UyblhHYW1hbHNTT0g1WHRCVU1zbnRMaDE5OGRqOGlwYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747102494),
('p8sF62Vk2P359VJMhSQumR8JnwqktIDa32C1xuiz', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYmxqS1M4MTc0a2xsMG9YWmFoc3k3UUdCT0JOUm8zcEdzRzNJdWZ1TiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747105764),
('pAe68MwlVmOKLAq06c8YinLGrbyt0nRHG5XB9cIK', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMU02T0U2emVnc2I0TWhwZnVUTFoxRTA0dEtid1dETlMyd0d1dG9IcyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==', 1747108636),
('PbMlDLPT1Pz6housTt6elisQDJ42OqTWZpmSSc7N', NULL, '127.0.0.1', 'WhatsApp/2.2518.3 W', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV252TGZjT2xkd3VGUWNWaXJFSlVmU2tRTDBCME4zSDFmMzVibW9sbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747100220),
('pgon7b1VqtisDLP0gGRjDViwRQ3yS1R61KYE7UzB', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT00zbnhGY0VEcE5vZW0zTUdIdDRzamRMRWVueUM3VTlHNEp2T0tFUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747100639),
('PUZaUWW8LJd70Xiqsws6Q7qugW5Bj9hqrAv9PH2e', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM0JreFVDcUVmSW5MSUxyT1oxYTN4V1A3dW9YUG43eUhsT0x4U3JTVCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747102775),
('qQCzc5sAU9SlZWFMsj1JXlGrOUJ6T6fT5CZ6ALjA', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM2hRaTNId0RDd1ZFeExFYXBxaEZYc3ZzV1Q3U0V1VjJUR3prd05STSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747108722),
('RDae7PPNd6GOOXATxzka4aWsMJfA7pniepdT2XGI', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiSVdpeVFmbVR5UHBib29aUzJoRzN2UzJNWlY3dDdIREtRNTVEZEMzTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9qb2ItdmFjYW5jeSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzQ3MDk5ODU1O31zOjQ6ImNhcnQiO2E6Mjp7czo0OiJjYXJ0IjtPOjI5OiJJbGx1bWluYXRlXFN1cHBvcnRcQ29sbGVjdGlvbiI6Mjp7czo4OiIAKgBpdGVtcyI7YToyOntzOjMyOiIxOTNmNjMyNjQ0ZTA2YTMwN2NiYTE4OTE3YWIxMzkyNCI7TzozNToiU3VyZnNpZGVtZWRpYVxTaG9wcGluZ2NhcnRcQ2FydEl0ZW0iOjk6e3M6NToicm93SWQiO3M6MzI6IjE5M2Y2MzI2NDRlMDZhMzA3Y2JhMTg5MTdhYjEzOTI0IjtzOjI6ImlkIjtzOjI6IjE5IjtzOjM6InF0eSI7aToyO3M6NDoibmFtZSI7czozMzoiVGFzIEVuY2VuZyBHb25kb2sgQW55YW1hbiBTYW1vc2lyIjtzOjU6InByaWNlIjtkOjQ5MDAwO3M6Nzoib3B0aW9ucyI7Tzo0MjoiU3VyZnNpZGVtZWRpYVxTaG9wcGluZ2NhcnRcQ2FydEl0ZW1PcHRpb25zIjoyOntzOjg6IgAqAGl0ZW1zIjthOjA6e31zOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7fXM6NTI6IgBTdXJmc2lkZW1lZGlhXFNob3BwaW5nY2FydFxDYXJ0SXRlbQBhc3NvY2lhdGVkTW9kZWwiO3M6MTg6IkFwcFxNb2RlbHNcUHJvZHVjdCI7czo0NDoiAFN1cmZzaWRlbWVkaWFcU2hvcHBpbmdjYXJ0XENhcnRJdGVtAHRheFJhdGUiO2k6MjE7czo0NDoiAFN1cmZzaWRlbWVkaWFcU2hvcHBpbmdjYXJ0XENhcnRJdGVtAGlzU2F2ZWQiO2I6MDt9czozMjoiOGViNzQ3Yjk1Yjk4NjJlOWQ4MzAzMWJlYjk5Mzg3MjAiO086MzU6IlN1cmZzaWRlbWVkaWFcU2hvcHBpbmdjYXJ0XENhcnRJdGVtIjo5OntzOjU6InJvd0lkIjtzOjMyOiI4ZWI3NDdiOTViOTg2MmU5ZDgzMDMxYmViOTkzODcyMCI7czoyOiJpZCI7czoyOiIyMSI7czozOiJxdHkiO2k6OTtzOjQ6Im5hbWUiO3M6MzM6IlRvcGkgQW55YW1hbiBFY2VuZyBHb25kb2sgU2Ftb3NpciI7czo1OiJwcmljZSI7ZDoyMTAwMDtzOjc6Im9wdGlvbnMiO086NDI6IlN1cmZzaWRlbWVkaWFcU2hvcHBpbmdjYXJ0XENhcnRJdGVtT3B0aW9ucyI6Mjp7czo4OiIAKgBpdGVtcyI7YTowOnt9czoyODoiACoAZXNjYXBlV2hlbkNhc3RpbmdUb1N0cmluZyI7YjowO31zOjUyOiIAU3VyZnNpZGVtZWRpYVxTaG9wcGluZ2NhcnRcQ2FydEl0ZW0AYXNzb2NpYXRlZE1vZGVsIjtzOjE4OiJBcHBcTW9kZWxzXFByb2R1Y3QiO3M6NDQ6IgBTdXJmc2lkZW1lZGlhXFNob3BwaW5nY2FydFxDYXJ0SXRlbQB0YXhSYXRlIjtpOjIxO3M6NDQ6IgBTdXJmc2lkZW1lZGlhXFNob3BwaW5nY2FydFxDYXJ0SXRlbQBpc1NhdmVkIjtiOjA7fX1zOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7fXM6ODoid2lzaGxpc3QiO086Mjk6IklsbHVtaW5hdGVcU3VwcG9ydFxDb2xsZWN0aW9uIjoyOntzOjg6IgAqAGl0ZW1zIjthOjI6e3M6MzI6IjE5M2Y2MzI2NDRlMDZhMzA3Y2JhMTg5MTdhYjEzOTI0IjtPOjM1OiJTdXJmc2lkZW1lZGlhXFNob3BwaW5nY2FydFxDYXJ0SXRlbSI6OTp7czo1OiJyb3dJZCI7czozMjoiMTkzZjYzMjY0NGUwNmEzMDdjYmExODkxN2FiMTM5MjQiO3M6MjoiaWQiO2k6MTk7czozOiJxdHkiO2k6MTtzOjQ6Im5hbWUiO3M6MzM6IlRhcyBFbmNlbmcgR29uZG9rIEFueWFtYW4gU2Ftb3NpciI7czo1OiJwcmljZSI7ZDo0OTAwMDtzOjc6Im9wdGlvbnMiO086NDI6IlN1cmZzaWRlbWVkaWFcU2hvcHBpbmdjYXJ0XENhcnRJdGVtT3B0aW9ucyI6Mjp7czo4OiIAKgBpdGVtcyI7YTowOnt9czoyODoiACoAZXNjYXBlV2hlbkNhc3RpbmdUb1N0cmluZyI7YjowO31zOjUyOiIAU3VyZnNpZGVtZWRpYVxTaG9wcGluZ2NhcnRcQ2FydEl0ZW0AYXNzb2NpYXRlZE1vZGVsIjtzOjE4OiJBcHBcTW9kZWxzXFByb2R1Y3QiO3M6NDQ6IgBTdXJmc2lkZW1lZGlhXFNob3BwaW5nY2FydFxDYXJ0SXRlbQB0YXhSYXRlIjtpOjIxO3M6NDQ6IgBTdXJmc2lkZW1lZGlhXFNob3BwaW5nY2FydFxDYXJ0SXRlbQBpc1NhdmVkIjtiOjA7fXM6MzI6IjU2NGRkMGFiMzRiNjM4NzhjYTIyMzdjNDdhNjIwY2YyIjtPOjM1OiJTdXJmc2lkZW1lZGlhXFNob3BwaW5nY2FydFxDYXJ0SXRlbSI6OTp7czo1OiJyb3dJZCI7czozMjoiNTY0ZGQwYWIzNGI2Mzg3OGNhMjIzN2M0N2E2MjBjZjIiO3M6MjoiaWQiO2k6MjI7czozOiJxdHkiO2k6MTtzOjQ6Im5hbWUiO3M6Mzk6IktvdGFrIENvdmVyIFRpc3N1ZSBBbnlhbWFuIEVjZW5nIEdvbmRvayI7czo1OiJwcmljZSI7ZDozMDAwMDtzOjc6Im9wdGlvbnMiO086NDI6IlN1cmZzaWRlbWVkaWFcU2hvcHBpbmdjYXJ0XENhcnRJdGVtT3B0aW9ucyI6Mjp7czo4OiIAKgBpdGVtcyI7YTowOnt9czoyODoiACoAZXNjYXBlV2hlbkNhc3RpbmdUb1N0cmluZyI7YjowO31zOjUyOiIAU3VyZnNpZGVtZWRpYVxTaG9wcGluZ2NhcnRcQ2FydEl0ZW0AYXNzb2NpYXRlZE1vZGVsIjtzOjE4OiJBcHBcTW9kZWxzXFByb2R1Y3QiO3M6NDQ6IgBTdXJmc2lkZW1lZGlhXFNob3BwaW5nY2FydFxDYXJ0SXRlbQB0YXhSYXRlIjtpOjIxO3M6NDQ6IgBTdXJmc2lkZW1lZGlhXFNob3BwaW5nY2FydFxDYXJ0SXRlbQBpc1NhdmVkIjtiOjA7fX1zOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7fX19', 1747108932),
('RjztdFLap9lMwfhiEJsxJE9BnHx7nesTSavOksYJ', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiejVraWV3TUdjcFhVN3lqcElQZ01Ta3g1NU0xa0JQQ09ydzhCb0ZWVCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wZW5qYWR3YWxhbi1wZW5qZW1wdXRhbi9hZGQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1747101301),
('RlQVKPEfVAKmuuawhWusRwWTV7oBWTRTVx8bMDHH', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMHllV2RvYjNzc1hUNTVlV3dzTldiSXhIRXFnRXJvUnZMZnJZT3NkbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747104513),
('rps7Dlp9oqwO7l3J4P0x0aYbrCtluvLbcJKato0p', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMDJ6cFJ4UGZFbU9tdUFac1dhUW80NEFHQVlVZG44ZGZ5OTVrdWlHTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747104780),
('Rw6gmTUsKoD81pQh0NH0oUhkpM88oHuMfQQyKfbR', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTnY1UHdPTW9ETkhqUXI1T1ZyYWx1QnF0SjNheWVaaDg2d1VjQ0VCaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747102136),
('Sa20NMqyf62uGouN7g8oehTC3f75nW29tV3cQjx0', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQU5BS2FmRE8zUGgxeEFiSnJTdU1WZmduTTBYNkdHZFhUVUdtYTFOciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747105537),
('slCNW3Wz6ZJo7myNDAAbGeeHaRCtgtYu4SqpokS5', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRFdzMHFheUV4NTFkOHBVQTYwbnpJSWF4eHpVMTNwNjI0M0hwRDk1ZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747106544),
('St8NHymbSHk7QwydYKHNxO38wQsfkoOP2sL21xQB', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia1NIUElhck1HUDd1RTJQVzY4SUI5Qk9xZDZhNzkzRXNaRDFsdVZWciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747102412),
('tl1hhP3ht6MfI4tRTCi2MpRNhCKIg1ylVfSeLShv', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRG5lR2FzTDdsdUM5OWtQYkRaNnBwRHJzRWQ5cjhZMW5teTFWeklNaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747102887),
('UcLTuO0zWH8aVzEj0TxwpOpYXd0bSRnfNta9Aa48', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibkhYT0N2R3VMZGFCRGRDYW9CTldZbFpUenJIR2Znc1lQVVdITm1MdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zaG9wL2tvdGFrLWNvdmVyLXRpc3N1ZS1hbnlhbWFuLWVjZW5nLWdvbmRvayI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747105740),
('v7dPA6KCE6Iz5oKmyxl7KuvdCAmbkZjCI3PTBaUw', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic0NGYTFKeFZzOThRaUp6QjBTMUpkRFZFSnhqd1N2VEdrR0hiMGRsOCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747106073),
('VgqbrLQayqzKy2A5YtWGHLTOzCYIDZjLxYIviKT7', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT1JWbzhnT3BEc1U1alhTbjRVc1ZXTDYwVWg1c2lWMVJJUHd5R1JRbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747106625),
('VV4G2uOsXFlEeCSzuiLkEAfPrihcHzcvoK5j3fSd', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidGpFdXpWQTYxYmZXQVFMb3VMb2ZkRFhscEpXNUxoNnBjdHhRZ0pUVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747107566),
('WAoMKV1HShoIAfm9XKNIfSuibKsVdWzO51buI2hn', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicTV6ZW5DNmdNRUpVVThMcUp0eWRMaEZoc256blI2Q1l3Z0hSeDdUUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747105249),
('wlROwiV0XVTnduk1mfAwlwgGM63RI2pfTdETs8AZ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidkhVTTU0aFlGaHJSMmJwNWJzQ1N4UnFvaldqc21NM3d6dTFaSTlhYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747102265),
('WqmSvqL8c7gyShaPdfqbKeM0vPHWsqQtE9SZ0i6C', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTklNZEZrcHJvTnZWZTJ4Vk0yUGJUdGpPeHlSbDZweUFneVdGdXhyeCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747106044),
('XArsTk7oZND6JvP8CFQr3QEarye7HZoeh70OG9nq', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicFRUcVFMSjQ4MWZmYUpRMm83d2ZUTVVZVldTRllPMXVwTXpldGhHaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747103593),
('xggTQw2hVs4t0EnwtyjKYHu3qsZL735QWIO9WReX', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZXgzd29ycHVmMTZwSGpkeVlldzlpdGtVaWw4akhTRWNkSXNOeDh1bCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747104653),
('XJ9dmUaurNNzO2XGEgg4Ya7CKVMKY3bHIfy3Zy8s', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUTlyMUZsaWlIbzdnVEUzUlAwSndBUVhDVElEak9Qc3kzYXZNcU56OCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747107501),
('xoUeHHfTPQqn0lmaDpp4Yt7yE3MesNZRBzTsglI3', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUmNQeTdaZXRxbWVoOGNlRFV6N1BXUkpNZ3V0ZU5xRmg4Ukg1QXlkcSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747102531),
('yzEtN1DW30QYhKelHgAIy3BK3beDecI9mUetoDaW', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWExJVkpWTXIwSk1taUFhM1ZhenJNTHBrdUNoVkxmVTNnZ0ttTXRtMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747108781);

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
(5, 'Topi', 'Bank Koperasi', 'ECENG GONDOK', '/shop', '1745404301.png', 1, '2025-04-22 20:31:41', '2025-04-22 20:31:41'),
(6, 'Cover Kotak Tissue', 'Bank Koperasi', 'ECENG GONDOK', 'http://127.0.0.1:8000/shop?name=1&size=12&order=-1&brands=&categories=18&min=1&max=10000000', '1745859368.png', 1, '2025-04-28 09:53:16', '2025-04-28 09:56:40'),
(7, 'Bantal', 'Bank Koperasi', 'ECENG GONDOK', 'http://127.0.0.1:8000/shop?name=1&size=12&order=-1&brands=&categories=17&min=1&max=10000000', '1745859562.png', 1, '2025-04-28 09:59:23', '2025-04-28 09:59:23'),
(8, 'Vas Guci', 'Bank Koperasi', 'ECENG GONDOK', 'a', '1745859628.png', 1, '2025-04-28 10:00:29', '2025-04-28 10:00:29');

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
(1, '2025-05-13', 10, 'Request Pemasok', 1, 'Otomatis dari permintaan disetujui', '2025-05-13 01:54:23', '2025-05-13 01:54:23');

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
(1, 'Jadi Pemasok Eceng Gondok dan Dapatkan Keuntungan!', 'Jadi Pemasok Eceng Gondok dan Dapatkan WOW!Jadi Pemasok Eceng Gondok dan Dapatkan WOW!\r\n\r\n\r\nJadi Pemasok Eceng Gondok dan Dapatkan WOW!Jadi Pemasok Eceng Gondok dan Dapatkan WOW!\r\n\r\nJadi Pemasok Eceng Gondok dan Dapatkan WOW!Jadi Pemasok Eceng Gondok dan Dapatkan WOW!\r\n\r\nJadi Pemasok Eceng Gondok dan Dapatkan WOW!Jadi Pemasok Eceng Gondok dan Dapatkan WOW!', 'uploads/supplier_info/1746500646_Y80Gte.jpg', NULL, NULL, NULL, NULL, NULL, 2, 1, '2025-05-05 20:04:06', '2025-05-05 20:31:35');

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
(1, 2, 'Efran Lumbantoruan', 'efranlumbantoruan83@gmail.com', '082264528495', '082264528495', NULL, 10, 'uang_tunai', 'uploads/bukti_pemasok/1747101209_pPkIGw.png', 'wqe', 'disetujui', NULL, 'oke', '2025-05-13 01:53:29', '2025-05-13 01:54:23', 'Pangururan', 'Pardomuan Nauli', 'balige');

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
  `invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mode` enum('midtrans','manual_atm') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','declined','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `snap_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `order_id`, `invoice`, `mode`, `status`, `snap_token`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'ORDER-1-81abea07-3394-4e75-b02e-b91ea6757782', '', 'approved', '4fae7ccd-4c89-4e11-ae7b-e429db1ee3f1', '2025-05-12 17:20:16', '2025-05-12 17:30:42');

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
(1, 'Sion', 'spardosi12@gmail.com', '82278900178', NULL, NULL, '$2y$12$YcK4oO3FzOE5Bl1ywX9SrOwF5BZE8vEEd4Dv8mOafjZY3YG9L.hgm', NULL, NULL, 'ADM', NULL, NULL, '2025-05-12 17:14:49', '2025-05-12 17:14:49', NULL, NULL, NULL),
(2, 'Efran Lumbantoruan', 'efranlumbantoruan83@gmail.com', '82264528495', NULL, NULL, '$2y$12$JlISYyyZPaty7HxzgGMvPOPmd4YOL65u0QmP4TeRdssfdR240OBh2', NULL, NULL, 'ADM', NULL, NULL, '2025-05-13 01:49:41', '2025-05-13 01:49:41', NULL, NULL, NULL),
(3, 'Listra Imelda Sidabutar', 'lalistramanoban27@gmail.com', '82164080661', NULL, NULL, '$2y$12$HFubD87zLLCPRS5gxgB1IeGiB.FMWXLH0AjE1rfJFELTPT0qlbMwi', NULL, NULL, 'USR', NULL, NULL, '2025-05-13 03:57:14', '2025-05-13 03:57:14', NULL, NULL, NULL);

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
(2, 1, 19, 'Tas Enceng Gondok Anyaman Samosir', 1, '49000.00', '2025-05-13 02:32:24', '2025-05-13 02:32:24'),
(6, 1, 22, 'Kotak Cover Tissue Anyaman Eceng Gondok', 1, '30000.00', '2025-05-13 03:13:37', '2025-05-13 03:13:37');

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
-- Indeks untuk tabel `related_videos`
--
ALTER TABLE `related_videos`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `transactions_order_id_foreign` (`order_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `email_verifications`
--
ALTER TABLE `email_verifications`
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
-- AUTO_INCREMENT untuk tabel `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `job_lists`
--
ALTER TABLE `job_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `month_names`
--
ALTER TABLE `month_names`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `penjadwalan_penjemputans`
--
ALTER TABLE `penjadwalan_penjemputans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `related_videos`
--
ALTER TABLE `related_videos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `slides`
--
ALTER TABLE `slides`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user_cart_items`
--
ALTER TABLE `user_cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `wishlist_items`
--
ALTER TABLE `wishlist_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- Ketidakleluasaan untuk tabel `thread_messages`
--
ALTER TABLE `thread_messages`
  ADD CONSTRAINT `thread_messages_thread_id_foreign` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
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
