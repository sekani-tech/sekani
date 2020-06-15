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
    $verify = mysqli_query($connection, "SELECT * FROM institutions WHERE rcn = '$rcn'");
    if (count([$verify]) == 1) {
        $x = mysqli_fetch_array($verify);
        $int_id = $x['int_id'];
        $mvamt = 10000000.00;
        $bal = 0.00;
        $queryx = "INSERT INTO int_vault (int_id, account_no,
    movable_amount, balance, date, last_withdrawal, last_deposit) VALUES ('{$int_id}',
    '{$account_no}', '{$mvamt}', '{$bal}', '{$submitted_on}', '{$bal}', '{$bal}')";
    $gogoo = mysqli_query($connection, $queryx);
    if($gogoo){
        $acc_gl_list = "INSERT INTO `acc_gl_account` (`id`, `int_id`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
        (1, '$intnumer', 1, 'CASH ASSET', 0, '1', '10010000', 0, 1, 2, 1, NULL, '', 0, '0.00', NULL),
        (2, '$intnumer', 1, 'Main Vault', 1, '.2.', '10011000', 0, 1, 1, 1, NULL, NULL, 0, '0.00', 23108),
        (3, '$intnumer', 1, 'Teller Funds', 1, '.3.', '10012000', 0, 1, 1, 1, NULL, NULL, 0, '0.00', 23116),
        (5, '$intnumer', 1, 'Due from Banks', 0, '', '10020000', 0, 1, 2, 1, NULL, NULL, 0, '0.00', NULL),
        (6, '$intnumer', 1, 'Micro Small & Medium  Enterprise  Loan', 13, '.6.', '10062000', 0, 1, 1, 1, NULL, NULL, 0, '0.00', 15352),
        (7, '$intnumer', 1, 'Other Asset', 0, '.', '10070000', 0, 0, 2, 1, NULL, NULL, 0, '0.00', NULL),
        (8, '$intnumer', 1, 'Prepaid Rent', 7, '.8.', '10075000', 0, 1, 1, 1, NULL, NULL, 0, '0.00', 12049),
        (9, '$intnumer', 1, 'Other Prepayment', 7, '.9.', '10077000', 0, 1, 1, 1, NULL, NULL, 0, '0.00', NULL),
        (10, '$intnumer', 1, 'Short Term Investment', 0, '.', '10040000', 0, 1, 2, 1, NULL, NULL, 0, '0.00', NULL),
        (11, '$intnumer', 1, 'Treasury Bills', 10, '.11.', '10041000', 0, 1, 1, 1, NULL, NULL, 0, '0.00', NULL),
        (12, '$intnumer', 1, 'Long Term Investment', 10, '.12.', '10050000', 0, 0, 2, 1, NULL, NULL, 0, '0.00', NULL),
        (13, '$intnumer', 1, 'Loans and Advances/ Lease', 0, '.', '10060000', 0, 1, 2, 1, NULL, NULL, 0, '0.00', NULL),
        (14, '$intnumer', 1, 'Bills Discounted', 13, '.14.', '10063000', 0, 1, 1, 1, NULL, NULL, 0, '0.00', NULL),
        (15, '$intnumer', 1, 'Fixed Asset', 0, '.', '10080000', 0, 1, 2, 1, NULL, NULL, 0, '0.00', NULL),
        (16, '$intnumer', 1, 'Freehold Land and Building', 15, '.16.', '10081000', 0, 1, 1, 1, NULL, NULL, 0, '0.00', NULL),
        (17, '$intnumer', 1, 'Leasehold Land and Building', 15, '.17.', '10082000', 0, 1, 1, 1, NULL, NULL, 0, '0.00', NULL),
        (18, '$intnumer', 1, 'Furniture and Fixtures', 15, '.18.', '10084000', 0, 1, 1, 1, NULL, NULL, 0, '0.00', 17981),
        (19, '$intnumer', 1, 'Motor Vehicle', 15, '.19.', '10085000', 0, 1, 1, 1, NULL, NULL, 0, '0.00', NULL),
        (20, '$intnumer', 1, 'Office Equipment', 15, '.20.', '10086000', 0, 1, 1, 1, NULL, NULL, 0, '0.00', 18855),
        (21, '$intnumer', 1, 'Plant and Mechinary', 15, '.21.', '10083000', 0, 1, 1, 1, NULL, NULL, 0, '0.00', 17972),
        (22, '$intnumer', 1, 'Asset Transfer Account', 7, '.22.', '10071100', 0, 1, 1, 1, NULL, NULL, 0, '0.00', 8938),
        (23, '$intnumer', 1, 'DEPOSITS', 25, '.23.', '20010000', 0, 1, 2, 2, NULL, NULL, 0, '0.00', NULL),
        (24, '$intnumer', 1, 'Uncleared Effect/Transit Item', 178, '.24.', '20044000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', NULL),
        (25, '$intnumer', 1, 'Liability', 0, '.', '20000000', 0, 1, 2, 2, NULL, NULL, 0, '0.00', NULL),
        (26, '$intnumer', 1, 'Liability Transfer Account', 25, '.26.', '20060000', 0, 0, 1, 2, NULL, NULL, 0, '0.00', 23212),
        (27, '$intnumer', 1, 'Loan Overpayment', 25, '.27.', '20090000', 0, 0, 1, 2, NULL, NULL, 0, '0.00', NULL),
        (28, '$intnumer', 1, 'Provision for Taxation', 178, '.28.', '20048000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', NULL),
        (29, '$intnumer', 1, 'Interest in suspense', 178, '.29.', '20047000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', NULL),
        (30, '$intnumer', 1, 'Share Premium', 191, '.30.', '60020000', 0, 1, 1, 3, NULL, NULL, 0, '0.00', 6337),
        (31, '$intnumer', 1, 'Salaries, Wages and Allowances', 68, '.68.31.', '90021000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', 17719),
        (32, '$intnumer', 1, 'Provision for Dimuniition in the value of Investment', 178, '.32.', '20045000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', NULL),
        (33, '$intnumer', 1, 'TAKINGS FROM', 0, '.', '20020000', 0, 1, 2, 2, NULL, NULL, 0, '0.00', NULL),
        (34, '$intnumer', 1, 'Other Institutions', 33, '.34.', '20022000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', NULL),
        (35, '$intnumer', 1, 'Re-finanacing Facility', 33, '.35.', '20030000', 0, 1, 2, 2, NULL, NULL, 0, '0.00', NULL),
        (36, '$intnumer', 1, 'Banks in Nigeria', 33, '.36.', '20021000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', NULL),
        (37, '$intnumer', 1, 'Provision for losses on off balance sheet items', 178, '.37.', '20046000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', NULL),
        (38, '$intnumer', 1, 'ACCUMULATED DEPRECIATION', 0, '.', '30000000', 0, 1, 2, 2, NULL, NULL, 0, '0.00', NULL),
        (39, '$intnumer', 1, 'Land and Building (Depr)', 38, '.39.', '30010000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', NULL),
        (40, '$intnumer', 1, 'Leasehold (Depr)', 38, '.40.', '30020000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', NULL),
        (41, '$intnumer', 1, 'Furniture and Fitures (Depr)', 38, '.41.', '30030000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', 17980),
        (42, '$intnumer', 1, 'Motor Vehicle (Depr)', 38, '.42.', '30040000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', NULL),
        (44, '$intnumer', 1, 'Office Equiptment (Depr)', 38, '.44.', '30050000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', 18250),
        (46, '$intnumer', 1, 'Plant and Machinary (Depr)', 38, '.46.', '30060000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', NULL),
        (47, '$intnumer', 1, 'CAPITAL', 0, '.', '50000000', 0, 0, 2, 3, NULL, NULL, 0, '0.00', NULL),
        (48, '$intnumer', 1, 'Issued & Fully Paid', 47, '.48.', '50020000', 0, 1, 1, 3, NULL, NULL, 0, '0.00', 13001),
        (50, '$intnumer', 1, 'General Reserve', 191, '.50.', '60030000', 0, 1, 1, 3, NULL, NULL, 0, '0.00', NULL),
        (51, '$intnumer', 1, 'Other Reserves', 191, '.51.', '60070000', 0, 0, 1, 3, NULL, NULL, 0, '0.00', NULL),
        (52, '$intnumer', 1, 'Retained Earnings', 191, '.52.', '60080000', 0, 0, 1, 3, NULL, NULL, 0, '0.00', NULL),
        (53, '$intnumer', 1, 'INCOME', 0, '.', '80000000', 0, 0, 2, 4, NULL, NULL, 0, '0.00', NULL),
        (54, '$intnumer', 1, 'INTEREST INCOME', 53, '.54.', '80010000', 0, 0, 2, 4, NULL, NULL, 0, '0.00', NULL),
        (55, '$intnumer', 1, 'Other Financial Services Income', 62, '.62.55.', '80039000', 0, 0, 1, 4, NULL, NULL, 0, '0.00', 23189),
        (56, '$intnumer', 1, 'Loan Penalty Income', 62, '.62.56.', '80037000', 0, 0, 1, 4, NULL, NULL, 0, '0.00', 4531),
        (57, '$intnumer', 1, 'EXPENSE', 0, '.57.', '90000000', 0, 0, 2, 5, NULL, NULL, 0, '0.00', NULL),
        (58, '$intnumer', 1, 'Group Registration Fees', 198, '.58.', '80026000', 0, 1, 1, 4, NULL, NULL, 0, '0.00', 23187),
        (59, '$intnumer', 1, 'Recovery Income', 62, '.62.59.', '80036000', 0, 0, 1, 4, NULL, NULL, 0, '0.00', 3737),
        (60, '$intnumer', 1, 'Income from Investment', 62, '.62.60.', '80038000', 0, 1, 1, 4, NULL, NULL, 0, '0.00', NULL),
        (61, '$intnumer', 1, 'Credit Referance Serach', 62, '.62.61.', '80032000', 0, 0, 1, 4, NULL, NULL, 0, '0.00', 8942),
        (62, '$intnumer', 1, 'OTHER INCOME', 53, '.62.', '80030000', 0, 0, 2, 4, NULL, NULL, 0, '0.00', NULL),
        (63, '$intnumer', 1, 'OTHER OPERATING EXPENSES', 0, '.', '90050000', 0, 0, 2, 5, NULL, NULL, 0, '0.00', NULL),
        (64, '$intnumer', 1, 'Interest Expenses on Borrowing', 165, '.64.', '90013000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', NULL),
        (65, '$intnumer', 1, 'Term Deposit Interest', 165, '.65.', '90011000', 0, 0, 1, 5, NULL, NULL, 0, '0.00', 22853),
        (66, '$intnumer', 1, 'Fueling and Lubricant', 97, '.97.66.', '90042000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', 21151),
        (67, '$intnumer', 1, 'LOAN LOSS PROVISION', 25, '.67.', '40000000', 0, 0, 2, 2, NULL, NULL, 0, '0.00', NULL),
        (68, '$intnumer', 1, 'PERSONEL COST', 63, '.68.', '90020000', 0, 0, 2, 5, NULL, NULL, 0, '0.00', NULL),
        (69, '$intnumer', 1, 'Director Remuneration & Expenses', 113, '.113.69.', '90031000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', NULL),
        (70, '$intnumer', 1, 'Productivity Bonus', 57, '.68.70.', '90025000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', NULL),
        (71, '$intnumer', 1, '13th month', 68, '.68.71.', '90022000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', NULL),
        (72, '$intnumer', 1, 'Staff Medicals', 68, '.68.72.', '90023000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', NULL),
        (73, '$intnumer', 1, 'Pension Contribution', 68, '.68.73.', '90024000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', NULL),
        (74, '$intnumer', 1, 'Bad Debt Written Off', 201, '.74.', '90071000', 0, 0, 1, 5, NULL, NULL, 0, '0.00', 3712),
        (75, '$intnumer', 1, 'Electricals Repairs', 97, '.97.75.', '90049100', 0, 1, 1, 5, NULL, NULL, 0, '0.00', 18248),
        (76, '$intnumer', 1, 'Printing and Stationaries', 97, '.97.76.', '90047000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', 19166),
        (77, '$intnumer', 1, 'Electricity and other unilities expenses', 97, '.97.77.', '90043000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', 19162),
        (78, '$intnumer', 1, 'Transportion', 97, '.97.78.', '90044000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', 21149),
        (79, '$intnumer', 1, 'Office Consumables', 57, '.79.', '90059100', 0, 1, 1, 5, NULL, NULL, 0, '0.00', 5492),
        (80, '$intnumer', 1, 'Audit Fee', 63, '.80.', '90056000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', NULL),
        (81, '$intnumer', 1, 'Legal Fee', 63, '.81.', '90057000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', 14568),
        (82, '$intnumer', 1, 'Professional and Consultancy fee', 63, '.82.', '90054000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', 17956),
        (83, '$intnumer', 1, 'Telephone and Communications', 97, '.97.83.', '90046000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', 21042),
        (85, '$intnumer', 1, 'DTA Expenses', 97, '.97.85.', '90045000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', NULL),
        (86, '$intnumer', 1, 'Annual Subscription', 63, '.86.', '90051000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', NULL),
        (87, '$intnumer', 1, 'Registration and Govt Charges', 63, '.87.', '90055000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', 1569),
        (88, '$intnumer', 1, 'Advertising and Publicity', 63, '.88.', '90052000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', NULL),
        (89, '$intnumer', 1, 'Depreciation of Fixed Assets', 98, '.98.89.', '90081000', 0, 0, 1, 5, NULL, NULL, 0, '0.00', NULL),
        (90, '$intnumer', 1, 'Commission', 91, '.91.90.', '90063000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', NULL),
        (91, '$intnumer', 1, 'OTHER FINACIAL EXPENSES', 63, '.91.', '90060000', 0, 0, 2, 5, NULL, NULL, 0, '0.00', NULL),
        (92, '$intnumer', 1, 'NDIC Premium', 91, '.91.92.', '90062000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', NULL),
        (93, '$intnumer', 1, 'Furniture and Fittings Repairs', 97, '.97.93.', '90049200', 0, 1, 1, 5, NULL, NULL, 0, '0.00', 6303),
        (94, '$intnumer', 1, 'Penalty Charges', 63, '.94.', '90058000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', NULL),
        (95, '$intnumer', 1, 'Office Equip Repairs', 97, '.97.95.', '90049400', 0, 1, 1, 5, NULL, NULL, 0, '0.00', 19164),
        (96, '$intnumer', 1, 'Plant and Machinery Repairs', 97, '.97.96.', '90049000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', NULL),
        (97, '$intnumer', 1, 'OVERHEAD EXPENSES', 63, '.97.', '90040000', 0, 1, 2, 5, NULL, NULL, 0, '0.00', NULL),
        (98, '$intnumer', 1, 'DEPRECIATION & AMORTIZATION', 63, '.98.', '90080000', 0, 0, 2, 5, NULL, NULL, 0, '0.00', NULL),
        (99, '$intnumer', 1, 'OTHER NON OPERATING INCOME', 53, '.99.', '80040000', 0, 0, 2, 4, NULL, NULL, 0, '0.00', NULL),
        (100, '$intnumer', 1, 'Cash Donations', 99, '.99.100.', '80041000', 0, 1, 1, 4, NULL, NULL, 0, '0.00', NULL),
        (101, '$intnumer', 1, 'Other Non Operational Income', 99, '.99.101.', '80042000', 0, 1, 1, 4, NULL, NULL, 0, '0.00', NULL),
        (102, '$intnumer', 1, 'DG Micro Loans', 13, '.102.', '10061000', 0, 1, 1, 1, NULL, NULL, 0, '0.00', 23210),
        (104, '$intnumer', 1, 'Overdraft', 13, '.104.', '10067000', 0, 0, 1, 1, NULL, NULL, 0, '0.00', 22800),
        (105, '$intnumer', 1, 'Office Rent', 97, '.97.105.', '90041000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', 12048),
        (106, '$intnumer', 1, 'Office Entertainment ', 63, '.106.', '90059000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', 11942),
        (108, '$intnumer', 1, 'Motor vehicle Repairs', 97, '.97.108.', '90048000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', 18853),
        (109, '$intnumer', 1, 'Postage', 97, '.97.109.', '90049600', 0, 1, 1, 5, NULL, NULL, 0, '0.00', NULL),
        (111, '$intnumer', 1, 'General Repairs and Maintenance', 97, '.97.111.', '90049300', 0, 1, 1, 5, NULL, NULL, 0, '0.00', 18845),
        (112, '$intnumer', 1, 'Bank Charges', 91, '.91.112.', '90061000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', 6674),
        (113, '$intnumer', 1, 'DIRECTORS COST', 63, '.113.', '90030000', 0, 0, 2, 5, NULL, NULL, 0, '0.00', NULL),
        (114, '$intnumer', 1, 'Interest Accrued not Paid', 178, '.114.', '20043000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', 5495),
        (116, '$intnumer', 1, 'FCMB', 5, '.116.', '10021000', 0, 1, 1, 1, NULL, NULL, 1, '0.00', NULL),
        (117, '$intnumer', 1, 'Fidelity Bank', 5, '.117.', '10022000', 0, 1, 1, 1, NULL, NULL, 1, '0.00', 18186),
        (118, '$intnumer', 1, 'Teller Differences', 1, '.118.', '10013000', 0, 1, 1, 1, NULL, NULL, 0, '0.00', 646),
        (119, '$intnumer', 1, 'First Bank Plc', 5, '.119.', '10023000', 0, 1, 1, 1, NULL, NULL, 1, '0.00', NULL),
        (120, '$intnumer', 1, 'UBA', 5, '.120.', '10024000', 0, 1, 1, 1, NULL, NULL, 1, '0.00', NULL),
        (121, '$intnumer', 1, 'Access Bank Plc', 5, '.121.', '10025000', 0, 1, 1, 1, NULL, NULL, 1, '0.00', NULL),
        (122, '$intnumer', 1, 'Lease Advances', 13, '.122.', '10066000', 0, 1, 1, 1, NULL, NULL, 0, '0.00', NULL),
        (123, '$intnumer', 1, 'DG Staff Loan', 13, '.123.', '10065000', 0, 1, 1, 1, NULL, NULL, 0, '0.00', NULL),
        (124, '$intnumer', 1, 'Hire Purchase', 13, '.124.', '10064000', 0, 1, 1, 1, NULL, NULL, 0, '0.00', NULL),
        (125, '$intnumer', 1, 'Voluntary Savings', 23, '.23.125.', '20012000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', 23109),
        (126, '$intnumer', 1, 'Demand Deposit', 23, '.23.126.', '20011000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', 22858),
        (127, '$intnumer', 1, 'Time/Term Deposit', 23, '.23.127.', '20014000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', 22855),
        (128, '$intnumer', 1, 'Provision for other losses', 178, '.128.', '20049100', 0, 1, 1, 2, NULL, NULL, 0, '0.00', 6305),
        (129, '$intnumer', 1, 'Other Deposits', 23, '.23.129.', '20015000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', 22781),
        (130, '$intnumer', 1, 'Escheat Control Account', 25, '.130.', '20080000', 0, 0, 1, 2, NULL, NULL, 0, '0.00', 20849),
        (131, '$intnumer', 1, 'Bills Discounted Income', 54, '.54.131.', '80013000', 0, 1, 1, 4, NULL, NULL, 0, '0.00', NULL),
        (132, '$intnumer', 1, 'Micro Loan Interest Income', 54, '.54.132.', '80011000', 0, 1, 1, 4, NULL, NULL, 0, '0.00', 23211),
        (133, '$intnumer', 1, 'Hire Purchase Income', 54, '.54.133.', '80014000', 0, 1, 1, 4, NULL, NULL, 0, '0.00', NULL),
        (134, '$intnumer', 1, 'Staff Loan Income ', 54, '.54.134.', '80015000', 0, 1, 1, 4, NULL, NULL, 0, '0.00', NULL),
        (135, '$intnumer', 1, 'Micro Small & Medium  Enterprise  Loan Income', 54, '.54.135.', '80012000', 0, 0, 1, 4, NULL, NULL, 0, '0.00', NULL),
        (136, '$intnumer', 1, 'Lease Advances Income', 54, '.54.136.', '80016000', 0, 1, 1, 4, NULL, NULL, 0, '0.00', NULL),
        (137, '$intnumer', 1, 'Fees: Legal', 198, '.137.', '80021000', 0, 0, 1, 4, NULL, NULL, 0, '0.00', 10172),
        (138, '$intnumer', 1, 'Loan MONITORING Fees', 198, '.138.', '80022000', 0, 1, 1, 4, NULL, 'Loan MONITORING', 0, '0.00', 9680),
        (139, '$intnumer', 1, 'Loan Application Income', 198, '.139.', '80023000', 0, 1, 1, 4, NULL, NULL, 0, '0.00', 10180),
        (140, '$intnumer', 1, 'Insurance Income', 198, '.140.', '80024000', 0, 1, 1, 4, NULL, NULL, 0, '0.00', 10176),
        (141, '$intnumer', 1, 'Loan Processing Income', 198, '.141.', '80025000', 0, 1, 1, 4, NULL, NULL, 0, '0.00', 10168),
        (142, '$intnumer', 1, 'SMS Alert', 62, '.62.142.', '80031000', 0, 0, 1, 4, NULL, NULL, 0, '0.00', 22801),
        (143, '$intnumer', 1, 'Stamp Duty', 62, '.62.143.', '80033000', 0, 1, 1, 4, NULL, NULL, 0, '0.00', 11859),
        (144, '$intnumer', 1, 'Account Maintainance', 62, '.62.144.', '80034000', 0, 1, 1, 4, NULL, NULL, 0, '0.00', 22787),
        (145, '$intnumer', 1, 'Charges on Pass Book', 198, '.145.', '80027000', 0, 1, 1, 4, NULL, NULL, 0, '0.00', 23191),
        (146, '$intnumer', 1, 'Charges on Cheque', 198, '.146.', '80028000', 0, 1, 1, 4, NULL, NULL, 0, '0.00', 21315),
        (147, '$intnumer', 1, 'Overdraft Income', 54, '.54.147.', '80017000', 0, 1, 1, 4, NULL, NULL, 0, '0.00', NULL),
        (149, '$intnumer', 1, 'Deposit for Shares', 178, '.149.', '20049300', 0, 1, 1, 2, NULL, NULL, 0, '0.00', 23208),
        (150, '$intnumer', 1, 'System Reconciliation Account', 25, '.150.', '20091000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', 303),
        (151, '$intnumer', 1, 'Preference Shares', 47, '.151.', '50030000', 0, 1, 1, 3, NULL, NULL, 0, '0.00', 12971),
        (152, '$intnumer', 1, 'Suspense Account', 178, '.152.', '20049000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', 467),
        (153, '$intnumer', 1, 'Security Guards', 63, '.153.', '90053000', 0, 0, 1, 5, NULL, NULL, 0, '0.00', NULL),
        (154, '$intnumer', 1, 'ACCT Re-activation Fees', 62, '.62.154.', '80035000', 0, 0, 1, 4, NULL, NULL, 0, '0.00', 18261),
        (155, '$intnumer', 1, 'Shares Control', 25, '.155.', '20070000', 0, 0, 1, 2, NULL, NULL, 0, '0.00', 10272),
        (156, '$intnumer', 1, 'Account Payable', 178, '.156.', '20041000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', 3808),
        (157, '$intnumer', 1, 'Stationery', 57, '.157.', '10076000', 0, 0, 1, 5, NULL, NULL, 0, '0.00', NULL),
        (158, '$intnumer', 1, 'Cheque for Collection / Transit Item', 7, '.158.', '10073000', 0, 0, 1, 1, NULL, NULL, 0, '0.00', NULL),
        (161, '$intnumer', 1, 'Suspense Account', 7, '.161.', '10078000', 0, 0, 1, 1, NULL, NULL, 0, '0.00', NULL),
        (163, '$intnumer', 1, 'Mandatory Savings', 23, '.23.163.', '20013000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', 23190),
        (164, '$intnumer', 1, 'Unearned Income', 178, '.164.', '20042000', 0, 0, 1, 2, NULL, NULL, 0, '0.00', 6354),
        (165, '$intnumer', 1, 'INTEREST EXPENSE', 0, '.', '90010000', 0, 0, 2, 5, NULL, NULL, 0, '0.00', NULL),
        (166, '$intnumer', 1, 'Placements', 0, '.', '10030000', 0, 0, 2, 1, NULL, NULL, 0, '0.00', NULL),
        (167, '$intnumer', 1, 'Secured With Treasury Bills', 166, '.167.', '10031000', 0, 0, 1, 1, NULL, NULL, 0, '0.00', NULL),
        (168, '$intnumer', 1, 'Unsecured ', 166, '.168.', '10032000', 0, 0, 1, 1, NULL, NULL, 0, '0.00', NULL),
        (169, '$intnumer', 1, 'Quoted Companies', 12, '.12.169.', '10051000', 0, 0, 1, 1, NULL, NULL, 0, '0.00', NULL),
        (170, '$intnumer', 1, 'Unquoted Companies', 12, '.12.170.', '10052000', 0, 0, 1, 1, NULL, NULL, 0, '0.00', NULL),
        (171, '$intnumer', 1, 'Sunsidaries Companies', 12, '.12.171.', '10053000', 0, 0, 1, 1, NULL, NULL, 0, '0.00', NULL),
        (172, '$intnumer', 1, 'Others', 12, '.12.172.', '10054000', 0, 0, 1, 1, NULL, NULL, 0, '0.00', NULL),
        (173, '$intnumer', 1, 'Account Recievable ', 7, '.173.', '10071000', 0, 0, 1, 1, NULL, NULL, 0, '0.00', NULL),
        (174, '$intnumer', 1, 'Accrued Interest', 7, '.174.', '10072000', 0, 0, 1, 1, NULL, NULL, 0, '0.00', NULL),
        (176, '$intnumer', 1, 'Prepaid Interest', 7, '.176.', '10074000', 0, 0, 1, 1, NULL, NULL, 0, '0.00', NULL),
        (177, '$intnumer', 1, 'Goodwill & Other Intangible Assets', 7, '.177.', '10079000', 0, 0, 1, 1, NULL, NULL, 0, '0.00', NULL),
        (178, '$intnumer', 1, 'OTHER LIABILITIES', 0, '.', '20040000', 0, 0, 2, 2, NULL, NULL, 0, '0.00', NULL),
        (179, '$intnumer', 1, 'Dividends Payable', 178, '.179.', '20049200', 0, 0, 1, 2, NULL, NULL, 0, '0.00', NULL),
        (180, '$intnumer', 1, 'BORROWINGS ON-LENDING', 0, '.', '20050000', 0, 1, 2, 2, NULL, NULL, 0, '0.00', NULL),
        (181, '$intnumer', 1, 'FGN', 180, '.181.', '20051000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', NULL),
        (182, '$intnumer', 1, 'State Government', 180, '.182.', '20052000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', 21143),
        (183, '$intnumer', 1, 'LGA', 180, '.183.', '20054000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', 16038),
        (184, '$intnumer', 1, 'Foreign Agencies', 180, '.184.', '20055000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', NULL),
        (185, '$intnumer', 1, 'Others', 180, '.185.', '20056000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', NULL),
        (186, '$intnumer', 1, 'Pass & Watch (1 - 30 days)', 67, '.67.186.', '40010000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', NULL),
        (187, '$intnumer', 1, 'Sub-Standard (31 - 60 days)', 67, '.67.187.', '40020000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', NULL),
        (188, '$intnumer', 1, 'Doubtful (61 - 90 days)', 67, '.67.188.', '40030000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', NULL),
        (189, '$intnumer', 1, 'Lost (91 days & Above)', 67, '.67.189.', '40040000', 0, 1, 1, 2, NULL, NULL, 0, '0.00', NULL),
        (190, '$intnumer', 1, 'Authorized Share captial', 47, '.190.', '50010000', 0, 1, 1, 3, NULL, NULL, 0, '0.00', NULL),
        (191, '$intnumer', 1, 'RESERVES', 0, '.', '60000000', 0, 0, 2, 3, NULL, NULL, 0, '0.00', NULL),
        (192, '$intnumer', 1, 'Statutory Reserve', 191, '.192.', '60010000', 0, 1, 1, 3, NULL, NULL, 0, '0.00', NULL),
        (194, '$intnumer', 1, 'Deferred Grant/donation Reserve', 191, '.194.', '60040000', 0, 1, 1, 3, NULL, NULL, 0, '0.00', NULL),
        (195, '$intnumer', 1, 'Bonus Reserve', 191, '.195.', '60050000', 0, 1, 1, 3, NULL, NULL, 0, '0.00', NULL),
        (196, '$intnumer', 1, 'Revaluation Reserves', 191, '.196.', '60060000', 0, 1, 1, 3, NULL, NULL, 0, '0.00', NULL),
        (197, '$intnumer', 1, 'OFF-BALANCE SHEET ENGAGEMENT', 191, '.197.', '70000000', 0, 1, 1, 3, NULL, NULL, 0, '0.00', NULL),
        (198, '$intnumer', 1, 'FEES & CHARGES', 0, '.', '80020000', 0, 0, 2, 4, NULL, NULL, 0, '0.00', NULL),
        (199, '$intnumer', 1, 'Savings Interest', 165, '.199.', '90012000', 0, 0, 1, 5, NULL, NULL, 0, '0.00', 7465),
        (200, '$intnumer', 1, 'Internet Subscription', 97, '.97.200.', '90049500', 0, 1, 1, 5, NULL, NULL, 0, '0.00', 17292),
        (201, '$intnumer', 1, 'WRITE OFF', 0, '.', '90070000', 0, 0, 2, 5, NULL, NULL, 0, '0.00', NULL),
        (202, '$intnumer', 1, 'Provision for bad debt', 201, '.202.', '90072000', 0, 1, 1, 5, NULL, NULL, 0, '0.00', NULL),
        (203, '$intnumer', 1, 'Transfer Wallet', 1, '.162.1.203.', '10013100', 0, 1, 1, 1, NULL, NULL, 0, '0.00', 14565),
        (204, '$intnumer', 1, 'One Day Charge', 198, '.204.', '80028001', 0, 1, 1, 4, NULL, NULL, 0, '0.00', 19115),
        (398, '$intnumer', 1, 'INTERNET, SUBSCRIPTION AND WEB SEVICES', 0, NULL, '52750', NULL, 1, 1, 5, NULL, 'Internet subscr', 1, '0.00', NULL),
        (399, '$intnumer', 1, 'OFFICE REPAIRS', 0, NULL, '59089', NULL, 1, 1, 5, NULL, 'Office repairs', 1, '0.00', NULL),
        (400, '$intnumer', 1, 'VEHICLE REPAIRS', 0, NULL, '57703', NULL, 1, 1, 5, NULL, 'Vehicle repairs', 1, '0.00', NULL),
        (402, '$intnumer', 1, 'SALARIES ARREARS', 0, NULL, '24786', NULL, 1, 1, 2, NULL, 'SALARY', 0, '0.00', NULL),
        (408, '$intnumer', 1, 'BVN Search', 53, NULL, '45588', NULL, 1, 1, 4, NULL, '', 0, '0.00', NULL);
        ";
        $ed = mysqli_query($connection, $acc_gl_list);
    }
    if ($ed) {
        echo header("Location: ../institution.php");
    } else {
        echo "oboy";
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