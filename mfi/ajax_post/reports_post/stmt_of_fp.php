<?php
 include("../../../functions/connect.php");
 session_start();
 $out= '';
 $logo = $_SESSION['int_logo'];
$name = $_SESSION['int_name'];
$sessint_id = $_SESSION['int_id'];
$current = date('d/m/Y');
$gl_acc = "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id'";
$out = '</div>
<div class="card">
  <div class="card-body">
    <div style="margin:auto; text-align:center;">
    <img style="width:200px; height:200px;"src="'.$logo.'" alt="sf">
    <h2>'.$name.'</h2>
    <h4>STATEMENT OF FINANCIAL POSITION</h4>
    <h4></h4>
    <P>'.$current.'</P>
    </div>
  </div>
</div>
<div class="card">
  <div class="card-header card-header-primary">
    <h4 class="card-title">Assets</h4>
  </div>
  <div class="card-body">
    <table class="table">
      <thead>
        <th style="font-weight:bold;"></th>
        <th style="font-weight:bold;"></th>
        <th style="text-align: center; font-weight:bold;">2020 <br> &#x20A6</th>
        <th style="text-align: center; font-weight:bold;">2018 <br> &#x20A6</th>
      </thead>
      <tbody>
          <tr>
              <td></td>
              <td><b>Current Assets</b></td>
              <td></td>
              <td></td>
          </tr>
        <tr>
          <td></td>
          <td>Cash and Bank</td>
          <td style="text-align: center">4,436,527</td>
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
          <td><b>Prepaid Expenses</b></td>
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
            <td></td>
            <td></td>
            <td></td>
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
          <td>Leasehold</td>
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
          <td>Intangible Assets</td>
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
          <td><b>NBV</b></td>
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
    <h4 class="card-title">Liablities and Equity</h4>
  </div>
  <div class="card-body">
    <table class="table">
      <thead>
        <th style="font-weight:bold;">Codes</th>
        <th style="font-weight:bold;">GL Account</th>
        <th style="text-align: center; font-weight:bold;">2020 &#x20A6</th>
        <th style="text-align: center; font-weight:bold;">2018 &#x20A6</th>
      </thead>
      <tbody>
          <tr>
              <td></td>
              <td><b>Current Liabilities</b></td>
              <td></td>
              <td></td>
          </tr>
        <tr>
          <td></td>
          <td>Deposit Liablities</td>
          <td style="text-align: center">4,436,527</td>
          <td style="text-align: center">4,436,527</td>
        </tr>
        <tr>
          <td></td>
          <td>Trade and Other Payables</td>
          <td style="text-align: center">66,109,561</td>
          <td style="text-align: center">66,109,561</td>
        </tr>
        <tr>
          <td></td>
          <td><b>Total Current Liabilities</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
              <td></td>
              <td><b>Non-Current Liabilities</b></td>
              <td></td>
              <td></td>
          </tr>
        <tr>
          <td></td>
          <td>Unearned Income</td>
          <td style="text-align: center"></td>
          <td style="text-align: center"></td>
        </tr>
        <tr>
          <td></td>
          <td><b>Total Non-Current Liabilities</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
        </tr>
        <tr>
          <td></td>
          <td><b>Total Liabilities</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td><b>Shareholders Equity</b></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
          <td></td>
          <td>Share Capital</td>
          <td style="text-align: center">0</td>
          <td style="text-align: center">0</td>
        </tr>
        <tr>
          <td></td>
          <td>Retained Surplus</td>
          <td style="text-align: center"></td>
          <td style="text-align: center"></td>
        </tr>
        <tr>
          <td></td>
          <td><b>Total Shareholders Equity</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
          <td style="text-align: center"><b>70.456,088</b></td>
        </tr>
        <tr>
          <td></td>
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