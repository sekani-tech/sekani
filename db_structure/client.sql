-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2020 at 09:48 PM
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
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` bigint(20) DEFAULT NULL,
  `int_id` varchar(20) DEFAULT NULL,
  `loan_officer_id` int(100) DEFAULT NULL,
  `loan_status` varchar(50) DEFAULT NULL,
  `branch_id` int(20) DEFAULT NULL,
  `client_type` varchar(20) DEFAULT NULL,
  `account_no` varchar(20) DEFAULT NULL,
  `activation_date` date DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `display_name` varchar(100) DEFAULT NULL,
  `mobile_no` varchar(50) DEFAULT NULL,
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
  `id_img_url` varchar(200) DEFAULT NULL,
  `LGA` varchar(255) DEFAULT NULL,
  `signature` varchar(200) DEFAULT NULL,
  `passport` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
