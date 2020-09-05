<?php

$page_title = "Track Dormancy";
$destination = "report_financial.php";
include('header.php');

?>
<!-- Content added here -->
<?php
$int_id = $_SESSION['int_id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $efd = $_POST['submit'];
  if($efd == "subs"){
    $ina = $_POST['inactive'];
    $dor = $_POST['dormant'];
    $arc = $_POST['archive'];

    $sdoi = "SELECT * FROM dormancy_counter WHERE int_id = '$int_id'";
    $dsio = mysqli_query($connection, $sdoi);
    $yr = mysqli_fetch_array($dsio);
    $fi = $yr['int_id'];
    $dskj = $yr['day_to_inactive'];
    $sdio = $yr['day_to_dormancy'];
    $aspo = $yr['day_to_archive'];

    $user_id = $_SESSION['user_id'];
    $date = date('Y-m-d');
    if($fi == $int_id & $dskj == $ina & $sdio == $dor & $aspo == $arc){

    }
    else if($fi == $int_id){
      $ioi = "UPDATE dormancy_counter SET day_to_inactive = '$ina', day_to_dormancy = '$dor', day_to_archive = '$arc', updated_on = '$date', updated_by = '$user_id' WHERE int_id = '$int_id'";
      $fkd = mysqli_query($connection, $ioi);
    }
    else{
      $ioi = "INSERT INTO `dormancy_counter` (`int_id`, `day_to_inactive`, `day_to_dormancy`, `day_to_archive`, `updated_on`, `updated_by`)
       VALUES ('$int_id', '$ina', '$dor', '$arc', '$date', '$user_id')";
      $fkd = mysqli_query($connection, $ioi);
    }
  }
  if($fkd){
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
         type: "success",
          title: "Success",
            text: "Dormancy Days set!",
         showConfirmButton: false,
       timer: 2000
        })
        });
 </script>';
 $URL="../mfi/trk_dormant.php?message1=$randms";

 echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
  }
}
?>
<?php
$today = date('Y-m-d');
$wpem = "SELECT * FROM dormancy_counter WHERE int_id = '$int_id'";
$wp = mysqli_query($connection, $wpem);
$erer = mysqli_fetch_array($wp);
$inactive = $erer['day_to_inactive'];
$dormant = $erer['day_to_dormancy'];
$archive = $erer['day_to_archive'];
?>
<!-- print content -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Track Dormancy</h4>
                </div>
                <div class="card-body">
                <form method = "POST">
                    <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Days to Inactive</label>
                          <input type="text" value="<?php echo $inactive;?>" class="form-control" name="inactive">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Days to Dormancy</label>
                          <input type="text" value="<?php echo $dormant;?>" class="form-control" name="dormant">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Days to Archive</label>
                          <input type="text" value="<?php echo $archive;?>" class="form-control" name="archive">
                        </div>
                      </div>
                    </div>
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <button id="input" name ="submit" type="submit" value="subs" class="btn btn-primary">Set Days</button>
                  </form>
                </div>
            </div>
            <div id="outjournal" class="col-md-12">

              </div>
          </div>
        </div>
      </div>

<?php

include('footer.php');

?>