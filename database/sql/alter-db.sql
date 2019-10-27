SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

SET time_zone = "+00:00";

USE `original_eosksaco_visitors`;

CREATE TABLE `sessions` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100) NOT NULL DEFAULT 'SESSION' COLLATE 'utf8mb4_unicode_ci',
	`wetlab_id` INT(10) UNSIGNED NOT NULL,
	`start_time` TIME NOT NULL,
	`end_time` TIME NOT NULL,
	`seats_available` SMALLINT(6) NOT NULL DEFAULT '1',
	`seats_taken` SMALLINT(6) NOT NULL DEFAULT '0',
	`created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	`price` DECIMAL(8,2) NOT NULL DEFAULT '1000.00',
	`description` VARCHAR(500) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
	PRIMARY KEY (`id`),
	INDEX `sessions_wetlab_id_foreign` (`wetlab_id`),
	CONSTRAINT `sessions_wetlab_id_foreign` FOREIGN KEY (`wetlab_id`) REFERENCES `wet_labs` (`id`)
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
AUTO_INCREMENT=401
;

INSERT INTO `sessions` (`name`, `wetlab_id`, `start_time`, `end_time`, `seats_available`, `seats_taken`, `created_at`, `updated_at`, `price`, `description`) VALUES
	('Session 1', 1, '09:00:00', '10:00:00', 2, 0, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 1000.00, NULL),
	('Session 2', 1, '10:00:00', '11:00:00', 1, 0, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 1000.00, NULL),
	('Session 3', 1, '11:00:00', '12:00:00', 3, 0, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 1000.00, NULL),
	('Session 4', 1, '12:00:00', '13:00:00', 3, 0, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 1000.00, NULL),
	('Session 5', 1, '13:00:00', '14:00:00', 3, 0, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 1000.00, NULL);


ALTER TABLE `wet_labs` DROP COLUMN IF EXISTS `seats`;
ALTER TABLE `wet_labs` DROP COLUMN IF EXISTS `days`;
ALTER TABLE `wet_labs` DROP COLUMN IF EXISTS `price`;

ALTER TABLE `passport_wetlab` DROP COLUMN IF EXISTS `session_id`;
ALTER TABLE `passport_wetlab` ADD COLUMN `session_id` BIGINT(20) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `passport_wetlab` ADD INDEX `passport_wetlab_session_id_foreign` (`session_id`);
ALTER TABLE `passport_wetlab` ADD CONSTRAINT `passport_wetlab_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`);

