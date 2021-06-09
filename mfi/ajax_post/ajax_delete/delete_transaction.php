<?php
include('../../../functions/connect.php');

$id = 0;
//dd($_POST['id']);
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    if ($id > 0) {
        // Check record exists
        $recordCondition = [
            'id' => $id
        ];
        $findRecord = selectOne('account_transaction', $recordCondition);
        $transactionId = $findRecord['transaction_id'];
        $accountNo = $findRecord['account_no'];
        $institutionId = $findRecord['int_id'];
        $credit = $findRecord['credit'];
        $debit = $findRecord['debit'];
        if ($credit > 0) {
            $findAccount = selectOne('account', ['account_no' => $accountNo]);
            $accountBalance = $findAccount['account_balance_derived'];
            $accountId = $findAccount['id'];
            $productId = $findAccount['product_id'];

            $newBalance = $accountBalance - $credit;
            $updateGlBalance = update('account', $accountId, 'id', ['account_balance_derived'  => $newBalance]);

            $findGl = selectOne('savings_acct_rule', ['savings_product_id' => $productId, 'int_id' => $institutionId]);
            $glcode = $findGl['asst_loan_port'];
            $glConditions = [
                'int_id' => $institutionId,
                'gl_code' => $glcode
            ];
            $findGl = selectOne('acc_gl_account', $glConditions);
            $glBalance = $findGl['organization_running_balance_derived'];
            $glID = $findGl['id'];
            $glParent = $findGl['parent_id'];
            $conditionsGlUpdate = [
                'int_id' => $institutionId,
                'gl_code' => $glcode
            ];
            $newGlBalnce = $glBalance - $credit;
            $updateGlDetails = [
                'organization_running_balance_derived' => $newGlBalnce
            ];
            $updateGlBalance = update('acc_gl_account', $glID, 'id', $updateGlDetails);
        } else {
            $findAccount = selectOne('account', ['account_no' => $accountNo]);
            $accountBalance = $findAccount['account_balance_derived'];
            $accountId = $findAccount['id'];
            $productId = $findAccount['product_id'];

            $newBalance = $accountBalance + $debit;
            $updateGlBalance = update('account', $accountId, 'id', ['account_balance_derived'  => $newBalance]);

            $findGl = selectOne('savings_acct_rule', ['savings_product_id' => $productId, 'int_id' => $institutionId]);
            $glcode = $findGl['asst_loan_port'];
            $glConditions = [
                'int_id' => $institutionId,
                'gl_code' => $glcode
            ];
            $findGl = selectOne('acc_gl_account', $glConditions);
            $glBalance = $findGl['organization_running_balance_derived'];
            $glID = $findGl['id'];
            $glParent = $findGl['parent_id'];
            $conditionsGlUpdate = [
                'int_id' => $institutionId,
                'gl_code' => $glcode
            ];
            $newGlBalnce = $glBalance + $debit;
            $updateGlDetails = [
                'organization_running_balance_derived' => $newGlBalnce
            ];
            $updateGlBalance = update('acc_gl_account', $glID, 'id', $updateGlDetails);
        }
        $deleteTellerRecord = delete('institution_account_transaction', $transactionId, 'transaction_id');
        $deleteGlRecord = delete('gl_account_transaction', $transactionId, 'transaction_id');
        $deleteRecord = delete('account_transaction', $id, 'id');
        if (!$deleteRecord) {
            printf("Error: \n", mysqli_error($connection)); //checking for errors
            exit();
        }
        if ($deleteRecord) {
            echo 1;
            exit;
        } else {
            echo 0;
            exit;
        }
    }
    echo 0;
    exit;
}
