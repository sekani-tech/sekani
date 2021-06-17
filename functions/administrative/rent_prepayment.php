<?php

include("../connect.php");
session_start();



// collect session data
$institutionId = $_SESSION['int_id'];
$branchId = $_SESSION['branch_id'];
$today = date("Y-m-d");
$user = $_SESSION['user_id'];
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

if (isset($_POST['amount']) && isset($_POST['transDate'])) {
    // declaring varaibles 
    $rentDate = $_POST['transDate'];
    $amount = floatval(preg_replace('/[^\d.]/', '', $_POST['amount']));
    $prepayGl = $_POST['prepay_gl'];
    $expenseGl = $_POST['expense_gl'];
    $numberOfYears = $_POST['no_of_years'] * 12;
    $transactionId = "RENT_PREPAY" . $randms;

    // get year from date
    $year =  getYear($rentDate);
    $description = "RENT_FOR_THE_YEAR_" . $year;
    // find if rent for year has been created already
    $yearSearchConditions = [
        'int_id' => $institutionId,
        'branch_id' => $branchId,
        'year' => $year
    ];
    $yearSearch = selectOne("prepayment_account", $yearSearchConditions);
    $foundYear = $yearSearch['year'];
    if ($foundYear != "") {
        $_SESSION["feedback"] = " Prepayment already booked for this year ";
        $_SESSION["Lack_of_intfund_$randms"] = "0";
        echo header("Location: ../../mfi/rent_repayment.php?message1=$randms-6");
        exit();
    }

    // collect gl account data
    $prepayGlConditions = [
        'int_id' => $institutionId,
        'branch_id' => $branchId,
        'gl_code' => $prepayGl
    ];
    $findPrepayGl = selectOne("acc_gl_account", $prepayGlConditions);
    if (!$findPrepayGl) {
        $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Could not find Prepayment GL  - " . $error;
        $_SESSION["Lack_of_intfund_$randms"] = "0";
        echo header("Location: ../../mfi/rent_repayment.php?message1=$randms-7");
        exit();
    }
    $currentPrepayBalance = $findPrepayGl['organization_running_balance_derived'];
    $prepayParentId = $findPrepayGl['parent_id'];
    $prepayGlId = $findPrepayGl['id'];

    $newBalance = $currentPrepayBalance + $amount;
    $updateGlDetails = [
        'organization_running_balance_derived' => $newBalance
    ];
    $updatePrepayGL = update('acc_gl_account', $prepayGlId, 'id', $updateGlDetails);
    if (!$updatePrepayGL) {
        $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = " Could not fund Prepayment GL - " . $error;
        $_SESSION["Lack_of_intfund_$randms"] = "1";
        echo header("Location: ../../mfi/rent_repayment.php?message1=$randms-2");
        exit();
    } else {
        $prepayTransactionDetails = [
            'int_id' => $institutionId,
            'branch_id' => $branchId,
            'gl_code' => $prepayGl,
            'parent_id' => $prepayParentId,
            'transaction_id' => $transactionId,
            'description' => $description,
            'transaction_type' => "Credit",
            'transaction_date' => $today,
            'amount' => $amount,
            'gl_account_balance_derived' => $newBalance,
            'overdraft_amount_derived' => $amount,
            'cumulative_balance_derived' => $newBalance,
            'credit' => $amount
        ];

        $storePrepayTransaction = insert('gl_account_transaction', $prepayTransactionDetails);
        if (!$storePrepayTransaction) {
            $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
            $_SESSION["feedback"] = " Could not store Prepayment transaction details - " . $error;
            $_SESSION["Lack_of_intfund_$randms"] = "1";
            echo header("Location: ../../mfi/rent_repayment.php?message1=$randms-2");
            exit();
        } else {
            // go ahead and generate prepayement data
            // like maturity date
            $maturityDate = addMonth($rentDate, $numberOfYears);
            $prepaymentAccountDetails = [
                'int_id' => $institutionId,
                'branch_id' => $branchId,
                'year' => $year,
                'amount' => $amount,
                'gl_code' => $prepayGl,
                'expense_gl_code' => $expenseGl,
                'prepayment_made' => 0,
                'start_date' => $rentDate,
                'end_date' => $maturityDate,
                'created_by' => $user
            ];
            $createPrepaymentAccount = insert('prepayment_account', $prepaymentAccountDetails);
            $prepaymentAccountId = $createPrepaymentAccount;
            if (!$storePrepayTransaction) {
                $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
                $_SESSION["feedback"] = " Could not book prepayment - " . $error;
                $_SESSION["Lack_of_intfund_$randms"] = "1";
                echo header("Location: ../../mfi/rent_repayment.php?message1=$randms-3");
                exit();
            } else {
                $prepayAmount = $amount / $numberOfYears;
                $i = 1;
                while ($i <= $numberOfYears) {
                    $repayDate = addMonth($rentDate, $i);
                    echo $repayDate . '</br>';
                    $prepaymentScheduledetails = [
                        'int_id' => $institutionId,
                        'branch_id' => $branchId,
                        'prepayment_account_id' => $prepaymentAccountId,
                        'expense_date' => $repayDate,
                        'expense_amount' => $prepayAmount
                    ];
                    $createPrepaymentSchedule = insert('prepayment_schedule', $prepaymentScheduledetails);
                    $i++;
                    if ($maturityDate == $repayDate) {
                        $_SESSION["feedback"] = " Prepayment sucessfully initiated ";
                        $_SESSION["Lack_of_intfund_$randms"] = "1";
                        echo header("Location: ../../mfi/rent_repayment.php?message0=$randms");
                        exit();
                    }
                }
            }
        }
    }
    # !ENDS HERE
} else {
    $_SESSION["feedback"] = " Kindly Provide provide all necessary detail ";
    $_SESSION["Lack_of_intfund_$randms"] = "1";
    echo header("Location: ../../mfi/rent_repayment.php?message0=$randms");
    exit();
}
