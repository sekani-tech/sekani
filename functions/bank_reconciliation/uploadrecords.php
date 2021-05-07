<?php
include("../connect.php");
session_start();
$sessint_id = $_SESSION['int_id'];
$sessbranch_id = $_SESSION['branch_id'];
$sessuser_id = $_SESSION['user_id'];

if(!empty($_POST['inUploadedNotInSekani'])) {

    $inUploadedNotInSekaniArray = unserialize($_POST['inUploadedNotInSekani']);
    $GLCode = $_POST['gl_code'];

    $numOfRecords = sizeof($inUploadedNotInSekaniArray);

    $i = 1;

    foreach($inUploadedNotInSekaniArray as $inUploadedNotInSekani) {
        extract($inUploadedNotInSekani);

        $uploadedAmount = (int) str_replace(',', '', $uploadedAmount);

        $getCurrentGLBalance = mysqli_query($connection, "SELECT organization_running_balance_derived FROM `acc_gl_account` WHERE int_id = {$sessint_id} AND gl_code = {$GLCode}");
        $currentGLBalance = mysqli_fetch_array($getCurrentGLBalance)['organization_running_balance_derived'];

        if($uploadedType == 'Credit') {

            $cumulativeBalanceDerived = $currentGLBalance + $uploadedAmount;

            $glAccountTransData = [
                'int_id' => $sessint_id,
                'branch_id' => $sessbranch_id,
                'gl_code' => $GLCode,
                'parent_id' => '',
                'transaction_id' => $uploadedTransID,
                'description' => $uploadedDescription,
                'transaction_type' => 'credit',
                'teller_id' => $sessuser_id,
                'is_reversed' => 0,
                'transaction_date' => date('Y-m-d', strtotime($uploadedTransDate)),
                'amount' => $uploadedAmount,
                'gl_account_balance_derived' => $cumulativeBalanceDerived,
                'branch_balance_derived' => '',
                'overdraft_amount_derived' => $uploadedAmount,
                'balance_end_date_derived' => date('Y-m-d'),
                'balance_number_of_days_derived' => '',
                'cumulative_balance_derived' => $cumulativeBalanceDerived,
                'created_date' => date('Y-m-d H:i:s'),
                'manually_adjusted_or_reversed' => 1,
                'credit' => $uploadedAmount
            ];

        }
        
        if ($uploadedType == 'Debit') {

            $cumulativeBalanceDerived = $currentGLBalance - $uploadedAmount;

            $glAccountTransData = [
                'int_id' => $sessint_id,
                'branch_id' => $sessbranch_id,
                'gl_code' => $GLCode,
                'parent_id' => '',
                'transaction_id' => $uploadedTransID,
                'description' => $uploadedDescription,
                'transaction_type' => 'debit',
                'teller_id' => $sessuser_id,
                'is_reversed' => 0,
                'transaction_date' => date('Y-m-d', strtotime($uploadedTransDate)),
                'amount' => $uploadedAmount,
                'gl_account_balance_derived' => $cumulativeBalanceDerived,
                'branch_balance_derived' => '',
                'overdraft_amount_derived' => $uploadedAmount,
                'balance_end_date_derived' => date('Y-m-d'),
                'balance_number_of_days_derived' => '',
                'cumulative_balance_derived' => $cumulativeBalanceDerived,
                'created_date' => date('Y-m-d H:i:s'),
                'manually_adjusted_or_reversed' => 1,
                'debit' => $uploadedAmount
            ];

        }

        // inserting gl account transaction data into db
        $uploadedGLAccountTrans = insert('gl_account_transaction', $glAccountTransData);

        //update acc_gl_account table's organization running balance derived
        

        if($uploadedGLAccountTrans) {
            if($i == $numOfRecords) {
                $_SESSION["upload_successful"] = 1;
                return $_SESSION["upload_successful"];
            }
        } else {
            $_SESSION["upload_failed"] = 1;
            return $_SESSION["upload_failed"];
        }

        $i++;
    }
}