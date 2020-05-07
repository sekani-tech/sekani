<?php

$page_title = "View teller";
$destination = "staff_mgmt.php";
    include("header.php");
?>
<?php
if(isset($_GET["id"])) {
  $id = $_GET["id"];
  $update = true;
  $query = mysqli_query($connection, "SELECT * FROM tellers WHERE name ='$id' && int_id='$sessint_id'");
  if (count([$query]) == 1) {
    $ans = mysqli_fetch_array($query);
    $id = $ans['id'];
    $int_id = $ans['int_id'];
    $tell_name = $ans['name'];
    $postlimit = $ans['post_limit'];
    $tellerno = $ans['till_no'];
    $tillno = $ans['till'];
    $startdate = $ans['valid_from'];
    $endate = $ans['valid_to'];
    $branch_id = $ans['branch_id'];
    $branchquery = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch_id'");
    if (count([$branchquery]) == 1) {
      $ans = mysqli_fetch_array($branchquery);
      $branch = $ans['name'];
    }
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
                  <h4 class="card-title">Teller Report</h4>
                  <!-- <p class="card-category">Fill in all important data</p> -->
                </div>
                <div class="card-body">
                  <form action="" method="POST">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Start Date</label>
                          <input type="date" value="<?php echo $startdate;?>" name="" class="form-control" id="start">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">End Date</label>
                          <input type="date" value="<?php echo $endate;?>" name="" class="form-control" id="end">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <!-- populate from db -->
                          <label class="bmd-label-floating">Branch</label>
                          <input type="text" id="branch" name="" value="<?php echo $branch;?>" class="form-control" readonly>
                        </div>
                      </div>
                      <div class=" col-md-4 form-group">
                          <!-- populate from db -->
                          <label for="bmd-label-floating">Teller ID</label>
                          <input type="text" id="till" name="" value="<?php echo $tellerno;?>" class="form-control" readonly>
                          <input type="text" id="int_id" name="" value="<?php echo $sessint_id;?>" class="form-control" readonly>
                      </div>
                      </div>
                      <!-- <button type="reset" class="btn btn-danger pull-left">Reset</button> -->
                    <!-- <button class="btn btn-primary pull-right">Run Report</button> -->
                    <div class="clearfix"></div>
                  </form>
                  <button type="reset" class="btn btn-danger pull-left">Reset</button>
                  <button id="run" class="btn btn-primary pull-right">Run Report</button>
                  <!-- writing a code to the run the reort at click -->
                  <script>
                    $(document).ready(function () {
                      $('#run').on("click", function () {
                        var start = $('#start').val();
                        var end = $('#end').val();
                        var branch = $('#branch').val();
                        var teller = $('#till').val();
                        var int_id = $('#int_id').val();
                        $.ajax({
                          url: "run_teller_report.php",
                          method: "POST",
                          data:{start:start, end:end, branch:branch, teller:teller, int_id:int_id},
                          success: function (data) {
                            $('#outjournal').html(data);
                          }
                        })
                      });
                    });
                  </script>
                  <!-- this section is the end of run report -->
                </div>
              </div>
            </div>
            <!-- teller report -->
            <!-- populate for print with above data -->
            <div class="col-md-12">
              <!-- DISPLAY TELLER HERE -->
              <div id="outjournal"></div>
              <!-- END DISPLAY OF TELLER -->
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Name of Institution</h4>
                  <p class="card-category">Teller call over report</p>
                </div>
                <div class="card-body">
                  <form action="" method="post">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="">Name of Teller</label>
                            <input type="text" value="<?php echo $tell_name;?>" name="" id="" class="form-control" readonly>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="">Branch</label>
                            <input type="text" value="<?php echo $branch;?>" name="" id="" class="form-control" readonly>
                        </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">As at:</label>
                          <input type="date" value="<?php echo $startdate;?>" name="" class="form-control" id="" readonly>
                        </div>
                      </div>
                      </div>
                    <div class="clearfix"></div>
                  </form>
                  <div class="table-responsive">
                  <!-- <script>
                  $(document).ready(function() {
                  $('#tabledat4').DataTable();
                  });
                  </script> -->
                    <table id="tabledat4" class="table" style="width: 100%;">
                      <thead class=" text-primary">
                      <?php
                        //$result = mysqli_query($connection, $query);
                      ?>
                        <!-- <th>
                          ID
                        </th> -->
                        <th>Account Name</th>
                        <th>
                          Opening Balance
                        </th>
                        <th>Deposit</th>
                        <th>
                          Withdrawal
                        </th>
                        <th>Balance</th>
                      </thead>
                      <tbody>
                      <?php //if (mysqli_num_rows($result) > 0) {
                        //while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php //$row["id"]; ?>
                          <th><?php //echo $row["name"]; ?></th>
                          <th><?php //echo $row["description"]; ?></th>
                          <th><?php //echo $row["short_name"]; ?></th>
                          <td></td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <th></th>
                            <th>total deposit</th>
                            <th>total withdrawal</th>
                            <th>total balance</th>
                        </tr>
                        <?php //}
                          //  // echo "0 Document";
                          //}
                          ?>
                      </tbody>
                    </table>
                  </div>
                  <!-- table ends here -->
                  <p><b>Opening Balance:</b> 129 </p>
                  <p><b>Total Deposit:</b> 129 </p>
                  <p><b>Total Withdrawal:</b> 129 </p>
                  <p><b>Closing Balance:</b> 129 </p>
                  <hr>
                  <p><b>Teller Sign:</b> 129                        <b>Date:</b></p>
                  <p><b>Checked By:</b>                             <b>Date/Sign:</b></p>
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