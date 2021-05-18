<?php

$disb = $_POST['disb'];     // ex. 2021-05-12
$repay = $_POST['repay'];   // ex. day 
$fdi = $repay.'s'; // ex. days

$repay_every = $_POST['repayno'];   // ex. 30

$disb_stt = strtotime($disb);
$dsl = date('Y-m-d', strtotime('+'.$repay_every . ' '. $fdi, $disb_stt));

echo '
<div class="form-group">
    <label>Repayment Start Date:</label>
    <input type="date" value = "'.$dsl.'" name="repay_start" class="form-control" id="repay_start" readonly>
</div>
';

?>