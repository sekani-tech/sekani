CREATE TABLE `sekanisy_admin`.`prepayment_account` ( `id` INT NOT NULL AUTO_INCREMENT , `int_id` INT NOT NULL , 
`branch_id` INT NOT NULL , `year` YEAR NOT NULL , `amount` DECIMAL(19,2) NOT NULL , `gl_code` VARCHAR(20) NOT NULL , 
`expense_gl_code` VARCHAR(20) NOT NULL , `prepayment_made` DECIMAL(19,2) NOT NULL , `start_date` DATE NOT NULL , 
`end_date` DATE NOT NULL , `created_by` INT NOT NULL , `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `sekanisy_admin`.`prepayment_schedule` ( `id` INT NOT NULL AUTO_INCREMENT , `int_id` INT NOT NULL , 
`branch_id` INT NOT NULL , `prepayment_account_id` INT NOT NULL , `expense_date` DATE NOT NULL , 
`expense_amount` DECIMAL(19,2) NOT NULL , 
`expended` INT NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `sekanisy_admin`.`template_control` (
   `id` INT NOT NULL AUTO_INCREMENT , `title` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2021 at 01:06 AM
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
-- Table structure for table `administrative_control`
--

CREATE TABLE `administrative_control` (
  `id` int(11) NOT NULL,
  `int_id` int(11) NOT NULL,
  `title` varchar(40) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `grace_period` int(11) NOT NULL,
  `function_status` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrative_control`
--
ALTER TABLE `administrative_control`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrative_control`
--
ALTER TABLE `administrative_control`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


CREATE TABLE `administrative_control_transaction` ( `id` INT NOT NULL , `int_id` INT NOT NULL , 
`admin_control_id` INT NOT NULL , 
`title` VARCHAR(40) NOT NULL , `transaction_date` DATE NOT NULL , `transaction_type` VARCHAR(10) NOT NULL , 
`service_start` DATE NOT NULL , `service_end` DATE NOT NULL , 
`expense_gl` VARCHAR(20) NOT NULL , 
`transaction_id` VARCHAR(100) NOT NULL ) ENGINE = InnoDB;