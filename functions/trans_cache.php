<?php
include("connect.php");
session_start();
require_once "../bat/phpmailer/PHPMailerAutoload.php";
?>

<?php
// Session data declaration
$emailu = $_SESSION["email"]; 
$int_name = $_SESSION["int_name"];
$int_email = $_SESSION["int_email"];
$int_web = $_SESSION["int_web"];
$int_phone = $_SESSION["int_phone"];
$int_logo = $_SESSION["int_logo"];
$int_address = $_SESSION["int_address"];
$sessint_id = $_SESSION["int_id"];
$nm = $_SESSION["username"];
$sint_id = $_SESSION['int_id'];
$user_id = $_SESSION["user_id"];
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$getacct1 = mysqli_query($connection, "SELECT * FROM staff WHERE user_id = '$user_id' && int_id = '$sint_id'");
if (count([$getacct1]) == 1) {
    $uw = mysqli_fetch_array($getacct1);
    $staff_id = $uw["id"];
    $staff_email = $uw["email"];
}
$taketeller = "SELECT * FROM tellers WHERE name = '$staff_id' && int_id = '$sint_id'";

if(isset($_POST['transact_id'])){
    // Declaring Variables
    $trans_id = $_POST['transact_id'];
    $trans_from = $_POST['transfrom'];
    $amount = $_POST['amount'];
    $trans_to = $_POST['transto'];
    $branch_id = $_POST['branch'];
    $credit = "credit";
    $debit = "debit";
    $irvs = 0;
    $trans_date = date('Y-m-d h:m:s');

    $query3 = "SELECT client.firstname, client.lastname, account.product_id, account.account_no, account.id, account.total_withdrawals_derived, account.account_balance_derived FROM client JOIN account ON client.account_no = account.account_no WHERE client.int_id = '$sint_id' AND client.id ='$trans_from'";
    $querexec = mysqli_query($connection, $query3);
    $a = mysqli_fetch_array($querexec);
    $transnameone = strtoupper($a['firstname']." ". $a['lastname']);
    $accountone = $a['account_no'];
    $accprid = $a['product_id'];
    $accidone = $a['id'];
    $accountbalone = $a['account_balance_derived'];
    $ttlwithdrawal = $a['total_withdrawals_derived'];

    // Get the account data for the recipient 
    $query4 = "SELECT client.firstname, client.lastname, account.product_id, account.account_no, account.id, account.total_deposits_derived, account.account_balance_derived FROM client JOIN account ON client.account_no = account.account_no WHERE client.int_id = '$sint_id' AND client.id ='$trans_to'";
    $queryexec = mysqli_query($connection, $query4);
    $b = mysqli_fetch_array($queryexec);
    $transnametwo = strtoupper($b['firstname']." ". $b['lastname']);
    $accountbaltwo = $b['account_balance_derived'];
    $accounttwo = $b['account_no'];
    $accprdid = $b['product_id'];
    $accidtwo = $b['id'];
    $ttldeposit = $b['total_deposits_derived'];

    // Code is to check if User making transaction is a teller
    $check_me_men = mysqli_query($connection, $taketeller);
    if(count([$check_me_men]) > 0){
        // if account being transferred from is greater than amount, proceed to code
        if($accountbalone >= $amount){
            $auponres = "INSERT INTO `transfer_cache` (`int_id`, `branch_id`, `account_officer_id`, `transact_id`, `trans_from`, `amount`, `trans_to`, `trans_date`,`status`)
             VALUES ('$sessint_id', '$branch_id', '$staff_id', '$trans_id', '$trans_from', '$amount', '$trans_to', current_timestamp(), 'Pending')";
            // update the depositor transaction
            $rsd= mysqli_query($connection, $auponres);
           if($rsd){
                //  Transaction Successful
            $_SESSION["Lack_of_intfund_$randms"] = "TELLER";
            echo header ("Location: ../mfi/bank_transfer.php?message2=$randms");
           }
        }
        else{
             // Not enough money in the bank account
            $_SESSION["Lack_of_intfund_$randms"] = "TELLER";
            echo header ("Location: ../mfi/bank_transfer.php?message1=$randms");
        }
    }
    else{
    // you're not authorized not a teller
    $_SESSION["Lack_of_intfund_$randms"] = "TELLER";
    echo header ("Location: ../mfi/bank_transfer.php?message0=$randms");
    }
}
?>
