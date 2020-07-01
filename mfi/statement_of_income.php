<?php

$page_title = "STATEMENT OF INCOME";
$destination = "report_financial.php";
include('header.php');

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
                    <h4 class="card-title">Statement of Income</h4>
                </div>
                <div class="card-body">
                <form action="">
                    <div class="row">
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
                        <label for="">Start Date</label>
                        <input type="date" name="" id="start" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">End Date</label>
                        <input type="date" name="" id="end" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Branch</label>
                        <select name="" id="" class="form-control">
                        <?php echo fill_branch($connection);?>
                        </select>
                      </div>
                      <!-- <div class="form-group col-md-3">
                        <label for="">Break Down per Branch</label>
                        <select name="" id="" class="form-control">
                            <option value="">No</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
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
              </div>
              <!-- <div class="card">
                <div class="card-body">
                  <form action="">
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label for="">Initial Year</label>
                        <select name="" id="" class="form-control">
                          <option value="">2018</option>
                          <option value="">2019</option>
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="">Comparing Year</label>
                        <select name="" id="" class="form-control">
                          <option value="">2018</option>
                          <option value="">2019</option>
                        </select>
                      </div>
                    </div>
                  </form>
                </div>
              </div> -->
              <script>
                    $(document).ready(function () {
                      $('#input').on("click", function () {
                        var start = $('#start').val();
                        var end = $('#end').val();
                        $.ajax({
                          url: "ajax_post/reports_post/stmt_of_income.php", 
                          method: "POST",
                          data:{start:start, end:end},
                          success: function (data) {
                            $('#outjournal').html(data);
                          }
                        })
                      });
                    });
                  </script>
              <div id="outjournal" class="col-md-10">

              </div>
          </div>
        </div>
      </div>

<?php

include('footer.php');

?>