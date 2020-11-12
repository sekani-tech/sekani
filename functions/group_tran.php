<?php
include 'connect.php';
require_once "../bat/phpmailer/PHPMailerAutoload.php";
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $collections = [];
    foreach ($_POST['customerID'] as $key => $value) {
        $collections[] = array('client_id' => $value, 'client_amount' => $_POST['amount'][$key], 'client_name' => $_POST['customerName'][$key]);
    }


// CHECK Session and Pass information into variable
//    inst name
    $int_name = $_SESSION["int_name"];
//        inst email
    $int_email = $_SESSION["int_email"];
    $int_web = $_SESSION["int_web"];
    $type = $_POST['pay_type'];
    $description = $_POST['description'];

//    inst phone number
    $int_phone = $_SESSION["int_phone"];
    $int_logo = $_SESSION["int_logo"];
    $int_address = $_SESSION["int_address"];
    $sessint_id = $_SESSION["int_id"];
//    user Id from staff table
    $m_id = $_SESSION["user_id"];
//    sender id
    $sender_id = $_SESSION["sender_id"];
    $today = date('Y-m-d');
    $branch_id = $_SESSION["branch_id"];

//    get the staff posting
    $staffCondition = ['user_id' => $m_id, 'int_id' => $sessint_id];
    $staffDetails = selectOne('staff', $staffCondition);

    $staffEmail = $staffDetails['email'];
    $staffId = $staffDetails['user_id'];

    if ($_POST['acc'] == 'deposit') {
        foreach ($collections as $key => $collection) {
//        get users Account Details
            $clientAmount = $collection['client_amount'];

//            Generating a transaction Id
            for ($len = 20, $transId = ''; strlen($transId) < $len; $transId .= chr(!mt_rand(0, 2) ? mt_rand(48, 57) : (!mt_rand(0, 1) ? mt_rand(65, 90) : mt_rand(97, 122)))) ;

//            getting Client information
            $clientCondition = ['id' => $collection['client_id'], 'int_id' => $sessint_id];
            $clientDetails = selectOne('client', $clientCondition);


//            check if the account number have 00 and add when necessary
            if (strlen($clientDetails['account_no']) < 10) {
                $clientAccountNumber = '00' . $clientDetails['account_no'];
            } else {
                $clientAccountNumber = $clientDetails['account_no'];
            }

            $accountCondition = ['account_no' => $clientAccountNumber, 'int_id' => $sessint_id];
            $clientAccountDetail = selectOne('account', $accountCondition);

//           get the savings product id
            $product_id = $clientAccountDetail['product_id'];
            $client_id = $clientAccountDetail['client_id'];
            $new_client_acct_bal = $clientAccountDetail['account_balance_derived'] + $clientAmount;
            $new_total_dep_derived = $clientAccountDetail['total_deposits_derived'] + $clientAmount;
//            increase client amount

            $numberAcct = number_format("$new_client_acct_bal", 2);
            $trans_type = "credit";
            $is_reversed = 0;
            $gen_date = date('Y-m-d H:i:s');
            $pint = date('Y-m-d H:i:s');
            $gends = date('Y-m-d h:i:sa');

//            get insit information and add new amount to old balance
            $instCondition = ['int_id' => $sessint_id, 'teller_id' => $staffId];
            $instDetails = selectOne('institution_account', $instCondition);

            if ($instDetails) {
                $new_inst_acct_bal = $instDetails['account_balance_derived'] + $clientAmount;
                $new_inst_total_bal_der = $instDetails['total_deposits_derived'] + $clientAmount;
            }

//            check if client exist, tell id exist, and amount exist
//            dd($clientAmount);
            if (!empty($client_id) && !empty($staffId) && !empty($clientAmount)) {
                $tellerCondition = ['int_id' => $sessint_id, 'name' => $staffId];
                $tellerDetails = selectOne('tellers', $tellerCondition);
                $is_del = $tellerDetails['is_deleted'];
                $till = $tellerDetails['till'];
                $post_limit = $tellerDetails['post_limit'];
                $till_no = $tellerDetails['till_no'];
                $till_name = $tellerDetails['name'];

//                getting the payment type using $type
                $paymentTypeCondition = ['int_id' => $sessint_id, 'id' => $type];
                $paymentTypeDetails = selectOne('payment_type', $paymentTypeCondition);
                $isBank = $paymentTypeDetails['is_bank'];
                $glCode = $paymentTypeDetails['gl_code'];

//                use glCode to get organization balance and parent information
                $organizationCon = ['int_id' => $sessint_id, 'gl_code' => $glCode];
                $organizationDetails = selectOne('acc_gl_account', $organizationCon);
//                dd($organizationDetails);
                $organizationBal = $organizationDetails["organization_running_balance_derived"];
                $new_l_acct_bal = $organizationBal + $clientAmount;
                $parent = $organizationDetails["parent_id"];

//                institution Account transaction check
                $instAccountTransactionCon = ['int_id' => $sessint_id, 'transaction_id' => $transId];
                $instAccountTransactionDetails = selectOne('institution_account_transaction', $instAccountTransactionCon);

//                account transaction check
                $accountTransCondition = ['int_id' => $sessint_id, 'transaction_id' => $transId];
                $accountTransDetails = selectOne('account_transaction', $accountTransCondition);

//                transact cache check
                $transactCacheCon = ['int_id' => $sessint_id, 'transact_id' => $transId];
                $transactCacheDetails = selectOne('transact_cache', $transactCacheCon);

//                display Account number
                $account_display = substr("$clientAccountNumber", 0, 3) . "*****" . substr("$clientAccountNumber", 8);

//                information for display
//                collect client information which include name, email, phone and sms status

                $clientFullName = $clientDetails['firstname'] . ' ' . $clientDetails['middlename'] . ' ' . $clientDetails['lastname'];
                $client_name = strtoupper($clientFullName);
                $client_email = $clientDetails["email_address"];
                $client_phone = $clientDetails["mobile_no"];
                $client_sms = $clientDetails["SMS_ACTIVE"];

                if ($transactCacheDetails == 0 && $accountTransDetails == 0 && $instAccountTransactionDetails == 0) {
//                    check if tell is Active for the transaction
                    if ($is_del == "0") {
                        if ($clientAmount <= $post_limit) {

//                            update account table
                            $constantName = 'account_no';
                            $updateClientCon = [
                                'account_balance_derived' => $new_client_acct_bal,
                                'updatedon_date' => $today,
                                'last_deposit' => $clientAmount,
                                'total_deposits_derived' => $new_total_dep_derived
                            ];
                            $updateClient = update('account', $clientAccountNumber, $constantName, $updateClientCon);

                            if ($updateClient) {

                                // update the clients transaction
                                $updateClientTransCon = [
                                    'int_id' => $sessint_id, 'branch_id' => $branch_id,
                                    'account_no' => $clientAccountNumber, 'product_id' => $product_id,
                                    'teller_id' => $staffId, 'client_id' => $client_id,
                                    'transaction_id' => $transId, 'description' => $description,
                                    'transaction_type' => $trans_type, 'is_reversed' => $is_reversed,
                                    'transaction_date' => $gen_date, 'amount' => $clientAmount,
                                    'running_balance_derived' => $new_client_acct_bal, 'overdraft_amount_derived' => $clientAmount,
                                    'created_date' => $gen_date, 'appuser_id' => $m_id, 'credit' => $clientAmount
                                ];
                                $updateClientTrans = create('account_transaction', $updateClientTransCon);
                                if ($updateClientTrans) {
                                    // get the loan in arrears
                                    $checkClientLoanCon = ['int_id' => $sessint_id, 'client_id' => $client_id];
                                    $checkClientLoanDetails = checkLoanArrears('loan_arrear', $checkClientLoanCon);

                                    if ($checkClientLoanDetails) {
//                                        loan Arrears Information
                                        $clientArrearsId = $checkClientLoanDetails["id"];
                                        $arrearsInstId = $checkClientLoanDetails["int_id"];
                                        $arrearloanId = $checkClientLoanDetails["loan_id"];
                                        $a_principal = $checkClientLoanDetails["principal_amount"];
                                        $a_interest = $checkClientLoanDetails["interest_amount"];
                                        $loan_amount = $a_principal + $a_interest;

//                                        get loan information
                                        $loanCondition = ['id' => $arrearloanId, 'int_id' => $sessint_id];
                                        $loanDetails = selectOne('loan', $loanCondition);
                                        $loan_product_id = $loanDetails["product_id"];
                                        $current_out_loan = $loanDetails["total_outstanding_derived"];

//                                        get acct_rule information
                                        $accRuleCon = ['int_id' => $sessint_id, 'loan_product_id' => $loan_product_id];
                                        $accRuleDetails = selectOne('acct_rule', $accRuleCon);
                                        // loan portfolio
                                        $loan_port = $accRuleDetails["asst_loan_port"];
                                        // loan income interest
                                        $int_loan_port = $accRuleDetails["inc_interest"];

//                                        Check gl for principal
                                        $acc_gl_accountCon = ['int_id' => $sessint_id, 'gl_code' => $loan_port];
                                        $acc_gl_accountDetails = selectOne('acc_gl_account', $acc_gl_accountCon);
                                        $principalBalPort = $acc_gl_accountDetails["organization_running_balance_derived"];
                                        $principalParentId = $acc_gl_accountDetails["parent_id"];

//                                        check gl for interest
                                        $acc_gl_account_interestCon = ['int_id' => $sessint_id, 'gl_code' => $int_loan_port];
                                        $acc_gl_account_interestDetails = selectOne('acc_gl_account', $acc_gl_account_interestCon);
                                        $interestBalPort = $acc_gl_account_interestDetails["organization_running_balance_derived"];
                                        $interestParentId = $acc_gl_account_interestDetails["parent_id"];

//                                        check if the amount collect clear the current loan
                                        if ($clientAmount >= $loan_amount) {
                                            $constantId = 'id';
                                            $updateLoanCon = ['principal_amount' => '0.00', 'interest_amount' => '0.00', 'installment' => '0.00'];
                                            $updateLoanDetails = update('loan_arrear', $clientArrearsId, $constantId, $updateLoanCon);
                                            $updated_principal_loan_port = $principalBalPort + $a_principal;
                                            $update_interest_loan_port = $interestBalPort + $a_interest;
                                            $collection_principal = $a_principal;
                                            $collection_interest = $a_interest;

//                                            update the acc_gl_account with the new information
                                            $glConstantName = 'gl_code';
                                            $updateGlCon = ['organization_running_balance_derived' => $updated_principal_loan_port];
                                            $updateGlDetails = update('acc_gl_account', $loan_port, $glConstantName, $updateGlCon);
                                            if ($updateGlDetails) {
                                                $insert_loan_portCon = [
                                                    'int_id' => $sessint_id, 'branch_id' => $branch_id, 'gl_code' => $loan_port,
                                                    'parent_id' => $interestParentId, 'transaction_id' => $transId, 'description' => $description,
                                                    'transaction_type' => 'Loan Repayment Principal / ' . $client_name, 'teller_id' => $tellerDetails['id'],
                                                    'is_reversed' => 0, 'transaction_date' => $gen_date, 'amount' => $collection_principal,
                                                    'gl_account_balance_derived' => $updated_principal_loan_port, 'overdraft_amount_derived' => $updated_principal_loan_port,
                                                    'credit' => $collection_principal
                                                ];
                                                $insert_loan_portDetails = create('gl_account_transaction', $insert_loan_portCon);
//                                                    insert interest now
                                                if ($insert_loan_portDetails) {
                                                    $updateInterestGlCon = ['organization_running_balance_derived' => $update_interest_loan_port];
                                                    $updateInterestGlDetails = update('acc_gl_account', $int_loan_port, $glConstantName, $updateInterestGlCon);
//                                                        Send interest information to database
                                                    if ($updateInterestGlDetails) {
                                                        $interestInfoCon = [
                                                            'int_id' => $sessint_id, 'branch_id' => $branch_id, 'gl_code' => $int_loan_port,
                                                            'parent_id' => $interestParentId, 'transaction_id' => $transId, 'description' => $description,
                                                            'transaction_type' => 'Loan Repayment Interest / ' . $client_name, 'teller_id' => $tellerDetails['id'],
                                                            'is_reversed' => 0, 'transaction_date' => $gen_date, 'amount' => $collection_interest,
                                                            'gl_account_balance_derived' => $update_interest_loan_port, 'overdraft_amount_derived' => $update_interest_loan_port,
                                                            'credit' => $collection_interest
                                                        ];
                                                        $interestInfoDetails = create('gl_account_transaction', $interestInfoCon);
                                                    } else {
                                                        echo "LOAN INTEREST BAD";
                                                    }
                                                } else {
                                                    echo "LOAN PRIN. INTEREST BAD";
                                                }
                                            } else {
                                                echo "GL UPDATE BAD";
                                            }
                                        } else {
                                            $loan_bal = $clientAmount / 2;
                                            $loan_bal_prin = $a_principal - $loan_bal;
                                            $loan_bal_int = $a_interest - $loan_bal;

//                                            update the loan_arrears table
                                            $loanArrearsConstantName = 'id';
                                            $newLoanArrearsCon = ['principal_amount' => $loan_bal_prin, 'interest_amount' => $loan_bal_int, 'installment' => 1];
                                            $newLoanArrearsDetails = update('loan_arrear', $clientArrearsId, $loanArrearsConstantName, $newLoanArrearsCon);
                                            if ($newLoanArrearsDetails) {
                                                $update_pri_loan_port = $principalBalPort + $loan_bal;
                                                $update_int_loan_port = $interestBalPort + $loan_bal;
                                                $collection_principal = $loan_bal;
                                                $collection_interest = $loan_bal;

//                                                update acc_gl_account
                                                $glConstantName = 'gl_code';
                                                $updateGlCon = ['organization_running_balance_derived' => $update_pri_loan_port];
                                                $updateGlDetails = update('acc_gl_account', $loan_port, $glConstantName, $updateGlCon);
                                                if ($updateGlDetails) {
                                                    // Update outstanding loan Balance
                                                    $new_out_loan = $current_out_loan - $update_pri_loan_port;
                                                    $loanConstantName = 'id';
                                                    $updateLoanCon = ['total_outstanding_derived' => $new_out_loan];
                                                    $updateLoanDetails = update('loan', $arrearloanId, $loanConstantName, $updateLoanCon);
                                                    if ($updateLoanDetails) {
                                                        $insert_loan_portCon = [
                                                            'int_id' => $sessint_id, 'branch_id' => $branch_id, 'gl_code' => $loan_port,
                                                            'parent_id' => $interestParentId, 'transaction_id' => $transId, 'description' => $description,
                                                            'transaction_type' => 'Loan Repayment Principal / ' . $client_name, 'teller_id' => $tellerDetails['id'],
                                                            'is_reversed' => 0, 'transaction_date' => $gen_date, 'amount' => $collection_principal,
                                                            'gl_account_balance_derived' => $updated_principal_loan_port, 'overdraft_amount_derived' => $updated_principal_loan_port,
                                                            'credit' => $collection_principal
                                                        ];
                                                        $insert_loan_portDetails = create('gl_account_transaction', $insert_loan_portCon);
                                                        if ($insert_loan_portDetails) {
                                                            $updateInterestGlCon = ['organization_running_balance_derived' => $update_interest_loan_port];
                                                            $updateInterestGlDetails = update('acc_gl_account', $int_loan_port, $glConstantName, $updateInterestGlCon);
//                                                        Send interest information to database
                                                            if ($updateInterestGlDetails) {
                                                                $interestInfoCon = [
                                                                    'int_id' => $sessint_id, 'branch_id' => $branch_id, 'gl_code' => $int_loan_port,
                                                                    'parent_id' => $interestParentId, 'transaction_id' => $transId, 'description' => $description,
                                                                    'transaction_type' => 'Loan Repayment Interest / ' . $client_name, 'teller_id' => $tellerDetails['id'],
                                                                    'is_reversed' => 0, 'transaction_date' => $gen_date, 'amount' => $collection_interest,
                                                                    'gl_account_balance_derived' => $update_interest_loan_port, 'overdraft_amount_derived' => $update_interest_loan_port,
                                                                    'credit' => $collection_interest
                                                                ];
                                                                $interestInfoDetails = create('gl_account_transaction', $interestInfoCon);
                                                            } else {
                                                                echo "LOAN INTEREST BAD";
                                                            }
                                                        } else {
                                                            echo "LOAN PRIN. INTEREST BAD";
                                                        }
                                                    } else {
                                                        echo "GL UPDATE BAD";
                                                    }
                                                }
                                            }
                                        }


                                    }
                                }
                            }
                        }

//                        checking for bank == 1
                        if ($isBank == 1) {
                            // update the GL
                            $glConstantName = 'gl_code';
                            $updateGlCon = ['organization_running_balance_derived' => $new_l_acct_bal];
                            $updateLoanDetails = update('acc_gl_account', $glCode, $glConstantName, $updateGlCon);
                            if ($updateLoanDetails) {
//                                insert into gl_account_transaction
                                $glAccCondition = ['int_id' => $sessint_id, 'branch_id' => $branch_id, 'gl_code' => $glCode,
                                    'parent_id' => $parent, 'transaction_id' => $transId, 'description' => $description,
                                    'transaction_type' => $trans_type, 'teller_id' => $staffId, 'transaction_date' => $gen_date,
                                    'amount' => $clientAmount, 'gl_account_balance_derived' => $new_l_acct_bal,
                                    'overdraft_amount_derived' => $clientAmount, 'credit' => $clientAmount
                                ];
                                $glAccDetails = create('gl_account_transaction', $glAccCondition);
//                                come back here again
                            }
                        } elseif ($isBank == 0) {
                            // update the GL
                            $instConstantName = 'teller_id';
                            $updateInstCon = ['account_balance_derived' => $new_inst_acct_bal, 'total_deposits_derived' => $new_inst_total_bal_der];
                            $updateInstDetails = update('institution_account', $staff_id, $instConstantName, $updateGlCon);
                            if ($updateInstDetails) {
//                                insert into gl_account_transaction
                                $instAccCondition = ['int_id' => $sessint_id, 'branch_id' => $branch_id, 'client_id' => $client_id,
                                    'transaction_id' => $transId, 'description' => $description, 'transaction_type' => $trans_type,
                                    'teller_id' => $staffId, 'is_reversed' => 0, 'transaction_date' => $gen_date,
                                    'amount' => $clientAmount, 'running_balance_derived' => $new_inst_acct_bal,
                                    'overdraft_amount_derived' => $clientAmount, 'appuser_id' => $m_id, 'credit' => $clientAmount
                                ];
                                $glAccDetails = create('institution_account_transaction', $instAccCondition);

                            }
                        }

                        if ($glAccDetails){
//                            $_SESSION["Lack_of_intfund_$randms"] = "Deposit Successful";
                                echo header("Location: ../mfi/transaction.php");
                        }
//                        Send SMS
//                        if ($glAccDetails) {
//                            if ($client_sms == "1") {
//                                ?>
<!--                                <input type="text" id="s_int_id" value="--><?php //echo $sessint_id; ?><!--" hidden>-->
<!--                                <input type="text" id="s_acct_nox" value="--><?php //echo $clientAccountNumber; ?><!--" hidden>-->
<!--                                <input type="text" id="s_branch_id" value="--><?php //echo $branch_id; ?><!--" hidden>-->
<!--                                <input type="text" id="s_sender_id" value="--><?php //echo $sender_id; ?><!--" hidden>-->
<!--                                <input type="text" id="s_phone" value="--><?php //echo $client_phone; ?><!--" hidden>-->
<!--                                <input type="text" id="s_client_id" value="--><?php //echo $client_id; ?><!--" hidden>-->
<!--                                <input type="text" id="s_acct_no" value="--><?php //echo $account_display; ?><!--" hidden>-->
<!--                                <input type="text" id="s_int_name" value="--><?php //echo $int_name; ?><!--" hidden>-->
<!--                                <input type="text" id="s_amount"-->
<!--                                       value="--><?php //echo number_format($clientAmount, 2); ?><!--" hidden>-->
<!--                                <input type="text" id="s_desc" value="--><?php //echo $description; ?><!--" hidden>-->
<!--                                <input type="text" id="s_date" value="--><?php //echo $pint; ?><!--" hidden>-->
<!--                                <input type="text" id="s_balance"-->
<!--                                       value="--><?php //echo number_format($new_client_acct_bal, 2); ?><!--" hidden>-->
<!--                                <div id="make_display"></div>-->
<!--                                <script>-->
<!--                                    //                                                function that sends a message and is done in mfi/ajax_post/sms/sms.php-->
<!--                                    $(document).ready(function () {-->
<!--                                        var int_id = $('#s_int_id').val();-->
<!--                                        var branch_id = $('#s_branch_id').val();-->
<!--                                        var sender_id = $('#s_sender_id').val();-->
<!--                                        var phone = $('#s_phone').val();-->
<!--                                        var client_id = $('#s_client_id').val();-->
<!--                                        var account_no = $('#s_acct_nox').val();-->
<!--                                        // function-->
<!--                                        var amount = $('#s_amount').val();-->
<!--                                        var trans_type = "Credit";-->
<!--                                        var acct_no = $('#s_acct_no').val();-->
<!--                                        var int_name = $('#s_int_name').val();-->
<!--                                        var desc = $('#s_desc').val();-->
<!--                                        var date = $('#s_date').val();-->
<!--                                        var balance = $('#s_balance').val();-->
<!--                                        // now we work on the body.-->
<!--                                        var msg = int_name + " "-->
<!--                                            + trans_type + " \n"-->
<!--                                            + "Amt: NGN " + amount-->
<!--                                            + " \n Acct: " + acct_no-->
<!--                                            + "\nDesc: " + desc-->
<!--                                            + " \nBal: " + balance-->
<!--                                            + " \nAvail: " + balance-->
<!--                                            + "\nDate: " + date + "\nThanks!";-->
<!--                                        $.ajax({-->
<!--                                            url: "../mfi/ajax_post/sms/sms.php",-->
<!--                                            method: "POST",-->
<!--                                            data: {-->
<!--                                                int_id: int_id,-->
<!--                                                branch_id: branch_id,-->
<!--                                                sender_id: sender_id,-->
<!--                                                phone: phone,-->
<!--                                                msg: msg,-->
<!--                                                client_id: client_id,-->
<!--                                                account_no: account_no-->
<!--                                            },-->
<!--                                            success: function (data) {-->
<!--                                                $('#make_display').html(data);-->
<!--                                            }-->
<!--                                        });-->
<!--                                    });-->
<!--                                </script>-->
<!--                                --><?php
//                            }
//                            // Send Email using PHP Mailer Library
//                            $mail = new PHPMailer;
//                            $mail->From = $int_email;
//                            $mail->FromName = $int_name;
//                            $mail->addAddress($client_email, $client_name);
//                            $mail->addReplyTo($int_email, "No Reply");
//                            $mail->isHTML(true);
//                            $mail->Subject = "Transaction Alert from $int_name";
//                            $mail->Body = "<!DOCTYPE html>
//          <html>
//              <head>
//              <style>
//              .lon{
//                height: 100%;
//                  background-color: #eceff3;
//                  font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
//              }
//              .main{
//                  margin-right: auto;
//                  margin-left: auto;
//                  width: 550px;
//                  height: auto;
//                  background-color: white;
//
//              }
//              .header{
//                  margin-right: auto;
//                  margin-left: auto;
//                  width: 550px;
//                  height: auto;
//                  background-color: white;
//              }
//              .logo{
//                  margin-right:auto;
//                  margin-left: auto;
//                  width:auto;
//                  height: auto;
//                  background-color: white;
//
//              }
//              .text{
//                  padding: 20px;
//                  font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
//              }
//              table{
//                  padding:30px;
//                  width: 100%;
//              }
//              table td{
//                  font-size: 15px;
//                  color:rgb(65, 65, 65);
//              }
//          </style>
//              </head>
//              <body>
//                <div class='lon'>
//                  <div class='header'>
//                    <div class='logo'>
//                    <img  style='margin-left: 200px; margin-right: auto; height:150px; width:150px;'class='img' src= '$int_logo'/>
//                </div>
//            </div>
//                <div class='main'>
//                    <div class='text'>
//                        Dear $client_name,
//                        <h2 style='text-align:center;'>Notification of Credit Alert</h2>
//                        this is to notify you of an incoming credit to your account $clientAccountNumber,
//                        Kindly confirm with your bank.<br/><br/>
//                         Please see the details below
//                    </div>
//                    <table>
//                        <tbody>
//                            <div>
//                          <tr>
//                            <td> <b >Account Number</b></td>
//                            <td >$account_display</td>
//                          </tr>
//                          <tr>
//                            <td > <b>Account Name</b></td>
//                            <td >$client_name</td>
//                          </tr>
//                          <tr>
//                            <td > <b>Reference</b></td>
//                            <td >$description</td>
//                          </tr>
//                          <tr>
//                            <td > <b>Reference Id</b></td>
//                            <td >$transid</td>
//                          </tr>
//                          <tr>
//                            <td> <b>Transaction Amount</b></td>
//                            <td>$clientAmount</td>
//                          </tr>
//                          <tr>
//                            <td> <b>Transaction Date/Time</b></td>
//                            <td>$gen_date</td>
//                          </tr>
//                          <tr>
//                            <td> <b>Value Date</b></td>
//                            <td>$gends</td>
//                          </tr>
//                          <tr>
//                            <td> <b>Account Balance</b></td>
//                            <td>&#8358; $new_client_acct_bal</td>
//                          </tr>
//                        </tbody>
//                        <!-- Optional JavaScript -->
//                        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
//                        <script src='https://code.jquery.com/jquery-3.4.1.slim.min.js' integrity='sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n' crossorigin='anonymous'></script>
//                        <script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js' integrity='sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo' crossorigin='anonymous'></script>
//                        <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js' integrity='sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6' crossorigin='anonymous'></script>
//                      </body>
//                    </table>
//                </div>
//                </div>
//              </body>
//          </html>";
//                            $mail->AltBody = "This is the plain text version of the email content";
//                            // mail system
//                            if (!$mail->send()) {
//                                echo "Mailer Error: " . $mail->ErrorInfo;
//                                $_SESSION["Lack_of_intfund_$randms"] = "Deposit Successful";
//                                echo header("Location: ../mfi/transact.php?message0=$randms");
//                            } else {
//                                $_SESSION["Lack_of_intfund_$randms"] = "Deposit Has Been Done, Awaiting Approval!";
//                                echo header("Location: ../mfi/transact.php?messagep=$randms");
//                            }
//
//                            // sends a mail first
//                        } else {
//                            // echo error in the gl
//                            $_SESSION["Lack_of_intfund_$randms"] = "Transaction Failed";
//                            echo header("Location: ../mfi/transact.php?legal=$randms");
//                        }

                    } else {
                        echo "is del check";
                    }
                } else {
                    $_SESSION["Lack_of_intfund_$randms"] = "System Error";
                    echo header("Location: ../mfi/transact.php?legalq=$randms");
                }

            }
            else {
//                // you're not authorized not a teller
//                $_SESSION["Lack_of_intfund_$randms"] = "TELLER";
//                echo header("Location: ../mfi/transact.php?messagex2=$randms");
            }

        }

    } elseif
    ($_POST['acc'] == 'withdraw') {
        echo 'not working yet';
    }
}