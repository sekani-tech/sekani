<?php

$page_title = "Create Teller";
$destination = "staff_mgmt.php";
    include("header.php");

    function fill_client($connection) {
      $sint_id = $_SESSION["int_id"];
      $org = "SELECT * FROM branch WHERE int_id = '$sint_id'";
      $res = mysqli_query($connection, $org);
      $out = '';
      while ($row = mysqli_fetch_array($res))
      {
        $out .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
      }
      return $out;
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
                  <h4 class="card-title">Create teller</h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                  <form action="../functions/teller_upload.php" method="POST">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Branch</label>
                          <select name="branch" class="form-control" id="input">
                          <option value="">select an option</option>
                          <?php echo fill_client($connection); ?>
                        </select>
                        </div>
                      </div>
                  <script>
                              $(document).ready(function() {
                                $('#input').change(function(){
                                  var id = $(this).val();
                                  var tell_name = $('#input').val();
                                  var int_id = $('#int_id').val();
                                  $.ajax({
                                    url:"create_teller_branch.php",
                                    method:"POST",
                                    data:{id:id, int_id:int_id},
                                    success:function(data){
                                      $('#show_branch').html(data);
                                    }
                                  })
                                });
                              })
                            </script>
                            <!-- another -->
                            <!-- da -->
                      <div class="col-md-4">
                      <div class="form-group">
                        <label class="bmd-label-floating">Teller Name</label>
                        <!-- <div id="show_branch"></div> -->
                        <select id="show_branch" name="branch" class="form-control">

                        </select>
                      </div>
                      </div>
                      <div class="col-md-4 form-group">
                      <script>
                              $(document).ready(function() {
                                $('#tell_desc').change(function(){
                                  var me = $(this).val();
                                  var id = $('#input').val();
                                  var tell_name = $('#input').val();
                                  var int_id = $('#int_id').val();
                                  $.ajax({
                                    url:"ajax_post/tellme.php",
                                    method:"POST",
                                    data:{id:id, int_id:int_id, me:me},
                                    success:function(data){
                                      $('#tellers').html(data);
                                    }
                                  })
                                });
                              })
                        </script>
                          <label class="bmd-label-floating" >Description</label>
                          <input type="text" name="teller_no" id="tell_desc" class="form-control">
                          <div id="tellers"></div>
                          <input type="text" id="int_id" value="<?php echo $sessint_id; ?>" hidden class="form-control">
                          <!-- damn -->
                      </div>
                      <div class="col-md-4 form-group">
                          <label class="bmd-label-floating" >Posting Limit</label>
                          <input type="number" name="post_limit" id="" class="form-control">
                      </div>
                      </div>
                      <a href="staff_mgmt.php" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary pull-right">Create Teller</button>
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