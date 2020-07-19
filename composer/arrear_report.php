<?php
$output = '';
include("../functions/connect.php");
session_start();
?>
<?php
  $intname = $_SESSION['int_name'];
  $branch_id = $_SESSION["branch_id"];
  $date = $_POST['end'];
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
        $currentdate = $_POST['end'];
        $query = "SELECT * FROM loan_arrear WHERE int_id = '$sessint_id'";
        $result = mysqli_query($connection, $query);
        while ($q = mysqli_fetch_array($result, MYSQLI_ASSOC))
          {
            $loan_id = $q['loan_id'];
            $name = $q['client_id'];
            $anam = mysqli_query($connection, "SELECT firstname, lastname FROM client WHERE id = '$name'");
            $f = mysqli_fetch_array($anam);
            $nae = strtoupper($f["firstname"]." ".$f["lastname"]);
            $principal = number_format($q["principal_amount"]);
            $int_amount = $q["interest_amount"];
            $get_loan = mysqli_query($connection, "SELECT loan_term, total_outstanding_derived FROM loan WHERE id = '$loan_id' AND int_id = '$sessint_id'");
            $mik = mysqli_fetch_array($get_loan);
            $l_n = $mik["loan_term"];
            $t_o = $mik["total_outstanding_derived"];
            $from = $q["fromdate"];
            $to = $q["duedate"];
            $out .= '
            <tr>
            <th style="font-size: 50px;" class="column1">'.$nae.'</th>
            <th style="font-size: 50px;" class="column1">'.$principal.'</th>
            <th style="font-size: 50px;" class="column1">'.$int_amount.'</th>
            <th style="font-size: 50px;" class="column1">'.$l_n.'</th>
            <th style="font-size: 50px;" class="column1">'.$from.'</th>
            <th style="font-size: 50px;" class="column1">'.$to.'</th>
            <th style="font-size: 50px;" class="column1">'.$t_o.'</th>
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
<h1>'.$_SESSION["int_full"].' <br/>Loans in arrears Report</h1>
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
      Client Name
    </th>
    <th style="font-size: 50px;" class="column1">
    Principal Due
    </th>
    <th style="font-size: 50px;" class="column1">
    Interest Due
    </th>
    <th style="font-size: 50px;" class="column1">
    Loan Term
    </th>
    <th style="font-size: 50px;" class="column1">
    Disbursement Date
    </th>
    <th style="font-size: 50px;" class="column1">
    Repayment Date
    </th>
    <th style="font-size: 50px;" class="column1">
    Outstanding Loan Balance
    </th>
      </tr>
    </thead>
  <tbody>
  "'.fill_report($connection).'"
  </tbody>
  </table>
  </main>
  ');
  $file_name = 'Loan Repayments in Arrears for '.$intname.'.pdf';
  $mpdf->Output($file_name, 'D');
?>