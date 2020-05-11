<?php
$output = '';
include("../functions/connect.php");
session_start();
?>
<?php
if (isset($_POST["start1"]) && isset($_POST["branch1"]) && isset($_POST["teller1"]) && isset($_POST["int_id1"]))
{
    $int_id = $_POST["int_id1"];
    if($_POST["start1"] != '' && $_POST["teller1"] != '')
    {
      $start = $_POST["start1"];
      $std = date("Y-M-d",strtotime($start));
       $end = $_POST["end1"];
       $etd = date("Y-M-d",strtotime($end));
       $branch = $_POST["branch1"];
       $teller = $_POST["teller1"];
       $int_name = $_SESSION["int_name"];
      //  check
      $query = mysqli_query($connection, "SELECT * FROM tellers WHERE name ='$teller' && int_id='$int_id' && branch_id = '$branch'");
  if (count([$query]) == 1) {
    $ans = mysqli_fetch_array($query);
    $id = $ans['id'];
    $int_id = $ans['int_id'];
    $tell_name = $ans['description'];
    $postlimit = $ans['post_limit'];
    $tellerno = $ans['till_no'];
    $tillno = $ans['till'];
    $startdate = $ans['valid_from'];
    $endate = $ans['valid_to'];
    $branch_id = $ans['branch_id'];
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
   if (count([$query]) == 1 && count([$branchquery]) == 1) {
    // here we will some data
    $genb1 = mysqli_query($connection, "SELECT SUM(credit) AS credit FROM institution_account_transaction WHERE teller_id = '$teller' && int_id = '$int_id' && branch_id = '$branch_id' && transaction_date >= '$start' AND transaction_date <= '$end' ORDER BY id ASC");
    // then we will be fixing
    $genb = mysqli_query($connection, "SELECT SUM(debit) AS debit FROM institution_account_transaction WHERE teller_id = '$teller' && int_id = '$int_id' && branch_id = '$branch_id' && transaction_date >= '$start' AND transaction_date <= '$end' ORDER BY id ASC");
    $m1 = mysqli_fetch_array($genb1);
    $m = mysqli_fetch_array($genb);
    // qwerty
    $tcp = $m1["credit"];
    $tdp = $m["debit"];
    // summing
    $finalbal = number_format(($tcp - $tdp), 2);
    $tcdp = number_format(round($tcp), 2);
    $tddp = number_format(round($tdp), 2);
    // total
    function fill_report($connection, $int_id, $start, $end, $branch_id, $teller)
    {
      // import
      $querytoget = mysqli_query($connection, "SELECT * FROM institution_account_transaction WHERE teller_id = '$teller' && int_id = '$int_id' && branch_id = '$branch_id' && transaction_date >= '$start' AND transaction_date <= '$end' ORDER BY id ASC");
      // $q = mysqli_fetch_array($querytoget);
      $out = '';
        
      
      while ($q = mysqli_fetch_array($querytoget))
      {
        $client_id = $q["client_id"];
        $client_query = mysqli_query($connection, "SELECT * FROM client WHERE id = '$client_id' && int_id = '$int_id'");
        $nx = mysqli_fetch_array($client_query);
        
      // wertyui
      $client_name = $nx["firstname"]." ".$nx["middlename"]." ".$nx["lastname"];
      // qwert
      $transact_id = $q["transaction_id"];
      $transaction_type = $q["transaction_type"];
      $transaction_date = $q["transaction_date"];
      $camt = $q["credit"];
      $damt = $q["debit"];
      $balance = $q["running_balance_derived"];
     //  test
      $teller_id = $q["teller_id"];
      $teller_run_bal = $q["running_balance_derived"];
      // the next
      if ($transaction_type == "vault_in") {
        $client_name = "Valut In";
        $amt = number_format($damt, 2);
      }
      if ($transaction_type == "valut_out") {
        $client_name = "Valut Out";
        $amt = number_format($camt, 2);
      }
      $amt = $camt;
      $amt2 = $damt;
        
        $amt = number_format($amt, 2);
        
        $amt2 = number_format($amt2, 2);
      

        $out .= '
        <tr>
        <th>'.$client_name.'</th>
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
$mpdf->WriteHTML('<link rel="stylesheet" media="print" href="pdf/style.css" media="all"/>
<header class="clearfix">
<div id="logo">
  <img src="'.$_SESSION["int_logo"].'" height="80" width="80">
</div>
<h1>'.$_SESSION["int_name"].' - Call Over Report</h1>
<div id="company" class="clearfix">
  <div>'.$branch.'</div>
  <div>'.$branch_location.'</div>
  <div>(+234) '.$branch_phone.'</div>
  <div><a href="mailto:'.$branch_email.'">'.$branch_email.'</a></div>
</div>
<div id="project">
  <div><span>TELLER NAME</span> '.$tell_name.'</div>
  <div><span>BRANCH</span> '.$branch.' </div>
  <div><span>FROM</span> '.$std.'</div>
  <div><span>AS AT</span> '.$etd.'</div>
</div>
</header>
<main>
<table>
<thead>
  <tr>
    <th class="service">Account Name</th>
    <th class="desc">Deposit</th>
    <th>Withdrawal</th>
    <th>Balance</th>
  </tr>
</thead>
<tbody>
"'.fill_report($connection, $int_id, $start, $end, $branch_id, $teller).'"
<tr>
<th>Total</th>
 <th>&#8358; '.$tcdp.'</th>
 <th>&#8358; '.$tddp.'</th>
<th>&#8358; '.$finalbal.'</th>
</tr>
</tbody>
</table>
<div id="notices">
<div>Opening Balance: </div>
<br/>
<div>Total Deposit: &#8358; '.$tcdp.' </div>
<br/>
<div>Total Withdrawal: &#8358; '.$tddp.'</div>
<br/>
<div>Closing Balance: &#8358; '.$finalbal.'</div>
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
$mpdf->Output();
  } else {
    echo 'Not Seeing Data';
  }
  // if it
    }
  }
?>