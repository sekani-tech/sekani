<?php
include("../connect.php");
// die($_POST["amount"]);
// OUTTA HERE
session_start();
$sessint_id =  $_SESSION['int_id'];
if (isset($_POST["amount"]) && isset($_POST["payment_date"])) {

    $manual_amount = $_POST["amount"];
    $manual_payment_date = $_POST["payment_date"];
    $manual_payment_type = $_POST["payment_type"];
    $manual_repayment_id = $_POST["out_id"];
    $manual_account_no = $_POST["account_no"];
    // CHECK THE LOAN
    $query_rep = mysqli_query($connection, "SELECT * FROM `loan_repayment_schedule` WHERE int_id = '$sessint_id' AND id = '$manual_repayment_id'");
    if (mysqli_num_rows($query_rep) > 0) {
        $ro = mysqli_fetch_array($query_rep);
        $old_principal = $ro["principal_amount"];
        $old_interest = $ro["interest_amount"];
        $old_general = $old_principal + $old_interest;
        $charge_amount = 0;
        $charge_type = "";
        // missin
        // if its interest first
        if ($manual_payment_type == "1") {
            $charge_type = "Loan Manual Interest Repayment";
            // if the amont is greater than interest turn it to zero
            if ($manual_amount >= $old_interest) {
                $int_bal = 0;
                $prin_bal = $old_principal;
                // charge amount will be the interest amount
                $charge_amount = $old_interest;
            } else {
                // else take the amount out of interest, out put the balance
                $int_bal = $old_interest - $manual_amount;
                $prin_bal = $old_principal;
                // charge amount will be initail amount
                $charge_amount = $manual_amount;
            }
            // end
        } else if ($manual_payment_type == "2") {
            $charge_type = "Loan Manual Principal Repayment";

            if ($manual_amount >= $old_principal) {
                $prin_bal = 0;
                $int_bal = $old_interest;
                $charge_amount = $old_principal;
            } else {
                $prin_bal = $old_principal - $manual_amount;
                $int_bal = $old_interest;
                $charge_amount = $manual_amount;
            }
            // end
        } else if ($manual_payment_type == "3") {
            $charge_type = "Loan Manual Principal and Interest Repayment";

            if ($manual_amount >= $old_general) {
                $prin_bal = 0;
                $int_bal = 0;
                $charge_amount = $old_general;
            } else {
                $charge_amount = $manual_amount;
                // else if the general is bigger
                $old_check = $old_general - $manual_amount;
                $prin_bal = ($old_check / 2);
                $int_bal = ($old_check / 2);
                // divide the amount into two
            }
        }
        // check the account if the money exist
        $query_account = mysqli_query($connection, "SELECT * FROM `account` WHERE account_no = '$manual_account_no' AND int_id = '$sessint_id'");
        if (mysqli_num_rows($query_account) > 0) {
            $ad = mysqli_fetch_array($query_account);
            $account_id = $ad["id"];
            $client_id = $ad["client_id"];
            $branch_id = $ad["branch_id"];
            $old_account_balance = $ad["account_balance_derived"];
            $old_tot_withdrawal = $ad["total_withdrawals_derived"];
            // add the new account balance here
            $digits = 8;
            $randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
            $trans_id = $randms . $branch_id;
            $new_account_balance = $old_account_balance - $charge_amount;
            $new_tot_withdrawal = $old_account_balance + $charge_amount;
            // REMOTE
            if ($old_account_balance >= $charge_amount) {
                $update_account = mysqli_query($connection, "UPDATE `account` SET account_balance_derived = '$new_account_balance', total_withdrawals_derived = '$new_tot_withdrawal' WHERE id = '$account_id'");
                if ($update_account) {
                    $insert_account_transaction = mysqli_query($connection, "INSERT INTO `account_transaction` (`int_id`, `branch_id`,
            `product_id`, `account_id`, `account_no`, `client_id`, `teller_id`, `transaction_id`,
            `description`, `transaction_type`, `is_reversed`, `transaction_date`, `amount`, `overdraft_amount_derived`,
            `balance_end_date_derived`, `balance_number_of_days_derived`, `running_balance_derived`,
            `cumulative_balance_derived`, `created_date`, `appuser_id`, `manually_adjusted_or_reversed`, `debit`, `credit`) 
            VALUES ('{$sessint_id}', '{$branch_id}', '0', '{$account_id}', '{$manual_account_no}', '{$client_id}', '0', '{$trans_id}',
            '{$charge_type}', 'loan_repayment', '0', '{$manual_payment_date}', '{$charge_amount}', '{$charge_amount}',
            '{$manual_payment_date}', '0', '{$new_account_balance}',
            '{$new_account_balance}', '{$manual_payment_date}', '0', '0', '{$charge_amount}', '0.00')");
                    if ($insert_account_transaction) {
                        if ($prin_bal < 1 && $int_bal < 1) {
                            $install = "0";
                        } else {
                            $install = "1";
                        }
                        $update_repayment = mysqli_query($connection, "UPDATE `loan_repayment_schedule` SET principal_amount = '$prin_bal', interest_amount = '$int_bal', installment = '$install' WHERE id = '$manual_repayment_id' AND int_id = '$sessint_id'");
                        if ($update_repayment) {
                            echo "Done";
                            echo '<script type="text/javascript">
                                    $(document).ready(function(){
                                    swal({
                                    type: "success",
                                    title: "Repayment Successful",
                                    text: "Thank you",
                                    showConfirmButton: false,
                                    timer: 2000
                                    })
                                    });
                                    </script>
                                    ';
                            $URL = "../../mfi/manual_recollection.php";
                            echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                        } else {
                            echo "Failed";
                            echo '<script type="text/javascript">
              $(document).ready(function(){
               swal({
                type: "error",
                title: "Error Updating Repayment",
                text: "Please check User Account",
               showConfirmButton: false,
                timer: 2000
                })
                });
               </script>
              ';
                            $URL = "../../mfi/manual_recollection.php";
                            echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                        }
                    } else {
                        echo "account issue";
                        echo '<script type="text/javascript">
              $(document).ready(function(){
               swal({
                type: "error",
                title: "Error Posting Account Transaction",
                text: "Please check User Account",
               showConfirmButton: false,
                timer: 2000
                })
                });
               </script>
              ';
                        $URL = "../../mfi/manual_recollection.php";
                        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                    }
                } else {
                    echo "6";
                    echo '<script type="text/javascript">
      $(document).ready(function(){
       swal({
        type: "error",
        title: "Account Didnt update",
        text: "Please check User Account",
       showConfirmButton: false,
        timer: 2000
        })
        });
       </script>
      ';
                    $URL = "../../mfi/manual_recollection.php";
                    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                }
            } else {
                echo "5";
                echo '<script type="text/javascript">
          $(document).ready(function(){
           swal({
            type: "error",
            title: "Insufficient Fund",
            text: "Please check User Account",
           showConfirmButton: false,
            timer: 2000
            })
            });
           </script>
          ';
            }
        } else {
            echo "4";
            echo '<script type="text/javascript">
      $(document).ready(function(){
       swal({
        type: "error",
        title: "Account Not Found",
        text: "Please check User Account",
       showConfirmButton: false,
        timer: 2000
        })
        });
       </script>
      ';
            $URL = "../../mfi/manual_recollection.php";
            echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
        }
    } else {
        echo "3";
        echo '<script type="text/javascript">
        $(document).ready(function(){
         swal({
          type: "error",
          title: "Payment Data is Missing",
          text: "Please check loan data",
         showConfirmButton: false,
          timer: 2000
          })
          });
         </script>
        ';
        $URL = "../../mfi/manual_recollection.php";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    }
} else {
    echo "1";
    echo '<script type="text/javascript">
      $(document).ready(function(){
       swal({
        type: "error",
        title: "Payment Data is Missing",
        text: "Please check loan data",
       showConfirmButton: false,
        timer: 2000
        })
        });
       </script>
      ';
    $URL = "../../mfi/manual_recollection.php";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}
    // END OUTTA HERE
