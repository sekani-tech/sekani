<?php

include("../connect.php");
session_start();
$institutionId = $_SESSION['int_id'];
$branchId = $_SESSION['branch_id'];
// $today = date("Y-m-d");
$user = $_SESSION['user_id'];
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

if (isset($_POST['amount']) && isset($_POST['income_gl']) && isset($_POST['expense_gl'])) {
    $incomeGl = $_POST['income_gl'];
    $expenseGl = $_POST['expense_gl'];
    $amount = floatval(preg_replace('/[^\d.]/', '', $_POST['amount']));
    $transactionId = $_POST['transid'];
    $description = $_POST['description'];
    $today = $_POST['transDate'];

    $incomeConditions = [
        'gl_code' => $incomeGl,
        'int_id' => $institutionId,
        'branch_id' => $branchId
    ];
    $findIncomeGl = selectOne('acc_gl_account', $incomeConditions);
    $currentIncomeBalance = $findIncomeGl['organization_running_balance_derived'];
    $incomeParentId = $findIncomeGl['parent_id'];
    $incomeGlId = $findIncomeGl['id'];
    if ($currentIncomeBalance >= $amount) {
        $newincomeBalance = $currentIncomeBalance - $amount;
        // now find necessary details for expense gl
        $expenseConditions = [
            'gl_code' => $expenseGl,
            'int_id' => $institutionId,
            'branch_id' => $branchId,
        ];
        $findExpenseGl = selectOne('acc_gl_account', $expenseConditions);
        $currentExpenseBalance = $findExpenseGl['organization_running_balance_derived'];
        $expenseParentId = $findExpenseGl['parent_id'];
        $expenseGlId = $findExpenseGl['id'];
        $newExpenseBalance = $currentExpenseBalance + $amount;

        // update income balance so as to show dedection and provide
        // transaction details
        $updateGlDetails = [
            'organization_running_balance_derived' => $newincomeBalance
        ];
        $updateIncomeGL = update('acc_gl_account', $incomeGlId, 'id', $updateGlDetails);
        if ($updateIncomeGL) {
            $updateExpenseGlDetails = [
                'organization_running_balance_derived' => $newExpenseBalance
            ];
            $updateExpanseGl = update('acc_gl_account', $expenseGlId, 'id', $updateExpenseGlDetails);
        } else {
            if (!$updateIncomeGL) {
                printf('Error: %s\n', mysqli_error($connection)); //checking for errors
                exit();
            }
        }
        if ($updateExpanseGl) {
            $incomeTransactionDetails = [
                'int_id' => $institutionId,
                'branch_id' => $branchId,
                'gl_code' => $incomeGl,
                'parent_id' => $incomeParentId,
                'transaction_id' => $transactionId,
                'description' => $description,
                'transaction_type' => "debit",
                'transaction_date' => $today,
                'amount' => $amount,
                'gl_account_balance_derived' => $newincomeBalance,
                'overdraft_amount_derived' => $amount,
                'cumulative_balance_derived' => $newincomeBalance,
                'debit' => $amount
            ];

            $storeIncomeTransaction = insert('gl_account_transaction', $incomeTransactionDetails);
            if ($storeIncomeTransaction) {
                $expenseTransactionDetails = [
                    'int_id' => $institutionId,
                    'branch_id' => $branchId,
                    'gl_code' => $expenseGl,
                    'parent_id' => $expenseParentId,
                    'transaction_id' => $transactionId,
                    'description' => $description,
                    'transaction_type' => "credit",
                    'transaction_date' => $today,
                    'amount' => $amount,
                    'gl_account_balance_derived' => $newExpenseBalance,
                    'overdraft_amount_derived' => $amount,
                    'cumulative_balance_derived' => $newExpenseBalance,
                    'credit' => $amount
                ];

                $storeExpenseTransaction = insert('gl_account_transaction', $expenseTransactionDetails);
                if ($storeExpenseTransaction) {
                    $_SESSION["feedback"] = "Transaction Successful!";
                    $_SESSION["Lack_of_intfund_$randms"] = "10";
                    echo header("Location: ../../mfi/gl_postings.php?message0=$randms");
                } else {
                    // everything was fine until the last moment
                    // could not store transaction details for expense gl
                    $_SESSION["feedback"] = "Error storing record for expense GL!";
                    $_SESSION["Lack_of_intfund_$randms"] = "10";
                    echo header("Location: ../../mfi/gl_postings.php?message1=$randms");
                }
            } else {
                // income transaction not stored for some weird reason
                $_SESSION["feedback"] = "Error storing record for income GL!";
                $_SESSION["Lack_of_intfund_$randms"] = "10";
                echo header("Location: ../../mfi/gl_postings.php?message1=$randms");
            }
        }
    } else {
        // not enough funds
        $_SESSION["feedback"] = "Not enough funds!";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../mfi/gl_postings.php?message1=$randms");
    }
} else {
    // provide all necessary information
    $_SESSION["feedback"] = "Kindly provide all Neccessary Information!";
    $_SESSION["Lack_of_intfund_$randms"] = "10";
    echo header("Location: ../../mfi/gl_postings.php?message1=$randms");
}
