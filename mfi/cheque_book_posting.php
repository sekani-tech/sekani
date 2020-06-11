<?php

$page_title = "CHQ/Pass Book Posting";
$destination = "index.php";
    include("header.php");

?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">CHQ Book Portal</h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                  <form action="../functions/chq_upload.php" method="post">
                    <div class="row">
                      <div class="col-md-4">
                          <?php
                           // a function for client data fill
                           function fill_client($connection) {
                            $sint_id = $_SESSION["int_id"];
                            $org = "SELECT * FROM client WHERE int_id = '$sint_id'";
                            $res = mysqli_query($connection, $org);
                            $out = '';
                            while ($row = mysqli_fetch_array($res))
                            {
                              $out .= '<option value="'.$row["id"].'">'.$row["display_name"].'</option>';
                            }
                            return $out;
                          }
                          ?>
                          <script>
                              $(document).ready(function() {
                                $('#client_name').change(function(){
                                  var id = $(this).val();
                                  $.ajax({
                                    url:"ajax_post/chq_accno.php",
                                    method:"POST",
                                    data:{id:id},
                                    success:function(data){
                                      $('#show_product').html(data);
                                    }
                                  })
                                });
                              })
                            </script>
                        <div class="form-group">
                          <label class="bmd-label-floating"> Accural Name</label>
                          <select name="client_id" class="form-control" id="acc_name">
                          <option value="">select an option</option>
                          <?php echo fill_client($connection); ?>
                        </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Account No</label>
                          <select name="acc_no" class="form-control" id="show_product">
                          <option value="">select an option</option>
                        </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">No of Leaves</label>
                          <select name="client_id" class="form-control" id="acc_name">
                          <option value="">select an option</option>
                          <option value="">1-50</option>
                          <option value="">51-100</option>
                          <option value="">101-150</option>
                          <option value="">151-200</option>
                        </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Range No</label>
                          <input type="text" class="form-control" name="range">
                        </div>
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