<?php
session_start();
include "../functions/connect.php";

    $int_id = $_SESSION['int_id'];
    $transact_date = $_SESSION['transact_date'];
    $newDate = date("Y-m-d", strtotime($transact_date));
    $branch_id = $_SESSION['branch_id'];
    $today = date("Y-m-d");
$condition = [
            'int_id' => $_SESSION['int_id'],
        ];
$data = [
        'transaction_date' => $newDate,
        'branch_id' => $_SESSION['branch_id'],
        'int_id' => $_SESSION['int_id'],
        'manual_posted' => 1
    ];
$rand = 7;
$randstring = str_pad(rand(0, pow(10, $rand) - 1), $rand, '0', STR_PAD_LEFT);

$findTeller = selectAll('institution_account', $condition);
foreach($findTeller as $teller_data){
$amount = $teller_data['account_balance_derived'];
$tellerId = $teller_data['teller_id'];
$tellerGlCode = $teller_data['gl_code'];

$check_vault_amount = selectOne('int_vault',$condition);
            $vault_amount = $check_vault_amount['balance'];
            $vault_gl = $check_vault_amount['gl_code'];
            $newBalance = $vault_amount + $amount;
     $update_vault_amount = mysqli_query($connection, "UPDATE int_vault SET balance = '$newBalance' WHERE int_id = '$int_id' ");
     if($update_vault_amount){ 
        $glConditions = [
                        'int_id' => $int_id,
                        'branch_id' => $branch_id,
                        'gl_code' => $vault_gl
                    ];
        $findGl = selectOne('acc_gl_account', $glConditions);
                $glBalance = $findGl['organization_running_balance_derived'];
                $glID = $findGl['id'];
                $glParent = $findGl['parent_id'];
                $glAccount = $findGl['gl_code'];
 
                if ($findGl) {
                    $newGlBalnce =  $glBalance + $newBalance;
                    $conditionsGlUpdate = [
                        'int_id' => $int_id,
                        'gl_code' => $glAccount
                    ];
                    $updateGlDetails = [
                        'organization_running_balance_derived' => $newGlBalnce
                    ];
                    $updateGlBalance = update('acc_gl_account', $glID, 'id', $updateGlDetails);
                    if ($updateGlBalance) {
                        $glTransactionDetails = [
                            'int_id' => $int_id,
                            'branch_id' => $branch_id,
                            'gl_code' => $glAccount,
                            'parent_id' => $glParent,
                            'transaction_id' => $randstring,
                            'description' => 'Vault Transaction',
                            'transaction_type' => "credit",
                            'transaction_date' => $today,
                            'amount' => $newBalance,
                            'gl_account_balance_derived' => $newGlBalnce,
                            'overdraft_amount_derived' => $newBalance,
                            'cumulative_balance_derived' => $newGlBalnce,
                            'credit' => $newBalance
                        ];
                        $storeVaultTransaction = insert('gl_account_transaction', $glTransactionDetails);
                            if($storeVaultTransaction){
                                
                            $glConditions = [
                        'int_id' => $int_id,
                        'branch_id' => $branch_id,
                        'gl_code' => $tellerGlCode
                    ];
        $findGl = selectOne('acc_gl_account', $glConditions);
                $glBalance = $findGl['organization_running_balance_derived'];
                $glID = $findGl['id'];
                $glParent = $findGl['parent_id'];
                $glAccount = $findGl['gl_code'];



                                        $newGlBalance =  $glBalance - $amount;
                                        $updateGlBalance = update('acc_gl_account', $glID, 'id', $updateGlDetails);

                                        $glTransactionDetails = [
                                        'int_id' => $int_id,
                                        'branch_id' => $branch_id,
                                        'gl_code' => $tellerGlCode,
                                        'parent_id' => $glParent,
                                        'transaction_id' => $randstring,
                                        'description' => 'Vault In',
                                        'transaction_type' => "debit",
                                        'transaction_date' => $today,
                                        'amount' => $amount,
                                        'gl_account_balance_derived' => $newGlBalance,
                                        'overdraft_amount_derived' => $amount,
                                        'cumulative_balance_derived' => $newGlBalance,
                                        'debit' => $amount
                                    ];
                                    $storeTellerTransaction = insert('gl_account_transaction', $glTransactionDetails);
                                    if ($storeTellerTransaction){
                                        $updateTellerDetails = ['account_balance_derived' => 0];
                                        $updateTellerBalance = update('institution_account', $branch_id, $int_id, $updateTellerDetails);
                        if ($updateTellerBalance){
$insertendofday = insert('endofday_tb', $data);
if($updateTellerBalance){
    $intvaultdata = [
                                        'int_id' => $int_id,
                                        'branch_id' => $branch_id,
                                        'teller_id' => $tellerId,
                                        'transaction_id' => $randstring,
                                        'description' => 'Vault Transaction',
                                        'transaction_type' => "vault in",
                                        'transaction_date' => $today,
                                        'amount' => $amount,
                                        'vault_balance_derived' => $newBalance,
                                        'overdraft_amount_derived' => $amount,
                                        'cumulative_balance_derived' => $newBalance,
                                        'credit' => $amount
                                    ];
    $insertIntVault = insert('institution_vault_transaction', $intvaultdata);
if ($insertIntVault){
        $intaccountdata = [
                                        'int_id' => $int_id,
                                        'branch_id' => $branch_id,
                                        'teller_id' => $tellerId,
                                        'transaction_id' => $randstring,
                                        'description' => 'Vault Transaction',
                                        'transaction_type' => "vault in",
                                        'transaction_date' => $today,
                                        'amount' => $amount,
                                        'is_vault' => 1,
                                        'running_balance_derived' => 0,
                                        'overdraft_amount_derived' => $amount,
                                        'cumulative_balance_derived' => 0,
                                        'debit' => $amount
                                    ];
    $insertAccountTrans = insert('institution_account_transaction', $intaccountdata);
    if ($insertAccountTrans){
        include("../functions/loans/auto_function/loan_collection.php");
        $check_o = loan_collection($connection);
        header("Location: end_of_day.php?response=success");
    }
          
}
 
}
                                        }
                                    }
                                }
                                
                                
}
}
}
}
?>
