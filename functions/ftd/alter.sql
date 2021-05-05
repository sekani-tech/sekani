ALTER TABLE `ftd_booking_account` CHANGE `submittedon_date` `submittedon_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `ftd_booking_account` CHANGE `maturedon_date` `booked_date` DATE NOT NULL;
ALTER TABLE `ftd_booking_account` CHANGE `linked_savings_account` `linked_savings_account` VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
ALTER TABLE `ftd_booking_account` CHANGE `ftd_id` `ftd_no` VARCHAR(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
ALTER TABLE `ftd_interest_schedule` CHANGE `ftd_id` `ftd_id` INT(10) NOT NULL;
ALTER TABLE `ftd_interest_schedule` CHANGE `ftd_no` `ftd_no` VARCHAR(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
ALTER TABLE `ftd_interest_schedule` CHANGE `end_date` `maturity_date` DATE NOT NULL;
ALTER TABLE `ftd_booking_account` CHANGE `interest_repayment` `interest_repayment` INT(1) NOT NULL;
ALTER TABLE `ftd_interest_schedule` CHANGE `interest_repayment` `interest_repayment` INT(1) NOT NULL;
ALTER TABLE `ftd_interest_schedule` CHANGE `installment` `installment` DECIMAL(19,2) NOT NULL;