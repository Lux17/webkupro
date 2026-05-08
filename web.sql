-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for web
CREATE DATABASE IF NOT EXISTS `web` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `web`;

-- Dumping structure for table web.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table web.cache: ~2 rows (approximately)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('user1@gmail.com|127.0.0.1', 'i:1;', 1777637103),
	('user1@gmail.com|127.0.0.1:timer', 'i:1777637103;', 1777637103);

-- Dumping structure for table web.files
CREATE TABLE IF NOT EXISTS `files` (
  `id_files` int NOT NULL AUTO_INCREMENT,
  `nama_files` text,
  `id_user` text,
  `tgl` date DEFAULT NULL,
  `file` text,
  PRIMARY KEY (`id_files`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table web.files: ~3 rows (approximately)
INSERT INTO `files` (`id_files`, `nama_files`, `id_user`, `tgl`, `file`) VALUES
	(5, 'komik', '1', '2026-04-26', 'upload/1777202802_komik.jpeg'),
	(6, 'video_tutorial', '1', '2026-04-26', 'upload/1777202979_membaca.mp4'),
	(7, 'foto', '67', '2026-05-01', 'upload/1777638908_guru.png');

-- Dumping structure for table web.jawaban_kuis
CREATE TABLE IF NOT EXISTS `jawaban_kuis` (
  `attempt_id` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `skor` int DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `id_kuis` int DEFAULT NULL,
  `id_mapel` int DEFAULT NULL,
  PRIMARY KEY (`attempt_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table web.jawaban_kuis: ~2 rows (approximately)
INSERT INTO `jawaban_kuis` (`attempt_id`, `id_user`, `skor`, `timestamp`, `id_kuis`, `id_mapel`) VALUES
	(29, 29, 50, NULL, 2, 1),
	(30, 29, 100, NULL, 2, 1);

-- Dumping structure for table web.kelas
CREATE TABLE IF NOT EXISTS `kelas` (
  `id_kelas` int NOT NULL AUTO_INCREMENT,
  `nama_kelas` text,
  PRIMARY KEY (`id_kelas`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table web.kelas: ~3 rows (approximately)
INSERT INTO `kelas` (`id_kelas`, `nama_kelas`) VALUES
	(4, 'Kelas X'),
	(5, 'Kelas XI'),
	(6, 'Kelas XII');

-- Dumping structure for table web.kuis
CREATE TABLE IF NOT EXISTS `kuis` (
  `id_kuis` int NOT NULL AUTO_INCREMENT,
  `kode_kuis` text,
  `id_mapel` int DEFAULT NULL,
  `id_guru` int DEFAULT NULL,
  `durasi` int DEFAULT NULL,
  PRIMARY KEY (`id_kuis`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table web.kuis: ~2 rows (approximately)
INSERT INTO `kuis` (`id_kuis`, `kode_kuis`, `id_mapel`, `id_guru`, `durasi`) VALUES
	(1, '20260501204454', 4, 66, 45),
	(2, '20260501210453', 5, 69, 15);

-- Dumping structure for table web.mata_pelajaran
CREATE TABLE IF NOT EXISTS `mata_pelajaran` (
  `id_mapel` int NOT NULL AUTO_INCREMENT,
  `nama_mapel` text,
  `id_kelas` int NOT NULL,
  `id_guru` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  PRIMARY KEY (`id_mapel`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table web.mata_pelajaran: ~2 rows (approximately)
INSERT INTO `mata_pelajaran` (`id_mapel`, `nama_mapel`, `id_kelas`, `id_guru`) VALUES
	(4, 'Kimia - Semester Ganjil', 4, '66'),
	(5, 'Kimia -Semester Genap', 4, '69');

-- Dumping structure for table web.materi
CREATE TABLE IF NOT EXISTS `materi` (
  `id_materi` int NOT NULL AUTO_INCREMENT,
  `title` text,
  `content` longtext,
  `tgl` timestamp NULL DEFAULT NULL,
  `id_mapel` text,
  `id_guru` text,
  PRIMARY KEY (`id_materi`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table web.materi: ~2 rows (approximately)
INSERT INTO `materi` (`id_materi`, `title`, `content`, `tgl`, `id_mapel`, `id_guru`) VALUES
	(4, 'Tinjauan Ulang Materi Kimia SMP/MTS (tentatif)', '<p>isi</p>', '2026-05-01 13:43:18', '4', NULL),
	(5, 'Hukum Dasar Kimia', '<p>isi</p>', '2026-05-01 13:44:13', '5', NULL);

-- Dumping structure for table web.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`),
  CONSTRAINT `password_reset_tokens_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table web.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table web.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table web.sessions: ~4 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('Akc6jfVABBQMUQGDNDh5PYvGQk01rzXTHvLWPIcU', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSGxFZENnUmZQR0d4OXdobDdwQWp3SGFYRmJaMFo5aXBHbXRNVXNnNCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777664622),
	('C373fZpOJFjfyuGVljFLmlTjBO8aXXjPLBSuxCvt', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV1phYk05SWhjVFRmMlRUa1E5VkFNM2FKNzFjeEsxMjVpeW1ITjRPTyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1777670271),
	('hJm52HICODmkRizhaHXNwERwPRIJ9e9rISidxYEh', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTjA3UzhWdjFweE04aTJtZ2JXTVQzSGdDUFRlOXA3NFM5bUZTeURBRiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1777664623),
	('UUzij9VqLHUFuEwptPogfsbM5ykZQOcXSBaB4nST', 29, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoieUt4SGZINWRBU0FLMXhJOHMyRFZEMmRqYWlSTWt6RnA4MXg5aUtwQiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbmZvIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjk7czo3OiJpc191c2VyIjtiOjE7fQ==', 1777669616);

-- Dumping structure for table web.soal
CREATE TABLE IF NOT EXISTS `soal` (
  `id_soal` int NOT NULL AUTO_INCREMENT,
  `kode_kuis` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `id_mapel` int DEFAULT NULL,
  `id_guru` int NOT NULL,
  `durasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pertanyaan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `opsi_a` text,
  `opsi_b` text,
  `opsi_c` text,
  `opsi_d` text,
  `opsi_e` text,
  `jawaban` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_soal`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table web.soal: ~6 rows (approximately)
INSERT INTO `soal` (`id_soal`, `kode_kuis`, `id_mapel`, `id_guru`, `durasi`, `pertanyaan`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `opsi_e`, `jawaban`) VALUES
	(1, '20260425104714', 1, 63, '45', 'ibukota jawa barat28', 'Jakarta28', 'bandung28', 'cirebon38', 'semarang28', 'bali28', 'd'),
	(8, '20260426114210', 1, 66, '45', 'Sebutkan Ibu Kota Provinsi Jawa Barat', 'Bandung', 'Jakarta', 'Cirebon', 'Bekasi', 'Bogor', 'a'),
	(9, '20260426114210', 1, 66, '45', 'Sebutkan Ibu Kota Provinsi Jawa Timur', 'Bandung', 'Semarang', 'Surabaya', 'Tanggerang', 'Ciawi', 'c'),
	(10, '20260501204454', 4, 66, '45', 'Sebutkan Ibu Kota Provinsi Jawa Barat', 'Jakarta', 'Bandung', 'Cirebon', 'Bekasi', 'Bogor', 'b'),
	(11, '20260501204535', 5, 66, '45', 'Sebutkan Ibu Kota Provinsi Jawa Timur', 'Jakarta', 'Surabaya', 'Cirebon', 'Bekasi', 'Sumba', 'b'),
	(12, '20260501210453', 5, 69, '15', 'Sebutkan Ibu Kota Provinsi Jawa Timur', 'Jakarta', 'Surabaya', 'Banten', 'Bogor', 'Semarang', 'b');

-- Dumping structure for table web.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nisn` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `nip` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rolename` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_kelas` int DEFAULT NULL,
  `jenis_kelamin` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `no_hp` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table web.users: ~6 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `nisn`, `nip`, `rolename`, `alamat`, `id_kelas`, `jenis_kelamin`, `tgl_lahir`, `no_hp`, `remember_token`, `updated_at`, `created_at`) VALUES
	(25, 'Mentor567', 'admin@example.com4567', NULL, '$2y$12$pv5aOVTC.Q/p0RjVWYOPvuIz2zRYpDal.oIMhaU0M6TZxyZzDfwcW', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6834567', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(29, 'user1', 'user@gmail.com', NULL, '$2y$12$l5CKv49vKO365/8Ou6J/2u2.ElD0GcU/TAXf2KfQmXDUYuqW1i5lm', '12345', NULL, 'pengguna', 'Jl. Tuparev 11', 4, 'Laki-Laki', '2022-06-11', '081234567', 'O323lVyCVJ8mFQAatq15S2NKDd1EWVwZBwtpqaBVNB7A9NExN9YGSi0QT3hC', '2026-05-01 14:03:37', '0000-00-00 00:00:00'),
	(66, 'Zaenal  Abidin S.Si', 'guru@gmail.com', NULL, '$2y$12$BkPbLOGXqX2tOHLF919uYOb38VPb7mxK75Tnrfj5Zz3Sn8n8Tdsk6', NULL, '123456', 'guru', 'Blok Wage Plumbon', NULL, 'Laki-Laki', '1999-02-17', '081234567890', NULL, '2026-05-01 13:36:59', NULL),
	(67, 'admin', 'admin@gmail.com', NULL, '$2y$12$QUKYDDP6QMdC5y5c/nyPB.cy2KeHNHX9ixCXoXq9rJa0KELcAXynK', NULL, NULL, 'admin', NULL, NULL, NULL, NULL, '08123456789', NULL, NULL, NULL),
	(69, 'Tuti Pujiastuti S.Si', 'guru1@gmail.com', NULL, '$2y$12$obmzrEpmPgKeIUwPy/HSSOD18839Bh2PwcJVtKxSJmVQAy5qWQfZi', NULL, '567890', 'guru', 'Karawang Timur', NULL, 'Perempuan', '2026-05-14', '084567890123', NULL, NULL, NULL),
	(70, 'Haris Zaelani S.Si', 'guru2@gmail.com', NULL, '$2y$12$vET37Z3wPjzzivr8FKigtuP2Xd0DdKE/P688aDZAeOHgLfYy6sIkC', NULL, '2345678', 'guru', 'Cirebon', NULL, 'Laki-Laki', '2000-06-20', '08567890123', NULL, NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
