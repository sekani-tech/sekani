ALTER TABLE `assets` ADD `expense_gl` VARCHAR(30) NOT NULL AFTER `gl_code`; 
-- // 28/06/2021
INSERT INTO `administrative_control` (`id`, `int_id`, `title`, `start_date`, `end_date`, `grace_period`, `function_status`, `description`) VALUES (NULL, '9', 'SEKANI SUBSCRIPTION', '2020-12-01', '2021-04-26', '0', '1', 'Subscribe to use our services'), 
(NULL, '9', 'BACK DATING', '2020-12-01', '2021-01-29', '2', '1', 'You are naturally not allowed to back date transactions pay to unlock this feature'), 
(NULL, '9', 'MIGRATION', '2021-01-29', '2021-02-26', '0', '0', 'Migrate your organization existing history onto the system.');