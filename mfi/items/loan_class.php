<?php
include("../../functions/connect.php");
session_start();

$out= '';
$logo = $_SESSION['int_logo'];
$sessint_id = $_SESSION['int_id'];
$name = $_SESSION['int_name'];

$picked_date = $_POST['picked_date'];
$thirty_days_before_picked_date = date("Y-m-d", strtotime("-30 Days", strtotime($picked_date)));
$branch_id = $_POST['branch_id'];

$getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
while ($result = mysqli_fetch_array($getParentID)) {
    $parent_id = $result['parent_id'];
}

if ($parent_id == 0) {
    // pass and watch
    $fuf = "SELECT SUM(principal_amount) AS principal_amount FROM loan_arrear WHERE int_id = '$sessint_id' AND installment >= '1' AND (counter BETWEEN '31' AND '60') AND (duedate BETWEEN '$thirty_days_before_picked_date' AND '$picked_date')";
    $difo = mysqli_query($connection, $fuf);
    $do = mysqli_fetch_array($difo);
    $pandw = $do['principal_amount'];

    // Substandard
    $dffedr = "SELECT SUM(principal_amount) AS principal_amount FROM loan_arrear WHERE int_id = '$sessint_id' AND installment >= '1' AND (counter BETWEEN '61' AND '90') AND (duedate BETWEEN '$thirty_days_before_picked_date' AND '$picked_date')";
    $sdd = mysqli_query($connection, $dffedr);
    $d = mysqli_fetch_array($sdd);
    $sub = $d['principal_amount'];

    // doubtful
    $zxrs = "SELECT SUM(principal_amount) AS principal_amount FROM loan_arrear WHERE int_id = '$sessint_id' AND installment >= '1' AND (counter BETWEEN '91' AND '180') AND (duedate BETWEEN '$thirty_days_before_picked_date' AND '$picked_date')";
    $dsdfs = mysqli_query($connection, $zxrs);
    $io = mysqli_fetch_array($dsdfs);
    $doub = $io['principal_amount'];

    // lost
    $sdsedw = "SELECT SUM(principal_amount) AS principal_amount FROM loan_arrear WHERE int_id = '$sessint_id' AND installment >= '1' AND counter > '180' AND (duedate BETWEEN '$thirty_days_before_picked_date' AND '$picked_date')";
    $sdas = mysqli_query($connection, $sdsedw);
    $sds = mysqli_fetch_array($sdas);
    $los = $sds['principal_amount'];

    // total portfolio at risk
    $tpar = $pandw + $sub + $doub + $los;

    // total interest in suspense
    $dsio = "SELECT SUM(interest_amount) AS interest_amount FROM loan_arrear WHERE installment >= '1' AND int_id = '$sessint_id' AND (duedate BETWEEN '$thirty_days_before_picked_date' AND '$picked_date')";
    $dso = mysqli_query($connection, $dsio);
    $is = mysqli_fetch_array($dso);
    $fdl = $is['interest_amount'];

    // performing loan
    $query = "SELECT id, loan_id, principal_amount, interest_amount, duedate FROM loan_repayment_schedule WHERE loan_id NOT IN (SELECT loan_id FROM loan_arrear) AND (duedate BETWEEN '$thirty_days_before_picked_date' AND '$picked_date') AND installment >= '1' AND int_id = '$sessint_id'";
    $result = mysqli_query($connection, $query);
    $performing = 0;
    if(mysqli_num_rows($result) > 0) {
      $performing = 0;
      while($row = mysqli_fetch_array($result)) {
        $performing += $row['principal_amount'] + $row['interest_amount'];
      }
    }

    // // total outstanding derived
    // $dd = "SELECT SUM(interest_amount) AS interest_amount FROM loan_repayment_schedule WHERE installment >= '1' AND int_id = '$sessint_id'";
    // $sdoi = mysqli_query($connection, $dd);
    // $e = mysqli_fetch_array($sdoi);
    // $interest_rep = $e['interest_amount'];

    // $dfdf = "SELECT SUM(principal_amount) AS principal_amount FROM loan_repayment_schedule WHERE installment >= '1' AND int_id = '$sessint_id'";
    // $sdswe = mysqli_query($connection, $dfdf);
    // $u = mysqli_fetch_array($sdswe);
    // $prin_rep = $u['principal_amount'];

    // // arrears
    // $dd = "SELECT SUM(interest_amount) AS interest_amount FROM loan_arrear WHERE installment >= '1' AND int_id = '$sessint_id'";
    // $sdoi = mysqli_query($connection, $dd);
    // $e = mysqli_fetch_array($sdoi);
    // $interest_arr = $e['interest_amount'];

    // $dfdf = "SELECT SUM(principal_amount) AS principal_amount FROM loan_arrear WHERE installment >= '1' AND int_id = '$sessint_id'";
    // $sdswe = mysqli_query($connection, $dfdf);
    // $u = mysqli_fetch_array($sdswe);
    // $prin_arr = $u['principal_amount'];

    // $outstandingone = $prin_rep + $interest_rep;

    // $outstandingtwo = $prin_arr + $interest_arr;

    // $outstanding = $outstandingone + $outstandingtwo;

    // // performing loan
    // $performing = $outstanding - ($fdl + $tpar);

    // $total = $performing + $fdl + $tpar;
} else {
    // pass and watch
    $fuf = "SELECT SUM(principal_amount) AS principal_amount FROM loan_arrear WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND installment >= '1' AND (counter BETWEEN '31' AND '60') AND (duedate BETWEEN '$thirty_days_before_picked_date' AND '$picked_date')";
    $difo = mysqli_query($connection, $fuf);
    $do = mysqli_fetch_array($difo);
    $pandw = $do['principal_amount'];

    // Substandard
    $dffedr = "SELECT SUM(principal_amount) AS principal_amount FROM loan_arrear WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND installment >= '1' AND (counter BETWEEN '61' AND '90') AND (duedate BETWEEN '$thirty_days_before_picked_date' AND '$picked_date')";
    $sdd = mysqli_query($connection, $dffedr);
    $d = mysqli_fetch_array($sdd);
    $sub = $d['principal_amount'];

    // doubtful
    $zxrs = "SELECT SUM(principal_amount) AS principal_amount FROM loan_arrear WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND installment >= '1' AND (counter BETWEEN '91' AND '180') AND (duedate BETWEEN '$thirty_days_before_picked_date' AND '$picked_date')";
    $dsdfs = mysqli_query($connection, $zxrs);
    $io = mysqli_fetch_array($dsdfs);
    $doub = $io['principal_amount'];

    // lost
    $sdsedw = "SELECT SUM(principal_amount) AS principal_amount FROM loan_arrear WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND installment >= '1' AND counter > '180' AND (duedate BETWEEN '$thirty_days_before_picked_date' AND '$picked_date')";
    $sdas = mysqli_query($connection, $sdsedw);
    $sds = mysqli_fetch_array($sdas);
    $los = $sds['principal_amount'];

    // total portfolio at risk
    $tpar = $pandw + $sub + $doub + $los;

    // total interest in suspense
    $dsio = "SELECT SUM(interest_amount) AS interest_amount FROM loan_arrear WHERE installment >= '1' AND int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND (duedate BETWEEN '$thirty_days_before_picked_date' AND '$picked_date')";
    $dso = mysqli_query($connection, $dsio);
    $is = mysqli_fetch_array($dso);
    $fdl = $is['interest_amount'];

    // performing loan
    $query = "SELECT id, loan_id, principal_amount, interest_amount, duedate FROM loan_repayment_schedule WHERE loan_id NOT IN (SELECT loan_id FROM loan_arrear) AND (duedate BETWEEN '$thirty_days_before_picked_date' AND '$picked_date') AND installment >= '1' AND int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id)";
    $result = mysqli_query($connection, $query);
    $performing = 0;
    if(mysqli_num_rows($result) > 0) {
      $performing = 0;
      while($row = mysqli_fetch_array($result)) {
        $performing += $row['principal_amount'] + $row['interest_amount'];
      }
    }
}
?>

<div class="card">

  <div class="card-header card-header-primary">
    <h4 class="card-title">Summary of Loan Classification</h4>
  </div>

  <div class="card-body">

    <table class="table">

      <thead>
        <th style="font-weight:bold;">S/N</th>
        <th style="font-weight:bold; text-align: center;"></th>
        <th style="font-weight:bold; text-align: center;">AMOUNT <br> &#x20A6</th>
      </thead>

      <tbody>
        <tr>
            <td>10762</td>
            <td>Performing</td>
            <td style=" text-align: center;"><?php echo number_format($performing, 2);?></td>
            <!-- <td style="background-color:bisque;"></td> -->
        </tr>
        <tr>
            <td>10763</td>
            <td><b>Non-Performing (Portfolio-At-Risk)</b></td>
            <td style=" text-align: center;"></td>
            <!-- <td style="background-color:bisque;"></td> -->
        </tr>
        <tr>
            <td>10764</td>
            <td>Pass & Watch</td>
            <!-- <td></td> -->
            <td style="background-color:bisque; text-align: center;"><?php echo number_format($pandw, 2);?></td>
        </tr>
        <tr>
            <td>10765</td>
            <td>Substandard</td>
            <!-- <td></td> -->
            <td style="background-color:bisque; text-align: center;"><?php echo number_format($sub, 2);?></td>
        </tr>
        <tr>
            <td>10766</td>
            <td>Doubtful</td>
            <!-- <td></td> -->
            <td style="background-color:bisque; text-align: center;"><?php echo number_format($doub, 2);?></td>
        </tr>
        <tr>
            <td>10767</td>
            <td>Lost</td>
            <!-- <td></td> -->
            <td style="background-color:bisque; text-align: center;"><?php echo number_format($los, 2);?></td>
        </tr>
        <tr>
            <td>10768</td>
            <td><b>Total (Portfolio-At-Risk)</b></td>
            <!-- <td></td> -->
            <td style="background-color:bisque; font-weight:bold; text-align: center;"><?php echo number_format($tpar, 2);?></td>
        </tr>
        <tr>
            <td></td>
            <td>Interest In Suspense</td>
            <!-- <td></td> -->
            <td style="background-color:bisque; text-align: center;"><?php echo number_format($fdl, 2);?></td>
        </tr>
        <tr>
            <td>10769</td>
            <td><b>Total</b></td>
            <!-- <td style="background-color:bisque;"></td> -->
            <?php
            $total = $performing + $tpar;
            ?>
            <td style="background-color:bisque; font-weight:bold; text-align: center;"><?php echo number_format($total, 2);?></td>
        </tr>
      </tbody>

    </table>

    <!-- <div class="form-group mt-4">
      <form method="POST" action="">
          <input hidden name="start" type="text" value="<?php echo $thirty_days_before_picked_date; ?>" />
          <input hidden name="end" type="text" value="<?php echo $picked_date; ?>" />
          <input hidden name="branch_id" type="text" value="<?php echo $branch_id; ?>" />
          <button type="submit" name="downloadPDF" class="btn btn-primary pull-left">Download PDF</button>
      </form>
    </div> -->

  </div>

</div>