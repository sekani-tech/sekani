-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 15, 2020 at 08:21 PM
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
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `int_id` int(100) DEFAULT NULL,
  `branch_id` int(100) DEFAULT NULL,
  `account_no` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `account_type` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `client_id` int(100) DEFAULT NULL,
  `product_id` int(100) DEFAULT NULL,
  `field_officer_id` int(100) DEFAULT NULL,
  `group_id` bigint(20) DEFAULT NULL,
  `deposit_type_enum` smallint(5) NOT NULL DEFAULT '100',
  `submittedon_date` date NOT NULL,
  `submittedon_userid` bigint(20) DEFAULT NULL,
  `approvedon_date` date DEFAULT NULL,
  `approvedon_userid` bigint(20) DEFAULT NULL,
  `currency_code` varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'NGN',
  `currency_digits` smallint(5) NOT NULL DEFAULT '2',
  `activatedon_date` date DEFAULT NULL,
  `activatedon_userid` bigint(20) DEFAULT NULL,
  `closedon_date` date DEFAULT NULL,
  `closedon_userid` bigint(20) DEFAULT NULL,
  `currency_multiplesof` smallint(5) DEFAULT '2',
  `nominal_annual_interest_rate` decimal(19,6) DEFAULT NULL,
  `interest_compounding_period_enum` smallint(5) DEFAULT NULL,
  `interest_posting_period_enum` smallint(5) NOT NULL DEFAULT '4',
  `interest_calculation_type_enum` smallint(5) DEFAULT NULL,
  `interest_calculation_days_in_year_type_enum` smallint(5) DEFAULT NULL,
  `min_required_opening_balance` decimal(19,6) DEFAULT NULL,
  `lockin_period_frequency` decimal(19,6) DEFAULT NULL,
  `lockin_period_frequency_enum` smallint(5) DEFAULT NULL,
  `withdrawal_fee_for_transfer` tinyint(4) DEFAULT '1',
  `allow_overdraft` tinyint(1) NOT NULL DEFAULT '0',
  `overdraft_limit` decimal(19,6) DEFAULT NULL,
  `nominal_annual_interest_rate_overdraft` decimal(19,6) DEFAULT '0.000000',
  `min_overdraft_for_interest_calculation` decimal(19,6) DEFAULT '0.000000',
  `min_required_balance` decimal(19,6) DEFAULT NULL,
  `min_balance_for_interest_calculation` decimal(19,6) DEFAULT NULL,
  `lockedin_until_date_derived` date DEFAULT NULL,
  `total_deposits_derived` decimal(19,6) DEFAULT NULL,
  `total_withdrawals_derived` decimal(19,6) DEFAULT NULL,
  `total_withdrawal_fees_derived` decimal(19,6) DEFAULT NULL,
  `total_fees_charge_derived` decimal(19,6) DEFAULT NULL,
  `total_penalty_charge_derived` decimal(19,6) DEFAULT NULL,
  `total_annual_fees_derived` decimal(19,6) DEFAULT NULL,
  `total_quarterly_fees_owed_derived` decimal(19,6) DEFAULT NULL,
  `total_quarterly_fees_derived` decimal(19,6) DEFAULT NULL,
  `total_interest_earned_derived` decimal(19,6) DEFAULT NULL,
  `total_interest_posted_derived` decimal(19,6) DEFAULT NULL,
  `total_overdraft_interest_derived` decimal(19,6) DEFAULT '0.000000',
  `total_withhold_tax_derived` decimal(19,6) DEFAULT NULL,
  `total_writtenoff_derived` decimal(19,6) DEFAULT NULL,
  `enforce_min_required_balance` tinyint(1) NOT NULL DEFAULT '0',
  `start_interest_calculation_date` date DEFAULT NULL,
  `on_hold_funds_derived` decimal(19,6) DEFAULT NULL,
  `version` int(15) NOT NULL DEFAULT '1',
  `account_balance_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `rejectedon_date` date DEFAULT NULL,
  `rejectedon_userid` bigint(20) DEFAULT NULL,
  `withdrawnon_date` date DEFAULT NULL,
  `withdrawnon_userid` bigint(20) DEFAULT NULL,
  `auto_renew_on_closure` tinyint(1) NOT NULL DEFAULT '0',
  `withhold_tax` tinyint(4) NOT NULL DEFAULT '0',
  `tax_group_id` bigint(20) DEFAULT NULL,
  `last_interest_calculation_date` date DEFAULT NULL,
  `last_activity_date` date DEFAULT NULL,
  `last_quarterly_calculation_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `int_id_acct` (`int_id`),
  KEY `client_id_acct` (`client_id`),
  KEY `branch_id_acct` (`branch_id`),
  KEY `product_id_acct` (`product_id`),
  KEY `field_officer_id_acct` (`field_officer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `account_transaction`
--

DROP TABLE IF EXISTS `account_transaction`;
CREATE TABLE IF NOT EXISTS `account_transaction` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `int_id` int(100) NOT NULL,
  `branch_id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `account_id` int(100) DEFAULT NULL,
  `account_no` varchar(100) NOT NULL,
  `client_id` int(100) NOT NULL,
  `transaction_id` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `transaction_type` varchar(50) NOT NULL,
  `is_reversed` tinyint(1) NOT NULL,
  `transaction_date` date NOT NULL,
  `amount` decimal(19,6) NOT NULL,
  `overdraft_amount_derived` decimal(19,6) DEFAULT NULL,
  `balance_end_date_derived` date DEFAULT NULL,
  `balance_number_of_days_derived` int(11) DEFAULT NULL,
  `running_balance_derived` decimal(19,6) DEFAULT NULL,
  `cumulative_balance_derived` decimal(19,6) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `appuser_id` bigint(20) DEFAULT NULL,
  `manually_adjusted_or_reversed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `int_id_acctrans` (`int_id`),
  KEY `branch_id_acctrans` (`branch_id`),
  KEY `product_id_acctrans` (`product_id`),
  KEY `account_id_acctrans` (`account_id`),
  KEY `client_id_acctrans` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

DROP TABLE IF EXISTS `branch`;
CREATE TABLE IF NOT EXISTS `branch` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `int_id` int(100) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `email` varchar(500) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `location` longtext,
  PRIMARY KEY (`id`),
  KEY `branch_int_id` (`int_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `account_type` varchar(20) DEFAULT NULL,
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
  KEY `branch_id_client` (`branch_id`),
  KEY `loan_officer_id_client` (`loan_officer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `institutions`
--

DROP TABLE IF EXISTS `institutions`;
CREATE TABLE IF NOT EXISTS `institutions` (
  `int_id` int(100) NOT NULL AUTO_INCREMENT,
  `int_name` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `rcn` varchar(25) DEFAULT NULL,
  `int_state` varchar(25) CHARACTER SET utf8mb4 DEFAULT NULL,
  `lga` varchar(25) DEFAULT NULL,
  `office_address` longtext,
  `office_phone` varchar(25) DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `pc_title` varchar(10) DEFAULT NULL,
  `pc_surname` varchar(25) DEFAULT NULL,
  `pc_other_name` varchar(25) DEFAULT NULL,
  `pc_designation` varchar(25) DEFAULT NULL,
  `pc_phone` varchar(25) DEFAULT NULL,
  `pc_email` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`int_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `institution_account`
--

DROP TABLE IF EXISTS `institution_account`;
CREATE TABLE IF NOT EXISTS `institution_account` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `int_id` int(100) DEFAULT NULL,
  `account_no` varchar(20) NOT NULL,
  `submittedon_date` date NOT NULL,
  `submittedon_userid` bigint(20) DEFAULT NULL,
  `currency_code` varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'NGN',
  `account_balance_derived` decimal(19,6) NOT NULL DEFAULT '0.000000',
  `nominal_annual_interest_rate` decimal(19,6) DEFAULT NULL,
  `interest_compounding_period_enum` smallint(5) DEFAULT NULL,
  `interest_posting_period_enum` smallint(5) NOT NULL DEFAULT '4',
  `interest_calculation_type_enum` smallint(5) DEFAULT NULL,
  `interest_calculation_days_in_year_type_enum` smallint(5) DEFAULT NULL,
  `min_required_opening_balance` decimal(19,6) DEFAULT NULL,
  `lockin_period_frequency` decimal(19,6) DEFAULT NULL,
  `lockin_period_frequency_enum` smallint(5) DEFAULT NULL,
  `withdrawal_fee_for_transfer` tinyint(4) DEFAULT '1',
  `allow_overdraft` tinyint(1) NOT NULL DEFAULT '0',
  `overdraft_limit` decimal(19,6) DEFAULT NULL,
  `nominal_annual_interest_rate_overdraft` decimal(19,6) DEFAULT '0.000000',
  `min_overdraft_for_interest_calculation` decimal(19,6) DEFAULT '0.000000',
  `min_required_balance` decimal(19,6) DEFAULT NULL,
  `min_balance_for_interest_calculation` decimal(19,6) DEFAULT NULL,
  `lockedin_until_date_derived` date DEFAULT NULL,
  `total_deposits_derived` decimal(19,6) DEFAULT NULL,
  `total_withdrawals_derived` decimal(19,6) DEFAULT NULL,
  `total_withdrawal_fees_derived` decimal(19,6) DEFAULT NULL,
  `total_fees_charge_derived` decimal(19,6) DEFAULT NULL,
  `total_penalty_charge_derived` decimal(19,6) DEFAULT NULL,
  `total_annual_fees_derived` decimal(19,6) DEFAULT NULL,
  `total_quarterly_fees_owed_derived` decimal(19,6) DEFAULT NULL,
  `total_quarterly_fees_derived` decimal(19,6) DEFAULT NULL,
  `total_interest_earned_derived` decimal(19,6) DEFAULT NULL,
  `total_interest_posted_derived` decimal(19,6) DEFAULT NULL,
  `total_overdraft_interest_derived` decimal(19,6) DEFAULT '0.000000',
  `total_withhold_tax_derived` decimal(19,6) DEFAULT NULL,
  `total_writtenoff_derived` decimal(19,6) DEFAULT NULL,
  `enforce_min_required_balance` tinyint(1) NOT NULL DEFAULT '0',
  `start_interest_calculation_date` date DEFAULT NULL,
  `on_hold_funds_derived` decimal(19,6) DEFAULT NULL,
  `version` int(15) NOT NULL DEFAULT '1',
  `rejectedon_date` date DEFAULT NULL,
  `rejectedon_userid` bigint(20) DEFAULT NULL,
  `withdrawnon_date` date DEFAULT NULL,
  `withdrawnon_userid` bigint(20) DEFAULT NULL,
  `auto_renew_on_closure` tinyint(1) NOT NULL DEFAULT '0',
  `withhold_tax` tinyint(4) NOT NULL DEFAULT '0',
  `tax_group_id` bigint(20) DEFAULT NULL,
  `last_interest_calculation_date` date DEFAULT NULL,
  `last_activity_date` date DEFAULT NULL,
  `last_quarterly_calculation_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `int_id` (`int_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `institution_account_transaction`
--

DROP TABLE IF EXISTS `institution_account_transaction`;
CREATE TABLE IF NOT EXISTS `institution_account_transaction` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `int_id` int(100) NOT NULL,
  `branch_id` int(100) NOT NULL,
  `client_id` int(100) NOT NULL,
  `transaction_id` varchar(20) NOT NULL,
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
  `manually_adjusted_or_reversed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `int_id_intacct` (`int_id`),
  KEY `brh_id_intacct` (`branch_id`),
  KEY `client_id_intacct` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

DROP TABLE IF EXISTS `loan`;
CREATE TABLE IF NOT EXISTS `loan` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `int_id` int(100) DEFAULT NULL,
  `account_no` varchar(20) NOT NULL,
  `client_id` int(100) DEFAULT NULL,
  `product_id` int(100) DEFAULT NULL,
  `fund_id` bigint(20) DEFAULT NULL,
  `col_id` int(100) DEFAULT NULL,
  `col_name` varchar(30) DEFAULT NULL,
  `col_description` longtext,
  `loan_officer` varchar(50) DEFAULT NULL,
  `loan_purpose` varchar(100) DEFAULT NULL,
  `currency_code` varchar(3) NOT NULL,
  `currency_digits` smallint(5) NOT NULL,
  `principal_amount_proposed` decimal(19,6) NOT NULL,
  `principal_amount` decimal(19,6) NOT NULL,
  `loan_term` int(100) DEFAULT NULL,
  `interest_rate` decimal(19,6) DEFAULT NULL,
  `approved_principal` decimal(19,6) NOT NULL,
  `repayment_date` date DEFAULT NULL,
  `arrearstolerance_amount` decimal(19,6) DEFAULT NULL,
  `is_floating_interest_rate` bit(1) DEFAULT b'0',
  `interest_rate_differential` decimal(19,6) DEFAULT '0.000000',
  `nominal_interest_rate_per_period` decimal(19,6) DEFAULT NULL,
  `interest_period_frequency_enum` smallint(5) DEFAULT NULL,
  `annual_nominal_interest_rate` decimal(19,6) DEFAULT NULL,
  `interest_method_enum` smallint(5) DEFAULT NULL,
  `interest_calculated_in_period_enum` smallint(5) NOT NULL DEFAULT '1',
  `allow_partial_period_interest_calcualtion` tinyint(1) NOT NULL DEFAULT '0',
  `term_frequency` smallint(5) NOT NULL DEFAULT '0',
  `term_period_frequency_enum` smallint(5) NOT NULL DEFAULT '2',
  `repay_every` varchar(100) DEFAULT NULL,
  `repayment_period_frequency_enum` smallint(5) DEFAULT NULL,
  `number_of_repayments` smallint(5) NOT NULL,
  `grace_on_principal_periods` smallint(5) DEFAULT NULL,
  `recurring_moratorium_principal_periods` smallint(5) DEFAULT NULL,
  `grace_on_interest_periods` smallint(5) DEFAULT NULL,
  `grace_interest_free_periods` smallint(5) DEFAULT NULL,
  `amortization_method` smallint(5) DEFAULT NULL,
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
  PRIMARY KEY (`id`),
  KEY `int_id_loan` (`int_id`),
  KEY `product_id_loan` (`product_id`),
  KEY `client_id_loan` (`client_id`),
  KEY `collateral_id_loan` (`col_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `loan_gaurantor`
--

DROP TABLE IF EXISTS `loan_gaurantor`;
CREATE TABLE IF NOT EXISTS `loan_gaurantor` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `int_id` int(100) DEFAULT NULL,
  `loan_id` int(100) DEFAULT NULL,
  `client_id` int(100) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `phone2` varchar(15) DEFAULT NULL,
  `home_address` longtext,
  `office_address` longtext,
  `position_held` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `int_id_gau` (`int_id`),
  KEY `loan_id_gau` (`loan_id`),
  KEY `client_id_gau` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `loan_interest_port`
--

DROP TABLE IF EXISTS `loan_interest_port`;
CREATE TABLE IF NOT EXISTS `loan_interest_port` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `int_id` int(100) DEFAULT NULL,
  `officer_id` int(100) DEFAULT NULL,
  `branch_id` int(100) DEFAULT NULL,
  `account_no` varchar(20) DEFAULT NULL,
  `client_id` int(100) DEFAULT NULL,
  `interest_amount` decimal(16,9) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `loan_principal_port`
--

DROP TABLE IF EXISTS `loan_principal_port`;
CREATE TABLE IF NOT EXISTS `loan_principal_port` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `int_id` int(100) DEFAULT NULL,
  `officer_id` int(100) DEFAULT NULL,
  `branch_id` int(100) DEFAULT NULL,
  `account_no` varchar(20) DEFAULT NULL,
  `client_id` int(100) DEFAULT NULL,
  `principal_amount` decimal(16,9) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `loan_transaction`
--

DROP TABLE IF EXISTS `loan_transaction`;
CREATE TABLE IF NOT EXISTS `loan_transaction` (
  `id` int(100) NOT NULL,
  `int_id` int(100) NOT NULL,
  `branch_id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `loan_id` int(100) NOT NULL,
  `transaction_id` varchar(20) DEFAULT NULL,
  `client_id` int(100) NOT NULL,
  `account_no` varchar(20) NOT NULL,
  `is_reversed` tinyint(1) NOT NULL,
  `external_id` varchar(100) DEFAULT NULL,
  `transaction_type_enum` smallint(5) NOT NULL,
  `transaction_date` date NOT NULL,
  `amount` decimal(19,6) NOT NULL,
  `principal_portion_derived` decimal(19,6) DEFAULT NULL,
  `interest_portion_derived` decimal(19,6) DEFAULT NULL,
  `fee_charges_portion_derived` decimal(19,6) DEFAULT NULL,
  `penalty_charges_portion_derived` decimal(19,6) DEFAULT NULL,
  `overpayment_portion_derived` decimal(19,6) DEFAULT NULL,
  `unrecognized_income_portion` decimal(19,6) DEFAULT NULL,
  `suspended_interest_portion_derived` decimal(19,6) DEFAULT NULL,
  `suspended_fee_charges_portion_derived` decimal(19,6) DEFAULT NULL,
  `suspended_penalty_charges_portion_derived` decimal(19,6) DEFAULT NULL,
  `outstanding_loan_balance_derived` decimal(19,6) DEFAULT NULL,
  `recovered_portion_derived` decimal(19,6) DEFAULT NULL,
  `submitted_on_date` date NOT NULL,
  `manually_adjusted_or_reversed` tinyint(1) DEFAULT '0',
  `created_date` datetime DEFAULT NULL,
  `appuser_id` bigint(20) DEFAULT NULL,
  `is_account_transfer` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `int_id_loantrans` (`int_id`),
  KEY `branch_id_loantrans` (`branch_id`),
  KEY `product_id_loantrans` (`product_id`),
  KEY `loan_id_loantrans` (`loan_id`),
  KEY `client_id_loantrans` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `linked_savings_acct` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_charge_id` (`charge_id`),
  KEY `product_int_id` (`int_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `employee_status` varchar(20) DEFAULT NULL,
  `org_role` varchar(30) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `img` longtext,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `int_id_staff` (`int_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `password` varchar(500) DEFAULT NULL,
  `usertype` varchar(25)  DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `last_logged` timestamp NULL DEFAULT NULL,
  `time_created` date DEFAULT NULL,
  `pics` longtext,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `int_id_users` (`int_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `branch_id_acct` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  ADD CONSTRAINT `client_id_acct` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `field_officer_id_acct` FOREIGN KEY (`field_officer_id`) REFERENCES `staff` (`user_id`),
  ADD CONSTRAINT `int_id_acct` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`),
  ADD CONSTRAINT `product_id_acct` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `account_transaction`
--
ALTER TABLE `account_transaction`
  ADD CONSTRAINT `branch_id_acctrans` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  ADD CONSTRAINT `client_id_acctrans` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `int_id_acctrans` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`),
  ADD CONSTRAINT `product_id_acctrans` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `branch`
--
ALTER TABLE `branch`
  ADD CONSTRAINT `branch_int_id` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`);

--
-- Constraints for table `charge`
--
ALTER TABLE `charge`
  ADD CONSTRAINT `charge_int_id` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`);

--
-- Constraints for table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `branch_id_client` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  ADD CONSTRAINT `int_id_client` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`),
  ADD CONSTRAINT `loan_officer_id_client` FOREIGN KEY (`loan_officer_id`) REFERENCES `staff` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `collateral`
--
ALTER TABLE `collateral`
  ADD CONSTRAINT `int_id_collateral` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`);

--
-- Constraints for table `institution_account`
--
ALTER TABLE `institution_account`
  ADD CONSTRAINT `int_id` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`);

--
-- Constraints for table `institution_account_transaction`
--
ALTER TABLE `institution_account_transaction`
  ADD CONSTRAINT `brh_id_intacct` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  ADD CONSTRAINT `client_id_intacct` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `int_id_intacct` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`);

--
-- Constraints for table `loan`
--
ALTER TABLE `loan`
  ADD CONSTRAINT `collateral_id_loan` FOREIGN KEY (`col_id`) REFERENCES `collateral` (`id`),
  ADD CONSTRAINT `int_id_loan` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`),
  ADD CONSTRAINT `product_id_loan` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `loan_gaurantor`
--
ALTER TABLE `loan_gaurantor`
  ADD CONSTRAINT `client_id_gau` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `int_id_gau` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`);

--
-- Constraints for table `loan_transaction`
--
ALTER TABLE `loan_transaction`
  ADD CONSTRAINT `branch_id_loantrans` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  ADD CONSTRAINT `client_id_loantrans` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `int_id_loantrans` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`),
  ADD CONSTRAINT `loan_id_loantrans` FOREIGN KEY (`loan_id`) REFERENCES `loan` (`id`),
  ADD CONSTRAINT `product_id_loantrans` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

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
