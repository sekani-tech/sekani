ALTER TABLE `loan_arrear` ADD `amount_collected` DECIMAL(19,2) NOT NULL AFTER `completed_derived`;
ALTER TABLE `loan_repayment_schedule` ADD `amount_collected` DECIMAL(19,2) NOT NULL AFTER `completed_derived`;



-- for FTD product creation this update is needed
ALTER TABLE `charges_cache` CHANGE `cache_prod_id` `cache_prod_id` VARCHAR(255) NULL;
ALTER TABLE `charges_cache` CHANGE `is_status` `is_status` INT(3) NOT NULL;
ALTER TABLE `savings_product` ADD `gl_Code` INT NOT NULL AFTER `validate_period`;

-- for groups
ALTER TABLE `groups` CHANGE `id` `id` INT(100) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);
ALTER TABLE `group_clients` CHANGE `id` `id` INT(100) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);
ALTER TABLE `group_client_cache` CHANGE `id` `id` INT(100) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);
-----------------------------------------------------------------------------------------------------------


-- for bulk deposit
ALTER TABLE `transact_cache` ADD `teller_id` INT(100) NOT NULL AFTER `staff_id`;

-- client_charge
ALTER TABLE `client_charge` ADD `approved` INT NOT NULL AFTER `date`;

-- for bulk approval this update is needed
ALTER TABLE `account` ADD `chooseDate` DATETIME NULL DEFAULT NULL AFTER `last_activity_date`;
ALTER TABLE `institution_account` ADD `chooseDate` DATETIME NULL DEFAULT NULL AFTER `last_activity_date`;
ALTER TABLE `account_transaction` ADD `chooseDate` DATETIME NULL DEFAULT NULL AFTER `created_date`;

-- loan arears for PAR calculation
ALTER TABLE `loan_arrear` ADD `bank_provision` VARCHAR(20) NOT NULL AFTER `par`;

-- changes on institutions table
ALTER TABLE `institutions` ADD  `facebook` varchar(100) NOT NULL AFTER `sender_id`,
ADD  `twitter` varchar(100) NOT NULL AFTER `facebook`, ADD  `instagram` varchar(100) NOT NULL AFTER `twitter`, ADD  `lat` varchar(500) DEFAULT NULL AFTER `instagram`,
ADD  `lng` varchar(500) DEFAULT NULL AFTER `lat`;

-- add tables

ALTER TABLE `institutions` ADD `payment_callback` VARCHAR(500) NULL AFTER `lng`;

ALTER TABLE `sekani_wallet` ADD `sms_balance` DECIMAL(19,2) NOT NULL DEFAULT '0.00' AFTER `running_balance`, ADD `bvn_balance` DECIMAL(19,2) NOT NULL DEFAULT '0.00' AFTER `sms_balance`, ADD `bills_balance` DECIMAL(19,2) NOT NULL DEFAULT '0.00' AFTER `bvn_balance`;

-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2021 at 01:01 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sekanisy_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `wallet_transaction_cache`
--

CREATE TABLE `wallet_transaction_cache` (
  `id` int(100) NOT NULL,
  `int_id` int(100) DEFAULT NULL,
  `user_id` int(100) DEFAULT NULL,
  `reference` varchar(500) DEFAULT NULL,
  `amount` decimal(19,2) NOT NULL DEFAULT 0.00,
  `wallet_type` varchar(20) NOT NULL,
  `datetime` datetime NOT NULL,
  `status` varchar(200) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wallet_transaction_cache`
--
ALTER TABLE `wallet_transaction_cache`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wallet_transaction_cache`
--
ALTER TABLE `wallet_transaction_cache`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

ALTER TABLE `wallet_transaction_cache` ADD `description` LONGTEXT NOT NULL AFTER `wallet_type`;

ALTER TABLE `asset_type` CHANGE `total_amount` `gl_code` BIGINT(20) NULL;

-- change on inventory table
ALTER TABLE `inventory` ADD `is_book` INT(1) NOT NULL AFTER `item`;

-- drop chq_book table
DROP TABLE `chq_book`;

--
-- Table structure for table `inventory_posting`
--

CREATE TABLE `inventory_posting` (
  `id` int(100) NOT NULL,
  `int_id` int(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `branch_id` int(20) NOT NULL,
  `account_no` varchar(20) NOT NULL,
  `book_type` varchar(60) NOT NULL,
  `leaves_no` varchar(30) NOT NULL,
  `range_amount` varchar(20) NOT NULL,
  `charge_applied` int(60) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `inventory_posting`
  ADD PRIMARY KEY (`id`);
  
ALTER TABLE `inventory_posting`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

