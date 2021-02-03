ALTER TABLE `loan_arrear` ADD `amount_collected` DECIMAL(19,2) NOT NULL AFTER `completed_derived`;
ALTER TABLE `loan_repayment_schedule` ADD `amount_collected` DECIMAL(19,2) NOT NULL AFTER `completed_derived`;

-- for bulk approval this update is needed
ALTER TABLE `account` ADD `chooseDate` DATETIME NULL DEFAULT NULL AFTER `last_activity_date`;
ALTER TABLE `institution_account` ADD `chooseDate` DATETIME NULL DEFAULT NULL AFTER `last_activity_date`;
ALTER TABLE `account_transaction` ADD `chooseDate` DATETIME NULL DEFAULT NULL AFTER `created_date`;

-- for FTD product creation this update is needed
ALTER TABLE `charges_cache` CHANGE `cache_prod_id` `cache_prod_id` VARCHAR(255) NULL;
ALTER TABLE `charges_cache` CHANGE `is_status` `is_status` INT(3) NOT NULL;
ALTER TABLE `savings_product` ADD `gl_Code` INT NOT NULL AFTER `validate_period`;

-- for groups
ALTER TABLE `groups` CHANGE `id` `id` INT(100) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);
ALTER TABLE `group_clients` CHANGE `id` `id` INT(100) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);
ALTER TABLE `group_client_cache` CHANGE `id` `id` INT(100) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);


-- for bulk deposit
ALTER TABLE `transact_cache` ADD `teller_id` INT(100) NOT NULL AFTER `staff_id`;