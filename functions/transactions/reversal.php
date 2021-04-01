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
        $branchId = $transactionData['branch_id'];
        $productId = $transactionData['product_id'];
        $accountId = $transactionData['account_id'];
        $accountNumber =  $transactionData['account_no'];
        $clientId =  $transactionData['client_id'];
        $tellerId = $transactionData['teller_id'];
        $transactionId = $transactionData['transaction_id'];
        $description = $transactionData['description'];
        $transactionType = $transactionData['transaction_type'];
        $transactionDate = $transactionData['transaction_date'];
        $amount = $transactionData['amount'];
        $overdraftAmountDerived = $transactionData['overdraft_amount_derived'];
        $balanceEndDateDerived = $transactionData['balance_end_date_derived'];
        $balanceNoOfDaysDerived = $transactionData['balance_number_of_days_derived'];
        $runningBalanceDerived = $transactionData['running_balance_derived'];
        $cumulativeBalanceDerived = $transactionData['cumulative_balance_derived'];
        $createdDate = date('Y-m-d H:i:s');
        $appUserId = $transactionData['appuser_id'];

        // find account details from account table and deduct the current balance
        $findAccount = mysqli_query($connection, "SELECT * FROM account WHERE account_no = '$accountNumber' AND client_id = '$clientId'");
        
        if ($findAccount) {
            // Put account data into an array
            $accountData = mysqli_fetch_array($findAccount);
            $accountBalance = $accountData['account_balance_derived'];
            // check transaction type and calculate reversal account balance amount as needed.
            if ($transactionType == "credit") {
                $reversedAccountBalance = $accountBalance - $amount;
            } else if ($transactionType == "debit") {
                $reversedAccountBalance = $accountBalance + $amount;
            } 
            else if ($transactionType == "") {
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
                $updateAccount = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$reversedAccountBalance' WHERE account_no = '$accountNumber' AND client_id =  '$clientId'");
                $updateAccountTransaction = mysqli_query($connection, "UPDATE account_transaction SET is_reversed = 1 WHERE transaction_id = '$transactionId'");

                if ($updateAccount && $updateAccountTransaction) {
                    // Find insitution account data first
                    $findInstitutionAccount = mysqli_query($connection, "SELECT * FROM institution_account WHERE teller_id = '$tellerId' AND int_id = '$institutionID'");
                    
                    if (count([$findInstitutionAccount]) == 1) {
                        $institutionAccountData =  mysqli_fetch_array($findInstitutionAccount);
                        $institutionAccountBalance = $institutionAccountData['account_balance_derived'];
                        
                        if ($transactionType == "credit") {
                            $newInstitutionBalance = $institutionAccountBalance - $amount;
                        } else if ($transactionType == "debit") {
                            $newInstitutionBalance = $institutionAccountBalance + $amount;
                        }
                        // Update the institution account
                        $updateInstitutionAccount = mysqli_query($connection, "UPDATE institution_account SET account_balance_derived = '$newInstitutionBalance' WHERE teller_id = '$tellerId' AND int_id = '$institutionID'");

                        if ($updateInstitutionAccount) {
                            // Store reversal data
                            
                            $reversal = mysqli_query($connection, "INSERT INTO reversal (int_id, account_no, client_id, transaction_id, transact_date, staff_id, teller_id, amount_reversed, account_balance_derived) 
                            VALUES ('$institutionID', '$accountNumber', '$clientId', '$transactionId', '$transactionDate', '$staff', '$tellerId', '$amount', '$reversedAccountBalance')");

                            // Update account_transaction and institution_account_transaction records
                            if ($reversal) {
                                
                                if ($transactionType == "credit") {
                                    $describe = $description+"_CREDIT_REVERSAL";
                                    $query = "INSERT INTO institution_account_transaction (int_id, branch_id, client_id, transaction_id, description, transaction_type, 
                                    teller_id, is_vault, is_reversed, transaction_date, amount, running_balance_derived, overdraft_amount_derived, balance_end_date_derived,
                                    balance_number_of_days_derived, cumulative_balance_derived, created_date, appuser_id, manually_adjusted_or_reversed, debit)
                                    VALUES ('$institutionID', '$branchId', '$clientId', '$transactionId', '$describe', 'debit',
                                    '$tellerId', 0, 0, '$transactionDate', '$amount', '$newInstitutionBalance', '$overdraftAmountDerived', '$balanceEndDateDerived',
                                    '$balanceNoOfDaysDerived', '$newInstitutionBalance', '$createdDate', '$appUserId', 1, '$amount')";
                                    
                                } else if ($transactionType == "debit") {
                                    $describe = $description+"_DEBIT_REVERSAL";
                                    $query = "INSERT INTO institution_account_transaction (int_id, branch_id, client_id, transaction_id, description, transaction_type, 
                                    teller_id, is_vault, is_reversed, transaction_date, amount, running_balance_derived, overdraft_amount_derived, balance_end_date_derived,
                                    balance_number_of_days_derived, cumulative_balance_derived, created_date, appuser_id, manually_adjusted_or_reversed, credit)
                                    VALUES ('$institutionID', '$branchId', '$clientId', '$transactionId', '$description', 'credit',
                                    '$tellerId', 0, 0, '$transactionDate', '$amount', '$newInstitutionBalance', '$overdraftAmountDerived', '$balanceEndDateDerived',
                                    '$balanceNoOfDaysDerived', '$newInstitutionBalance', '$createdDate', '$appUserId', 1, '$amount')";
                                }
                                
                                $newInstitutionAccountTransaction = mysqli_query($connection, $query);

                                if ($newInstitutionAccountTransaction) {
                                    if ($transactionType == "credit") {
                                        $query = "INSERT INTO account_transaction (int_id, branch_id, product_id, account_id, account_no, client_id, teller_id, transaction_id,
                                        description, transaction_type, is_reversed, transaction_date, amount, overdraft_amount_derived, balance_end_date_derived, balance_number_of_days_derived,
                                        running_balance_derived, cumulative_balance_derived, created_date, chooseDate, appuser_id, manually_adjusted_or_reversed, debit)
                                        VALUES ('$institutionID', '$branchId', '$productId', '$accountId', '$accountNumber', '$clientId', '$tellerId', '$transactionId',
                                        'CREDIT_REVERSAL', 'debit', 0, '$transactionDate', '$amount', '$overdraftAmountDerived', '$balanceEndDateDerived', '$balanceNoOfDaysDerived',
                                        '$reversedAccountBalance', '$reversedAccountBalance', '$createdDate', '', '$appUserId', 1, '$amount')";
                                    
                                    } else if ($transactionType == "debit") {
                                        $query = "INSERT INTO account_transaction (int_id, branch_id, product_id, account_id, account_no, client_id, teller_id, transaction_id,
                                        description, transaction_type, is_reversed, transaction_date, amount, overdraft_amount_derived, balance_end_date_derived, balance_number_of_days_derived,
                                        running_balance_derived, cumulative_balance_derived, created_date, chooseDate, appuser_id, manually_adjusted_or_reversed, credit)
                                        VALUES ('$institutionID', '$branchId', '$productId', '$accountId', '$accountNumber', '$clientId', '$tellerId', '$transactionId',
                                        'DEBIT_REVERSAL', 'credit', 0, '$transactionDate', '$amount', '$overdraftAmountDerived', '$balanceEndDateDerived', '$balanceNoOfDaysDerived',
                                        '$reversedAccountBalance', '$reversedAccountBalance', '$createdDate', '', '$appUserId', 1, '$amount')";
                                    }

                                    $newAccountTransaction = mysqli_query($connection, $query);

                                    if ($newAccountTransaction) {
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
