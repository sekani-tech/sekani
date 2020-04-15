<?php
$loan_term = $_POST["loant"];
$repayment_start = $_POST["repay_start"];
$rep_every = $_POST["repay"];
$disburse_date = $_POST["disbd"];

$principal_amount = $_POST["prina"];
$interest_rate = $_POST["intr"] ;
$maxL = $_POST["max_Lamount"];
$minL = $_POST["min_Lamount"];
$maxint = $_POST["max_intrate"];
$minint = $_POST["max_intrate"];

 if($minL > $principal_amount ) {
    echo '<label style="color: red;">Minimum loan has not been met! Please adjust loan</label';
}
else if($maxL>=$principal_amount){
    echo '';
}
else if($principal_amount > $maxL) {
    echo '<label style="color: red;">Maximum loan has been exceeded! Please adjust loan</label';
}
?>