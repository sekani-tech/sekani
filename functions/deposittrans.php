<?php
include("connect.php");
session_start();
$sessint_id = $_SESSION["int_id"];
?>
<?php
$test = $_POST['test'];
$acct_no = $_POST['account_no'];
$amt = $_POST['amount'];
$type = $_POST['pay_type'];
 $runaccount = mysqli_query($connection, "SELECT * FROM account WHERE account_no ='$acct_no' && int_id = '$sessint_id' ");
     if (count([$runaccount]) == 1) {
         $x = mysqli_fetch_array($runaccount);
         $brnid = $x['branch_id'];
         $tryacc = $x['account_no'];
         $product_id = $x['product_id'];
         $acct_b_d = $x['account_balance_derived'];
         $client_id = $x['client_id'];
         $digits = 6;
         $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
 
         if ($acct_no == $tryacc) {
            if ($test == "deposit") {
                $dd = "Deposit";
                $ogs = "Not Verified";
                $trancache = "INSERT INTO transact_cache (int_id, account_no, client_id, amount, pay_type, transact_type, product_type, status) VALUES ('{$sessint_id}', '{$acct_no}', '{$client_id}', '{$amt}', '{$type}', '{$dd}', '{$product_id}', '{$ogs}')";
                $go = mysqli_query($connection, $trancache);
                if ($go) {
                  $_SESSION["Lack_of_intfund_$randms"] = "Deposit Has Been Done, Awaiting Approval!";
                   echo header ("Location: ../mfi/transact.php?message=$randms");
                } else {
                   $_SESSION["Lack_of_intfund_$randms"] = "Transaction Failed";
                   echo header ("Location: ../mfi/transact.php?message2=$randms");
               //      if ($connection->error) {
               //          try {
               //              throw new Exception("MYSQL error $connection->error <br> $trancache ", $mysqli->error);
               //          } catch (Exception $e) {
               //              echo "Error No: ".$e->getCode()." - ".$e->getMessage() . "<br>";
               //              echo n12br($e->getTraceAsString());
               //          }
               //  }
                }
            } else {
                echo "Not equal to deposit";
            }
         } else {
            $_SESSION["Lack_of_intfund_$randms"] = "Account not Found";
            echo header ("Location: ../mfi/transact.php?message7=$randms");
         }
    }
//      if ($connection->error) {
//              try {
//                  throw new Exception("MYSQL error $connection->error <br> $runaccount ", $mysqli->error);
//              } catch (Exception $e) {
//                  echo "Error No: ".$e->getCode()." - ".$e->getMessage() . "<br>";
//                  echo n12br($e->getTraceAsString());
//     }
// }
?>