<?php
include('../functions/connect.php');

$query_arrears_table = mysqli_query($connection, "SELECT * FROM `loan_arrear` WHERE installment >= '1' LIMIT 1");

if (mysqli_num_rows($query_arrears_table) > 0) {
// get all the loan in arrears
while ($rrow = mysqli_fetch_array($query_arrears_table)) {
    $arr_id = $rrow["id"];
    $int_id = $rrow["int_id"];
    $loan_id = $rrow["loan_id"];
    // $principal_amount = $rrow["principal_amount"];
    // $interest_amount = $rrow["interest_amount"];

    // MAKE A PUSH
    $select_loan_client = mysqli_query($connection, "SELECT * FROM `loan` WHERE id = '$loan_id'");

    if (mysqli_num_rows($select_loan_client) > 0) {

        while ($lrow = mysqli_fetch_array($select_loan_client)) {
        $client_id = $lrow["client_id"];
        $loan_id = $lrow["id"];
        $product_id = $lrow["product_id"];
        $account_no = $lrow["account_no"];
        $int_id = $lrow["int_id"];
        $approved_by = $lrow["approvedon_userid"];
        // due date is today
        $sch_date = date("Y-m-d");
        $gen_date = date("Y-m-d H:i:s");

        // Make a NEW PUSH
        $collection_id = $rrow["id"];
        $collection_loan = $rrow["loan_id"];
        $collection_client_id = $lrow["client_id"];
        $collection_installment = $rrow["installment"];
        $collection_principal = $rrow["principal_amount"];
        $collection_interest = $rrow["interest_amount"];
        $general_date_due = $rrow["duedate"];

        // Make a new push
        $collection_due_paid = $collection_principal + $collection_interest;

         // get account balance of client account
         $loan_account = mysqli_query($connection, "SELECT * FROM account WHERE account_no = '$account_no' AND client_id = '$collection_client_id' AND int_id = '$int_id'");
         $u = mysqli_fetch_array($loan_account);
         $account_id = $u["id"];
         $client_account_balance = $u["account_balance_derived"];
         $tot_withdrawal = $u["total_withdrawals_derived"];
         $balance_remaining = $client_account_balance - $collection_due_paid;
         $total_withd =  $u["total_withdrawals_derived"] + $collection_due_paid;

        
         // get client Data Displayable at Description
         $client_account = mysqli_query($connection, "SELECT * FROM client WHERE id = '$client_id' AND int_id = '$int_id'");
         if (mysqli_num_rows($client_account) > 0) {
         $cx = mysqli_fetch_array($client_account);
         $branch_id = $cx["branch_id"];
         $client_firstname = $cx["firstname"];
         $client_phone = $cx["mobile_no"];
         

         //  Declare Transaction ID
         $digits = 5;
         $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
         $trans_id = $client_firstname.$randms.$branch_id;
         } else {
             echo "No Client Found";
         }

         // Start a Summary of Total Outstanding Derived
         $query_sum_repayment = mysqli_query($connection, "SELECT SUM(principal_amount + interest_amount) AS outstanding_repayment FROM `loan_repayment_schedule` WHERE ((loan_id = '$loan_id' AND int_id = '$int_id' AND client_id = '$client_id') AND installment > 0)");
         // get the information

         $gsr = mysqli_fetch_array($query_sum_repayment);
         $outstanding_repayment = $gsr["outstanding_repayment"];
         $query_sum_arrears = mysqli_query($connection, "SELECT SUM(principal_amount + interest_amount) AS outstanding_arrears FROM `loan_arrear` WHERE ((loan_id = '$loan_id' AND int_id = '$int_id' AND client_id = '$client_id') AND installment > 0)");
         // get the information

         $gsa = mysqli_fetch_array($query_sum_arrears);
         $outstanding_arrears = $gsa["outstanding_arrears"];

         // Output Total Outstanding Loan
         $outstanding_loan_balance = $outstanding_repayment + $outstanding_arrears;
         // End of Summary




         // Start Loan GL Portfolio and Interest GL Code
         $open_acct_rule = mysqli_query($connection, "SELECT * FROM acct_rule WHERE int_id = '$int_id' AND loan_product_id = '$product_id'");
         $ty = mysqli_fetch_array($open_acct_rule);
         $loan_port = $ty["asst_loan_port"];
         $int_loan_port = $ty["inc_interest"];

         // Get interest and Principal GL Code Accounting Rule and Query the Account GL TABLE
         $take_d_s = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE gl_code = '$loan_port' AND int_id = '$int_id'");
         $gdb = mysqli_fetch_array($take_d_s);
         // geng new thing here
         $int_d_s = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE gl_code = '$int_loan_port' AND int_id = '$int_id'");
         $igdb = mysqli_fetch_array($int_d_s);

         // Display Both Interest Balance and Port Balance
         $intbalport = $igdb["organization_running_balance_derived"];
         $newbalport = $gdb["organization_running_balance_derived"];
         // End Loan GL Portfolio and Interest GL Code

         //  test the condition IF Balance is Greater than Repayment Due Amount
         if ($client_account_balance >= $collection_due_paid) {
            $update_client_account = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$balance_remaining', total_withdrawals_derived = '$total_withd' WHERE int_id = '$int_id' AND client_id = '$client_id' AND account_no = '$account_no'");
            if ($update_client_account) {
                // insert into account

                $insert_client_trans = mysqli_query($connection, "INSERT INTO `account_transaction` (`int_id`, `branch_id`,
                        `product_id`, `account_id`, `account_no`, `client_id`, `teller_id`, `transaction_id`,
                        `description`, `transaction_type`, `is_reversed`, `transaction_date`, `amount`, `overdraft_amount_derived`,
                        `balance_end_date_derived`, `balance_number_of_days_derived`, `running_balance_derived`,
                        `cumulative_balance_derived`, `created_date`, `appuser_id`, `manually_adjusted_or_reversed`, `debit`, `credit`) 
                        VALUES ('{$int_id}', '{$branch_id}', '0', '{$account_id}', '{$account_no}', '{$client_id}', '0', '{$trans_id}',
                        'Loan_Repayment', 'loan_repayment', '0', '{$gen_date}', '{$collection_due_paid}', '{$collection_due_paid}',
                        '{$gen_date}', '0', '{$balance_remaining}',
                        '{$balance_remaining}', '{$gen_date}', '0', '0', '{$collection_due_paid}', '0.00')");

                if ($insert_client_trans) {
                // If client Account Transaction Successful Update the Loan and Loan Transaction Table for Reference

                 // Get the Current Loan Outstanding from *LINE 57 to LINE 71*
                 $new_outstanding_balance = $outstanding_loan_balance - $collection_due_paid;
                 $up_client_loan = mysqli_query($connection, "UPDATE loan SET total_outstanding_derived = '$new_outstanding_balance' WHERE int_id = '$int_id' AND client_id = '$client_id' AND (id = '$loan_id' AND account_no = '$account_no')");

                  // if loan update successful insert a transaction
                  if ($up_client_loan) {
                      // update the loan transaction
                      $update_loan_trans = mysqli_query($connection, "INSERT INTO `loan_transaction` (`int_id`, `branch_id`, `product_id`, `loan_id`, `transaction_id`, `client_id`, `account_no`, `is_reversed`, `external_id`, `transaction_type`, `transaction_date`, `amount`,
                      `payment_method`, `principal_portion_derived`, `interest_portion_derived`, `fee_charges_portion_derived`, `penalty_charges_portion_derived`,
                      `overpayment_portion_derived`, `unrecognized_income_portion`, `suspended_interest_portion_derived`, `suspended_fee_charges_portion_derived`, 
                      `suspended_penalty_charges_portion_derived`, `outstanding_loan_balance_derived`, `recovered_portion_derived`, `submitted_on_date`, `manually_adjusted_or_reversed`, `created_date`, `appuser_id`, `is_account_transfer`) 
                      VALUES ('{$int_id}', '{$branch_id}', '0', '{$collection_loan}', '{$trans_id}', '{$client_id}', '{$account_no}', '0', '0', 'Repayment', '{$gen_date}', '{$collection_due_paid}', 
                      'auto_account', '{$collection_principal}', '{$collection_interest}', '0', '0', 
                      '0', NULL, '0', '0', '0', '{$new_outstanding_balance}', '{$collection_due_paid}', '{$gen_date}', '0', '{$gen_date}', '0', '1')");

                      // if the Loan Transaction Insertion Successful Update Loan Repayment Schedule
                      if ($update_loan_trans) {
                        $update_rep_status = mysqli_query($connection, "UPDATE `loan_arrear` SET installment = '0' WHERE int_id = '$int_id' AND id = '$collection_id'");

                        // if the repayment update is successful
                        if ($update_rep_status) {

                            // Update the GL for Loan Interest and Portfolio from *LINE 76 to LINE 92*

                                        // START WITH Portfolio UPDATE - First Calculate the Balance
                                        $updated_loan_port = $newbalport - $collection_principal;
                                        $update_the_loan = mysqli_query($connection, "UPDATE acc_gl_account SET organization_running_balance_derived = '$updated_loan_port' WHERE int_id ='$int_id' AND gl_code = '$loan_port'");

                                        // after update of GL insert into transaction
                                        if ($update_the_loan) {
                                            $insert_loan_port = mysqli_query($connection, "INSERT INTO `gl_account_transaction` (`int_id`, `branch_id`, `gl_code`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`,
                                            `amount`, `gl_account_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`) 
                                            VALUES ('{$int_id}', '{$branch_id}', '{$loan_port}', '{$trans_id}', 'Loan_Repayment Principal / {$client_firstname}', 'Loan_Repayment Principal', '0', '0', '{$gen_date}',
                                            '{$collection_principal}', '{$updated_loan_port}', '{$updated_loan_port}', '{$gen_date}', '0', '0', '{$gen_date}', '0', '{$collection_principal}', '0.00')");
                                            // if The Loan Port folio Transaction has been Inserted Properly
                                            // Move to Update Interest
                                            if ($insert_loan_port) {

                                                // END WITH Interest UPDATE  - Calculate the Balance
                                                $intloan_port = $intbalport + $collection_interest;
                                                $update_the_int_loan = mysqli_query($connection, "UPDATE acc_gl_account SET organization_running_balance_derived = '$intloan_port' WHERE int_id = '$int_id' AND gl_code ='$int_loan_port'");

                                                // if Updating Loan Successful, Insert into the Interest Income Portfolio GL
                                                if ($update_the_int_loan) {
                                                    $insert_i_port = mysqli_query($connection, "INSERT INTO `gl_account_transaction` (`int_id`, `branch_id`, `gl_code`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`,
                                                    `amount`, `gl_account_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`) 
                                                    VALUES ('{$int_id}', '{$branch_id}', '{$int_loan_port}', '{$trans_id}', 'Loan_Repayment Interest / {$client_firstname}', 'Loan_Repayment Interest', '0', '0', '{$gen_date}',
                                                    '{$collection_interest}', '{$intloan_port}', '{$intloan_port}', '{$gen_date}', '0', '0', '{$gen_date}', '0', '{$collection_interest}', '0.00')");
                                                    if ($insert_i_port) {
                                                        echo "Done inserting to port";
                                                    } else {
                                                        echo "Error inserting to port";
                                                    }

// IMPORT AJAX in MFI FOLDER
include("../mfi/ajaxcallx.php");
$query_institution = mysqli_query($connection, "SELECT * FROM `institutions` WHERE int_id = '$int_id'");
if (mysqli_num_rows($query_institution) > 0) {
    $gi = mysqli_fetch_array($query_institution);

    // Get Information
    $int_name = $gi["int_name"];
    $sender_id = $gi["sender_id"];
    $description = "Loan Arrears Repayment";

    // Star the Customers Account Number
    $account_display = substr("$account_no", 0, 3)."*****".substr("$account_no",8);

?>
<!-- DEFINE TRANSACTION FIRST LAYER -->
<input type="text" id="s_int_id" value="<?php echo $int_id; ?>" hidden>
<input type="text" id="s_acct_nox" value="<?php echo $account_no; ?>" hidden>
<input type="text" id="s_branch_id" value="<?php echo $branch_id; ?>" hidden>
<input type="text" id="s_sender_id" value="<?php echo $sender_id; ?>" hidden>
<input type="text" id="s_phone" value="<?php echo $client_phone; ?>" hidden>
<input type="text" id="s_client_id" value="<?php echo $client_id; ?>" hidden>

<!-- ACCOUNT DETIALS -->
<input type="text" id="s_int_name" value="<?php echo $int_name; ?>" hidden>
<input type="text" id="s_acct_no" value="<?php echo $account_display; ?>" hidden>
<input type="text" id="s_amount" value="<?php echo $collection_due_paid; ?>" hidden>
<input type="text" id="s_desc" value="<?php echo $description; ?>" hidden>
<input type="text" id="s_date" value="<?php echo $gen_date; ?>" hidden>
<input type="text" id="s_balance" value="<?php echo number_format($balance_remaining, 2); ?>" hidden>

<!-- Script to Send AJAX information -->
<script>
$(document).ready(function() {
    // STORE ENTITY DETAILS
    var int_id = $('#s_int_id').val();
    var branch_id = $('#s_branch_id').val();
    var sender_id = $('#s_sender_id').val();
    var phone = $('#s_phone').val();
    var client_id = $('#s_client_id').val();
    var account_no = $('#s_acct_nox').val();

    // STORE VALUE OF TRANSACTION
    var amount = $('#s_amount').val();
    var acct_no = $('#s_acct_no').val();
    var int_name = $('#s_int_name').val();
    var trans_type = "Debit";
    var desc = $('#s_desc').val();
    var date = $('#s_date').val();
    var balance = $('#s_balance').val();
    // now we work on the body.
    var msg = int_name+" "+trans_type+" \n" + "Amt:NGN "+amount+" \n Acct: "+acct_no+"\nDesc: "+desc+" \nBal: "+balance+" \nAvail: "+balance+"\nDate: "+date+"\nThanks";
    $.ajax({
        url:"../mfi/ajax_post/sms/sms.php",
        method:"POST",
        data:{int_id:int_id, branch_id:branch_id, sender_id:sender_id, phone:phone, msg:msg, client_id:client_id, account_no:account_no },
        success:function(data){
            $('#make_display').html(data);
            }
        });
    });
</script>
<div id="make_display" hidden></div>
<?php
}


                                        
                                                } else {
                                                    echo "There was an Error Updating Loan Interest GL";
                                                }
                                            } else {
                                                echo "There was an Error Inserting to Loan Port GL";
                                            }
                                        } else {
                                            echo "There was an Error Updating Loan Port GL";
                                        }

                        } else {
                            echo "There was an Error Updating Repayment Schedule Table";
                        }
                    } else {
                        echo "There was an Error Inserting into Loan Table";
                    }
                } else {
                    echo "There was an Error Updating Loan Table";
                }
                 
            } else {
                echo "There was an Error Inserting in Client Transaction Table";
            }
            } else {
                echo "There was an Error Updating Client Account";
            }

         } else  {

            //  INPUT ELSE NOW
            // Else if it's not Greater Logic has to Change
                    
                    // calculate the Remaining Balance
                    // check if the balance is zero or greater.
                    if ($client_account_balance > 0) {
                        $balance_remaining = $client_account_balance - $collection_due_paid;
                        $new_collection_done = $client_account_balance;

                        // INTEREST AND  PRINCIPAL CALCULATION FOR ARREARS
                        if ($client_account_balance > $collection_interest) {
                            // CAC_interest for Arrears
                            $cac_interest = 0;
                            // cac_p is calculation of balance after taking interest
                            $cac_p = $client_account_balance - $collection_interest;
                            // cac principal is current payment minus the balance for pricipal in Arrears
                            $cac_principal = $collection_principal - $cac_p;
                            // collection interest for loan 
                            $collection_interest = $collection_interest;
                            // Collection Principal Calculation of *LINE284 for GL*
                            $collection_principal = $cac_p;
                            
                        } else {
                            // CAC_interest for Arrears Balance Minus 
                            $cac_interest = $client_account_balance - $collection_interest;
                            // CAC principal is Principal in Arrears
                            $cac_principal = $collection_principal;
                            // collection interest for loan 
                            $collection_interest = $client_account_balance;
                            // Collection Principal Was Zero cause balance was Exhusted
                            $collection_principal = 0;
                        }
                

                        // - D A T A TO GL -
                        // Update the GL for Loan Interest and Portfolio from *LINE 76 to LINE 92*

                                        // START WITH Portfolio UPDATE - First Calculate the Balance
                                        $updated_loan_port = $newbalport - $collection_principal;
                                        $update_the_loan = mysqli_query($connection, "UPDATE acc_gl_account SET organization_running_balance_derived = '$updated_loan_port' WHERE int_id ='$int_id' AND gl_code = '$loan_port'");

                                        // after update of GL insert into transaction
                                        if ($update_the_loan) {
                                            $insert_loan_port = mysqli_query($connection, "INSERT INTO `gl_account_transaction` (`int_id`, `branch_id`, `gl_code`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`,
                                            `amount`, `gl_account_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`) 
                                            VALUES ('{$int_id}', '{$branch_id}', '{$loan_port}', '{$trans_id}', 'Loan_Repayment Principal / {$client_firstname}', 'Loan_Repayment Principal', '0', '0', '{$gen_date}',
                                            '{$collection_principal}', '{$updated_loan_port}', '{$updated_loan_port}', '{$gen_date}', '0', '0', '{$gen_date}', '0', '{$collection_principal}', '0.00')");
                                            // if The Loan Port folio Transaction has been Inserted Properly
                                            // Move to Update Interest
                                            if ($insert_loan_port) {

                                                // END WITH Interest UPDATE  - Calculate the Balance
                                                $intloan_port = $intbalport + $collection_interest;
                                                $update_the_int_loan = mysqli_query($connection, "UPDATE acc_gl_account SET organization_running_balance_derived = '$intloan_port' WHERE int_id = '$int_id' AND gl_code ='$int_loan_port'");

                                                // if Updating Loan Successful, Insert into the Interest Income Portfolio GL
                                                if ($update_the_int_loan) {
                                                    $insert_i_port = mysqli_query($connection, "INSERT INTO `gl_account_transaction` (`int_id`, `branch_id`, `gl_code`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`,
                                                    `amount`, `gl_account_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`) 
                                                    VALUES ('{$int_id}', '{$branch_id}', '{$int_loan_port}', '{$trans_id}', 'Loan_Repayment Interest / {$client_firstname}', 'Loan_Repayment Interest', '0', '0', '{$gen_date}',
                                                    '{$collection_interest}', '{$intloan_port}', '{$intloan_port}', '{$gen_date}', '0', '0', '{$gen_date}', '0', '{$collection_interest}', '0.00')");

                                                    // update
                                                    if ($insert_i_port) {
                                                    echo "Inserted into Port";
                                                    } else {
                                                        echo "There is an Error in Inserting into Portfolio";
                                                    }
                                                } else {
                                                    echo "There is an Error in Updating Interest Portfolio";
                                                }
                                            } else {
                                                echo "There is an Error in Inserting to Gl Portfolio";
                                            }
                                        } else {
                                            echo "There is an Error in Updating GL Portfolio";
                                        }

                        // UPDATE GL 
                        // END GL UPDATE
                    } else {
                        $balance_remaining = $client_account_balance - $collection_due_paid;
                        $new_collection_done = 0;
                        $cac_principal = $collection_principal;
                        $cac_interest = $collection_interest;
                    }
                    // MOVE IT UP TO THE NEXT

                    // MAKE AN UPDATE
                     // update client account balance
                     $update_client_account = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$balance_remaining', total_withdrawals_derived = '$total_withd' WHERE int_id = '$int_id' AND client_id = '$client_id' AND account_no = '$account_no'");
                     if ($update_client_account) {
                        //  TRANSCTION
                        $insert_client_trans = mysqli_query($connection, "INSERT INTO `account_transaction` (`int_id`, `branch_id`,
                        `product_id`, `account_id`, `account_no`, `client_id`, `teller_id`, `transaction_id`,
                        `description`, `transaction_type`, `is_reversed`, `transaction_date`, `amount`, `overdraft_amount_derived`,
                        `balance_end_date_derived`, `balance_number_of_days_derived`, `running_balance_derived`,
                        `cumulative_balance_derived`, `created_date`, `appuser_id`, `manually_adjusted_or_reversed`, `debit`, `credit`) 
                        VALUES ('{$int_id}', '{$branch_id}', '0', '{$account_id}', '{$account_no}', '{$client_id}', '0', '{$trans_id}',
                        'Loan_Repayment', 'loan_repayment', '0', '{$gen_date}', '{$collection_due_paid}', '{$collection_due_paid}',
                        '{$gen_date}', '0', '{$balance_remaining}',
                        '{$balance_remaining}', '{$gen_date}', '0', '0', '{$collection_due_paid}', '0.00')");

                        if ($insert_client_trans) {
                            // If client Account Transaction Successful Update the Loan and Loan Transaction Table for Reference

                        // Get the Current Loan Outstanding from *LINE 57 to LINE 71*
                        $new_outstanding_balance = $outstanding_loan_balance - $new_collection_done;
                        $up_client_loan = mysqli_query($connection, "UPDATE loan SET total_outstanding_derived = '$new_outstanding_balance' WHERE int_id = '$int_id' AND client_id = '$client_id' AND (id = '$loan_id' AND account_no = $account_no)");

                        // if loan update successful insert a transaction
                        if ($up_client_loan) {
                            // update the loan transaction
                            $update_loan_trans = mysqli_query($connection, "INSERT INTO `loan_transaction` (`int_id`, `branch_id`, `product_id`, `loan_id`, `transaction_id`, `client_id`, `account_no`, `is_reversed`, `external_id`, `transaction_type`, `transaction_date`, `amount`,
                            `payment_method`, `principal_portion_derived`, `interest_portion_derived`, `fee_charges_portion_derived`, `penalty_charges_portion_derived`,
                            `overpayment_portion_derived`, `unrecognized_income_portion`, `suspended_interest_portion_derived`, `suspended_fee_charges_portion_derived`, 
                            `suspended_penalty_charges_portion_derived`, `outstanding_loan_balance_derived`, `recovered_portion_derived`, `submitted_on_date`, `manually_adjusted_or_reversed`, `created_date`, `appuser_id`, `is_account_transfer`) 
                            VALUES ('{$int_id}', '{$branch_id}', '0', '{$collection_loan}', '{$trans_id}', '{$client_id}', '{$account_no}', '0', '0', 'Repayment', '{$gen_date}', '{$collection_due_paid}', 
                            'auto_account', '{$collection_principal}', '{$collection_interest}', '0', '0', 
                            '0', NULL, '0', '0', '0', '{$new_outstanding_balance}', '{$collection_due_paid}', '{$gen_date}', '0', '{$gen_date}', '0', '1')");

if ($update_loan_trans) {
    $update_rep_status = mysqli_query($connection, "UPDATE `loan_arrear` SET installment = '1', principal_amount = '$cac_principal', interest_amount = '$cac_interest'  WHERE int_id = '$int_id' AND id = '$collection_id'");
// PUSH IT UP
// if the repayment update is successful
if ($update_rep_status) {
// LOCATION
// Start SMS
// IMPORT AJAX in MFI FOLDER
include("../mfi/ajaxcallx.php");
$query_institution = mysqli_query($connection, "SELECT * FROM `institutions` WHERE int_id = '$int_id'");
if (mysqli_num_rows($query_institution) > 0) {
    $gi = mysqli_fetch_array($query_institution);

    // Get Information
    $int_name = $gi["int_name"];
    $sender_id = $gi["sender_id"];
    $description = "Loan Arrears Due";

    // Star the Customers Account Number
    $account_display = substr("$account_no", 0, 3)."*****".substr("$account_no",8);

?>
<!-- DEFINE TRANSACTION FIRST LAYER -->
<input type="text" id="s_int_id" value="<?php echo $int_id; ?>" hidden>
<input type="text" id="s_acct_nox" value="<?php echo $account_no; ?>" hidden>
<input type="text" id="s_branch_id" value="<?php echo $branch_id; ?>" hidden>
<input type="text" id="s_sender_id" value="<?php echo $sender_id; ?>" hidden>
<input type="text" id="s_phone" value="<?php echo $client_phone; ?>" hidden>
<input type="text" id="s_client_id" value="<?php echo $client_id; ?>" hidden>

<!-- ACCOUNT DETIALS -->
<input type="text" id="s_int_name" value="<?php echo $int_name; ?>" hidden>
<input type="text" id="s_acct_no" value="<?php echo $account_display; ?>" hidden>
<input type="text" id="s_amount" value="<?php echo $collection_due_paid; ?>" hidden>
<input type="text" id="s_desc" value="<?php echo $description; ?>" hidden>
<input type="text" id="s_date" value="<?php echo $gen_date; ?>" hidden>
<input type="text" id="s_balance" value="<?php echo number_format($balance_remaining, 2); ?>" hidden>

<!-- Script to Send AJAX information -->
<script>
$(document).ready(function() {
    // STORE ENTITY DETAILS
    var int_id = $('#s_int_id').val();
    var branch_id = $('#s_branch_id').val();
    var sender_id = $('#s_sender_id').val();
    var phone = $('#s_phone').val();
    var client_id = $('#s_client_id').val();
    var account_no = $('#s_acct_nox').val();

    // STORE VALUE OF TRANSACTION
    var amount = $('#s_amount').val();
    var acct_no = $('#s_acct_no').val();
    var int_name = $('#s_int_name').val();
    var trans_type = "Debit";
    var desc = $('#s_desc').val();
    var date = $('#s_date').val();
    var balance = $('#s_balance').val();
    // now we work on the body.
    var msg = int_name+" "+trans_type+" \n" + "Amt:NGN "+amount+" \n Acct: "+acct_no+"\nDesc: "+desc+" \nBal: "+balance+" \nAvail: "+balance+"\nDate: "+date+"\nThanks";
    $.ajax({
        url:"../mfi/ajax_post/sms/sms.php",
        method:"POST",
        data:{int_id:int_id, branch_id:branch_id, sender_id:sender_id, phone:phone, msg:msg, client_id:client_id, account_no:account_no },
        success:function(data){
            $('#make_display').html(data);
            }
        });
    });
</script>
<div id="make_display" hidden></div>
<?php
}
// End SMS
} else {
    echo "There was an Error Updating Repayment Schedule (No Balance)";
}

} else {
    echo "There was an Error Inserting to Loan Transaction (No Balance)";
}

                        } else {
                            echo "There was an Error Updating Loan(No Balance)";
                        }
                        } else {
                            echo "There was an Error Inserting in Client Transaction Table(No Balance)";
                        }

                    } else {
                        echo "There was an Error Updating Client Account(No Balance)";
                    }

                    
        }
         
        }
    } else {
        echo "Cant Find Loan";
    }
    
}
} else {
    echo "No Loan in Arrears Found";
}
?>