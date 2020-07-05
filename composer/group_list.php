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
            $sessint_id = $_SESSION['int_id'];
          // import
        //   $glcode = $_POST['glcode'];
        $query = "SELECT * FROM groups WHERE int_id = '$sessint_id' AND status = 'Approved' ORDER BY g_name ASC";
        $result = mysqli_query($connection, $query);
        while ($q = mysqli_fetch_array($result, MYSQLI_ASSOC))
          {
            $cid= $q["id"];
            $gname = $q["g_name"];
            $reg_type = $q["reg_type"];
            $meeting_day = $q["meeting_day"];
            $meeting_frequency = $q["meeting_frequency"];
            $meeting_time = $q["meeting_time"];
            $meeting_location = $q["meeting_location"];
            $out .= '
            <tr>
            <th style="font-size: 30px;" class="column1">'.$gname.'</th>
            <th style="font-size: 30px;" class="column1">'.$reg_type.'</th>
            <th style="font-size: 30px;" class="column1">'.$meeting_day.'</th>
            <th style="font-size: 30px;" class="column1">'.$meeting_frequency.'</th>
            <th style="font-size: 30px;" class="column1">'.$meeting_time.'</th>
            <th style="font-size: 30px;" class="column1">'.$meeting_location.'</th>
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
<h1>'.$_SESSION["int_full"].' <br/> Group List Report</h1>
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
      Group Name
    </th>
    <th style="font-size: 30px;" class="column1">
    Reg Type
    </th>
    <th style="font-size: 30px;" class="column1">
    Meeting Day
    </th>
    <th style="font-size: 30px;" class="column1">
    Meeting Frequency
    </th>
    <th style="font-size: 30px;" class="column1">
    Meeting Time
    </th>
    <th style="font-size: 30px;" class="column1">
    Meeting Location
    </th>
      </tr>
    </thead>
  <tbody>
  "'.fill_report($connection).'"
  </tbody>
  </table>
  </main>
  ');
  $file_name = 'Group List Report for '.$intname.'-'.$date.'.pdf';
  $mpdf->Output($file_name, 'D');
?>