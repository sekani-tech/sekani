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
            <div class="col-md-6">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Dormancy Dates</h4>
                  <!-- Insert number users institutions -->
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                  
                    <table class="rtable display nowrap" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM asset_type WHERE int_id ='$sessint_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <!-- <th>
                          ID
                        </th> -->
                        <th>S/No</th>
                        <th>Status</th>
                        <th>
                         Days
                        </th>
                        <th style="text-align:end;">
                          Edit
                        </th>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>inactive</td>
                          <td><?php echo $inactive;?></td>
                          <td style="text-align:end;"><a href="dromancy_edit.php" class="btn btn-info">Edit</a></td>
                        </tr>
                        <tr>
                          <td>2</td>
                          <td>Dormancy</td>
                          <td><?php echo $dormant;?></td>
                          <td style="text-align:end;"><a href="dromancy_edit.php" class="btn btn-info">Edit</a></td>
                        </tr>
                        <tr>
                          <td>3</td>
                          <td>Archive</td>
                          <td><?php echo $archive;?></td>
                          <td style="text-align:end;"><a href="dromancy_edit.php" class="btn btn-info">Edit</a></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>

<?php

include('footer.php');

?>