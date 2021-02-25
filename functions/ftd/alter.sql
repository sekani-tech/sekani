ALTER TABLE `ftd_booking_account` CHANGE `submittedon_date` `submittedon_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `ftd_booking_account` CHANGE `maturedon_date` `booked_date` DATE NOT NULL;
ALTER TABLE `ftd_booking_account` CHANGE `linked_savings_account` `linked_savings_account` VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;