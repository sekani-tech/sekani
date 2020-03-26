-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2020 at 03:12 PM
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
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(100) NOT NULL,
  `int_id` int(100) NULL,
  `charge_id` int(100) DEFAULT NULL,
  `name` varchar(25) DEFAULT NULL,
  `short_name` varchar(25) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `fund_id` int(100) DEFAULT NULL,
  `in_amt_multiples` int(100) DEFAULT NULL,
  `principal_amount` decimal(19,6) DEFAULT NULL,
  `min_principal_amount` decimal(19,6) DEFAULT NULL,
  `max_principal_amount` decimal(19,6) DEFAULT NULL,
  `loan_term` int(11) DEFAULT NULL,
  `min_loan_term` int(11) DEFAULT NULL,
  `max_loan_term` int(11) DEFAULT NULL,
  `repayment_frequency` int(11) DEFAULT NULL,
  `repayment_every` varchar(20) DEFAULT NULL,
  `interest_rate` decimal(19,6) DEFAULT NULL,
  `min_interest_rate` decimal(19,6) DEFAULT NULL,
  `max_interest_rate` decimal(19,6) DEFAULT NULL,
  `interest_rate_applied` varchar(50) DEFAULT NULL,
  `interest_rate_methodoloy` varchar(50) DEFAULT NULL,
  `ammortization_method` varchar(100) DEFAULT NULL,
  `cycle_count` varchar(50) DEFAULT NULL,
  `auto_allocate_overpayment` varchar(50) DEFAULT NULL,
  `additional_charge` varchar(50) DEFAULT NULL,
  `auto_disburse` varchar(50) DEFAULT NULL,
  `linked_savings_acct` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `int_id`, `charge_id`, `name`, `short_name`, `description`, `fund_id`, `in_amt_multiples`, `principal_amount`, `min_principal_amount`, `max_principal_amount`, `loan_term`, `min_loan_term`, `max_loan_term`, `repayment_frequency`, `repayment_every`, `interest_rate`, `min_interest_rate`, `max_interest_rate`, `interest_rate_applied`, `interest_rate_methodoloy`, `ammortization_method`, `cycle_count`, `auto_allocate_overpayment`, `additional_charge`, `auto_disburse`, `linked_savings_acct`) VALUES
(1, 6, NULL, 'DG Microcredit', 'DGM', 'Microcredit Loan', 1, NULL, '10000.000000', '10000.000000', '300000.000000', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL),
(2, 6, NULL, 'DG Individual Loan', 'DGIL', 'Individual Loan', 1, NULL, '30000.000000', '30000.000000', '2000000.000000', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL),
(3, 6, NULL, 'Salary Advance', 'DSA', 'Loan For Salary Earners', 1, NULL, '40000.000000', '40000.000000', '200000.000000', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL),
(4, 6, NULL, 'Staff Loan', 'SL', 'Staff Loan', 1, NULL, '1000.000000', '1000.000000', '5000000.000000', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL),
(5, 6, NULL, 'School Aid', 'SC', 'Loan for schools', 1, NULL, '50000.000000', '50000.000000', '5000000.000000', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL),
(6, 6, NULL, 'Energy Loan', 'EL', 'Energy Loan', 1, NULL, '10000.000000', '10000.000000', '10000000.000000', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_charge_id` (`charge_id`),
  ADD KEY `product_int_id` (`int_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_charge_id` FOREIGN KEY (`charge_id`) REFERENCES `charge` (`id`),
  ADD CONSTRAINT `product_int_id` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
