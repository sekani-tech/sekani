<?php

$page_title = "Approve";
$destination = "transact_approval.php";
include("header.php");
include("ajaxcall.php");
require_once "../bat/phpmailer/PHPMailerAutoload.php";
?>
<!-- IMPORTING FO THE EXPENSE -->
<?php
// the session
$int_name = $_SESSION["int_name"];
$int_email = $_SESSION["int_email"];
$int_web = $_SESSION["int_web"];
$int_phone = $_SESSION["int_phone"];
$int_logo = $_SESSION["int_logo"];
$int_address = $_SESSION["int_address"];
$sessint_id = $_SESSION["int_id"];
$appuser_id = $_SESSION['user_id'];
$sender_id = $_SESSION["sender_id"];
$gen_date = date('Y-m-d h:i:sa');
$pint = date('Y-m-d h:i:sa');
$gends = date('Y-m-d h:i:sa');
?>
<?php
if (isset($_GET['approve']) && $_GET['approve'] !== '') {
  $appod = $_GET['approve'];

  $checkm = mysqli_query($connection, "SELECT * FROM transact_cache WHERE id = '$appod' && int_id = '$sessint_id' && status = 'Pending'");
  if (count([$checkm]) == 1) {
    $x = mysqli_fetch_array($checkm);

    $cn = $x['client_name'];
    $client_id = $x['client_id'];
    $id = $client_id;
    $acct_no = $x['account_no'];
    $account_display = substr("$acct_no", 0, 3) . "*****" . substr("$acct_no", 8);
    $teller_id = $x['teller_id'];
    $ao = $x['account_off_name'];
    $amount = $x['amount'];
    $famt = number_format("$amount", 2);
    $pay_type = $x['pay_type'];
    $transact_type = $x['transact_type'];
    $description = $x['description'];
    $transid = $x['transact_id'];
    $product_type = $x['product_type'];
    $stat = $x['status'];
    $branch_idm = $x['branch_id'];
    $teller_id = $x['staff_id'];
    $transaction_date = $x['date'];
    $is_bank = $x["is_bank"];
    $bank_gl_code = $x["bank_gl_code"];
    $irvs = 0;

    $glv = selectOne('acc_gl_account', ['int_id' => $sessint_id, 'gl_code' => $bank_gl_code]);
    //      $gl_manq = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE gl_code = '$bank_gl_code' && int_id = '$sessint_id'");
    //      $glv = mysqli_fetch_array($gl_manq);
    $E_acct_bal = $glv["organization_running_balance_derived"];
    // DMAN
    $new_gl_balx = $E_acct_bal + $amount;
    $new_gl_bal2x = $E_acct_bal - $amount;
  }
}
$gen_date = date('Y-m-d h:i:sa');
$gends = date('Y-m-d h:i:sa');
// we will call the institution account

?>
<!-- THIS IS BEGINING OF THE EXPENSE -->
<?php
// making expense transaction
// get all important things first
$taketeller = "SELECT * FROM tellers WHERE id = '$teller_id' && int_id = '$sessint_id'";
$check_me_men = mysqli_query($connection, $taketeller);
if ($check_me_men) {
  $ex = mysqli_fetch_array($check_me_men);
  $is_del = $ex["is_deleted"];
  $branch_id = $ex['branch_id'];
  $till = $ex["till"];
  $post_limit = $ex["post_limit"];
  $gl_code = $ex["till"];
  $till_no = $ex["till_no"];
  // we will call the GL
  $gl_codex = $acct_no;
  $gl_amt = $amount;
  $pym = $pay_type;
  $trans_id = $transid;
  // MININ IMOORT
  $gl_man = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE gl_code = '$gl_codex' && int_id = '$sessint_id'");
  $gl = mysqli_fetch_array($gl_man);
  $gl_name = $gl["name"];
  $l_acct_bal = $gl["organization_running_balance_derived"];
  $new_gl_bal = $l_acct_bal + $gl_amt;
  // remeber the institution account
  $damn = mysqli_query($connection, "SELECT * FROM institution_account WHERE int_id = '$sessint_id' AND teller_id = '$teller_id' OR submittedon_userid = '$teller_id'");
  if (count([$damn]) == 1) {
    $x = mysqli_fetch_array($damn);
    $int_acct_bal = $x['account_balance_derived'];
    // $tbd = $x['total_deposits_derived'] + $amount;
    $tbd2 = $x['total_withdrawals_derived'] + $gl_amt;
    $new_int_bal2 = $int_acct_bal - $gl_amt;
    $new_int_bal = $amount + $int_acct_bal;
  }
}
?>
<!-- STARTING THE SERVER -->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  //  RUN A QUERY TO CHECK IF THE TRANSACTION HAS BEEN DONE BEFORE
  $q1 = mysqli_query($connection, "SELECT * FROM `institution_account_transaction` WHERE transaction_id = '$transid' && int_id='$sessint_id'");
  $resx1 = mysqli_num_rows($q1);
  if ($resx1 == 0) {
    // Lets geit on
    $approve = $_POST['submit'];
    $decline = $_POST['submit'];
    if ($approve == 'approve') {
      if (isset($_GET['approve']) && $_GET['approve'] !== '') {
        $appod = $_GET['approve'];
        $checkm = mysqli_query($connection, "SELECT * FROM transact_cache WHERE id = '$appod' && int_id = '$sessint_id'");
        if (count([$checkm]) == 1) {
          $x = mysqli_fetch_array($checkm);
          $ssint_id = $_SESSION["int_id"];
          $appuser_id = $_SESSION["user_id"];
          $staff_id = $x['staff_id'];
          $amount = $x['amount'];
          $famt = number_format("$amount", 2);
          $pay_type = $x['pay_type'];
          $transact_type = $x['transact_type'];
          $product_type = $x['product_type'];
          $stat = $x['status'];
          $gen_date = date("Y-m-d h:i:sa");
          $digits = 9;
          $randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
          $transid = $transid;

          if ($stat == "Pending") {
            $getacct = mysqli_query($connection, "SELECT * FROM account WHERE account_no = '$acct_no' && int_id = '$sessint_id'");
            if (2 == 2) {
              if (count([$getacct]) == 1) {
                $y = mysqli_fetch_array($getacct);
                $branch_id = $y['branch_id'];
                $client_id = $y['client_id'];
                $acc_id = $y['id'];
                $int_acct_bal = $y['account_balance_derived'];
                $comp = $amount + $int_acct_bal;
                $numberacct = number_format("$comp", 2);
                $comp2 = $int_acct_bal - $amount;
                $numberacct2 = number_format("$comp2", 2);
                $compall = $y["account_balance_derived"] - $amount;
                $trans_type = "credit";
                $trans_type2 = "debit";
                $irvs = 0;
                //  select the acccount
                $dbclient = mysqli_query($connection, "SELECT * FROM client WHERE id = '$client_id' && int_id = '$sessint_id'");
                if (count([$dbclient]) == 1) {
                  $a = mysqli_fetch_array($dbclient);
                  $branch_id = $a['branch_id'];
                  $client_phone = $a["mobile_no"];
                  $client_sms = $a["SMS_ACTIVE"];
                }
?>
                <input type="text" id="s_int_id" value="<?php echo $sessint_id; ?>" hidden>
                <input type="text" id="s_acct_nox" value="<?php echo $acct_no; ?>" hidden>
                <input type="text" id="s_branch_id" value="<?php echo $branch_id; ?>" hidden>
                <input type="text" id="s_sender_id" value="<?php echo $sender_id; ?>" hidden>
                <input type="text" id="s_phone" value="<?php echo $client_phone; ?>" hidden>
                <input type="text" id="s_client_id" value="<?php echo $client_id; ?>" hidden>
                <div id="make_display"></div>
                <?php
                //    account deposit computation
                if ($transact_type == "Deposit" && $client_id = $id) {
                  $new_abd = $comp;
                  $iupq = "UPDATE account SET account_balance_derived = '$new_abd',
                     last_deposit = '$amount' WHERE account_no = '$acct_no' && int_id = '$sessint_id'";
                  $iupqres = mysqli_query($connection, $iupq);
                  if ($iupqres) {
                    $iat = "INSERT INTO account_transaction (int_id, branch_id, account_id,
                         account_no, product_id,
                         client_id, teller_id, transaction_id, description, transaction_type, is_reversed,
                         transaction_date, amount, running_balance_derived, overdraft_amount_derived,
                         created_date, appuser_id, credit) VALUES ('{$ssint_id}', '{$branch_id}',
                         '{$acc_id}', '{$acct_no}', '{$product_type}', '{$client_id}', '{$teller_id}',
                         '{$transid}', '{$description}', '{$trans_type}', '{$irvs}',
                         '{$transaction_date}', '{$amount}', '{$new_abd}', '{$amount}',
                         '{$gen_date}', '{$appuser_id}', '{$amount}')";
                    $res3 = mysqli_query($connection, $iat);
                    if ($res3) {
                      $v = "Verified";
                      $iupqx = "UPDATE transact_cache SET `status` = '$v' WHERE id = '$appod' && int_id = '$sessint_id'";
                      $res4 = mysqli_query($connection, $iupqx);
                      if ($res4) {
                        // MAKING A MOVE
                        // get the loan in arrears
                        $select_arrear = mysqli_query($connection, "SELECT * FROM `loan_arrear` WHERE client_id = '$client_id' AND int_id = '$sessint_id' AND installment >= 1 ORDER BY id ASC LIMIT 1");
                        // QWERTY
                        $gas = mysqli_fetch_array($select_arrear);
                        $a_id = $gas["id"];
                        $a_int_id = $gas["int_id"];
                        $a_loan_id = $gas["loan_id"];
                        $select_l = mysqli_query($connection, "SELECT * FROM 'loan' WHERE id = '$a_loan_id' AND int_id = '$sessint_id'");
                        $lm = mysqli_fetch_array($select_l);
                        // get id
                        $loan_product_id = $lm["product_id"];
                        // query_on
                        $select_prod_acct = mysqli_query($connection, "SELECT * FROM `acct_rule` WHERE loan_product_id = '$loan_product_id' AND int_id = '$sessint_id'");
                        // check out the gl_code names
                        $li_m = mysqli_fetch_array($select_prod_acct);
                        // loan portfolio
                        $loan_port = $li_m["asst_loan_port"];
                        // loan income interest
                        $int_loan_port = $li_m["inc_interest"];
                        // end of the gl
                        $a_principal = $gas["principal_amount"];
                        $a_interest = $gas["interest_amount"];
                        $loan_amount = $a_principal + $a_interest;
                        // END MOVE
                        // run a code to check if the account is less than or equals to the amount
                        // BEFORE RUNNING CHECK GL AND BALANCE\
                        $take_d_s = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE gl_code = '$loan_port' AND int_id = '$sessint_id'");
                        $gdb = mysqli_fetch_array($take_d_s);
                        // geng new thing here
                        $int_d_s = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE gl_code = '$int_loan_port' AND int_id = '$sessint_id'");
                        $igdb = mysqli_fetch_array($int_d_s);
                        // IMPOSSIBLE
                        $intbalport = $igdb["organization_running_balance_derived"];
                        $newbalport = $gdb["organization_running_balance_derived"];
                        // AFTER RUNING
                        // ALRIGHT WE MOVING
                        if ($amount >= $loan_amount) {
                          // ok good
                          $update_arrear = mysqli_query($connection, "UPDATE `loan_arrear` SET principal_amount = '0.00', interest_amount = '0.00', installment = '0' WHERE id = '$a_id' AND int_id = '$a_int_id' AND client_id = '$client_id'");
                          // check out the update
                          if ($update_arrear) {
                            //   $loan_bal = $amount / 2;
                            // $loan_bal_prin = $a_principal;
                            // $loan_bal_int = $a_interest;
                            // OK NOW RUN A FUNCTION.
                            $updated_loan_port = $newbalport + $a_principal;
                            $intloan_port = $intbalport + $a_interest;
                            $collection_principal = $a_principal;
                            $collection_interest = $a_interest;
                            $update_the_loan = mysqli_query($connection, "UPDATE `acc_gl_account` SET organization_running_balance_derived = '$updated_loan_port' WHERE int_id ='$sessint_id' AND gl_code = '$loan_port'");
                            // Qwerty
                            if ($update_the_loan) {
                              // damn with
                              $insert_loan_port = mysqli_query($connection, "INSERT INTO `gl_account_transaction` (`int_id`, `branch_id`, `gl_code`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`,
                   `amount`, `gl_account_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`) 
                  VALUES ('{$sessint_id}', '{$branch_id}', '{$loan_port}', '{$transid}', 'Loan Repayment Principal / {$cn}', 'Loan Repayment Principal', '0', '0', '{$transaction_date}',
                   '{$collection_principal}', '{$updated_loan_port}', '{$updated_loan_port}', '{$gen_date}', '0', '0', '{$gen_date}', '0', '{$collection_principal}', '0.00')");
                              if ($insert_loan_port) {
                                //  go for the interest
                                $update_the_int_loan = mysqli_query($connection, "UPDATE acc_gl_account SET organization_running_balance_derived = '$intloan_port' WHERE int_id = '$sessint_id' AND gl_code ='$int_loan_port'");
                                if ($update_the_int_loan) {
                                  $insert_i_port = mysqli_query($connection, "INSERT INTO `gl_account_transaction` (`int_id`, `branch_id`, `gl_code`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`,
               `amount`, `gl_account_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`) 
              VALUES ('{$sessint_id}', '{$branch_id}', '{$int_loan_port}', '{$transid}', 'Loan Repayment Interest / {$cn}', 'Loan Repayment Interest', '0', '0', '{$transaction_date}',
               '{$collection_interest}', '{$intloan_port}', '{$intloan_port}', '{$gen_date}', '0', '0', '{$gen_date}', '0', '{$collection_interest}', '0.00')");
                                  // done
                                } else {
                                  echo "LOAN INTEREST BAD";
                                }
                              } else {
                                echo "LOAN PRIN. INTEREST BAD";
                              }
                            } else {
                              echo "GL UPDATE BAD";
                            }
                            // sec wise
                          }
                        } else if ($amount < $loan_amount) {
                          // ok nice
                          $loan_bal = $amount / 2;
                          $loan_bal_prin = $a_principal - $loan_bal;
                          $loan_bal_int = $a_interest - $loan_bal;
                          // pop up
                          $update_arrear = mysqli_query($connection, "UPDATE `loan_arrear` SET principal_amount = '$loan_bal_prin', interest_amount = '$loan_bal_int', installment = '1' WHERE id = '$a_id' AND int_id = '$a_int_id' AND client_id = '$client_id'");
                          if ($update_arrear) {
                            // OK NOW RUN A FUNCTION.
                            $updated_loan_port = $newbalport + $loan_bal;
                            $intloan_port = $intbalport + $loan_bal;
                            $collection_principal = $loan_bal;
                            $collection_interest = $loan_bal;
                            $update_the_loan = mysqli_query($connection, "UPDATE `acc_gl_account` SET organization_running_balance_derived = '$updated_loan_port' WHERE int_id ='$sessint_id' AND gl_code = '$loan_port'");
                            // Qwerty
                            if ($update_the_loan) {
                              // damn with
                              $insert_loan_port = mysqli_query($connection, "INSERT INTO `gl_account_transaction` (`int_id`, `branch_id`, `gl_code`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`,
                   `amount`, `gl_account_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`) 
                  VALUES ('{$sessint_id}', '{$branch_id}', '{$loan_port}', '{$transid}', 'Loan Repayment Principal / {$cn}', 'Loan Repayment Principal', '0', '0', '{$transaction_date}',
                   '{$collection_principal}', '{$updated_loan_port}', '{$updated_loan_port}', '{$gen_date}', '0', '0', '{$gen_date}', '0', '{$collection_principal}', '0.00')");
                              if ($insert_loan_port) {
                                //  go for the interest
                                $update_the_int_loan = mysqli_query($connection, "UPDATE acc_gl_account SET organization_running_balance_derived = '$intloan_port' WHERE int_id = '$sessint_id' AND gl_code ='$int_loan_port'");
                                if ($update_the_int_loan) {
                                  $insert_i_port = mysqli_query($connection, "INSERT INTO `gl_account_transaction` (`int_id`, `branch_id`, `gl_code`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`,
               `amount`, `gl_account_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`) 
              VALUES ('{$sessint_id}', '{$branch_id}', '{$int_loan_port}', '{$transid}', 'Loan Repayment Interest / {$cn}', 'Loan Repayment Interest', '0', '0', '{$transaction_date}',
               '{$collection_interest}', '{$intloan_port}', '{$intloan_port}', '{$gen_date}', '0', '0', '{$gen_date}', '0', '{$collection_interest}', '0.00')");
                                  // done
                                } else {
                                  echo "LOAN INTEREST BAD";
                                }
                              } else {
                                echo "LOAN PRIN. INTEREST BAD";
                              }
                            } else {
                              echo "GL UPDATE BAD";
                            }
                            // sec wise
                          }
                        }
                        // MAKING IT OUT
                        // SMS POSTING
                        // END THE TRANSACTION
                        if ($client_sms == "1") {
                          $trans_type = "Credit";
                          $balance = number_format($comp, 2);
                          $msg = "Acct: " . appendAccountNo($acct_no, 6) . "\nAmt: NGN " . number_format($amount, 2) . " " . $trans_type . "\nDesc: " . $description . "\nAvail Bal: " . $balance . "\nDate: " . $pint;
                          // creating unique message ID
                          $digits = 9;
                          $messageId = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
                          // check for needed values
                          // if exists proceed to send SMS
                          if ($sender_id != "" && $client_phone != "" && $msg != "" && $sessint_id != "" && $branch_id != "") {
                            // Check the length of the phone numer
                            // if 10 add country code
                            $phoneLength = strlen($client_phone);
                            if ($phoneLength == 10) {
                              $clientPhone = "234" . $client_phone;
                            }
                            if ($phoneLength == 11) {
                              $phone =  substr($client_phone, 1);
                              $clientPhone = "234" . $phone;
                            }
                            $testData = [
                              'int_id' => $sessint_id,
                              'texts' => $clientPhone,
                              'number' => $client_phone
                            ];
                            $insertTest = insert('test_data', $testData);
                            $sql_fund = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$sessint_id'");
                            $qw = mysqli_fetch_array($sql_fund);
                            $smsBalance = $qw["sms_balance"];
                            $total_with = $qw["total_withdrawal"];
                            $total_int_profit = $qw["int_profit"];
                            $total_sekani_charge = $qw["sekani_charge"];
                            $total_merchant_charge = $qw["merchant_charge"];
                            if ($smsBalance >= 4) {

                              $curl = curl_init();
                              $escape = mysqli_real_escape_string($connection, $msg);

                              curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://sms.vanso.com//rest/sms/submit/long',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => '{
                                          "account": {
                                              "password": "kwPPkiV4",
                                              "systemId": "NG.102.0421"
                                              },
                                              "sms": {
                                                  "dest":"' . $clientPhone . '",
                                                  "src": "' . $sender_id . '",
                                                  "text": "' . $escape . '",
                                                  "unicode": true
                                              }

                                          }',
                                CURLOPT_HTTPHEADER => array(
                                  'Content-Type: application/json',
                                  'Authorization: Basic TkcuMTAyLjA0MjE6a3dQUGtpVjQ='
                                ),
                              ));


                              $response = curl_exec($curl);
                              // dd($response);
                              // success
                              $err = curl_close($curl);
                              if ($err) {
                                echo "Connection Error";
                                $obj = json_decode($response, TRUE);
                                $status = $obj['messageParts'][0]['status'];
                                $errorMessage = $obj['messageParts'][0]['errorMessage'];
                                $errorCode = $obj['messageParts'][0]['errorCode'];
                                $smsData = [
                                  'int_id' => $sessint_id,
                                  'branch_id' => $branch_id,
                                  'mobile_no' => $clientPhone,
                                  'message' => $escape,
                                  'status' => $status,
                                  'ticket_id' => $ticketId,
                                  'error_message' => $errorMessage,
                                  'error_code' => $errorCode
                                ];
                                $insertSms = insert('sms_record', $smsData);
                              } else {
                                $obj = json_decode($response, TRUE);
                                $status = $obj['messageParts'][0]['status'];
                                $ticketId = $obj['messageParts'][0]['ticketId'];
                                $errorMessage = $obj['messageParts'][0]['errorMessage'];
                                $errorCode = $obj['messageParts'][0]['errorCode'];
                                // check for success response
                                if ($status != "") {
                                  $smsData = [
                                    'int_id' => $sessint_id,
                                    'branch_id' => $branch_id,
                                    'mobile_no' => $clientPhone,
                                    'message' => $escape,
                                    'transaction_date' => $today,
                                    'status' => $status,
                                    'ticket_id' => $ticketId,
                                    'error_message' => $errorMessage,
                                    'error_code' => $errorCode
                                  ];
                                  $insertSms = insert('sms_record', $smsData);
                                  // Declare variables needed to keep record of the transaction
                                  $cal_bal = $smsBalance - 4;
                                  $cal_with = $total_with + 4;
                                  $cal_sek = $total_sekani_charge + 0;
                                  $cal_mch = $total_merchant_charge + 4;
                                  $cal_int_prof = $total_int_profit + 0;
                                  $digits = 9;
                                  $date = date("Y-m-d");
                                  $date2 = date('Y-m-d H:i:s');
                                  $randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
                                  $trans = "SKWAL" . $randms . "SMS" . $sessint_id;
                                  $update_transaction = mysqli_query($connection, "UPDATE sekani_wallet SET sms_balance = '$cal_bal', total_withdrawal = '$cal_with',
                                  int_profit = '$cal_int_prof', sekani_charge = '$cal_sek', merchant_charge = '$cal_mch' WHERE int_id = '$sessint_id' AND branch_id = '$branch_id'");
                                  if ($update_transaction) {
                                    // inserting record of transaction.
                                    $insert_transaction = mysqli_query($connection, "INSERT INTO `sekani_wallet_transaction` (`int_id`, `branch_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `wallet_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, 
                                    `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`,
                                    `int_profit`, `sekani_charge`, `merchant_charge`)
                                    VALUES ('{$sessint_id}', '{$branch_id}', '{$trans}', 'SMS charge', 'sms', NULL, '0', '{$date}', '4', '{$cal_bal}', '{$cal_bal}', {$date}, 
                                    NULL, NULL, '{$date2}', '0', '0.00', '4.00', '{$cal_int_prof}', '{$cal_sek}', '{$cal_mch}')");
                                    if ($insert_transaction) {
                                      // store SMS charge
                                      $insert_qualif = mysqli_query($connection, "INSERT INTO `sms_charge` (`int_id`, `branch_id`, `trans_id`, `client_id`, `account_no`, `amount`, `charge_date`) VALUES ('{$sessint_id}', '{$branch_id}', '{$trans}', '{$client_id}', '{$acct_no}', '4', '{$date}')");
                                    }
                                  }
                                }
                              }
                            }
                          }
                ?>

                          <?php
                        }
                        // end it for the SMS POSTING
                        // ENDING OF THE AR
                        if ($is_bank == 1) {
                          $upglacct = "UPDATE `acc_gl_account` SET `organization_running_balance_derived` = '$new_gl_balx' WHERE int_id = '$sessint_id' && gl_code = '$bank_gl_code'";
                          $dbgl = mysqli_query($connection, $upglacct);
                          if ($dbgl) {
                            $gl_acc = "INSERT INTO gl_account_transaction (int_id, branch_id, gl_code, transaction_id, description,
                                  transaction_type, teller_id, transaction_date, amount, gl_account_balance_derived, overdraft_amount_derived,
                                    created_date, credit) VALUES ('{$sessint_id}', '{$branch_id}', '{$bank_gl_code}', '{$transid}', '{$description}', '{$trans_type}', '{$staff_id}',
                                     '{$transaction_date}', '{$amount}', '{$new_gl_balx}', '{$amount}', '{$gen_date}', '{$amount}')";
                            $mxc = mysqli_query($connection, $gl_acc);
                            if ($mxc) {
                              echo '<script type="text/javascript">
                                      $(document).ready(function(){
                                          swal({
                                              type: "success",
                                              title: "Deposit Transaction",
                                              text: "Transaction Approval Successful",
                                              showConfirmButton: false,
                                              timer: 2000
                                          })
                                      });
                                      </script>
                                      ';
                              $URL = "transact_approval.php?get='.$clientPhone.'";
                              echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                            } else {
                              echo "Error in Bank Transaction";
                            }
                          }
                        } else if ($is_bank == 0) {
                          // institution account
                          $int_account_trans = "UPDATE institution_account SET account_balance_derived = '$new_int_bal' WHERE teller_id = '$teller_id' OR submittedon_userid = '$teller_id' AND int_id = '$sessint_id'";
                          $query1 = mysqli_query($connection, $int_account_trans);
                          // check if int account has been updated
                          if ($query1) {
                            $trust = "INSERT INTO institution_account_transaction (int_id, branch_id,
                                 client_id, transaction_id, description, transaction_type, teller_id, is_reversed,
                                 transaction_date, amount, running_balance_derived, overdraft_amount_derived,
                                 created_date, appuser_id, credit) VALUES ('{$sessint_id}', '{$branch_id}',
                                '{$client_id}', '{$transid}', '{$description}', '{$trans_type}', '{$teller_id}', '{$irvs}',
                                '{$transaction_date}', '{$amount}', '{$new_int_bal}', '{$amount}',
                                '{$gen_date}', '{$appuser_id}', '{$amount}')";
                            $res9 = mysqli_query($connection, $trust);
                            if ($res9) {
                              //  MAILING SYSTEMS WILL COME IN LATER
                              //  REMEMBER MAILING SYSTEMS
                              echo '<script type="text/javascript">
                                $(document).ready(function(){
                                    swal({
                                        type: "success",
                                        title: "Deposit Transaction",
                                        text: "Transaction Approval Successful",
                                        showConfirmButton: false,
                                        timer: 2000
                                    })
                                });
                                </script>
                                ';
                              $URL = "transact_approval.php";
                              echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                            } else {
                              echo '<script type="text/javascript">
                                 $(document).ready(function(){
                                     swal({
                                         type: "error",
                                         title: "System Error",
                                         text: "Call - Check the institution account",
                                         showConfirmButton: false,
                                         timer: 2000
                                     })
                                 });
                                 </script>
                                 ';
                            }
                          } else {
                            // system error
                            echo '<script type="text/javascript">
                                 $(document).ready(function(){
                                     swal({
                                         type: "error",
                                         title: "System Error",
                                         text: "Call - Check the institution account",
                                         showConfirmButton: false,
                                         timer: 2000
                                     })
                                 });
                                 </script>
                                 ';
                          }
                        } else {
                          echo '<script type="text/javascript">
                                $(document).ready(function(){
                                    swal({
                                        type: "error",
                                        title: "No Payment Type",
                                        text: "Call - Check the institution account",
                                        showConfirmButton: false,
                                        timer: 2000
                                    })
                                });
                                </script>
                                ';
                        }
                        // institution account transaction
                      } else {
                        echo '<script type="text/javascript">
                               $(document).ready(function(){
                                   swal({
                                       type: "error",
                                       title: "Error",
                                       text: "Error updating Cache",
                                       showConfirmButton: false,
                                       timer: 2000
                                   })
                               });
                               </script>
                               ';
                      }
                    } else {
                      echo '<script type="text/javascript">
                           $(document).ready(function(){
                               swal({
                                   type: "error",
                                   title: "Error",
                                   text: "Error in Transaction 1",
                                   showConfirmButton: false,
                                   timer: 2000
                               })
                           });
                           </script>
                           ';
                    }
                  } else {
                    echo '<script type="text/javascript">
                       $(document).ready(function(){
                           swal({
                               type: "error",
                               title: "Error",
                               text: "Error in Account",
                               showConfirmButton: false,
                               timer: 2000
                           })
                       });
                       </script>
                       ';
                  }
                } else if ($transact_type == "Withdrawal" && $client_id = $id) {
                  $getaccount = mysqli_query($connection, "SELECT * FROM institution_account WHERE int_id = '$sessint_id' && teller_id = '$staff_id' OR submittedon_userid = '$teller_id'");
                  $getbal = mysqli_fetch_array($getaccount);
                  $runtellb = 0;
                  if ($is_bank == 1) {
                    $runtellb = $E_acct_bal;
                  } else if ($is_bank == 0) {
                    $runtellb = $getbal["account_balance_derived"];
                  }
                  // importing the needed on the gl
                  if ($runtellb >= $amount) {
                    $new_abd2 = $comp2;
                    $iupq = "UPDATE account SET account_balance_derived = '$new_abd2',
                     last_withdrawal = '$amount' WHERE account_no = '$acct_no' && int_id = '$sessint_id'";
                    $iupqres = mysqli_query($connection, $iupq);
                    if ($iupqres) {
                      $xmx = "INSERT INTO `account_transaction` (`int_id`, `branch_id`, `product_id`, `account_id`, `account_no`, 
                       `client_id`, `teller_id`, `transaction_id`, `description`, `transaction_type`, `is_reversed`, `transaction_date`, 
                       `amount`, `overdraft_amount_derived`, `balance_end_date_derived`, 
                      `running_balance_derived`,  `cumulative_balance_derived`, `created_date`, `appuser_id`, `debit`) 
                       VALUES ('{$sessint_id}', '{$branch_id}', '{$product_type}', 
                       '{$acc_id}', '{$acct_no}', '{$client_id}', {$teller_id}, 
                       '{$transid}', '{$description}', '{$trans_type2}', '{$irvs}', '{$transaction_date}',
                       '{$amount}', '{$amount}', '{$gen_date}', '{$comp2}', '{$amount}', '{$gen_date}', '{$appuser_id}', '{$amount}')";
                      $res3 = mysqli_query($connection, $xmx);
                      //  if ($connection->error) {
                      //            try {
                      //                throw new Exception("MYSQL error $connection->error <br> $xmx ", $mysqli->error);
                      //            } catch (Exception $e) {
                      //                echo "Error No: ".$e->getCode()." - ".$e->getMessage() . "<br>";
                      //                echo n12br($e->getTraceAsString());
                      //            }
                      //    }
                      if ($xmx) {
                        $v = "Verified";
                        $iupqx = "UPDATE transact_cache SET `status` = '$v' WHERE id = '$appod' && int_id = '$sessint_id'";
                        $res4 = mysqli_query($connection, $iupqx);
                        if ($res4) {
                          //  now for DEBIT
                          if ($client_sms == "1") {
                            $trans_type = "Debit";
                            $balance = number_format($comp2, 2);
                            $msg = "Acct: " . appendAccountNo($acct_no, 6) . "\nAmt: NGN " . number_format($amount, 2) . " " . $trans_type . "\nDesc: " . $description . "\nAvail Bal: " . $balance . "\nDate: " . $pint;
                            // creating unique message ID
                            $digits = 9;
                            $messageId = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
                            // check for needed values
                            // if exists proceed to send SMS
                            if ($sender_id != "" && $client_phone != "" && $msg != "" && $sessint_id != "" && $branch_id != "") {
                              // Check the length of the phone numer
                              // if 10 add country code
                              $phoneLength = strlen($client_phone);
                              if ($phoneLength == 10) {
                                $clientPhone = "234" . $client_phone;
                              }
                              if ($phone_length == 11) {
                                $phone =  substr($client_phone, 1);
                                $clientPhone = "234" . $phone;
                              }
                              $sql_fund = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$sessint_id'");
                              $qw = mysqli_fetch_array($sql_fund);
                              $smsBalance = $qw["sms_balance"];
                              $total_with = $qw["total_withdrawal"];
                              $total_int_profit = $qw["int_profit"];
                              $total_sekani_charge = $qw["sekani_charge"];
                              $total_merchant_charge = $qw["merchant_charge"];
                              if ($smsBalance >= 4) {

                                $curl = curl_init();
                                $escape = mysqli_real_escape_string($connection, $msg);

                                curl_setopt_array($curl, array(
                                  CURLOPT_URL => 'https://sms.vanso.com//rest/sms/submit/long',
                                  CURLOPT_RETURNTRANSFER => true,
                                  CURLOPT_ENCODING => '',
                                  CURLOPT_MAXREDIRS => 10,
                                  CURLOPT_TIMEOUT => 0,
                                  CURLOPT_FOLLOWLOCATION => true,
                                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                  CURLOPT_CUSTOMREQUEST => 'POST',
                                  CURLOPT_POSTFIELDS => '{
                                      "account": {
                                          "password": "kwPPkiV4",
                                          "systemId": "NG.102.0421"
                                          },
                                          "sms": {
                                              "dest":"' . $clientPhone . '",
                                              "src": "' . $senderId . '",
                                              "text": "' . $escape . '",
                                              "unicode": true
                                          }

                                      }',
                                  CURLOPT_HTTPHEADER => array(
                                    'Content-Type: application/json',
                                    'Authorization: Basic TkcuMTAyLjA0MjE6a3dQUGtpVjQ='
                                  ),
                                ));

                                $response = curl_exec($curl);
                                // success
                                $err = curl_close($curl);
                                if ($err) {
                                  echo "Connection Error";
                                  $obj = json_decode($response, TRUE);
                                  $status = $obj['messageParts'][0]['status'];
                                  $errorMessage = $obj['messageParts'][0]['errorMessage'];
                                  $errorCode = $obj['messageParts'][0]['errorCode'];
                                  $smsData = [
                                    'int_id' => $sessint_id,
                                    'branch_id' => $branch_id,
                                    'mobile_no' => $clientPhone,
                                    'message' => $escape,
                                    'status' => $status,
                                    'ticket_id' => $ticketId,
                                    'error_message' => $errorMessage,
                                    'error_code' => $errorCode
                                  ];
                                  $insertSms = insert('sms_record', $smsData);
                                } else {
                                  $obj = json_decode($response, TRUE);
                                $status = $obj['messageParts'][0]['status'];
                                $ticketId = $obj['messageParts'][0]['ticketId'];
                                $errorMessage = $obj['messageParts'][0]['errorMessage'];
                                $errorCode = $obj['messageParts'][0]['errorCode'];
                                // check for success response
                                if ($status != "") {
                                  $smsData = [
                                    'int_id' => $sessint_id,
                                    'branch_id' => $branch_id,
                                    'mobile_no' => $clientPhone,
                                    'message' => $escape,
                                    'transaction_date' => $today,
                                    'status' => $status,
                                    'ticket_id' => $ticketId,
                                    'error_message' => $errorMessage,
                                    'error_code' => $errorCode
                                  ];
                                  $insertSms = insert('sms_record', $smsData);
                                    // Declare variables needed to keep record of the transaction
                                    $cal_bal = $smsBalance - 4;
                                    $cal_with = $total_with + 4;
                                    $cal_sek = $total_sekani_charge + 0;
                                    $cal_mch = $total_merchant_charge + 4;
                                    $cal_int_prof = $total_int_profit + 0;
                                    $digits = 9;
                                    $date = date("Y-m-d");
                                    $date2 = date('Y-m-d H:i:s');
                                    $randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
                                    $trans = "SKWAL" . $randms . "SMS" . $sessint_id;
                                    $update_transaction = mysqli_query($connection, "UPDATE sekani_wallet SET sms_balance = '$cal_bal', total_withdrawal = '$cal_with',
                                  int_profit = '$cal_int_prof', sekani_charge = '$cal_sek', merchant_charge = '$cal_mch' WHERE int_id = '$sessint_id' AND branch_id = '$branch_id'");
                                    if ($update_transaction) {
                                      // inserting record of transaction.
                                      $insert_transaction = mysqli_query($connection, "INSERT INTO `sekani_wallet_transaction` (`int_id`, `branch_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `wallet_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, 
                                    `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`,
                                    `int_profit`, `sekani_charge`, `merchant_charge`)
                                    VALUES ('{$sessint_id}', '{$branch_id}', '{$trans}', 'SMS charge', 'sms', NULL, '0', '{$date}', '4', '{$cal_bal}', '{$cal_bal}', {$date}, 
                                    NULL, NULL, '{$date2}', '0', '0.00', '4.00', '{$cal_int_prof}', '{$cal_sek}', '{$cal_mch}')");
                                      if ($insert_transaction) {
                                        // store SMS charge
                                        $insert_qualif = mysqli_query($connection, "INSERT INTO `sms_charge` (`int_id`, `branch_id`, `trans_id`, `client_id`, `account_no`, `amount`, `charge_date`) VALUES ('{$sessint_id}', '{$branch_id}', '{$trans}', '{$client_id}', '{$acct_no}', '4', '{$date}')");
                                      }
                                    }
                                  }
                                }
                              }
                            }
                          ?>

                <?php
                          }
                          // institution account
                          if ($is_bank == 1) {
                            $upglacct = "UPDATE `acc_gl_account` SET `organization_running_balance_derived` = '$new_gl_bal2x' WHERE int_id = '$sessint_id' && gl_code = '$bank_gl_code'";
                            $dbgl = mysqli_query($connection, $upglacct);
                            if ($dbgl) {
                              $gl_acc1 = "INSERT INTO gl_account_transaction (int_id, branch_id, gl_code, transaction_id, description,
                      transaction_type, teller_id, transaction_date, amount, gl_account_balance_derived, overdraft_amount_derived,
                        created_date, debit) VALUES ('{$sessint_id}', '{$branch_id}', '{$bank_gl_code}', '{$transid}', '{$description}', '{$trans_type2}', '{$staff_id}',
                         '{$transaction_date}', '{$amount}', '{$new_gl_bal2x}', '{$amount}', '{$gen_date}', '{$amount}')";
                              $mkl = mysqli_query($connection, $gl_acc1);
                              if ($mkl) {
                                echo '<script type="text/javascript">
                          $(document).ready(function(){
                              swal({
                                  type: "success",
                                  title: "Withdrawal Transaction",
                                  text: "Transaction Approval Successful",
                                  showConfirmButton: false,
                                  timer: 2000
                              })
                          });
                          </script>
                          ';
                                $URL = "transact_approval.php";
                                echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                              } else {
                                echo "Error at the Bank Withdrawal";
                                echo '<script type="text/javascript">
                           $(document).ready(function(){
                               swal({
                                   type: "error",
                                   title: "Withdrawal Transaction",
                                   text: "Transaction Approval Error",
                                   showConfirmButton: false,
                                   timer: 2000
                               })
                           });
                           </script>
                           ';
                              }
                              //    if ($connection->error) {
                              //     try {
                              //         throw new Exception("MYSQL error $connection->error <br> $gl_acc1 ", $mysqli->error);
                              //     } catch (Exception $e) {
                              //         echo "Error No: ".$e->getCode()." - ".$e->getMessage() . "<br>";
                              //         echo n12br($e->getTraceAsString());
                              //     }
                              // }
                            }
                          } else if ($is_bank == 0) {
                            // institution account transaction
                            $int_account_trans = "UPDATE institution_account SET account_balance_derived = '$new_int_bal2' WHERE teller_id = '$teller_id' OR submittedon_userid = '$teller_id' AND int_id = '$sessint_id'";
                            $query1 = mysqli_query($connection, $int_account_trans);
                            // check if int account has been updated
                            if ($query1) {
                              $trust = "INSERT INTO institution_account_transaction (int_id, branch_id,
                                 client_id, transaction_id, description, transaction_type, teller_id, is_reversed,
                                 transaction_date, amount, running_balance_derived, overdraft_amount_derived,
                                 created_date, appuser_id, debit) VALUES ('{$sessint_id}', '{$branch_id}',
                                '{$client_id}', '{$transid}', '{$description}', '{$trans_type2}', '{$teller_id}', '{$irvs}',
                                '{$transaction_date}', '{$amount}', '{$new_int_bal2}', '{$amount}',
                                '{$gen_date}', '{$appuser_id}', '{$amount}')";
                              $res9 = mysqli_query($connection, $trust);
                              if ($res9) {
                                //  REMEMBER MAILING SYSTEMS
                                echo '<script type="text/javascript">
                                 $(document).ready(function(){
                                     swal({
                                         type: "success",
                                         title: "Withdrawal Transaction",
                                         text: "Transaction Approval Successful",
                                         showConfirmButton: false,
                                         timer: 2000
                                     })
                                 });
                                 </script>
                                 ';
                                $URL = "transact_approval.php";
                                echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                              } else {
                                echo '<script type="text/javascript">
                                 $(document).ready(function(){
                                     swal({
                                         type: "error",
                                         title: "System Error",
                                         text: "Call - Check the institution account",
                                         showConfirmButton: false,
                                         timer: 2000
                                     })
                                 });
                                 </script>
                                 ';
                              }
                            } else {
                              // system error
                              echo '<script type="text/javascript">
                                 $(document).ready(function(){
                                     swal({
                                         type: "error",
                                         title: "System Error",
                                         text: "Call - Check the institution account",
                                         showConfirmButton: false,
                                         timer: 2000
                                     })
                                 });
                                 </script>
                                 ';
                            }
                          } else {
                            echo "Nothing";
                          }
                        } else {
                          echo '<script type="text/javascript">
                               $(document).ready(function(){
                                   swal({
                                       type: "error",
                                       title: "Error",
                                       text: "Error updating Cache",
                                       showConfirmButton: false,
                                       timer: 2000
                                   })
                               });
                               </script>
                               ';
                        }
                      } else {
                        echo '<script type="text/javascript">
                           $(document).ready(function(){
                               swal({
                                   type: "error",
                                   title: "Error",
                                   text: "Error in Transaction 2",
                                   showConfirmButton: false,
                                   timer: 2000
                               })
                           });
                           </script>
                           ';
                      }
                    } else {
                      echo '<script type="text/javascript">
                       $(document).ready(function(){
                           swal({
                               type: "error",
                               title: "Error",
                               text: "Error in Account",
                               showConfirmButton: false,
                               timer: 2000
                           })
                       });
                       </script>
                       ';
                    }
                  } else {
                    // ec
                    echo '<script type="text/javascript">
                     $(document).ready(function(){
                         swal({
                             type: "error",
                             title: "Teller or Bank",
                             text: "Insufficient Fund",
                             showConfirmButton: false,
                             timer: 2000
                         })
                     });
                     </script>
                     ';
                  }
                } else if ($transact_type == "Expense") {
                  $getaccount = mysqli_query($connection, "SELECT * FROM institution_account WHERE int_id = '$sessint_id' && teller_id = '$staff_id' OR submittedon_userid = '$teller_id'");
                  $getbal = mysqli_fetch_array($getaccount);
                  $runtellb = $getbal["account_balance_derived"];
                  // importing the needed on the gl
                  if ($runtellb >= $amount) {
                    $upglacct = "UPDATE `acc_gl_account` SET `organization_running_balance_derived` = '$new_gl_bal' WHERE int_id = '$sessint_id' && gl_code = '$gl_codex'";
                    $dbgl = mysqli_query($connection, $upglacct);
                    if ($dbgl) {
                      $upinta = "UPDATE institution_account SET account_balance_derived = '$new_int_bal2', total_withdrawals_derived = '$tbd2' WHERE int_id = '$sessint_id' AND teller_id = '$staff_id' OR submittedon_userid = '$teller_id'";
                      $res1 = mysqli_query($connection, $upinta);
                      if ($res1) {
                        $iat2 = "INSERT INTO institution_account_transaction (int_id, branch_id,
               teller_id, transaction_id, description, transaction_type, is_reversed,
               transaction_date, amount, running_balance_derived, overdraft_amount_derived,
               created_date, appuser_id, debit) VALUES ('{$sessint_id}', '{$branch_idm}',
               '{$gl_codex}', '{$trans_id}', '{$description}', 'Debit', '{$irvs}',
               '{$transaction_date}', '{$gl_amt}', '{$new_int_bal2}', '{$gl_amt}',
               '{$gen_date}', '{$staff_id}', '{$gl_amt}')";
                        $res4 = mysqli_query($connection, $iat2);
                        if ($res4) {
                          // REMEMBER TO SEND A MAIL
                          $v = "Verified";
                          $updateTrans = "UPDATE transact_cache SET `status` = '$v' WHERE int_id = '$sessint_id' && id='$appod'";
                          $resl = mysqli_query($connection, $updateTrans);
                          // FINAL
                          if ($resl) {
                            echo '<script type="text/javascript">
                                 $(document).ready(function(){
                                     swal({
                                         type: "success",
                                         title: "Expense",
                                         text: "Expense Transaction Approval Successful",
                                         showConfirmButton: false,
                                         timer: 2000
                                     })
                                 });
                                 </script>
                                 ';
                            $URL = "transact_approval.php";
                            echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                          } else {
                            // echo error in transact cache
                            echo '<script type="text/javascript">
                           $(document).ready(function(){
                               swal({
                                   type: "error",
                                   title: "Error",
                                   text: "Error in Account Transaction Cache",
                                   showConfirmButton: false,
                                   timer: 2000
                               })
                           });
                           </script>
                           ';
                          }
                        } else {
                          // echo error at institution account transaction
                          echo '<script type="text/javascript">
                       $(document).ready(function(){
                           swal({
                               type: "error",
                               title: "Error",
                               text: "Error in Account Transaction",
                               showConfirmButton: false,
                               timer: 2000
                           })
                       });
                       </script>
                       ';
                        }
                      } else {
                        // echo error institution account
                        echo '<script type="text/javascript">
                       $(document).ready(function(){
                           swal({
                               type: "error",
                               title: "Error",
                               text: "Error in Teller Account",
                               showConfirmButton: false,
                               timer: 2000
                           })
                       });
                       </script>
                       ';
                      }
                    } else {
                      // echo error in account gl
                      echo '<script type="text/javascript">
                       $(document).ready(function(){
                           swal({
                               type: "error",
                               title: "Error",
                               text: "Error in Expense GL Account",
                               showConfirmButton: false,
                               timer: 2000
                           })
                       });
                       </script>
                       ';
                    }
                  } else {
                    echo '<script type="text/javascript">
                     $(document).ready(function(){
                         swal({
                             type: "error",
                             title: "Teller",
                             text: "Insufficient Fund",
                             showConfirmButton: false,
                             timer: 2000
                         })
                     });
                     </script>
                     ';
                  }
                  //  insire
                }
                //  an else goes here

                else {
                  echo '<script type="text/javascript">
                     $(document).ready(function(){
                         swal({
                             type: "error",
                             title: "Error",
                             text: "No Deposit or Withdrawal",
                             showConfirmButton: false,
                             timer: 2000
                         })
                     });
                     </script>
                     ';
                }
              }
            } else {
              // group accounts
              $getacct =  mysqli_query($connection, "Select * FROM group_balance WHERE account_no = '$acct_no'");
              if (count([$getacct]) == 1) {
                $y = mysqli_fetch_array($getacct);
                $branch_id = $y['branch_id'];
                $client_id = $y['client_id'];
                $acc_id = $y['id'];
                $int_acct_bal = $y['account_balance_derived'];
                $comp = $amount + $int_acct_bal;
                $numberacct = number_format("$comp", 2);
                $comp2 = $int_acct_bal - $amount;
                $numberacct2 = number_format("$comp2", 2);
                $compall = $y["account_balance_derived"] - $amount;
                $trans_type = "credit";
                $trans_type2 = "debit";
                $irvs = 0;
                //  select the acccount
                $dbclient = mysqli_query($connection, "SELECT * FROM groups WHERE id = '$client_id' && int_id = '$sessint_id'");
                if (count([$dbclient]) == 1) {
                  $a = mysqli_fetch_array($dbclient);
                  $branch_id = $a['branch_id'];
                  $client_phone = $a["pc_phone"];
                  $client_sms = 1;
                }
                ?>
                <input type="text" id="s_int_id" value="<?php echo $sessint_id; ?>" hidden>
                <input type="text" id="s_acct_nox" value="<?php echo $acct_no; ?>" hidden>
                <input type="text" id="s_branch_id" value="<?php echo $branch_id; ?>" hidden>
                <input type="text" id="s_sender_id" value="<?php echo $sender_id; ?>" hidden>
                <input type="text" id="s_phone" value="<?php echo $client_phone; ?>" hidden>
                <input type="text" id="s_client_id" value="<?php echo $client_id; ?>" hidden>
                <div id="make_display"></div>
                <?php
                //   group account deposit computation
                if ($transact_type == "Deposit" && $client_id = $id) {
                  $new_abd = $comp;
                  $iupq = "UPDATE group_balance SET account_balance_derived = '$new_abd',
                     last_deposit = '$amount' WHERE account_no = '$acct_no' && int_id = '$sessint_id'";
                  $iupqres = mysqli_query($connection, $iupq);
                  if ($iupqres) {
                    $iat = "INSERT INTO group_transaction (int_id, branch_id, account_id,
                         account_no, product_id,
                         client_id, teller_id, transaction_id, description, transaction_type, is_reversed,
                         transaction_date, amount, running_balance_derived, overdraft_amount_derived,
                         created_date, appuser_id, credit) VALUES ('{$ssint_id}', '{$branch_id}',
                         '{$acc_id}', '{$acct_no}', '{$product_type}', '{$client_id}', '{$teller_id}',
                         '{$transid}', '{$description}', '{$trans_type}', '{$irvs}',
                         '{$transaction_date}', '{$amount}', '{$new_abd}', '{$amount}',
                         '{$gen_date}', '{$appuser_id}', '{$amount}')";
                    $res3 = mysqli_query($connection, $iat);
                    if ($res3) {
                      $v = "Verified";
                      $iupqx = "UPDATE transact_cache SET `status` = '$v' WHERE id = '$appod' && int_id = '$sessint_id'";
                      $res4 = mysqli_query($connection, $iupqx);
                      if ($res4) {
                        // MAKING IT OUT
                        // SMS POSTING
                        // END THE TRANSACTION
                        if ($client_sms == "1") {
                          $trans_type = "Credit";
                          $balance = number_format($comp, 2);
                          $msg = "Acct: " . appendAccountNo($acct_no, 6) . "\nAmt: NGN " . number_format($amount, 2) . " " . $trans_type . "\nDesc: " . $description . "\nAvail Bal: " . $balance . "\nDate: " . $pint;
                          // creating unique message ID
                          $digits = 9;
                          $messageId = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
                          // check for needed values
                          // if exists proceed to send SMS
                          if ($sender_id != "" && $client_phone != "" && $msg != "" && $sessint_id != "" && $branch_id != "") {
                            // Check the length of the phone numer
                            // if 10 add country code
                            $phoneLength = strlen($client_phone);
                            if ($phoneLength == 10) {
                              $clientPhone = "234" . $client_phone;
                            }
                            if ($phone_length == 11) {
                              $phone =  substr($client_phone, 1);
                              $clientPhone = "234" . $phone;
                            }
                            $testData = [
                              'int_id' => $sessint_id,
                              'texts' => $clientPhone
                            ];
                            $insertTest = insert('test_data', $testData);
                            $sql_fund = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$sessint_id'");
                            $qw = mysqli_fetch_array($sql_fund);
                            $smsBalance = $qw["sms_balance"];
                            $total_with = $qw["total_withdrawal"];
                            $total_int_profit = $qw["int_profit"];
                            $total_sekani_charge = $qw["sekani_charge"];
                            $total_merchant_charge = $qw["merchant_charge"];
                            if ($smsBalance >= 4) {

                              $curl = curl_init();
                              $escape = mysqli_real_escape_string($connection, $msg);

                              curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://sms.vanso.com//rest/sms/submit/long',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => '{
                                      "account": {
                                          "password": "kwPPkiV4",
                                          "systemId": "NG.102.0421"
                                          },
                                          "sms": {
                                              "dest":"' . $clientPhone . '",
                                              "src": "' . $senderId . '",
                                              "text": "' . $message . '",
                                              "unicode": true
                                          }

                                      }',
                                CURLOPT_HTTPHEADER => array(
                                  'Content-Type: application/json',
                                  'Authorization: Basic TkcuMTAyLjA0MjE6a3dQUGtpVjQ='
                                ),
                              ));

                              $response = curl_exec($curl);
                              // success
                              $err = curl_close($curl);
                              if ($err) {
                                echo "Connection Error";
                                $obj = json_decode($response, TRUE);
                                $status = $obj['messageParts'][0]['status'];
                                $errorMessage = $obj['messageParts'][0]['errorMessage'];
                                $errorCode = $obj['messageParts'][0]['errorCode'];
                                $smsData = [
                                  'int_id' => $sessint_id,
                                  'branch_id' => $branch_id,
                                  'mobile_no' => $clientPhone,
                                  'message' => $escape,
                                  'status' => $status,
                                  'ticket_id' => $ticketId,
                                  'error_message' => $errorMessage,
                                  'error_code' => $errorCode
                                ];
                                $insertSms = insert('sms_record', $smsData);
                              } else {
                                $obj = json_decode($response, TRUE);
                                $status = $obj['messageParts'][0]['status'];
                                $ticketId = $obj['messageParts'][0]['ticketId'];
                                $errorMessage = $obj['messageParts'][0]['errorMessage'];
                                $errorCode = $obj['messageParts'][0]['errorCode'];
                                // check for success response
                                if ($status != "") {
                                  $smsData = [
                                    'int_id' => $sessint_id,
                                    'branch_id' => $branch_id,
                                    'mobile_no' => $clientPhone,
                                    'message' => $escape,
                                    'transaction_date' => $today,
                                    'status' => $status,
                                    'ticket_id' => $ticketId,
                                    'error_message' => $errorMessage,
                                    'error_code' => $errorCode
                                  ];
                                  $insertSms = insert('sms_record', $smsData);
                                  // Declare variables needed to keep record of the transaction
                                  $cal_bal = $smsBalance - 4;
                                  $cal_with = $total_with + 4;
                                  $cal_sek = $total_sekani_charge + 0;
                                  $cal_mch = $total_merchant_charge + 4;
                                  $cal_int_prof = $total_int_profit + 0;
                                  $digits = 9;
                                  $date = date("Y-m-d");
                                  $date2 = date('Y-m-d H:i:s');
                                  $randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
                                  $trans = "SKWAL" . $randms . "SMS" . $sessint_id;
                                  $update_transaction = mysqli_query($connection, "UPDATE sekani_wallet SET sms_balance = '$cal_bal', total_withdrawal = '$cal_with',
                                  int_profit = '$cal_int_prof', sekani_charge = '$cal_sek', merchant_charge = '$cal_mch' WHERE int_id = '$sessint_id' AND branch_id = '$branch_id'");
                                  if ($update_transaction) {
                                    // inserting record of transaction.
                                    $insert_transaction = mysqli_query($connection, "INSERT INTO `sekani_wallet_transaction` (`int_id`, `branch_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `wallet_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, 
                                    `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`,
                                    `int_profit`, `sekani_charge`, `merchant_charge`)
                                    VALUES ('{$sessint_id}', '{$branch_id}', '{$trans}', 'SMS charge', 'sms', NULL, '0', '{$date}', '4', '{$cal_bal}', '{$cal_bal}', {$date}, 
                                    NULL, NULL, '{$date2}', '0', '0.00', '4.00', '{$cal_int_prof}', '{$cal_sek}', '{$cal_mch}')");
                                    if ($insert_transaction) {
                                      // store SMS charge
                                      $insert_qualif = mysqli_query($connection, "INSERT INTO `sms_charge` (`int_id`, `branch_id`, `trans_id`, `client_id`, `account_no`, `amount`, `charge_date`) VALUES ('{$sessint_id}', '{$branch_id}', '{$trans}', '{$client_id}', '{$acct_no}', '4', '{$date}')");
                                    }
                                  }
                                }
                              }
                            }
                          }
                ?>

                          <?php
                        }
                        // end it for the SMS POSTING
                        // ENDING OF THE AR
                        if ($is_bank == 1 || $is_bank == 2) {
                          $upglacct = "UPDATE `acc_gl_account` SET `organization_running_balance_derived` = '$new_gl_balx' WHERE int_id = '$sessint_id' && gl_code = '$bank_gl_code'";
                          $dbgl = mysqli_query($connection, $upglacct);
                          if ($dbgl) {
                            $gl_acc = "INSERT INTO gl_account_transaction (int_id, branch_id, gl_code, transaction_id, description,
                                  transaction_type, teller_id, transaction_date, amount, gl_account_balance_derived, overdraft_amount_derived,
                                    created_date, credit) VALUES ('{$sessint_id}', '{$branch_id}', '{$bank_gl_code}', '{$transid}', '{$description}', '{$trans_type}', '{$staff_id}',
                                     '{$transaction_date}', '{$amount}', '{$new_gl_balx}', '{$amount}', '{$gen_date}', '{$amount}')";
                            $mxc = mysqli_query($connection, $gl_acc);
                            if ($mxc) {
                              echo '<script type="text/javascript">
                                      $(document).ready(function(){
                                          swal({
                                              type: "success",
                                              title: "Deposit Transaction",
                                              text: "Transaction Approval Successful",
                                              showConfirmButton: false,
                                              timer: 2000
                                          })
                                      });
                                      </script>
                                      ';
                              $URL = "transact_approval.php";
                              echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                            } else {
                              echo "Error in Bank Transaction";
                            }
                          }
                        } else if ($is_bank == 0) {
                          // institution account
                          $int_account_trans = "UPDATE institution_account SET account_balance_derived = '$new_int_bal' WHERE teller_id = '$teller_id' OR submittedon_userid = '$teller_id' AND int_id = '$sessint_id'";
                          $query1 = mysqli_query($connection, $int_account_trans);
                          // check if int account has been updated
                          if ($query1) {
                            $trust = "INSERT INTO institution_account_transaction (int_id, branch_id,
                                 client_id, transaction_id, description, transaction_type, teller_id, is_reversed,
                                 transaction_date, amount, running_balance_derived, overdraft_amount_derived,
                                 created_date, appuser_id, credit) VALUES ('{$sessint_id}', '{$branch_id}',
                                '{$client_id}', '{$transid}', '{$description}', '{$trans_type}', '{$teller_id}', '{$irvs}',
                                '{$transaction_date}', '{$amount}', '{$new_int_bal}', '{$amount}',
                                '{$gen_date}', '{$appuser_id}', '{$amount}')";
                            $res9 = mysqli_query($connection, $trust);
                            if ($res9) {
                              //  MAILING SYSTEMS WILL COME IN LATER
                              //  REMEMBER MAILING SYSTEMS
                              echo '<script type="text/javascript">
                                $(document).ready(function(){
                                    swal({
                                        type: "success",
                                        title: "Deposit Transaction",
                                        text: "Transaction Approval Successful",
                                        showConfirmButton: false,
                                        timer: 2000
                                    })
                                });
                                </script>
                                ';
                              $URL = "transact_approval.php";
                              echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                            } else {
                              echo '<script type="text/javascript">
                                 $(document).ready(function(){
                                     swal({
                                         type: "error",
                                         title: "System Error",
                                         text: "Call - Check the institution account",
                                         showConfirmButton: false,
                                         timer: 2000
                                     })
                                 });
                                 </script>
                                 ';
                            }
                          } else {
                            // system error
                            echo '<script type="text/javascript">
                                 $(document).ready(function(){
                                     swal({
                                         type: "error",
                                         title: "System Error",
                                         text: "Call - Check the institution account",
                                         showConfirmButton: false,
                                         timer: 2000
                                     })
                                 });
                                 </script>
                                 ';
                          }
                        } else {
                          echo '<script type="text/javascript">
                                $(document).ready(function(){
                                    swal({
                                        type: "error",
                                        title: "No Payment Type",
                                        text: "Call - Check the institution account",
                                        showConfirmButton: false,
                                        timer: 2000
                                    })
                                });
                                </script>
                                ';
                        }
                        // institution account transaction
                      } else {
                        echo '<script type="text/javascript">
                               $(document).ready(function(){
                                   swal({
                                       type: "error",
                                       title: "Error",
                                       text: "Error updating Cache",
                                       showConfirmButton: false,
                                       timer: 2000
                                   })
                               });
                               </script>
                               ';
                      }
                    } else {
                      echo '<script type="text/javascript">
                           $(document).ready(function(){
                               swal({
                                   type: "error",
                                   title: "Error",
                                   text: "Error in Transaction 1",
                                   showConfirmButton: false,
                                   timer: 2000
                               })
                           });
                           </script>
                           ';
                    }
                  } else {
                    echo '<script type="text/javascript">
                       $(document).ready(function(){
                           swal({
                               type: "error",
                               title: "Error",
                               text: "Error in Account",
                               showConfirmButton: false,
                               timer: 2000
                           })
                       });
                       </script>
                       ';
                  }
                } else if ($transact_type == "Withdrawal" && $client_id = $id) {
                  $getaccount = mysqli_query($connection, "SELECT * FROM institution_account WHERE int_id = '$sessint_id' && teller_id = '$staff_id' OR submittedon_userid = '$teller_id'");
                  $getbal = mysqli_fetch_array($getaccount);
                  $runtellb = 0;
                  if ($is_bank == 1) {
                    $runtellb = $E_acct_bal;
                  } else if ($is_bank == 0) {
                    $runtellb = $getbal["account_balance_derived"];
                  }
                  // importing the needed on the gl
                  if ($runtellb >= $amount) {
                    $new_abd2 = $comp2;
                    $iupq = "UPDATE groub_balance SET account_balance_derived = '$new_abd2',
                     last_withdrawal = '$amount' WHERE account_no = '$acct_no' && int_id = '$sessint_id'";
                    $iupqres = mysqli_query($connection, $iupq);
                    if ($iupqres) {
                      $xmx = "INSERT INTO `group_transaction` (`int_id`, `branch_id`, `product_id`, `account_id`, `account_no`, 
                       `client_id`, `teller_id`, `transaction_id`, `description`, `transaction_type`, `is_reversed`, `transaction_date`, 
                       `amount`, `overdraft_amount_derived`, `balance_end_date_derived`, 
                      `running_balance_derived`,  `cumulative_balance_derived`, `created_date`, `appuser_id`, `debit`) 
                       VALUES ('{$sessint_id}', '{$branch_id}', '{$product_type}', 
                       '{$acc_id}', '{$acct_no}', '{$client_id}', {$teller_id}, 
                       '{$transid}', '{$description}', '{$trans_type2}', '{$irvs}', '{$transaction_date}',
                       '{$amount}', '{$amount}', '{$gen_date}', '{$comp2}', '{$amount}', '{$gen_date}', '{$appuser_id}', '{$amount}')";
                      $res3 = mysqli_query($connection, $xmx);

                      if ($xmx) {
                        $v = "Verified";
                        $iupqx = "UPDATE transact_cache SET `status` = '$v' WHERE id = '$appod' && int_id = '$sessint_id'";
                        $res4 = mysqli_query($connection, $iupqx);
                        if ($res4) {
                          //  now for DEBIT
                          if ($client_sms == "1") {
                            $trans_type = "Debit";
                            $balance = number_format($comp2, 2);
                            $msg = "Acct: " . appendAccountNo($acct_no, 6) . "\nAmt: NGN " . number_format($amount, 2) . " " . $trans_type . "\nDesc: " . $description . "\nAvail Bal: " . $balance . "\nDate: " . $pint;
                            // creating unique message ID
                            $digits = 9;
                            $messageId = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
                            // check for needed values
                            // if exists proceed to send SMS
                            if ($sender_id != "" && $client_phone != "" && $msg != "" && $sessint_id != "" && $branch_id != "") {
                              // Check the length of the phone numer
                              // if 10 add country code
                              $phoneLength = strlen($client_phone);
                              if ($phoneLength == 10) {
                                $clientPhone = "234" . $client_phone;
                              }
                              if ($phone_length == 11) {
                                $phone =  substr($client_phone, 1);
                                $clientPhone = "234" . $phone;
                              }
                              $sql_fund = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$sessint_id'");
                              $qw = mysqli_fetch_array($sql_fund);
                              $smsBalance = $qw["sms_balance"];
                              $total_with = $qw["total_withdrawal"];
                              $total_int_profit = $qw["int_profit"];
                              $total_sekani_charge = $qw["sekani_charge"];
                              $total_merchant_charge = $qw["merchant_charge"];
                              if ($smsBalance >= 4) {

                                $curl = curl_init();
                                $escape = mysqli_real_escape_string($connection, $msg);

                                curl_setopt_array($curl, array(
                                  CURLOPT_URL => 'https://sms.vanso.com//rest/sms/submit/long',
                                  CURLOPT_RETURNTRANSFER => true,
                                  CURLOPT_ENCODING => '',
                                  CURLOPT_MAXREDIRS => 10,
                                  CURLOPT_TIMEOUT => 0,
                                  CURLOPT_FOLLOWLOCATION => true,
                                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                  CURLOPT_CUSTOMREQUEST => 'POST',
                                  CURLOPT_POSTFIELDS => '{
                                      "account": {
                                          "password": "kwPPkiV4",
                                          "systemId": "NG.102.0421"
                                          },
                                          "sms": {
                                              "dest":"' . $clientPhone . '",
                                              "src": "' . $senderId . '",
                                              "text": "' . $escape . '",
                                              "unicode": true
                                          }

                                      }',
                                  CURLOPT_HTTPHEADER => array(
                                    'Content-Type: application/json',
                                    'Authorization: Basic TkcuMTAyLjA0MjE6a3dQUGtpVjQ='
                                  ),
                                ));
                                // success
                                $err = curl_close($curl);
                                if ($err) {
                                  echo "Connection Error";
                                  $obj = json_decode($response, TRUE);
                                  $status = $obj['messageParts'][0]['status'];
                                  $errorMessage = $obj['messageParts'][0]['errorMessage'];
                                  $errorCode = $obj['messageParts'][0]['errorCode'];
                                  $smsData = [
                                    'int_id' => $sessint_id,
                                    'branch_id' => $branch_id,
                                    'mobile_no' => $clientPhone,
                                    'message' => $escape,
                                    'status' => $status,
                                    'ticket_id' => $ticketId,
                                    'error_message' => $errorMessage,
                                    'error_code' => $errorCode
                                  ];
                                  $insertSms = insert('sms_record', $smsData);
                                } else {
                                  $obj = json_decode($response, TRUE);
                                  $status = $obj['messageParts'][0]['status'];
                                  $ticketId = $obj['messageParts'][0]['ticketId'];
                                  $errorMessage = $obj['messageParts'][0]['errorMessage'];
                                  $errorCode = $obj['messageParts'][0]['errorCode'];
                                  // check for success response
                                  if ($status != "") {
                                    $smsData = [
                                      'int_id' => $sessint_id,
                                      'branch_id' => $branch_id,
                                      'mobile_no' => $clientPhone,
                                      'message' => $escape,
                                      'transaction_date' => $today,
                                      'status' => $status,
                                      'ticket_id' => $ticketId,
                                      'error_message' => $errorMessage,
                                      'error_code' => $errorCode
                                    ];
                                    $insertSms = insert('sms_record', $smsData);
                                    // Declare variables needed to keep record of the transaction
                                    $cal_bal = $smsBalance - 4;
                                    $cal_with = $total_with + 4;
                                    $cal_sek = $total_sekani_charge + 0;
                                    $cal_mch = $total_merchant_charge + 4;
                                    $cal_int_prof = $total_int_profit + 0;
                                    $digits = 9;
                                    $date = date("Y-m-d");
                                    $date2 = date('Y-m-d H:i:s');
                                    $randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
                                    $trans = "SKWAL" . $randms . "SMS" . $sessint_id;
                                    $update_transaction = mysqli_query($connection, "UPDATE sekani_wallet SET sms_balance = '$cal_bal', total_withdrawal = '$cal_with',
                                  int_profit = '$cal_int_prof', sekani_charge = '$cal_sek', merchant_charge = '$cal_mch' WHERE int_id = '$sessint_id' AND branch_id = '$branch_id'");
                                    if ($update_transaction) {
                                      // inserting record of transaction.
                                      $insert_transaction = mysqli_query($connection, "INSERT INTO `sekani_wallet_transaction` (`int_id`, `branch_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `wallet_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, 
                                    `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`,
                                    `int_profit`, `sekani_charge`, `merchant_charge`)
                                    VALUES ('{$sessint_id}', '{$branch_id}', '{$trans}', 'SMS charge', 'sms', NULL, '0', '{$date}', '4', '{$cal_bal}', '{$cal_bal}', {$date}, 
                                    NULL, NULL, '{$date2}', '0', '0.00', '4.00', '{$cal_int_prof}', '{$cal_sek}', '{$cal_mch}')");
                                      if ($insert_transaction) {
                                        // store SMS charge
                                        $insert_qualif = mysqli_query($connection, "INSERT INTO `sms_charge` (`int_id`, `branch_id`, `trans_id`, `client_id`, `account_no`, `amount`, `charge_date`) VALUES ('{$sessint_id}', '{$branch_id}', '{$trans}', '{$client_id}', '{$acct_no}', '4', '{$date}')");
                                      }
                                    }
                                  }
                                }
                              }
                            }
                          ?>

<?php
                          }
                          // institution account
                          if ($is_bank == 1) {
                            $upglacct = "UPDATE `acc_gl_account` SET `organization_running_balance_derived` = '$new_gl_bal2x' WHERE int_id = '$sessint_id' && gl_code = '$bank_gl_code'";
                            $dbgl = mysqli_query($connection, $upglacct);
                            if ($dbgl) {
                              $gl_acc1 = "INSERT INTO gl_account_transaction (int_id, branch_id, gl_code, transaction_id, description,
                      transaction_type, teller_id, transaction_date, amount, gl_account_balance_derived, overdraft_amount_derived,
                        created_date, debit) VALUES ('{$sessint_id}', '{$branch_id}', '{$bank_gl_code}', '{$transid}', '{$description}', '{$trans_type2}', '{$staff_id}',
                         '{$transaction_date}', '{$amount}', '{$new_gl_bal2x}', '{$amount}', '{$gen_date}', '{$amount}')";
                              $mkl = mysqli_query($connection, $gl_acc1);
                              if ($mkl) {
                                echo '<script type="text/javascript">
                          $(document).ready(function(){
                              swal({
                                  type: "success",
                                  title: "Withdrawal Transaction",
                                  text: "Transaction Approval Successful",
                                  showConfirmButton: false,
                                  timer: 2000
                              })
                          });
                          </script>
                          ';
                                $URL = "transact_approval.php";
                                echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                              } else {
                                echo "Error at the Bank Withdrawal";
                                echo '<script type="text/javascript">
                           $(document).ready(function(){
                               swal({
                                   type: "error",
                                   title: "Withdrawal Transaction",
                                   text: "Transaction Approval Error",
                                   showConfirmButton: false,
                                   timer: 2000
                               })
                           });
                           </script>
                           ';
                              }
                            }
                          } else if ($is_bank == 0) {
                            // institution account transaction
                            $int_account_trans = "UPDATE institution_account SET account_balance_derived = '$new_int_bal2' WHERE teller_id = '$teller_id' OR submittedon_userid = '$teller_id' AND int_id = '$sessint_id'";
                            $query1 = mysqli_query($connection, $int_account_trans);
                            // check if int account has been updated
                            if ($query1) {
                              $trust = "INSERT INTO institution_account_transaction (int_id, branch_id,
                                 client_id, transaction_id, description, transaction_type, teller_id, is_reversed,
                                 transaction_date, amount, running_balance_derived, overdraft_amount_derived,
                                 created_date, appuser_id, debit) VALUES ('{$sessint_id}', '{$branch_id}',
                                '{$client_id}', '{$transid}', '{$description}', '{$trans_type2}', '{$teller_id}', '{$irvs}',
                                '{$transaction_date}', '{$amount}', '{$new_int_bal2}', '{$amount}',
                                '{$gen_date}', '{$appuser_id}', '{$amount}')";
                              $res9 = mysqli_query($connection, $trust);
                              if ($res9) {
                                //  REMEMBER MAILING SYSTEMS
                                echo '<script type="text/javascript">
                                 $(document).ready(function(){
                                     swal({
                                         type: "success",
                                         title: "Withdrawal Transaction",
                                         text: "Transaction Approval Successful",
                                         showConfirmButton: false,
                                         timer: 2000
                                     })
                                 });
                                 </script>
                                 ';
                                $URL = "transact_approval.php";
                                echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                              } else {
                                echo '<script type="text/javascript">
                                 $(document).ready(function(){
                                     swal({
                                         type: "error",
                                         title: "System Error",
                                         text: "Call - Check the institution account",
                                         showConfirmButton: false,
                                         timer: 2000
                                     })
                                 });
                                 </script>
                                 ';
                              }
                            } else {
                              // system error
                              echo '<script type="text/javascript">
                                 $(document).ready(function(){
                                     swal({
                                         type: "error",
                                         title: "System Error",
                                         text: "Call - Check the institution account",
                                         showConfirmButton: false,
                                         timer: 2000
                                     })
                                 });
                                 </script>
                                 ';
                            }
                          } else {
                            echo "Nothing";
                          }
                        } else {
                          echo '<script type="text/javascript">
                               $(document).ready(function(){
                                   swal({
                                       type: "error",
                                       title: "Error",
                                       text: "Error updating Cache",
                                       showConfirmButton: false,
                                       timer: 2000
                                   })
                               });
                               </script>
                               ';
                        }
                      } else {
                        echo '<script type="text/javascript">
                           $(document).ready(function(){
                               swal({
                                   type: "error",
                                   title: "Error",
                                   text: "Error in Transaction 2",
                                   showConfirmButton: false,
                                   timer: 2000
                               })
                           });
                           </script>
                           ';
                      }
                    } else {
                      echo '<script type="text/javascript">
                       $(document).ready(function(){
                           swal({
                               type: "error",
                               title: "Error",
                               text: "Error in Account",
                               showConfirmButton: false,
                               timer: 2000
                           })
                       });
                       </script>
                       ';
                    }
                  } else {
                    // ec
                    echo '<script type="text/javascript">
                     $(document).ready(function(){
                         swal({
                             type: "error",
                             title: "Teller or Bank",
                             text: "Insufficient Fund",
                             showConfirmButton: false,
                             timer: 2000
                         })
                     });
                     </script>
                     ';
                  }
                } else if ($transact_type == "Expense") {
                  $getaccount = mysqli_query($connection, "SELECT * FROM institution_account WHERE int_id = '$sessint_id' && teller_id = '$staff_id' OR submittedon_userid = '$teller_id'");
                  $getbal = mysqli_fetch_array($getaccount);
                  $runtellb = $getbal["account_balance_derived"];
                  // importing the needed on the gl
                  if ($runtellb >= $amount) {
                    $upglacct = "UPDATE `acc_gl_account` SET `organization_running_balance_derived` = '$new_gl_bal' WHERE int_id = '$sessint_id' && gl_code = '$gl_codex'";
                    $dbgl = mysqli_query($connection, $upglacct);
                    if ($dbgl) {
                      $upinta = "UPDATE institution_account SET account_balance_derived = '$new_int_bal2', total_withdrawals_derived = '$tbd2' WHERE int_id = '$sessint_id' AND teller_id = '$staff_id' OR submittedon_userid = '$teller_id'";
                      $res1 = mysqli_query($connection, $upinta);
                      if ($res1) {
                        $iat2 = "INSERT INTO institution_account_transaction (int_id, branch_id,
               teller_id, transaction_id, description, transaction_type, is_reversed,
               transaction_date, amount, running_balance_derived, overdraft_amount_derived,
               created_date, appuser_id, debit) VALUES ('{$sessint_id}', '{$branch_idm}',
               '{$gl_codex}', '{$trans_id}', '{$description}', 'Debit', '{$irvs}',
               '{$transaction_date}', '{$gl_amt}', '{$new_int_bal2}', '{$gl_amt}',
               '{$gen_date}', '{$staff_id}', '{$gl_amt}')";
                        $res4 = mysqli_query($connection, $iat2);
                        if ($res4) {
                          // REMEMBER TO SEND A MAIL
                          $v = "Verified";
                          $updateTrans = "UPDATE transact_cache SET `status` = '$v' WHERE int_id = '$sessint_id' && id='$appod'";
                          $resl = mysqli_query($connection, $updateTrans);
                          // FINAL
                          if ($resl) {
                            echo '<script type="text/javascript">
                                 $(document).ready(function(){
                                     swal({
                                         type: "success",
                                         title: "Expense",
                                         text: "Expense Transaction Approval Successful",
                                         showConfirmButton: false,
                                         timer: 2000
                                     })
                                 });
                                 </script>
                                 ';
                            $URL = "transact_approval.php";
                            echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                          } else {
                            // echo error in transact cache
                            echo '<script type="text/javascript">
                           $(document).ready(function(){
                               swal({
                                   type: "error",
                                   title: "Error",
                                   text: "Error in Account Transaction Cache",
                                   showConfirmButton: false,
                                   timer: 2000
                               })
                           });
                           </script>
                           ';
                          }
                        } else {
                          // echo error at institution account transaction
                          echo '<script type="text/javascript">
                       $(document).ready(function(){
                           swal({
                               type: "error",
                               title: "Error",
                               text: "Error in Account Transaction",
                               showConfirmButton: false,
                               timer: 2000
                           })
                       });
                       </script>
                       ';
                        }
                      } else {
                        // echo error institution account
                        echo '<script type="text/javascript">
                       $(document).ready(function(){
                           swal({
                               type: "error",
                               title: "Error",
                               text: "Error in Teller Account",
                               showConfirmButton: false,
                               timer: 2000
                           })
                       });
                       </script>
                       ';
                      }
                    } else {
                      // echo error in account gl
                      echo '<script type="text/javascript">
                       $(document).ready(function(){
                           swal({
                               type: "error",
                               title: "Error",
                               text: "Error in Expense GL Account",
                               showConfirmButton: false,
                               timer: 2000
                           })
                       });
                       </script>
                       ';
                    }
                  } else {
                    echo '<script type="text/javascript">
                     $(document).ready(function(){
                         swal({
                             type: "error",
                             title: "Teller",
                             text: "Insufficient Fund",
                             showConfirmButton: false,
                             timer: 2000
                         })
                     });
                     </script>
                     ';
                  }
                  //  insire
                }
                //  an else goes here

                else {
                  echo '<script type="text/javascript">
                     $(document).ready(function(){
                         swal({
                             type: "error",
                             title: "Error",
                             text: "No Deposit or Withdrawal",
                             showConfirmButton: false,
                             timer: 2000
                         })
                     });
                     </script>
                     ';
                }
              }
              // ends here
            }
          } else {
            // a message
            echo '<script type="text/javascript">
                     $(document).ready(function(){
                         swal({
                             type: "error",
                             title: "Error",
                             text: "Transaction Has Been Approved Already",
                             showConfirmButton: false,
                             timer: 2000
                         })
                     });
                     </script>
                     ';
          }
        }
      }
    } else {
      $digits = 10;
      $randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
      if (isset($_GET['approve']) && $_GET['approve'] !== '') {
        $appe = $_GET['approve'];
        $dc = "declined";
        $take = "UPDATE transact_cache SET `status` = '$dc' WHERE id = '$appe' && int_id = '$sessint_id'";
        $deny = mysqli_query($connection, $take);
        if ($deny) {
          echo '<script type="text/javascript">
                             $(document).ready(function(){
                                 swal({
                                     type: "success",
                                     title: "Success",
                                     text: "Transaction Declined",
                                     showConfirmButton: false,
                                     timer: 2000
                                 })
                             });
                             </script>
         ';
          $URL = "transact_approval.php";
          echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
        } else {
          echo '<script type="text/javascript">
                             $(document).ready(function(){
                                 swal({
                                     type: "error",
                                     title: "Error",
                                     text: "Error Not Declined",
                                     showConfirmButton: false,
                                     timer: 2000
                                 })
                             });
                             </script>
       ';
        }
      }
    }
  } else {
    // echo this transaction has been done already
    echo '<script type="text/javascript">
                             $(document).ready(function(){
                                 swal({
                                     type: "error",
                                     title: "Transaction Already Done!",
                        text: "This transaction has been done already",
                     showConfirmButton: false,
                  timer: 2000
         })
        });
    </script>
       ';
    $URL = "transact_approval.php";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
  }
}
?>
<!-- Content added here -->

<div class="content">
  <div class="container-fluid">
    <!-- your content here -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">Approve Transaction</h4>
            <p class="card-category">Make sure everything is in order</p>
          </div>
          <div class="card-body">
            <form method="post">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Transaction Type:</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $transact_type; ?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Posted By</label>
                    <input type="text" class="form-control" name="email" value="<?php if ($ao != "") {
                                                                                  echo $ao;
                                                                                } else {
                                                                                  $findResponsible = mysqli_query($connection, "SELECT display_name FROM staff WHERE id = '$teller_id'");
                                                                                  $data = mysqli_fetch_array($findResponsible);
                                                                                  echo $staffName = $data['display_name'];
                                                                                } ?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Client Name</label>
                    <input type="text" class="form-control" name="phone" value="<?php echo $cn; ?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Amount</label>
                    <input type="text" class="form-control" name="location" value="<?php echo $amount; ?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Description</label>
                    <input type="text" class="form-control" name="descript" value="<?php echo $description; ?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Transaction Narration</label>
                    <?php if ($is_bank == 1) { ?>
                      <input type="text" value="Bank" class="form-control" readonly>
                    <?php } else if ($is_bank == 0) { ?>
                      <input type="text" value="Cash" class="form-control" readonly>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Transaction ID</label>
                    <input type="text" class="form-control" name="transidddd" value="<?php echo $transid; ?>">
                  </div>
                </div>
              </div>
              <a href="client.php" class="btn btn-secondary">Back</a>
              <button type="submit" name="submit" value="decline" class="btn btn-danger pull-right">Decline</button>
              <?php
              $findAccount = mysqli_query($connection, "SELECT account_no  FROM account WHERE account_no = '$acct_no'");
              $data = mysqli_fetch_array($findAccount);
              if ($findAccount) {
                $findAccount = mysqli_query($connection, "SELECT account_no  FROM group_balance WHERE account_no = '$acct_no'");
              ?>
                <button type="submit" name="submit" value="approve" class="btn btn-primary pull-right">Approve</button>
              <?php
              } else if ($data['account_no'] == $acct_no) {
                //output
              ?>
                <button type="submit" name="submit" value="approve" class="btn btn-primary pull-right">Approve</button>
              <?php
              } else {
              ?>
                <button type="submit" name="submit" class="btn btn-primary pull-right" disabled>Approve</button>
              <?php
                printf('Error: %s\n', mysqli_error($connection)); //checking for errors
                exit();
              }
              ?>
              <div class="clearfix"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- /content -->
  </div>
</div>

<?php

include("footer.php");



?>