<?php
include("connect.php");
session_start();
$sint_id = $_SESSION['int_id'];
$user_id = $_SESSION['user_id'];
?>
<?php
if(isset($_POST['ftd_no'])){
    if($_POST['client']!='' && $_POST['s_product']!=''){
    $client = $_POST['client'];
    $amount = $_POST['amount'];
    $ftd_no = $_POST['ftd_no'];
    $date = $_POST['date'];
    $l_term = $_POST['l_term'];
    $mat_date = $_POST['mat_date'];
    $int_rate = $_POST['int_rate'];
    $lsaa = $_POST['linked_savings_acct'];
    $acc_off = $_POST['acc_off'];
    $sproduct_id = $_POST['s_product'];
    $int_repay = $_POST['int_repay'];
    $currency_code = 'NGN';
    $dating = date('Y-m-d h:i:sa');
    if(isset($_POST['auto_renew'])){
        $auto_renew = '1';
    }
    else{
        $auto_renew = '0';
    }

    $fdp = "SELECT * FROM client WHERE id = '$client'";
    $fdop = mysqli_query($connection, $fdp);
    $f = mysqli_fetch_array($fdop);
    $branch_id = $f['branch_id'];

    // Products
    $weio = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$sproduct_id'");
    $ifdo = mysqli_fetch_array($weio);
    $pname = $ifdo['name'];
    $type_id = $ifdo['accounting_type'];

    // an account number generation
    $inttest = str_pad($branch_id, 3, '0', STR_PAD_LEFT);
    $digit = 4;
    $randms = str_pad(rand(0, pow(10, $digit)-1), 7, '0', STR_PAD_LEFT);
    $account_no = $inttest."".$randms;

    // To derive deposit amount 
    $fsdofi = "SELECT * FROM account WHERE int_id = '$sint_id' AND id = '$lsaa'";
    $fodi =  mysqli_query($connection, $fsdofi);
    $io = mysqli_fetch_array($fodi);
    if($io){
        $linked_account_bal = $io['account_balance_derived'];
        $prod_id = $io['product_id'];
        $l_acc_no = $io['account_no'];
        if($linked_account_bal > $amount){
        $new_linked_account_bal =  $linked_account_bal - $amount;
        $idofs = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$new_linked_account_bal',
         last_withdrawal = '$amount' WHERE id = '$lsaa'");

         if($idofs){
            $descrip = "FTD_Booking";
            $irvs = "0";
            $iat = "INSERT INTO account_transaction (int_id, branch_id,
            account_no, product_id, account_id,
            client_id, transaction_id, description, transaction_type, is_reversed,
            transaction_date, amount, running_balance_derived, overdraft_amount_derived,
            created_date, appuser_id, debit) VALUES ('{$sint_id}', '{$branch_id}',
            '{$l_acc_no}', '{$prod_id}', '{$lsaa}', '{$client}', '{$ftd_no}', '{$descrip}', 'Debit', '{$irvs}',
            '{$dating}', '{$amount}', '{$new_linked_account_bal}', '{$amount}',
            '{$dating}', '{$user_id}', {$amount})";
            $res3 = mysqli_query($connection, $iat);

            if($res3){
                $dsopdo = "INSERT INTO account (int_id, branch_id, account_no, account_type, type_id,
                product_id, client_id, field_officer_id, submittedon_date, submittedon_userid,
                currency_code, account_balance_derived, term, int_rate, maturedon_date, linked_savings_account, 
                last_deposit, auto_renew_on_closure,
                interest_repayment)
                 VALUES ('{$sint_id}', '{$branch_id}', '{$account_no}', '{$pname}', '{$type_id}', '{$sproduct_id}',
                 '{$client}', '{$acc_off}', '{$dating}', '{$user_id}', '{$currency_code}', 
                 '{$amount}', '{$l_term}', '{$int_rate}', '{$mat_date}', '{$lsaa}', '{$amount}', '{$auto_renew}',
                 '{$int_repay}')";
                $fd = mysqli_query($connection, $dsopdo);

                $accountins = "INSERT INTO ftd_booking_account (int_id, branch_id, ftd_id, account_no,
                product_id, client_id, field_officer_id, submittedon_date, submittedon_userid,
                currency_code, account_balance_derived, term, int_rate, maturedon_date, linked_savings_account, 
                last_deposit, auto_renew_on_closure,
                interest_repayment, status)
                 VALUES ('{$sint_id}', '{$branch_id}', '{$ftd_no}', '{$account_no}', '{$sproduct_id}',
                 '{$client}', '{$acc_off}', '{$dating}', '{$user_id}', '{$currency_code}', 
                 '{$amount}', '{$l_term}', '{$int_rate}', '{$mat_date}', '{$lsaa}', '{$amount}', '{$auto_renew}',
                 '{$int_repay}', 'Pending')";

                $fd = mysqli_query($connection, $accountins);
                if($fd){
                    $fdiae = mysqli_query($connection, "SELECT * FROM ftd_booking_account WHERE int_id = '$sint_id' AND account_no = '$account_no'");
                    $if = mysqli_fetch_array($fdiae);
                    $ifod = $if['id'];
                    $iat = "INSERT INTO account_transaction (int_id, branch_id,
                    account_no, product_id, account_id,
                    client_id, transaction_id, description, transaction_type, is_reversed,
                    transaction_date, amount, running_balance_derived, overdraft_amount_derived,
                    created_date, appuser_id, credit) VALUES ('{$sint_id}', '{$branch_id}',
                    '{$account_no}', '{$sproduct_id}', '{$ifod}', '{$client}', '{$ftd_no}', '{$descrip}', 'Debit', '{$irvs}',
                    '{$dating}', '{$amount}', '{$amount}', '{$amount}',
                    '{$dating}', '{$user_id}', {$amount})";
                    $res3 = mysqli_query($connection, $iat);
                    if($res3){
                        $_SESSION["Lack_of_intfund_$randms"] = " was updated successfully!";
                        echo header ("Location: ../mfi/ftd_booking.php?message1=$randms");
                    }
                    else{
                        $_SESSION["Lack_of_intfund_$randms"] = " was updated successfully!";
                        echo header ("Location: ../mfi/ftd_booking.php?message2=$randms"); 
                    }
                }
            }else{
                $_SESSION["Lack_of_intfund_$randms"] = " was updated successfully!";
                echo header ("Location: ../mfi/ftd_booking.php?message3=$randms"); 
            }
    }
    else{
        $_SESSION["Lack_of_intfund_$randms"] = " was updated successfully!";
        echo header ("Location: ../mfi/ftd_booking.php?message4=$randms"); 
    }
    }
    else{
        $_SESSION["Lack_of_intfund_$randms"] = " was updated successfully!";
        echo header ("Location: ../mfi/ftd_booking.php?message7=$randms"); 
    }
}
else{
    $_SESSION["Lack_of_intfund_$randms"] = " was updated successfully!";
    echo header ("Location: ../mfi/ftd_booking.php?message5=$randms"); 
}
}
else{
    $_SESSION["Lack_of_intfund_$randms"] = " was updated successfully!";
    echo header ("Location: ../mfi/ftd_booking.php?message6=$randms"); 
}
}
else{
    $_SESSION["Lack_of_intfund_$randms"] = " was updated successfully!";
    echo header ("Location: ../mfi/ftd_booking.php?message7=$randms"); 
}
?>