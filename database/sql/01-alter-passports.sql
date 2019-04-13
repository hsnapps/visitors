ALTER TABLE `passports` ADD COLUMN `password` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci';
ALTER TABLE `passports` ADD COLUMN `remember_token` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci';
