-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 12, 2021 at 01:52 PM
-- Server version: 5.7.32-cll-lve
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sekanisy_dgmfb`
--

-- --------------------------------------------------------

--
-- Table structure for table `reversal`
--

CREATE TABLE `reversal` (
  `id` int(11) NOT NULL,
  `int_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `transaction_id` varchar(200) NOT NULL,
  `account_no` int(11) NOT NULL,
  `transact_date` date NOT NULL,
  `reversal_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `staff_id` int(11) NOT NULL,
  `teller_id` int(11) NOT NULL,
  `amount_reversed` int(11) NOT NULL,
  `account_balance_derived` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reversal`
--
ALTER TABLE `reversal`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reversal`
--
ALTER TABLE `reversal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
