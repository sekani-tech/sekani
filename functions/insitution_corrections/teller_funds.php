<?php

include('../connect.php');
session_start();
$institutionId = $_SESSION['int_id'];
$glCode = "10102";
// find transactions that do not exists in journal
// first find the gl associated with the products.

$findMissingTransactions = mysqli_query($connection, "SELECT * FROM `institution_account_transaction` WHERE transaction_id NOT IN (SELECT transaction_id FROM gl_account_transaction WHERE gl_code = $glCode AND int_id = $insitutionId)");
// dd($findMissingTransactionsQuery);

if ($findMissingTransactions) {
    while (mysqli_num_rows($findMissingTransactions) > 0) {
        $details = mysqli_fetch_array($findMissingTransactions);
        $credit = $details['credit'];
        $debit = $details['debit'];
        // $glConditions = [
        //     'int_id' => $insitutionId,
        //     'gl_code' => $glCode
        // ];
        // $findGl = selectOne('acc_gl_account', $glConditions);
        // $glBalance = $findGl['organization_running_balance_derived'];
        
        if ($credit > 0.00) {
            $glConditions = [
                'int_id' => $institutionId,
                'gl_code' => $glCode
            ];
            $findGl = selectOne('acc_gl_account', $glConditions);
            $glBalance = $findGl['organization_running_balance_derived'];
            $glID = $findGl['id'];
            $glParent = $findGl['parent_id'];
            $conditionsGlUpdate = [
                'int_id' => $institutionId,
                'gl_code' => $glcode
            ];
            $newGlBalnce = $glBalance + $credit;
            $updateGlDetails = [
                'organization_running_balance_derived' => $newGlBalnce
            ];
            $updateGlBalance = update('acc_gl_account', $glID, 'id', $updateGlDetails);
            if ($updateGlBalance) {
                $glTransactionDetails = [
                    'int_id' => $institutionId,
                    'branch_id' => $details['branch_id'],
                    'gl_code' => $glcode,
                    'parent_id' => $glParent,
                    'transaction_id' => $details['transaction_id'],
                    'description' => $details['description'],
                    'transaction_type' => $details['transaction_type'],
                    'transaction_date' => $details['transaction_date'],
                    'amount' => $details['amount'],
                    'gl_account_balance_derived' => $newGlBalnce,
                    'overdraft_amount_derived' => $details['amount'],
                    'cumulative_balance_derived' => $newGlBalnce,
                    'credit' => $credit
                ];
                $storeGlTransaction = insert('gl_account_transaction', $glTransactionDetails);
                if (!$storeGlTransaction) {
                    printf("<br>1-Error: \n", mysqli_error($connection)); //checking for errors
                    exit();
                } else {
                    echo "Credit Success <br>";
                }
            }
        } else{
            $glConditions = [
                'int_id' => $institutionId,
                'gl_code' => $glCode
            ];
            $findGl = selectOne('acc_gl_account', $glConditions);
            $glBalance = $findGl['organization_running_balance_derived'];
            $glID = $findGl['id'];
            $glParent = $findGl['parent_id'];
            $conditionsGlUpdate = [
                'int_id' => $institutionId,
                'gl_code' => $glcode
            ];
            $newGlBalnce = $glBalance - $debit;
            $updateGlDetails = [
                'organization_running_balance_derived' => $newGlBalnce
            ];
            $updateGlBalance = update('acc_gl_account', $glID, 'id', $updateGlDetails);
            if ($updateGlBalance) {
                $glTransactionDetails = [
                    'int_id' => $institutionId,
                    'branch_id' => $details['branch_id'],
                    'gl_code' => $glcode,
                    'parent_id' => $glParent,
                    'transaction_id' => $details['transaction_id'],
                    'description' => $details['description'],
                    'transaction_type' => $details['transaction_type'],
                    'transaction_date' => $details['transaction_date'],
                    'amount' => $details['amount'],
                    'gl_account_balance_derived' => $newGlBalnce,
                    'overdraft_amount_derived' => $details['amount'],
                    'cumulative_balance_derived' => $newGlBalnce,
                    'debit' => $debit
                ];
                $storeGlTransaction = insert('gl_account_transaction', $glTransactionDetails);
                if (!$storeGlTransaction) {
                    printf("<br>1-Error: \n", mysqli_error($connection)); //checking for errors
                    exit();
                } else {
                    echo "Debit Success <br>";
                }
            }
        }
    }
}
