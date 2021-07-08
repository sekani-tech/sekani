CREATE TABLE `prepayment_account` ( `id` INT NOT NULL AUTO_INCREMENT , `int_id` INT NOT NULL , 
`branch_id` INT NOT NULL , `year` YEAR NOT NULL , `amount` DECIMAL(19,2) NOT NULL , `gl_code` VARCHAR(20) NOT NULL , 
`expense_gl_code` VARCHAR(20) NOT NULL , `prepayment_made` DECIMAL(19,2) NOT NULL , `start_date` DATE NOT NULL , 
`end_date` DATE NOT NULL , `created_by` INT NOT NULL , `created_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `prepayment_schedule` ( `id` INT NOT NULL AUTO_INCREMENT , `int_id` INT NOT NULL , 
`branch_id` INT NOT NULL , `prepayment_account_id` INT NOT NULL , `expense_date` DATE NOT NULL , 
`expense_amount` DECIMAL(19,2) NOT NULL , 
`expended` INT NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `template_control` (
   `id` INT NOT NULL AUTO_INCREMENT , `title` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
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


ALTER TABLE `administrative_control`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `administrative_control`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;



CREATE TABLE `administrative_control_transaction` ( `id` INT NOT NULL , `int_id` INT NOT NULL , 
`admin_control_id` INT NOT NULL , 
`title` VARCHAR(40) NOT NULL , `transaction_date` DATE NOT NULL , `transaction_type` VARCHAR(10) NOT NULL , 
`service_start` DATE NOT NULL , `service_end` DATE NOT NULL , 
`expense_gl` VARCHAR(20) NOT NULL , 
`transaction_id` VARCHAR(100) NOT NULL ) ENGINE = InnoDB;