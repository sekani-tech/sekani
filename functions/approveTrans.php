<?php
include("connect.php");
session_start();
?>
<?php
if (isset($_GET['approve']) && $_GET['approve'] !== '') {
    $appod = $_GET['approve'];
    $checkm = mysqli_query($connection, "SELECT * FROM transact_cache WHERE id = '$appod'");
    if (count([$checkm]) == 1) {
        $x = mysqli_fetch_array($checkm);
        $ssint_id = $_SESSION["int_id"];
        $appuser_id = $_SESSION["user_id"];
        $acct_no = $x['account_no'];
        $staff_id = $x['staff_id'];
        $amount = $x['amount'];
        $pay_type = $x['pay_type'];
        $transact_type = $x['transact_type'];
        $product_type = $x['product_type'];
        $stat = $x['status'];
        $gen_date = date("Y-m-d");
        $digits = 4;
        $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
        $transid = $ssint_id."-".$randms;

        if ($stat == "Not Verified") {
            $getacct = mysqli_query($connection, "SELECT * FROM account WHERE account_no = '$acct_no'");
            if (count([$getacct]) == 1) {
               $y = mysqli_fetch_array($getacct);
               $branch_id = $y['branch_id'];
               $acct_no = $y['account_no'];
               $client_id = $y['client_id'];
               $int_acct_bal = $x['account_balance_derived'];
               $comp = $amount + $int_acct_bal;
               $comp2 = $int_acct_bal - $amount;
               $trans_type = "credit";
               $trans_type2 = "debit";
               $irvs = 0;
    
            //    account deposite computation
              if($transact_type == "Deposit") {
                $new_abd = $comp;
                $iupq = "UPDATE account SET account_balance_derived = '$new_abd',
                total_deposits_derived = '$amount' WHERE account_no = '$acct_no'";
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
                        $iupqx = "UPDATE transact_cache SET `status` = '$v' WHERE id = '$appod'";
                        $res4 = mysqli_query($connection, $iupqx);
                        if ($res4) {
                            $_SESSION["Lack_of_intfund_$randms"] = "Successfully Approved";
                            echo header ("Location: ../mfi/transact_approval.php?message1=$randms");
                        } else {
                            $_SESSION["Lack_of_intfund_$randms"] = "Error updating Cache";
                            echo header ("Location: ../mfi/transact_approval.php?message2=$randms");
                        }
                        
                    } else {
                        $_SESSION["Lack_of_intfund_$randms"] = "Error in Transaction";
                        echo header ("Location: ../mfi/transact_approval.php?message2=$randms");
                    }
                } else {
                    $_SESSION["Lack_of_intfund_$randms"] = "Error in Account";
                        echo header ("Location: ../mfi/transact_approval.php?message2=$randms");
                }
              } else if ($transact_type == "Withdrawal") {
                $new_abd2 = $comp2;
                $iupq = "UPDATE account SET account_balance_derived = '$new_abd2',
                total_withdrawals_derived  = '$amount' WHERE account_no = '$acct_no'";
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
                        $iupqx = "UPDATE transact_cache SET `status` = '$v' WHERE id = '$appod'";
                        $res4 = mysqli_query($connection, $iupqx);
                        if ($res4) {
                            $_SESSION["Lack_of_intfund_$randms"] = "Successfully Approved";
                            echo header ("Location: ../mfi/transact_approval.php?message1=$randms");
                        } else {
                            $_SESSION["Lack_of_intfund_$randms"] = "Error updating Cache";
                            echo header ("Location: ../mfi/transact_approval.php?message2=$randms");
                        }
                    } else {
                        $_SESSION["Lack_of_intfund_$randms"] = "Error in Transaction";
                        echo header ("Location: ../mfi/transact_approval.php?message2=$randms");
                    }
                } else {
                    $_SESSION["Lack_of_intfund_$randms"] = "Error in Account";
                        echo header ("Location: ../mfi/transact_approval.php?message2=$randms");
                }
              } else {
                $_SESSION["Lack_of_intfund_$randms"] = "Error No With or Dep";
                echo header ("Location: ../mfi/transact_approval.php?message2=$randms");
               }

            }
        } else {
            // a message
            $_SESSION["Lack_of_intfund_$randms"] = "Transaction Has Been Verified Already";
                echo header ("Location: ../mfi/transact_approval.php?message3=$randms");
        }
    }
}
?>