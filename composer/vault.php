<?php
$output = '';
include("../functions/connect.php");
session_start();
?>
<?php
if (isset($_POST["start1"]) && isset($_POST["branch1"]) && isset($_POST["int_id1"]))
{
    $int_id = $_POST["int_id1"];
    if($_POST["start1"] != '')
    {
      $std = $_POST["start1"];
      $datex= strtotime($std); 
      $sdate = date("Y-m-d", $datex);
       $start = $sdate;
      //  echo $start;
       $endx = $_POST["end1"];
       $datey= strtotime($endx); 
       $eyd= date("Y-m-d", strtotime('+1 day', $datey));
       $end = $eyd;
       $branch_id = $_POST["branch1"];
       $teller = $_POST["teller1"];
       $int_name = $_SESSION["int_name"];
      //  check
    $branchquery = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch_id'");
    if (count([$branchquery]) == 1) {
      $ans = mysqli_fetch_array($branchquery);
      $branch = $ans['name'];
      $branch_email = $ans['email'];
      $branch_location = $ans['location'];
      $branch_phone = $ans['phone'];
    }
  }
  // End
   //  Always Check the vault
   if (count([$branchquery]) == 1) {
    // here we will some data
    $genb1 = mysqli_query($connection, "SELECT SUM(credit) AS credit FROM institution_account_transaction WHERE is_vault = '1' && branch_id = '$branch_id' && int_id ='$int_id' && transaction_date BETWEEN '$start' AND '$end'  ORDER BY transaction_date ASC");
    // then we will be fixing
    $genb = mysqli_query($connection, "SELECT SUM(debit) AS debit FROM institution_account_transaction WHERE is_vault = '1' && branch_id = '$branch_id' && int_id ='$int_id' && transaction_date BETWEEN '$start' AND '$end' ORDER BY transaction_date ASC");
    $m1 = mysqli_fetch_array($genb1);
    $m = mysqli_fetch_array($genb);
    // qwerty
    $tcp = $m1["credit"];
    $tdp = $m["debit"];
    // summing
    $famt = mysqli_query($connection, "SELECT * FROM int_vault WHERE int_id='$int_id'");
    $fx = mysqli_fetch_array($famt);
    $flamt =  $fx["balance"];
        $finalbal = number_format(($flamt), 2);
        $tcdp = number_format(round($tcp), 2);
        $tddp = number_format(round($tdp), 2);
    // total
    function fill_report($connection, $int_id, $start, $end, $branch_id)
    {

      $querytoget = mysqli_query($connection, "SELECT * FROM institution_account_transaction WHERE is_vault = '1' && branch_id = '$branch_id' && int_id ='$int_id' && transaction_date BETWEEN '$start' AND '$end' ORDER BY transaction_date ASC");

      $out = '';
      $q = mysqli_fetch_array($querytoget);

      while ($q = mysqli_fetch_array($querytoget))
      {
      // $transaction_type = $q["transaction_type"];
      $transaction_date = $q["transaction_date"];
      $camt = $q["credit"];
      $damt = $q["debit"];
      $balance = $q["running_balance_derived"];
      $description = $q["description"];
      $amt = $camt;
      $amt2 = $damt;
        
        $amt = number_format($amt, 2);
        
        $amt2 = number_format($amt2, 2);
      

        $out .= '
        <tr>
        <th>'.$transaction_date.'</th>
        <th>'.$description.'</th>
        <th>&#8358; '.$amt.'</th>
        <th>&#8358; '.$amt2.'</th>
        <th>&#8358; '.number_format($balance, 2).'</th>
        </tr>
      ';
      }
      return $out;
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
<h1>'.$_SESSION["int_name"].' - Vault transaction Report</h1>
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
  <th class="service">Date/Time</th>
    <th class="service">Account Name</th>
    <th class="desc">Deposit</th>
    <th>Withdrawal</th>
    <th>Balance</th>
  </tr>
</thead>
<tbody>
"'.fill_report($connection, $int_id, $start, $end, $branch_id).'"
<tr>
<th>Total</th>
<th></th>
 <th>&#8358; '.$tcdp.'</th>
 <th>&#8358; '.$tddp.'</th>
<th>&#8358; '.$finalbal.'</th>
</tr>
</tbody>
</table>
<div id="notices">
<div>Total Deposit: &#8358; '.$tcdp.' </div>
<br/>
<div>Total Withdrawal: &#8358; '.$tddp.'</div>
<br/>
<div>Current Balance: &#8358; '.$finalbal.'</div>
<br/>
<div>Teller Sign:__________________________________</div>
<br/>
<div id="company" class="clearfix">
Date:__________________________________
</div>
<br/>
<div>Checked by:__________________________________</div>
<br/>
<div id="company" class="clearfix">
Date and Sign:__________________________________
</div>
</div>
</main>
');
$file_name = 'Institution Transaction as at '.$end.'.pdf';
$mpdf->Output($file_name, 'D');
  } else {
    echo 'Not Seeing Data';
  }
    }
?>