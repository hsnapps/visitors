-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.37-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for eosksaco_rsos
CREATE DATABASE IF NOT EXISTS `eosksaco_rsos` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `eosksaco_rsos`;

-- Dumping structure for table eosksaco_rsos.carts
CREATE TABLE IF NOT EXISTS `carts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `passport_id` int(10) unsigned NOT NULL,
  `item_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Either courses or wetlabs',
  `item_id` int(10) unsigned NOT NULL COMMENT 'The record id in the tables courses or wetlabs',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `starts_on` date NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `days` int(11) NOT NULL DEFAULT '1',
  `expiration_date` date NOT NULL,
  `checkout_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carts_passport_id_foreign` (`passport_id`),
  CONSTRAINT `carts_passport_id_foreign` FOREIGN KEY (`passport_id`) REFERENCES `passports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table eosksaco_rsos.courses
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

-- Data exporting was unselected.
-- Dumping structure for table eosksaco_rsos.course_passport
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

-- Data exporting was unselected.
-- Dumping structure for table eosksaco_rsos.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table eosksaco_rsos.orders
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table eosksaco_rsos.order_items
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table eosksaco_rsos.passports
CREATE TABLE IF NOT EXISTS `passports` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL DEFAULT '0',
  `admin_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '$2y$10$ijohMEwRkdaFCidZaVMAou7UUM9mhgv.3hBSDSxcZzSoTZzrx6N1S',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `passports_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table eosksaco_rsos.passport_wetlab
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

-- Data exporting was unselected.
-- Dumping structure for table eosksaco_rsos.payments
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table eosksaco_rsos.wet_labs
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

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
