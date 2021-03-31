-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 30, 2021 at 01:35 AM
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
-- Database: `sekanisy_realaid`
--

-- --------------------------------------------------------

--
-- Table structure for table `group_balance`
--

CREATE TABLE `group_balance` (
  `id` int(11) NOT NULL,
  `int_id` int(11) NOT NULL,
  `branch_name` varchar(255) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `group_id` int(11) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `loan_officer_name` varchar(255) NOT NULL,
  `submitted_on_date` date NOT NULL,
  `approved_on_date` date NOT NULL,
  `activated_on_date` date NOT NULL,
  `account_no` varchar(11) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `total_deposits_derived` int(50) NOT NULL,
  `total_withdrawals_derived` int(50) NOT NULL,
  `total_fees_charge_derived` int(50) NOT NULL,
  `account_balance_derived` int(50) NOT NULL,
  `Last_activity_date` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `group_balance`
--
ALTER TABLE `group_balance`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `group_balance`
--
ALTER TABLE `group_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;




ALTER TABLE `group_balance` CHANGE `Last_activity_date` `Last_activity_date` DATE NOT NULL;
ALTER TABLE `group_balance` CHANGE `product_Id` `product_id` INT(11) NOT NULL;
ALTER TABLE `group_balance` CHANGE `group_Id` `group_id` INT(11) NOT NULL;
ALTER TABLE `group_balance` CHANGE `client_Id` `client_id` INT(11) NOT NULL;
ALTER TABLE `group_balance` CHANGE `Status` `status` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;