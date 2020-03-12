-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 11, 2020 at 02:01 PM
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
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `int_id` int(100) DEFAULT NULL,
  `loan_officer_id` int(100) DEFAULT NULL,
  `loan_status` varchar(50) DEFAULT NULL,
  `branch_id` int(100) DEFAULT NULL,
  `client_type` varchar(20) DEFAULT NULL,
  `account_no` varchar(20) DEFAULT NULL,
  `activation_date` date DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `display_name` varchar(100) DEFAULT NULL,
  `mobile_no` varchar(50) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `is_staff` tinyint(1) DEFAULT '0',
  `date_of_birth` varchar(100) DEFAULT NULL,
  `image_id` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_on` date DEFAULT NULL,
  `submittedon_date` date DEFAULT NULL,
  `email_address` varchar(150) DEFAULT NULL,
  `mobile_no_2` varchar(50) DEFAULT NULL,
  `BVN` varchar(255) DEFAULT NULL,
  `ADDRESS` varchar(255) DEFAULT NULL,
  `STATE_OF_ORIGIN` varchar(255) DEFAULT NULL,
  `COUNTRY` varchar(255) DEFAULT NULL,
  `SMS_ACTIVE` smallint(6) DEFAULT '0',
  `EMAIL_ACTIVE` smallint(6) DEFAULT '0',
  `id_card` varchar(50) DEFAULT NULL,
  `id_img_url` longtext CHARACTER SET utf8 COLLATE utf8_general_ci,
  `LGA` varchar(255) DEFAULT NULL,
  `signature` longtext CHARACTER SET utf8 COLLATE utf8_general_ci,
  `passport` longtext CHARACTER SET utf8 COLLATE utf8_general_ci,
  PRIMARY KEY (`id`),
  KEY `int_id_client` (`int_id`),
  KEY `loan_officer_id_client` (`loan_officer_id`),
  KEY `branch_id_client` (`branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `branch_id_client` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  ADD CONSTRAINT `int_id_client` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`),
  ADD CONSTRAINT `loan_officer_id_client` FOREIGN KEY (`loan_officer_id`) REFERENCES `staff` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
