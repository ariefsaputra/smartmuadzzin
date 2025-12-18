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

-- Dumping structure for table smartmuadzzin-v2.jadwal_sholat
CREATE TABLE IF NOT EXISTS `jadwal_sholat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `hijriyah` varchar(50) DEFAULT NULL,
  `subuh` time DEFAULT NULL,
  `imsak` time DEFAULT NULL,
  `syuruq` time DEFAULT NULL,
  `dhuha` time DEFAULT NULL,
  `dzuhur` time DEFAULT NULL,
  `ashar` time DEFAULT NULL,
  `maghrib` time DEFAULT NULL,
  `isya` time DEFAULT NULL,
  `source` varchar(50) DEFAULT 'local',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_tanggal` (`tanggal`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table smartmuadzzin-v2.jadwal_sholat: ~31 rows (approximately)
DELETE FROM `jadwal_sholat`;
INSERT INTO `jadwal_sholat` (`id`, `tanggal`, `hijriyah`, `subuh`, `imsak`, `syuruq`, `dhuha`, `dzuhur`, `ashar`, `maghrib`, `isya`, `source`, `created_at`) VALUES
	(1, '2025-12-01', '10 Jumadil Akhir 1447 H', '04:02:00', '03:52:00', '05:16:00', '05:49:00', '11:42:00', '15:07:00', '18:01:00', '19:12:00', 'myquran', '2025-12-03 02:07:27'),
	(2, '2025-12-02', '11 Jumadil Akhir 1447 H', '04:02:00', '03:52:00', '05:16:00', '05:50:00', '11:42:00', '15:07:00', '18:02:00', '19:12:00', 'myquran', '2025-12-03 02:07:27'),
	(3, '2025-12-03', '12 Jumadil Akhir 1447 H', '04:02:00', '03:52:00', '05:17:00', '05:50:00', '11:43:00', '15:08:00', '18:02:00', '19:13:00', 'myquran', '2025-12-03 02:07:28'),
	(4, '2025-12-04', '13 Jumadil Akhir 1447 H', '04:02:00', '03:52:00', '05:17:00', '05:50:00', '11:43:00', '15:08:00', '18:02:00', '19:13:00', 'myquran', '2025-12-03 02:07:28'),
	(5, '2025-12-05', '14 Jumadil Akhir 1447 H', '04:03:00', '03:53:00', '05:17:00', '05:51:00', '11:44:00', '15:09:00', '18:03:00', '19:14:00', 'myquran', '2025-12-03 02:07:29'),
	(6, '2025-12-06', '15 Jumadil Akhir 1447 H', '04:03:00', '03:53:00', '05:18:00', '05:51:00', '11:44:00', '15:09:00', '18:03:00', '19:14:00', 'myquran', '2025-12-03 02:07:29'),
	(7, '2025-12-07', '16 Jumadil Akhir 1447 H', '04:03:00', '03:53:00', '05:18:00', '05:51:00', '11:44:00', '15:10:00', '18:04:00', '19:15:00', 'myquran', '2025-12-03 02:07:30'),
	(8, '2025-12-08', '17 Jumadil Akhir 1447 H', '04:03:00', '03:53:00', '05:18:00', '05:52:00', '11:45:00', '15:11:00', '18:04:00', '19:16:00', 'myquran', '2025-12-03 02:07:30'),
	(9, '2025-12-09', '18 Jumadil Akhir 1447 H', '04:04:00', '03:54:00', '05:19:00', '05:52:00', '11:45:00', '15:11:00', '18:05:00', '19:16:00', 'myquran', '2025-12-03 02:07:31'),
	(10, '2025-12-10', '19 Jumadil Akhir 1447 H', '04:04:00', '03:54:00', '05:19:00', '05:53:00', '11:46:00', '15:12:00', '18:05:00', '19:17:00', 'myquran', '2025-12-03 02:07:31'),
	(11, '2025-12-11', '20 Jumadil Akhir 1447 H', '04:04:00', '03:54:00', '05:20:00', '05:53:00', '11:46:00', '15:12:00', '18:06:00', '19:17:00', 'myquran', '2025-12-03 02:07:32'),
	(12, '2025-12-12', '21 Jumadil Akhir 1447 H', '04:05:00', '03:55:00', '05:20:00', '05:53:00', '11:47:00', '15:13:00', '18:07:00', '19:18:00', 'myquran', '2025-12-03 02:07:32'),
	(13, '2025-12-13', '22 Jumadil Akhir 1447 H', '04:05:00', '03:55:00', '05:20:00', '05:54:00', '11:47:00', '15:13:00', '18:07:00', '19:18:00', 'myquran', '2025-12-03 02:07:33'),
	(14, '2025-12-14', '23 Jumadil Akhir 1447 H', '04:05:00', '03:55:00', '05:21:00', '05:54:00', '11:48:00', '15:14:00', '18:08:00', '19:19:00', 'myquran', '2025-12-03 02:07:33'),
	(15, '2025-12-15', '24 Jumadil Akhir 1447 H', '04:06:00', '03:56:00', '05:21:00', '05:55:00', '11:48:00', '15:14:00', '18:08:00', '19:19:00', 'myquran', '2025-12-03 02:07:34'),
	(16, '2025-12-16', '25 Jumadil Akhir 1447 H', '04:06:00', '03:56:00', '05:22:00', '05:55:00', '11:49:00', '15:15:00', '18:09:00', '19:20:00', 'myquran', '2025-12-03 02:07:34'),
	(17, '2025-12-17', '26 Jumadil Akhir 1447 H', '04:07:00', '03:57:00', '05:22:00', '05:56:00', '11:49:00', '15:15:00', '18:09:00', '19:20:00', 'myquran', '2025-12-03 02:07:35'),
	(18, '2025-12-18', '27 Jumadil Akhir 1447 H', '04:07:00', '03:57:00', '05:23:00', '05:56:00', '11:50:00', '15:16:00', '18:10:00', '19:21:00', 'myquran', '2025-12-03 02:07:35'),
	(19, '2025-12-19', '28 Jumadil Akhir 1447 H', '04:08:00', '03:58:00', '05:23:00', '05:57:00', '11:50:00', '15:16:00', '18:10:00', '19:22:00', 'myquran', '2025-12-03 02:07:36'),
	(20, '2025-12-20', '29 Jumadil Akhir 1447 H', '04:08:00', '03:58:00', '05:24:00', '05:57:00', '11:51:00', '15:17:00', '18:11:00', '19:22:00', 'myquran', '2025-12-03 02:07:36'),
	(21, '2025-12-21', '1 Rajab 1447 H', '04:09:00', '03:59:00', '05:24:00', '05:58:00', '11:51:00', '15:18:00', '18:11:00', '19:23:00', 'myquran', '2025-12-03 02:07:37'),
	(22, '2025-12-22', '2 Rajab 1447 H', '04:09:00', '03:59:00', '05:25:00', '05:58:00', '11:52:00', '15:18:00', '18:12:00', '19:23:00', 'myquran', '2025-12-03 02:07:37'),
	(23, '2025-12-23', '3 Rajab 1447 H', '04:10:00', '04:00:00', '05:25:00', '05:59:00', '11:52:00', '15:19:00', '18:12:00', '19:24:00', 'myquran', '2025-12-03 02:07:37'),
	(24, '2025-12-24', '4 Rajab 1447 H', '04:10:00', '04:00:00', '05:26:00', '05:59:00', '11:53:00', '15:19:00', '18:13:00', '19:24:00', 'myquran', '2025-12-03 02:07:38'),
	(25, '2025-12-25', '5 Rajab 1447 H', '04:11:00', '04:01:00', '05:26:00', '06:00:00', '11:53:00', '15:19:00', '18:13:00', '19:24:00', 'myquran', '2025-12-03 02:07:38'),
	(26, '2025-12-26', '6 Rajab 1447 H', '04:11:00', '04:01:00', '05:27:00', '06:00:00', '11:54:00', '15:20:00', '18:14:00', '19:25:00', 'myquran', '2025-12-03 02:07:39'),
	(27, '2025-12-27', '7 Rajab 1447 H', '04:12:00', '04:02:00', '05:27:00', '06:01:00', '11:54:00', '15:20:00', '18:14:00', '19:25:00', 'myquran', '2025-12-03 02:07:39'),
	(28, '2025-12-28', '8 Rajab 1447 H', '04:12:00', '04:02:00', '05:28:00', '06:01:00', '11:55:00', '15:21:00', '18:14:00', '19:26:00', 'myquran', '2025-12-03 02:07:40'),
	(29, '2025-12-29', '9 Rajab 1447 H', '04:13:00', '04:03:00', '05:28:00', '06:02:00', '11:55:00', '15:21:00', '18:15:00', '19:26:00', 'myquran', '2025-12-03 02:07:40'),
	(30, '2025-12-30', '10 Rajab 1447 H', '04:13:00', '04:03:00', '05:29:00', '06:02:00', '11:56:00', '15:22:00', '18:15:00', '19:27:00', 'myquran', '2025-12-03 02:07:41'),
	(31, '2025-12-31', '11 Rajab 1447 H', '04:14:00', '04:04:00', '05:29:00', '06:03:00', '11:56:00', '15:22:00', '18:16:00', '19:27:00', 'myquran', '2025-12-03 02:07:41');

-- Dumping structure for table smartmuadzzin-v2.media_slider
CREATE TABLE IF NOT EXISTS `media_slider` (
  `id` int NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `type` enum('image','video') DEFAULT 'image',
  `caption` varchar(255) DEFAULT NULL,
  `ordering` int DEFAULT '0',
  `duration` int NOT NULL DEFAULT '6000',
  `enabled` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table smartmuadzzin-v2.media_slider: ~0 rows (approximately)
DELETE FROM `media_slider`;

-- Dumping structure for table smartmuadzzin-v2.pengaturan
CREATE TABLE IF NOT EXISTS `pengaturan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `keyname` varchar(100) DEFAULT NULL,
  `value` text,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `keyname` (`keyname`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table smartmuadzzin-v2.pengaturan: ~19 rows (approximately)
DELETE FROM `pengaturan`;
INSERT INTO `pengaturan` (`id`, `keyname`, `value`, `updated_at`) VALUES
	(1, 'lokasi_lat', '-6.914744', '2025-11-27 03:44:53'),
	(2, 'lokasi_lng', '107.609810', '2025-11-27 03:44:53'),
	(3, 'durasi_iqamah_subuh', '5', '2025-11-27 03:44:53'),
	(4, 'durasi_iqamah_dzuhur', '10', '2025-11-27 03:44:53'),
	(5, 'durasi_iqamah_ashar', '10', '2025-11-27 03:44:53'),
	(6, 'durasi_iqamah_maghrib', '5', '2025-11-27 03:44:53'),
	(7, 'durasi_iqamah_isya', '10', '2025-11-27 03:44:53'),
	(8, 'audio_adzan', '0', '2025-11-27 03:44:53'),
	(9, 'theme', 'default', '2025-11-27 03:44:53'),
	(10, 'nama_masjid', 'Masjid Al Ukhuwwah Griya Saluyu', '2025-11-27 06:25:47'),
	(11, 'alamat_masjid', 'Komp. Griya Saluyu, Rancasari', '2025-11-27 22:19:29'),
	(12, 'kode_kota', '1219', '2025-11-27 05:50:09'),
	(13, 'nama_kota', 'KOTA BANDUNG', '2025-11-27 06:25:47'),
	(14, 'running_text', 'Dukung operasional DKM Al Ukhuwwah. Donasi: Muamalat 1010106464 (DKM Al Ukhuwwah GS) | Jago Syariah 501010697891 (Dicky Nurdiansyah)', '2025-12-12 03:18:50'),
	(15, 'durasi_menjelang_adzan', '600', '2025-11-28 22:27:51'),
	(16, 'durasi_adzan', '240', '2025-11-28 22:27:51'),
	(17, 'durasi_menjelang_iqamah', '300', '2025-11-28 22:27:51'),
	(18, 'durasi_waktu_sholat', '600', '2025-11-28 22:27:51'),
	(19, 'durasi_khutbah_jumat', '1200', '2025-11-28 22:27:51');

-- Dumping structure for table smartmuadzzin-v2.pengumuman
CREATE TABLE IF NOT EXISTS `pengumuman` (
  `id` int NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) DEFAULT NULL,
  `isi` text,
  `kategori` enum('keuangan_jumat','imam_khatib','umum') DEFAULT 'umum',
  `mulai` datetime DEFAULT NULL,
  `sampai` datetime DEFAULT NULL,
  `durasi` int DEFAULT '8000',
  `enabled` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table smartmuadzzin-v2.pengumuman: ~1 rows (approximately)
DELETE FROM `pengumuman`;
INSERT INTO `pengumuman` (`id`, `judul`, `isi`, `kategori`, `mulai`, `sampai`, `durasi`, `enabled`, `created_at`) VALUES
	(2, 'Laporan Jumat Per 5 Desember 2025', 'Saldo Jumat pekan lalu=Rp 3.021.020,-\r\nTotal Penerimaan=Rp 1.896.000,-\r\nTotal Pengeluaran=Rp 2.286.500,-\r\nSaldo per 05 Desember 2025=Rp 2.630.520,-', 'keuangan_jumat', '2025-12-04 09:42:00', '2025-12-12 09:42:00', 30000, 1, '2025-12-08 09:43:05');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
