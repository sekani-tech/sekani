<?php

$page_title = "Financial Report";
$destination = "report_financial.php";
    include("header.php");
?>
<?php
 if (isset($_GET["view24"])) {
?>

 <?php
 }
 else if(isset($_GET["view25"])){
 ?>
 <div class="content">
        <div class="container-fluid">
                    <!-- your content here -->
                    <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                <h4 class="card-title">General Ledger Report</h4>
            </div>
            <?php
                  function fill_gl($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM acc_gl_account WHERE int_id = '$sint_id' AND (parent_id != '0' || parent_id != '' || parent_id != 'NULL') ORDER BY name ASC";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["gl_code"].'">'.$row["gl_code"].' - '.$row["name"].'</option>';
                  }
                  return $out;
                  }
                  function fill_branch($connection)
                  {
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
                  
                <div class="card-body">
                  <form action="">
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label for="">Start Date</label>
                        <input type="date" name="" id="start" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">End Date</label>
                        <input type="date" name="" id="end" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Branch</label>
                        <select name="" id="branch" class="form-control">
                            <?php echo fill_branch($connection);?>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">GL account</label>
                        <select name="gl_code" id="glcode" class="form-control">
                        <?php echo fill_gl($connection);?>
                        </select>
                      </div>
                    </div>
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <span id="runstructure" type="submit" class="btn btn-primary">Run report</span>
                  </form>
                </div>
              </div>
              <script>
                    $(document).ready(function () {
                      $('#runstructure').on("click", function () {
                        var start = $('#start').val();
                        var end = $('#end').val();
                        var branch = $('#branch').val();
                        var glcode = $('#glcode').val();
                        $.ajax({
                          url: "items/gl_report.php",
                          method: "POST",
                          data:{start:start, end:end, branch:branch, glcode:glcode},
                          success: function (data) {
                            $('#shstructure').html(data);
                          }
                        })
                      });
                    });
                  </script>
              <div id="shstructure" class="card">

              </div>
            </div>
          </div>

        </div>
 </div>
 <?php
 }
 ?>