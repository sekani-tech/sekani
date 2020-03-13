-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 13, 2020 at 10:38 AM
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
-- Table structure for table `institution_account_transaction`
--

DROP TABLE IF EXISTS `institution_account_transaction`;
CREATE TABLE IF NOT EXISTS `institution_account_transaction` (
  `id` int(100) NOT NULL,
  `int_id` int(100) NOT NULL,
  `branch_id` int(100) NOT NULL,
  `client_id` int(100) NOT NULL,
  `tansaction_id` varchar(20) NOT NULL,
  `transaction_type` varchar(50) NOT NULL,
  `is_reversed` tinyint(1) NOT NULL,
  `transaction_date` date NOT NULL,
  `amount` decimal(19,6) NOT NULL,
  `running_balance_derived` decimal(19,6) DEFAULT NULL,
  `overdraft_amount_derived` decimal(19,6) DEFAULT NULL,
  `balance_end_date_derived` date DEFAULT NULL,
  `balance_number_of_days_derived` int(11) DEFAULT NULL,
  `cumulative_balance_derived` decimal(19,6) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `appuser_id` bigint(20) DEFAULT NULL,
  `manually_adjusted_or_reversed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `int_id_intacct` (`int_id`),
  KEY `brh_id_intacct` (`branch_id`),
  KEY `client_id_intacct` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `institution_account_transaction`
--
ALTER TABLE `institution_account_transaction`
  ADD CONSTRAINT `brh_id_intacct` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  ADD CONSTRAINT `client_id_intacct` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `int_id_intacct` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
