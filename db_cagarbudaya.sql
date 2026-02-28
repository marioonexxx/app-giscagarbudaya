-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 07, 2026 at 02:54 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_cagarbudaya`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cagar_budaya`
--

CREATE TABLE `cagar_budaya` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `kategori_id` bigint UNSIGNED NOT NULL,
  `kode_wilayah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_regnas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `alamat_lengkap` text COLLATE utf8mb4_unicode_ci,
  `file_surat_pengantar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_rekomendasi_tacb` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_verifikasi` enum('Pendaftaran','Diverifikasi','Revisi','Ditetapkan','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pendaftaran',
  `peringkat` enum('Nasional','Provinsi','Kabupaten/Kota') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_sk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_sk_penetapan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_penetapan` year DEFAULT NULL,
  `tipe_geometri` enum('Titik','Poligon') COLLATE utf8mb4_unicode_ci NOT NULL,
  `koordinat` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cagar_budaya`
--

INSERT INTO `cagar_budaya` (`id`, `user_id`, `kategori_id`, `kode_wilayah`, `nama`, `kode_regnas`, `deskripsi`, `alamat_lengkap`, `file_surat_pengantar`, `file_rekomendasi_tacb`, `status_verifikasi`, `peringkat`, `nomor_sk`, `file_sk_penetapan`, `tahun_penetapan`, `tipe_geometri`, `koordinat`, `created_at`, `updated_at`) VALUES
(1, 3, 5, '81.01', 'Gunung Binaya', NULL, 'Gunung Binaya', 'Pulau Seram', 'dokumen_usulan/qr8s1A8LB2bpHYLPa0HOUhExgRreXRtMeentDFrb.pdf', 'dokumen_usulan/UBnug5wdxXYoN3jfJiPcBWC5h0F53MUADNlhoaeJ.pdf', 'Diverifikasi', NULL, NULL, NULL, NULL, 'Titik', '{\"lat\": -3.172896591765207, \"lng\": 129.45484134206237}', '2026-02-07 05:18:54', '2026-02-07 05:31:44'),
(2, 3, 5, '81.01', 'Taman Nasional Manusela Ajukan Ulang', NULL, 'Taman Nasional Manusela Ajukan Ulang', 'Taman Nasional Manusela Ajukan Ulang', 'dokumen_usulan/NsuMaZf3FEDCCiTznkx0ARgSXFKXhYou3EbKKfLT.pdf', 'dokumen_usulan/caBFEQMauOQSxtdyaodDewW0rz7orYRbmACAH55u.pdf', 'Pendaftaran', NULL, NULL, NULL, NULL, 'Poligon', '[{\"lat\": -3.0715524724836794, \"lng\": 129.61268495515114}, {\"lat\": -3.0818373089630495, \"lng\": 129.61178351695804}, {\"lat\": -3.0824801079461395, \"lng\": 129.63152930594944}, {\"lat\": -3.072066716663243, \"lng\": 129.63028446273043}]', '2026-02-07 06:09:08', '2026-02-07 06:25:36');

-- --------------------------------------------------------

--
-- Table structure for table `evaluasi_cagar_budaya`
--

CREATE TABLE `evaluasi_cagar_budaya` (
  `id` bigint UNSIGNED NOT NULL,
  `cagar_budaya_id` bigint UNSIGNED NOT NULL,
  `evaluator_id` bigint UNSIGNED NOT NULL,
  `tanggal_evaluasi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `catatan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kesimpulan` enum('Layak','Tidak Layak','Perlu Revisi') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `evaluasi_cagar_budaya`
--

INSERT INTO `evaluasi_cagar_budaya` (`id`, `cagar_budaya_id`, `evaluator_id`, `tanggal_evaluasi`, `catatan`, `kesimpulan`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2026-02-07 05:31:44', 'Data sudah lengkap', 'Layak', '2026-02-07 05:31:44', '2026-02-07 05:31:44'),
(2, 2, 2, '2026-02-07 06:09:32', 'Kurang Lengkap Foto gak Jelas', 'Perlu Revisi', '2026-02-07 06:09:32', '2026-02-07 06:09:32'),
(3, 2, 2, '2026-02-07 06:25:20', 'Masih tidak lengkap, dokumen Tim Ahli Cagar Budaya Tidak Lengkap', 'Perlu Revisi', '2026-02-07 06:25:20', '2026-02-07 06:25:20');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `foto_cagar_budaya`
--

CREATE TABLE `foto_cagar_budaya` (
  `id` bigint UNSIGNED NOT NULL,
  `cagar_budaya_id` bigint UNSIGNED NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `foto_cagar_budaya`
--

INSERT INTO `foto_cagar_budaya` (`id`, `cagar_budaya_id`, `path`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, 'cagar-budaya/foto/P7uXCOJrohQnEvNU8EZNpUGtU7V476eCkQMAhwlj.jpg', 'mcm1.jpeg', '2026-02-07 05:18:54', '2026-02-07 05:18:54'),
(2, 1, 'cagar-budaya/foto/tQGrUHoHcZ6vLrvhx8Ec5R50NiwRxJBHThECMrqC.jpg', 'tampak depan patung christina martha tiahahu.jpeg', '2026-02-07 05:18:54', '2026-02-07 05:18:54'),
(3, 1, 'cagar-budaya/foto/g7EYkeFucHuBKCTL9tJG4vkV5AZyBm8U0duzOgK6.jpg', 'tampak samping kanan patung.jpeg', '2026-02-07 05:18:54', '2026-02-07 05:18:54'),
(4, 1, 'cagar-budaya/foto/MV0tsf614DzmtJi53t7Tb4FTx1tborotcdNY3M9X.jpg', 'tampak samping patung.png', '2026-02-07 05:18:54', '2026-02-07 05:18:54'),
(7, 2, 'cagar-budaya/foto/ZLenDrdeFCEKWX3EwTWwXtAj8TI1QSJAiIK64uhu.jpg', 'mcm1.jpeg', '2026-02-07 06:25:36', '2026-02-07 06:25:36'),
(8, 2, 'cagar-budaya/foto/6NFsTJN8l74RIyecbHM0OQMKLJf5zhSwD2UUiOun.jpg', 'tampak depan patung christina martha tiahahu.jpeg', '2026-02-07 06:25:36', '2026-02-07 06:25:36'),
(9, 2, 'cagar-budaya/foto/xzjm96jpB4fqb9oZR9NfaBp75Xmm7EwQ5z59ojep.jpg', 'tampak samping kanan patung.jpeg', '2026-02-07 06:25:36', '2026-02-07 06:25:36'),
(10, 2, 'cagar-budaya/foto/QdfYkTx7C8Wfw8qTJcmcmZGq2Ee1jwzWeAACFJxp.jpg', 'tampak samping patung.png', '2026-02-07 06:25:36', '2026-02-07 06:25:36');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_budaya`
--

CREATE TABLE `kategori_budaya` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_budaya`
--

INSERT INTO `kategori_budaya` (`id`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Benda', '2026-02-07 05:17:47', '2026-02-07 05:17:47'),
(2, 'Bangunan', '2026-02-07 05:17:47', '2026-02-07 05:17:47'),
(3, 'Struktur', '2026-02-07 05:17:47', '2026-02-07 05:17:47'),
(4, 'Situs', '2026-02-07 05:17:47', '2026-02-07 05:17:47'),
(5, 'Kawasan', '2026-02-07 05:17:47', '2026-02-07 05:17:47');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2026_02_05_152958_create_wilayah_table', 1),
(4, '2026_02_05_152959_create_users_table', 1),
(5, '2026_02_05_153021_create_kategori_budaya_table', 1),
(6, '2026_02_05_153124_create_cagar_budaya_table', 1),
(7, '2026_02_05_153159_create_evaluasi_cagar_budaya_table', 1),
(8, '2026_02_05_182324_create_foto_cagar_budaya_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('bVIEclzvwFK9GCqQmID0FcZdGsaNmoioo95mpnsx', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVldJRGFURjdiUlgzMWRUVERYdGNrYTJiOW1WbFV1RnpTeGE0TGpEVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1770475692),
('CE7DRyc8MszpuBCpyifxukM2U5MCCrw8e4mbJQjU', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoia0poWk91WGZNV2dodUZCREY5MTBmMDVFQmhFa1JRY3ZyUnBGWWtoayI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZXZhbHVhdG9yL3ZlcmlmaWthc2kvMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1770470752);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `peran` enum('admin_kabupaten','evaluator','super_admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin_kabupaten',
  `kode_wilayah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `peran`, `kode_wilayah`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin Prov', 'admin@mail.com', NULL, '$2y$12$gnnSmJIXJnZherqQmRlXwuM5oyITe0L6w7uf0MpCPfitjSlU6SkiO', 'super_admin', '81', NULL, '2026-02-07 05:17:48', '2026-02-07 05:17:48'),
(2, 'Evaluator TACB', 'evaluator@mail.com', NULL, '$2y$12$1nJGvKE5F18LodscKHKHy.QAHxqruCuhPydnGQ9klcYPQXvICBjHy', 'evaluator', '81', NULL, '2026-02-07 05:17:48', '2026-02-07 05:17:48'),
(3, 'Admin Kab. Maluku Tengah', 'kabmalukutengah@mail.com', NULL, '$2y$12$7w4I5kpD/XI.YIxQtQgsO..1udZRAAwGcYWuVMRe9XJpS33Sgq7Ee', 'admin_kabupaten', '81.01', NULL, '2026-02-07 05:17:48', '2026-02-07 05:17:48'),
(4, 'Admin Kab. Maluku Tenggara', 'kabmalukutenggara@mail.com', NULL, '$2y$12$rbOBGmM4XG1Uvtbu8RBfR.F91wi4CE0yqffwrmWDhSQUTmpRaUhgK', 'admin_kabupaten', '81.02', NULL, '2026-02-07 05:17:48', '2026-02-07 05:17:48'),
(5, 'Admin Kab. Kepulauan Tanimbar', 'kabkepulauantanimbar@mail.com', NULL, '$2y$12$19FD7QOipYuLPL3OUonaoOB/jBbFWmHDiRtdafYJfzLd.hSHIt8bG', 'admin_kabupaten', '81.03', NULL, '2026-02-07 05:17:48', '2026-02-07 05:17:48'),
(6, 'Admin Kab. Buru', 'kabburu@mail.com', NULL, '$2y$12$kIbtDHuq6bJRm4WHyEOXvuEW6HKlpcRIQvgN.LHjF/ykz9/2uaBKi', 'admin_kabupaten', '81.04', NULL, '2026-02-07 05:17:49', '2026-02-07 05:17:49'),
(7, 'Admin Kab. Kepulauan Aru', 'kabkepulauanaru@mail.com', NULL, '$2y$12$0kNb0KJfE1p43YhlXyrAyuNT.5Of2mXzL0kTtZ8vIwO8/1UsQ2JQ6', 'admin_kabupaten', '81.05', NULL, '2026-02-07 05:17:49', '2026-02-07 05:17:49'),
(8, 'Admin Kab. Seram Bagian Barat', 'kabserambagianbarat@mail.com', NULL, '$2y$12$oOvPr1Bg6oANbw3GX4GCoumaxSTfYHjN9FHa2/rfsUyB4GXdMiSxG', 'admin_kabupaten', '81.06', NULL, '2026-02-07 05:17:49', '2026-02-07 05:17:49'),
(9, 'Admin Kab. Seram Bagian Timur', 'kabserambagiantimur@mail.com', NULL, '$2y$12$SMK.62dK/u0XrauPjx4aRu2Ha.Rhzkh4xJY7./AmvGyZuABgTnOs2', 'admin_kabupaten', '81.07', NULL, '2026-02-07 05:17:49', '2026-02-07 05:17:49'),
(10, 'Admin Kab. Maluku Barat Daya', 'kabmalukubaratdaya@mail.com', NULL, '$2y$12$iGOiu7EaXQ3mCvsfNWd1PeDpFKaeDFQodetHUJkcUU9gaUf8DFCdW', 'admin_kabupaten', '81.08', NULL, '2026-02-07 05:17:50', '2026-02-07 05:17:50'),
(11, 'Admin Kab. Buru Selatan', 'kabburuselatan@mail.com', NULL, '$2y$12$cNQwMuAe4HnDwFDK49iEh.pKaEb6Ys6LgGanLEHxWk2jZsVo.PFdC', 'admin_kabupaten', '81.09', NULL, '2026-02-07 05:17:50', '2026-02-07 05:17:50'),
(12, 'Admin Kota Ambon', 'kotaambon@mail.com', NULL, '$2y$12$Q6PQOui0GAxZlhRVubrTouf.wb8qPgK059qsyIsKEaqwb1hwAqpzy', 'admin_kabupaten', '81.71', NULL, '2026-02-07 05:17:50', '2026-02-07 05:17:50'),
(13, 'Admin Kota Tual', 'kotatual@mail.com', NULL, '$2y$12$7sCvvVR0kTj.wmB3ZHNP9.AxPY09L5EzxOBwu3qTemg/5axtNPDIa', 'admin_kabupaten', '81.72', NULL, '2026-02-07 05:17:50', '2026-02-07 05:17:50');

-- --------------------------------------------------------

--
-- Table structure for table `wilayah`
--

CREATE TABLE `wilayah` (
  `kode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tingkat` enum('Provinsi','Kabupaten','Kota') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wilayah`
--

INSERT INTO `wilayah` (`kode`, `nama`, `tingkat`) VALUES
('81', 'Provinsi Maluku', 'Provinsi'),
('81.01', 'Kab. Maluku Tengah', 'Kabupaten'),
('81.02', 'Kab. Maluku Tenggara', 'Kabupaten'),
('81.03', 'Kab. Kepulauan Tanimbar', 'Kabupaten'),
('81.04', 'Kab. Buru', 'Kabupaten'),
('81.05', 'Kab. Kepulauan Aru', 'Kabupaten'),
('81.06', 'Kab. Seram Bagian Barat', 'Kabupaten'),
('81.07', 'Kab. Seram Bagian Timur', 'Kabupaten'),
('81.08', 'Kab. Maluku Barat Daya', 'Kabupaten'),
('81.09', 'Kab. Buru Selatan', 'Kabupaten'),
('81.71', 'Kota Ambon', 'Kota'),
('81.72', 'Kota Tual', 'Kota');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cagar_budaya`
--
ALTER TABLE `cagar_budaya`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cagar_budaya_kode_regnas_unique` (`kode_regnas`),
  ADD KEY `cagar_budaya_user_id_foreign` (`user_id`),
  ADD KEY `cagar_budaya_kategori_id_foreign` (`kategori_id`),
  ADD KEY `cagar_budaya_kode_wilayah_foreign` (`kode_wilayah`);

--
-- Indexes for table `evaluasi_cagar_budaya`
--
ALTER TABLE `evaluasi_cagar_budaya`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evaluasi_cagar_budaya_cagar_budaya_id_foreign` (`cagar_budaya_id`),
  ADD KEY `evaluasi_cagar_budaya_evaluator_id_foreign` (`evaluator_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `foto_cagar_budaya`
--
ALTER TABLE `foto_cagar_budaya`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foto_cagar_budaya_cagar_budaya_id_foreign` (`cagar_budaya_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_budaya`
--
ALTER TABLE `kategori_budaya`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_kode_wilayah_foreign` (`kode_wilayah`);

--
-- Indexes for table `wilayah`
--
ALTER TABLE `wilayah`
  ADD PRIMARY KEY (`kode`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cagar_budaya`
--
ALTER TABLE `cagar_budaya`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `evaluasi_cagar_budaya`
--
ALTER TABLE `evaluasi_cagar_budaya`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `foto_cagar_budaya`
--
ALTER TABLE `foto_cagar_budaya`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori_budaya`
--
ALTER TABLE `kategori_budaya`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cagar_budaya`
--
ALTER TABLE `cagar_budaya`
  ADD CONSTRAINT `cagar_budaya_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_budaya` (`id`),
  ADD CONSTRAINT `cagar_budaya_kode_wilayah_foreign` FOREIGN KEY (`kode_wilayah`) REFERENCES `wilayah` (`kode`),
  ADD CONSTRAINT `cagar_budaya_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `evaluasi_cagar_budaya`
--
ALTER TABLE `evaluasi_cagar_budaya`
  ADD CONSTRAINT `evaluasi_cagar_budaya_cagar_budaya_id_foreign` FOREIGN KEY (`cagar_budaya_id`) REFERENCES `cagar_budaya` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `evaluasi_cagar_budaya_evaluator_id_foreign` FOREIGN KEY (`evaluator_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `foto_cagar_budaya`
--
ALTER TABLE `foto_cagar_budaya`
  ADD CONSTRAINT `foto_cagar_budaya_cagar_budaya_id_foreign` FOREIGN KEY (`cagar_budaya_id`) REFERENCES `cagar_budaya` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_kode_wilayah_foreign` FOREIGN KEY (`kode_wilayah`) REFERENCES `wilayah` (`kode`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
