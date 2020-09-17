<?php
include("connect.php");
session_start();
require_once "../bat/phpmailer/PHPMailerAutoload.php";
?>

<?php
$emailu = $_SESSION["email"];
$brand = $_SESSION["branch_id"];
$int_name = $_SESSION["int_name"];
$int_email = $_SESSION["int_email"];
$int_web = $_SESSION["int_web"];
$int_phone = $_SESSION["int_phone"];
$int_logo = $_SESSION["int_logo"];
$int_address = $_SESSION["int_address"];
$sessint_id = $_SESSION["int_id"];
$nm = $_SESSION["username"];
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$sint_id = $_SESSION['int_id'];

// If data is sent to this page
if (isset($_POST['transact_id']) && isset($_POST['type'])) {
    // Declaring variables
    $randms = str_pad(rand(0, pow(10, 8)-1), 10, '0', STR_PAD_LEFT);
    $type = $_POST['type'];
    $branchid = $_POST['branch_id'];
    $tid = $_POST['teller_id'];
    $amount = $_POST['amount'];
    $balance =$_POST['balance'];
    $transact_id = $_POST['transact_id'];
    $bank_type = $_POST['bank_type'];
    $glcode = $_POST['gl_code'];
    
    $gl = "SELECT * FROM acc_gl_account WHERE gl_code = '$bank_type'";
    $gla = mysqli_query($connection, $gl);
    $np = mysqli_fetch_array($gla);
    $glbalance = $np['organization_running_balance_derived'];
    $glname = $np['name'];

    $que = "SELECT * FROM institution_account WHERE teller_id = '$tid'";
    $rock = mysqli_query($connection, $que);
    $yn = mysqli_fetch_array($rock);
    $tellbalance = $yn['account_balance_derived'];
    $tellgl = $yn['gl_code'];

    $fdd = "SELECT * FROM acc_gl_account WHERE int_id='$sessint_id' AND gl_code='$tellgl'";
    $ssddd = mysqli_query($connection, $fdd);
    $sd = mysqli_fetch_array($ssddd);
    $tellglbalance = $sd['organization_running_balance_derived'];

    $quet = "SELECT * FROM tellers WHERE name = '$tid'";
    $rocka = mysqli_query($connection, $quet);
    $yy = mysqli_fetch_array($rocka);
    $tellname = $yy['description'];
    $transdate = date('Y-m-d h:i:sa');
    $crdate = date('Y-m-d H:m:s');
    $vault = mysqli_query($connection, "SELECT * FROM int_vault WHERE branch_id = '$branchid' && int_id = '$sint_id'");
    $itb = mysqli_fetch_array($vault);
    $vault_limit = $itb['movable_amount'];
    $int_gl = $itb['gl_code'];

    // vault gl
    $vau = mysqli_query($connection,"SELECT * FROM acc_gl_account WHERE int_id = '$sint_id' AND gl_code = '$int_gl'");
    $ese = mysqli_fetch_array($vau);
    $parent_id = $ese['parent_id'];
  // If transaction is a vault in execute this code
  if($tid || $bank_type){
    if($type == "vault_in"){
      // if the teller balance is equal is bigger amount
            if($tellbalance >= $amount){
                $new_tellbalance = $tellbalance - $amount;
                $newtellgl = $tellglbalance - $amount;
                $new_vaultbalance = $balance + $amount;

                $blnc = number_format($new_vaultbalance);
                $amt = number_format($amount);
                $vaultinquery = "UPDATE institution_account SET account_balance_derived = '$new_tellbalance' WHERE teller_id = '$tid' AND int_id = '$sessint_id' AND branch_id = '$brand'";
                $ein = mysqli_query($connection, $vaultinquery);
                $description = "Deposited into Vault";
                if($ein){

                  $ddffd = "UPDATE acc_gl_account SET organization_running_balance_derived = '$newtellgl' WHERE gl_code = '$tellgl' && int_id = '$sint_id' AND branch_id = '$branchid'";
                  $onxzx = mysqli_query($connection, $ddffd);
                  
                    $vaufinquery = "UPDATE int_vault SET balance = '$new_vaultbalance', last_deposit = '$amount'  WHERE int_id = '$sint_id' AND branch_id = '$branchid'";
                    $fon = mysqli_query($connection, $vaufinquery);

                    $vaultffinquery = "UPDATE acc_gl_account SET organization_running_balance_derived = '$new_vaultbalance' WHERE gl_code = '$int_gl' && int_id = '$sint_id' AND branch_id = '$branchid'";
                    $on = mysqli_query($connection, $vaultffinquery);
                    if($on){
                        $record ="INSERT INTO institution_account_transaction (int_id, branch_id,
                        transaction_id, description, transaction_type, teller_id,is_vault, is_reversed,
                        transaction_date, amount, running_balance_derived, overdraft_amount_derived,
                        created_date, appuser_id, debit) VALUES ('{$sint_id}','{$branchid}', '{$transact_id}','{$description}',
                        '{$type}', '{$tid}', '1', '0', '{$transdate}', '{$amount}', '{$new_tellbalance}','{$amount}', '{$crdate}',
                        '{$tid}', '{$amount}')";
                        $reffcord ="INSERT INTO gl_account_transaction (int_id, branch_id, gl_code, parent_id, transaction_id, description,
                        transaction_type, teller_id, transaction_date, amount, gl_account_balance_derived, overdraft_amount_derived,
                          created_date, credit) VALUES ( '{$sint_id}', '{$branchid}', '{$int_gl}', '{$parent_id}','{$transact_id}', '{$description}', '{$type}', NULL, '{$transdate}', '{$amount}',
                           '{$new_vaultbalance}', '{$amount}', '{$crdate}', '{$amount}')";
                            $risn = mysqli_query($connection, $reffcord);

                       $rin = mysqli_query($connection, $record);
                       $vable = "INSERT INTO institution_vault_transaction (int_id, branch_id, transaction_id, description, transaction_type,
                       teller_id, transaction_date, amount, vault_balance_derived, overdraft_amount_derived, created_date, appuser_id, credit)
                         VALUES ('{$sint_id}', '{$branchid}', '{$transact_id}', '{$description}', '{$type}', '{$tid}', '{$transdate}', '{$amount}',
                         '{$new_vaultbalance}', '{$amount}', '{$crdate}', '{$tid}', '{$amount}')";
                        $rlt = mysqli_query($connection, $vable);

                    if($rlt){
                      $quy = "SELECT * FROM staff WHERE int_id = '$sessint_id' AND employee_status = 'Employed'";
                      $rult = mysqli_query($connection, $quy);
                      if (mysqli_num_rows($rult) > 0) {
                        while ($row = mysqli_fetch_array($rult))
                            {
                              $username = $row['username'];
                              $remail = $row['email'];
                              $roleid = $row['org_role'];
                              $quyd = "SELECT * FROM permission WHERE role_id = '$roleid'";
                              $rlot = mysqli_query($connection, $quyd);
                              $tolm = mysqli_fetch_array($rlot);
                              $vaul = $tolm['vault_email'];
                              
                              if ($vaul == 1 || $vaul == "1") {
         // mailin
                            // begining of mail
                            $mail = new PHPMailer;
                            // from email addreess and name
                            $mail->From = $int_email;
                            $mail->FromName = $int_name;
                            // to adress and name
                            $mail->addAddress($remail, $username);
                            // reply address
                            //Address to which recipient will reply
                            // progressive html images
                            $mail->addReplyTo($int_email, "Reply");
                            // CC and BCC
                            //CC and BCC
                            // $mail->addCC("cc@example.com");
                            // $mail->addBCC("bcc@example.com");
                            // Send HTML or Plain Text Email
                            $mail->isHTML(true);
                            $mail->Subject = "Vault Alert From ".$int_name;
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
                                          <img style='margin-left: 200px; margin-right: auto; height:150px; width:150px;'class='img' src='$int_logo'/>
                                      </div>
                                  </div>
                                      <div class='main'>
                                          <div class='text'>
                                              Dear $clientt_name,
                                              <h2 style='text-align:center;'>Notification of Vault Alert</h2>
                                              this is to notify you that a vault-In transaction has been made in $int_name,
                                               by $nm Kindly confirm with your bank.<br/><br/>
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
                                                  <td > <b>From</b></td>
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
                                         // mail system
                                         if(!$mail->send()) 
                                         {
                                           $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
                                           echo "sent";
                                          //  echo header ("Location: ../mfi/teller_journal.php?message6=$randms");
                                          $URL="../mfi/teller_journal.php?message6=$randms";

                           echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                                         } else
                                         {
                                           $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
                                           echo "error";
                                          //  echo header ("Location: ../mfi/teller_journal.php?message1=$randms");
                                          $URL="../mfi/teller_journal.php?message1=$randms";

                           echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                                         }
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
                $newtellgl = $tellglbalance + $amount;
                $new_vaultbalance = $balance - $amount;
                $blnc = number_format($new_vaultbalance);
                $amt = number_format($amount);

                $vaultinquery = "UPDATE institution_account SET account_balance_derived = '$new_tellbalance' WHERE teller_id = '$tid' && int_id = '$sint_id' AND int_id = '$sessint_id' AND branch_id = '$brand'";
                $ein = mysqli_query($connection, $vaultinquery);

                $ddffd = "UPDATE acc_gl_account SET organization_running_balance_derived = '$newtellgl' WHERE gl_code = '$tellgl' && int_id = '$sint_id' AND branch_id = '$branchid'";
                  $onxzx = mysqli_query($connection, $ddffd);

                $description = "Withdrawn from vault";
                if($ein){
                    $vaultgl = "UPDATE acc_gl_account SET organization_running_balance_derived = '$new_vaultbalance' WHERE gl_code = '$int_gl' && int_id = '$sint_id' AND branch_id = '$branchid'";
                    $ow = mysqli_query($connection, $vaultgl);
                    $vaultinquery2 = "UPDATE int_vault SET balance = '$new_vaultbalance', last_withdrawal = '$amount' WHERE int_id = '$sint_id' AND branch_id = '$branchid'";
                    $on = mysqli_query($connection, $vaultinquery2);
                    // $glquery = "UPDATE acc_gl_account SET organization_running_balance_derived = '$new_vaultbalance' WHERE gl_code = '' AND int_id = '$sint_id'";
                    // $ond = mysqli_query($connection, $glquery);
                    if($on){
                        $recorrrd ="INSERT INTO institution_account_transaction (int_id, branch_id,
                        transaction_id, description, transaction_type, teller_id, is_vault, is_reversed,
                        transaction_date, amount, running_balance_derived, overdraft_amount_derived,
                        created_date, appuser_id, credit) VALUES ('{$sint_id}','{$branchid}', '{$transact_id}','{$description}',
                        '{$type}', '{$tid}', '1', '0', '{$transdate}', '{$amount}', '{$new_tellbalance}','{$amount}', '{$crdate}',
                        '{$tid}', '{$amount}')";
                        $rin = mysqli_query($connection, $recorrrd);

                        $record ="INSERT INTO gl_account_transaction (int_id, branch_id, gl_code, parent_id, transaction_id, description,
                        transaction_type, teller_id, transaction_date, amount, gl_account_balance_derived, overdraft_amount_derived,
                          created_date, debit) VALUES ( '{$sint_id}', '{$branchid}', '{$int_gl}', '{$parent_id}', '{$transact_id}', '{$description}', '{$type}', NULL, '{$transdate}', '{$amount}',
                           '{$new_vaultbalance}', '{$amount}', '{$crdate}', '{$amount}')";
                            $riln = mysqli_query($connection, $record);

                        $vabl = "INSERT INTO institution_vault_transaction (int_id, branch_id, transaction_id, description, transaction_type,
                        teller_id, transaction_date, amount, vault_balance_derived, overdraft_amount_derived, created_date, appuser_id, debit)
                          VALUES ('{$sint_id}', '{$branchid}', '{$transact_id}', '{$description}', '{$type}', '{$tid}', '{$transdate}', '{$amount}',
                          '{$new_vaultbalance}', '{$amount}', '{$crdate}', '{$tid}', '{$amount}')";
                         $rlt = mysqli_query($connection, $vabl);

                         if($rlt){
                          $quy = "SELECT * FROM staff WHERE int_id = '$sessint_id' AND employee_status = 'Employed'";
                          $rult = mysqli_query($connection, $quy);
                          if (mysqli_num_rows($rult) > 0) {
                            while ($row = mysqli_fetch_array($rult))
                                {
                                  $username = $row['username'];
                                  $remail = $row['email'];
                                  $roleid = $row['org_role'];
                                  $quyd = "SELECT * FROM permission WHERE role_id = '$roleid'";
                                  $rlot = mysqli_query($connection, $quyd);
                                  $tolm = mysqli_fetch_array($rlot);
                                  $vaul = $tolm['vault_email'];
                                  
                                  if ($vaul == 1 || $vaul == "1") {
                                           // mailin
                            // begining of mail
                            $mail = new PHPMailer;
                            // from email addreess and name
                            $mail->From = $int_email;
                            $mail->FromName = $int_name;
                            // to adress and name
                            $mail->addAddress($remail, $username);
                            // reply address
                            //Address to which recipient will reply
                            // progressive html images
                            $mail->addReplyTo($int_email, "Reply");
                            // CC and BCC
                            //CC and BCC
                            // $mail->addCC("cc@example.com");
                            // $mail->addBCC("bcc@example.com");
                            // Send HTML or Plain Text Email
                            $mail->isHTML(true);
                            $mail->Subject = "Vault Alert From ".$int_name;
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
                                              <img style='margin-left: 200px; margin-right: auto; height:150px; width:150px;'class='img' src='$int_logo'/>
                                          </div>
                                      </div>
                                          <div class='main'>
                                              <div class='text'>
                                                  Dear $clientt_name,
                                                  <h2 style='text-align:center;'>Notification of Vault Alert</h2>
                                                  this is to notify you that a vault-Out transaction has been made in $int_name,
                                                   by $nm Kindly confirm with your bank.<br/><br/>
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
                                                      <td > <b>From</b></td>
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
                                             // mail system
                                             if(!$mail->send()) 
                                             {
                                               $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
                                               echo "sent";
                                              //  echo header ("Location: ../mfi/teller_journal.php?message6=$randms");
                                              $URL="../mfi/teller_journal.php?message6=$randms";
    
                               echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                                             } else
                                             {
                                               $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
                                               echo "error";
                                              //  echo header ("Location: ../mfi/teller_journal.php?message1=$randms");
                                              $URL="../mfi/teller_journal.php?message1=$randms";
    
                               echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                                             }
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
    else if($type == "to_bank"){
      if($balance >= $amount){
        if($amount >= $vault_limit){
            $_SESSION["Lack_of_intfund_$randms"] = "";
               echo "error";
              echo header ("Location: ../mfi/teller_journal.php?message=$randms");
        }
        else{
            $new_glbalance = $glbalance + $amount;
            $new_vaultbalance = $balance - $amount;
            $blnc = number_format($new_vaultbalance);
            $amt = number_format($amount);
            $vaultinquery = "UPDATE acc_gl_account SET organization_running_balance_derived = '$new_glbalance' WHERE gl_code = '$bank_type' && int_id = '$sint_id'";
            $ein = mysqli_query($connection, $vaultinquery);

            $glnquery = "UPDATE acc_gl_account SET organization_running_balance_derived = '$new_vaultbalance' WHERE gl_code = '$int_gl' && int_id = '$sint_id' AND branch_id = '$branchid'";
            $on = mysqli_query($connection, $glnquery);

            $description = "Deposited to $glname";
            if($ein){
                $vaultinquery2 = "UPDATE int_vault SET balance = '$new_vaultbalance', last_withdrawal = '$amount' WHERE int_id = '$sint_id' AND branch_id = '$branchid'";
                $on = mysqli_query($connection, $vaultinquery2);
                if($on){
                    $resscord ="INSERT INTO gl_account_transaction (int_id, branch_id, gl_code, parent_id, transaction_id, description,
                transaction_type, teller_id, transaction_date, amount, gl_account_balance_derived, overdraft_amount_derived,
                  created_date, credit) VALUES ( '{$sint_id}', '{$branchid}', '{$bank_type}', '{$parent_id}', '{$transact_id}', '{$description}', '{$type}', NULL, '{$transdate}', '{$amount}',
                   '{$new_glbalance}', '{$amount}', '{$crdate}', '{$amount}')";
                    $rin = mysqli_query($connection, $resscord);

                    $recrd ="INSERT INTO gl_account_transaction (int_id, branch_id, gl_code, parent_id, transaction_id, description,
                        transaction_type, teller_id, transaction_date, amount, gl_account_balance_derived, overdraft_amount_derived,
                          created_date, debit) VALUES ( '{$sint_id}', '{$branchid}', '{$int_gl}', '{$parent_id}', '{$transact_id}', '{$description}', '{$type}', NULL, '{$transdate}', '{$amount}',
                           '{$new_vaultbalance}', '{$amount}', '{$crdate}', '{$amount}')";
                            $rind = mysqli_query($connection, $recrd);

                    $vabl = "INSERT INTO institution_vault_transaction (int_id, branch_id, transaction_id, description, transaction_type,
                    teller_id, transaction_date, amount, vault_balance_derived, overdraft_amount_derived, created_date, appuser_id, debit)
                      VALUES ('{$sint_id}', '{$branchid}', '{$transact_id}', '{$description}', '{$type}', '{$tid}', '{$transdate}', '{$amount}',
                      '{$new_vaultbalance}', '{$amount}', '{$crdate}', '{$tid}', '{$amount}')";
                     $rlt = mysqli_query($connection, $vabl);
                     if($rlt){
                      $quy = "SELECT * FROM staff WHERE int_id = '$sessint_id' AND employee_status = 'Employed'";
                      $rult = mysqli_query($connection, $quy);
                      if (mysqli_num_rows($rult) > 0) {
                        while ($row = mysqli_fetch_array($rult))
                            {
                              $username = $row['username'];
                              $remail = $row['email'];
                              $roleid = $row['org_role'];
                              $quyd = "SELECT * FROM permission WHERE role_id = '$roleid'";
                              $rlot = mysqli_query($connection, $quyd);
                              $tolm = mysqli_fetch_array($rlot);
                              $vaul = $tolm['vault_email'];
                              
                              if ($vaul == 1 || $vaul == "1") {
         // mailin
                            // begining of mail
                            $mail = new PHPMailer;
                            // from email addreess and name
                            $mail->From = $int_email;
                            $mail->FromName = $int_name;
                            // to adress and name
                            $mail->addAddress($remail, $username);
                            // reply address
                            //Address to which recipient will reply
                            // progressive html images
                            $mail->addReplyTo($int_email, "Reply");
                            // CC and BCC
                            //CC and BCC
                            // $mail->addCC("cc@example.com");
                            // $mail->addBCC("bcc@example.com");
                            // Send HTML or Plain Text Email
                            $mail->isHTML(true);
                            $mail->Subject = "Vault Alert From ".$int_name;
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
                                          <img style='margin-left: 200px; margin-right: auto; height:150px; width:150px;'class='img' src='$int_logo'/>
                                      </div>
                                  </div>
                                      <div class='main'>
                                          <div class='text'>
                                              Dear $clientt_name,
                                              <h2 style='text-align:center;'>Notification of Vault Alert</h2>
                                              this is to notify you that a Bank transaction has been made in $int_name,
                                               by $nm Kindly confirm with your bank.<br/><br/>
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
                                                  <td > <b>From</b></td>
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
                                         // mail system
                                         if(!$mail->send()) 
                                         {
                                           $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
                                           echo "sent";
                                          //  echo header ("Location: ../mfi/teller_journal.php?message6=$randms");
                                          $URL="../mfi/teller_journal.php?message6=$randms";

                           echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                                         } else
                                         {
                                           $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
                                           echo "error";
                                          //  echo header ("Location: ../mfi/teller_journal.php?message1=$randms");
                                          $URL="../mfi/teller_journal.php?message1=$randms";

                           echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                                         }
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
    else if($type == "from_bank"){
      if($glbalance >= $amount){
        $new_glbalance = $glbalance - $amount;
        $new_vaultbalance = $balance + $amount;
        $blnc = number_format($new_vaultbalance);
        $amt = number_format($amount);
        $vaultinquery = "UPDATE acc_gl_account SET organization_running_balance_derived = '$new_glbalance' WHERE gl_code = '$bank_type' && int_id = '$sint_id'";
        $ein = mysqli_query($connection, $vaultinquery);

        $vaultffinquery = "UPDATE acc_gl_account SET organization_running_balance_derived = '$new_vaultbalance' WHERE gl_code = '$int_gl' && int_id = '$sint_id' AND branch_id = '$branchid'";
                    $on = mysqli_query($connection, $vaultffinquery);

        $description = "Withdrawn from $glname";
        if($ein){
            $vaultinquery2 = "UPDATE int_vault SET balance = '$new_vaultbalance', last_deposit = '$amount' WHERE int_id = '$sint_id' AND branch_id = '$branchid'";
            $on = mysqli_query($connection, $vaultinquery2);
            if($on){
              $record ="INSERT INTO gl_account_transaction (int_id, branch_id, gl_code, transaction_id, description,
              transaction_type, teller_id, transaction_date, amount, gl_account_balance_derived, overdraft_amount_derived,
                created_date, debit) VALUES ( '{$sint_id}', '{$branchid}', '{$bank_type}', '{$transact_id}', '{$description}', '{$type}', NULL, '{$transdate}', '{$amount}',
                 '{$new_glbalance}', '{$amount}', '{$crdate}', '{$amount}')";
               $rin = mysqli_query($connection, $record);

               $record ="INSERT INTO gl_account_transaction (int_id, branch_id, gl_code, parent_id, transaction_id, description,
                        transaction_type, teller_id, transaction_date, amount, gl_account_balance_derived, overdraft_amount_derived,
                          created_date, credit) VALUES ( '{$sint_id}', '{$branchid}', '{$int_gl}', '{$parent_id}', '{$transact_id}', '{$description}', '{$type}', NULL, '{$transdate}', '{$amount}',
                           '{$new_vaultbalance}', '{$amount}', '{$crdate}', '{$amount}')";
                            $rin = mysqli_query($connection, $record);

               $vable = "INSERT INTO institution_vault_transaction (int_id, branch_id, transaction_id, description, transaction_type,
               teller_id, transaction_date, amount, vault_balance_derived, overdraft_amount_derived, created_date, appuser_id, credit)
                 VALUES ('{$sint_id}', '{$branchid}', '{$transact_id}', '{$description}', '{$type}', '{$tid}', '{$transdate}', '{$amount}',
                 '{$new_vaultbalance}', '{$amount}', '{$crdate}', '{$tid}', '{$amount}')";
                $rlt = mysqli_query($connection, $vable);
                if($rlt){
                  $quy = "SELECT * FROM staff WHERE int_id = '$sessint_id' AND employee_status = 'Employed'";
                  $rult = mysqli_query($connection, $quy);
                  if (mysqli_num_rows($rult) > 0) {
                    while ($row = mysqli_fetch_array($rult))
                        {
                          $username = $row['username'];
                          $remail = $row['email'];
                          $roleid = $row['org_role'];
                          $quyd = "SELECT * FROM permission WHERE role_id = '$roleid'";
                          $rlot = mysqli_query($connection, $quyd);
                          $tolm = mysqli_fetch_array($rlot);
                          $vaul = $tolm['vault_email'];
                          
                          if ($vaul == 1 || $vaul == "1") {
         // mailin
                            // begining of mail
                            $mail = new PHPMailer;
                            // from email addreess and name
                            $mail->From = $int_email;
                            $mail->FromName = $int_name;
                            // to adress and name
                            $mail->addAddress($remail, $username);
                            // reply address
                            //Address to which recipient will reply
                            // progressive html images
                            $mail->addReplyTo($int_email, "Reply");
                            // CC and BCC
                            //CC and BCC
                            // $mail->addCC("cc@example.com");
                            // $mail->addBCC("bcc@example.com");
                            // Send HTML or Plain Text Email
                            $mail->isHTML(true);
                            $mail->Subject = "Vault Alert From ".$int_name;
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
                                      <img style='margin-left: 200px; margin-right: auto; height:150px; width:150px;'class='img' src='$int_logo'/>
                                  </div>
                              </div>
                                  <div class='main'>
                                      <div class='text'>
                                          Dear $clientt_name,
                                          <h2 style='text-align:center;'>Notification of Vault Alert</h2>
                                          this is to notify you that a Bank transaction has been made in $int_name,
                                           by $nm Kindly confirm with your bank.<br/><br/>
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
                                              <td > <b>From</b></td>
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
                                     // mail system
                                     if(!$mail->send()) 
                                     {
                                       $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
                                       echo "sent";
                                      //  echo header ("Location: ../mfi/teller_journal.php?message6=$randms");
                                      $URL="../mfi/teller_journal.php?message6=$randms";

                       echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                                     } else
                                     {
                                       $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
                                       echo "error";
                                      //  echo header ("Location: ../mfi/teller_journal.php?message1=$randms");
                                      $URL="../mfi/teller_journal.php?message1=$randms";

                       echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                                     }
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
else if($amount >= $glbalance){
    $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
   echo "error";
  echo header ("Location: ../mfi/teller_journal.php?message11=$randms");
}
    }
    else{
        $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
           echo "error";
          echo header ("Location: ../mfi/teller_journal.php?message5=$randms");
    }
  }
  else{
    $_SESSION["Lack_of_intfund_$randms"] = "";
    echo "error";
    echo header ("Location: ../mfi/teller_journal.php?message10=$randms");
}
}
?>