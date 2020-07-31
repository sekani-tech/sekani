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
        echo header("Location: ../institution.php");
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