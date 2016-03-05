-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2016 at 10:26 PM
-- Server version: 5.6.24
-- PHP Version: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `freelanceroffice`
--

-- --------------------------------------------------------

--
-- Table structure for table `fx_account_details`
--

CREATE TABLE IF NOT EXISTS `fx_account_details` (
  `id` bigint(20) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `fullname` varchar(160) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `locale` varchar(100) COLLATE utf8_unicode_ci DEFAULT 'en_US',
  `address` varchar(64) COLLATE utf8_unicode_ci DEFAULT '-',
  `phone` varchar(32) COLLATE utf8_unicode_ci DEFAULT '-',
  `mobile` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `skype` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language` varchar(40) COLLATE utf8_unicode_ci DEFAULT 'english',
  `department` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(32) COLLATE utf8_unicode_ci DEFAULT 'default_avatar.jpg',
  `use_gravatar` enum('Y','N') COLLATE utf8_unicode_ci DEFAULT 'Y',
  `as_company` enum('false','true') COLLATE utf8_unicode_ci DEFAULT 'false',
  `allowed_modules` text COLLATE utf8_unicode_ci,
  `hourly_rate` decimal(10,2) DEFAULT '0.00'
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `fx_account_details`
--

INSERT INTO `fx_account_details` (`id`, `user_id`, `fullname`, `company`, `city`, `country`, `locale`, `address`, `phone`, `mobile`, `skype`, `language`, `department`, `avatar`, `use_gravatar`, `as_company`, `allowed_modules`, `hourly_rate`) VALUES
(1, 1, 'Ultra Software Solution', '1', NULL, NULL, 'en_US', '-', '', NULL, NULL, 'english', NULL, 'default_avatar.jpg', 'Y', 'false', NULL, '0.00'),
(5, 5, 'epm', '-', NULL, NULL, 'en_US', '-', '+6281293109031', NULL, NULL, 'english', NULL, 'default_avatar.jpg', 'Y', 'false', NULL, '0.00'),
(6, 6, 'Client', '-', NULL, NULL, 'en_US', '-', '+6281293109031', NULL, NULL, 'english', NULL, 'default_avatar.jpg', 'Y', 'false', NULL, '0.00'),
(8, 8, 'EHR', '-', NULL, NULL, 'en_US', '-', '', NULL, NULL, 'english', NULL, 'USER-EHR-CV.pdf', 'Y', 'false', NULL, '0.00'),
(9, 9, 'ebusiness', '-', NULL, NULL, 'en_US', '-', '+6281293109031', NULL, NULL, 'english', NULL, 'default_avatar.jpg', 'Y', 'false', NULL, '0.00'),
(10, 10, 'efinance', '-', NULL, NULL, 'en_US', '-', '+6281293109031', NULL, NULL, 'english', NULL, 'default_avatar.jpg', 'Y', 'false', NULL, '0.00'),
(11, 11, 'Project Manager', '-', NULL, NULL, 'en_US', '-', '+6281293109031', NULL, NULL, 'english', NULL, 'USER-PROJECTMANAGER-CV.pdf', 'Y', 'false', NULL, '0.00'),
(13, 13, 'Test', '-', NULL, NULL, 'en_US', '-', '+6281293109031', NULL, NULL, 'english', NULL, 'default_avatar.jpg', 'Y', 'false', NULL, '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `fx_activities`
--

CREATE TABLE IF NOT EXISTS `fx_activities` (
  `activity_id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `module` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `module_field_id` int(11) DEFAULT NULL,
  `activity` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activity_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `icon` varchar(32) COLLATE utf8_unicode_ci DEFAULT 'fa-coffee',
  `value1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fx_activities`
--

INSERT INTO `fx_activities` (`activity_id`, `user`, `module`, `module_field_id`, `activity`, `activity_date`, `icon`, `value1`, `value2`, `deleted`) VALUES
(1, 1, 'users', 7, 'activity_deleted_system_user', '2016-02-22 06:40:53', 'fa-trash-o', 'ehr2', NULL, 0),
(2, 1, 'users', 4, 'activity_deleted_system_user', '2016-02-22 06:41:44', 'fa-trash-o', 'efinance', NULL, 0),
(3, 1, 'users', 3, 'activity_deleted_system_user', '2016-02-22 06:42:02', 'fa-trash-o', 'ehr', NULL, 0),
(4, 1, 'users', 2, 'activity_deleted_system_user', '2016-02-22 06:42:17', 'fa-trash-o', 'ebusiness', NULL, 0),
(6, 9, 'Clients', 2, 'activity_added_new_company', '2016-02-22 11:25:50', 'fa-user', 'Test Ebusiness Role', NULL, 0),
(7, 9, 'projects', 2, 'activity_added_new_project', '2016-02-22 11:27:49', 'fa-coffee', 'PRO67497', '', 0),
(8, 9, 'projects', 3, 'activity_added_new_project', '2016-02-22 11:29:21', 'fa-coffee', 'PRO25691', '', 0),
(9, 9, 'projects', 4, 'activity_added_new_project', '2016-02-22 11:31:00', 'fa-coffee', 'PRO81899', '', 0),
(10, 11, 'projects', 2, 'activity_edited_a_project', '2016-02-24 05:59:01', 'fa-coffee', 'PRO67497', '', 0),
(11, 11, 'bugs', NULL, 'activity_bug_delete', '2016-02-24 11:43:51', 'fa-bug', NULL, '', 0),
(12, 9, 'projects', 5, 'activity_added_new_project', '2016-02-24 11:46:32', 'fa-coffee', 'PRO63192', '', 0),
(13, 10, 'invoices', 1, 'activity_invoice_created', '2016-02-24 16:45:38', 'fa-plus', 'INV0001', NULL, 0),
(14, 10, 'invoices', 2, 'activity_invoice_created', '2016-02-24 16:46:15', 'fa-plus', 'INV0002', NULL, 0),
(15, 10, 'estimates', 1, 'activity_estimate_created', '2016-02-24 17:02:11', 'fa-plus', 'EST48632', NULL, 0),
(16, 10, 'expenses', 1, 'activity_expense_created', '2016-02-24 17:19:24', 'fa-plus', 'USD 8000', 'Test Ebusiness Create Project', 0),
(19, 11, 'projects', 2, 'activity_edited_a_project', '2016-02-29 04:33:11', 'fa-coffee', 'PRO67497', '', 0),
(18, 10, 'expenses', 1, 'activity_expense_edited', '2016-02-24 17:20:01', 'fa-pencil', '8000.00', 'Test Ebusiness Create Project', 0),
(20, 8, 'users', 12, 'activity_deleted_system_user', '2016-03-01 02:45:21', 'fa-trash-o', 'kevin', NULL, 0),
(21, 8, 'Users', 13, 'activity_updated_system_user', '2016-03-01 02:46:38', 'fa-edit', 'Test', NULL, 0),
(22, 11, 'projects', 2, 'activity_edited_team', '2016-03-02 02:24:27', 'fa-group', '', '', 0),
(23, 11, 'projects', 2, 'activity_uploaded_file', '2016-03-02 02:25:26', 'fa-file', 'test', '', 0),
(24, 1, 'projects', 2, 'activity_deleted_a_file', '2016-03-02 02:30:00', 'fa-times', 'closeupme.jpg', '', 0),
(25, 1, 'projects', 2, 'activity_uploaded_file', '2016-03-02 02:37:45', 'fa-file', 'Test Admin', '', 0),
(26, 5, 'projects', 2, 'activity_uploaded_file', '2016-03-02 02:42:41', 'fa-file', 'Test Staff', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fx_api_access`
--

CREATE TABLE IF NOT EXISTS `fx_api_access` (
  `id` int(11) unsigned NOT NULL,
  `key` varchar(40) NOT NULL DEFAULT '',
  `controller` varchar(50) NOT NULL DEFAULT '',
  `date_created` datetime DEFAULT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fx_api_keys`
--

CREATE TABLE IF NOT EXISTS `fx_api_keys` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `api_key` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `is_private_key` tinyint(1) NOT NULL DEFAULT '0',
  `ip_addresses` text COLLATE utf8_unicode_ci,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fx_api_limits`
--

CREATE TABLE IF NOT EXISTS `fx_api_limits` (
  `id` int(11) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `count` int(10) NOT NULL,
  `hour_started` int(11) NOT NULL,
  `api_key` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fx_api_logs`
--

CREATE TABLE IF NOT EXISTS `fx_api_logs` (
  `id` int(11) NOT NULL,
  `uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `method` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `params` text COLLATE utf8_unicode_ci,
  `api_key` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  `rtime` float DEFAULT NULL,
  `authorized` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fx_assign_projects`
--

CREATE TABLE IF NOT EXISTS `fx_assign_projects` (
  `a_id` int(11) unsigned NOT NULL,
  `assigned_user` int(11) NOT NULL,
  `project_assigned` int(11) NOT NULL,
  `assign_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fx_assign_projects`
--

INSERT INTO `fx_assign_projects` (`a_id`, `assigned_user`, `project_assigned`, `assign_date`) VALUES
(7, 1, 2, '2016-03-02 02:24:16'),
(8, 5, 2, '2016-03-02 02:24:16'),
(9, 8, 2, '2016-03-02 02:24:16'),
(10, 9, 2, '2016-03-02 02:24:16'),
(11, 10, 2, '2016-03-02 02:24:16'),
(12, 11, 2, '2016-03-02 02:24:16'),
(13, 13, 2, '2016-03-02 02:24:16');

-- --------------------------------------------------------

--
-- Table structure for table `fx_assign_tasks`
--

CREATE TABLE IF NOT EXISTS `fx_assign_tasks` (
  `a_id` int(11) unsigned NOT NULL,
  `assigned_user` int(11) NOT NULL,
  `project_assigned` int(11) NOT NULL,
  `task_assigned` int(11) NOT NULL,
  `assign_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fx_bugs`
--

CREATE TABLE IF NOT EXISTS `fx_bugs` (
  `bug_id` int(11) NOT NULL,
  `issue_ref` int(11) DEFAULT NULL,
  `project` int(11) DEFAULT NULL,
  `reporter` int(11) DEFAULT NULL,
  `assigned_to` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bug_status` enum('Unconfirmed','Confirmed','In Progress','Resolved','Verified') COLLATE utf8_unicode_ci DEFAULT 'Unconfirmed',
  `issue_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reproducibility` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `severity` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `priority` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bug_description` text COLLATE utf8_unicode_ci,
  `reported_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_modified` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fx_bug_comments`
--

CREATE TABLE IF NOT EXISTS `fx_bug_comments` (
  `c_id` int(11) NOT NULL,
  `bug_id` int(11) NOT NULL,
  `comment_by` int(11) NOT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `date_commented` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fx_bug_files`
--

CREATE TABLE IF NOT EXISTS `fx_bug_files` (
  `file_id` int(11) NOT NULL,
  `bug` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_ext` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` int(5) DEFAULT NULL,
  `is_image` int(2) DEFAULT NULL,
  `image_width` int(5) DEFAULT NULL,
  `image_height` int(5) DEFAULT NULL,
  `original_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_name` text COLLATE utf8_unicode_ci,
  `description` text COLLATE utf8_unicode_ci,
  `uploaded_by` int(11) NOT NULL,
  `date_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fx_captcha`
--

CREATE TABLE IF NOT EXISTS `fx_captcha` (
  `captcha_id` bigint(13) unsigned NOT NULL,
  `captcha_time` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(16) COLLATE utf8_unicode_ci DEFAULT '0',
  `word` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fx_captcha`
--

INSERT INTO `fx_captcha` (`captcha_id`, `captcha_time`, `ip_address`, `word`) VALUES
(1, 1456136113, '::1', 'ngL7502n'),
(2, 1456286471, '::1', 'kh9QNs7e');

-- --------------------------------------------------------

--
-- Table structure for table `fx_categories`
--

CREATE TABLE IF NOT EXISTS `fx_categories` (
  `id` int(11) unsigned NOT NULL,
  `cat_name` varchar(255) DEFAULT NULL,
  `module` varchar(32) DEFAULT 'expenses'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fx_categories`
--

INSERT INTO `fx_categories` (`id`, `cat_name`, `module`) VALUES
(1, 'Domain Purchase', 'expenses'),
(2, 'Hardware Used', 'expenses'),
(3, 'Software Used', 'expenses'),
(4, 'Transportation Fee', 'expenses'),
(5, 'Internet and Top Up Fees', 'expenses'),
(6, 'Server Used', 'projects'),
(7, 'PC / Notebook Used', 'projects'),
(8, 'Operating System Used', 'projects'),
(9, 'Database Used', 'projects'),
(10, 'IDE Used', 'projects');

-- --------------------------------------------------------

--
-- Table structure for table `fx_comments`
--

CREATE TABLE IF NOT EXISTS `fx_comments` (
  `comment_id` int(11) NOT NULL,
  `project` int(11) NOT NULL,
  `posted_by` int(11) NOT NULL,
  `message` text COLLATE utf8_unicode_ci,
  `date_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fx_comment_replies`
--

CREATE TABLE IF NOT EXISTS `fx_comment_replies` (
  `reply_id` int(11) NOT NULL,
  `parent_comment` int(11) DEFAULT NULL,
  `reply_msg` text COLLATE utf8_unicode_ci,
  `replied_by` int(11) DEFAULT NULL,
  `del` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `date_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fx_companies`
--

CREATE TABLE IF NOT EXISTS `fx_companies` (
  `co_id` int(11) unsigned NOT NULL,
  `company_ref` int(32) DEFAULT NULL,
  `individual` tinyint(4) DEFAULT '0',
  `company_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `primary_contact` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_email` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_phone` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_mobile` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_fax` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency` varchar(32) COLLATE utf8_unicode_ci DEFAULT 'USD',
  `language` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VAT` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hosting_company` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hostname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `port` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_password` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_username` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_holder` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iban` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bic` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sortcode` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `skype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fx_companies`
--

INSERT INTO `fx_companies` (`co_id`, `company_ref`, `individual`, `company_name`, `primary_contact`, `company_email`, `company_website`, `company_phone`, `company_mobile`, `company_fax`, `company_address`, `city`, `state`, `currency`, `language`, `country`, `VAT`, `date_added`, `hosting_company`, `hostname`, `port`, `account_password`, `account_username`, `zip`, `account_holder`, `account`, `iban`, `bank`, `bic`, `sortcode`, `skype`, `linkedin`, `facebook`, `twitter`) VALUES
(1, 3891768, 0, 'Ultra Software Solution', '1', 'ultrasoftwaresolution@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'USD', 'english', NULL, NULL, '2016-02-18 12:13:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 9325485, 0, 'Test Ebusiness Role', NULL, 'test@test.com', '', '', '', '', '', '', '', 'USD', 'english', 'Australia', '', '2016-02-22 11:25:50', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `fx_config`
--

CREATE TABLE IF NOT EXISTS `fx_config` (
  `config_key` varchar(255) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fx_config`
--

INSERT INTO `fx_config` (`config_key`, `value`) VALUES
('2checkout_private_key', ''),
('2checkout_publishable_key', ''),
('2checkout_seller_id', ''),
('allowed_files', 'gif|png|jpeg|jpg|pdf|doc|txt|docx|xls|zip|rar|xls|mp4'),
('allow_client_registration', 'TRUE'),
('automatic_email_on_recur', 'TRUE'),
('auto_backup_db', 'TRUE'),
('auto_close_ticket', '30'),
('beta_updates', 'FALSE'),
('bitcoin_address', ''),
('build', '0'),
('button_color', 'success'),
('captcha_registration', 'FALSE'),
('client_create_project', 'TRUE'),
('company_address', '4146 Golden Woods'),
('company_city', 'Glass Hill, Sydney'),
('company_country', 'Australia'),
('company_domain', 'http://localhost/pm/freelanceroffice/'),
('company_email', 'ultrasoftwaresolution@gmail.com'),
('company_fax', ''),
('company_legal_name', 'Gitbench LLC'),
('company_logo', 'logo.png'),
('company_mobile', ''),
('company_name', 'Ultra Software Solution'),
('company_phone', '+123 456 789'),
('company_phone_2', ''),
('company_registration', ''),
('company_state', 'Victoria'),
('company_vat', ''),
('company_zip_code', ''),
('contact_person', 'John Doe'),
('cron_key', '34WI2L12L87I1A65M90M9A42N41D08A26I'),
('cron_last_run', 'Wed-12-15 05:17:32'),
('currency_decimals', '2'),
('currency_position', 'before'),
('date_format', '%d-%m-%Y'),
('date_php_format', 'd-m-Y'),
('date_picker_format', 'dd-mm-yyyy'),
('decimal_separator', '.'),
('default_currency', 'USD'),
('default_currency_symbol', '$'),
('default_language', 'english'),
('default_tax', '0.00'),
('default_terms', 'Thank you for <span style="font-weight: bold;">your</span> business. Please process this invoice within the due date.'),
('demo_mode', 'FALSE'),
('developer', 'ig63Yd/+yuA8127gEyTz9TY4pnoeKq8dtocVP44+BJvtlRp8Vqcetwjk51dhSB6Rx8aVIKOPfUmNyKGWK7C/gg=='),
('display_estimate_badge', 'TRUE'),
('display_invoice_badge', 'TRUE'),
('email_account_details', 'TRUE'),
('email_estimate_message', 'Hi {CLIENT}<br>Thanks for your business inquiry. <br>The estimate EST {REF} is attached with this email. <br>Estimate Overview:<br>Estimate # : EST {REF}<br>Amount: {CURRENCY} {AMOUNT}<br> You can view the estimate online at:<br>{LINK}<br>Best Regards,<br>{COMPANY}'),
('email_invoice_message', 'Hello {CLIENT}<br>Here is the invoice of {CURRENCY} {AMOUNT}<br>You can view the invoice online at:<br>{LINK}<br>Best Regards,<br>{COMPANY}'),
('email_staff_tickets', 'TRUE'),
('enable_languages', 'TRUE'),
('estimate_color', '#FB6B5B'),
('estimate_footer', 'Powered by Freelancer Office'),
('estimate_language', 'en'),
('estimate_prefix', 'EST'),
('estimate_terms', 'Looking forward to doing business with you.'),
('file_max_size', '80000'),
('gcal_api_key', ''),
('gcal_id', ''),
('hide_branding', 'FALSE'),
('hide_sidebar', 'FALSE'),
('increment_invoice_number', 'TRUE'),
('installed', 'TRUE'),
('invoices_due_after', '30'),
('invoice_color', '#53B567'),
('invoice_footer', 'Powered by Freelancer Office'),
('invoice_language', 'en'),
('invoice_logo', 'invoice_logo.png'),
('invoice_logo_height', '60'),
('invoice_logo_width', '304'),
('invoice_prefix', 'INV'),
('invoice_start_no', '1'),
('languages', ''),
('last_check', '1457140309'),
('last_seen_activities', '1452719930'),
('locale', 'en_US'),
('login_bg', 'bg_wall.jpg'),
('login_title', 'Project Management'),
('logo_or_icon', 'logo_title'),
('mail_encryption', 'tls'),
('mail_imap_host', 'mail.digitaleyes.gr'),
('mail_password', ''),
('mail_username', ''),
('notify_bug_assignment', 'TRUE'),
('notify_bug_comments', 'TRUE'),
('notify_bug_status', 'TRUE'),
('notify_message_received', 'TRUE'),
('notify_payment_received', 'TRUE'),
('notify_project_assignments', 'TRUE'),
('notify_project_comments', 'TRUE'),
('notify_project_files', 'TRUE'),
('notify_task_assignments', 'TRUE'),
('paypal_cancel_url', 'paypal/cancel'),
('paypal_email', 'ultrasoftwaresolution@gmail.com'),
('paypal_ipn_url', 'paypal/t_ipn/ipn'),
('paypal_live', 'TRUE'),
('paypal_success_url', 'paypal/success'),
('pdf_engine', 'mpdf'),
('postmark_api_key', ''),
('postmark_from_address', ''),
('project_prefix', 'PRO'),
('protocol', 'mail'),
('purchase_code', 'a4a9bf12-07e8-4863-930c-76b53564ae5a'),
('quantity_decimals', '2'),
('reminder_message', 'Hello {CLIENT}<br>This is a friendly reminder to pay your invoice of {CURRENCY} {AMOUNT}<br>You can view the invoice online at:<br>{LINK}<br>Best Regards,<br>{COMPANY}'),
('remote_login_expires', '72'),
('reset_key', '34WI2L12L87I1A65M90M9A42N41D08A26I'),
('rows_per_table', '25'),
('settings', 'crons'),
('show_estimate_tax', 'TRUE'),
('show_invoice_tax', 'TRUE'),
('show_login_image', 'TRUE'),
('show_only_logo', 'FALSE'),
('sidebar_theme', 'dark'),
('site_appleicon', 'logo.png'),
('site_author', 'William M.'),
('site_desc', 'Freelancer Office is a Web based PHP project management system for Freelancers - buy it on codecanyon'),
('site_favicon', 'logo.png'),
('site_icon', 'fa-flask'),
('slack_channel', ''),
('slack_notification', 'FALSE'),
('slack_username', ''),
('slack_webhook', ''),
('smtp_host', 'smtp.mandrillapp.com'),
('smtp_pass', ''),
('smtp_port', '587'),
('smtp_user', 'ultrasoftwaresolution@gmail.com'),
('stripe_private_key', ''),
('stripe_public_key', ''),
('swap_to_from', 'FALSE'),
('system_font', 'roboto_condensed'),
('tax_decimals', '2'),
('theme_color', 'success'),
('thousand_separator', ','),
('timezone', 'Europe/London'),
('top_bar_color', 'dark'),
('two_checkout_live', 'TRUE'),
('updates', '1'),
('use_gravatar', 'TRUE'),
('use_postmark', 'FALSE'),
('valid_license', 'TRUE'),
('website_name', 'Ultra Software Solution'),
('xrates_check', '2016-03-02');

-- --------------------------------------------------------

--
-- Table structure for table `fx_countries`
--

CREATE TABLE IF NOT EXISTS `fx_countries` (
  `id` int(6) NOT NULL,
  `value` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=242 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fx_countries`
--

INSERT INTO `fx_countries` (`id`, `value`) VALUES
(1, 'Afghanistan'),
(2, 'Aringland Islands'),
(3, 'Albania'),
(4, 'Algeria'),
(5, 'American Samoa'),
(6, 'Andorra'),
(7, 'Angola'),
(8, 'Anguilla'),
(9, 'Antarctica'),
(10, 'Antigua and Barbuda'),
(11, 'Argentina'),
(12, 'Armenia'),
(13, 'Aruba'),
(14, 'Australia'),
(15, 'Austria'),
(16, 'Azerbaijan'),
(17, 'Bahamas'),
(18, 'Bahrain'),
(19, 'Bangladesh'),
(20, 'Barbados'),
(21, 'Belarus'),
(22, 'Belgium'),
(23, 'Belize'),
(24, 'Benin'),
(25, 'Bermuda'),
(26, 'Bhutan'),
(27, 'Bolivia'),
(28, 'Bosnia and Herzegovina'),
(29, 'Botswana'),
(30, 'Bouvet Island'),
(31, 'Brazil'),
(32, 'British Indian Ocean territory'),
(33, 'Brunei Darussalam'),
(34, 'Bulgaria'),
(35, 'Burkina Faso'),
(36, 'Burundi'),
(37, 'Cambodia'),
(38, 'Cameroon'),
(39, 'Canada'),
(40, 'Cape Verde'),
(41, 'Cayman Islands'),
(42, 'Central African Republic'),
(43, 'Chad'),
(44, 'Chile'),
(45, 'China'),
(46, 'Christmas Island'),
(47, 'Cocos (Keeling) Islands'),
(48, 'Colombia'),
(49, 'Comoros'),
(50, 'Congo'),
(51, 'Congo'),
(52, ' Democratic Republic'),
(53, 'Cook Islands'),
(54, 'Costa Rica'),
(55, 'Ivory Coast (Ivory Coast)'),
(56, 'Croatia (Hrvatska)'),
(57, 'Cuba'),
(58, 'Cyprus'),
(59, 'Czech Republic'),
(60, 'Denmark'),
(61, 'Djibouti'),
(62, 'Dominica'),
(63, 'Dominican Republic'),
(64, 'East Timor'),
(65, 'Ecuador'),
(66, 'Egypt'),
(67, 'El Salvador'),
(68, 'Equatorial Guinea'),
(69, 'Eritrea'),
(70, 'Estonia'),
(71, 'Ethiopia'),
(72, 'Falkland Islands'),
(73, 'Faroe Islands'),
(74, 'Fiji'),
(75, 'Finland'),
(76, 'France'),
(77, 'French Guiana'),
(78, 'French Polynesia'),
(79, 'French Southern Territories'),
(80, 'Gabon'),
(81, 'Gambia'),
(82, 'Georgia'),
(83, 'Germany'),
(84, 'Ghana'),
(85, 'Gibraltar'),
(86, 'Greece'),
(87, 'Greenland'),
(88, 'Grenada'),
(89, 'Guadeloupe'),
(90, 'Guam'),
(91, 'Guatemala'),
(92, 'Guinea'),
(93, 'Guinea-Bissau'),
(94, 'Guyana'),
(95, 'Haiti'),
(96, 'Heard and McDonald Islands'),
(97, 'Honduras'),
(98, 'Hong Kong'),
(99, 'Hungary'),
(100, 'Iceland'),
(101, 'India'),
(102, 'Indonesia'),
(103, 'Iran'),
(104, 'Iraq'),
(105, 'Ireland'),
(106, 'Israel'),
(107, 'Italy'),
(108, 'Jamaica'),
(109, 'Japan'),
(110, 'Jordan'),
(111, 'Kazakhstan'),
(112, 'Kenya'),
(113, 'Kiribati'),
(114, 'Korea (north)'),
(115, 'Korea (south)'),
(116, 'Kuwait'),
(117, 'Kyrgyzstan'),
(118, 'Lao People''s Democratic Republic'),
(119, 'Latvia'),
(120, 'Lebanon'),
(121, 'Lesotho'),
(122, 'Liberia'),
(123, 'Libyan Arab Jamahiriya'),
(124, 'Liechtenstein'),
(125, 'Lithuania'),
(126, 'Luxembourg'),
(127, 'Macao'),
(128, 'Macedonia'),
(129, 'Madagascar'),
(130, 'Malawi'),
(131, 'Malaysia'),
(132, 'Maldives'),
(133, 'Mali'),
(134, 'Malta'),
(135, 'Marshall Islands'),
(136, 'Martinique'),
(137, 'Mauritania'),
(138, 'Mauritius'),
(139, 'Mayotte'),
(140, 'Mexico'),
(141, 'Micronesia'),
(142, 'Moldova'),
(143, 'Monaco'),
(144, 'Mongolia'),
(145, 'Montserrat'),
(146, 'Morocco'),
(147, 'Mozambique'),
(148, 'Myanmar'),
(149, 'Namibia'),
(150, 'Nauru'),
(151, 'Nepal'),
(152, 'Netherlands'),
(153, 'Netherlands Antilles'),
(154, 'New Caledonia'),
(155, 'New Zealand'),
(156, 'Nicaragua'),
(157, 'Niger'),
(158, 'Nigeria'),
(159, 'Niue'),
(160, 'Norfolk Island'),
(161, 'Northern Mariana Islands'),
(162, 'Norway'),
(163, 'Oman'),
(164, 'Pakistan'),
(165, 'Palau'),
(166, 'Palestinian Territories'),
(167, 'Panama'),
(168, 'Papua New Guinea'),
(169, 'Paraguay'),
(170, 'Peru'),
(171, 'Philippines'),
(172, 'Pitcairn'),
(173, 'Poland'),
(174, 'Portugal'),
(175, 'Puerto Rico'),
(176, 'Qatar'),
(177, 'Runion'),
(178, 'Romania'),
(179, 'Russian Federation'),
(180, 'Rwanda'),
(181, 'Saint Helena'),
(182, 'Saint Kitts and Nevis'),
(183, 'Saint Lucia'),
(184, 'Saint Pierre and Miquelon'),
(185, 'Saint Vincent and the Grenadines'),
(186, 'Samoa'),
(187, 'San Marino'),
(188, 'Sao Tome and Principe'),
(189, 'Saudi Arabia'),
(190, 'Senegal'),
(191, 'Serbia and Montenegro'),
(192, 'Seychelles'),
(193, 'Sierra Leone'),
(194, 'Singapore'),
(195, 'Slovakia'),
(196, 'Slovenia'),
(197, 'Solomon Islands'),
(198, 'Somalia'),
(199, 'South Africa'),
(200, 'South Georgia and the South Sandwich Islands'),
(201, 'Spain'),
(202, 'Sri Lanka'),
(203, 'Sudan'),
(204, 'Suriname'),
(205, 'Svalbard and Jan Mayen Islands'),
(206, 'Swaziland'),
(207, 'Sweden'),
(208, 'Switzerland'),
(209, 'Syria'),
(210, 'Taiwan'),
(211, 'Tajikistan'),
(212, 'Tanzania'),
(213, 'Thailand'),
(214, 'Togo'),
(215, 'Tokelau'),
(216, 'Tonga'),
(217, 'Trinidad and Tobago'),
(218, 'Tunisia'),
(219, 'Turkey'),
(220, 'Turkmenistan'),
(221, 'Turks and Caicos Islands'),
(222, 'Tuvalu'),
(223, 'Uganda'),
(224, 'Ukraine'),
(225, 'United Arab Emirates'),
(226, 'United Kingdom'),
(227, 'United States of America'),
(228, 'Uruguay'),
(229, 'Uzbekistan'),
(230, 'Vanuatu'),
(231, 'Vatican City'),
(232, 'Venezuela'),
(233, 'Vietnam'),
(234, 'Virgin Islands (British)'),
(235, 'Virgin Islands (US)'),
(236, 'Wallis and Futuna Islands'),
(237, 'Western Sahara'),
(238, 'Yemen'),
(239, 'Zaire'),
(240, 'Zambia'),
(241, 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `fx_currencies`
--

CREATE TABLE IF NOT EXISTS `fx_currencies` (
  `code` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `symbol` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `xrate` decimal(12,5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fx_currencies`
--

INSERT INTO `fx_currencies` (`code`, `name`, `symbol`, `xrate`) VALUES
('AED', 'United Arab Emirates Dirham', 'ARE', '3.67304'),
('AUD', 'Australian Dollar', '$', '1.39352'),
('BRL', 'Brazilian Real', 'R$', '3.94490'),
('CAD', 'Canadian Dollar', '$', '1.34396'),
('CHF', 'Swiss Franc', 'Fr', '0.99788'),
('CLP', 'Chilean Peso', '$', '693.62740'),
('CNY', 'Chinese Yuan', '¥', '6.55080'),
('CZK', 'Czech Koruna', 'Kč', '24.86509'),
('DKK', 'Danish Krone', 'kr', '6.85972'),
('EUR', 'Euro', '€', '0.92036'),
('GBP', 'British Pound', '£', '0.71652'),
('HKD', 'Hong Kong Dollar', '$', '7.77249'),
('HUF', 'Hungarian Forint', 'Ft', '285.02040'),
('IDR', 'Indonesian Rupiah', 'Rp', '13328.50000'),
('ILS', 'Israeli New Shekel', '₪', '3.88928'),
('INR', 'Indian Rupee', 'INR', '67.86076'),
('JPY', 'Japanese Yen', '¥', '113.88260'),
('KES', 'Kenya shillings', 'kes', '101.67940'),
('KRW', 'Korean Won', '₩', '1234.07334'),
('MXN', 'Mexican Peso', '$', '17.97512'),
('MYR', 'Malaysian Ringgit', 'RM', '4.15990'),
('NOK', 'Norwegian Krone', 'kr', '8.65974'),
('NZD', 'New Zealand Dollar', '$', '1.50733'),
('PHP', 'Philippine Peso', '₱', '47.29967'),
('PKR', 'Pakistan Rupee', '₨', '104.82270'),
('PLN', 'Polish Zloty', 'zł', '3.98705'),
('RUB', 'Russian Ruble', '₽', '73.77449'),
('SEK', 'Swedish Krona', 'kr', '8.60972'),
('SGD', 'Singapore Dollar', '$', '1.40187'),
('THB', 'Thai Baht', '฿', '35.62073'),
('TRY', 'Turkish Lira', '₺', '2.94399'),
('TWD', 'Taiwan Dollar', '$', '33.13206'),
('USD', 'US Dollar', '$', '1.00000'),
('VEF', 'Bolívar Fuerte', 'Bs.', '6.32055'),
('ZAR', 'South African Rand', 'R', '15.68471');

-- --------------------------------------------------------

--
-- Table structure for table `fx_departments`
--

CREATE TABLE IF NOT EXISTS `fx_departments` (
  `deptid` int(10) NOT NULL,
  `deptname` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `depthidden` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fx_departments`
--

INSERT INTO `fx_departments` (`deptid`, `deptname`, `depthidden`) VALUES
(1, 'eMTS', NULL),
(2, 'eFinance', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fx_email_templates`
--

CREATE TABLE IF NOT EXISTS `fx_email_templates` (
  `template_id` int(11) NOT NULL,
  `email_group` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `template_body` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fx_email_templates`
--

INSERT INTO `fx_email_templates` (`template_id`, `email_group`, `subject`, `template_body`) VALUES
(1, 'registration', 'Registration successful', '<table align="center" border="0" cellpadding="0" cellspacing="0" id="backgroundTable">\n	<tbody>\n		<tr>\n			<td valign="top">			<table align="center" border="0" cellpadding="0" cellspacing="0">\n				<tbody>\n					<tr>\n						<td height="50" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n					</tr>\n					<tr>\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px;">\n							<tbody>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n								<tr>\n									<td width="560">									<h4>New Account</h4>\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Hi {USERNAME},</p>\n								<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">			Thanks for joining {SITE_NAME}. We listed your sign in details below, make sure you keep them safe.<br>			To open your {SITE_NAME} homepage, please follow this link:<br>			<a href="{SITE_URL}" style="color: #11A7DB; text-decoration: none;"><strong>{SITE_NAME} Account</strong></a><br><br>			Link doesn''t work? Copy the following link to your browser address bar:<br><br>{SITE_URL}<br><br>			Your username: {USERNAME}<br>			Your email address: {EMAIL}<br>			Your password: {PASSWORD}<br><br><br>										Best Regards,<br>																		{SITE_NAME}</p>\n									</td>\n								</tr>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td height="10" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>'),
(2, 'forgot_password', 'Forgot Password', '<table align="center" border="0" cellpadding="0" cellspacing="0" id="backgroundTable">\n	<tbody>\n		<tr>\n			<td valign="top">			<table align="center" border="0" cellpadding="0" cellspacing="0">\n				<tbody>\n					<tr>\n						<td height="50" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n					</tr>\n					<tr>\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px;">\n							<tbody>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n								<tr>\n									<td width="560">									<h4>New Password</h4>\n																	<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">			Forgot your password, huh? No big deal.<br>To create a new password, just follow this link:<br>			<a href="{PASS_KEY_URL}" style="color: #11A7DB; text-decoration: none;"><strong>Create new password</strong></a><br><br>			Link doesn''t work? Copy the following link to your browser address bar:<br>			{PASS_KEY_URL}<br><br>			You received this email, because it was requested by a {SITE_NAME} user.This is part of the procedure to create a new password on the system. If you DID NOT request a new password then please ignore this email and your password will remain the same.<br><br>Thank you,<br><br>										Best Regards,<br>																		{SITE_NAME}</p>\n									</td>\n								</tr>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td height="10" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>'),
(3, 'change_email', 'Change Email', '<table align="center" border="0" cellpadding="0" cellspacing="0" id="backgroundTable">\n	<tbody>\n		<tr>\n			<td valign="top">			<table align="center" border="0" cellpadding="0" cellspacing="0">\n				<tbody>\n					<tr>\n						<td height="50" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n					</tr>\n					<tr>\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px; ">\n							<tbody>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n								<tr>\n									<td width="560">									<h4>Change Email</h4>\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Hi {NEW_EMAIL},</p>\n								<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">			You have changed your email address for {SITE_NAME}.<br>Follow this link to confirm your new email address:<br>			<a href="{NEW_EMAIL_KEY_URL}" style="color: #11A7DB; text-decoration: none;"><strong>Confirm Email</strong></a><br><br>			Link doesn''t work? Copy the following link to your browser address bar:<br>			{NEW_EMAIL_KEY_URL}<br><br>			Your email address: {NEW_EMAIL}<br><br>			You received this email, because it was requested by a {SITE_NAME} user. If you have received this by mistake, please DO NOT click the confirmation link, and simply delete this email. After a short time, the request will be removed from the system.<br><br>Thank you,<br><br>										Best Regards,<br>																		{SITE_NAME}</p>\n									</td>\n								</tr>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td height="10" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>'),
(4, 'activate_account', 'Activate Account', '<table align="center" border="0" cellpadding="0" cellspacing="0" id="backgroundTable">\n	<tbody>\n		<tr>\n			<td valign="top">			<table align="center" border="0" cellpadding="0" cellspacing="0">\n				<tbody>\n					<tr>\n						<td height="50" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n					</tr>\n					<tr>\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px; ">\n							<tbody>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n								<tr>\n									<td width="560">									<h4>Activate Account</h4>\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Hi {USERNAME},</p>\n								<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">			Thanks for joining {SITE_NAME}. We listed your sign in details below, make sure you keep them safe.			To verify your email address, please follow this link:<br>			<a href="{ACTIVATE_URL}" style="color: #11A7DB; text-decoration: none;"><strong>Complete Registration</strong></a><br><br>			Link doesn''t work? Copy the following link to your browser address bar:<br>			{ACTIVATE_URL}<br>			Please verify your email within {ACTIVATION_PERIOD} hours, otherwise your registration will become invalid and you will have to register again.<br><br>			Your username: {USERNAME}<br>			Your email address: {EMAIL}<br>			Your password: {PASSWORD}<br><br><br>																					Best Regards,<br>																		{SITE_NAME}</p>\n									</td>\n								</tr>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td height="10" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>'),
(5, 'reset_password', 'Reset Password', '<table align="center" border="0" cellpadding="0" cellspacing="0" id="backgroundTable">\n	<tbody>\n		<tr>\n			<td valign="top">			<table align="center" border="0" cellpadding="0" cellspacing="0">\n				<tbody>\n					<tr>\n						<td height="50" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n					</tr>\n					<tr>\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px;">\n							<tbody>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n								<tr>\n									<td width="560">									<h4>New Password</h4>\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Hi {USERNAME},</p>\n								<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">			You have changed your password.<br>Please, keep it in your records so you don''t forget it:<br>Your username: {USERNAME}<br>Your email address: {EMAIL}<br>Your new password: {NEW_PASSWORD}<br><br><br>										Best Regards,<br>																		{SITE_NAME}</p>\n									</td>\n								</tr>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td height="10" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>'),
(6, 'bug_assigned', 'New Bug Assigned', '<table align="center" border="0" cellpadding="0" cellspacing="0" id="backgroundTable">\n	<tbody>\n		<tr>\n			<td valign="top">			<table align="center" border="0" cellpadding="0" cellspacing="0">\n				<tbody>\n					<tr>\n						<td height="50" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n					</tr>\n					<tr>\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px;">\n							<tbody>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n								<tr>\n									<td width="560">									<h4>Bug assigned</h4>\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Hi there,</p>\n								<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">			A new bug <strong>{ISSUE_TITLE} </strong> has been assigned to you by {ASSIGNED_BY} in project <strong>{PROJECT_TITLE}</strong>.<br>You can view this bug by logging in to the portal using the link below:<br><a href="{SITE_URL}" style="color: #11A7DB; text-decoration: none;"><strong>View Dashboard</strong></a><br><br><br>									Best Regards,<br>																		{SITE_NAME}</p>\n									</td>\n								</tr>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td height="10" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>'),
(7, 'bug_status', 'Bug status changed', '<table align="center" border="0" cellpadding="0" cellspacing="0" id="backgroundTable">\n	<tbody>\n		<tr>\n			<td valign="top">			<table align="center" border="0" cellpadding="0" cellspacing="0">\n				<tbody>\n					<tr>\n						<td height="50" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n					</tr>\n					<tr>\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px;">\n							<tbody>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n								<tr>\n									<td width="560">									<h4>Bug status changed</h4>\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Hi There,</p>\n								<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">			Bug <strong>{ISSUE_TITLE}</strong> has been marked as {STATUS} by {MARKED_BY}.<br>You can view this bug by logging in to the portal using the link below:<br><a href="{BUG_URL}" style="color: #11A7DB; text-decoration: none;"><strong>View Dashboard</strong></a><br><br><br>									Best Regards,<br>																		{SITE_NAME}</p>\n									</td>\n								</tr>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td height="10" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>'),
(8, 'bug_comment', 'New Bug Comment Received', '<table align="center" border="0" cellpadding="0" cellspacing="0" id="backgroundTable">\n	<tbody>\n		<tr>\n			<td valign="top">			<table align="center" border="0" cellpadding="0" cellspacing="0">\n				<tbody>\n					<tr>\n						<td height="50" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n					</tr>\n					<tr>\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px;">\n							<tbody>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n								<tr>\n									<td width="560">									<h4>New comment received</h4>\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Hi There,</p>\n								<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">			A new comment has been posted by <strong>{POSTED_BY}</strong> to bug <strong>{ISSUE_TITLE}</strong>.<br>You can view the comment using the link below:<br><a href="{COMMENT_URL}" style="color: #11A7DB; text-decoration: none;"><strong>View Dashboard</strong></a><br><br></p>\n<blockquote style="font-style:italic">\n{COMMENT_MESSAGE}</blockquote>\n<br>									Best Regards,<br>																		{SITE_NAME}<p></p>\n									</td>\n								</tr>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td height="10" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>'),
(9, 'bug_file', 'New bug file', '<table align="center" border="0" cellpadding="0" cellspacing="0" id="backgroundTable">\n	<tbody>\n		<tr>\n			<td valign="top">			<table align="center" border="0" cellpadding="0" cellspacing="0">\n				<tbody>\n					<tr>\n						<td height="50" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n					</tr>\n					<tr>\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px;">\n							<tbody>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n								<tr>\n									<td width="560">									<h4>New Upload</h4>\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Hi There,</p>\n								<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">			A new file has been uploaded by <strong>{UPLOADED_BY}</strong> to issue <strong>{ISSUE_TITLE}</strong>.<br>You can view the bug using the link below.:<br><a href="{BUG_URL}" style="color: #11A7DB; text-decoration: none;"><strong>View Dashboard</strong></a><br><br><br>									Best Regards,									<br>																		{SITE_NAME}</p>\n									</td>\n								</tr>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td height="10" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>'),
(10, 'bug_reported', 'New bug Reported', '<table align="center" border="0" cellpadding="0" cellspacing="0" id="backgroundTable">\n	<tbody>\n		<tr>\n			<td valign="top">			<table align="center" border="0" cellpadding="0" cellspacing="0">\n				<tbody>\n					<tr>\n						<td height="50" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n					</tr>\n					<tr>\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px;">\n							<tbody>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n								<tr>\n									<td width="560">									<h4>New bug reported</h4>\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Hi There,</p>\n								<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">			A new bug <strong>{ISSUE_TITLE}</strong> has been reported by {ADDED_BY}.<br>You can view the Bug using the Dashboard Page.:<br><a href="{BUG_URL}" style="color: #11A7DB; text-decoration: none;"><strong>View Dashboard</strong></a><br><br><br>									Best Regards,									<br>																		{SITE_NAME}</p>\n									</td>\n								</tr>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td height="10" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>'),
(11, 'project_file', 'New Project File', '<table align="center" border="0" cellpadding="0" cellspacing="0" id="backgroundTable">\n	<tbody>\n		<tr>\n			<td valign="top">			<table align="center" border="0" cellpadding="0" cellspacing="0">\n				<tbody>\n					<tr>\n						<td height="50" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n					</tr>\n					<tr>\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px;">\n							<tbody>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n								<tr>\n									<td width="560">									<h4>New Upload</h4>\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Hi There,</p>\n								<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">			A new file has been uploaded by <strong>{UPLOADED_BY}</strong> to project <strong>{PROJECT_TITLE}</strong>.<br>You can view the Project using the link below:<br><a href="{PROJECT_URL}" style="color: #11A7DB; text-decoration: none;"><strong>View Dashboard</strong></a><br><br><br>									Best Regards,									<br>																		{SITE_NAME}</p>\n									</td>\n								</tr>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td height="10" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>'),
(12, 'project_complete', 'Project Completed', '<table align="center" border="0" cellpadding="0" cellspacing="0" id="backgroundTable">\n	<tbody>\n		<tr>\n			<td valign="top">			<table align="center" border="0" cellpadding="0" cellspacing="0">\n				<tbody>\n					<tr>\n						<td height="50" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n					</tr>\n					<tr>\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px;">\n							<tbody>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n								<tr>\n									<td width="560">									<h4>Project Completed</h4>\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Hi {CLIENT_NAME},</p>\n								<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">			Project : <strong>{PROJECT_TITLE}</strong> - <strong>{PROJECT_CODE}</strong> has been completed.<br>You can view the project by logging into your portal Account:<br><a href="{PROJECT_URL}" style="color: #11A7DB; text-decoration: none;"><strong>View Dashboard</strong></a><br><br>Project Overview:<br>Hours Logged # : <strong>{PROJECT_HOURS}</strong> hours<br>Project Cost : <strong>{PROJECT_COST}</strong><br><br>									Best Regards,									<br>																		{SITE_NAME}</p>\n									</td>\n								</tr>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td height="10" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>'),
(13, 'project_comment', 'New Project Comment Received', '<table align="center" border="0" cellpadding="0" cellspacing="0" id="backgroundTable">\n\n	<tbody>\n\n		<tr>\n\n			<td valign="top">			<table align="center" border="0" cellpadding="0" cellspacing="0">\n\n				<tbody>\n\n					<tr>\n\n						<td height="50" width="600">&nbsp;</td>\n\n					</tr>\n\n					<tr>\n\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n\n					</tr>\n\n					<tr>\n\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px;">\n\n							<tbody>\n\n								<tr>\n\n									<td height="10" width="560">&nbsp;</td>\n\n								</tr>\n\n								<tr>\n\n									<td width="560">\n									<h4>New comment received</h4>\n\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Hi There,</p>\n\n								<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">\n			A new comment has been posted by <strong>{POSTED_BY}</strong> to project <strong>{PROJECT_TITLE}</strong>.\n\nYou can view the comment using the link below:<br>\n<a href="{COMMENT_URL}" style="color: #11A7DB; text-decoration: none;"><strong>View Dashboard</strong></a>\n<br><br>\n<span style="font-style:italic;">{COMMENT_MESSAGE}</span>\n<br><br>\n\n									Best Regards,\n									<br>									\n									{SITE_NAME}</p>\n\n									</td>\n\n								</tr>\n\n								<tr>\n\n									<td height="10" width="560">&nbsp;</td>\n\n								</tr>\n\n							</tbody>\n\n						</table>\n\n						</td>\n\n					</tr>\n\n					<tr>\n\n						<td height="10" width="600">&nbsp;</td>\n\n					</tr>\n\n					<tr>\n\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n\n					</tr>\n\n				</tbody>\n\n			</table>\n\n			</td>\n\n		</tr>\n\n	</tbody>\n\n</table>'),
(14, 'task_assigned', 'Task assigned', '<table align="center" border="0" cellpadding="0" cellspacing="0" id="backgroundTable">\n	<tbody>\n		<tr>\n			<td valign="top">			<table align="center" border="0" cellpadding="0" cellspacing="0">\n				<tbody>\n					<tr>\n						<td height="50" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n					</tr>\n					<tr>\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px;">\n							<tbody>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n								<tr>\n									<td width="560">									<h4>Task Assigned</h4>\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Hi There,</p>\n								<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">			A new task <strong>{TASK_NAME}</strong> has been assigned to you by <strong>{ASSIGNED_BY}</strong> in project <strong>{PROJECT_TITLE}</strong>.You can view this task by logging in to the portal using the link below:<br><a href="{PROJECT_URL}" style="color: #11A7DB; text-decoration: none;"><strong>View Dashboard</strong></a><br><br><br>									Best Regards,									<br>																		{SITE_NAME}</p>\n									</td>\n								</tr>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td height="10" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>'),
(15, 'project_assigned', 'Project assigned', '<table align="center" border="0" cellpadding="0" cellspacing="0" id="backgroundTable">\n	<tbody>\n		<tr>\n			<td valign="top">			<table align="center" border="0" cellpadding="0" cellspacing="0">\n				<tbody>\n					<tr>\n						<td height="50" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n					</tr>\n					<tr>\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px;">\n							<tbody>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n								<tr>\n									<td width="560">									<h4>Project Assigned</h4>\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Hi There,</p>\n								<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">			A new project <strong>{PROJECT_TITLE}</strong> has been assigned to you by {ASSIGNED_BY}.<br>You can view this project by logging in to the portal using the link below:<br><a href="{PROJECT_URL}" style="color: #11A7DB; text-decoration: none;"><strong>View Dashboard</strong></a><br><br><br>									Best Regards,									<br>																		{SITE_NAME}</p>\n									</td>\n								</tr>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td height="10" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>'),
(16, 'payment_email', 'Payment Received', '<table align="center" border="0" cellpadding="0" cellspacing="0" id="backgroundTable">\n	<tbody>\n		<tr>\n			<td valign="top">			<table align="center" border="0" cellpadding="0" cellspacing="0">\n				<tbody>\n					<tr>\n						<td height="50" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n					</tr>\n					<tr>\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px;">\n							<tbody>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n								<tr>\n									<td width="560">									<h4>Invoice {REF} Payment</h4>\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Dear Customer,</p>\n								<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">								We have received your payment of {INVOICE_CURRENCY} {PAID_AMOUNT}.<br>								Thank you for your Payment and business. We look forward to working with you again.<br>								--------------------------<br>																		<br><br>																		Best Regards,<br>																		{SITE_NAME}</p>\n									</td>\n								</tr>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td height="10" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>'),
(17, 'invoice_message', 'New Invoice', '<table align="center" border="0" cellpadding="0" cellspacing="0" id="backgroundTable">\n	<tbody>\n		<tr>\n			<td valign="top">			<table align="center" border="0" cellpadding="0" cellspacing="0">\n				<tbody>\n					<tr>\n						<td height="50" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n					</tr>\n					<tr>\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px;">\n							<tbody>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n								<tr>\n									<td width="560">									<h4>Invoice {REF}</h4>\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Hello {CLIENT},</p>\n									<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">Here is the invoice of {CURRENCY}{AMOUNT}<br>									You can login to see the status of your invoice by using this link:<br>									<a href="{INVOICE_LINK}" style="color: #11A7DB; text-decoration: none;"><strong>View Invoice</strong></a><br>									<br>									Best Regards,<br>									{SITE_NAME}</p>\n									</td>\n								</tr>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td height="10" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>'),
(18, 'invoice_reminder', 'Invoice Reminder', '<table align="center" border="0" cellpadding="0" cellspacing="0" id="backgroundTable">\n	<tbody>\n		<tr>\n			<td valign="top">			<table align="center" border="0" cellpadding="0" cellspacing="0">\n				<tbody>\n					<tr>\n						<td height="50" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n					</tr>\n					<tr>\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px;">\n							<tbody>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n								<tr>\n									<td width="560">									<h4>Invoice {REF} Reminder</h4>\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Hello {CLIENT},</p>\n								<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">									This is a friendly reminder to pay your invoice of {CURRENCY} {AMOUNT}<br>									You can view the invoice online at:<br>																		<a href="{INVOICE_LINK}" style="color: #11A7DB; text-decoration: none;"><strong>View Invoice</strong>									</a><br><br>																		Best Regards,<br>																		{SITE_NAME}</p>\n									</td>\n								</tr>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td height="10" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>'),
(19, 'message_received', 'Message Received', '<table align="center" id="backgroundTable">\n	<tbody>\n		<tr>\n			<td valign="top">			<table align="center">\n				<tbody>\n					<tr>\n						<td height="50" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n					</tr>\n					<tr>\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px; ">\n							<tbody>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n								<tr>\n									<td width="560">									<h4>New message received</h4>\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Hi {RECIPIENT},</p>\n								<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">You have received a message from <strong>{SENDER}</strong>.<br>------------------------------------------------------------------:<br><span style="font-style:italic;">{MESSAGE}</span><br><br><a href="{SITE_URL}" style="color: #11A7DB; text-decoration: none;"><strong>View Message</strong></a><br><br><br>									Best Regards,									<br>																		{SITE_NAME}</p>\n									</td>\n								</tr>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td height="10" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>'),
(20, 'estimate_email', 'New Estimate', '<table style="margin-left:20px; " id="backgroundTable">\n	<tbody>\n		<tr>\n			<td valign="top">			<table align="center">\n				<tbody>\n					<tr>\n						<td height="50" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n					</tr>\n					<tr>\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px; ">\n							<tbody>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n								<tr>\n									<td width="560">									<h4>Estimate {ESTIMATE_REF} Created</h4>\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Hi {CLIENT},</p>\n								<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">Thanks for your business inquiry.<br>The estimate <strong>{ESTIMATE_REF}</strong> is attached with this email.<br><br>Estimate Overview:<br>Estimate # : <strong>{ESTIMATE_REF}</strong><br>Amount: <strong>{CURRENCY}{AMOUNT}</strong><br>You can view the estimate online at:<br><a href="{ESTIMATE_LINK}" style="color: #11A7DB; text-decoration: none;"><strong>View Estimate</strong></a><br><br><br>									Best Regards,									<br>																		{SITE_NAME}</p>\n									</td>\n								</tr>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td height="10" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>'),
(21, 'ticket_staff_email', 'New Ticket [TICKET_CODE]', '<table align="center" border="0" cellpadding="0" cellspacing="0" id="backgroundTable">\n	<tbody>\n		<tr>\n			<td valign="top">			<table align="center" border="0" cellpadding="0" cellspacing="0">\n				<tbody>\n					<tr>\n						<td height="50" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n					</tr>\n					<tr>\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px;">\n							<tbody>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n								<tr>\n									<td width="560">									<h4>New Ticket</h4>\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Hi {USER_EMAIL},</p>\n								<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">Ticket <strong>#{TICKET_CODE}</strong> has been created by the client.<br>You may view the ticket by clicking on the following link:<br>Client Email : {REPORTER_EMAIL}<br><br><a href="{TICKET_LINK}" style="color: #11A7DB; text-decoration: none;"><strong>View Ticket</strong></a><br><br><br>									Best Regards,									<br>																		{SITE_NAME}</p>\n									</td>\n								</tr>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td height="10" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>'),
(22, 'ticket_client_email', 'Ticket [TICKET_CODE] Opened', '<table align="center" border="0" cellpadding="0" cellspacing="0" id="backgroundTable">\n	<tbody>\n		<tr>\n			<td valign="top">			<table align="center" border="0" cellpadding="0" cellspacing="0">\n				<tbody>\n					<tr>\n						<td height="50" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n					</tr>\n					<tr>\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px;">\n							<tbody>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n								<tr>\n									<td width="560">									<h4>Ticket Opened</h4>\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Hi {CLIENT_EMAIL},</p>\n								<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">			Your ticket has been opened with us.<br>Ticket #{TICKET_CODE}<br>Status : Open<br>Click on the below link to see the ticket details and post replies: <br><a href="{TICKET_LINK}" style="color: #11A7DB; text-decoration: none;"><strong>View Ticket</strong></a><br><br><br>									Best Regards,									<br>																		{SITE_NAME}</p>\n									</td>\n								</tr>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td height="10" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>'),
(23, 'ticket_reply_email', 'Ticket [TICKET_CODE] Response', '<table align="center" border="0" cellpadding="0" cellspacing="0" id="backgroundTable">\n	<tbody>\n		<tr>\n			<td valign="top">			<table align="center" border="0" cellpadding="0" cellspacing="0">\n				<tbody>\n					<tr>\n						<td height="50" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n					</tr>\n					<tr>\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px;">\n							<tbody>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n								<tr>\n									<td width="560">									<h4>Ticket Response</h4>\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Hi There,</p>\n								<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">A new response has been added to Ticket <strong>#{TICKET_CODE}</strong><br><br>Ticket : <strong>#{TICKET_CODE}</strong><br>Status : <strong>{TICKET_STATUS}</strong><br><span style="font-style:italic;"><strong>{TICKET_REPLY}</strong></span><br>To see the response and post additional comments, click on the link below:<br><a href="{TICKET_LINK}" style="color: #11A7DB; text-decoration: none;"><strong>View Ticket</strong></a><br><br><br>									Best Regards,									<br>																		{SITE_NAME}</p>\n									</td>\n								</tr>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td height="10" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>'),
(24, 'ticket_closed_email', 'Ticket [TICKET_CODE] Closed', '<table align="center" border="0" cellpadding="0" cellspacing="0" id="backgroundTable">\n	<tbody>\n		<tr>\n			<td valign="top">			<table align="center" border="0" cellpadding="0" cellspacing="0">\n				<tbody>\n					<tr>\n						<td height="50" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n					</tr>\n					<tr>\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px;">\n							<tbody>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n								<tr>\n									<td width="560">									<h4>Ticket Closed</h4>\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Hi {REPORTER_EMAIL},</p>\n								<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">			Ticket <strong>#{TICKET_CODE}</strong> has been closed by <strong>{STAFF_USERNAME}</strong><br>Ticket : <strong>#{TICKET_CODE}</strong><br>Status : <strong>{TICKET_STATUS}</strong><br>Replies : <strong>{NO_OF_REPLIES}</strong><br>To see the responses or open the ticket, click on the link below:<br><a href="{TICKET_LINK}" style="color: #11A7DB; text-decoration: none;"><strong>View Ticket</strong></a><br><br><br>									Best Regards,									<br>																		{SITE_NAME}</p>\n									</td>\n								</tr>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td height="10" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>'),
(25, 'project_updated', 'Project updated', '<table align="center" border="0" cellpadding="0" cellspacing="0" id="backgroundTable">\n	<tbody>\n		<tr>\n			<td valign="top">			<table align="center" border="0" cellpadding="0" cellspacing="0">\n				<tbody>\n					<tr>\n						<td height="50" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n					</tr>\n					<tr>\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px;">\n							<tbody>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n								<tr>\n									<td width="560">									<h4>Project Updated</h4>\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Hi There,</p>\n								<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">			<strong>{PROJECT_TITLE}</strong> has been updated by <strong>{ASSIGNED_BY}</strong>.You can view this project by logging in to the portal using the link below:<br><a href="{PROJECT_URL}" style="color: #11A7DB; text-decoration: none;"><strong>View Dashboard</strong></a><br><br><br>									Best Regards,									<br>																		{SITE_NAME}</p>\n									</td>\n								</tr>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td height="10" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>'),
(26, 'task_updated', 'Task updated', '<table align="center" border="0" cellpadding="0" cellspacing="0" id="backgroundTable">\n\n	<tbody>\n\n		<tr>\n\n			<td valign="top">			<table align="center" border="0" cellpadding="0" cellspacing="0">\n\n				<tbody>\n\n					<tr>\n\n						<td height="50" width="600">&nbsp;</td>\n\n					</tr>\n\n					<tr>\n\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n\n					</tr>\n\n					<tr>\n\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px;">\n\n							<tbody>\n\n								<tr>\n\n									<td height="10" width="560">&nbsp;</td>\n\n								</tr>\n\n								<tr>\n\n									<td width="560">\n									<h4>Task Updated</h4>\n\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Hi There,</p>\n\n								<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">\n			<strong>{TASK_NAME}</strong> in <strong>{PROJECT_TITLE}</strong> has been updated by <strong>{ASSIGNED_BY}</strong>.<br>\n\nYou can view this project by logging in to the portal using the link below:<br>\n<a href="{PROJECT_URL}" style="color: #11A7DB; text-decoration: none;"><strong>View Dashboard</strong></a>\n<br><br><br>\n\n									Best Regards,\n									<br>									\n									{SITE_NAME}</p>\n\n									</td>\n\n								</tr>\n\n								<tr>\n\n									<td height="10" width="560">&nbsp;</td>\n\n								</tr>\n\n							</tbody>\n\n						</table>\n\n						</td>\n\n					</tr>\n\n					<tr>\n\n						<td height="10" width="600">&nbsp;</td>\n\n					</tr>\n\n					<tr>\n\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n\n					</tr>\n\n				</tbody>\n\n			</table>\n\n			</td>\n\n		</tr>\n\n	</tbody>\n\n</table>'),
(27, 'email_signature', NULL, 'William M.');
INSERT INTO `fx_email_templates` (`template_id`, `email_group`, `subject`, `template_body`) VALUES
(28, 'auto_close_ticket', 'Ticket Auto Closed', '<table align="center" border="0" cellpadding="0" cellspacing="0" id="backgroundTable">\n	<tbody>\n		<tr>\n			<td valign="top">			<table align="center" border="0" cellpadding="0" cellspacing="0">\n				<tbody>\n					<tr>\n						<td height="50" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td height="90" style="color:#999999" width="600">{INVOICE_LOGO}</td>\n					</tr>\n					<tr>\n						<td bgcolor="whitesmoke" height="200" style="background:whitesmoke; border:1px solid #e0e0e0; font-family:Helvetica,Arial,sans-serif" valign="top" width="600">						<table align="center" style="margin-left:15px;">\n							<tbody>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n								<tr>\n									<td width="560">									<h4>Ticket Closed</h4>\n									<p style="font-size:12px; font-family:Helvetica,Arial,sans-serif">Hi {REPORTER_EMAIL},</p>\n								<p style="font-size:12px; line-height:20px; font-family:Helvetica,Arial,sans-serif">Ticket <strong>#{TICKET_CODE}</strong> has been auto closed due to inactivity. <br><br>Ticket : <strong>#{TICKET_CODE}</strong><br>Status : <strong>{TICKET_STATUS}</strong><br>To see the responses or open the ticket, click on the link below:<br><a href="{TICKET_LINK}" style="color: #11A7DB; text-decoration: none;"><strong>View Ticket</strong></a><br><br><br>									Best Regards,									<br>																		{SITE_NAME}</p>\n									</td>\n								</tr>\n								<tr>\n									<td height="10" width="560">&nbsp;</td>\n								</tr>\n							</tbody>\n						</table>\n						</td>\n					</tr>\n					<tr>\n						<td height="10" width="600">&nbsp;</td>\n					</tr>\n					<tr>\n						<td align="right"><span style="font-size:10px; color:#999999; font-family:Helvetica,Arial,sans-serif">{SIGNATURE}</span></td>\n					</tr>\n				</tbody>\n			</table>\n			</td>\n		</tr>\n	</tbody>\n</table>');

-- --------------------------------------------------------

--
-- Table structure for table `fx_estimates`
--

CREATE TABLE IF NOT EXISTS `fx_estimates` (
  `est_id` int(11) NOT NULL,
  `reference_no` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `client` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `due_date` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency` varchar(32) COLLATE utf8_unicode_ci DEFAULT 'USD',
  `discount` float NOT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  `tax` int(11) NOT NULL DEFAULT '0',
  `status` enum('Accepted','Declined','Pending') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pending',
  `date_sent` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `est_deleted` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `date_saved` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `emailed` enum('Yes','No') COLLATE utf8_unicode_ci DEFAULT 'No',
  `show_client` enum('Yes','No') COLLATE utf8_unicode_ci DEFAULT 'Yes',
  `invoiced` enum('Yes','No') COLLATE utf8_unicode_ci DEFAULT 'No'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fx_estimates`
--

INSERT INTO `fx_estimates` (`est_id`, `reference_no`, `client`, `due_date`, `currency`, `discount`, `notes`, `tax`, `status`, `date_sent`, `est_deleted`, `date_saved`, `emailed`, `show_client`, `invoiced`) VALUES
(1, 'EST48632', '1', '2016-02-24', 'USD', 0, 'Looking forward to doing business with you.', 0, 'Pending', NULL, 'No', '2016-02-24 17:02:11', 'No', 'Yes', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `fx_estimate_items`
--

CREATE TABLE IF NOT EXISTS `fx_estimate_items` (
  `item_id` int(11) NOT NULL,
  `item_tax_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `item_name` varchar(150) COLLATE utf8_unicode_ci DEFAULT 'Item Name',
  `item_desc` longtext COLLATE utf8_unicode_ci,
  `unit_cost` decimal(10,2) DEFAULT '0.00',
  `quantity` decimal(10,2) DEFAULT '0.00',
  `item_tax_total` decimal(10,2) DEFAULT '0.00',
  `total_cost` decimal(10,2) DEFAULT '0.00',
  `estimate_id` int(11) NOT NULL,
  `date_saved` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `item_order` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fx_expenses`
--

CREATE TABLE IF NOT EXISTS `fx_expenses` (
  `id` int(11) unsigned NOT NULL,
  `added_by` int(11) DEFAULT NULL,
  `billable` int(11) DEFAULT '1',
  `amount` decimal(10,2) DEFAULT '0.00',
  `expense_date` varchar(32) DEFAULT NULL,
  `notes` text,
  `project` int(11) DEFAULT NULL,
  `client` int(11) DEFAULT NULL,
  `receipt` varchar(255) DEFAULT NULL,
  `invoiced` int(11) DEFAULT NULL,
  `invoiced_id` int(11) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `saved` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fx_expenses`
--

INSERT INTO `fx_expenses` (`id`, `added_by`, `billable`, `amount`, `expense_date`, `notes`, `project`, `client`, `receipt`, `invoiced`, `invoiced_id`, `category`, `saved`) VALUES
(1, 10, 1, '8000.00', '24-02-2016', 'test', 2, 1, NULL, 0, NULL, 1, '2016-02-24 17:19:24');

-- --------------------------------------------------------

--
-- Table structure for table `fx_fields`
--

CREATE TABLE IF NOT EXISTS `fx_fields` (
  `id` int(10) NOT NULL,
  `deptid` int(10) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `uniqid` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fx_files`
--

CREATE TABLE IF NOT EXISTS `fx_files` (
  `file_id` int(11) NOT NULL,
  `project` int(11) NOT NULL,
  `file_name` text COLLATE utf8_unicode_ci,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ext` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` int(10) DEFAULT NULL,
  `is_image` int(2) DEFAULT NULL,
  `image_width` int(5) DEFAULT NULL,
  `image_height` int(5) DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `uploaded_by` int(11) NOT NULL,
  `date_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fx_files`
--

INSERT INTO `fx_files` (`file_id`, `project`, `file_name`, `title`, `path`, `ext`, `size`, `is_image`, `image_width`, `image_height`, `description`, `uploaded_by`, `date_posted`) VALUES
(2, 2, 'closeupme.jpg', 'Test Admin', 'PRO67497/admin/admin', '.jpg', 24, 1, 562, 592, 'Admin', 1, '2016-03-02 02:37:36'),
(3, 2, 'foreverlonely.jpg', 'Test Staff', 'PRO67497/e_employee/epm', '.jpg', 63, 1, 340, 286, 'test staff', 5, '2016-03-02 02:42:35'),
(4, 2, 'IMG00095-20140728-1644.jpg', 'Test Staff', 'PRO67497/e_employee/epm', '.jpg', 38, 1, 640, 480, 'test staff', 5, '2016-03-02 02:42:35');

-- --------------------------------------------------------

--
-- Table structure for table `fx_invoices`
--

CREATE TABLE IF NOT EXISTS `fx_invoices` (
  `inv_id` int(11) NOT NULL,
  `reference_no` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `client` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `due_date` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8_unicode_ci,
  `allow_paypal` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Yes',
  `allow_stripe` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `allow_2checkout` enum('Yes','No') COLLATE utf8_unicode_ci DEFAULT 'Yes',
  `allow_bitcoin` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `recurring` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `r_freq` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '31',
  `recur_start_date` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `recur_end_date` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `recur_frequency` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `recur_next_date` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'USD',
  `status` enum('Unpaid','Paid') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Unpaid',
  `archived` int(11) DEFAULT '0',
  `date_sent` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `inv_deleted` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `date_saved` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `emailed` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `show_client` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Yes',
  `viewed` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `alert_overdue` int(11) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fx_invoices`
--

INSERT INTO `fx_invoices` (`inv_id`, `reference_no`, `client`, `due_date`, `notes`, `allow_paypal`, `allow_stripe`, `allow_2checkout`, `allow_bitcoin`, `tax`, `discount`, `recurring`, `r_freq`, `recur_start_date`, `recur_end_date`, `recur_frequency`, `recur_next_date`, `currency`, `status`, `archived`, `date_sent`, `inv_deleted`, `date_saved`, `emailed`, `show_client`, `viewed`, `alert_overdue`) VALUES
(1, 'INV0001', '1', '2016-03-25', 'Thank you for <span >your</span> business. Please process this invoice within the due date.', 'No', 'No', 'No', 'No', '0.00', '0.00', 'No', '31', NULL, NULL, NULL, NULL, 'USD', 'Unpaid', 0, NULL, 'No', '2016-02-24 16:45:38', 'No', 'Yes', 'No', 0),
(2, 'INV0002', '1', '2016-03-25', 'Thank you for <span >your</span> business. Please process this invoice within the due date.', 'No', 'No', 'No', 'No', '0.00', '0.00', 'No', '31', NULL, NULL, NULL, NULL, 'USD', 'Unpaid', 0, NULL, 'No', '2016-02-24 16:46:15', 'No', 'Yes', 'No', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fx_items`
--

CREATE TABLE IF NOT EXISTS `fx_items` (
  `item_id` int(11) NOT NULL,
  `item_tax_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `item_tax_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantity` decimal(10,2) DEFAULT '0.00',
  `total_cost` decimal(10,2) DEFAULT '0.00',
  `invoice_id` int(11) NOT NULL,
  `item_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'Item Name',
  `item_desc` longtext COLLATE utf8_unicode_ci,
  `unit_cost` decimal(10,2) DEFAULT '0.00',
  `item_order` int(11) DEFAULT '0',
  `date_saved` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fx_items_saved`
--

CREATE TABLE IF NOT EXISTS `fx_items_saved` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT 'Item Name',
  `item_desc` longtext COLLATE utf8_unicode_ci,
  `unit_cost` decimal(10,2) DEFAULT '0.00',
  `item_tax_rate` decimal(10,2) DEFAULT '0.00',
  `item_tax_total` decimal(10,2) DEFAULT '0.00',
  `quantity` decimal(10,2) DEFAULT '0.00',
  `total_cost` decimal(10,2) DEFAULT '0.00',
  `deleted` enum('Yes','No') COLLATE utf8_unicode_ci DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fx_languages`
--

CREATE TABLE IF NOT EXISTS `fx_languages` (
  `code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(2) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fx_languages`
--

INSERT INTO `fx_languages` (`code`, `name`, `icon`, `active`) VALUES
('cs', 'czech', 'cs', 1),
('de', 'german', 'de', 1),
('el', 'greek', 'gr', 1),
('en', 'english', 'us', 1),
('es', 'spanish', 'es', 1),
('fr', 'french', 'fr', 1),
('it', 'italian', 'it', 0),
('nl', 'dutch', 'nl', 1),
('no', 'norwegian', 'no', 1),
('pl', 'polish', 'pl', 0),
('pt', 'portuguese', 'pt', 1),
('ro', 'romanian', 'ro', 1),
('ru', 'russian', 'ru', 1),
('sr', 'serbian', 'sr', 0),
('tr', 'turkish', 'tr', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fx_links`
--

CREATE TABLE IF NOT EXISTS `fx_links` (
  `link_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `client` int(11) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `link_title` varchar(255) DEFAULT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `description` text,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fx_locales`
--

CREATE TABLE IF NOT EXISTS `fx_locales` (
  `locale` varchar(10) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `language` varchar(100) DEFAULT NULL,
  `name` varchar(250) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fx_locales`
--

INSERT INTO `fx_locales` (`locale`, `code`, `language`, `name`) VALUES
('aa_DJ', 'aa', 'afar', 'Afar (Djibouti)'),
('aa_ER', 'aa', 'afar', 'Afar (Eritrea)'),
('aa_ET', 'aa', 'afar', 'Afar (Ethiopia)'),
('af_ZA', 'af', 'afrikaans', 'Afrikaans (South Africa)'),
('am_ET', 'am', 'amharic', 'Amharic (Ethiopia)'),
('an_ES', 'an', 'aragonese', 'Aragonese (Spain)'),
('ar_AE', 'ar', 'arabic', 'Arabic (United Arab Emirates)'),
('ar_BH', 'ar', 'arabic', 'Arabic (Bahrain)'),
('ar_DZ', 'ar', 'arabic', 'Arabic (Algeria)'),
('ar_EG', 'ar', 'arabic', 'Arabic (Egypt)'),
('ar_IN', 'ar', 'arabic', 'Arabic (India)'),
('ar_IQ', 'ar', 'arabic', 'Arabic (Iraq)'),
('ar_JO', 'ar', 'arabic', 'Arabic (Jordan)'),
('ar_KW', 'ar', 'arabic', 'Arabic (Kuwait)'),
('ar_LB', 'ar', 'arabic', 'Arabic (Lebanon)'),
('ar_LY', 'ar', 'arabic', 'Arabic (Libya)'),
('ar_MA', 'ar', 'arabic', 'Arabic (Morocco)'),
('ar_OM', 'ar', 'arabic', 'Arabic (Oman)'),
('ar_QA', 'ar', 'arabic', 'Arabic (Qatar)'),
('ar_SA', 'ar', 'arabic', 'Arabic (Saudi Arabia)'),
('ar_SD', 'ar', 'arabic', 'Arabic (Sudan)'),
('ar_SY', 'ar', 'arabic', 'Arabic (Syria)'),
('ar_TN', 'ar', 'arabic', 'Arabic (Tunisia)'),
('ar_YE', 'ar', 'arabic', 'Arabic (Yemen)'),
('ast_ES', 'ast', 'asturian', 'Asturian (Spain)'),
('as_IN', 'as', 'assamese', 'Assamese (India)'),
('az_AZ', 'az', 'azerbaijani', 'Azerbaijani (Azerbaijan)'),
('az_TR', 'az', 'azerbaijani', 'Azerbaijani (Turkey)'),
('bem_ZM', 'bem', 'bemba', 'Bemba (Zambia)'),
('ber_DZ', 'ber', 'berber', 'Berber (Algeria)'),
('ber_MA', 'ber', 'berber', 'Berber (Morocco)'),
('be_BY', 'be', 'belarusian', 'Belarusian (Belarus)'),
('bg_BG', 'bg', 'bulgarian', 'Bulgarian (Bulgaria)'),
('bn_BD', 'bn', 'bengali', 'Bengali (Bangladesh)'),
('bn_IN', 'bn', 'bengali', 'Bengali (India)'),
('bo_CN', 'bo', 'tibetan', 'Tibetan (China)'),
('bo_IN', 'bo', 'tibetan', 'Tibetan (India)'),
('br_FR', 'br', 'breton', 'Breton (France)'),
('bs_BA', 'bs', 'bosnian', 'Bosnian (Bosnia and Herzegovina)'),
('byn_ER', 'byn', 'blin', 'Blin (Eritrea)'),
('ca_AD', 'ca', 'catalan', 'Catalan (Andorra)'),
('ca_ES', 'ca', 'catalan', 'Catalan (Spain)'),
('ca_FR', 'ca', 'catalan', 'Catalan (France)'),
('ca_IT', 'ca', 'catalan', 'Catalan (Italy)'),
('crh_UA', 'crh', 'crimean turkish', 'Crimean Turkish (Ukraine)'),
('csb_PL', 'csb', 'kashubian', 'Kashubian (Poland)'),
('cs_CZ', 'cs', 'czech', 'Czech (Czech Republic)'),
('cv_RU', 'cv', 'chuvash', 'Chuvash (Russia)'),
('cy_GB', 'cy', 'welsh', 'Welsh (United Kingdom)'),
('da_DK', 'da', 'danish', 'Danish (Denmark)'),
('de_AT', 'de', 'german', 'German (Austria)'),
('de_BE', 'de', 'german', 'German (Belgium)'),
('de_CH', 'de', 'german', 'German (Switzerland)'),
('de_DE', 'de', 'german', 'German (Germany)'),
('de_LI', 'de', 'german', 'German (Liechtenstein)'),
('de_LU', 'de', 'german', 'German (Luxembourg)'),
('dv_MV', 'dv', 'divehi', 'Divehi (Maldives)'),
('dz_BT', 'dz', 'dzongkha', 'Dzongkha (Bhutan)'),
('ee_GH', 'ee', 'ewe', 'Ewe (Ghana)'),
('el_CY', 'el', 'greek', 'Greek (Cyprus)'),
('el_GR', 'el', 'greek', 'Greek (Greece)'),
('en_AG', 'en', 'english', 'English (Antigua and Barbuda)'),
('en_AS', 'en', 'english', 'English (American Samoa)'),
('en_AU', 'en', 'english', 'English (Australia)'),
('en_BW', 'en', 'english', 'English (Botswana)'),
('en_CA', 'en', 'english', 'English (Canada)'),
('en_DK', 'en', 'english', 'English (Denmark)'),
('en_GB', 'en', 'english', 'English (United Kingdom)'),
('en_GU', 'en', 'english', 'English (Guam)'),
('en_HK', 'en', 'english', 'English (Hong Kong SAR China)'),
('en_IE', 'en', 'english', 'English (Ireland)'),
('en_IN', 'en', 'english', 'English (India)'),
('en_JM', 'en', 'english', 'English (Jamaica)'),
('en_MH', 'en', 'english', 'English (Marshall Islands)'),
('en_MP', 'en', 'english', 'English (Northern Mariana Islands)'),
('en_MU', 'en', 'english', 'English (Mauritius)'),
('en_NG', 'en', 'english', 'English (Nigeria)'),
('en_NZ', 'en', 'english', 'English (New Zealand)'),
('en_PH', 'en', 'english', 'English (Philippines)'),
('en_SG', 'en', 'english', 'English (Singapore)'),
('en_TT', 'en', 'english', 'English (Trinidad and Tobago)'),
('en_US', 'en', 'english', 'English (United States)'),
('en_VI', 'en', 'english', 'English (Virgin Islands)'),
('en_ZA', 'en', 'english', 'English (South Africa)'),
('en_ZM', 'en', 'english', 'English (Zambia)'),
('en_ZW', 'en', 'english', 'English (Zimbabwe)'),
('eo', 'eo', 'esperanto', 'Esperanto'),
('es_AR', 'es', 'spanish', 'Spanish (Argentina)'),
('es_BO', 'es', 'spanish', 'Spanish (Bolivia)'),
('es_CL', 'es', 'spanish', 'Spanish (Chile)'),
('es_CO', 'es', 'spanish', 'Spanish (Colombia)'),
('es_CR', 'es', 'spanish', 'Spanish (Costa Rica)'),
('es_DO', 'es', 'spanish', 'Spanish (Dominican Republic)'),
('es_EC', 'es', 'spanish', 'Spanish (Ecuador)'),
('es_ES', 'es', 'spanish', 'Spanish (Spain)'),
('es_GT', 'es', 'spanish', 'Spanish (Guatemala)'),
('es_HN', 'es', 'spanish', 'Spanish (Honduras)'),
('es_MX', 'es', 'spanish', 'Spanish (Mexico)'),
('es_NI', 'es', 'spanish', 'Spanish (Nicaragua)'),
('es_PA', 'es', 'spanish', 'Spanish (Panama)'),
('es_PE', 'es', 'spanish', 'Spanish (Peru)'),
('es_PR', 'es', 'spanish', 'Spanish (Puerto Rico)'),
('es_PY', 'es', 'spanish', 'Spanish (Paraguay)'),
('es_SV', 'es', 'spanish', 'Spanish (El Salvador)'),
('es_US', 'es', 'spanish', 'Spanish (United States)'),
('es_UY', 'es', 'spanish', 'Spanish (Uruguay)'),
('es_VE', 'es', 'spanish', 'Spanish (Venezuela)'),
('et_EE', 'et', 'estonian', 'Estonian (Estonia)'),
('eu_ES', 'eu', 'basque', 'Basque (Spain)'),
('eu_FR', 'eu', 'basque', 'Basque (France)'),
('fa_AF', 'fa', 'persian', 'Persian (Afghanistan)'),
('fa_IR', 'fa', 'persian', 'Persian (Iran)'),
('ff_SN', 'ff', 'fulah', 'Fulah (Senegal)'),
('fil_PH', 'fil', 'filipino', 'Filipino (Philippines)'),
('fi_FI', 'fi', 'finnish', 'Finnish (Finland)'),
('fo_FO', 'fo', 'faroese', 'Faroese (Faroe Islands)'),
('fr_BE', 'fr', 'french', 'French (Belgium)'),
('fr_BF', 'fr', 'french', 'French (Burkina Faso)'),
('fr_BI', 'fr', 'french', 'French (Burundi)'),
('fr_BJ', 'fr', 'french', 'French (Benin)'),
('fr_CA', 'fr', 'french', 'French (Canada)'),
('fr_CF', 'fr', 'french', 'French (Central African Republic)'),
('fr_CG', 'fr', 'french', 'French (Congo)'),
('fr_CH', 'fr', 'french', 'French (Switzerland)'),
('fr_CM', 'fr', 'french', 'French (Cameroon)'),
('fr_FR', 'fr', 'french', 'French (France)'),
('fr_GA', 'fr', 'french', 'French (Gabon)'),
('fr_GN', 'fr', 'french', 'French (Guinea)'),
('fr_GP', 'fr', 'french', 'French (Guadeloupe)'),
('fr_GQ', 'fr', 'french', 'French (Equatorial Guinea)'),
('fr_KM', 'fr', 'french', 'French (Comoros)'),
('fr_LU', 'fr', 'french', 'French (Luxembourg)'),
('fr_MC', 'fr', 'french', 'French (Monaco)'),
('fr_MG', 'fr', 'french', 'French (Madagascar)'),
('fr_ML', 'fr', 'french', 'French (Mali)'),
('fr_MQ', 'fr', 'french', 'French (Martinique)'),
('fr_NE', 'fr', 'french', 'French (Niger)'),
('fr_SN', 'fr', 'french', 'French (Senegal)'),
('fr_TD', 'fr', 'french', 'French (Chad)'),
('fr_TG', 'fr', 'french', 'French (Togo)'),
('fur_IT', 'fur', 'friulian', 'Friulian (Italy)'),
('fy_DE', 'fy', 'western frisian', 'Western Frisian (Germany)'),
('fy_NL', 'fy', 'western frisian', 'Western Frisian (Netherlands)'),
('ga_IE', 'ga', 'irish', 'Irish (Ireland)'),
('gd_GB', 'gd', 'scottish gaelic', 'Scottish Gaelic (United Kingdom)'),
('gez_ER', 'gez', 'geez', 'Geez (Eritrea)'),
('gez_ET', 'gez', 'geez', 'Geez (Ethiopia)'),
('gl_ES', 'gl', 'galician', 'Galician (Spain)'),
('gu_IN', 'gu', 'gujarati', 'Gujarati (India)'),
('gv_GB', 'gv', 'manx', 'Manx (United Kingdom)'),
('ha_NG', 'ha', 'hausa', 'Hausa (Nigeria)'),
('he_IL', 'he', 'hebrew', 'Hebrew (Israel)'),
('hi_IN', 'hi', 'hindi', 'Hindi (India)'),
('hr_HR', 'hr', 'croatian', 'Croatian (Croatia)'),
('hsb_DE', 'hsb', 'upper sorbian', 'Upper Sorbian (Germany)'),
('ht_HT', 'ht', 'haitian', 'Haitian (Haiti)'),
('hu_HU', 'hu', 'hungarian', 'Hungarian (Hungary)'),
('hy_AM', 'hy', 'armenian', 'Armenian (Armenia)'),
('ia', 'ia', 'interlingua', 'Interlingua'),
('id_ID', 'id', 'indonesian', 'Indonesian (Indonesia)'),
('ig_NG', 'ig', 'igbo', 'Igbo (Nigeria)'),
('ik_CA', 'ik', 'inupiaq', 'Inupiaq (Canada)'),
('is_IS', 'is', 'icelandic', 'Icelandic (Iceland)'),
('it_CH', 'it', 'italian', 'Italian (Switzerland)'),
('it_IT', 'it', 'italian', 'Italian (Italy)'),
('iu_CA', 'iu', 'inuktitut', 'Inuktitut (Canada)'),
('ja_JP', 'ja', 'japanese', 'Japanese (Japan)'),
('ka_GE', 'ka', 'georgian', 'Georgian (Georgia)'),
('kk_KZ', 'kk', 'kazakh', 'Kazakh (Kazakhstan)'),
('kl_GL', 'kl', 'kalaallisut', 'Kalaallisut (Greenland)'),
('km_KH', 'km', 'khmer', 'Khmer (Cambodia)'),
('kn_IN', 'kn', 'kannada', 'Kannada (India)'),
('kok_IN', 'kok', 'konkani', 'Konkani (India)'),
('ko_KR', 'ko', 'korean', 'Korean (South Korea)'),
('ks_IN', 'ks', 'kashmiri', 'Kashmiri (India)'),
('ku_TR', 'ku', 'kurdish', 'Kurdish (Turkey)'),
('kw_GB', 'kw', 'cornish', 'Cornish (United Kingdom)'),
('ky_KG', 'ky', 'kirghiz', 'Kirghiz (Kyrgyzstan)'),
('lg_UG', 'lg', 'ganda', 'Ganda (Uganda)'),
('li_BE', 'li', 'limburgish', 'Limburgish (Belgium)'),
('li_NL', 'li', 'limburgish', 'Limburgish (Netherlands)'),
('lo_LA', 'lo', 'lao', 'Lao (Laos)'),
('lt_LT', 'lt', 'lithuanian', 'Lithuanian (Lithuania)'),
('lv_LV', 'lv', 'latvian', 'Latvian (Latvia)'),
('mai_IN', 'mai', 'maithili', 'Maithili (India)'),
('mg_MG', 'mg', 'malagasy', 'Malagasy (Madagascar)'),
('mi_NZ', 'mi', 'maori', 'Maori (New Zealand)'),
('mk_MK', 'mk', 'macedonian', 'Macedonian (Macedonia)'),
('ml_IN', 'ml', 'malayalam', 'Malayalam (India)'),
('mn_MN', 'mn', 'mongolian', 'Mongolian (Mongolia)'),
('mr_IN', 'mr', 'marathi', 'Marathi (India)'),
('ms_BN', 'ms', 'malay', 'Malay (Brunei)'),
('ms_MY', 'ms', 'malay', 'Malay (Malaysia)'),
('mt_MT', 'mt', 'maltese', 'Maltese (Malta)'),
('my_MM', 'my', 'burmese', 'Burmese (Myanmar)'),
('naq_NA', 'naq', 'namibia', 'Namibia'),
('nb_NO', 'nb', 'norwegian bokmål', 'Norwegian Bokmål (Norway)'),
('nds_DE', 'nds', 'low german', 'Low German (Germany)'),
('nds_NL', 'nds', 'low german', 'Low German (Netherlands)'),
('ne_NP', 'ne', 'nepali', 'Nepali (Nepal)'),
('nl_AW', 'nl', 'dutch', 'Dutch (Aruba)'),
('nl_BE', 'nl', 'dutch', 'Dutch (Belgium)'),
('nl_NL', 'nl', 'dutch', 'Dutch (Netherlands)'),
('nn_NO', 'nn', 'norwegian nynorsk', 'Norwegian Nynorsk (Norway)'),
('no_NO', 'no', 'norwegian', 'Norwegian (Norway)'),
('nr_ZA', 'nr', 'south ndebele', 'South Ndebele (South Africa)'),
('nso_ZA', 'nso', 'northern sotho', 'Northern Sotho (South Africa)'),
('oc_FR', 'oc', 'occitan', 'Occitan (France)'),
('om_ET', 'om', 'oromo', 'Oromo (Ethiopia)'),
('om_KE', 'om', 'oromo', 'Oromo (Kenya)'),
('or_IN', 'or', 'oriya', 'Oriya (India)'),
('os_RU', 'os', 'ossetic', 'Ossetic (Russia)'),
('pap_AN', 'pap', 'papiamento', 'Papiamento (Netherlands Antilles)'),
('pa_IN', 'pa', 'punjabi', 'Punjabi (India)'),
('pa_PK', 'pa', 'punjabi', 'Punjabi (Pakistan)'),
('pl_PL', 'pl', 'polish', 'Polish (Poland)'),
('ps_AF', 'ps', 'pashto', 'Pashto (Afghanistan)'),
('pt_BR', 'pt', 'portuguese', 'Portuguese (Brazil)'),
('pt_GW', 'pt', 'portuguese', 'Portuguese (Guinea-Bissau)'),
('pt_PT', 'pt', 'portuguese', 'Portuguese (Portugal)'),
('ro_MD', 'ro', 'romanian', 'Romanian (Moldova)'),
('ro_RO', 'ro', 'romanian', 'Romanian (Romania)'),
('ru_RU', 'ru', 'russian', 'Russian (Russia)'),
('ru_UA', 'ru', 'russian', 'Russian (Ukraine)'),
('rw_RW', 'rw', 'kinyarwanda', 'Kinyarwanda (Rwanda)'),
('sa_IN', 'sa', 'sanskrit', 'Sanskrit (India)'),
('sc_IT', 'sc', 'sardinian', 'Sardinian (Italy)'),
('sd_IN', 'sd', 'sindhi', 'Sindhi (India)'),
('seh_MZ', 'seh', 'sena', 'Sena (Mozambique)'),
('se_NO', 'se', 'northern sami', 'Northern Sami (Norway)'),
('sid_ET', 'sid', 'sidamo', 'Sidamo (Ethiopia)'),
('si_LK', 'si', 'sinhala', 'Sinhala (Sri Lanka)'),
('sk_SK', 'sk', 'slovak', 'Slovak (Slovakia)'),
('sl_SI', 'sl', 'slovenian', 'Slovenian (Slovenia)'),
('sn_ZW', 'sn', 'shona', 'Shona (Zimbabwe)'),
('so_DJ', 'so', 'somali', 'Somali (Djibouti)'),
('so_ET', 'so', 'somali', 'Somali (Ethiopia)'),
('so_KE', 'so', 'somali', 'Somali (Kenya)'),
('so_SO', 'so', 'somali', 'Somali (Somalia)'),
('sq_AL', 'sq', 'albanian', 'Albanian (Albania)'),
('sq_MK', 'sq', 'albanian', 'Albanian (Macedonia)'),
('sr_BA', 'sr', 'serbian', 'Serbian (Bosnia and Herzegovina)'),
('sr_ME', 'sr', 'serbian', 'Serbian (Montenegro)'),
('sr_RS', 'sr', 'serbian', 'Serbian (Serbia)'),
('ss_ZA', 'ss', 'swati', 'Swati (South Africa)'),
('st_ZA', 'st', 'southern sotho', 'Southern Sotho (South Africa)'),
('sv_FI', 'sv', 'swedish', 'Swedish (Finland)'),
('sv_SE', 'sv', 'swedish', 'Swedish (Sweden)'),
('sw_KE', 'sw', 'swahili', 'Swahili (Kenya)'),
('sw_TZ', 'sw', 'swahili', 'Swahili (Tanzania)'),
('ta_IN', 'ta', 'tamil', 'Tamil (India)'),
('teo_UG', 'teo', 'teso', 'Teso (Uganda)'),
('te_IN', 'te', 'telugu', 'Telugu (India)'),
('tg_TJ', 'tg', 'tajik', 'Tajik (Tajikistan)'),
('th_TH', 'th', 'thai', 'Thai (Thailand)'),
('tig_ER', 'tig', 'tigre', 'Tigre (Eritrea)'),
('ti_ER', 'ti', 'tigrinya', 'Tigrinya (Eritrea)'),
('ti_ET', 'ti', 'tigrinya', 'Tigrinya (Ethiopia)'),
('tk_TM', 'tk', 'turkmen', 'Turkmen (Turkmenistan)'),
('tl_PH', 'tl', 'tagalog', 'Tagalog (Philippines)'),
('tn_ZA', 'tn', 'tswana', 'Tswana (South Africa)'),
('to_TO', 'to', 'tongan', 'Tongan (Tonga)'),
('tr_CY', 'tr', 'turkish', 'Turkish (Cyprus)'),
('tr_TR', 'tr', 'turkish', 'Turkish (Turkey)'),
('ts_ZA', 'ts', 'tsonga', 'Tsonga (South Africa)'),
('tt_RU', 'tt', 'tatar', 'Tatar (Russia)'),
('ug_CN', 'ug', 'uighur', 'Uighur (China)'),
('uk_UA', 'uk', 'ukrainian', 'Ukrainian (Ukraine)'),
('ur_PK', 'ur', 'urdu', 'Urdu (Pakistan)'),
('uz_UZ', 'uz', 'uzbek', 'Uzbek (Uzbekistan)'),
('ve_ZA', 've', 'venda', 'Venda (South Africa)'),
('vi_VN', 'vi', 'vietnamese', 'Vietnamese (Vietnam)'),
('wa_BE', 'wa', 'walloon', 'Walloon (Belgium)'),
('wo_SN', 'wo', 'wolof', 'Wolof (Senegal)'),
('xh_ZA', 'xh', 'xhosa', 'Xhosa (South Africa)'),
('yi_US', 'yi', 'yiddish', 'Yiddish (United States)'),
('yo_NG', 'yo', 'yoruba', 'Yoruba (Nigeria)'),
('zh_CN', 'zh', 'chinese', 'Chinese (China)'),
('zh_HK', 'zh', 'chinese', 'Chinese (Hong Kong SAR China)'),
('zh_SG', 'zh', 'chinese', 'Chinese (Singapore)'),
('zh_TW', 'zh', 'chinese', 'Chinese (Taiwan)'),
('zu_ZA', 'zu', 'zulu', 'Zulu (South Africa)');

-- --------------------------------------------------------

--
-- Table structure for table `fx_login_attempts`
--

CREATE TABLE IF NOT EXISTS `fx_login_attempts` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(40) NOT NULL,
  `login` varchar(50) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fx_messages`
--

CREATE TABLE IF NOT EXISTS `fx_messages` (
  `msg_id` int(11) NOT NULL,
  `user_to` int(11) DEFAULT NULL,
  `user_from` int(11) DEFAULT NULL,
  `message` longtext COLLATE utf8_unicode_ci,
  `status` enum('Read','Unread') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Unread',
  `attached_file` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_received` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `favourite` int(11) DEFAULT '0',
  `deleted` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fx_milestones`
--

CREATE TABLE IF NOT EXISTS `fx_milestones` (
  `id` int(11) NOT NULL,
  `milestone_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `project` int(11) DEFAULT NULL,
  `start_date` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `due_date` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fx_outgoing_emails`
--

CREATE TABLE IF NOT EXISTS `fx_outgoing_emails` (
  `id` int(11) unsigned NOT NULL,
  `sent_to` varchar(64) DEFAULT NULL,
  `sent_from` varchar(64) DEFAULT NULL,
  `subject` text,
  `message` longtext,
  `date_sent` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `delivered` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fx_payments`
--

CREATE TABLE IF NOT EXISTS `fx_payments` (
  `p_id` int(11) NOT NULL,
  `invoice` int(11) NOT NULL,
  `paid_by` int(11) NOT NULL,
  `payer_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_method` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency` varchar(64) COLLATE utf8_unicode_ci DEFAULT 'USD',
  `amount` longtext COLLATE utf8_unicode_ci,
  `trans_id` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attached_file` text COLLATE utf8_unicode_ci,
  `payment_date` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `month_paid` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `year_paid` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `inv_deleted` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fx_payment_methods`
--

CREATE TABLE IF NOT EXISTS `fx_payment_methods` (
  `method_id` int(11) NOT NULL,
  `method_name` varchar(64) NOT NULL DEFAULT 'Paypal'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fx_payment_methods`
--

INSERT INTO `fx_payment_methods` (`method_id`, `method_name`) VALUES
(1, 'Online'),
(2, 'Cash'),
(3, 'Bank Deposit'),
(5, 'Cheque');

-- --------------------------------------------------------

--
-- Table structure for table `fx_permissions`
--

CREATE TABLE IF NOT EXISTS `fx_permissions` (
  `permission_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive','deleted') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active'
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fx_permissions`
--

INSERT INTO `fx_permissions` (`permission_id`, `name`, `description`, `status`) VALUES
(1, 'view_all_invoices', 'Allow user access to view all invoices', 'active'),
(2, 'edit_all_invoices', 'Allow user access to edit all invoices', 'active'),
(3, 'add_invoices', 'Allow user access to add invoices', 'active'),
(4, 'delete_invoices', 'Allow user access to delete invoice', 'active'),
(5, 'pay_invoice_offline', 'Allow user access to make offline Invoice Payments', 'active'),
(6, 'view_payments', 'Allow user access to view own payments', 'active'),
(7, 'email_invoices', 'Allow user access to email invoices', 'active'),
(8, 'send_email_reminders', 'Allow user access to send invoice reminders', 'active'),
(9, 'add_estimates', 'Allow user access to add estimates', 'active'),
(10, 'edit_estimates', 'Allow user access to edit all estimates', 'active'),
(11, 'view_all_estimates', 'Allow user access to view all estimates', 'active'),
(12, 'delete_estimates', 'Allow user access to delete estimates', 'active'),
(17, 'view_all_projects', 'Allow user access to view all projects', 'active'),
(18, 'view_project_cost', 'Allow user access to view project cost', 'active'),
(19, 'add_projects', 'Allow user access to add projects', 'active'),
(20, 'edit_all_projects', 'Allow user access to edit projects', 'active'),
(21, 'view_all_projects', 'Allow user access to view all projects', 'active'),
(22, 'delete_projects', 'Allow user access to delete projects', 'active'),
(23, 'edit_settings', 'Allow user access to edit all settings', 'active'),
(25, 'view_project_clients', 'Allow staff to view project''s clients', 'active'),
(26, 'view_project_notes', 'Allow staff to view project notes', 'active'),
(27, 'view_all_expenses', 'Allow staff to view all expenses', 'active'),
(28, 'edit_expenses', 'Allow staff to edit expenses', 'active'),
(29, 'delete_expenses', 'Allow staff to delete expenses', 'active'),
(30, 'add_expenses', 'Allow staff to add expenses', 'active'),
(31, 'view_project_expenses', 'Allow staff to view project expenses', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `fx_priorities`
--

CREATE TABLE IF NOT EXISTS `fx_priorities` (
  `priority` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fx_priorities`
--

INSERT INTO `fx_priorities` (`priority`) VALUES
('Low'),
('Medium'),
('High');

-- --------------------------------------------------------

--
-- Table structure for table `fx_projects`
--

CREATE TABLE IF NOT EXISTS `fx_projects` (
  `project_id` int(11) NOT NULL,
  `project_code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'Project Title',
  `description` longtext COLLATE utf8_unicode_ci,
  `client` int(11) NOT NULL,
  `currency` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_date` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `due_date` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fixed_rate` enum('Yes','No') COLLATE utf8_unicode_ci DEFAULT 'No',
  `hourly_rate` decimal(10,2) DEFAULT '0.00',
  `fixed_price` decimal(10,2) DEFAULT '0.00',
  `progress` int(11) DEFAULT '0',
  `notes` longtext COLLATE utf8_unicode_ci,
  `assign_to` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('On Hold','Active','Done') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Active',
  `timer` enum('On','Off') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Off',
  `timer_started_by` int(11) DEFAULT NULL,
  `timer_start` int(11) DEFAULT NULL,
  `time_logged` int(11) DEFAULT NULL,
  `proj_deleted` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `auto_progress` enum('TRUE','FALSE') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'FALSE',
  `estimate_hours` decimal(10,2) NOT NULL DEFAULT '0.00',
  `settings` text COLLATE utf8_unicode_ci,
  `language` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `archived` int(11) DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `alert_overdue` int(11) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fx_projects`
--

INSERT INTO `fx_projects` (`project_id`, `project_code`, `project_title`, `description`, `client`, `currency`, `start_date`, `due_date`, `fixed_rate`, `hourly_rate`, `fixed_price`, `progress`, `notes`, `assign_to`, `status`, `timer`, `timer_started_by`, `timer_start`, `time_logged`, `proj_deleted`, `auto_progress`, `estimate_hours`, `settings`, `language`, `archived`, `date_created`, `alert_overdue`) VALUES
(2, 'PRO67497', 'Test Ebusiness Create Project', '<p>Test Ebusiness Project</p>', 1, 'USD', '2016-02-22', '2018-06-01', 'Yes', '0.00', '60000000.00', 0, NULL, 'a:7:{i:0;s:1:"1";i:1;s:1:"5";i:2;s:1:"8";i:3;s:1:"9";i:4;s:2:"10";i:5;s:2:"11";i:6;s:2:"13";}', 'Active', 'Off', NULL, NULL, NULL, 'No', 'FALSE', '400000.00', '{"show_milestones":"on","show_project_tasks":"on","show_project_files":"on","show_project_bugs":"on","show_project_calendar":"on","show_project_comments":"on","show_project_gantt":"on","show_project_hours":"on","client_add_tasks":"on","project_id":2}', 'english', 0, '2016-02-22 11:27:49', 0),
(3, 'PRO25691', 'Test Project', '<p>Testing aja ya...<span >Testing aja ya...</span><span >Testing aja ya...</span><span >Testing aja ya...</span><span >Testing aja ya...</span><span >Testing aja ya...</span><span >Testing aja ya...</span><span >Testing aja ya...</span><span >Testing aja ya...</span><span >Testing aja ya...</span><span >Testing aja ya...</span></p>', 2, 'USD', '2016-02-22', '2018-06-01', 'Yes', '0.00', '5000.00', 0, NULL, 'b:0;', 'Active', 'Off', NULL, NULL, NULL, 'No', 'FALSE', '4000.00', '{"show_milestones":"on","show_project_tasks":"on","show_project_files":"on","show_project_bugs":"on","show_project_calendar":"on","show_project_comments":"on","show_project_gantt":"on","show_project_hours":"on","client_add_tasks":"on","project_id":3}', 'english', 0, '2016-02-22 11:29:21', 0),
(4, 'PRO81899', 'test', '<p>test</p>', 2, 'USD', '2016-02-22', '2016-02-22', 'Yes', '0.00', '3000.00', 0, NULL, 'b:0;', 'Active', 'Off', NULL, NULL, NULL, 'No', 'FALSE', '3000.00', '{"show_milestones":"on","show_project_tasks":"on","show_project_files":"on","show_project_bugs":"on","show_project_calendar":"on","show_project_comments":"on","show_project_gantt":"on","show_project_hours":"on","client_add_tasks":"on","project_id":4}', 'english', 0, '2016-02-22 11:31:00', 0),
(5, 'PRO63192', 'TEST', '<p>TEST</p>', 2, 'USD', '2016-02-24', '2016-02-26', 'Yes', '0.00', '300.00', 0, NULL, 'b:0;', 'Active', 'Off', NULL, NULL, NULL, 'No', 'FALSE', '0.00', '{"show_milestones":"on","show_project_tasks":"on","show_project_files":"on","show_project_bugs":"on","show_project_calendar":"on","show_project_comments":"on","show_project_gantt":"on","show_project_hours":"on","client_add_tasks":"on","project_id":5}', 'english', 0, '2016-02-24 11:46:31', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fx_project_categories`
--

CREATE TABLE IF NOT EXISTS `fx_project_categories` (
  `pc_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `description` varchar(8000) NOT NULL,
  `price` decimal(18,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fx_project_categories`
--

INSERT INTO `fx_project_categories` (`pc_id`, `project_id`, `categories_id`, `description`, `price`) VALUES
(2, 4, 8, 'Testing', '50.00'),
(3, 2, 6, 'Test', '50.00');

-- --------------------------------------------------------

--
-- Table structure for table `fx_project_settings`
--

CREATE TABLE IF NOT EXISTS `fx_project_settings` (
  `id` int(11) NOT NULL,
  `setting` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fx_project_settings`
--

INSERT INTO `fx_project_settings` (`id`, `setting`, `description`) VALUES
(1, 'show_team_members', 'Allow client to view team members'),
(2, 'show_milestones', 'Allow client to view project milestones'),
(5, 'show_project_tasks', 'Allow client to view project tasks'),
(6, 'show_project_files', 'Allow client to view project files'),
(7, 'show_timesheets', 'Allow clients to view project timesheets'),
(8, 'show_project_bugs', 'Allow client to view project bugs'),
(9, 'show_project_history', 'Allow client to view project history'),
(10, 'show_project_calendar', 'Allow clients to view project calendars'),
(11, 'show_project_comments', 'Allow clients to view project comments'),
(12, 'show_project_links', 'Allow client to view project links'),
(59, 'client_add_tasks', 'Allow client to to add task'),
(60, 'show_project_gantt', 'Allow client to view Gantt chart');

-- --------------------------------------------------------

--
-- Table structure for table `fx_project_timer`
--

CREATE TABLE IF NOT EXISTS `fx_project_timer` (
  `timer_id` int(11) NOT NULL,
  `project` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `start_time` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `end_time` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `date_timed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `billable` tinyint(4) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fx_roles`
--

CREATE TABLE IF NOT EXISTS `fx_roles` (
  `r_id` int(11) NOT NULL,
  `role` varchar(64) NOT NULL,
  `default` int(11) NOT NULL,
  `permissions` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fx_roles`
--

INSERT INTO `fx_roles` (`r_id`, `role`, `default`, `permissions`) VALUES
(1, 'admin', 1, '{"settings":"permissions","role":"admin","view_all_invoices":"on","edit_invoices":"on","pay_invoice_offline":"on","view_all_payments":"on","email_invoices":"on","send_email_reminders":"on"}'),
(2, 'client', 2, '{"settings":"permissions","role":"client"}'),
(3, 'e_employee', 3, '{"settings":"permissions","role":"staff","view_all_invoices":"on","edit_invoices":"on","add_invoices":"on","pay_invoice_offline":"on","send_email_reminders":"on"}'),
(6, 'e_finance', 0, ''),
(7, 'e_business', 0, ''),
(8, 'e_hr', 0, ''),
(9, 'e_project_management', 0, ''),
(10, 'eMTS', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `fx_saved_tasks`
--

CREATE TABLE IF NOT EXISTS `fx_saved_tasks` (
  `template_id` int(11) NOT NULL,
  `task_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT 'Task Name',
  `task_desc` text COLLATE utf8_unicode_ci,
  `visible` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Yes',
  `estimate_hours` decimal(10,2) DEFAULT '0.00',
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `saved_by` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fx_status`
--

CREATE TABLE IF NOT EXISTS `fx_status` (
  `id` int(11) NOT NULL,
  `status` varchar(200) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fx_status`
--

INSERT INTO `fx_status` (`id`, `status`) VALUES
(1, 'answered'),
(2, 'closed'),
(3, 'open'),
(5, 'in progress');

-- --------------------------------------------------------

--
-- Table structure for table `fx_tasks`
--

CREATE TABLE IF NOT EXISTS `fx_tasks` (
  `t_id` int(11) NOT NULL,
  `task_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'Task Name',
  `project` int(11) NOT NULL,
  `milestone` int(11) DEFAULT NULL,
  `assigned_to` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `visible` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Yes',
  `task_progress` int(11) DEFAULT '0',
  `timer_status` enum('On','Off') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Off',
  `timer_started_by` int(11) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL,
  `estimated_hours` decimal(10,2) DEFAULT NULL,
  `logged_time` int(11) NOT NULL DEFAULT '0',
  `auto_progress` enum('TRUE','FALSE') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'FALSE',
  `due_date` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fx_tasks_timer`
--

CREATE TABLE IF NOT EXISTS `fx_tasks_timer` (
  `timer_id` int(11) NOT NULL,
  `task` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `start_time` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `end_time` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `user` int(11) DEFAULT NULL,
  `date_timed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `billable` tinyint(4) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fx_task_files`
--

CREATE TABLE IF NOT EXISTS `fx_task_files` (
  `file_id` int(11) NOT NULL,
  `task` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_name` mediumtext COLLATE utf8_unicode_ci,
  `path` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `file_ext` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `is_image` int(2) DEFAULT NULL,
  `image_width` int(10) DEFAULT NULL,
  `image_height` int(10) DEFAULT NULL,
  `original_name` mediumtext COLLATE utf8_unicode_ci,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `file_status` enum('unconfirmed','confirmed','in_progress','done','verified') COLLATE utf8_unicode_ci DEFAULT 'unconfirmed',
  `uploaded_by` int(11) DEFAULT NULL,
  `date_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fx_tax_rates`
--

CREATE TABLE IF NOT EXISTS `fx_tax_rates` (
  `tax_rate_id` int(11) NOT NULL,
  `tax_rate_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `tax_rate_percent` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fx_tax_rates`
--

INSERT INTO `fx_tax_rates` (`tax_rate_id`, `tax_rate_name`, `tax_rate_percent`) VALUES
(1, 'VAT', '13.00');

-- --------------------------------------------------------

--
-- Table structure for table `fx_ticketreplies`
--

CREATE TABLE IF NOT EXISTS `fx_ticketreplies` (
  `id` int(10) NOT NULL,
  `ticketid` int(10) DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `replier` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `replierid` int(10) DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fx_tickets`
--

CREATE TABLE IF NOT EXISTS `fx_tickets` (
  `id` int(10) NOT NULL,
  `ticket_code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `status` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `reporter` int(10) DEFAULT '0',
  `priority` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `additional` text COLLATE utf8_unicode_ci,
  `attachment` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `archived_t` int(2) DEFAULT '0',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fx_un_sessions`
--

CREATE TABLE IF NOT EXISTS `fx_un_sessions` (
  `session_id` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fx_un_sessions`
--

INSERT INTO `fx_un_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('ecaf9f6c1bd4a1bf9f375bfc8a1bf9ba', '::1', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.109 Safari/537.36 OPR/35.0.2066.68', 1457150871, 'a:7:{s:9:"user_data";s:0:"";s:7:"user_id";s:1:"9";s:8:"username";s:9:"ebusiness";s:7:"role_id";s:1:"7";s:6:"status";s:1:"1";s:14:"requested_page";s:61:"http://localhost/pm/freelanceroffice/companies/view/details/2";s:13:"previous_page";s:61:"http://localhost/pm/freelanceroffice/companies/view/details/2";}');

-- --------------------------------------------------------

--
-- Table structure for table `fx_updates`
--

CREATE TABLE IF NOT EXISTS `fx_updates` (
  `build` int(11) NOT NULL DEFAULT '0',
  `code` varchar(50) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `version` varchar(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `filename` varchar(255) DEFAULT NULL,
  `importance` enum('low','medium','high') DEFAULT 'low',
  `dependencies` varchar(255) DEFAULT NULL,
  `installed` int(11) DEFAULT '0',
  `sql` text,
  `files` text,
  `depends` varchar(255) DEFAULT NULL,
  `includes` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fx_users`
--

CREATE TABLE IF NOT EXISTS `fx_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '2',
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `new_password_key` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `new_email_key` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_ip` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cv` varchar(8000) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fx_users`
--

INSERT INTO `fx_users` (`id`, `username`, `password`, `email`, `role_id`, `activated`, `banned`, `ban_reason`, `new_password_key`, `new_password_requested`, `new_email`, `new_email_key`, `last_ip`, `last_login`, `cv`, `created`, `modified`) VALUES
(1, 'admin', '$P$Bqk4m0La.tOtTNceyktCW6Q9wz2G92.', 'ultrasoftwaresolution@gmail.com', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, '::1', '2016-03-02 02:29:37', '', '2016-02-18 13:13:33', '2016-03-02 02:29:37'),
(5, 'epm', '$P$BL28Ze4iCD1GUDS4rX1yi3eZxt3o1O/', 'epm@gmail.com', 3, 1, 0, NULL, NULL, NULL, NULL, NULL, '::1', '2016-03-02 02:41:51', '', '2016-02-22 04:27:06', '2016-03-02 02:41:51'),
(6, 'client', '$P$BbgCdTpw65NzhFx0IEPRRYiOdcFcD6/', 'client@gmail.com', 2, 1, 0, NULL, NULL, NULL, NULL, NULL, '::1', '2016-02-22 10:55:11', '', '2016-02-22 04:33:14', '2016-02-22 10:55:11'),
(8, 'ehr', '$P$Bn77pIdq5m0hGw3k6tS98n7AaXSNtr/', 'ehr@solution.co.id', 8, 1, 0, NULL, NULL, NULL, NULL, NULL, '::1', '2016-03-02 02:41:22', 'USER-EHR-CV.pdf', '2016-02-22 06:50:09', '2016-03-02 02:41:22'),
(9, 'ebusiness', '$P$B.kQ.Q0C12UxD7enzevyP53pT1Q7FZ0', 'ebusiness@gmail.com', 7, 1, 0, NULL, NULL, NULL, NULL, NULL, '::1', '2016-03-05 03:21:21', '', '2016-02-22 08:21:32', '2016-03-05 03:21:21'),
(10, 'efinance', '$P$BktMyxAyp3aM6/ILx43dOTtIC6x2b50', 'efinance@gmail.com', 6, 1, 0, NULL, NULL, NULL, NULL, NULL, '::1', '2016-03-01 02:03:39', '', '2016-02-22 08:22:49', '2016-03-01 02:03:39'),
(11, 'projectmanager', '$P$B132zTByvqTW6wsDpDYBAl7nhQXL6f0', 'projectmanager@gmail.com', 9, 1, 0, NULL, NULL, NULL, NULL, NULL, '::1', '2016-03-02 02:21:14', 'USER-PROJECTMANAGER-CV.pdf', '2016-02-23 02:47:59', '2016-03-02 02:21:14'),
(13, 'test', '$P$BV3evbWlo2rVBXCa77cdV.0Dykw.9W/', 'test@test.com', 1, 1, 0, NULL, NULL, NULL, NULL, NULL, '::1', '0000-00-00 00:00:00', '', '2016-03-01 02:42:23', '2016-03-01 02:42:23');

-- --------------------------------------------------------

--
-- Table structure for table `fx_user_autologin`
--

CREATE TABLE IF NOT EXISTS `fx_user_autologin` (
  `key_id` char(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `expires` timestamp NULL DEFAULT NULL,
  `remote` int(2) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fx_account_details`
--
ALTER TABLE `fx_account_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fx_activities`
--
ALTER TABLE `fx_activities`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `fx_api_access`
--
ALTER TABLE `fx_api_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fx_api_keys`
--
ALTER TABLE `fx_api_keys`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `user` (`user`);

--
-- Indexes for table `fx_api_limits`
--
ALTER TABLE `fx_api_limits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fx_api_logs`
--
ALTER TABLE `fx_api_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fx_assign_projects`
--
ALTER TABLE `fx_assign_projects`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `fx_assign_tasks`
--
ALTER TABLE `fx_assign_tasks`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `fx_bugs`
--
ALTER TABLE `fx_bugs`
  ADD PRIMARY KEY (`bug_id`), ADD UNIQUE KEY `issue_ref` (`issue_ref`);

--
-- Indexes for table `fx_bug_comments`
--
ALTER TABLE `fx_bug_comments`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `fx_bug_files`
--
ALTER TABLE `fx_bug_files`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `fx_captcha`
--
ALTER TABLE `fx_captcha`
  ADD PRIMARY KEY (`captcha_id`), ADD KEY `word` (`word`);

--
-- Indexes for table `fx_categories`
--
ALTER TABLE `fx_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fx_comments`
--
ALTER TABLE `fx_comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `fx_comment_replies`
--
ALTER TABLE `fx_comment_replies`
  ADD PRIMARY KEY (`reply_id`);

--
-- Indexes for table `fx_companies`
--
ALTER TABLE `fx_companies`
  ADD PRIMARY KEY (`co_id`);

--
-- Indexes for table `fx_config`
--
ALTER TABLE `fx_config`
  ADD PRIMARY KEY (`config_key`);

--
-- Indexes for table `fx_countries`
--
ALTER TABLE `fx_countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fx_currencies`
--
ALTER TABLE `fx_currencies`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `fx_departments`
--
ALTER TABLE `fx_departments`
  ADD PRIMARY KEY (`deptid`);

--
-- Indexes for table `fx_email_templates`
--
ALTER TABLE `fx_email_templates`
  ADD PRIMARY KEY (`template_id`);

--
-- Indexes for table `fx_estimates`
--
ALTER TABLE `fx_estimates`
  ADD PRIMARY KEY (`est_id`), ADD UNIQUE KEY `reference_no` (`reference_no`);

--
-- Indexes for table `fx_estimate_items`
--
ALTER TABLE `fx_estimate_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `fx_expenses`
--
ALTER TABLE `fx_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fx_fields`
--
ALTER TABLE `fx_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fx_files`
--
ALTER TABLE `fx_files`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `fx_invoices`
--
ALTER TABLE `fx_invoices`
  ADD PRIMARY KEY (`inv_id`), ADD UNIQUE KEY `reference_no` (`reference_no`);

--
-- Indexes for table `fx_items`
--
ALTER TABLE `fx_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `fx_items_saved`
--
ALTER TABLE `fx_items_saved`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `fx_languages`
--
ALTER TABLE `fx_languages`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `fx_links`
--
ALTER TABLE `fx_links`
  ADD PRIMARY KEY (`link_id`);

--
-- Indexes for table `fx_locales`
--
ALTER TABLE `fx_locales`
  ADD PRIMARY KEY (`locale`);

--
-- Indexes for table `fx_login_attempts`
--
ALTER TABLE `fx_login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fx_messages`
--
ALTER TABLE `fx_messages`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `fx_milestones`
--
ALTER TABLE `fx_milestones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fx_outgoing_emails`
--
ALTER TABLE `fx_outgoing_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fx_payments`
--
ALTER TABLE `fx_payments`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `fx_payment_methods`
--
ALTER TABLE `fx_payment_methods`
  ADD PRIMARY KEY (`method_id`);

--
-- Indexes for table `fx_permissions`
--
ALTER TABLE `fx_permissions`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `fx_projects`
--
ALTER TABLE `fx_projects`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `fx_project_categories`
--
ALTER TABLE `fx_project_categories`
  ADD PRIMARY KEY (`pc_id`);

--
-- Indexes for table `fx_project_settings`
--
ALTER TABLE `fx_project_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fx_project_timer`
--
ALTER TABLE `fx_project_timer`
  ADD PRIMARY KEY (`timer_id`);

--
-- Indexes for table `fx_roles`
--
ALTER TABLE `fx_roles`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `fx_saved_tasks`
--
ALTER TABLE `fx_saved_tasks`
  ADD PRIMARY KEY (`template_id`);

--
-- Indexes for table `fx_status`
--
ALTER TABLE `fx_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fx_tasks`
--
ALTER TABLE `fx_tasks`
  ADD PRIMARY KEY (`t_id`);

--
-- Indexes for table `fx_tasks_timer`
--
ALTER TABLE `fx_tasks_timer`
  ADD PRIMARY KEY (`timer_id`);

--
-- Indexes for table `fx_task_files`
--
ALTER TABLE `fx_task_files`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `fx_tax_rates`
--
ALTER TABLE `fx_tax_rates`
  ADD KEY `Index 1` (`tax_rate_id`);

--
-- Indexes for table `fx_ticketreplies`
--
ALTER TABLE `fx_ticketreplies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fx_tickets`
--
ALTER TABLE `fx_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fx_un_sessions`
--
ALTER TABLE `fx_un_sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `fx_updates`
--
ALTER TABLE `fx_updates`
  ADD PRIMARY KEY (`build`);

--
-- Indexes for table `fx_users`
--
ALTER TABLE `fx_users`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `fx_user_autologin`
--
ALTER TABLE `fx_user_autologin`
  ADD PRIMARY KEY (`key_id`,`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fx_account_details`
--
ALTER TABLE `fx_account_details`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `fx_activities`
--
ALTER TABLE `fx_activities`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `fx_api_access`
--
ALTER TABLE `fx_api_access`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_api_keys`
--
ALTER TABLE `fx_api_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_api_limits`
--
ALTER TABLE `fx_api_limits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_api_logs`
--
ALTER TABLE `fx_api_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_assign_projects`
--
ALTER TABLE `fx_assign_projects`
  MODIFY `a_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `fx_assign_tasks`
--
ALTER TABLE `fx_assign_tasks`
  MODIFY `a_id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_bugs`
--
ALTER TABLE `fx_bugs`
  MODIFY `bug_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_bug_comments`
--
ALTER TABLE `fx_bug_comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_bug_files`
--
ALTER TABLE `fx_bug_files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_captcha`
--
ALTER TABLE `fx_captcha`
  MODIFY `captcha_id` bigint(13) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fx_categories`
--
ALTER TABLE `fx_categories`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `fx_comments`
--
ALTER TABLE `fx_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_comment_replies`
--
ALTER TABLE `fx_comment_replies`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_companies`
--
ALTER TABLE `fx_companies`
  MODIFY `co_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fx_countries`
--
ALTER TABLE `fx_countries`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=242;
--
-- AUTO_INCREMENT for table `fx_departments`
--
ALTER TABLE `fx_departments`
  MODIFY `deptid` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fx_email_templates`
--
ALTER TABLE `fx_email_templates`
  MODIFY `template_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `fx_estimates`
--
ALTER TABLE `fx_estimates`
  MODIFY `est_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fx_estimate_items`
--
ALTER TABLE `fx_estimate_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_expenses`
--
ALTER TABLE `fx_expenses`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fx_fields`
--
ALTER TABLE `fx_fields`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_files`
--
ALTER TABLE `fx_files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `fx_invoices`
--
ALTER TABLE `fx_invoices`
  MODIFY `inv_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `fx_items`
--
ALTER TABLE `fx_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_items_saved`
--
ALTER TABLE `fx_items_saved`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_links`
--
ALTER TABLE `fx_links`
  MODIFY `link_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_login_attempts`
--
ALTER TABLE `fx_login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `fx_messages`
--
ALTER TABLE `fx_messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_milestones`
--
ALTER TABLE `fx_milestones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_outgoing_emails`
--
ALTER TABLE `fx_outgoing_emails`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_payments`
--
ALTER TABLE `fx_payments`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_payment_methods`
--
ALTER TABLE `fx_payment_methods`
  MODIFY `method_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `fx_permissions`
--
ALTER TABLE `fx_permissions`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `fx_projects`
--
ALTER TABLE `fx_projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `fx_project_categories`
--
ALTER TABLE `fx_project_categories`
  MODIFY `pc_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `fx_project_settings`
--
ALTER TABLE `fx_project_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `fx_project_timer`
--
ALTER TABLE `fx_project_timer`
  MODIFY `timer_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_roles`
--
ALTER TABLE `fx_roles`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `fx_saved_tasks`
--
ALTER TABLE `fx_saved_tasks`
  MODIFY `template_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_status`
--
ALTER TABLE `fx_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `fx_tasks`
--
ALTER TABLE `fx_tasks`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_tasks_timer`
--
ALTER TABLE `fx_tasks_timer`
  MODIFY `timer_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_task_files`
--
ALTER TABLE `fx_task_files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_tax_rates`
--
ALTER TABLE `fx_tax_rates`
  MODIFY `tax_rate_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fx_ticketreplies`
--
ALTER TABLE `fx_ticketreplies`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_tickets`
--
ALTER TABLE `fx_tickets`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fx_users`
--
ALTER TABLE `fx_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
