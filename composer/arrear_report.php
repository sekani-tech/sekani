<?php
  $output = '';
  include("../functions/connect.php");
  session_start();

  $intname = $_SESSION['int_name'];
  $branch_id = $_SESSION["branch_id"];
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
    // $glcode = $_POST['glcode'];
    $query = "SELECT client_id, loan_id, SUM(principal_amount) AS principal_amount, SUM(interest_amount) AS interest_amount, counter FROM loan_arrear WHERE int_id = '$sessint_id' AND installment >= '1' GROUP BY loan_id ORDER BY loan_id";
    $result = mysqli_query($connection, $query);
    while ($q = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
      $loan_id = $q['loan_id'];
      $name = $q['client_id'];
      $anam = mysqli_query($connection, "SELECT firstname, lastname FROM client WHERE id = '$name'");
      $f = mysqli_fetch_array($anam);
      $nae = strtoupper($f["firstname"]." ".$f["lastname"]);
      $principal = number_format($q["principal_amount"], 2);
      $interest = $q["interest_amount"];
      $counter = $q["counter"];

      $get_loan = mysqli_query($connection, "SELECT loan_term, repay_every, maturedon_date, total_outstanding_derived FROM loan WHERE id = '$loan_id' AND int_id = '$sessint_id'");
      $mik = mysqli_fetch_array($get_loan);
      $l_n = $mik["loan_term"];
      $repay_every = $mik['repay_every'];
      $maturity_date = $mik['maturedon_date'];

      $get_last_repay_date = mysqli_query($connection, "SELECT transaction_date FROM `loan_transaction` WHERE int_id = '$sessint_id' AND loan_id = '$loan_id' ORDER BY transaction_date DESC LIMIT 1");
      if(mysqli_num_rows($get_last_repay_date) == 1) {
          $last_repay_date = mysqli_fetch_array($get_last_repay_date)['transaction_date'];
      } else {
          $last_repay_date = 'NIL';
      }

      $amount_in_arrears = number_format(round($q['principal_amount'] + $q['interest_amount']), 2);
      
      $out .= '
        <tr>
            <td style="font-size: 50px;" class="column1">'.$nae.'</td>
            <td style="font-size: 50px;" class="column1">'.$principal.'</td>
            <td style="font-size: 50px;" class="column1">'.$interest.'</td>
            <td style="font-size: 50px;" class="column1">'.$counter.'</td>
            <td style="font-size: 50px;" class="column1">'.$loan_term . ' ' . $repay_every.'</td>
            <td style="font-size: 50px;" class="column1">'.$maturity_date.'</td>
            <td style="font-size: 50px;" class="column1">'.$last_repay_date.'</td>
            <td style="font-size: 50px;" class="column1">'.$amount_in_arrears.'</td>
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
<h1>'.$_SESSION["int_full"].' <br/>Loans in Arrears Report</h1>
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
      <thead class="text-primary">
        <tr>
          <th style="font-size: 50px;" class="column1">
            Client Name
          </th>
          <th style="font-size: 50px;" class="column1">
            Principal Due
          </th>
          <th style="font-size: 50px;" class="column1">
            Interest Due
          </th>
          <th style="font-size: 50px;" class="column1">
            Days in Arrears
          </th>
          <th style="font-size: 50px;" class="column1">
            Loan Term
          </th>
          <th style="font-size: 50px;" class="column1">
            Maturity Date
          </th>
          <th style="font-size: 50px;" class="column1">
            Last Repayment Date
          </th>
          <th style="font-size: 50px;" class="column1">
            Amount in Arrears
          </th>
        </tr>
      </thead>
      <tbody>
      "'.fill_report($connection).'"
      </tbody>
    </table>
  </main>
  ');
  $file_name = 'loans-in-arrears-for-'.$intname.'.pdf';
  $mpdf->Output($file_name, 'D');
?>