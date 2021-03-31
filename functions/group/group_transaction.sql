-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2021 at 12:26 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.32

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
-- Table structure for table `group_transaction`
--

CREATE TABLE `group_transaction` (
  `id` int(100) NOT NULL,
  `int_id` int(100) NOT NULL,
  `branch_id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `account_id` int(100) DEFAULT NULL,
  `account_no` varchar(100) NOT NULL,
  `client_id` int(100) NOT NULL,
  `teller_id` int(100) DEFAULT NULL,
  `transaction_id` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `transaction_type` varchar(50) NOT NULL,
  `is_reversed` tinyint(1) NOT NULL,
  `transaction_date` date DEFAULT NULL,
  `amount` decimal(19,2) NOT NULL,
  `overdraft_amount_derived` decimal(19,2) DEFAULT NULL,
  `balance_end_date_derived` date DEFAULT NULL,
  `balance_number_of_days_derived` int(11) DEFAULT NULL,
  `running_balance_derived` decimal(19,2) DEFAULT NULL,
  `cumulative_balance_derived` decimal(19,2) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `chooseDate` datetime DEFAULT NULL,
  `appuser_id` bigint(20) DEFAULT NULL,
  `manually_adjusted_or_reversed` tinyint(1) DEFAULT 0,
  `debit` decimal(19,2) NOT NULL,
  `credit` decimal(19,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `group_transaction`
--
ALTER TABLE `group_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `int_id_acctrans` (`int_id`),
  ADD KEY `account_id_acctrans` (`account_id`),
  ADD KEY `client_id_acctrans` (`client_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `group_transaction`
--
ALTER TABLE `group_transaction`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
