<?php
$output = '';
include("../functions/connect.php");
session_start();
?>
<?php
   if (isset($_POST["start"]) && isset($_POST["end"])) {
    $start = $_POST["start"];
   $end = $_POST["end"];
   $sessint_id =$_SESSION['int_id'];
    function fill_data($connection, $start, $end, $sessint_id){
        // import
        $accountquery = "SELECT * FROM loan WHERE int_id = $sessint_id AND submittedon_date BETWEEN '$start' AND '$end'";
        $resul = mysqli_query($connection, $accountquery);
        $out = '';
  
        while ($q = mysqli_fetch_array($resul))
        {
          $name = $q['client_id'];
          $anam = mysqli_query($connection, "SELECT firstname, lastname FROM client WHERE id = '$name'");
          $f = mysqli_fetch_array($anam);
          $nae = strtoupper($f["firstname"]." ".$f["lastname"]);
  
          $prina = $q["principal_amount"];
          $loant = $q["loan_term"]; 
          $disb = $q["disbursement_date"]; 
          $repay = $q["repayment_date"]; 
          $intrate = $q["interest_rate"]; 
          $fee = $q["fee_charges_charged_derived"]; 
          $intr = $intrate/100;
          $final = $intr * $prina;
          $total = $loant * $final;
          $income = $fee + $total;
          $out .= '
          <tr>
              <td style = "font-size:20px;">'.$nae.'</td>
              <td style = "font-size:20px;">'.$prina.'</td>
              <td style = "font-size:20px;">'.$loant.'</td>
              <td style = "font-size:20px;">'.$disb.'</td>
              <td style = "font-size:20px;">'.$repay.'</td>
              <td style = "font-size:20px;">'.$intrate.'</td>
              <td style = "font-size:20px;">'.$final.'</td>
              <td style = "font-size:20px;">'.$total.'</td>
              <td style = "font-size:20px;">'.$fee.'</td>
              <td style = "font-size:20px;">'.$income.'</td>
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
<h1>Disbursed Loan Report</h1>
</header>
<main>
<table>
<thead>
<tr class="table100-head">
    <th style = "font-size:20px;">Client Name</th>
    <th style = "font-size:20px;">Loan Amount</th>
    <th style = "font-size:20px;">Loan Term</th>
    <th style = "font-size:20px;">Disbursement Date</th>
    <th style = "font-size:20px;">Maturity Date</th>
    <th style = "font-size:20px;">Interest Rate</th>
    <th style = "font-size:20px;">Monthly Interest</th>
    <th style = "font-size:20px;">Total Interest</th>
    <th style = "font-size:20px;">Fee</th>
    <th style = "font-size:20px;">Total Income</th>
</tr>
</thead>
<tbody>
"'.fill_data($connection, $start, $end, $sessint_id).'"
<tr>
<th style = "font-size:20px;">Total</th>
<th style = "font-size:20px;"></th>
 <th style = "font-size:20px;">&#8358; '.$tcdp.'</th>
 <th style = "font-size:20px;">&#8358; '.$tddp.'</th>
<th style = "font-size:20px;">&#8358; '.$finalbal.'</th>
</tr>
</tbody>
</table>
</main>
');
$file_name = 'Disbursed Loan Report as at '.$end.'.pdf';
$mpdf->Output($file_name, 'D');
  } else {
    echo 'Not Seeing Data';
  }
?>