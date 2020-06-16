<?php
// START
include("DB/connect.php");
// GET THE LOAN DISBURSMENT CACHE CHECK BY DISBURSMENT CHACHE ID
// GET THE LOAN
// WIRTE A CODE FOR THE REPAYMENT FUNCTION - IF
// END
$select_all_disbursment_cache = mysqli_query($connection, "SELECT * FROM `loan_disbursement_cache` WHERE status = 'Approved'");
while($x = mysqli_fetch_array($select_all_disbursment_cache)) {
    // Get the client ID, Status, Product_id.
    $client_id = $x["client_id"];
    $product_id = $x["product_id"];
    $int_id = $x["int_id"];
    // NOW CHECK THE ACCOUNT
    $select_loan_client = mysqli_query($connection, "SELECT * FROM `loan` WHERE client_id = '$client_id' AND $product_id = '$product_id' AND int_id = '$int_id'");
    while ($y = mysqli_fetch_array($select_loan_client)) {
        // GET THE LOAN DETAILS FOR THE REPAYMENT
        // SELECT THE REPAYMENT SCH. IF IT IS ZERO - DO A REPAYMENT, IF IT IS MORE THAN.
        $loan_id = $y["id"];
        $acct_no = $y["account_no"];
        $client_id = $y["client_id"];
        $product_id = $y["product_id"];
        // DISPLAY THE REPAYMENT STUFFS
        $pincpal_amount = $y["principal_amount"];
        $loan_term = $y["loan_term"];
        $interest_rate = $y["interest_rate"];
        $no_of_rep = $y["number_of_repayments"];
        $rep_every = $y["repay_every"];
        // DATE
        $disburse_date = $y["disbursement_date"];
        $repayment_start = $y["repayment_date"];
        // GET THE REPAYMENT END DATE
        $loan_term1 = $loan_term - 1;
        $loan_term2 = $loan_term;
        if($rep_every == "month"){
            $actualend_date = date('Y-m-d', strtotime("+".$loan_term1." months", strtotime($repayment_start)));
            $actualend_date1 = date('Y-m-d', strtotime("+".$loan_term2." months", strtotime($repayment_start)));
        }else if($rep_every == "day"){
            $actualend_date = date('Y-m-d', strtotime("+".$loan_term1." days", strtotime($repayment_start)));
            $actualend_date1 = date('Y-m-d', strtotime("+".$loan_term2." days", strtotime($repayment_start)));
        }else if($rep_every == "year"){
            $actualend_date = date('Y-m-d', strtotime("+".$loan_term1." years", strtotime($repayment_start)));
            $actualend_date1 = date('Y-m-d', strtotime("+".$loan_term2." years", strtotime($repayment_start)));
        } else if($rep_every == "week"){
            $actualend_date = date('Y-m-d', strtotime("+".$loan_term1." weeks", strtotime($repayment_start)));
            $actualend_date1 = date('Y-m-d', strtotime("+".$loan_term2." weeks", strtotime($repayment_start)));
        }
        // GET THE END DATE OF THE LOAN
        $matured_date = $actualend_date;
        $matured_date2 = $actualend_date1;
        // GET THE END DATE OF THE LOAN
        $matured_date = $actualend_date;
        echo "EVERY LOAN START AND END DATE "."CLIENT ".$client_id." -". $repayment_start." - ".$matured_date;
        // REPAYMENT SCHEDULE
        // -----------------
        ?>
        <table>
          <thead>
              <tr>name</tr>
              <tr>start</tr>
              <tr>end</tr>
              <tr>Installment</tr>
              <tr>Amount Due</tr>
              <tr>Interest</tr>
          </thead>
        <?php
        $install = 1;
        $damn = 0;
        if ($no_of_rep == 1) {
        while (strtotime("+1 ".$rep_every, strtotime($repayment_start)) <= strtotime($matured_date2)) {
            ?>
            <tbody>
         <td><?php echo $client_id; ?></td>
         <td><?php echo $repayment_start; ?></td>
         <td><?php echo $matured_date; ?></td>
         <td><?php echo $install++; ?></td>
         <td><?php echo $pincpal_amount / $loan_term; ?></td>
         <td><?php echo ((($interest_rate / 100) * $pincpal_amount) * $loan_term) / $loan_term ?></td>
         </tbody>
         <?php
        $repayment_start = date ("Y-m-d", strtotime("+1 ".$rep_every, strtotime($repayment_start)));
        }
    } else if ($no_of_rep > 1) {
        while ($damn <= $no_of_rep) {
            ?>
            <tbody>
         <td><?php echo $client_id; ?></td>
         <td><?php echo $repayment_start; ?></td>
         <td><?php echo $matured_date; ?></td>
         <td><?php echo $install++; ?></td>
         <td><?php echo $pincpal_amount / $loan_term; ?></td>
         <td><?php echo ((($interest_rate / 100) * $pincpal_amount) * $loan_term) / $loan_term ?></td>
         </tbody>
            <?php
            //  $repayment_start = date ("Y-m-d", strtotime("+1 ".$rep_every, strtotime($repayment_start)));
             $damn++;
        }
    }
        ?>
        </table>
        <?php
        // IF IT IS NULL 
        $select_repayment_sch = mysqli_query($connection, "SELECT * FROM `loan_repayment_schedule` AND loan_id = '$loan_id' AND client_id = '$client_id' AND id IS NULL");
        while ($select_repayment_sch) {
            // NOTHING
        }
        // IF THE QUERY IS NOT NULL RUN THE REPAYMENT CODE
        $select_repayment_sch = mysqli_query($connection, "SELECT * FROM `loan_repayment_schedule` AND loan_id = '$loan_id' AND client_id = '$client_id' AND id IS NOT NULL");
        // CHECK THE LAST REPAYMENT DATE THAT IS NOT DONE - COMPLETED DERIVED.
        
    }
}
?>