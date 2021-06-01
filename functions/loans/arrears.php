<?php
include('../connect.php');
session_start();
$sessint_id = $_SESSION['int_id'];
$currentdate = date('Y-m-d');
$currentdate_time = date('Y-m-d H:i:s');

// count it
// check it check if installment is 0 or 1.
$conditions = [
    'int_id' => $sessint_id,
    'installment' => 1
];
$dateConditions = [
    'duedate' => $currentdate
];

$select_arrears = selectAllLessEq('loan_repayment_schedule', $conditions, $dateConditions);

if ($select_arrears) {
    for ($i = 0; $i < sizeof($select_arrears); $i++) {
        // now we need to get it.
        $lr_schedule_id = $select_arrears[$i]['id'];
        $lr_int_id = $select_arrears[$i]['int_id'];
        $lr_loan_id = $select_arrears[$i]['loan_id'];
        $lr_client_id = $select_arrears[$i]['client_id'];
        $lr_fromdate = $select_arrears[$i]['fromdate'];
        $lr_duedate = $select_arrears[$i]['duedate'];
        $lr_installment = $select_arrears[$i]['installment'];
        $lr_principal_amount = $select_arrears[$i]['principal_amount'];
        $lr_principal_completed_derived = $select_arrears[$i]['principal_completed_derived'];
        $lr_interest_amount = $select_arrears[$i]['interest_amount'];
        $lr_interest_completed_derived = $select_arrears[$i]['interest_completed_derived'];
        
        $arrearConditions = [
            'loan_id' => $lr_loan_id,
            'loan_schedule_id' => $lr_schedule_id
        ];
    
        $findArrear = selectAll('loan_arrear', $arrearConditions);

        $currentdate = date('Y-m-d');
        $cal_start = strtotime($lr_duedate);
        $cal_end = strtotime($currentdate);
        $days_between = ceil(abs($cal_end - $cal_start) / 86400);
    
        if (!$findArrear) {
            if(count($findArrear) == 0) {
                $arrearData = [
                    'int_id' => $lr_int_id,
                    'loan_id' => $lr_loan_id,
                    'loan_schedule_id' => $lr_schedule_id,
                    'client_id' => $lr_client_id,
                    'fromdate' => $lr_fromdate,
                    'duedate' => $lr_duedate,
                    'installment' => $lr_installment,
                    'counter' => $days_between,
                    'principal_amount' => $lr_principal_amount,
                    'principal_completed_derived' => $lr_principal_completed_derived,
                    'interest_amount' => $lr_interest_amount,
                    'interest_completed_derived' => $lr_interest_completed_derived,
                    'created_date' => $currentdate_time,
                    'lastmodified_date' => $currentdate_time,
                    'completed_derived' => 1        // value as 1 means it has not been paid off
                ];
    
                $insertArrears = insert('loan_arrear', $arrearData);
                if (!$insertArrears) {
                    printf('1-Error: %s\n', mysqli_error($connection));
                    exit();
    
                } else {
                    echo 'INSERTED SUCCESSFULLY - Loan ID: ' . $lr_loan_id . '<br>';
                }
            }        
    
        } else {

            $currentdate = date('Y-m-d');
            $currentdate_time = date('Y-m-d H:i:s');
            $cal_start = strtotime($lr_duedate);
            $cal_end = strtotime($currentdate);
            $days_between = ceil(abs($cal_end - $cal_start) / 86400);

            if(30 > $days_between && $days_between > 0) {
                $ffd = $select_arrears[$i]['principal_amount'];
                $bnk_prov = (0.05 * $ffd);
            }
            else if(60 > $days_between && $days_between > 30) {
                $fdfdf = $select_arrears[$i]['principal_amount'];
                $bnk_prov = (0.2 * $fdfdf);
            }
            else if(90 > $days_between && $days_between > 60) {
                $dfgd = $select_arrears[$i]['principal_amount'];
                $bnk_prov = (0.5 * $dfgd) ;
            }
            else if($days_between > 90) {
                $juiui = $select_arrears[$i]['principal_amount'];
                $bnk_prov = $juiui;
            } else {
                $bnk_prov = 0;
            }

            $prin = $select_arrears[$i]['principal_amount'];
            $par = ($bnk_prov/$prin) * 100;
            
            $arrear_update = mysqli_query($connection, "UPDATE loan_arrear SET principal_amount = {$lr_principal_amount}, interest_amount = {$lr_interest_amount}, counter = {$days_between}, 
            par = {$par}, bank_provision = {$bnk_prov}, lastmodified_date = '$currentdate_time' WHERE int_id = {$sessint_id} AND loan_id = {$lr_loan_id} AND loan_schedule_id = {$lr_schedule_id}");
            if (!$arrear_update) {
                printf('2-Error: %s\n', mysqli_error($connection)); //checking for errors
                exit();
            } else {
                echo 'UPDATED SUCCESSFULLY - Loan ID: ' . $lr_loan_id . '<br>';
            }
        }
    } 

} else {
    printf('3-Error: %s\n', mysqli_error($connection));
    exit();
}

?>