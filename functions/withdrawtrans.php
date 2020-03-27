<?php
include("connect.php");
session_start();
$sessint_id = $_SESSION["int_id"];
?>
<?php
$test2 = $_POST['test2'];
$acct_no2 = $_POST['account_no2'];
$amt2 = $_POST['amount2'];
$type2 = $_POST['pay_type2'];
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);

 $runaccount = mysqli_query($connection, "SELECT * FROM account WHERE account_no='$acct_no2' && int_id = '$sessint_id' ");
     if (count([$runaccount]) == 1) {
         $x = mysqli_fetch_array($runaccount);
         $brnid = $x['branch_id'];
         $tryacc = $x['account_no'];
         $product_id = $x['product_id'];
         $acct_b_d = $x['account_balance_derived'];
         $client_id = $x['client_id'];

         if ($acct_no2 == $tryacc) {
            if ($test2 == "withdraw") {
                if ($acct_b_d >= $amt2) {
                    $wd = "Withdrawal";
                    $gms = "Not Verified";
                 $trancache = "INSERT INTO transact_cache (int_id, account_no, client_id, amount, pay_type, transact_type, product_type, status) VALUES
                 ('{$sessint_id}', '{$acct_no2}', '{$client_id}', '{$amt2}', '{$type2}', '{$gms}', '{$product_id}', '{$gms}') ";
                 if ($trancache) {
                    $_SESSION["Lack_of_intfund_$randms"] = "Withdrawal Successful!";
                   echo header ("Location: ../mfi/transact.php?message3=$randms");
                 } else {
                    $_SESSION["Lack_of_intfund_$randms"] = "Withdrawal Failed";
                   echo header ("Location: ../mfi/transact.php?message4=$randms");
     
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
    //  if ($connection->error) {
    //          try {
    //              throw new Exception("MYSQL error $connection->error <br> $runaccount ", $mysqli->error);
    //          } catch (Exception $e) {
    //              echo "Error No: ".$e->getCode()." - ".$e->getMessage() . "<br>";
    //              echo n12br($e->getTraceAsString());
    //          }
    //  }
?>