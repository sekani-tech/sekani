<?php

include("../connect.php");
session_start();
$instittutionId = $_SESSION['int_id'];
// find transctions you wish to delete.
$transactionConditions = [
    'description' => "",
    'int_id' => $instittutionId,
];
$findTransactions = selectAll('account_transaction', $transactionConditions);
if (!$findTransactions) {
    printf('Error: %s\n', mysqli_error($connection)); //checking for errors
    exit();
} else {
    // collect account information
    // reverse transaction by crediting or debting account with gotten value from transaction
    foreach ($findTransactions as $data => $transactionData) {
        $id = $transactionData['id'];
        $clientId = $transactionData['client_id'];
        $accountNo = $transactionData['account_no'];
        $credit = $transactionData['credit'];
        $debit = $transactionData['debit'];
        $amount = $transactionData['amount'];

        $accountConditions = [
            'account_no' => $accountNo,
            'client_id' => $clientId
        ];
        $findAccount = selectOne('account', $accountConditions);
        $accountId = $findAccount['id'];
        if ($amount == $credit) {
            $accountBalance =  $findAccount['account_balance_derived'] + $amount;
        } else if ($amount == $debit) {
            $accountBalance =  $findAccount['account_balance_derived'] - $amount;
        }
        $reconcileAccount = update('account', $accountId, 'id', ['account_balance_derived' => $accountBalance]);
        // delete transaction
        if (!$reconcileAccount) {
            printf('Error: %s\n', mysqli_error($connection)); //checking for errors
            exit();
        } else {
            $deleteTransaction = delete('account_transaction', $id, 'id');
            if (!$deleteTransaction) {
                printf('Error: %s\n', mysqli_error($connection)); //checking for errors
                exit();
            } else {
                //output
                echo "Transaction deleted Successfully";
                echo "<br>";
            }
        }
    }
} 
// successfull