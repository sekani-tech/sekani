<?php
    $arrear = mysqli_query($connection, "UPDATE loan_arrear SET installment = '0', amount_collected = '$tatb' WHERE id = '$id'");
    if($arrear){
        $acco = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$amount_collected' WHERE client_id = '$client'");
        if($acco){
            $pre_out = mysqli_query($connection,"SELECT * loan WHERE id = '$loan_id'");
            $exec = mysqli_fetch_array($pre_out);
            $outstanding = $exec['total_oustanding_derived'];
            $new_outs = $outstanding - $tatb;
            $outs= mysqli_query($connection, "UPDATE loan SET total_oustanding_derived = '$new_outs' WHERE id = '$loan_id'");
            echo 'successful';
            // end
        }
    }
?>