-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2020 at 01:54 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sekanisy_danelsglobal`
--

-- --------------------------------------------------------

--
-- Table structure for table `m_client`
--

CREATE TABLE `clients` (
  `id` bigint(20) NULL,
  `int_id` varchar(20) NULL,
  `loan_officer_id` INT(100) NULL,
  `loan_status` varchar(50) NULL,
  `branch_id` INT(20) NULL,
  `client_type` varchar(20) NULL,
  `account_no` varchar(20) NULL,
  `activation_date` date DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `display_name` varchar(100) NULL,
  `mobile_no` varchar(50) DEFAULT NULL,
  `is_staff` tinyint(1) NULL DEFAULT '0',
  `date_of_birth` varchar(100) NULL,
  `image_id` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_on` date DEFAULT NULL,
  `email_address` varchar(150) DEFAULT NULL,
  `mobile_no_2` varchar(50) DEFAULT NULL,
  `BVN` varchar(255) DEFAULT NULL,
  `ADDRESS` varchar(255) DEFAULT NULL,
  `STATE_OF_ORIGIN` varchar(255) DEFAULT NULL,
  `COUNTRY` varchar(255) DEFAULT NULL,
  `SMS_ACTIVE` smallint(6) NULL DEFAULT '0',
  `EMAIL_ACTIVE` smallint(6) NULL DEFAULT '0',
  `id_card` varchar(50) NULL,
  `id_img_url` varchar(200) NULL,
  `LGA` varchar(255) DEFAULT NULL,
  `signature` varchar(200) NULL,
  `passport` varchar(200) NULL
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `m_client` (`id`, `int_id`, `loan_status`, `loan_officer_id`, `branch_id`, `client_type`, `account_no`, `activation_date`, `firstname`, `middlename`, `lastname`, `display_name`, `mobile_no`, `is_staff`, `date_of_birth`, `image_id`, `updated_by`, `updated_on`, `submittedon_date`, `email_address`, `mobile_no_2`, `BVN`, `ADDRESS`, `STATE_OF_ORIGIN`,  `COUNTRY`, `SMS_ACTIVE`, `EMAIL_ACTIVE`, `id_card`, `id_img_url`, `LGA`, `signature`, `passport`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, '0002-0013-0001', '2019-02-11', 'AR-RAIHAAN ISLAMIC', NULL, 'SCHOOL LIMITED 2', 'AR-RAIHAAN ISLAMIC SCHOOL LIMITED 2', '08037239008', 0, '', NULL, NULL, NULL, '2019-02-11', 'dewale_deyemi@yahoo.com', NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),



--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_client`
--
