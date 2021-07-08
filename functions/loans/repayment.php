<?php
// This code collects the loan that is due today
include("../connect.php");
// todays date
$today = date('Y-m-d');
$code1 = mysqli_query($connection, "SELECT * FROM loan_repayment_schedule WHERE installment >= '1' AND duedate = '$today'");
if(mysqli_num_rows($code1) > 0){
    // if code ok
    while($arr1 = mysqli_fetch_array($code1, MYSQLI_ASSOC)){
        // declare variables
        $mainid = $arr1['id'];
        $loan_id = $arr1['loan_id'];
        $int_id = $arr1['int_id'];
        $client_id = $arr1['client_id'];
        $duedate = $arr1['duedate'];
        $principal = $arr1['principal_amount'];
        $interest = $arr1['interest_amount'];
        $amount_collected = $arr1['amount_collected'];

        // check client balance for  money
        $code2 = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$client_id' AND account_balance_derived > '0' ORDER BY account_balance_derived DESC LIMIT 1");
        if(mysqli_num_rows($code2) > 0){
        $arr2 = mysqli_fetch_array($code2);
        $account_balance = $arr2['account_balance_derived'];
        $account_id = $arr2['id'];
        // if money is available
        if($account_balance > 0){
            // check money to be collected
            $tatbp = ($principal + $interest) - $amount_collected;
            // if  account balance is more than the total amount to be paid
            if($account_balance >= $tatbp){
                // Update repayment schedule
                $code3 = mysqli_query($connection, "UPDATE loan_repayment_schedule SET installment = '0' WHERE int_id = '$int_id' AND id = '$mainid'");
                if($code3){
                    // Update outstanding loan balance
                    $code4 = mysqli_query($connection, "SELECT * FROM loan WHERE int_id = '$int_id' AND id = '$loan_id'");
                    $arr4 = mysqli_fetch_array($code4);
                    $original_outbalance = $arr4['total_outstanding_derived'];
                    $new_oustanding = $original_outbalance - $tatbp;
                    $code5 = mysqli_query($connection, "UPDATE loan SET total_outstanding_derived = '$new_oustanding' WHERE int_id = '$int_id' AND id = '$loan_id'");
                    if($code5){
                        // Update account balance
                        $new_balance = $account_balance - $tatbp;
                        $code6 = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$new_balance', last_withdrawal = '$tatbp' WHERE client_id = '$client_id' AND id ='$account_id'");
                        if($code6){
                            echo 'amount fully paid for client '.$client_id.'</br>';
                        }
                        else{
                            echo 'error updating account for client '.$client_id.'</br>';
                        }
                    }
                    else{
                        echo 'error updating loan for client '.$client_id.'</br>';
                    }
                }
                else{
                    echo 'error updating repayment for client '.$client_id.'</br>';
                }
            }
            // if total amount to be paid is more than account balance
            else if($account_balance < $tatbp){
                // take money all money in account
                $code7 = mysqli_query($connection, "UPDATE account SET account_balance_derived = '0', last_withdrawal = '$account_balance' WHERE int_id = '$int_id' AND id = '$account_id'");
                if($code7){
                    // Update outstanding loan balance
                    $code8 = mysqli_query($connection, "SELECT * FROM loan WHERE int_id = '$int_id' AND id = '$loan_id'");
                    $arr8 = mysqli_fetch_array($code8);
                    $original_outbalance = $arr8['total_outstanding_derived'];
                    $new_oustanding = $original_outbalance - $account_balance;
                    $code9 = mysqli_query($connection, "UPDATE loan SET total_outstanding_derived = '$new_oustanding' WHERE int_id = '$int_id' AND id = '$loan_id'");
                    if($code9){
                        // Update loan repayment
                        $code10 = mysqli_query($connection, "UPDATE loan_repayment_schedule SET amount_collected = '$account_balance' WHERE int_id = '$int_id' AND id = '$mainid'");
                        if($code10){
                            echo 'Not enough money in client '.$client_id.' account, amount collected</br>';
                        }
                        else{
                            echo 'error updating repayment for client '.$client_id.'</br>';
                        }
                        // installment for the repayment was not changed, and no need to move it to arrear table B/C code in schedule.php will do it when triggered
                        // But amount was taken and outstanding loan balance was updated
                    }
                    else{
                        echo 'error updating loan for client '.$client_id.'</br>';
                    }
                }
                else{
                    echo 'error updating account for client '.$client_id.'</br>';
                }
            }
        }
        // If money is not available
        else if($account_balance <= 0){
            echo 'No money in account for client '.$client_id.'</br>';
        }
    }
    else{
        echo 'No suitable account found for client '.$client_id.'</br>';
    }
    }
}
else{
    echo 'No loans repayed today';
}
?>