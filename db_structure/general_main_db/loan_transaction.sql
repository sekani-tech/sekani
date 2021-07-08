-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 16, 2020 at 09:33 AM
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
-- Table structure for table `loan_transaction`
--

DROP TABLE IF EXISTS `loan_transaction`;
CREATE TABLE IF NOT EXISTS `loan_transaction` (
  `id` int(100) NOT NULL,
  `int_id` int(100) DEFAULT NULL,
  `branch_id` int(100) DEFAULT NULL,
  `product_id` int(100) DEFAULT NULL,
  `loan_id` int(100) DEFAULT NULL,
  `transaction_id` varchar(20) DEFAULT NULL,
  `client_id` int(100) NOT NULL,
  `account_no` varchar(20) NOT NULL,
  `is_reversed` tinyint(1) DEFAULT NULL,
  `external_id` varchar(100) DEFAULT NULL,
  `transaction_type` varchar(20) DEFAULT NULL,
  `transaction_date` date DEFAULT NULL,
  `amount` decimal(19,6) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `principal_portion_derived` decimal(19,6) DEFAULT NULL,
  `interest_portion_derived` decimal(19,6) DEFAULT NULL,
  `fee_charges_portion_derived` decimal(19,6) DEFAULT NULL,
  `penalty_charges_portion_derived` decimal(19,6) DEFAULT NULL,
  `overpayment_portion_derived` decimal(19,6) DEFAULT NULL,
  `unrecognized_income_portion` decimal(19,6) DEFAULT NULL,
  `suspended_interest_portion_derived` decimal(19,6) DEFAULT NULL,
  `suspended_fee_charges_portion_derived` decimal(19,6) DEFAULT NULL,
  `suspended_penalty_charges_portion_derived` decimal(19,6) DEFAULT NULL,
  `outstanding_loan_balance_derived` decimal(19,6) DEFAULT NULL,
  `recovered_portion_derived` decimal(19,6) DEFAULT NULL,
  `submitted_on_date` date NOT NULL,
  `manually_adjusted_or_reversed` tinyint(1) DEFAULT '0',
  `created_date` datetime DEFAULT NULL,
  `appuser_id` bigint(20) DEFAULT NULL,
  `is_account_transfer` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `int_id_loantrans` (`int_id`),
  KEY `branch_id_loantrans` (`branch_id`),
  KEY `product_id_loantrans` (`product_id`),
  KEY `loan_id_loantrans` (`loan_id`),
  KEY `client_id_loantrans` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `loan_transaction`
--
ALTER TABLE `loan_transaction`
  ADD CONSTRAINT `branch_id_loantrans` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  ADD CONSTRAINT `client_id_loantrans` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `int_id_loantrans` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`),
  ADD CONSTRAINT `loan_id_loantrans` FOREIGN KEY (`loan_id`) REFERENCES `loan` (`id`),
  ADD CONSTRAINT `product_id_loantrans` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
