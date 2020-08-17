<?php

$page_title = "STATEMENT OF FINANCIAL POSITION";
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
                    <h4 class="card-title">Statement of Financial Position</h4>
                </div>
                <div class="card-body">
                <form action="">
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label for="">As At:</label>
                        <input type="date" name="" value="<?php echo $today?>" id="end" class="form-control">
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
                        <select name="" id="brne" class="form-control">
                            <?php echo fill_branch($connection); ?>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label for=""></label>
                        <input type="date" hidden value="<?php echo $startdate; ?>" name="" id="start" class="form-control">
                      </div>
                      <!-- <div class="form-group col-md-3">
                        <label for="">Break Down per Branch</label>
                        <select name="" id="" class="form-control">
                            <option value="">No</option>
                        </select>
                      </div> -->
                      <!-- <div class="form-group col-md-3">
                        <label for="">Hide Zero Balances</label>
                        <select name="" id="" class="form-control">
                            <option value="">No</option>
                        </select>
                      </div> -->
                    </div>
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <span id="input" type="submit" class="btn btn-primary">Run report</span>
                  </form>
                </div>
                <script>
                    $(document).ready(function () {
                      $('#input').on("click", function () {
                        var start = $('#start').val();
                        var end = $('#end').val();
                        var branch = $('#brne').val();
                        $.ajax({
                          url: "ajax_post/reports_post/stmt_of_fp.php", 
                          method: "POST",
                          data:{start:start, end:end},
                          success: function (data) {
                            $('#outjournal').html(data);
                          }
                        })
                      });
                    });
                  </script>
            </div>
            <div id="outjournal" class="col-md-10">

              </div>
          </div>
        </div>
      </div>

<?php

include('footer.php');

?>