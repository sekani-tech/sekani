<?php
$output = '';
include("../functions/connect.php");
session_start();
?>
<?php
if(isset($_POST["start"]) && isset($_POST["end"])){
  $std = $_POST["start"];
  $endx = $_POST["end"];
  $glcode = $_POST["gl_acc"];
  $branch_id = $_POST["branch"];
  // $staff = $_POST["staff"];
  $int_id = $_SESSION['int_id'];
        $querytoxxget = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE branch_id = '$branch_id' AND gl_code = '$glcode' AND int_id ='$int_id'");
        $q = mysqli_fetch_array($querytoxxget);
        $glname = $q['name'];
        $finalbal = $q['organization_running_balance_derived'];

        $qut = mysqli_query($connection, "SELECT SUM(credit) AS credit FROM gl_account_transaction WHERE branch_id = '$branch_id' AND gl_code = '$glcode' AND int_id ='$int_id' AND transaction_date BETWEEN '$std' AND '$endx' ORDER BY transaction_date ASC");
        $e = mysqli_fetch_array($qut);
        $tcdp = $e['credit'];

        $qust = mysqli_query($connection, "SELECT SUM(debit) AS debit FROM gl_account_transaction WHERE branch_id = '$branch_id' AND gl_code = '$glcode' AND int_id ='$int_id' AND transaction_date BETWEEN '$std' AND '$endx' ORDER BY transaction_date ASC");
        $ea = mysqli_fetch_array($qust);
        $tddp = $ea['debit'];



  function fill_report($connection, $int_id, $std, $glcode, $endx, $branch_id)
        {
            $out = '';
          // import
        //   $glcode = $_POST['glcode'];
          $querytoget = mysqli_query($connection, "SELECT * FROM gl_account_transaction WHERE branch_id = '$branch_id' AND gl_code = '$glcode' AND int_id ='$int_id' AND transaction_date BETWEEN '$std' AND '$endx' ORDER BY transaction_date ASC");
          while ($q = mysqli_fetch_array($querytoget, MYSQLI_ASSOC))
          {

          $transaction_date = $q["transaction_date"];
          $camt = $q["credit"];
          $damt = $q["debit"];
          $balance = $q["gl_account_balance_derived"];
          $description = $q['description'];
          $amt = $camt;
          $amt2 = $damt;
            
            $amt = number_format($amt, 2);
            
            $amt2 = number_format($amt2, 2);
          

            $out .= '
            <tr>
            <th>'.$transaction_date.'</th>
            <th>'.$description.'</th>
            <th>'.$amt.'</th>
            <th>'.$amt2.'</th>
            <th>'.number_format($balance, 2).'</th>
            </tr>
          ';
          }
        // }
          return $out;
        }
  require_once __DIR__ . '/vendor/autoload.php';
  $mpdf = new \Mpdf\Mpdf();
  $mpdf->SetWatermarkImage(''.$_SESSION["int_logo"].'');
  $mpdf->showWatermarkImage = true;
  $mpdf->WriteHTML('<link rel="stylesheet" media="print" href="pdf/style.css" media="all"/>
  <header class="clearfix">
  <div id="logo">
    <img src="'.$_SESSION["int_logo"].'" height="80" width="80">
  </div>
  <h1>General Ledger Report As at '.$endx.'</h1>
  </header>
  <main>
  <table>
  <thead class=" text-primary">
  <tr>
      <tr>
      <th>
      Date/Time
      </th>
      <th>
       Description
      </th>
      <th>
       Deposit
      </th>
      <th>
        Withdrawal
      </th>
      <th>
        Balance
      </th>
      </tr>
    </thead>
  <tbody>
  "'.fill_report($connection, $int_id, $std, $glcode, $endx, $branch_id).'"
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
  $file_name = 'General Ledger Report for '.$glname.'-'.$glcode.'.pdf';
  $mpdf->Output($file_name, 'D');
    }
    else {
      echo 'Not Seeing Data';
    }
?>