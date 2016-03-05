SET @s = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE table_name = 'fx_payments'
        AND table_schema = DATABASE()
        AND column_name = 'attached_file'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE fx_payments ADD `attached_file` TEXT NULL  AFTER `notes`"
));

PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @s = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE table_name = 'fx_companies'
        AND table_schema = DATABASE()
        AND column_name = 'state'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE fx_companies ADD `state` VARCHAR(255)  NULL  DEFAULT NULL  AFTER `city`"
));

PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;


SET @s = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE table_name = 'fx_companies'
        AND table_schema = DATABASE()
        AND column_name = 'individual'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE fx_companies ADD `individual` TINYINT  NULL  DEFAULT '0'  AFTER `company_ref`"
));

PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;


SET @s = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE table_name = 'fx_user_autologin'
        AND table_schema = DATABASE()
        AND column_name = 'expires'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE fx_user_autologin ADD `expires` TIMESTAMP  NULL  DEFAULT NULL  AFTER `last_login`"
));

PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @s = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE table_name = 'fx_user_autologin'
        AND table_schema = DATABASE()
        AND column_name = 'remote'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE fx_user_autologin ADD `remote` INT(2)  NULL  DEFAULT '0'  AFTER `expires`"
));

PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;



SET @s = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE table_name = 'fx_tasks_timer'
        AND table_schema = DATABASE()
        AND column_name = 'billable'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE fx_tasks_timer ADD `billable` TINYINT  NULL  DEFAULT '1'  AFTER `date_timed`"
));

PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;


SET @s = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE table_name = 'fx_project_timer'
        AND table_schema = DATABASE()
        AND column_name = 'billable'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE fx_project_timer ADD `billable` TINYINT  NULL  DEFAULT '1'  AFTER `date_timed`"
));

PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;


SET @s = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE table_name = 'fx_projects'
        AND table_schema = DATABASE()
        AND column_name = 'alert_overdue'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE fx_projects ADD `alert_overdue` INT  NULL  DEFAULT '0'  AFTER `date_created`"
));

PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;


SET @s = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE table_name = 'fx_invoices'
        AND table_schema = DATABASE()
        AND column_name = 'alert_overdue'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE fx_invoices ADD `alert_overdue` INT  NULL  DEFAULT '0'  AFTER `viewed`"
));

PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;


SET @s = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE table_name = 'fx_project_timer'
        AND table_schema = DATABASE()
        AND column_name = 'description'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE fx_project_timer ADD `description` TEXT  NULL  AFTER `end_time`"
));

PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;


SET @s = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE table_name = 'fx_tasks_timer'
        AND table_schema = DATABASE()
        AND column_name = 'description'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE fx_tasks_timer ADD `description` TEXT  NULL  AFTER `end_time`"
));

PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;


SET @s = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE table_name = 'fx_account_details'
        AND table_schema = DATABASE()
        AND column_name = 'hourly_rate'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE fx_account_details ADD `hourly_rate` DECIMAL(10,2)  NULL  DEFAULT '0.00'  AFTER `allowed_modules`"
));

PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

INSERT IGNORE `fx_config` (`config_key`, `value`) VALUES
('swap_to_from', 'TRUE'),
('remote_login_expires', '72'),
('cron_last_run', ''),
('xrates_check', ''),
('theme_color', 'success'),
('login_title', 'Project Manager'),
('top_bar_color', 'dark'),
('bitcoin_address', ''),
('auto_backup_db', 'TRUE'),
('notify_payment_received', 'TRUE'),
('hide_sidebar', 'FALSE'),
('two_checkout_live', 'FALSE'),
('slack_webhook',''),
('slack_channel',''),
('slack_notification','FALSE'),
('slack_username',''),
('beta_updates','FALSE'),
('mail_encryption', 'tls'),
('mail_imap_host', 'mail.domain.com'),
('mail_password', ''),
('mail_username', ''),
('auto_close_ticket', '30');



INSERT INTO `fx_email_templates` (`template_id`, `email_group`, `subject`, `template_body`) VALUES (NULL, 'email_signature', NULL, '');

INSERT INTO `fx_project_settings` (`id`, `setting`, `description`) VALUES (NULL, 'show_project_gantt', 'Allow client to view Gantt chart');

INSERT INTO `fx_project_settings` (`id`, `setting`, `description`) VALUES (NULL, 'show_project_hours', 'Allow client to view project hours');



ALTER TABLE `fx_account_details` CHANGE `department` `department` TEXT  NULL;



INSERT INTO `fx_email_templates` (`template_id`, `email_group`, `subject`, `template_body`) VALUES (NULL, 'auto_close_ticket', 'Ticket Auto Closed', 'Ticket {TICKET_CODE} has been closed due to inactivity. \n\nLast Reply: {LAST_REPLY_DATE}\n');



ALTER TABLE `fx_account_details` CHANGE `department` `department` VARCHAR(200)  NULL  DEFAULT 'NULL';

INSERT INTO `fx_permissions` (`permission_id`, `name`, `description`, `status`) VALUES (NULL, 'view_all_expenses', 'Allow staff to view all expenses', 'active');

INSERT INTO `fx_permissions` (`permission_id`, `name`, `description`, `status`)
VALUES ('', 'edit_expenses', 'Allow staff to edit expenses', 'active');

INSERT INTO `fx_permissions` (`permission_id`, `name`, `description`, `status`)
VALUES ('', 'delete_expenses', 'Allow staff to delete expenses', 'active');

INSERT INTO `fx_permissions` (`permission_id`, `name`, `description`, `status`)
VALUES ('', 'add_expenses', 'Allow staff to add expenses', 'active');

INSERT INTO `fx_permissions` (`permission_id`, `name`, `description`, `status`)
VALUES ('', 'view_project_expenses', 'Allow staff to view project expenses', 'active');

ALTER TABLE `fx_messages` CHANGE `message` `message` LONGTEXT  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NULL;

INSERT INTO `fx_payment_methods` (`method_id`, `method_name`) VALUES (NULL, 'Stripe');

INSERT INTO `fx_payment_methods` (`method_id`, `method_name`) VALUES (NULL, 'Paypal');

INSERT INTO `fx_payment_methods` (`method_id`, `method_name`) VALUES (NULL, '2Checkout');



CREATE TABLE IF NOT EXISTS `fx_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) DEFAULT NULL,
  `module` varchar(32) DEFAULT 'expenses',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

INSERT INTO `fx_categories` (`id`, `cat_name`, `module`)
VALUES ('', 'Accomodation', 'expenses');


INSERT INTO `fx_project_settings` (`id`, `setting`, `description`)
VALUES ('', 'show_project_cost', 'Allow client to view project cost');


CREATE TABLE IF NOT EXISTS `fx_expenses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
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
  `saved` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
