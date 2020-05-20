<?php
include("connect.php");
session_start();
?>
<?php
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
    $transdate = date('Y-m-d');
    $crdate = date('Y-m-d H:m:s');
    $vault = mysqli_query($connection, "SELECT * FROM int_vault WHERE branch_id = '$branchid' && int_id = '$sint_id'");
    $itb = mysqli_fetch_array($vault);
    $vault_limit = $itb['movable_amount'];

    if($type == "vault_in"){
        if($amount >= $vault_limit){
            $_SESSION["Lack_of_intfund_$randms"] = "";
               echo "error";
              echo header ("Location: ../mfi/teller_journal.php?message=$randms");
        }
        else{
            if($tellbalance > $amount){
                $new_tellbalance = $tellbalance - $amount;
                $new_vaultbalance = $balance + $amount;
    
                $vaultinquery = "UPDATE institution_account SET account_balance_derived = '$new_tellbalance' WHERE teller_id = '$tid'";
                $ein = mysqli_query($connection, $vaultinquery);
                $description = "Deposited into Vault";
                if($ein){
                    $vaultinquery2 = "UPDATE int_vault SET balance = '$new_vaultbalance', last_deposit = '$amount' WHERE int_id = '$sint_id'";
                    $on = mysqli_query($connection, $vaultinquery2);
                    if($on){
                        $record ="INSERT INTO institution_account_transaction (int_id, branch_id,
                        transaction_id, description, transaction_type, teller_id, is_reversed,
                        transaction_date, amount, running_balance_derived, overdraft_amount_derived,
                        created_date, appuser_id, credit) VALUES ('{$sint_id}','{$branchid}', '{$transact_id}','{$description}',
                        '{$type}', '{$tid}', '0', '{$transdate}', '{$amount}', '{$amount}','{$amount}', '{$crdate}',
                        '{$tid}', '{$amount}')";
                       $rin = mysqli_query($connection, $record);
                    if($rin){
                        $_SESSION["Lack_of_intfund_$randms"] = "";
                        echo "error";
                        echo header ("Location: ../mfi/teller_journal.php?message1=$randms");
                    }
                    else{
                        $_SESSION["Lack_of_intfund_$randms"] = "";
                        echo "error";
                        echo header ("Location: ../mfi/teller_journal.php?message5=$randms");
                    }
                }
                }
            }
            elseif($amount >= $tellbalance){
                $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
               echo "error";
              echo header ("Location: ../mfi/teller_journal.php?message2=$randms");
            }
        }
    }
    else if($type == "vault_out"){
        if($balance > $amount){
                $new_tellbalance = $tellbalance + $amount;
                $new_vaultbalance = $balance - $amount;
    
                $vaultinquery = "UPDATE institution_account SET account_balance_derived = '$new_tellbalance' WHERE teller_id = '$tid' && int_id = '$sint_id'";
                $ein = mysqli_query($connection, $vaultinquery);
                $description = "Withdrawn from vault";
                if($ein){
                    $vaultinquery2 = "UPDATE int_vault SET balance = '$new_vaultbalance', last_withdrawal = '$amount' WHERE int_id = '$sint_id'";
                    $on = mysqli_query($connection, $vaultinquery2);
                    if($on){
                        $record ="INSERT INTO institution_account_transaction (int_id, branch_id,
                        transaction_id, description, transaction_type, teller_id, is_reversed,
                        transaction_date, amount, running_balance_derived, overdraft_amount_derived,
                        created_date, appuser_id, debit) VALUES ('{$sint_id}','{$branchid}', '{$transact_id}','{$description}',
                        '{$type}', '{$tid}', '0', '{$transdate}', '{$amount}', '{$amount}','{$amount}', '{$crdate}',
                        '{$tid}', '{$amount}')";
                        $rin = mysqli_query($connection, $record);
                    if($rin){
                        $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
                        echo "error";
                        echo header ("Location: ../mfi/teller_journal.php?message3=$randms");
                    }
                    else{
                        $_SESSION["Lack_of_intfund_$randms"] = "";
                        echo "error";
                        echo header ("Location: ../mfi/teller_journal.php?message5=$randms");
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