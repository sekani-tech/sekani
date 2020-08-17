<?php
$output = '';
include("../functions/connect.php");
session_start();
$int_id = $_SESSION["int_id"];
$branch_id = $_SESSION["branch_id"];
if ($branch_id != "") {
$b_query = mysqli_query($connection, "SELECT * FROM `branch` WHERE id = '$branch_id' AND int_id = '$int_id'");
$m = mysqli_fetch_array($b_query);
$branch_email = $m["email"];
$branch_name = $m["name"];
$branch_location = $m["location"];
$branch_phone = $m["phone"];
}
?>
<?php
if (isset($_GET["id"]) && isset($_GET["x"]))
{
    $harsh = $_GET["id"];
    $id = $_GET["x"];
    // echo $id;
    // echo $harsh;
    // verify user
    if (password_verify($id, $harsh) && $harsh != "" && $id != "") {
        $query = mysqli_query($connection, "SELECT * FROM `sekani_wallet_transaction` WHERE id = '$id' AND int_id = '$int_id'");
        if (mysqli_num_rows($query) >= 1) {
            // make a new echo
            $x = mysqli_fetch_array($query);
            $desc = $x["description"];
            $trans = $x["transaction_id"];
            $type = $x["transaction_type"];
            $amount = $x["amount"];
            list($token, $disco, $meter, $unit) = explode(",", $desc);
            //   anything
            require_once __DIR__ . '/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [105, 148]]);
$mpdf->SetWatermarkImage(''.$_SESSION["int_logo"].'');
$mpdf->showWatermarkImage = true;
$mpdf->WriteHTML('<link rel="stylesheet" media="print" href="pdf/style.css" media="all"/>
<header class="clearfix">
<div id="logo">
  <img src="'.$_SESSION["int_logo"].'" height="80" width="80">
</div>
<h1 style="font-size: 12px;">'.$_SESSION["int_name"].' - BILL PAYMENT RECIEPT</h1>
<div id="company" class="clearfix" style="font-size: 12px;">
  <div> <span style="font-size: 12px;">'.$branch_location.' </span></div>
  <div> <span style="font-size: 12px;">(+234) '.$branch_phone.'</span> </div>
  <div><a href="mailto:'.$branch_email.'">'.$branch_email.'</a></div>
</div>
<div id="project">
  <div><span>TRANSACTION ID: '.$trans.'</span></div>
</div>
</header>
<main>
<table>
<tbody>
<tr>
<th> <b>AMOUNT PAID</b></th>
<th></th>
<th></th>
        <th><b>&#8358; '.$amount.'</b></th>
</tr>
<tr>
<tr>
<th><b>TOKEN</b></th>
<th></th>
<th></th>
        <th><b>'.$token.'</b></th>
</tr>
<tr>
<th><b>METER NUMBER</b></th>
<th></th>
<th></th>
 <th><b>'.$meter.'</b></th>
</tr>
<tr>
<th><b>UNIT</b></th>
<th></th>
<th></th>
 <th><b>'.$unit.'</b></th>
</tr>
<tr>
<th><b>CHARGE</b></th>
<th></th>
<th></th>
 <th><b>&#8358; 100</b></th>
</tr>
<tr>
<th><b>TOTAL</b></th>
<th></th>
<th></th>
<th><b>&#8358; '.($amount + 100).'</b></th>
</tr>
</tbody>
</table>
</main>
');
$file_name = $type.''.$meter.'.pdf';
$mpdf->Output($file_name, 'D');
            // end  PDF of such
        } else {
            // makwe a new echo;
            echo header("location: ../mfi/bill.php");
            // make a new move
        }
    } else {
        echo header("location: ../mfi/bill.php");
    }
    
} else {
    // echo  something new.
    echo header("location: ../mfi/bill.php");
}
?>