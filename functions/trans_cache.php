<?php
include("connect.php");
session_start();
$today = Date('Y-m-d H.i.s');

if (isset($_POST['account_noFrom']) && isset($_POST['account_noTo'])) {
    // Session data declaration
    $emailu = $_SESSION["email"];
    $int_name = $_SESSION["int_name"];
    $int_email = $_SESSION["int_email"];
    $int_web = $_SESSION["int_web"];
    $int_phone = $_SESSION["int_phone"];
    $int_logo = $_SESSION["int_logo"];
    $int_address = $_SESSION["int_address"];
    $institutionId = $_SESSION["int_id"];
    $nm = $_SESSION["username"];
    $userId = $_SESSION["user_id"];
    $digits = 6;
    $randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
    // Declaring Transaction Variables
    $transacionId = $_POST['transact_id'];
    $transferFrom = $_POST['account_noFrom'];
    $amount = floatval(preg_replace('/[^\d.]/', '', $_POST['amount']));
    $transferTo = $_POST['account_noTo'];
    $branchId = $_POST['branch'];
    $transactionDate = $_POST['transDate'];
    $credit = "credit";
    $debit = "debit";
    $irvs = 0;
    $trans_date = date('Y-m-d h:m:s');
    $getacct1 = mysqli_query($connection, "SELECT * FROM staff WHERE user_id = '$userId' && int_id = '$institutionId'");
    if (count([$getacct1]) == 1) {
        $uw = mysqli_fetch_array($getacct1);
        $staff_id = $uw["id"];
        $staff_email = $uw["email"];
    }
    $taketeller = mysqli_query($connection, "SELECT * FROM tellers WHERE name = '$staff_id' && int_id = '$institutionId'");
    if (!$taketeller) {
        printf('Error: %s\n', mysqli_error($connection)); //checking for errors
        exit();
        // send back feedback of teller not found or user not a teller
    }
    $tellerDetails = mysqli_fetch_array($taketeller);
    $tellerLimit = $tellerDetails['post_limit'];

    if ($tellerLimit >= $amount) {
        // find all sender info before procedding with transaction
        $senderConditions = [
            'account_no' => $transferFrom,
            'int_id' => $institutionId
        ];
        $senderDetails = selectOne('account', $senderConditions);
        if (!$senderDetails) {
            printf('Error: %s\n', mysqli_error($connection)); //checking for errors
            exit();
            // send them back
        }
        $senderAccountBalance = $senderDetails['account_balance_derived'];
        $senderAccountId = $senderDetails['id'];
        $senderproductID = $senderDetails['product_id'];
        $senderclientId = $senderDetails['client_id'];
        $senderWithrawalBlance = $senderDetails['total_withdrawals_derived'];
        $senderNewBalance = $senderAccountBalance - $amount;
        $senderNewWithdrwalBalnce = $senderWithrawalBlance + $amount;


        // receivers info
        $receiverConditions = [
            'account_no' => $transferTo,
            'int_id' => $institutionId
        ];
        $receiverDetails = selectOne('account', $receiverConditions);
        if (!$receiverDetails) {
            printf('Error: %s\n', mysqli_error($connection)); //checking for errors
            exit();
            // send them back
        }
        $receiverAccountBalance = $receiverDetails['account_balance_derived'];
        $receiverAccountId = $receiverDetails['id'];
        $receiverproductID = $receiverDetails['product_id'];
        $receiverclientId = $receiverDetails['client_id'];
        $receiverDepositBalance = $receiverDetails['total_deposits_derived'];
        $receiverNewBalance = $receiverAccountBalance + $amount;
        $receiverDepositBalance = $receiverDepositBalance + $amount;
        // find senders' and  recevivers' name
        // create description
        $findSendersName = mysqli_query($connection, "SELECT display_name FROM client WHERE id = '$senderclientId'");
        $sender = mysqli_fetch_array($findSendersName);
        $fromName = $sender['display_name'];
        $findReceiversName = mysqli_query($connection, "SELECT display_name FROM client WHERE id = '$receiverclientId'");
        $receiver = mysqli_fetch_array($findReceiversName);
        $toName = $receiver['display_name'];
        $descriptionFrom = "Transfer frm " . $fromName . " to " . $toName;
        $descriptionTo = "Transfer to " . $toName . " frm" . $fromName;
        // we can now move on with the transactions
        // but first confirm is sender has enough money in thier account
        if ($senderAccountBalance >= $amount) {
            // continue transactions
            $senderUpdatedData = [
                'account_balance_derived' => $senderNewBalance,
                'total_withdrawals_derived' => $senderNewWithdrwalBalnce,
                'last_withdrawal' => $amount
            ];
            $updateSenderAccount =  update('account', $senderAccountId, 'id', $senderUpdatedData);
            if (!$updateSenderAccount) {
                printf('Error: %s\n', mysqli_error($connection)); //checking for errors
                exit();
                // send error could not update senders account
            } else {
                // store transaction data
                $senderTransactionDetails = [
                    'int_id' => $institutionId,
                    'branch_id' => $branchId,
                    'amount' => $amount,
                    'transaction_id' => $transacionId,
                    'description' => $descriptionFrom,
                    'account_no' => $transferFrom,
                    'product_id' => $senderproductID,
                    'client_id' => $senderclientId,
                    'transaction_type' => "debit",
                    'transaction_date' => $transactionDate,
                    'overdraft_amount_derived' => $amount,
                    'running_balance_derived' => $senderNewBalance,
                    'cumulative_balance_derived' => $senderNewBalance,
                    'appuser_id' => $userId,
                    'debit' => $amount,
                    'created_date' => $today
                ];

                $storeSenderTransaction =  insert('account_transaction', $senderTransactionDetails);
                if (!$storeSenderTransaction) {
                    printf('Error: %s\n', mysqli_error($connection)); //checking for errors
                    exit();
                } else {
                    //receivers transaction details
                    $receiverUpdatedData = [
                        'account_balance_derived' => $receiverNewBalance,
                        'total_deposits_derived' => $receiverDepositBalance,
                        'last_deposit' => $amount
                    ];
                    $updateReceiverAccount =  update('account', $receiverAccountId, 'id', $receiverUpdatedData);
                    if (!$updateReceiverAccount) {
                        printf('Error: %s\n', mysqli_error($connection)); //checking for errors
                        exit();
                    } else {
                        // store revecivers transaction
                        $receiverTransactionDetails = [
                            'int_id' => $institutionId,
                            'branch_id' => $branchId,
                            'amount' => $amount,
                            'transaction_id' => $transacionId,
                            'description' => $descriptionTo,
                            'account_no' => $transferTo,
                            'product_id' => $receiverproductID,
                            'client_id' => $receiverclientId,
                            'transaction_type' => "credit",
                            'transaction_date' => $transactionDate,
                            'overdraft_amount_derived' => $amount,
                            'running_balance_derived' => $receiverNewBalance,
                            'cumulative_balance_derived' => $receiverNewBalance,
                            'appuser_id' => $userId,
                            'credit' => $amount,
                            'created_date' => $today
                        ];

                        $storeReceiverTransaction =  insert('account_transaction', $receiverTransactionDetails);
                        if (!$storeReceiverTransaction) {
                            printf('Error: %s\n', mysqli_error($connection)); //checking for errors
                            exit();
                            // could not store receivers transaction
                            // otherwise transaction sucessful
                            $_SESSION["feedback"] = "Transaction Successful, could not store receivers transaction";
                            $_SESSION["Lack_of_intfund_$randms"] = "2";
                            echo header("Location: ../mfi/bank_transfer.php?message1=1");
                        } else {
                            // output success message
                            $_SESSION["feedback"] = "Transaction Successful";
                            $_SESSION["Lack_of_intfund_$randms"] = "Teller";
                            echo header("Location: ../mfi/bank_transfer.php?message0=$randms");
                        }
                    }
                }
            }
        } else {
            // send back inssuficient funds feedback message
        }
        # !ends here
    } else {
        // send for Aprroval
    }
    #isset ends here
}else{
    // input nescessary data
}
// if (isset($_POST['transact_id'])) {


//     $query3 = "SELECT client.firstname, client.lastname, account.product_id, account.account_no, account.id, account.total_withdrawals_derived, account.account_balance_derived FROM client JOIN account ON client.account_no = account.account_no WHERE client.int_id = '$institutionId' AND client.id ='$transferFrom'";
//     $querexec = mysqli_query($connection, $query3);
//     $a = mysqli_fetch_array($querexec);
//     $transnameone = strtoupper($a['firstname'] . " " . $a['lastname']);
//     $accountone = $a['account_no'];
//     $accprid = $a['product_id'];
//     $accidone = $a['id'];
//     $accountbalone = $a['account_balance_derived'];
//     $ttlwithdrawal = $a['total_withdrawals_derived'];

//     // Get the account data for the recipient 
//     $query4 = "SELECT client.firstname, client.lastname, account.product_id, account.account_no, account.id, account.total_deposits_derived, account.account_balance_derived FROM client JOIN account ON client.account_no = account.account_no WHERE client.int_id = '$institutionId' AND client.id ='$transferTo'";
//     $queryexec = mysqli_query($connection, $query4);
//     $b = mysqli_fetch_array($queryexec);
//     $transnametwo = strtoupper($b['firstname'] . " " . $b['lastname']);
//     $accountbaltwo = $b['account_balance_derived'];
//     $accounttwo = $b['account_no'];
//     $accprdid = $b['product_id'];
//     $accidtwo = $b['id'];
//     $ttldeposit = $b['total_deposits_derived'];

//     // Code is to check if User making transaction is a teller
//     $check_me_men = mysqli_query($connection, $taketeller);
//     if (count([$check_me_men]) > 0) {
//         // if account being transferred from is greater than amount, proceed to code
//         if ($accountbalone >= $amount) {
//             $auponres = "INSERT INTO `transfer_cache` (`int_id`, `branch_id`, `account_officer_id`, `transact_id`, `trans_from`, `amount`, `trans_to`, `trans_date`,`status`)
//              VALUES ('$institutionId', '$branch_id', '$staff_id', '$trans_id', '$transferFrom', '$amount', '$transferTo', current_timestamp(), 'Pending')";
//             // update the depositor transaction
//             $rsd = mysqli_query($connection, $auponres);
//             if ($rsd) {
//                 //  Transaction Successful
//                 $_SESSION["Lack_of_intfund_$randms"] = "TELLER";
//                 echo header("Location: ../mfi/bank_transfer.php?message2=$randms");
//             }
//         } else {
//             // Not enough money in the bank account
//             $_SESSION["Lack_of_intfund_$randms"] = "TELLER";
//             echo header("Location: ../mfi/bank_transfer.php?message1=$randms");
//         }
//     } else {
//         // you're not authorized not a teller
//         $_SESSION["Lack_of_intfund_$randms"] = "TELLER";
//         echo header("Location: ../mfi/bank_transfer.php?message0=$randms");
//     }
// }
