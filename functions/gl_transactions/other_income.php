<?php
// collect system and realtime data 
include("../connect.php");
session_start();
$institutionId = $_SESSION['int_id'];
$branchId = $_SESSION['branch_id'];
// $today = date("Y-m-d");
$user = $_SESSION['user_id'];
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

// intialize post data 
$incomeGl = $_POST['acct_gl'];
$amount = floatval(preg_replace('/[^\d.]/', '', $_POST['amount']));
$description = $_POST['descrip'];
$transactionId = $_POST['transid'];
$today = $_POST['transDate'];


// collect gl account data
$incomeGlConditions = [
    'int_id' => $institutionId,
    'branch_id' => $branchId,
    'gl_code' => $incomeGl
];
$findIncomeGl = selectOne("acc_gl_account", $incomeGlConditions);
if($findIncomeGl['manual_journal_entries_allowed'] != 1){
    $_SESSION["feedback"] = "Can't post in this GL, Manual entry not allowed!!";
    $_SESSION["Lack_of_intfund_$randms"] = "10";
    echo header("Location: ../../mfi/gl_postings.php?message1=$randms");
    exit();
}
$currentIncomeBalance = $findIncomeGl['organization_running_balance_derived'];
$incomeParentId = $findIncomeGl['parent_id'];
$incomeGlId = $findIncomeGl['id'];

$newBalance = $currentIncomeBalance + $amount;

if ($findIncomeGl) {
    $updateGlDetails = [
        'organization_running_balance_derived' => $newBalance
    ];
    $updateIncomeGL = update('acc_gl_account', $incomeGlId, 'id', $updateGlDetails);
    if ($updateIncomeGL) {

        $incomeTransactionDetails = [
            'int_id' => $institutionId,
            'branch_id' => $branchId,
            'gl_code' => $incomeGl,
            'parent_id' => $incomeParentId,
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

        $storeIncomeTransaction = insert('gl_account_transaction', $incomeTransactionDetails);
        if ($storeIncomeTransaction) {
            $_SESSION["feedback"] = "Transaction Successful!";
            $_SESSION["Lack_of_intfund_$randms"] = "10";
            echo header("Location: ../../mfi/gl_postings.php?message0=$randms");
        } else {
            // income transaction not stored for some weird reason
            $_SESSION["feedback"] = "Error storing Transaction record income GL!";
            $_SESSION["Lack_of_intfund_$randms"] = "10";
            echo header("Location: ../../mfi/gl_postings.php?message1=$randms");
        }
    } else {
        // income transaction not stored for some weird reason
        $_SESSION["feedback"] = "Error Funding GL!";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../mfi/gl_postings.php?message1=$randms");
    }
} else {
    // can't find gl
    // income transaction not stored for some weird reason
    $_SESSION["feedback"] = "Can't find GL or GL does not exist!";
    $_SESSION["Lack_of_intfund_$randms"] = "10";
    echo header("Location: ../../mfi/gl_postings.php?message1=$randms");
}
