<?php
/////////////////////// AUTO CODE TO CALCULATE THE DEPRECIATION OF ALL ASSETS IN AN INSTITUTION ///////////////////////
$sessint_id = $_SESSION['int_id'];

// Pull all assets
$ifdo = mysqli_query($connection, "SELECT * FROM assets WHERE int_id = {$sessint_id}");
while($pd = mysqli_fetch_array($ifdo)){
    $aorp = $pd['id'];
    $int_id = $pd['int_id'];
    $asset_name = $pd['asset_name'];
    $asset_type_id = $pd['asset_type_id'];
    $type = $pd['type'];
    $qty = $pd['qty'];
    $unit_price = $pd['unit_price'];
    $amount = $pd['amount'];
    $asset_no = $pd['asset_no'];
    $location = $pd['location'];
    $date = $pd['date'];
    $dep = $pd['depreciation_value'];
    $current_year = $pd['current_year_depreciation'];
    $current_month = $pd['current_month_depreciation'];
    $curr_year = date('Y-m-d');
    $curr_month = date('m');

    // to get difference in years
    $purdate = strtotime($date);
    $currentdate = strtotime($curr_year);
    $datediff = $currentdate - $purdate;
    $datt = round($datediff / (60 * 60 * 24 * 365));

    // to get percentage
    $dom = ($dep/100) * $unit_price;
    // to get current year depreciation
    $currentyear = $unit_price - ($dom * $datt);

    // to get current month depreciation
    $curr_mon = $dom / 12;
    // last year plus number of months spent = this month depreciation

    $lasty = $unit_price - ($dom * ($datt - 1));
    if($currentyear != $unit_price){
    $current_month = $lasty + ($curr_mon * $curr_month);
    
    }
    else{
       $current_month =  $unit_price -($curr_mon * $curr_month);
    }

    $idof = "UPDATE assets SET current_year_depreciation = '$currentyear', current_month_depreciation = '$current_month' WHERE int_id = '$int_id' AND id = '$aorp'";
    $dos = mysqli_query($connection, $idof);
    if($dos){
        echo 'Depreciation Value for '.$asset_name.' with int_id '.$int_id.' was calculated</br>';
    }
}