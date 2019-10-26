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


-- Dumping database structure for eosksaco_visitors
DROP DATABASE IF EXISTS `eosksaco_visitors`;
CREATE DATABASE IF NOT EXISTS `eosksaco_visitors` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `eosksaco_visitors`;

-- Dumping structure for table eosksaco_visitors.carts
CREATE TABLE IF NOT EXISTS `carts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `passport_id` int(10) unsigned NOT NULL,
  `item_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Either courses or wetlabs',
  `item_id` int(10) unsigned NOT NULL COMMENT 'The record id in the tables courses or wetlabs',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `starts_on` date DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `days` int(11) NOT NULL DEFAULT '1',
  `expiration_date` date NOT NULL,
  `checkout_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carts_passport_id_foreign` (`passport_id`),
  CONSTRAINT `carts_passport_id_foreign` FOREIGN KEY (`passport_id`) REFERENCES `passports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table eosksaco_visitors.carts: ~2 rows (approximately)
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` (`id`, `passport_id`, `item_type`, `item_id`, `title`, `starts_on`, `price`, `days`, `expiration_date`, `checkout_id`, `created_at`, `updated_at`) VALUES
	(30, 4, 'wetlabs', 4, 'WetLab D', '2019-09-03', 1000.00, 5, '2019-08-21', NULL, '2019-08-19 16:17:58', '2019-08-19 16:17:58'),
	(31, 4, 'wetlabs', 7, 'WetLab G', '2019-12-30', 1000.00, 1, '2019-08-21', NULL, '2019-08-19 16:17:58', '2019-08-19 16:17:58');
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;

-- Dumping structure for table eosksaco_visitors.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table eosksaco_visitors.categories: ~4 rows (approximately)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `name`) VALUES
	(1, 'Doctors'),
	(2, 'Nurses'),
	(3, 'Students'),
	(4, 'Academics');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Dumping structure for table eosksaco_visitors.category_course
CREATE TABLE IF NOT EXISTS `category_course` (
  `category_id` int(10) unsigned NOT NULL,
  `course_id` int(10) unsigned NOT NULL,
  KEY `category_course_course_id_foreign` (`course_id`),
  KEY `category_course_category_id_foreign` (`category_id`),
  CONSTRAINT `category_course_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `category_course_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table eosksaco_visitors.category_course: ~11 rows (approximately)
/*!40000 ALTER TABLE `category_course` DISABLE KEYS */;
INSERT INTO `category_course` (`category_id`, `course_id`) VALUES
	(2, 1),
	(2, 2),
	(2, 3),
	(2, 4),
	(2, 5),
	(2, 6),
	(3, 6),
	(1, 7),
	(3, 7),
	(1, 8),
	(3, 8);
/*!40000 ALTER TABLE `category_course` ENABLE KEYS */;

-- Dumping structure for table eosksaco_visitors.category_wet_lab
CREATE TABLE IF NOT EXISTS `category_wet_lab` (
  `category_id` int(10) unsigned NOT NULL,
  `wet_lab_id` int(10) unsigned NOT NULL,
  KEY `category_wet_lab_wet_lab_id_foreign` (`wet_lab_id`),
  KEY `category_wet_lab_category_id_foreign` (`category_id`),
  CONSTRAINT `category_wet_lab_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `category_wet_lab_wet_lab_id_foreign` FOREIGN KEY (`wet_lab_id`) REFERENCES `wet_labs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table eosksaco_visitors.category_wet_lab: ~16 rows (approximately)
/*!40000 ALTER TABLE `category_wet_lab` DISABLE KEYS */;
INSERT INTO `category_wet_lab` (`category_id`, `wet_lab_id`) VALUES
	(1, 1),
	(3, 1),
	(1, 2),
	(3, 2),
	(1, 3),
	(3, 3),
	(1, 4),
	(3, 4),
	(1, 5),
	(3, 5),
	(1, 6),
	(3, 6),
	(1, 7),
	(3, 7),
	(1, 8),
	(3, 8);
/*!40000 ALTER TABLE `category_wet_lab` ENABLE KEYS */;

-- Dumping structure for table eosksaco_visitors.courses
CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seats` int(11) NOT NULL DEFAULT '50',
  `starts_on` date NOT NULL,
  `days` int(11) NOT NULL DEFAULT '1' COMMENT 'Course duration in days',
  `price` decimal(8,2) NOT NULL DEFAULT '1000.00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `courses_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table eosksaco_visitors.courses: ~8 rows (approximately)
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` (`id`, `name`, `seats`, `starts_on`, `days`, `price`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'Course A', 1442, '2019-11-24', 3, 1.00, NULL, '2019-07-29 12:25:32', '2019-07-29 15:10:57'),
	(2, 'Course B', 551, '2020-11-04', 3, 2.00, NULL, '2019-07-29 12:25:32', '2019-07-29 15:10:57'),
	(3, 'Course C', 828, '2018-01-10', 1, 3.00, NULL, '2019-07-29 12:25:32', '2019-07-29 15:10:57'),
	(4, 'Course D', 506, '2020-04-21', 2, 4.00, NULL, '2019-07-29 12:25:32', '2019-07-29 15:10:57'),
	(5, 'Course E', 1012, '2019-09-22', 2, 5.00, NULL, '2019-07-29 12:25:32', '2019-07-29 15:10:58'),
	(6, 'Course F', 717, '2020-05-30', 2, 1.00, NULL, '2019-07-29 12:25:32', '2019-08-18 20:45:54'),
	(7, 'Course G', 1977, '2019-08-22', 4, 1.00, NULL, '2019-07-29 12:25:32', '2019-08-18 17:16:00'),
	(8, 'Course H', 1560, '2019-07-30', 5, 7.00, NULL, '2019-07-29 12:25:32', '2019-07-29 15:10:58');
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;

-- Dumping structure for table eosksaco_visitors.course_passport
CREATE TABLE IF NOT EXISTS `course_passport` (
  `course_id` int(10) unsigned NOT NULL,
  `passport_id` int(10) unsigned NOT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT '0',
  `cancelled_by_visitor` tinyint(1) NOT NULL DEFAULT '0',
  `cancelled_by_provider` tinyint(1) NOT NULL DEFAULT '0',
  `attended` tinyint(1) NOT NULL DEFAULT '0',
  KEY `course_passport_course_id_foreign` (`course_id`),
  KEY `course_passport_passport_id_foreign` (`passport_id`),
  CONSTRAINT `course_passport_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  CONSTRAINT `course_passport_passport_id_foreign` FOREIGN KEY (`passport_id`) REFERENCES `passports` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table eosksaco_visitors.course_passport: ~3 rows (approximately)
/*!40000 ALTER TABLE `course_passport` DISABLE KEYS */;
INSERT INTO `course_passport` (`course_id`, `passport_id`, `paid`, `cancelled_by_visitor`, `cancelled_by_provider`, `attended`) VALUES
	(7, 4, 0, 0, 0, 0),
	(7, 5, 0, 0, 0, 0),
	(6, 4, 0, 0, 0, 0);
/*!40000 ALTER TABLE `course_passport` ENABLE KEYS */;

-- Dumping structure for table eosksaco_visitors.hotel_bookings
CREATE TABLE IF NOT EXISTS `hotel_bookings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `room_id` int(10) unsigned NOT NULL DEFAULT '1',
  `days` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2 Days',
  `price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table eosksaco_visitors.hotel_bookings: ~5 rows (approximately)
/*!40000 ALTER TABLE `hotel_bookings` DISABLE KEYS */;
INSERT INTO `hotel_bookings` (`id`, `room_id`, `days`, `price`, `created_at`, `updated_at`) VALUES
	(1, 1, '1', 250.00, '2019-07-29 12:27:39', '2019-07-29 12:27:39'),
	(2, 1, '2', 500.00, '2019-07-29 12:27:39', '2019-07-29 12:27:39'),
	(3, 1, '3', 750.00, '2019-07-29 12:27:39', '2019-07-29 12:27:39'),
	(4, 1, '4', 1000.00, '2019-07-29 12:27:40', '2019-07-29 12:27:40'),
	(5, 1, '5', 1250.00, '2019-07-29 12:27:40', '2019-07-29 12:27:40');
/*!40000 ALTER TABLE `hotel_bookings` ENABLE KEYS */;

-- Dumping structure for table eosksaco_visitors.hotel_booking_passport
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table eosksaco_visitors.hotel_booking_passport: ~2 rows (approximately)
/*!40000 ALTER TABLE `hotel_booking_passport` DISABLE KEYS */;
INSERT INTO `hotel_booking_passport` (`id`, `hotel_booking_id`, `passport_id`, `paid`, `cancelled_by_visitor`, `cancelled_by_provider`, `used`, `used_on`, `notes`, `created_at`, `updated_at`) VALUES
	(1, 1, 3, 0, 0, 0, 0, NULL, NULL, NULL, NULL),
	(2, 2, 3, 0, 0, 0, 0, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `hotel_booking_passport` ENABLE KEYS */;

-- Dumping structure for table eosksaco_visitors.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table eosksaco_visitors.migrations: ~27 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2019_04_12_091042_create_passports_table', 1),
	(2, '2019_04_13_105220_create_courses_table', 1),
	(3, '2019_04_13_105244_create_wet_labs_table', 1),
	(4, '2019_04_13_105951_create_course_passport_table', 1),
	(5, '2019_04_13_114216_create_passport_wetlab_table', 1),
	(6, '2019_04_13_130937_course_passport_many_to_many', 1),
	(7, '2019_04_13_131223_passport_wetlab_many_to_many', 1),
	(8, '2019_04_14_064046_create_carts_table', 1),
	(9, '2019_04_16_132406_create_orders_table', 1),
	(10, '2019_04_16_132407_create_payments_table', 1),
	(11, '2019_04_18_085841_alter_payment_table', 1),
	(12, '2019_04_18_091804_remove_checkout_id_from_orders', 1),
	(13, '2019_04_19_193054_remove_order_id_from_payments', 1),
	(14, '2019_04_20_093113_create_order_items_table', 1),
	(15, '2019_04_20_094611_remove_checkout_from_orders', 1),
	(16, '2019_04_20_103657_alter_payment_result_description', 1),
	(17, '2019_07_25_234928_create_hotel_bookings_table', 1),
	(18, '2019_07_25_235402_create_hotel_passport_table', 1),
	(19, '2019_07_26_161414_set_starts_on_nullable', 1),
	(20, '2019_07_29_045258_create_passport_titles_table', 2),
	(21, '2019_07_29_050210_add_passport_title_id', 2),
	(22, '2019_07_29_052027_add_course_category', 2),
	(24, '2019_07_29_063202_remove_category', 3),
	(27, '2019_07_29_063526_create_table_category_course', 4),
	(28, '2019_07_29_063546_create_table_category_wet_lab', 4),
	(29, '2019_07_30_061830_create_categories_table', 5),
	(30, '2019_07_30_064528_add_avater_to_passport', 6),
	(31, '2019_08_20_160055_create_rooms_table', 7),
	(32, '2019_08_20_161619_add_room_category_to_hotel_bookings', 7);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table eosksaco_visitors.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `passport_id` int(10) unsigned NOT NULL,
  `payment_id` bigint(20) unsigned NOT NULL,
  `subtotal` decimal(8,2) NOT NULL,
  `vat` decimal(8,2) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_passport_id_foreign` (`passport_id`),
  KEY `orders_payment_id_foreign` (`payment_id`),
  CONSTRAINT `orders_passport_id_foreign` FOREIGN KEY (`passport_id`) REFERENCES `passports` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table eosksaco_visitors.orders: ~8 rows (approximately)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`id`, `passport_id`, `payment_id`, `subtotal`, `vat`, `amount`, `status`, `created_at`, `updated_at`) VALUES
	(1, 3, 1, 1000.00, 50.00, 1050.00, 1, '2019-07-30 14:28:37', '2019-07-30 14:28:37'),
	(2, 3, 2, 1000.00, 50.00, 1050.00, 1, '2019-07-30 14:29:38', '2019-07-30 14:29:38'),
	(3, 3, 3, 250.00, 12.50, 262.50, 1, '2019-07-30 14:31:44', '2019-07-30 14:31:44'),
	(4, 3, 4, 500.00, 25.00, 525.00, 1, '2019-07-30 14:32:17', '2019-07-30 14:32:17'),
	(5, 3, 5, 2000.00, 100.00, 560.00, 1, '2019-07-31 13:10:11', '2019-07-31 13:10:11'),
	(6, 1, 6, 1.00, 0.05, 1.05, 1, '2019-08-04 21:28:59', '2019-08-04 21:28:59'),
	(7, 4, 7, 1.00, 0.05, 1.05, 1, '2019-08-18 16:46:04', '2019-08-18 16:46:04'),
	(11, 5, 17, 1.00, 0.05, 1.05, 1, '2019-08-18 20:45:54', '2019-08-18 20:45:54'),
	(12, 1, 20, 500.00, 25.00, 525.00, 1, '2019-08-20 18:46:22', '2019-08-20 18:46:22');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

-- Dumping structure for table eosksaco_visitors.order_items
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `item_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `item_price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table eosksaco_visitors.order_items: ~9 rows (approximately)
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` (`id`, `order_id`, `item_type`, `item_name`, `item_id`, `item_price`, `created_at`, `updated_at`) VALUES
	(1, 1, 'courses', 'Course F', 6, 1000.00, '2019-07-30 14:28:37', '2019-07-30 14:28:37'),
	(2, 2, 'wetlabs', 'WetLab G', 7, 1000.00, '2019-07-30 14:29:38', '2019-07-30 14:29:38'),
	(3, 3, 'booking', '1 Days', 1, 250.00, '2019-07-30 14:31:44', '2019-07-30 14:31:44'),
	(4, 4, 'booking', '2 Days', 2, 500.00, '2019-07-30 14:32:17', '2019-07-30 14:32:17'),
	(5, 5, 'wetlabs', 'WetLab C', 3, 1000.00, '2019-07-31 13:10:11', '2019-07-31 13:10:11'),
	(6, 5, 'wetlabs', 'WetLab E', 5, 1000.00, '2019-07-31 13:10:11', '2019-07-31 13:10:11'),
	(7, 6, 'courses', 'Course G', 7, 1.00, '2019-08-04 21:28:59', '2019-08-04 21:28:59'),
	(8, 7, 'courses', 'Course G', 7, 1.00, '2019-08-18 16:46:04', '2019-08-18 16:46:04'),
	(12, 11, 'courses', 'Course F', 6, 1.00, '2019-08-18 20:45:54', '2019-08-18 20:45:54'),
	(13, 12, 'booking', '2 Days', 2, 500.00, '2019-08-20 18:46:22', '2019-08-20 18:46:22');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;

-- Dumping structure for table eosksaco_visitors.passports
CREATE TABLE IF NOT EXISTS `passports` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL DEFAULT '0',
  `admin_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(10) unsigned NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_place` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bar_code` text COLLATE utf8mb4_unicode_ci,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profession` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `specialist` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sfch_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sfch_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_recipt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expire_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `payment` tinyint(1) NOT NULL DEFAULT '0',
  `conference_reg` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wet_lab_reg` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_of_payment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '$2y$10$w.hH0Szbmsi4Gx9UXvsfW.jGQTYPvr08ay3Q5RphctUYQdq7031aq',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `passports_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table eosksaco_visitors.passports: ~5 rows (approximately)
/*!40000 ALTER TABLE `passports` DISABLE KEYS */;
INSERT INTO `passports` (`id`, `event_id`, `admin_id`, `category_id`, `first_name`, `middle_name`, `last_name`, `work_place`, `country`, `bar_code`, `code`, `amount`, `mobile_no`, `profession`, `specialist`, `sfch_number`, `sfch_image`, `bank_recipt`, `email`, `expire_date`, `approved`, `payment`, `conference_reg`, `wet_lab_reg`, `type_of_payment`, `status`, `password`, `remember_token`, `created_at`, `updated_at`, `avatar`) VALUES
	(1, 1, 1, 1, 'Hassan', NULL, 'Baabdullah', 'KFAFAH', 'SA', NULL, NULL, NULL, '966569163852', 'BCS, PMP', NULL, NULL, NULL, NULL, 'prog.hasan@gmail.com', NULL, 0, 0, NULL, NULL, NULL, NULL, '$2y$10$EDug9wKHFjQhRp.i9wwcr.X/uTwgg6hajzTuF8N3nU2AtafA/u072', '7OXcINRKYjtQ57Sx5bSPzu9W47n8m5CS9bfJEougJNRVgwkQpnLv2adsu8Rt', '2019-07-29 12:25:32', '2019-08-20 19:10:14', '5jc7ILOyqnLsL4KHOY8q'),
	(2, 1, 1, 2, 'Alf', NULL, 'Rutherford', 'Shields, Nikolaus and Terry', 'SA', NULL, NULL, NULL, '+1-598-567-1047', 'culpa qui', NULL, NULL, NULL, NULL, 'little.aileen@yahoo.com', NULL, 0, 0, NULL, NULL, NULL, NULL, '$2y$10$c9dr9XtS/mhePwtkwZR1reyeUJo516OU2YvlWaaOffd0rt257D1WS', '6AZ05URTvj47VXAfOFAB0AgHP1EZ68rTfwSHKIDd9dqzwr6I1ywluLCevxkB', '2019-07-29 12:25:32', '2019-07-30 14:05:03', 'eejm1BbwFmUXQ1l1cDNN'),
	(3, 1, 1, 3, 'Mac', NULL, 'McKenzie', 'O\'Conner, Graham and Maggio', 'SA', NULL, NULL, NULL, '1-645-534-9148 x32285', 'voluptas soluta', NULL, NULL, NULL, NULL, 'jamal.swe1987@gmail.com', NULL, 0, 0, NULL, NULL, NULL, NULL, '$2y$10$FSqFe.cvrQS24sSRb8k6l.RPJB7dRH/WltsCJsAx8RWlY59LPm/r2', 'edJngDI5mr2xsoZr80V5TOJqPIQsGURqZD322Gr3DGzczbIZIUxkMtzxv6iK', '2019-07-29 12:25:32', '2019-07-31 13:07:44', 'cY6TMIb7Rr7anQCatTRY'),
	(4, 1, 1, 3, 'Salem', NULL, 'Aljohari', 'LivePresentation', 'SA', '', '', '', '22222222222', 'Manager', '', '', '', '', 'salem@livepresentation.net', '', 0, 0, '', '', '', '', '$2y$10$FSqFe.cvrQS24sSRb8k6l.RPJB7dRH/WltsCJsAx8RWlY59LPm/r2', 'OVc9JX07F5FWV1y5lVJzlKos11v5hpHyd1tGg1Cq5jfaPEgdTUQuLWXEiIM9', '2019-07-29 12:25:32', '2019-08-18 16:19:32', 'ikC8zxIXYNFld9GIb0Ch'),
	(5, 1, 1, 3, 'Alaa', '', 'Alshemiri', 'LivePresentation', 'SA', '', '', '', '5555555555', 'Manager', '', '', '', '', 'ar.za.q@hotmail.com', '', 0, 0, '', '', '', '', '$2y$10$FSqFe.cvrQS24sSRb8k6l.RPJB7dRH/WltsCJsAx8RWlY59LPm/r2', 'jonOZAgzO2MKWnWGJYJJJFeWbBM9SdiszjVsQaPTb9wNoMheWamT2Gs9nXIn', '2019-07-29 12:25:32', '2019-08-18 16:19:32', '');
/*!40000 ALTER TABLE `passports` ENABLE KEYS */;

-- Dumping structure for table eosksaco_visitors.passport_titles
CREATE TABLE IF NOT EXISTS `passport_titles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table eosksaco_visitors.passport_titles: ~3 rows (approximately)
/*!40000 ALTER TABLE `passport_titles` DISABLE KEYS */;
INSERT INTO `passport_titles` (`id`, `name`) VALUES
	(1, 'Phd.'),
	(2, 'Dr.'),
	(3, 'Std.');
/*!40000 ALTER TABLE `passport_titles` ENABLE KEYS */;

-- Dumping structure for table eosksaco_visitors.passport_wetlab
CREATE TABLE IF NOT EXISTS `passport_wetlab` (
  `wetlab_id` int(10) unsigned NOT NULL,
  `passport_id` int(10) unsigned NOT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT '0',
  `cancelled_by_visitor` tinyint(1) NOT NULL DEFAULT '0',
  `cancelled_by_provider` tinyint(1) NOT NULL DEFAULT '0',
  `attended` tinyint(1) NOT NULL DEFAULT '0',
  KEY `passport_wetlab_wetlab_id_foreign` (`wetlab_id`),
  KEY `passport_wetlab_passport_id_foreign` (`passport_id`),
  CONSTRAINT `passport_wetlab_passport_id_foreign` FOREIGN KEY (`passport_id`) REFERENCES `passports` (`id`),
  CONSTRAINT `passport_wetlab_wetlab_id_foreign` FOREIGN KEY (`wetlab_id`) REFERENCES `wet_labs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table eosksaco_visitors.passport_wetlab: ~3 rows (approximately)
/*!40000 ALTER TABLE `passport_wetlab` DISABLE KEYS */;
INSERT INTO `passport_wetlab` (`wetlab_id`, `passport_id`, `paid`, `cancelled_by_visitor`, `cancelled_by_provider`, `attended`) VALUES
	(7, 3, 0, 0, 0, 0),
	(3, 3, 0, 0, 0, 0),
	(5, 3, 0, 0, 0, 0);
/*!40000 ALTER TABLE `passport_wetlab` ENABLE KEYS */;

-- Dumping structure for table eosksaco_visitors.payments
CREATE TABLE IF NOT EXISTS `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `passport_id` int(10) unsigned NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `online` tinyint(1) NOT NULL DEFAULT '1',
  `card_type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_holder` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_expiration` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'mm / yy',
  `card_last_4` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_result_id` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_result_code` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_result_description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_passport_id_foreign` (`passport_id`),
  CONSTRAINT `payments_passport_id_foreign` FOREIGN KEY (`passport_id`) REFERENCES `passports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table eosksaco_visitors.payments: ~11 rows (approximately)
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` (`id`, `passport_id`, `amount`, `online`, `card_type`, `card_holder`, `card_expiration`, `card_last_4`, `currency`, `payment_result_id`, `payment_result_code`, `payment_result_description`, `created_at`, `updated_at`) VALUES
	(1, 3, 1050.00, 1, 'VISA', 'HASSAN BAABDULLAH', '01-2022', '9011', 'EUR', '8ac7a4a16c2ec488016c41c7df015434', '000.100.110', 'Request successfully processed in \'Merchant in Integrator Test Mode\'', '2019-07-30 14:28:37', '2019-07-30 14:28:37'),
	(2, 3, 1050.00, 1, 'VISA', 'HASSAN BAABDULLAH', '01-2022', '9011', 'EUR', '8ac7a49f6c2eca3d016c41c8cf3a5374', '000.100.110', 'Request successfully processed in \'Merchant in Integrator Test Mode\'', '2019-07-30 14:29:38', '2019-07-30 14:29:38'),
	(3, 3, 262.50, 1, 'VISA', 'HASSAN BAABDULLAH', '01-2022', '9011', 'EUR', '8ac7a49f6c2eca3d016c41cabd345b61', '000.100.110', 'Request successfully processed in \'Merchant in Integrator Test Mode\'', '2019-07-30 14:31:44', '2019-07-30 14:31:44'),
	(4, 3, 525.00, 1, 'VISA', 'HASSAN BAABDULLAH', '01-2022', '9011', 'EUR', '8ac7a4a16c2ec488016c41cb3d2661f0', '000.100.110', 'Request successfully processed in \'Merchant in Integrator Test Mode\'', '2019-07-30 14:32:17', '2019-07-30 14:32:17'),
	(5, 3, 560.00, 1, 'VISA', 'HASSAN BAABDULLAH', '05-2022', '5070', 'USD', '8ac7a49f6c430b5e016c46a675017ffa', '000.100.112', 'Request successfully processed in \'Merchant in Connector Test Mode\'', '2019-07-31 13:10:11', '2019-07-31 13:10:11'),
	(6, 1, 1.05, 1, 'VISA', 'HASSAN BAABDULLAH', '01-2022', '9011', 'SAR', '8ac9a4a36c482eca016c5c63c337249b', '000.000.000', 'Transaction succeeded', '2019-08-04 21:28:59', '2019-08-04 21:28:59'),
	(7, 4, 1.05, 1, 'VISA', 'HASSAN AHMED', '01-2022', '6129', 'SAR', '8ac9a4a76c8b5d18016ca379c3c54c3c', '000.000.000', 'Transaction succeeded', '2019-08-18 16:46:04', '2019-08-18 16:46:04'),
	(17, 5, 1.05, 1, 'VISA', 'HASSAN AHMED', '01-2022', '6129', 'SAR', '8ac9a4a76c8b5d18016ca45494d1289e', '000.000.000', 'Transaction succeeded', '2019-08-18 20:45:54', '2019-08-18 20:45:54'),
	(18, 1, 0.00, 1, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '200.300.404', 'invalid or missing parameter', '2019-08-20 18:31:42', '2019-08-20 18:31:42'),
	(19, 1, 0.00, 1, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '200.300.404', 'invalid or missing parameter', '2019-08-20 18:43:14', '2019-08-20 18:43:14'),
	(20, 1, 525.00, 1, 'VISA', 'HASSAN BAABDULLAH', '01-2022', '9011', 'EUR', '8ac7a49f6caf1eba016cafb52c2c526c', '000.100.110', 'Request successfully processed in \'Merchant in Integrator Test Mode\'', '2019-08-20 18:46:22', '2019-08-20 18:46:22');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;

-- Dumping structure for table eosksaco_visitors.rooms
CREATE TABLE IF NOT EXISTS `rooms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table eosksaco_visitors.rooms: ~0 rows (approximately)
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` (`id`, `category`, `count`) VALUES
	(1, 'STANDARD', 99);
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;

-- Dumping structure for table eosksaco_visitors.wet_labs
CREATE TABLE IF NOT EXISTS `wet_labs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seats` int(11) NOT NULL DEFAULT '50',
  `starts_on` date NOT NULL,
  `days` int(11) NOT NULL DEFAULT '1' COMMENT 'Course duration in days',
  `price` decimal(8,2) NOT NULL DEFAULT '1000.00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wet_labs_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table eosksaco_visitors.wet_labs: ~8 rows (approximately)
/*!40000 ALTER TABLE `wet_labs` DISABLE KEYS */;
INSERT INTO `wet_labs` (`id`, `name`, `seats`, `starts_on`, `days`, `price`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'WetLab A', 1166, '2020-01-12', 5, 1000.00, NULL, '2019-07-29 12:25:32', '2019-07-29 15:10:58'),
	(2, 'WetLab B', 572, '2019-11-30', 1, 1000.00, NULL, '2019-07-29 12:25:32', '2019-07-29 15:10:58'),
	(3, 'WetLab C', 1202, '2020-11-02', 5, 1000.00, NULL, '2019-07-29 12:25:32', '2019-07-31 13:10:11'),
	(4, 'WetLab D', 1180, '2019-09-03', 5, 1000.00, NULL, '2019-07-29 12:25:32', '2019-07-29 15:10:58'),
	(5, 'WetLab E', 400, '2020-02-10', 5, 1000.00, NULL, '2019-07-29 12:25:32', '2019-07-31 13:10:11'),
	(6, 'WetLab F', 662, '2019-08-18', 5, 1000.00, NULL, '2019-07-29 12:25:32', '2019-07-29 15:10:58'),
	(7, 'WetLab G', 271, '2019-12-30', 1, 1000.00, NULL, '2019-07-29 12:25:32', '2019-07-30 14:29:38'),
	(8, 'WetLab H', 565, '2019-08-14', 4, 1000.00, NULL, '2019-07-29 12:25:33', '2019-07-29 15:10:58');
/*!40000 ALTER TABLE `wet_labs` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
