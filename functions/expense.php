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
    $staff_name = $uw['firstname'].' '.$a['middlename'].' '.$a['lastname'];
}
$staff_name  = strtoupper($_SESSION["username"]);
$gen_date = date('Y-m-d H:i:s');
?>
<?php
// GET ALL THE POSTED FORM FOR THIS
$gl_codex = $_POST['gl_no'];
$gl_amt = $_POST['amount'];
$pym = $_POST['payment_method'];
$trans_id = $_POST['transid'];
$desc = $_POST['descrip'];
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
?>
<?php
// making expense transaction
// get all important things first
$taketeller = "SELECT * FROM tellers WHERE name = '$staff_id' && int_id = '$sessint_id'";
$check_me_men = mysqli_query($connection, $taketeller);
if ($check_me_men) {
$ex = mysqli_fetch_array($check_me_men);
$is_del = $ex["is_deleted"];
$branch_id = $ex['branch_id'];
$till = $ex["till"];
$post_limit = $ex["post_limit"];
$gl_code = $ex["till"];
$till_no = $ex["till_no"];
// we will call the GL
$gl_man = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE gl_code = '$gl_codex' && int_id = '$sessint_id'");
$gl = mysqli_fetch_array($gl_man);
$gl_name = $gl["name"];
$l_acct_bal = $gl["organization_running_balance_derived"];
$parent_id = $gl["parent_id"];
$new_gl_bal = $l_acct_bal + $gl_amt;
// remeber the institution account
$damn = mysqli_query($connection, "SELECT * FROM institution_account WHERE int_id = '$sessint_id' && teller_id = '$staff_id'");
    if (count([$damn]) == 1) {
        $x = mysqli_fetch_array($damn);
        $int_acct_bal = $x['account_balance_derived'];
        // $tbd = $x['total_deposits_derived'] + $amt;
        $tbd2 = $x['total_withdrawals_derived'] + $gl_amt;
        $new_int_bal2 = $int_acct_bal - $gl_amt;
    }
}
?>
<?php
// check if the teller is deleted or active
$q3 = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE gl_code = '$gl_codex' && int_id='$sessint_id'");
// run the query
$resx1 = mysqli_fetch_array($q3);
$mxd = $resx1["gl_code"];
if ($mxd == $gl_codex && $mxd != NULL || $mxd != 0) {
if ($is_del == "0" && $is_del != NULL) {
    // check if the teller account is greater the gl amount else insufficient fund
    if ($int_acct_bal >= $gl_amt) {
        // check if it exceed the posting limit
        if ($gl_amt <= $post_limit) {
            // update the account gl
            $upglacct = "UPDATE `acc_gl_account` SET `organization_running_balance_derived` = '$new_gl_bal' WHERE int_id = '$sessint_id' && gl_code = '$gl_codex'";
            $dbgl = mysqli_query($connection, $upglacct);
            if ($dbgl) {
                $gl_acc = "INSERT INTO gl_account_transaction (int_id, branch_id, gl_code, parent_id, transaction_id, description,
                transaction_type, teller_id, transaction_date, amount, gl_account_balance_derived, overdraft_amount_derived,
                  created_date, credit) VALUES ('{$sessint_id}', '{$branch_id}', '{$gl_codex}', '{$parent_id}', '{$trans_id}', '{$desc}', 'Credit', '{$staff_id}',
                   '{$gen_date}', '{$gl_amt}', '{$new_gl_bal}', '{$gl_amt}', '{$gen_date}', '{$gl_amt}')";
                   $res4 = mysqli_query($connection, $gl_acc);
                if($res4){
                $upinta = "UPDATE institution_account SET account_balance_derived = '$new_int_bal2', total_withdrawals_derived = '$tbd2' WHERE int_id = '$sessint_id' && teller_id = '$staff_id'";
                $res1 = mysqli_query($connection, $upinta);
                }
                if ($res1) {
                    $trans_type2= "Expense";
                    $irvs = 0;
                    $gen_date = date('Y-m-d H:i:s');
                    $iat2 = "INSERT INTO institution_account_transaction (int_id, branch_id,
            teller_id, transaction_id, description, transaction_type, is_reversed,
            transaction_date, amount, running_balance_derived, overdraft_amount_derived,
            created_date, appuser_id, debit) VALUES ('{$sessint_id}', '{$branch_id}',
            '{$gl_codex}', '{$trans_id}', '{$desc}', 'Debit', '{$irvs}',
            '{$gen_date}', '{$gl_amt}', '{$new_int_bal2}', '{$gl_amt}',
            '{$gen_date}', '{$staff_id}', '{$gl_amt}')";
                $res4 = mysqli_query($connection, $iat2);
                if ($res4) {
                    // now we will send a mail
                    $_SESSION["Lack_of_intfund_$randms"] = "Expense Successful";
                   echo header ("Location: ../mfi/transact.php?loan1=$randms");
                } else {
                  // error in intstitution account transaction
                  $_SESSION["Lack_of_intfund_$randms"] = "Expense Failed";
                  echo header ("Location: ../mfi/transact.php?legal=$randms");
                }
                } else {
                    // echo error in institution account update
                    $_SESSION["Lack_of_intfund_$randms"] = "Expense Failed";
                    echo header ("Location: ../mfi/transact.php?legal=$randms");
                }
            } else {
           // echo error at the GL posting
           $_SESSION["Lack_of_intfund_$randms"] = "Expense Failed";
            echo header ("Location: ../mfi/transact.php?legal=$randms");
           }
        } else {
            // run the expense for approval
            $trancache = "INSERT INTO transact_cache (int_id, branch_id, transact_id, description, account_no,
            client_name, staff_id, account_off_name,
            amount, pay_type, transact_type, status, date) VALUES
            ('{$sessint_id}', '{$branch_id}', '{$trans_id}', '{$desc}', '{$gl_codex}', '{$gl_name}',
            '{$staff_id}', '{$staff_name}', '{$gl_amt}', '{$pym}',
            'Expense', 'Pending', '{$gen_date}') ";
            $go = mysqli_query($connection, $trancache);
            if ($go) {
                $_SESSION["Lack_of_intfund_$randms"] = "Expense Successful!";
               echo header ("Location: ../mfi/transact.php?loan2=$randms");
             } else {
                $_SESSION["Lack_of_intfund_$randms"] = "Expense Failed";
               echo header ("Location: ../mfi/transact.php?loan4=$randms");
//             if ($connection->error) {
//     try {   
//         throw new Exception("MySQL error $connection->error <br> Query:<br> $trancache", $mysqli->error);   
//     } catch(Exception $e ) {
//         echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
//         echo nl2br($e->getTraceAsString());
//     }
// }
             }
             
        }
       } else {
        // echo insufficient fund
        $_SESSION["Lack_of_intfund_$randms"] = "Failed - Insufficient Fund";
        header ("Location: ../mfi/transact.php?message5=$randms");
      }
} else {
// echo a you are not authorized message
$_SESSION["Lack_of_intfund_$randms"] = "TELLER";
echo header ("Location: ../mfi/transact.php?messagex2=$randms");
}
} else {
    // Making now
    $_SESSION["Lack_of_intfund_$randms"] = "TELLER";
    echo header ("Location: ../mfi/transact.php?loan2c=$randms");
}
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