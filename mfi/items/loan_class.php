<?php
include("../../functions/connect.php");
session_start();

$out= '';
$logo = $_SESSION['int_logo'];
$sessint_id = $_SESSION['int_id'];
$name = $_SESSION['int_name'];

if(!empty($_POST['picked_date'])) {
  
  $date = $_POST['picked_date'];
  $branch_id = $_POST['branch_id'];

  $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
  while ($result = mysqli_fetch_array($getParentID)) {
      $parent_id = $result['parent_id'];
  }

  if ($parent_id == 0) {
      // performing loan
      $getPerforming = mysqli_query($connection, "SELECT SUM(lr.principal_amount) as principal, SUM(lr.interest_amount) as interest FROM loan_repayment_schedule lr JOIN loan l ON lr.loan_id = l.id WHERE l.id NOT IN (SELECT loan_id FROM loan_arrear) AND l.int_id = '$sessint_id' AND l.disbursement_date <= '$date' AND total_outstanding_derived <> 0");
      $performing = mysqli_fetch_array($getPerforming);
      $principal = $performing['principal'];
      $interest = $performing['interest'];
      $performing = $principal + $interest;

      $allpar = mysqli_query($connection, "SELECT * FROM loan_arrear WHERE int_id = '$sessint_id' AND installment >= '1' GROUP BY loan_id ORDER BY loan_id");

  } else {
      $getPerforming = mysqli_query($connection, "SELECT SUM(lr.principal_amount) as principal, SUM(lr.interest_amount) as interest FROM loan_repayment_schedule lr JOIN loan l ON lr.loan_id = l.id WHERE l.id NOT IN (SELECT loan_id FROM loan_arrear) AND l.int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND l.disbursement_date <= '$date' AND total_outstanding_derived <> 0");
      $performing = mysqli_fetch_array($getPerforming);
      $principal = $performing['principal'];
      $interest = $performing['interest'];
      $performing = $principal + $interest;

      $allpar = mysqli_query($connection, "SELECT * FROM loan_arrear WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND installment >= '1' GROUP BY loan_id ORDER BY loan_id");
  }

  // $valueofpar1to30 = 0;
  
  $pandw = 0;
  
  $sub = 0;
  
  $doub = 0;
  
  $los = 0;

  while($eachpar = mysqli_fetch_array($allpar)) {
    if($eachpar['counter'] <= '30') {
        $loan_id = $eachpar['loan_id'];
        $getpar1to30 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount, SUM(interest_amount) AS interest_amount FROM loan_repayment_schedule WHERE int_id = '$sessint_id' AND loan_id = '$loan_id' AND installment >= '1'");
        $par1to30 = mysqli_fetch_array($getpar1to30);
        $principal = $par1to30['principal_amount'];
        $interest = $par1to30['interest_amount'];
        $performing += $principal + $interest;

    } else if ($eachpar['counter'] >= '31' && $eachpar['counter'] <= '60') {
        $loan_id = $eachpar['loan_id'];
        $getpar31to60 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount, SUM(interest_amount) AS interest_amount FROM loan_repayment_schedule WHERE int_id = '$sessint_id' AND loan_id = '$loan_id' AND installment >= '1'");
        $par31to60 = mysqli_fetch_array($getpar31to60);
        $principal = $par31to60['principal_amount'];
        $interest = $par31to60['interest_amount'];
        $pandw += $principal + $interest;

    } else if ($eachpar['counter'] >= '61' && $eachpar['counter'] <= '90') {
        $loan_id = $eachpar['loan_id'];
        $getpar61to90 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount, SUM(interest_amount) AS interest_amount FROM loan_repayment_schedule WHERE int_id = '$sessint_id' AND loan_id = '$loan_id' AND installment >= '1'");
        $par61to90 = mysqli_fetch_array($getpar61to90);
        $principal = $par61to90['principal_amount'];
        $interest = $par61to90['interest_amount'];
        $sub += $principal + $interest;

    } else if ($eachpar['counter'] >= '91' && $eachpar['counter'] <= '180') {
        $loan_id = $eachpar['loan_id'];
        $getpar91to180 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount, SUM(interest_amount) AS interest_amount FROM loan_repayment_schedule WHERE int_id = '$sessint_id' AND loan_id = '$loan_id' AND installment >= '1'");
        $par91to180 = mysqli_fetch_array($getpar91to180);
        $principal = $par91to180['principal_amount'];
        $interest = $par91to180['interest_amount'];
        $doub += $principal + $interest;

    } else {
        $loan_id = $eachpar['loan_id'];
        $getpar180andmore = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount, SUM(interest_amount) AS interest_amount FROM loan_repayment_schedule WHERE int_id = '$sessint_id' AND loan_id = '$loan_id' AND installment >= '1'");
        $par180andmore = mysqli_fetch_array($getpar180andmore);
        $principal = $par180andmore['principal_amount'];
        $interest = $par180andmore['interest_amount'];
        $los += $principal + $interest;
    }
  }

  // total portfolio at risk
  $tpar = $pandw + $sub + $doub + $los;

  // total interest in suspense
  $dsio = "SELECT SUM(interest_amount) AS interest_amount FROM loan_arrear WHERE installment >= '1' AND int_id = '$sessint_id' AND duedate <= '$date'";
  $dso = mysqli_query($connection, $dsio);
  $is = mysqli_fetch_array($dso);
  $iis = $is['interest_amount'];
  ?>

  <div class="card">

    <div class="card-header card-header-primary">
      <h4 class="card-title">Summary of Loan Classification</h4>
    </div>

    <div class="card-body">

      <table class="table">

        <thead>
          <th style="font-weight:bold; text-align: center;"></th>
          <th style="font-weight:bold; text-align: center;">AMOUNT <br> &#x20A6</th>
        </thead>

        <tbody>
          <tr>
              <td>Performing</td>
              <td style=" text-align: center;"><?php echo number_format(round($performing), 2);?></td>
              <!-- <td style="background-color:bisque;"></td> -->
          </tr>
          <tr>
              <td><b>Non-Performing (Portfolio-At-Risk)</b></td>
              <td style=" text-align: center;"></td>
              <!-- <td style="background-color:bisque;"></td> -->
          </tr>
          <tr>
              <td>Pass & Watch</td>
              <!-- <td></td> -->
              <td style="background-color:bisque; text-align: center;"><?php echo number_format(round($pandw), 2);?></td>
          </tr>
          <tr>
              <td>Substandard</td>
              <!-- <td></td> -->
              <td style="background-color:bisque; text-align: center;"><?php echo number_format(round($sub), 2);?></td>
          </tr>
          <tr>
              <td>Doubtful</td>
              <!-- <td></td> -->
              <td style="background-color:bisque; text-align: center;"><?php echo number_format(round($doub), 2);?></td>
          </tr>
          <tr>
              <td>Lost</td>
              <!-- <td></td> -->
              <td style="background-color:bisque; text-align: center;"><?php echo number_format(round($los), 2);?></td>
          </tr>
          <tr>
              <td><b>Total (Portfolio-At-Risk)</b></td>
              <!-- <td></td> -->
              <td style="background-color:bisque; font-weight:bold; text-align: center;"><?php echo number_format(round($tpar), 2);?></td>
          </tr>
          <tr>
              <td>Interest In Suspense</td>
              <!-- <td></td> -->
              <td style="background-color:bisque; text-align: center;"><?php echo number_format(round($iis), 2);?></td>
          </tr>
          <tr>
              <td><b>Total</b></td>
              <!-- <td style="background-color:bisque;"></td> -->
              <?php
              $total = $performing + $tpar;
              ?>
              <td style="background-color:bisque; font-weight:bold; text-align: center;"><?php echo number_format(round($total), 2);?></td>
          </tr>
        </tbody>

      </table>

      <!-- <div class="form-group mt-4">
        <form method="POST" action="">
            <input hidden name="end" type="text" value="<?php echo $date; ?>" />
            <input hidden name="branch_id" type="text" value="<?php echo $branch_id; ?>" />
            <button type="submit" name="downloadPDF" class="btn btn-primary pull-left">Download PDF</button>
        </form>
      </div> -->

    </div>

  </div>
  
<?php
}
?>