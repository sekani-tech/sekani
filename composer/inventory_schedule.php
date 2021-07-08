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
            $int_id = $_SESSION['int_id'];
            $start = $_POST["start"];
            $end = $_POST["end"];
            $branch_id = $_POST["branch"];
          // import
        //   $glcode = $_POST['glcode'];
        $currentdate = date('Y-m-d');
        $query = mysqli_query($connection, "SELECT * FROM inventory WHERE branch_id = '$branch_id' AND int_id ='$int_id' AND date BETWEEN '$start' AND '$end'");
        while ($q = mysqli_fetch_array($query, MYSQLI_ASSOC))
          {
            $date = $q["date"];
            $sn = $q["serial_no"];
            $item = $q['item'];
            $quantity = $q['quantity'];
            $unit_price = $q['unit_price'];
            $total = $q['total_price'];

            $out .= '
            <tr>
            <th class="column1">'.$date.'</th>
            <th class="column1">'.$sn.'</th>
            <th class="column1">'.$item.'</th>
            <th class="column1">'.$quantity.'</th>
            <th class="column1">'.$unit_price.'</th>
            <th class="column1">'.$total.'</th>
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
<h1>'.$_SESSION["int_full"].' <br/>Inventory Schedule Report '.$current.'</h1>
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
      <th class="column1">
      Date
    </th>
    <th class="column1">
    Serial No
    </th>
    <th class="column1">
    Item
    </th>
    <th class="column1">
    Quantity
    </th>
    <th class="column1">
    Unit Price
    </th>
    <th class="column1">
   Total Price
    </th>
      </tr>
    </thead>
  <tbody>
  "'.fill_report($connection).'"
  </tbody>
  </table>
  </main>
  ');
  $file_name = 'Inventory Report '.$intname.'-'.$date.'.pdf';
  $mpdf->Output($file_name, 'D');
?>