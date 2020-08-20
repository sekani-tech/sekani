<?php 
include("connect.php");
session_start();
$randms = str_pad(rand(0, pow(10, 8)-1), 10, '0', STR_PAD_LEFT);
?>
<?php
if (isset($_POST['id'])) {
    // Declare Variables
    $id = $_POST['id'];
    $amount = $_POST['amount'];
    $ftd_no = $_POST['ftd_no'];
    $date = $_POST['date'];
    $l_term = $_POST['l_term'];
    $int_rate = $_POST['int_rate'];
    $linked = $_POST['linked'];
    $mat_date = $_POST['mat_date'];
    $int_repay = $_POST['int_repay'];
    $auto_renew = $_POST['auto_renew'];
    $acc_off = $_POST['acc_off'];
    $sessint_id = $_SESSION['int_id'];
    $curr_date = date('Y-m-d');
    $user_id = $_SESSION['user_id'];

    // Collect extra data needed
    $odi = mysqli_query($connection, "SELECT * FROM ftd_booking_account WHERE int_id = '$sessint_id' AND id = '$id'");
    $iod = mysqli_fetch_array($odi);
    $prev_amount = $iod['account_balance_derived'];
    $prev_linked_account = $iod['linked_savings_account'];

    // to check if linked account is equal
    if($prev_linked_account == $linked){
        // Data for the linked savings
        $qpeo = mysqli_query($connection, "SELECT * FROM account WHERE int_id = '$sessint_id' AND id = '$prev_linked_account'");
        $iweo = mysqli_fetch_array($qpeo);
        $linked_savings_amount = $iweo['account_balance_derived'];
        $branch_id = $iweo['branch_id'];
        $acc = $iweo['account_no'];
        $prod = $iweo['product_id'];
        $clien = $iweo['client_id'];

        // to check if the amount hasnt changed
        if($prev_amount == $amount){
            // FTD was not update. Code runs normal
            $up = "UPDATE ftd_booking_account SET ftd_id = '$ftd_no', field_officer_id = '$acc_off', submittedon_date = '$date', account_balance_derived = '$amount', term = '$l_term',
              int_rate = '$int_rate', maturedon_date = '$mat_date', linked_savings_account = '$linked', auto_renew_on_closure = '$auto_renew', interest_repayment = '$int_repay',
              status = 'Approved' WHERE int_id = '$sessint_id' AND id = '$id'";
            $update = mysqli_query($connection, $up);
            if($update){
                // FTD Successful
                $_SESSION["Lack_of_intfund_$randms"] = "";
                echo header ("Location: ../mfi/ftd_approval.php?message1=$randms");
            }
            else{
                 // FTD not Successfull
                $_SESSION["Lack_of_intfund_$randms"] = "";
                echo header ("Location: ../mfi/ftd_approval.php?message2=$randms");
            }
        }
        else if($prev_amount != $amount){
            // FTD Amount was updated. Creating new data for calculation
            $new_balance = $prev_amount + $linked_savings_amount;
            // If amount is not equal to balance
            if($amount >= $new_balance){
                $_SESSION["Lack_of_intfund_$randms"] = " ";
                echo header ("Location: ../mfi/ftd_approval.php?message3=$randms");
            }
            // if new_balance is more than amount
            else if($new_balance > $amount){
                $acc_bal = $new_balance - $amount;
                $up = "UPDATE ftd_booking_account SET ftd_id = '$ftd_no', field_officer_id = '$acc_off', submittedon_date = '$date', account_balance_derived = '$amount', term = '$l_term',
                int_rate = '$int_rate', maturedon_date = '$mat_date', linked_savings_account = '$linked', auto_renew_on_closure = '$auto_renew', interest_repayment = '$int_repay',
                status = 'Approved' WHERE int_id = '$sessint_id' AND id = '$id'";
                $update = mysqli_query($connection, $up);

                // to put the money back into the account and record reversal
                $fdio = "UPDATE account SET account_balance_derived = '$acc_bal', last_withdrawal = '$amount' WHERE int_id = '$sessint_id' AND id = '$linked'";
                $wow = mysqli_query($connection, $fdio);

                // first transaction is for the reversal
                $des = "RVSL for FTD Booking";
                $sosd = "INSERT INTO account_transaction (int_id, branch_id, account_id, account_no, product_id, client_id, transaction_id,
                description, transaction_type, is_reversed, transaction_date, amount, running_balance_derived, overdraft_amount_derived,
                created_date, appuser_id, credit)
                VALUES('{$sessint_id}', '{$branch_id}', '{$linked}', '{$acc}', '{$prod}', '{$clien}', '{$ftd_no}', '{$des}', 'Credit', '1',
                 '{$curr_date}', '{$prev_amount}', '{$new_balance}', '{$prev_amount}', '{$curr_date}', '{$user_id}', '{$prev_amount}')";
                $mdso = mysqli_query($connection, $sosd);

                // The Second transaction is  for the new FTD
                $descrip = "FTD_Booking";
                $opweop = "INSERT INTO account_transaction (int_id, branch_id, account_id, account_no, product_id, client_id, transaction_id,
                description, transaction_type, is_reversed, transaction_date, amount, running_balance_derived, overdraft_amount_derived,
                created_date, appuser_id, debit)
                VALUES('{$sessint_id}', '{$branch_id}', '{$linked}', '{$acc}', '{$prod}', '{$clien}', '{$ftd_no}', '{$descrip}', 'Debit', '1',
                 '{$curr_date}', '{$amount}', '{$acc_bal}', '{$amount}', '{$curr_date}', '{$user_id}', '{$amount}')";
                $spod = mysqli_query($connection, $opweop);

                // If Transaction Successful
                if($update && $wow && $mdso && $spod){
                    $_SESSION["Lack_of_intfund_$randms"] = " ";
                    echo header ("Location: ../mfi/ftd_approval.php?message1=$randms");
                }
                else{
                    echo header ("Location: ../mfi/ftd_approval.php?message2=$randms");
                }
            }
        }
    }
    else if($prev_linked_account != $linked){
        // Data For Old Linked Account
        $qpeo = mysqli_query($connection, "SELECT * FROM account WHERE int_id = '$sessint_id' AND id = '$prev_linked_account'");
        $iweo = mysqli_fetch_array($qpeo);
        $linked_savings_amount = $iweo['account_balance_derived'];
        $branch_id = $iweo['branch_id'];
        $acc = $iweo['account_no'];
        $prod = $iweo['product_id'];
        $clien = $iweo['client_id'];

        // Data for New Linked Account
        $rioer = mysqli_query($connection, "SELECT * FROM account WHERE int_id = '$sessint_id' AND id = '$linked'");
        $sdopw = mysqli_fetch_array($rioer);
        $linked_savings_amount_b = $sdopw['account_balance_derived'];
        $branch_id_b = $sdopw['branch_id'];
        $acc_b = $sdopw['account_no'];
        $prod_b = $sdopw['product_id'];
        $clien_b = $sdopw['client_id'];

        // If theres not enough money in the new account, Throw error Back
        if($linked_savings_amount_b < $amount){
            $_SESSION["Lack_of_intfund_$randms"] = "";
            echo header ("Location: ../mfi/ftd_approval.php?message3=$randms");
        }
        // If Money is available, Proceed to execute code
        else if($linked_savings_amount_b >= $amount){
            // Code to add amount back to the previous account
            $new_bal = $linked_savings_amount + $amount;
            $fdio = "UPDATE account SET account_balance_derived = '$new_bal', last_deposit = '$amount' WHERE int_id = '$sessint_id' AND id = '$prev_linked_account'";
            $wow = mysqli_query($connection, $fdio);

            // Reversal transaction for the account
            $des = "RVSL for FTD_Booking";
            $sosd = "INSERT INTO account_transaction (int_id, branch_id, account_id, account_no, product_id, client_id, transaction_id,
            description, transaction_type, is_reversed, transaction_date, amount, running_balance_derived, overdraft_amount_derived,
            created_date, appuser_id, credit)
            VALUES('{$sessint_id}', '{$branch_id}', '{$prev_linked_account}', '{$acc}', '{$prod}', '{$clien}', '{$ftd_no}', '{$des}', 'Credit', '1',
             '{$curr_date}', '{$amount}', '{$new_bal}', '{$amount}', '{$curr_date}', '{$user_id}', '{$amount}')";
            $mdso = mysqli_query($connection, $sosd);

            // Code to Remove amount from to the previous account
            $new_bal_b = $linked_savings_amount_b - $amount;
            $sodie = "UPDATE account SET account_balance_derived = '$new_bal_b', last_withdrawal = '$amount' WHERE int_id = '$sessint_id' AND id = '$linked'";
            $eowpsd = mysqli_query($connection, $sodie);

            // Transaction for the account
            $sds = "FTD_Booking";
            $dopfo = "INSERT INTO account_transaction (int_id, branch_id, account_id, account_no, product_id, client_id, transaction_id,
            description, transaction_type, is_reversed, transaction_date, amount, running_balance_derived, overdraft_amount_derived,
            created_date, appuser_id, credit)
            VALUES('{$sessint_id}', '{$branch_id_b}', '{$linked}', '{$acc_b}', '{$prod_b}', '{$clien_b}', '{$ftd_no}', '{$sds}', 'Debit', '1',
             '{$curr_date}', '{$amount}', '{$new_bal_b}', '{$amount}', '{$curr_date}', '{$user_id}', '{$amount}')";
            $dsio = mysqli_query($connection, $dopfo);

            // FTD booking
            $up = "UPDATE ftd_booking_account SET ftd_id = '$ftd_no', field_officer_id = '$acc_off', submittedon_date = '$date', account_balance_derived = '$amount', term = '$l_term',
            int_rate = '$int_rate', maturedon_date = '$mat_date', linked_savings_account = '$linked', auto_renew_on_closure = '$auto_renew', interest_repayment = '$int_repay',
            status = 'Approved' WHERE int_id = '$sessint_id' AND id = '$id'";
            $update = mysqli_query($connection, $up);
            // If queries are successful
            if($wow && $mdso && $eowpsd && $dsio && $update){
                $_SESSION["Lack_of_intfund_$randms"] = "";
                echo header ("Location: ../mfi/ftd_approval.php?message1=$randms");
            }
            else{
                $_SESSION["Lack_of_intfund_$randms"] = "";
                echo header ("Location: ../mfi/ftd_approval.php?message3=$randms");
            }
        }
    }
}
else if(isset($_GET['approve'])) {
    $id = $_GET['approve'];

    $fdoi = mysqli_query($connection, "UPDATE ftd_booking_account SET status = 'Approved' WHERE id = '$id'");
    if($fdoi){
        $_SESSION["Lack_of_intfund_$randms"] = " Account was updated successfully!";
        echo header ("Location: ../mfi/ftd_approval.php?message1=$randms");
    }
    else{
        $_SESSION["Lack_of_intfund_$randms"] = " Account was updated successfully!";
        echo header ("Location: ../mfi/ftd_approval.php?message2=$randms");
    }

}
?>