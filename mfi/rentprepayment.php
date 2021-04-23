<?php

$month = getPieceOfDate($year,'m');
$rentmonth = mysqli_query($connection, "SELECT * FROM prepayment_account WHERE monthend = '$month'");
if($rentmonth == 0){    
$amount;
}

?>