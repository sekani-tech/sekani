<?php
include("connect.php");
session_start();
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