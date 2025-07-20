-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table smartmuadzzin.jadwal_sholat
CREATE TABLE IF NOT EXISTS `jadwal_sholat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `tanggal_hijriyah` varchar(50) DEFAULT NULL,
  `imsak` time DEFAULT NULL,
  `subuh` time DEFAULT NULL,
  `syuruq` time DEFAULT NULL,
  `dhuha` time DEFAULT NULL,
  `dzuhur` time DEFAULT NULL,
  `ashar` time DEFAULT NULL,
  `maghrib` time DEFAULT NULL,
  `isya` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tanggal` (`tanggal`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartmuadzzin.jadwal_sholat: ~31 rows (approximately)
DELETE FROM `jadwal_sholat`;
INSERT INTO `jadwal_sholat` (`id`, `tanggal`, `tanggal_hijriyah`, `imsak`, `subuh`, `syuruq`, `dhuha`, `dzuhur`, `ashar`, `maghrib`, `isya`, `created_at`) VALUES
	(2, '2025-07-17', '21 Muharram 1447 H', '04:33:00', '04:43:00', '05:55:00', '06:29:00', '11:59:00', '15:20:00', '17:56:00', '22:23:00', '2025-07-17 11:39:34'),
	(3, '2025-07-01', '5 Muharram 1447 H', '04:31:00', '04:41:00', '05:54:00', '06:28:00', '11:57:00', '15:17:00', '17:53:00', '19:03:00', '2025-07-17 12:00:30'),
	(4, '2025-07-02', '6 Muharram 1447 H', '04:31:00', '04:41:00', '05:54:00', '06:28:00', '11:57:00', '15:18:00', '17:53:00', '19:03:00', '2025-07-17 12:00:31'),
	(5, '2025-07-03', '7 Muharram 1447 H', '04:31:00', '04:41:00', '05:54:00', '06:28:00', '11:57:00', '15:18:00', '17:53:00', '19:03:00', '2025-07-17 12:00:32'),
	(6, '2025-07-04', '8 Muharram 1447 H', '04:31:00', '04:41:00', '05:54:00', '06:28:00', '11:58:00', '15:18:00', '17:54:00', '19:03:00', '2025-07-17 12:00:32'),
	(7, '2025-07-05', '9 Muharram 1447 H', '04:31:00', '04:41:00', '05:55:00', '06:28:00', '11:58:00', '15:18:00', '17:54:00', '19:03:00', '2025-07-17 12:00:33'),
	(8, '2025-07-06', '10 Muharram 1447 H', '04:32:00', '04:42:00', '05:55:00', '06:28:00', '11:58:00', '15:18:00', '17:54:00', '19:04:00', '2025-07-17 12:00:34'),
	(9, '2025-07-07', '11 Muharram 1447 H', '04:32:00', '04:42:00', '05:55:00', '06:28:00', '11:58:00', '15:19:00', '17:54:00', '19:04:00', '2025-07-17 12:00:34'),
	(10, '2025-07-08', '12 Muharram 1447 H', '04:32:00', '04:42:00', '05:55:00', '06:28:00', '11:58:00', '15:19:00', '17:54:00', '19:04:00', '2025-07-17 12:00:35'),
	(11, '2025-07-09', '13 Muharram 1447 H', '04:32:00', '04:42:00', '05:55:00', '06:28:00', '11:58:00', '15:19:00', '17:55:00', '19:04:00', '2025-07-17 12:00:36'),
	(12, '2025-07-10', '14 Muharram 1447 H', '04:32:00', '04:42:00', '05:55:00', '06:28:00', '11:58:00', '15:19:00', '17:55:00', '19:04:00', '2025-07-17 12:00:36'),
	(13, '2025-07-11', '15 Muharram 1447 H', '04:32:00', '04:42:00', '05:55:00', '06:29:00', '11:59:00', '15:19:00', '17:55:00', '19:04:00', '2025-07-17 12:00:37'),
	(14, '2025-07-12', '16 Muharram 1447 H', '04:32:00', '04:42:00', '05:55:00', '06:29:00', '11:59:00', '15:19:00', '17:55:00', '19:04:00', '2025-07-17 12:00:38'),
	(15, '2025-07-13', '17 Muharram 1447 H', '04:33:00', '04:43:00', '05:55:00', '06:29:00', '11:59:00', '15:20:00', '17:55:00', '19:05:00', '2025-07-17 12:00:38'),
	(16, '2025-07-14', '18 Muharram 1447 H', '04:33:00', '04:43:00', '05:55:00', '06:29:00', '11:59:00', '15:20:00', '17:56:00', '19:05:00', '2025-07-17 12:00:39'),
	(17, '2025-07-15', '19 Muharram 1447 H', '04:33:00', '04:43:00', '05:55:00', '06:29:00', '11:59:00', '15:20:00', '17:56:00', '19:05:00', '2025-07-17 12:00:40'),
	(18, '2025-07-16', '20 Muharram 1447 H', '04:33:00', '04:43:00', '05:55:00', '06:29:00', '11:59:00', '15:20:00', '17:56:00', '19:05:00', '2025-07-17 12:00:40'),
	(19, '2025-07-18', '22 Muharram 1447 H', '04:33:00', '04:43:00', '05:55:00', '06:28:00', '11:59:00', '15:20:00', '17:56:00', '19:05:00', '2025-07-17 12:00:42'),
	(20, '2025-07-19', '23 Muharram 1447 H', '04:33:00', '04:43:00', '05:55:00', '06:28:00', '11:59:00', '15:20:00', '17:56:00', '19:05:00', '2025-07-17 12:00:42'),
	(21, '2025-07-20', '24 Muharram 1447 H', '04:33:00', '04:43:00', '05:55:00', '06:28:00', '11:59:00', '15:20:00', '17:57:00', '19:05:00', '2025-07-17 12:00:43'),
	(22, '2025-07-21', '25 Muharram 1447 H', '04:33:00', '04:43:00', '05:55:00', '06:28:00', '12:00:00', '15:20:00', '17:57:00', '19:05:00', '2025-07-17 12:00:44'),
	(23, '2025-07-22', '26 Muharram 1447 H', '04:33:00', '04:43:00', '05:55:00', '06:28:00', '12:00:00', '15:21:00', '17:57:00', '19:05:00', '2025-07-17 12:00:44'),
	(24, '2025-07-23', '27 Muharram 1447 H', '04:33:00', '04:43:00', '05:55:00', '06:28:00', '12:00:00', '15:21:00', '17:57:00', '19:05:00', '2025-07-17 12:00:45'),
	(25, '2025-07-24', '28 Muharram 1447 H', '04:33:00', '04:43:00', '05:55:00', '06:28:00', '12:00:00', '15:21:00', '17:57:00', '19:05:00', '2025-07-17 12:00:46'),
	(26, '2025-07-25', '29 Muharram 1447 H', '04:33:00', '04:43:00', '05:55:00', '06:28:00', '12:00:00', '15:21:00', '17:57:00', '19:05:00', '2025-07-17 12:00:46'),
	(27, '2025-07-26', '30 Muharram 1447 H', '04:33:00', '04:43:00', '05:55:00', '06:28:00', '12:00:00', '15:21:00', '17:57:00', '19:05:00', '2025-07-17 12:00:47'),
	(28, '2025-07-27', '1 Safar 1447 H', '04:33:00', '04:43:00', '05:55:00', '06:28:00', '12:00:00', '15:21:00', '17:58:00', '19:05:00', '2025-07-17 12:00:48'),
	(29, '2025-07-28', '2 Safar 1447 H', '04:33:00', '04:43:00', '05:55:00', '06:27:00', '12:00:00', '15:21:00', '17:58:00', '19:05:00', '2025-07-17 12:00:48'),
	(30, '2025-07-29', '3 Safar 1447 H', '04:33:00', '04:43:00', '05:55:00', '06:27:00', '12:00:00', '15:21:00', '17:58:00', '19:05:00', '2025-07-17 12:00:49'),
	(31, '2025-07-30', '4 Safar 1447 H', '04:33:00', '04:43:00', '05:54:00', '06:27:00', '12:00:00', '15:21:00', '17:58:00', '19:05:00', '2025-07-17 12:00:50'),
	(32, '2025-07-31', '5 Safar 1447 H', '04:33:00', '04:43:00', '05:54:00', '06:27:00', '12:00:00', '15:20:00', '17:58:00', '19:05:00', '2025-07-17 12:00:50');

-- Dumping structure for table smartmuadzzin.pengaturan
CREATE TABLE IF NOT EXISTS `pengaturan` (
  `kunci` varchar(50) NOT NULL,
  `nilai` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`kunci`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartmuadzzin.pengaturan: ~20 rows (approximately)
DELETE FROM `pengaturan`;
INSERT INTO `pengaturan` (`kunci`, `nilai`, `created_at`, `updated_at`) VALUES
	('alamat', 'Komp. Griya Saluyu, Mekarjaya, Kec. Racasari, Kota Bandung', '2025-07-17 16:34:27', '2025-07-17 16:40:03'),
	('durasi_ashar_adzan', '90', '2025-07-17 13:20:15', '2025-07-18 08:37:50'),
	('durasi_ashar_iqamah', '300', '2025-07-17 13:20:15', '2025-07-17 16:38:07'),
	('durasi_ashar_sholat', '600', '2025-07-17 13:20:15', '2025-07-17 13:20:15'),
	('durasi_dzuhur_adzan', '90', '2025-07-17 13:20:15', '2025-07-18 08:37:50'),
	('durasi_dzuhur_iqamah', '300', '2025-07-17 13:20:15', '2025-07-17 16:38:07'),
	('durasi_dzuhur_sholat', '600', '2025-07-17 13:20:15', '2025-07-17 13:20:15'),
	('durasi_isya_adzan', '90', '2025-07-17 13:20:15', '2025-07-18 08:37:50'),
	('durasi_isya_iqamah', '300', '2025-07-17 13:20:15', '2025-07-17 16:38:07'),
	('durasi_isya_sholat', '600', '2025-07-17 13:20:15', '2025-07-17 13:20:15'),
	('durasi_maghrib_adzan', '90', '2025-07-17 13:20:15', '2025-07-18 08:37:50'),
	('durasi_maghrib_iqamah', '300', '2025-07-17 13:20:15', '2025-07-17 16:38:07'),
	('durasi_maghrib_sholat', '600', '2025-07-17 13:20:15', '2025-07-17 13:20:15'),
	('durasi_shubuh_adzan', '90', '2025-07-17 13:20:15', '2025-07-18 08:37:50'),
	('durasi_shubuh_iqamah', '600', '2025-07-17 13:20:15', '2025-07-17 16:38:07'),
	('durasi_shubuh_sholat', '600', '2025-07-17 13:20:15', '2025-07-17 16:38:07'),
	('id_kota', '1219', '2025-07-02 09:55:50', '2025-07-02 09:57:17'),
	('last_sync', '2025-07-17 19:03:00', '2025-07-17 19:03:39', '2025-07-17 19:03:39'),
	('nama_masjid', 'Masjid Al-Ukhuwwah', '2025-07-02 09:19:15', '2025-07-17 16:34:27'),
	('running_text', 'Selamat datang di Masjid Al Ukhuwwah Griya Saluyu. Jaga kebersihan, rapatkan shaf, dan perbanyak dzikir.', '2025-07-02 09:19:15', '2025-07-02 09:19:15');

-- Dumping structure for table smartmuadzzin.posters
CREATE TABLE IF NOT EXISTS `posters` (
  `id` int NOT NULL AUTO_INCREMENT,
  `judul` varchar(100) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartmuadzzin.posters: ~0 rows (approximately)
DELETE FROM `posters`;

-- Dumping structure for table smartmuadzzin.running_text
CREATE TABLE IF NOT EXISTS `running_text` (
  `id` int NOT NULL AUTO_INCREMENT,
  `isi` text NOT NULL,
  `aktif` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table smartmuadzzin.running_text: ~2 rows (approximately)
DELETE FROM `running_text`;
INSERT INTO `running_text` (`id`, `isi`, `aktif`) VALUES
	(1, 'Kajian Malam Ini: Ustadz Ahmad | Ba\'da Maghrib | Tema: Menjadi Muslim Produktif', 1),
	(2, 'Donasi Masjid dapat disalurkan ke rekening BSI 123456789 a.n. DKM Fathul Baari', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
