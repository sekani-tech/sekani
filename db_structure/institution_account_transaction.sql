-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2020 at 11:29 AM
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
-- Table structure for table `institution_account_transaction`
--

CREATE TABLE `institution_account_transaction` (
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
  `manually_adjusted_or_reversed` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `institution_account_transaction`
--
ALTER TABLE `institution_account_transaction`
  ADD PRIMARY KEY (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
