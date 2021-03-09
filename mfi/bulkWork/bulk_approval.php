<?php
include('../../functions/connect.php');
session_start();
if (isset($_POST['submit'])) {
    $digit = 6;
    try {
        $randms = str_pad(random_int(0, (10 ** $digit) - 1), 7, '0', STR_PAD_LEFT);
    } catch (Exception $e) {
    }
    if (isset($_POST['checkBoxArray'])) {
        $bulk_options = $_POST['bulk_options'];
        switch ($bulk_options) {
            case 'Approval':
                $bulk_options_type = $_POST['bulk_options_type'];
                if ($bulk_options_type === 'Deposit') {
                    foreach ($_POST['checkBoxArray'] as $key => $postValueId) {
                        $id = $postValueId;
                        $inst_id = $_SESSION['int_id'];

//        Get the transaction from transact_cache
                        $transactionDataCon = [
                            'id' => $id,
                            'int_id' => $inst_id,
                            'status' => 'Pending',
                            'transact_type' => $bulk_options_type
                        ];
                        $transactionData = selectOne('transact_cache', $transactionDataCon);

                        $transactionCacheId = $transactionData['id'];
                        $transactionCacheInst_id = $transactionData['int_id'];
                        $transactionCacheBranchId = $transactionData['branch_id'];
                        $transactionCacheTransId = $transactionData['transact_id'];
                        $transactionCacheDesc = $transactionData['description'];
                        $transactionCacheAccountNo = $transactionData['account_no'];
                        $transactionCacheClientId = $transactionData['client_id'];
                        $transactionCacheClientName = $transactionData['client_name'];
                        $transactionCacheStaff_id = $transactionData['staff_id'];
                        $transactionCacheTellerId = $transactionData['teller_id'];
                        $transactionCacheAmount = $transactionData['amount'];
                        $transactionCachePayType = $transactionData['pay_type'];
                        $transactionCacheTransType = $transactionData['transact_type'];
                        $transactionCacheProductType = $transactionData['product_type'];
                        $transactionCacheDate = $transactionData['date'];

//                        check if transaction has been done before
                        $doneBeforeCon = [
                            'int_id' => $transactionCacheInst_id,
                            'branch_id' => $transactionCacheBranchId,
                            'account_no' => $transactionCacheAccountNo,
                            'transaction_id' => $transactionCacheTransId
                        ];
                        $doneBefore = selectSpecificData('account_transaction', ['transaction_id'], $doneBeforeCon);
                        if ($doneBefore) {
                            $showKey = $key + 1;
                            $_SESSION["Lack_of_intfund_$randms"] = "Sorry this transaction is already done";
                            header("Location: ../transact_approval.php?messageBulkApp1=$showKey");
                            exit();
                        }

                        $tellerCon = ['id' => $transactionCacheTellerId, 'int_id' => $transactionCacheInst_id];
                        $tellerDetails = selectOne('tellers', $tellerCon);
                        $tellerNameID = $tellerDetails['id'];
                        $tellerName = $tellerDetails['name'];

                        //                  get account information using account number
                        $accountDetails = selectOne('account', ['account_no' => $transactionCacheAccountNo]);
                        if (!$accountDetails) {
                            $showKey = $key + 1;
                            $_SESSION["Lack_of_intfund_$randms"] = "Sorry Account Number is Not Found";
                            header("Location: ../transact_approval.php?messageBulkApp2=$showKey");
                            exit();
                        }
//                            dd($accountDetails);
                        //                  account information for other table
                        $accountProductId = $accountDetails['product_id'];
                        $accountId = $accountDetails['id'];
                        //                        set all total derived
                        $totalDeposit = $accountDetails['total_deposits_derived'] + $transactionCacheAmount;
                        $accountBal = $accountDetails['account_balance_derived'] + $transactionCacheAmount;

                        //                        prepare information for database
                        $accountConstantName = 'id';
                        $accountData = [
                            'total_deposits_derived' => $totalDeposit,
                            'account_balance_derived' => $accountBal,
                            'last_deposit' => $transactionCacheAmount,
                            'last_activity_date' => date("Y-m-d"),
                            'chooseDate' => $transactionCacheDate
                        ];

                        //                        send record to account_transaction details and update the necessary information
                        $accountTransData = [
                            'int_id' => $transactionCacheInst_id,
                            'branch_id' => $transactionCacheBranchId,
                            'product_id' => $accountProductId,
                            'account_id' => $accountId,
                            'account_no' => $transactionCacheAccountNo,
                            'client_id' => $transactionCacheClientId,
                            'teller_id' => $transactionCacheTellerId,
                            'transaction_id' => $transactionCacheTransId,
                            'description' => $transactionCacheDesc,
                            'transaction_type' => 'credit',
                            'transaction_date' => $transactionCacheDate,
                            'amount' => $transactionCacheAmount,
                            'running_balance_derived' => $accountBal,
                            'cumulative_balance_derived' => $accountBal,
                            'created_date' => date("Y-m-d H:i:s"),
                            'chooseDate' => $transactionCacheDate,
                            'appuser_id' => $transactionCacheStaff_id,
                            'credit' => $transactionCacheAmount,
                        ];

                        $getGlCode = selectOne('payment_type', ['id' => $transactionCachePayType]);

                        if (!$getGlCode) {
                            $showKey = $key + 1;
                            $_SESSION["Lack_of_intfund_$randms"] = "Sorry Payment Type not Defined";
                            header("Location: ../transact_approval.php?messageBulkApp3=$showKey");
                            exit();
                        }
                        $glCode = $getGlCode['gl_code'];
                        //                        get information form gl_account and update it
                        $acc_gl_accountData = ['gl_code' => $glCode, 'int_id' => $transactionCacheInst_id];
                        $glAccountDetails = selectOne('acc_gl_account', $acc_gl_accountData);
                        // dd($glAccountDetails);
                        $newOrgRunningBal = $glAccountDetails['organization_running_balance_derived'] + $transactionCacheAmount;


                        // get insit information and add new amount to old balance
                        // $instCondition = ['int_id' => $transactionCacheInst_id, 'teller_id' => $tellerNameID || $tellerName];
                        // $instDetails = selectOne('institution_account', $instCondition);

                        $instCondition = "SELECT * FROM `institution_account` WHERE int_id = '$transactionCacheInst_id' AND teller_id = '$tellerNameID' || '$tellerName'";
                        $instDetails = mysqli_query($connection, $instCondition);

                        if (!$instDetails) {
                            $showKey = $key + 1;
                            $_SESSION["Lack_of_intfund_$randms"] = "Sorry Institution not found";
                            header("Location: ../transact_approval.php?messageBulkApp4=$showKey");
                            exit();
                        }
                        $new_inst_acct_bal = $instDetails['account_balance_derived'] + $transactionCacheAmount;
                        $new_inst_total_bal_der = $instDetails['total_deposits_derived'] + $transactionCacheAmount;
                        $idValue = $instDetails['id'];
                        $update_instAccountCon = [
                            'submittedon_userid' => $transactionCacheStaff_id,
                            'account_balance_derived' => $new_inst_acct_bal,
                            'teller_id' => $transactionCacheTellerId,
                            'total_deposits_derived' => $new_inst_total_bal_der,
                            'last_activity_date' => date("Y-m-d H:i:s"),
                            'chooseDate' => $transactionCacheDate
                        ];

                        //                        get info about institution_account_transaction and update it
                        $instAccountTransCon = [
                            'int_id' => $inst_id,
                            'branch_id' => $transactionCacheBranchId,
                            'client_id' => $transactionCacheClientId,
                            'transaction_id' => $transactionCacheTransId,
                            'description' => $transactionCacheDesc,
                            'transaction_type' => 'credit',
                            'teller_id' => $transactionCacheTellerId,
                            'is_vault' => 0,
                            'transaction_date' => $transactionCacheDate,
                            'amount' => $transactionCacheAmount,
                            'running_balance_derived' => $new_inst_acct_bal,
                            'cumulative_balance_derived' => $new_inst_acct_bal,
                            'created_date' => date("Y-m-d H:i:s"),
                            'appuser_id' => $transactionCacheStaff_id,
                            'credit' => $transactionCacheAmount
                        ];


                        //                        get information for gl_account_transaction
                        $gl_accountCon = [
                            'int_id' => $inst_id,
                            'branch_id' => $transactionCacheBranchId,
                            'gl_code' => $glCode,
                            'parent_id' => $accountProductId,
                            'transaction_id' => $transactionCacheTransId,
                            'description' => $transactionCacheDesc,
                            'transaction_type' => 'Deposit',
                            'teller_id' => $transactionCacheTellerId,
                            'transaction_date' => $transactionCacheDate,
                            'amount' => $transactionCacheAmount,
                            'gl_account_balance_derived' => $newOrgRunningBal,
                            'cumulative_balance_derived' => $newOrgRunningBal,
                            'created_date' => date("Y-m-d H:i:s"),
                            'credit' => $transactionCacheAmount
                        ];

//                            a check to make sure all information are available and correct before sending it to data tables
                        if ($tellerDetails && $accountDetails && $getGlCode && $glAccountDetails && $instDetails) {
                            //                        update account table
                            $updateLastDeposit = update('account', $accountId, $accountConstantName, $accountData);
//                                insert into account transaction
                            $accountTransDetails = create('account_transaction', $accountTransData);
                            //                        update the acc_gl_account
                            $update_glAccount = update('acc_gl_account', $glAccountDetails['id'],
                                'id', ['organization_running_balance_derived' => $newOrgRunningBal]);
//                                update the institution account information
                            $update_instAccount = update('institution_account', $idValue, 'id', $update_instAccountCon);
//                                insert record in institution account transaction
                            $institution_account = create('institution_account_transaction', $instAccountTransCon);
//                                insert record into gl account transaction
                            $gl_accountDetails = create('gl_account_transaction', $gl_accountCon);
//                            Update the transact_cache with verified
                            $updateTransactionCache = update('transact_cache', $transactionCacheId, 'id', ['status' => 'Verified']);
                        }
                    }
                    $totalNumber = count($_POST['checkBoxArray']);
                    $_SESSION["Lack_of_intfund_$randms"] = "Transaction Approved";
                    header("Location: ../transact_approval.php?messageBulkApp5=$totalNumber");
                    exit();
                } //                    Approval Withdrawal session
                else {
                    foreach ($_POST['checkBoxArray'] as $key => $postValueId) {
                        $id = $postValueId;
                        $inst_id = $_SESSION['int_id'];

//        Get the transaction from transact_cache
                        $transactionDataCon = ['id' => $id, 'int_id' => $inst_id, 'status' => 'Pending', 'transact_type' => $bulk_options_type];
                        $transactionData = selectOne('transact_cache', $transactionDataCon);
                        $transactionCacheId = $transactionData['id'];
                        $transactionCacheInst_id = $transactionData['int_id'];
                        $transactionCacheBranchId = $transactionData['branch_id'];
                        $transactionCacheTransId = $transactionData['transact_id'];
                        $transactionCacheDesc = $transactionData['description'];
                        $transactionCacheAccountNo = $transactionData['account_no'];
                        $transactionCacheClientId = $transactionData['client_id'];
                        $transactionCacheClientName = $transactionData['client_name'];
                        $transactionCacheStaff_id = $transactionData['staff_id'];
                        $transactionCacheTellerId = $transactionData['teller_id'];
                        $transactionCacheAmount = $transactionData['amount'];
                        $transactionCachePayType = $transactionData['pay_type'];
                        $transactionCacheTransType = $transactionData['transact_type'];
                        $transactionCacheProductType = $transactionData['product_type'];
                        $transactionCacheDate = $transactionData['date'];

//                        check client account if money is available
                        $clientAccountBalanceCon = [
                            'int_id' => $transactionCacheInst_id,
                            'branch_id' => $transactionCacheBranchId,
                            'account_no' => $transactionCacheAccountNo,
                            'client_id' => $transactionCacheClientId,
                        ];
                        $clientAccountBalanceDetails = selectSpecificData('account', ['account_no', 'account_balance_derived'], $clientAccountBalanceCon);
                        if (!$clientAccountBalanceDetails) {
                            $showKey = $key + 1;
                            $_SESSION["Lack_of_intfund_$randms"] = "Insufficient fund for this account";
                            header("Location: ../transact_approval.php?messageBulkApp9=$showKey");
                            exit();
                        }
                        $clientCurrentBalance = $clientAccountBalanceDetails['account_balance_derived'];
                        if ($clientCurrentBalance < $transactionCacheAmount) {
                            $showKey = $key + 1;
                            $_SESSION["Lack_of_intfund_$randms"] = "Insufficient fund for this account";
                            header("Location: ../transact_approval.php?messageBulkApp8=$showKey");
                            exit();
                        }

                        //                        check if transaction has been done before
                        $doneBeforeCon = [
                            'int_id' => $transactionCacheInst_id,
                            'branch_id' => $transactionCacheBranchId,
                            'account_no' => $transactionCacheAccountNo,
                            'transaction_id' => $transactionCacheTransId
                        ];
                        $doneBefore = selectSpecificData('account_transaction', ['transaction_id'], $doneBeforeCon);
                        if ($doneBefore) {
                            $showKey = $key + 1;
                            $_SESSION["Lack_of_intfund_$randms"] = "Sorry This traction is already done";
                            header("Location: ../transact_approval.php?messageBulkApp1=$showKey");
                            exit();
                        }

                        $tellerCon = ['id' => $transactionCacheTellerId, 'int_id' => $transactionCacheInst_id];
                        $tellerDetails = selectOne('tellers', $tellerCon);
                        $tellerNameID = $tellerDetails['name'];

                        //                  get account information using account number
                        $accountDetails = selectOne('account', ['account_no' => $transactionCacheAccountNo]);
                        if (!$accountDetails) {
                            $showKey = $key + 1;
                            $_SESSION["Lack_of_intfund_$randms"] = "Sorry Account Number is  not Found";
                            header("Location: ../transact_approval.php?messageBulkApp2=$showKey");
                            exit();
                        }
//                            dd($accountDetails);
                        //                  account information for other table
                        $accountProductId = $accountDetails['product_id'];
                        $accountId = $accountDetails['id'];
                        //                        set all total derived
                        $totalWithdrawal = $accountDetails['total_withdrawals_derived'] + $transactionCacheAmount;
                        $accountBal = $accountDetails['account_balance_derived'] - $transactionCacheAmount;

                        //                        prepare information for database
                        $accountConstantName = 'id';
                        $accountData = [
                            'total_withdrawals_derived' => $totalWithdrawal,
                            'account_balance_derived' => $accountBal,
                            'last_withdrawal' => $transactionCacheAmount,
                            'last_activity_date' => date("Y-m-d"),
                            'chooseDate' => $transactionCacheDate
                        ];

                        //                        send record to account_transaction details and update the necessary information
                        $accountTransData = [
                            'int_id' => $transactionCacheInst_id,
                            'branch_id' => $transactionCacheBranchId,
                            'product_id' => $accountProductId,
                            'account_id' => $accountId,
                            'account_no' => $transactionCacheAccountNo,
                            'client_id' => $transactionCacheClientId,
                            'teller_id' => $transactionCacheTellerId,
                            'transaction_id' => $transactionCacheTransId,
                            'description' => $transactionCacheDesc,
                            'transaction_type' => 'debit',
                            'transaction_date' => $transactionCacheDate,
                            'amount' => $transactionCacheAmount,
                            'running_balance_derived' => $accountBal,
                            'cumulative_balance_derived' => $accountBal,
                            'created_date' => date("Y-m-d H:i:s"),
                            'chooseDate' => $transactionCacheDate,
                            'appuser_id' => $transactionCacheStaff_id,
                            'debit' => $transactionCacheAmount,
                        ];

                        $getGlCode = selectOne('payment_type', ['id' => $transactionCachePayType]);

                        if (!$getGlCode) {
                            $showKey = $key + 1;
                            $_SESSION["Lack_of_intfund_$randms"] = "Sorry Payment Type not Defined";
                            header("Location: ../transact_approval.php?messageBulkApp3=$showKey");
                            exit();
                        }
                        $glCode = $getGlCode['gl_code'];
                        //                        get information form gl_account and update it
                        $acc_gl_accountData = ['gl_code' => $glCode, 'int_id' => $transactionCacheInst_id];
                        $glAccountDetails = selectOne('acc_gl_account', $acc_gl_accountData);
                        // dd($glAccountDetails);
                        $newOrgRunningBal = $glAccountDetails['organization_running_balance_derived'] - $transactionCacheAmount;

                        //                      get insit information and add new amount to old balance
                        $instCondition = ['int_id' => $transactionCacheInst_id, 'teller_id' => $tellerNameID];
                        $instDetails = selectOne('institution_account', $instCondition);
                        if (!$instDetails) {
                            $showKey = $key + 1;
                            $_SESSION["Lack_of_intfund_$randms"] = "Sorry Institution not found";
                            header("Location: ../transact_approval.php?messageBulkApp4=$showKey");
                            exit();
                        }
                        $newInstAcctBal = $instDetails['account_balance_derived'] - $transactionCacheAmount;
                        $newInstTotalBalDer = $instDetails['total_withdrawals_derived'] + $transactionCacheAmount;
                        $idValue = $instDetails['id'];
                        $update_instAccountCon = [
                            'submittedon_userid' => $transactionCacheStaff_id,
                            'account_balance_derived' => $newInstAcctBal,
                            'teller_id' => $transactionCacheTellerId,
                            'total_withdrawals_derived' => $newInstTotalBalDer,
                            'last_activity_date' => date("Y-m-d H:i:s"),
                            'chooseDate' => $transactionCacheDate
                        ];

                        //                        get info about institution_account_transaction and update it
                        $instAccountTransCon = [
                            'int_id' => $inst_id,
                            'branch_id' => $transactionCacheBranchId,
                            'client_id' => $transactionCacheClientId,
                            'transaction_id' => $transactionCacheTransId,
                            'description' => $transactionCacheDesc,
                            'transaction_type' => 'debit',
                            'teller_id' => $transactionCacheTellerId,
                            'is_vault' => 0,
                            'transaction_date' => $transactionCacheDate,
                            'amount' => $transactionCacheAmount,
                            'running_balance_derived' => $newInstAcctBal,
                            'cumulative_balance_derived' => $newInstAcctBal,
                            'created_date' => date("Y-m-d H:i:s"),
                            'appuser_id' => $transactionCacheStaff_id,
                            'debit' => $transactionCacheAmount
                        ];


                        //                        get information for gl_account_transaction
                        $gl_accountCon = [
                            'int_id' => $inst_id,
                            'branch_id' => $transactionCacheBranchId,
                            'gl_code' => $glCode,
                            'parent_id' => $accountProductId,
                            'transaction_id' => $transactionCacheTransId,
                            'description' => $transactionCacheDesc,
                            'transaction_type' => 'debit',
                            'teller_id' => $transactionCacheTellerId,
                            'transaction_date' => $transactionCacheDate,
                            'amount' => $transactionCacheAmount,
                            'gl_account_balance_derived' => $newOrgRunningBal,
                            'cumulative_balance_derived' => $newOrgRunningBal,
                            'created_date' => date("Y-m-d H:i:s"),
                            'debit' => $transactionCacheAmount
                        ];

//                            a check to make sure all information are available and correct before sending it to data tables
                        if ($tellerDetails && $accountDetails && $getGlCode && $glAccountDetails && $instDetails) {
                            //                        update account table
                            $updateLastWithdrawal = update('account', $accountId, $accountConstantName, $accountData);
//                                insert into account transaction
                            $accountTransDetails = create('account_transaction', $accountTransData);
                            //                        update the acc_gl_account
                            $update_glAccount = update('acc_gl_account', $glAccountDetails['id'],
                                'id', ['organization_running_balance_derived' => $newOrgRunningBal]);
//                                update the institution account information
                            $update_instAccount = update('institution_account', $idValue, 'id', $update_instAccountCon);
//                                insert record in institution account transaction
                            $institution_account = create('institution_account_transaction', $instAccountTransCon);
//                                insert record into gl account transaction
                            $gl_accountDetails = create('gl_account_transaction', $gl_accountCon);
//                            Update the transact_cache with verified
                            $updateTransactionCache = update('transact_cache', $transactionCacheId, 'id', ['status' => 'Verified']);
                        }
                    }
                    $totalNumber = count($_POST['checkBoxArray']);
                    $_SESSION["Lack_of_intfund_$randms"] = "Transaction Approved";
                    header("Location: ../transact_approval.php?messageBulkApp5=$totalNumber");
                    exit();
                }
                break;
            case
            'Decline':
                $bulk_options_type = $_POST['bulk_options_type'];
//            Decline Withdrawal
                if ($bulk_options_type === 'Withdrawal') {
                    foreach ($_POST['checkBoxArray'] as $key => $postValueId) {
                        $id = $postValueId;
                        $inst_id = $_SESSION['int_id'];

//        Get the transaction from transact_cache
                        $transactionDataCon = ['id' => $id, 'int_id' => $inst_id, 'status' => 'Pending', 'transact_type' => $bulk_options_type];
                        $transactionData = selectOne('transact_cache', $transactionDataCon);
                        if (!$transactionData) {
                            $_SESSION["Lack_of_intfund_$randms"] = "No Withdrawal Transaction Found";
                            header("Location: ../transact_approval.php?messageBulkApp7=$randms");
                            exit();
                        }
                        $transactionCacheId = $transactionData['id'];
//                            Update the transact_cache with Decline
                        $updateTransactionCache = update('transact_cache', $transactionCacheId, 'id', ['status' => 'Decline']);
                    }
                    if ($updateTransactionCache) {
                        $totalNumber = count($_POST['checkBoxArray']);
                        $_SESSION["Lack_of_intfund_$randms"] = "Transaction Approved";
                        header("Location: ../transact_approval.php?messageBulkApp6=$totalNumber");
                        exit();
                    }
                } else {
//                    Decline Deposit
                    foreach ($_POST['checkBoxArray'] as $key => $postValueId) {
                        $id = $postValueId;
                        $inst_id = $_SESSION['int_id'];

//        Get the transaction from transact_cache
                        $transactionDataCon = ['id' => $id, 'int_id' => $inst_id, 'status' => 'Pending', 'transact_type' => $bulk_options_type];
                        $transactionData = selectOne('transact_cache', $transactionDataCon);
                        if (!$transactionData) {
                            $_SESSION["Lack_of_intfund_$randms"] = "No Withdrawal Transaction Found";
                            header("Location: ../transact_approval.php?messageBulkApp7=$randms");
                            exit();
                        }
                        $transactionCacheId = $transactionData['id'];
//                            Update the transact_cache with Decline
                        $updateTransactionCache = update('transact_cache', $transactionCacheId, 'id', ['status' => 'Decline']);
                        if ($updateTransactionCache) {
                            $totalNumber = count($_POST['checkBoxArray']);
                            $_SESSION["Lack_of_intfund_$randms"] = "Transaction Approved";
                            header("Location: ../transact_approval.php?messageBulkApp6=$totalNumber");
                            exit();
                        }
                    }

                }
                break;
        }
    } else {
        $_SESSION["Lack_of_intfund_$randms"] = "Sorry Please Select Some Transactions";
        header("Location: ../transact_approval.php?message4=$randms");
        exit();
    }
}

