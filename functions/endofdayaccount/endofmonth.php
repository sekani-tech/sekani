<?php
include('../connect.php');
session_start();
//Convert date to month here
//check if month is set 
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

if (isset($_POST['endofmonth'])) {
    
    $closedDate = $_POST['closedDate'];
    
    // PUT IN A FUNCTION ... will be used for end of year
    $endOfMonthResp = endOfMonth($closedDate,$connection);
    if($endOfMonthResp == 0) {
        header("Location: ../../mfi/end_of_month.php?message1=$randms");
    } else {
        // echo $endOfMonthResp;
        header("Location: ../../mfi/end_of_month.php?error=".$endOfMonthResp."");
    }
} 
?>

