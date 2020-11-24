<?php
include('../../functions/connect.php');
session_start();

/** Include PHPExcel_IOFactory */
include('../vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['submit'])) {
    $digit = 4;
    $randms = str_pad(rand(0, pow(10, $digit) - 1), 7, '0', STR_PAD_LEFT);
//    chosen branch upon upload
    $chosenBranch = $_POST['branch'];
    $inst_id = $_SESSION['int_id'];
    $currentAppUser = $_SESSION['staff_id'];

//    check for excel file submitted
    if ($_FILES["excelFile"]["name"] != '') {
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

//            Join data with content from the excel sheet
            foreach ($data as $key => $row) {
                $ourDataTables[] = array(
                    'Branch_Name' => $row['0'],
                    'Account_Name' => $row['1'],
                    'Account_Number' => $row['2'],
                    'Phone_Number' => $row['3'],
                    'date' => $row['4'],
                    'amount' => $row['5'],
                    'deposit_slip_number' => $row['6'],
                    'teller_id' => $row['7'],
                );
            }

//            send information one by one
            foreach ($ourDataTables as $key => $ourDataTable) {
//                Variable Name
                $accountClientName = $ourDataTable['Account_Name'];
                $amount = $ourDataTable['amount'];
                $tellerId = $ourDataTable['teller_id'];
                $convertDate = strtotime($ourDataTable['date']);
                $date = date('Y-m-d', $convertDate);
                $fullDate = $date . ' ' . date('H:i:s');
                $transactionNumber = $ourDataTable['deposit_slip_number'];


//                    check account number given
                if (strlen($ourDataTable['Account_Number']) < 10) {
                    $accountNumber = '00' . $ourDataTable['Account_Number'];
                } else $accountNumber = $ourDataTable['Account_Number'];

//                getting tellers info to check for post limit
                $tellersCondition = ['id' => $tellerId];
                $tellerDetails = selectOne('tellers', $tellersCondition);
//                branch and teller id for check
                $tellerNameId = $tellerDetails['name'];
                $tellerBranch = $tellerDetails['branch_id'];
                $tellerPostLimit = $tellerDetails['post_limit'];
                if ($tellerBranch == $chosenBranch) {

//                  get account information using account number
                    $accountDetails = selectOne('account', ['account_no' => $accountNumber]);

//                  account information for other table
                    $accountProductId = $accountDetails['product_id'];
                    $accountId = $accountDetails['id'];
                    $accountClientId = $accountDetails['client_id'];

                    if ($amount > $tellerPostLimit) {
//                      get information and update transact_cache
                        $transactionCacheCon = [
                            'int_id' => $inst_id,
                            'branch_id' => $chosenBranch,
                            'transact_id' => $transactionNumber,
                            'description' => 'Bulk Deposit',
                            'account_no' => $accountNumber,
                            'client_id' => $accountClientId,
                            'client_name' => $accountClientName,
                            'staff_id' => $currentAppUser,
                            'amount' => $amount,
                            'pay_type' => 'Cash',
                            'transact_type' => 'Deposit',
                            'product_type' => $accountProductId,
                            'status' => 'Pending',
                            'date' => $fullDate,
                        ];
//                        fix gl_code when you meet boss
                        $transactionCacheApproval = create('transact_cache', $transactionCacheCon);
                    } else {
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
                            'transaction_id' => $transactionNumber,
                            'description' => 'bulk deposit',
                            'transaction_type' => 'debit',
                            'transaction_date' => $fullDate,
                            'amount' => $amount,
                            'running_balance_derived' => $accountBal,
                            'cumulative_balance_derived' => $accountBal,
                            'created_date' => date("Y-m-d H:i:s"),
                            'appuser_id' => $currentAppUser,
                            'debit' => $amount,
                        ];
                        $accountTransDetails = create('account_transaction', $accountTransData);

                        $getGlCode = selectOne('acct_rule', ['loan_product_id' => $accountProductId]);
                        $glCode = $getGlCode['asst_loan_port'];
//                        get information form gl_account and update it
                        $acc_gl_accountData = ['gl_code' => $glCode];
                        $glAccountDetails = selectOne('acc_gl_account', $acc_gl_accountData);
                        $newOrgRunningBal = $glAccountDetails['organization_running_balance_derived'] + $amount;

//                        update the acc_gl_account
                        $update_glAccount = update('acc_gl_account', $glAccountDetails['id'], 'id', ['organization_running_balance_derived' => $newOrgRunningBal]);

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
                            'last_activity_date' => $date
                        ];
                        $update_instAccount = update('institution_account', $idValue, 'id', $update_instAccountCon);

//                        get info about institution_account_transaction and update it
                        $instAccountTransCon = [
                            'int_id' => $inst_id,
                            'branch_id' => $chosenBranch,
                            'client_id' => $accountClientId,
                            'transaction_id' => $transactionNumber,
                            'description' => 'Bulk Deposit',
                            'transaction_type' => 'debit',
                            'teller_id' => $tellerNameId,
                            'is_vault' => 0,
                            'transaction_date' => $date,
                            'amount' => $amount,
                            'running_balance_derived' => $new_inst_acct_bal,
                            'cumulative_balance_derived' => $new_inst_acct_bal,
                            'created_date' => $fullDate,
                            'appuser_id' => $currentAppUser,
                            'debit' => $amount
                        ];
                        $institution_account = create('institution_account_transaction', $instAccountTransCon);

//                        get information and update transact_cache
                        $transactionCacheCon = [
                            'int_id' => $inst_id,
                            'branch_id' => $chosenBranch,
                            'transact_id' => $transactionNumber,
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
                            'transaction_id' => $transactionNumber,
                            'description' => 'Bulk Deposit',
                            'transaction_type' => 'Deposit',
                            'teller_id' => $tellerNameId,
                            'transaction_date' => $date,
                            'amount' => $amount,
                            'gl_account_balance_derived' => $newOrgRunningBal,
                            'cumulative_balance_derived' => $newOrgRunningBal,
                            'created_date' => $fullDate,
                            'debit' => $amount
                        ];
//                        $gl_accountDetails = create('gl_account_transaction', $gl_accountCon);

                    }


                } else {
                    echo $message = '<div class="alert alert-danger">Sorry this Teller Can not Preform this Action</div>';
                    exit();
                }

            }
//                        check if every data was sent successfully
            if (!empty($gl_accountDetails) && !empty($transactionCache) && !empty($institution_account)
                && !empty($tellerDetails) && !empty($accountDetails) && !empty($instDetails)
                && !empty($glAccountDetails) && !empty($accountTransDetails) && !empty($transactionCacheApproval)) {
                if (!empty($update_instAccount) && !empty($update_glAccount) && !empty($updateLastDeposit) ) {
                    $_SESSION["Lack_of_intfund_$randms"] = "Transaction Successful!";
                    header ("Location: ../bulk_deposit.php?message1=$randms");
                    exit();
                }
            } elseif (!empty($gl_accountDetails) && !empty($transactionCache) && !empty($institution_account)
                && !empty($tellerDetails) && !empty($accountDetails) && !empty($instDetails)
                && !empty($glAccountDetails) && !empty($accountTransDetails)) {
                $_SESSION["Lack_of_intfund_$randms"] = "Sent for Approval!";
                header ("Location: ../bulk_deposit.php?message4=$randms");
                exit();
            } else {
                $_SESSION["Lack_of_intfund_$randms"] = "Transaction not Successful!";
                header ("Location: ../bulk_deposit.php?message2=$randms");
                exit();
            }
        }

    } else {
        $_SESSION["Lack_of_intfund_$randms"] = "File Input Rejected!";
        header ("Location: ../bulk_deposit.php?message3=$randms");
        exit();
    }


}
