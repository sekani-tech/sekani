<?php
$hello = "SELECT * FROM loan_disbursement_cache WHERE int_id = '$sessint_id' AND status = 'Approved'";
$query1 = mysqli_query($connection, $hello);

if (mysqli_num_rows($query1) > 0) {
    // if code ok
    while ($ex = mysqli_fetch_array($query1, MYSQLI_ASSOC)) {
        $client_id = $ex["client_id"];
        $product_id = $ex["product_id"];

        $query2 = mysqli_query($connection, "SELECT * FROM `loan` WHERE client_id = '$client_id' AND product_id = '$product_id' AND int_id = '$sessint_id'");

        // here hthere is a problemn,  but it is fixed
        if (mysqli_num_rows($query2) > 0) {
            while ($y = mysqli_fetch_array($query2)) {
                $loan_id = $y["id"];
                $acct_no = $y["account_no"];
                $client_id = $y["client_id"];
                $product_id = $y["product_id"];
                // DISPLAY THE REPAYMENT STUFFS
                $princpal_amount = $y["principal_amount"];
                $loan_term = $y["loan_term"];
                $interest_rate = $y["interest_rate"];
                $no_of_rep = $y["number_of_repayments"];
                $rep_every = strtolower($y["repay_every"]);
                // DATE
                $disburse_date = $y["disbursement_date"];
                $offical_repayment = $y["repayment_date"];
                $repayment_start = $y["repayment_date"];
                // GET THE REPAYMENT END DATE
                $startdate =  new DateTime($disburse_date);
                $sch_date = date("Y-m-d h:i:s");
                // SECHDULE DATE
                $approved_by = $y["approvedon_userid"];

                // Here we check if the loan is monthly, weekly, daily or annually so as to enable us make the 
                // right interest calcuations per month. 
                // Given that interest is calculated per month and not per period
                if ($rep_every == 'month' || $rep_every == 'months') {
                    $interest_amount = ($interest_rate / 100) * $princpal_amount;
                    $period_loan = $princpal_amount / $loan_term;
                } else if ($rep_every == 'year' || $rep_every == 'years') {
                    // To find the amount of months in the given loan term we multiply it by the amount of months in a standard calendar year
                    $months = $loan_term * 12;
                    // Here we find the end date of schedule
                    // remeber to convert to date time for proper usage 
                    $date = strtotime(date("Y-m-d", strtotime($disburse_date)) . " +$months month");
                    $end_date = new DateTime(date("y-m-d", $date));
                    // Then go on to find the difference between the scheduled start date and the end date to find the amount of months
                    $calcuated_month = date_diff($startdate, $end_date)->m;
                    // Finding the intrest as needed
                    // Then go on to find the monthly interest by multiplying the interest rate by the amount of months found
                    $interest_amount_cal = ($interest_rate / 100) * $princpal_amount;
                    $interest_amount_total = $interest_amount_cal * $calcuated_month;
                    // Now find the period the periodic interest rate by dividing the total interests by the amount of terms.
                    $interest_amount = $interest_amount_total / $loan_term;
                    $period_loan = $princpal_amount / $loan_term;
                } else if ($rep_every == 'week' || $rep_every == 'weeks') {
                    // To find the amount of months we first divide the amount the loan term by 4 referencing the amount of weeks in a month
                    $months = $loan_term / 4;
                    // Here we find the end date of schedule
                    // remeber to convert to date time for proper usage 
                    $date = strtotime(date("Y-m-d", strtotime($disburse_date)) . " +$months month");
                    $end_date = new DateTime(date("y-m-d", $date));
                    // Then go on to find the difference between the scheduled start date and the end date to find the amount of months
                    $calcuated_month = date_diff($startdate, $end_date)->m;
                    // Finding the intrest as needed
                    // Then go on to find the monthly interest by multiplying the interest rate by the amount of months found
                    $interest_amount_cal = ($interest_rate / 100) * $princpal_amount;
                    $interest_amount_total = $interest_amount_cal * $calcuated_month;
                    // Now find the period the periodic interest rate by dividing the total interests by the amount of terms.
                    $interest_amount = $interest_amount_total / $loan_term;
                    $period_loan = $princpal_amount / $loan_term;
                } else if ($rep_every == 'day' || $rep_every == 'days') {
                    // To find the amount of months in the given term we devide the term by the standard 30 days
                    $months = $loan_term / 30;
                    // Here we find the end date of schedule
                    // remeber to convert to date time for proper usage 
                    $date = strtotime(date("Y-m-d", strtotime($disburse_date)) . " +$months month");
                    $end_date = new DateTime(date("y-m-d", $date));
                    // Then go on to find the difference between the scheduled start date and the end date to find the amount of months
                    $calcuated_month = date_diff($startdate, $end_date)->m;
                    // Finding the intrest as needed
                    // Then go on to find the monthly interest by multiplying the interest rate by the amount of months found
                    $interest_amount_cal = ($interest_rate / 100) * $princpal_amount;
                    $interest_amount_total = $interest_amount_cal * $calcuated_month;
                    // Now find the period the periodic interest rate by dividing the total interests by the amount of terms.
                    $interest_amount = $interest_amount_total / $loan_term;
                    $period_loan = $princpal_amount / $loan_term;
                }
                $amount_collected = $period_loan + $interest_amount;

                $select_repayment_sch = mysqli_query($connection, "SELECT * FROM `loan_repayment_schedule` WHERE loan_id = '$loan_id' AND int_id = '$sessint_id'");
                $dm = mysqli_fetch_array($select_repayment_sch);
                if ($dm <= 0 && $sessint_id !== "0") {
                    if ($rep_every == 'week' || $rep_every == 'weeks') {
                        $i = 1;
                        while ($i <= $loan_term) {
                            $repay = date('Y-m-d', strtotime($disburse_date . ' + ' . $i . ' ' . $rep_every));
                            echo $repay . '</br>';
                            $insert_repay = mysqli_query($connection, "INSERT INTO `loan_repayment_schedule` (`int_id`, `loan_id`, `client_id`, `fromdate`, `duedate`, `installment`, 
                        `principal_amount`, `interest_amount`, `created_date`, `amount_collected`, `lastmodified_date`) VALUES('$sessint_id', '$loan_id', '$client_id', '$disburse_date', '$repay', '1', '$period_loan', '$interest_amount', '$sch_date', '0', '$sch_date')");
                            if ($insert_repay) {
                                echo 'Inserted for Interval =' . $i . '/<br>';
                            }
                            $i++;
                        }
                    } else if ($rep_every == 'month' || $rep_every == 'months') {
                        $i = 1;
                        while ($i <= $loan_term) {
                            $repay = date('Y-m-d', strtotime($disburse_date . ' + ' . $i . ' ' . $rep_every));
                            echo $repay . '</br>';
                            $insert_repay = mysqli_query($connection, "INSERT INTO `loan_repayment_schedule` (`int_id`, `loan_id`, `client_id`, `fromdate`, `duedate`, `installment`, 
                        `principal_amount`, `interest_amount`, `created_date`, `amount_collected`, `lastmodified_date`) VALUES('$sessint_id', '$loan_id', '$client_id', '$disburse_date', '$repay', '1', '$period_loan', '$interest_amount', '$sch_date', '0', '$sch_date')");
                            if ($insert_repay) {
                                echo 'Inserted for Interval =' . $i . '/<br>';
                            }
                            $i++;
                        }
                    } else if ($rep_every == 'year' || $rep_every == 'years') {
                        $i = 1;
                        while ($i <= $loan_term) {
                            $repay = date('Y-m-d', strtotime($disburse_date . ' + ' . $i . ' ' . $rep_every));
                            echo $repay . '</br>';
                            $insert_repay = mysqli_query($connection, "INSERT INTO `loan_repayment_schedule` (`int_id`, `loan_id`, `client_id`, `fromdate`, `duedate`, `installment`, 
                        `principal_amount`, `interest_amount`, `created_date`, `amount_collected`, `lastmodified_date`) VALUES('$sessint_id', '$loan_id', '$client_id', '$disburse_date', '$repay', '1', '$period_loan', '$interest_amount', '$sch_date', '0', '$sch_date')");
                            if ($insert_repay) {
                                echo 'Inserted for Interval =' . $i . '/<br>';
                            }
                            $i++;
                        }
                    } else if ($rep_every == 'day' || $rep_every == 'days') {
                        $i = 1;
                        while ($i <= $loan_term) {
                            $repay = date('Y-m-d', strtotime($disburse_date . ' + ' . $i . ' ' . $rep_every));
                            echo $repay . '</br>';
                            $insert_repay = mysqli_query($connection, "INSERT INTO `loan_repayment_schedule` (`int_id`, `loan_id`, `client_id`, `fromdate`, `duedate`, `installment`, 
                        `principal_amount`, `interest_amount`, `created_date`, `amount_collected`, `lastmodified_date`) VALUES('$sessint_id', '$loan_id', '$client_id', '$disburse_date', '$repay', '1', '$period_loan', '$interest_amount', '$sch_date', '0', '$sch_date')");
                            if ($insert_repay) {
                                echo 'Inserted for Interval =' . $i . '/<br>';
                            }
                            $i++;
                        }
                    }
                }
            }
        }
    }
}
?>