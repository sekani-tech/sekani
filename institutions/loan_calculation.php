<?php
// i will be loading data back

$result = '';
$prina = $_POST["prina"];
$loant = $_POST["loant"];
$intr = $_POST["intr"];
$repay_start = $_POST["repay_start"];

$r = $intr / (12 * 100);
$t = $loant * 12;
// for now lets look at years

$EMI = ($prina * $r * pow(1 + $r, $t)) / (pow(1 + $r, $t) - 1);

$result = '<div class="my-3">
  <!-- replace values with loan data -->
  <div class="form -group">
    <label for="">Disbursement:</label> <span>'.$prina.'</span>
  </div>
  <div class="form -group">
    <label for="">Date &amp; Principal Due:</label> <ul>
      <li>EMI('.$repay_start.') - '.$EMI.'</li>
    </ul>
  </div>
  <div class="form -group">
    <label for="">Principal Balance:</label> <span>'.$prina.'</span>
  </div>
  <div class="form -group">
    <label for="">Intrest Rate:</label> <span>'.$intr.'%</span>
  </div>
</div>';
echo $result
?>