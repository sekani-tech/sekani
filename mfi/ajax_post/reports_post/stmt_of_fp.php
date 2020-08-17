<?php
 include("../../../functions/connect.php");
 session_start();
 $out= '';
 $logo = $_SESSION['int_logo'];
$name = $_SESSION['int_full'];
$sessint_id = $_SESSION['int_id'];
$current = date('d/m/Y');

$start = $_POST['start'];
$starttime = strtotime($start);
$startd = date("F d, Y", $starttime);

$end = $_POST['end'];
$endtime = strtotime($end);
$current = date("F d, Y", $endtime);

$duefrom = mysqli_query($connection, "SELECT sum(organization_running_balance_derived) AS organization_running_balance_derived FROM acc_gl_account WHERE int_id = '$sessint_id' AND parent_id = '5'");
$otws = mysqli_fetch_array($duefrom);
$bank = $otws['organization_running_balance_derived'];

$cash = mysqli_query($connection, "SELECT sum(organization_running_balance_derived) AS organization_running_balance_derived FROM acc_gl_account WHERE int_id = '$sessint_id' AND parent_id = '1'");
$otss = mysqli_fetch_array($cash);
$cassh = $otss['organization_running_balance_derived'];
$cashbank = $cassh + $bank;
$out = '
<div class="card">
  <div class="card-header card-header-primary">
    <h4 class="card-title">Assets</h4>
  </div>
  <div class="card-body">
    <table class="table">
      <thead>
        <th style="font-weight:bold;"></th>
        <th style="font-weight:bold;"></th>
        <th style="text-align: center; font-weight:bold;">'.$current.' <br/>(NGN)</th>
        <th style="text-align: center; font-weight:bold;">'.$startd.' <br/>(NGN)</th>
      </thead>
      <tbody>
      <tr>
          <td></td>
          <td><b>ASSETS</b></td>
          <td style="text-align: center"></td>
          <td style="text-align: center"></td>
        </tr>
          <tr>
              <td></td>
              <td><b>Current Assets</b></td>
              <td></td>
              <td></td>
          </tr>
        <tr>
          <td></td>
          <td>Cash and Bank</td>
          <td style="text-align: center">'.$cashbank.'</td>
          <td style="text-align: center">4,436,527</td>
        </tr>
        <tr>
          <td></td>
          <td>Loans and Recievables</td>
          <td style="text-align: center">66,109,561</td>
          <td style="text-align: center">66,109,561</td>
        </tr>
        <tr>
          <td></td>
          <td>Inventory</td>
          <td style="text-align: center"></td>
          <td style="text-align: center"></td>
        </tr>
        <tr>
          <td></td>
          <td>Prepayment</td>
          <td style="text-align: center"></td>
          <td style="text-align: center"></td>
        </tr>
        <tr>
          <td></td>
          <td><b>Total Current Assets</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
        </tr>
        <tr>
              <td></td>
              <td><b>Non-Current Assets</b></td>
              <td></td>
              <td></td>
          </tr>
        <tr>
          <td></td>
          <td>Land and Building</td>
          <td style="text-align: center">0</td>
          <td style="text-align: center">0</td>
        </tr>
        <tr>
          <td></td>
          <td>Funiture and fittings</td>
          <td style="text-align: center">0</td>
          <td style="text-align: center">0</td>
        </tr>
        <tr>
          <td></td>
          <td>Motor Vehicles</td>
          <td style="text-align: center">0</td>
          <td style="text-align: center">0</td>
        </tr>
        <tr>
          <td></td>
          <td>Office Equipment</td>
          <td style="text-align: center">0</td>
          <td style="text-align: center">0</td>
        </tr>
        <tr>
          <td></td>
          <td>Plant and Machinery</td>
          <td style="text-align: center">0</td>
          <td style="text-align: center">0</td>
        </tr>
        <tr>
          <td></td>
          <td><b>Total Non-Current Assets</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
        </tr>
        <tr>
          <td></td>
          <td><b>Less: Accumulated Description</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
        </tr>
        <tr>
          <td></td>
          <td><b>NPV</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
        </tr>
        <tr>
          <td></td>
          <td><b>Total Asset</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="card">
  <div class="card-header card-header-primary">
    <h4 class="card-title">Liablities</h4>
  </div>
  <div class="card-body">
    <table class="table">
      <thead>
        <th style="font-weight:bold;">GL Account</th>
        <th style="text-align: center; font-weight:bold;">'.$start.' <br/>(NGN)</th>
        <th style="text-align: center; font-weight:bold;">'.$end.' <br/>(NGN)</th>
      </thead>
      <tbody>
      <tr>
              <td><b>LIABILITIES & EQUITY</b></td>
              <td></td>
              <td></td>
          </tr>
          <tr>
              <td><b>Current Liabilities</b></td>
              <td></td>
              <td></td>
          </tr>
        <tr>
          <td>Deposit Liablities</td>
          <td style="text-align: center">4,436,527</td>
          <td style="text-align: center">4,436,527</td>
        </tr>
        <tr>
          <td>Trade and Other Payables</td>
          <td style="text-align: center">66,109,561</td>
          <td style="text-align: center">66,109,561</td>
        </tr>
        <tr>
          <td><b>Total Current Liabilities</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
        </tr>
        <tr>
              <td><b>Non-Current Liabilities</b></td>
              <td></td>
              <td></td>
          </tr>
        <tr>
          <td>Unearned Income</td>
          <td style="text-align: center"></td>
          <td style="text-align: center"></td>
        </tr>
        <tr>
          <td><b>Total Non-Current Liabilities</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
        </tr>
        <tr>
          <td><b>Total Liabilities</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
        </tr>
        <tr>
            <td><b>Shareholders Equity</b></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
          <td> Authorised Share Capital</td>
          <td style="text-align: center">0</td>
          <td style="text-align: center">0</td>
        </tr>
        <tr>
          <td> Current Retained Earning</td>
          <td style="text-align: center"></td>
          <td style="text-align: center"></td>
        </tr>
        <tr>
          <td><b>Total Shareholders Equity</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
        </tr>
        <tr>
          <td><b>Total Liabilities and Shareholders Equity</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
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