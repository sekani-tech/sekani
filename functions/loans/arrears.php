<?php
include("../connect.php");
session_start();
$sessint_id = $_SESSION['int_id'];
$date = date('Y-m-d');
$datetime = date('Y-m-d H:i:s');

// count it
// check it check if installment is 0 or 1.
$conditions = [
    'int_id' => $sessint_id,
    'installment' => 1
];
$dateConditions = [
    'duedate' => $date
];

$select_arrears = selectAllLessEq('loan_repayment_schedule', $conditions, $dateConditions);
if (!$select_arrears) {
    printf('1-Error: %s\n', mysqli_error($connection)); //checking for errors
    exit();
}

for ($i = 0; $i < sizeof($select_arrears); $i++) {
    // now we need to get it.
    $lr_id = $select_arrears[$i]["id"];
    $lr_int_id = $select_arrears[$i]["int_id"];
    $lr_loan_id = $select_arrears[$i]["loan_id"];
    $lr_client_id = $select_arrears[$i]["client_id"];
    // counting from the duedate of the first installment of the loan's repayment schedule
    $lr_due_date = $select_arrears[0]["duedate"];
    $lr_installment = $select_arrears[$i]["installment"];
    $lr_principal_amount = $select_arrears[$i]["principal_amount"];
    $lr_principal_completed_derived = $select_arrears[$i]["principal_completed_derived"];
    $lr_interest_amount = $select_arrears[$i]["interest_amount"];
    $lr_interest_completed_derived = $select_arrears[$i]["interest_completed_derived"];
    
    $arrearConditions = [
        'loan_id' => $lr_loan_id
    ];

    $findArrear = selectAll('loan_arrear', $arrearConditions);

    if (!$findArrear) {
        if(count($findArrear) == 0) {
            $arrearData = [
                'int_id' => $lr_int_id,
                'loan_id' => $lr_loan_id,
                'client_id' => $lr_client_id,
                'installment' => $lr_installment,
                'counter' => 0,
                'principal_amount' => $lr_principal_amount,
                'principal_completed_derived' => $lr_principal_completed_derived,
                'interest_amount' => $lr_interest_amount,
                'interest_completed_derived' => $lr_interest_completed_derived,
                'created_date' => $datetime
            ];

            $insertArrears = insert('loan_arrear', $arrearData);
            if (!$insertArrears) {
                printf('3-Error: %s\n', mysqli_error($connection)); //checking for errors
                exit();

            } else {
                echo "INSERTED SUCCESSFULLY <br>";
            }
        }        

    } else {
        for ($j = 0; $j < sizeof($findArrear); $j++) {
        
            $arrearId = $findArrear[$j]["id"];
            $i_counter = $findArrear[$j]["counter"];
            // php
            $current_date = date('Y-m-d');
            $cal_start = strtotime($lr_due_date);
            $cal_end = strtotime($current_date);
            // do your calculation
            $days_between = ceil(abs($cal_end - $cal_start) / 86400);
            // percentage Value
            $days_no = $i_counter;
            $prin = $findArrear[$j]['principal_amount'];
            $intr = $findArrear[$j]['interest_amount'];
            $new_prin = $prin + $lr_principal_amount;
            $new_intr = $intr + $lr_interest_amount;

            $thirty = '0.00';
            $sixty = '0.00';
            $ninety = '0.00';
            $above = '0.00';

            if(30 > $days_no && $days_no > 0) {
                $thirty = number_format($findArrear[$j]['principal_amount'], 2);
                $ffd = $findArrear[$j]['principal_amount'];
                $bnk_prov = (0.05 * $ffd);
            }
            else if(60 > $days_no && $days_no > 30) {
                $sixty = number_format($findArrear[$j]['principal_amount'], 2);
                $fdfdf = $findArrear[$j]['principal_amount'];
                $bnk_prov = (0.2 * $fdfdf);
            }
            else if(90 > $days_no && $days_no > 60) {
                $ninety = number_format($findArrear[$j]['principal_amount'], 2);
                $dfgd = $findArrear[$j]['principal_amount'];
                $bnk_prov = (0.5 * $dfgd) ;
            }
            else if($days_no > 90) {
                $above = number_format($findArrear[$j]['principal_amount'], 2);
                $juiui = $findArrear[$j]['principal_amount'];
                $bnk_prov = $juiui;
            } else {
                $bnk_prov = 0;
            }

            $pfar = 0;
            $par = ($bnk_prov/$prin) * 100;
            // update ok
            $updateValues = [
                'principal_amount' => $new_prin,
                'interest_amount' => $new_intr,
                'counter' => $days_between, 
                'par' => $par, 
                'bank_provision' => $bnk_prov
            ];

            $arrear_update = update('loan_arrear', $arrearId, 'id', $updateValues);
            if (!$arrear_update) {
                printf('5-Error: %s\n', mysqli_error($connection)); //checking for errors
                exit();
            }

            // $arrear_update = mysqli_query($connection, "UPDATE `loan_arrear` SET counter = '$days_between', par='$par', bank_provision = '$bnk_prov' WHERE id = '$lr_id' AND int_id = '$lr_int_id' AND loan_id = '$lr_loan_id' AND client_id = '$lr_client_id'");
            // aiit running.
            if ($arrear_update) {
                echo "UPDATED SUCCESSFULLY <br>";

            } else {
                echo  "BAD <br>";
            }

            // now are done here!
            echo "DIFFERENCE BETWEEN DATE IS ".$days_between . "<br>";
        }
    }
} 
// count out
?>