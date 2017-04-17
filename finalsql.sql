USE mit57;

CREATE TABLE `mit57`.`finalUsers` (
  `finalUsersID` INT NOT NULL AUTO_INCREMENT,
  `fName` VARCHAR(45) NOT NULL,
  `lName` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `phoneNumber` INT NOT NULL,
  `age` INT NOT NULL,
  PRIMARY KEY (`finalUsersID`));

CREATE TABLE `mit57`.`ratings` (
  `ratingsID` INT NOT NULL AUTO_INCREMENT,
  `beerID_fk` INT NOT NULL,
  `finalUsersID_fk` INT NOT NULL,
  `rating` INT NOT NULL,
  PRIMARY KEY (`ratingsID`));

CREATE TABLE `mit57`.`beers` (
  `beerID` INT NOT NULL AUTO_INCREMENT,
  `beerName` VARCHAR(45) NOT NULL,
  `beerABV` INT NOT NULL,
  `beerStyle` VARCHAR(45) NOT NULL,
  `brewerID_fk` INT NOT NULL,
  `finalUsersID_fk` INT NOT NULL,
  PRIMARY KEY (`beerID`));

CREATE TABLE `mit57`.`brewers` (
  `brewersID` INT NOT NULL AUTO_INCREMENT,
  `brewerName` VARCHAR(45) NOT NULL,
  `brewerLocation` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`brewersID`));
  
ALTER TABLE `mit57`.`ratings` 
ADD INDEX `finalUsersID_idx` (`finalUsersID_fk` ASC),
ADD INDEX `beerID_idx` (`beerID_fk` ASC);


ALTER TABLE `mit57`.`beers` 
ADD INDEX `finalUsersID_idx` (`finalUsersID_fk` ASC);
