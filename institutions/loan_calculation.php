<?php
// i will be loading data back
$result = '';
$prina = $_POST["prina"];
$loant = $_POST["loant"];
$intr = $_POST["intr"];
$repay_start = $_POST["repay_start"];
$rep = $_POST["repay"];
// $r = $intr / (12 * 100);
// $t = $loant;
// $EMI = ($prina * $r * pow(1 + $r, $t)) / (pow(1 + $r, $t) - 1);
$tms = '';
$r = $intr / 100;
$gi = $r * $prina;
$pd = $gi + $prina;
$t = $loant;
$EMI = ($gi + $prina) / $t;
$tm = $rep;
if ($tm == 'day') {
  $tms = 'days';
} else if ($tm == 'month') {
  $tms = 'months';
} else if ($tm == 'year') {
  $tms = 'years';
} else {
  echo 'error';
}

$formg = date('Y-m-d', strtotime($repay_start. ' + '.$t.' '.$tms.''));
$end_date = $formg;
$date = $repay_start;
function fill_com ($e, $d, $tx, $em) {
  date_default_timezone_set('UTC');
  echo "<label for=''>". "Date & Principal Due:" ."</label>";
while (strtotime($d) <= strtotime($e)) {
    echo "<div class='form-group'>" . "<ul>" . "<li>". date("d M Y", strtotime($d)) . ": " . $em . "</li>" . "</ul>"."</div>";
    $d = date ("Y-m-d", strtotime("+1 ".$tx." ", strtotime($d)));
}
date("M Y", strtotime($d));
}
$result1 = '<div class="my-3">
  <!-- replace values with loan data -->
  <div class="form -group">
    <label for="">Disbursement:</label> <span>'.$prina.'</span>
  </div>
</div>';
$result2 = '<div class="my-3">
  <!-- replace values with loan data -->
  <div class="form -group">
    <label for="">Principal Balance:</label> <span>'.$pd.'</span>
  </div>
  <div class="form -group">
    <label for="">Interest Rate:</label> <span>'.$intr.'%</span>
  </div>
</div>';
echo $result1;
echo fill_com($end_date, $date, $tms, $EMI);
echo $result2;
?>
