<?php
// here i am going to add the connection
include("connect.php");
session_start();
?>
<!-- another for inputting the data -->
<?php
$int_name = $_POST['int_name'];
$int_full = $_POST['int_full'];
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
pc_designation, pc_phone, pc_email, img, sender_id) VALUES ('{$int_name}','{$int_full}','{$rcn}',
'{$lga}', '{$int_state}', '{$email}', '{$office_address}', '{$submitted_on}', '{$website}', '{$office_phone}',
'{$pc_title}', '{$pc_surname}', '{$pc_other_name}', '{$pc_designation}',
'{$pc_phone}', '{$pc_email}', '{$imagex}', '{$sender_id}')";
// add
$result = mysqli_query($connection, $query);
if ($result) {
    $dsf = mysqli_query($connection, "SELECT * FROM institutions WHERE int_name = '$int_name'");
    $df = mysqli_fetch_array($dsf);
    $intid = $df['int_id'];
    $foi = "INSERT INTO `branch` (`int_id`, `parent_id`, `opening_date`, `name`, `email`, `state`, `lga`, `location`,`phone`)
     VALUES ('{$intid}','0', '{$submitted_on}', 'Head Office', '{$int_state}', '{$lga}', '{$email}', '{$office_address}', '{$office_phone}')";
    $foia = mysqli_query($connection,$foi);
    // vault for the branch
    $brna = mysqli_query($connection, "SELECT * FROM branch WHERE int_id = '{$ssint_id}' AND name = '{$name}'");
    $gom = mysqli_fetch_array($brna);
    $br_id = $gom['id']; 
        $mvamt = 10000000.00;
        $bal = 0.00;
        $queryx = "INSERT INTO int_vault (int_id, branch_id, movable_amount, balance, date, last_withdrawal, last_deposit, gl_code) VALUES ('{$ssint_id}',
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
    $dos = "INSERT INTO `acc_gl_account` (`int_id`, `int_id_no`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`, `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`, `organization_running_balance_derived`, `last_entry_id_derived`) VALUES
    ('$intid', 1, '{$br_id}', 'CASH BALANCES', 0, NULL, '10100', 0, 1, 2, 1, NULL, 'CASH BALANCES', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'MAIN VAULT', 420, NULL, '10101', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'TELLER FUNDS', 420, NULL, '10102', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'CASH', 420, NULL, '10103', 0, 0, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'FIRST BANK', 500, NULL, '10201', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'WEMA BANK', 500, NULL, '10202', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'SKYE BANK', 500, NULL, '10203', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'ECO BANK', 500, NULL, '10204', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'FCMB', 500, NULL, '10205', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 1, '{$br_id}', 'PREPAYMENT', 0, NULL, '10300', 0, 0, 2, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'RENT PREPAYMENT', 429, NULL, '10301', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'INSURANCE', 429, NULL, '10302', 0, 0, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 1, '{$br_id}', 'SHORT TERM INVESTMENT', 0, NULL, '10400', 0, 0, 2, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'TREASURY BILLS', 432, NULL, '10401', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 1, '{$br_id}', 'LOANS AND ADVANCES/LEASES 	', 0, NULL, '10500', 0, 0, 2, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'Micro loans', 434, NULL, '10501', 0, 0, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'Small & Medium enterprises loan', 434, NULL, '10502', 0, 0, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 1, '{$br_id}', 'NON CURRENT ASSET', 0, NULL, '10600', 0, 0, 2, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'freehold LAND AND BUILDING', 437, NULL, '10601', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'LEASEHOLD land & building', 437, NULL, '10602', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'FURNITURE AND FITTINGS', 437, NULL, '10603', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'MOTOR VEHICLE', 437, NULL, '10604', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'OFFICE EQUIPMENT', 437, NULL, '10605', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'PLANT AND MaCHINeRY', 437, NULL, '10606', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'accumulated depreciation', 437, NULL, '10614', 0, 0, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 1, '{$br_id}', 'deposits', 0, NULL, '20100', 0, 0, 2, 2, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'Demand deposit', 445, NULL, '20101', 0, 0, 1, 2, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'mandatary deposit', 445, NULL, '20102', 0, 0, 1, 2, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'voluntary savings deposit', 445, NULL, '20103', 0, 0, 1, 2, NULL, 'VOLUNTARY SAVINGS DEPOSIT', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'Time/term deposit', 445, NULL, '20104', 0, 0, 1, 2, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'LOANS FROM OTHER BANKS', 445, NULL, '20105', 0, 1, 1, 2, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'LOANS FROM DIRECTORS', 445, NULL, '20106', 0, 1, 1, 2, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'deposit FROM government agency for on-lending', 445, NULL, '20107', 0, 0, 1, 2, NULL, '', 0, 0.00, NULL),
    ('$intid', 1, '{$br_id}', 'Capital', 0, NULL, '30100', 0, 0, 2, 3, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'Authorized Share Capital', 453, NULL, '30101', 0, 0, 1, 3, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'Issued & fully paid', 453, NULL, '30102', 0, 0, 1, 3, NULL, '', 0, 0.00, NULL),
    ('$intid', 2, '{$br_id}', 'reserves', 0, NULL, '30200', 0, 0, 2, 3, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'General Reserves', 456, NULL, '30201', 0, 0, 1, 3, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'Retained profit/loss', 456, NULL, '30202', 0, 0, 1, 3, NULL, '', 0, 0.00, NULL),
    ('$intid', 1, '{$br_id}', 'OPERATING INCOME', 0, NULL, '40100', 0, 0, 2, 4, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'Interest income', 459, NULL, '40101', 0, 0, 1, 4, NULL, '', 0, 0.00, NULL),
    ('$intid', 1, '{$br_id}', 'operating expense', 0, NULL, '50100', 0, 0, 2, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'interest expense', 461, NULL, '50102', 0, 0, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'fees/charges income', 459, NULL, '40102', 0, 1, 1, 4, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'income from other investment', 459, NULL, '40103', 0, 1, 1, 4, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'SALARIES, WAGES AND ALLOWANCES', 461, NULL, '50101', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'oFFICE RENT', 461, NULL, '50103', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'POSTAGE', 461, NULL, '50104', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'BVN SEARCH', 461, NULL, '50105', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 2, '{$br_id}', 'non-current liability', 0, NULL, '20200', 0, 0, 2, 2, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'Account payable', 469, NULL, '20201', 0, 1, 1, 2, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'Account recievable', 437, NULL, '10608', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'Accrued interest recievable', 437, NULL, '10609', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'inventory', 437, NULL, '10610', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'other prepayment', 429, NULL, '10303', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'suspense account', 437, NULL, '10611', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'Goodwill and Other Intangible Assets', 437, NULL, '10612', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'FUELING AND LUBRICANT', 461, NULL, '50106', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'ELECTRICITY AND OTHER  Utilities  EXPENSES', 461, NULL, '50107', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'Specific Loan/Lease Loss Provision ', 437, NULL, '10613', 0, 1, 1, 1, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'SUBSCRIPTION AND WEB SEVICES', 461, NULL, '50108', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'STATIONERies', 461, NULL, '50109', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'TELEPHONE AND COMMUNICATIONS', 461, NULL, '50110', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'PRINTING', 461, NULL, '50111', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'PROFESSIONAL AND CONSULTANCY FEE', 461, NULL, '50112', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'VEHICLE REPAIRS', 461, NULL, '50113', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'OFFICE BUILDING REPAIRS', 461, NULL, '50114', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'PLANT AND MACHINERY REPAIRS', 461, NULL, '50115', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'ELECTRICALS REPAIRS', 461, NULL, '50116', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'FURNITURE AND FITTINGS REPAIRS', 461, NULL, '50117', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'OFFICE EQUIP REPAIRS', 461, NULL, '50118', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'Government dues & subscriptions', 461, NULL, '50119', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'DIRECTORS COST', 461, NULL, '50120', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'AUDIT FEE', 461, NULL, '50121', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'LEGAL FEE', 461, NULL, '50122', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'OFFICE ENTERTAINMENT', 461, NULL, '50123', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'OFFICE CONSUMABLES', 461, NULL, '50124', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'loan WRITe OFF', 461, NULL, '50125', 0, 0, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'DEPRECIATION OF FIXED ASSETS', 461, NULL, '50126', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 0, '{$br_id}', 'MISCELLANEOUS', 461, NULL, '50127', 0, 1, 1, 5, NULL, '', 0, 0.00, NULL),
    ('$intid', 1, '{$br_id}', 'dues from bank', 0, NULL, '10200', 0, 0, 2, 1, NULL, '', 0, 0.00, NULL);
    ";
    $dsp = mysqli_query($connection, $dos);
    if($dsp){
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