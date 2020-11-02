<?php
    include('../connect.php');
    $hello = "SELECT * FROM loan_disbursement_cache WHERE status = 'Approved'";
    $query1 = mysqli_query($connection, $hello);
    
    if(mysqli_num_rows($query1) > 0){
        // if code ok
        while($ex = mysqli_fetch_array($query1, MYSQLI_ASSOC)){
            // $ex = mysqli_fetch_array($query1);
            // var_dump($ex);
            $client_id = $ex["client_id"];
            $product_id = $ex["product_id"];
            $int_id = $ex["int_id"];
            // i dont need
            $query2 = mysqli_query($connection, "SELECT * FROM loan WHERE int_id = '13'");
            if($query2){
               while( $y = mysqli_fetch_array($query2)){
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
                $sch_date = date("Y-m-d h:i:s");
                // SECHDULE DATE
                $approved_by = $y["approvedon_userid"];

                $interest_amount = ($interest_rate/100) * $princpal_amount;
                $period_loan = $princpal_amount / $loan_term;
                $amount_collected = $period_loan + $interest_amount;

                $select_repayment_sch = mysqli_query($connection, "SELECT * FROM `loan_repayment_schedule` WHERE loan_id = '$loan_id' AND client_id = '$client_id' AND int_id = '$int_id'");
                $dm = mysqli_fetch_array($select_repayment_sch);
                 if($dm <= 0 && $int_id != "0"){
                    if($rep_every == 'week'){
                        $i = 1;
                        while($i <= $loan_term){
                            $repay = date('Y-m-d', strtotime($offical_repayment. ' + '.$i.' '.$rep_every));
                            echo $repay.'</br>';
                        $insert_repay = mysqli_query($connection, "INSERT INTO `loan_repayment_schedule` (`int_id`, `loan_id`, `client_id`, `fromdate`, `duedate`, `installment`, 
                        `principal_amount`, `interest_amount`, `created_date`, `amount_collected`, `lastmodified_date`) VALUES('$int_id', '$loan_id', '$client_id', '$offical_repayment', '$repay', '1', '$period_loan', '$interest_amount', '$sch_date', '0', '$sch_date')");
                            if($insert_repay){
                                echo 'Inserted for Interval ='.$i.'/<br>';
                            }
                        $i++;
                        }
                    }
                    else if($rep_every == 'month'){
                        $i = 1;
                        while($i <= $loan_term){
                            $repay = date('Y-m-d', strtotime($offical_repayment. ' + '.$i.' '.$rep_every));
                            echo $repay.'</br>';
                        $insert_repay = mysqli_query($connection, "INSERT INTO `loan_repayment_schedule` (`int_id`, `loan_id`, `client_id`, `fromdate`, `duedate`, `installment`, 
                        `principal_amount`, `interest_amount`, `created_date`, `amount_collected`, `lastmodified_date`) VALUES('$int_id', '$loan_id', '$client_id', '$offical_repayment', '$repay', '1', '$period_loan', '$interest_amount', '$sch_date', '0', '$sch_date')");
                            if($insert_repay){
                                echo 'Inserted for Interval ='.$i.'/<br>';
                            }
                        $i++;

                        }
                    }
                    else if($rep_every == 'year'){
                        $i = 1;
                        while($i <= $loan_term){
                            $repay = date('Y-m-d', strtotime($offical_repayment. ' + '.$i.' '.$rep_every));
                            echo $repay.'</br>';
                        $insert_repay = mysqli_query($connection, "INSERT INTO `loan_repayment_schedule` (`int_id`, `loan_id`, `client_id`, `fromdate`, `duedate`, `installment`, 
                        `principal_amount`, `interest_amount`, `created_date`, `amount_collected`, `lastmodified_date`) VALUES('$int_id', '$loan_id', '$client_id', '$offical_repayment', '$repay', '1', '$period_loan', '$interest_amount', '$sch_date', '0', '$sch_date')");
                            if($insert_repay){
                                echo 'Inserted for Interval ='.$i.'/<br>';
                            }
                        $i++;

                        }
                    }
                    else if($rep_every == 'day'){
                        $i = 1;
                        while($i <= $loan_term){
                            $repay = date('Y-m-d', strtotime($offical_repayment. ' + '.$i.' '.$rep_every));
                            echo $repay.'</br>';
                        $insert_repay = mysqli_query($connection, "INSERT INTO `loan_repayment_schedule` (`int_id`, `loan_id`, `client_id`, `fromdate`, `duedate`, `installment`, 
                        `principal_amount`, `interest_amount`, `created_date`, `amount_collected`, `lastmodified_date`) VALUES('$int_id', '$loan_id', '$client_id', '$offical_repayment', '$repay', '1', '$period_loan', '$interest_amount', '$sch_date', '0', '$sch_date')");
                            if($insert_repay){
                                echo 'Inserted for Interval ='.$i.'/<br>';
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
<?php
    $today = date('Y-m-d');
    $seir = mysqli_query($connection,"SELECT * FROM loan_repayment_schedule WHERE duedate < '$today' AND installment >= '1'");
    // if($seir){
    //     while($qu = mysqli_fetch_array($seir)){
    //         $id = $qu['id'];
    //         $int_id = $qu['int_id'];
    //         $loan_id = $qu['loan_id'];
    //         $client_id = $qu['client_id'];
    //         $fromdate = $qu['fromdate'];
    //         $duedate = $qu['duedate'];
    //         $principal_amount = $qu['principal_amount'];
    //         $interest_amount = $qu['interest_amount'];
    //         $created_date = $qu['created_date'];
    //         $amount_collected = $qu['amount_collected'];
    //         $lastmodified_date = $qu['lastmodified_date'];

    //         $query3 = mysqli_query($connection, "INSERT INTO `loan_arrear` (`int_id`, `loan_id`, `client_id`, `fromdate`, `duedate`, `installment`, 
    //         `principal_amount`, `interest_amount`, `created_date`, `amount_collected`, `lastmodified_date`) VALUES('$int_id', '$loan_id', '$client_id',
    //         '$fromdate', '$duedate', '1', '$principal_amount', '$interest_amount', '$created_date', '$amount_collected', '$lastmodified_date')");
    //         if($query3){
    //             echo 'Loan payment moved to arrears</br>';
    //             $doi = mysqli_query($connection, "UPDATE loan_repayment_schedule SET installment = '0' WHERE id = '$id'");
    //         }
    //     }
    // }
?>