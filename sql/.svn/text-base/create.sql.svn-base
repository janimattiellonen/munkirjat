SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `munkirjat_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_swedish_ci ;
USE `munkirjat_db` ;

-- -----------------------------------------------------
-- Table `munkirjat_db`.`book`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `munkirjat_db`.`book` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(128) CHARACTER SET 'utf8' COLLATE 'utf8_swedish_ci' NOT NULL ,
  `language_id` INT(10) UNSIGNED NULL ,
  `page_count` INT(5) UNSIGNED NULL ,
  `is_read` TINYINT(1) UNSIGNED NULL DEFAULT 0 ,
  `created_at` DATETIME NULL ,
  `updated_at` DATETIME NULL ,
  `started_reading` DATETIME NULL ,
  `finished_reading` DATETIME NULL ,
  `isbn` VARCHAR(40) NULL ,
  `rating` DOUBLE(5,2) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `title` (`title` ASC) ,
  INDEX `index_rating` (`rating` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_swedish_ci;


-- -----------------------------------------------------
-- Table `munkirjat_db`.`user`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `munkirjat_db`.`user` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(30) NOT NULL ,
  `password` VARCHAR(64) NOT NULL ,
  `salt` VARCHAR(40) NOT NULL ,
  `firstname` VARCHAR(64) NULL ,
  `lastname` VARCHAR(64) NULL ,
  `email` VARCHAR(128) NOT NULL ,
  `enabled` TINYINT(1) NULL DEFAULT 1 ,
  `role` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) ,
  INDEX `index3` (`password` ASC) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) ,
  INDEX `index5` (`enabled` ASC) ,
  INDEX `index_role` (`role` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `munkirjat_db`.`accountverification`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `munkirjat_db`.`accountverification` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `hash` VARCHAR(40) NULL ,
  `user_id` INT(10) UNSIGNED NOT NULL ,
  `verification_date` DATETIME NULL ,
  `verified` TINYINT(1) UNSIGNED NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `fk_av_user` (`user_id` ASC) ,
  INDEX `index3` (`hash` ASC) ,
  INDEX `index4` (`verification_date` ASC) ,
  INDEX `index5` (`verified` ASC) ,
  CONSTRAINT `fk_av_user`
    FOREIGN KEY (`user_id` )
    REFERENCES `munkirjat_db`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `munkirjat_db`.`genre`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `munkirjat_db`.`genre` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `munkirjat_db`.`author`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `munkirjat_db`.`author` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `firstname` VARCHAR(45) NOT NULL ,
  `lastname` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `index2` (`firstname` ASC, `lastname` ASC) ,
  INDEX `index3` (`lastname` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `munkirjat_db`.`book_author`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `munkirjat_db`.`book_author` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `book_id` INT(10) UNSIGNED NULL ,
  `author_id` INT(10) UNSIGNED NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `index2` (`book_id` ASC, `author_id` ASC) ,
  INDEX `fk_ba_book` (`book_id` ASC) ,
  INDEX `fk_ba_author` (`author_id` ASC) ,
  CONSTRAINT `fk_ba_book`
    FOREIGN KEY (`book_id` )
    REFERENCES `munkirjat_db`.`book` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ba_author`
    FOREIGN KEY (`author_id` )
    REFERENCES `munkirjat_db`.`author` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `munkirjat_db`.`book_genre`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `munkirjat_db`.`book_genre` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `book_id` INT(10) UNSIGNED NULL ,
  `genre_id` INT(10) UNSIGNED NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_bg_book` (`book_id` ASC) ,
  INDEX `fk_bg_genre` (`genre_id` ASC) ,
  CONSTRAINT `fk_bg_book`
    FOREIGN KEY (`book_id` )
    REFERENCES `munkirjat_db`.`book` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bg_genre`
    FOREIGN KEY (`genre_id` )
    REFERENCES `munkirjat_db`.`genre` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `munkirjat_db`.`tag`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `munkirjat_db`.`tag` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(128) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `munkirjat_db`.`book_tag`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `munkirjat_db`.`book_tag` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `book_id` INT(10) UNSIGNED NOT NULL ,
  `tag_id` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_bt_book` (`book_id` ASC) ,
  INDEX `fk_bt_tag` (`tag_id` ASC) ,
  CONSTRAINT `fk_bt_book`
    FOREIGN KEY (`book_id` )
    REFERENCES `munkirjat_db`.`book` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bt_tag`
    FOREIGN KEY (`tag_id` )
    REFERENCES `munkirjat_db`.`tag` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
