<?php

$page_title = "Create Branch";
$destination = "branch.php";
    include("header.php");

?>
<?php
                      function fill_branch($connection)
                      {
                        $sint_id = $_SESSION["int_id"];
                        $org = "SELECT * FROM branch WHERE int_id = '$sint_id'";
                        $res = mysqli_query($connection, $org);
                        $output = '';
                        while ($row = mysqli_fetch_array($res))
                        {
                          $output .= '<option value = "'.$row["id"].'"> '.$row["name"].' </option>';
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
                  <form action="../functions/branch_upload.php" method="post">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Name</label>
                          <input type="text" class="form-control" name="name">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Email</label>
                          <input type="email" class="form-control" name="email">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Phone</label>
                          <input type="tel" class="form-control" name="phone">
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <label class="bmd-label-floating">Location</label>
                          <input type="text" class="form-control" name="location">
                        </div>
                      </div>
                      
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">State:</label>
                          <select id="static" class="form-control" style="text-transform: uppercase;" name="state">
                          <?php echo fill_state($connection);?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-check-label">LGA</label>
                          <select id="showme" class="form-control" style="text-transform: uppercase;" name="lga">
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-check-label">Parent Branch</label>
                          <select class="form-control" style="text-transform: uppercase;" name="parent_bid">
                          <option value = "0">select parent Branch</option>
                          <?php echo fill_branch($connection);?>
                          </select>
                        </div>
                      </div>
                      <div class=" col-md-4 form-group">
                          <label for="form-check-label">Vault GL</label>
                          <select name="income_gl" id="" class="form-control">
                              <option value="">Choose Vault Account Gl</option>
                              <?php echo fill_in($connection) ?>
                          </select>
                      </div>
                      </div>
                      <a href="client.php" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary pull-right">Create Branch</button>
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