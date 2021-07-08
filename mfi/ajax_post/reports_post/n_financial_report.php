<?php
 include("../../../functions/connect.php");
 session_start();
 $out= '';
// Declaring Variables
$sessint_id = $_SESSION['int_id'];
$current = date('d/m/Y');
$start = $_POST['start'];
$end = $_POST['end'];
$branch_id = $_POST['branch'];

// To get branch name
$diud = mysqli_query($connection, "SELECT * FROM branch WHERE id = '$branch_id'");
$br = mysqli_fetch_array($diud);
$branchname = $br['name'];

// To get all dates in the specific format required
$time = strtotime($end);
$curren = date("F d, Y", $time);
$prevyear = date("F d, Y", strtotime("-1 year", $time));
$prevmyear = date("Y-m-d", strtotime("-1 year", $time));

// for number of active clients current year
$dfd = mysqli_query($connection, "SELECT * FROM client WHERE int_id = '$sessint_id' AND status = 'Approved' AND submittedon_date < '$end'");
$sds = mysqli_num_rows($dfd);

// for number active clients last year
$dfddk = mysqli_query($connection, "SELECT * FROM client WHERE int_id = '$sessint_id' AND status = 'Approved' AND submittedon_date < '$prevmyear'");
$sodds = mysqli_num_rows($dfddk);

// for number of clients within current time
$jfjf = mysqli_query($connection, "SELECT * FROM client WHERE int_id = '$sessint_id' AND status = 'Approved' AND (submittedon_date BETWEEN '$start' AND '$end')");
$rod = mysqli_num_rows($jfjf);

// for number of clients between this year and last
$sdsd = mysqli_query($connection, "SELECT * FROM client WHERE int_id = '$sessint_id' AND status = 'Approved' AND (submittedon_date BETWEEN '$prevmyear' AND '$end')");
$yer = mysqli_num_rows($sdsd);

// For number of active burrowers current year
$wpoc = mysqli_query($connection, "SELECT * FROM client WHERE int_id = '$sessint_id' AND status = 'Approved' AND loan_status = 'ACTIVE' AND (submittedon_date BETWEEN '$start' AND '$end')");
$bur = mysqli_num_rows($wpoc);

// For number of active burrowers last year
$erut = mysqli_query($connection, "SELECT * FROM client WHERE int_id = '$sessint_id' AND status = 'Approved' AND loan_status = 'ACTIVE' AND (submittedon_date BETWEEN '$prevmyear' AND '$end')");
$las = mysqli_num_rows($erut);

// For number of personnel
$erut = mysqli_query($connection, "SELECT * FROM staff WHERE int_id = '$sessint_id' AND employee_status = 'Employed' AND (submittedon_date BETWEEN '$prevmyear' AND '$end')");
$las = mysqli_num_rows($erut);


$out = '
<div class="card">
  <div class="card-header card-header-primary">
    <h4 class="card-title">Operational Data</h4>
  </div>
  <div class="card-body">
  <input type="text" readonly value="'.$branchname.'" name="" id="start" class="form-control">
    <table class="table">
      <thead>
        <th style="font-weight:bold;"></th>
        <th style="text-align: center; font-weight:bold;">'.$curren.'<br/>(NGN)</th>
        <th style="text-align: center; font-weight:bold;">'.$prevyear.'<br/>(NGN)</th>
      </thead>
      <tbody>
          <tr>
              <td>Number of active clients</td>
              <td style="text-align: center">'.$sds.'</td>
              <td style="text-align: center">'.$sodds.'</td>
          </tr>
        <tr>
          <td>Number Of new clients during period</td>
          <td style="text-align: center">'.$rod.'</td>
          <td style="text-align: center">'.$yer.'</td>
        </tr>
        <tr>
          <td>Number of active burrowers</td>
          <td style="text-align: center">'.$bur.'</td>
          <td style="text-align: center">'.$las.'</td>
        </tr>
        <tr>
          <td>Number of voluntary depositors</td>
          <td style="text-align: center"></td>
          <td style="text-align: center"></td>
        </tr>
        <tr>
          <td>Number of deposit Accounts</td>
          <td style="text-align: center"></td>
          <td style="text-align: center"></td>
        </tr>
        <tr>
          <td>Number of savers facilitates</td>
          <td style="text-align: center"><b>70.456,088</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
        </tr>
        <tr>
            <td>Number of Personnel</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
              <td>Number of Loan Officers</td>
              <td></td>
              <td></td>
          </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="card">
  <div class="card-header card-header-primary">
    <h4 class="card-title">Macroeconomic Data</h4>
  </div>
  <div class="card-body">
    <table class="table">
      <thead>
        <th style="font-weight:bold;"></th>
        <th style="text-align: center; font-weight:bold;">'.$curren.'<br/>(NGN)</th>
        <th style="text-align: center; font-weight:bold;">'.$prevyear.'<br/>(NGN)</th>
      </thead>
      <tbody>
          <tr>
              <td>Inflation Rate</td>
              <td></td>
              <td></td>
          </tr>
        <tr>
          <td>Market Rate for Burrower</td>
          <td style="text-align: center">4,436,527</td>
          <td style="text-align: center">4,436,527</td>
        </tr>
        <tr>
          <td>Gross National Income for Capital</td>
          <td style="text-align: center">66,109,561</td>
          <td style="text-align: center">66,109,561</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<!--//report ends here -->
<div class="card">
   <div class="card-body">
    <a href="" class="btn btn-primary">Back</a>
    <a href="" class="btn btn-success btn-left">Print</a>
   </div>
 </div> ';
 echo $out;
?>