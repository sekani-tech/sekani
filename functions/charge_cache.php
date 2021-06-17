<?php
// called database connection
include("connect.php");
// user management
session_start();

?>
<?php
if(isset($_POST['transid'])){
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$sessint_id = $_SESSION["int_id"];
$branch_id = $_SESSION["branch_id"];
$users = $_SESSION["user_id"];
$e = mysqli_query($connection, "SELECT * FROM staff WHERE user_id ='$users'");
$r = mysqli_fetch_array($e);
$staff_id = $r['id'];

if(isset($_POST['charge'])){
  $charges = $_POST['charge'];
}
else{
  $charges = "0000";
}
$client = $_POST['client_id'];
$transid = $_POST['transid'];
$descrip = $_POST['descrip'];
$acct_no = $_POST['acct_no'];
$date = date('Y-m-d H:i:s');

$taketeller = "SELECT * FROM tellers WHERE name = '$staff_id' && int_id = '$sessint_id'";
$check_me_men = mysqli_query($connection, $taketeller);
if ($check_me_men) {
    $ex = mysqli_fetch_array($check_me_men);
$is_del = $ex["is_deleted"];
$till = $ex["till"];
$post_limit = $ex["post_limit"];
$till_no = $ex["till_no"];
$till_name = $ex["name"];

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

// credit checks and accounting rules
$don = mysqli_query($connection, "SELECT * FROM charge WHERE id = '$charges'");
$s = mysqli_fetch_array($don);
$amount = $s['amount'];
$pay_type = $s['gl_code'];
// insertion query for product
$query4 = "SELECT client.firstname, client.lastname, account.product_id, account.account_no, account.total_withdrawals_derived, account.account_balance_derived FROM client JOIN account ON client.account_no = account.account_no WHERE client.int_id = '$sessint_id' AND client.id ='$client' AND account.account_no = '$acct_no'";
$queryexec = mysqli_query($connection, $query4);
$b = mysqli_fetch_array($queryexec);
$accbal = $b['account_balance_derived'];
$ttl = $b['total_withdrawals_derived'];
$acc_no = $b['account_no'];
$sproduct_id = $b['product_id'];
$clientname = $b['firstname']." ".$b['lastname'];

$reor = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE gl_code='$pay_type'");
$ron = mysqli_fetch_array($reor);
$glbalance = $ron['organization_running_balance_derived'];

$newglball = $glbalance + $amount;
$ttlwith = $ttl + $amount;
$newbal = $accbal - $amount;

        // update the clients transaction
        $description = "Fee on charges";
        $trans_type ="debit";
        $irvs = "0";
        $iat = "INSERT INTO client_charge (int_id, branch_id, client_id, acct_id, transact_id, charge_id, amount, description, date, approved)
         VALUES ('{$sessint_id}', '{$branch_id}', '{$client}', '{$acct_no}', '{$transid}', '{$charges}', '{$amount}', '{$descrip}', '{$date}', '1')";
        $res3 = mysqli_query($connection, $iat);
                   if ($res3) {
                    $_SESSION["Lack_of_intfund_$randms"] = " was updated successfully!";
                          // success
                          echo header ("Location: ../mfi/transact.php?message1=$randms");
                        } else {
                           $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
                           echo "error";
                          echo header ("Location: ../mfi/transact.php?message2=$randms");
                            // echo header("location: ../mfi/client.php");
                        }
              }
              else {
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
          }
// if ($connection->error) {
//   try {   
//       throw new Exception("MySQL error $connection->error <br> Query:<br> $query", $mysqli->error);   
//   } catch(Exception $e ) {
//       echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
//       echo nl2br($e->getTraceAsString());
//   }
// }
?>