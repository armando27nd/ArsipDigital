-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 18, 2025 at 04:11 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arsip_digital`
--

-- --------------------------------------------------------

--
-- Table structure for table `agenda`
--

CREATE TABLE `agenda` (
  `id` bigint UNSIGNED NOT NULL,
  `disposisi_id` bigint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time DEFAULT NULL,
  `kegiatan` text COLLATE utf8mb4_unicode_ci,
  `tempat` text COLLATE utf8mb4_unicode_ci,
  `pejabat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agenda`
--

INSERT INTO `agenda` (`id`, `disposisi_id`, `tanggal`, `jam`, `kegiatan`, `tempat`, `pejabat`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-07-15', '12:31:00', 'adsas', '123', '-', 'asd', '2025-07-15 06:24:37', '2025-07-15 06:24:37'),
(2, 2, '2025-08-05', '21:00:00', 'job fair', 'disnaker', 'bu neni', '-', '2025-08-04 21:29:17', '2025-08-04 21:29:17'),
(3, 3, '2025-08-05', '08:00:00', 'job fair', 'disnaker', 'kadis', '--', '2025-08-04 21:55:12', '2025-08-04 21:55:12');

-- --------------------------------------------------------

--
-- Table structure for table `disposisi`
--

CREATE TABLE `disposisi` (
  `id` bigint UNSIGNED NOT NULL,
  `admin_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `parent_disposisi` bigint UNSIGNED DEFAULT NULL,
  `instruksi_admin` text COLLATE utf8mb4_unicode_ci,
  `no_dan_tanggal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_instruksi_admin` timestamp NULL DEFAULT NULL,
  `file_surat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_registrasi` int NOT NULL,
  `tanggal` date NOT NULL,
  `index_kartu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `perihal` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `asal` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `instruksi` text COLLATE utf8mb4_unicode_ci,
  `instruksi_user` text COLLATE utf8mb4_unicode_ci,
  `diteruskan` text COLLATE utf8mb4_unicode_ci,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `status` enum('proses','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `disposisi`
--

INSERT INTO `disposisi` (`id`, `admin_id`, `user_id`, `parent_disposisi`, `instruksi_admin`, `no_dan_tanggal`, `waktu_instruksi_admin`, `file_surat`, `no_registrasi`, `tanggal`, `index_kartu`, `perihal`, `asal`, `instruksi`, `instruksi_user`, `diteruskan`, `catatan`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 3, NULL, '-ada', 'asd', '2025-07-20 18:45:19', '1752585852_masker.jpg', 123, '2025-07-15', NULL, 'adsas', 'asd', NULL, NULL, '-asdas', '-', 'disetujui', '2025-07-15 06:24:12', '2025-07-20 18:45:19'),
(2, 3, 2, NULL, '-', '1211', '2025-08-04 21:28:38', '1754368047_write up ctf team H.A.N.D (HARRY SEPTONI ARMANDO NADAPDAP).pdf', 1212, '2025-08-05', NULL, '--', 'pt.x', NULL, NULL, '-', '-', 'disetujui', '2025-08-04 21:27:28', '2025-08-04 21:28:38'),
(3, 3, 2, NULL, '--', '1212', '2025-08-04 21:54:45', '1754369644_butki foto 3.jpg', 11222, '2025-08-05', NULL, '--', 'pt.xxx', NULL, NULL, '--', '--', 'disetujui', '2025-08-04 21:54:04', '2025-08-04 21:54:45'),
(4, 3, 2, NULL, 'Yth, Sekdis', 'B-000.8..4/57/ORG/2025/ 04 Juli 2025', '2025-08-04 23:58:49', '1754377055_disposisi1.jpg', 1080, '2025-08-05', NULL, 'Pelaksanaan Kompetisi Inovasi Pelayanan Publik Banten Tahun 2025', 'Provinsi Banten', NULL, NULL, 'YthL Kabid Penta', '-', 'disetujui', '2025-08-04 23:57:35', '2025-08-04 23:58:49');

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
(1, '2025_07_15_123832_create_surat_masuk_table', 1),
(2, '2025_07_15_124001_create_surat_keluar_table', 1),
(3, '2025_07_15_124024_create_users_tabel', 1),
(4, '2025_07_15_124041_create_disposisi_table', 1),
(5, '2025_07_15_124052_create_agenda_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `surat_keluar`
--

CREATE TABLE `surat_keluar` (
  `id_sk` int UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `kode_klasifikasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi_ringkasan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `asal` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `surat_keluar`
--

INSERT INTO `surat_keluar` (`id_sk`, `tanggal`, `kode_klasifikasi`, `no_surat`, `isi_ringkasan`, `asal`, `file`, `keterangan`, `created_at`, `updated_at`) VALUES
(2, '2025-08-02', 'asdas', 'addjoqdnqh1', 'adsasds', 'adasd', '1754118453_logo untara.png', '123', '2025-08-02 00:07:33', '2025-08-02 00:07:33');

-- --------------------------------------------------------

--
-- Table structure for table `surat_masuk`
--

CREATE TABLE `surat_masuk` (
  `id_sm` int UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `kode_klasifikasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi_ringkasan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `asal` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `surat_masuk`
--

INSERT INTO `surat_masuk` (`id_sm`, `tanggal`, `kode_klasifikasi`, `no_surat`, `isi_ringkasan`, `asal`, `file`, `keterangan`, `created_at`, `updated_at`) VALUES
(2, '2025-08-05', 'Apa ya?', 'ApaYa?', 'APa YA?', 'Apa YA?', '1754360558_write up ctf team H.A.N.D (HARRY SEPTONI ARMANDO NADAPDAP).pdf', '- nono', '2025-08-02 00:21:47', '2025-08-04 19:22:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `role`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'user', 'user', 'user', '$2y$10$C7FL/X/kkzi/a5CBuqngGeSzHjnAA79tPIkD1yDd6vmFaUQtrRSci', NULL, '2025-07-15 06:17:26', '2025-07-15 06:17:26'),
(3, 'Admin', 'admin', 'admin', '$2y$10$AnbSRSGOBj2Zhiylh8PBd.BreQPAF/HkhTEwLcagyPODWEqYOoRdy', NULL, '2025-07-15 06:18:04', '2025-07-15 06:18:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agenda_disposisi_id_foreign` (`disposisi_id`);

--
-- Indexes for table `disposisi`
--
ALTER TABLE `disposisi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `disposisi_admin_id_foreign` (`admin_id`),
  ADD KEY `disposisi_user_id_foreign` (`user_id`),
  ADD KEY `disposisi_parent_disposisi_foreign` (`parent_disposisi`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  ADD PRIMARY KEY (`id_sk`);

--
-- Indexes for table `surat_masuk`
--
ALTER TABLE `surat_masuk`
  ADD PRIMARY KEY (`id_sm`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `disposisi`
--
ALTER TABLE `disposisi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `surat_keluar`
--
ALTER TABLE `surat_keluar`
  MODIFY `id_sk` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `surat_masuk`
--
ALTER TABLE `surat_masuk`
  MODIFY `id_sm` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agenda`
--
ALTER TABLE `agenda`
  ADD CONSTRAINT `agenda_disposisi_id_foreign` FOREIGN KEY (`disposisi_id`) REFERENCES `disposisi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `disposisi`
--
ALTER TABLE `disposisi`
  ADD CONSTRAINT `disposisi_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `disposisi_parent_disposisi_foreign` FOREIGN KEY (`parent_disposisi`) REFERENCES `disposisi` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `disposisi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
