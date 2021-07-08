-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 05, 2020 at 01:00 AM
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
-- Table structure for table `charge`
--

DROP TABLE IF EXISTS `charge`;
CREATE TABLE IF NOT EXISTS `charge` (
  `id` int(100) NOT NULL,
  `int_id` int(100) DEFAULT NULL,
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
  `tax_group_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `charge_int_id` (`int_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `charge`
--

INSERT INTO `charge` (`id`, `int_id`, `name`, `currency_code`, `charge_applies_to_enum`, `charge_time_enum`, `charge_calculation_enum`, `charge_payment_mode_enum`, `amount`, `fee_on_day`, `fee_interval`, `fee_on_month`, `is_penalty`, `is_active`, `allow_override`, `is_deleted`, `min_cap`, `max_cap`, `fee_frequency`, `income_or_liability_account_id`, `tax_group_id`) VALUES
(1, 6, 'something', 'NGN', 1, 1, 1, 1, '10.000000', 1, 0, 0, 0, 0, 0, 0, '1.000000', '1.000000', 1, 1, 1),
(2, 6, 'Flint', 'NGN', 2, 2, 2, 2, '500.000000', 3, 3, 3, 0, 0, 0, 0, '5.000000', '6.000000', 7, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `int_id` int(100) DEFAULT NULL,
  `loan_officer_id` int(100) DEFAULT NULL,
  `loan_officer` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `loan_status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bank` varchar(100) DEFAULT NULL,
  `acct_no` varchar(20) DEFAULT NULL,
  `display_name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `phone2` varchar(15) DEFAULT NULL,
  `addres` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `gender` varchar(20) DEFAULT NULL,
  `is_staff` varchar(10) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `img` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `gau_first_name` varchar(50) DEFAULT NULL,
  `gau_last_name` varchar(50) DEFAULT NULL,
  `gau_phone` varchar(15) DEFAULT NULL,
  `gau_phone2` varchar(15) DEFAULT NULL,
  `gau_home_address` longtext,
  `gau_office_address` longtext,
  `gau_position_held` varchar(100) DEFAULT NULL,
  `gau_email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `int_id_client` (`int_id`),
  KEY `l_o_id` (`loan_officer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `int_id`, `loan_officer_id`, `loan_officer`, `loan_status`, `bank`, `acct_no`, `display_name`, `email`, `first_name`, `last_name`, `phone`, `phone2`, `addres`, `gender`, `is_staff`, `date_of_birth`, `img`, `gau_first_name`, `gau_last_name`, `gau_phone`, `gau_phone2`, `gau_home_address`, `gau_office_address`, `gau_position_held`, `gau_email`) VALUES
(1, 6, 2, 'sammy', 'No', 'WEMA', '203748499', 'client1', 'client@gmail.com', 'client', 'client2', '081', '080', 'client address', 'Male', 'No', '2020-02-26', 'https://url', 'kin', 'kina', '081', '080', 'kin', 'kin', 'kin', 'kin@gmail.com'),
(3, 6, 2, 'sammy', 'No', 'FIRST BANK', '0728273833', 'samm', 'flinttech@gmail.com', 'h', 'c', '2', '3', 'd', 'Female', 'Yes', '2020-02-05', 'https://url', 'sanusi', 's', '8', '7', 'd', 'd', 'CEO', 'sanusi@gmail.com'),
(4, 6, 18, 'teston', 'No', 'UBA', '03949294949', 'frank', 'frank@gmail.com', 'frk', 'frk', '08162399614', '09012323455', 'fk2 H', 'Male', 'No', '1999-02-11', 'https://location', 'ok', 'is', '02837747', '0938383', 'somewhere', 'somewhere', 'something', 'ok@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `collateral`
--

DROP TABLE IF EXISTS `collateral`;
CREATE TABLE IF NOT EXISTS `collateral` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `int_id` int(100) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `value` varchar(100) DEFAULT NULL,
  `description` longtext,
  PRIMARY KEY (`id`),
  KEY `int_id_collateral` (`int_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `collateral`
--

INSERT INTO `collateral` (`id`, `int_id`, `type`, `value`, `description`) VALUES
(1, 6, 'Fixed Asset', 'Land', 'Have a land somewhere.');

-- --------------------------------------------------------

--
-- Table structure for table `credit_check`
--

DROP TABLE IF EXISTS `credit_check`;
CREATE TABLE IF NOT EXISTS `credit_check` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `related_entity_enum_value` smallint(2) NOT NULL,
  `expected_result` int(11) DEFAULT NULL,
  `severity_level_enum_value` smallint(2) NOT NULL,
  `stretchy_report_id` int(11) NOT NULL,
  `stretchy_report_param_map` varchar(200) DEFAULT NULL,
  `general_error_message` varchar(500) NOT NULL,
  `user_friendly_error_message` varchar(500) NOT NULL,
  `general_warning_message` varchar(500) NOT NULL,
  `general_success_message` varchar(500) NOT NULL,
  `user_friendly_success_message` varchar(500) NOT NULL,
  `user_friendly_warning_message` varchar(500) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `rating_type` int(11) NOT NULL DEFAULT '1' COMMENT '1 stands for boolean type and 2 stands for score type'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `funds`
--

DROP TABLE IF EXISTS `funds`;
CREATE TABLE IF NOT EXISTS `funds` (
  `id` int(100) NOT NULL,
  `int_id` int(100) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `institutions`
--

DROP TABLE IF EXISTS `institutions`;
CREATE TABLE IF NOT EXISTS `institutions` (
  `int_id` int(100) NOT NULL AUTO_INCREMENT,
  `int_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rcn` varchar(25) DEFAULT NULL,
  `int_state` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lga` varchar(25) DEFAULT NULL,
  `office_address` longtext,
  `office_phone` varchar(25) DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `pc_title` varchar(10) DEFAULT NULL,
  `pc_surname` varchar(25) DEFAULT NULL,
  `pc_other_name` varchar(25) DEFAULT NULL,
  `pc_designation` varchar(25) DEFAULT NULL,
  `pc_phone` varchar(25) DEFAULT NULL,
  `pc_email` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`int_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `institutions`
--

INSERT INTO `institutions` (`int_id`, `int_name`, `rcn`, `int_state`, `lga`, `office_address`, `office_phone`, `email`, `website`, `pc_title`, `pc_surname`, `pc_other_name`, `pc_designation`, `pc_phone`, `pc_email`) VALUES
(3, 'Flint technology LTD', '12637484RC', 'FCT', 'AMAC', 'Federal Ministry of Finance', '0816239961', 'sunnyboye2015@gmail.com', 'www.flinttech@gmail.com', 'Mr', 'jsjs', 'jimmy', 'jimmy', '09034567648', 'ff@m.c'),
(6, 'Dally', '20192293RC', 'FCT', 'AMAC', 'Karu Abuja', '+2348162399614', 'Dally@gmail.com', 'www.dally.com', 'Mr', 'samuel', 'james', 'kemi', '+2349078695849', 'jamesp@yahoo.com'),
(7, 'Sekani Systems', '100test', 'FCT', 'AMAC', 'Monrovia Street no 22, Wuse II ABUJA.', '08162399614', 'sekanisystems@gmail.com', 'www.sekanisystems.com', 'Mr', 'Samuel', 'Tosin', 'Ajiboye', '09012384783', 'sun@gmail.com'),
(8, 'Sammy', '20091', 'FCT', 'AMAC', 'somewhere', '092nn', 'sammy@gmail.com', 'www.flinttech.com', 'Mr', 'samuel', 'james', 'something', '08162399762', 'sunn@N.c'),
(9, 'danels global', '0', 'Abuja', 'null', 'null', '081', 'danielsglobal@d.com', 'www.danielsglobal.com', 'name', 'surname', 'name', 'name', '081', 'email@email.com');

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

DROP TABLE IF EXISTS `loan`;
CREATE TABLE IF NOT EXISTS `loan` (
  `id` int(100) NOT NULL,
  `int_id` int(100) DEFAULT NULL,
  `account_no` varchar(20) NOT NULL,
  `client_id` int(100) DEFAULT NULL,
  `product_id` int(100) DEFAULT NULL,
  `fund_id` bigint(20) DEFAULT NULL,
  `loan_officer` varchar(50) DEFAULT NULL,
  `loan_purpose` varchar(100) DEFAULT NULL,
  `currency_code` varchar(3) NOT NULL,
  `currency_digits` smallint(5) NOT NULL,
  `principal_amount_proposed` decimal(19,6) NOT NULL,
  `principal_amount` decimal(19,6) NOT NULL,
  `loan_term` int(100) DEFAULT NULL,
  `interest_rate` decimal(19,6) DEFAULT NULL,
  `approved_principal` decimal(19,6) NOT NULL,
  `arrearstolerance_amount` decimal(19,6) DEFAULT NULL,
  `is_floating_interest_rate` bit(1) DEFAULT b'0',
  `interest_rate_differential` decimal(19,6) DEFAULT '0.000000',
  `nominal_interest_rate_per_period` decimal(19,6) DEFAULT NULL,
  `interest_period_frequency_enum` smallint(5) DEFAULT NULL,
  `annual_nominal_interest_rate` decimal(19,6) DEFAULT NULL,
  `interest_method_enum` smallint(5) NOT NULL,
  `interest_calculated_in_period_enum` smallint(5) NOT NULL DEFAULT '1',
  `allow_partial_period_interest_calcualtion` tinyint(1) NOT NULL DEFAULT '0',
  `term_frequency` smallint(5) NOT NULL DEFAULT '0',
  `term_period_frequency_enum` smallint(5) NOT NULL DEFAULT '2',
  `repay_every` varchar(100) DEFAULT NULL,
  `repayment_period_frequency_enum` smallint(5) NOT NULL,
  `number_of_repayments` smallint(5) NOT NULL,
  `grace_on_principal_periods` smallint(5) DEFAULT NULL,
  `recurring_moratorium_principal_periods` smallint(5) DEFAULT NULL,
  `grace_on_interest_periods` smallint(5) DEFAULT NULL,
  `grace_interest_free_periods` smallint(5) DEFAULT NULL,
  `amortization_method` smallint(5) NOT NULL,
  `submittedon_date` date DEFAULT NULL,
  `submittedon_userid` bigint(20) DEFAULT NULL,
  `approvedon_date` date DEFAULT NULL,
  `approvedon_userid` bigint(20) DEFAULT NULL,
  `expected_disbursedon_date` date DEFAULT NULL,
  `expected_firstrepaymenton_date` date DEFAULT NULL,
  `interest_calculated_from_date` date DEFAULT NULL,
  `disbursement_date` date DEFAULT NULL,
  `disbursedon_userid` bigint(20) DEFAULT NULL,
  `expected_maturedon_date` date DEFAULT NULL,
  `maturedon_date` date DEFAULT NULL,
  `closedon_date` date DEFAULT NULL,
  `closedon_userid` bigint(20) DEFAULT NULL,
  `total_charges_due_at_disbursement_derived` decimal(19,6) DEFAULT NULL,
  `principal_disbursed_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `principal_repaid_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `principal_writtenoff_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `principal_outstanding_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `interest_charged_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `interest_repaid_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `interest_waived_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `interest_writtenoff_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `interest_outstanding_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `fee_charges_charged_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `fee_charges_repaid_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `fee_charges_waived_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `fee_charges_writtenoff_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `fee_charges_outstanding_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `penalty_charges_charged_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `penalty_charges_repaid_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `penalty_charges_waived_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `penalty_charges_writtenoff_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `penalty_charges_outstanding_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `total_expected_repayment_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `total_repayment_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `total_expected_costofloan_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `total_costofloan_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `total_waived_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `total_writtenoff_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `total_outstanding_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `total_overpaid_derived` decimal(19,6) DEFAULT NULL,
  `rejectedon_date` date DEFAULT NULL,
  `rejectedon_userid` bigint(20) DEFAULT NULL,
  `rescheduledon_date` date DEFAULT NULL,
  `rescheduledon_userid` bigint(20) DEFAULT NULL,
  `withdrawnon_date` date DEFAULT NULL,
  `withdrawnon_userid` bigint(20) DEFAULT NULL,
  `writtenoffon_date` date DEFAULT NULL,
  `loan_transaction_strategy_id` bigint(20) DEFAULT NULL,
  `sync_disbursement_with_meeting` tinyint(1) DEFAULT NULL,
  `loan_counter` smallint(6) DEFAULT NULL,
  `loan_product_counter` smallint(6) DEFAULT NULL,
  `fixed_emi_amount` decimal(19,6) DEFAULT NULL,
  `max_outstanding_loan_balance` decimal(19,6) DEFAULT NULL,
  `grace_on_arrears_ageing` smallint(5) DEFAULT NULL,
  `is_npa` tinyint(1) NOT NULL DEFAULT '0',
  `is_in_duplum` tinyint(1) NOT NULL DEFAULT '0',
  `is_suspended_income` tinyint(1) NOT NULL DEFAULT '0',
  `total_recovered_derived` decimal(19,6) DEFAULT NULL,
  `accrued_till` date DEFAULT NULL,
  `interest_recalcualated_on` date DEFAULT NULL,
  `days_in_month_enum` smallint(5) NOT NULL DEFAULT '1',
  `days_in_year_enum` smallint(5) NOT NULL DEFAULT '1',
  `interest_recalculation_enabled` tinyint(4) NOT NULL DEFAULT '0',
  `guarantee_amount_derived` decimal(19,6) DEFAULT NULL,
  `create_standing_instruction_at_disbursement` tinyint(1) DEFAULT NULL,
  `version` int(15) NOT NULL DEFAULT '1',
  `writeoff_reason_cv_id` int(11) DEFAULT NULL,
  `loan_sub_status_id` smallint(5) DEFAULT NULL,
  `is_topup` tinyint(1) NOT NULL DEFAULT '0',
  `repay_principal_every` int(11) NOT NULL DEFAULT '1',
  `repay_interest_every` int(11) NOT NULL DEFAULT '1',
  `restrict_linked_savings_product_type` bigint(20) DEFAULT NULL,
  `mandatory_savings_percentage` decimal(19,6) DEFAULT NULL,
  `internal_rate_of_return` decimal(19,2) DEFAULT '0.00',
  KEY `int_id_loan` (`int_id`),
  KEY `product_id_loan` (`product_id`),
  KEY `client_id_loan` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `org_role`
--

DROP TABLE IF EXISTS `org_role`;
CREATE TABLE IF NOT EXISTS `org_role` (
  `int_id` int(100) DEFAULT NULL,
  `role` varchar(200) DEFAULT NULL,
  `permission` int(11) DEFAULT NULL,
  KEY `int_id_row` (`int_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `org_role`
--

INSERT INTO `org_role` (`int_id`, `role`, `permission`) VALUES
(6, 'HR', NULL),
(6, 'CEO', NULL),
(7, 'OWNER', NULL),
(6, 'FRONT DESK CLERK', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `int_id` int(100) DEFAULT NULL,
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
  `linked_savings_acct` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_charge_id` (`charge_id`),
  KEY `product_int_id` (`int_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `int_id`, `charge_id`, `name`, `short_name`, `description`, `fund_id`, `in_amt_multiples`, `principal_amount`, `min_principal_amount`, `max_principal_amount`, `loan_term`, `min_loan_term`, `max_loan_term`, `repayment_frequency`, `repayment_every`, `interest_rate`, `min_interest_rate`, `max_interest_rate`, `interest_rate_applied`, `interest_rate_methodoloy`, `ammortization_method`, `cycle_count`, `auto_allocate_overpayment`, `additional_charge`, `auto_disburse`, `linked_savings_acct`) VALUES
(1, 6, 2, 'Back to School', 'BTS', 'a student loan', 1, 10, '10000.000000', '100.000000', '10000.000000', 5, 1, 7, 10, 'year', '0.200000', '0.100000', '2.000000', 'per_year', 'flat', 'equal_installment', 'no', 'yes', 'no', 'yes', 'Abuja Savings Group'),
(2, 6, 1, 'Higher Institution', 'HI', 'For college', 2, 8, '50000.000000', '10000.000000', '100000.000000', 10, 1, 10, 10, 'month', '20.000000', '8.000000', '20.000000', 'per_month', '1', 'equal_installment', 'no', 'no', 'no', 'no', 'Abuja Savings Group');

-- --------------------------------------------------------

--
-- Table structure for table `savings_account`
--

DROP TABLE IF EXISTS `savings_account`;
CREATE TABLE IF NOT EXISTS `savings_account` (
  `client_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
CREATE TABLE IF NOT EXISTS `staff` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `int_id` int(100) DEFAULT NULL,
  `user_id` int(100) DEFAULT NULL,
  `int_name` varchar(50) DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  `display_name` varchar(25) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `description` longtext,
  `address` longtext,
  `date_joined` date DEFAULT NULL,
  `org_role` varchar(30) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `img` longtext,
  PRIMARY KEY (`id`),
  KEY `int_id_staff` (`int_id`),
  KEY `user_id_staff` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `int_id`, `user_id`, `int_name`, `username`, `display_name`, `email`, `first_name`, `last_name`, `description`, `address`, `date_joined`, `org_role`, `phone`, `img`) VALUES
(1, 6, 2, 'Dally', 'sam', 'sam', 'sam@gmail.com', 'sam', 'sam', 'something', 'something', '2020-02-24', 'CEO', '08162399', 'https://somewhere'),
(2, 7, 1, 'Sekani Systems', 'robot', 'robot test', 'robot@gmail.com', 'robot', 'test', 'something', 'something', '2020-02-24', 'OWNER', '08162399614', 'https://url'),
(7, 6, 16, 'Dally', 'flint123', 'flint', 'test@gmail.com', 'test', 'test', 'test', 'test', '2020-02-26', 'CEO', '98262', 'https://location'),
(8, 6, 17, 'Dally', 'clerk', 'front desk clerk', 'clerk@gmail.com', 'clerk', 'clerk', 'clerk', 'clerk', '2020-02-26', 'FRONT DESK CLERK', '0901267384', 'https://url'),
(9, 6, 18, 'Dally', 'teston', 'teston', 'teston@gmail.com', 'test', 'testton', 'testtest', 'testt', '2020-02-26', 'FRONT DESK CLERK', '08162399614', 'ss'),
(10, 9, 42, 'danels global', 'BMOHAMMED', 'Mohammed, Bashir', NULL, 'Bashir', 'Mohammed', NULL, NULL, '2018-12-12', NULL, NULL, NULL),
(11, 9, 43, 'danels global', 'MAKANDE', 'Akande, Mosi', NULL, 'Mosi', 'Akande', NULL, NULL, '2018-12-12', NULL, NULL, NULL),
(12, 9, 44, 'danels global', 'OLILIAN', 'Lilian, Ogochukwu', NULL, 'Ogochukwu', 'Lilian', NULL, NULL, '2019-02-19', NULL, NULL, NULL),
(13, 9, 40, 'danels global', 'PMR', 'Mr, Peter', NULL, 'Peter', 'Mr', NULL, NULL, '2019-02-19', NULL, NULL, NULL),
(14, 9, 41, 'danels global', 'FUMOGBAI', 'Umogbai, Favour', NULL, 'Favour', 'Umogbai', NULL, NULL, '2019-02-19', NULL, NULL, NULL),
(15, 9, 39, 'danels global', 'GENEH', 'Eneh, Grace ', NULL, 'Grace ', 'Eneh', NULL, NULL, '2019-02-19', NULL, NULL, NULL),
(16, 9, 38, 'danels global', 'FIBEKWE', 'Ibekwe, Faith', NULL, 'Faith', 'Ibekwe', NULL, NULL, '2019-02-19', NULL, NULL, NULL),
(17, 9, 37, 'danels global', 'EABDUL', 'Abdul, Emmanuel', NULL, 'Emmanuel', 'Abdul', NULL, NULL, '2019-02-19', NULL, NULL, NULL),
(18, 9, 36, 'danels global', 'TABUO', 'Abuo, Thomas', NULL, 'Thomas', 'Abuo', NULL, NULL, '2019-02-19', NULL, NULL, NULL),
(19, 9, 35, 'danels global', 'JAGADA', 'Agada, Jerry', NULL, 'Jerry', 'Agada', NULL, NULL, '2019-02-19', NULL, NULL, NULL),
(20, 9, 34, 'danels global', 'MAKHILE', 'Akhile, Mercy', NULL, 'Mercy', 'Akhile', NULL, NULL, '2019-02-19', NULL, NULL, NULL),
(21, 9, 33, 'danels global', 'AAKPAN', 'Akpan, Alice', NULL, 'Alice', 'Akpan', NULL, NULL, '2019-02-19', NULL, NULL, NULL),
(22, 9, 32, 'danels global', 'FBINTA', 'Binta, Fatima', NULL, 'Fatima', 'Binta', NULL, NULL, '2019-02-19', NULL, NULL, NULL),
(23, 9, 31, 'danels global', 'JBIODU', 'Biodu, Joseph', NULL, 'Joseph', 'Biodu', NULL, NULL, '2019-02-19', NULL, NULL, NULL),
(24, 9, 30, 'danels global', 'BEKONG', 'Ekong, Blessing', NULL, 'Blessing', 'Ekong', NULL, NULL, '2019-02-19', NULL, NULL, NULL),
(25, 9, 29, 'danels global', 'EFALETI', 'Faleti, Emmanuel', NULL, 'Emmanuel', 'Faleti', NULL, NULL, '2019-02-19', NULL, NULL, NULL),
(26, 9, 28, 'danels global', 'FIMOUKHUEDE', 'Imoukhuede, Felix', NULL, 'Felix', 'Imoukhuede', NULL, NULL, '2019-02-19', NULL, NULL, NULL),
(27, 9, 27, 'danels global', 'CKATO', 'Kato, Christine', NULL, 'Christine', 'Kato', NULL, NULL, '2019-02-19', NULL, NULL, NULL),
(28, 9, 26, 'danels global', 'OOCHE', 'Oche, Oche', NULL, 'Oche', 'Oche', NULL, NULL, '2019-02-19', NULL, NULL, NULL),
(29, 9, 25, 'danels global', 'OOJORO', 'Ojoro, Onyeche', NULL, 'Onyeche', 'Ojoro', NULL, NULL, '2019-02-19', NULL, NULL, NULL),
(30, 9, 24, 'danels global', 'SOLABODE', 'Olabode, Saheed', NULL, 'Saheed', 'Olabode', NULL, NULL, '2019-02-19', NULL, NULL, NULL),
(31, 9, 23, 'danels global', 'JOLUKPOSO', 'Olukposo, John', NULL, 'John', 'Olukposo', NULL, NULL, '2019-02-19', NULL, NULL, NULL),
(32, 9, 22, 'danels global', 'BSHUAIBU', 'Shuaibu, Blessing', NULL, 'Blessing', 'Shuaibu', NULL, NULL, '2019-02-19', NULL, NULL, NULL),
(33, 9, 21, 'danels global', 'ATAHADDUS', 'Tahaddus, Abigail', NULL, 'Abigail', 'Tahaddus', NULL, NULL, '2019-02-19', NULL, NULL, NULL),
(34, 9, 20, 'danels global', 'ATOKURAH', 'Tokurah, Austin', NULL, 'Austin', 'Tokurah', NULL, NULL, '2019-02-19', NULL, NULL, NULL),
(35, 9, 19, 'danels global', 'NYACHAM', 'Yacham, Nuhu', NULL, 'Nuhu', 'Yacham', NULL, NULL, '2019-02-19', NULL, NULL, NULL),
(36, 9, 63, 'danels global', 'LYEWANDE', 'Yewande, Linda', NULL, 'Linda', 'Yewande', NULL, NULL, '2019-02-19', NULL, NULL, NULL),
(37, 9, 45, 'danels global', 'MEJIE', 'EJIE, MELVIS', NULL, 'MELVIS', 'EJIE', NULL, NULL, '2019-03-01', NULL, NULL, NULL),
(38, 9, 46, 'danels global', 'LONALUGBUM', 'Onalugbum, Larry', NULL, 'Larry', 'Onalugbum', NULL, NULL, '2019-03-14', NULL, NULL, NULL),
(39, 9, 47, 'danels global', 'CSIDI', 'SIDI, CYNTHIA', NULL, 'CYNTHIA', 'SIDI', NULL, NULL, '2019-03-20', NULL, NULL, NULL),
(40, 9, 48, 'danels global', 'AAGU', 'AGU, AMAKA', NULL, 'AMAKA', 'AGU', NULL, NULL, '2019-01-01', NULL, NULL, NULL),
(41, 9, 49, 'danels global', 'UUMOGBAI', 'UMOGBAI, UMOGBAI', NULL, 'UMOGBAI', 'UMOGBAI', NULL, NULL, '2019-01-01', NULL, NULL, NULL),
(42, 9, 50, 'danels global', 'VIKWOYI', 'Ikwoyi, Veronica', NULL, 'Veronica', 'Ikwoyi', NULL, NULL, '2019-05-20', NULL, NULL, NULL),
(43, 9, 52, 'danels global', 'IUZOMA', 'May Uzoma, Igweoko', NULL, 'Igweoko', 'May Uzoma', NULL, NULL, '2019-06-06', NULL, NULL, NULL),
(44, 9, 53, 'danels global', 'MAPKAN', 'Apkan, Mercy Bassey', NULL, 'Mercy Bassey', 'Apkan', NULL, NULL, '2019-06-06', NULL, NULL, NULL),
(45, 9, 54, 'danels global', 'LACHOR', 'Achor, Linda, Chinelo', NULL, 'Linda, Chinelo', 'Achor', NULL, NULL, '2019-06-17', NULL, NULL, NULL),
(46, 9, 55, 'danels global', 'OOBAJI', 'Obaji, Odinaka I', NULL, 'Odinaka I', 'Obaji', NULL, NULL, '2019-06-13', NULL, NULL, NULL),
(47, 9, 56, 'danels global', 'VPIUS', 'Pius, Victor', NULL, 'Victor', 'Pius', NULL, NULL, '2019-06-06', NULL, NULL, NULL),
(48, 9, 57, 'danels global', 'QAGU', 'Agu, Queen', NULL, 'Queen', 'Agu', NULL, NULL, '2019-07-01', NULL, NULL, NULL),
(49, 9, 58, 'danels global', 'JSAMUEL', 'Samuel, Julie', NULL, 'Julie', 'Samuel', NULL, NULL, '2019-08-01', NULL, NULL, NULL),
(50, 9, 59, 'danels global', 'PJOHN', 'John, Patience', NULL, 'Patience', 'John', NULL, NULL, '2019-09-04', NULL, NULL, NULL),
(51, 9, 60, 'danels global', 'OSOLOMON', 'Solomon, Osas', NULL, 'Osas', 'Solomon', NULL, NULL, '2019-09-01', NULL, NULL, NULL),
(52, 9, 61, 'danels global', 'JSOLOMON', 'Solomon, Jude Osareme', NULL, 'Jude Osareme', 'Solomon', NULL, NULL, '2019-08-01', NULL, NULL, NULL),
(53, 9, 62, 'danels global', 'SSUPPORT', 'Sekani Support', NULL, 'Support', 'Sekani', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `int_id` int(50) DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `password` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `usertype` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `last_logged` timestamp NULL DEFAULT NULL,
  `time_created` date DEFAULT NULL,
  `pics` longtext,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `int_id_users` (`int_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `int_id`, `username`, `fullname`, `password`, `usertype`, `status`, `last_logged`, `time_created`, `pics`) VALUES
(1, 7, 'robot', 'robot test', '$2y$10$bBNsJA2KZNuoR9ZZQRsd1.JE4xVc8/LE7Q7nr96O.dRC6GABZDiEy', 'super_admin', 'Not Active', '2020-03-02 20:24:40', '2020-02-18', NULL),
(2, 6, 'sam', 'sammy', '$2y$10$bBNsJA2KZNuoR9ZZQRsd1.JE4xVc8/LE7Q7nr96O.dRC6GABZDiEy', 'staff', 'Active', '2020-03-04 23:04:58', '2020-02-13', 'https://something'),
(16, 6, 'flint123', 'flint', '$2y$10$bBNsJA2KZNuoR9ZZQRsd1.JE4xVc8/LE7Q7nr96O.dRC6GABZDiEy', 'staff', 'Not Active', '2020-02-26 17:42:32', '2020-02-26', 'https://location'),
(17, 6, 'clerk', 'front desk clerk', '$2y$10$sMaGiJM1VbqX9SxCJiSzt.gl5kj49AdBDu9UNCYbxpUxMwZGyIGxu', 'staff', 'Not Active', '2020-02-26 11:37:39', '2020-02-26', 'https://url'),
(18, 6, 'teston', 'teston', '$2y$10$E8v18q39LIlV7w7q4121geix/K5ky/d9DdSHZh5aPANqAUDrShpwu', 'staff', 'Active', '2020-02-26 17:47:44', '2020-02-26', 'ss'),
(19, 9, 'NYACHAM', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(20, 9, 'ATOKURAH', NULL, '$2a$10$mhg5jDZQpk9Pvf2AI4WHJ.994iBf07juY23w6EA302VHAp/CjBvUO', NULL, 'Not Active', '2019-12-24 17:13:35', '2019-08-22', NULL),
(21, 9, 'ATAHADDUS', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(22, 9, 'BSHUAIBU', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(23, 9, 'JOLUKPOSO', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(24, 9, 'SOLABODE', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(25, 9, 'OOJORO', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(26, 9, 'OOCHE', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(27, 9, 'CKATO', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(28, 9, 'FIMOUKHUEDE', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(29, 9, 'EFALETI', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(30, 9, 'BEKONG', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(31, 9, 'JBIODU', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(32, 9, 'FBINTA', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(33, 9, 'AAKPAN', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(34, 9, 'MAKHILE', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(35, 9, 'JAGADA', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(36, 9, 'TABUO', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(37, 9, 'EABDUL', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(38, 9, 'FIBEKWE', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(39, 9, 'GENEH', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(40, 9, 'PMR', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(41, 9, 'FUMOGBAI', NULL, '$2a$10$r3KmKfB5kFhb3WsVfQPIK.tWSCtWUH5.I.aUhfE9sf90sKB0mlyh.', NULL, 'Not Active', '2020-02-18 12:42:09', '2019-08-22', NULL),
(42, 9, 'BMOHAMMED', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(43, 9, 'MAKANDE', NULL, '$2a$10$AWhp52CpN0D55HmStzGFZe4eIAucw4Sa7IVp1OB/Ao3Z9l681Z2q.', NULL, 'Not Active', '2020-02-13 19:30:56', '2019-08-22', NULL),
(44, 9, 'OLILIAN', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(45, 9, 'MEJIE', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(46, 9, 'LONALUGBUM', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(47, 9, 'CSIDI', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(48, 9, 'AAGU', NULL, '$2a$10$tx/yStTlnOhh9T1xut84d.FjOyW8VxXCZxRGc7XH8ohe269gCANPm', NULL, 'Not Active', '2020-01-08 22:40:22', '2019-08-22', NULL),
(49, 9, 'UUMOGBAI', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(50, 9, 'VIKWOYI', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(52, 9, 'IUZOMA', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(53, 9, 'MAPKAN', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(54, 9, 'LACHOR', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(55, 9, 'OOBAJI', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(56, 9, 'VPIUS', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(57, 9, 'QAGU', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(58, 9, 'JSAMUEL', NULL, '$2a$10$XHWIGlOHQr8U.7mnspxfUuT8wctbMgLCbaFRxUS7Ah7pTFyO2h3VW', NULL, 'Not Active', '2019-12-19 17:58:33', '2019-08-22', NULL),
(59, 9, 'PJOHN', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-12-04 13:36:01', '2019-08-22', NULL),
(60, 9, 'OSOLOMON', NULL, '$2a$10$v1qN9KVuJmTKyR3Oaly7GeK2jKhUSqXYfecYDe1WCJ3ijX.l9oXn6', NULL, 'Not Active', '2020-01-08 11:08:00', '2019-08-22', NULL),
(61, 9, 'JSOLOMON', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL),
(62, 9, 'SSUPPORT', NULL, '$2a$10$wY46YL0i9JOq5aBQmXVuz.aaDw/9hMTffA.YfHWeatb2G6P2qjpvS', NULL, 'Not Active', '2020-02-11 03:20:35', '2019-08-22', NULL),
(63, 9, 'LYEWANDE', NULL, '$2a$10$T5YY8Il.7ZTy7/02tsp43uBd6UTg.vZ89zT3k/CqhVZxC5oapmyGq', NULL, 'Not Active', '2019-08-27 15:23:53', '2019-08-22', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `charge`
--
ALTER TABLE `charge`
  ADD CONSTRAINT `charge_int_id` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`);

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `int_id_client` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`),
  ADD CONSTRAINT `l_o_id` FOREIGN KEY (`loan_officer_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `collateral`
--
ALTER TABLE `collateral`
  ADD CONSTRAINT `int_id_collateral` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`);

--
-- Constraints for table `loan`
--
ALTER TABLE `loan`
  ADD CONSTRAINT `client_id_loan` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `int_id_loan` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`),
  ADD CONSTRAINT `product_id_loan` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `org_role`
--
ALTER TABLE `org_role`
  ADD CONSTRAINT `int_id_row` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_charge_id` FOREIGN KEY (`charge_id`) REFERENCES `charge` (`id`),
  ADD CONSTRAINT `product_int_id` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `int_id_staff` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`),
  ADD CONSTRAINT `user_id_staff` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `int_id_users` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
