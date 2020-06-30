<?php

$page_title = "GL template";
$destination = "branch.php";
    include("header.php");

?>
<?php
if (isset($_GET["message1"])) {
  $key = $_GET["message1"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "General Ledger Assigned",
          text: "Activities are now being recorded",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
}
else if (isset($_GET["message2"])) {
$key = $_GET["message2"];
// $out = $_SESSION["lack_of_intfund_$key"];
$tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
echo '<script type="text/javascript">
$(document).ready(function(){
    swal({
        type: "error",
        title: "Error Assigning Ledger",
        text: "Contact TechSupport.",
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
                  <h4 class="card-title">Assign New GL Template</h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                  <form action="../functions/assign_gl.php" method="post">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">System Function</label>
                          <select name="system" id="selctttype" class="form-control">
                          <option value="" hidden>select an option</option>
                          <option value="1">Vault</option>
                          <option value="2">Charges</option>
                          <option value="3">Tellers</option>
                          </select>
                        </div>
                        <script>
                    $(document).ready(function () {
                      $('#selctttype').on("change", function () {
                        var id = $(this).val();
                        $.ajax({
                          url: "ajax_post/select_portal.php", 
                          method: "POST",
                          data:{id:id},
                          success: function (data) {
                            $('#rerer').html(data);
                          }
                        })
                      });
                    });
                  </script>
                      </div>
                      <!-- <div id ="worl" class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Current GL Assigned to:</label>
                          <input class="form-control" type="text" id="idq3" value="">
                        </select>
                        </div> 
                      </div> -->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Classification</label>
                          <select class="form-control" name="class_type" id="clickit">
                            <option value="">Select an option</option>
                            <option value="1">ASSET</option>
                            <option value="2">LIABILITY</option>
                            <option value="3">EQUITY</option>
                            <option value="4">INCOME</option>
                            <option value="5">EXPENSE</option>
                        </select>
                        </div>
                      </div>
                      <script>
                    $(document).ready(function () {
                      $('#clickit').on("change", function () {
                        var id = $(this).val();
                        $.ajax({
                          url: "ajax_post/select_gl.php", 
                          method: "POST",
                          data:{id:id},
                          success: function (data) {
                            $('#collect').html(data);
                          }
                        })
                      });
                    });
                  </script>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">GL Report</label>
                          <select class="form-control" name="gl_code" id="collect">
                            <option value="">Select an option</option>
                        </select>
                        </div>
                      </div>
                      <div class="col-md-8" id="rerer">
                        <div class="form-group">
                          <label class="bmd-label-floating">Portal</label>
                          <!-- <select class="form-control">
                              <option>select an option</option>
                          </select> -->
                        </div>
                      </div>
                      </div>
                      <a href="client.php" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary pull-right">Assign</button>
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