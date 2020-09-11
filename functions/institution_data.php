<?php
// here i am going to add the connection
include("connect.php");
session_start();
?>
<!-- another for inputting the data -->
<?php
$int_name = $_POST['int_name'];
$int_full = $_POST['int_full'];
$ingram = $_POST['ingram'];
$tweet = $_POST['tweet'];
$face = $_POST['face'];
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
$sender_id = $_POST['sender_id'];
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

$query = "INSERT INTO institutions (int_name, int_full, rcn, lga, int_state, email,
office_address, incorporation_date, website, office_phone, pc_title, pc_surname, pc_other_name,
pc_designation, pc_phone, pc_email, img, sender_id, facebook, twitter, instagram) VALUES ('{$int_name}','{$int_full}','{$rcn}',
'{$lga}', '{$int_state}', '{$email}', '{$office_address}', '{$submitted_on}', '{$website}', '{$office_phone}',
'{$pc_title}', '{$pc_surname}', '{$pc_other_name}', '{$pc_designation}',
'{$pc_phone}', '{$pc_email}', '{$imagex}', '{$sender_id}', '{$face}', '{$tweet}', '{$ingram}')";
// add
$result = mysqli_query($connection, $query);
if ($result) {
    $dsf = mysqli_query($connection, "SELECT * FROM institutions WHERE int_name = '$int_name'");
    $df = mysqli_fetch_array($dsf);
    $intid = $df['int_id'];
    $foi = "INSERT INTO `branch` (`int_id`, `parent_id`, `opening_date`, `name`, `email`, `state`, `lga`, `location`,`phone`)
     VALUES ('{$intid}','0', '{$submitted_on}', 'Head Office', '{$int_state}', '{$lga}', '{$email}', '{$office_address}', '{$office_phone}')";
    $foia = mysqli_query($connection, $foi);
    // vault for the branch
    $brna = mysqli_query($connection, "SELECT * FROM branch WHERE int_id = '$intid' AND name = 'Head Office'");
    $gom = mysqli_fetch_array($brna);
    $br_id = $gom['id']; 
        $mvamt = 10000000.00;
        $bal = 0.00;
        $queryx = "INSERT INTO int_vault (int_id, branch_id, movable_amount, balance, date, last_withdrawal, last_deposit, gl_code) VALUES ('{$intid}',
    '{$br_id}', '{$mvamt}', '{$bal}', '{$submitted_on}', '{$bal}', '{$bal}', '{$incomegl}')";
    $gogoo = mysqli_query($connection, $queryx);

    if($gogoo){
    $riedfoifo = "INSERT INTO `org_role` (`int_id`, `role`, `description`, `permission`)
   VALUES ('{$intid}', 'super user', '', '1')";
  $fdrty = mysqli_query($connection, $riedfoifo);
    if($fdrty){
    $dsid = "SELECT * FROM org_role WHERE int_id = '$intid' AND role = 'super user'";
    $perv = mysqli_query($connection, $dsid);
    $di = mysqli_fetch_array($perv);
    $org_ole = $di['id'];

    $fdopf = "INSERT INTO `permission` (`int_id`, `role_id`, `acc_op`, `acc_update`, `trans_appv`, `trans_post`, `loan_appv`, `acct_appv`,
        `staff_cabal`, `valut`, `vault_email`, `view_report`, `view_dashboard`, `configuration`, `bills`) 
        VALUES ('$intid', '$org_ole', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1')";
        $fdpoijf = mysqli_query($connection, $fdopf);
if($fdpoijf){
    // Cash Balances GL
    $cash = "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
            ('$intid', 1, '$br_id', 'CASH BALANCES', 0, NULL, '10100', 0, 0, 2, 1, NULL, 'CASH BALANCES', 0, 0.00, NULL)";
    $balf = mysqli_query($connection, $cash);
    if($balf){
        $diis = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$intid' AND name = 'CASH BALANCES'");
        $as = mysqli_fetch_array($diis);
        $pid = $as['id'];
        $fdop = mysqli_query($connection, 
        "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
        ('$intid', 0, 20, 'MAIN VAULT', '$pid', NULL, '10101', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
        ('$intid', 0, 20, 'TELLER FUNDS', '$pid', NULL, '10102', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
        ('$intid', 0, 20, 'CASH', '$pid', NULL, '10103', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
        ('$intid', 0, 20, 'SUSPENSE INCOME', '$pid', NULL, '10104', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL)
        ");
    }

        // dues from bank
        $cash = "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
        ('$intid', 2, '$br_id', 'DUES FROM BANK', 0, NULL, '10200', 0, 0, 2, 1, NULL, '', 0, 0.00, NULL)";
    $balf = mysqli_query($connection, $cash);
    if($balf){
    $diis = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$intid' AND name = 'DUES FROM BANK'");
    $as = mysqli_fetch_array($diis);
    $pid = $as['id'];
    $fdop = mysqli_query($connection, 
    "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
    ('$intid', 0, '$br_id', 'ECO BANK', '$pid', NULL, '10201', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '$br_id', 'GUARANTEE TRUST BANK', '$pid', NULL, '10202', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '$br_id', 'FIRST BANK', '$pid', NULL, '10203', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '$br_id', 'WEMA BANK', '$pid', NULL, '10204', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '$br_id', 'SKYE BANK', '$pid', NULL, '10205', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '$br_id', 'FCMB', '$pid', NULL, '10206', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL)
    ");
}

    // PREPAYMENT
    $cash = "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
            ('$intid', 3, '$br_id', 'PREPAYMENT', 0, NULL, '10300', 0, 0, 2, 1, NULL, '', 0, 0.00, NULL)";
    $balf = mysqli_query($connection, $cash);
    if($balf){
        $diis = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$intid' AND name = 'PREPAYMENT'");
        $as = mysqli_fetch_array($diis);
        $pid = $as['id'];
        $fdop = mysqli_query($connection, 
        "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
        ('$intid', 0, '$br_id', 'RENT PREPAYMENT', '$pid', NULL, '10301', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
        ('$intid', 0, '$br_id', 'INSURANCE', '$pid', NULL, '10302', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
        ('$intid', 0, '$br_id', 'other prepayment', '$pid', NULL, '10303', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL)
        ");
    }

        // SHORT TERM INVESTMENT
        $cash = "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
        ('$intid', 4, '$br_id', 'SHORT TERM INVESTMENT', 0, NULL, '10400', 0, 0, 2, 1, NULL, '', 0, 0.00, NULL)";
    $balf = mysqli_query($connection, $cash);
    if($balf){
    $diis = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$intid' AND name = 'SHORT TERM INVESTMENT'");
    $as = mysqli_fetch_array($diis);
    $pid = $as['id'];
    $fdop = mysqli_query($connection, 
    "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
    ('$intid', 0, '$br_id', 'TREASURY BILLS', '$pid', NULL, '10401', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL)
    ");
}

    // LOANS AND ADVANCES/LEASES
    $cash = "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
    ('$intid', 5, '$br_id', 'LOANS AND ADVANCES/LEASES', 0, NULL, '10500', 0, 0, 2, 1, NULL, '', 0, 0.00, NULL)";
    $balf = mysqli_query($connection, $cash);
    if($balf){
        $diis = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$intid' AND name = 'LOANS AND ADVANCES/LEASES'");
        $as = mysqli_fetch_array($diis);
        $pid = $as['id'];
        $fdop = mysqli_query($connection, 
        "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
        ('$intid', 0, '$br_id', 'Micro loans', '$pid', NULL, '10501', 0, 0, 1, 1, NULL, '', 0, 0.00, NULL),
        ('$intid', 0, '$br_id', 'Small & Medium Enterprise Loans', '$pid', NULL, '10502', 0, 0, 1, 1, NULL, '', 0, 0.00, NULL)
        ");
    }

        // NON CURRENT ASSET
        $cash = "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
        ('$intid', 6, '$br_id', 'NON CURRENT ASSET', 0, NULL, '10600', 0, 0, 2, 1, NULL, '', 0, 0.00, NULL)";
    $balf = mysqli_query($connection, $cash);
    if($balf){
    $diis = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$intid' AND name = 'NON CURRENT ASSET'");
    $as = mysqli_fetch_array($diis);
    $pid = $as['id'];
    $fdop = mysqli_query($connection, 
    "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
    ('$intid', 0, '$br_id', 'freehold LAND AND BUILDING', '$pid', NULL, '10601', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '$br_id', 'LEASEHOLD land & building', '$pid', NULL, '10602', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '$br_id', 'FURNITURE AND FITTINGS', '$pid', NULL, '10603', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '$br_id', 'MOTOR VEHICLE', '$pid', NULL, '10604', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '$br_id', 'OFFICE EQUIPMENT', '$pid', NULL, '10605', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '$br_id', 'PLANT AND MaCHINeRY', '$pid', NULL, '10606', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '$br_id', 'accumulated depreciation', '$pid', NULL, '10607', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '$br_id', 'Account recievable', '$pid', NULL, '10608', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '$br_id', 'Accrued interest recievable', '$pid', NULL, '10609', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '$br_id', 'inventory', '$pid', NULL, '10610', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '$br_id', 'suspense account', '$pid', NULL, '10611', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '$br_id', 'Goodwill and Other Intangible Assets', '$pid', NULL, '10612', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '$br_id', 'Specific Loan/Lease Loss Provision', '$pid', NULL, '10613', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '$br_id', 'Accumulate Depreciation', '$pid', NULL, '10614', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL)
    ");
}
    // Other Asset
    $cash = "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
    ('$intid', 7, '$br_id', 'OTHER ASSET', 0, NULL, '10700', 0, 0, 2, 1, NULL, '', 0, 0.00, NULL)";
    $balf = mysqli_query($connection, $cash);
    if($balf){
        $diis = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$intid' AND name = 'OTHER ASSET'");
        $as = mysqli_fetch_array($diis);
        $pid = $as['id'];
        $fdop = mysqli_query($connection, 
        "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
        ('$intid', 0, '$br_id', 'Insufficient Repayment', '$pid', NULL, '10701', 0, 0, 1, 2, NULL, '', 0, 0.00, NULL)
        ");
    }
    // deposits
    $cash = "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
            ('$intid', 1, '$br_id', 'DEPOSITS', 0, NULL, '20100', 0, 0, 2, 2, NULL, '', 0, 0.00, NULL)";
    $balf = mysqli_query($connection, $cash);
    if($balf){
        $diis = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$intid' AND name = 'DEPOSITS'");
        $as = mysqli_fetch_array($diis);
        $pid = $as['id'];
        $fdop = mysqli_query($connection, 
        "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
        ('$intid', 0, '$br_id', 'Demand deposit', '$pid', NULL, '20101', 0, 0, 1, 2, NULL, '', 0, 0.00, NULL),
        ('$intid', 0, '$br_id', 'mandatory deposit', '$pid', NULL, '20102', 0, 1, 1, 2, NULL, '', 0, 0.00, NULL),
        ('$intid', 0, '$br_id', 'voluntary savings deposit', '$pid', NULL, '20103', 0, 0, 1, 2, NULL, 'VOLUNTARY SAVINGS DEPOSIT', 0, 0.00, NULL),
        ('$intid', 0, '$br_id', 'Time/term deposit', '$pid', NULL, '20104', 0, 0, 1, 2, NULL, '', 0, 0.00, NULL),
        ('$intid', 0, '$br_id', 'LOANS FROM OTHER BANKS', '$pid', NULL, '20105', 0, 1, 1, 2, NULL, '', 0, 0.00, NULL),
        ('$intid', 0, '$br_id', 'LOANS FROM DIRECTORS', '$pid', NULL, '20106', 0, 1, 1, 2, NULL, '', 0, 0.00, NULL),
        ('$intid', 0, '$br_id', 'deposit FROM government agency for on-lending', '$pid', NULL, '20107', 0, 1, 1, 2, NULL, '', 0, 0.00, NULL)
        ");
    }
        // non-current liability
        $cash = "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
        ('$intid', 2, '$br_id', 'NON CURRENT LIABILITY', 0, NULL, '20200', 0, 0, 2, 2, NULL, '', 0, 0.00, NULL)";
    $balf = mysqli_query($connection, $cash);
    if($balf){
    $diis = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$intid' AND name = 'NON CURRENT LIABILITY'");
    $as = mysqli_fetch_array($diis);
    $pid = $as['id'];
    $fdop = mysqli_query($connection, 
    "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
    ('$intid', 0, '$br_id', 'Account payable', '$pid', NULL, '20201', 0, 1, 1, 2, NULL, '', 0, 0.00, NULL)
    ");
}

        // Capital
        $cash = "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
        ('$intid', 1, '$br_id', 'Capital', 0, NULL, '30100', 0, 0, 2, 3, NULL, '', 0, 0.00, NULL)";
    $balf = mysqli_query($connection, $cash);
    if($balf){
    $diis = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$intid' AND name = 'Capital'");
    $as = mysqli_fetch_array($diis);
    $pid = $as['id'];
    $fdop = mysqli_query($connection, 
    "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
    ('$intid', 0, '$br_id', 'Authorized Share Capital', '$pid', NULL, '30101', 0, 0, 1, 3, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '$br_id', 'Issued & fully paid', '$pid', NULL, '30102', 0, 0, 1, 3, NULL, '', 0, 0.00, NULL)
    ");
}

    // reserves
    $cash = "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
            ('$intid', 2, '$br_id', 'RESERVES', 0, NULL, '30200', 0, 0, 2, 3, NULL, '', 0, 0.00, NULL)";
    $balf = mysqli_query($connection, $cash);
    if($balf){
        $diis = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$intid' AND name = 'RESERVES'");
        $as = mysqli_fetch_array($diis);
        $pid = $as['id'];
        $fdop = mysqli_query($connection, 
        "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
        ('$intid', 0, '$br_id', 'General Reserves', '$pid', NULL, '30201', 0, 0, 1, 3, NULL, '', 0, 0.00, NULL),
        ('$intid', 0, '$br_id', 'Retained profit/loss', '$pid', NULL, '30202', 0, 0, 1, 3, NULL, '', 0, 0.00, NULL)
        ");
    }

        // OPERATING INCOME
        $cash = "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
        ('$intid', 1, '$br_id', 'OPERATING INCOME', 0, NULL, '40100', 0, 0, 2, 4, NULL, '', 0, 0.00, NULL)";
    $balf = mysqli_query($connection, $cash);
    if($balf){
    $diis = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$intid' AND name = 'OPERATING INCOME'");
    $as = mysqli_fetch_array($diis);
    $pid = $as['id'];
    $fdop = mysqli_query($connection, 
    "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
    ('$intid', 0, '$br_id', 'Interest income', '$pid', NULL, '40101', 0, 0, 1, 4, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '$br_id', 'fees/charges income', '$pid', NULL, '40102', 0, 1, 1, 4, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '$br_id', 'income from other investment', '$pid', NULL, '40103', 0, 1, 1, 4, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '$br_id', 'Recovery Income', '$pid', NULL, '40104', 0, 1, 1, 4, NULL, '', 0, 0.00, NULL)
    ");
}
        // Personnel expense
        $cash = "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
        ('$intid', 1, '$br_id', 'PERSONNEL EXPENSE', 0, NULL, '50100', 0, 0, 2, 2, NULL, '', 0, 0.00, NULL)";
    $balf = mysqli_query($connection, $cash);
    if($balf){
        $diis = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$intid' AND name = 'PERSONNEL EXPENSE'");
        $as = mysqli_fetch_array($diis);
        $pid = $as['id'];
        $fdop = mysqli_query($connection, 
        "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
        ('$int_id', 0, '$br_id', 'SALARIES, WAGES AND ALLOWANCES', '$pid', NULL, '50101', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
        ('$int_id', 0, '$br_id', 'interest expense', '$pid', NULL, '50102', 0, 0, 1, 5, NULL, '', 0, 0.00, NULL),
        ('$int_id', 0, '$br_id', 'BVN SEARCH', '$pid', NULL, '50105', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
        ('$int_id', 0, '$br_id', 'ELECTRICITY AND OTHER  Utilities  EXPENSES', '$pid', NULL, '50107', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
        ('$int_id', 0, '$br_id', 'STATIONERies', '$pid', NULL, '50109', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
        ('$int_id', 0, '$br_id', 'PRINTING', '$pid', NULL, '50111', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
        ('$int_id', 0, '$br_id', 'OFFICE BUILDING REPAIRS', '$pid', NULL, '50114', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
        ('$int_id', 0, '$br_id', 'PLANT AND MACHINERY REPAIRS', '$pid', NULL, '50115', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
        ('$int_id', 0, '$br_id', 'INTEREST WRITE OFF', '$pid', NULL, '50116', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
        ('$int_id', 0, '$br_id', 'FURNITURE AND FITTINGS REPAIRS', '$pid', NULL, '50117', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
        ('$int_id', 0, '$br_id', 'OFFICE EQUIP REPAIRS', '$pid', NULL, '50118', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
        ('$int_id', 0, '$br_id', 'Government dues & subscriptions', '$pid', NULL, '50119', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
        ('$int_id', 0, '$br_id', 'DIRECTORS COST', '$pid', NULL, '50120', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
        ('$int_id', 0, '$br_id', 'loan WRITe OFF', '$pid', NULL, '50125', 0, 0, 1, 5, NULL, '', 0, 0.00, NULL),
        ('$int_id', 0, '$br_id', 'Productivity Bonus', '$pid', NULL, '50129', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
        ('$int_id', 0, '$br_id', '13th month', '$pid', NULL, '50130', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
        ('$int_id', 0, '$br_id', ' Staff Welfare', '$pid', NULL, '50131', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
        ('$int_id', 0, '$br_id', 'staff Medicals', '$pid', NULL, '50132', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL)
        ");
    }
        // Administrative expense
        $cash = "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
            ('$intid', 2, '$br_id', 'ADMINISTRATIVE EXPENSE', 0, NULL, '50200', 0, 0, 2, 2, NULL, '', 0, 0.00, NULL)";
        $balf = mysqli_query($connection, $cash);
        if($balf){
            $diis = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$intid' AND name = 'ADMINISTRATIVE EXPENSE'");
            $as = mysqli_fetch_array($diis);
            $pid = $as['id'];
            $fdop = mysqli_query($connection, 
            "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
                ('$intid', 0, '$br_id', 'oFFICE RENT', '$pid', NULL, '50201', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
                ('$intid', 0, '$br_id', 'POSTAGE', '$pid', NULL, '50204', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
                ('$intid', 0, '$br_id', 'FUELING AND LUBRICANT', '$pid', NULL, '50208', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
                ('$intid', 0, '$br_id', 'Internet Subscription', '$pid', NULL, '50228', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
                ('$intid', 0, '$br_id', 'TELEPHONE AND COMMUNICATIONS', '$pid', NULL, '50220', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
                ('$intid', 0, '$br_id', 'PROFESSIONAL AND CONSULTANCY FEE', '$pid', NULL, '50219', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
                ('$intid', 0, '$br_id', 'VEHICLE REPAIRS', '$pid', NULL, '50203', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
                ('$intid', 0, '$br_id', 'LEGAL FEE', '$pid', NULL, '50217', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
                ('$intid', 0, '$br_id', 'OFFICE ENTERTAINMENT', '$pid', NULL, '50202', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
                ('$intid', 0, '$br_id', 'Pre-incorporation & post-incorporation', '$pid', NULL, '50425', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
                ('$intid', 0, '$br_id', 'DEPRECIATION OF FIXED ASSETS', '$pid', NULL, '50224', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
                ('$intid', 0, '$br_id', 'Software and Hosting Exp', '$pid', NULL, '50221', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
                ('$intid', 0, '$br_id', 'Commission', '$pid', NULL, '50225', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
                ('$intid', 0, '$br_id', 'Cleaning & Toiletries', '$pid', NULL, '50205', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
                ('$intid', 0, '$br_id', 'Local Training', '$pid', NULL, '50206', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
                ('$intid', 0, '$br_id', 'International Training', '$pid', NULL, '50207', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
                ('$intid', 0, '$br_id', 'Loan loss provision Expense', '$pid', NULL, '50209', 0, 0, 1, 5, NULL, '', 0, 0.00, NULL),
                ('$intid', 0, '$br_id', 'Director Expenses', '$pid', NULL, '50210', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
                ('$intid', 0, '$br_id', 'Bad debt witten off', '$pid', NULL, '50211', 0, 0, 1, 5, NULL, '', 0, 0.00, NULL),
                ('$intid', 0, '$br_id', 'Local Transportation	', '$pid', NULL, '50212', 0, 0, 1, 5, NULL, '', 0, 0.00, NULL),
                ('$intid', 0, '$br_id', 'Local Travels', '$pid', NULL, '502'$intid'', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
                ('$intid', 0, '$br_id', 'International Travels', '$pid', NULL, '50214', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
                ('$intid', 0, '$br_id', 'CREDIT BUREAU', '$pid', NULL, '50227', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
                ('$intid', 0, '$br_id', 'Other Administrative Expenses', '$pid', NULL, '50215', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
                ('$intid', 0, '$br_id', 'LEASEHOLD land & building', '$pid', NULL, '50226', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL)
                ");
        }

                // Financial expense
                $cash = "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
                ('$intid', 3, '$br_id', 'FINANCIAL EXPENSE', 0, NULL, '50300', 0, 0, 2, 2, NULL, '', 0, 0.00, NULL)";
            $balf = mysqli_query($connection, $cash);
            if($balf){
                $diis = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$intid' AND name = 'FINANCIAL EXPENSE'");
                $as = mysqli_fetch_array($diis);
                $pid = $as['id'];
                $fdop = mysqli_query($connection, 
                "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
                    ('$int_id', 0, '$br_id', ' Interest Expenses on Borrowing', '$pid', NULL, '50301', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
                    ('$int_id', 0, '$br_id', 'Bank Charges', '$pid', NULL, '50302', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL)
                    ");
            }
    if($fdop){
        $fiweo = "INSERT INTO `asset_type` 
        (`int_id`, `branch_id`, `asset_name`, `depreciation_value`, `total_amount`) VALUES
        ('$intid', '$br_id', 'PLANT & MACHINERY', '5', ''),
        ('$intid', '$br_id', 'MOTOR VEHICLE', '5', ''),
        ('$intid', '$br_id', 'FURNIURE & FITTINGS', '5', ''),
        ('$intid', '$br_id', 'OFFICE EQUIPMENT', '5', ''),
        ('$intid', '$br_id', 'LAND & BUILDING', '6', '');
        ";
        $pore = mysqli_query($connection, $fiweo);
        echo header ("Location: ../institution.php?message1=$randms");
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
    }
    else{
        echo 'problem';
           if ($connection->error) {
            try {   
                throw new Exception("MySQL error $connection->error <br> Query:<br> $query", $mysqli->error);   
            } catch(Exception $e ) {
                echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
                echo nl2br($e->getTraceAsString());
            }
        }
    }
       
} else {
    // Display an error message
    echo "<p>Bad</p>";
}
    }
else{
    echo "<p>insert org role not work</p>";
}
    }
}
else{
    echo "<p>insert institution not work</p>";
}
?>