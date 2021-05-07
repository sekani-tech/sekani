<?php

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
