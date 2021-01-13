ALTER TABLE `loan_arrear` ADD `amount_collected` DECIMAL(19,2) NOT NULL AFTER `completed_derived`;
ALTER TABLE `loan_repayment_schedule` ADD `amount_collected` DECIMAL(19,2) NOT NULL AFTER `completed_derived`;

-- for bulk approval this update is needed
ALTER TABLE `account` ADD `chooseDate` DATETIME NULL DEFAULT NULL AFTER `last_activity_date`;
ALTER TABLE `institution_account` ADD `chooseDate` DATETIME NULL DEFAULT NULL AFTER `last_activity_date`;
ALTER TABLE `account_transaction` ADD `chooseDate` DATETIME NULL DEFAULT NULL AFTER `created_date`;