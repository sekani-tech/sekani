<?php

$page_title = "Edit Branch";
$destination = "branch.php";
    include("header.php");

?>
<?php
 if (isset($_GET["edit"])) {
  $user_id = $_GET["edit"];
  $update = true;
  $value = mysqli_query($connection, "SELECT * FROM branch WHERE id='$user_id'");

  if (count([$value] == 1)) {
    $n = mysqli_fetch_array($value);
    $name = $n['name'];
    $email = $n['email'];
    $phone = $n['phone'];
    $location = $n['location'];
    $state = $n['state'];
    $lga = $n['lga'];
    $parent_id = $n['parent_id'];
  }
  $df = mysqli_query($connection, "SELECT * FROM branch WHERE id = '$parent_id'");
  $s = mysqli_fetch_array($df);
  $pname = $s['name'];
}
?>
<!-- Content added here -->
<?php
                      function fill_branch($connection)
                      {
                        $us_id = $_GET["edit"];
                        $sint_id = $_SESSION["int_id"];
                        $org = "SELECT * FROM branch WHERE int_id = '$sint_id'";
                        $res = mysqli_query($connection, $org);
                        $output = '';
                        while ($row = mysqli_fetch_array($res))
                        {
                          $cyr_id = $row["id"];
                          if($us_id == $cyr_id){
                            $output .= '<option hidden value = "'.$row["id"].'"> '.$row["name"].' </option>';
                          }
                          else{
                          $output .= '<option value = "'.$row["id"].'"> '.$row["name"].' </option>';
                          }
                        }
                        return $output;
                      }
                              function fill_in($connection)
                              {
                                $sint_id = $_SESSION["int_id"];
                                $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' && parent_id !='0' && classification_enum = '1' && disabled = '0' ORDER BY name ASC";
                                $res = mysqli_query($connection, $org);
                                $output = '';
                                while ($row = mysqli_fetch_array($res))
                                {
                                  $output .= '<option value = "'.$row["gl_code"].'"> '.$row["name"].' </option>';
                                }
                                return $output;
                              }
                          function fill_state($connection)
                            {
                            $org = "SELECT * FROM states";
                            $res = mysqli_query($connection, $org);
                            $out = '';
                            while ($row = mysqli_fetch_array($res))
                            {
                              $out .= '<option value="'.$row["name"].'">' .$row["name"]. '</option>';
                            }
                            return $out;
                            }?>
                  <script>
                    $(document).ready(function() {
                      $('#static').on("change", function(){
                        var id = $(this).val();
                        $.ajax({
                          url:"ajax_post/lga.php",
                          method:"POST",
                          data:{id:id},
                          success:function(data){
                            $('#showme').html(data);
                          }
                        })
                      });
                    });
                </script>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Create new Branch</h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                  <form action="../functions/branch_update.php" method="post">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Name</label>
                          <input type="text" value="<?php echo $name;?>" class="form-control" name="name">
                          <input type="text" hidden value="<?php echo $user_id;?>" class="form-control" name="id">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Email</label>
                          <input type="text" value="<?php echo $email;?>" class="form-control" name="email">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Phone</label>
                          <input type="number" value="<?php echo $phone;?>" class="form-control" name="phone">
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <label class="bmd-label-floating">Location</label>
                          <input type="text" value="<?php echo $location;?>" class="form-control" name="location">
                        </div>
                      </div>
                      
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">State:</label>
                          <select id="static" class="form-control" style="text-transform: uppercase;" name="state">
                          <option hidden value="<?php echo $state;?>"><?php echo $state;?></option>
                          <?php echo fill_state($connection);?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-check-label">LGA</label>
                          <select id="showme" class="form-control" style="text-transform: uppercase;" name="lga">
                          <option hidden value="<?php echo $lga;?>"><?php echo $lga;?></option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-check-label">Parent Branch</label>
                          <select class="form-control" name="parent_bid">
                          <option hidden value = "<?php echo $parent_id;?>"><?php echo $pname;?></option>
                          <?php echo fill_branch($connection);?>
                          </select>
                        </div>
                      </div>
                      </div>
                      <a href="client.php" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary pull-right">Update Branch</button>
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