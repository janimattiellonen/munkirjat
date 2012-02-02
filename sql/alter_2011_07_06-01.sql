SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

ALTER TABLE `munkirjat_db`.`book` ADD COLUMN `created_at` DATETIME NULL DEFAULT NULL  AFTER `is_read` , ADD COLUMN `updated_at` DATETIME NULL DEFAULT NULL  AFTER `created_at` ;


ALTER TABLE `book` CHANGE `language_id` `language_id` VARCHAR( 3 ) NULL DEFAULT NULL;

ALTER TABLE `munkirjat_db`.`user` ADD COLUMN `role` VARCHAR(45) NOT NULL  AFTER `enabled` 
, ADD INDEX `index_role` (`role` ASC) ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

