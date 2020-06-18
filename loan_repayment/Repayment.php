<?php
// // START
// include("DB/connect.php");
// // GET THE LOAN DISBURSMENT CACHE CHECK BY DISBURSMENT CHACHE ID
// // GET THE LOAN
// // WIRTE A CODE FOR THE REPAYMENT FUNCTION - IF
// // END
// $select_all_disbursment_cache = mysqli_query($connection, "SELECT * FROM `loan_disbursement_cache` WHERE status = 'Approved'");
// while($x = mysqli_fetch_array($select_all_disbursment_cache)) {
//     // Get the client ID, Status, Product_id.
//     $client_id = $x["client_id"];
//     $product_id = $x["product_id"];
//     $int_id = $x["int_id"];
//     // NOW CHECK THE ACCOUNT
//     $select_loan_client = mysqli_query($connection, "SELECT * FROM `loan` WHERE client_id = '$client_id' AND $product_id = '$product_id' AND int_id = '$int_id'");
//     while ($y = mysqli_fetch_array($select_loan_client)) {
//         // GET THE LOAN DETAILS FOR THE REPAYMENT
//         // SELECT THE REPAYMENT SCH. IF IT IS ZERO - DO A REPAYMENT, IF IT IS MORE THAN.
//         $loan_id = $y["id"];
//         $acct_no = $y["account_no"];
//         $client_id = $y["client_id"];
//         $product_id = $y["product_id"];
//         // DISPLAY THE REPAYMENT STUFFS
//         $pincpal_amount = $y["principal_amount"];
//         $loan_term = $y["loan_term"];
//         $interest_rate = $y["interest_rate"];
//         $no_of_rep = $y["number_of_repayments"];
//         $rep_every = $y["repay_every"];
//         // DATE
//         $disburse_date = $y["disbursement_date"];
//         $offical_repayment = $y["repayment_date"];
//         $repayment_start = $y["repayment_date"];
//         // GET THE REPAYMENT END DATE
//         $sch_date = date("Y-m-d");
//         // SECHDULE DATE
//         $approved_by = $y["approvedon_userid"];
//         // END OF OFFICAL INFO
//         $loan_term1 = $loan_term - 1;
//         $loan_term2 = $loan_term;
//         if($rep_every == "month"){
//             $actualend_date = date('Y-m-d', strtotime("+".$loan_term1." months", strtotime($repayment_start)));
//             $actualend_date1 = date('Y-m-d', strtotime("+".$loan_term2." months", strtotime($repayment_start)));
//         }else if($rep_every == "day"){
//             $actualend_date = date('Y-m-d', strtotime("+".$loan_term1." days", strtotime($repayment_start)));
//             $actualend_date1 = date('Y-m-d', strtotime("+".$loan_term2." days", strtotime($repayment_start)));
//         }else if($rep_every == "year"){
//             $actualend_date = date('Y-m-d', strtotime("+".$loan_term1." years", strtotime($repayment_start)));
//             $actualend_date1 = date('Y-m-d', strtotime("+".$loan_term2." years", strtotime($repayment_start)));
//         } else if($rep_every == "week"){
//             $actualend_date = date('Y-m-d', strtotime("+".$loan_term1." weeks", strtotime($repayment_start)));
//             $actualend_date1 = date('Y-m-d', strtotime("+".$loan_term2." weeks", strtotime($repayment_start)));
//         }
//         // GET THE END DATE OF THE LOAN
//         $matured_date = $actualend_date;
//         $matured_date2 = $actualend_date1;
//         // GET THE END DATE OF THE LOAN
//         $matured_date = $actualend_date;
//         // echo "EVERY LOAN START AND END DATE "."CLIENT ".$client_id." -". $repayment_start." - ".$matured_date;
//         // REPAYMENT SCHEDULE
//         // -----------------
//         // IF IT IS NULL 
//         $select_repayment_sch = mysqli_query($connection, "SELECT * FROM `loan_repayment_schedule` WHERE loan_id = '$loan_id' AND client_id = '$client_id' AND int_id = '$int_id'");
//         $dm = mysqli_fetch_array($select_repayment_sch);
//         // dman
//         if ($dm <= 0) {
//             // NOTHING
//         while (strtotime("+1 ".$rep_every, strtotime($repayment_start)) <= strtotime($matured_date2)) {
//            $rep_client_id =  $client_id;
//            $rep_fromdate =  $repayment_start;
//            $rep_duedate = $matured_date;
//             $rep_install = $no_of_rep;
//            $rep_comp_derived =  $pincpal_amount / $loan_term;
//            $rep_int_amt = ((($interest_rate / 100) * $pincpal_amount) * $loan_term) / $loan_term;
//         //    $general_payment = $pincpal_amount + ((($interest_rate / 100) * $pincpal_amount) * $loan_term);
//         //    echo "GENERAL PAYMENT".$general_payment;
//         //    WE DO A NEXT STUFF
//         $insert_into_repsch = mysqli_query($connection, "INSERT INTO `loan_repayment_schedule` (`int_id`, `loan_id`, `client_id`, `fromdate`, `duedate`, `installment`, 
//             `principal_amount`, `principal_completed_derived`, `principal_writtenoff_derived`, `interest_amount`, `interest_completed_derived`, `interest_writtenoff_derived`, 
//             `interest_waived_derived`, `accrual_interest_derived`, `suspended_interest_derived`, `fee_charges_amount`, `fee_charges_completed_derived`, `fee_charges_writtenoff_derived`, 
//             `fee_charges_waived_derived`, `accrual_fee_charges_derived`, `suspended_fee_charges_derived`, `penalty_charges_amount`, `penalty_charges_completed_derived`, 
//             `penalty_charges_writtenoff_derived`, `penalty_charges_waived_derived`, `accrual_penalty_charges_derived`, `suspended_penalty_charges_derived`, 
//             `total_paid_in_advance_derived`, `total_paid_late_derived`, `completed_derived`, `obligations_met_on_date`, `createdby_id`, `created_date`, `lastmodified_date`, 
//             `lastmodifiedby_id`, `recalculated_interest_component`) 
//             VALUES ('{$int_id}', '{$loan_id}', '{$rep_client_id}', '{$offical_repayment}', '{$rep_fromdate}', '{$rep_install}', 
//             '{$rep_comp_derived}', '{$rep_comp_derived}', '0', '{$rep_int_amt}', '{$rep_int_amt}', '0',
//             NULL, '0', '0', '0', '0', '0',
//             NULL, '0', '0', '0', '{0}',
//             '0', '0', '0', '0', 
//             '0', '0', '0', NULL, '{$approved_by}', '{$sch_date}', '{$sch_date}',
//             '{$approved_by}', '0')");
//             if ($insert_into_repsch) {
//                 echo "WE GOOD";
//             } else {
//                 echo "WE BAD";
//             }
//         // END OF WE DO A NEXT STUFF
//         $repayment_start = date ("Y-m-d", strtotime("+1 ".$rep_every, strtotime($repayment_start)));
//         }

//         } else {
//         // IF THE QUERY IS NOT NULL RUN THE REPAYMENT CODE
//         // CHECK THE LAST REPAYMENT DATE THAT IS NOT DONE - COMPLETED DERIVED.
//         $d_loan_id = $dm["loan_id"];
//         $d_client_id = $dm["client_id"];
//         $d_int_id = $dm["int_id"];
//         $collect_loan = mysqli_query($connection, "SELECT * FROM `loan_repayment_schedule` WHERE loan_id = '$d_loan_id' AND client_id = '$d_client_id' AND int_id = '$d_int_id' AND (installment > 0) AND duedate = '$sch_date' ORDER BY id ASC LIMIT 1");
//         // EXPORT THE IDS HERE
//         while ($pop = mysqli_fetch_array($collect_loan)) {
//             $collection_id = $pop["id"];
//             $collection_loan = $pop["loan_id"];
//             $collection_client_id = $pop["client_id"];
//             $collection_installment = $pop["installment"];
//             $collection_principal = $pop["principal_amount"];
//             $collection_interest = $pop["interest_amount"];
//             $general_date_due = $pop["duedate"];
//             $post_installment = $collection_installment - 1;
//             $select_loanx = mysqli_query($connection, "SELECT * FROM loan WHERE id = '$collection_loan'");
//             $ges = mysqli_fetch_array($select_loanx);
//             $new_loan_term = $ges["loan_term"];
//             $general_payment = ($collection_principal + $collection_interest) * $new_loan_term;
//             echo "GENERAL PAYMENT".$general_payment;
//             $collection_due_paid = $collection_principal + $collection_interest;
//             $loan_account = mysqli_query($connection, "SELECT * FROM account WHERE account_no = '$acct_no' AND client_id = '$collection_client_id' AND int_id = '$d_int_id'");
//             $u = mysqli_fetch_array($loan_account);
//             $account_id = $u["id"];
//             $client_account_balance = $u["account_balance_derived"];
//             $balance_remaining = $client_account_balance - $collection_due_paid;
//             $total_withd =  $u["total_withdrawals_derived"] + $collection_due_paid;
//             // PILLED
//             // CLIENT 
//             $client_account = mysqli_query($connection, "SELECT * FROM client WHERE id = '$client_id' AND int_id = '$int_id'");
//             $cx = mysqli_fetch_array($client_account);
//             $branch_id = $cx["branch_id"];
//             $client_firstname = $cx["firstname"];
//             $gen_date = date('Y-m-d');
//             // TESTING FOR ME
//             echo "<p> ACCOUNT-NO:".$acct_no."</p>";
//             echo "<p>BALANCE: ".$client_account_balance."</p>";
//             echo "<p>DUE AMOUNT: ".$collection_due_paid."</p>";
//             echo "<p>BALANCE AFTER REPAYMENT: ".$balance_remaining."</p>";
//             echo "__";
//             // $ppx = mysqli_fetch_array($loan_account);
//             if ($client_account_balance >= $collection_due_paid) {
//                 // DO THE MOVE BY TAKING THE CARD
//                 $digits = 5;
//                 $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
//                 $trans_id = $client_firstname.$randms.$branch_id;
//                 // update client account
//                 $update_client_account = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$balance_remaining', total_withdrawals_derived = '$total_withd' WHERE int_id = '$int_id' AND client_id = '$client_id' AND account_no = '$acct_no'");
//                 if ($update_client_account) {
//                 // update client account transaction
//                 $insert_client_trans = mysqli_query($connection, "INSERT INTO `account_transaction` (`int_id`, `branch_id`,
//                 `product_id`, `account_id`, `account_no`, `client_id`, `teller_id`, `transaction_id`,
//                 `description`, `transaction_type`, `is_reversed`, `transaction_date`, `amount`, `overdraft_amount_derived`,
//                 `balance_end_date_derived`, `balance_number_of_days_derived`, `running_balance_derived`,
//                 `cumulative_balance_derived`, `created_date`, `appuser_id`, `manually_adjusted_or_reversed`, `debit`, `credit`) 
//                 VALUES ('{$int_id}', '{$branch_id}', '0', '{$account_id}', '$acct_no', '{$client_id}', '0', '{$trans_id}',
//                 'Loan', 'loan_repayment', '0', '{$gen_date}', '{$collection_due_paid}', '{$collection_due_paid}',
//                 '{$gen_date}', '0', '{$balance_remaining}',
//                 '{$balance_remaining}', '{$gen_date}', '0', '0', '{$collection_due_paid}', '0.00')");
//                 if ($insert_client_trans) {
//                     // update loan
//                     $total_out_stand = $general_payment - $collection_due_paid;
//                   $up_client_loan = mysqli_query($connection, "UPDATE loan SET total_outstanding_derived = '$total_out_stand' WHERE int_id = '$int_id' AND client_id = '$client_id' AND (id = '$loan_id' AND account_no = '$acct_no')");
//                   if ($up_client_loan) {
//                     // update the loan transaction
//                     $update_loan_trans = mysqli_query($connection, "INSERT INTO `loan_transaction` (`int_id`, `branch_id`, `product_id`, `loan_id`, `transaction_id`, `client_id`, `account_no`, `is_reversed`, `external_id`, `transaction_type`, `transaction_date`, `amount`,
//                      `payment_method`, `principal_portion_derived`, `interest_portion_derived`, `fee_charges_portion_derived`, `penalty_charges_portion_derived`,
//                      `overpayment_portion_derived`, `unrecognized_income_portion`, `suspended_interest_portion_derived`, `suspended_fee_charges_portion_derived`, 
//                      `suspended_penalty_charges_portion_derived`, `outstanding_loan_balance_derived`, `recovered_portion_derived`, `submitted_on_date`, `manually_adjusted_or_reversed`, `created_date`, `appuser_id`, `is_account_transfer`) 
//                     VALUES ('{$int_id}', '{$branch_id}', '0', '{$collection_loan}', '{$trans_id}', '{$client_id}', '{$acct_no}', '0', '0', 'Repayment', '{$gen_date}', '{$collection_due_paid}', 
//                     'auto_account', '{$collection_principal}', '{$collection_interest}', '0', '0', 
//                     '0', NULL, '0', '0', '0', '{$total_out_stand}', '{$collection_due_paid}', '{$gen_date}', '0', '{$gen_date}', '0', '1')");
//                     //   if ($connection->error) {
//                     //             try {
//                     //                 throw new Exception("MYSQL error $connection->error <br> $update_loan_trans ", $mysqli->error);
//                     //             } catch (Exception $e) {
//                     //                 echo "Error No: ".$e->getCode()." - ".$e->getMessage() . "<br>";
//                     //                 echo n12br($e->getTraceAsString());
//                     //             }
//                     //         }
//                     if ($update_loan_trans) {
//                         // update the repayment sch history
//                         $update_repayment = mysqli_query($connection, "INSERT INTO `loan_repayment_schedule_history` (`int_id`, `loan_id`, `client_id`, `loan_reschedule_request_id`, `fromdate`, `duedate`, `installment`, `principal_amount`, `interest_amount`, `fee_charges_amount`, `penalty_charges_amount`, `createdby_id`, `created_date`, `lastmodified_date`, `lastmodifiedby_id`, `version`)
//                         VALUES ('{$int_id}', '{$loan_id}', '{$client_id}', '{$collection_id}', '{$repayment_start}', '{$matured_date}', '{$collection_principal}', '{$collection_interest}', '0', '0', NULL, NULL, '{$gen_date}', NULL, NULL, '')");
//                         if ($update_repayment) {
//                             // loan repayment status
//                             $update_rep_status = mysqli_query($connection, "INSERT INTO `loan_repayment_status` (`int_id`, `loan_id`, `client_id`, `product_id`, `date_due`, `date_paid`, `status`, `pay_descript`, `loan_status`, `loan_status_descript`, `pay_type`, `pay_status`) 
//                             VALUES ('{$int_id}', '{$loan_id}', '{$client_id}', '{$product_id}', '{$general_date_due}', '{$gen_date}', '0', 'early', '0', 'active', 'account', '0')");
//                             if ($update_rep_status) {
//                                 // YOU STOPPED HERE HERE
//                                // update the repayement sch.
//                                $uodate_rep_status = mysqli_query($connection, "UPDATE `loan_repayment_schedule` SET installment = '$post_installment' WHERE int_id = '$int_id' AND id = '$collection_id'");
//                                if ($update_rep_status) {
//                                    echo "SUCCESS AT LAST";
//                                } else {
//                                    echo "ERROR AT LAST";
//                                }
//                               // FROM THE LOAN
//                             } else {
//                                 echo "ERROR at Repayment Status";
//                             }
//                         } else {
//                             echo "ERROR Loan Reayment Schedule History";
//                         }
//                     } else {
//                         echo "ERROR in Update Transaction";
//                     }
//                   } else {
//                     echo "BAD at the loan update";
//                   }
//                 } else {
//                     echo "Error in client transaction";
//                 }            
//                 //  THINK ABOUT SOMETHING ELSE
//                 } else {
//                     echo "Error in Update Client Account";
//                 }
//                 // END UPDATE
//             } else if ($client_account_balance < $collection_due_paid && $client_account_balance >= 1) {
//                 // DO CARD COLLECTION
//                 echo "TAKE FUND HERE AND ALSO ON THE FLUTTER ACCOUNT";
//                 //  DO REPAYMENT COLLECTION
//              } else {
//                 $balance_remaining = "Insufficient Fund";
//                 // DO THE INSUFFICIENT POSTING
//                 // TAKE THE CARD - IF CARD SUCCESS (REMEMBER TO DO THE TRANSACTION, REDUCE THE ID BY 1);
//                 // IF CARD IS BAD - THROW THE ACCOUNT INTO MINUS
//                 echo "NO FUND";
//             }
//             // DO AN ACCOUNT TRANSACTION IF ANY IS GOOD;
//             // echo "Due Paid".$collection_due_paid;
//             // echo "Collection".$collection_installment;
//         }
//         // stuffs
//         // SHOWING ME NEW
//         }
//     }
// }
?>
