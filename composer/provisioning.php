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
        $currentdate = date('Y-m-d');
        $query = "SELECT * FROM loan WHERE int_id = '$sessint_id'";
        $result = mysqli_query($connection, $query);
        while ($q = mysqli_fetch_array($result, MYSQLI_ASSOC))
          {
            $std = date("Y-m-d");
            if($std >= $q["maturedon_date"] ){
            $name = $q['client_id'];
            $anam = mysqli_query($connection, "SELECT firstname, lastname FROM client WHERE id = '$name'");
            $f = mysqli_fetch_array($anam);
            $nae = strtoupper($f["firstname"]." ".$f["lastname"]);
            $principal = number_format($q["principal_amount"]);
            $loant = $q["loan_term"];
            $disb_date = $q["disbursement_date"];
            $repay = $q["maturedon_date"];
            $loant = $q["loan_term"];
            $bal = $q["total_outstanding_derived"];

            $out .= '
            <tr>
            <th style="font-size: 50px;" class="column1">'.$nae.'</th>
            <th style="font-size: 50px;" class="column1">'.$principal.'</th>
            <th style="font-size: 50px;" class="column1">'.$loant.'</th>
            <th style="font-size: 50px;" class="column1">'.$disb_date.'</th>
            <th style="font-size: 50px;" class="column1">'.$repay.'</th>
            <th style="font-size: 50px;" class="column1">'.$bal.'</th>
            </tr>
          ';
          }
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
<h1>'.$_SESSION["int_full"].' <br/>Matured Loans as at '.$current.'</h1>
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
    Principal Amount
    </th>
    <th style="font-size: 50px;" class="column1">
    Loan Term
    </th>
    <th style="font-size: 50px;" class="column1">
    Disbursement Date
    </th>
    <th style="font-size: 50px;" class="column1">
   Maturity Date
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
  $file_name = 'Loan classification reports for '.$intname.'-'.$date.'.pdf';
  $mpdf->Output($file_name, 'D');
?>