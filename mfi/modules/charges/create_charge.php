<?php

$page_title = "Create Charge";
$destination = "products_config.php";
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
                  <h4 class="card-title">Create Charge</h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                  <form action="../functions/charge_upload.php" method="POST">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Name</label>
                          <input type="text" class="form-control" name="name">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <!-- populate from db -->
                          <label class="bmd-label-floating">Product</label>
                          <select name="product" id="" class="form-control">
                              <option value="1">Loan</option>
                              <option value="2">Savings</option>
                              <option value="3">Shares</option>
                              <option value="4">Current</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Charge Type</label>
                          <select name="charge_type" id="ok" class="form-control">
                              <option value="1">Disbursement</option>
                              <option value="2">Specified Due Date</option>
                              <option value="3">Installment Fees</option>
                              <option value="4">Overdue Installment Fees</option>
                              <option value="5">Disbursement - Paid with Repayment</option>
                              <option value="6">Loan Rescheduliing Fee</option>
                              <option value="7">Transaction</option>
                          </select>
                        </div>
                      </div>
                      <script>
                    $(document).ready(function() {
                      $('#ok').on("change", function(){
                        var id = $(this).val();
                        $.ajax({
                          url:"ajax_post/specified_date.php",
                          method:"POST",
                          data:{id:id},
                          success:function(data){
                            $('#okay').html(data);
                          }
                        })
                      });
                    });
                </script>
                <div class="col-md-4" id = "okay">
                </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Amount</label>
                          <input type="number" step=".01" class="form-control" name="amount">
                        </div>
                      </div>
                      <div class=" col-md-4 form-group">
                          <label for="bmd-label-floating">Charge Option</label>
                          <select name="charge_option" id="" class="form-control">
                              <option value="1">Flat</option>
                              <option value="2">Principal Due</option>
                              <option value="3">Principal + Interest Due on Installment</option>
                              <option value="4">Interest Due on Installment</option>
                              <option value="5">Total Oustanding Loan Principal</option>
                              <option value="6">Original Loan Principal</option>
                              <option value="7">Percentage</option>
                          </select>
                      </div>
                      <div class=" col-md-4 form-group">
                          <label for="bmd-label-floating">Charge Payment Mode</label>
                          <select name="charge_payment" id="" class="form-control">
                              <option value="1">Regular</option>
                              <option value="2">Account Transfer</option>
                          </select>
                      </div>
                      <div class=" col-md-4 form-group">
                      <?php
                              function fill_in($connection)
                              {
                                $sint_id = $_SESSION["int_id"];
                                $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' && parent_id !='0' && classification_enum = '4' && disabled = '0' ORDER BY gl_code ASC";
                                $res = mysqli_query($connection, $org);
                                $output = '';
                                while ($row = mysqli_fetch_array($res))
                                {
                                  $output .= '<option value = "'.$row["gl_code"].'"> '.$row["name"].' </option>';
                                }
                                return $output;
                              }
                              ?>
                          <label for="bmd-label-floating">Income GL</label>
                          <select name="Income_gl" id="" class="form-control">
                              <option value="">Choose Income Account Gl</option>
                              <?php echo fill_in($connection) ?>
                          </select>
                      </div>
                      <div class=" col-md-2 form-group">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" name="is_pen" type="checkbox" value="1">
                                Penalty
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                        </div>
                        <div class=" col-md-2 form-group">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" name="is_active" type="checkbox" value="1">
                                Active
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                        </div>
                        <div class=" col-md-2 form-group">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" name="allow_over" type="checkbox" value="1">
                                Allowed to Override
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                      </div>
                      </div>
                      <a href="products_config.php" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary pull-right">Create Charge</button>
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