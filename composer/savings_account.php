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
    if(isset($_POST['eww'])){
      $sad = 'in Debit';
    }
    else{
      $sad = '';
    }
  function fill_report($connection)
        {
            $out = '';
            $sessint_id =$_SESSION['int_id'];
          // import
        //   $glcode = $_POST['glcode'];
          if(isset($_POST['eww'])){
            $query = "SELECT client.client_type, client.id, client.account_type, client.account_no, client.mobile_no, client.firstname, client.lastname FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND account.type_id = '2' AND account.account_balance_derived < '0.00'";
          }
          else{
            $query = "SELECT client.client_type, client.id, client.account_type, client.account_no, client.mobile_no, client.firstname, client.lastname FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND account.type_id = '2'";
          }
        $result = mysqli_query($connection, $query);
        while ($q = mysqli_fetch_array($result, MYSQLI_ASSOC))
          {
            $cid = $q["id"];
          $firstname = $q["firstname"];
          $lastname = $q["lastname"];
          $account = strtoupper($q["client_type"]);
            $q["account_type"];
            $cid= $q["id"];
            $atype = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$cid'");
            if (count([$atype]) == 1) {
                $yxx = mysqli_fetch_array($atype);
                if(isset($yxx['product_id'])){
                $actype = $yxx['product_id'];
                }
              $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$actype'");
            if (count([$spn])) {
              $d = mysqli_fetch_array($spn);
              if(isset($d["name"])){
              $savingp = $d["name"];
              }
            }
            }
            $acc = $q["account_no"];
            $don = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$cid'");
            $ew = mysqli_fetch_array($don);
            if(isset($ew['account_balance_derived'])){
            $accountb = $ew['account_balance_derived'];
            }
            $out .= '
            <tr>
            <th style="font-size: 30px;" class="column1">'.$firstname.'</th>
            <th style="font-size: 30px;" class="column1">'.$lastname.'</th>
            <th style="font-size: 30px;" class="column1">'.$account.'</th>
            <th style="font-size: 30px;" class="column1">'.$savingp.'</th>
            <th style="font-size: 30px;" class="column1">'.$acc.'</th>
            <th style="font-size: 30px;" class="column1">'.$accountb.'</th>
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
<h1>'.$_SESSION["int_full"].' <br/> Savings Account Report '.$sad.'</h1>
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
      Account Balances
    </th>
      </tr>
    </thead>
  <tbody>
  "'.fill_report($connection).'"
  </tbody>
  </table>
  </main>
  ');
  $file_name = 'Savings Account Report '.$sad.' for '.$intname.'-'.$date.'.pdf';
  $mpdf->Output($file_name, 'D');
?>