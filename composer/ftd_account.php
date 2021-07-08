<?php
$output = '';
include("../functions/connect.php");
session_start();

$intname = $_SESSION['int_name'];
$sessint_id = $_SESSION['int_id'];
$branch_id = $_SESSION["branch_id"];
$today = date('d/m/Y');

$branchquery = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch_id'");
if (count([$branchquery]) == 1) {
  $ans = mysqli_fetch_array($branchquery);
  $branch = $ans['name'];
  $branch_email = $ans['email'];
  $branch_location = $ans['location'];
  $branch_phone = $ans['phone'];
}

function fill_report($connection, $sessint_id, $branch_id)
{
  $out = '';

  $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
  while ($result = mysqli_fetch_array($getParentID)) {
      $parent_id = $result['parent_id'];
  }

  if ($parent_id == 0) {
      $query = "SELECT c.firstname, c.lastname, c.client_type, f.product_id, f.account_no, a.account_balance_derived FROM ftd_booking_account f JOIN client c ON f.client_id = c.id JOIN account a ON c.id = a.client_id WHERE f.int_id = '$sessint_id' AND f.status = 'Approved' ORDER BY c.firstname ASC";
      $result = mysqli_query($connection, $query);
  } else {
      $query = "SELECT c.firstname, c.lastname, c.client_type, f.product_id, f.account_no, a.account_balance_derived FROM ftd_booking_account f JOIN client c ON f.client_id = c.id JOIN account a ON c.id = a.client_id WHERE f.int_id = '$sessint_id' AND f.branch_id = '$branch_id' AND f.status = 'Approved' ORDER BY c.firstname ASC";
      $result = mysqli_query($connection, $query);
  }


  if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $firstname = $row["firstname"];
      $lastname = $row["lastname"];
      $client_type = strtoupper($row["client_type"]);

      $prod = $row["product_id"];
      $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$prod'");
      if (count([$spn])) {
        $d = mysqli_fetch_array($spn);
        $savings_product = $d["name"];
      }
      
      $account_no = $row["account_no"];
      $account_balance = $row["account_balance_derived"];

      $out .= '
        <tr>
          <th style="font-size: 30px;" class="column1">'.$firstname.'</th>
          <th style="font-size: 30px;" class="column1">'.$lastname.'</th>
          <th style="font-size: 30px;" class="column1">'.$client_type.'</th>
          <th style="font-size: 30px;" class="column1">'.$savings_product.'</th>
          <th style="font-size: 30px;" class="column1">'.$account_no.'</th>
          <th style="font-size: 30px;" class="column1">'.$account_balance.'</th>
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
    <h1>'.$_SESSION["int_full"].' <br/> Fixed Deposit Account Report '.$sad.'</h1>
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
          <th style="font-size: 30px;" class="column1">
            First Name
          </th>
          <th style="font-size: 30px;" class="column1">
            Last Name
          </th>
          <th style="font-size: 30px;" class="column1">
            Client Type
          </th>
          <th style="font-size: 30px;" class="column1">
            Account Type
          </th>
          <th style="font-size: 30px;" class="column1">
            Account Number
          </th>
          <th style="font-size: 30px;" class="column1">
            Account Balance
          </th>
        </tr>
      </thead>
      <tbody>
      "'.fill_report($connection, $sessint_id, $branch_id).'"
      </tbody>
    </table>
  </main>
');
$file_name = 'ftd-account-report-'.strtolower($intname).'-'.$today.'.pdf';
$mpdf->Output($file_name, 'D');
?>