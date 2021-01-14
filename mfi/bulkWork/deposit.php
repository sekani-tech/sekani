<?php
include('../../functions/connect.php');
session_start();

/** Include PHPExcel_IOFactory */
include('../vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;

$digit = 4;
try {
    $randms = str_pad(random_int(0, (10 ** $digit) - 1), 7, '0', STR_PAD_LEFT);
} catch (Exception $e) {
}
if (isset($_POST['submit'])) {
//    chosen branch upon upload
    $chosenBranch = $_POST['branch'];
    $transactionType = $_POST['transaction'];
    $inst_id = $_SESSION['int_id'];
    $currentAppUser = $_SESSION['staff_id'];
    $totalAmount = 0;
    $tellerId = null;

//    check for excel file submitted
    if ($_FILES["excelFile"]["name"] !== '') {
        $allowed_extension = array('xls', 'csv', 'xlsx');
        $file_array = explode(".", $_FILES["excelFile"]["name"]);
        $file_extension = end($file_array);

        if (in_array($file_extension, $allowed_extension)) {
            try {
                $file_name = time() . '.' . $file_extension;
                move_uploaded_file($_FILES['excelFile']['tmp_name'], $file_name);
                $file_type = IOFactory::identify($file_name);
                $reader = IOFactory::createReader($file_type);
                $spreadsheet = $reader->load($file_name);

                unlink($file_name);

//            Data from excel Sheet
                $data = $spreadsheet->getActiveSheet()->toArray();
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            }

//            our data table for insertion
            $ourDataTables = [];
        }

//            Join data with content from the excel sheet
        foreach ($data as $key => $row) {
            $ourDataTables[] = array(
                'Branch_Name' => $row['0'],
                'Account_Name' => $row['1'],
                'Account_Number' => $row['2'],
                'Phone_Number' => $row['3'],
                'date' => $row['4'],
                'amount' => $row['5'],
                'teller_id' => $row['6'],
                'payment_type_id' => $row['7'],
                'transaction_type_id' => $row['8']
            );
        }

//        get the total money and and teller Id and check of the header is removed
        foreach ($ourDataTables as $key => $ourData) {
            //                check if the header was remove
            if ($ourData['teller_id'] === "teller id") {
                $_SESSION["Lack_of_intfund_$randms"] = "Sorry Please remove the header from this file";
                header("Location: ../bulk_deposit.php?message6=$randms");
                exit();
            }

            if ($ourData['payment_type_id'] === 'payment type id') {
                $_SESSION["Lack_of_intfund_$randms"] = "Sorry Please Add the payment type Id before upload";
                header("Location: ../bulk_deposit.php?message7=$randms");
                exit();
            }
            if ($ourData['transaction_type_id'] === 'Transaction Type') {
                $_SESSION["Lack_of_intfund_$randms"] = "Sorry Please Add the transaction type Id before upload";
                header("Location: ../bulk_deposit.php?message8=$randms");
                exit();
            }
            $totalAmount += $ourData['amount'];
            $tellerId = $ourData['teller_id'];
        }

        //                getting tellers info to check for post limit
        $tellersCondition = ['id' => $tellerId];
        $tellerDetails = selectOne('tellers', $tellersCondition);
//                branch and teller id for check
        $tellerNameId = $tellerDetails['name'];
        $tellerBranch = $tellerDetails['branch_id'];
        $tellerPostLimit = $tellerDetails['post_limit'];

        if ($transactionType == 1) {
            // deposit
            if ($ourData['transaction_type_id'] != $transactionType) {
                $_SESSION["Lack_of_intfund_$randms"] = "Sorry File Input Rejected!";
                header("Location: ../bulk_deposit.php?message9=$randms");
                exit();
            } else {
                if ($totalAmount > $tellerPostLimit) {
//            send information one by one
                    foreach ($ourDataTables as $key => $ourDataTable) {
//                Variable Name
                        try {
                            $depositRand = str_pad(random_int(0, (10 ** $digit) - 1), 7, '0', STR_PAD_LEFT);
                        } catch (Exception $e) {
                        }
                        $accountClientName = $ourDataTable['Account_Name'];
                        $paymentType = $ourDataTable['payment_type_id'];
                        $amount = $ourDataTable['amount'];
                        $tellerId = $ourDataTable['teller_id'];

                        $convertDate = strtotime($ourDataTable['date']);
                        $date = date('Y-m-d', $convertDate);
                        $fullDate = $date . ' ' . date('H:i:s');
//                        $transactionNumber = $ourDataTable['deposit_slip_number'];
//                    check account number given
                        if (strlen($ourDataTable['Account_Number']) === 9) {
                            $accountNumber = '0' . $ourDataTable['Account_Number'];
                        } else if (strlen($ourDataTable['Account_Number']) <= 8) {
                            $accountNumber = '00' . $ourDataTable['Account_Number'];
                        } else {
                            $accountNumber = $ourDataTable['Account_Number'];
                        }

                        if ($chosenBranch == $tellerBranch) {

//                  get account information using account number
                            $accountDetails = selectOne('account', ['account_no' => $accountNumber]);
//                  account information for other table
                            $accountProductId = $accountDetails['product_id'];
                            $accountId = $accountDetails['id'];
                            $accountClientId = $accountDetails['client_id'];
                            //                      get information and update transact_cache
                            $transactionCacheCon = [
                                'int_id' => $inst_id,
                                'branch_id' => $chosenBranch,
                                'transact_id' => $depositRand,
                                'description' => 'Bulk Deposit',
                                'account_no' => $accountNumber,
                                'client_id' => $accountClientId,
                                'client_name' => $accountClientName,
                                'staff_id' => $currentAppUser,
                                'teller_id' => $tellerId,
                                'amount' => $amount,
                                'pay_type' => $paymentType,
                                'transact_type' => 'Deposit',
                                'product_type' => $accountProductId,
                                'status' => 'Pending',
                                'date' => $fullDate,
                            ];
                            $transactionCacheApproval = create('transact_cache', $transactionCacheCon);
                        } else {
                            $_SESSION["Lack_of_intfund_$randms"] = "Sorry this Teller Can not Preform this Action";
                            header("Location: ../bulk_deposit.php?message5=$randms");
                            exit();
                        }
                    }
                    if ($transactionCacheApproval) {
                        $_SESSION["Lack_of_intfund_$randms"] = "Sent for Approval!";
                        header("Location: ../bulk_deposit.php?message4=$randms");
                        exit();
                    }
                }
                else {
//            send information one by one
                    foreach ($ourDataTables as $kay => $ourDataTable) {
//                Variable Name
                        $accountClientName = $ourDataTable['Account_Name'];
                        $paymentType = $ourDataTable['payment_type_id'];
                        $amount = $ourDataTable['amount'];
                        $tellerId = $ourDataTable['teller_id'];
                        $convertDate = strtotime($ourDataTable['date']);
                        $date = date('Y-m-d', $convertDate);
                        $fullDate = $date . ' ' . date('H:i:s');
//                        $transactionNumber = $ourDataTable['deposit_slip_number'];
//                    check account number given
                        if (strlen($ourDataTable['Account_Number']) < 10) {
                            $accountNumber = '00' . $ourDataTable['Account_Number'];
                        } else {
                            $accountNumber = $ourDataTable['Account_Number'];
                        }

                        if ($chosenBranch == $tellerBranch) {

//                  get account information using account number
                            $accountDetails = selectOne('account', ['account_no' => $accountNumber]);
//                    dd($accountDetails);
//                  account information for other table
                            $accountProductId = $accountDetails['product_id'];
                            $accountId = $accountDetails['id'];
                            $accountClientId = $accountDetails['client_id'];


                            //                        set all total derived
                            $totalDeposit = $accountDetails['total_deposits_derived'] + $amount;
                            $accountBal = $accountDetails['account_balance_derived'] + $amount;

                            //                        prepare information for database
                            $accountConstantName = 'id';
                            $accountData = [
                                'total_deposits_derived' => $totalDeposit,
                                'account_balance_derived' => $accountBal,
                                'last_deposit' => $amount,
                                'last_activity_date' => date("Y-m-d"),
                                'chooseDate' => $date
                            ];
                            //                        update account table
                            $updateLastDeposit = update('account', $accountId, $accountConstantName, $accountData);

                            //                        send record to account_transaction details and update the necessary information
                            $accountTransData = [
                                'int_id' => $inst_id,
                                'branch_id' => $chosenBranch,
                                'product_id' => $accountProductId,
                                'account_id' => $accountId,
                                'account_no' => $accountNumber,
                                'client_id' => $accountClientId,
                                'teller_id' => $tellerId,
                                'transaction_id' => $randms,
                                'description' => 'bulk deposit',
                                'transaction_type' => 'credit',
                                'transaction_date' => $fullDate,
                                'amount' => $amount,
                                'running_balance_derived' => $accountBal,
                                'cumulative_balance_derived' => $accountBal,
                                'created_date' => date("Y-m-d H:i:s"),
                                'chooseDate' => $date,
                                'appuser_id' => $currentAppUser,
                                'credit' => $amount,
                            ];
                            $accountTransDetails = create('account_transaction', $accountTransData);

                            $getGlCode = selectOne('payment_type', ['id' => $paymentType]);
                            $glCode = $getGlCode['gl_code'];
                            //                        get information form gl_account and update it
                            $acc_gl_accountData = ['gl_code' => $glCode, 'int_id' => $inst_id];
                            $glAccountDetails = selectOne('acc_gl_account', $acc_gl_accountData);
                            // dd($glAccountDetails);
                            $newOrgRunningBal = $glAccountDetails['organization_running_balance_derived'] + $amount;

                            //                        update the acc_gl_account
                            $update_glAccount = update('acc_gl_account', $glAccountDetails['id'],
                                'id', ['organization_running_balance_derived' => $newOrgRunningBal]);

//                      get insit information and add new amount to old balance
                            $instCondition = ['int_id' => $inst_id, 'teller_id' => $tellerNameId];
                            $instDetails = selectOne('institution_account', $instCondition);
                            $new_inst_acct_bal = $instDetails['account_balance_derived'] + $amount;
                            $new_inst_total_bal_der = $instDetails['total_deposits_derived'] + $amount;
//                        dd($instDetails['account_balance_derived']);

//                        prepare data for update
                            $idValue = $instDetails['id'];
                            $update_instAccountCon = [
                                'submittedon_userid' => $currentAppUser,
                                'account_balance_derived' => $new_inst_acct_bal,
                                'teller_id' => $tellerNameId,
                                'total_deposits_derived' => $new_inst_total_bal_der,
                                'last_activity_date' => date("Y-m-d H:i:s"),
                                'chooseDate' => $date
                            ];
                            $update_instAccount = update('institution_account', $idValue, 'id', $update_instAccountCon);

//                        get info about institution_account_transaction and update it
                            $instAccountTransCon = [
                                'int_id' => $inst_id,
                                'branch_id' => $chosenBranch,
                                'client_id' => $accountClientId,
                                'transaction_id' => $randms,
                                'description' => 'Bulk Deposit',
                                'transaction_type' => 'credit',
                                'teller_id' => $tellerNameId,
                                'is_vault' => 0,
                                'transaction_date' => $date,
                                'amount' => $amount,
                                'running_balance_derived' => $new_inst_acct_bal,
                                'cumulative_balance_derived' => $new_inst_acct_bal,
                                'created_date' => $fullDate,
                                'appuser_id' => $currentAppUser,
                                'credit' => $amount
                            ];
                            $institution_account = create('institution_account_transaction', $instAccountTransCon);

//                        get information and update transact_cache
                            $transactionCacheCon = [
                                'int_id' => $inst_id,
                                'branch_id' => $chosenBranch,
                                'transact_id' => $randms,
                                'description' => 'Bulk Deposit',
                                'account_no' => $accountNumber,
                                'client_id' => $accountClientId,
                                'client_name' => $accountClientName,
                                'staff_id' => $currentAppUser,
                                'amount' => $amount,
                                'pay_type' => 'Cash',
                                'transact_type' => 'Deposit',
                                'product_type' => $accountProductId,
                                'status' => 'Verified',
                                'date' => $fullDate,
                            ];
//                        fix gl_code when you meet boss
                            $transactionCache = create('transact_cache', $transactionCacheCon);

//                        get information for gl_account_transaction
                            $gl_accountCon = [
                                'int_id' => $inst_id,
                                'branch_id' => $chosenBranch,
                                'gl_code' => $glCode,
                                'parent_id' => $accountProductId,
                                'transaction_id' => $randms,
                                'description' => 'Bulk Deposit',
                                'transaction_type' => 'Deposit',
                                'teller_id' => $tellerNameId,
                                'transaction_date' => $date,
                                'amount' => $amount,
                                'gl_account_balance_derived' => $newOrgRunningBal,
                                'cumulative_balance_derived' => $newOrgRunningBal,
                                'created_date' => $fullDate,
                                'credit' => $amount
                            ];
                            $gl_accountDetails = create('gl_account_transaction', $gl_accountCon);
                        } else {
                            $_SESSION["Lack_of_intfund_$randms"] = "Sorry this Teller Can not Preform this Action";
                            header("Location: ../bulk_deposit.php?message5=$randms");
                            exit();
                        }

                    }
//                        check if every data was sent successfully
                    if (!empty($gl_accountDetails) && !empty($transactionCache) && !empty($institution_account)
                        && !empty($tellerDetails) && !empty($accountDetails) && !empty($instDetails)
                        && !empty($glAccountDetails) && !empty($accountTransDetails) && !empty($transactionCacheApproval)) {
                        if (!empty($update_instAccount) && !empty($update_glAccount) && !empty($updateLastDeposit)) {
                            $_SESSION["Lack_of_intfund_$randms"] = "Transaction Successful!";
                            header("Location: ../bulk_deposit.php?message1=$randms");
                            exit();
                        }
                        // check for approval
                    } elseif (!empty($transactionCache) && !empty($gl_accountDetails) && !empty($institution_account)
                        && !empty($tellerDetails) && !empty($accountDetails) && !empty($instDetails)
                        && !empty($glAccountDetails) && !empty($accountTransDetails)) {
                        $_SESSION["Lack_of_intfund_$randms"] = "Sent for Approval!";
                        header("Location: ../bulk_deposit.php?message4=$randms");
                        exit();
                    } else {
                        $_SESSION["Lack_of_intfund_$randms"] = "Transaction not Successful!";
                        header("Location: ../bulk_deposit.php?message2=$randms");
                        exit();
                    }
                }
            }
        }
        if ($transactionType == 2) {
            // withdrawal
            if ($ourData['transaction_type_id'] != $transactionType) {
                $_SESSION["Lack_of_intfund_$randms"] = "Sorry File Input Rejected!";
                header("Location: ../bulk_deposit.php?message10=$randms");
                exit();
            } else {
//            send information one by one
                foreach ($ourDataTables as $key => $ourDataTable) {
                    try {
                        $withDrawRand = str_pad(random_int(0, (10 ** $digit) - 1), 7, '0', STR_PAD_LEFT);
                    } catch (Exception $e) {
                    }
//                Variable Name
                    $accountClientName = $ourDataTable['Account_Name'];
                    $paymentType = $ourDataTable['payment_type_id'];
                    $amount = $ourDataTable['amount'];
                    $tellerId = $ourDataTable['teller_id'];
                    $convertDate = strtotime($ourDataTable['date']);
                    $date = date('Y-m-d', $convertDate);
                    $fullDate = $date . ' ' . date('H:i:s');
//                    $transactionNumber = $ourDataTable['deposit_slip_number'];
//                    check account number given
                    if (strlen($ourDataTable['Account_Number']) === 9) {
                        $accountNumber = '0' . $ourDataTable['Account_Number'];
                    } else if (strlen($ourDataTable['Account_Number']) <= 8) {
                        $accountNumber = '00' . $ourDataTable['Account_Number'];
                    } else {
                        $accountNumber = $ourDataTable['Account_Number'];
                    }

                    if ($chosenBranch == $tellerBranch) {

//                  get account information using account number
                        $accountDetails = selectOne('account', ['account_no' => $accountNumber]);

//                  account information for other table
                        $accountProductId = $accountDetails['product_id'];
                        $accountId = $accountDetails['id'];
                        $accountClientId = $accountDetails['client_id'];
                        //                      get information and update transact_cache
                        $transactionCacheCon = [
                            'int_id' => $inst_id,
                            'branch_id' => $chosenBranch,
                            'transact_id' => $withDrawRand,
                            'description' => 'Bulk Withdrawal',
                            'account_no' => $accountNumber,
                            'client_id' => $accountClientId,
                            'client_name' => $accountClientName,
                            'staff_id' => $currentAppUser,
                            'teller_id' => $tellerId,
                            'amount' => $amount,
                            'pay_type' => $paymentType,
                            'transact_type' => 'Withdrawal',
                            'product_type' => $accountProductId,
                            'status' => 'Pending',
                            'date' => $fullDate,
                        ];
                        $transactionCacheApproval = create('transact_cache', $transactionCacheCon);
                    } else {
                        $_SESSION["Lack_of_intfund_$randms"] = "Sorry this Teller Can not Preform this Action";
                        header("Location: ../bulk_deposit.php?message5=$randms");
                        exit();
                    }
                }
                if ($transactionCacheApproval) {

                    $_SESSION["Lack_of_intfund_$randms"] = "Sent for Approval!";
                    header("Location: ../bulk_deposit.php?message4=$randms");
                    exit();
                }

            }
        }
    } else {
        $_SESSION["Lack_of_intfund_$randms"] = "File Input Rejected!";
        header("Location: ../bulk_deposit.php?message3=$randms");
        exit();
    }
}


