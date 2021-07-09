<?php
/////////////////////// AUTO CODE TO CALCULATE THE DEPRECIATION OF ALL ASSETS IN AN INSTITUTION ///////////////////////
<<<<<<< HEAD
function asset_depreciation($arr, $_cb, $cb) {

    $connection = $arr['connection'];
    $sessint_id = $_SESSION['int_id'];
=======
$sessint_id = $_SESSION['int_id'];
>>>>>>> Victor

// Pull all assets
$ifdo = mysqli_query($connection, "SELECT * FROM assets WHERE int_id = {$sessint_id}");
while($pd = mysqli_fetch_array($ifdo)){
    $aorp = $pd['id'];
    $int_id = $pd['int_id'];
    $asset_name = $pd['asset_name'];
    $asset_type_id = $pd['asset_type_id'];
    $type = $pd['type'];
    $qty = $pd['qty'];
    $unit_price = $pd['unit_price'];
    $amount = $pd['amount'];
    $asset_no = $pd['asset_no'];
    $location = $pd['location'];
    $date = $pd['date'];
    $dep = $pd['depreciation_value'];
    $current_year = $pd['current_year_depreciation'];
    $current_month = $pd['current_month_depreciation'];
    $curr_year = date('Y-m-d');
    $curr_month = date('m');
<<<<<<< HEAD
    $branch_id = $pd['branch_id'];
    $incomeGl = $pd["gl_code"];
    $expenseGl = $pd["expense_gl"];
    $digits = 6;
    $randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

    
    $transactionId = $randms;
=======

>>>>>>> Victor
    // to get difference in years
    $purdate = strtotime($date);
    $currentdate = strtotime($curr_year);
    $datediff = $currentdate - $purdate;
    $datt = round($datediff / (60 * 60 * 24 * 365));

    // to get percentage
    $dom = ($dep/100) * $unit_price;
    // to get current year depreciation
    $currentyear = $unit_price - ($dom * $datt);

    // to get current month depreciation
    $curr_mon = $dom / 12;
<<<<<<< HEAD
    $amount_2 = $curr_mon;
=======
>>>>>>> Victor
    // last year plus number of months spent = this month depreciation

    $lasty = $unit_price - ($dom * ($datt - 1));
    if($currentyear != $unit_price){
    $current_month = $lasty + ($curr_mon * $curr_month);
    
    }
    else{
       $current_month =  $unit_price -($curr_mon * $curr_month);
    }

    $idof = "UPDATE assets SET current_year_depreciation = '$currentyear', current_month_depreciation = '$current_month' WHERE int_id = '$int_id' AND id = '$aorp'";
    $dos = mysqli_query($connection, $idof);
    if($dos){
<<<<<<< HEAD

    
        
    $incomeConditions = [
        'gl_code' => $incomeGl,
        'int_id' =>$sessint_id,
        'branch_id' => $branch_id
    ];
    $findIncomeGl = selectOne('acc_gl_account', $incomeConditions);
    $currentIncomeBalance = $findIncomeGl['organization_running_balance_derived'];
    $incomeParentId = $findIncomeGl['parent_id'];
    $incomeGlId = $findIncomeGl['id'];
    if ($currentIncomeBalance >= $amount_2) {
        $newincomeBalance = $currentIncomeBalance - $amount_2;
        // now find necessary details for expense gl
        $expenseConditions = [
            'gl_code' => $expenseGl,
            'int_id' => $sessint_id,
            'branch_id' => $branch_id,
        ];
        $findExpenseGl = selectOne('acc_gl_account', $expenseConditions);
        $currentExpenseBalance = $findExpenseGl['organization_running_balance_derived'];
        $expenseParentId = $findExpenseGl['parent_id'];
        $expenseGlId = $findExpenseGl['id'];
        $newExpenseBalance = $currentExpenseBalance + $amount_2;

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
                'int_id' => $sessint_id,
                'branch_id' => $branch_id,
                'gl_code' => $incomeGl,
                'parent_id' => $incomeParentId,
                'transaction_id' => $transactionId,
                'description' =>"ASSET_DEPRECIATION",
                'transaction_type' => "debit",
                'transaction_date' => date('Y-m-d'),
                'amount' => $amount_2,
                'gl_account_balance_derived' => $newincomeBalance,
                'overdraft_amount_derived' => $amount_2,
                'cumulative_balance_derived' => $newincomeBalance,
                'debit' => $amount_2
            ];

            $storeIncomeTransaction = insert('gl_account_transaction', $incomeTransactionDetails);
            if ($storeIncomeTransaction) {
                $expenseTransactionDetails = [
                    'int_id' => $sessint_id,
                    'branch_id' => $branch_id,
                    'gl_code' => $expenseGl,
                    'parent_id' => $expenseParentId,
                    'transaction_id' => $transactionId,
                    'description' => "ASSET_DEPRECIATION",
                    'transaction_type' => "credit",
                    'transaction_date' => date('Y-m-d'),
                    'amount' => $amount_2,
                    'gl_account_balance_derived' => $newExpenseBalance,
                    'overdraft_amount_derived' => $amount_2,
                    'cumulative_balance_derived' => $newExpenseBalance,
                    'credit' => $amount_2
                ];

                $storeExpenseTransaction = insert('gl_account_transaction', $expenseTransactionDetails);
                if ($storeExpenseTransaction) {
                    // $_SESSION["Lack_of_intfund_$randms"] = "Transaction Successful!";
                    // echo header("Location: ../../mfi/gl_postings.php?message=$randms");
                } else {
                    // everything was fine until the last moment
                    // could not store transaction details for expense gl
                    // $_SESSION["Lack_of_intfund_$randms"] = "Error storing record for expense GL!";
                    // echo header("Location: ../../mfi/gl_postings.php?message1=$randms");
                }
            } else {
                // income transaction not stored for some weird reason
                // $_SESSION["Lack_of_intfund_$randms"] = "Error storing record for income GL!";
                // echo header("Location: ../../mfi/gl_postings.php?message2=$randms");
            }
        }
    } else {
        // not enough funds
        $_SESSION["Lack_of_intfund_$randms"] = "not enough funds!";
        echo header("Location: ../../mfi/gl_postings.php?message3=$randms");
    }


        // $cb('Asset Depreciation successful');
        $arr['response'] = 0;
        if(is_callable($cb)) {
            call_user_func($cb,$_cb,$arr);
        }
        // echo 'Depreciation Value for '.$asset_name.' with int_id '.$int_id.' was calculated</br>';
    }
}
} 

=======
        echo 'Depreciation Value for '.$asset_name.' with int_id '.$int_id.' was calculated</br>';
    }
}
>>>>>>> Victor
