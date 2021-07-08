CREATE TABLE `saving_balances_migration` (
  `id` int(11) NOT NULL,
  `int_id` varchar(200) NOT NULL,
  `Branch_Name` varchar(200) NOT NULL,
  `Group_Name` varchar(200) NOT NULL,
  `Group_Id` varchar(200) NOT NULL,
  `Client_Name` varchar(200) NOT NULL,
  `Client_Id` varchar(200) NOT NULL,
  `Product_Id` varchar(200) NOT NULL,
  `Loan_Officer` varchar(200) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Submitted_On_Date` date NOT NULL,
  `Approved_On_Date` date NOT NULL,
  `Activated_On_Date` date NOT NULL,
  `Account_No` varchar(200) NOT NULL,
  `Status` varchar(200) NOT NULL,
  `Total_Deposits_Derived` varchar(200) NOT NULL,
  `Total_Withdrawals_Derived` varchar(200) NOT NULL,
  `Total_Fees_Charge_Derived` varchar(200) NOT NULL,
  `Account_Balance_Derived` varchar(200) NOT NULL,
  `Last_Activity_Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



--
-- Indexes for dumped tables
--

--
-- Indexes for table `saving_balances_migration`
--
ALTER TABLE `saving_balances_migration` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `saving_balances_migration` ADD PRIMARY KEY(`id`);
ALTER TABLE `saving_balances_migration` DROP `Name`;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `saving_balances_migration`
--
ALTER TABLE `saving_balances_migration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;