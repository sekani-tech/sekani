<?php
 include("../connect.php");
    $date = date('Y-m-d');
    $query1 = mysqli_query($connection, "SELECT * FROM loan_arrear WHERE installment >= '1'");
    if($query1){
        while($ion = mysqli_fetch_array($query1)){
            $id = $ion['id'];
            $client = $ion['client_id'];
            $loan_id = $ion['loan_id'];

            $acct = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$client' AND account_balance_derived > '0' ORDER BY account_balance_derived DESC LIMIT 1");
            
            if($acct){
                $abc = mysqli_fetch_array($acct);
            $account_balance = $abc['account_balance_derived'];
            if($account_balance == '0.00'){
                // IF NULL, SEND MESSAGE
                echo 'No money in account</br>';
            }
            else{
                // if money in account
                $account_id = $abc['id'];
                $principal_amount = $ion['principal_amount'];
                $amount_collected = $ion['amount_collected'];
                $interest_amount = $ion['interest_amount'];
                $tatbp = ($principal_amount + $interest_amount) - $amount_collected;
                if($account_balance >= $tatbp){
                    // if account balance is more than total amount to be paid
                    $arrear = mysqli_query($connection, "UPDATE loan_arrear SET installment = '0' WHERE id = '$id'");
                    // set arrear repayment as cleared
                    if($arrear){
                        $query2 = mysqli_query($connection, "SELECT * FROM loan WHERE id = '$loan_id'");
                        $exe = mysqli_fetch_array($query2);
                        $total_out = $exe['total_outstanding_derived'];
                        $newouts = $total_out - $tatbp;
                        $newacc = $account_balance -  $tatbp;
                        $account = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$newacc', updateon_date = '$date' WHERE client_id = '$client' AND id = '$account_id'");
                        $loan = mysqli_query($connection, "UPDATE loan SET total_outstanding_derived = '$newouts' WHERE id = '$loan_id'");
                        // Update oustanding loan balance and account balance
                    }
                    echo 'Amount fully paid!</br>';
                }
                else if($account_balance < $tatbp){
                    // if account balane is less than total amount to be paid
                    $new_amount = $amount_collected + $account_balance;
                     $arrear = mysqli_query($connection, "UPDATE loan_arrear SET amount_collected = '$new_amount' WHERE id = '$id'");
                     // set amount in arrears until it needed
                     if($arrear){
                         $query2 = mysqli_query($connection, "SELECT * FROM loan WHERE id = '$loan_id'");
                         $exe = mysqli_fetch_array($query2);
                         $total_out = $exe['total_outstanding_derived'];
                         $newouts = $total_out - $account_balance;
                         $account = mysqli_query($connection, "UPDATE account SET account_balance_derived = '0', updateon_date = '$date' WHERE client_id = '$client' AND id = '$account_id'");
                         $loan = mysqli_query($connection, "UPDATE loan SET total_outstanding_derived = '$newouts' WHERE id = '$loan_id'");
                         if($account && $loan){
                            echo 'Amount not enough, stored in arrears</br>';
                         }
                         // Update oustanding loan balance and account balance
                     }
                }
            }
        }
        else{
            echo 'error</b>';
        }
        }
    }
    // // declare variables
//  $query1 = mysqli_query($connection, "SELECT * FROM loan_arrear WHERE installment >= '1'");
//  while($que = mysqli_fetch_array($query1)){
//     if($que){
//         // DETERMINE ACCOUNT BALANCE
//         $id = $que['id'];
//         $client = $que['client_id'];
//         $loan_id = $que['loan_id'];
//         $acct = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$client' AND account_balance_derived > '0' ORDER BY account_balance_derived DESC LIMIT 1");
//         $abc = mysqli_fetch_array($acct);
//         if($abc == NULL){
//             // IF NULL, SEND MESSAGE
//             echo 'No money in account</br>';
//         }
//         else{
//             // ELSE RUN CODE BELOW
//             $account_balance = $abc['account_balance_derived'];
//             echo $account_balance.' ';

//             // get total amount to be paid
//             $principal_amount = $que['principal_amount'];
//             $interest_amount = $que['interest_amount'];
//             $ammount = $que['amount_collected'];
//              if($ammount > 0){
//                 $tatb = $principal_amount + $interest_amount - $ammount;
//             // if amount is more than total in arrear
//                 if($account_balance > $tatb){
//                     $amount_collected = $account_balance - $tatb;
//                     include('payment.php');
//                 }
//                 else{
//                     $err = $ammount + $account_balance; //amount previously collected and current amount to be collected
//                     $arrear = mysqli_query($connection, "UPDATE loan_arrear SET amount_collected = '$err' WHERE id = '$id'");
//                     // update loan outstanding
//                     $pre_out = mysqli_query($connection,"SELECT * loan WHERE id = '$loan_id'");
//                     $exec = mysqli_fetch_array($pre_out);
//                     echo $loan_id.' <= loan here ';
//                     var_dump($pre_out);
//                     $outstanding = $exec['total_oustanding_derived'];
//                     $new_outs = $outstanding - $account_balance;
//                     $outs= mysqli_query($connection, "UPDATE loan SET total_oustanding_derived = '$new_outs' WHERE id = '$loan_id'");
//                     if($outs){
//                         $acco = mysqli_query($connection, "UPDATE account SET account_balance_derived = '0' WHERE client_id = '$client'");
//                     }
//                     echo 'successful';
//                 }
//              }else{
//                 $tatb = $principal_amount + $interest_amount;
//                 // if amount is more than total in arrear
//                 if($account_balance > $tatb){
//                    $amount_collected = $account_balance - $tatb;
//                    include('payment.php');
//                 }else{
//                     $arrear = mysqli_query($connection, "UPDATE loan_arrear SET amount_collected = '$account_balance' WHERE id = '$id'");

//                     $pre_out = mysqli_query($connection,"SELECT * loan WHERE id = '$loan_id'");
//                     $exec = mysqli_fetch_array($pre_out);
//                     $outstanding = $exec['total_oustanding_derived'];
//                     $new_outs = $outstanding - $account_balance;
//                     $outs= mysqli_query($connection, "UPDATE loan SET total_oustanding_derived = '$new_outs' WHERE id = '$loan_id'");
//                     if($outs){
//                         $acco = mysqli_query($connection, "UPDATE account SET account_balance_derived = '0' WHERE client_id = '$client'");
//                     }
//                     echo 'successful';
//                 }
//              }
            

//         }
       
//     }
//     else{
//         echo 'No loan</br>';
//     }
// }
?>
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