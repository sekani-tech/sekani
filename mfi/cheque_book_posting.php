<?php

$page_title = "CHQ/Pass Book Posting";
$destination = "index.php";
    include("header.php");

?>
<?php
  if (isset($_GET["message1"])) {
    $key = $_GET["message1"];
    $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
    // $out = $_SESSION["lack_of_intfund_$key"];
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "success",
            title: "Posting Successful",
            text: "Cheque book has been posted",
            showConfirmButton: false,
            timer: 2000
        })
    });
    </script>
    ';
    $_SESSION["lack_of_intfund_$key"] = 0;
  }
}
// If it is not successfull, It will show this message
else if (isset($_GET["message2"])) {
  $key = $_GET["message2"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  // $out = $_SESSION["lack_of_intfund_$key"];
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Error",
          text: "Error During Posting",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
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
                                $('#acc_name').change(function(){
                                  var id = $(this).val();
                                  $.ajax({
                                    url:"ajax_post/chq_accno.php",
                                    method:"POST",
                                    data:{id:id},
                                    success:function(data){
                                      $('#showing').html(data);
                                    }
                                  })
                                });
                              })
                            </script>
                        <div class="form-group">
                          <label class="bmd-label-floating"> Accural Name</label>
                          <select name="acc_name" class="form-control" id="acc_name">
                          <option value="">select an option</option>
                          <?php echo fill_client($connection); ?>
                        </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Account No</label>
                          <select name="acc_no" class="form-control" id="showing">
                          <option value="">select an option</option>
                        </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">No of Leaves</label>
                          <select name="no_leaves" class="form-control" id="acc_name">
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
                    <button type="submit" class="btn btn-primary pull-right">Post Cheque</button>
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