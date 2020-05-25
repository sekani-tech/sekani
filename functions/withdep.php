<?php
include("connect.php");
session_start();
require_once "../bat/phpmailer/PHPMailerAutoload.php";
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
$getacct1 = mysqli_query($connection, "SELECT * FROM staff WHERE user_id = '$m_id' && int_id = '$sessint_id'");
if (count([$getacct1]) == 1) {
    $uw = mysqli_fetch_array($getacct1);
    $staff_id = $uw["id"];
    $staff_email = $uw["email"];
    echo $staff_id;
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
$account_display = substr("$acct_no",7)."*****".substr("$acct_no",8);
$amt2 = $_POST['amount'];
$type2 = $_POST['pay_type'];
$appuser_id = $_SESSION['user_id'];
// $branch_id = $_SESSION['branch_id'];
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
// 1234567890
// fetch the clients account
$getacct = mysqli_query($connection, "SELECT * FROM account WHERE account_no = '$acct_no' && int_id = '$sessint_id'");
if (count([$getacct]) == 1) {
$y = mysqli_fetch_array($getacct);
$branch_id = $y['branch_id'];
$acct_no = $y['account_no'];
$tryacc = $y['account_no'];
// get the savings product id
$sproduct_id = $y['product_id'];
$client_id = $y['client_id'];
$client_acct_bal = $y['account_balance_derived'];
$tbd = $y['total_deposits_derived'] + $amt;
$tbd2 = $y['total_withdrawals_derived'] + $amt2;
$comp = $amt + $client_acct_bal;
$numberacct = number_format("$comp",2);
$comp2 = $client_acct_bal - $amt2;
$numberacct2 = number_format("$comp2",2);
$trans_type = "credit";
$trans_type2 = "debit";
$irvs = 0;
// $space = 10;
// $randms2 = str_pad(rand(0, pow(10, $space)-1), $space, '0', STR_PAD_LEFT);
// $transid = $randms2;
$gen_date = date('Y-m-d H:i:s');
$gends = date('Y-m-d');
// we will call the institution account
$damn = mysqli_query($connection, "SELECT * FROM institution_account WHERE int_id = '$sessint_id' && teller_id = '$staff_id'");
    if (count([$damn]) == 1) {
        $x = mysqli_fetch_array($damn);
        $int_acct_bal = $x['account_balance_derived'];
        $tbdx = $x['total_deposits_derived'] + $amt;
        $tbd2x = $x['total_withdrawals_derived'] + $amt2;
        $new_int_bal = $amt + $int_acct_bal;
        $new_int_bal2 = $int_acct_bal - $amt2;
    }

$dbclient = mysqli_query($connection, "SELECT * FROM client WHERE id = '$client_id' && int_id = '$sessint_id'");
if (count([$dbclient]) == 1) {
    $a = mysqli_fetch_array($dbclient);
    $branch_id = $a['branch_id'];
    $clientt_name = $a['firstname'].' '.$a['middlename'].' '.$a['lastname'];
    $clientt_name = strtoupper($clientt_name);
    $client_email = $a["email_address"];
}
}

// we will write a query to check if this person posting is a teller and has not been restricted
// a condition to post the amount if it less or equal to the post - limit of the teller.

$taketeller = "SELECT * FROM tellers WHERE name = '$staff_id' && int_id = '$sessint_id'";
$check_me_men = mysqli_query($connection, $taketeller);
if ($check_me_men) {
    $ex = mysqli_fetch_array($check_me_men);
$is_del = $ex["is_deleted"];
$till = $ex["till"];
$post_limit = $ex["post_limit"];
$gl_code = $ex["till"];
$till_no = $ex["till_no"];
$till_name = $ex["name"];
// we will call the GL
$gl_man = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE gl_code = '$gl_code' && int_id = '$sessint_id'");
$gl = mysqli_fetch_array($gl_man);
$l_acct_bal = $gl["organization_running_balance_derived"];
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
        $iupq = "UPDATE account SET account_balance_derived = '$new_abd', last_deposit = '$amt', total_deposits_derived = '$tbd' WHERE account_no = '$acct_no' && int_id = '$sessint_id'";
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
        // update the institution account
        $iupq2 = "UPDATE institution_account SET account_balance_derived = '$new_int_bal', total_deposits_derived = '$tbdx' WHERE int_id = '$sessint_id' && teller_id = '$staff_id'";
        $iupqres2 = mysqli_query($connection, $iupq2);
        // update the institution transaction
        if ($iupqres2) {
            $iat2 = "INSERT INTO institution_account_transaction (int_id, branch_id,
        client_id, transaction_id, description, transaction_type, teller_id, is_reversed,
        transaction_date, amount, running_balance_derived, overdraft_amount_derived,
        created_date, appuser_id, credit) VALUES ('{$sessint_id}', '{$branch_id}',
        '{$client_id}', '{$transid}','{$description}', '{$trans_type}', '{$staff_id}', '{$irvs}',
        '{$gen_date}', '{$amt}', '{$new_int_bal}', '{$amt}',
        '{$gen_date}', '{$appuser_id}', '{$amt}')";
        $res4 = mysqli_query($connection, $iat2);
        if ($res4) {
        // update the GL
        $upglacct = "UPDATE `acc_gl_account` SET `organization_running_balance_derived` = '$new_gl_bal' WHERE int_id = '$sessint_id' && gl_code = '$till'";
        $dbgl = mysqli_query($connection, $upglacct);
        if ($dbgl) {
            // echo a successful message
            $mail = new PHPMailer;
            $mail->From = $int_email;
            $mail->FromName = $int_name;
            $mail->addAddress($client_email);
            $mail->addReplyTo($int_email, "No Reply");
            $mail->isHTML(true);
            $mail->Subject = "Transaction Alert from $int_name";
            $mail->Body = "<!doctype html>
            <html lang='en'>
              <head>
                <!-- Required meta tags -->
                <meta charset='utf-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
                <!-- Bootstrap CSS -->
                <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' integrity='sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh' crossorigin='anonymous'>
            
                <title>Transaction Alert</title>
              </head>
              <body>
                <div class='container'>
                    <div class='row justify-content-md-center'>
                      <div class='col col-lg-6'>
                        <div class='shadow p-3 mb-5 bg-white rounded'>
                            <!-- int logo -->
                            <div class='row justify-content-md-center'>
                                <img src='$int_logo' height='60px' width='60px' alt='int image' class='rounded mx-auto d-block'>
                                <div class='spinner-grow text-primary' role='status'>
                                    <span class='sr-only'>Loading...</span>
                                  </div>
                            </div>
                            <span> <b>$int_name</b> </span> || <span class='lead' style='font-size: 13px;'> $int_location </span>
                        </div>
                      </div>
                    </div>
                    <div class='row'>
                      <div class='col col-lg-12'>
                        <div class='shadow-sm p-3 mb-5 bg-white rounded'>$gen_date
                            <div>
                                <!-- fot the ext bod -->
                                <p><b>Dear $clientt_name</b></p>
                                <p>We wish to inform you that a <b>$trans_type</b> transaction recently occurred on your bank account.
                                Please find below details of the transaction:</p>
                            </div>
                            <p>
                                <div class='shadow p-3 mb-5 bg-white rounded'>Transaction Details - <b>$trans_type</b></div>
                                <table class='table table-borderless'>
                                    <tbody>
                                        <div>
                                      <tr>
                                        <td> <b style='font-size: 12px;'>Account Number</b></td>
                                        <td style='font-size: 12px;'>$account_display</td>
                                      </tr>
                                      <tr>
                                        <td style='font-size: 12px;'> <b>Account Name</b></td>
                                        <td style='font-size: 12px;'>$clientt_name</td>
                                      </tr>
                                      <tr>
                                        <td style='font-size: 12px;'> <b>Reference</b></td>
                                        <td style='font-size: 12px;'>$description</td>
                                      </tr>
                                      <tr>
                                        <td style='font-size: 12px;'> <b>Reference Id</b></td>
                                        <td style='font-size: 12px;'>$transid</td>
                                      </tr>
                                      <tr>
                                        <td style='font-size: 12px;'> <b>Transaction Amount</b></td>
                                        <td style='font-size: 12px;'>$amt</td>
                                      </tr>
                                      <tr>
                                        <td style='font-size: 12px;'> <b>Transaction Date/Time</b></td>
                                        <td style='font-size: 12px;'>$gen_date</td>
                                      </tr>
                                      <tr>
                                        <td style='font-size: 12px;'> <b>Value Date</b></td>
                                        <td style='font-size: 12px;'>$gends</td>
                                      </tr>
                                      <tr>
                                        <td style='font-size: 12px;'> <b>Account Balance</b></td>
                                        <td style='font-size: 12px;'>&#8358; $numberacct</td>
                                      </tr>
                                    </tbody>
                                </div>
                                  </table>
                            </p>
                            <button type='button' class='btn btn-primary btn-lg btn-block'> <b style='font-size: 15px;'>Print Account Statement</b></button>
                        </div>
                      </div>
                    </div>
                  </div>
                <!-- Optional JavaScript -->
                <!-- jQuery first, then Popper.js, then Bootstrap JS -->
                <script src='https://code.jquery.com/jquery-3.4.1.slim.min.js' integrity='sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n' crossorigin='anonymous'></script>
                <script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js' integrity='sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo' crossorigin='anonymous'></script>
                <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js' integrity='sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6' crossorigin='anonymous'></script>
              </body>
            </html>";
            $mail->AltBody = "This is the plain text version of the email content";
            // mail system
            if(!$mail->send()) 
               {
                   echo "Mailer Error: " . $mail->ErrorInfo;
                   $_SESSION["Lack_of_intfund_$randms"] = "Deposit Successful";
                   echo header ("Location: ../mfi/transact.php?message0=$randms");
               } else
               {
                   $_SESSION["Lack_of_intfund_$randms"] = "Deposit Successful";
                   echo header ("Location: ../mfi/transact.php?message=$randms");
               }
            // sends a mail first
        } else {
            // echo error in the gl
            $_SESSION["Lack_of_intfund_$randms"] = "Transaction Failed";
            echo header ("Location: ../mfi/transact.php?legal=$randms");
        }
        } else {
            // echo eror at the institution account transaction
            $_SESSION["Lack_of_intfund_$randms"] = "Transaction Failed";
            echo header ("Location: ../mfi/transact.php?legal=$randms");
        }
        } else {
            // echo error at the institution update
            $_SESSION["Lack_of_intfund_$randms"] = "Transaction Failed";
            echo header ("Location: ../mfi/transact.php?legal=$randms");
        }
        } else {
            // echo error at the clients transaction
            $_SESSION["Lack_of_intfund_$randms"] = "Transaction Failed";
            echo header ("Location: ../mfi/transact.php?legal=$randms");
        }
    } else {
        // echo error at clients transaction
        $_SESSION["Lack_of_intfund_$randms"] = "Transaction Failed";
        echo header ("Location: ../mfi/transact.php?legal=$randms");
    }
    } 
    } else {
      // display wrong acount number
      $_SESSION["Lack_of_intfund_$randms"] = "Account not Found";
      echo header ("Location: ../mfi/transact.php?message7=$randms");
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
            $clientt_name = $py['firstname'].' '.$py['middlename'].' '.$py['lastname'];
                $clientt_name = strtoupper($clientt_name);
                $brh= $py['branch_id'];
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
               $trancache = "INSERT INTO transact_cache (int_id, branch_id, transact_id, description, account_no, client_id, client_name, staff_id, account_off_name, amount, pay_type, transact_type, product_type, status, date)
               VALUES ('{$sessint_id}', '{$branch_id}', '{$transid}', '{$description}', '{$acct_no}', '{$client_id}', '{$clientt_name}', '{$staff_id}', '{$staff_name}', '{$amt}', '{$type}', '{$dd}', '{$product_id}', '{$ogs}', '{$gen_date}')";
               $go = mysqli_query($connection, $trancache);
               if ($go) {
                $mail = new PHPMailer;
                $mail->From = $int_email;
                $mail->FromName = $int_name;
                $mail->addAddress($client_email);
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
                          <img  style='margin-left: 225px; margin-right: auto; height:100px; width:100px;'class='img' src= '$int_logo'/>
                      </div>
                  </div>
                      <div class='main'>
                          <div class='text'>
                              Dear $clientt_name,
                              <h2 style='text-align:center;'>Notification of Credit Alert</h2>
                              this is to notify you of an incoming credit to your account $acct_no,
                               by $int_name Kindly confirm with your bank.<br/><br/>
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
                if(!$mail->send()) 
                   {
                       echo "Mailer Error: " . $mail->ErrorInfo;
                       $_SESSION["Lack_of_intfund_$randms"] = "Deposit Successful";
                       echo header ("Location: ../mfi/transact.php?message0=$randms");
                   } else
                   {
                       $_SESSION["Lack_of_intfund_$randms"] = "Deposit Has Been Done, Awaiting Approval!";
                       echo header ("Location: ../mfi/transact.php?messagep=$randms");
                   }
                 
               } else {
                  $_SESSION["Lack_of_intfund_$randms"] = "Transaction Failed";
                  echo header ("Location: ../mfi/transact.php?message2=$randms");
               }
           } else {
               echo "Not equal to deposit";
           }
        } else {
           $_SESSION["Lack_of_intfund_$randms"] = "Account not Found";
           echo header ("Location: ../mfi/transact.php?message7=$randms");
        }
   }
  }
    else if ($test == "withdraw" && $int_acct_bal >= $amt2) {
        // check if the POSTING-LIMIT
        // check if client has cash
        if ($client_acct_bal >=  $amt2) {
          if ($amt2 <= $post_limit) {
            // update the clients account
            $new_abd2 = $comp2;
            $iupq = "UPDATE account SET account_balance_derived = '$new_abd2',
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
            // update the institution account
            $iupq2 = "UPDATE institution_account SET account_balance_derived = '$new_int_bal2', total_withdrawals_derived = '$tbd2x' WHERE int_id = '$sessint_id' && teller_id = '$staff_id'";
            $iupqres2 = mysqli_query($connection, $iupq2);
            if ($iupqres2) {
                // update the institution transaction
             $iat2 = "INSERT INTO institution_account_transaction (int_id, branch_id,
            client_id, transaction_id, description, transaction_type, teller_id, is_reversed,
            transaction_date, amount, running_balance_derived, overdraft_amount_derived,
            created_date, appuser_id, debit) VALUES ('{$sessint_id}', '{$branch_id}',
            '{$client_id}', '{$transid}', '{$description}', '{$trans_type2}', '{$staff_id}', '{$irvs}',
            '{$gen_date}', '{$amt2}', '{$new_int_bal2}', '{$amt2}',
            '{$gen_date}', '{$appuser_id}', '{$amt2}')";
            $res4 = mysqli_query($connection, $iat2);
            if ($res4) {
               // update the GL
              $upglacct = "UPDATE `acc_gl_account` SET `organization_running_balance_derived` = '$new_gl_bal2' WHERE int_id = '$sessint_id' && gl_code = '$till'";
              $dbgl = mysqli_query($connection, $upglacct);
              if ($dbgl) {
                // echo a successful message
                $mail = new PHPMailer;
                $mail->From = $int_email;
                $mail->FromName = $int_name;
                $mail->addAddress($client_email, $clientt_name);
                $mail->addReplyTo($int_email, "No Reply");
                $mail->isHTML(true);
                $mail->Subject = "A Debit Transaction Alert from $int_name";
                $mail->Body = "<!doctype html>
                <html lang='en'>
                  <head>
                    <!-- Required meta tags -->
                    <meta charset='utf-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
                
                    <!-- Bootstrap CSS -->
                    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' integrity='sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh' crossorigin='anonymous'>
                
                    <title>Transaction Alert</title>
                  </head>
                  <body>
                    <div class='container'>
                        <div class='row justify-content-md-center'>
                          <div class='col col-lg-6'>
                            <div class='shadow p-3 mb-5 bg-white rounded'>
                                <!-- int logo -->
                                <div class='row justify-content-md-center'>
                                    <img src='$int_logo' height='60px' width='60px' alt='int image' class='rounded mx-auto d-block'>
                                    <div class='spinner-grow text-primary' role='status'>
                                        <span class='sr-only'>Loading...</span>
                                      </div>
                                </div>
                                <span> <b>$int_name</b> </span> || <span class='lead' style='font-size: 13px;'></span>
                            </div>
                          </div>
                        </div>
                        <div class='row'>
                          <div class='col col-lg-12'>
                            <div class='shadow-sm p-3 mb-5 bg-white rounded'>$gen_date
                                <div>
                                    <!-- fot the ext bod -->
                                    <p><b>Dear $clientt_name</b></p>
                                    <p>We wish to inform you that a <b>$trans_type2</b> transaction recently occurred on your bank account.
                                    Please find below details of the transaction:</p>
                                </div>
                                <p>
                                    <div class='shadow p-3 mb-5 bg-white rounded'>Transaction Details - <b>$trans_type2</b></div>
                                    <table class='table table-borderless'>
                                        <tbody>
                                            <div>
                                          <tr>
                                            <td> <b style='font-size: 12px;'>Account Number</b></td>
                                            <td style='font-size: 12px;'>$account_display</td>
                                          </tr>
                                          <tr>
                                            <td style='font-size: 12px;'> <b>Account Name</b></td>
                                            <td style='font-size: 12px;'>$clientt_name</td>
                                          </tr>
                                          <tr>
                                        <td style='font-size: 12px;'> <b>Reference</b></td>
                                        <td style='font-size: 12px;'>$description</td>
                                      </tr>
                                          <tr>
                                            <td style='font-size: 12px;'> <b>Reference Id</b></td>
                                            <td style='font-size: 12px;'>$transid</td>
                                          </tr>
                                          <tr>
                                            <td style='font-size: 12px;'> <b>Transaction Amount</b></td>
                                            <td style='font-size: 12px;'>$amt2</td>
                                          </tr>
                                          <tr>
                                            <td style='font-size: 12px;'> <b>Transaction Date/Time</b></td>
                                            <td style='font-size: 12px;'>$gen_date</td>
                                          </tr>
                                          <tr>
                                            <td style='font-size: 12px;'> <b>Value Date</b></td>
                                            <td style='font-size: 12px;'>$gends</td>
                                          </tr>
                                          <tr>
                                            <td style='font-size: 12px;'> <b>Account Balance</b></td>
                                            <td style='font-size: 12px;'>&#8358; $numberacct2</td>
                                          </tr>
                                        </tbody>
                                    </div>
                                      </table>
                                </p>
                                <button type='button' class='btn btn-primary btn-lg btn-block'> <b style='font-size: 15px;'>Print Account Statement</b></button>
                            </div>
                          </div>
                        </div>
                      </div>
                    <!-- Optional JavaScript -->
                    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
                    <script src='https://code.jquery.com/jquery-3.4.1.slim.min.js' integrity='sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n' crossorigin='anonymous'></script>
                    <script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js' integrity='sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo' crossorigin='anonymous'></script>
                    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js' integrity='sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6' crossorigin='anonymous'></script>
                  </body>
                </html>";
                $mail->AltBody = "This is the plain text version of the email content";
                // mail system
                if(!$mail->send()) 
                   {
                       echo "Mailer Error: " . $mail->ErrorInfo;
                       $_SESSION["Lack_of_intfund_$randms"] = "Deposit Successful";
                       echo header ("Location: ../mfi/transact.php?message0=$randms");
                   } else
                   {
                       $_SESSION["Lack_of_intfund_$randms"] = "Deposit Successful";
                       echo header ("Location: ../mfi/transact.php?message=$randms");
                   }
                // sends a mail first
            } else {
                // echo error in the gl
                $_SESSION["Lack_of_intfund_$randms"] = "Transaction Failed";
                echo header ("Location: ../mfi/transact.php?message2=$randms");
            }
            }
            } else {
                // echo error at int account
                $_SESSION["Lack_of_intfund_$randms"] = "Transaction Failed";
            echo header ("Location: ../mfi/transact.php?legal=$randms");
            }
            } else {
                // echo error in account transaction
                $_SESSION["Lack_of_intfund_$randms"] = "Transaction Failed";
            echo header ("Location: ../mfi/transact.php?legal=$randms");
            }
            } else {
                // echo in account
                $_SESSION["Lack_of_intfund_$randms"] = "Transaction Failed";
            echo header ("Location: ../mfi/transact.php?legal=$randms");
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
                    $clientt_name = $py['firstname'].' '.$py['middlename'].' '.$py['lastname'];
                    $clientt_name = strtoupper($clientt_name);
                }
               if ($test2 == "withdraw") {
                   if ($acct_b_d >= $amt2) {
                       $wd = "Withdrawal";
                       $gms = "Pending";
                      //  STOPPED HERE
                    $trancache = "INSERT INTO transact_cache (int_id, branch_id, transact_id, description, account_no, client_id, client_name, staff_id, account_off_name, amount, pay_type, transact_type, product_type, status, date) VALUES
                    ('{$sessint_id}', '{$branch_id}', '{$transid}','{$description}', '{$acct_no2}', '{$client_id}', '{$clientt_name}', '{$staff_id}', '{$staff_name}', '{$amt2}', '{$type2}', '{$wd}', '{$sproduct_id}', '{$gms}', '$gen_date') ";
                    $go = mysqli_query($connection, $trancache);
                    if ($go) {
                      $mail = new PHPMailer;
            $mail->From = $int_email;
            $mail->FromName = $int_name;
            $mail->addAddress($client_email);
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
                      <img  style='margin-left: 225px; margin-right: auto; height:100px; width:100px;'class='img' src='$int_logo'/>
                  </div>
              </div>
                  <div class='main'>
                      <div class='text'>
                          Dear $clientt_name,
                          <h2 style='text-align:center;'>Notification of Debit Alert</h2>
                          this is to notify you of an incoming debit to your account $acct_no,
                           by $int_name Kindly confirm with your bank.<br/><br/>
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
            if(!$mail->send()) 
               {
                   echo "Mailer Error: " . $mail->ErrorInfo;
                   $_SESSION["Lack_of_intfund_$randms"] = "Withdrawal Successful";
                   echo header ("Location: ../mfi/transact.php?message0=$randms");
               } else
               {
                $_SESSION["Lack_of_intfund_$randms"] = "Withdrawal Successful!";
                echo header ("Location: ../mfi/transact.php?message3=$randms");
               }
                    } else {
                       $_SESSION["Lack_of_intfund_$randms"] = "Withdrawal Failed";
                      echo header ("Location: ../mfi/transact.php?message4=$randms");
                    }
                   } else {
                       $_SESSION["Lack_of_intfund_$randms"] = "Failed - Insufficient Fund";
                       header ("Location: ../mfi/transact.php?message5=$randms");
                   }
                } else {
                    echo "Test is Empty";
                }
            } else {
               $_SESSION["Lack_of_intfund_$randms"] = "Account Not Found";
               echo header ("Location: ../mfi/transact.php?message7=$randms");
            }
        }
        } else {
                $_SESSION["Lack_of_intfund_$randms"] = "Account not Found";
                echo header ("Location: ../mfi/transact.php?message5=$randms");
             }
        } else {
          // echo error client has insufficient fund
          $_SESSION["Lack_of_intfund_$randms"] = "Failed - Insufficient Fund";
          header ("Location: ../mfi/transact.php?messagex5=$randms");
        }
    } else {
        $_SESSION["Lack_of_intfund_$randms"] = "Failed - Insufficient Fund";
        header ("Location: ../mfi/transact.php?message5=$randms");
    }
} else {
    // echo this teller is not authorized
    $_SESSION["Lack_of_intfund_$randms"] = "TELLER";
    echo header ("Location: ../mfi/transact.php?messagex2=$randms");
}
} else {
  $_SESSION["Lack_of_intfund_$randms"] = "System Error";
  echo header ("Location: ../mfi/transact.php?legalq=$randms");
}
// cont.
} else {
// you're not authorized not a teller
$_SESSION["Lack_of_intfund_$randms"] = "TELLER";
echo header ("Location: ../mfi/transact.php?messagex2=$randms");
// remeber to fix account transaction for approval
}

?>
<?php
// 
?>