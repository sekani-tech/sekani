<?php
 include("../../../functions/connect.php");
 session_start();
 $out= '';
 $logo = $_SESSION['int_logo'];
$name = $_SESSION['int_name'];
$sessint_id = $_SESSION['int_id'];
$current = date('d/m/Y');

// Operating Revenue Data
$gl_acc_exec = mysqli_query($connection, "SELECT sum(organization_running_balance_derived) AS organization_running_balance_derived FROM acc_gl_account WHERE int_id = '$sessint_id' AND parent_id = '54'");
$gl = mysqli_fetch_array($gl_acc_exec);
$interest_income = $gl['organization_running_balance_derived'];

$service_fee = mysqli_query($connection, "SELECT sum(organization_running_balance_derived) AS organization_running_balance_derived FROM acc_gl_account WHERE int_id = '$sessint_id' AND parent_id = '198'");
$fe = mysqli_fetch_array($service_fee);
$fee = $fe['organization_running_balance_derived'];


$gl_acc_exec = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '90013000'");
$gl = mysqli_fetch_array($gl_acc_exec);
$burrowing = $gl['organization_running_balance_derived'];

$other_fee = mysqli_query($connection, "SELECT sum(organization_running_balance_derived) AS organization_running_balance_derived FROM acc_gl_account WHERE int_id = '$sessint_id' AND parent_id = '62'");
$ot = mysqli_fetch_array($other_fee);
$other = $ot['organization_running_balance_derived'];

$netintincome = $interest_income - $burrowing;
$ttlincome = $netintincome + $fee + $other;

// Operating Expenses data. If a better, more compact form of arranging this data is available, please feel free to edit.
$salary = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '90021000'");
$sl = mysqli_fetch_array($salary);
$salaries = $sl['organization_running_balance_derived'];

$fuel = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '90042000'");
$fl = mysqli_fetch_array($fuel);
$fueling = $fl['organization_running_balance_derived'];

$trans = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '90044000'");
$tl = mysqli_fetch_array($trans);
$transportation = $tl['organization_running_balance_derived'];

$office = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '90041000'");
$ol = mysqli_fetch_array($office);
$office_rent = $ol['organization_running_balance_derived'];

$print = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '90047000'");
$pl = mysqli_fetch_array($print);
$printing = $pl['organization_running_balance_derived'];

$electro = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '90043000'");
$el = mysqli_fetch_array($electro);
$electricity = $el['organization_running_balance_derived'];

$prof = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '90054000'");
$rl = mysqli_fetch_array($prof);
$profession = $rl['organization_running_balance_derived'];

$sub = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '90051000'");
$sul = mysqli_fetch_array($sub);
$subscribe = $sul['organization_running_balance_derived'];

$repau = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '57703'");
$rl = mysqli_fetch_array($repau);
$repairs = $rl['organization_running_balance_derived'];

$general = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '90049300'");
$grl = mysqli_fetch_array($general);
$general = $grl['organization_running_balance_derived'];

$bank = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '90061000'");
$bl = mysqli_fetch_array($bank);
$burrowing = $bl['organization_running_balance_derived'];

$gl_acc_exec = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '90013000'");
$gl = mysqli_fetch_array($gl_acc_exec);
$burrowing = $gl['organization_running_balance_derived'];

$gl_acc_exec = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '90013000'");
$gl = mysqli_fetch_array($gl_acc_exec);
$burrowing = $gl['organization_running_balance_derived'];

$gl_acc_exec = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '90013000'");
$gl = mysqli_fetch_array($gl_acc_exec);
$burrowing = $gl['organization_running_balance_derived'];

$gl_acc_exec = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '90013000'");
$gl = mysqli_fetch_array($gl_acc_exec);
$burrowing = $gl['organization_running_balance_derived'];

$gl_acc_exec = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '90013000'");
$gl = mysqli_fetch_array($gl_acc_exec);
$burrowing = $gl['organization_running_balance_derived'];

$out = '';
$out = '<div class="card">
<div class="card-body">
  <div style="margin:auto; text-align:center;">
  <img style="height: 200px; width:200px;"src="'.$logo.'" alt="sf">
  <h2>'.$name.'</h2>
  <h4>Statement of Income</h4>
  <h4></h4>
  <P>'.$current.'</P>
  </div>
</div>
</div>
<div class="card">
<div class="card-header card-header-primary">
  <h4 class="card-title">Operating Revenue</h4>
</div>
<div class="card-body">
  <table class="table">
    <thead>
      <th style="font-weight:bold;">Codes</th>
      <th style="font-weight:bold;">GL Account</th>
      <th style="text-align: center; font-weight:bold;">2019 <br/>(NGN)</th>
      <th style="text-align: center; font-weight:bold;">2020 <br/>(NGN)</th>
    </thead>
    <tbody>
      <tr>
        <td></td>
        <td>Interest on Loans:</td>
        <td style="text-align: center">'.number_format($interest_income).'</td>
        <td style="text-align: center">23,809,347</td>
      </tr>
      <tr>
        <td></td>
        <td>Less interest on borrowings and deposit liabilities:</td>
        <td style="text-align: center">'.number_format($burrowing).'</td>
        <td style="text-align: center">3,605,801</td>
      </tr>
      <tr>
        <td></td>
        <td><b>Net Interest Income</b></td>
        <td style="text-align: center"><b>'.number_format($netintincome).'</b></td>
        <td style="text-align: center"><b>20,203,547</b></td>
      </tr>
      <tr>
        <td></td>
        <td>Services fees, fines and penalties</td>
        <td style="text-align: center">'.number_format($fee).'</td>
        <td style="text-align: center">6,694,511</td>
      </tr>
      <tr>
        <td></td>
        <td>Other services and other income</td>
        <td style="text-align: center">'.number_format($other).'</td>
        <td style="text-align: center">491,685</td>
      </tr>
      <tr>
        <td></td>
        <td><b>Total Income</b></td>
        <td style="text-align: center"><b>'.number_format($ttlincome).'</b></td>
        <td style="text-align: center"><b>27,389,742</b></td>
      </tr>
    </tbody>
  </table>
</div>
</div>
<div class="card">
<div class="card-header card-header-primary">
  <h4 class="card-title">Operating Expenses</h4>
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
        <td>Salaries, Wages and Allowances</td>
        <td style="text-align: center">15,586,836</td>
        <td style="text-align: center">15,586,836</td>
      </tr>
      <tr>
        <td></td>
        <td>Fueling and Lubricant</td>
        <td style="text-align: center">724,350</td>
        <td style="text-align: center">724,350</td>
      </tr>
      <tr>
        <td></td>
        <td>Transport and Traveling</td>
        <td style="text-align: center">2,667,200</td>
        <td style="text-align: center">2,667,200</td>
      </tr>
      <tr>
        <td></td>
        <td>Office Rent</td>
        <td style="text-align: center">1,290,000</td>
        <td style="text-align: center">1,290,000</td>
      </tr>
      <tr>
        <td></td>
        <td>Printing and Stationaries</td>
        <td style="text-align: center">504,600</td>
        <td style="text-align: center">504,600</td>
      </tr>
      <tr>
        <td></td>
        <td>Electricity and other unilities expenses</td>
        <td style="text-align: center">504,600</td>
        <td style="text-align: center">504,600</td>
      </tr>
      <tr>
        <td></td>
        <td>Professional and Consultancy fee</td>
        <td style="text-align: center">504,600</td>
        <td style="text-align: center">504,600</td>
      </tr>
      <tr>
        <td></td>
        <td>Annual Subscription</td>
        <td style="text-align: center">504,600</td>
        <td style="text-align: center">504,600</td>
      </tr>
      <tr>
        <td></td>
        <td>Traffic and Vehicle Repairs</td>
        <td style="text-align: center">504,600</td>
        <td style="text-align: center">504,600</td>
      </tr>
      <tr>
        <td></td>
        <td>General Repairs and Maintenance</td>
        <td style="text-align: center">504,600</td>
        <td style="text-align: center">504,600</td>
      </tr>
      <tr>
        <td></td>
        <td>Bank Charges</td>
        <td style="text-align: center">504,600</td>
        <td style="text-align: center">504,600</td>
      </tr>
      <tr>
        <td></td>
        <td>Public Relations</td>
        <td style="text-align: center">504,600</td>
        <td style="text-align: center">504,600</td>
      </tr>
      <tr>
        <td></td>
        <td>Hotel and Lodging</td>
        <td style="text-align: center">504,600</td>
        <td style="text-align: center">504,600</td>
      </tr>
      <tr>
        <td></td>
        <td>Bad debt Written Off</td>
        <td style="text-align: center">504,600</td>
        <td style="text-align: center">504,600</td>
      </tr>
      <tr>
        <td></td>
        <td>Security & Sanition</td>
        <td style="text-align: center">504,600</td>
        <td style="text-align: center">504,600</td>
      </tr>
      <tr>
        <td></td>
        <td>Miscelious Expense</td>
        <td style="text-align: center">504,600</td>
        <td style="text-align: center">504,600</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td style="text-align: center"><b> 25,445,674</b></td>
        <td style="text-align: center"><b> 25,445,674</b></td>
      </tr>
      <tr>
        <td></td>
        <td style="font-weight:bold;">NET SURPLUS FROM OPERATIONS</td>
        <td style="font-weight:bold; text-align: center"> 1,944,068 </td>
        <td style="font-weight:bold; text-align: center">1,944,068</td>
      </tr>
      <tr>
        <td></td>
        <td>Depreciation</td>
        <td style="text-align: center">1,429,000</td>
        <td style="text-align: center">1,429,000</td>
      </tr>
      <tr>
        <td></td>
        <td>Income Tax</td>
        <td style="text-align: center">139,700</td>
        <td style="text-align: center">139,700</td>
      </tr>
      <tr>
        <td></td>
        <td style="font-weight:bold;">SURPLUS FOR THE YEAR</td>
        <td style="font-weight:bold; text-align: center">  375,368  </td>
        <td style="font-weight:bold; text-align: center">375,368</td>
      </tr>
    </tbody>
  </table>
</div>
</div>
<!--//report ends here -->
<div class="card">
 <div class="card-body">
  <a href="" class="btn btn-primary">Print</a>
 </div>
</div>
</div>';
echo $out;
?>