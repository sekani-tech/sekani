<?php
include("connect.php");
session_start();
require_once "../bat/phpmailer/PHPMailerAutoload.php";
?>

<?php
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
                        // echo a successful message
            $mail = new PHPMailer;
            $mail->From = $int_email;
            $mail->FromName = $int_name;
            $mail->addAddress('hesanmal316@gmail.com');
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
                            <span> <b>$int_name</b> </span> || <span class='lead' style='font-size: 13px;'> $int_address </span>
                        </div>
                      </div>
                    </div>
                    <div class='row'>
                      <div class='col col-lg-12'>
                        <div class='shadow-sm p-3 mb-5 bg-white rounded'>$crdate
                            <div>
                                <!-- fot the ext bod -->
                                <p><b>Dear Director/b></p>
                                <p>We wish to inform you that a <b>Vault - In</b> transaction recently occurred in your Vault.
                                Please find below details of the transaction:</p>
                            </div>
                            <p>
                                <div class='shadow p-3 mb-5 bg-white rounded'>Transaction Details - <b>Vault - In</b></div>
                                <table class='table table-borderless'>
                                    <tbody>
                                        <div>
                                      <tr>
                                        <td style='font-size: 12px;'> <b>Transfer From</b></td>
                                        <td style='font-size: 12px;'>$tellname</td>
                                      </tr>
                                      <tr>
                                        <td style='font-size: 12px;'> <b>Description</b></td>
                                        <td style='font-size: 12px;'>$description</td>
                                      </tr>
                                      <tr>
                                        <td style='font-size: 12px;'> <b>Reference Id</b></td>
                                        <td style='font-size: 12px;'>$transact_id</td>
                                      </tr>
                                      <tr>
                                        <td style='font-size: 12px;'> <b>Transaction Amount</b></td>
                                        <td style='font-size: 12px;'>&#8358; $amt</td>
                                      </tr>
                                      <tr>
                                        <td style='font-size: 12px;'> <b>Transaction Date/Time</b></td>
                                        <td style='font-size: 12px;'>$transdate</td>
                                      </tr>
                                      <tr>
                                        <td style='font-size: 12px;'> <b>Account Balance</b></td>
                                        <td style='font-size: 12px;'>&#8358; $blnc</td>
                                      </tr>
                                    </tbody>
                                </div>
                                  </table>
                            </p>
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
                $_SESSION["Lack_of_intfund_$randms"] = "";
                echo "error";
                echo header ("Location: ../mfi/teller_journal.php?message6=$randms");
               } else
               {
                $_SESSION["Lack_of_intfund_$randms"] = "";
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
                        $mail = new PHPMailer;
            $mail->From = $int_email;
            $mail->FromName = $int_name;
            $mail->addAddress('hesanmal316@gmail.com');
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
                            <span> <b>$int_name</b> </span> || <span class='lead' style='font-size: 13px;'> $int_address </span>
                        </div>
                      </div>
                    </div>
                    <div class='row'>
                      <div class='col col-lg-12'>
                        <div class='shadow-sm p-3 mb-5 bg-white rounded'>$crdate
                            <div>
                                <!-- fot the ext bod -->
                                <p><b>Dear Director/b></p>
                                <p>We wish to inform you that a <b>Vault - Out</b> transaction recently occurred in your Vault.
                                Please find below details of the transaction:</p>
                            </div>
                            <p>
                                <div class='shadow p-3 mb-5 bg-white rounded'>Transaction Details - <b>Vault - In</b></div>
                                <table class='table table-borderless'>
                                    <tbody>
                                        <div>
                                      <tr>
                                        <td style='font-size: 12px;'> <b>Transfer From</b></td>
                                        <td style='font-size: 12px;'>$tellname</td>
                                      </tr>
                                      <tr>
                                        <td style='font-size: 12px;'> <b>Description</b></td>
                                        <td style='font-size: 12px;'>$description</td>
                                      </tr>
                                      <tr>
                                        <td style='font-size: 12px;'> <b>Reference Id</b></td>
                                        <td style='font-size: 12px;'>$transact_id</td>
                                      </tr>
                                      <tr>
                                        <td style='font-size: 12px;'> <b>Transaction Amount</b></td>
                                        <td style='font-size: 12px;'>&#8358; $amt</td>
                                      </tr>
                                      <tr>
                                        <td style='font-size: 12px;'> <b>Transaction Date/Time</b></td>
                                        <td style='font-size: 12px;'>$transdate</td>
                                      </tr>
                                      <tr>
                                        <td style='font-size: 12px;'> <b>Account Balance</b></td>
                                        <td style='font-size: 12px;'>&#8358; $blnc</td>
                                      </tr>
                                    </tbody>
                                </div>
                                  </table>
                            </p>
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
                $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
                echo "error";
                echo header ("Location: ../mfi/teller_journal.php?message6=$randms");
               } else
               {
                $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
                echo "error";
                echo header ("Location: ../mfi/teller_journal.php?messag3=$randms");
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