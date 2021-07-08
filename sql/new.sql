-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema sekani
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema sekani
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sekani` DEFAULT CHARACTER SET utf8 ;
-- -----------------------------------------------------
-- Schema sekani
-- -----------------------------------------------------
USE `sekani` ;

-- -----------------------------------------------------
-- Table `sekani`.`institution`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sekani`.`institution` (
  `idinstitution` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `rcn` VARCHAR(45) NOT NULL,
  `state` VARCHAR(45) NOT NULL,
  `lga` VARCHAR(45) NOT NULL,
  `address` TEXT NULL,
  `incoporation_date` DATE NULL,
  `phone` VARCHAR(45) NULL,
  `email` VARCHAR(100) NULL,
  `website` VARCHAR(100) NULL,
  `image` LONGTEXT NULL,
  `sender_id` VARCHAR(45) NULL,
  PRIMARY KEY (`idinstitution`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sekani`.`branch`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sekani`.`branch` (
  `idbranch` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(45) NULL,
  `phone_no` VARCHAR(45) NULL,
  `state` VARCHAR(45) NULL,
  `lga` VARCHAR(100) NULL,
  `location` TEXT NULL,
  `opened_date` VARCHAR(45) NULL,
  `heirachy` VARCHAR(11) NULL,
  `status` VARCHAR(45) NULL,
  `parent_id` VARCHAR(45) NULL,
  `institution_idinstitution` INT NOT NULL,
  PRIMARY KEY (`idbranch`),
  INDEX `fk_branch_institution1_idx` (`institution_idinstitution` ASC),
  CONSTRAINT `fk_branch_institution1`
    FOREIGN KEY (`institution_idinstitution`)
    REFERENCES `sekani`.`institution` (`idinstitution`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sekani`.`client`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sekani`.`client` (
  `idclient` INT NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(45) NOT NULL,
  `middlename` VARCHAR(45) NULL,
  `lastname` VARCHAR(45) NOT NULL,
  `displayname` VARCHAR(45) NOT NULL,
  `account_officer` VARCHAR(80) NULL,
  `client_type` VARCHAR(45) NULL,
  `phone_no` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `state_of_origin` VARCHAR(45) NULL,
  `country` VARCHAR(45) NULL,
  `lga` VARCHAR(45) NULL,
  `occupation` VARCHAR(45) NULL,
  `gender` VARCHAR(45) NULL,
  `is_staff` VARCHAR(45) NULL,
  `activation_date` VARCHAR(45) NULL,
  `submitted_on_date` VARCHAR(45) NULL,
  `client_status` VARCHAR(45) NULL DEFAULT 'Not Approved',
  `institution_idinstitution` INT NOT NULL,
  `branch_idbranch` INT NOT NULL,
  INDEX `fk_client_institution1_idx` (`institution_idinstitution` ASC),
  PRIMARY KEY (`idclient`),
  INDEX `fk_client_branch1_idx` (`branch_idbranch` ASC),
  CONSTRAINT `fk_client_institution1`
    FOREIGN KEY (`institution_idinstitution`)
    REFERENCES `sekani`.`institution` (`idinstitution`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_client_branch1`
    FOREIGN KEY (`branch_idbranch`)
    REFERENCES `sekani`.`branch` (`idbranch`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sekani`.`pc_bio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sekani`.`pc_bio` (
  `idpc_bio` INT NOT NULL AUTO_INCREMENT,
  `pc_title` VARCHAR(45) NULL,
  `pc_surname` VARCHAR(45) NULL,
  `pc_othername` VARCHAR(100) NULL,
  `pc_designation` VARCHAR(45) NULL,
  `pc_phone` VARCHAR(45) NULL,
  `pc_email` VARCHAR(45) NULL,
  `institution_idinstitution` INT NOT NULL,
  PRIMARY KEY (`idpc_bio`),
  INDEX `fk_pc_bio_institution1_idx` (`institution_idinstitution` ASC),
  CONSTRAINT `fk_pc_bio_institution1`
    FOREIGN KEY (`institution_idinstitution`)
    REFERENCES `sekani`.`institution` (`idinstitution`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sekani`.`staff`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sekani`.`staff` (
  `idstaff` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(45) NOT NULL,
  `middle_name` VARCHAR(45) NULL,
  `last_name` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NULL,
  `designation` VARCHAR(45) NULL,
  `phone_no` VARCHAR(45) NULL,
  `home_address` TEXT NULL,
  `img` LONGTEXT NULL,
  `date_joined` DATE NULL,
  `employment_status` VARCHAR(45) NULL,
  `institution_idinstitution` INT NOT NULL,
  `branch_idbranch` INT NOT NULL,
  PRIMARY KEY (`idstaff`),
  INDEX `fk_staff_institution1_idx` (`institution_idinstitution` ASC),
  INDEX `fk_staff_branch1_idx` (`branch_idbranch` ASC),
  CONSTRAINT `fk_staff_institution1`
    FOREIGN KEY (`institution_idinstitution`)
    REFERENCES `sekani`.`institution` (`idinstitution`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_staff_branch1`
    FOREIGN KEY (`branch_idbranch`)
    REFERENCES `sekani`.`branch` (`idbranch`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sekani`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sekani`.`users` (
  `idusers` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NULL,
  `passkey` VARCHAR(100) NULL,
  `lastlogin` DATETIME NULL,
  `forgot_passkey` VARCHAR(45) NULL,
  `time_created` DATETIME NULL,
  `pin` VARCHAR(10) NULL,
  `pc_bio_idpc_bio` INT NOT NULL,
  `staff_idstaff` INT NOT NULL,
  `users_idusers` INT NOT NULL,
  PRIMARY KEY (`idusers`),
  INDEX `fk_users_pc_bio1_idx` (`pc_bio_idpc_bio` ASC),
  INDEX `fk_users_staff1_idx` (`staff_idstaff` ASC),
  INDEX `fk_users_users1_idx` (`users_idusers` ASC),
  CONSTRAINT `fk_users_pc_bio1`
    FOREIGN KEY (`pc_bio_idpc_bio`)
    REFERENCES `sekani`.`pc_bio` (`idpc_bio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_staff1`
    FOREIGN KEY (`staff_idstaff`)
    REFERENCES `sekani`.`staff` (`idstaff`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_users1`
    FOREIGN KEY (`users_idusers`)
    REFERENCES `sekani`.`users` (`idusers`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sekani`.`client_credentials`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sekani`.`client_credentials` (
  `idclient_credentials` INT NOT NULL AUTO_INCREMENT,
  `id_card` VARCHAR(45) NULL,
  `card_url` LONGTEXT NULL,
  `signature` LONGTEXT NULL,
  `passport` LONGTEXT NULL,
  `rcn` VARCHAR(45) NULL,
  `bvn` VARCHAR(45) NULL,
  `client_idclient` INT NOT NULL,
  PRIMARY KEY (`idclient_credentials`),
  INDEX `fk_client_credentials_client1_idx` (`client_idclient` ASC),
  CONSTRAINT `fk_client_credentials_client1`
    FOREIGN KEY (`client_idclient`)
    REFERENCES `sekani`.`client` (`idclient`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sekani`.`clients_next_of_kin`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sekani`.`clients_next_of_kin` (
  `idclients_next_of_kin` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(45) NOT NULL,
  `last_name` VARCHAR(45) NOT NULL,
  `middle_name` VARCHAR(45) NULL,
  `date_of_birth` DATE NULL,
  `gender` VARCHAR(8) NULL,
  `relationship` VARCHAR(45) NULL,
  `home_address` TEXT NULL,
  `phone_no` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `client_idclient` INT NOT NULL,
  PRIMARY KEY (`idclients_next_of_kin`),
  INDEX `fk_clients_next_of_kin_client1_idx` (`client_idclient` ASC),
  CONSTRAINT `fk_clients_next_of_kin_client1`
    FOREIGN KEY (`client_idclient`)
    REFERENCES `sekani`.`client` (`idclient`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sekani`.`client_contact status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sekani`.`client_contact status` (
  `idclient_contact status` INT NOT NULL AUTO_INCREMENT,
  `email_active` VARCHAR(4) NULL DEFAULT 'NO',
  `sms_active` VARCHAR(4) NULL DEFAULT 'NO',
  `client_idclient` INT NOT NULL,
  PRIMARY KEY (`idclient_contact status`),
  INDEX `fk_client_contact status_client1_idx` (`client_idclient` ASC),
  CONSTRAINT `fk_client_contact status_client1`
    FOREIGN KEY (`client_idclient`)
    REFERENCES `sekani`.`client` (`idclient`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sekani`.`accounts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sekani`.`accounts` (
  `idaccounts` INT NOT NULL AUTO_INCREMENT,
  `account_no` VARCHAR(45) NOT NULL,
  `account_type` VARCHAR(45) NOT NULL,
  `last_deposit` DECIMAL(19,2) NULL,
  `last_withdrawal` DECIMAL(19,2) NULL,
  `activation_date` DATETIME NULL,
  `last_activity_date` DATETIME NULL,
  `client_idclient` INT NOT NULL,
  PRIMARY KEY (`idaccounts`),
  INDEX `fk_accounts_client1_idx` (`client_idclient` ASC),
  CONSTRAINT `fk_accounts_client1`
    FOREIGN KEY (`client_idclient`)
    REFERENCES `sekani`.`client` (`idclient`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sekani`.`acounts_derived`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sekani`.`acounts_derived` (
  `idacounts_derived` INT NOT NULL AUTO_INCREMENT,
  `total_deposits_derived` DECIMAL(19,2) NULL,
  `total_withdrwals_derived` DECIMAL(19,2) NULL,
  `total_interest_earned` DECIMAL(19,2) NULL,
  `total_penalty` DECIMAL(19,2) NULL,
  `total_fees` DECIMAL(19,2) NULL,
  `total_charges` DECIMAL(19,2) NULL,
  `accounts_idaccounts` INT NOT NULL,
  PRIMARY KEY (`idacounts_derived`),
  INDEX `fk_acounts_derived_accounts1_idx` (`accounts_idaccounts` ASC),
  CONSTRAINT `fk_acounts_derived_accounts1`
    FOREIGN KEY (`accounts_idaccounts`)
    REFERENCES `sekani`.`accounts` (`idaccounts`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sekani`.`charges`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sekani`.`charges` (
  `idcharges` INT NOT NULL AUTO_INCREMENT,
  `currency` VARCHAR(3) NULL,
  `charge_applies_to` VARCHAR(45) NULL,
  `charge_time_enum` VARCHAR(45) NULL,
  `charge_calculation` VARCHAR(45) NULL,
  `charge_payment` VARCHAR(45) NULL,
  `amount` VARCHAR(45) NULL,
  `fee_on_day` VARCHAR(45) NULL,
  `fee_interval` VARCHAR(45) NULL,
  `fee_on_month` VARCHAR(45) NULL,
  `is_penalty` VARCHAR(45) NULL,
  `is_active` VARCHAR(4) NULL,
  `allow_overdrive` VARCHAR(4) NULL DEFAULT 'YES',
  `is_deleted` VARCHAR(4) NULL,
  `min_cap` DECIMAL(19,2) NULL,
  `max_cap` DECIMAL(19,2) NULL,
  `fee_frequency` INT NULL,
  `gl_code` VARCHAR(45) NULL,
  PRIMARY KEY (`idcharges`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sekani`.`products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sekani`.`products` (
  `idproducts` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `short_code` VARCHAR(45) NULL,
  `description` TEXT NULL,
  `charges_idcharges` INT NOT NULL,
  PRIMARY KEY (`idproducts`),
  INDEX `fk_products_charges1_idx` (`charges_idcharges` ASC),
  CONSTRAINT `fk_products_charges1`
    FOREIGN KEY (`charges_idcharges`)
    REFERENCES `sekani`.`charges` (`idcharges`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sekani`.`loan_product`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sekani`.`loan_product` (
  `idloan_product` INT NOT NULL AUTO_INCREMENT,
  `interest` INT NULL,
  `loan_term` VARCHAR(45) NULL,
  `principal_amount` DECIMAL(11,2) NULL,
  `min_loan_term` VARCHAR(45) NULL,
  `max_loan_term` VARCHAR(45) NULL,
  `amortization_method` VARCHAR(45) NULL,
  `rmin_principal` VARCHAR(45) NULL,
  `max_principal` VARCHAR(45) NULL,
  `grace_on_interest` VARCHAR(45) NULL,
  `grace_on_charge` VARCHAR(45) NULL,
  `repayment_frequency` VARCHAR(45) NULL,
  `products_idproducts` INT NOT NULL,
  PRIMARY KEY (`idloan_product`),
  INDEX `fk_loan_product_products1_idx` (`products_idproducts` ASC),
  CONSTRAINT `fk_loan_product_products1`
    FOREIGN KEY (`products_idproducts`)
    REFERENCES `sekani`.`products` (`idproducts`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sekani`.`fixed-deposit_product`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sekani`.`fixed-deposit_product` (
  `idlfixed_deposit_product` INT NOT NULL AUTO_INCREMENT,
  `interest` INT NULL,
  `min_fixed_deposit` DECIMAL(15,2) NULL,
  `max_fixed_deposit` DECIMAL(15,2) NULL,
  `amortization_method` VARCHAR(45) NULL,
  `min_principal` DECIMAL(15,2) NULL,
  `max_principal` DECIMAL(15,2) NULL,
  `rule_type` VARCHAR(100) NULL,
  `products_idproducts` INT NOT NULL,
  PRIMARY KEY (`idlfixed_deposit_product`),
  INDEX `fk_fixed-deposit_product_products1_idx` (`products_idproducts` ASC),
  CONSTRAINT `fk_fixed-deposit_product_products1`
    FOREIGN KEY (`products_idproducts`)
    REFERENCES `sekani`.`products` (`idproducts`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sekani`.`savings_product`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sekani`.`savings_product` (
  `idsavings_product` INT NOT NULL AUTO_INCREMENT,
  `min_amount` DECIMAL(12,2) NULL,
  `intetrest` INT NULL,
  `products_idproducts` INT NOT NULL,
  PRIMARY KEY (`idsavings_product`),
  INDEX `fk_savings_product_products1_idx` (`products_idproducts` ASC),
  CONSTRAINT `fk_savings_product_products1`
    FOREIGN KEY (`products_idproducts`)
    REFERENCES `sekani`.`products` (`idproducts`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sekani`.`acounts_product`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sekani`.`acounts_product` (
  `accounts_idaccounts` INT NOT NULL,
  `products_idproducts` INT NOT NULL,
  INDEX `fk_acounts_product_accounts1_idx` (`accounts_idaccounts` ASC),
  INDEX `fk_acounts_product_products1_idx` (`products_idproducts` ASC),
  CONSTRAINT `fk_acounts_product_accounts1`
    FOREIGN KEY (`accounts_idaccounts`)
    REFERENCES `sekani`.`accounts` (`idaccounts`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_acounts_product_products1`
    FOREIGN KEY (`products_idproducts`)
    REFERENCES `sekani`.`products` (`idproducts`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sekani`.`account_transaction`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sekani`.`account_transaction` (
  `idaccount_transaction` INT NOT NULL AUTO_INCREMENT,
  `transaction_id` VARCHAR(100) NULL,
  `description` VARCHAR(45) NULL,
  `transaction_type` VARCHAR(45) NULL,
  `credit` VARCHAR(3) NULL DEFAULT 'NO',
  `debit` VARCHAR(3) NULL DEFAULT 'NO',
  `amount` DECIMAL(19,2) NULL,
  `created_date` DATE NULL,
  PRIMARY KEY (`idaccount_transaction`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sekani`.`account_transaction_has_accounts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sekani`.`account_transaction_has_accounts` (
  `account_transaction_idaccount_transaction` INT NOT NULL,
  `accounts_idaccounts` INT NOT NULL,
  PRIMARY KEY (`account_transaction_idaccount_transaction`, `accounts_idaccounts`),
  INDEX `fk_account_transaction_has_accounts_accounts1_idx` (`accounts_idaccounts` ASC),
  INDEX `fk_account_transaction_has_accounts_account_transaction1_idx` (`account_transaction_idaccount_transaction` ASC),
  CONSTRAINT `fk_account_transaction_has_accounts_account_transaction1`
    FOREIGN KEY (`account_transaction_idaccount_transaction`)
    REFERENCES `sekani`.`account_transaction` (`idaccount_transaction`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_account_transaction_has_accounts_accounts1`
    FOREIGN KEY (`accounts_idaccounts`)
    REFERENCES `sekani`.`accounts` (`idaccounts`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sekani`.`vault`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sekani`.`vault` (
  `idvault` INT NOT NULL AUTO_INCREMENT,
  `description` TEXT NULL,
  `last_transaction_date` DATETIME NULL,
  `balance` VARCHAR(45) NULL,
  `created_day` TIMESTAMP NULL,
  `institution_idinstitution` INT NOT NULL,
  `branch_idbranch` INT NOT NULL,
  PRIMARY KEY (`idvault`),
  INDEX `fk_vault_institution1_idx` (`institution_idinstitution` ASC),
  INDEX `fk_vault_branch1_idx` (`branch_idbranch` ASC),
  CONSTRAINT `fk_vault_institution1`
    FOREIGN KEY (`institution_idinstitution`)
    REFERENCES `sekani`.`institution` (`idinstitution`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_vault_branch1`
    FOREIGN KEY (`branch_idbranch`)
    REFERENCES `sekani`.`branch` (`idbranch`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sekani`.`vault_transaction`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sekani`.`vault_transaction` (
  `idvault_transaction` INT NOT NULL AUTO_INCREMENT,
  `credit` DECIMAL(19,2) NULL,
  `debit` DECIMAL(19,2) NULL,
  `transaction_type` VARCHAR(7) NULL,
  `vault_idvault` INT NOT NULL,
  PRIMARY KEY (`idvault_transaction`),
  INDEX `fk_vault_transaction_vault1_idx` (`vault_idvault` ASC),
  CONSTRAINT `fk_vault_transaction_vault1`
    FOREIGN KEY (`vault_idvault`)
    REFERENCES `sekani`.`vault` (`idvault`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sekani`.`teller`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sekani`.`teller` (
  `idteller` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT NULL,
  `post_limit` DECIMAL(19,2) NULL,
  `valid_from` TIMESTAMP NULL,
  `valid_to` TIMESTAMP NULL,
  `is_deleted` VARCHAR(4) NULL,
  `till` VARCHAR(500) NULL,
  `state` SMALLINT(5) NULL,
  PRIMARY KEY (`idteller`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sekani`.`teller_assigned`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sekani`.`teller_assigned` (
  `idteller_assigned` INT NOT NULL AUTO_INCREMENT,
  `staff_idstaff` INT NOT NULL,
  `teller_idteller` INT NOT NULL,
  PRIMARY KEY (`idteller_assigned`),
  INDEX `fk_teller_assigned_staff1_idx` (`staff_idstaff` ASC),
  INDEX `fk_teller_assigned_teller1_idx` (`teller_idteller` ASC),
  CONSTRAINT `fk_teller_assigned_staff1`
    FOREIGN KEY (`staff_idstaff`)
    REFERENCES `sekani`.`staff` (`idstaff`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_teller_assigned_teller1`
    FOREIGN KEY (`teller_idteller`)
    REFERENCES `sekani`.`teller` (`idteller`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sekani`.`teller_has_vault_transaction`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sekani`.`teller_has_vault_transaction` (
  `teller_idteller` INT NOT NULL,
  `vault_transaction_idvault_transaction` INT NOT NULL,
  PRIMARY KEY (`teller_idteller`, `vault_transaction_idvault_transaction`),
  INDEX `fk_teller_has_vault_transaction_vault_transaction1_idx` (`vault_transaction_idvault_transaction` ASC),
  INDEX `fk_teller_has_vault_transaction_teller1_idx` (`teller_idteller` ASC),
  CONSTRAINT `fk_teller_has_vault_transaction_teller1`
    FOREIGN KEY (`teller_idteller`)
    REFERENCES `sekani`.`teller` (`idteller`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_teller_has_vault_transaction_vault_transaction1`
    FOREIGN KEY (`vault_transaction_idvault_transaction`)
    REFERENCES `sekani`.`vault_transaction` (`idvault_transaction`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
