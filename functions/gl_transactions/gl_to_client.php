<?php

include("../connect.php");
session_start();
$institutionId = $_SESSION['int_id'];
$branchId = $_SESSION['branch_id'];
// $today = date("Y-m-d");
$user = $_SESSION['user_id'];
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

// check if you got the nesscearry values
if (isset($_POST['account_no']) && isset($_POST['acct_gl'])) {
    $clientAccount = $_POST['account_no'];
    $glAccount = $_POST['acct_gl'];
    $transacionId = $_POST['transid'];
    $description = $_POST['description'];
    $amount = floatval(preg_replace('/[^\d.]/', '', $_POST['amount']));
    $today = $_POST['transDate'];

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

    $checkGlConditions = [
        'int_id' => $institutionId,
        'gl_code' => $glAccount
    ];
    $checkGl = selectOne('acc_gl_account', $checkGlConditions);
    if (!$queryVariable) {
        $error = "Error: \n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Sorry could not Find Chosen GL! - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../mfi/gl_postings.php?message1=$randms");
    } 
    $glBalance = $checkGl['organization_running_balance_derived'];
    if ($glBalance >= $amount) {
        // credit the money from clients account
        // then update te clients current account balance 
        // finally insert transaction history to complete clients debiting process
        $newBalance = $clientBalance + $amount;
        $updateDetails = [
            'account_balance_derived' => $newBalance,
            'last_deposit' => $amount,
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
                'transaction_type' => "credit",
                'transaction_date' => $today,
                'overdraft_amount_derived' => $amount,
                'running_balance_derived' => $newBalance,
                'cumulative_balance_derived' => $newBalance,
                'appuser_id' => $user,
                'credit' => $amount,
                'created_date' => $today
            ];
            $storeTransaction = insert('account_transaction', $transactionDetails);
            if ($storeTransaction) {
                // update gl and record history of transaction
                // updating savings portfolio
                $findSavingsGl = selectOne('savings_acct_rule', ['savings_product_id' => $productId, 'int_id' => $institutionId]);
                $savingsGlcode = $findSavingsGl['asst_loan_port'];
                $savingsGlConditions = [
                    'int_id' => $institutionId,
                    'gl_code' => $savingsGlcode
                ];
                $findGl = selectOne('acc_gl_account', $savingsGlConditions);
                $glBalance = $findGl['organization_running_balance_derived'];
                $glSavingsID = $findGl['id'];
                $glSavingsParent = $findGl['parent_id'];
                // $conditionsGlUpdate = [
                //     'int_id' => $institutionId,
                //     'gl_code' => $savingsGlcode
                // ];
                $newGlBalnce = $glBalance + $amount;
                $updateSavingsGlDetails = [
                    'organization_running_balance_derived' => $newGlBalnce
                ];
                $updateSavingsGlBalance = update('acc_gl_account', $glSavingsID, 'id', $updateSavingsGlDetails);
                if ($updateSavingsGlBalance) {
                    $glSavingsTransactionDetails = [
                        'int_id' => $institutionId,
                        'branch_id' => $branchId,
                        'gl_code' => $savingsGlcode,
                        'parent_id' => $glSavingsParent,
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
                    $storeSavingsGlTransaction = insert('gl_account_transaction', $glSavingsTransactionDetails);
                    if (!$storeSavingsGlTransaction) {
                        printf("<br>1-Error: \n", mysqli_error($connection)); //checking for errors
                        exit();
                    } else {
                        echo "Debit Success <br>";
                    }
                }
                // credit gl
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
                    $updateGlBalance = update('acc_gl_account', $glID, 'id', $updateGlDetails);
                    if ($updateGlBalance) {
                        $glTransactionDetails = [
                            'int_id' => $institutionId,
                            'branch_id' => $branchId,
                            'gl_code' => $glAccount,
                            'parent_id' => $glParent,
                            'transaction_id' => $transacionId,
                            'description' => $description,
                            'transaction_type' => "debit",
                            'transaction_date' => $today,
                            'amount' => $amount,
                            'gl_account_balance_derived' => $newGlBalnce,
                            'overdraft_amount_derived' => $amount,
                            'cumulative_balance_derived' => $newGlBalnce,
                            'debit' => $amount
                        ];
                        $storeGlTransaction = insert('gl_account_transaction', $glTransactionDetails);
                        if ($storeGlTransaction) {
                            // Everything went fine
                            // Sucess feedback
                            $_SESSION["feedback"] = "Expense Income Transaction Successful!";
                            $_SESSION["Lack_of_intfund_$randms"] = "10";
                            echo header("Location: ../../mfi/gl_postings.php?message0=$randms");
                        } else {
                            // Transaction successful but GL record not saved

                            $_SESSION["feedback"] = "Transaction successful but GL record not saved!";
                            $_SESSION["Lack_of_intfund_$randms"] = "10";
                            echo header("Location: ../../mfi/gl_postings.php?message1=$randms");
                        }
                    }
                } else {
                    // something is wrong with gl account

                    $_SESSION["feedback"] = "Sorry could not Find Chosen GL!";
                    $_SESSION["Lack_of_intfund_$randms"] = "10";
                    echo header("Location: ../../mfi/gl_postings.php?message1=$randms");
                }
            } else {
                // client transaction not saved
                $_SESSION["feedback"] = "There was an error Storing Customer's Transaction -  Kindly contact Support!";
                $_SESSION["Lack_of_intfund_$randms"] = "10";
                echo header("Location: ../../mfi/gl_postings.php?message1=$randms");
            }
        } else {
            // customer not be funded
            $_SESSION["feedback"] = "Could not credit money from customer!";
            $_SESSION["Lack_of_intfund_$randms"] = "10";
            echo header("Location: ../../mfi/gl_postings.php?message1=$randms");
        }
    } else {
        // insufficient account balance
        $_SESSION["feedback"] = "Insufficient Balance in GL Account!";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../mfi/gl_postings.php?message1=$randms");
    }
} else {

    $_SESSION["feedback"] = "Provide the Necessary Information!";
    $_SESSION["Lack_of_intfund_$randms"] = "10";
    echo header("Location: ../../mfi/gl_postings.php?message1=$randms");
}
