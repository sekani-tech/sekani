<?php
$output = '';
include("../functions/connect.php");
session_start();
?>
<?php
  $intname = $_SESSION['int_name'];
  $branch_id = $_SESSION["branch_id"];
  $date = date('d/m/Y');
  $month = $_POST["month"];
  function branch_opt($connection)
{  
    $br_id = $_SESSION["branch_id"];
    $sint_id = $_SESSION["int_id"];
    $dff = "SELECT * FROM branch WHERE int_id ='$sint_id' AND id = '$br_id' || parent_id = '$br_id'";
    $dof = mysqli_query($connection, $dff);
    $out = '';
    while ($row = mysqli_fetch_array($dof))
    {
      $do = $row['id'];
    $out .= " OR branch_id ='$do'";
    }
    return $out;
}
$br_id = $_SESSION["branch_id"];
$sessint_id = $_SESSION['int_id'];
$branches = branch_opt($connection);

  // $staff = $_POST["staff"];
  $branchquery = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch_id'");
    if (count([$branchquery]) == 1) {
      $ans = mysqli_fetch_array($branchquery);
      $branch = $ans['name'];
      $branch_email = $ans['email'];
      $branch_location = $ans['location'];
      $branch_phone = $ans['phone'];
    }
    if($month =="0"){
        $mog = date('Y');
       $ns = date('m');
       $std = date('Y-m-d');
       $dar = date('F');
       $curren = $mog."-".$ns."-01";
       $curdate = $dar.", ".$mog;
    }
    else if($month =="1"){
       $mog = date('Y');
       $ns = "-01-01";
       $ms ="-01-31";
       $curren = $mog.$ns;
       $std = $mog.$ms;
        $curdate = "Jan, ".$mog;
    }
    else if($month =="2"){
        $mog = date('Y');
        $ns = "-02-01";
        $ms ="-02-28";
        $curren = $mog.$ns;
        $std = $mog.$ms;
        $curdate = "Feb, ".$mog;
     }
     else if($month =="3"){
        $mog = date('Y');
        $ns = "-03-01";
        $ms ="-03-31";
        $curren = $mog.$ns;
        $std = $mog.$ms;
        $curdate = "Mar, ".$mog;
        
     }
     else if($month =="4"){
        $mog = date('Y');
        $ns = "-04-01";
        $ms ="-04-30";
        $curren = $mog.$ns;
        $std = $mog.$ms;
        $curdate = "Apr, ".$mog;
     }
     else if($month =="5"){
        $mog = date('Y');
        $ns = "-05-01";
        $ms ="-05-31";
        $curren = $mog.$ns;
        $std = $mog.$ms;
        $curdate = "May, ".$mog;
     }
     else if($month =="6"){
        $mog = date('Y');
        $ns = "-06-01";
        $ms ="-06-30";
        $curren = $mog.$ns;
        $std = $mog.$ms;
        $curdate = "Jun, ".$mog;
     }
     else if($month =="7"){
        $mog = date('Y');
        $ns = "-07-01";
        $ms ="-07-31";
        $curren = $mog.$ns;
        $std = $mog.$ms;
        $curdate = "Jul, ".$mog;
     }
     else if($month =="8"){
        $mog = date('Y');
        $ns = "-08-01";
        $ms ="-08-31";
        $curren = $mog.$ns;
        $std = $mog.$ms;
        $curdate = "Aug, ".$mog;
     }
     else if($month =="9"){
        $mog = date('Y');
        $ns = "-09-01";
        $ms ="-09-30";
        $curren = $mog.$ns;
        $std = $mog.$ms;
        $curdate = "Sep, ".$mog;
     }
     else if($month =="10"){
        $mog = date('Y');
        $ns = "-10-01";
        $ms ="-10-31";
        $curren = $mog.$ns;
        $std = $mog.$ms;
        $curdate = "Oct, ".$mog;
     }
     else if($month =="11"){
        $mog = date('Y');
        $ns = "-11-01";
        $ms ="-11-30";
        $curren = $mog.$ns;
        $std = $mog.$ms;
        $curdate = "Nov, ".$mog;
     }
     else if($month =="12"){
        $mog = date('Y');
        $ns = "-12-01";
        $ms ="-12-31";
        $curren = $mog.$ns;
        $std = $mog.$ms;
        $curdate = "Dec, ".$mog;
     }
  function fill_report($connection, $curren, $std, $br_id, $branches)
        {
            $out = '';
            $sessint_id =$_SESSION['int_id'];
          // import
        //   $glcode = $_POST['glcode'];
        $query = "SELECT * FROM groups WHERE int_id = '$sessint_id' && status = 'Approved' AND (branch_id ='$br_id' $branches) && submittedon_date BETWEEN '$curren' AND '$std'";
        $result = mysqli_query($connection, $query);
        while ($q = mysqli_fetch_array($result, MYSQLI_ASSOC))
          {
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
<h1>'.$_SESSION["int_full"].' <br/> Groups registered on '.$curdate.'</h1>
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
  "'.fill_report($connection, $curren, $std, $br_id, $branches).'"
  </tbody>
  </table>
  </main>
  ');
  $file_name = 'Registered Group Report for '.$intname.'-'.$curdate.'.pdf';
  $mpdf->Output($file_name, 'D');
?>