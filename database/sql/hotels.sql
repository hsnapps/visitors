-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.37-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             10.2.0.5656
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table eosksaco_rsos.hotel_bookings
CREATE TABLE IF NOT EXISTS `hotel_bookings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `days` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2 Days',
  `price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table eosksaco_rsos.hotel_bookings: ~5 rows (approximately)
/*!40000 ALTER TABLE `hotel_bookings` DISABLE KEYS */;
INSERT INTO `hotel_bookings` (`id`, `days`, `price`, `created_at`, `updated_at`) VALUES
	(1, '1', 200.00, '2019-07-26 15:28:55', '2019-07-26 15:28:55'),
	(2, '2', 400.00, '2019-07-26 15:28:56', '2019-07-26 15:28:56'),
	(3, '3', 600.00, '2019-07-26 15:28:56', '2019-07-26 15:28:56'),
	(4, '4', 800.00, '2019-07-26 15:28:56', '2019-07-26 15:28:56'),
	(5, '5', 1000.00, '2019-07-26 15:28:56', '2019-07-26 15:28:56');
/*!40000 ALTER TABLE `hotel_bookings` ENABLE KEYS */;

-- Dumping structure for table eosksaco_rsos.hotel_booking_passport
CREATE TABLE IF NOT EXISTS `hotel_booking_passport` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hotel_booking_id` int(10) unsigned NOT NULL,
  `passport_id` int(10) unsigned NOT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT '0',
  `cancelled_by_visitor` tinyint(1) NOT NULL DEFAULT '0',
  `cancelled_by_provider` tinyint(1) NOT NULL DEFAULT '0',
  `used` tinyint(1) NOT NULL DEFAULT '0',
  `used_on` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hotel_booking_passport_hotel_booking_id_foreign` (`hotel_booking_id`),
  KEY `hotel_booking_passport_passport_id_foreign` (`passport_id`),
  CONSTRAINT `hotel_booking_passport_hotel_booking_id_foreign` FOREIGN KEY (`hotel_booking_id`) REFERENCES `hotel_bookings` (`id`),
  CONSTRAINT `hotel_booking_passport_passport_id_foreign` FOREIGN KEY (`passport_id`) REFERENCES `passports` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table eosksaco_rsos.hotel_booking_passport: ~0 rows (approximately)
/*!40000 ALTER TABLE `hotel_booking_passport` DISABLE KEYS */;
INSERT INTO `hotel_booking_passport` (`id`, `hotel_booking_id`, `passport_id`, `paid`, `cancelled_by_visitor`, `cancelled_by_provider`, `used`, `used_on`, `notes`, `created_at`, `updated_at`) VALUES
	(1, 2, 1, 0, 0, 0, 0, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `hotel_booking_passport` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
