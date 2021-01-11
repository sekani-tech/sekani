<?php
// include connection page 
include("../connect.php");
session_start();

$institutionID = $_SESSION["int_id"];

// the staff carrying out this operation
$staff = $_SESSION['user_id'];

if (isset($_POST['id']) && isset($_POST['account_number'])) {
    $accountTransactionId = $_POST['id'];
    // $amount =  $_POST['amount'];
    // Collect all the information in the needed row
    $findTransaction = mysqli_query($connection, "SELECT * FROM account_transaction WHERE id = '$accountTransactionId'");
    
    if ($findTransaction) {
        // Put data into an array
        $transactionData =  mysqli_fetch_array($findTransaction);
        $clientId =  $transactionData['client_id'];
        $amount = $transactionData['amount'];
        $transactionType = $transactionData['transaction_type'];
        $accountNumber =  $transactionData['account_no'];
        $transactionDate = $transactionData['transaction_date'];
        $transactionId = $transactionData['transaction_id'];
        $tellerId = $transactionData['teller_id'];

        // find account details from account table and deduct the current balance
        $findAccount = mysqli_query($connection, "SELECT * FROM account WHERE account_no = '$accountNumber' AND client_id = '$clientId'");
        
        if ($findAccount) {
            // Put account data into an array
            $accountData = mysqli_fetch_array($findAccount);
            $accountBalance = $accountData['account_balance_derived'];
            // check transaction type and calculate reversal account balance amount as needed.
            if ($transactionType = "credit") {
                $reversedBalance = $accountBalance - $amount;
            } else if ($transactionType = "debit") {
                $reversedBalance = $accountBalance + $amount;
            } 
            else if ($transactionType = "") {
                echo '<script type="text/javascript">
                                    $(document).ready(function(){
                                        swal({
                                            type: "error",
                                            title: "Reversal Transaction",
                                            text: "Transaction type Narration is not correct",
                                            showConfirmButton: false,
                                            timer: 2000
                                        })
                                    });
                                    </script>
                                    ';
                $URL = "../../mfi/client_statement.php";
                echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
            }
            // check if the teller exists first
            if ($tellerId !== "") {
                // insert new value into account
                $updateAccount = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$reversedBalance' WHERE account_no = '$accountNumber' AND client_id =  '$clientId'");
                // var_dump($updateAccount);
                if ($updateAccount) {
                    // Find insitution account data first
                    $findInstitutionAccount = mysqli_query($connection, "SELECT * FROM institution_account WHERE teller_id = '$tellerId' AND '$institutionID'");
                    
                    if (count([$findInstitutionAccount]) == 1) {
                        $institutionAccountData =  mysqli_fetch_array($findInstitutionAccount);
                        $insitutionAccountBalance = $institutionAccountData['account_balance_derived'];
                        
                        if ($transactionType = "credit") {
                            $newBalance = $insitutionAccountBalance - $amount;
                        } else if ($transactionType = "debit") {
                            $newBalance = $insitutionAccountBalance + $amount;
                        }
                        // Update the institution account
                        $updateInstitutionAccount = mysqli_query($connection, "UPDATE institution_account SET account_balance_derived = '$newBalance' WHERE teller_id = '$tellerId' AND '$institutionID'");
                        
                        if ($updateInstitutionAccount) {
                            // Store reversal data
                            $reversal = mysqli_query($connection, "INSERT INTO reversal (int_id, account_no, client_id, transaction_id, transact_date, staff_id, teller_id, amount_reversed, account_balance_derived) 
                            VALUES ('$institutionID', '$accountNumber', '$clientId', '$transactionId', '$transactionDate', '$staff', '$tellerId', '$amount', '$reversedBalance')");
                            // var_dump($reversal);
                            // after successfully inserting data into the DB we would go on to delete the transactions information in account_transaction and institution_account_transaction
                            if ($reversal) {
                                $deleteInstitutionTransaction = mysqli_query($connection, "DELETE FROM institution_account_transaction WHERE transaction_id = '$transactionId' AND teller_id = '$tellerId'");
                                if ($deleteInstitutionTransaction) {
                                    $deleteTransactionRecord = mysqli_query($connection, "DELETE FROM account_transaction WHERE id = '$accountTransactionId'");
                                    if ($deleteTransactionRecord) {
                                        $_SESSION["reversal"] = 1;
                                        $_SESSION["client_id"] = $_POST['id'];
                                        $_SESSION["start"] = $_POST["start"];
                                        $_SESSION["end"] = $_POST["end"];
                                        $_SESSION["account_id"] = $_POST["account_id"];

                                        $URL = "../../mfi/client_statement.php";
                                        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                                    }
                                    // Could not delete transaction record.
                                    else {
                                        echo '<script type="text/javascript">
                                        $(document).ready(function(){
                                            swal({
                                                type: "error",
                                                title: "Reversal Transaction",
                                                text: "Could not Delete Transaction Record",
                                                showConfirmButton: false,
                                                timer: 2000
                                            })
                                        });
                                        </script>
                                        ';
                                        $URL = "../../mfi/client_statement.php";
                                        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                                    }
                                } 
                                else {
                                    echo '<script type="text/javascript">
                                    $(document).ready(function(){
                                        swal({
                                            type: "error",
                                            title: "Reversal Transaction",
                                            text: "Could not Delete Record from Tellers Till",
                                            showConfirmButton: false,
                                            timer: 2000
                                        })
                                    });
                                    </script>
                                    ';
                                    $URL = "../../mfi/client_statement.php";
                                    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                                }
                            }
                            // if failed throw error
                            else {
                                echo '<script type="text/javascript">
                                $(document).ready(function(){
                                    swal({
                                        type: "error",
                                        title: "Reversal Transaction",
                                        text: "Could not store Reversal record",
                                        showConfirmButton: false,
                                        timer: 2000
                                    })
                                });
                                </script>
                                ';
                                $URL = "../../mfi/client_statement.php";
                                echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                            }
                        } 
                        else {
                            echo '<script type="text/javascript">
                                    $(document).ready(function(){
                                        swal({
                                            type: "error",
                                            title: "Reversal Transaction",
                                            text: "Could not update Tellers Till",
                                            showConfirmButton: false,
                                            timer: 2000
                                        })
                                    });
                                    </script>
                                    ';
                            $URL = "../../mfi/client_statement.php";
                            echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                        }
                    }
                }
            }
            // else throw teller error
            else {
                echo '<script type="text/javascript">
                                    $(document).ready(function(){
                                        swal({
                                            type: "error",
                                            title: "Reversal Transaction",
                                            text: "Teller Who performed this transaction not recorded",
                                            showConfirmButton: false,
                                            timer: 2000
                                        })
                                    });
                                    </script>
                                    ';
                $URL = "../../mfi/client_statement.php";
                echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
            }
        } 
        else {
            echo '<script type="text/javascript">
                                    $(document).ready(function(){
                                        swal({
                                            type: "error",
                                            title: "Reversal Transaction",
                                            text: "Account information not Tallying",
                                            showConfirmButton: false,
                                            timer: 2000
                                        })
                                    });
                                    </script>
                                    ';
            $URL = "../../mfi/client_statement.php";
            echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
        }
    }
}
