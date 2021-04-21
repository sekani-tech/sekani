<?php

include("../connect.php");
session_start();
$institutionId = $_SESSION['int_id'];
$branchId = $_SESSION['branch_id'];
$today = date("Y-m-d");
$user = $_SESSION['user_id'];
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

// check if you got the nesscearry values
if (isset($_POST['account_no']) && isset($_POST['acct_gl'])) {
    $clientAccount = $_POST['account_no'];
    $glAccount = $_POST['acct_gl'];
    $transacionId = $_POST['transid'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];

    // first check if client has sufficient balance
    $conditions = [
        'int_id' => $institutionId,
        'account_no' => $clientAccount
    ];

    $checkAccount = selectOne('account', $conditions);
    $clientBalance = $checkAccount['account_balance_derived'];
    $accountId = $checkAccount['id'];
    $productID = $checkAccount['product_id'];
    $clientId = $checkAccount['client_id'];
    if ($clientBalance >= $amount) {
        // take the money from clients account
        // then update te clients current account balance 
        // finally insert transaction history to complete clients debiting process
        $newBalance = $clientBalance - $amount;
        $updateDetails = [
            'account_balance_derived' => $newBalance,
            'last_withdrawal' => $amount,
            'last_activity_date' => $today,
        ];
        $updateCondition = [
            'int_id' => $institutionId,
            'account_no' => $clientAccount
        ];
        $updateBalance = update('account', $clientAccount, 'account_no', $updateDetails);
        if ($updateBalance) {
            // for future reference 
            // do note the following information in the transactionDetails array
            // are all the information you must provide 
            // when storing a transaction
            $transactionDetails = [
                'int_id' => $institutionId,
                'branch_id' => $branchId,
                'amount' => $amount,
                'transaction_id' => $transacionId,
                'description' => $description,
                'account_no' => $clientAccount,
                'product_id' => $productID,
                'client_id' => $clientId,
                'transaction_type' => "debit",
                'transaction_date' => $today,
                'overdraft_amount_derived' => $amount,
                'running_balance_derived' => $newBalance,
                'cumulative_balance_derived' => $newBalance,
                'appuser_id' => $user,
                'debit' => $amount
            ];
            $storeTransaction = insert('account_transaction', $transactionDetails);
            if ($storeTransaction) {
                // update gl and record history of transaction
                $glConditions = [
                    'int_id' => $institutionId,
                    'gl_code' => $glAccount
                ];
                $findGl = selectOne('acc_gl_account', $glConditions);
                $glBalance = $findGl['organization_running_balance_derived'];
                $glID = $findGl['id'];
                $glParent = $findGl['parent_id'];

                if ($findGl) {
                    $newGlBalnce =  $glBalance - $amount;
                    $conditionsGlUpdate = [
                        'int_id' => $institutionId,
                        'gl_code' => $glAccount
                    ];
                    $updateGlDetails = [
                        'organization_running_balance_derived' => $newGlBalnce
                    ];
                    $updateGlBalance = update('acc_gl_account', $glAccount, 'gl_code', $updateGlDetails);
                    if ($updateGlBalance) {
                        $glTransactionDetails = [
                            'int_id' => $institutionId,
                            'branch_id' => $branchId,
                            'gl_code' => $glAccount,
                            'parent_id' => $glParent,
                            'transaction_id' => $transacionId,
                            'description' => $description,
                            'transaction_type' => "credit",
                            'transaction_date' => $today,
                            'amount' => $amount,
                            'gl_account_balance_derived' => $newGlBalnce,
                            'overdraft_amount_derived' => $amount,
                            'cumulative_balance_derived' => $newGlBalnce,
                            'credit' => $amount
                        ];
                        $storeGlTransaction = insert('gl_account_transaction', $glTransactionDetails);
                        if ($storeGlTransaction) {
                            // Everything went fine
                            // Sucess feedback
                            $_SESSION["Lack_of_intfund_$randms"] = "Income Transaction Successful!";
                            echo header("Location: ../../mfi/gl_postings.php?income1=$randms");
                        } else {
                            // Transaction successful but GL record not saved
                            $_SESSION["Lack_of_intfund_$randms"] = "Transaction successful but GL record not saved!";
                            echo header("Location: ../../mfi/gl_postings.php?income2=$randms");
                        }
                    }
                } else {
                    // something is wrong with gl account
                    $_SESSION["Lack_of_intfund_$randms"] = "Sorry could not Find Chosen GL!";
                    echo header("Location: ../../mfi/gl_postings.php?income3=$randms");
                }
            } else {
                // client transaction not saved
                $_SESSION["Lack_of_intfund_$randms"] = "There was an error Storing Customer's Transaction \n Kindly contact Support!";
                echo header("Location: ../../mfi/gl_postings.php?income4=$randms");
            }
        } else {
            // customer not deducted
            $_SESSION["Lack_of_intfund_$randms"] = "Could not deduct money from customer!";
            echo header("Location: ../../mfi/gl_postings.php?income5=$randms");
        }
    } else {
        // insufficient account balance
        $_SESSION["Lack_of_intfund_$randms"] = "Insufficient Balance in Customers Account!";
        echo header("Location: ../../mfi/gl_postings.php?income6=$randms");
    }
} else {
    $_SESSION["Lack_of_intfund_$randms"] = "Provide the Necessary Information!";
    echo header("Location: ../../mfi/gl_postings.php?income7=$randms");
}
