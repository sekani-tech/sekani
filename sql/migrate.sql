CREATE TABLE group_details_migrate (
  id INT(11) NOT NULL AUTO_INCREMENT, int_id INT NOT NULL, Branch_Name VARCHAR(100), Group_Name VARCHAR(100), Group_Id VARCHAR(100), Client_Name VARCHAR(100),	Client_Id INT, 
  Date_Of_Birth DATE, Gender VARCHAR(10), Phone_Number VARCHAR(20), Staff_Name VARCHAR(20), Status VARCHAR(15), Activation_Date DATE, 
  Office_Id VARCHAR(20), Display_Name VARCHAR(20), Hierarchy INT, Activated_By_User VARCHAR(100),	Submitted_On_Date DATE, 
  Submitted_By_User VARCHAR(100), Closed_By_User VARCHAR(100), Account_No VARCHAR(100), Group_Details_Registration VARCHAR(100), 
  Group_Details_Meeting_Day VARCHAR(100), Group_Details_Meeting_Frequency INT, Group_Details_Meeting_Location VARCHAR(100), 
  Group_Details_Meeting_Time INT, Group_Details_Geographical_Region VARCHAR(100), Group_Details_Submitted_On_Date DATE, migration_status INT DEFAULT '0',
  PRIMARY KEY (id)
);

CREATE TABLE loan_balances_migrate (
  id INT(11) NOT NULL AUTO_INCREMENT, int_id INT NOT NULL, Branch_Name VARCHAR(100), Loan_Officer_Name VARCHAR(100),	Group_Name VARCHAR(100), 
  Group_Id VARCHAR(100), Client_Name VARCHAR(100), Client_Id VARCHAR(100), Gender VARCHAR(10), Arrears_Date DATE, Arrears_Days INT, 
  Arrears_Amount DECIMAL(19,2), Product_Group VARCHAR(100), Parent_Product_Group VARCHAR(100), Product_Name VARCHAR(100), Linked_Top_Up_Loan_Id VARCHAR(100), 
  Account_No VARCHAR(100), Loan_Officer_Id VARCHAR(100), Loan_Purpose VARCHAR(100), Loan_Status_Id VARCHAR(100), 
  Loan_Type VARCHAR(100), Principal_Amount DECIMAL(19,2),	Nominal_Interest_Rate_Per_Period INT, Annual_Nominal_Interest_Rate INT,	
  Interest_Method VARCHAR(100), Interest_Calculated_In_Period INT, Term_Frequency INT,	Repay_Every INT, 
  Repayment_Period_Frequency INT, Number_Of_Repayments INT, Grace_On_Principal_Periods INT, Submitted_On_Date DATE, Submitted_By_User VARCHAR(100), 
  Approved_On_Date DATE, Disbursed_On_Date DATE, Matured_On_Date DATE, Principal_Disbursed_Derived DECIMAL(19,2),	
  Principal_Repaid_Derived DECIMAL(19,2), Principal_Outstanding_Derived DECIMAL(19,2), 
  Total_Expected_Repayment DECIMAL(19,2), Derived_Total_Repayment DECIMAL(19,2), Derived_Total_Outstanding_Derived DECIMAL(19,2), 
  Loan_Product_Counter VARCHAR(100), Loan_Details_Loan_Sector VARCHAR(100), Loan_Details_Submitted_On_Date DATE,	
  Loan_Guarantors_Id VARCHAR(100),	Loan_Guarantors_Client_Reln VARCHAR(100), Loan_Guarantors_Type VARCHAR(100), 
  Loan_Guarantors_Client_Id VARCHAR(100), Loan_Guarantors_Firstname VARCHAR(100), Loan_Guarantors_Lastname VARCHAR(100), 
  Loan_Guarantors_Dob DATE, Loan_Guarantors_Address_Line_1 TEXT, Loan_Guarantors_City VARCHAR(100), Loan_Guarantors_Country VARCHAR(100), 
  Loan_Guarantors_House_Phone_Number VARCHAR(100), Loan_Guarantors_Submitted_By_User VARCHAR(100), 
  Loan_Guarantors_Submitted_On_Date DATE, Loan_Guarantors_Relationship_Wi18 VARCHAR(100),	Loan_Collateral_Id VARCHAR(100),	
  Loan_Collateral_Type VARCHAR(100), Loan_Collateral_Value DECIMAL(19,2), Loan_Collateral_Description TEXT, 
  Loan_Collateral_Submitted_By_User VARCHAR(100), Loan_Collateral_Submitted_On_Date DATE,	Loan_Collateral_Descrition_Of_Asset5 VARCHAR(100), Loan_Collateral_Approximate_Cos6 VARCHAR(100), migration_status INT DEFAULT '0',
  PRIMARY KEY (id)
);

CREATE TABLE loan_transactions_migrate (
  id INT(11) NOT NULL AUTO_INCREMENT, int_id INT NOT NULL, Branch_Name VARCHAR(100), Loan_Officer_Name VARCHAR(100), Group_Name VARCHAR(100), Group_Id VARCHAR(100), Client_Name VARCHAR(100), Client_Id VARCHAR(100), Date_Of_Birth VARCHAR(100), 
  Gender VARCHAR(10), Phone_Number VARCHAR(30), Staff_Name VARCHAR(100), Created_By VARCHAR(100), Interest_Accrued DECIMAL(19,2), 
  Transfer_Total_Repaid DECIMAL(19,2), Product_Short_Name VARCHAR(10), Product_Name VARCHAR(100), Product_Id VARCHAR(100), 
  Account_Number VARCHAR(100), Payment_Channel VARCHAR(100), Reference VARCHAR(100), Total_Repaid DECIMAL(19,2),
  Principal_Repaid DECIMAL(19,2), Interest_Repaid DECIMAL(19,2), Fees_Repaid DECIMAL(19,2), Penalties_Repaid DECIMAL(19,2), 
  Overpayment_Repaid DECIMAL(19,2), Total_Recovered DECIMAL(19,2), Product_Group VARCHAR(100),	
  Parent_Product_Group VARCHAR(100), Transaction_Id VARCHAR(100), Effective_Date DATE, Submitted_On_Date DATE, migration_status INT DEFAULT '0',
  PRIMARY KEY(id)
);


CREATE TABLE `client_details_migrate` (
  `id` int(11) NOT NULL,
  `int_id` varchar(200) NOT NULL,
  `branch_name` varchar(100) DEFAULT NULL,
  `loan_officer_name` varchar(200) DEFAULT NULL,
  `group_name` varchar(200) DEFAULT NULL,
  `group_id` varchar(200) DEFAULT NULL,
  `client_name` varchar(200) DEFAULT NULL,
  `clientID` varchar(200) DEFAULT NULL,
  `date_Of_birth` date DEFAULT NULL,
  `gender` varchar(8) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `staff_name` varchar(200) DEFAULT NULL,
  `account_no` varchar(200) DEFAULT NULL,
  `external_id` varchar(50) DEFAULT NULL,
  `status` varchar(40) DEFAULT NULL,
  `activation_date` date DEFAULT NULL,
  `office_id` varchar(40) DEFAULT NULL,
  `default_savings_product` varchar(200) DEFAULT NULL,
  `default_savings_account` varchar(200) DEFAULT NULL,
  `Client_Type` varchar(200) DEFAULT NULL,
  `Client_Classification` varchar(200) DEFAULT NULL,
  `Email_Address` varchar(200) DEFAULT NULL,
  `Mobile_No_2` varchar(200) DEFAULT NULL,
  `Business_Details_Business_Name` varchar(200) DEFAULT NULL,
  `Business_Details_Business_Type` varchar(200) DEFAULT NULL,
  `Business_Details_Business_Start_Date` varchar(200) DEFAULT NULL,
  `Business_Details_Address` text DEFAULT NULL,
  `Business_Details_State` varchar(200) DEFAULT NULL,
  `Business_Details_LGA` varchar(200) DEFAULT NULL,
  `Business_Details_City` varchar(200) DEFAULT NULL,
  `Business_Details_Nigeria` varchar(200) DEFAULT NULL,
  `Business_Details_Geographical_Region` varchar(200) DEFAULT NULL,
  `Business_Details_Nearest_Bus_Stop` varchar(200) DEFAULT NULL,
  `Business_Details_Submitted_On_Date` varchar(200) DEFAULT NULL,
  `Client_Details_BVN` varchar(200) DEFAULT NULL,
  `Client_Details_Address` varchar(200) DEFAULT NULL,
  `Client_Details_State_Of_Origin` varchar(200) DEFAULT NULL,
  `Client_Details_LGA` varchar(200) DEFAULT NULL,
  `Client_Details_City` varchar(200) DEFAULT NULL,
  `Client_Details_Marital_Status` varchar(10) DEFAULT NULL,
  `Client_Details_Occupation` varchar(200) DEFAULT NULL,
  `Client_Details_No_Of_Household` varchar(200) DEFAULT NULL,
  `Client_Details_Disability` varchar(200) DEFAULT NULL,
  `Client_Details_Submitted_On_Date` varchar(200) DEFAULT NULL,
  `Next_Of_Kin_Name` varchar(200) DEFAULT NULL,
  `Next_Of_Kin_Address` varchar(200) DEFAULT NULL,
  `Next_Of_Kin_City` varchar(200) DEFAULT NULL,
  `Next_Of_Kin_Phone_Number` varchar(200) DEFAULT NULL,
  `Next_Of_Kin_Relation_To_Client` varchar(200) DEFAULT NULL,
  `Next_Of_Kin_State` varchar(200) DEFAULT NULL,
  `Next_Of_Kin_Submitted_On_Date` date DEFAULT NULL,
  `Client_Identifiers_Id_Client_Name` varchar(200) DEFAULT NULL,
  `Client_Identifiers_Document_Type_Id` varchar(200) DEFAULT NULL,
  `Client_Identifiers_Document_key` varchar(200) DEFAULT NULL,
  `client_identifiers_description` varchar(200) DEFAULT NULL,
  `client_identifiers_Validation_policy_id` varchar(200) DEFAULT NULL,
  `migration_status` INT DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `client_details_migrate`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client_details_migrate`
--
ALTER TABLE `client_details_migrate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;


CREATE TABLE `saving_balances_migration` (
  `id` int(11) NOT NULL,
  `int_id` varchar(200) NOT NULL,
  `Branch_Name` varchar(200) NOT NULL,
  `Group_Name` varchar(200) NOT NULL,
  `Group_Id` varchar(200) NOT NULL,
  `Client_Name` varchar(200) NOT NULL,
  `Client_Id` varchar(200) NOT NULL,
  `Product_Id` varchar(200) NOT NULL,
  `Loan_Officer_Name` varchar(200) NOT NULL,
  `Submitted_On_Date` date NOT NULL,
  `Approved_On_Date` date NOT NULL,
  `Activated_On_Date` date NOT NULL,
  `Account_No` varchar(200) NOT NULL,
  `Status` varchar(200) NOT NULL,
  `Total_Deposits_Derived` varchar(200) NOT NULL,
  `Total_Withdrawals_Derived` varchar(200) NOT NULL,
  `Total_Fees_Charge_Derived` varchar(200) NOT NULL,
  `Account_Balance_Derived` varchar(200) NOT NULL,
  `Last_Activity_Date` date NOT NULL,
  `migration_status` INT DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `saving_balances_migration`
--
ALTER TABLE `saving_balances_migration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `saving_balances_migration`
--
ALTER TABLE `saving_balances_migration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;


CREATE TABLE savings_transactions_migrate (
id INT(11) NOT NULL AUTO_INCREMENT, int_id INT NOT NULL, Branch_Name VARCHAR(100), Loan_Officer_Name VARCHAR(100),	Group_Name VARCHAR(100), Group_Id VARCHAR(100), 
Client_Name VARCHAR(100), Client_Id VARCHAR(100), Created_By VARCHAR(100), Deposit DECIMAL(19,2), Withdrawal DECIMAL(19,2), 
Interest_Posting DECIMAL(19,2), Charges_Applied DECIMAL(19), Charges_Waived DECIMAL(19,2), Transfer_Amount DECIMAL(19,2), Product_Short_Name VARCHAR(10), 
Product_Name VARCHAR(100), Product_Id VARCHAR(100), Account_Number VARCHAR(100), Payment_Channel VARCHAR(100), 
Reference VARCHAR(100), Product_Group VARCHAR(100), Parent_Product_Group VARCHAR(100), 
Transaction_Type VARCHAR(100), Transaction_Id VARCHAR(100), Office_Id VARCHAR(100), Payment_Detail_Id VARCHAR(100), Effective_Date DATE, Is_Account_Transfer VARCHAR(10),
migration_status INT DEFAULT '0',
PRIMARY KEY (id)
);

-- ignore this for now
-- UPDATE accounts inner join client.display_name = saving_balances_migration.client_name
-- SET 

CREATE TABLE outstanding_report_migrate (
id INT(11) NOT NULL AUTO_INCREMENT, int_id INT, client_id VARCHAR(100), client_name VARCHAR(100), dob DATE, 
gender VARCHAR(10), account VARCHAR(20), branch VARCHAR(10), product VARCHAR(20), interest_at_disbursement DECIMAL(19,2), 
eir DECIMAL(19,2), loan_principal DECIMAL(19,2), outstanding_principal DECIMAL(19,2), interest DECIMAL(19,2),	fees DECIMAL (19,2), 
total DECIMAL(19,2),	loan_officer VARCHAR(100), disbursed DATE, installments int, loan_frequency int, periods VARCHAR(10), 
status varchar(10), trp DECIMAL(2.1), groupn varchar(100), bussiness_type VARCHAR(100), loan_purpose VARCHAR(100), 
payment_type VARCHAR(100), final_payment_date DATE, maturity_date DATE, arrear_amount DECIMAL(19,2),	days_in_arrears int,
migration_status int,
PRIMARY KEY (id)
);

CREATE TABLE clients_branch_migrate (
id INT NOT NULL AUTO_INCREMENT, int_id INT, client_id VARCHAR(100),	name VARCHAR(100), group_name VARCHAR(100), 
product VARCHAR(10), amount DECIMAL(19,2), outstanding_principal DECIMAL(19,2), outstanding_interest DECIMAL(19,2), 
fees DECIMAL(19,2), repaid DECIMAL (19,2), outstanding_loan_balance DECIMAL (19,2), expected_payment_date DECIMAL(19,2), 
expected_payment DECIMAL(19,2), next_payment DATE, overdue DECIMAL(19,2), avaliable_balance DECIMAL(19,2), 
last_depost DECIMAL(19,2),	available_balance DECIMAL(19,2),	last_balance DECIMAL(19,2), migration_status INT DEFAULT '0',
PRIMARY KEY (id)
);

-- to display account details
SELECT saving_balances_migration.Submitted_On_Date, saving_balances_migration.Approved_On_Date,
saving_balances_migration.Activated_On_Date, saving_balances_migration.Loan_Officer_Name,
clients_branch_migrate.last_depost, clients_branch_migrate.available_balance,
clients_branch_migrate.name, saving_balances_migration.Account_No
FROM saving_balances_migration
INNER JOIN clients_branch_migrate ON saving_balances_migration.Client_Name=clients_branch_migrate.name;


-- to display loan details
SELECT outstanding_report_migrate.account, outstanding_report_migrate.loan_principal, outstanding_report_migrate.outstanding_principal,
outstanding_report_migrate.interest, outstanding_report_migrate.fees, outstanding_report_migrate.total, clients_branch_migrate.repaid,
clients_branch_migrate.overdue, clients_branch_migrate.group_name
FROM outstanding_report_migrate
LEFT JOIN clients_branch_migrate ON outstanding_report_migrate.client_name = clients_branch_migrate.name;