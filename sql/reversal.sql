CREATE TABLE `reversal` ( `id` INT NOT NULL AUTO_INCREMENT , `int_id` INT NOT NULL , `client_id` INT NOT NULL , `account_no` INT NOT NULL , `transact_date` DATE NOT NULL , `reversal_date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP , `staff_id` INT NOT NULL , `teller_id` INT NOT NULL , `amount_reversed` INT NOT NULL , `account_balance_derived` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `reversal` ADD `transaction_id` VARCHAR(200) NOT NULL AFTER `client_id`;

