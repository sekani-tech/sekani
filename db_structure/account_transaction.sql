-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 12, 2020 at 02:14 PM
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
-- Table structure for table `account_transaction`
--

DROP TABLE IF EXISTS `account_transaction`;
CREATE TABLE IF NOT EXISTS `account_transaction` (
  `id` int(100) NOT NULL,
  `int_id` int(100) NOT NULL,
  `branch_id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `account_id` int(100) NOT NULL,
  `account_no` varchar(100) NOT NULL,
  `client_id` int(100) NOT NULL,
  `tansaction_id` varchar(20) NOT NULL,
  `transaction_type` varchar(50) NOT NULL,
  `is_reversed` tinyint(1) NOT NULL,
  `transaction_date` date NOT NULL,
  `amount` decimal(19,6) NOT NULL,
  `overdraft_amount_derived` decimal(19,6) DEFAULT NULL,
  `balance_end_date_derived` date DEFAULT NULL,
  `balance_number_of_days_derived` int(11) DEFAULT NULL,
  `running_balance_derived` decimal(19,6) DEFAULT NULL,
  `cumulative_balance_derived` decimal(19,6) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `appuser_id` bigint(20) DEFAULT NULL,
  `manually_adjusted_or_reversed` tinyint(1) DEFAULT '0',
  KEY `int_id_acctrans` (`int_id`),
  KEY `branch_id_acctrans` (`branch_id`),
  KEY `product_id_acctrans` (`product_id`),
  KEY `account_id_acctrans` (`account_id`),
  KEY `client_id_acctrans` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_transaction`
--
ALTER TABLE `account_transaction`
  ADD CONSTRAINT `account_id_acctrans` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`),
  ADD CONSTRAINT `branch_id_acctrans` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  ADD CONSTRAINT `client_id_acctrans` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `int_id_acctrans` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`),
  ADD CONSTRAINT `product_id_acctrans` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
