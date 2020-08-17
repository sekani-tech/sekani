<?php
$output = '';
include("../functions/connect.php");
session_start();
?>
<?php
if (isset($_POST["start_date"]) && isset($_POST["end_date"]) && isset($_POST["int_id"]))
{
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];
    $branch_id = $_POST['branch_id'];
    $sessint_id = $_POST['int_id'];
    $onemonthly = $_POST['previous_month_date'];
    $current_interest_on_loans = $_POST['current_interest_on_loans'];
    $previous_interest_on_loans = $_POST['previous_interest_on_loans'];
    $total_current_fees = $_POST['total_current_fees'];
    $total_previous_fees = $_POST['total_previous_fees'];
    $current_liabilities = $_POST['current_liabilities'];
    $previous_liabilities = $_POST['previous_liabilities'];
    $current_net_interest_on_income = $_POST['current_net_interest_on_income'];
    $previous_net_interest_on_income = $_POST['previous_net_interest_on_income'];
    $current_charge_income = $_POST['current_charge_income'];
    $previous_charge_income = $_POST['previous_charge_income'];
    $current_total_revenue = $_POST['current_total_revenue'];
    $previous_total_revenue = $_POST['previous_total_revenue'];
    $current_total_operating_expense = $_POST['current_total_operating_expense'];
    $previous_total_operating_expense = $_POST['previous_total_operating_expense'];
    $current_net_profit_from_operation = $_POST['current_net_profit_from_operation'];
    $previous_net_profit_from_operation = $_POST['previous_net_profit_from_operation'];
    $profit_current_year = $_POST['profit_current_year'];
    $profit_previous_year = $_POST['profit_previous_year'];
    $onemontstart = $_POST['prev_month_start'];

    $time = strtotime($end);
    $curren = date("F d, Y", $time);
    $onemonth = date("F d, Y", strtotime("-1 month", $time));

    $branchquery = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch_id'");
    if (count([$branchquery]) == 1) {
      $ans = mysqli_fetch_array($branchquery);
      $branch = $ans['name'];
      $branch_email = $ans['email'];
      $branch_location = $ans['location'];
      $branch_phone = $ans['phone'];
    }
    // loop for charges
    function fill_charge($connection, $sessint_id, $start, $onemontstart, $end, $onemonthly)
{
  $stateg = "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND classification_enum = '4' AND gl_code !='80010000'";
  $state1 = mysqli_query($connection, $stateg);
  $outxx = '';
  while ($row = mysqli_fetch_array($state1))
  {
    $namde = $row['name'];

    $glcode = $row['gl_code'];

    $opbalance = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id = '$sessint_id' AND gl_code = '$glcode' AND transaction_date BETWEEN '$start' AND '$end' ORDER BY id DESC LIMIT 1";
    $fodf = mysqli_query($connection, $opbalance);
      $n = mysqli_fetch_array($fodf);
      if(isset($n['credit'])){
      $endbal = number_format($n['credit'], 2);
      }else{
        $endbal = "0.00";
      }
    
    $fdf = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id = '$sessint_id' AND gl_code = '$glcode' AND transaction_date BETWEEN '$onemontstart' AND '$onemonthly' ORDER BY id DESC LIMIT 1";
    $ss = mysqli_query($connection, $fdf);
      $u = mysqli_fetch_array($ss);
      if(isset($u['credit'])){
      $lastmon = number_format($u['credit'], 2);
      }
      else{
        $lastmon = "0.00";
      }
if($endbal == '0.00' && $lastmon == '0.00'){
  $outxx .= '';
}
else{
  $outxx .= '
  <tr>
  <td>'.$namde.'</td>
  <td style="text-align: center">'.$endbal.'</td>
  <td style="text-align: center">'.$lastmon.'</td>
</tr>
';
}

  }
return $outxx;
}
    function fill_operation($connection, $sessint_id, $start, $onemontstart, $end, $onemonthly)
{
  $stateg = "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND parent_id !='0' AND classification_enum ='5' ORDER BY name ASC";
  $state1 = mysqli_query($connection, $stateg);
  $outxx = '';
  while ($row = mysqli_fetch_array($state1))
  {
    $namde = $row['name'];

    $glcode = $row['gl_code'];

    $opbalance = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id = '$sessint_id' AND gl_code = '$glcode' AND transaction_date BETWEEN '$start' AND '$end' ORDER BY id DESC LIMIT 1";
    $fodf = mysqli_query($connection, $opbalance);
      $n = mysqli_fetch_array($fodf);
      if(isset($n)){
      $endbal = number_format($n['credit'], 2);
      }else{
        $endbal = "0.00";
      }
    
    $fdf = "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE int_id = '$sessint_id' AND gl_code = '$glcode' AND transaction_date BETWEEN '$onemontstart' AND '$onemonthly' ORDER BY id DESC LIMIT 1";
    $ss = mysqli_query($connection, $fdf);
      $u = mysqli_fetch_array($ss);
      if(isset($u)){
      $lastmon = number_format($u['credit'], 2);
      }
      else{
        $lastmon = "0.00";
      }
if($endbal == '0.00' && $lastmon == '0.00'){
  $outxx .= '';
}
else{
  $outxx .= '
  <tr>
  <td>'.$namde.'</td>
  <td style="text-align: center">'.$endbal.'</td>
  <td style="text-align: center">'.$lastmon.'</td>
</tr>';
}
  }
return $outxx;
}
    // NOTHIG
require_once __DIR__ . '/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf();
$mpdf->SetWatermarkImage(''.$_SESSION["int_logo"].'');
$mpdf->showWatermarkImage = true;
$mpdf->WriteHTML('<link rel="stylesheet" media="print" href="pdf/style.css" media="all"/>
<header class="clearfix">
<div id="logo">
  <img src="'.$_SESSION["int_logo"].'" height="80" width="80">
</div>
<h1>'.$_SESSION["int_name"].' - Statement of Income</h1>
<div id="company" class="clearfix">
  <div>'.$branch.'</div>
  <div>'.$branch_location.'</div>
  <div>(+234) '.$branch_phone.'</div>
  <div><a href="mailto:'.$branch_email.'">'.$branch_email.'</a></div>
</div>
<div id="project">
  <div><span>BRANCH</span> '.$branch.' </div>
  <div><span>FROM</span> '.$start.'</div>
  <div><span>AS AT</span> '.$end.'</div>
</div>
</header>
<main>
    <table>
    <thead>
    <tr>
    <th>GL Account</th>
    <th>'.$curren.'<br/>(NGN)</th>
    <th>'.$onemonth.'<br/>(NGN)</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="height:35px;"><b>Interest Income:</b></td>
        <td style="height:35px;">'.number_format($current_interest_on_loans).'</td>
        <td style="height:35px;">'.number_format($previous_interest_on_loans).'</td>
      </tr>
      <tr>
        <td style="height:35px;">Less interest Expense:</td>
        <td style="height:35px;">'.number_format($current_liabilities).'</td>
        <td style="height:35px;">'.number_format($previous_liabilities).'</td>
      </tr>
      <tr>
        <td style="height:35px;"><b>NET INTEREST INCOME</b></td>
        <td style="height:35px;" ><b>'.number_format($current_net_interest_on_income).'</b></td>
        <td style="height:35px;" ><b>'.number_format($previous_net_interest_on_income).'</b></td>
      </tr>
      <tr>
        <td style="height:35px;"><b>Services fees, fines and penalties</b></td>
        <td style="height:35px;"></td>
        <td style="height:35px;"></td>
      </tr>
      '.fill_charge($connection, $sessint_id, $start, $onemontstart, $end, $onemonthly).'
      <tr>
        <td style="height:35px;"><b>SUB TOTAL INCOME</b></td>
        <td style="height:35px;"><b>'.number_format($total_current_fees).'</b></td>
        <td style="height:35px;"><b>'.number_format($total_previous_fees).'</b></td>
      </tr>
      <tr>
        <td style="height:35px;">Other services and other income</td>
        <td style="height:35px;">0.00</td>
        <td style="height:35px;">0.00</td>
      </tr>
      <tr>
        <td style="height:35px;"><b>GROSS OPERATING INCOME</b></td>
        <td style="height:35px;" ><b>'.number_format($current_total_revenue).'</b></td>
        <td style="height:35px;" ><b>'.number_format($previous_total_revenue).'</b></td>
      </tr>
    </tbody>
    </table>
    <table>
    <thead>
    <tr>
      <th>GL Account</th>
      <th >'.$curren.' <br/>(NGN)</th>
      <th >'.$onemonth.' <br/>(NGN)</th>
      </tr>
    </thead>
    <tbody>
    '.fill_operation($connection, $sessint_id, $start, $onemontstart, $end, $onemonthly).'
    <tr>
        <td style="height:35px;">SUB TOTAL EXPENSE</td>
        <td style="height:35px;"><b>'.number_format($current_total_operating_expense).'</b></td>
        <td style="height:35px;"><b>'.number_format($previous_total_operating_expense).'</b></td>
      </tr>
      <tr>
        <td style="height:35px;"><b>GROSS PROFIT/(LOSS) FROM OPERATIONS</td>
        <td style="height:35px;"><b>'.number_format($current_net_profit_from_operation).'</b></td>
        <td style="height:35px;"><b>'.number_format($previous_net_profit_from_operation).'</b></td>
      </tr>
      <tr>
        <td style="height:35px;">Depreciation</td>
        <td style="height:35px;">0.00</td>
        <td style="height:35px;">0.00</td>
      </tr>
      <tr>
        <td style="height:35px;">Income Tax</td>
        <td style="height:35px;">0.00</td> 
        <td style="height:35px;">0.00</td>
      </tr>
      <tr>
        <td style="height:35px;"><b>NET PROFIT/(LOSS) FOR THE YEAR</b></td>
        <td style="height:35px;"><b>'.number_format($profit_current_year).'</b></td>
        <td style="height:35px;"><b>'.number_format($profit_previous_year).'</b></td>
      </tr>
    </tbody>
    </table>
</main>
');
$file_name = ''.$_SESSION["int_name"].' Statement of income '.$curren.'.pdf';
$mpdf->Output($file_name, 'D');
    }
?>