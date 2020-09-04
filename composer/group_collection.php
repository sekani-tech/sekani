<?php
$output = '';
include("../functions/connect.php");
session_start();
?>
<?php
if(isset($_POST["start"]) && isset($_POST["end"])){
  $intname = $_SESSION['int_name'];
    $start = $_POST["start"];
    $int_id = $_SESSION["int_id"];
    $end = $_POST["end"];
    $group = $_POST["group"];
    $branch_id = $_POST["branch"];
    $officer = $_POST["officer"];

    $odsp = "SELECT * FROM branch WHERE int_id = '$int_id' AND id ='$branch_id'";
    $io = mysqli_query($connection, $odsp);
    $i = mysqli_fetch_array($io);
    $branch = $i['name'];

    $spdop = "SELECT * FROM staff WHERE int_id = '$int_id' AND id ='$officer' AND employee_status = 'Employed'";
    $dso = mysqli_query($connection, $spdop);
    $ti = mysqli_fetch_array($dso);
    if(isset($ti)){
      $officer_name = $ti['display_name'];
    }
    else{
      $officer_name = "All";
    }

    $dfpo = "SELECT * FROM groups WHERE int_id = '$int_id' AND id = '$group' AND loan_officer ='$officer' AND status ='Approved'";
    $sdoi = mysqli_query($connection, $dfpo);
    $dio = mysqli_fetch_array($sdoi);
    if(isset($dio)){
      $grname = $dio['g_name'];
    }
    else{
      $grname = "All";
    }
    function fill_collect($connection, $officer, $group){
      $sessint_id = $_SESSION['int_id'];
      $out = '';
      if($officer == 'all'){
        $query = "SELECT * FROM groups WHERE int_id ='$sessint_id'";
      }
      else{
        if($group == 'all'){
          $query = "SELECT * FROM groups WHERE int_id ='$sessint_id' AND loan_officer = '$officer'";
        }
        else{
          $query = "SELECT * FROM groups WHERE int_id ='$sessint_id' AND loan_officer = '$officer' AND id = '$group'";
        }
      }
      $result = mysqli_query($connection, $query);
      while($row = mysqli_fetch_array($result)){
          $g_id = $row['id'];
          $g_name = $row['g_name'];
          $dod = "SELECT * FROM group_clients WHERE group_id = '$g_id'";
          $fdi = mysqli_query($connection, $dod);
          while($fo = mysqli_fetch_array($fdi)){
            $name = "";
            $c_name = $fo["client_name"];
            $c_id = $fo["client_id"];
            $mobile = $fo["mobile_no"];
            $prod = $fo["product_name"];
            $account = $fo["account_no"];

            $sdl = "SELECT * FROM account WHERE client_id = '$c_id'";
            $soiw = mysqli_query($connection, $sdl);
            $ow = mysqli_fetch_array($soiw);
            $balance = $ow['account_balance_derived'];

            $worp = "SELECT * FROM loan WHERE client_id = '$c_id'";
            $dfoi = mysqli_query($connection, $worp);
            $ds = mysqli_fetch_array($dfoi);
            $repayment = $ds['repayment_date'];
            $matured = $ds['maturedon_date'];

            $dd = "SELECT SUM(interest_amount) AS interest_amount FROM loan_repayment_schedule WHERE installment >= '1' AND client_id = '$c_id' AND int_id = '$sessint_id'";
            $sdoi = mysqli_query($connection, $dd);
            $e = mysqli_fetch_array($sdoi);
            $interest = $e['interest_amount'];

            $dfdf = "SELECT SUM(principal_amount) AS principal_amount FROM loan_repayment_schedule WHERE installment >= '1' AND client_id = '$c_id' AND int_id = '$sessint_id'";
            $sdswe = mysqli_query($connection, $dfdf);
            $u = mysqli_fetch_array($sdswe);
            $prin = $u['principal_amount'];

            $outstanding = $prin + $interest;

            // Arrears
            $ldfkl = "SELECT SUM(interest_amount) AS interest_amount FROM loan_arrear WHERE installment >= '1' AND client_id = '$c_id' AND int_id = '$sessint_id'";
            $fosdi = mysqli_query($connection, $ldfkl);
            $l = mysqli_fetch_array($fosdi);
            $interesttwo = $l['interest_amount'];

            $sdospd = "SELECT SUM(principal_amount) AS principal_amount FROM loan_arrear WHERE installment >= '1' AND client_id = '$c_id' AND int_id = '$sessint_id'";
            $sodi = mysqli_query($connection, $sdospd);
            $s = mysqli_fetch_array($sodi);
            $printwo = $s['principal_amount'];

            $outstandingtwo = $printwo + $interesttwo;
            $ttout = $outstanding + $outstandingtwo;

            $out .='
            <tr>
              <td>'.$c_name.'</td>
              <td>'.$c_id.'</td>
              <td>'.$g_name.'</td>
              <td>'.$mobile.'</td>
              <td>'.$prod.'</td>
              <td>'.$account.'</td>
              <td>'.number_format($ttout, 2).'</td>
              <td>'.number_format($outstanding, 2).'</td>
              <td>'.$repayment.'</td>
              <td>'.$matured.'</td>
              <td>'.number_format($outstanding, 2).'</td>
              <td></td>
              <td>'.number_format($balance, 2).'</td>
            </tr>
            ';
          
      }
    }
       
  return $out;
}
  require_once __DIR__ . '/vendor/autoload.php';
  $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [297, 210]]);
  $mpdf->SetWatermarkImage(''.$_SESSION["int_logo"].'');
  $mpdf->showWatermarkImage = true;
  $mpdf->WriteHTML('
  <!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
	h1{
    text-align: center;
    }
</style>
</head>
<body>
 <div id="logo">
    <img src="'.$_SESSION["int_logo"].'" height="80" width="80">
  </div>
<h1>'.$intname.' - Group collection Sheet</h1>
<p>Account Officer: '.$officer_name.'</p>
<p>Branch: '.$branch.'</p>
<p>Groups: '.$grname.'</p>

<table style="width:100%;">
<thead>
     <tr>
       <th>Client Name</th>
       <th>Client ID</th>
       <th>Group</th>
       <th>Phone Number</th>
       <th>Product</th>
       <th>Account Number</th>
       <th>Outstanding</th>
       <th>Total Due</th>
       <th>Expected Repayment</th>
       <th>Maturity Date</th>
       <th>Expected Repayment Amount</th>
       <th>Actual Repayment</th>
       <th>Total Savings Balance</th>
  </tr>
  </thead>
  <tbody>
  </tbody>
</table>
</body>
</html>

  ');
  $file_name = 'Group Collection for '.$intname.'.pdf';
  $mpdf->Output($file_name, 'D');
    }
    else {
      echo 'Not Seeing Data';
    }
?>