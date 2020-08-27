<?php

$page_title = "Track Dormancy";
$destination = "report_financial.php";
include('header.php');

?>
<?php
$today = date('Y-m-d');
$year = date('Y');
$sdoins =$year."-01-01";
$endtime = strtotime($sdoins);
$startdate = date("Y-m-d", strtotime("-1 day", $endtime));
?>
<!-- Content added here -->
<!-- print content -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Track Dormancy</h4>
                </div>
                <div class="card-body">
                <form action="">
                    <div class="row">
                    <div class="form-group col-md-3">
                        <label for="">Select Dormancy Date</label>
                        <select name="" id="dorm" class="form-control">
                            <option value="90">90 Days</option>
                            <option value="180">180 Days</option>
                            <option value="365">365 Days</option>
                        </select>
                      </div>
                      <?php
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
                      <div class="form-group col-md-3">
                        <label for="">Branch</label>
                        <select name="" id="bran" class="form-control">
                            <?php echo fill_branch($connection); ?>
                        </select>
                      </div>
                    </div>
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <span id="input" type="submit" class="btn btn-primary">Run report</span>
                  </form>
                </div>
                <script>
                    $(document).ready(function () {
                      $('#input').on("click", function () {
                        var dorm = $('#dorm').val();
                        var bran = $('#bran').val();
                        $.ajax({
                          url: "ajax_post/trk_dorm.php", 
                          method: "POST",
                          data:{dorm:dorm, bran:bran},
                          success: function (data) {
                            $('#outjournal').html(data);
                          }
                        })
                      });
                    });
                  </script>
            </div>
            <div id="outjournal" class="col-md-12">

              </div>
          </div>
        </div>
      </div>

<?php

include('footer.php');

?>