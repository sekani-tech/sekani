<?php
include("connect.php");
session_start();
require_once "../bat/phpmailer/PHPMailerAutoload.php";

$int_name = $_SESSION["int_name"];
$int_email = $_SESSION["int_email"];
$int_web = $_SESSION["int_web"];
$int_phone = $_SESSION["int_phone"];
$int_logo = $_SESSION["int_logo"];
$int_address = $_SESSION["int_address"];
$sessint_id = $_SESSION["int_id"];
$staff_id = $_SESSION["user_id"];
$staff_name  = strtoupper($_SESSION["username"]);
?>
<?php
$acct_no = $_POST['account_no'];
$amt = $_POST['collect'];
$pm = $_POST['payment_method'];
$ti = $_POST['transid'];
$exp_amt = $_POST['exp_amt'];

if ($exp_amt == "NAN" || $exp_amt == "" || $exp_amt == 0) {
    $_SESSION["Lack_of_intfund_$randms"] = "No Active Loan";
    echo header ("Location: ../mfi/transact.php?loan4=$randms");
} else {
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
        }
    }
$person = mysqli_query($connection, "SELECT loan.interest_rate, client.id, client.loan_status, client.account_no, loan.id, client.branch_id, loan.product_id, principal_amount, loan_term, loan.interest_rate FROM loan JOIN client ON loan.client_id = client.id WHERE client.int_id ='$sessint_id' && client_id = '$client_id'");
 if (count([$person]) == 1) {
   $x = mysqli_fetch_array($person);
   $pa = $x['principal_amount'];
    $brh = $x['branch_id'];
    $lsss = $x['loan_status'];
    $p_id = $x['product_id'];
    $account_no = $x['account_no'];
    $interest_R = $x['interest_rate'];
    $lt = $x['loan_term'];
    $ln_id = $x['id'];
    $expa = $pa / $lt;
    $nin = mysqli_query($connection, "SELECT name FROM branch WHERE id ='$brh'");
 if (count([$nin]) == 1) {
    $g = mysqli_fetch_array($nin);
    $branch_name = $g['name'];
 }
// transaction id generation
    $sessint_id = $_SESSION["int_id"];
    $inttest = str_pad($sessint_id, 3, '0', STR_PAD_LEFT);
    $digits = 4;
    $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
    $transid = $inttest."-".$randms;
//  run a query to display clientm name         
}

$clamt = $amt - $expa;
$trans_type = "Loan Repayment";

$gms = "Pending";

if ($lsss == "Active") {
if ($clamt >= 0) {
    $trancache = "INSERT INTO transact_cache (int_id, transact_id, account_no, client_id, client_name, staff_id, account_off_name, amount, pay_type, transact_type, status) VALUES
                ('{$sessint_id}', '{$ti}', '{$acct_no}', '{$client_id}', '{$clientt_name}', '{$staff_id}', '{$staff_name}', '{$amt}', '{$pm}', '{$trans_type}', '{$gms}') ";
                $go = mysqli_query($connection, $trancache);
                if ($go) {
                   $_SESSION["Lack_of_intfund_$randms"] = "Withdrawal Successful!";
                  echo header ("Location: ../mfi/transact.php?loan1=$randms");
                  // Start mail
$mail = new PHPMailer;
// from email addreess and name
$mail->From = $int_email;
$mail->FromName = $int_name;
// to adress and name
$mail->addAddress($email, $username);
// reply address
//Address to which recipient will reply
// progressive html images
$mail->addReplyTo($intemail, "Reply");
// CC and BCC
//CC and BCC
// $mail->addCC("cc@example.com");
// $mail->addBCC("bcc@example.com");
// Send HTML or Plain Text Email
$mail->isHTML(true);
$mail->Subject = "Transaction Alert from $int_name";
$mail->Body = "
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'> <!-- utf-8 works for most cases -->
        <meta name='viewport' content='width=device-width'> <!-- Forcing initial-scale shouldn't be necessary -->
        <meta http-equiv='X-UA-Compatible' content='IE=edge'> <!-- Use the latest (edge) version of IE rendering engine -->
        <meta name='x-apple-disable-message-reformatting'>  <!-- Disable auto-scale in iOS 10 Mail entirely -->
        <title> DGMFB</title> <!-- The title tag shows in email notifications, like Android 4.4. -->
    
    
        <link href='https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i' rel='stylesheet'>
    
        <!-- CSS Reset : BEGIN -->
    <style>
        .head{
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .logo{
            border: 1px solid black;
            height: 150px;
            width: 900px;
            margin-bottom: 20px;
        }
        .dear{
            border:black;
            height: 30px;
            width: 900px;
        }
        .message{
            color: black;
            padding-bottom: 20px;
        }
        .grid-container{
            display: grid;
            grid-column-gap: 10px;
            grid-template-columns: 150px 150px;
            padding: 20px;
        }
        .col{
            display: inline-block;
        }
        img{
            margin: 30px;
            width: 100px;
            height: 100px;
            float: right;
        }
    </style>
    <body>
        <div class='head'>
            
            <div class='logo'>
                <img src='./instimg/goku gt.jpg'></img>
                <h4>Date: 4/2/2020</h4>
            </div>
            <div>
                <div class='dear'>
                <b>Dear $clientt_name,</b>
                </div>
                <div class='message'>
                    <u>$int_name Notification alert</u><br/>
                   <p>We wish to inform you that a transaction has been made on your account with us.</br>
                    The details of the transaction are shown below:</p> 
                </div>
                <div class='message'>
                <u> Transaction Notification;</u><br/>
                <div class='grid-container'>
                    <div class='row'><p> Account Number</p></div>
                    <div class='row'><p>: $tryacc</p></div>
                    <div class='row'><p>Branch</p></div>
                    <div class='row'><p>: $branch_name</p></div>
                    <div class='row'><p>Description</p></div>
                    <div class='row'><p>: Credit transaction</p></div>
                    <div class='row'><p>Amount</p></div>
                    <div class='row'><p>: $amt</p></div>
                    <div class='row'><p>Value Date</p></div>
                    <div class='row'><p>5/2/2020</p></div>
                    
                </div>
              
                <u>Account Balance are as follows:</u>
                   <P>Current Balance: 157,000</P> 
                   <p>Available Balance: 157,000</p> 
                </div>
                <div>
                    Thank you for choosing DGMFB.
                </div>
            </div>
        </div>
    </body>
</html>
";
$mail->AltBody = "This is the plain text version of the email content";
// mail system
if(!$mail->send()) 
{
    echo "Mailer Error: " . $mail->ErrorInfo;
} else
{
    echo $xm = "Changing Password?";
}
  // end Mail system
                } else {
                   $_SESSION["Lack_of_intfund_$randms"] = "Withdrawal Failed";
                  echo header ("Location: ../mfi/transact.php?loan2=$randms");
                }
} else if ($clamt < 0) {
    $_SESSION["Lack_of_intfund_$randms"] = "Amount Less Than Expected Amount";
    echo header ("Location: ../mfi/transact.php?loan3=$randms");
}

} else {
    $_SESSION["Lack_of_intfund_$randms"] = "No Active Loan";
    echo header ("Location: ../mfi/transact.php?loan4=$randms");
}
}
?>