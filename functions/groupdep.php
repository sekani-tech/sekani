<?php
include("connect.php");
session_start();
require_once "../bat/phpmailer/PHPMailerAutoload.php";

$int_name = $_SESSION["int_name"];
$int_email = $_SESSION["int_email"];
$int_web = $_SESSION["int_web"];
$int_phone = $_SESSION["int_phone"];
$int_logo = $_SESSION["int_logo"];
$int_address = $_SESSION["int_address"];
$sessint_id = $_SESSION["int_id"];
$m_id = $_SESSION["user_id"];
$sender_id = $_SESSION["sender_id"];
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);

// declare it into the inputs
$getacct1 = mysqli_query($connection, "SELECT * FROM staff WHERE user_id = '$m_id' && int_id = '$sessint_id'");
if (count([$getacct1]) == 1) {
    $uw = mysqli_fetch_array($getacct1);
    $staff_id = $uw["id"];
    $staff_email = $uw["email"];
    echo $staff_id;
}
$staff_name  = strtoupper($_SESSION["username"]);

// To Check for transaction type
if(isset($_POST['transtype'])){
    // Declaring values
    $type = $_POST['transtype'];
    $acount_no = $_POST['account_no'];
    $amount = $_POST['amount'];
}
// Error for transaction Type
else{
    $_SESSION["Lack_of_intfund_$randms"] = "Deposit Has Been Done, Awaiting Approval!";
    echo header ("Location: ../mfi/transact.php?message=$randms");
}
?>