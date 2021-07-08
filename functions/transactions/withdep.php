<?php
include("../connect.php");
include("../../mfi/ajaxcall.php");
session_start();
require_once "../../bat/phpmailer/PHPMailerAutoload.php";
// qwertyuiop
// CHECK HTN APPROVAL
$int_name = $_SESSION["int_name"];
$int_email = $_SESSION["int_email"];
$int_web = $_SESSION["int_web"];
$int_phone = $_SESSION["int_phone"];
$int_logo = $_SESSION["int_logo"];
$int_address = $_SESSION["int_address"];
$sessint_id = $_SESSION["int_id"];
$m_id = $_SESSION["user_id"];
$sender_id = $_SESSION["sender_id"];
$tday = date('Y-m-d');
// declare it into the inputs
$getacct1 = mysqli_query($connection, "SELECT * FROM staff WHERE user_id = '$m_id' && int_id = '$sessint_id'");
if (count([$getacct1]) == 1) {
  $uw = mysqli_fetch_array($getacct1);
  $staff_id = $uw["id"];
  $staff_email = $uw["email"];
  echo $staff_id . "STAFF";
}
$staff_name  = strtoupper($_SESSION["username"]);
?>
<?php
$test = $_POST['test'];
$acct_no = $_POST['account_no'];
$amt = $_POST['amount'];
$type = $_POST['pay_type'];
$transid = $_POST['transid'];
$description = $_POST['description'];
// variable for second which is withdrawal
$test2 = $_POST['test'];
$acct_no2 = $_POST['account_no'];
$account_display = substr("$acct_no", 7) . "*****" . substr("$acct_no", 8);
$amt2 = $_POST['amount'];
$type2 = $_POST['pay_type'];
$appuser_id = $_SESSION['user_id'];
// $branch_id = $_SESSION['branch_id'];
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
// 1234567890
// fetch the clients account
$account = $_POST['account_no'];
// $fdi = "SELECT * FROM account WHERE account_no = '$account' AND int_id = '$sessint_id'";
// $dfo = mysqli_query($connection, $fdi);
// $fodp = mysqli_fetch_array($dfo);
// $ds = $fodp['status'];

// move
$getacct = mysqli_query($connection, "SELECT * FROM account WHERE account_no = '$acct_no' && int_id = '$sessint_id'");
if (count([$getacct]) == 1) {
  $y = mysqli_fetch_array($getacct);
  $branch_id = $_SESSION["branch_id"];
  $acct_no = $y['account_no'];
  $tryacc = $y['account_no'];
  // get the savings product id
  $sproduct_id = $y['product_id'];
  $client_id = $y['client_id'];
  $client_acct_bal = $y['account_balance_derived'];
  $tbd = $y['total_deposits_derived'] + $amt;
  $tbd2 = $y['total_withdrawals_derived'] + $amt2;
  $comp = $amt + $client_acct_bal;
  $numberacct = number_format("$comp", 2);
  $comp2 = $client_acct_bal - $amt2;
  $numberacct2 = number_format("$comp2", 2);
  $trans_type = "credit";
  $trans_type2 = "debit";
  $irvs = 0;
  // $space = 10;
  // $randms2 = str_pad(rand(0, pow(10, $space)-1), $space, '0', STR_PAD_LEFT);
  // $transid = $randms2;
  // $gen_date = date('Y-m-d H:i:s');
  $gen_date = $_POST['transDate'];
  $pint = date('Y-m-d H:i:s');
  $gends = date('Y-m-d h:i:sa');
  // we will call the institution account
  $damn = mysqli_query($connection, "SELECT * FROM institution_account WHERE int_id = '$sessint_id' && teller_id = '$staff_id' OR submittedon_userid = '$staff_id'");
  if (mysqli_num_rows($damn) > 0) {
    $x = mysqli_fetch_array($damn);
    $int_acct_bal = $x['account_balance_derived'];
    $tbdx = $x['total_deposits_derived'] + $amt;
    $tbd2x = $x['total_withdrawals_derived'] + $amt2;
    $new_int_bal = $amt + $int_acct_bal;
    $new_int_bal2 = $int_acct_bal - $amt2;
  } else {
    echo "No Account Found";
  }

  $dbclient = mysqli_query($connection, "SELECT * FROM client WHERE id = '$client_id' && int_id = '$sessint_id'");
  if (count([$dbclient]) == 1) {
    $a = mysqli_fetch_array($dbclient);
    // $branch_id = $a['branch_id'];
    $clientt_name = $a['firstname'] . ' ' . $a['middlename'] . ' ' . $a['lastname'];
    $clientt_name = strtoupper($clientt_name);
    $client_email = $a["email_address"];
    $client_phone = $a["mobile_no"];
    $client_sms = $a["SMS_ACTIVE"];
  }
}

if ($client_id != "" && $acct_no != "" || $acct_no2 != "" && $staff_id != "") {

  // we will write a query to check if this person posting is a teller and has not been restricted
  // a condition to post the amount if it less or equal to the post - limit of the teller.

  $taketeller = "SELECT * FROM tellers WHERE name = '$staff_id' && int_id = '$sessint_id'";
  $check_me_men = mysqli_query($connection, $taketeller);
  if (mysqli_num_rows($check_me_men) > 0) {
    $ex = mysqli_fetch_array($check_me_men);
    $is_del = $ex["is_deleted"];
    $till = $ex["till"];
    $post_limit = $ex["post_limit"];
    $till_no = $ex["till_no"];
    $till_name = $ex["name"];

    $pay_type = "SELECT * FROM payment_type WHERE int_id = '$sessint_id' AND id ='$type'";
    $pay_query = mysqli_query($connection, $pay_type);
    $r = mysqli_fetch_array($pay_query);
    $isbank = $r['is_bank'];
    $glcode = $r['gl_code'];


    // we will call the GL
    $gl_man = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE gl_code = '$glcode' && int_id = '$sessint_id'");
    $gl = mysqli_fetch_array($gl_man);
    $l_acct_bal = $gl["organization_running_balance_derived"];
    $parent = $gl["parent_id"];
    // add if before anything


    $new_gl_bal = $l_acct_bal + $amt;
    $new_gl_bal2 = $l_acct_bal - $amt2;
    // checking if the teller is not deleted

    // checke three places to see if the transaction has been done
    $q1 = mysqli_query($connection, "SELECT * FROM `institution_account_transaction` WHERE transaction_id = '$transid' && int_id='$sessint_id'");
    $q2 = mysqli_query($connection, "SELECT * FROM `account_transaction` WHERE transaction_id = '$transid' && int_id='$sessint_id'");
    $q3 = mysqli_query($connection, "SELECT * FROM `transact_cache` WHERE transact_id = '$transid' && int_id='$sessint_id'");
    // run the query
    $resx1 = mysqli_num_rows($q1);
    $resx2 = mysqli_num_rows($q2);
    $resx3 = mysqli_num_rows($q3);
    // we will execute the statement
    $account_display = substr("$acct_no", 0, 3) . "*****" . substr("$acct_no", 8);
?>
    <input type="text" id="s_int_id" value="<?php echo $sessint_id; ?>" hidden>
    <input type="text" id="s_acct_nox" value="<?php echo $acct_no; ?>" hidden>
    <input type="text" id="s_branch_id" value="<?php echo $branch_id; ?>" hidden>
    <input type="text" id="s_sender_id" value="<?php echo $sender_id; ?>" hidden>
    <input type="text" id="s_phone" value="<?php echo $client_phone; ?>" hidden>
    <input type="text" id="s_client_id" value="<?php echo $client_id; ?>" hidden>
    <input type="text" id="s_acct_no" value="<?php echo $acct_display; ?>" hidden>
    <input type="text" id="s_int_name" value="<?php echo $int_name; ?>" hidden>
    <div id="make_display"></div>
    <?php
    // your daddy
    if ($resx1 == 0 && $resx2 == 0 && $resx3 == 0) {
      // check if exsist
      if ($is_del == "0" && $is_del != NULL) {
        if ($amt2 <= $post_limit && $test == "deposit") {
          // check if the teller posting limit matches in the range of the withdrawal amount
          //  check accoutn
          if ($acct_no == $tryacc) {
            // after checkng if number exsitsi
            if ($test == "deposit") {
              // update the clients account
              $new_abd = $comp;
              $iupq = "UPDATE account SET account_balance_derived = '$new_abd', updatedon_date = '$tday', last_deposit = '$amt', total_deposits_derived = '$tbd' WHERE account_no = '$acct_no' && int_id = '$sessint_id'";
              $iupqres = mysqli_query($connection, $iupq);
              if ($iupqres) {
                // update the clients transaction
                $iat = "INSERT INTO account_transaction (int_id, branch_id,
        account_no, product_id, teller_id,
        client_id, transaction_id, description, transaction_type, is_reversed,
        transaction_date, amount, running_balance_derived, overdraft_amount_derived,
        created_date, appuser_id, credit) VALUES ('{$sessint_id}', '{$branch_id}',
        '{$acct_no}', '{$sproduct_id}', '{$staff_id}', '{$client_id}', '{$transid}', '{$description}', '{$trans_type}', '{$irvs}',
        '{$gen_date}', '{$amt}', '{$new_abd}', '{$amt}',
        '{$gen_date}', '{$appuser_id}', {$amt})";
                $res3 = mysqli_query($connection, $iat);
                if ($res3) {
                  // amen BEGINNING
                  // MAKING A MOVE
                  // get the loan in arrears
                  $select_arrear = mysqli_query($connection, "SELECT * FROM `loan_arrear` WHERE client_id = '$client_id' AND int_id = '$sessint_id' AND installment >= '1' ORDER BY id ASC LIMIT 1");
                  // QWERTY
                  $gas = mysqli_fetch_array($select_arrear);
                  $a_id = $gas["id"];
                  $a_int_id = $gas["int_id"];
                  $a_loan_id = $gas["loan_id"];
                  $select_l = mysqli_query($connection, "SELECT * FROM 'loan' WHERE id = '$a_loan_id' AND int_id = '$sessint_id'");
                  $lm = mysqli_fetch_array($select_l);
                  // get id
                  $loan_product_id = $lm["product_id"];
                  $current_out_loan = $lm["total_outstanding_derived"];
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
                  $ppid = $igdb["parent_id"];
                  $ppd = $gdb["parent_id"];
                  // AFTER RUNING
                  // ALRIGHT WE MOVING
                  if ($amt >= $loan_amount) {
                    // ok good
                    $update_arrear = mysqli_query($connection, "UPDATE `loan_arrear` SET principal_amount = '0.00', interest_amount = '0.00', installment = '0' WHERE id = '$a_id' AND int_id = '$a_int_id' AND client_id = '$client_id'");
                    // check out the update
                    if ($update_arrear) {
                      //   $loan_bal = $amt / 2;
                      // $loan_bal_prin = $a_principal;
                      // $loan_bal_int = $a_interest;
                      // OK NOW RUN A FUNCTION.
                      $updated_loan_port = $newbalport + $a_principal;
                      $intloan_port = $intbalport + $a_interest;
                      $collection_principal = $a_principal;
                      $collection_interest = $a_interest;
                      $update_the_loan = mysqli_query($connection, "UPDATE `acc_gl_account` SET organization_running_balance_derived = '$updated_loan_port' WHERE int_id ='$sessint_id' AND gl_code = '$loan_port'");

                      // Update outstanding loan Balance
                      // Qwerty
                      if ($update_the_loan) {
                        // damn with
                        $insert_loan_port = mysqli_query($connection, "INSERT INTO `gl_account_transaction` (`int_id`, `branch_id`, `gl_code`, `parent_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`,
                 `amount`, `gl_account_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`) 
                VALUES ('{$sessint_id}', '{$branch_id}', '{$loan_port}', '{$ppid}', '{$transid}', 'Loan Repayment Principal / {$clientt_name}', 'Loan Repayment Principal', '0', '0', '{$gen_date}',
                 '{$collection_principal}', '{$updated_loan_port}', '{$updated_loan_port}', '{$gen_date}', '0', '0', '{$gen_date}', '0', '{$collection_principal}', '0.00')");
                        if ($insert_loan_port) {
                          //  go for the interest
                          $update_the_int_loan = mysqli_query($connection, "UPDATE acc_gl_account SET organization_running_balance_derived = '$intloan_port' WHERE int_id = '$sessint_id' AND gl_code ='$int_loan_port'");
                          if ($update_the_int_loan) {
                            $insert_i_port = mysqli_query($connection, "INSERT INTO `gl_account_transaction` (`int_id`, `branch_id`, `gl_code`, `parent_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`,
             `amount`, `gl_account_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`) 
            VALUES ('{$sessint_id}', '{$branch_id}', '{$int_loan_port}', '{$ppd}', '{$transid}', 'Loan Repayment Interest / {$clientt_name}', 'Loan Repayment Interest', '0', '0', '{$gen_date}',
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
                  } else if ($amt < $loan_amount) {
                    // ok nice
                    $loan_bal = $amt / 2;
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
                      // Update outstanding loan Balance
                      $new_out_loan = $current_out_loan - $updated_loan_port;
                      $update_olb = mysqli_query($connection, "UPDATE loan SET total_outstanding_derived = '$new_out_loan' WHERE id = '$a_loan_id' AND int_id = '$sessint_id'");
                      // Qwerty

                      if ($update_the_loan) {
                        // damn with
                        $insert_loan_port = mysqli_query($connection, "INSERT INTO `gl_account_transaction` (`int_id`, `branch_id`, `gl_code`, `parent_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`,
                 `amount`, `gl_account_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`) 
                VALUES ('{$sessint_id}', '{$branch_id}', '{$loan_port}', '{$ppid}', '{$transid}', 'Loan Repayment Principal / {$clientt_name}', 'Loan Repayment Principal', '0', '0', '{$gen_date}',
                 '{$collection_principal}', '{$updated_loan_port}', '{$updated_loan_port}', '{$gen_date}', '0', '0', '{$gen_date}', '0', '{$collection_principal}', '0.00')");
                        if ($insert_loan_port) {
                          //  go for the interest
                          $update_the_int_loan = mysqli_query($connection, "UPDATE acc_gl_account SET organization_running_balance_derived = '$intloan_port' WHERE int_id = '$sessint_id' AND gl_code ='$int_loan_port'");
                          if ($update_the_int_loan) {
                            $insert_i_port = mysqli_query($connection, "INSERT INTO `gl_account_transaction` (`int_id`, `branch_id`, `gl_code`, `parent_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`,
             `amount`, `gl_account_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`) 
            VALUES ('{$sessint_id}', '{$branch_id}', '{$int_loan_port}', '{$ppd}', '{$transid}', 'Loan Repayment Interest / {$clientt_name}', 'Loan Repayment Interest', '0', '0', '{$gen_date}',
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
                  // END THE TRANSACTION
                  // ENDING OF THE AR
                  if ($isbank == 1) {
                    // update the GL
                    $upglacct = "UPDATE `acc_gl_account` SET `organization_running_balance_derived` = '$new_gl_bal' WHERE int_id = '$sessint_id' && gl_code = '$glcode'";
                    $dbgl = mysqli_query($connection, $upglacct);
                    if ($dbgl) {
                      $gl_acc = "INSERT INTO gl_account_transaction (int_id, branch_id, gl_code, parent_id, transaction_id, description,
                transaction_type, teller_id, transaction_date, amount, gl_account_balance_derived, overdraft_amount_derived,
                  created_date, credit) VALUES ('{$sessint_id}', '{$branch_id}', '{$glcode}', '{$parent}', '{$transid}', '{$description}', '{$trans_type}', '{$staff_id}',
                   '{$gen_date}', '{$amt}', '{$new_gl_bal}', '{$amt}', '{$gen_date}', '{$amt}')";
                      $res4 = mysqli_query($connection, $gl_acc);
                    }
                  } else if ($isbank == 0) {
                    // update the institution account
                    $iupq2 = "UPDATE institution_account SET account_balance_derived = '$new_int_bal', total_deposits_derived = '$tbdx' WHERE int_id = '$sessint_id' && teller_id = '$staff_id'";
                    $iupqres2 = mysqli_query($connection, $iupq2);
                    if ($iupqres2) {
                      $iat2 = "INSERT INTO institution_account_transaction (int_id, branch_id,
          client_id, transaction_id, description, transaction_type, teller_id, is_reversed,
          transaction_date, amount, running_balance_derived, overdraft_amount_derived,
          created_date, appuser_id, credit) VALUES ('{$sessint_id}', '{$branch_id}',
          '{$client_id}', '{$transid}','{$description}', '{$trans_type}', '{$staff_id}', '{$irvs}',
          '{$gen_date}', '{$amt}', '{$new_int_bal}', '{$amt}',
          '{$gen_date}', '{$appuser_id}', '{$amt}')";
                      $res4 = mysqli_query($connection, $iat2);
                    }
                  }
                  if ($res4) {
                    $findSavingsGl = selectOne('savings_acct_rule', ['savings_product_id' => $sproduct_id, 'int_id' => $sessint_id]);
                    $savingsGlcode = $findSavingsGl['asst_loan_port'];
                    $savingsGlConditions = [
                      'int_id' => $sessint_id,
                      'gl_code' => $savingsGlcode
                    ];
                    $findGl = selectOne('acc_gl_account', $savingsGlConditions);
                    $glBalance = $findGl['organization_running_balance_derived'];
                    $glSavingsID = $findGl['id'];
                    $glSavingsParent = $findGl['parent_id'];
                    // $conditionsGlUpdate = [
                    //     'int_id' => $institutionId,
                    //     'gl_code' => $savingsGlcode
                    // ];
                    $newGlBalnce = $glBalance + $amt;
                    $updateSavingsGlDetails = [
                      'organization_running_balance_derived' => $newGlBalnce
                    ];
                    $updateSavingsGlBalance = update('acc_gl_account', $glSavingsID, 'id', $updateSavingsGlDetails);
                    if ($updateSavingsGlBalance) {
                      $glSavingsTransactionDetails = [
                        'int_id' => $sessint_id,
                        'branch_id' => $branch_id,
                        'gl_code' => $savingsGlcode,
                        'parent_id' => $glSavingsParent,
                        'transaction_id' => $transid,
                        'description' => $description,
                        'transaction_type' => "credit",
                        'transaction_date' => $gen_date,
                        'amount' => $amt,
                        'gl_account_balance_derived' => $newGlBalnce,
                        'overdraft_amount_derived' => $amt,
                        'cumulative_balance_derived' => $newGlBalnce,
                        'credit' => $amt
                      ];
                      $storeSavingsGlTransaction = insert('gl_account_transaction', $glSavingsTransactionDetails);
                      if (!$storeSavingsGlTransaction) {
                        printf("<br>1-Error: \n", mysqli_error($connection)); //checking for errors
                        exit();
                      } else {
                        echo "Credit Success <br>";
                      }
                    }
                    if ($client_sms == "1") {
                      // message to be sent
                      $trans_type = "Credit";
                      $balance = number_format($comp, 2);
                      $msg = "$int_name $trans_type \n Amt: NGN {$amt} \n Acct: {$acct_no}\nDesc: {$description} \nBal: {$balance} \nAvail: {$balance}\nDate: {$pint}\nThanks!";
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
                                                        "text": "' . $msg . '",
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
                          } else {
                            $obj = json_decode($response, TRUE);
                            $status = $obj['response'];
                            // check for success response
                            if ($status != "") {
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
                    // aomkjjkk
                    $mail = new PHPMailer;
                    $mail->From = $int_email;
                    $mail->FromName = $int_name;
                    $mail->addAddress($client_email, $clientt_name);
                    $mail->addReplyTo($int_email, "No Reply");
                    $mail->isHTML(true);
                    $mail->Subject = "Transaction Alert from $int_name";
                    $mail->Body = "<!DOCTYPE html>
          <html>
              <head>
              <style>
              .lon{
                height: 100%;
                  background-color: #eceff3;
                  font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
              }
              .main{
                  margin-right: auto;
                  margin-left: auto;
                  width: 550px;
                  height: auto;
                  background-color: white;
  
              }
              .header{
                  margin-right: auto;
                  margin-left: auto;
                  width: 550px;
                  height: auto;
                  background-color: white;
              }
              .logo{
                  margin-right:auto;
                  margin-left: auto;
                  width:auto;
                  height: auto;
                  background-color: white;
  
              }
              .text{
                  padding: 20px;
                  font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
              }
              table{
                  padding:30px;
                  width: 100%;
              }
              table td{
                  font-size: 15px;
                  color:rgb(65, 65, 65);
              }
          </style>
              </head>
              <body>
                <div class='lon'>
                  <div class='header'>
                    <div class='logo'>
                    <img  style='margin-left: 200px; margin-right: auto; height:150px; width:150px;'class='img' src= '$int_logo'/>
                </div>
            </div>
                <div class='main'>
                    <div class='text'>
                        Dear $clientt_name,
                        <h2 style='text-align:center;'>Notification of Credit Alert</h2>
                        this is to notify you of an incoming credit to your account $acct_no,
                        Kindly confirm with your bank.<br/><br/>
                         Please see the details below
                    </div>
                    <table>
                        <tbody>
                            <div>
                          <tr>
                            <td> <b >Account Number</b></td>
                            <td >$account_display</td>
                          </tr>
                          <tr>
                            <td > <b>Account Name</b></td>
                            <td >$clientt_name</td>
                          </tr>
                          <tr>
                            <td > <b>Reference</b></td>
                            <td >$description</td>
                          </tr>
                          <tr>
                            <td > <b>Reference Id</b></td>
                            <td >$transid</td>
                          </tr>
                          <tr>
                            <td> <b>Transaction Amount</b></td>
                            <td>$amt</td>
                          </tr>
                          <tr>
                            <td> <b>Transaction Date/Time</b></td>
                            <td>$gen_date</td>
                          </tr>
                          <tr>
                            <td> <b>Value Date</b></td>
                            <td>$gends</td>
                          </tr>
                          <tr>
                            <td> <b>Account Balance</b></td>
                            <td>&#8358; $numberacct</td>
                          </tr>
                        </tbody>
                        <!-- Optional JavaScript -->
                        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
                        <script src='https://code.jquery.com/jquery-3.4.1.slim.min.js' integrity='sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n' crossorigin='anonymous'></script>
                        <script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js' integrity='sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo' crossorigin='anonymous'></script>
                        <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js' integrity='sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6' crossorigin='anonymous'></script>
                      </body>
                    </table>
                </div>
                </div>
              </body>
          </html>";
                    $mail->AltBody = "This is the plain text version of the email content";
                    // mail system
                    if (!$mail->send()) {
                      echo "Mailer Error: " . $mail->ErrorInfo;
                      $_SESSION["Lack_of_intfund_$randms"] = "Deposit Successful";
                      echo header("Location: ../../mfi/transact.php?message0=$randms");
                    } else {
                      $_SESSION["Lack_of_intfund_$randms"] = "Deposit Has Been Done, Awaiting Approval!";
                      echo header("Location: ../../mfi/transact.php?messagep=$randms");
                    }

                    // sends a mail first
                  } else {
                    // echo error in the gl
                    $_SESSION["Lack_of_intfund_$randms"] = "Transaction Failed";
                    echo header("Location: ../../mfi/transact.php?legal=$randms");
                  }
                } else {
                  // echo error at the clients transaction
                  $_SESSION["Lack_of_intfund_$randms"] = "Transaction Failed";
                  echo header("Location: ../../mfi/transact.php?legal=$randms");
                }
              } else {
                // echo error at clients transaction
                $_SESSION["Lack_of_intfund_$randms"] = "Transaction Failed";
                echo header("Location: ../../mfi/transact.php?legal=$randms");
              }
            }
          } else {
            // display wrong acount number
            $_SESSION["Lack_of_intfund_$randms"] = "Account not Found";
            echo header("Location: ../../mfi/transact.php?message7=$randms");
          }
        } else if ($amt2 > $post_limit && $test == "deposit") {
          $new_abd = $comp;
          $runaccount = mysqli_query($connection, "SELECT * FROM account WHERE account_no ='$acct_no' && int_id = '$sessint_id' ");
          if (count([$runaccount]) == 1) {
            $x = mysqli_fetch_array($runaccount);
            $brnid = $x['branch_id'];
            $tryacc = $x['account_no'];
            $product_id = $x['product_id'];
            $acct_b_d = $x['account_balance_derived'];
            $client_id = $x['client_id'];

            $clientfn =  mysqli_query($connection, "SELECT client.id, client.firstname, client.middlename, client.lastname FROM client JOIN account ON account.client_id = client.id && account.account_no ='$acct_no' && client.int_id = '$sessint_id' ");
            if (count([$clientfn]) == 1) {
              $py = mysqli_fetch_array($clientfn);
              $clientt_name = $py['firstname'] . ' ' . $py['middlename'] . ' ' . $py['lastname'];
              $clientt_name = strtoupper($clientt_name);
              $brh = $py['branch_id'];
              $nin = mysqli_query($connection, "SELECT name FROM branch WHERE id ='$brh'");
              if (count([$nin]) == 1) {
                $g = mysqli_fetch_array($nin);
                $branch_name = $g['name'];
              }
            }
            if ($acct_no == $tryacc) {
              if ($test == "deposit") {
                $dd = "Deposit";
                $ogs = "Pending";
                $trancache = "INSERT INTO transact_cache (int_id, branch_id, transact_id, description, account_no, client_id, client_name, staff_id, account_off_name, amount, pay_type, transact_type, product_type, status, date, is_bank, bank_gl_code)
               VALUES ('{$sessint_id}', '{$branch_id}', '{$transid}', '{$description}', '{$acct_no}', '{$client_id}', '{$clientt_name}', '{$staff_id}', '{$staff_name}', '{$amt}', '{$type}', '{$dd}', '{$product_id}', '{$ogs}', '{$gen_date}', '{$isbank}', '{$glcode}')";
                $go = mysqli_query($connection, $trancache);
                if ($go) {
                  $_SESSION["Lack_of_intfund_$randms"] = "Transaction Failed";
                  echo header("Location: ../../mfi/transact.php?message=$randms");
                } else {
                  $_SESSION["Lack_of_intfund_$randms"] = "Transaction Failed";
                  echo header("Location: ../../mfi/transact.php?message2=$randms");
                }
              } else {
                echo "Not equal to deposit";
              }
            } else {
              $_SESSION["Lack_of_intfund_$randms"] = "Account not Found";
              echo header("Location: ../../mfi/transact.php?message7=$randms");
            }
          }
        } else if ($test == "withdraw") {
          // check if the POSTING-LIMIT
          if ($isbank == 1) {
            $int_acct_bal = $l_acct_bal;
          } else if ($isbank == 0) {
            $int_acct_bal = $int_acct_bal;
          }
          // dd($int_acct_bal);
          if ($int_acct_bal >= $amt2) {
            // check if client has cash
            if ($client_acct_bal >=  $amt2) {
              if ($amt2 <= $post_limit) {
                // update the clients account
                $new_abd2 = $comp2;
                $iupq = "UPDATE account SET account_balance_derived = '$new_abd2', updatedon_date = '$tday',
            last_withdrawal = '$amt', total_withdrawals_derived = '$tbd2' WHERE account_no = '$acct_no' && int_id = '$sessint_id'";
                $iupqres = mysqli_query($connection, $iupq);
                // update the clients transaction
                if ($iupqres) {
                  $iat = "INSERT INTO account_transaction (int_id, branch_id,
            account_no, product_id, teller_id,
            client_id, transaction_id, description, transaction_type, is_reversed,
            transaction_date, amount, running_balance_derived, overdraft_amount_derived,
            created_date, appuser_id, debit) VALUES ('{$sessint_id}', '{$branch_id}',
            '{$acct_no}', '{$sproduct_id}', '{$staff_id}', '{$client_id}', '{$transid}', '{$description}', '{$trans_type2}', '{$irvs}',
            '{$gen_date}', '{$amt2}', '{$new_abd2}', '{$amt}',
            '{$gen_date}', '{$appuser_id}', '{$amt2}')";
                  $res3 = mysqli_query($connection, $iat);
                  if ($res3) {
                    if ($isbank == 1) {
                      // update the GL
                      $upglacct = "UPDATE `acc_gl_account` SET `organization_running_balance_derived` = '$new_gl_bal2' WHERE int_id = '$sessint_id' && gl_code = '$glcode'";
                      $dbgl = mysqli_query($connection, $upglacct);
                      if ($dbgl) {
                        $gl_acc = "INSERT INTO gl_account_transaction (int_id, branch_id, gl_code, parent_id, transaction_id, description,
                                  transaction_type, teller_id, transaction_date, amount, gl_account_balance_derived, overdraft_amount_derived,
                                    created_date, debit) VALUES ('{$sessint_id}', '{$branch_id}', '{$glcode}', '{$parent}','{$transid}', '{$description}', '{$trans_type}', '{$staff_id}',
                                    '{$gen_date}', '{$amt}', '{$new_gl_bal2}', '{$amt}', '{$gen_date}', '{$amt}')";
                        $res4 = mysqli_query($connection, $gl_acc);
                      }
                    } else if ($isbank == 0) {
                      // update the institution account
                      $iupq2 = "UPDATE institution_account SET account_balance_derived = '$new_int_bal', total_deposits_derived = '$tbdx' WHERE int_id = '$sessint_id' && teller_id = '$staff_id'";
                      $iupqres2 = mysqli_query($connection, $iupq2);
                      if ($iupqres2) {
                        $iat2 = "INSERT INTO institution_account_transaction (int_id, branch_id,
                        client_id, transaction_id, description, transaction_type, teller_id, is_reversed,
                        transaction_date, amount, running_balance_derived, overdraft_amount_derived,
                        created_date, appuser_id, debit) VALUES ('{$sessint_id}', '{$branch_id}',
                        '{$client_id}', '{$transid}','{$description}', '{$trans_type}', '{$staff_id}', '{$irvs}',
                        '{$gen_date}', '{$amt}', '{$new_int_bal}', '{$amt}',
                        '{$gen_date}', '{$appuser_id}', '{$amt}')";
                        $res4 = mysqli_query($connection, $iat2);
                      }
                    } else if ($isbank == 2) {
                      $upglacct = "UPDATE `acc_gl_account` SET `organization_running_balance_derived` = '$new_gl_bal2' WHERE int_id = '$sessint_id' && gl_code = '$glcode'";
                      $dbgl = mysqli_query($connection, $upglacct);
                      if ($dbgl) {
                        $gl_acc = "INSERT INTO gl_account_transaction (int_id, branch_id, gl_code, parent_id, transaction_id, description,
                                  transaction_type, teller_id, transaction_date, amount, gl_account_balance_derived, overdraft_amount_derived,
                                    created_date, debit) VALUES ('{$sessint_id}', '{$branch_id}', '{$glcode}', '{$parent}','{$transid}', '{$description}', '{$trans_type}', '{$staff_id}',
                                    '{$gen_date}', '{$amt}', '{$new_gl_bal2}', '{$amt}', '{$gen_date}', '{$amt}')";
                        $res4 = mysqli_query($connection, $gl_acc);
                      }
                    }

                    if ($res4) {
                      // DO THE ACCOUNT CHARGE
                      $findSavingsGl = selectOne('savings_acct_rule', ['savings_product_id' => $sproduct_id, 'int_id' => $sessint_id]);
                        $savingsGlcode = $findSavingsGl['asst_loan_port'];
                        $savingsGlConditions = [
                          'int_id' => $sessint_id,
                          'gl_code' => $savingsGlcode
                        ];
                        $findGl = selectOne('acc_gl_account', $savingsGlConditions);
                        $glBalance = $findGl['organization_running_balance_derived'];
                        $glSavingsID = $findGl['id'];
                        $glSavingsParent = $findGl['parent_id'];
                        // $conditionsGlUpdate = [
                        //     'int_id' => $institutionId,
                        //     'gl_code' => $savingsGlcode
                        // ];
                        $newGlBalnce = $glBalance - $amt;
                        $updateSavingsGlDetails = [
                          'organization_running_balance_derived' => $newGlBalnce
                        ];
                        $updateSavingsGlBalance = update('acc_gl_account', $glSavingsID, 'id', $updateSavingsGlDetails);
                        if ($updateSavingsGlBalance) {
                          $glSavingsTransactionDetails = [
                            'int_id' => $sessint_id,
                            'branch_id' => $branch_id,
                            'gl_code' => $savingsGlcode,
                            'parent_id' => $glSavingsParent,
                            'transaction_id' => $transid,
                            'description' => $description,
                            'transaction_type' => "debit",
                            'transaction_date' => $gen_date,
                            'amount' => $amt,
                            'gl_account_balance_derived' => $newGlBalnce,
                            'overdraft_amount_derived' => $amt,
                            'cumulative_balance_derived' => $newGlBalnce,
                            'debit' => $amt
                          ];
                          $storeSavingsGlTransaction = insert('gl_account_transaction', $glSavingsTransactionDetails);
                          if (!$storeSavingsGlTransaction) {
                            printf("<br>1-Error: \n", mysqli_error($connection)); //checking for errors
                            exit();
                          } else {
                            echo "Debit Success <br>";
                          }
                        }
                      if ($client_sms == "1") {
                        $findSavingsGl = selectOne('savings_acct_rule', ['savings_product_id' => $sproduct_id, 'int_id' => $sessint_id]);
                        $savingsGlcode = $findSavingsGl['asst_loan_port'];
                        $savingsGlConditions = [
                          'int_id' => $sessint_id,
                          'gl_code' => $savingsGlcode
                        ];
                        $findGl = selectOne('acc_gl_account', $savingsGlConditions);
                        $glBalance = $findGl['organization_running_balance_derived'];
                        $glSavingsID = $findGl['id'];
                        $glSavingsParent = $findGl['parent_id'];
                        // $conditionsGlUpdate = [
                        //     'int_id' => $institutionId,
                        //     'gl_code' => $savingsGlcode
                        // ];
                        $newGlBalnce = $glBalance - $amt;
                        $updateSavingsGlDetails = [
                          'organization_running_balance_derived' => $newGlBalnce
                        ];
                        $updateSavingsGlBalance = update('acc_gl_account', $glSavingsID, 'id', $updateSavingsGlDetails);
                        if ($updateSavingsGlBalance) {
                          $glSavingsTransactionDetails = [
                            'int_id' => $sessint_id,
                            'branch_id' => $branch_id,
                            'gl_code' => $savingsGlcode,
                            'parent_id' => $glSavingsParent,
                            'transaction_id' => $transid,
                            'description' => $description,
                            'transaction_type' => "debit",
                            'transaction_date' => $gen_date,
                            'amount' => $amt,
                            'gl_account_balance_derived' => $newGlBalnce,
                            'overdraft_amount_derived' => $amt,
                            'cumulative_balance_derived' => $newGlBalnce,
                            'debit' => $amt
                          ];
                          $storeSavingsGlTransaction = insert('gl_account_transaction', $glSavingsTransactionDetails);
                          if (!$storeSavingsGlTransaction) {
                            printf("<br>1-Error: \n", mysqli_error($connection)); //checking for errors
                            exit();
                          } else {
                            echo "Credit Success <br>";
                          }
                        }
                        $trans_type = "Debit";
                        $balance = number_format($comp2, 2);
                        $msg = "$int_name $trans_type \n Amt: NGN {$amt} \n Acct: {$acct_no}\nDesc: {$description} \nBal: {$balance} \nAvail: {$balance}\nDate: {$pint}\nThanks!";
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
                          $sql_fund = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$sessint_id'");
                          $qw = mysqli_fetch_array($sql_fund);
                          $smsBalance = $qw["sms_balance"];
                          $total_with = $qw["total_withdrawal"];
                          $total_int_profit = $qw["int_profit"];
                          $total_sekani_charge = $qw["sekani_charge"];
                          $total_merchant_charge = $qw["merchant_charge"];
                          if ($smsBalance >= 4) {

                            $curl = curl_init();

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
                                                        "text": "' . $msg . '",
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
                            } else {
                              $obj = json_decode($response, TRUE);
                              $status = $obj['response'];
                              // check for success response
                              if ($status != "") {
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
                      // check the type of that account number product and get the name
                      // SEND THE MAIL
                      // END THE ACCOUNT CHARGE
                      $mail = new PHPMailer;
                      $mail->From = $int_email;
                      $mail->FromName = $int_name;
                      $mail->addAddress($client_email, $clientt_name);
                      $mail->addReplyTo($int_email, "No Reply");
                      $mail->isHTML(true);
                      $mail->Subject = "Transaction Alert from $int_name";
                      $mail->Body = "<!DOCTYPE html>
                        <html>
                            <head>
                            <style>
                            .lon{
                              height: 100%;
                                background-color: #eceff3;
                                font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                            }
                            .main{
                                margin-right: auto;
                                margin-left: auto;
                                width: 550px;
                                height: auto;
                                background-color: white;
                
                            }
                            .header{
                                margin-right: auto;
                                margin-left: auto;
                                width: 550px;
                                height: auto;
                                background-color: white;
                            }
                            .logo{
                                margin-right:auto;
                                margin-left: auto;
                                width:auto;
                                height: auto;
                                background-color: white;
                
                            }
                            .text{
                                padding: 20px;
                                font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                            }
                            table{
                                padding:30px;
                                width: 100%;
                            }
                            table td{
                                font-size: 15px;
                                color:rgb(65, 65, 65);
                            }
                        </style>
                            </head>
                            <body>
                              <div class='lon'>
                                <div class='header'>
                                  <div class='logo'>
                                  <img  style='margin-left: 200px; margin-right: auto; height:150px; width:150px;'class='img' src='$int_logo'/>
                              </div>
                          </div>
                              <div class='main'>
                                  <div class='text'>
                                      Dear $clientt_name,
                                      <h2 style='text-align:center;'>Notification of Debit Alert</h2>
                                      this is to notify you of an incoming debit to your account $acct_no,
                                      Kindly confirm with your bank.<br/><br/>
                                      Please see the details below
                                  </div>
                                  <table>
                                      <tbody>
                                          <div>
                                        <tr>
                                          <td> <b >Account Number</b></td>
                                          <td >$account_display</td>
                                        </tr>
                                        <tr>
                                          <td > <b>Account Name</b></td>
                                          <td >$clientt_name</td>
                                        </tr>
                                        <tr>
                                          <td > <b>Reference</b></td>
                                          <td >$description</td>
                                        </tr>
                                        <tr>
                                          <td > <b>Reference Id</b></td>
                                          <td >$transid</td>
                                        </tr>
                                        <tr>
                                          <td > <b>Transaction Amount</b></td>
                                          <td >$amt</td>
                                        </tr>
                                        <tr>
                                          <td > <b>Transaction Date/Time</b></td>
                                          <td >$gen_date</td>
                                        </tr>
                                        <tr>
                                          <td > <b>Value Date</b></td>
                                          <td >$gends</td>
                                        </tr>
                                        <tr>
                                          <td > <b>Account Balance</b></td>
                                          <td >&#8358; $numberacct</td>
                                        </tr>
                                      </tbody>
                                      <!-- Optional JavaScript -->
                                      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
                                      <script src='https://code.jquery.com/jquery-3.4.1.slim.min.js' integrity='sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n' crossorigin='anonymous'></script>
                                      <script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js' integrity='sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo' crossorigin='anonymous'></script>
                                      <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js' integrity='sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6' crossorigin='anonymous'></script>
                                    </body>
                                  </table>
                              </div>
                              </div>
                            </body>
                        </html>";
                      $mail->AltBody = "This is the plain text version of the email content";
                      // mail system
                      if (!$mail->send()) {
                        echo "Mailer Error: " . $mail->ErrorInfo;
                        $_SESSION["Lack_of_intfund_$randms"] = "Withdrawal Successful";
                        echo header("Location: ../../mfi/transact.php?message0=$randms");
                      } else {
                        $_SESSION["Lack_of_intfund_$randms"] = "Withdrawal Successful!";
                        echo header("Location: ../../mfi/transact.php?message3=$randms");
                      }
                      // sends a mail first
                    } else {
                      // echo error in the gl
                      $_SESSION["Lack_of_intfund_$randms"] = "Transaction Failed";
                      echo header("Location: ../../mfi/transact.php?message2=$randms");
                    }
                  } else {
                    // echo error in the gl
                    $_SESSION["Lack_of_intfund_$randms"] = "Transaction Failed";
                    echo header("Location: ../../mfi/transact.php?message2=$randms");
                  }
                } else {
                  // echo in account
                  $_SESSION["Lack_of_intfund_$randms"] = "Transaction Failed";
                  echo header("Location: ../../mfi/transact.php?legal=$randms");
                }
              } else if ($amt2 > $post_limit) {
                // post to for approval
                $runaccount = mysqli_query($connection, "SELECT * FROM account WHERE account_no='$acct_no2' && int_id = '$sessint_id' ");
                if (count([$runaccount]) == 1) {
                  $x = mysqli_fetch_array($runaccount);
                  $brnid = $x['branch_id'];
                  $tryacc = $x['account_no'];
                  $product_id = $x['product_id'];
                  $acct_b_d = $x['account_balance_derived'];
                  $client_id = $x['client_id'];

                  if ($acct_no2 == $tryacc) {
                    $clientfn =  mysqli_query($connection, "SELECT client.id, client.firstname, client.middlename, client.lastname FROM client JOIN account ON account.client_id = client.id && account.account_no ='$acct_no' && client.int_id = '$sessint_id' ");
                    if (count([$clientfn]) == 1) {
                      $py = mysqli_fetch_array($clientfn);
                      $clientt_name = $py['firstname'] . ' ' . $py['middlename'] . ' ' . $py['lastname'];
                      $clientt_name = strtoupper($clientt_name);
                    }
                    if ($test2 == "withdraw") {
                      if ($acct_b_d >= $amt2) {
                        $wd = "Withdrawal";
                        $gms = "Pending";
                        //  STOPPED HERE
                        $trancache = "INSERT INTO transact_cache (int_id, branch_id, transact_id, description, account_no, client_id, client_name, staff_id, account_off_name, amount, pay_type, transact_type, product_type, status, date, is_bank, bank_gl_code) VALUES
                    ('{$sessint_id}', '{$branch_id}', '{$transid}','{$description}', '{$acct_no2}', '{$client_id}', '{$clientt_name}', '{$staff_id}', '{$staff_name}', '{$amt2}', '{$type2}', '{$wd}', '{$sproduct_id}', '{$gms}', '{$gen_date}', '{$isbank}', '{$glcode}')";
                        $go = mysqli_query($connection, $trancache);
                        if ($go) {
                          $_SESSION["Lack_of_intfund_$randms"] = "Transaction Failed";
                          echo header("Location: ../../mfi/transact.php?message=$randms");
                        } else {
                          $_SESSION["Lack_of_intfund_$randms"] = "Withdrawal Failed";
                          echo header("Location: ../../mfi/transact.php?message4=$randms");
                        }
                      } else {
                        $_SESSION["Lack_of_intfund_$randms"] = "Failed - Insufficient Fund";
                        header("Location: ../../mfi/transact.php?message5=1");
                      }
                    } else {
                      echo "Test is Empty";
                    }
                  } else {
                    $_SESSION["Lack_of_intfund_$randms"] = "Account Not Found";
                    echo header("Location: ../../mfi/transact.php?message7=$randms");
                  }
                }
              } else {
                $_SESSION["Lack_of_intfund_$randms"] = "Account not Found";
                echo header("Location: ../../mfi/transact.php?message5=2");
              }
            } else {
              // echo error client has insufficient fund
              $_SESSION["Lack_of_intfund_$randms"] = "Failed - Insufficient Fund";
              header("Location: ../../mfi/transact.php?messagex5=$randms");
            }
          } else {
            $_SESSION["Lack_of_intfund_$randms"] = "Failed - Insufficient Fund";
            header("Location: ../../mfi/transact.php?message5=3");
          }
        } else {
          $_SESSION["Lack_of_intfund_$randms"] = "Failed - Insufficient Fund";
          header("Location: ../../mfi/transact.php?message5=4");
        }
      } else {
        // echo this teller is not authorized
        $_SESSION["Lack_of_intfund_$randms"] = "TELLER";
        echo header("Location: ../../mfi/transact.php?messagex2=$randms");
      }
    } else {
      $_SESSION["Lack_of_intfund_$randms"] = "System Error";
      echo header("Location: ../../mfi/transact.php?legalq=$randms");
    }
    // cont.
  } else {
    // you're not authorized not a teller
    $_SESSION["Lack_of_intfund_$randms"] = "TELLER";
    echo header("Location: ../../mfi/transact.php?messagex2=$randms");
    // remeber to fix account transaction for approval
  }
} else {
  // To Check if CLIENT EXIST
  $_SESSION["Lack_of_intfund_$randms"] = "TELLER";
  echo header("Location: ../../mfi/transact.php?message123=$randms");
}
?>
<?php
// qwerty
?>