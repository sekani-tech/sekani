<?php
// here i am going to add the connection
include("connect.php");
session_start();
?>
<!-- another for inputting the data -->
<?php
$int_name = $_POST['int_name'];
$rcn = $_POST['rcn'];
$lga = $_POST['lga'];
$int_state = $_POST['int_state'];
$email = $_POST['email'];
$office_address = $_POST['office_address'];
$website = $_POST['website'];
$office_phone = $_POST['office_phone'];
$pc_title = $_POST['pc_title'];
$pc_surname = $_POST['pc_surname'];
$pc_other_name = $_POST['pc_other_name'];
$pc_designation = $_POST['pc_designation'];
$pc_phone = $_POST['pc_phone'];
$pc_email = $_POST['pc_email'];
// preparation of account number
$sessint_id = $_SESSION["int_id"];
$ldi = $_SESSION["user_id"];
$inttest = str_pad($sessint_id, 3, '0', STR_PAD_LEFT);
$usertest = str_pad($ldi, 3, '0', STR_PAD_LEFT);
$digits = 4;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$account_no = $inttest. "-" .$usertest. "-" .$randms;
// done with account number preparation
$submitted_on = date("Y-m-d");
$currency = "NGN";

$digits = 10;
$temp = explode(".", $_FILES['int_logo']['name']);
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$imagex = $int_name. '.' .end($temp);

if (move_uploaded_file($_FILES['int_logo']['tmp_name'], "instimg/" . $imagex)) {
    $msg = "Image uploaded successfully";
} else {
  $msg = "Image Failed";
}
$int_no = "SELECT * FROM institutions";
$eddd = mysqli_query($connection, $int_no);
$mw = mysqli_num_rows($eddd);
$intnumer = $mw + 1;

$query = "INSERT INTO institutions (int_name, rcn, lga, int_state, email,
office_address, website, office_phone, pc_title, pc_surname, pc_other_name,
pc_designation, pc_phone, pc_email, img) VALUES ('{$int_name}','{$rcn}',
'{$lga}', '{$int_state}', '{$email}', '{$office_address}', '{$website}', '{$office_phone}',
'{$pc_title}', '{$pc_surname}', '{$pc_other_name}', '{$pc_designation}',
'{$pc_phone}', '{$pc_email}', '{$imagex}')";
// add
$result = mysqli_query($connection, $query);
if ($result) {
    $verify = mysqli_query($connection, "SELECT * FROM institutions WHERE int_name = '$int_name'");
    if (count([$verify]) == 1) {
        $x = mysqli_fetch_array($verify);
        $int_id = $x['int_id'];
        $gl_query = "INSERT INTO `acc_gl_account` (`int_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`) VALUES
        ('$int_id', 'CASH ASSET', 0, '1', '10010000', 0, 1, 2, 1, NULL, '', 0),
        ('$int_id', 'Main Vault', 1, '.2.', '10011000', 0, 1, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Teller Funds', 1, '.3.', '10012000', 0, 1, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Due from Banks', 0, '', '10020000', 0, 1, 2, 1, NULL, NULL, 0),
        ('$int_id', 'Micro Small & Medium Enterprise Loan', 13, '.6.', '10062000', 0, 1, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Other Asset', 0, '.', '10070000', 0, 0, 2, 1, NULL, NULL, 0),
        ('$int_id', 'Prepaid Rent', 7, '.8.', '10075000', 0, 1, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Other Prepayment', 7, '.9.', '10077000', 0, 1, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Short Term Investment', 0, '.', '10040000', 0, 1, 2, 1, NULL, NULL, 0),
        ('$int_id', 'Treasury Bills', 10, '.11.', '10041000', 0, 1, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Long Term Investment', 10, '.12.', '10050000', 0, 0, 2, 1, NULL, NULL, 0),
        ('$int_id', 'Loans and Advances/ Lease', 0, '.', '10060000', 0, 1, 2, 1, NULL, NULL, 0),
        ('$int_id', 'Bills Discounted', 13, '.14.', '10063000', 0, 1, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Fixed Asset', 0, '.', '10080000', 0, 1, 2, 1, NULL, NULL, 0),
        ('$int_id', 'Freehold Land and Building', 15, '.16.', '10081000', 0, 1, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Leasehold Land and Building', 15, '.17.', '10082000', 0, 1, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Furniture and Fixtures', 15, '.18.', '10084000', 0, 1, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Motor Vehicle', 15, '.19.', '10085000', 0, 1, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Office Equipment', 15, '.20.', '10086000', 0, 1, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Plant and Mechinary', 15, '.21.', '10083000', 0, 1, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Asset Transfer Account', 7, '.22.', '10071100', 0, 1, 1, 1, NULL, NULL, 0),
        ('$int_id', 'DEPOSITS', 25, '.23.', '20010000', 0, 1, 2, 2, NULL, NULL, 0),
        ('$int_id', 'Uncleared Effect/Transit Item', 178, '.24.', '20044000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Liability', 0, '.', '20000000', 0, 1, 2, 2, NULL, NULL, 0),
        ('$int_id', 'Liability Transfer Account', 25, '.26.', '20060000', 0, 0, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Loan Overpayment', 25, '.27.', '20090000', 0, 0, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Provision for Taxation', 178, '.28.', '20048000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Interest in suspense', 178, '.29.', '20047000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Share Premium', 191, '.30.', '60020000', 0, 1, 1, 3, NULL, NULL, 0),
        ('$int_id', 'Salaries, Wages and Allowances', 68, '.68.31.', '90021000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Provision for Dimuniition in the value of Investment', 178, '.32.', '20045000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'TAKINGS FROM', 0, '.', '20020000', 0, 1, 2, 2, NULL, NULL, 0),
        ('$int_id', 'Other Institutions', 33, '.34.', '20022000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Re-finanacing Facility', 33, '.35.', '20030000', 0, 1, 2, 2, NULL, NULL, 0),
        ('$int_id', 'Banks in Nigeria', 33, '.36.', '20021000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Provision for losses on off balance sheet items', 178, '.37.', '20046000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'ACCUMULATED DEPRECIATION', 0, '.', '30000000', 0, 1, 2, 2, NULL, NULL, 0),
        ('$int_id', 'Land and Building (Depr)', 38, '.39.', '30010000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Leasehold (Depr)', 38, '.40.', '30020000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Furniture and Fitures (Depr)', 38, '.41.', '30030000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Motor Vehicle (Depr)', 38, '.42.', '30040000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Office Equiptment (Depr)', 38, '.44.', '30050000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Plant and Machinary (Depr)', 38, '.46.', '30060000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'CAPITAL', 0, '.', '50000000', 0, 0, 2, 3, NULL, NULL, 0),
        ('$int_id', 'Issued & Fully Paid', 47, '.48.', '50020000', 0, 1, 1, 3, NULL, NULL, 0),
        ('$int_id', 'General Reserve', 191, '.50.', '60030000', 0, 1, 1, 3, NULL, NULL, 0),
        ('$int_id', 'Other Reserves', 191, '.51.', '60070000', 0, 0, 1, 3, NULL, NULL, 0),
        ('$int_id', 'Retained Earnings', 191, '.52.', '60080000', 0, 0, 1, 3, NULL, NULL, 0),
        ('$int_id', 'INCOME', 0, '.', '80000000', 0, 0, 2, 4, NULL, NULL, 0),
        ('$int_id', 'INTEREST INCOME', 53, '.54.', '80010000', 0, 0, 2, 4, NULL, NULL, 0),
        ('$int_id', 'Other Financial Services Income', 62, '.62.55.', '80039000', 0, 0, 1, 4, NULL, NULL, 0),
        ('$int_id', 'Loan Penalty Income', 62, '.62.56.', '80037000', 0, 0, 1, 4, NULL, NULL, 0),
        ('$int_id', 'EXPENSE', 0, '.57.', '90000000', 0, 0, 2, 5, NULL, NULL, 0),
        ('$int_id', 'Group Registration Fees', 198, '.58.', '80026000', 0, 1, 1, 4, NULL, NULL, 0),
        ('$int_id', 'Recovery Income', 62, '.62.59.', '80036000', 0, 0, 1, 4, NULL, NULL, 0),
        ('$int_id', 'Income from Investment', 62, '.62.60.', '80038000', 0, 1, 1, 4, NULL, NULL, 0),
        ('$int_id', 'Credit Referance Serach', 62, '.62.61.', '80032000', 0, 0, 1, 4, NULL, NULL, 0),
        ('$int_id', 'OTHER INCOME', 53, '.62.', '80030000', 0, 0, 2, 4, NULL, NULL, 0),
        ('$int_id', 'OTHER OPERATING EXPENSES', 0, '.', '90050000', 0, 0, 2, 5, NULL, NULL, 0),
        ('$int_id', 'Interest Expenses on Borrowing', 165, '.64.', '90013000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Term Deposit Interest', 165, '.65.', '90011000', 0, 0, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Fueling and Lubricant', 97, '.97.66.', '90042000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'LOAN LOSS PROVISION', 25, '.67.', '40000000', 0, 0, 2, 2, NULL, NULL, 0),
        ('$int_id', 'PERSONEL COST', 63, '.68.', '90020000', 0, 0, 2, 5, NULL, NULL, 0),
        ('$int_id', 'Director Remuneration & Expenses', 113, '.113.69.', '90031000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Productivity Bonus', 57, '.68.70.', '90025000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', '13th month', 68, '.68.71.', '90022000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Staff Medicals', 68, '.68.72.', '90023000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Pension Contribution', 68, '.68.73.', '90024000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Bad Debt Written Off', 201, '.74.', '90071000', 0, 0, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Electricals Repairs', 97, '.97.75.', '90049100', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Printing and Stationaries', 97, '.97.76.', '90047000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Electricity and other unilities expenses', 97, '.97.77.', '90043000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Transportion', 97, '.97.78.', '90044000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Office Consumables', 57, '.79.', '90059100', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Audit Fee', 63, '.80.', '90056000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Legal Fee', 63, '.81.', '90057000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Professional and Consultancy fee', 63, '.82.', '90054000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Telephone and Communications', 97, '.97.83.', '90046000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'DTA Expenses', 97, '.97.85.', '90045000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Annual Subscription', 63, '.86.', '90051000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Registration and Govt Charges', 63, '.87.', '90055000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Advertising and Publicity', 63, '.88.', '90052000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Depreciation of Fixed Assets', 98, '.98.89.', '90081000', 0, 0, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Commission', 91, '.91.90.', '90063000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'OTHER FINACIAL EXPENSES', 63, '.91.', '90060000', 0, 0, 2, 5, NULL, NULL, 0),
        ('$int_id', 'NDIC Premium', 91, '.91.92.', '90062000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Furniture and Fittings Repairs', 97, '.97.93.', '90049200', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Penalty Charges', 63, '.94.', '90058000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Office Equip Repairs', 97, '.97.95.', '90049400', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Plant and Machinery Repairs', 97, '.97.96.', '90049000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'OVERHEAD EXPENSES', 63, '.97.', '90040000', 0, 1, 2, 5, NULL, NULL, 0),
        ('$int_id', 'DEPRECIATION & AMORTIZATION', 63, '.98.', '90080000', 0, 0, 2, 5, NULL, NULL, 0),
        ('$int_id', 'OTHER NON OPERATING INCOME', 53, '.99.', '80040000', 0, 0, 2, 4, NULL, NULL, 0),
        ('$int_id', 'Cash Donations', 99, '.99.100.', '80041000', 0, 1, 1, 4, NULL, NULL, 0),
        ('$int_id', 'Other Non Operational Income', 99, '.99.101.', '80042000', 0, 1, 1, 4, NULL, NULL, 0),
        ('$int_id', 'DG Micro Loans', 13, '.102.', '10061000', 0, 1, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Overdraft', 13, '.104.', '10067000', 0, 0, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Office Rent', 97, '.97.105.', '90041000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Office Entertainment ', 63, '.106.', '90059000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Motor vehicle Repairs', 97, '.97.108.', '90048000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Postage', 97, '.97.109.', '90049600', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'General Repairs and Maintenance', 97, '.97.111.', '90049300', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Bank Charges', 91, '.91.112.', '90061000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'DIRECTORS COST', 63, '.113.', '90030000', 0, 0, 2, 5, NULL, NULL, 0),
        ('$int_id', 'Interest Accrued not Paid', 178, '.114.', '20043000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'FCMB', 5, '.116.', '10021000', 0, 1, 1, 1, NULL, NULL, 1),
        ('$int_id', 'Fidelity Bank', 5, '.117.', '10022000', 0, 1, 1, 1, NULL, NULL, 1),
        ('$int_id', 'Teller Differences', 1, '.118.', '10013000', 0, 1, 1, 1, NULL, NULL, 0),
        ('$int_id', 'First Bank Plc', 5, '.119.', '10023000', 0, 1, 1, 1, NULL, NULL, 1),
        ('$int_id', 'UBA', 5, '.120.', '10024000', 0, 1, 1, 1, NULL, NULL, 1),
        ('$int_id', 'Access Bank Plc', 5, '.121.', '10025000', 0, 1, 1, 1, NULL, NULL, 1),
        ('$int_id', 'Lease Advances', 13, '.122.', '10066000', 0, 1, 1, 1, NULL, NULL, 0),
        ('$int_id', 'DG Staff Loan', 13, '.123.', '10065000', 0, 1, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Hire Purchase', 13, '.124.', '10064000', 0, 1, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Voluntary Savings', 23, '.23.125.', '20012000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Demand Deposit', 23, '.23.126.', '20011000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Time/Term Deposit', 23, '.23.127.', '20014000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Provision for other losses', 178, '.128.', '20049100', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Other Deposits', 23, '.23.129.', '20015000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Escheat Control Account', 25, '.130.', '20080000', 0, 0, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Bills Discounted Income', 54, '.54.131.', '80013000', 0, 1, 1, 4, NULL, NULL, 0),
        ('$int_id', 'Micro Loan Interest Income', 54, '.54.132.', '80011000', 0, 1, 1, 4, NULL, NULL, 0),
        ('$int_id', 'Hire Purchase Income', 54, '.54.133.', '80014000', 0, 1, 1, 4, NULL, NULL, 0),
        ('$int_id', 'Staff Loan Income ', 54, '.54.134.', '80015000', 0, 1, 1, 4, NULL, NULL, 0),
        ('$int_id', 'Micro Small & Medium  Enterprise  Loan Income', 54, '.54.135.', '80012000', 0, 0, 1, 4, NULL, NULL, 0),
        ('$int_id', 'Lease Advances Income', 54, '.54.136.', '80016000', 0, 1, 1, 4, NULL, NULL, 0),
        ('$int_id', 'Fees: Legal', 198, '.137.', '80021000', 0, 0, 1, 4, NULL, NULL, 0),
        ('$int_id', 'Loan MONITORING Fees', 198, '.138.', '80022000', 0, 1, 1, 4, NULL, 'Loan MONITORING', 0),
        ('$int_id', 'Loan Application Income', 198, '.139.', '80023000', 0, 1, 1, 4, NULL, NULL, 0),
        ('$int_id', 'Insurance Income', 198, '.140.', '80024000', 0, 1, 1, 4, NULL, NULL, 0),
        ('$int_id', 'Loan Processing Income', 198, '.141.', '80025000', 0, 1, 1, 4, NULL, NULL, 0),
        ('$int_id', 'SMS Alert', 62, '.62.142.', '80031000', 0, 0, 1, 4, NULL, NULL, 0),
        ('$int_id', 'Stamp Duty', 62, '.62.143.', '80033000', 0, 1, 1, 4, NULL, NULL, 0),
        ('$int_id', 'Account Maintainance', 62, '.62.144.', '80034000', 0, 1, 1, 4, NULL, NULL, 0),
        ('$int_id', 'Charges on Pass Book', 198, '.145.', '80027000', 0, 1, 1, 4, NULL, NULL, 0),
        ('$int_id', 'Charges on Cheque', 198, '.146.', '80028000', 0, 1, 1, 4, NULL, NULL, 0),
        ('$int_id', 'Overdraft Income', 54, '.54.147.', '80017000', 0, 1, 1, 4, NULL, NULL, 0),
        ('$int_id', 'Deposit for Shares', 178, '.149.', '20049300', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'System Reconciliation Account', 25, '.150.', '20091000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Preference Shares', 47, '.151.', '50030000', 0, 1, 1, 3, NULL, NULL, 0),
        ('$int_id', 'Suspense Account', 178, '.152.', '20049000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Security Guards', 63, '.153.', '90053000', 0, 0, 1, 5, NULL, NULL, 0),
        ('$int_id', 'ACCT Re-activation Fees', 62, '.62.154.', '80035000', 0, 0, 1, 4, NULL, NULL, 0),
        ('$int_id', 'Shares Control', 25, '.155.', '20070000', 0, 0, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Account Payable', 178, '.156.', '20041000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Stationery', 57, '.157.', '10076000', 0, 0, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Cheque for Collection / Transit Item', 7, '.158.', '10073000', 0, 0, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Suspense Account', 7, '.161.', '10078000', 0, 0, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Mandatory Savings', 23, '.23.163.', '20013000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Unearned Income', 178, '.164.', '20042000', 0, 0, 1, 2, NULL, NULL, 0),
        ('$int_id', 'INTEREST EXPENSE', 0, '.', '90010000', 0, 0, 2, 5, NULL, NULL, 0),
        ('$int_id', 'Placements', 0, '.', '10030000', 0, 0, 2, 1, NULL, NULL, 0),
        ('$int_id', 'Secured With Treasury Bills', 166, '.167.', '10031000', 0, 0, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Unsecured ', 166, '.168.', '10032000', 0, 0, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Quoted Companies', 12, '.12.169.', '10051000', 0, 0, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Unquoted Companies', 12, '.12.170.', '10052000', 0, 0, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Sunsidaries Companies', 12, '.12.171.', '10053000', 0, 0, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Others', 12, '.12.172.', '10054000', 0, 0, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Account Recievable ', 7, '.173.', '10071000', 0, 0, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Accrued Interest', 7, '.174.', '10072000', 0, 0, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Prepaid Interest', 7, '.176.', '10074000', 0, 0, 1, 1, NULL, NULL, 0),
        ('$int_id', 'Goodwill & Other Intangible Assets', 7, '.177.', '10079000', 0, 0, 1, 1, NULL, NULL, 0),
        ('$int_id', 'OTHER LIABILITIES', 0, '.', '20040000', 0, 0, 2, 2, NULL, NULL, 0),
        ('$int_id', 'Dividends Payable', 178, '.179.', '20049200', 0, 0, 1, 2, NULL, NULL, 0),
        ('$int_id', 'BORROWINGS ON-LENDING', 0, '.', '20050000', 0, 1, 2, 2, NULL, NULL, 0),
        ('$int_id', 'FGN', 180, '.181.', '20051000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'State Government', 180, '.182.', '20052000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'LGA', 180, '.183.', '20054000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Foreign Agencies', 180, '.184.', '20055000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Others', 180, '.185.', '20056000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Pass & Watch (1 - 30 days)', 67, '.67.186.', '40010000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Sub-Standard (31 - 60 days)', 67, '.67.187.', '40020000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Doubtful (61 - 90 days)', 67, '.67.188.', '40030000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Lost (91 days & Above)', 67, '.67.189.', '40040000', 0, 1, 1, 2, NULL, NULL, 0),
        ('$int_id', 'Authorized Share captial', 47, '.190.', '50010000', 0, 1, 1, 3, NULL, NULL, 0),
        ('$int_id', 'RESERVES', 0, '.', '60000000', 0, 0, 2, 3, NULL, NULL, 0),
        ('$int_id', 'Statutory Reserve', 191, '.192.', '60010000', 0, 1, 1, 3, NULL, NULL, 0),
        ('$int_id', 'Deferred Grant/donation Reserve', 191, '.194.', '60040000', 0, 1, 1, 3, NULL, NULL, 0),
        ('$int_id', 'Bonus Reserve', 191, '.195.', '60050000', 0, 1, 1, 3, NULL, NULL, 0),
        ('$int_id', 'Revaluation Reserves', 191, '.196.', '60060000', 0, 1, 1, 3, NULL, NULL, 0),
        ('$int_id', 'OFF-BALANCE SHEET ENGAGEMENT', 191, '.197.', '70000000', 0, 1, 1, 3, NULL, NULL, 0),
        ('$int_id', 'FEES & CHARGES', 0, '.', '80020000', 0, 0, 2, 4, NULL, NULL, 0),
        ('$int_id', 'Savings Interest', 165, '.199.', '90012000', 0, 0, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Internet Subscription', 97, '.97.200.', '90049500', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'WRITE OFF', 0, '.', '90070000', 0, 0, 2, 5, NULL, NULL, 0),
        ('$int_id', 'Provision for bad debt', 201, '.202.', '90072000', 0, 1, 1, 5, NULL, NULL, 0),
        ('$int_id', 'Transfer Wallet', 1, '.162.1.203.', '10013100', 0, 1, 1, 1, NULL, NULL, 0),
        ('$int_id', 'One Day Charge', 198, '.204.', '80028001', 0, 1, 1, 4, NULL, NULL, 0),
        ('$int_id', 'INTERNET, SUBSCRIPTION AND WEB SEVICES', 0, NULL, '52750', NULL, 1, 1, 5, NULL, 'Internet subscr', 1),
        ('$int_id', 'OFFICE REPAIRS', 0, NULL, '59089', NULL, 1, 1, 5, NULL, 'Office repairs', 1),
        ('$int_id', 'VEHICLE REPAIRS', 0, NULL, '57703', NULL, 1, 1, 5, NULL, 'Vehicle repairs', 1),
        ('$int_id', 'COVID-19', 0, NULL, '56316', 0, 0, 1, 5, NULL, 'MASK, QUICK CASH, SUPPORT ..ETC', 1),
        ('$int_id', 'SALARIES ARREARS', 0, NULL, '24786', NULL, 1, 1, 2, NULL, 'SALARY', 0),
        ('$int_id', 'BVN Search', 53, NULL, '45588', NULL, 1, 1, 4, NULL, '', 0)";
        $gloc = mysqli_query($connection, $gl_query);
    if ($gloc) {
        echo header("Location: ../institution.php");
    } else {
        echo $int_id."oboy";
    }
    } else {
        echo "no count";
    }
    // if ($connection->error) {
    //     try {   
    //         throw new Exception("MySQL error $connection->error <br> Query:<br> $queryx", $mysqli->error);   
    //     } catch(Exception $e ) {
    //         echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
    //         echo nl2br($e->getTraceAsString());
    //     }
    // }
    // successfully inserted the data
    // header("Location: ../../manage_users.php");
    exit;
} else {
    // Display an error message
    echo "<p>Bad</p>";
}
?>