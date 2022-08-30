<?php
/*
 CREATE TABLE `exchange_list`.`parity` (
  `code` VARCHAR(9) NOT NULL DEFAULT '\"-\"',
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`code`));


CREATE TABLE `exchange_list`.`adapter` (
  `name` VARCHAR(25) NOT NULL,
  `returnType` VARCHAR(5) NULL,
  `kind` BIT NULL,
  PRIMARY KEY (`name`));

CREATE TABLE `exchange_list`.`rates` (
  `time` VARCHAR(11) NOT NULL,
  `currCode` VARCHAR(9) NOT NULL,
  `adapterName` VARCHAR(25) NOT NULL,
  `buy` FLOAT NULL,
  `sell` FLOAT NULL,
  PRIMARY KEY (`currCode`, `adapterName`, `time`),
  INDEX `adapterName_idx` (`adapterName` ASC) VISIBLE,
  CONSTRAINT `currCode`
    FOREIGN KEY (`currCode`)
    REFERENCES `exchange_list`.`parity` (`code`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `adapterName`
    FOREIGN KEY (`adapterName`)
    REFERENCES `exchange_list`.`adapter` (`name`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE);



 */