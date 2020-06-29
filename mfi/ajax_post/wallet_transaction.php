<?php
include("../../functions/connect.php");
session_start();
$output = '';
?>
<?php
if (isset($_POST["start"]) && isset($_POST["branch_id"]) && isset($_POST["end"]) && isset($_POST["int_id"]))
{
// dman
$int_id = $_POST["int_id"];
$std = $_POST["start"];
$datex= strtotime($std); 
$sdate = date("Y-m-d", $datex);
 $start = $sdate;
//  echo $start;
 $endx = $_POST["end"];
 $datey= strtotime($endx); 
 $eyd= date("Y-m-d", $datey);
 $end = $eyd;
//  echo $end;
 $branch_id = $_POST["branch_id"];
 $int_name = $_SESSION["int_name"];
//  branch
$branchquery = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch_id'");
if (count([$branchquery]) == 1) {
  $ans = mysqli_fetch_array($branchquery);
  $branch = $ans['name'];
}
// making
if (count([$branchquery]) == 1) {
    $out = '';
    // here we will some data
    $genb1 = mysqli_query($connection, "SELECT SUM(credit) AS credit FROM sekani_wallet_transaction WHERE (int_id = '$int_id' AND branch_id = '$branch_id') AND ( transaction_date BETWEEN '$start' AND '$end' ) ORDER BY transaction_date ASC");
        // then we will be fixing
        $genb = mysqli_query($connection, "SELECT SUM(debit) AS debit FROM sekani_wallet_transaction WHERE (int_id = '$int_id' AND branch_id = '$branch_id') AND (transaction_date BETWEEN '$start' AND '$end' ) ORDER BY transaction_date ASC");
        $m1 = mysqli_fetch_array($genb1);
        $m = mysqli_fetch_array($genb);

        // MAKING
        // $genb12 = mysqli_query($connection, "SELECT `wallet_balance_derived` FROM sekani_wallet_transaction WHERE (int_id = '$int_id' AND branch_id = '$branch_id') AND (transaction_date BETWEEN '$start' AND '$end' ) ORDER BY id DESC LIMIT 1");
        // $genb122 = mysqli_query($connection, "SELECT `wallet_balance_derived` FROM sekani_wallet_transaction WHERE (int_id = '$int_id' AND branch_id = '$branch_id') AND (transaction_date BETWEEN '$start' AND '$end' ) ORDER BY id ASC LIMIT 1");
        
        // $m12 = mysqli_fetch_array($genb12);
        // $m122 = mysqli_fetch_array($genb122);
        $tcp = $m1["credit"];
        $tdp = $m["debit"];
        // $famt =  $m12["wallet_balance_derived"];
        // $famt2 =  $m122["wallet_balance_derived"];
        // $finalbal = number_format(($famt), 2);
        // $finalbal2 = number_format(($famt2), 2);
        $tcdp = number_format(round($tcp), 2);
        $tddp = number_format(round($tdp), 2);
        // function
        function fill_report($connection, $int_id, $start, $end, $branch_id)
        {
            $out = '';
            $querytoget = mysqli_query($connection, "SELECT * FROM sekani_wallet_transaction WHERE ((int_id = '$int_id' AND branch_id = '$branch_id') AND (transaction_date BETWEEN '$start' AND '$end')) ORDER BY id ASC");
          // $q = mysqli_fetch_array($querytoget);
          while ($q = mysqli_fetch_array($querytoget)) {
            //   new moment
            $trans_id = $q["transaction_id"];
            $trans_date = $q["transaction_date"];
            $credit = $q["credit"];
            $debit = $q["debit"];
            $balance = $q["wallet_balance_derived"];
            $description = $q["description"];

            $amt = number_format($credit, 2);
            $amt2 = number_format($debit, 2);

            $out .= '
            <tr>
              <th>.'.$trans_date.'.<th>
              <th>.'.$trans_id.'.<th>
              <th>.'.$description.'.<th>
              <th>.'.$amt.'.<th>
              <th>.'.$amt2.'.<th>
              <th>.'.$balance.'.<th>
            </tr>
            ';
          }
        }
        return $out;
    }
    $output = '
    <div class="card">
    <div class="card-header card-header-primary">
      <h4 class="card-title">'.$int_name." ".$branch.'</h4>
      <p class="card-category">Teller Call Over Report</p>
    </div>
    <div class="card-body">
      <!-- sup -->
      <!-- hello -->
      <form action="../composer/teller_call.php" method="post">
        <div class="row">
            <div class="col-md-4 form-group">
                <label for="">Name of Teller</label>
                <input type="text" name="" value="'.$tell_name.'" id="" class="form-control" readonly>
                <input type="text" name="start1" value="'.$start.'" id="start1" class="form-control" hidden>
                <input type="text" name="end1" value="'.$end.'" id="end1" class="form-control" hidden>
                <input type="text" name="branch1" value="'.$branch_id.'" id="branch1" class="form-control" hidden>
                <input type="text" name="teller1" value="'.$teller.'" id="teller1" class="form-control" hidden>
                <input type="text" name="int_id1" value="'.$int_id.'" id="int_id1" class="form-control" hidden>
            </div>
            <div class="col-md-4 form-group">
                <label for="">Branch</label>
                <input type="text" name="" value="'.$branch.'" id="" class="form-control" readonly>
            </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="bmd-label-floating">As at:</label>
              <input type="text" value="'.$end.'" name="" class="form-control" id="" readonly>
            </div>
          </div>
          </div>
        <div class="clearfix"></div>
      
      <div class="table-responsive">
        <table id="tabledat4" class="table" style="width: 100%;">
          <thead class=" text-primary">
          <th>Date/Time</th>
            <th>Account Name</th>
            <th>Deposit</th>
            <th>
              Withdrawal
            </th>
            <th>Balance</th>
          </thead>
          <tbody>
          "'.fill_report($connection, $int_id, $start, $end, $teller).'"
          <tr>
        <th>Total</th>
        <th></th>
         <th>'.$tcdp.'</th>
         <th>'.$tddp.'</th>
      <th>'.$finalbal.'</th>
        </tr>
          </tbody>
        </table>
      </div>
      <hr>
      <p><b>Teller Sign:</b> 129                        <b>Date:</b></p>
      <p><b>Checked By: '.$_SESSION["username"].'</b>                             <b>Date/Sign: '.$start." - ".$end.' </b></p>

      <p>
      <button id="pddf" type="sumbit" class="btn btn-primary pull-right">PDF print</button>
      <div id=""></div>
      </p>
      </form>
    </div>
  </div>';
  echo $output;
} else {
    echo "DMAN NOT SEEING";
}
?>