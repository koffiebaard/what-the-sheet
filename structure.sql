CREATE TABLE `sheet` (
  `id` VARCHAR(32) NOT NULL,
  `race` VARCHAR(50) NULL,
  `name` VARCHAR(50) NULL,
  `class` VARCHAR(50) NULL,
  `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`));

ALTER TABLE `sheet` 
  ADD COLUMN `share_token` VARCHAR(40) NULL;
