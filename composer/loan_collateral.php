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
  function fill_report($connection)
        {
            $out = '';
            $sessint_id =$_SESSION['int_id'];
          // import
        //   $glcode = $_POST['glcode'];
        $query = "SELECT * FROM collateral WHERE int_id = '$sessint_id'";
        $result = mysqli_query($connection, $query);
        while ($q = mysqli_fetch_array($result, MYSQLI_ASSOC))
          {
            $date = $q["date"];
            $name = $q['client_id'];
            $anam = mysqli_query($connection, "SELECT firstname, lastname FROM client WHERE id = '$name'");
            $f = mysqli_fetch_array($anam);
            $nae = strtoupper($f["firstname"]." ".$f["lastname"]);
            $value = $q["value"];
            $type = $q["type"];
            $desc = $q["description"];
            $out .= '
            <tr>
            <th style="font-size: 60px;" class="column1">'.$date.'</th>
            <th style="font-size: 60px;" class="column1">'.$nae.'</th>
            <th style="font-size: 60px;" class="column1">'.$value.'</th>
            <th style="font-size: 60px;" class="column1">'.$type.'</th>
            <th style="font-size: 60px;" class="column1">'.$desc.'</th>
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
<h1>'.$_SESSION["int_full"].' <br/> Loan Collateral Schedule</h1>
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
      <th style="font-size: 60px;" class="column1">
      Date
    </th>
    <th style="font-size: 60px;" class="column1">
      Client Name
    </th>
    <th style="font-size: 60px;" class="column1">
      Type
    </th>
    <th style="font-size: 60px;" class="column1">
      Value
    </th>
    <th style="font-size: 60px;" class="column1">
     Desccription
    </th>
      </tr>
    </thead>
  <tbody>
  "'.fill_report($connection).'"
  </tbody>
  </table>
  </main>
  ');
  $file_name = 'Collateral Schedule Report for '.$intname.'-'.$date.'.pdf';
  $mpdf->Output($file_name, 'D');
?>