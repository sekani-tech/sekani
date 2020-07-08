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
            $branch = $_SESSION["branch_id"];
          // import
        //   $glcode = $_POST['glcode'];
        $currentdate = date('Y-m-d');
        $query = "SELECT * FROM institution_account_transaction WHERE branch_id = '$branch' AND int_id = '$sessint_id' AND transaction_date = '$currentdate'";
        $result = mysqli_query($connection, $query);
        while ($q = mysqli_fetch_array($result, MYSQLI_ASSOC))
          {
            $trans_type = $q["transaction_type"];
            $trans_date = $q["transaction_date"];
            $desc = $q["description"];

            $name = $q['appuser_id'];
            $anam = mysqli_query($connection, "SELECT display_name FROM staff WHERE id = '$name'");
            $f = mysqli_fetch_array($anam);
            $disname = strtoupper($f["display_name"]);
            $debt = number_format($q["debit"]);
            $cred = number_format($q["credit"]);
            $bal = number_format($q["running_balance_derived"], 2);

            $out .= '
            <tr>
            <th style="font-size: 50px;" class="column1">'.$trans_type.'</th>
            <th style="font-size: 50px;" class="column1">'.$trans_date.'</th>
            <th style="font-size: 50px;" class="column1">'.$desc.'</th>
            <th style="font-size: 50px;" class="column1">'.$disname.'</th>
            <th style="font-size: 50px;" class="column1">'.$debt.'</th>
            <th style="font-size: 50px;" class="column1">'.$cred.'</th>
            <th style="font-size: 50px;" class="column1">'.$bal.'</th>
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
<h1>'.$_SESSION["int_full"].' <br/>All transactions made on '.$current.'</h1>
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
      Transaction Type
    </th>
    <th style="font-size: 50px;" class="column1">
    Transaction Date
    </th>
    <th style="font-size: 50px;" class="column1">
    Reference
    </th>
    <th style="font-size: 50px;" class="column1">
    Account Officer
    </th>
    <th style="font-size: 50px;" class="column1">
    Debits(&#8358;)
    </th>
    <th style="font-size: 50px;" class="column1">
    Credits(&#8358;)
    </th>
    <th style="font-size: 50px;" class="column1">
    Account Balance(&#8358;)
    </th>
      </tr>
    </thead>
  <tbody>
  "'.fill_report($connection).'"
  </tbody>
  </table>
  </main>
  ');
  $file_name = 'Transactions Made by '.$intname.'-'.$date.'.pdf';
  $mpdf->Output($file_name, 'D');
?>