<?php
include("connect.php");
session_start();
require_once "../bat/phpmailer/PHPMailerAutoload.php";
// qwertyuiop
// CHECK HTN APPROVAL
$int_name = $_SESSION["int_name"];
$int_email = $_SESSION["int_email"];
$int_web = $_SESSION["int_web"];
$int_phone = $_SESSION["int_phone"];
$int_logo = $_SESSION["int_logo"];
$int_address = $_SESSION["int_address"];
$sessint_id = $_SESSION["int_id"];
$m_id = $_SESSION["user_id"];
$getacct1 = mysqli_query($connection, "SELECT * FROM staff WHERE user_id = '$m_id' && int_id = '$sessint_id'");
if (count([$getacct1]) == 1) {
    $uw = mysqli_fetch_array($getacct1);
    $staff_id = $uw["id"];
    echo $staff_id;
}
$staff_name  = strtoupper($_SESSION["username"]);
?>
<?php
// GET ALL THE POSTED FORM FOR THIS
?>
<?php
// making expense transaction
// get all important things first
$taketeller = "SELECT * FROM tellers WHERE name = '$staff_id' && int_id = '$sessint_id'";
$check_me_men = mysqli_query($connection, $taketeller);
if ($check_me_men) {
$ex = mysqli_fetch_array($check_me_men);
$is_del = $ex["is_deleted"];
$till = $ex["till"];
$post_limit = $ex["post_limit"];
$gl_code = $ex["till"];
$till_no = $ex["till_no"];
// we will call the GL
$gl_man = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE gl_code = '$gl_code' && int_id = '$sessint_id'");
$gl = mysqli_fetch_array($gl_man);
$l_acct_bal = $gl["organization_running_balance_derived"];

// remeber the institution account
$damn = mysqli_query($connection, "SELECT * FROM institution_account WHERE int_id = '$sessint_id'");
    if (count([$damn]) == 1) {
        $x = mysqli_fetch_array($damn);
        $int_acct_bal = $x['account_balance_derived'];
        $tbd = $x['total_deposits_derived'] + $amt;
        $tbd2 = $x['total_withdrawals_derived'] + $amt2;
        $new_int_bal = $amt + $int_acct_bal;
        $new_int_bal2 = $int_acct_bal - $amt2;
    }
}
?>
<?php
?>
<!-- THINGS TO DO JUST --DONE WHERE IF HAS BEEN DONE -->
<?php
// now check if this person is active
// end this

// ****TASK FOR TODAY****
// INSERT INTO GL ACCOUNT
// MAKE THE TRANSACTION REFLECT ON THE TELLER TRANSACTION
// IF IT EXCEEDS THE TELLER LIMIT JUST POST FOR APPROVAL
// DROP AND ALERT WITHT THE SEKANI ADMIN
// REMEMBER THE TELLER REPORT
?>