CREATE TABLE `sms_record` ( `id` INT NOT NULL , `int_id` INT NOT NULL , 
`branch_id` INT NOT NULL , 
`mobile_no` VARCHAR(40) NOT NULL , `transaction_date` DATE NOT NULL , `message` TEXT NOT NULL , 
`status` VARCHAR(20) NOT NULL , `error_message` VARCHAR(40) NOT NULL , 
`error_code` INT NOT NULL , 
`ticket_id` VARCHAR(100) NOT NULL ) ENGINE = InnoDB;

ALTER TABLE `sms_record`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `sms_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;