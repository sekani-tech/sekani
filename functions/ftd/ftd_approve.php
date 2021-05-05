<?php
include("../connect.php");
session_start();
$userId = $_SESSION['user_id'];
$sessint_id = $_SESSION['int_id'];
$randms = str_pad(rand(0, pow(10, 8) - 1), 10, '0', STR_PAD_LEFT);
// first condition caters for when you first view before approval
if(!isset($_GET["approve"])){
    
    // Declare Variables
    $ftd_id = $_POST['ftd_id'];
    $amount = $_POST['amount'];
    $ftd_no = $_POST['ftd_no'];
    $submittedon_date = date('Y-m-d H:i:s');
    $booked_date = $_POST['booked_date'];
    $l_term = $_POST['l_term'];
    $int_rate = $_POST['int_rate'];
    $linked = $_POST['linked'];
    $int_repay = $_POST['int_repay'];
    $auto_renew = $_POST['auto_renew'];
    $acc_off = $_POST['acc_off'];
    $curr_date = date('Y-m-d h:i:sa');
    $tday = date('Y-m-d');

    // update record in case of changes
    $up = "UPDATE ftd_booking_account SET ftd_no = '$ftd_no', field_officer_id = '$acc_off', submittedon_date = '$submittedon_date', account_balance_derived = '$amount', term = '$l_term',
              int_rate = '$int_rate', booked_date = '$booked_date', linked_savings_account = '$linked', auto_renew_on_closure = '$auto_renew', interest_repayment = '$int_repay',
              status = 'Approved' WHERE int_id = '$sessint_id' AND id = '$ftd_id'";
    $update = mysqli_query($connection, $up);

    if($up){
        // BACKTO
        // check for the needed FTD information
        $pickFTD = mysqli_query($connection, "SELECT * FROM ftd_booking_account WHERE int_id = '$sessint_id' AND id = '$ftd_id'");
        $picked = mysqli_fetch_array($pickFTD);
        $bookedAmount = $picked['account_balance_derived'];
        $linkedAccount = $picked['linked_savings_account'];
        $institutionId = $picked['int_id'];
        $branchId = $picked['branch_id'];
        $product_id = $picked['product_id'];
        $transaction_date = $picked['booked_date'];
        $intRate = $picked['int_rate'];
        $ftdTerm = $picked['term'];

        if($pickFTD){
            // check clients account balance so we can make the necessary deduction
            // first collect data for check
            $checkAccount = mysqli_query($connection, "SELECT id, account_balance_derived, account_no, product_id, client_id 
            FROM account WHERE int_id = '$institutionId' AND account_no = '$linkedAccount'");
            $accountDetails = mysqli_fetch_array($checkAccount);
            $accountId = $accountDetails['id'];
            $currentAccountBalance = $accountDetails['account_balance_derived'];
            $productId = $accountDetails['product_id'];
            $clientId = $accountDetails['client_id'];
            // now run check
            if($currentAccountBalance >= $bookedAmount){
                // We can now successfully book the clients FTD by deducting the amount from 1
                // the linked account
                // first calculate amount after withdrawal
                $debitAmount = $currentAccountBalance - $bookedAmount;
                // update customers account
                $updateCurrentBalance = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$debitAmount', last_withdrawal = $bookedAmount 
                WHERE int_id = '$sessint_id' AND account_no = $linkedAccount");
                if($updateCurrentBalance){
                    // now we insert the the transaction record into the db
                    $transactionRecords = [
                        'int_id' => $institutionId,
                        'branch_id' => $branchId,
                        'client_id' => $clientId,
                        'product_id' => $productId,
                        'account_no' => $linkedAccount,
                        'amount' => $amount,
                        'account_id' => $accountId,
                        'transaction_id' => $ftd_no,
                        'description' => "FTD Booking",
                        'transaction_date' => $transaction_date,
                        'transaction_type' => "debit",
                        'overdraft_amount_derived' => $amount,
                        'running_balance_derived' => $debitAmount,
                        'created_date' => date('Y-m-d H:i:s'),
                        'appuser_id' => $userId,
                        'debit' => $amount
                    ];

                    // after collecting the details we then insert it into the db
                    $recordAccountTransaction = insert('account_transaction', $transactionRecords);

                    if($recordAccountTransaction){

                        $getGLCode = mysqli_query($connection, "SELECT gl_code FROM `savings_product` where int_id = {$institutionId} and id = {$product_id}");
                        $GLCode = mysqli_fetch_array($getGLCode)['gl_code'];

                        $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = {$institutionId} AND id = {$branchId}");
                        $parent_id = mysqli_fetch_array($getParentID)['parent_id'];

                        // add booked amount to 'organization_running_balance_derived' for the selected 'gl_code' in the `acc_gl_account` table
                        $getOrganizationRunningBalance = mysqli_query($connection, "SELECT organization_running_balance_derived FROM `acc_gl_account` WHERE int_id = {$institutionId} AND gl_code = {$GLCode}");
                        $currentOrganizationRunningBalance = mysqli_fetch_array($getOrganizationRunningBalance)['organization_running_balance_derived'];
        
                        $newOrganizationRunningBalance = $currentOrganizationRunningBalance + $bookedAmount;
                        $updateOrganizationRunningBalance = mysqli_query($connection, "UPDATE `acc_gl_account` SET organization_running_balance_derived = {$newOrganizationRunningBalance} WHERE int_id = {$institutionId} AND gl_code = {$GLCode}");

                        if($updateOrganizationRunningBalance) {
                            // FTD booked amount added to the gl found in gl_code
                            $newGLAccountTransactionData = [
                                'int_id' => $institutionId,
                                'branch_id' => $branchId,
                                'gl_code' => $GLCode,
                                'parent_id' => $parent_id,
                                'transaction_id' => $ftd_no,
                                'description' => 'Booked_FTD',
                                'transaction_type' => 'credit',
                                'teller_id' => $userId,
                                'is_reversed' => 0,
                                'transaction_date' => date('Y-m-d'),
                                'amount' => $bookedAmount,
                                'gl_account_balance_derived' => $newOrganizationRunningBalance,
                                'branch_balance_derived' => '',
                                'overdraft_amount_derived' => $bookedAmount,
                                'balance_end_date_derived' => date('Y-m-d'),
                                'balance_number_of_days_derived' => '',
                                'cumulative_balance_derived' => $newOrganizationRunningBalance,
                                'created_date' => date('Y-m-d H:i:s'),
                                'manually_adjusted_or_reversed' => 0,
                                'credit' => $bookedAmount
                            ];
    
                            $insertGLAccountTransaction = insert('gl_account_transaction', $newGLAccountTransactionData);
    
                            if($insertGLAccountTransaction) {
                                $interestValue = ($intRate / 100) * $bookedAmount;
                                $ftdTermMonth = $ftdTerm / 30;
                                $interestAmount =  $interestValue / 12;
                                $i = 1;
                                while ($i <= $ftdTermMonth) {
                                    $maturity_date = date('Y-m-d', strtotime('+'. $i * 30 .' Days', strtotime($transaction_date)));
                                    echo $maturity_date . '</br>';
                                    $scheduleData = [
                                        'int_id' => $institutionId,
                                        'branch_id' => $branchId,
                                        'client_id' => $clientId,
                                        'ftd_id' => $ftd_id,
                                        'installment' => $bookedAmount,
                                        'ftd_no' => $ftd_no,
                                        'maturity_date' => $maturity_date,
                                        'interest_rate' => $intRate,
                                        'interest_amount' => $interestAmount,
                                        'interest_repayment' => '0',
                                        'linked_savings_account' => $linkedAccount
                                    ];
                                    $schedule = insert('ftd_interest_schedule', $scheduleData);
                                    
                                    if ($schedule) {
                                        // success message
                                        echo "Schedule created for " + $clientId;
                                    }       
        
                                    $todaysdate = date('Y-m-d');
                                    $todaysdate_time = date('Y-m-d H:i:s');
        
                                    if(strtotime($todaysdate) >= strtotime($maturity_date)){
                                        $dsiu = "SELECT * FROM account WHERE int_id = '$sessint_id' AND account_no = '$linkedAccount'";
                                        $fdio = mysqli_query($connection, $dsiu);
                                        $pw = mysqli_fetch_array($fdio);
                                        $account_bal = $pw['account_balance_derived'];
                                        $brid = $pw['branch_id'];
                                        $account_no = $pw['account_no'];
                                        $account_id = $pw['id'];
                                        $prd = $pw['product_id'];
                                        $new_bal = $interestAmount +  $account_bal;
                                
                                        $dsiod = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$new_bal', last_deposit = '$bookedAmount' WHERE 
                                            account_no = '$linkedAccount' AND int_id = '$sessint_id'");
                                            
                                        if($dsiod){
                                            echo 'account updated</br>';
                                            $dpo = mysqli_query($connection, "INSERT INTO account_transaction (int_id, branch_id, account_no, account_id, product_id,
                                            client_id, transaction_id, description, transaction_type, is_reversed, transaction_date, amount, running_balance_derived,
                                            overdraft_amount_derived, created_date, appuser_id, credit) VALUES ('{$sessint_id}', '{$brid}', '{$account_no}', '{$account_id}', '{$prd}',
                                                '{$clientId}', '{$ftd_no}', 'FTD_Interest', 'Credit', '0', '{$todaysdate}',
                                                '{$interestAmount}', '{$new_bal}', '{$interestAmount}', '{$todaysdate_time}', '{$userId}', '{$interestAmount}')");

                                            if($dpo) {
                                                // interest deposited into the customer's account is added to the gl found in expense_glcode
                                                $getExpenseGLCode = mysqli_query($connection, "SELECT expense_glcode FROM `savings_product` where int_id = {$institutionId} and id = {$product_id}");
                                                $expenseGLCode = mysqli_fetch_array($getExpenseGLCode)['expense_glcode'];

                                                // add interest amount to 'organization_running_balance_derived' for the selected 'gl_code' (expense_glcode) in the `acc_gl_account` table
                                                $getOrganizationRunningBalance2 = mysqli_query($connection, "SELECT organization_running_balance_derived FROM `acc_gl_account` WHERE int_id = {$institutionId} AND gl_code = {$expenseGLCode}");
                                                $currentOrganizationRunningBalance2 = mysqli_fetch_array($getOrganizationRunningBalance2)['organization_running_balance_derived'];
                                
                                                $newOrganizationRunningBalance2 = $currentOrganizationRunningBalance2 + $interestAmount;
                                                $updateOrganizationRunningBalance2 = mysqli_query($connection, "UPDATE `acc_gl_account` SET organization_running_balance_derived = {$newOrganizationRunningBalance2} WHERE int_id = {$institutionId} AND gl_code = {$expenseGLCode}");

                                                if($updateOrganizationRunningBalance2) {
                                                    // FTD booked amount added to the gl found in gl_code
                                                    $newGLAccountTransactionData2 = [
                                                        'int_id' => $institutionId,
                                                        'branch_id' => $branchId,
                                                        'gl_code' => $expenseGLCode,
                                                        'parent_id' => $parent_id,
                                                        'transaction_id' => $ftd_no,
                                                        'description' => 'Expense_Income',
                                                        'transaction_type' => 'credit',
                                                        'teller_id' => $userId,
                                                        'is_reversed' => 0,
                                                        'transaction_date' => date('Y-m-d'),
                                                        'amount' => $interestAmount,
                                                        'gl_account_balance_derived' => $newOrganizationRunningBalance2,
                                                        'branch_balance_derived' => '',
                                                        'overdraft_amount_derived' => $interestAmount,
                                                        'balance_end_date_derived' => date('Y-m-d'),
                                                        'balance_number_of_days_derived' => '',
                                                        'cumulative_balance_derived' => $newOrganizationRunningBalance2,
                                                        'created_date' => date('Y-m-d H:i:s'),
                                                        'manually_adjusted_or_reversed' => 0,
                                                        'credit' => $interestAmount
                                                    ];
                                                    
                                                    $insertGLAccountTransaction2 = insert('gl_account_transaction', $newGLAccountTransactionData2);

                                                    if($insertGLAccountTransaction2) {
                                                        if($i == $ftdTermMonth) {
                                                            $bvf = mysqli_query($connection, "SELECT installment, maturity_date FROM `ftd_interest_schedule` WHERE int_id = '$sessint_id' AND ftd_id = '$ftd_id' ORDER BY id DESC LIMIT 1");
                                                            $bvff = mysqli_fetch_array($bvf);
                                                            $principal = $bvff['installment'];
                                                            $lastMaturityDate = $bvff['maturity_date'];
                
                                                            $new_bal += $principal;
                                                            
                                                            if($lastMaturityDate < $todaysdate) {
                                                                $cbm = mysqli_query($connection, "INSERT INTO account_transaction (int_id, branch_id, account_no, account_id, product_id,
                                                                client_id, transaction_id, description, transaction_type, is_reversed, transaction_date, amount, running_balance_derived,
                                                                overdraft_amount_derived, created_date, appuser_id, credit) VALUES ('{$sessint_id}', '{$brid}', '{$account_no}', '{$account_id}', '{$prd}',
                                                                '{$clientId}', '{$ftd_no}', 'FTD_Principal', 'Credit', '0', '{$todaysdate}', '{$principal}', '{$new_bal}', '{$principal}', '{$todaysdate_time}', '{$userId}', '{$principal}')");
                
                                                                if($cbm) {
                                                                    echo 'account transaction inserted</br>';

                                                                    // deduct principal amount from 'organization_running_balance_derived' for the selected 'gl_code' in the `acc_gl_account` table
                                                                    $getOrganizationRunningBalance3 = mysqli_query($connection, "SELECT organization_running_balance_derived FROM `acc_gl_account` WHERE int_id = {$institutionId} AND gl_code = {$GLCode}");
                                                                    $currentOrganizationRunningBalance3 = mysqli_fetch_array($getOrganizationRunningBalance3)['organization_running_balance_derived'];

                                                                    $newOrganizationRunningBalance3 = $currentOrganizationRunningBalance3 - $principal;
                                                                    $updateOrganizationRunningBalance3 = mysqli_query($connection, "UPDATE `acc_gl_account` SET organization_running_balance_derived = {$newOrganizationRunningBalance3} WHERE int_id = {$institutionId} AND gl_code = {$GLCode}");

                                                                    if($updateOrganizationRunningBalance3) {

                                                                        $newGLAccountTransactionData3 = [
                                                                            'int_id' => $institutionId,
                                                                            'branch_id' => $branchId,
                                                                            'gl_code' => $GLCode,
                                                                            'parent_id' => $parent_id,
                                                                            'transaction_id' => $ftd_no,
                                                                            'description' => 'FTD_LIABILITY_EXPENSE',
                                                                            'transaction_type' => 'debit',
                                                                            'teller_id' => $userId,
                                                                            'is_reversed' => 0,
                                                                            'transaction_date' => date('Y-m-d'),
                                                                            'amount' => $principal,
                                                                            'gl_account_balance_derived' => $newOrganizationRunningBalance3,
                                                                            'branch_balance_derived' => '',
                                                                            'overdraft_amount_derived' => $principal,
                                                                            'balance_end_date_derived' => date('Y-m-d'),
                                                                            'balance_number_of_days_derived' => '',
                                                                            'cumulative_balance_derived' => $newOrganizationRunningBalance3,
                                                                            'created_date' => date('Y-m-d H:i:s'),
                                                                            'manually_adjusted_or_reversed' => 0,
                                                                            'debit' => $principal
                                                                        ];
                                                                        
                                                                        $insertGLAccountTransaction3 = insert('gl_account_transaction', $newGLAccountTransactionData3);

                                                                        if($insertGLAccountTransaction3) {

                                                                            $fmdpf = mysqli_query($connection, "UPDATE ftd_interest_schedule SET interest_repayment = '1' WHERE int_id = '$sessint_id' AND ftd_no = '$ftd_no'");
                    
                                                                            if($fmdpf) {

                                                                                $updateCurrentBalance = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$new_bal' WHERE int_id = '$sessint_id' AND account_no = '$linkedAccount'");
                                                                                if($updateCurrentBalance) {
                                                                                    // 'is_paid' value is updated to 1 in the `ftd_booking_account` table to indicate that the FTD repayment is completed
                                                                                    $updateFTD = mysqli_query($connection, "UPDATE `ftd_booking_account` SET is_paid = '1' WHERE int_id = {$sessint_id} AND id = {$ftd_id}");
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
                                        }
                                    }
        
                                    $i++;
        
                                    $updateFTD = mysqli_query($connection, "UPDATE ftd_booking_account SET status = 'Approved' WHERE id = '$ftd_id'");
                                    if($updateFTD){
                                        $_SESSION["Lack_of_intfund_$randms"] = "FTD approval Successful";
                                        echo header("Location: ../../mfi/ftd_approval.php?message1=$randms");
                                    }else{
                                        // something is wrong... update not successful
                                        $_SESSION["Lack_of_intfund_$randms"] = "Something is wrong! FTD status not changed";
                                        echo header("Location: ../../mfi/ftd_approval.php?message7=$randms");       
                                    }
                                }
                            }
                        }
                    }
                    else{
                        // something is wrong... transaction record not inserted into DB
                        $_SESSION["Lack_of_intfund_$randms"] = "Money deducted but record of transaction not stored";
                        echo header("Location: ../../mfi/ftd_approval.php?message6=$randms");
                    }

                }else{
                    // something is wrong... accounts table not updated hence 
                    // money not deducted
                    $_SESSION["Lack_of_intfund_$randms"] = "Money not deducted from account";
                    echo header("Location: ../../mfi/ftd_approval.php?message4=$randms");
                }
                
            }else{
                // not enough money in linked account
                $_SESSION["Lack_of_intfund_$randms"] = "Not enough Money in Linked account!";
                echo header("Location: ../../mfi/ftd_approval.php?message3=$randms");    
            }
        }else{
            printf('Error: %s\n', mysqli_error($connection));//checking for errors
            exit();
        }
    }else{
        $_SESSION["Lack_of_intfund_$randms"] = "Something is wrong unable to Approve FTD!";
        echo header("Location: ../../mfi/ftd_approval.php?message9=$randms");
    }
    // ends here
}else if(isset($_GET["approve"])){ //here I am only carrying out the function when you hit approve on ftd_approval.php
    // check for the needed FTD information
    $ftd_id = $_GET["approve"];
    $pickFTD = mysqli_query($connection, "SELECT * FROM ftd_booking_account WHERE int_id = '$sessint_id' AND id = '$ftd_id'");
    $picked = mysqli_fetch_array($pickFTD);
    $ftd_id = $picked['id'];
    $ftd_no = $picked['ftd_no'];
    $product_id = $picked['product_id'];
    $bookedAmount = $picked['account_balance_derived'];
    $linkedAccount = $picked['linked_savings_account'];
    $institutionId = $picked['int_id'];
    $branchId = $picked['branch_id'];
    $submittedon_date = date('Y-m-d H:i:s');
    $transaction_date = $picked['booked_date'];
    $intRate = $picked['int_rate'];
    $ftdTerm = $picked['term'];

    if($pickFTD){
        // check clients account balance so we can make the necessary deduction
        // first collect data for check
        $checkAccount = mysqli_query($connection, "SELECT id, account_balance_derived, account_no, product_id, client_id FROM account WHERE int_id = '$institutionId' AND account_no = '$linkedAccount'");
        $accountDetails = mysqli_fetch_array($checkAccount);
        $accountId = $accountDetails['id'];
        $currentAccountBalance = $accountDetails['account_balance_derived'];
        $productId = $accountDetails['product_id'];
        $clientId = $accountDetails['client_id'];
        
        // now run check
        if($currentAccountBalance >= $bookedAmount){
            // We can now successfully book the clients FTD by deducting the amount from 2
            // the linked account
            // first calculate amount after withdrawal
            $debitAmount = $currentAccountBalance - $bookedAmount;
            // update customers account
            $updateCurrentBalance = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$debitAmount', last_withdrawal = $bookedAmount 
            WHERE int_id = '$sessint_id' AND account_no = $linkedAccount");
            if($updateCurrentBalance){
                // now we insert the the transaction record into the db
                $transactionRecords = [
                    'int_id' => $institutionId,
                    'branch_id' => $branchId,
                    'product_id' => $productId,
                    'client_id' => $clientId,
                    'account_no' => $linkedAccount,
                    'amount' => $bookedAmount,
                    'account_id' => $accountId,
                    'transaction_id' => $ftd_no,
                    'description' => "FTD Booking",
                    'transaction_date' => $transaction_date,
                    'transaction_type' => "debit",
                    'overdraft_amount_derived' => $bookedAmount,
                    'running_balance_derived' => $debitAmount,
                    'created_date' => date('Y-m-d H:i:s'),
                    'appuser_id' => $userId,
                    'debit' => $bookedAmount
                ];

                // dd($transactionRecords);
                // after collecting the details we then insert it into the db
                $recordAccountTransaction = insert('account_transaction', $transactionRecords);
                
                if($recordAccountTransaction){

                    $getGLCode = mysqli_query($connection, "SELECT gl_code FROM `savings_product` where int_id = {$institutionId} and id = {$product_id}");
                    $GLCode = mysqli_fetch_array($getGLCode)['gl_code'];

                    $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = {$institutionId} AND id = {$branchId}");
                    $parent_id = mysqli_fetch_array($getParentID)['parent_id'];

                    // add booked amount to 'organization_running_balance_derived' for the selected 'gl_code' in the `acc_gl_account` table
                    $getOrganizationRunningBalance = mysqli_query($connection, "SELECT organization_running_balance_derived FROM `acc_gl_account` WHERE int_id = {$institutionId} AND gl_code = {$GLCode}");
                    $currentOrganizationRunningBalance = mysqli_fetch_array($getOrganizationRunningBalance)['organization_running_balance_derived'];
    
                    $newOrganizationRunningBalance = $currentOrganizationRunningBalance + $bookedAmount;
                    $updateOrganizationRunningBalance = mysqli_query($connection, "UPDATE `acc_gl_account` SET organization_running_balance_derived = {$newOrganizationRunningBalance} WHERE int_id = {$institutionId} AND gl_code = {$GLCode}");

                    if($updateOrganizationRunningBalance) {
                        // FTD booked amount added to the gl found in gl_code
                        $newGLAccountTransactionData = [
                            'int_id' => $institutionId,
                            'branch_id' => $branchId,
                            'gl_code' => $GLCode,
                            'parent_id' => $parent_id,
                            'transaction_id' => $ftd_no,
                            'description' => 'Booked_FTD',
                            'transaction_type' => 'credit',
                            'teller_id' => $userId,
                            'is_reversed' => 0,
                            'transaction_date' => date('Y-m-d'),
                            'amount' => $bookedAmount,
                            'gl_account_balance_derived' => $newOrganizationRunningBalance,
                            'branch_balance_derived' => '',
                            'overdraft_amount_derived' => $bookedAmount,
                            'balance_end_date_derived' => date('Y-m-d'),
                            'balance_number_of_days_derived' => '',
                            'cumulative_balance_derived' => $newOrganizationRunningBalance,
                            'created_date' => date('Y-m-d H:i:s'),
                            'manually_adjusted_or_reversed' => 0,
                            'credit' => $bookedAmount
                        ];

                        $insertGLAccountTransaction = insert('gl_account_transaction', $newGLAccountTransactionData);

                        if($insertGLAccountTransaction) {
                            $interestValue = ($intRate / 100) * $bookedAmount;
                            $ftdTermMonth = $ftdTerm / 30;
                            $interestAmount =  $interestValue / 12;
                            $i = 1;
                            while ($i <= $ftdTermMonth) {
                                $maturity_date = date('Y-m-d', strtotime('+'. $i * 30 .' Days', strtotime($transaction_date)));
                                echo $maturity_date . '</br>';
                                $scheduleData = [
                                    'int_id' => $institutionId,
                                    'branch_id' => $branchId,
                                    'client_id' => $clientId,
                                    'ftd_id' => $ftd_id,
                                    'installment' => $bookedAmount,
                                    'ftd_no' => $ftd_no,
                                    'maturity_date' => $maturity_date,
                                    'interest_rate' => $intRate,
                                    'interest_amount' => $interestAmount,
                                    'interest_repayment' => '0',
                                    'linked_savings_account' => $linkedAccount
                                ];
                                $schedule = insert('ftd_interest_schedule', $scheduleData);
                                
                                if ($schedule) {
                                    // success message
                                    echo "Schedule created for " + $clientId;
                                }       
    
                                $todaysdate = date('Y-m-d');
                                $todaysdate_time = date('Y-m-d H:i:s');
    
                                if(strtotime($todaysdate) >= strtotime($maturity_date)){
                                    $dsiu = "SELECT * FROM account WHERE int_id = '$sessint_id' AND account_no = '$linkedAccount'";
                                    $fdio = mysqli_query($connection, $dsiu);
                                    $pw = mysqli_fetch_array($fdio);
                                    $account_bal = $pw['account_balance_derived'];
                                    $brid = $pw['branch_id'];
                                    $account_no = $pw['account_no'];
                                    $account_id = $pw['id'];
                                    $prd = $pw['product_id'];
                                    $new_bal = $interestAmount +  $account_bal;
                            
                                    $dsiod = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$new_bal', last_deposit = '$bookedAmount' WHERE 
                                        account_no = '$linkedAccount' AND int_id = '$sessint_id'");
                                        
                                    if($dsiod){
                                        echo 'account updated</br>';
                                        $dpo = mysqli_query($connection, "INSERT INTO account_transaction (int_id, branch_id, account_no, account_id, product_id,
                                        client_id, transaction_id, description, transaction_type, is_reversed, transaction_date, amount, running_balance_derived,
                                        overdraft_amount_derived, created_date, appuser_id, credit) VALUES ('{$sessint_id}', '{$brid}', '{$account_no}', '{$account_id}', '{$prd}',
                                            '{$clientId}', '{$ftd_no}', 'FTD_Interest', 'Credit', '0', '{$todaysdate}',
                                            '{$interestAmount}', '{$new_bal}', '{$interestAmount}', '{$todaysdate_time}', '{$userId}', '{$interestAmount}')");
    
                                        if($dpo) {
                                            // interest deposited into the customer's account is added to the gl found in expense_glcode
                                            $getExpenseGLCode = mysqli_query($connection, "SELECT expense_glcode FROM `savings_product` where int_id = {$institutionId} and id = {$product_id}");
                                            $expenseGLCode = mysqli_fetch_array($getExpenseGLCode)['expense_glcode'];

                                            // add interest amount to 'organization_running_balance_derived' for the selected 'gl_code' (expense_glcode) in the `acc_gl_account` table
                                            $getOrganizationRunningBalance2 = mysqli_query($connection, "SELECT organization_running_balance_derived FROM `acc_gl_account` WHERE int_id = {$institutionId} AND gl_code = {$expenseGLCode}");
                                            $currentOrganizationRunningBalance2 = mysqli_fetch_array($getOrganizationRunningBalance2)['organization_running_balance_derived'];

                                            $newOrganizationRunningBalance2 = $currentOrganizationRunningBalance2 + $interestAmount;
                                            $updateOrganizationRunningBalance2 = mysqli_query($connection, "UPDATE `acc_gl_account` SET organization_running_balance_derived = {$newOrganizationRunningBalance2} WHERE int_id = {$institutionId} AND gl_code = {$expenseGLCode}");

                                            if($updateOrganizationRunningBalance2) {
                                                // FTD booked amount added to the gl found in gl_code
                                                $newGLAccountTransactionData2 = [
                                                    'int_id' => $institutionId,
                                                    'branch_id' => $branchId,
                                                    'gl_code' => $expenseGLCode,
                                                    'parent_id' => $parent_id,
                                                    'transaction_id' => $ftd_no,
                                                    'description' => 'Expense_Income',
                                                    'transaction_type' => 'credit',
                                                    'teller_id' => $userId,
                                                    'is_reversed' => 0,
                                                    'transaction_date' => date('Y-m-d'),
                                                    'amount' => $interestAmount,
                                                    'gl_account_balance_derived' => $newOrganizationRunningBalance2,
                                                    'branch_balance_derived' => '',
                                                    'overdraft_amount_derived' => $interestAmount,
                                                    'balance_end_date_derived' => date('Y-m-d'),
                                                    'balance_number_of_days_derived' => '',
                                                    'cumulative_balance_derived' => $newOrganizationRunningBalance2,
                                                    'created_date' => date('Y-m-d H:i:s'),
                                                    'manually_adjusted_or_reversed' => 0,
                                                    'credit' => $interestAmount
                                                ];
                                                
                                                $insertGLAccountTransaction2 = insert('gl_account_transaction', $newGLAccountTransactionData2);

                                                if($insertGLAccountTransaction2) {
                                                    if($i == $ftdTermMonth) {
                                                        $bvf = mysqli_query($connection, "SELECT installment, maturity_date FROM `ftd_interest_schedule` WHERE int_id = '$sessint_id' AND ftd_id = '$ftd_id' ORDER BY id DESC LIMIT 1");
                                                        $bvff = mysqli_fetch_array($bvf);
                                                        $principal = $bvff['installment'];
                                                        $lastMaturityDate = $bvff['maturity_date'];

                                                        $new_bal += $principal;
                                                        
                                                        if($lastMaturityDate < $todaysdate) {
                                                            $cbm = mysqli_query($connection, "INSERT INTO account_transaction (int_id, branch_id, account_no, account_id, product_id,
                                                            client_id, transaction_id, description, transaction_type, is_reversed, transaction_date, amount, running_balance_derived,
                                                            overdraft_amount_derived, created_date, appuser_id, credit) VALUES ('{$sessint_id}', '{$brid}', '{$account_no}', '{$account_id}', '{$prd}',
                                                            '{$clientId}', '{$ftd_no}', 'FTD_Principal', 'Credit', '0', '{$todaysdate}', '{$principal}', '{$new_bal}', '{$principal}', '{$todaysdate_time}', '{$userId}', '{$principal}')");

                                                            if($cbm) {
                                                                echo 'account transaction inserted</br>';

                                                                // deduct principal amount from 'organization_running_balance_derived' for the selected 'gl_code' in the `acc_gl_account` table
                                                                $getOrganizationRunningBalance3 = mysqli_query($connection, "SELECT organization_running_balance_derived FROM `acc_gl_account` WHERE int_id = {$institutionId} AND gl_code = {$GLCode}");
                                                                $currentOrganizationRunningBalance3 = mysqli_fetch_array($getOrganizationRunningBalance3)['organization_running_balance_derived'];

                                                                $newOrganizationRunningBalance3 = $currentOrganizationRunningBalance3 - $principal;
                                                                $updateOrganizationRunningBalance3 = mysqli_query($connection, "UPDATE `acc_gl_account` SET organization_running_balance_derived = {$newOrganizationRunningBalance3} WHERE int_id = {$institutionId} AND gl_code = {$GLCode}");

                                                                if($updateOrganizationRunningBalance3) {

                                                                    $newGLAccountTransactionData3 = [
                                                                        'int_id' => $institutionId,
                                                                        'branch_id' => $branchId,
                                                                        'gl_code' => $GLCode,
                                                                        'parent_id' => $parent_id,
                                                                        'transaction_id' => $ftd_no,
                                                                        'description' => 'FTD_LIABILITY_EXPENSE',
                                                                        'transaction_type' => 'debit',
                                                                        'teller_id' => $userId,
                                                                        'is_reversed' => 0,
                                                                        'transaction_date' => date('Y-m-d'),
                                                                        'amount' => $principal,
                                                                        'gl_account_balance_derived' => $newOrganizationRunningBalance3,
                                                                        'branch_balance_derived' => '',
                                                                        'overdraft_amount_derived' => $principal,
                                                                        'balance_end_date_derived' => date('Y-m-d'),
                                                                        'balance_number_of_days_derived' => '',
                                                                        'cumulative_balance_derived' => $newOrganizationRunningBalance3,
                                                                        'created_date' => date('Y-m-d H:i:s'),
                                                                        'manually_adjusted_or_reversed' => 0,
                                                                        'debit' => $principal
                                                                    ];
                                                                    
                                                                    $insertGLAccountTransaction3 = insert('gl_account_transaction', $newGLAccountTransactionData3);

                                                                    if($insertGLAccountTransaction3) {
                                                                        
                                                                        $fmdpf = mysqli_query($connection, "UPDATE ftd_interest_schedule SET interest_repayment = '1' WHERE int_id = '$sessint_id' AND ftd_no = '$ftd_no'");
                
                                                                        if($fmdpf) {

                                                                            $updateCurrentBalance = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$new_bal' WHERE int_id = '$sessint_id' AND account_no = '$linkedAccount'");
                                                                            if($updateCurrentBalance) {
                                                                                // 'is_paid' value is updated to 1 in the `ftd_booking_account` table to indicate that the FTD repayment is completed
                                                                                $updateFTD = mysqli_query($connection, "UPDATE `ftd_booking_account` SET is_paid = '1' WHERE int_id = {$sessint_id} AND id = {$ftd_id}");
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
                                    }
                                }
    
                                $i++;
    
                                $updateFTD = mysqli_query($connection, "UPDATE ftd_booking_account SET status = 'Approved' WHERE id = '$ftd_id'");
                                if($updateFTD){
                                    $_SESSION["Lack_of_intfund_$randms"] = "FTD approval Successful";
                                    echo header("Location: ../../mfi/ftd_approval.php?message1=$randms");
                                }else{
                                    // something is wrong... update not successful
                                    $_SESSION["Lack_of_intfund_$randms"] = "Something is wrong! FTD status not changed";
                                    echo header("Location: ../../mfi/ftd_approval.php?message7=$randms");       
                                }
                            }
                        }
                    }
                }
                else{
                    // something is wrong... transaction record not inserted into DB
                    $_SESSION["Lack_of_intfund_$randms"] = "Money deducted but record of transaction not stored";
                    echo header("Location: ../../mfi/ftd_approval.php?message6=$randms");
                }

            }else{
                // something is wrong... accounts table not updated hence 
                // money not deducted
                $_SESSION["Lack_of_intfund_$randms"] = "Money not deducted from account";
                echo header("Location: ../../mfi/ftd_approval.php?message4=$randms");
            }
            
        }else{
            // not enough money in linked account
            $_SESSION["Lack_of_intfund_$randms"] = "Not enough Money in Linked account!";
            echo header("Location: ../../mfi/ftd_approval.php?message3=$randms");    
        }
    }else{
        printf('Error: %s\n', mysqli_error($connection));//checking for errors
        exit();
    }

}else{
    $_SESSION["Lack_of_intfund_$randms"] = " Something is wrong with this FTD booking!";
    echo header("Location: ../../mfi/ftd_approval.php?message2=$randms");
}