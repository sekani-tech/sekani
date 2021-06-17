<?php
include("../../connect.php");
session_start();
$institutionId = $_SESSION["int_id"];
$senderId = $_SESSION["sender_id"];
$nm = $_SESSION["username"];
$user_id = $_SESSION["user_id"];
$gen_date = date("Y-m-d");

$approve = $_POST['submit'];
$decline = $_POST['submit'];
$expenseId = $_POST['id'];
$digits = 9;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
if ($approve == "approve") {
    $findTransaction = selectOne('transact_cache', ['id' => $expenseId]);
    $acct_no = $findTransaction['account_no'];
    $branchId = $findTransaction['branch_id'];
    $transactionId = $findTransaction['transact_id'];
    // find out if transaction id exists
    // $findDuplicate = selectOne('transact_cache', ['int_id' => $institutionId, 'transact_id' => $transactionId, 'status' => 'Verified']);
    // dd($findTransaction);
    // if (!$findDuplicate) {
    //     $error = "Error: \n" . mysqli_error($connection); //checking for errors
    //     $_SESSION["feedback"] = "Sorry something may be wrong with transaction - " . $error;
    //     $_SESSION["Lack_of_intfund_$randms"] = "9";
    //     echo header("Location: ../../../mfi/expense_approval.php?message1=$randms");
    // } else {
    //     $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
    //     $_SESSION["feedback"] = "Sorry Transaction may already have been approved - " . $error;
    //     $_SESSION["Lack_of_intfund_$randms"] = "9";
    //     echo header("Location: ../../../mfi/expense_approval.php?message1=$randms");
    // }
    $description = $findTransaction['description'];
    $amount = $findTransaction['amount'];
    $isBank = $findTransaction['is_bank'];
    $staffId = $findTransaction['staff_id'];
    $transactType = $findTransaction['transact_type'];
    $transactionDate = $findTransaction['date'];
    // $paymentType = $findTransaction['']
    $findExpenseGl = selectOne("acc_gl_account", ['gl_code' => $acct_no]);
    if (!$findExpenseGl) {
        $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Sorry Expense GL does not exist - " . $error;
        $_SESSION["Lack_of_intfund_$randms"] = "9";
        echo header("Location: ../../../mfi/expense_approval.php?message1=$randms");
    }
    $expenseGlId = $findExpenseGl['id'];
    $expenseParentId = $findExpenseGl['parent_id'];
    $runningExpenseBalance = $findExpenseGl['organization_running_balance_derived'];
    $newExpenseBalance = $runningExpenseBalance + $amount;
    $updateValues = [
        'organization_running_balance_derived' => $newExpenseBalance
    ];
    $updateExpenseGl = update("acc_gl_account", $expenseGlId, 'id', $updateValues);

    // importing the needed on the gl
    if ($updateExpenseGl) {
        $transactionExpenseHistory = [
            'int_id' => $institutionId,
            'branch_id' => $branchId,
            'gl_code' => $acct_no,
            'parent_id' => $expenseParentId,
            'description' => $description,
            'transaction_id' => $transactionId,
            'transaction_type' => 'Credit',
            'transaction_date' => $gen_date,
            'amount' => $amount,
            'credit' => $amount,
            'gl_account_balance_derived' => $newExpenseBalance
        ];
        $transactionExpenseDetail = insert('gl_account_transaction', $transactionExpenseHistory);
        if ($transactionExpenseDetail) {
            // find if payment method is bank or not
            // $findIsBank = selectOne("payment_type", ['id' => $pym]);
            // $isBank = $findIsBank['is_bank'];
            // $bankGlCode = $findIsBank['gl_code'];
            // dd($isBank);
            // make deduction from bank
            if ($isBank == 1) {
                $glQuery = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE gl_code = '$bankGlCode' && int_id = '$institutionId'");
                $findBankgl = mysqli_fetch_array($glQuery); // dd($findBankgl);
                $bankParentId = $findBankgl['parent_id'];
                $runningBalance = $findBankgl['organization_running_balance_derived'];
                $newBalance = $runningBalance - $gl_amt;
                // now update gl balance
                $updateGlBalance = "UPDATE `acc_gl_account` SET `organization_running_balance_derived` = '$newBalance' WHERE int_id = '$institutionId' && gl_code = '$bankGlCode'";
                $updated = mysqli_query($connection, $updateGlBalance);
                if (!$updated) {
                    $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
                    $_SESSION["feedback"] = "Sorry could update Bank balance - " . $error;
                    $_SESSION["Lack_of_intfund_$randms"] = "9";
                    echo header("Location: ../../../mfi/expense_approval.php?message1=$randms");
                } else {
                    $transactionHistory = [
                        'int_id' => $institutionId,
                        'branch_id' => $branchId,
                        'gl_code' => $bankGlCode,
                        'parent_id' => $bankParentId,
                        'description' => $description,
                        'transaction_id' => $transactionId,
                        'transaction_type' => 'Debit',
                        'transaction_date' => $gen_date,
                        'amount' => $amount,
                        'debit' => $amount,
                        'gl_account_balance_derived' => $newBalance
                    ];
                    $transactionDetail = insert('gl_account_transaction', $transactionHistory);
                    // dd($transactionDetail);
                    // var_dump($transactionDetail);
                    if ($transactionDetail) {
                        // now we will send a mail
                        $v = "Verified";
                        $updateTrans = "UPDATE transact_cache SET `status` = '$v' WHERE int_id = '$institutionId' && id='$expenseId'";
                        $resl = mysqli_query($connection, $updateTrans);
                        if ($resl) {
                            $_SESSION["feedback"] = "Transaction Successful";
                            $_SESSION["Lack_of_intfund_$randms"] = "9";
                            echo header("Location: ../../../mfi/expense_approval.php?message0=$randms");
                        } else {
                            $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
                            $_SESSION["feedback"] = "Sorry, Transaction successful but could not change approval status - " . $error;
                            $_SESSION["Lack_of_intfund_$randms"] = "9";
                            echo header("Location: ../../../mfi/expense_approval.php?message1=$randms");
                        }
                    } else {
                        $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
                        $_SESSION["feedback"] = "Transaction successful - Could not store bank transaction record, - " . $error;
                        $_SESSION["Lack_of_intfund_$randms"] = "9";
                        echo header("Location: ../../../mfi/expense_approval.php?message1=$randms");
                    }
                }
            } else {
                $findTellersTill = selectOneWithOr('institution_account', ['int_id' => $institutionId, 'teller_id' => $staffId], 'submittedon_userid', $staffId);
                $tillId = $findTellersTill['id'];
                $tellerBalance = $findTellersTill["account_balance_derived"];
                $totalWithdrwalBalance = $findTellersTill["total_withdrawals_derived"];
                $newTotalWithdrawal = $totalWithdrwalBalance - $amount;
                $newTellerBalance = $tellerBalance - $amount;
                $tellersUpdateValue = [
                    'account_balance_derived' => $newTellerBalance,
                    'total_withdrawals_derived' => $totalWithdrwalBalance
                ];
                if ($tellerBalance >= $amount) {
                    $updateTill = update('institution_account', $tillId, 'id', $tellersUpdateValue);
                    if ($updateTill) {
                        $tellerTransactionDetails = [
                            'int_id' => $institutionId,
                            'branch_id' => $branchId,
                            'client_id' => $acct_no,
                            'transaction_id' => $transactionId,
                            'description' => $description,
                            'transaction_type' => $transactType,
                            'teller_id' => $staffId,
                            'is_reversed' => 0,
                            'transaction_date' => $transactionDate,
                            'amount' => $amount,
                            'running_balance_derived' => $newTellerBalance,
                            'overdraft_amount_derived' => $amount,
                            'created_date' => $gen_date,
                            'appuser_id' => $user_id,
                            'debit' => $amount
                        ];
                        $storeTellerTransaction = insert('institution_account_transaction', $tellerTransactionDetails);
                        if (!$storeTellerTransaction) {
                            $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
                            $_SESSION["feedback"] = "Sorry could not store transaction record in tellers till - " . $error;
                            $_SESSION["Lack_of_intfund_$randms"] = "9";
                            echo header("Location: ../../../mfi/expense_approval.php?message1=$randms");
                        } else {
                            $v = "Verified";
                            $updateTrans = "UPDATE transact_cache SET `status` = '$v' WHERE int_id = '$institutionId' && id='$expenseId'";
                            $resl = mysqli_query($connection, $updateTrans);
                            if ($resl) {
                                $_SESSION["feedback"] = "Transaction Successful";
                                $_SESSION["Lack_of_intfund_$randms"] = "9";
                                echo header("Location: ../../../mfi/expense_approval.php?message0=$randms");
                            } else {
                                $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
                                $_SESSION["feedback"] = "Sorry Expense GL does not exist - " . $error;
                                $_SESSION["Lack_of_intfund_$randms"] = "9";
                                echo header("Location: ../../../mfi/expense_approval.php?message1=$randms");
                            }
                        }
                    }
                } else {
                    $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
                    $_SESSION["feedback"] = "Sorry Insufficeint fund in tellers till - " . $error;
                    $_SESSION["Lack_of_intfund_$randms"] = "9";
                    echo header("Location: ../../../mfi/expense_approval.php?message1=$randms");
                }
            }
        } else {
            $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
            $_SESSION["feedback"] = "Sorry could not Expense to chossen GL - " . $error;
            $_SESSION["Lack_of_intfund_$randms"] = "9";
            echo header("Location: ../../../mfi/expense_approval.php?message1=$randms");
        }
        // FINAL
    }
}
