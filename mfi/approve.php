<?php

$page_title = "Approve";
$destination = "transact_approval.php";
    include("header.php");
    require_once "../bat/phpmailer/PHPMailerAutoload.php";
?>
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
$branch_id = $_SESSION['branch_id'];
$gen_date = date('Y-m-d H:i:s');
$gends = date('Y-m-d');
?>
<?php
if (isset($_GET['approve']) && $_GET['approve'] !== '') {
  $appod = $_GET['approve'];
  $checkm = mysqli_query($connection, "SELECT * FROM transact_cache WHERE id = '$appod' && int_id = '$sessint_id' && status = 'Pending'");
  if (count([$checkm]) == 1) {
      $x = mysqli_fetch_array($checkm);
      $ssint_id = $_SESSION["int_id"];
      $appuser_id = $_SESSION["user_id"];
      $cn = $x['client_name'];
      $client_id = $x['client_id'];
      $id = $client_id;
      $acct_no = $x['account_no'];
      $account_display = substr("$acct_no",7)."*****".substr("$acct_no",8);
      $staff_id = $x['staff_id'];
      $ao = $x['account_off_name'];
      $amount = $x['amount'];
      $famt = number_format("$amount", 2);
      $pay_type = $x['pay_type'];
      $transact_type = $x['transact_type'];
      $transid = $x['transact_id'];
      $product_type = $x['product_type'];
      $stat = $x['status'];
      $irvs = 0;
  }
}
$gen_date = date('Y-m-d H:i:s');
$gends = date('Y-m-d');
// we will call the institution account
$damn = mysqli_query($connection, "SELECT * FROM institution_account WHERE int_id = '$sessint_id'");
    if (count([$damn]) == 1) {
        $x = mysqli_fetch_array($damn);
        $int_acct_bal = $x['account_balance_derived'];
        $new_int_bal = $amount + $int_acct_bal;
        $new_int_bal2 = $int_acct_bal - $amount;
}
?>
<?php
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
          $acct_no = $x['account_no'];
          $staff_id = $x['staff_id'];
          $amount = $x['amount'];
          $famt = number_format("$amount", 2);
          $pay_type = $x['pay_type'];
          $transact_type = $x['transact_type'];
          $product_type = $x['product_type'];
          $stat = $x['status'];
          $gen_date = date("Y-m-d");
          $digits = 10;
          $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
          $transid = $sessint_id."-".$randms;
  
          if ($stat == "Pending") {
              $getacct = mysqli_query($connection, "SELECT * FROM account WHERE account_no = '$acct_no' && int_id = '$sessint_id'");
              if (count([$getacct]) == 1) {
                 $y = mysqli_fetch_array($getacct);
                 $branch_id = $y['branch_id'];
                 $acct_no = $y['account_no'];
                 $client_id = $y['client_id'];
                 $int_acct_bal = $y['account_balance_derived'];
                 $comp = $amount + $int_acct_bal;
                 $numberacct = number_format("$comp",2);
                 $comp2 = $int_acct_bal - $amount;
                 $numberacct2 = number_format("$comp2",2);
                 $trans_type = "credit";
                 $trans_type2 = "debit";
                 $irvs = 0;
  
              //    account deposit computation
                if($transact_type == "Deposit") {
                  $new_abd = $comp;
                  $iupq = "UPDATE account SET account_balance_derived = '$new_abd',
                  last_deposit = '$amount' WHERE account_no = '$acct_no' && int_id = '$sessint_id'";
                  $iupqres = mysqli_query($connection, $iupq);
                  if ($iupqres) {
                      $iat = "INSERT INTO account_transaction (int_id, branch_id,
                      account_no, product_id,
                      client_id, transaction_id, transaction_type, is_reversed,
                      transaction_date, amount, running_balance_derived, overdraft_amount_derived,
                      created_date, appuser_id) VALUES ('{$ssint_id}', '{$branch_id}',
                      '{$acct_no}', '{$product_type}', '{$client_id}', '{$trans_id}', '{$trans_type}', '{$irvs}',
                      '{$gen_date}', '{$amount}', '{$new_abd}', '{$amount}',
                      '{$gen_date}', '{$appuser_id}')";
                      $res3 = mysqli_query($connection, $iat);
                      if ($res3) {
                          $v = "Verified";
                          $iupqx = "UPDATE transact_cache SET `status` = '$v' WHERE id = '$appod' && int_id = '$sessint_id'";
                          $res4 = mysqli_query($connection, $iupqx);
                          if ($res4) {
                            // institution account
                            $int_account_trans = "UPDATE institution_account SET account_balance_derived = '$new_int_bal' WHERE int_id = '$sessint_id'";
                            $query1 = mysqli_query($connection, $int_account_trans);
                            // check if int account has been updated
                            if ($query1) {
                              $trust = "INSERT INTO institution_account_transaction (int_id, branch_id,
                              client_id, transaction_id, transaction_type, is_reversed,
                              transaction_date, amount, running_balance_derived, overdraft_amount_derived,
                              created_date, appuser_id) VALUES ('{$sessint_id}', '{$branch_id}',
                             '{$client_id}', '{$transid}', '{$transact_type}', '{$irvs}',
                             '{$gen_date}', '{$amount}', '{$new_int_bal}', '{$amount}',
                             '{$gen_date}', '{$appuser_id}')";
                             $res9 = mysqli_query($connection, $trust);
                             if ($res9) {
                              $mail = new PHPMailer;
                              $mail->From = $int_email;
                              $mail->FromName = $int_name;
                              $mail->addAddress($email, $username);
                              $mail->addReplyTo($int_email, "Reply");
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
                                                          <td style='font-size: 12px;'> <b>Reference Id</b></td>
                                                          <td style='font-size: 12px;'>$transid</td>
                                                        </tr>
                                                        <tr>
                                                          <td style='font-size: 12px;'> <b>Transaction Amount</b></td>
                                                          <td style='font-size: 12px;'>$famt</td>
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
                                 } else
                                 {
                                  echo '<script type="text/javascript">
                                  $(document).ready(function(){
                                      swal({
                                          type: "success",
                                          title: "Success",
                                          text: "Transaction Successfully Approved",
                                          showConfirmButton: false,
                                          timer: 2000
                                      })
                                  });
                                  </script>
                                  ';
                                  $URL="transact_approval.php";
                                  echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                                 }
                              //  here we go
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
                                text: "Error in Transaction",
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
                } else if ($transact_type == "Withdrawal") {
                  $new_abd2 = $comp2;
                  $iupq = "UPDATE account SET account_balance_derived = '$new_abd2',
                  last_withdrawal = '$amount' WHERE account_no = '$acct_no' && int_id = '$sessint_id'";
                  $iupqres = mysqli_query($connection, $iupq);
                  if ($iupqres) {
                      $iat = "INSERT INTO account_transaction (int_id, branch_id,
                      account_no, product_id,
                      client_id, transaction_id, transaction_type, is_reversed,
                      transaction_date, amount, running_balance_derived, overdraft_amount_derived,
                      created_date, appuser_id) VALUES ('{$ssint_id}', '{$branch_id}',
                      '{$acct_no}', '{$product_type}', '{$client_id}', '{$trans_id}', '{$trans_type2}', '{$irvs}',
                      '{$gen_date}', '{$amount}', '{$new_abd}', '{$amount}',
                      '{$gen_date}', '{$appuser_id}')";
                      $res3 = mysqli_query($connection, $iat);
                      if ($res3) {
                          $v = "Verified";
                          $iupqx = "UPDATE transact_cache SET `status` = '$v' WHERE id = '$appod' && int_id = '$sessint_id'";
                          $res4 = mysqli_query($connection, $iupqx);
                          if ($res4) {
                            // institution account
                            // institution account transaction
                            $int_account_trans = "UPDATE institution_account SET account_balance_derived = '$new_int_bal2' WHERE int_id = '$sessint_id'";
                            $query1 = mysqli_query($connection, $int_account_trans);
                            // check if int account has been updated
                            if ($query1) {
                              $trust = "INSERT INTO institution_account_transaction (int_id, branch_id,
                              client_id, transaction_id, transaction_type, is_reversed,
                              transaction_date, amount, running_balance_derived, overdraft_amount_derived,
                              created_date, appuser_id) VALUES ('{$sessint_id}', '{$branch_id}',
                             '{$client_id}', '{$transid}', '{$transact_type}', '{$irvs}',
                             '{$gen_date}', '{$amount}', '{$new_int_bal2}', '{$amount}',
                             '{$gen_date}', '{$appuser_id}')";
                             $res9 = mysqli_query($connection, $trust);
                             if ($res9) {
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
                                                          <td style='font-size: 12px;'> <b>Reference Id</b></td>
                                                          <td style='font-size: 12px;'>$transid</td>
                                                        </tr>
                                                        <tr>
                                                          <td style='font-size: 12px;'> <b>Transaction Amount</b></td>
                                                          <td style='font-size: 12px;'>$famt</td>
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
                                 } else
                                 {
                                     $_SESSION["Lack_of_intfund_$randms"] = "Deposit Successful";
                                     echo header ("Location: ../mfi/transact.php?message=$randms");
                                     echo '<script type="text/javascript">
                              $(document).ready(function(){
                                  swal({
                                      type: "success",
                                      title: "Success",
                                      text: "Transaction Successfully Approved",
                                      showConfirmButton: false,
                                      timer: 2000
                                  })
                              });
                              </script>
                              ';
                              $URL="transact_approval.php";
                              echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                                 }
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
                                text: "Error in Transaction",
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
                } else if ($transact_type == "Loan Repayment") {
                  $person = mysqli_query($connection, "SELECT loan.interest_rate, client.id, client.account_no, loan.id, client.branch_id, loan.product_id, principal_amount, loan_term, loan.interest_rate FROM loan JOIN client ON loan.client_id = client.id WHERE client.int_id ='$sessint_id' && client_id = '$client_id'");
                    if (count([$person]) == 1) {
                      $x = mysqli_fetch_array($person);
                      $pa = $x['principal_amount'];
                      $brh = $x['branch_id'];
                      $p_id = $x['product_id'];
                      $account_no = $x['account_no'];
                      $interest_R = $x['interest_rate'];
                      $lt = $x['loan_term'];
                      $ln_id = $x['id'];
                      $expa = $pa / $lt;
                      // transaction id generation
                      $sessint_id = $_SESSION["int_id"];
                      $inttest = str_pad($sessint_id, 3, '0', STR_PAD_LEFT);
                      $digits = 4;
                     $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
                     $transid = $inttest."-".$randms;
                    //  run a query to display clientm name
                    $cqu = mysqli_query($connection, "SELECT * FROM client WHERE id = '$id'");
                    if (count([$cqu]) == 1) {
                      $us = mysqli_fetch_array($cqu);
                      $display_n = $us['display_name'];
                    }
                    }
                    $exp_amount = $expa;
  $amt_recieved = $amount;
  $pay_meth = $pay_type;
  $transaction_id = $transid;
  // make collection calculation
  $loan_principal = $pa;
  $loan_term = $lt;
  // test quickly - out put balance of the loan and calulation logic
  $minus = $amt_recieved - $exp_amount;
  $exp_error = "";
  // now lets output the loan amount remaning into a variable
  $clamt = $loan_principal - $amt_recieved;
  $minlt = $loan_term - 1;
  if ($clamt >= 0) {
    $update_loan_b = "UPDATE loan SET principal_amount = '$clamt', loan_term = '$minlt' WHERE client_id = '$id'";
      $run_ulb = mysqli_query($connection, $update_loan_b);
      // we update loan transaction
      if ($run_ulb) {
        $inst_id = $sessint_id;
        $branch = $brh;
        $prod_id = $p_id;
        $loan_id = $ln_id;
        $trns_id = $transid;
        $cc_id = $id;
        $acct_no = $account_no;
        $trans_type = "credit";
        $trans_date = date("Y-m-d");
        $amt = $amt_recieved;
        $py_m = $pay_meth; 
        $p_d = $amt_recieved - ($amt_recieved * $interest_R);
        $i_d = $amt_recieved * $interest_R;
          // quick query on outstanding loan balance derived
        $olbd = mysqli_query($connection, "SELECT * FROM loan where client_id = '$id'");
        if (count([$olbd]) == 1) {
          $oo = mysqli_fetch_array($olbd);
          $out_loan_bal = $oo['principal_amount'];
          $prd = $oo['principal_repaid_derived'] + $amt;
          $rnu = mysqli_query($connection, "UPDATE loan SET principal_repaid_derived = '$prd'  WHERE client_id = '$id'");
        }
        $appuser_id = $_SESSION["user_id"];
        $olbdq = "INSERT INTO loan_transaction (int_id, branch_id,
        product_id, loan_id, transaction_id, client_id,
        account_no, transaction_type, transaction_date, amount,
        payment_method, principal_portion_derived, interest_portion_derived,
        outstanding_loan_balance_derived, submitted_on_date,
        created_date, appuser_id) VALUES ('{$inst_id}', '{$branch}',
        '{$prod_id}', '{$loan_id}', '{$transid}', '{$cc_id}',
        '{$acct_no}', '{$trans_type}', '{$trans_date}', '{$amt}', '{$pay_meth}',
        '{$p_d}', '{$i_d}', '{$out_loan_bal}', '{$trans_date}', '{$trans_date}',
        '{$appuser_id}')";
        $res2 = mysqli_query($connection, $olbdq);
      // we update institution account
      if ($res2) {
        $uiab = mysqli_query($connection, "SELECT * FROM institution_account WHERE int_id = '$sessint_id'");
        if (count([$uiab]) == 1) {
          $x = mysqli_fetch_array($uiab);
          $int_acct_bal = $x['account_balance_derived'];
          $new_abd = $amt_recieved + $int_acct_bal;
          $iupq = "UPDATE institution_account SET account_balance_derived = '$new_abd' WHERE int_id = '$sessint_id'";
          $iupqres = mysqli_query($connection, $iupq);
      // we insert credit institution account transaction
      if ($iupqres) {
        $trans_id = $transaction_id;
        $trans_type = "credit";
        $trans_date = date("Y-m-d");
        $trans_amt = $amt;
        $irvs = 0;
        $ova = 0;
        $running_b = $new_abd;
        $created_date = date("Y-m-d");
        $iat = "INSERT INTO institution_account_transaction (int_id, branch_id,
        client_id, transaction_id, transaction_type, is_reversed,
        transaction_date, amount, running_balance_derived, overdraft_amount_derived,
        created_date, appuser_id) VALUES ('{$inst_id}', '{$branch}',
        '{$id}', '{$trans_id}', '{$trans_type}', '{$irvs}',
        '{$trans_date}', '{$trans_amt}', '{$running_b}', '{$trans_amt}',
        '{$created_date}', '{$appuser_id}')";
        $res3 = mysqli_query($connection, $iat);
      //   if ($connection->error) {
      //     try {
      //         throw new Exception("MYSQL error $connection->error <br> $iat ", $mysqli->error);
      //     } catch (Exception $e) {
      //         echo "Error No: ".$e->getCode()." - ".$e->getMessage() . "<br>";
      //         echo n12br($e->getTraceAsString());
      //     }
      // }
        // we insert to principal portfolio
        if ($res3) {
          // we insert to interest portfolio
          $last = "INSERT INTO loan_principal_port (int_id, officer_id, branch_id,
          client_id, principal_amount) VALUES ('{$inst_id}', '{$appuser_id}',
          '{$branch}', '{$id}', '{$p_d}')";
          $last2 = "INSERT INTO loan_interest_port (int_id, officer_id, branch_id,
          client_id, interest_amount) VALUE ('{$inst_id}', '{$appuser_id}',
          '{$branch}', '{$id}', '{$i_d}')";
          $res4 = mysqli_query($connection, $last);
          $res5 = mysqli_query($connection, $last2);
          if ($res4) {
            if ($res5) {
              $llp = mysqli_query($connection, "SELECT * FROM loan where client_id = '$id'");
        if (count([$llp]) == 1) {
          $oo = mysqli_fetch_array($llp);
          $outloanbal = $oo['principal_amount'];
        }
              if ($outloanbal == 0) {
                $updc = mysqli_query($connection, "UPDATE client SET loan_status = 'Not Active' WHERE id = '$id'");
                $ixxxx = "UPDATE transact_cache SET `status` = '$v' WHERE id = '$appod' && int_id = '$sessint_id'";
                $res4 = mysqli_query($connection, $ixxxx);
                echo '<script type="text/javascript">
                    $(document).ready(function(){
                        swal({
                            type: "success",
                            title: "Fully Paid",
                            text: "Loan Has Been Fully Paid",
                            showConfirmButton: false,
                            timer: 2000
                        })
                    });
                    </script>
                    ';
              } else {
                $ixxxx = "UPDATE transact_cache SET `status` = '$v' WHERE id = '$appod' && int_id = '$sessint_id'";
                $res4 = mysqli_query($connection, $ixxxx);
                echo '<script type="text/javascript">
                    $(document).ready(function(){
                        swal({
                            type: "success",
                            title: "Loan Repayment",
                            text: "Transaction Has Been Approved Already",
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
                            title: "Interest",
                            text: "Error at Interest",
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
                            title: "Error Principal",
                            text: "Error At Princiapl Portfolio",
                            showConfirmButton: false,
                            timer: 2000
                        })
                    });
                    </script>
                    ';
          }
         // test new laon balance to de-activate client loan status
        } else {
          echo '<script type="text/javascript">
                    $(document).ready(function(){
                        swal({
                            type: "error",
                            title: "Error Institution",
                            text: "Institution Account Transaction",
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
                            title: "Error Institution Update",
                            text: "Institution Account Update Error",
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
                            title: "Error Institution Account",
                            text: "Cant Get Institution Account",
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
                            title: "Error Loan Transaction",
                            text: "Cant Insert into Loan Transaction",
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
                            title: "Error Loan Insertion",
                            text: "Transaction Failed Cant Process Repayment",
                            showConfirmButton: false,
                            timer: 2000
                        })
                    });
                    </script>
                    ';
      }
  } else if ($clamt < 0) {
    $chaclamt2 = $amt_recieved - $loan_principal;
    $loan_amt = $loan_principal;
    $zero = 0;
    // chaclamt means remaining amount which will be posted
    $update_loan_b = "UPDATE loan SET principal_amount = '$zero', loan_term = '$zero' WHERE client_id = '$id'";
    $run_ulb = mysqli_query($connection, $update_loan_b);
    // we update loan transaction
    if ($run_ulb) {
      $inst_id = $sessint_id;
      $branch = $brh;
      $prod_id = $p_id;
      $loan_id = $ln_id;
      $trns_id = $transid;
      $cc_id = $id;
      $acct_no = $account_no;
      $trans_type = "credit";
      $trans_date = date("Y-m-d");
      $amt = $loan_amt;
      $py_m = $pay_meth;
      $p_d = $amt - ($amt * $interest_R);
      $i_d = $amt * $interest_R;
        // quick query on outstanding loan balance derived
      $olbd = mysqli_query($connection, "SELECT * FROM loan where client_id = '$id'");
      if (count([$olbd]) == 1) {
        $oo = mysqli_fetch_array($olbd);
        $out_loan_bal = $oo['principal_amount'];
        $prd = $oo['principal_repaid_derived'] + $amt;
        $rnu = mysqli_query($connection, "UPDATE loan SET principal_repaid_derived = '$prd'  WHERE client_id = '$id'");
      }
      $appuser_id = $_SESSION["user_id"];
      $olbdq = "INSERT INTO loan_transaction (int_id, branch_id,
      product_id, loan_id, transaction_id, client_id,
      account_no, transaction_type, transaction_date, amount,
      payment_method, principal_portion_derived, interest_portion_derived,
      outstanding_loan_balance_derived, submitted_on_date,
      created_date, appuser_id) VALUES ('{$inst_id}', '{$branch}',
      '{$prod_id}', '{$loan_id}', '{$transid}', '{$cc_id}',
      '{$acct_no}', '{$trans_type}', '{$trans_date}', '{$amt}', '{$pay_meth}',
      '{$p_d}', '{$i_d}', '{$out_loan_bal}', '{$trans_date}', '{$trans_date}',
      '{$appuser_id}')";
      $res2 = mysqli_query($connection, $olbdq);
      if ($connection->error) {
        try {   
            throw new Exception("MySQL error $connection->error <br> Query:<br> $olbdq", $mysqli->error);   
        } catch(Exception $e ) {
            echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
            echo nl2br($e->getTraceAsString());
        }
    }
    // we update institution account
    if ($res2) {
      $uiab = mysqli_query($connection, "SELECT * FROM institution_account WHERE int_id = '$sessint_id'");
      if (count([$uiab]) == 1) {
        $x = mysqli_fetch_array($uiab);
        $int_acct_bal = $x['account_balance_derived'];
        $new_abd = $amt + $int_acct_bal;
        $iupq = "UPDATE institution_account SET account_balance_derived = '$new_abd' WHERE int_id = '$sessint_id'";
        $iupqres = mysqli_query($connection, $iupq);
    // we insert credit institution account transaction
    if ($iupqres) {
      $trans_id = $transaction_id;
      $trans_type = "credit";
      $trans_date = date("Y-m-d");
      $trans_amt = $amt;
      $irvs = 0;
      $ova = 0;
      $running_b = $new_abd;
      $created_date = date("Y-m-d");
      $iat = "INSERT INTO institution_account_transaction (int_id, branch_id,
      client_id, transaction_id, transaction_type, is_reversed,
      transaction_date, amount, running_balance_derived, overdraft_amount_derived,
      created_date, appuser_id) VALUES ('{$inst_id}', '{$branch}',
      '{$id}', '{$trans_id}', '{$trans_type}', '{$irvs}',
      '{$trans_date}', '{$trans_amt}', '{$running_b}', '{$trans_amt}',
      '{$created_date}', '{$appuser_id}')";
      $res3 = mysqli_query($connection, $iat);
    //   if ($connection->error) {
    //     try {
    //         throw new Exception("MYSQL error $connection->error <br> $iat ", $mysqli->error);
    //     } catch (Exception $e) {
    //         echo "Error No: ".$e->getCode()." - ".$e->getMessage() . "<br>";
    //         echo n12br($e->getTraceAsString());
    //     }
    // }
      // we insert to principal portfolio
      if ($res3) {
        // we insert to interest portfolio
        $last = "INSERT INTO loan_principal_port (int_id, officer_id, branch_id,
        client_id, principal_amount) VALUES ('{$inst_id}', '{$appuser_id}',
        '{$branch}', '{$id}', '{$p_d}')";
        $last2 = "INSERT INTO loan_interest_port (int_id, officer_id, branch_id,
        client_id, interest_amount) VALUE ('{$inst_id}', '{$appuser_id}',
        '{$branch}', '{$id}', '{$i_d}')";
        $res4 = mysqli_query($connection, $last);
        $res5 = mysqli_query($connection, $last2);
        if ($res4) {
          if ($res5) {
            $llp = mysqli_query($connection, "SELECT * FROM loan where client_id = '$id'");
      if (count([$llp]) == 1) {
        $oo = mysqli_fetch_array($llp);
        $outloanbal = $oo['principal_amount'];
        $cab = $oo['account_no'];
      }
            if ($outloanbal == 0) {
              $updc = mysqli_query($connection, "UPDATE client SET loan_status = 'Not Active' WHERE id = '$id'");
              $forc = mysqli_query($connection, "SELECT * FROM account WHERE account_no = '$cab'");
              if (count([$forc]) == 1) {
                $q = mysqli_fetch_array($forc);
                $canb = $q['account_balance_derived'];
                $newcanb = $canb + $chaclamt2;
                $irvs = 0;
                $updateclientacct = mysqli_query($connection, "UPDATE account SET balance = '$newcanb', dep = '$chaclamt2'");
                $insertnew = "INSERT INTO account_transaction (int_id, branch_id,
                account_no, product_id,
                client_id, transaction_id, transaction_type, is_reversed,
                transaction_date, amount, running_balance_derived, overdraft_amount_derived,
                created_date, appuser_id) VALUES ('{$ssint_id}', '{$branch}',
                '{$acct_no}', '{$product_type}', '{$client_id}', '{$trns_id}', '{$trans_type}', '{$irvs}',
                '{$gen_date}', '{$chaclamt2}', '{$newcanb}', '{$amount}',
                '{$trans_date}', '{$appuser_id}')";
                $res3 = mysqli_query($connection, $insertnew);
                $ixxxx = "UPDATE transact_cache SET `status` = '$v' WHERE id = '$appod' && int_id = '$sessint_id'";
                $res4 = mysqli_query($connection, $ixxxx);
                if ($res3) {
                  echo '<script type="text/javascript">
                  $(document).ready(function(){
                      swal({
                          type: "success",
                          title: "Over Payment, Amount Transfered to Linked Savings Account",
                          text: "Loan Has Been Fully Paid",
                          showConfirmButton: false,
                          timer: 2000
                      })
                  });
                  </script>
                  ';
                } else {
                  echo '<script type="text/javascript">
                  $(document).ready(function(){
                      swal({
                          type: "error",
                          title: "Ending Error",
                          text: "Error",
                          showConfirmButton: false,
                          timer: 2000
                      })
                  });
                  </script>
                  ';
                }
              }
            } else {
              $ixxxx = "UPDATE transact_cache SET `status` = '$v' WHERE id = '$appod' && int_id = '$sessint_id'";
                $res4 = mysqli_query($connection, $ixxxx);
              echo '<script type="text/javascript">
                  $(document).ready(function(){
                      swal({
                          type: "success",
                          title: "Payment Successful",
                          text: "Loan Has Been Paid",
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
                        title: "Error At Interest",
                        text: "Error in Interest Portfolio",
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
                          title: "Error Principal",
                          text: "Error At Principal Portfolio",
                          showConfirmButton: false,
                          timer: 2000
                      })
                  });
                  </script>
                  ';
        }
       // test new laon balance to de-activate client loan status
      } else {
        echo '<script type="text/javascript">
                  $(document).ready(function(){
                      swal({
                          type: "error",
                          title: "Error Institution",
                          text: "Institution Account Transaction",
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
                          title: "Error Institution Update",
                          text: "Institution Account Update Error",
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
                          title: "Error Institution Account",
                          text: "Cant Get Institution Account",
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
                          title: "Error Loan Transaction",
                          text: "Cant Insert into Loan Transaction",
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
                          title: "Error Loan Insertion",
                          text: "Transaction Failed Cant Process Repayment",
                          showConfirmButton: false,
                          timer: 2000
                      })
                  });
                  </script>
                  ';
    }
  } else {
    echo 'Nothing';
  }
                } else {
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
    $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
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
                          <input type="text" class="form-control" name="name" value="<?php echo $transact_type; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Posted By</label>
                          <input type="text" class="form-control" name="email" value="<?php echo $ao; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Client</label>
                          <input type="text" class="form-control" name="phone" value="<?php echo $cn; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Amount</label>
                          <input type="text" class="form-control" name="location" value="<?php echo $amount; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Transaction ID</label>
                          <input type="text" class="form-control" name="transidddd" value="<?php echo $transid; ?>" readonly>
                        </div>
                      </div>
                      </div>
                      <a href="client.php" class="btn btn-secondary">Back</a>
                      <button type="submit" name="submit" value="decline" class="btn btn-danger pull-right">Decline</button>
                    <button type="submit" name="submit" value="approve" class="btn btn-primary pull-right">Approve</button>
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