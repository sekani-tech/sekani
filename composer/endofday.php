<?php
$output = '';
include("../functions/connect.php");
session_start();
?>
<?php
  // $intname = $_SESSION['int_name'];
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
           $int_id =$_SESSION['int_id'];
        $query = "SELECT * FROM endofday_tb WHERE int_id = '$int_id'";
        $result = mysqli_query($connection, $query);
        while ($q = mysqli_fetch_array($result, MYSQLI_ASSOC))
          {
            $id = $q['id'];
            $datec = $q["dateclosed"];
            $closedb = $q["closedby"];
            $out .= '
            <tr>
            <th style="font-size: 12px;" class="column1">'. $id.'</th>
            <th style="font-size: 12px;" class="column1">'.$datec.'</th>
            <th style="font-size: 12px;" class="column1">'.$closedb.'</th>
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
<h1>'.$_SESSION["int_full"].' <br/> End of Day</h1>
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
      <th style="font-size: 20px;" class="column1">
 ID
    </th>
    <th style="font-size: 20px;" class="column1">
  DATE CLOSED
    </th>
    <th style="font-size: 20px;" class="column1">
  CLOSED BY
    </th>
      </tr>
    </thead>
  <tbody>
  "'.fill_report($connection).'"
  </tbody>
  </table>
  </main>
  ');
  $file_name = 'End of Day for -'.$date.'.pdf';
  $mpdf->Output($file_name, 'D');
?>