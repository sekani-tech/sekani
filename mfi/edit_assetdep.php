<?php

$page_title = "Asset Type Setup";
$destination = "branch.php";
    include("header.php");

?>
<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sesint_id = $_SESSION['int_id'];
    // check the button value
    $name = $_POST['name'];
    $dep = $_POST['dep'];
    $us_id = $_POST['id'];

        $wen = "UPDATE asset_type SET asset_name = '$name', depreciation_value= '$dep' WHERE int_id = '$sesint_id' AND id = '$us_id'";
        $quoery = mysqli_query($connection, $wen);

        if($quoery){
        echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "success",
                title: "Created Successfully",
                text: "Values Updated",
                showConfirmButton: false,
                timer: 2000
            })
        });
        </script>
        ';
        $URL="dep_setup.php";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
        
      }
      else{
        echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "error",
                title: "Failed",
                text: "Value Update failed",
                showConfirmButton: false,
                timer: 2000
            })
        });
        </script>
        ';
      }
    }
?>
<?php
 if (isset($_GET["edit"])) {
  $user_id = $_GET["edit"];
  $update = true;
  $value = mysqli_query($connection, "SELECT * FROM asset_type WHERE id='$user_id'");
  if ($value) {
    $n = mysqli_fetch_array($value);
    $name = $n['asset_name'];
    $branch = $n['branch_id'];
    $depval = $n['depreciation_value'];
  }
  $df = mysqli_query($connection, "SELECT * FROM branch WHERE id = '$branch'");
  $s = mysqli_fetch_array($df);
  $pname = $s['name'];
}

function fill_in($connection)
  {
    $sint_id = $_SESSION["int_id"];
    $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' AND parent_id !='0' AND name LIKE '%depreciation%' AND classification_enum = '1' AND disabled = '0' ORDER BY name ASC";
    $res = mysqli_query($connection, $org);
    $output = '';
    while ($row = mysqli_fetch_array($res))
    {
      $output .= '<option value = "'.$row["gl_code"].'"> '.$row["name"].' </option>';
    }
    return $output;
  }
?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Setup Asset Type</h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                  <form method="POST">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Asset Name</label>
                          <input type="text" value="<?php echo $name;?>" class="form-control" name="name">
                          <input type="text" hidden value="<?php echo $user_id;?>" class="form-control" name="id">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label class="bmd-label-floating">Depreciation Value(%)</label>
                          <input type="text" value="<?php echo $depval;?>" class="form-control" name="dep">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label class="bmd-label-floating">Depreciation GL</label>
                          <select type="text" class="form-control" name="gl_code">
                          <?php echo fill_in($connection);?>
                          </select>
                        </div>
                      </div>
                      </div>
                      <a href="client.php" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary pull-right">Update Asset Type</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- /content -->
        </div>
      </div>
<?php
    include("footer.php");

?>