
<?php

$page_title = "New Client";
$destination = "client.php";
include("header.php");

?>
<script src="../datatable/DropdownSelect.js"></script>
<!-- Content added here -->
<div class="content">
    <div class="container-fluid">
      <!-- your content here -->
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Create new Client</h4>
              <p class="card-category">Fill in all important data</p>
            </div>
            <div class="card-body">
              <form action="../functions/institution_client_upload.php" method="post" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Account Type</label>
                      <?php
                  function fill_savings($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM savings_product WHERE int_id = '$sint_id'";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                  }
                  return $out;
                  }
                  ?>
                        <select required name="acct_type" class="form-control" data-style="btn btn-link" id="collat">
                          <option value="">select a Account Type</option>
                          <?php echo fill_savings($connection); ?>
                        </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Client Type</label>
                      <select required name="ctype" class="form-control" id="tom">
                          <option value="">select</option>
                          <option value="Individual">Individual Account</option>
                          <option value="Joint">Joint Account</option>
                          <option value="Corporate">Corporate Account</option>
                        </select>
                    </div>
                  </div>
                  <script>
                    $(document).ready(function() {
                      $('#tom').on("change", function(){
                        var id = $(this).val();
                        $.ajax({
                          url:"ajax_post/client_type.php",
                          method:"POST",
                          data:{id:id},
                          success:function(data){
                            $('#client').html(data);
                          }
                        })
                      });
                    });
                </script>
                 
                </div>
                <div id="client">
                    </div>
                    <div id="maenn" hidden>
                    <div class="col-md-4">
            <div class="form-group">
                <label for="">State:</label>
                <select class="form-control" style="text-transform: uppercase;" name="state" id="selState" onchange="configureDropDownLists()">
                </select>
                
            </div>
            </div>
            <div class="col-md-4">
            <label for="">LGA:</label>
                <select  class="form-control" style="text-transform: uppercase;" name="lga" id="selCity">
                </select>
            </div>
                    </div>
                <a href="client.php" class="btn btn-danger">Back</a>
                <button type="submit" name="submit" id="submit" class="btn btn-primary pull-right">Create Client</button>
                <div class="clearfix"></div>
              </form>
            </div>
          </div>
        </div>
        <!-- /form card -->
      </div>
      <!-- /content -->
    </div>
  </div>

<?php

include("footer.php");

?>
