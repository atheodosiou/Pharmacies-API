SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `pharmacies` ;
CREATE SCHEMA IF NOT EXISTS `pharmacies` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `pharmacies` ;

-- -----------------------------------------------------
-- Table `pharmacies`.`pharmacy`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pharmacies`.`pharmacy` ;

CREATE  TABLE IF NOT EXISTS `pharmacies`.`pharmacy` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  `phone` VARCHAR(10) NULL ,
  `working_hours` TEXT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pharmacies`.`location`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pharmacies`.`location` ;

CREATE  TABLE IF NOT EXISTS `pharmacies`.`location` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `county` VARCHAR(55) NOT NULL ,
  `city` VARCHAR(55) NOT NULL ,
  `street_address` VARCHAR(255) NOT NULL ,
  `post_code` VARCHAR(6) NULL ,
  `latitude` DECIMAL(10,8) NOT NULL ,
  `longitude` DECIMAL(11,8) NOT NULL ,
  `accuracy` ENUM('ROOFTOP','RANGE_INTERPOLATED','GEOMETRIC_CENTER','APPROXIMATE') NOT NULL DEFAULT APPROXIMATE ,
  `pharmacy_id` INT NOT NULL ,
  PRIMARY KEY (`id`, `pharmacy_id`) ,
  INDEX `fk_location_pharmacy_idx` (`pharmacy_id` ASC) ,
  CONSTRAINT `fk_location_pharmacy`
    FOREIGN KEY (`pharmacy_id` )
    REFERENCES `pharmacies`.`pharmacy` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pharmacies`.`on_duty`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pharmacies`.`on_duty` ;

CREATE  TABLE IF NOT EXISTS `pharmacies`.`on_duty` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `start` DATETIME NOT NULL ,
  `expire` DATETIME NOT NULL ,
  `pharmacy_id` INT NOT NULL ,
  PRIMARY KEY (`id`, `pharmacy_id`) ,
  INDEX `fk_on_duty_pharmacy1_idx` (`pharmacy_id` ASC) ,
  CONSTRAINT `fk_on_duty_pharmacy1`
    FOREIGN KEY (`pharmacy_id` )
    REFERENCES `pharmacies`.`pharmacy` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

USE `pharmacies` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
