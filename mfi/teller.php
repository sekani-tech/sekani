<?php

$page_title = "Teller Report";
$destination = "index.php";
    include("header.php");

?>

<?php
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
                  <h4 class="card-title">Teller Report</h4>
                  <!-- <p class="card-category">Fill in all important data</p> -->
                </div>
                <div class="card-body">
                  <form action="" method="POST">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Start Date</label>
                          <input type="date" value="" name="" class="form-control" id="start">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">End Date</label>
                          <input type="date" value="" name="" class="form-control" id="end">
                          <input type="text" id="int_id" hidden name="" value="<?php echo $sessint_id;?>" class="form-control" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <!-- populate from db -->
                            <select name="branch" class="form-control" id="input" required>
                          <option value="">select an option</option>
                          <?php echo fill_client($connection); ?>
                          <script>
                              $(document).ready(function() {
                                $('#input').change(function(){
                                  var id = $(this).val();
                                  var int_id = $('#int_id').val();
                                  $.ajax({
                                    url:"ajax_post/create_teller_branch.php",
                                    method:"POST",
                                    data:{id:id, int_id:int_id},
                                    success:function(data) {
                                      $('#show_branchx').html(data);
                                    }
                                  })
                                });
                              })
                            </script>
                        </div>
                      </div>
                      <div class="col-md-4">
                          <!-- populate from db -->
                          <div class="form-group">
                          <select id="" name="tell_name" class="form-control" required>
                          </select>
                          <div id="show_branchx"></div>
                          </div>
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
                        var branch = $('#input').val();
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
                            <input type="text" name="" id="" class="form-control" readonly>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="">Branch</label>
                            <input type="text" name="" id="" class="form-control" readonly>
                        </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">As at:</label>
                          <input type="text" name="" class="form-control" id="" readonly>
                        </div>
                      </div>
                      </div>
                    <div class="clearfix"></div>
                  </form>
                  <div class="table-responsive">
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
            <!-- end  -->
          </div>
          <!-- /content -->
        </div>
      </div>

<?php

    include("footer.php");

?>