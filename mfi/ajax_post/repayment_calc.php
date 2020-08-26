<?php

$disb = $_POST['disb'];
$repay = $_POST['repay'];
$grace = $_POST['grace_prin'];
$fdi = $repay.'s';
$repayno = 1 + $grace;
$tod = date('Y-m-d');

$dsl = date('Y-m-d', strtotime($disb. ' + '.$repayno.' '.$fdi.''));

echo '<div class="form-group">
<label>Repayment Date:</label>
<input type="date" value = "'.$dsl.'" name="repay_start" class="form-control" id="repay_start">
</div>';
?>