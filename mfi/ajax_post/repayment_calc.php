<?php

$disb = $_POST['disb'];     // ex. 2021-05-12
$loan_term = $_POST["loant"] . ' ' . $_POST['repay'] . 's';
$repay_every = $_POST['repayno'];   // repayment_every value ex. 30 Days or 1 Month

$disb_stt = strtotime($disb);

// loan repayment start date in time value
$rst_stt = strtotime('+'. $repay_every, $disb_stt);

// loan tenure in time value
$lt_stt = strtotime('+'. $loan_term, $disb_stt);

if($lt_stt >= $rst_stt) {
    
    $rst = date('Y-m-d', $rst_stt);

    echo '
    <div class="form-group">
        <label>Repayment Start Date:</label>
        <input type="date" value = "'.$rst.'" name="repay_start" class="form-control" id="repay_start" readonly>
    </div>
    ';
}

?>