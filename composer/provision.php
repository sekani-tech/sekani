<?php
include("../functions/connect.php");
session_start();

$intname = $_SESSION['int_name'];
$sessint_id = $_SESSION['int_id'];
$branch_id = $_POST['branch_id'];

$branchquery = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch_id'");
if (count([$branchquery]) == 1) {
  $ans = mysqli_fetch_array($branchquery);
  $branch = $ans['name'];
  $branch_email = $ans['email'];
  $branch_location = $ans['location'];
  $branch_phone = $ans['phone'];
}

$current = date('d-m-Y');

function fill_report($connection, $sessint_id, $branch_id)
{
    $out = '';

    $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
    while ($row = mysqli_fetch_array($getParentID)) {
        $parent_id = $row['parent_id'];
    }

    if($parent_id == 0) {
        $result = mysqli_query($connection, "SELECT * FROM loan WHERE int_id = '$sessint_id'");
    } else {
        $result = mysqli_query($connection, "SELECT * FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id)");
    }

    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            $cid = $row['client_id'];
            $get_client_name = mysqli_query($connection, "SELECT display_name FROM client WHERE id = '$cid'");
            $client = mysqli_fetch_array($get_client_name);
            $client_name = $client['display_name'];

            $get_loan_id = mysqli_query($connection, "SELECT id FROM loan WHERE client_id = '$cid'");
            $loan = mysqli_fetch_array($get_loan_id);
            $loan_id = $loan['id'];

            // principal_amount holds the principal outstanding of a loan
            $query_principal_due =  mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_due FROM `loan_repayment_schedule` WHERE int_id = '$sessint_id' AND loan_id = '$loan_id'");
            $principal_due = mysqli_fetch_array($query_principal_due);
            $principal_due = $principal_due['principal_due'];

            // interest_amount holds the interest outstanding of a loan
            $query_interest_due =  mysqli_query($connection, "SELECT SUM(interest_amount) AS interest_due FROM `loan_repayment_schedule` WHERE int_id = '$sessint_id' AND loan_id = '$loan_id'");
            $interest_due = mysqli_fetch_array($query_interest_due);
            $interest_due = $interest_due['interest_due'];


            $query_principal_due2 =  mysqli_query($connection, "SELECT sum(principal_amount) as principal_due FROM `loan_arrear` WHERE int_id = '$sessint_id' AND loan_id = '$loan_id'");
            $principal_due2 = mysqli_fetch_array($query_principal_due2);
            $principal_due2 = $principal_due2['principal_due'];

            $query_interest_due2 =  mysqli_query($connection, "SELECT SUM(interest_amount) AS interest_due FROM `loan_arrear` WHERE int_id = '$sessint_id' AND loan_id = '$loan_id'");
            $interest_due2 = mysqli_fetch_array($query_interest_due2);
            $interest_due2 = $interest_due2['interest_due'];

            $repayment_due = $principal_due2 + $interest_due2;

            $counter_query = mysqli_query($connection, "SELECT counter FROM loan_arrear WHERE loan_id = '$loan_id'");
            $counter = mysqli_fetch_array($counter_query);
            $counter = $counter['counter'];

            if ($counter <= 30) {
              $repay1to30 = '₦ '.number_format(round($repayment_due), 2);
            } else {
              $repay1to30 = '';
            }

            if ($counter > 30 && $counter <= 60) {
              $repay31to60 = '₦ '.number_format(round($repayment_due), 2);
            } else {
              $repay31to60 = '';
            }

            if ($counter > 60 && $counter <= 90) {
              $repay61to90 = '₦ '.number_format(round($repayment_due), 2);
            } else {
              $repay61to90 = '';
            }

            if ($counter > 91 && $counter <= 180) {
              $repay91to180 = '₦ '.number_format(round($repayment_due), 2);
            } else {
              $repay91to180 = '';
            }

            if ($counter > 180) {
              $repay180andabove = '₦ '.number_format(round($repayment_due), 2);
            } else {
              $repay180andabove = '';
            }

            $totalNPL = round($principal_due2) + $interest_due2;

            if ($counter <= 30) {
                $provision = $repayment_due * 0.02;                
            } else if ($counter > 30 && $counter <= 60) {
                $provision = $repayment_due * 0.05;
            } else if ($counter > 60 && $counter <= 90) {
                $provision = $repayment_due * 0.2;
            } else if ($counter > 91 && $counter <= 180) {
                $provision = $repayment_due  * 0.5;
            } else {
                $provision = $repayment_due;
            }

            $out .= '
              <tr>
                <th style="font-size: 50px;" class="column1">'.$client_name.'</th>
                <th style="font-size: 50px;" class="column1">₦ '.number_format(round($principal_due), 2).'</th>
                <th style="font-size: 50px;" class="column1">₦ '.number_format(round($interest_due), 2).'</th>
                <th style="font-size: 50px;" class="column1">'.$repay1to30.'</th>
                <th style="font-size: 50px;" class="column1">'.$repay31to60.'</th>
                <th style="font-size: 50px;" class="column1">'.$repay61to90.'</th>
                <th style="font-size: 50px;" class="column1">'.$repay91to180.'</th>
                <th style="font-size: 50px;" class="column1">'.$repay180andabove.'</th>
                <th style="font-size: 50px;" class="column1">₦ '.number_format($totalNPL, 2).'</th>
                <th style="font-size: 50px;" class="column1">₦ '.number_format($provision, 2).'</th>
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
        <th style="font-size: 50px;" class="column1">
          Principal Due
        </th>
        <th style="font-size: 50px;" class="column1">
          Interest Due
        </th>
        <th style="font-size: 50px;" class="column1">
          1 - 30 days
        </th>
        <th style="font-size: 50px;" class="column1">
          31 - 60 days
        </th>
        <th style="font-size: 50px;" class="column1">
          61 - 90 days
        </th>
        <th style="font-size: 50px;" class="column1">
          91 - 180 days
        </th>
        <th style="font-size: 50px;" class="column1">
          180 days and more
        </th>
        <th style="font-size: 50px;" class="column1">
          Total NPL
        </th>
        <th style="font-size: 50px;" class="column1">
          Provision
        </th>
      </tr>
    </thead>
    <tbody>
      "'.fill_report($connection, $sessint_id, $branch_id).'"
    </tbody>
  </table>
</main>
');

$intname = strtolower($intname);
$file_name = 'provision-report-for-'.$intname.'-'.$current.'.pdf';
$mpdf->Output($file_name, 'D');
?>