<?php
// START
// echo "HERE I AM";
include("../functions/connect.php");
// GET THE LOAN DISBURSMENT CACHE CHECK BY DISBURSMENT CHACHE ID
// GET THE LOAN
// WIRTE A CODE FOR THE REPAYMENT FUNCTION - IF
// END
// $select_all_disbursment_cache = mysqli_query($connection, "SELECT * FROM `loan_disbursement_cache` WHERE status = 'Approved'");
// while($x = mysqli_fetch_array($select_all_disbursment_cache)) {
//     // Get the client ID, Status, Product_id.
//     $client_id = $x["client_id"];
//     $product_id = $x["product_id"];
//     $int_id = $x["int_id"];
//     // NOW CHECK THE ACCOUNT
//     $select_loan_client = mysqli_query($connection, "SELECT * FROM `loan` WHERE client_id = '$client_id' AND product_id = '$product_id' AND int_id = '$int_id'");
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
//         if ($dm <= 0 && $int_id != "0") {
//             // NOTHING
//         while (strtotime("+1 ".$rep_every, strtotime($repayment_start)) <= strtotime($matured_date2)) {
//            $rep_client_id =  $client_id;
//            $rep_fromdate =  $repayment_start;
//            $rep_duedate = $matured_date;
//             $rep_install = $no_of_rep;
//            $rep_comp_derived =  $pincpal_amount / $loan_term;
//            if ($rep_every == "month") {
//            $rep_int_amt = ((($interest_rate / 100) * $pincpal_amount) * $loan_term) / $loan_term;
//            } else if ($rep_every == "week") {
//             $rep_int_amt = (((($interest_rate / 100) * $pincpal_amount) * $loan_term) / $loan_term) / 4;
//            } else if ($rep_every == "") {
//             $rep_int_amt = (((($interest_rate / 100) * $pincpal_amount) * $loan_term) / $loan_term) / 28;
//            }
//         //    $general_payment = $pincpal_amount + ((($interest_rate / 100) * $pincpal_amount) * $loan_term);
//         //    echo "GENERAL PAYMENT".$general_payment;
//         // REPAYMENT COMMENT
//         //    WE DO A NEXT STUFF
//         // $insert_into_repsch = mysqli_query($connection, "INSERT INTO `loan_repayment_schedule` (`int_id`, `loan_id`, `client_id`, `fromdate`, `duedate`, `installment`, 
//         //     `principal_amount`, `principal_completed_derived`, `principal_writtenoff_derived`, `interest_amount`, `interest_completed_derived`, `interest_writtenoff_derived`, 
//         //     `interest_waived_derived`, `accrual_interest_derived`, `suspended_interest_derived`, `fee_charges_amount`, `fee_charges_completed_derived`, `fee_charges_writtenoff_derived`, 
//         //     `fee_charges_waived_derived`, `accrual_fee_charges_derived`, `suspended_fee_charges_derived`, `penalty_charges_amount`, `penalty_charges_completed_derived`, 
//         //     `penalty_charges_writtenoff_derived`, `penalty_charges_waived_derived`, `accrual_penalty_charges_derived`, `suspended_penalty_charges_derived`, 
//         //     `total_paid_in_advance_derived`, `total_paid_late_derived`, `completed_derived`, `obligations_met_on_date`, `createdby_id`, `created_date`, `lastmodified_date`, 
//         //     `lastmodifiedby_id`, `recalculated_interest_component`)
//         //     VALUES ('{$int_id}', '{$loan_id}', '{$rep_client_id}', '{$offical_repayment}', '{$rep_fromdate}', '{$rep_install}', 
//         //     '{$rep_comp_derived}', '{$rep_comp_derived}', '0', '{$rep_int_amt}', '{$rep_int_amt}', '0',
//         //     NULL, '0', '0', '0', '0', '0',
//         //     NULL, '0', '0', '0', '{0}',
//         //     '0', '0', '0', '0', 
//         //     '0', '0', '0', NULL, '{$approved_by}', '{$sch_date}', '{$sch_date}',
//         //     '{$approved_by}', '0')");
//         //     if ($insert_into_repsch) {
//         //         echo "WE GOOD";
//         //     } else {
//         //         echo "WE BAD";
//         //     }
//         // END OF WE DO A NEXT STUFF
//         // $repayment_start = date ("Y-m-d", strtotime("+1 ".$rep_every, strtotime($repayment_start)));
//         }

//         } else {
//         // IF THE QUERY IS NOT NULL RUN THE REPAYMENT CODE
//         // CHECK THE LAST REPAYMENT DATE THAT IS NOT DONE - COMPLETED DERIVED
//         $d_loan_id = $dm["loan_id"];
//         $d_client_id = $dm["client_id"];
//         $d_int_id = $dm["int_id"];
//         $collect_loan = mysqli_query($connection, "SELECT * FROM `loan_repayment_schedule` WHERE ((loan_id = '$d_loan_id' AND client_id = '$d_client_id') AND (int_id = '$d_int_id' AND (installment > 0) AND (duedate = '$sch_date'))) ORDER BY id ASC LIMIT 1");
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
//             $total_out_stand = $general_payment - $collection_due_paid;
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
//                 // 2 NAIRA PER MINUTES
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
//                 'Loan_Repayment', 'loan_repayment', '0', '{$gen_date}', '{$collection_due_paid}', '{$collection_due_paid}',
//                 '{$gen_date}', '0', '{$balance_remaining}',
//                 '{$balance_remaining}', '{$gen_date}', '0', '0', '{$collection_due_paid}', '0.00')");
//                 if ($insert_client_trans) {
//                     // update loan
                    
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
//                         $update_repayment = mysqli_query($connection, "INSERT INTO `loan_repayment_schedule_history` (`int_id`, `loan_id`, `client_id`, `loan_reschedule_request_id`, `fromdate`, `duedate`, `installment`, `principal_amount`, `interest_amount`, `fee_charges_amount`, `penalty_charges_amount`, `createdby_id`, `created_date`, `lastmodified_date`)
//                         VALUES ('{$int_id}', '{$loan_id}', '{$client_id}', '{$collection_id}', '{$repayment_start}', '{$matured_date}', '1', '{$collection_principal}', '{$collection_interest}', '0', '0', NULL, '{$gen_date}', '{$gen_date}')");
//                         if ($update_repayment) {
//                             // Loan_Repayment status
//                             $update_rep_status = mysqli_query($connection, "INSERT INTO `loan_repayment_status` (`int_id`, `loan_id`, `client_id`, `product_id`, `date_due`, `date_paid`, `status`, `pay_descript`, `loan_status`, `loan_status_descript`, `pay_type`, `pay_status`) 
//                             VALUES ('{$int_id}', '{$loan_id}', '{$client_id}', '{$product_id}', '{$general_date_due}', '{$gen_date}', '0', 'early', '0', 'active', 'account', '0')");
//                             if ($update_rep_status) {
//                                 // YOU STOPPED HERE HERE
//                                // update the repayement sch.
//                                $update_rep_status = mysqli_query($connection, "UPDATE `loan_repayment_schedule` SET installment = '$post_installment' WHERE int_id = '$int_id' AND id = '$collection_id'");
//                                if ($update_rep_status) {
//                                    echo "SUCCESS AT LAST";





//                                 //    UPDATE THE GL OF THE REPAYMENT
//                                 $open_acct_rule = mysqli_query($connection, "SELECT * FROM acct_rule WHERE int_id = '$int_id' AND loan_product_id = '$product_id'");
//                                 $ty = mysqli_fetch_array($open_acct_rule);
//                                     // reduce
//                                     $loan_port = $ty["asst_loan_port"];
//                                     $int_loan_port = $ty["inc_interest"];
//                                     $take_d_s = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE gl_code = '$loan_port' AND int_id = '$int_id'");
//                                     $gdb = mysqli_fetch_array($take_d_s);
//                                     // geng new thing here
//                                     $int_d_s = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE gl_code = '$int_loan_port' AND int_id = '$int_id'");
//                                     $igdb = mysqli_fetch_array($int_d_s);
//                                     // IMPOSSIBLE
//                                     $intbalport = $igdb["organization_running_balance_derived"];
//                                     $newbalport = $gdb["organization_running_balance_derived"];
//                                     $updated_loan_port = $newbalport - $collection_principal;
//                                     $intloan_port = $intbalport + $collection_interest;
                                    
//                                     $update_the_loan = mysqli_query($connection, "UPDATE acc_gl_account SET organization_running_balance_derived = '$updated_loan_port' WHERE int_id ='$int_id' AND gl_code = '$loan_port'");
//                                     if ($update_the_loan) {
//                                         // damn with
//                                         $insert_loan_port = mysqli_query($connection, "INSERT INTO `gl_account_transaction` (`int_id`, `branch_id`, `gl_code`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`,
//                                          `amount`, `gl_account_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`) 
//                                         VALUES ('{$int_id}', '{$branch_id}', '{$loan_port}', '{$trans_id}', 'Loan_Repayment Principal / {$client_firstname}', 'Loan_Repayment Principal', '0', '0', '{$gen_date}',
//                                          '{$collection_principal}', '{$updated_loan_port}', '{$updated_loan_port}', '{$gen_date}', '0', '0', '{$gen_date}', '0', '{$collection_principal}', '0.00')");
//                                          if ($insert_loan_port) {
//                                             $update_the_int_loan = mysqli_query($connection, "UPDATE acc_gl_account SET organization_running_balance_derived = '$intloan_port' WHERE int_id = '$int_id' AND gl_code ='$int_loan_port'");
//                                             if ($update_the_int_loan) {
//                                                 $insert_i_port = mysqli_query($connection, "INSERT INTO `gl_account_transaction` (`int_id`, `branch_id`, `gl_code`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`,
//                                          `amount`, `gl_account_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`) 
//                                         VALUES ('{$int_id}', '{$branch_id}', '{$int_loan_port}', '{$trans_id}', 'Loan_Repayment Interest / {$client_firstname}', 'Loan_Repayment Interest', '0', '0', '{$gen_date}',
//                                          '{$collection_interest}', '{$intloan_port}', '{$intloan_port}', '{$gen_date}', '0', '0', '{$gen_date}', '0', '{$collection_interest}', '0.00')");
//                                                 // done
//                                                 if ($insert_i_port) {
//                                                     echo "DONE HERE";
//                                                 } else {
//                                                     echo "WE NOT DONE";
//                                                 }
//                                             } else {
//                                                 echo "ERROR IN INTEREST EARNING";
//                                             }
//                                          } else {
//                                              echo "ERROR IN GL TRANSACTION FOR PORTFOLIO";
//                                             //  echo something else
//                                          }
//                                     } else {
//                                         // finish
//                                         echo "ERROR IN UPDATE";
//                                     }
//                                 //    and also for the Interest
//                                 //    END REPAYMENT
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
//             }
//             //  else if ($client_account_balance < $collection_due_paid && $client_account_balance >= 1) {
//             //     // DO CARD COLLECTION
//             //     $digits = 5;
//             //     $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
//             //     $trans_id = $client_firstname.$randms.$branch_id;
//             //     // check of the account balance is up to or not up to
//             //     $new_c_bal = $client_account_balance - $collection_interest;
//             //     if ($new_c_bal >= 0) {
//             //         // dman
//             //         $client_loan_bal = $new_c_bal;
//             //         // PUT THE INTEREST HERE
//             //         $open_acct_rule = mysqli_query($connection, "SELECT * FROM acct_rule WHERE int_id = '$int_id' AND loan_product_id = '$product_id'");
//             //         $ty = mysqli_fetch_array($open_acct_rule);
//             //             // reduce
//             //             $int_loan_port = $ty["inc_interest"];
//             //         $int_d_s = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE gl_code = '$int_loan_port' AND int_id = '$int_id'");
//             //             if (mysqli_num_rows($int_d_s) > 0) {
//             //                 $igdb = mysqli_fetch_array($int_d_s);
//             //                 $intbalport = $igdb["organization_running_balance_derived"];
//             //                 $intloan_port = $intbalport + $collection_interest;
//             //                 // run the port folio
//             //                 $update_the_int_loan = mysqli_query($connection, "UPDATE acc_gl_account SET organization_running_balance_derived = '$intloan_port' WHERE int_id = '$int_id' AND gl_code ='$int_loan_port'");
//             //                 if ($update_the_int_loan) {
//             //                 $insert_i_port = mysqli_query($connection, "INSERT INTO `gl_account_transaction` (`int_id`, `branch_id`, `gl_code`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`,
//             //                 `amount`, `gl_account_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`) 
//             //                 VALUES ('{$int_id}', '{$branch_id}', '{$int_loan_port}', '{$trans_id}', 'Loan_Repayment Interest / {$client_firstname}', 'Loan_Repayment Interest', '0', '0', '{$gen_date}',
//             //                 '{$collection_interest}', '{$intloan_port}', '{$intloan_port}', '{$gen_date}', '0', '0', '{$gen_date}', '0', '{$collection_interest}', '0.00')");
//             //                 if ($insert_i_port) {
//             //                     // noew update the interest
//             //                     $update_rep_sch = mysqli_query($connection, "UPDATE `loan_repayment_schedule` SET interest_amount = '0.00' WHERE id = '$collection_id'");
//             //                     if ($update_rep_sch) {
//             //                         echo "UPDATE LOAN REPAYMENT FOR AVAILABLE INTERESR";
//             //                     }
//             //                 } else {
//             //                     echo "PROBLEM WITH GL INTEREST";
//             //                 }
//             //                 } else {
//             //                     echo "ERROR IN INTEREST UPDATE";
//             //                 }
//             //             } else {
//             //                 echo "CANT FIND INTEREST PORTFOLIO";
//             //             }
//             //     } else if ($new_c_bal < 0) {
//             //         // damn
//             //         $client_loan_bal = 0.00;
//             //         $new_interest_balance = $collection_interest - $client_account_balance;
//             //         $collection_interest = $client_account_balance;
//             //         // $client_loan_bal = ;
//             //         $open_acct_rule = mysqli_query($connection, "SELECT * FROM acct_rule WHERE int_id = '$int_id' AND loan_product_id = '$product_id'");
//             //         $ty = mysqli_fetch_array($open_acct_rule);
//             //             // reduce
//             //             $int_loan_port = $ty["inc_interest"];
//             //         $int_d_s = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE gl_code = '$int_loan_port' AND int_id = '$int_id'");
//             //             if (mysqli_num_rows($int_d_s) > 0) {
//             //                 $igdb = mysqli_fetch_array($int_d_s);
//             //                 $intbalport = $igdb["organization_running_balance_derived"];
//             //                 $intloan_port = $intbalport + $collection_interest;
//             //                 // run the port folio
//             //                 $update_the_int_loan = mysqli_query($connection, "UPDATE acc_gl_account SET organization_running_balance_derived = '$intloan_port' WHERE int_id = '$int_id' AND gl_code ='$int_loan_port'");
//             //                 if ($update_the_int_loan) {
//             //                 $insert_i_port = mysqli_query($connection, "INSERT INTO `gl_account_transaction` (`int_id`, `branch_id`, `gl_code`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`,
//             //                 `amount`, `gl_account_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`) 
//             //                 VALUES ('{$int_id}', '{$branch_id}', '{$int_loan_port}', '{$trans_id}', 'Loan_Repayment Interest / {$client_firstname}', 'Loan_Repayment Interest', '0', '0', '{$gen_date}',
//             //                 '{$collection_interest}', '{$intloan_port}', '{$intloan_port}', '{$gen_date}', '0', '0', '{$gen_date}', '0', '{$collection_interest}', '0.00')");
//             //                 if ($insert_i_port) {
//             //                     // noew update the interest
//             //                     $update_rep_sch = mysqli_query($connection, "UPDATE `loan_repayment_schedule` SET interest_amount = '$new_interest_balance' WHERE id = '$collection_id'");
//             //                     if ($update_rep_sch) {
//             //                         echo "UPDATE LOAN REPAYMENT FOR AVAILABLE INTERESR";
//             //                     }
//             //                 } else {
//             //                     echo "PROBLEM WITH GL INTEREST";
//             //                 }
//             //                 } else {
//             //                     echo "ERROR IN INTEREST UPDATE";
//             //                 }
//             //             } else {
//             //                 echo "CANT FIND INTEREST PORTFOLIO";
//             //             }
//             //         // make a new look.
//             //     }
//             //     // MAKE A RECORD and leave the interest as 1. --- MAKE UP THE MOVES
//             //     // TAKE THE INTEREST FROM THE BALANCE
//             //     $update_client_account = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$client_loan_bal' WHERE int_id = '$int_id' AND client_id = '$client_id' AND account_no = '$acct_no'");
//             //        if ($update_client_account) {
//             //         $insert_client_trans = mysqli_query($connection, "INSERT INTO `account_transaction` (`int_id`, `branch_id`,
//             //         `product_id`, `account_id`, `account_no`, `client_id`, `teller_id`, `transaction_id`,
//             //         `description`, `transaction_type`, `is_reversed`, `transaction_date`, `amount`, `overdraft_amount_derived`,
//             //         `balance_end_date_derived`, `balance_number_of_days_derived`, `running_balance_derived`,
//             //         `cumulative_balance_derived`, `created_date`, `appuser_id`, `manually_adjusted_or_reversed`, `debit`, `credit`) 
//             //         VALUES ('{$int_id}', '{$branch_id}', '0', '{$account_id}', '{$acct_no}', '{$client_id}', '0', '{$trans_id}',
//             //         'Loan_Principal_Repayment', 'loan_repayment', '0', '{$gen_date}', '{$collection_interest}', '{$collection_interest}',
//             //         '{$gen_date}', '0', '{$client_loan_bal}',
//             //         '{$collection_interest}', '{$gen_date}', '0', '0', '{$collection_interest}', '0.00')");
//             //         if ($insert_client_trans) {
//             //             // make an update moves
//             //             $total_out_stand = $general_payment - $collection_interest;
//             //             $update_loan_trans = mysqli_query($connection, "INSERT INTO `loan_transaction` (`int_id`, `branch_id`, `product_id`, `loan_id`, `transaction_id`, `client_id`, `account_no`, `is_reversed`, `external_id`, `transaction_type`, `transaction_date`, `amount`,
//             //             `payment_method`, `principal_portion_derived`, `interest_portion_derived`, `fee_charges_portion_derived`, `penalty_charges_portion_derived`,
//             //             `overpayment_portion_derived`, `unrecognized_income_portion`, `suspended_interest_portion_derived`, `suspended_fee_charges_portion_derived`, 
//             //             `suspended_penalty_charges_portion_derived`, `outstanding_loan_balance_derived`, `recovered_portion_derived`, `submitted_on_date`, `manually_adjusted_or_reversed`, `created_date`, `appuser_id`, `is_account_transfer`) 
//             //            VALUES ('{$int_id}', '{$branch_id}', '0', '{$collection_loan}', '{$trans_id}', '{$client_id}', '{$acct_no}', '0', '0', 'Repayment_interest', '{$gen_date}', '{$collection_interest}', 
//             //            'auto_account', '{$collection_interest}', '{$collection_interest}', '0', '0', 
//             //            '0', NULL, '0', '0', '0', '{$total_out_stand}', '{$collection_interest}', '{$gen_date}', '0', '{$gen_date}', '0', '1')");
//             //            if ($update_loan_trans) {
//             //             // START QWERTY
//             //             echo "DONE WITH THE INTEREST REPAYMENT";
//             //             // -----++----
//             //             // END QWERTY
//             //            } else {
//             //             echo "ERROR IN UPDATE LOAN TRANSACTION";
//             //            }
//             //         } else {
//             //             echo "INTEREST TRANSACTION ERROR";
//             //         }
//             //         } else {
//             //             echo "ERROR IN INSERT TRANSACTION!";
//             //         }
//             //     // THE NEW INTEREST- BALANCE
//             //     // RECORED IN NECESSARY PLACES TO THE TRANSACTION -- UPDATE CLIENT ACCOUNT RECORD.
//             //     // CHECK IF THE PRINCPAL CAN GO AND DO SOME CHANGES
//             //     // -----MAKE A GOOD MOVE HERE-----
//             //     // TAKE THE INTEREST AMOUNT HERE
//             //     // check it can also take interest
//             //     //  DO REPAYMENT COLLECTION
//             //  }
//               else {
//                 // $balance_remaining = "Insufficient Fund";
//                 // DO THE INSUFFICIENT POSTING
//                 // TAKE THE CARD - IF CARD SUCCESS (REMEMBER TO DO THE TRANSACTION, REDUCE THE ID BY 1);
//                    // DO THE MOVE BY TAKING THE CARD
//                    $digits = 5;
//                    $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
//                    $trans_id = $client_firstname.$randms.$branch_id;
//                    // update client account
//                    $update_client_account = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$balance_remaining', total_withdrawals_derived = '$total_withd' WHERE int_id = '$int_id' AND client_id = '$client_id' AND account_no = '$acct_no'");
//                    if ($update_client_account) {
//                    // update client account transaction
//                    $insert_client_trans = mysqli_query($connection, "INSERT INTO `account_transaction` (`int_id`, `branch_id`,
//                    `product_id`, `account_id`, `account_no`, `client_id`, `teller_id`, `transaction_id`,
//                    `description`, `transaction_type`, `is_reversed`, `transaction_date`, `amount`, `overdraft_amount_derived`,
//                    `balance_end_date_derived`, `balance_number_of_days_derived`, `running_balance_derived`,
//                    `cumulative_balance_derived`, `created_date`, `appuser_id`, `manually_adjusted_or_reversed`, `debit`, `credit`) 
//                    VALUES ('{$int_id}', '{$branch_id}', '0', '{$account_id}', '{$acct_no}', '{$client_id}', '0', '{$trans_id}',
//                    'Loan_Repayment', 'loan_repayment', '0', '{$gen_date}', '{$collection_due_paid}', '{$collection_due_paid}',
//                    '{$gen_date}', '0', '{$balance_remaining}',
//                    '{$balance_remaining}', '{$gen_date}', '0', '0', '{$collection_due_paid}', '0.00')");
//                    if ($insert_client_trans) {
//                        // update loan
//                        $total_out_stand = $general_payment - $collection_due_paid;
//                      $up_client_loan = mysqli_query($connection, "UPDATE loan SET total_outstanding_derived = '$total_out_stand' WHERE int_id = '$int_id' AND client_id = '$client_id' AND (id = '$loan_id' AND account_no = '$acct_no')");
//                      if ($up_client_loan) {
//                         //  take take the loan outstanding table
//                        // update the loan transaction
//                        $update_loan_trans = mysqli_query($connection, "INSERT INTO `loan_transaction` (`int_id`, `branch_id`, `product_id`, `loan_id`, `transaction_id`, `client_id`, `account_no`, `is_reversed`, `external_id`, `transaction_type`, `transaction_date`, `amount`,
//                         `payment_method`, `principal_portion_derived`, `interest_portion_derived`, `fee_charges_portion_derived`, `penalty_charges_portion_derived`,
//                         `overpayment_portion_derived`, `unrecognized_income_portion`, `suspended_interest_portion_derived`, `suspended_fee_charges_portion_derived`, 
//                         `suspended_penalty_charges_portion_derived`, `outstanding_loan_balance_derived`, `recovered_portion_derived`, `submitted_on_date`, `manually_adjusted_or_reversed`, `created_date`, `appuser_id`, `is_account_transfer`) 
//                        VALUES ('{$int_id}', '{$branch_id}', '0', '{$collection_loan}', '{$trans_id}', '{$client_id}', '{$acct_no}', '0', '0', 'Repayment', '{$gen_date}', '{$collection_due_paid}', 
//                        'auto_account', '{$collection_principal}', '{$collection_interest}', '0', '0', 
//                        '0', NULL, '0', '0', '0', '{$total_out_stand}', '{$collection_due_paid}', '{$gen_date}', '0', '{$gen_date}', '0', '1')");
//                        //   if ($connection->error) {
//                        //             try {
//                        //                 throw new Exception("MYSQL error $connection->error <br> $update_loan_trans ", $mysqli->error);
//                        //             } catch (Exception $e) {
//                        //                 echo "Error No: ".$e->getCode()." - ".$e->getMessage() . "<br>";
//                        //                 echo n12br($e->getTraceAsString());
//                        //             }
//                        //         }
//                        if ($update_loan_trans) {
//                            // update the repayment sch history
//                            $update_repayment = mysqli_query($connection, "INSERT INTO `loan_repayment_schedule_history` (`int_id`, `loan_id`, `client_id`, `loan_reschedule_request_id`, `fromdate`, `duedate`, `installment`, `principal_amount`, `interest_amount`, `fee_charges_amount`, `penalty_charges_amount`, `createdby_id`, `created_date`, `lastmodified_date`)
//                             VALUES ('{$int_id}', '{$loan_id}', '{$client_id}', '{$collection_id}', '{$repayment_start}', '{$matured_date}', '1', '{$collection_principal}', '{$collection_interest}', '0', '0', NULL, '{$gen_date}', '{$gen_date}')");
//                            if ($update_repayment) {
//                                // Loan_Repayment status
//                                $update_rep_status = mysqli_query($connection, "INSERT INTO `loan_repayment_status` (`int_id`, `loan_id`, `client_id`, `product_id`, `date_due`, `date_paid`, `status`, `pay_descript`, `loan_status`, `loan_status_descript`, `pay_type`, `pay_status`) 
//                                VALUES ('{$int_id}', '{$loan_id}', '{$client_id}', '{$product_id}', '{$general_date_due}', '{$gen_date}', '0', 'early', '0', 'active', 'account', '0')");
//                                if ($update_rep_status) {
//                                    // YOU STOPPED HERE HERE
//                                   // update the repayement sch.
//                                   $update_rep_status = mysqli_query($connection, "UPDATE `loan_repayment_schedule` SET installment = '$post_installment' WHERE int_id = '$int_id' AND id = '$collection_id'");
//                                   if ($update_rep_status) {
//                                       echo "SUCCESS AT LAST";
//                                       if ($collection_interest < 0) {
//                                           $collection_interest = 0;
//                                       }
//                                       if ($collection_principal < 0) {
//                                         //  finsih 
//                                           $collection_principal = 0;
//                                       }
//                                         $makebig_move = mysqli_query($connection, "INSERT INTO `loan_arrear` (`int_id`, `loan_id`, `client_id`, `fromdate`, `duedate`, `installment`, `counter`, `principal_amount`, `principal_completed_derived`, `principal_writtenoff_derived`, `interest_amount`, `interest_completed_derived`, `interest_writtenoff_derived`, `total_paid_late_derived`, `completed_derived`, `obligations_met_on_date`, `createdby_id`, `created_date`, `lastmodified_date`) VALUES ('{$int_id}', '{$collection_loan}', '{$collection_client_id}', '{$gen_date}', '{$general_date_due}', '{$collection_installment}', '1', '{$collection_principal}', '{$collection_principal}', '0', '{$collection_interest}', '{$collection_interest}', '0', '0', '0', NULL, '{$approved_by}', '{$sch_date}', '{$sch_date}')");
//                                             if ($makebig_move) {
//                                                 echo "we done over here - LOAN IN ARREARS";
//                                             } else {
//                                                 echo "ERROR IN LOAN ARREAR";
//                                             }
//                                    //    and also for the Interest
//                                 //    qwerty
//                                    //    END REPAYMENT
//                                   } else {
//                                       echo "ERROR AT LAST";
//                                   }
//                                  // FROM THE LOAN
//                                } else {
//                                    echo "ERROR at Repayment Status";
//                                }
//                            } else {
//                                echo "ERROR Loan Reayment Schedule History";
//                            }
//                        } else {
//                            echo "ERROR in Update Transaction";
//                        }
//                      } else {
//                        echo "BAD at the loan update";
//                      }
//                    } else {
//                        echo "Error in client transaction";
//                    }            
//                    //  THINK ABOUT SOMETHING ELSE
//                    //  ALRUGHT INTEREST FIRST -- PRINCIpal
//                 // TAKE CHARGE EVERY 28 DAYS
//                    } else {
//                        echo "Error in Update Client Account";
//                    }
//                    // END UPDATE
//                 // IF CARD IS BAD - THROW THE ACCOUNT INTO MINUS
//                 echo "NO FUND";
//                 // MAKE A THROW FOR MINUS ACCOUNT TO THE GL
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
// ?>

<?php
// script to check all the users current time
// logic if the current time is different then make it non active
$current_time = date('Y-m-d H:i:s', strtotime('-2 minutes'));
// line to query the users
$select_user = mysqli_query($connection, "SELECT * FROM users");
while ($row = mysqli_fetch_array($select_user)) {
    // display each - lastlogged, id and int_id.
    $id = $row["id"];
    $int_id = $row["int_id"];
    $ll = $row["last_logged"];

    if ($current_time > $ll) {
        // make a query to update users profile to not active
        $activeq = "UPDATE users SET users.status ='Not Active' WHERE id = '$id' AND int_id = '$int_id'";
$rezz = mysqli_query($connection, $activeq);
        echo "F LATE";
    }
}
// ?>

<?php
// count it
// check it check if installment is 0 or 1.
$select_arrears = mysqli_query($connection, "SELECT * FROM `loan_arrear` WHERE installment >= 1");
while ($iq = mysqli_fetch_array($select_arrears)) {
    // now we need to get it.
    $a_id = $iq["id"];
    $a_int_id = $iq["int_id"];
    $a_loan_id = $iq["loan_id"];
    $a_client_id = $iq["client_id"];
    $i_due_date = $iq["duedate"];
    $i_counter = $iq["counter"];
    // php
    $current_date = date('Y-m-d');
    $cal_start = strtotime($i_due_date);
    $cal_end = strtotime($current_date);
    // do your calculation
    $days_between = ceil(abs($cal_end - $cal_start) / 86400);
    // percentage Value
                  $days_no = $iq['counter'];
                  $prin = $iq['principal_amount'];
                  $thirty = '0.00';
                  $sixty = '0.00';
                  $ninety = '0.00';
                  $above = '0.00';
                  if(30 > $days_no && $days_no > 0){
                    $thirty = number_format($iq['principal_amount'], 2);
                    $ffd = $iq['principal_amount'];
                    $bnk_prov = (0.05 * $ffd);
                  }
                  else if(60 > $days_no && $days_no > 30){
                    $sixty = number_format($iq['principal_amount'], 2);
                    $fdfdf = $iq['principal_amount'];
                    $bnk_prov = (0.2 * $fdfdf);
                  }
                  else if(90 > $days_no && $days_no > 60){
                    $ninety = number_format($iq['principal_amount'], 2);
                    $dfgd = $iq['principal_amount'];
                    $bnk_prov = (0.5 * $dfgd);
                  }
                  else if($days_no > 90){
                    $above = number_format($iq['principal_amount'], 2);
                    $juiui = $iq['principal_amount'];
                    $bnk_prov = $juiui;
                  }
                  $pfar = 0;
                  $par = ($bnk_prov/$prin) * 100;
    // update ok
    $arrear_update = mysqli_query($connection, "UPDATE `loan_arrear` SET counter = '$days_between', par='$par', bank_provision = '$bnk_prov' WHERE id = '$a_id' AND int_id = '$a_int_id' AND loan_id = '$a_loan_id' AND client_id = '$a_client_id'");
    // aiit running.
    if ($arrear_update) {
        echo "IT HAS BEEN RECORDED";
    } else {
        echo  "BAD";
    }
    // now are done here!
    echo "DIFFERENCE BETWEEN DATE IS".$days_between;
}
// count out
?>
<?php
//  OFF
echo '</br></br></br>FTD Booking Auto Code right here:</br>';
// THIS PROCESS ID FOR THE PAYMENT OF FIXED DEPOSIT INTEREST TO THEIR ACCOUNTS
$ftd_booking_account = mysqli_query($connection, "SELECT * FROM ftd_booking_account WHERE status = 'Approved' AND is_paid = '0' AND is_deleted = '0'");
while($a = mysqli_fetch_array($ftd_booking_account)){
    // To pull all data concerning each FTD account
    $id = $a['id'];
    $int_id = $a['int_id'];
    $branch_id = $a['branch_id'];
    $client_id = $a['client_id']; 
    $account_no = $a['account_no']; 
    $product_id = $a['product_id']; 
    $ftd_id = $a['ftd_id']; 
    $field_officer_id  = $a['field_officer_id']; 
    $submittedon_date = $a['submittedon_date']; 
    $submittedon_userid = $a['submittedon_userid']; 
    $currency_code = $a['currency_code']; 
    $account_balance_derived = $a['account_balance_derived']; 
    $term = $a['term']; 
    $int_rate = $a['int_rate']; 
    $maturedon_date = $a['maturedon_date']; 
    $linked_savings_account = $a['linked_savings_account']; 
    $last_deposit = $a['last_deposit']; 
    $last_withdrawal = $a['last_withdrawal']; 
    $auto_renew_on_closure = $a['auto_renew_on_closure']; 
    $interest_repayment = $a['interest_repayment'];
    $int_post_period = $a['interest_posting_period_enum'];

    $status = 'status';
    $todaysdate = date('Y-m-d');

    // to check if schedule has been added or not
    $feo = "SELECT * FROM ftd_interest_schedule WHERE ftd_id = '$id' AND int_id = '$int_id' AND ftd_no = '$ftd_id' AND branch_id = '$branch_id'";
    $fdio = mysqli_query($connection, $feo);
    $rieo = mysqli_fetch_array($fdio);
    // if balance has been added
    if($rieo >= 1){
        // Pull balance from ftd interest schedule
        $sdspo = "SELECT * FROM ftd_interest_schedule WHERE ftd_id = '$id' AND int_id = '$int_id' AND ftd_no = '$ftd_id' AND branch_id = '$branch_id' AND installment >= '1'";
        $sdoi = mysqli_query($connection, $sdspo);

        while($od = mysqli_fetch_array($sdoi)){
            $ifd = $od['id'];
            $linkedin = $od['linked_savings_account'];
            $linkedamount = $od['interest_amount'];
            $start_date = $od['start_date'];
            $clid = $od['client_id'];
            $ftt = $od['ftd_no'];

            // if its time to pull transaction
            if(strtotime($todaysdate) == strtotime($start_date)){

            $fddio = "SELECT * FROM account WHERE int_id = '$int_id' AND id = '$linkedin'";
            $fdfp = mysqli_query($connection, $fddio);
            $pw = mysqli_fetch_array($fdfp);
            $account_bal = $pw['account_balance_derived'];
            $brid = $pw['branch_id'];
            $account_no = $pw['account_no'];
            $prd = $pw['product_id'];
            $new_bal = $linkedamount +  $account_bal;

            $dsiod = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$new_bal', last_deposit = '$linkedamount' WHERE 
            id = '$linked_savings_account' AND int_id = '$int_id'");
            
            if($dsiod){
                echo 'account updated</br>';
                $dpo = mysqli_query($connection, "INSERT INTO account_transaction (int_id, branch_id, account_no, account_id, product_id,
                client_id, transaction_id, description, transaction_type, is_reversed, transaction_date, amount, running_balance_derived,
                overdraft_amount_derived, created_date, credit) VALUES ('{$int_id}', '{$brid}', '{$account_no}', '{$linkedin}', '{$prd}',
                 '{$clid}', '{$ftt}', 'monthly_interest_repayment', 'Credit', '0', '{$start_date}',
                 '{$linkedamount}', '{$new_bal}', '{$linkedamount}', '{$todaysdate}', '{$linkedamount}')");
            }
            if($dsiod){
                echo 'account transaction inserted</br>';
                $fmdpf = mysqli_query($connection, "UPDATE ftd_interest_schedule SET installment = '0' WHERE int_id = '$int_id' AND id = '$ifd'");
                echo 'ftd_interest_schedule updated</br>';
            }

        }
      }
    }
    else{
    // To check if the interest repayment is monthly or Bullet
    // if interest repayment is monthly
    if($interest_repayment == 1){
        // date calculation
        $i = 1;
        $feio = number_format($term/$int_post_period);
        if(strtotime($todaysdate) <= strtotime($maturedon_date)){
            while($i <= $feio){
                // to calculate start date
                $day = $i * $int_post_period;
                // start date
                $dsl = date('Y-m-d', strtotime($submittedon_date. ' + '.$day.' days'));
                // interest_amount
                $int_amt = ($int_rate/100) * $account_balance_derived;

                $woi = "INSERT INTO `ftd_interest_schedule` (`int_id`, `branch_id`, `client_id`,`ftd_id`, `installment`, `ftd_no`, 
                `start_date`, `end_date`, `interest_rate`, `interest_amount`, `linked_savings_account`, `interest_repayment`) 
                VALUES ('{$int_id}', '{$branch_id}', '{$client_id}', '{$id}', '{$i}', '{$ftd_id}', '{$dsl}', '{$dsl}', '{$int_rate}', '{$int_amt}', '{$linked_savings_account}', '{$interest_repayment}')";
                $myd = mysqli_query($connection, $woi);
                if($myd){
                    echo 'Done for ID '.$id.', number'.$i.'</br>';
                }
            $i++;
            }
        }
    }
    // if interest repayment is  Bullet
    else if($interest_repayment == 2){
      if(strtotime($todaysdate) <= strtotime($maturedon_date)){

        // amount Calculation
         $int_amt = ($int_rate/100) * $account_balance_derived;
        $feio = number_format($term/30);
        $dtc = $int_amt * $feio;
        $dsl = date('Y-m-d', strtotime($submittedon_date. ' + '.$term.' days'));

        // Execute Query
        $woi = "INSERT INTO `ftd_interest_schedule` (`int_id`, `branch_id`, `client_id`, `ftd_id`, `installment`, `ftd_no`, 
        `start_date`, `end_date`, `interest_rate`, `interest_amount`, `linked_savings_account`, `interest_repayment`) 
        VALUES ('{$int_id}', '{$branch_id}', '{$client_id}', '{$id}', '{$feio}', '{$ftd_id}', '{$dsl}', '{$dsl}', '{$int_rate}', '{$dtc}', '{$linked_savings_account}', '{$interest_repayment}')";
        $myd = mysqli_query($connection, $woi);
        if($myd){
            echo 'Done for ID '.$id.', number'.$feio.'</br>';
        }
      }
    }
  }
//   if the time is due to repay ftd booking
  if(strtotime($todaysdate) == strtotime($maturedon_date)){

        $dsiu = "SELECT * FROM account WHERE int_id = '$int_id' AND id = '$linked_savings_account'";
        $fdio = mysqli_query($connection, $dsiu);
        $pw = mysqli_fetch_array($fdio);
        $account_bal = $pw['account_balance_derived'];
        $brid = $pw['branch_id'];
        $account_no = $pw['account_no'];
        $prd = $pw['product_id'];
        $new_bal = $account_balance_derived +  $account_bal;

        $dsiod = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$new_bal', last_deposit = '$account_balance_derived' WHERE 
            id = '$linked_savings_account' AND int_id = '$int_id'");
            
            if($dsiod){
                echo 'account updated</br>';
                $dpo = mysqli_query($connection, "INSERT INTO account_transaction (int_id, branch_id, account_no, account_id, product_id,
                client_id, transaction_id, description, transaction_type, is_reversed, transaction_date, amount, running_balance_derived,
                overdraft_amount_derived, created_date, credit) VALUES ('{$int_id}', '{$brid}', '{$account_no}', '{$linked_savings_account}', '{$prd}',
                 '{$clid}', '{$ftt}', 'FTD_repayment', 'Credit', '0', '{$todaysdate}',
                 '{$account_balance_derived}', '{$new_bal}', '{$account_balance_derived}', '{$todaysdate}', '{$account_balance_derived}')");
            }
            if($dsiod){
                echo 'account transaction inserted</br>';
                $fmdpf = mysqli_query($connection, "UPDATE ftd_booking_account SET is_paid = '1', is_deleted = '1' WHERE int_id = '$int_id' AND id = '$id'");
                if($fmdpf){
                    echo 'ftd_interest_schedule updated</br>';
                    if($auto_renew_on_closure == 1){
                        $final_date = date('Y-m-d', strtotime($todaysdate. ' + '.$term.' days'));
                        $fmdpf = mysqli_query($connection, "UPDATE ftd_booking_account SET is_paid = '0', submittedon_date = '$todaysdate', maturedon_date = '$final_date', is_deleted = '0' WHERE int_id = '$int_id' AND id = '$id'");
                    }
                    else{
                        $pdofg = "DELETE FROM account WHERE int_id = '$int_id' AND client_id = '$client_id' AND account_no = '$account_no'";
                        $ifofd = mysqli_query($connection, $pdofg);
                        echo 'End of code</br>';
                    }
                }
            }
    }
}

?>


<?php
// CODE TO TRACK DORMANCY IN THE SYSTEM
echo '</br></br></br>Track Dormancy Code right here:</br>';
// Declaring the variables for dormant accounts
$account = "SELECT * FROM account WHERE type_id = '1'";
$exec = mysqli_query($connection, $account);
while($que = mysqli_fetch_array($exec)){
    $name = $que['account_no'];
    $id = $que['id'];
    $intid = $que['int_id'];
    $last_edit = $que['updatedon_date'];
    $date = date('Y-m-d');
    $status = $que['status'];
    $current = strtotime($date);
    $last_update = strtotime($last_edit);

    $fdi = "SELECT * FROM dormancy_counter WHERE int_id = '$intid'";
    $idfo = mysqli_query($connection, $fdi);
    if($idfo){
        $qp = mysqli_fetch_array($idfo);
        $ina = $qp['day_to_inactive'];
        $dor = $qp['day_to_dormancy'];
        $arc = $qp['day_to_archive'];

        $days = ceil(abs($current - $last_update) / 86400);
        if($days <= $ina){
            if($status == 'Active'){
                echo 'its already active</br>';
            }
            else{
                $fdi = "UPDATE account SET status = 'Active' WHERE id = '$id'";
                $ufd = mysqli_query($connection, $fdi);
                echo 'its active</br>';
            }
        }
        else if($days > $ina && $days <= $dor){
            if($status == 'Inactive'){
                echo 'its already Inactive</br>';
            }
            else{
                $fdi = "UPDATE account SET status = 'Inactive' WHERE id = '$id'";
                $ufd = mysqli_query($connection, $fdi);
                echo 'its Inactive';
            }
            
        }
        else if($days > $dor && $days <= $arc){
            if($status == 'Dormant'){
                echo 'its already Dormant</br>';
            }
            else{
                $fdi = "UPDATE account SET status = 'Dormant' WHERE id = '$id'";
                $ufd = mysqli_query($connection, $fdi);
                echo 'its Dormant';
            }
        }
        else if($days > $arc){
            if($status == 'Archived'){
                echo 'its already Archived</br>';
            }
            else{
                $fdi = "UPDATE account SET status = 'Archived' WHERE id = '$id'";
                $ufd = mysqli_query($connection, $fdi);
                echo 'its archived';
            }
        }
    }

}
?>

<?php
// due date
$charge_query = mysqli_query($connection, "SELECT * FROM auto_charge WHERE is_active = '1'");
// end date
if (mysqli_num_rows($charge_query) >= 1) {
    while ($bx = mysqli_fetch_array($charge_query)) {
    $c_id = $bx["id"];
    $c_int_id = $bx["int_id"];
    $c_name = $bx["name"];
    $c_type = $bx["charge_type"];
    $c_amount = $bx["amount"];
    $c_fee_day = $bx["fee_on_day"];
    // $c_interval = $bx["interval"];
    $c_gl = $bx["gl_code"];
    $c_cal = $bx["charge_cal"];
        // ok make a new move
      if ($c_type == "sms") {
        //   if it is equals to sms
        $check_sms_table = mysqli_query($connection, "SELECT * FROM `sms_charge` WHERE paid = '0' ORDER BY client_id, account_no LIMIT 1");
        if (mysqli_num_rows($check_sms_table) >= 1) {
            $sc = mysqli_fetch_array($check_sms_table);
                $s_client_id = $sc["client_id"];
                $s_account = $sc["account_no"];
                $s_int_id = $sc["int_id"];
                $s_branch_id = $sc["branch_id"];
                
                $sum_account = mysqli_query($connection, "SELECT * FROM `sms_charge` WHERE account_no = '$s_account' AND client_id = '$s_client_id'");
                $sm = mysqli_num_rows($sum_account);
                if ($c_cal <= "1"){
                    $s_amount = $c_amount * $sm;
                } else {
                    $s_amount = $c_amount * $sm;
                }
                
                // make a charge
                $select_account = mysqli_query($connection, "SELECT * FROM account WHERE account_no = '$s_account' AND client_id = '$s_client_id'");
                // $s
                $u = mysqli_fetch_array($select_account);
            $account_id = $u["id"];
            $client_account_balance = $u["account_balance_derived"];
            $balance_remaining = $client_account_balance - $s_amount;
            $total_withd =  $u["total_withdrawals_derived"] + $s_amount;
                $current_day = date('Y-m-d');
                $date_time = date('Y-m-d H:i:s');
                $last_month_day = date("Y-m-t");
                if ($current_day == $last_month_day) {
                    // make an echo.
                    $digits = 5;
                    $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
                    $trans_id = $randms."SMS";
                    $update_client_account = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$balance_remaining', total_withdrawals_derived = '$total_withd' WHERE client_id = '$s_client_id' AND account_no = '$s_account'");
                    if ($update_client_account) {
                    $insert_client_trans = mysqli_query($connection, "INSERT INTO `account_transaction` (`int_id`, `branch_id`,
                `product_id`, `account_id`, `account_no`, `client_id`, `teller_id`, `transaction_id`,
                `description`, `transaction_type`, `is_reversed`, `transaction_date`, `amount`, `overdraft_amount_derived`,
                `balance_end_date_derived`, `balance_number_of_days_derived`, `running_balance_derived`,
                `cumulative_balance_derived`, `created_date`, `appuser_id`, `manually_adjusted_or_reversed`, `debit`, `credit`) 
                VALUES ('{$s_int_id}', '{$s_branch_id}', '0', '{$account_id}', '{$s_account}', '{$s_client_id}', '0', '{$trans_id}',
                'SMS_CHARGE', 'SMS_CHARGE', '0', '{$current_day}', '{$s_amount}', '{$s_amount}',
                '{$current_day}', '0', '{$balance_remaining}',
                '{$balance_remaining}', '{$date_time}', '0', '0', '{$s_amount}', '0.00')");
                if ($insert_client_trans) {
                    // GET ALL GL
                    $query_gl = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE gl_code = '$c_gl' AND int_id = '$c_int_id'");
                    $igdb = mysqli_fetch_array($query_gl);
                    $intbalport = $igdb["organization_running_balance_derived"];
                    $s_gl_balance = $intbalport + $s_amount;
                    // get the GL
                    $update_the_loan = mysqli_query($connection, "UPDATE acc_gl_account SET organization_running_balance_derived = '$s_gl_balance' WHERE int_id ='$c_int_id' AND gl_code = '$c_gl'");
                    if ($update_the_loan) {
                        // make a new stuff
                        $insert_loan_port = mysqli_query($connection, "INSERT INTO `gl_account_transaction` (`int_id`, `branch_id`, `gl_code`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`,
                                         `amount`, `gl_account_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`) 
                                        VALUES ('{$c_int_id}', '{$s_branch_id}', '{$c_gl}', '{$trans_id}', 'SMS CHARGE / {$s_account}', 'sms_charge', '0', '0', '{$current_day}',
                                         '{$s_amount}', '{$s_gl_balance}', '{$s_gl_balance}', '{$current_day}', '0', '0', '{$current_day}', '0', '0.00', '{$s_amount}')");
                                         if ($insert_loan_port) {
                                            //  next code
                                             $update_sms = mysqli_query($connection, "UPDATE sms_charge SET paid = '1' WHERE client_id = '$s_client_id' AND account_no = '$s_account'");
                    if ($update_sms) {
                        echo "SMS CHARGE SUCCESS";
                    } else {
                        echo "SMS CHARGE BAD";
                    }
                                         } else {
                                             echo "Error at GL insert";
                                         }
                    } else {
                        echo "error at gl update";
                    }
                } else {
                    echo "SYSTEM ERROR - INSERT ACCOUNT";
                }
        } else {
            echo "SYSTEM ERROR - UPDATE ACCOUNT";
        }
                } else {
                    // not yet ending
                }
        } else {
            echo "No SMS Charge";
        }
      } else if ($c_type == "") {
        //   make something for something else
      }
}
}
// ECHO SOMETHING
echo date("Y-m-d")."CURRENT MONTH";
echo date("Y-m-t")."ENDING THIS MONTH";
?>
<?php
echo "<br/><br/> /////////////////////////////////////////////// LOAN REMODEL ////////////////////////////////////// <br/><br/>";
// here we will work on AUTO BACK DATE REPAYMENT
$get_back_model = mysqli_query($connection, "SELECT * FROM `loan_remodeling` WHERE status = '1'");
if (mysqli_num_rows($get_back_model) >= 1) {
    while ($row = mysqli_fetch_array($get_back_model)) {
        // display the details
        $m_id = $row["id"];
        $m_int_id = $row["int_id"];
        $m_client_id = $row["client_id"];
        $m_loan_id = $row["loan_id"];
        $m_amount_paid = $row["amount_paid"];
        $m_status = $row["status"];
        $loan_off = $row["loan_officer"];
        $today_date = date('Y-m-d');
        $get_repayment_sch = mysqli_query($connection, "SELECT * FROM `loan_repayment_schedule` WHERE installment = '1' AND (duedate < '$today_date') AND (loan_id = '$m_loan_id' AND client_id = '$m_client_id') ORDER BY id ASC LIMIT 1");
        if (mysqli_num_rows($get_repayment_sch) >= 1) {
            // while loop
            while ($lrp = mysqli_fetch_array($get_repayment_sch)) {
                $r_id = $lrp["id"];
                $r_principal = $lrp["principal_amount"];
                $r_interest = $lrp["interest_amount"];
                $repayment_amount = $r_principal + $r_interest;
                $r_loan_id = $lrp["loan_id"];
                $r_client_id = $lrp["client_id"];
                $r_from_date = $lrp["fromdate"];
                $r_due_date = $lrp["duedate"];
                // DO CALCULATE
                $get_loan = mysqli_query($connection, "SELECT * FROM `loan` WHERE id = '$r_loan_id'");
                $gl = mysqli_fetch_array($get_loan);
                $client_account_no = $gl["account_no"];
                if ($client_account_no != "") {
                    // check the amount paid
                    if ($m_amount_paid >= $repayment_amount) {
                        // check
                        $new_repayment_balance = $m_amount_paid - $repayment_amount;
                        // query the new
                        $query_remodel = mysqli_query($connection, "UPDATE `loan_remodeling` SET `amount_paid` = '$new_repayment_balance' WHERE id = '$m_id' AND client_id = '$m_client_id'");
                        if ($query_remodel) {
                            // update the repayment
                        $query_update_repayment = mysqli_query($connection, "UPDATE `loan_repayment_schedule` SET `principal_amount` = '0.00', `interest_amount` = '0.00', `installment` = '0' WHERE `loan_repayment_schedule`.`id` = '$r_id'");
                        if ($query_update_repayment) {
                            echo "REPAYED SUCCESSFULLY";
                        } else {
                            echo "ERROR IN UPDATING REPAYMENT STRUCTURE";
                        }
                        } else {
                            echo "ERROR IN UPDATING REMODEL";
                        }
                        // hit a function here
                        // enda fucntin
                    } else if ($m_amount_paid < $repayment_amount && $m_amount_paid >= 0) {
                        // check it up
                        $new_repayment_balance = $repayment_amount - $m_amount_paid;
                        $r_prin = $r_principal;
                        echo $r_prin."HOLLA NEW PRINCIPAL NOT UPTO";
                        $r_inte = $r_interest;
                        echo $r_inte."INTEREST NOT UPTO";
                        $model_balance = 0;
                        // UPDATE
                        $query_remodel = mysqli_query($connection, "UPDATE `loan_remodeling` SET `amount_paid` = '$model_balance' WHERE id = '$m_id' AND client_id = '$m_client_id'");
                        if ($query_remodel) {
                            // update the repayment
                            // check if it is equals to the interest.
                            if ($m_amount_paid >= $r_inte) {
                                $new_interest = 0;
                                $new_bqwe = $m_amount_paid - $r_inte;
                                $new_principal = $r_principal - $new_bqwe;
                                // end the principal
                                $query_update_repayment = mysqli_query($connection, "UPDATE `loan_repayment_schedule` SET `principal_amount` = '$new_principal', `interest_amount` = '$new_interest', `installment` = '0' WHERE `loan_repayment_schedule`.`loan_id` = '$r_loan_id' AND client_id = '$r_client_id' AND duedate = '$r_due_date'");
                        if ($query_update_repayment) {
                            // add the remaining amount to the arrear table
                                $check_arrear = mysqli_query($connection, "INSERT INTO `loan_arrear` (`int_id`, `loan_id`, `client_id`, `fromdate`, `duedate`, `installment`, `counter`, `principal_amount`, `principal_completed_derived`, `principal_writtenoff_derived`, `interest_amount`, `interest_completed_derived`, `interest_writtenoff_derived`, `total_paid_late_derived`, `completed_derived`, `obligations_met_on_date`, `createdby_id`, `created_date`, `lastmodified_date`) 
                            VALUES ('{$m_int_id}', '{$m_loan_id}', '{$m_client_id}', '{$r_from_date}', '{$r_due_date}', '1', '1', '{$new_principal}', '{$new_principal}', '0', '{$new_interest}', '{$new_interest}', '0', '0', '0', NULL, '{$loan_off}', '{$today_date}', '{$today_date}')");
                            if ($check_arrear) {
                                echo "REPAYMENT HAS BEEN POSTED TO ARREARS";
                            } else {
                                echo "ERROR UPDATING ARREAR";
                            }
                            // end adding to the arrrear table
                        } else {
                            echo "ERROR IN UPDATING REPAYMENT STRUCTURE";
                        }

                            } else if ($m_amount_paid < $r_inte) {
                                // less then just take the 
                                $new_interest = $r_inte - $m_amount_paid;
                                $new_principal = $r_prin;
                                // make post
                                $query_update_repayment = mysqli_query($connection, "UPDATE `loan_repayment_schedule` SET `principal_amount` = '$new_principal', `interest_amount` = '$new_interest', `installment` = '0' WHERE `loan_repayment_schedule`.`loan_id` = '$r_loan_id' AND client_id = '$r_client_id' AND duedate = '$r_due_date'");
                        if ($query_update_repayment) {
                            // add the remaining amount to the arrear table
                                $check_arrear = mysqli_query($connection, "INSERT INTO `loan_arrear` (`int_id`, `loan_id`, `client_id`, `fromdate`, `duedate`, `installment`, `counter`, `principal_amount`, `principal_completed_derived`, `principal_writtenoff_derived`, `interest_amount`, `interest_completed_derived`, `interest_writtenoff_derived`, `total_paid_late_derived`, `completed_derived`, `obligations_met_on_date`, `createdby_id`, `created_date`, `lastmodified_date`) 
                            VALUES ('{$m_int_id}', '{$m_loan_id}', '{$m_client_id}', '{$r_from_date}', '{$r_due_date}', '1', '1', '{$new_principal}', '{$new_principal}', '0', '{$new_interest}', '{$new_interest}', '0', '0', '0', NULL, '{$loan_off}', '{$today_date}', '{$today_date}')");
                            if ($check_arrear) {
                                echo "REPAYMENT HAS BEEN POSTED TO ARREARS";
                            } else {
                                echo "ERROR UPDATING ARREAR";
                            }
                            // end adding to the arrrear table
                        } else {
                            echo "ERROR IN UPDATING REPAYMENT STRUCTURE";
                        }
                            }
                        // end here
                        } else {
                            echo "ERROR IN UPDATING REMODEL";
                        }
                    }
                } else {
                    echo "CLIENT ACCOUNT NO IS EMPTY";
                }
            }
            // end while loop
        } else {
            echo "NO ACTIVE REPAYMENT";
        }
        // end the details
    }
} else {
    echo "NO ACTIVE REMODEL";
}
// END AUTO BACK REPAYMENT
?>
<?php
/////////////////////// AUTO CODE TO CALCULATE THE DEPRECIATION OF ALL ASSETS IN AN INSTITUTION ///////////////////////
echo '</br></br>Depreciation Calculation code right here:</br>';
// Pull all assets
$ifdo = mysqli_query($connection, "SELECT * FROM assets");
while($pd = mysqli_fetch_array($ifdo)){
    $aorp = $pd['id'];
    $int_id = $pd['int_id'];
    $asset_name = $pd['asset_name'];
    $asset_type_id = $pd['asset_type_id'];
    $type = $pd['type'];
    $qty = $pd['qty'];
    $unit_price = $pd['unit_price'];
    $amount = $pd['amount'];
    $asset_no = $pd['asset_no'];
    $location = $pd['location'];
    $date = $pd['date'];
    $dep = $pd['depreciation_value'];
    $current_year = $pd['current_year_depreciation'];
    $current_month = $pd['current_month_depreciation'];
    $curr_year = date('Y-m-d');
    $curr_month = date('m');

    // to get difference in years
    $purdate = strtotime($date);
    $currentdate = strtotime($curr_year);
    $datediff = $currentdate - $purdate;
    $datt = round($datediff / (60 * 60 * 24 * 365));

    // to get percentage
    $dom = ($dep/100) * $unit_price;
    // to get current year depreciation
    $currentyear = $unit_price - ($dom * $datt);

    // to get current month depreciation
    $curr_mon = $dom / 12;
    // last year plus number of months spent = this month depreciation
    $lasty = $unit_price - ($dom * ($datt - 1));
    if($currentyear != $unit_price){
    $current_month = $lasty + ($curr_mon * $curr_month);
    }
    else{
       $current_month =  $unit_price -($curr_mon * $curr_month);
    }

    $idof = "UPDATE assets SET current_year_depreciation = '$currentyear', current_month_depreciation = '$current_month' WHERE int_id = '$int_id' AND id = '$aorp'";
    $dos = mysqli_query($connection, $idof);
        if($dos){
            echo 'Depreciation Value for '.$asset_name.' with int_id '.$int_id.' was calculated</br>';
        }
}
?>