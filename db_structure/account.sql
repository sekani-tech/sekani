-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 12, 2020 at 01:14 PM
-- Server version: 8.0.18
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sekani_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `int_id` int(100) DEFAULT NULL,
  `branch_id` int(100) DEFAULT NULL,
  `account_no` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `account_type` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `client_id` int(100) DEFAULT NULL,
  `product_id` int(100) DEFAULT NULL,
  `field_officer_id` int(100) DEFAULT NULL,
  `group_id` bigint(20) DEFAULT NULL,
  `deposit_type_enum` smallint(5) NOT NULL DEFAULT '100',
  `submittedon_date` date NOT NULL,
  `submittedon_userid` bigint(20) DEFAULT NULL,
  `approvedon_date` date DEFAULT NULL,
  `approvedon_userid` bigint(20) DEFAULT NULL,
  `currency_code` varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'NGN',
  `currency_digits` smallint(5) NOT NULL DEFAULT '2',
  `activatedon_date` date DEFAULT NULL,
  `activatedon_userid` bigint(20) DEFAULT NULL,
  `closedon_date` date DEFAULT NULL,
  `closedon_userid` bigint(20) DEFAULT NULL,
  `currency_multiplesof` smallint(5) DEFAULT '2',
  `nominal_annual_interest_rate` decimal(19,6) DEFAULT NULL,
  `interest_compounding_period_enum` smallint(5) DEFAULT NULL,
  `interest_posting_period_enum` smallint(5) NOT NULL DEFAULT '4',
  `interest_calculation_type_enum` smallint(5) DEFAULT NULL,
  `interest_calculation_days_in_year_type_enum` smallint(5) DEFAULT NULL,
  `min_required_opening_balance` decimal(19,6) DEFAULT NULL,
  `lockin_period_frequency` decimal(19,6) DEFAULT NULL,
  `lockin_period_frequency_enum` smallint(5) DEFAULT NULL,
  `withdrawal_fee_for_transfer` tinyint(4) DEFAULT '1',
  `allow_overdraft` tinyint(1) NOT NULL DEFAULT '0',
  `overdraft_limit` decimal(19,6) DEFAULT NULL,
  `nominal_annual_interest_rate_overdraft` decimal(19,6) DEFAULT '0.000000',
  `min_overdraft_for_interest_calculation` decimal(19,6) DEFAULT '0.000000',
  `min_required_balance` decimal(19,6) DEFAULT NULL,
  `min_balance_for_interest_calculation` decimal(19,6) DEFAULT NULL,
  `lockedin_until_date_derived` date DEFAULT NULL,
  `total_deposits_derived` decimal(19,6) DEFAULT NULL,
  `total_withdrawals_derived` decimal(19,6) DEFAULT NULL,
  `total_withdrawal_fees_derived` decimal(19,6) DEFAULT NULL,
  `total_fees_charge_derived` decimal(19,6) DEFAULT NULL,
  `total_penalty_charge_derived` decimal(19,6) DEFAULT NULL,
  `total_annual_fees_derived` decimal(19,6) DEFAULT NULL,
  `total_quarterly_fees_owed_derived` decimal(19,6) DEFAULT NULL,
  `total_quarterly_fees_derived` decimal(19,6) DEFAULT NULL,
  `total_interest_earned_derived` decimal(19,6) DEFAULT NULL,
  `total_interest_posted_derived` decimal(19,6) DEFAULT NULL,
  `total_overdraft_interest_derived` decimal(19,6) DEFAULT '0.000000',
  `total_withhold_tax_derived` decimal(19,6) DEFAULT NULL,
  `total_writtenoff_derived` decimal(19,6) DEFAULT NULL,
  `enforce_min_required_balance` tinyint(1) NOT NULL DEFAULT '0',
  `start_interest_calculation_date` date DEFAULT NULL,
  `on_hold_funds_derived` decimal(19,6) DEFAULT NULL,
  `version` int(15) NOT NULL DEFAULT '1',
  `account_balance_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `rejectedon_date` date DEFAULT NULL,
  `rejectedon_userid` bigint(20) DEFAULT NULL,
  `withdrawnon_date` date DEFAULT NULL,
  `withdrawnon_userid` bigint(20) DEFAULT NULL,
  `auto_renew_on_closure` tinyint(1) NOT NULL DEFAULT '0',
  `withhold_tax` tinyint(4) NOT NULL DEFAULT '0',
  `tax_group_id` bigint(20) DEFAULT NULL,
  `last_interest_calculation_date` date DEFAULT NULL,
  `last_activity_date` date DEFAULT NULL,
  `last_quarterly_calculation_date` date DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `int_id_acct` (`int_id`),
  KEY `client_id_acct` (`client_id`),
  KEY `branch_id_acct` (`branch_id`),
  KEY `product_id_acct` (`product_id`),
  KEY `field_officer_id_acct` (`field_officer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `branch_id_acct` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  ADD CONSTRAINT `client_id_acct` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `field_officer_id_acct` FOREIGN KEY (`field_officer_id`) REFERENCES `staff` (`user_id`),
  ADD CONSTRAINT `int_id_acct` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`),
  ADD CONSTRAINT `product_id_acct` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
