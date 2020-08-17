<?php
$output = '';
include("../functions/connect.php");
session_start();
?>
<?php
  $intname = $_SESSION['int_name'];
  $branch_id = $_SESSION["branch_id"];
  $date = date('d/m/Y');
  // $staff = $_POST["staff"];
  $branchquery = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch_id'");
    if (count([$branchquery]) == 1) {
      $ans = mysqli_fetch_array($branchquery);
      $branch = $ans['name'];
      $branch_email = $ans['email'];
      $branch_location = $ans['location'];
      $branch_phone = $ans['phone'];
    }
    $current = date('Y-m-d');
  function fill_report($connection)
        {
            $out = '';
            $sessint_id = $_SESSION['int_id'];
          // import
        //   $glcode = $_POST['glcode'];

        $query = "SELECT * FROM loan_arrear WHERE int_id = '$sessint_id' AND installment = '1'";
        $result = mysqli_query($connection, $query);
        while ($q = mysqli_fetch_array($result, MYSQLI_ASSOC))
          {
            $cid = $q['client_id'];
            $sdip = "SELECT * FROM client WHERE id = '$cid'";
            $sdo = mysqli_query($connection, $sdip);
            $fe = mysqli_fetch_array($sdo);
            $client_name = $fe['firstname']." ".$fe["lastname"];
            $from_date = $q['fromdate'];
            $principal_amount = number_format($q['principal_amount'], 2);
            $interest = number_format($q['interest_amount'], 2);
            $npa = number_format(($q['interest_amount'] + $q['principal_amount']), 2);
            $days_no = $q['counter'];
            $zero = '0.00';
            $thirty = '0.00';
            $sixty = '0.00';
            $ninety = '0.00';
            $above = '0.00';
            if($days_no <= 1){
              $zero = number_format($q['principal_amount'], 2);
              $fdfs = $q['principal_amount'];
              $bnk_prov = (0.01 * $fdfs);
            }
            if(30 > $days_no){
              $thirty = number_format($q['principal_amount'], 2);
              $ffd = $q['principal_amount'];
              $bnk_prov = (0.05 * $ffd);
            }
            else if(60 > $days_no && $days_no > 30){
              $sixty = number_format($q['principal_amount'], 2);
              $fdfdf = $q['principal_amount'];
              $bnk_prov = (0.2 * $fdfdf);
            }
            else if(90 > $days_no && $days_no > 60){
              $ninety = number_format($q['principal_amount'], 2);
              $dfgd = $q['principal_amount'];
              $bnk_prov = (0.5 * $dfgd);
            }
            else if($days_no > 90){
              $above = number_format($q['principal_amount'], 2);
              $juiui = $q['principal_amount'];
              $bnk_prov = $juiui;
            }
            $out .= '
            <tr>
            <th style="font-size: 50px;" class="column1">'.$client_name.'</th>
            <th style="font-size: 50px;" class="column1">'.$from_date.'</th>
            <th style="font-size: 50px;" class="column1">'.$principal_amount.'</th>
            <th style="font-size: 50px;" class="column1">'.$interest.'</th>
            <th style="font-size: 50px;" class="column1">'.$npa.'</th>
            <th style="font-size: 50px;" class="column1">'.$zero.'</th>
            <th style="font-size: 50px;" class="column1">'.$thirty.'</th>
            <th style="font-size: 50px;" class="column1">'.$sixty.'</th>
            <th style="font-size: 50px;" class="column1">'.$ninety.'</th>
            <th style="font-size: 50px;" class="column1">'.$above.'</th>
            <th style="font-size: 50px;" class="column1">'.number_format($bnk_prov, 2).'</th>
            </tr>
          ';
        }
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
<h1>'.$_SESSION["int_full"].' <br/>Provision Report as at '.$current.'</h1>
<div id="company" class="clearfix">
  <div>'.$branch.'</div>
  <div>'.$branch_location.'</div>
  <div>(+234) '.$branch_phone.'</div>
  <div><a href="mailto:'.$branch_email.'">'.$branch_email.'</a></div>
</div>
<div id="project">
  <div><span>BRANCH</span> '.$branch.' </div>
</div>
</header>
  <main>
  <table>
  <thead class=" text-primary">
  <tr>
        <th style="font-size: 50px;" class="column1">
        Customer Name
        </th>
        <th>
        Past Due Date
        </th style="font-size: 50px;" class="column1">
        <th style="font-size: 50px;" class="column1">
        Principal Due
        </th>
        <th style="font-size: 50px;" class="column1">
        Interest Due
        </th>
        <th style="font-size: 50px;" class="column1">
        Total NPD
        </th>
        <th style="font-size: 50px;" class="column1">< 1 day</th>
        <th style="font-size: 50px;" class="column1">1 - 30 days</th>
        <th style="font-size: 50px;" class="column1">31 - 60 days</th>
        <th style="font-size: 50px;" class="column1">61 - 90 days</th>
        <th style="font-size: 50px;" class="column1">91 and Above</th>
        <th style="font-size: 50px;" class="column1">Bank Provision</th>
      </tr>
    </thead>
  <tbody>
  "'.fill_report($connection).'"
  </tbody>
  </table>
  </main>
  ');
  $file_name = 'Provision report for '.$intname.'-'.$date.'.pdf';
  $mpdf->Output($file_name, 'D');
?>