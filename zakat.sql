-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 07, 2026 at 07:48 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zakat`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','kasir','pengurus') COLLATE utf8mb4_unicode_ci DEFAULT 'pengurus',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Utama', 'admin@asy-syaakiriin.com', '$2y$12$3VR8U6Qj7rPgLdJg8qRblOxbL3aWxDBYuZ/aSwKaxohr8LKVKVYGC', 'admin', 1, NULL, '2026-02-24 04:05:31', '2026-02-24 04:05:31'),
(4, 'Pengurus 2', 'pengurus2@azis.com', '$2y$12$4x2sBK8TNNEe0Ja5wTuRTOdnJcFjutfuZqSZnLOAxc4lvpviwXuOe', 'pengurus', 1, NULL, '2026-02-24 06:05:19', '2026-02-24 06:05:19'),
(5, 'Petugas 3', 'petugas@azis.com', '$2y$12$keZYjUL7G8/oPuZPeF71h.1MJ8r3Hc/kguX6p.BBCp8p5hXvEfBh6', 'kasir', 1, NULL, '2026-02-24 08:34:04', '2026-02-24 08:34:04');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_17_000001_create_zakat_penerimaans_table', 1),
(5, '2026_02_18_204625_create_admins_table', 1),
(6, '2026_02_23_000002_add_created_by_to_zakat_penerimaans_table', 1),
(7, '2026_02_23_000003_add_bukti_to_zakat_penerimaans_table', 1),
(8, '2026_02_23_000004_add_kasir_role', 1),
(9, '2026_02_23_000004_add_role_to_users_table', 1),
(10, '2026_02_27_000001_add_bank_to_zakat_penerimaans_table', 2),
(11, '2026_02_27_204700_add_daily_sequence_to_zakat_penerimaans_table', 3);

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
('zyzwafS8YSdpbmYRCfj0ehuXtOKSF8AEeIfvJJCp', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN3JBT28zQUxIMnZoTndLVTRXQmZVTXhWMHFUUzM1WGdTOW1wOHJUZCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi90cmFuc2Frc2kvNzAiO3M6NToicm91dGUiO3M6MjA6ImFkbWluLnRyYW5zYWtzaS5zaG93Ijt9czo1MjoibG9naW5fYWRtaW5fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1772638870);

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
  `role` enum('admin','kasir','pengurus') COLLATE utf8mb4_unicode_ci DEFAULT 'pengurus',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Petugas 1', 'kasir@zis.com', '2026-02-24 04:15:51', '$2y$12$LVURLLdWUsHj/aJRlbzOF.kxEMJlsccOw1OmLzgBvN1TlqbSV6U.6', 'kasir', 1, NULL, '2026-02-24 04:15:51', '2026-02-24 05:22:48'),
(3, 'Pengurus 1', 'pengurus@azis.com', NULL, '$2y$12$ahSrTQC.7r.Lcu5/xDZ5mOkJuMHTMQg/ojGHIyozYUzLcBfZ8Xb7a', 'pengurus', 1, NULL, '2026-02-24 05:14:24', '2026-02-24 06:02:40'),
(4, 'Petugas 2', 'kasir@gmail.com', NULL, '$2y$12$YrvNCYSNOTydI03czOb9SulZdb8cwXAT4a8blhA2HSYutgZbtZpCa', 'kasir', 1, NULL, '2026-02-24 07:32:32', '2026-02-24 07:32:32');

-- --------------------------------------------------------

--
-- Table structure for table `zakat_penerimaans`
--

CREATE TABLE `zakat_penerimaans` (
  `id` bigint UNSIGNED NOT NULL,
  `nomor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `telpon` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profesi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_jiwa` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `atas_nama` json DEFAULT NULL,
  `items` json DEFAULT NULL,
  `total_uang` bigint UNSIGNED NOT NULL DEFAULT '0',
  `total_beras` decimal(8,1) NOT NULL DEFAULT '0.0',
  `terbilang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_amil` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `daily_sequence` int UNSIGNED DEFAULT NULL,
  `tanggal` date NOT NULL,
  `status` enum('Belum Lunas','Lunas','Batal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum Lunas',
  `bukti` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `zakat_penerimaans`
--

INSERT INTO `zakat_penerimaans` (`id`, `nomor`, `nama`, `alamat`, `telpon`, `profesi`, `jumlah_jiwa`, `atas_nama`, `items`, `total_uang`, `total_beras`, `terbilang`, `nama_amil`, `daily_sequence`, `tanggal`, `status`, `bukti`, `bank`, `tahun`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'ASY/26/UPZ/0001', 'Kemal Iksan', 'JL JALAN', '1', 'profesi', 1, '[]', '[{\"uang\": 30000, \"beras\": 2, \"jenis\": \"Zakat Fitrah\"}]', 30000, 2.0, 'Tiga Puluh Ribu Rupiah', 'Pengurus Ahmad', NULL, '2026-02-24', 'Lunas', 'bukti/I538GIP7DKPUiF1wKuZqbfZomSO17DjHYshiTfAa.jpg', NULL, '26', 3, '2026-02-24 05:56:31', '2026-02-24 05:58:10'),
(2, 'ASY/26/UPZ/0002', 'test pengurus', 'alamat', '123', 'profes', 2, '[\"jiwa 2\"]', '[{\"uang\": 20000, \"beras\": 2, \"jenis\": \"Zakat Fitrah\"}, {\"uang\": 10000, \"beras\": 2, \"jenis\": \"Zakat Maal\"}]', 30000, 4.0, 'Tiga Puluh Ribu Rupiah', 'Pengurus Ahmad', NULL, '2026-02-24', 'Belum Lunas', 'bukti/E25rpiV7WbQyIg62jA8ztboZzSF2J59Sob3NIVBu.jpg', NULL, '26', 3, '2026-02-24 07:28:50', '2026-02-24 07:28:50'),
(3, 'ASY/26/UPZ/0003', 'test', 'alamt', '123', 'asd', 1, '[]', '[{\"uang\": 30000, \"beras\": 2, \"jenis\": \"Zakat Fitrah\"}]', 30000, 2.0, 'Tiga Puluh Ribu Rupiah', '', NULL, '2026-02-24', 'Belum Lunas', 'bukti/Am653ESc4zFSUO5M6T9qcw9U1m2LVRHHyrFzJHHI.png', NULL, '26', NULL, '2026-02-24 07:29:37', '2026-02-24 07:59:03'),
(4, 'ASY/26/UPZ/0004', 'Kemal Iksan', 'JL JALAN', '123', '123', 1, '[]', '[{\"uang\": 30000, \"beras\": 2, \"jenis\": \"Zakat Fitrah\"}, {\"uang\": 30000, \"beras\": 2, \"jenis\": \"Zakat Maal\"}, {\"uang\": 30000, \"beras\": 2, \"jenis\": \"Infaq - Shodaqoh\"}]', 90000, 6.0, 'Sembilan Puluh Ribu Rupiah', 'Kasir Ahmad', NULL, '2026-02-24', 'Belum Lunas', 'bukti/wt5Zm12fRqwGWgXUGVcLg3CLQm5EwH3jqWX8T9JY.jpg', NULL, '26', 2, '2026-02-24 08:08:47', '2026-02-24 08:08:47'),
(5, 'ASY/26/UPZ/0005', 'Kemal Iksan', 'JL JALAN', '123', '123', 1, '[]', '[{\"uang\": 30000, \"beras\": 1, \"jenis\": \"Zakat Fitrah\"}]', 30000, 1.0, 'Tiga Puluh Ribu Rupiah', '', NULL, '2026-02-24', 'Belum Lunas', 'bukti/QRj9JaHhwFC9P6yn1FcnpYlKpelLw2QjuJoGP69C.jpg', NULL, '26', NULL, '2026-02-24 08:36:41', '2026-02-24 08:36:41'),
(6, 'ASY/26/UPZ/0006', '123', '123', '123', '12', 1, '[]', '[{\"uang\": 30000, \"beras\": 1, \"jenis\": \"Zakat Fitrah\"}]', 30000, 1.0, 'Tiga Puluh Ribu Rupiah', 'petugas', NULL, '2026-02-24', 'Belum Lunas', 'bukti/XDnoH21Wl9XRP4pkxPIlrp1lbO3Awd0UcY5p8ET5.jpg', NULL, '26', NULL, '2026-02-24 08:43:25', '2026-02-24 08:43:25'),
(7, 'ASY/26/UPZ/0007', 'Kemal Iksan', '213', '123', '123', 1, '[]', '[{\"uang\": 30000, \"beras\": 2, \"jenis\": \"Zakat Fitrah\"}]', 30000, 2.0, 'Tiga Puluh Ribu Rupiah', 'petugas', NULL, '2026-02-24', 'Lunas', 'bukti/snmtwtLXFdJcP8Oy4YSWiwqeHfAd8bVzjRuXPvZE.jpg', NULL, '26', NULL, '2026-02-24 09:04:58', '2026-02-24 09:04:58'),
(8, 'ASY/26/UPZ/0008', '123', '123', '123', '123', 1, '[]', '[{\"uang\": 30000, \"beras\": 2, \"jenis\": \"Zakat Fitrah\"}]', 30000, 2.0, 'Tiga Puluh Ribu Rupiah', 'Kasir Ahmad', NULL, '2026-02-24', 'Lunas', 'bukti/prgzk2QyaKUl36SE9iCtxeFroUbpJyVW6xM5d5mn.jpg', NULL, '26', 2, '2026-02-24 09:06:48', '2026-02-24 09:06:48'),
(9, 'ASY/26/UPZ/0009', 'Kemal Iksan', '123', '123', 'asd', 1, '[]', '[{\"uang\": 30000, \"beras\": 2, \"jenis\": \"Zakat Fitrah\"}]', 30000, 2.0, 'Tiga Puluh Ribu Rupiah', 'Admin UPZ', NULL, '2026-02-24', 'Belum Lunas', 'bukti/67aCI6u5ukxz9mMq3MnjqnJEPIYE1eG6sw2ZTORf.jpg', NULL, '26', NULL, '2026-02-24 09:11:43', '2026-02-24 09:11:43'),
(10, 'ASY/26/UPZ/0010', '123', '123', '123', '123', 1, '[]', '[{\"uang\": 30000, \"beras\": 2, \"jenis\": \"Zakat Fitrah\"}]', 30000, 2.0, 'Tiga Puluh Ribu Rupiah', '', NULL, '2026-02-24', 'Belum Lunas', 'bukti/6Aw9Un4bDvzRkpWnIw60cV6KWed0ocZBQ75JirRY.jpg', NULL, '26', NULL, '2026-02-24 09:13:09', '2026-02-24 09:13:09'),
(11, 'ASY/26/UPZ/0011', '123', '123', '123', '123', 1, '[]', '[{\"uang\": 30000, \"beras\": 2, \"jenis\": \"Zakat Fitrah\"}]', 30000, 2.0, 'Tiga Puluh Ribu Rupiah', 'petugas', NULL, '2026-02-24', 'Lunas', 'bukti/2s20Fbf2sVMaDoJWmsqqtAvJmmqgmm5DJLL8y1it.jpg', NULL, '26', NULL, '2026-02-24 09:16:50', '2026-02-24 09:21:32'),
(12, 'ASY/26/UPZ/0012', 'nama', 'alamt', '123', 'profesi', 1, '[]', '[{\"uang\": 30000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 30000, 0.0, 'Tiga Puluh Ribu Rupiah', 'kasir', NULL, '2026-02-26', 'Lunas', NULL, NULL, '26', 4, '2026-02-26 07:20:25', '2026-02-26 07:20:25'),
(13, 'ASY/26/UPZ/0013', 'test wa', 'alamat', '08123123123', 'asd', 1, '[]', '[{\"uang\": 30000, \"beras\": 2, \"jenis\": \"Zakat Fitrah\"}]', 30000, 2.0, 'Tiga Puluh Ribu Rupiah', 'kasir', NULL, '2026-02-26', 'Lunas', NULL, NULL, '26', 4, '2026-02-26 07:27:33', '2026-02-26 07:27:33'),
(14, 'ASY/26/UPZ/0014', 'TES BARU', 'TES BARU', '081224834330', 'TES BARU', 1, '[]', '[{\"uang\": 30000, \"beras\": 2, \"jenis\": \"Zakat Fitrah\"}]', 30000, 2.0, 'Tiga Puluh Ribu Rupiah', 'petugas', NULL, '2026-02-27', 'Lunas', NULL, 'Cash', '26', NULL, '2026-02-27 08:41:15', '2026-02-27 08:41:15'),
(15, 'ASY/26/UPZ/0015', 'TES BARU 2', 'TES BARU 2', '081224834330', 'TES BARU 2', 1, '[]', '[{\"uang\": 30000, \"beras\": 2, \"jenis\": \"Zakat Fitrah\"}]', 30000, 2.0, 'Tiga Puluh Ribu Rupiah', 'petugas', NULL, '2026-02-27', 'Lunas', NULL, 'BSI', '26', NULL, '2026-02-27 09:01:49', '2026-02-27 09:01:49'),
(16, 'ASY/26/UPZ/0016', 'TES BARU 3', 'TES BARU 3', '081224834330', 'TES BARU 3', 1, '[]', '[{\"uang\": 30000, \"beras\": 2, \"jenis\": \"Zakat Fitrah\"}]', 30000, 2.0, 'Tiga Puluh Ribu Rupiah', 'petugas', NULL, '2026-02-27', 'Lunas', NULL, 'Cash', '26', NULL, '2026-02-27 09:02:25', '2026-02-27 09:02:25'),
(17, 'ASY/26/UPZ/0017', 'TES BARU 3', 'TES BARU 3', '081224834330', 'TES BARU 3', 1, '[]', '[{\"uang\": 30000, \"beras\": 2, \"jenis\": \"Zakat Fitrah\"}]', 30000, 2.0, 'Tiga Puluh Ribu Rupiah', 'petugas', NULL, '2026-02-27', 'Lunas', NULL, 'Cash', '26', NULL, '2026-02-27 09:03:54', '2026-02-27 09:03:54'),
(18, 'ASY/26/UPZ/0018', 'TES BARU 3', 'TES BARU 3', '081224834330', 'TES BARU 3', 1, '[]', '[{\"uang\": 30000, \"beras\": 2, \"jenis\": \"Zakat Fitrah\"}]', 30000, 2.0, 'Tiga Puluh Ribu Rupiah', 'petugas', NULL, '2026-02-27', 'Lunas', NULL, 'Cash', '26', NULL, '2026-02-27 09:04:45', '2026-02-27 09:04:45'),
(19, 'ASY/26/UPZ/0019', 'TES BARU 4', 'TES BARU 4', '081224834330', 'TES BARU 4', 1, '[]', '[{\"uang\": 30000, \"beras\": 2, \"jenis\": \"Zakat Fitrah\"}]', 30000, 2.0, 'Tiga Puluh Ribu Rupiah', 'petugas', NULL, '2026-02-27', 'Lunas', NULL, 'Cash', '26', NULL, '2026-02-27 09:09:56', '2026-02-27 09:09:56'),
(20, 'ASY/26/UPZ/0020', 'TES BARU 5', 'TES BARU 5', '081224834330', 'TES BARU 5', 1, '[]', '[{\"uang\": 30000, \"beras\": 2, \"jenis\": \"Zakat Fitrah\"}]', 30000, 2.0, 'Tiga Puluh Ribu Rupiah', 'kasir', NULL, '2026-02-27', 'Lunas', NULL, 'QRIS', '26', 4, '2026-02-27 09:11:23', '2026-02-27 09:11:23'),
(21, 'ASY/26/UPZ/0021', 'TES BARU 6', 'TES BARU 6', '081224834330', 'TES BARU 6', 1, '[]', '[{\"uang\": 30000, \"beras\": 2, \"jenis\": \"Zakat Fitrah\"}]', 30000, 2.0, 'Tiga Puluh Ribu Rupiah', 'kasir', 2, '2026-02-27', 'Lunas', NULL, 'Cash', '26', 4, '2026-02-27 09:20:16', '2026-02-27 09:20:16'),
(22, 'ASY/26/UPZ/0022', 'TES BARU 7', 'TES BARU 7', '081224834330', 'TES BARU 7', 1, '[]', '[{\"uang\": 30000, \"beras\": 3, \"jenis\": \"Zakat Fitrah\"}]', 30000, 3.0, 'Tiga Puluh Ribu Rupiah', 'kasir', 3, '2026-02-27', 'Lunas', NULL, 'BSI', '26', 4, '2026-02-27 09:21:06', '2026-02-27 09:21:06'),
(23, 'ASY/26/UPZ/0023', 'Kemal Iksan', '123', '081224834330', '123', 1, '[]', '[{\"uang\": 30000, \"beras\": 2, \"jenis\": \"Zakat Fitrah\"}]', 30000, 2.0, 'Tiga Puluh Ribu Rupiah', 'Admin Utama', 1, '2026-02-27', 'Lunas', NULL, 'BSI', '26', NULL, '2026-02-27 09:31:39', '2026-02-27 09:31:39'),
(24, 'ASY/26/UPZ/0024', 'Kemal Iksan', 'JL JALAN', '081224834330', '123', 1, '[]', '[{\"uang\": 30000, \"beras\": 2, \"jenis\": \"Zakat Fitrah\"}]', 30000, 2.0, 'Tiga Puluh Ribu Rupiah', 'Admin Utama', 2, '2026-02-27', 'Lunas', NULL, 'BSI', '26', NULL, '2026-02-27 09:38:12', '2026-02-27 09:38:12'),
(25, 'ASY/26/UPZ/0025', 'Kemal Iksan', '123', '081224834330', '123', 1, '[]', '[{\"uang\": 30000, \"beras\": 1, \"jenis\": \"Zakat Fitrah\"}, {\"uang\": 22222, \"beras\": 2, \"jenis\": \"Yatim\"}]', 52222, 3.0, 'Lima Puluh Dua Ribu Dua Ratus Dua Puluh Dua Rupiah', 'Admin Utama', 3, '2026-02-27', 'Lunas', NULL, 'QRIS', '26', NULL, '2026-02-27 09:42:09', '2026-02-27 09:42:09'),
(26, 'ASY/26/UPZ/0026', 'Kemal Iksan', '123', '081224834330', '123', 1, '[]', '[{\"uang\": 30000, \"beras\": 8, \"jenis\": \"Zakat Fitrah\"}]', 30000, 8.0, 'Tiga Puluh Ribu Rupiah', 'Admin Utama', 4, '2026-02-27', 'Lunas', NULL, 'Cash', '26', NULL, '2026-02-27 09:49:28', '2026-02-27 09:49:28'),
(27, 'ASY/26/UPZ/0027', 'Kemal Iksan', 'asd', '081224834330', 'asd', 1, '[]', '[{\"uang\": 30000, \"beras\": 1, \"jenis\": \"Zakat Fitrah\"}]', 30000, 1.0, 'Tiga Puluh Ribu Rupiah', 'kasir', 1, '2026-02-28', 'Lunas', 'bukti/AydT5aXgKcODDXhsFNoABzUunrr4di7KgOS6oTHc.jpg', 'Cash', '26', 4, '2026-02-28 06:18:16', '2026-02-28 06:25:58'),
(28, 'ASY/26/UPZ/0028', 'Kemal Iksan', 'JL JALAN', '081224834330', 'asd', 1, '[]', '[{\"uang\": 30000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}, {\"uang\": 10000, \"beras\": 0, \"jenis\": \"Fidyah\"}, {\"uang\": 10000, \"beras\": 0, \"jenis\": \"Infaq - Shodaqoh\"}]', 50000, 0.0, 'Lima Puluh Ribu Rupiah', 'kasir', 2, '2026-02-28', 'Lunas', 'bukti/gUgaggZC5Ox2zr4UZWshnDvHj29QU5NQ2913sUc4.jpg', 'Cash', '26', 4, '2026-02-28 06:19:40', '2026-02-28 06:24:57'),
(29, 'ASY/26/UPZ/0029', 'Kemal Iksan', 'JL JALAN', '123', 'asd', 3, '[\"2\", \"3\"]', '[{\"uang\": 90000, \"beras\": 1, \"jenis\": \"Zakat Fitrah\"}]', 90000, 1.0, 'Sembilan Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/fcgeAw5SFRlNiNWa53N3jgZdtpHjHUHv8wu5Nks3.jpg', 'Cash', '26', NULL, '2026-02-28 06:28:33', '2026-02-28 06:28:33'),
(30, 'ASY/26/UPZ/0030', 'Kemal Iksan', 'JL JALAN', '123', 'asd', 5, '[\"2\", \"3\", \"4\", \"5\"]', '[{\"uang\": 150000, \"beras\": 1, \"jenis\": \"Zakat Fitrah\"}]', 150000, 1.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/paZKcHYC5wyJBK8ukg8LpELP6qN380kwJGZJFwNK.jpg', 'Cash', '26', NULL, '2026-02-28 06:29:29', '2026-02-28 06:29:29'),
(31, 'ASY/26/UPZ/0031', 'Kemal Iksan', 'asd', '123', 'as', 5, '[\"2\", \"3\", \"4\", \"5\"]', '[{\"uang\": 150000, \"beras\": 1, \"jenis\": \"Zakat Fitrah\"}]', 150000, 1.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/nFkbqTJwxUHB4eV1g4LvPQ6GLXanVLuqSJUSHgNP.jpg', 'Cash', '26', NULL, '2026-02-28 06:30:08', '2026-02-28 06:30:08'),
(33, 'ASY/26/UPZ/0032', 'Kemal Iksan', 'JL JALAN', '123', '123', 2, '[\"3\"]', '[{\"uang\": 60000, \"beras\": 2, \"jenis\": \"Zakat Fitrah\"}]', 60000, 2.0, 'Enam Puluh Ribu Rupiah', 'kasir', 3, '2026-02-28', 'Lunas', NULL, 'Cash', '26', 4, '2026-02-28 06:34:47', '2026-02-28 06:34:47'),
(34, 'ASY/26/UPZ/0033', 'Kemal Iksan', 'JL JALAN', '081224834330', '123', 5, '[\"2\", \"3\", \"4\", \"5\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}, {\"uang\": 30000, \"beras\": 0, \"jenis\": \"Zakat Maal\"}]', 180000, 0.0, 'Seratus Delapan Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/7GV9DimOD71X5ldHn76Fr2zPvxY0SbOboxjsHYhd.jpg', 'Cash', '26', NULL, '2026-02-28 06:54:57', '2026-02-28 06:54:57'),
(35, 'ASY/26/UPZ/0034', 'Kemal Iksan', '123', '1', '123', 5, '[\"2\", \"3\", \"4\", \"5\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}, {\"uang\": 30000, \"beras\": 0, \"jenis\": \"Zakat Maal\"}]', 180000, 0.0, 'Seratus Delapan Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/06PG23i1iI5a9fYQBJY99nKvtuPaqM39i6IDioUh.jpg', 'Cash', '26', NULL, '2026-02-28 06:55:45', '2026-02-28 06:55:45'),
(36, 'ASY/26/UPZ/0035', 'Kemal Iksan', 'JL JALAN', '081224834330', '123', 5, '[\"2\", \"3\", \"4\", \"5\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}, {\"uang\": 30000, \"beras\": 0, \"jenis\": \"Infaq - Shodaqoh\"}, {\"uang\": 30000, \"beras\": 0, \"jenis\": \"Fidyah\"}]', 210000, 0.0, 'Dua Ratus Sepuluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/xK7B4Z9J3vnHsIKvpRC7trlPcJHmN2mShpmOANvu.jpg', 'QRIS', '26', NULL, '2026-02-28 06:57:54', '2026-02-28 06:57:54'),
(37, 'ASY/26/UPZ/0036', 'Kemal Iksan', '123', '081224834330', '123', 5, '[\"2\", \"34\", \"5\", \"4\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}, {\"uang\": 30000, \"beras\": 0, \"jenis\": \"Yatim\"}]', 180000, 0.0, 'Seratus Delapan Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/azBycfUQQcuafZ7ZDpiH8Q3JUOxH92OTMUAtfV2s.jpg', 'BSI', '26', NULL, '2026-02-28 07:01:08', '2026-02-28 07:01:08'),
(38, 'ASY/26/UPZ/0037', '123', '123', '123', NULL, 5, '[\"2\", \"2\", \"2\", \"2\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}, {\"uang\": 30000, \"beras\": 0, \"jenis\": \"Yatim\"}]', 180000, 0.0, 'Seratus Delapan Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/vSx6AhyCV1fh5ijOVrKbhrOYdnF9iO4u7MGAv7ed.jpg', 'Cash', '26', NULL, '2026-02-28 07:03:05', '2026-02-28 07:03:05'),
(39, 'ASY/26/UPZ/0038', '123', '123', '1', '123', 5, '[\"2\", \"2\", \"2\", \"2\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 150000, 0.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/EwYGZq9eTXAwakGOCXfRoqLKFTcq04lf7JbCZIQM.jpg', 'Cash', '26', NULL, '2026-02-28 07:03:39', '2026-02-28 07:03:39'),
(40, 'ASY/26/UPZ/0039', 'Kemal Iksan', '123', '123', '123', 5, '[\"2\", \"2\", \"2\", \"2\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 150000, 0.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/gU8NeKVyVqhgGr4VEfe17nur4PAzi57iqIaxysvb.jpg', 'Cash', '26', NULL, '2026-02-28 07:05:22', '2026-02-28 07:05:22'),
(41, 'ASY/26/UPZ/0040', '123', '123', '081224834330', '1', 5, '[\"2\", \"2\", \"2\", \"2\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 150000, 0.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/pcsX3Ukk5Was5xcr9JSYVJEf3NcQ3mEPRpk7WI9Y.jpg', 'Cash', '26', NULL, '2026-02-28 07:07:31', '2026-02-28 07:07:31'),
(42, 'ASY/26/UPZ/0041', '123', '123', '1', '123', 5, '[\"2\", \"2\", \"2\", \"2\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 150000, 0.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/da9yIkOMef09ciTrnTmE7VebxxsCZ6In3ekNePDA.png', 'Cash', '26', NULL, '2026-02-28 07:11:14', '2026-02-28 07:11:14'),
(43, 'ASY/26/UPZ/0042', '123', '123', '123', '123', 5, '[\"2\", \"2\", \"2\", \"2\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 150000, 0.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/33ryNZpn0YWZzPmneMxO1COnIWcbytG1ekAvwfps.jpg', 'Cash', '26', NULL, '2026-02-28 07:13:24', '2026-02-28 07:13:24'),
(44, 'ASY/26/UPZ/0043', '123', '123', '123', '123', 5, '[\"2\", \"2\", \"2\", \"2\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 150000, 0.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/Gq0tRmwJ991Hi839zePT98O7jp9EV7vICiVxqnSL.jpg', 'Cash', '26', NULL, '2026-02-28 07:15:22', '2026-02-28 07:15:22'),
(45, 'ASY/26/UPZ/0044', '123', '123', '123', '123', 5, '[\"2\", \"2\", \"2\", \"2\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 150000, 0.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/a0MZbujazeDC9dXwtKNGksDnSW9XhIg9KpvbJPvm.jpg', 'Cash', '26', NULL, '2026-02-28 07:23:07', '2026-02-28 07:23:07'),
(46, 'ASY/26/UPZ/0045', '123', '123', '081224834330', '123', 5, '[\"2\", \"2\", \"2\", \"2\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 150000, 0.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/TctnLbd4KiLiHyeEHxlRj5IcnT2wRXowtmhkUmAF.jpg', 'Cash', '26', NULL, '2026-02-28 07:31:34', '2026-02-28 07:31:34'),
(47, 'ASY/26/UPZ/0046', 'Kemal Iksan', '123', '123', '123', 5, '[\"2\", \"2\", \"2\", \"2\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 150000, 0.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/LFVeYaA97QG7EUmXNH6eYAkc7lyQwhKbVjjdIb4s.jpg', 'Cash', '26', NULL, '2026-02-28 07:50:56', '2026-02-28 07:50:56'),
(48, 'ASY/26/UPZ/0047', 'Kemal Iksan', '123', '081224834330', '123', 5, '[\"2\", \"2\", \"2\", \"2\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 150000, 0.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/o8Tl6VApo9RsOE23KXdaLTOAFUZilK4P8Qv6Z0xw.png', 'Cash', '26', NULL, '2026-02-28 08:39:36', '2026-02-28 08:39:36'),
(49, 'ASY/26/UPZ/0048', 'Kemal Iksan', '1', '1', '1', 5, '[\"2\", \"2\", \"2\", \"2\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 150000, 0.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/ATkMwEMJ23XgjJMGg2cKDD5HPP0jsmHwTM1NgWx0.jpg', 'Cash', '26', NULL, '2026-02-28 08:42:53', '2026-02-28 08:42:53'),
(50, 'ASY/26/UPZ/0049', 'Kemal Iksan', '123', '123', '123', 5, '[\"2\", \"2\", \"2\", \"2\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 150000, 0.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/GjiEp0PeCeHu2F0Y7FwLIyG6ExSD9jX5pn6UBiFw.jpg', 'Cash', '26', NULL, '2026-02-28 08:43:34', '2026-02-28 08:43:34'),
(51, 'ASY/26/UPZ/0050', '123', '123', '1', '123', 5, '[\"2\", \"2\", \"2\", \"2\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 150000, 0.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/80ne9xFZ4k9rV9GP7YOdVJbOgEhFrFyLz8JCmqba.jpg', 'Cash', '26', NULL, '2026-02-28 08:47:20', '2026-02-28 08:47:20'),
(52, 'ASY/26/UPZ/0051', '123', '123', '1', '123', 5, '[\"2\", \"2\", \"2\", \"2\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 150000, 0.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/vbpGt8KDPtPMtDvVMeMEybq5eGRy6lWptYR1ErNW.jpg', 'Cash', '26', NULL, '2026-02-28 08:57:23', '2026-02-28 08:57:23'),
(53, 'ASY/26/UPZ/0052', '12', '123', '123', '1', 5, '[\"2\", \"2\", \"2\", \"2\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 150000, 0.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/zFSuyoynEkbriGgFO9hEGTjSf4KYLSz2e1LrGWaj.jpg', 'Cash', '26', NULL, '2026-02-28 09:02:20', '2026-02-28 09:02:20'),
(54, 'ASY/26/UPZ/0053', '123', '123', '123', '123', 5, '[\"2\", \"2\", \"2\", \"2\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 150000, 0.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/F2gVPyydXHjteDVgtGccccIDIYvj9D9sZbn8nRzf.jpg', 'Cash', '26', NULL, '2026-02-28 09:08:31', '2026-02-28 09:08:31'),
(55, 'ASY/26/UPZ/0054', 'Kemal Iksan', 'qwe', '123', 'qwe', 4, '[\"2\", \"2\", \"2\"]', '[{\"uang\": 120000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 120000, 0.0, 'Seratus Dua Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/H6sgPzksfrVRgBAiRcLRDptkkoW0GrwuT9F1RjRW.jpg', 'Cash', '26', NULL, '2026-02-28 09:09:42', '2026-02-28 09:09:42'),
(56, 'ASY/26/UPZ/0055', '123', '123', '123', '123', 5, '[\"2\", \"2\", \"2\", \"2\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 150000, 0.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/5na5ITrBdDYjxnxEmecisny3afe8yMGo7mf2T6I1.jpg', 'BSI', '26', NULL, '2026-02-28 09:12:53', '2026-02-28 09:12:53'),
(57, 'ASY/26/UPZ/0056', '123', '123', '123', '123', 5, '[\"2\", \"2\", \"2\", \"2\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 150000, 0.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/V9kspHCAHHAXB65jacqFElEbKRCcPWGUXqL52227.jpg', 'BSI', '26', NULL, '2026-02-28 09:14:57', '2026-02-28 09:14:57'),
(58, 'ASY/26/UPZ/0057', '123', '123', '123', '123', 5, '[\"2\", \"2\", \"2\", \"2\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 150000, 0.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/lFm2vCdRH5D6zRNRIQbLUoYmcCktBbv4I0LmCd4N.jpg', 'Cash', '26', NULL, '2026-02-28 09:15:35', '2026-02-28 09:15:35'),
(59, 'ASY/26/UPZ/0058', '123', '123', '123', '123', 5, '[\"2\", \"2\", \"2\", \"2\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 150000, 0.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/6RwngbSr3pFhziuTkPDjwOAGIlrlotsUAAAEk0DO.jpg', 'Cash', '26', NULL, '2026-02-28 09:18:12', '2026-02-28 09:18:12'),
(60, 'ASY/26/UPZ/0059', '123', '123', '123', '123', 5, '[\"2\", \"2\", \"2\", \"2\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 150000, 0.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Belum Lunas', 'bukti/I8AeLpmCP1af7JPSzuYK0RRajRopnvYPJMmVcxEf.jpg', 'Cash', '26', NULL, '2026-02-28 09:18:51', '2026-02-28 09:18:51'),
(61, 'ASY/26/UPZ/0060', '123', '123', '123', '123', 5, '[\"2\", \"2\", \"2\", \"2\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 150000, 0.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-02-28', 'Lunas', 'bukti/BSEMAOPfq01tHeL5fztF3lFNsi2iCjrOFbtAMxJi.jpg', 'Cash', '26', NULL, '2026-02-28 09:19:16', '2026-03-01 07:43:14'),
(62, 'ASY/26/UPZ/0061', 'Kemal Iksan', 'Jalan Ciawi', '081224834330', 'Pegawai Swasta', 5, '[\"Jiwa 2\", \"Jiwa 3\", \"Jiwa 4\", \"Jiwa 5\"]', '[{\"uang\": 262500, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}, {\"uang\": 350000, \"beras\": 0, \"jenis\": \"Fidyah\"}, {\"uang\": 100000, \"beras\": 0, \"jenis\": \"Infaq - Shodaqoh\"}]', 712500, 0.0, 'Tujuh Ratus Dua Belas Ribu Lima Ratus Rupiah', '', NULL, '2026-03-01', 'Lunas', 'bukti/sKteokzarTJs11FuIydmL59hjQ0Pk1x0lPfGckyl.jpg', 'Cash', '26', NULL, '2026-03-01 07:22:00', '2026-03-01 07:35:38'),
(63, 'ASY/26/UPZ/0062', 'Kemal Iksan', 'JL JALAN', '081224834330', 'profesi', 5, '[\"2\", \"3\", \"4\", \"5\"]', '[{\"uang\": 262500, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}, {\"uang\": 350000, \"beras\": 0, \"jenis\": \"Fidyah\"}, {\"uang\": 100000, \"beras\": 0, \"jenis\": \"Infaq - Shodaqoh\"}]', 712500, 0.0, 'Tujuh Ratus Dua Belas Ribu Lima Ratus Rupiah', 'Petugas 1', 1, '2026-03-01', 'Lunas', NULL, 'BSI', '26', 2, '2026-03-01 07:25:51', '2026-03-01 07:25:51'),
(64, 'ASY/26/UPZ/0063', '123', '123', '123', 'PNS', 1, '[]', '[{\"uang\": 30000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 30000, 0.0, 'Tiga Puluh Ribu Rupiah', '', NULL, '2026-03-04', 'Belum Lunas', 'bukti/iVJqawe2FhLso9bBbLqUxlZ89NllahmLDdK10ljb.png', 'Cash', '26', NULL, '2026-03-04 07:28:05', '2026-03-04 07:28:05'),
(65, 'ASY/26/UPZ/0064', '123', '123', '1', 'PNS', 5, '[\"123\", \"123\", \"123\", \"123\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 150000, 0.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-03-04', 'Belum Lunas', 'bukti/Voe3T0KvbxBAqTZ9pJ4vz5Dap9pBgQXrZHn0Bj85.png', 'Cash', '26', NULL, '2026-03-04 07:28:39', '2026-03-04 07:28:39'),
(66, 'ASY/26/UPZ/0065', '123', '123', '123', 'PNS', 5, '[\"2\", \"2\", \"2\", \"2\"]', '[{\"uang\": 150000, \"beras\": 0, \"jenis\": \"Zakat Fitrah\"}]', 150000, 0.0, 'Seratus Lima Puluh Ribu Rupiah', '', NULL, '2026-03-04', 'Belum Lunas', 'bukti/zcMmIsEIdA1WMRMkxLqXLKix2PSLrKMyEsOf4S3f.jpg', 'Cash', '26', NULL, '2026-03-04 07:39:44', '2026-03-04 07:39:44'),
(67, 'ASY/26/UPZ/0066', 'Kemal Iksan', 'asd', '123', 'PNS', 1, '[]', '[{\"uang\": 30000, \"beras\": 2, \"jenis\": \"Zakat Fitrah\"}]', 30000, 2.0, 'Tiga Puluh Ribu Rupiah', 'Admin Utama', 1, '2026-03-04', 'Lunas', NULL, 'Cash', '26', NULL, '2026-03-04 08:27:50', '2026-03-04 08:27:50'),
(68, 'ASY/26/UPZ/0067', 'Kemal Iksan', 'asd', '123', 'PNS', 5, '[\"2\", \"3\", \"4\", \"5\"]', '[{\"uang\": 150000, \"beras\": 3, \"jenis\": \"Zakat Fitrah\"}]', 150000, 3.0, 'Seratus Lima Puluh Ribu Rupiah', 'Admin Utama', 2, '2026-03-04', 'Lunas', NULL, 'Cash', '26', NULL, '2026-03-04 08:36:35', '2026-03-04 08:36:35'),
(69, 'ASY/26/UPZ/0068', 'Kemal Iksan', 'asd', '123', 'PNS', 6, '[\"2\", \"3\", \"4\", \"5\", \"6\"]', '[{\"uang\": 180000, \"beras\": 2, \"jenis\": \"Zakat Fitrah\"}]', 180000, 2.0, 'Seratus Delapan Puluh Ribu Rupiah', 'Admin Utama', 3, '2026-03-04', 'Lunas', NULL, 'Cash', '26', NULL, '2026-03-04 08:37:33', '2026-03-04 08:37:33'),
(70, 'ASY/26/UPZ/0069', 'Kemal Iksan', 'asd', '123', 'PNS', 10, '[\"2\", \"3\", \"4\", \"5\", \"6\", \"7\", \"8\", \"9\", \"10\"]', '[{\"uang\": 300000, \"beras\": 2, \"jenis\": \"Zakat Fitrah\"}]', 300000, 2.0, 'Tiga Ratus Ribu Rupiah', 'Admin Utama', 4, '2026-03-04', 'Lunas', NULL, 'Cash', '26', NULL, '2026-03-04 08:38:53', '2026-03-04 08:38:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `zakat_penerimaans`
--
ALTER TABLE `zakat_penerimaans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `zakat_penerimaans_nomor_unique` (`nomor`),
  ADD KEY `zakat_penerimaans_created_by_foreign` (`created_by`),
  ADD KEY `zakat_penerimaans_tahun_index` (`tahun`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `zakat_penerimaans`
--
ALTER TABLE `zakat_penerimaans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `zakat_penerimaans`
--
ALTER TABLE `zakat_penerimaans`
  ADD CONSTRAINT `zakat_penerimaans_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
