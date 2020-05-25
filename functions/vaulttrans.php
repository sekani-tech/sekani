<?php
include("connect.php");
session_start();
require_once "../bat/phpmailer/PHPMailerAutoload.php";
?>

<?php
$emailu = $_SESSION["email"]; 
$int_name = $_SESSION["int_name"];
$int_email = $_SESSION["int_email"];
$int_web = $_SESSION["int_web"];
$int_phone = $_SESSION["int_phone"];
$int_logo = $_SESSION["int_logo"];
$int_address = $_SESSION["int_address"];
$sessint_id = $_SESSION["int_id"];
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$sint_id = $_SESSION['int_id'];

// If data is sent to this page
if (isset($_POST['transact_id']) && isset($_POST['type'])) {
    // Declaring variables
    $randms = str_pad(rand(0, pow(10, 8)-1), 10, '0', STR_PAD_LEFT);
    $type = $_POST['type'];
    $branchid = $_POST['branch'];
    $tid = $_POST['teller_id'];
    $amount = $_POST['amount'];
    $balance =$_POST['balance'];
    $transact_id = $_POST['transact_id'];

    $que = "SELECT * FROM institution_account WHERE teller_id = '$tid'";
    $rock = mysqli_query($connection, $que);
    $yn = mysqli_fetch_array($rock);
    $tellbalance = $yn['account_balance_derived'];
    $quet = "SELECT * FROM tellers WHERE name = '$tid'";
    $rocka = mysqli_query($connection, $quet);
    $yy = mysqli_fetch_array($rocka);
    $tellname = $yy['description'];
    $transdate = date('Y-m-d');
    $crdate = date('Y-m-d H:m:s');
    $vault = mysqli_query($connection, "SELECT * FROM int_vault WHERE branch_id = '$branchid' && int_id = '$sint_id'");
    $itb = mysqli_fetch_array($vault);
    $vault_limit = $itb['movable_amount'];

    if($type == "vault_in"){
            if($tellbalance >= $amount){
                $new_tellbalance = $tellbalance - $amount;
                $new_vaultbalance = $balance + $amount;
                $blnc = number_format($new_vaultbalance);
                $amt = number_format($amount);
                $vaultinquery = "UPDATE institution_account SET account_balance_derived = '$new_tellbalance' WHERE teller_id = '$tid'";
                $ein = mysqli_query($connection, $vaultinquery);
                $description = "Deposited into Vault";
                if($ein){
                    $vaultinquery2 = "UPDATE int_vault SET balance = '$new_vaultbalance', last_deposit = '$amount' WHERE int_id = '$sint_id'";
                    $on = mysqli_query($connection, $vaultinquery2);
                    if($on){
                        $record ="INSERT INTO institution_account_transaction (int_id, branch_id,
                        transaction_id, description, transaction_type, teller_id,is_vault, is_reversed,
                        transaction_date, amount, running_balance_derived, overdraft_amount_derived,
                        created_date, appuser_id, credit) VALUES ('{$sint_id}','{$branchid}', '{$transact_id}','{$description}',
                        '{$type}', '{$tid}', '1', '0', '{$transdate}', '{$amount}', '{$new_vaultbalance}','{$amount}', '{$crdate}',
                        '{$tid}', '{$amount}')";
                       $rin = mysqli_query($connection, $record);
                    if($rin){
                      $quy = "SELECT * FROM staff WHERE int_id = '$sessint_id' && org_role ='MD'";
                      $rult = mysqli_query($connection, $quy);
                      if (mysqli_num_rows($rult) > 0) {
                        while ($row = mysqli_fetch_array($rult))
                            {
                              $remail = $row['email'];
                              $qemail = "SELECT * FROM staff WHERE email = '$remail'";
                              $qemail2 = mysqli_query($connection, $qemail);
                              $rt = mysqli_fetch_array($qemail2);
                              $role = $rt['org_role'];
                              $nm = $rt['display_name'];

                              $org_role = $role;
                              $queory = "SELECT * FROM org_role WHERE role = '$org_role'";
                              $process = mysqli_query($connection, $queory);
                              $rol = mysqli_fetch_array($process);
                              $role_id = $rol['id'];

                              $query2 = "SELECT * FROM permission WHERE role_id = '$role_id'";
                              $process2 = mysqli_query($connection, $query2);
                              $proce = mysqli_fetch_array($process2);
                              $valut = $proce['valut'];

                              if ($valut == 1 || $valut == "1") {
                              $mail = new PHPMailer;
                              $mail->From = $int_email;
                              $mail->FromName = $int_name;
                              $mail->addAddress($remail);
                              $mail->addReplyTo($int_email, "Reply");
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
                                          <img style='margin-left: 225px; margin-right: auto; height:100px; width:100px;'class='img' src='$int_logo'/>
                                      </div>
                                  </div>
                                      <div class='main'>
                                          <div class='text'>
                                              Dear $clientt_name,
                                              <h2 style='text-align:center;'>Notification of Vault Alert</h2>
                                              this is to notify you that a vault-In transaction has been made in $int_name,
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
                                                  <td > <b>Teller Name</b></td>
                                                  <td >$tellname</td>
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
                                                  <td>$transact_id</td>
                                                </tr>
                                                <tr>
                                                  <td> <b>Value Date</b></td>
                                                  <td>$transdate</td>
                                                </tr>
                                                <tr>
                                                  <td> <b>Account Balance</b></td>
                                                  <td>&#8358; $blnc</td>
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
                            }
                          }
                          } 
            // mail system
            if(!$mail->send()) 
               {
                $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
                echo "error";
                echo header ("Location: ../mfi/teller_journal.php?message6=$randms");
               } else
               {
                $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
                echo "error";
                echo header ("Location: ../mfi/teller_journal.php?message1=$randms");
               }
                    }
                    else{
                        $_SESSION["Lack_of_intfund_$randms"] = "";
                        echo "error";
                        echo header ("Location: ../mfi/teller_journal.php?message5=$randms");
                    }
                }
            }
        }
        else if($amount >= $tellbalance){
            $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
           echo "error";
          echo header ("Location: ../mfi/teller_journal.php?message2=$randms");
        }
    }
    else if($type == "vault_out"){
        if($balance >= $amount){
            if($amount >= $vault_limit){
                $_SESSION["Lack_of_intfund_$randms"] = "";
                   echo "error";
                  echo header ("Location: ../mfi/teller_journal.php?message=$randms");
            }
            else{
                $new_tellbalance = $tellbalance + $amount;
                $new_vaultbalance = $balance - $amount;
                $blnc = number_format($new_vaultbalance);
                $amt = number_format($amount);
                $vaultinquery = "UPDATE institution_account SET account_balance_derived = '$new_tellbalance' WHERE teller_id = '$tid' && int_id = '$sint_id'";
                $ein = mysqli_query($connection, $vaultinquery);
                $description = "Withdrawn from vault";
                if($ein){
                    $vaultinquery2 = "UPDATE int_vault SET balance = '$new_vaultbalance', last_withdrawal = '$amount' WHERE int_id = '$sint_id'";
                    $on = mysqli_query($connection, $vaultinquery2);
                    if($on){
                        $record ="INSERT INTO institution_account_transaction (int_id, branch_id,
                        transaction_id, description, transaction_type, teller_id, is_vault, is_reversed,
                        transaction_date, amount, running_balance_derived, overdraft_amount_derived,
                        created_date, appuser_id, debit) VALUES ('{$sint_id}','{$branchid}', '{$transact_id}','{$description}',
                        '{$type}', '{$tid}', '1', '0', '{$transdate}', '{$amount}', '{$new_vaultbalance}','{$amount}', '{$crdate}',
                        '{$tid}', '{$amount}')";
                        $rin = mysqli_query($connection, $record);
                    if($rin){
                      $quy = "SELECT * FROM staff WHERE int_id = '$sessint_id' && org_role ='MD'";
                      $rult = mysqli_query($connection, $quy);
                      if (mysqli_num_rows($rult) > 0) {
                        while ($row = mysqli_fetch_array($rult))
                            {
                              $remail = $row['email'];
                              $qemail = "SELECT * FROM staff WHERE email = '$remail'";
                              $qemail2 = mysqli_query($connection, $qemail);
                              $rt = mysqli_fetch_array($qemail2);
                              $role = $rt['org_role'];
                              $nm = $rt['display_name'];

                              $org_role = $role;
                              $queory = "SELECT * FROM org_role WHERE role = '$org_role'";
                              $process = mysqli_query($connection, $queory);
                              $rol = mysqli_fetch_array($process);
                              $role_id = $rol['id'];

                              $query2 = "SELECT * FROM permission WHERE role_id = '$role_id'";
                              $process2 = mysqli_query($connection, $query2);
                              $proce = mysqli_fetch_array($process2);
                              $valut = $proce['valut'];

                              if ($valut == 1 || $valut == "1") {
                              $mail = new PHPMailer;
                              $mail->From = $int_email;
                              $mail->FromName = $int_name;
                              $mail->addAddress($remail);
                              $mail->addReplyTo($int_email, "Reply");
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
                                          <img style='margin-left: 225px; margin-right: auto; height:100px; width:100px;'class='img' src='$int_logo'/>
                                      </div>
                                  </div>
                                      <div class='main'>
                                          <div class='text'>
                                              Dear $clientt_name,
                                              <h2 style='text-align:center;'>Notification of Vault Alert</h2>
                                              this is to notify you that a vault-Out transaction has been made in $int_name,
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
                                                  <td > <b>Teller Name</b></td>
                                                  <td >$tellname</td>
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
                                                  <td>$transact_id</td>
                                                </tr>
                                                <tr>
                                                  <td> <b>Value Date</b></td>
                                                  <td>$transdate</td>
                                                </tr>
                                                <tr>
                                                  <td> <b>Account Balance</b></td>
                                                  <td>&#8358; $blnc</td>
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
                            }
                          }
                          } 
            // mail system
            if(!$mail->send()) 
               {
                $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
                echo "error";
                echo header ("Location: ../mfi/teller_journal.php?message6=$randms");
               } else
               {
                $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
                echo "error";
                echo header ("Location: ../mfi/teller_journal.php?message3=$randms");
               }
                    }
                    else{
                        $_SESSION["Lack_of_intfund_$randms"] = "";
                        echo "error";
                        echo header ("Location: ../mfi/teller_journal.php?message5=$randms");
                    }
                }
                }
                }
        }
        elseif($amount >= $balance){
            $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
           echo "error";
          echo header ("Location: ../mfi/teller_journal.php?message4=$randms");
        }
    }
    else{
        $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
           echo "error";
          echo header ("Location: ../mfi/teller_journal.php?message5=$randms");
    }
}
?>