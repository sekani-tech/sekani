<?php
include('../../functions/connect.php');
session_start();

/** Include PHPExcel_IOFactory */
include('../../mfi/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;

$digit = 4;
try {
    $randms = str_pad(random_int(0, (10 ** $digit) - 1), 7, '0', STR_PAD_LEFT);
} catch (Exception $e) {
}
if (isset($_POST['submit'])) {

//    check for excel file submitted
    if ($_FILES["file"]["name"] !== '') {
        $allowed_extension = array('xls', 'csv', 'xlsx');
        $file_array = explode(".", $_FILES["file"]["name"]);
        $file_extension = end($file_array);

        if (in_array($file_extension, $allowed_extension)) {
            try {
                $file_name = time() . '.' . $file_extension;
                move_uploaded_file($_FILES['file']['tmp_name'], $file_name);
                $file_type = IOFactory::identify($file_name);
                $reader = IOFactory::createReader($file_type);
                $spreadsheet = $reader->load($file_name);

                unlink($file_name);

//            Data from excel Sheet
                $data = $spreadsheet->getActiveSheet()->toArray();
                
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            }

//            our data table for insertion
            $DataTables = [];
   
        }
    

    //            Join data with content from the excel sheet
            foreach ($data as $key => $row) {
                $DataTables[] = array(
                  
                    'client_id' => $row['2'],
                    'product_id' => $row['3'],
                    'account_no' => $row['4'],
                    'loan_officer' => $row['5'],
                    'loan_puporse' => $row['6'],
                    'principle_amount' => $row['7'],
                    'loan_term' => $row['8'],
                    'interest_rate' => $row['9'],
                    'repay_every' => $row['10'],
                    'repayment_date' => $row['11'],
                    'maturedon_date' => $row['12'],
                    'disbursement_date' => $row['13'],
                    'no_of_repayments' => $row['14'],
                    'amount_paid' => $row['15']
                
                
                );
              
                if(count($DataTables)) {
                    $keys = array_keys($DataTables);
                    $values = '';
                    $x = 1;
            
                    foreach($DataTables as $field) {
                        $values .= '?';
                        if($x < count($DataTables)) {
                            $values .= ', ';
                        }
                        $x++;
                    }
                    
                    foreach($DataTables as $values => $data){
                        $loanData = [
                            'int_id' => $_SESSION['int_id'],
                            'client_id' => $data['client_id'],
                            'product_id' => $data['product_id'],
                            'account_no' => $data['account_no'],
                            'loan_officer' => $data['loan_officer'],
                            'loan_puporse' => $data['loan_puporse'],
                            'principle_amount' => $data['principle_amount'],
                            'loan_term' => $data['loan_term'],
                            'interest_rate' => $data['interest_rate'],
                            'repay_every' => $data['repay_every'],
                            'repayment_date' => $data['repayment_date'],
                            'maturedon_date' => $data['maturedon_date'] , 
                             'disbursement_date' => $data['disbursement_date'],
                             'no_of_repayments' => $data['no_of_repayments'],
                             'amount_paid' => $data['amount_paid']
                        
                        ];
                     
                    }
                    $insertloan = insert('loan_remodeling', $loanData);
          //dd($loanData);
               
                       
                }
            }
        }
      
}

//CODE to remodel old loan imported into the system
$query1 = "SELECT * FROM loan_remodeling WHERE status = '0'";
$queryexec1 = mysqli_query($connection, $query1);
while($a = mysqli_fetch_array($queryexec1)) {
    $id = $a['id'];
    $int_id = $a['int_id'];
    $loan_id = $a['loan_id'];
    $client_id = $a['client_id'];
    $account_no  =$a['account_no'];
    $product_id =  $a['product_id'];
    $loan_officer =  $a['loan_officer'];
    $loan_puporse  =$a['loan_puporse'];
    $principal_amount = $a['principal_amount'];
    $loan_term = $a['loan_term'];
    $disbursement_date = $a['disbursement_date'];
    $interest_rate = $a['interest_rate'];
    $repayment_date = $a['repayment_date'];
    $repay_every = $a['repay_every'];
    $maturedon_date = $a['maturedon_date'];
    $no_of_repayments = $a['no_of_repayments'];
    $amount_paid = $a['amount_paid' ];
    $arrear_amount = $a['arrear_amount'];
    $status = $a['status'];
    $loan_status = $a['loan_status'];
    $outstanding = ($principal_amount + (($interest_rate/100) * $principal_amount) * $loan_term);
    $today = date('Y-m-d');

    $query2 = "INSERT INTO `loan` (`id`, `int_id`, `account_no`, `client_id`, `product_id`, `fund_id`, `col_id`, `col_name`, `col_description`, 
    `loan_officer`, `loan_purpose`, `currency_code`, `currency_digits`, `principal_amount_proposed`, `principal_amount`, `loan_term`, `interest_rate`, 
    `approved_principal`, `repayment_date`, `arrearstolerance_amount`, `is_floating_interest_rate`, `interest_rate_differential`, `nominal_interest_rate_per_period`, 
    `interest_period_frequency_enum`, `annual_nominal_interest_rate`, `interest_method_enum`, `interest_calculated_in_period_enum`, 
    `allow_partial_period_interest_calcualtion`, `term_frequency`, `term_period_frequency_enum`, `repay_every`, `repayment_period_frequency_enum`, 
    `number_of_repayments`, `grace_on_principal_periods`, `recurring_moratorium_principal_periods`, `grace_on_interest_periods`, 
    `grace_interest_free_periods`, `amortization_method`, `submittedon_date`, `submittedon_userid`, `approvedon_date`, `approvedon_userid`, 
    `expected_disbursedon_date`, `expected_firstrepaymenton_date`, `interest_calculated_from_date`, `disbursement_date`, `disbursedon_userid`, 
    `expected_maturedon_date`, `maturedon_date`, `closedon_date`, `closedon_userid`, `total_charges_due_at_disbursement_derived`, `principal_disbursed_derived`, 
    `principal_repaid_derived`, `principal_writtenoff_derived`, `principal_outstanding_derived`, `interest_charged_derived`, `interest_repaid_derived`, 
    `interest_waived_derived`, `interest_writtenoff_derived`, `interest_outstanding_derived`, `fee_charges_charged_derived`, `fee_charges_repaid_derived`, 
    `fee_charges_waived_derived`, `fee_charges_writtenoff_derived`, `fee_charges_outstanding_derived`, `penalty_charges_charged_derived`, 
    `penalty_charges_repaid_derived`, `penalty_charges_waived_derived`, `penalty_charges_writtenoff_derived`, `penalty_charges_outstanding_derived`, 
    `total_expected_repayment_derived`, `total_repayment_derived`, `total_expected_costofloan_derived`, `total_costofloan_derived`, 
    `total_waived_derived`, `total_writtenoff_derived`, `total_outstanding_derived`, `total_overpaid_derived`, `rejectedon_date`, `rejectedon_userid`, 
    `rescheduledon_date`, `rescheduledon_userid`, `withdrawnon_date`, `withdrawnon_userid`, `writtenoffon_date`, `loan_transaction_strategy_id`, 
    `sync_disbursement_with_meeting`, `loan_counter`, `loan_product_counter`, `fixed_emi_amount`, `max_outstanding_loan_balance`, `grace_on_arrears_ageing`, 
    `is_npa`, `is_in_duplum`, `is_suspended_income`, `total_recovered_derived`, `accrued_till`, `interest_recalcualated_on`, `days_in_month_enum`, 
    `days_in_year_enum`, `interest_recalculation_enabled`, `guarantee_amount_derived`, `create_standing_instruction_at_disbursement`, `version`, 
    `writeoff_reason_cv_id`, `loan_sub_status_id`, `is_topup`, `repay_principal_every`, `repay_interest_every`, `restrict_linked_savings_product_type`, 
    `mandatory_savings_percentage`, `internal_rate_of_return`) VALUES ('$loan_id', '$int_id', '$account_no', '$client_id', '$product_id', NULL, NULL, NULL, NULL, '$loan_officer', 
    '$loan_puporse', 'NGN', '2', '$principal_amount', '$principal_amount', '$loan_term', '$interest_rate', '$principal_amount', '$repayment_date', NULL, '0', '0.00', 
    NULL, NULL, NULL, NULL, '1', '0', '1', '2', '$repay_every', NULL, '$no_of_repayments', NULL, NULL, NULL, NULL, NULL, '$today', NULL, '$today', NULL, NULL, NULL, NULL, 
    '$disbursement_date', NULL, NULL, '$maturedon_date', NULL, NULL, NULL, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 
    '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '$arrear_amount', NULL, NULL, NULL, NULL, NULL, NULL, 
    NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', '0', NULL, NULL, NULL, '1', '1', '0', NULL, NULL, '1', NULL, '$loan_status', '', '1', '1', NULL, NULL, '0.00')";
    $queryexec2 = mysqli_query($connection, $query2);

    if($queryexec2){
        echo 'Client no: '.$client_id.' inserted into loan</br>';

        $query3 = "INSERT INTO loan_disbursement_cache (int_id, status, account_no, client_id, product_id, fund_id, col_id, col_name, col_description, loan_officer, 
        loan_purpose, currency_code, currency_digits, principal_amount_proposed, principal_amount, loan_term, interest_rate, approved_principal, repayment_date,
        term_frequency, repay_every, number_of_repayments, submittedon_date, submittedon_userid, approvedon_date, approvedon_userid, expected_disbursedon_date, 
        expected_firstrepaymenton_date, disbursement_date, disbursedon_userid, repay_principal_every, repay_interest_every, loan_sub_status_id, 
        expected_maturedon_date, maturedon_date, flag) VALUES ('$int_id', 'Approved', '$account_no', '$client_id', '$product_id', NULL, NULL, NULL, NULL, '$loan_officer','$loan_puporse', 
        'NGN', '2', '$principal_amount', '$principal_amount', '$loan_term', '$interest_rate', '$principal_amount', '$repayment_date', '0', '$repay_every', '$no_of_repayments',
        '$today', NULL, '$today', NULL, NULL, NULL, '$disbursement_date', NULL, '0', '0', '$loan_status', '$maturedon_date', '$maturedon_date', 'old')";
        $queryexec3 = mysqli_query($connection, $query3);

if ($connection->error) {
    try {   
        throw new Exception("MySQL error $connection->error <br> Query:<br> $query1", $mysqli->error);   
    } catch(Exception $e ) {
        echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
        echo nl2br($e->getTraceAsString());
    }
}
        if($queryexec3){
            echo 'Client no: '.$client_id.' inserted into loan_disbursement_cache</br>';
            $query4 = "UPDATE loan_remodeling SET status = '1' WHERE id = '$id'";
            $queryexec4 = mysqli_query($connection, $query4);
            if($queryexec4){
                echo 'Client no: '.$client_id.' updated in loan_remodeling</br>';
                $query5 = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$client_id' AND account_no = '$account_no'");
                if($query5){
                    $do = mysqli_fetch_array($query5);
                    $account = $do['account_balance_derived'];
                    $new_account = $account + $amount_paid;
                    $query6 = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$new_account' WHERE client_id = '$client_id' AND account_no = '$account_no'");
                    if($query6){
                        echo 'Client no: '.$client_id.' updated arrear amount to balance</br></br>';
                    }
                }
                else{
                    echo "ERROR finding matching account</br></br>";

                }
            } else {

                echo "EOOR";
            }
        }
    }
}
$hello = "SELECT * FROM loan_disbursement_cache WHERE status = 'Approved'";
$query1 = mysqli_query($connection, $hello);

if (mysqli_num_rows($query1) > 0) {
    // if code ok
    while ($ex = mysqli_fetch_array($query1, MYSQLI_ASSOC)) {
        $client_id = $ex["client_id"];
        $product_id = $ex["product_id"];
        $int_id = $ex["int_id"];

        // $ex = mysqli_fetch_array($query1);
        // var_dump($ex);
        // $client_id = $ex["client_id"];
        // $product_id = $ex["product_id"];
        // $int_id = $ex["int_id"];
        // i dont need
        $query2 = mysqli_query($connection, "SELECT * FROM `loan` WHERE client_id = '$client_id' AND product_id = '$product_id' AND int_id = '$int_id'");
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
                $rep_every = $y["repay_every"];
                // DATE
                $disburse_date = $y["disbursement_date"];
                $offical_repayment = $y["repayment_date"];
                $repayment_start = $y["repayment_date"];
                // GET THE REPAYMENT END DATE
                $startdate =  new DateTime($repayment_start);
                $sch_date = date("Y-m-d h:i:s");
                // SECHDULE DATE
                $approved_by = $y["approvedon_userid"];

                // Here we check if the loan is monthly, weekly, daily or annually so as to enable us make the 
                // right interest calcuations per month. 
                // Given that interest is calculated per month and not per period
                if ($rep_every == 'month') {
                    $interest_amount = ($interest_rate / 100) * $princpal_amount;
                    $period_loan = $princpal_amount / $loan_term;
                    //echo "month";
                } else if ($rep_every == 'year') {
                    // To find the amount of months in the given loan term we multiply it by the amount of months in a standard calendar year
                    $months = $loan_term * 12;
                    // Here we find the end date of schedule
                    // remeber to convert to date time for proper usage 
                    $date = strtotime(date("Y-m-d", strtotime($offical_repayment)) . " +$months month");
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
                } else if ($rep_every == 'week') {
                    // To find the amount of months we first divide the amount the loan term by 4 referencing the amount of weeks in a month
                    $months = $loan_term / 4;
                    // Here we find the end date of schedule
                    // remeber to convert to date time for proper usage 
                    $date = strtotime(date("Y-m-d", strtotime($offical_repayment)) . " +$months month");
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
                } else if ($rep_every == 'day') {
                    // To find the amount of months in the given term we devide the term by the standard 30 days
                    $months = $loan_term / 30;
                    // Here we find the end date of schedule
                    // remeber to convert to date time for proper usage 
                    $date = strtotime(date("Y-m-d", strtotime($offical_repayment)) . " +$months month");
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

                $select_repayment_sch = mysqli_query($connection, "SELECT * FROM `loan_repayment_schedule` WHERE loan_id = '$loan_id' AND int_id = '$int_id'");
                $dm = mysqli_fetch_array($select_repayment_sch);
                if ($dm <= 0 && $int_id !== "0") {
                    if ($rep_every == 'week') {
                        $i = 1;
                        while ($i <= $loan_term) {
                            $repay = date('Y-m-d', strtotime($offical_repayment . ' + ' . $i . ' ' . $rep_every));
                            echo $repay . '</br>';
                            $insert_repay = mysqli_query($connection, "INSERT INTO `loan_repayment_schedule` (`int_id`, `loan_id`, `client_id`, `fromdate`, `duedate`, `installment`, 
                        `principal_amount`, `interest_amount`, `created_date`, `amount_collected`, `lastmodified_date`) VALUES('$int_id', '$loan_id', '$client_id', '$offical_repayment', '$repay', '1', '$period_loan', '$interest_amount', '$sch_date', '0', '$sch_date')");
                            if ($insert_repay) {
                                echo 'Inserted for Interval =' . $i . '/<br>';
                            }
                            $i++;
                        }
                    } else if ($rep_every == 'month') {
                        $i = 1;
                        while ($i <= $loan_term) {
                            $repay = date('Y-m-d', strtotime($offical_repayment . ' + ' . $i . ' ' . $rep_every));
                            echo $repay . '</br>';
                            $insert_repay = mysqli_query($connection, "INSERT INTO `loan_repayment_schedule` (`int_id`, `loan_id`, `client_id`, `fromdate`, `duedate`, `installment`, 
                        `principal_amount`, `interest_amount`, `created_date`, `amount_collected`, `lastmodified_date`) VALUES('$int_id', '$loan_id', '$client_id', '$offical_repayment', '$repay', '1', '$period_loan', '$interest_amount', '$sch_date', '0', '$sch_date')");
                            if ($insert_repay) {
                                echo 'Inserted for Interval =' . $i . '/<br>';
                            }
                            $i++;
                        }
                    } else if ($rep_every == 'year') {
                        $i = 1;
                        while ($i <= $loan_term) {
                            $repay = date('Y-m-d', strtotime($offical_repayment . ' + ' . $i . ' ' . $rep_every));
                            echo $repay . '</br>';
                            $insert_repay = mysqli_query($connection, "INSERT INTO `loan_repayment_schedule` (`int_id`, `loan_id`, `client_id`, `fromdate`, `duedate`, `installment`, 
                        `principal_amount`, `interest_amount`, `created_date`, `amount_collected`, `lastmodified_date`) VALUES('$int_id', '$loan_id', '$client_id', '$offical_repayment', '$repay', '1', '$period_loan', '$interest_amount', '$sch_date', '0', '$sch_date')");
                            if ($insert_repay) {
                                echo 'Inserted for Interval =' . $i . '/<br>';
                            }
                            $i++;
                        }
                    } else if ($rep_every == 'day') {
                        $i = 1;
                        while ($i <= $loan_term) {
                            $repay = date('Y-m-d', strtotime($offical_repayment . ' + ' . $i . ' ' . $rep_every));
                            echo $repay . '</br>';
                            $insert_repay = mysqli_query($connection, "INSERT INTO `loan_repayment_schedule` (`int_id`, `loan_id`, `client_id`, `fromdate`, `duedate`, `installment`, 
                        `principal_amount`, `interest_amount`, `created_date`, `amount_collected`, `lastmodified_date`) VALUES('$int_id', '$loan_id', '$client_id', '$offical_repayment', '$repay', '1', '$period_loan', '$interest_amount', '$sch_date', '0', '$sch_date')");
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