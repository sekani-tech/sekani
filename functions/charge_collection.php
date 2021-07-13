<?php
    function charge_collection($arr,$_cb,$cb) {

        $connection = $arr['connection'];
        // due date
$charge_query = mysqli_query($connection, "SELECT * FROM auto_charge WHERE is_active = '1'");
// end date
// dd($charge_query);
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
                // if ($current_day == $last_month_day) {
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
                        $arr['response']=0;
                        // echo "SMS CHARGE SUCCESS";
                    } else {
                        $arr['response']='SMS CHARGE BAD';
                        // echo "SMS CHARGE BAD";
                    }
                                         } else {
                                            $arr['response']='Error at GL insert';
                                            //  $cb("Error at GL insert");
                                            //  echo "Error at GL insert";
                                         }
                    } else {
                        $arr['response']='error at gl update';
                        // echo "error at gl update";
                    }
                } else {
                    $arr['response']='SYSTEM ERROR - INSERT ACCOUNT';
                    // echo "SYSTEM ERROR - INSERT ACCOUNT";
                }
        } else {
            $arr['response']='SYSTEM ERROR - UPDATE ACCOUNT';
            // echo "SYSTEM ERROR - UPDATE ACCOUNT";
        }
                // } else {
                //     // not yet ending
                //     echo 3;
                // }
        } else {
            $arr['response']=0;
            // $arr['info']='No SMS Charge';
            // echo "No SMS Charge";
        }
      } else if ($c_type == "") {
        $arr['response']=0;
        //   make something for something else
        // echo 2;
      }
}
}

if(is_callable($cb)) {
    call_user_func($cb,$_cb,$arr);
}
    }
?>