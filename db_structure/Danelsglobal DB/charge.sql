-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2020 at 03:11 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `charge`
--

CREATE TABLE `charge` (
  `id` int(100) NOT NULL,
  `int_id` int(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `currency_code` varchar(3) NOT NULL,
  `charge_applies_to_enum` smallint(5) NOT NULL,
  `charge_time_enum` smallint(5) NOT NULL,
  `charge_calculation_enum` smallint(5) NOT NULL,
  `charge_payment_mode_enum` smallint(5) DEFAULT NULL,
  `amount` decimal(19,6) NOT NULL,
  `fee_on_day` smallint(5) DEFAULT NULL,
  `fee_interval` smallint(5) DEFAULT NULL,
  `fee_on_month` smallint(5) DEFAULT NULL,
  `is_penalty` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL,
  `allow_override` tinyint(1) DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `min_cap` decimal(19,6) DEFAULT NULL,
  `max_cap` decimal(19,6) DEFAULT NULL,
  `fee_frequency` smallint(5) DEFAULT NULL,
  `income_or_liability_account_id` bigint(20) DEFAULT NULL,
  `tax_group_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `charge`
--

INSERT INTO `charge` (`id`, `int_id`, `name`, `currency_code`, `charge_applies_to_enum`, `charge_time_enum`, `charge_calculation_enum`, `charge_payment_mode_enum`, `amount`, `fee_on_day`, `fee_interval`, `fee_on_month`, `is_penalty`, `is_active`, `allow_override`, `is_deleted`, `min_cap`, `max_cap`, `fee_frequency`, `income_or_liability_account_id`, `tax_group_id`) VALUES
(1, 6, 'Account Re-activation', 'NGN', 2, 2, 1, 0, '500.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(2, 6, 'Cheque Booklet', 'NGN', 2, 2, 1, 0, '2000.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(3, 6, 'Cheque Booklet - Manual', 'NGN', 2, 2, 1, 0, '2000.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(4, 6, 'Cheque Booklet - Staff', 'NGN', 2, 2, 1, 0, '1500.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(5, 6, 'Late Coming', 'NGN', 2, 2, 1, 0, '500.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(6, 6, 'Legal Fees', 'NGN', 1, 1, 7, 1, '1.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(7, 6, 'Loan Application Foam - Individual', 'NGN', 1, 1, 1, 1, '3000.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(8, 6, 'Loan Application Form ', 'NGN', 1, 1, 1, 1, '2000.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(9, 6, 'Loan Insurance', 'NGN', 1, 1, 7, 1, '1.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(10, 6, 'Loan Maturity Fee', 'NGN', 1, 15, 6, 0, '10.000000', NULL, NULL, NULL, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(11, 6, 'Loan Penalty', 'NGN', 1, 2, 3, 1, '15.000000', NULL, NULL, NULL, 1, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(12, 6, 'Management Fee 2%', 'NGN', 1, 1, 7, 1, '2.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(13, 6, 'Group Acct Opening', 'NGN', 2, 2, 1, 0, '10000.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(14, 6, 'Pass Booklet', 'NGN', 2, 2, 1, 0, '500.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(15, 6, 'Loan Processing fees', 'NGN', 1, 1, 7, 0, '2.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(16, 6, 'SMS Alert', 'NGN', 2, 7, 1, 0, '100.000000', 28, 1, 4, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(17, 6, 'Stamp Duty', 'NGN', 2, 2, 1, 0, '50.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(18, 6, 'Transfer charges', 'NGN', 2, 2, 1, 0, '200.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(19, 6, 'Management Fee 1%', 'NGN', 1, 1, 7, 1, '1.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(20, 6, 'Acct Maintance Fees', 'NGN', 2, 7, 1, 0, '200.000000', 24, 1, 5, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(21, 6, 'Name Search', 'NGN', 2, 2, 1, 0, '5000.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(22, 6, 'Credit Reference Search', 'NGN', 1, 1, 1, 0, '500.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(23, 6, 'BVN Search', 'NGN', 2, 2, 1, 0, '200.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(24, 6, 'Group membership Fees', 'NGN', 2, 2, 1, 0, '300.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(25, 6, 'DASUSU Passbook', 'NGN', 2, 2, 1, 0, '200.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(26, 6, 'EL Mgt Fees', 'NGN', 1, 1, 7, 1, '1.500000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(27, 6, 'EL Processing Fees', 'NGN', 1, 1, 7, 1, '1.500000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(28, 6, 'EL Insurance', 'NGN', 1, 1, 7, 1, '1.500000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(29, 6, 'One Day Charge(200)', 'NGN', 2, 2, 1, 0, '200.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(30, 6, 'One Day Charge (500)', 'NGN', 2, 2, 1, 0, '500.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(31, 6, 'One Day Charge (1000)', 'NGN', 2, 2, 1, 0, '1000.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(32, 6, 'One Day Charge (700)', 'NGN', 2, 2, 1, 0, '700.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(33, 6, 'One Day Charge (2000)', 'NGN', 2, 2, 1, 0, '2000.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(34, 6, 'One Day Charge (5000)', 'NGN', 2, 2, 1, 0, '5000.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(35, 6, 'One Day Charge (10000)', 'NGN', 2, 2, 1, 0, '10000.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(36, 6, 'One Day Charge(100)', 'NGN', 2, 2, 1, 0, '100.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(37, 6, 'Counter Cheque (200) Current Account', 'NGN', 2, 2, 1, 0, '200.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL),
(38, 6, 'Counter Cheque (100) Savings Account', 'NGN', 2, 2, 1, 0, '100.000000', NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `charge`
--
ALTER TABLE `charge`
  ADD PRIMARY KEY (`id`),
  ADD KEY `charge_int_id` (`int_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `charge`
--
ALTER TABLE `charge`
  ADD CONSTRAINT `charge_int_id` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
