<?php
// get connection
// & and create session
include("../connect.php");
session_start();
$sint_id = $_SESSION['int_id'];
$user_id = $_SESSION['user_id'];

// check if FTD VALUE is available
if(isset($_POST['ftd_no'])){
    if($_POST['client']!='' && $_POST['s_product']!=''){
        $client = $_POST['client'];
        $amount = $_POST['amount'];
        $ftd_no = $_POST['ftd_no'];
        $date = $_POST['date'];
        $l_term = $_POST['l_term'];
        $booked_date = $_POST['date'];
        $int_rate = $_POST['int_rate'];
        $lsaa = $_POST['linked_savings_acct'];
        $acc_off = $_POST['acc_off'];
        $sproduct_id = $_POST['s_product'];
        $int_repay = $_POST['int_repay'];
        $int_post = $_POST['int_post'];
        $currency_code = 'NGN';
        $tday = date('Y-m-d');
        $dating = date('Y-m-d h:i:sa');
        if(isset($_POST['auto_renew'])){
            $auto_renew = '1';
        }
        else{
            $auto_renew = '0';
        }

        // Finding branch id
        $findBranch = mysqli_query($connection, "SELECT branch_id FROM client WHERE id = '$client'");
        $row = mysqli_fetch_array($findBranch);
        $branch_id = $row['branch_id'];
        if(!$findBranch) {
                    printf('Error: %s\n', mysqli_error($connection));//checking for errors
                    exit();
                }else{
                    //output
                    $branch_id = $row['branch_id'];
                }
                // dd($findBranch);
        if($findBranch){
            // Find needed ftd product data
            $findSavingsProduct = mysqli_query($connection, "SELECT name, accounting_type FROM savings_product WHERE id = '$sproduct_id'");
            $savingsRow = mysqli_fetch_array($findSavingsProduct);
            $pname = $savingsRow['name'];
            $type_id = $savingsRow['accounting_type'];
            
            // FTD an account number generation
            $inttest = str_pad($branch_id, 3, '0', STR_PAD_LEFT);
            $digit = 4;
            $randms = str_pad(rand(0, pow(10, $digit)-1), 7, '0', STR_PAD_LEFT);
            $account_no = $inttest."".$randms;

            // Check clients account
            // To derive deposit amount 
            $fsdofi = "SELECT * FROM account WHERE int_id = '$sint_id' AND id = '$lsaa'";
            $fodi =  mysqli_query($connection, $fsdofi);
            $io = mysqli_fetch_array($fodi);
            $linked_account_bal = $io['account_balance_derived'];
            $prod_id = $io['product_id'];
            $linkedAccount = $io['account_no'];
            
            // two conditions to be met when booking 
            // first we check if clients account is founded 
            // if not FTD would be booked but client would be notified to fund account before approval
            if(!$fodi){
                // makes no sense but account not found
                $_SESSION["Lack_of_intfund_$randms"] = " was updated successfully!";
                echo header ("Location: ../../mfi/ftd_booking.php?message3=$randms");
            }else if($linked_account_bal >= $amount){
                // clients money is enough
                // For future development currency code would be gotten from product definition
                $ftdData = [
                    'int_id' => $sint_id, 
                    'branch_id' => $branch_id, 
                    'ftd_id' => $ftd_no, 
                    'account_no' => $account_no,
                    'product_id' => $prod_id, 
                    'client_id' => $client, 
                    'field_officer_id' => $acc_off, 
                    'submittedon_userid' => $user_id,
                    'currency_code' => 'NGN', 
                    'account_balance_derived' => $amount, 
                    'term' => $l_term, 
                    'int_rate' => $int_rate, 
                    'booked_date' => $booked_date, 
                    'linked_savings_account' => $linkedAccount, 
                    'last_deposit' => $anount, 
                    'auto_renew_on_closure' => $auto_renew, 
                    'interest_posting_period_enum' => $int_post,
                    'interest_repayment' => $int_repay, 
                    'status' => 'Pending'
                ];

                // inserting ftd data into db
                $bookFTD = insert('ftd_booking_account', $ftdData);
                if(!$bookFTD) {
                    printf('Error: %s\n', mysqli_error($connection));//checking for errors
                    exit();
                }else{
                    //output
                    // Client branch can not be found
                    $_SESSION["Lack_of_intfund_$randms"] = " was updated successfully!";
                    echo header ("Location: ../../mfi/ftd_booking.php?message4=$randms");
                }
            }else if($linked_account_bal <= $amount){
                // money in account not enough
                // For future development currency code would be gotten from product definition
                $ftdData = [
                    'int_id' => $sint_id, 
                    'branch_id' => $branch_id, 
                    'ftd_id' => $ftd_no, 
                    'account_no' => $account_no,
                    'product_id' => $prod_id, 
                    'client_id' => $client, 
                    'field_officer_id' => $acc_off, 
                    'submittedon_userid' => $user_id,
                    'currency_code' => 'NGN', 
                    'account_balance_derived' => $amount, 
                    'term' => $l_term, 
                    'int_rate' => $int_rate, 
                    'booked_date' => $booked_date, 
                    'linked_savings_account' => $linkedAccount, 
                    'last_deposit' => $anount, 
                    'auto_renew_on_closure' => $auto_renew, 
                    'interest_posting_period_enum' => $int_post,
                    'interest_repayment' => $int_repay, 
                    'status' => 'Pending'
                ];

                // inserting ftd data into db
                $bookFTD = insert('ftd_booking_account', $ftdData);
                if(!$bookFTD) {
                    printf('Error: %s\n', mysqli_error($connection));//checking for errors
                    exit();
                }else{
                    //output
                    // Client branch can not be found
                    $_SESSION["Lack_of_intfund_$randms"] = " was updated successfully!";
                    echo header ("Location: ../../mfi/ftd_booking.php?message5=$randms");
                }
            }
            
        }else{
            // Client branch can not be found
            $_SESSION["Lack_of_intfund_$randms"] = " was updated successfully!";
            echo header ("Location: ../../mfi/ftd_booking.php?message2=$randms");
        }
    }else{
        //Missing values from form
        $_SESSION["Lack_of_intfund_$randms"] = " was updated successfully!";
        echo header ("Location: ../../mfi/ftd_booking.php?message1=$randms");
    }

}else{
    // No FTD number generated
    $_SESSION["Lack_of_intfund_$randms"] = " was updated successfully!";
    echo header ("Location: ../../mfi/ftd_booking.php?message1=$randms");
}