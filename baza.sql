-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema WebDiP2021x066
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema WebDiP2021x066
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `WebDiP2021x066` DEFAULT CHARACTER SET utf8 ;
USE `WebDiP2021x066` ;

-- -----------------------------------------------------
-- Table `WebDiP2021x066`.`uloga`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2021x066`.`uloga` (
  `uloga_id` INT NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`uloga_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2021x066`.`korisnik`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2021x066`.`korisnik` (
  `korisnik_id` INT NOT NULL AUTO_INCREMENT,
  `ime` VARCHAR(45) NOT NULL,
  `prezime` VARCHAR(45) NOT NULL,
  `godina_rodenja` INT(5) NOT NULL,
  `korime` VARCHAR(45) NOT NULL,
  `lozinka` VARCHAR(45) NOT NULL,
  `sol` CHAR(64) NOT NULL,
  `lozinka256` CHAR(64) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `kolacici` INT(4) NOT NULL,
  `datum_registracije` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `broj_prijava` INT(3) NOT NULL,
  `uvjeti_koristenja` VARCHAR(45) NULL,
  `blokiran` TINYINT NOT NULL,
  `verificiran` TINYINT NOT NULL,
  `uloga_uloga_id` INT NOT NULL,
  PRIMARY KEY (`korisnik_id`),
  INDEX `fk_korisnik_uloga1_idx` (`uloga_uloga_id` ASC) ,
  CONSTRAINT `fk_korisnik_uloga1`
    FOREIGN KEY (`uloga_uloga_id`)
    REFERENCES `WebDiP2021x066`.`uloga` (`uloga_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2021x066`.`radnja`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2021x066`.`radnja` (
  `radnja_id` INT NOT NULL AUTO_INCREMENT,
  `radnja` VARCHAR(45) NOT NULL,
  `detalji` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`radnja_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2021x066`.`kategorija`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2021x066`.`kategorija` (
  `kategorija_id` INT NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(45) NOT NULL,
  `opis` VARCHAR(250) NULL,
  PRIMARY KEY (`kategorija_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2021x066`.`status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2021x066`.`status` (
  `status_id` INT NOT NULL AUTO_INCREMENT,
  `naziv_statusa` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`status_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2021x066`.`savjetovanje`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2021x066`.`savjetovanje` (
  `savjetovanje_id` INT NOT NULL AUTO_INCREMENT,
  `razlog` VARCHAR(50) NOT NULL,
  `opis` VARCHAR(100) NOT NULL,
  `stranka_id` INT NOT NULL,
  `odvjetnik_id` INT NOT NULL,
  PRIMARY KEY (`savjetovanje_id`),
  INDEX `fk_savjetovanje_korisnik1_idx` (`stranka_id` ASC) ,
  INDEX `fk_savjetovanje_korisnik2_idx` (`odvjetnik_id` ASC) ,
  CONSTRAINT `fk_savjetovanje_korisnik1`
    FOREIGN KEY (`stranka_id`)
    REFERENCES `WebDiP2021x066`.`korisnik` (`korisnik_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_savjetovanje_korisnik2`
    FOREIGN KEY (`odvjetnik_id`)
    REFERENCES `WebDiP2021x066`.`korisnik` (`korisnik_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2021x066`.`sudski`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2021x066`.`sudski` (
  `sudski_id` INT NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(45) NOT NULL,
  `radnja` VARCHAR(45) NOT NULL,
  `dokaz` VARCHAR(45) NOT NULL,
  `datum_pocetak` DATETIME NOT NULL,
  `datum_kraj` DATETIME NULL,
  `tuzitelj_id` INT NOT NULL,
  `status_id` INT NOT NULL,
  `kategorija_id` INT NOT NULL,
  PRIMARY KEY (`sudski_id`),
  INDEX `fk_sudski_korisnik1_idx` (`tuzitelj_id` ASC) ,
  INDEX `fk_sudski_status1_idx` (`status_id` ASC) ,
  INDEX `fk_sudski_kategorija1_idx` (`kategorija_id` ASC) ,
  CONSTRAINT `fk_sudski_korisnik1`
    FOREIGN KEY (`tuzitelj_id`)
    REFERENCES `WebDiP2021x066`.`korisnik` (`korisnik_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sudski_status1`
    FOREIGN KEY (`status_id`)
    REFERENCES `WebDiP2021x066`.`status` (`status_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sudski_kategorija1`
    FOREIGN KEY (`kategorija_id`)
    REFERENCES `WebDiP2021x066`.`kategorija` (`kategorija_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2021x066`.`zahtjev`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2021x066`.`zahtjev` (
  `zahtjev_id` INT NOT NULL AUTO_INCREMENT,
  `slika` VARCHAR(45) NOT NULL,
  `status` VARCHAR(45) NOT NULL,
  `argument_obrane` VARCHAR(45) NOT NULL,
  `datum` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `zakljucak` VARCHAR(45) NULL,
  `sudski_id` INT NOT NULL,
  `stranka_id` INT NOT NULL,
  `odvjetnik_id` INT NOT NULL,
  PRIMARY KEY (`zahtjev_id`),
  INDEX `fk_zahtjev_sudski1_idx` (`sudski_id` ASC) ,
  INDEX `fk_zahtjev_korisnik1_idx` (`stranka_id` ASC) ,
  INDEX `fk_zahtjev_korisnik2_idx` (`odvjetnik_id` ASC) ,
  CONSTRAINT `fk_zahtjev_sudski1`
    FOREIGN KEY (`sudski_id`)
    REFERENCES `WebDiP2021x066`.`sudski` (`sudski_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_zahtjev_korisnik1`
    FOREIGN KEY (`stranka_id`)
    REFERENCES `WebDiP2021x066`.`korisnik` (`korisnik_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_zahtjev_korisnik2`
    FOREIGN KEY (`odvjetnik_id`)
    REFERENCES `WebDiP2021x066`.`korisnik` (`korisnik_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2021x066`.`moderator_kategorije`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2021x066`.`moderator_kategorije` (
  `modkategorija_id` INT NOT NULL,
  `modmoderator_id` INT NOT NULL,
  INDEX `fk_moderator_kategorije_kategorija_idx` (`modkategorija_id` ASC) ,
  INDEX `fk_moderator_kategorije_korisnik1_idx` (`modmoderator_id` ASC) ,
  CONSTRAINT `fk_moderator_kategorije_kategorija`
    FOREIGN KEY (`modkategorija_id`)
    REFERENCES `WebDiP2021x066`.`kategorija` (`kategorija_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_moderator_kategorije_korisnik1`
    FOREIGN KEY (`modmoderator_id`)
    REFERENCES `WebDiP2021x066`.`korisnik` (`korisnik_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WebDiP2021x066`.`dnevnik`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WebDiP2021x066`.`dnevnik` (
  `dnevnik_id` INT NOT NULL,
  `vrijeme` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `korisnik_id` INT NOT NULL,
  `radnja_id` INT NOT NULL,
  PRIMARY KEY (`dnevnik_id`),
  INDEX `fk_dnevnik_korisnik1_idx` (`korisnik_id` ASC) ,
  INDEX `fk_dnevnik_radnja1_idx` (`radnja_id` ASC) ,
  CONSTRAINT `fk_dnevnik_korisnik1`
    FOREIGN KEY (`korisnik_id`)
    REFERENCES `WebDiP2021x066`.`korisnik` (`korisnik_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_dnevnik_radnja1`
    FOREIGN KEY (`radnja_id`)
    REFERENCES `WebDiP2021x066`.`radnja` (`radnja_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
