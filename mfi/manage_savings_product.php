<?php

$page_title = "New Product";
$destination = "index.php";
include("header.php");

?>
<?php
$sint_id = $_SESSION['int_id'];
$fd = "DELETE FROM charges_cache WHERE int_id = '$sint_id'";
$dos = mysqli_query($connection, $fd);
?>
<!-- Content added here -->
<div class="content">
  <div class="container-fluid">
    <!-- your content here -->
    <div class="row">
      <div class="col-md-10">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">Create new Product</h4>
            <p class="card-category">Fill in all important data</p>
          </div>
          <form id="form" action="../functions/int_savings_prod_upload.php" method="POST">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <!-- Each tab equals a stepper page -->
                    <!-- First Tab -->
                    <div class="tab">
                      <h3> New Account Product:</h3>
                      <p>All fields with <span style="color: red;">*</span> are required</p>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Name <span style="color: red;">*</span>:</label>
                            <input type="text" name="name" class="form-control" id="" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="shortLoanName">Short Loan Name <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" name="short_name" value="" placeholder="Short Name..." required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="loanDescription">Description <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" name="description" value="" placeholder="Description...." required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="installmentAmount">Account Type <span style="color: red;">*</span></label>
                            <select class="form-control" name="product_type" required>
                              <option value="1">Current</option>
                              <option value="2">Savings</option>
                              <option value="3">Dollar</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="installmentAmount">Savings Category<span style="color: red;">*</span></label>
                            <select class="form-control" name="saving_cat">
                              <option value="1">Voluntary</option>
                              <option value="2">Compulsory</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="installmentAmount">Auto Create</label>
                            <select class="form-control" name="autocreate">
                              <option value="2">No</option>
                              <option value="1">Yes</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="installmentAmount">Currency <span style="color: red;">*</span></label>
                            <select class="form-control" name="currency" required>
                              <option value="NGN">Nigerian Naira(NGN)</option>
                              <option value="USD">US Dollar($)</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="shortLoanName">Nominal Annual Interest rate <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" name="nominal_int_rate" value="" placeholder="enter value" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="installmentAmount">Compounding Period <span style="color: red;">*</span></label>
                            <select class="form-control" name="compound_period" required>
                              <option value="1">Daily</option>
                              <option value="2">Monthly</option>
                              <option value="3">Quarterly</option>
                              <option value="4">Bi-Annually</option>
                              <option value="5">Annually</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="interestRateApplied">Interest Posting period Type <span style="color: red;">*</span></label>
                            <select class="form-control" name="int_post_type" required>
                              <option value="1">Daily</option>
                              <option value="2">Monthly</option>
                              <option value="3">Quarterly</option>
                              <option value="4">Bi-Annually</option>
                              <option value="5">Annually</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6" hidden>
                          <div class="form-group">
                            <label for="interestMethodology">Interest Calculation Type <span style="color: red;">*</span></label>
                            <select class="form-control" name="int_cal_type" required>
                              <option value="1">Daily Balance</option>
                              <option value="2">Average Daily Balance</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="amortizatioMethody">Interest Calculation Days in Year type <span style="color: red;">*</span></label>
                            <select class="form-control" name="int_cal_days" required>
                              <option value="360">360 days</option>
                              <option value="365">365 days</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="shortLoanName">Minimum Balance <span style="color: red;">*</span></label>
                            <input type="number" class="form-control" name="auto_op_bal" value="" placeholder="1000" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="shortLoanName">Mininmum Balance for Interest Calculation <span style="color: red;">*</span></label>
                            <input type="number" class="form-control" name="min_balance_cal" value="" placeholder="10" required>
                          </div>
                        </div>
                        <div class="col-md-6" hidden>
                          <div class="form-group">
                            <label for="principal">Lockin Period Frequency <span style="color: red;">*</span></label>
                            <div class="row">
                              <div class="col-md-4">
                                <input type="number" class="form-control" name="lock_per_freq" value="" placeholder="Default" required>
                              </div>
                              <div class="col-md-8">
                                <select class="form-control" name="lock_per_freq_time">
                                  <option value="1">Days</option>
                                  <option value="2">Weeks</option>
                                  <option value="3">Months</option>
                                  <option value="4">Years</option>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6" hidden>
                          <div class="form-group">
                            <label for="additionalCharges">Allow OverDraft <span style="color: red;">*</span></label>
                            <select class="form-control" name="allover" required>
                              <option value="2">No</option>
                              <option value="1">Yes</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6" hidden>
                          <div class="form-group">
                            <label for="additionalCharges">Track Dormancy <span style="color: red;">*</span></label>
                            <select class="form-control" name="trk_dormancy" required>
                              <option value="2">No</option>
                              <option value="1">Yes</option>
                            </select>
                          </div>
                        </div>
                        <!-- <div class="col-md-6">
                       <div class="form-group">
                          <label for="additionalCharges" >Enable Withdrawal Notice</label>
                          <select class="form-control" name="with_notice" required>
                            <option value="2">No</option>
                            <option value="1">Yes</option>
                          </select>
                        </div>
                      </div> -->
                      </div>
                    </div>
                    <!-- First Tab -->
                    <!-- Second Tab -->
                    <div class="tab">
                      <h3> Interest Rate Chart :</h3>
                      <div class="form-group">
                        <button type="button" class="btn btn-primary" name="button" onclick="showDialog()"> <i class="fa fa-plus"></i> Add</button>
                      </div>
                      <div class="form-group">
                        <?php
                        $digits = 6;
                        $randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
                        $_SESSION["savings_temp"] = $randms;
                        $tempId = $_SESSION["savings_temp"];
                        $_SESSION["stemp"] = $_SESSION["savings_temp"];
                        $dbcache = $_SESSION["stemp"];
                        $_SESSION["product_temp"] = $randms;
                        ?>
                        <script>
                          $(document).ready(function() {
                            $('#clickit').on("change keyup paste click", function() {
                              var id = $(this).val();
                              var name = $('#nam').val();
                              var start = $('#start').val();
                              var end = $('#end').val();
                              var intrate = $('#intrate').val();
                              var desc = $('#desc').val();
                              $.ajax({
                                url: "interest_rate_chart.php",
                                method: "POST",
                                data: {
                                  id: id,
                                  name: name,
                                  start: start,
                                  end: end,
                                  intrate: intrate,
                                  desc: desc
                                },
                                success: function(data) {
                                  $('#coll').html(data);
                                  document.getElementById("off_me").setAttribute("hidden", "");
                                }
                              })
                            });
                          });
                        </script>
                        <!-- <button class="btn btn-primary pull-right" id="clickit">Add</button> -->
                        <div id="off_me">
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <td>Name</td>
                                <td>From Date</td>
                                <td>End Date</td>
                                <td>Interest Rate</td>
                                <td>Description</td>
                              </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                        </div>
                        <div id="coll"></div>
                      </div>
                      <!-- dialog box -->
                      <div class="form-group">
                        <div id="background">
                        </div>
                        <div id="diallbox">
                          <!-- <form method="POST" action="lend.php" > -->
                          <h3>Add Interest Rate</h3>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating" class="md-3 form-align " for=""> Name:</label>
                              <input type="text" name="col_name" id="nam" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating" for="">Start Date</label>
                              <input type="date" name="col_value" id="start" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating" for="">End Date:</label>
                              <input type="date" name="col_description" id="end" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating" for="">Interest Rate:</label>
                              <input type="number" name="col_value" id="intrate" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating" for="">Description:</label>
                              <input type="text" name="col_value" id="desc" class="form-control">
                            </div>
                          </div>
                          <div style="float:right;">
                            <span class="btn btn-primary pull-right" id="clickit" onclick="AddDlg()">Add</span>
                            <span class="btn btn-primary pull-right" onclick="AddDlg()">Cancel</span>
                          </div>
                          <!-- </form> -->
                          <script>
                            function AddDlg() {
                              var bg = document.getElementById("background");
                              var dlg = document.getElementById("diallbox");
                              bg.style.display = "none";
                              dlg.style.display = "none";
                            }

                            function showDialog() {
                              var bg = document.getElementById("background");
                              var dlg = document.getElementById("diallbox");
                              bg.style.display = "block";
                              dlg.style.display = "block";

                              var winWidth = window.innerWidth;
                              var winHeight = window.innerHeight;

                              dlg.style.left = (winWidth / 2) - 480 / 2 + "px";
                              dlg.style.top = "150px";
                            }
                          </script>
                          <style>
                            #background {
                              display: none;
                              width: 100%;
                              height: 100%;
                              position: fixed;
                              top: 0px;
                              left: 0px;
                              background-color: black;
                              opacity: 0.7;
                              z-index: 9999;
                            }

                            #diallbox {
                              /*initially dialog box is hidden*/
                              display: none;
                              position: fixed;
                              width: 480px;
                              z-index: 9999;
                              border-radius: 10px;
                              padding: 20px;
                              background-color: #ffffff;
                            }
                          </style>
                        </div>
                      </div>
                    </div>
                    <!-- Second Tab -->
                    <!-- Third Tab -->
                    <div class="tab">
                      <h3>Charges</h3>
                      <div class="col-md-2" align="right">
                        <a href="#addEmp" data-toggle="modal" type="button" name="add" class="btn btn-success">Add Charge</a>
                      </div>
                      <table id="empList" class="display table-bordered table-striped" style="width:100%">
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Charge</th>
                            <th>Collected On</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody id="showCharge">

                        </tbody>
                      </table>

                      <script>
                        empRecords = $('#empList').DataTable({
                          bFilter: false
                        });
                      </script>
                      <div class="modal fade" id="addEmp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <center>
                                <h4 class="modal-title" id="myModalLabel">Add New</h4>
                              </center>
                            </div>
                            <div class="modal-body">
                              <div class="container-fluid">
                                <form method="POST">
                                  <input type="text" hidden value="<?php echo $tempId; ?>" id="tempId">
                                  <div class="form-group" <label for="name" class="control-label">Charge</label>
                                    <input type="text" hidden value="<?php echo $tempId; ?>" id="main_p">
                                    <select name="charge_id" class="form-control" id="charge_id">
                                      <option value="">select an option</option>
                                      <?php echo fill_charges($connection); ?>
                                    </select>
                                  </div>
                                  <?php
                                  // load user role data
                                  function fill_charges($connection)
                                  {
                                    $sint_id = $_SESSION["int_id"];
                                    $tempId = $_SESSION["product_temp"];
                                    $org = "SELECT * FROM charge WHERE int_id = '$sint_id' AND is_active = '1'";
                                    $res = mysqli_query($connection, $org);
                                    $output = '';
                                    while ($row = mysqli_fetch_array($res)) {
                                      $output .= '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
                                    }
                                    return $output;
                                  }
                                  ?>
                                  <input type="text" hidden id="int_id" value="<?php echo $sint_id ?>">
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                                    <button type="submit" id="addCharge" name="add" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Save</a>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        <script>
                          $(document).ready(function() {
                            $('#addCharge').on("click", function() {
                              var id = $(this).val();
                              var int_id = $('#int_id').val();
                              var charge_id = $('#charge_id').val();
                              var tempId = $('#tempId').val();
                              $.ajax({
                                url: "ajax_post/products/addCharge.php",
                                method: "POST",
                                data: {
                                  // id: id,
                                  charge_id: charge_id,
                                  tempId: tempId
                                },
                                success: function(data) {
                                  var output = data;
                                  if (output = "Success") {
                                    $.ajax({
                                      url: "ajax_post/products/charge_table.php",
                                      method: "POST",
                                      data: {
                                        int_id: int_id,
                                        // end: end,
                                        tempId: tempId
                                      },
                                      success: function(data) {
                                        $('#showCharge').html(data);
                                        alert("Charge Successfully added");
                                      }
                                    })
                                  } else {
                                    alert("Error adding Charge");
                                  }
                                }
                              })
                            });
                          });
                        </script>
                      </div>
                    </div>

                    <!-- Third Tab -->
                    <!-- Fourth Tab -->
                    <div class="tab">
                      <div class="row">
                        <!-- replace values with loan data -->
                        <div class="col-md-6">
                          <h5 class="card-title">Accounting Rules</h5>
                          <div class="position-relative form-group ">
                            <div>
                              <div class="custom-radio custom-control">
                                <input type="radio" id="cashBased" checked name="acc" class="custom-control-input">
                                <label class="custom-control-label" for="cashBased">Cash Based</label>
                              </div>
                              <div class="custom-radio custom-control">
                                <input type="radio" id="accuralP" disabled name="acc" class="custom-control-input">
                                <label class="custom-control-label" for="accuralP">Accural (Periodic)</label>
                              </div>
                              <div class="custom-radio custom-control">
                                <input type="radio" id="accuralU" disabled name="acc" class="custom-control-input">
                                <label class="custom-control-label" for="accuralU">Accural (Upfront)</label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <!-- <br> -->
                          <h5 class="card-title">Assets</h5>
                          <div class="position-relative form-group">
                            <div class="form-group">
                              <?php
                              function fill_asset($connection)
                              {
                                $sint_id = $_SESSION["int_id"];
                                $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' && classification_enum = '1' ORDER BY name ASC";
                                $res = mysqli_query($connection, $org);
                                $output = '';
                                while ($row = mysqli_fetch_array($res)) {
                                  $output .= '<option value = "' . $row["gl_code"] . '"> ' . strtoupper($row["name"]) . ' </option>';
                                }
                                return $output;
                              }
                              ?>
                              <!-- <div class="col-md-8">
                              <label for="charge" class="form-align">Fund Source</label>
                              <select class="form-control form-control-sm" name="asst_fund_src">
                                <option value="">--</option>
                              </select>
                              </div> -->
                            </div>
                            <div class="form-group">
                              <div class="col-md-8">
                                <label for="charge" class="form-align ">Savings Portfolio</label>
                                <select class="form-control form-control-sm" name="asst_loan_port">
                                  <option value="">--</option>
                                  <?php echo fill_lia($connection) ?>
                                </select>
                              </div>
                            </div>
                            <!-- <div class="form-group">
                            <div class="col-md-8">
                            <label for="charge" class="form-align">Insufficient Repayment</label>
                            <select class="form-control form-control-sm" name="insufficient_repaymentlk">
                              <option value="">--</option>
                              <?php echo fill_asset($connection) ?>
                            </select>
                            </div>
                          </div> -->
                          </div>
                          <!-- <h5 class="card-title">Liabilities</h5> -->
                          <?php
                          function fill_lia($connection)
                          {
                            $sint_id = $_SESSION["int_id"];
                            $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' && classification_enum = '2' ORDER BY name ASC";
                            $res = mysqli_query($connection, $org);
                            $output = '';
                            while ($row = mysqli_fetch_array($res)) {
                              $output .= '<option value = "' . $row["gl_code"] . '"> ' . strtoupper($row["name"]) . ' </option>';
                            }
                            return $output;
                          }
                          ?>

                        </div>

                        <!-- <div class="col-md-8"> -->
                        <!-- </div> -->
                        <!-- </div>
                      <div class="row"> -->
                        <div class="col-md-6">
                          <h5 class="card-title">Income</h5>
                          <div class="position-relative form-group">
                            <div class="form-group">
                              <?php
                              function fill_in($connection)
                              {
                                $sint_id = $_SESSION["int_id"];
                                $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' && classification_enum = '4' ORDER BY name ASC";
                                $res = mysqli_query($connection, $org);
                                $output = '';
                                while ($row = mysqli_fetch_array($res)) {
                                  $output .= '<option value = "' . $row["gl_code"] . '"> ' . strtoupper($row["name"]) . ' </option>';
                                }
                                return $output;
                              }
                              ?>
                              <div class="col-md-6">
                                <label for="charge" class="form-align ">Income for Interest</label>
                                <select class="form-control form-control-sm" name="inc_interest">
                                  <option value="">--</option>
                                  <?php echo fill_in($connection) ?>
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="col-md-6">
                                <label for="charge" class="form-align ">Income from Fees</label>
                                <select class="form-control form-control-sm" name="inc_fees">
                                  <option value="">--</option>
                                  <?php echo fill_in($connection) ?>
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="col-md-6">
                                <label for="charge" class="form-align ">Income from Penalties</label>
                                <select class="form-control form-control-sm" name="inc_penalties">
                                  <option value="">--</option>
                                  <?php echo fill_in($connection) ?>
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="col-md-6">
                                <label for="charge" class="form-align ">Income from Recovery</label>
                                <select class="form-control form-control-sm" name="inc_recovery">
                                  <option value="">--</option>
                                  <?php echo fill_in($connection) ?>
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="col-md-6">
                                <label for="charge" class="form-align ">BVN Income</label>
                                <select class="form-control form-control-sm" name="bvn_income">
                                  <option value="">--</option>
                                  <?php echo fill_in($connection) ?>
                                </select>
                              </div>
                            </div>

                          </div>
                          <!-- next -->


                        </div>
                        <div class="col-md-6">
                          <h5 class="card-title">Expenses</h5>
                          <div class="position-relative form-group">
                            <?php
                            function fill_exp($connection)
                            {
                              $sint_id = $_SESSION["int_id"];
                              $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' && classification_enum = '5' ORDER BY name ASC";
                              $res = mysqli_query($connection, $org);
                              $output = '';
                              while ($row = mysqli_fetch_array($res)) {
                                $output .= '<option value = "' . $row["gl_code"] . '"> ' . $row["name"] . ' </option>';
                              }
                              return $output;
                            }
                            ?>
                            <div class="form-group">
                              <div class="col-md-6">
                                <label for="charge" class="form-align ">Losses Written Off</label>
                                <select class="form-control form-control-sm" name="exp_loss_written_off">
                                  <option value="">--</option>
                                  <?php echo fill_exp($connection) ?>
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="col-md-6">
                                <label for="charge" class="form-align ">Interest Written Off</label>
                                <select class="form-control form-control-sm" name="exp_interest_written_off">
                                  <option value="">--</option>
                                  <?php echo fill_exp($connection) ?>
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="col-md-6">
                                <label for="charge" class="form-align ">BVN Expense</label>
                                <select class="form-control form-control-sm" name="bvn_expense">
                                  <option value="">--</option>
                                  <?php echo fill_exp($connection) ?>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- <div class="row"> -->

                      <!-- Modal -->
                      <?php
                      function fill_all($connection)
                      {
                        $sint_id = $_SESSION["int_id"];
                        $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' ORDER BY name ASC";
                        $res = mysqli_query($connection, $org);
                        $output = '';
                        while ($row = mysqli_fetch_array($res)) {
                          $output .= '<option value = "' . $row["gl_code"] . '"> ' . $row["name"] . ' </option>';
                        }
                        return $output;
                      }
                      ?>
                      <!-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Add Accounting Insturction</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <?php
                                    function fill_payment($connection)
                                    {
                                      $sint_id = $_SESSION["int_id"];
                                      $getacct = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE name LIKE '%due from bank%' && int_id = '$sint_id'");
                                      $cx = mysqli_fetch_array($getacct);
                                      $dfb = $cx["id"];

                                      $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' && classification_enum = '1' && parent_id = '$dfb' ORDER BY name ASC";
                                      $res = mysqli_query($connection, $org);
                                      $output = '';
                                      while ($row = mysqli_fetch_array($res)) {
                                        $output .= '<option value = "' . $row["gl_code"] . '"> ' . $row["name"] . ' </option>';
                                      }
                                      return $output;
                                    }
                                    ?>
                                    <label for="charge" class="form-align ">Payment</label>
                                    <script>
                                      $(document).ready(function() {
                                        $('#run_pay').on("change keyup paste click", function() {
                                          var id = $('#payment_id').val();
                                          var int_id = $('#int_id').val();
                                          var main_p = $('#main_p').val();
                                          var idx = $('#payment_id_x').val();
                                          //  new
                                          if (idx != '' && id != '') {
                                            $.ajax({
                                              url: "ajax_post/payment_product.php",
                                              method: "POST",
                                              data: {
                                                id: id,
                                                int_id: int_id,
                                                main_p: main_p,
                                                idx: idx
                                              },
                                              success: function(data) {
                                                $('#show_payment').html(data);
                                                document.getElementById("ipayment_id").setAttribute("hidden", "");
                                                document.getElementById("real_payment").removeAttribute("hidden");
                                              }
                                            })
                                          } else {
                                            //  poor the internet
                                          }
                                        });
                                      });
                                    </script>
                                    <div id="real_payment" hidden></div>
                                    <div id="ipayment_id">
                                      <select id="payment_id" class="form-control form-control-sm" name="">
                                        <option value="">--</option>
                                        <?php echo fill_payment($connection) ?>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="charge" class="form-align">Asset Account</label>
                                    <select class="form-control form-control-sm" name="" id="payment_id_x">
                                      <option value="">--</option>
                                      <?php echo fill_asset($connection) ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" id="run_pay">Save changes</button>
                              <button type="button" class="btn btn-primary" id="run_pay2" hidden>Save changes</button>
                            </div>
                          </div>
                        </div>
                      </div> -->
                      <!-- Modal2 -->
                      <!-- <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel2">Add Fee To Income Account Rule</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <?php
                                    function fill_fee($connection)
                                    {
                                      $sint_id = $_SESSION["int_id"];
                                      $getacct = mysqli_query($connection, "SELECT * FROM `acc_gl_account` WHERE name LIKE '%FEE%' && parent_id = '0' && int_id = '$sint_id'");
                                      $cx = mysqli_fetch_array($getacct);
                                      $dfb = $cx["id"];

                                      $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' && parent_id = '$dfb' ORDER BY name ASC";
                                      $res = mysqli_query($connection, $org);
                                      $output = '';
                                      while ($row = mysqli_fetch_array($res)) {
                                        $output .= '<option value = "' . $row["gl_code"] . '"> ' . $row["name"] . ' </option>';
                                      }
                                      return $output;
                                    }
                                    ?>
                                    <label for="charge" class="form-align ">Fee</label>
                                    <script>
                                      $(document).ready(function() {
                                        $('#run_pay3').on("change keyup paste click", function() {
                                          var id2 = $('#payment_id2').val();
                                          var int_id = $('#int_id').val();
                                          var main_p = $('#main_p').val();
                                          var idx2 = $('#payment_id_x2').val();
                                          //  new
                                          if (idx2 != '' && id2 != '') {
                                            $.ajax({
                                              url: "ajax_post/payment_fee.php",
                                              method: "POST",
                                              data: {
                                                id2: id2,
                                                int_id: int_id,
                                                main_p: main_p,
                                                idx2: idx2
                                              },
                                              success: function(data) {
                                                $('#show_payment2').html(data);
                                                document.getElementById("ipayment_id2").setAttribute("hidden", "");
                                                document.getElementById("real_payment2").removeAttribute("hidden");
                                              }
                                            })
                                          } else {
                                            //  poor the internet
                                          }
                                        });
                                      });
                                    </script>
                                    <div id="real_payment2" hidden></div>
                                    <div id="ipayment_id2">
                                      <select class="form-control form-control-sm" name="" id="payment_id2">
                                        <option value="">--</option>
                                        <?php echo fill_fee($connection) ?>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="charge" class="form-align ">Income Account</label>
                                    <select class="form-control form-control-sm" name="" id="payment_id_x2">
                                      <option value="">--</option>
                                      <?php echo fill_in($connection) ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" id="run_pay3">Save changes</button>
                              <button type="button" class="btn btn-primary" id="run_pay4" hidden>Save changes</button>
                            </div>
                          </div>
                        </div>
                      </div> -->
                      <!-- Modal3 -->
                      <!-- <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Add Penalty To Income Account Rule</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <?php
                                    function fill_pen($connection)
                                    {
                                      $sint_id = $_SESSION["int_id"];
                                      $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' && name LIKE '%penalty%' ORDER BY name ASC";
                                      $res = mysqli_query($connection, $org);
                                      $output = '';
                                      while ($row = mysqli_fetch_array($res)) {
                                        $output .= '<option value = "' . $row["gl_code"] . '"> ' . $row["name"] . ' </option>';
                                      }
                                      return $output;
                                    }
                                    ?>
                                    <label for="charge" class="form-align ">Penalty</label>
                                    <script>
                                      $(document).ready(function() {
                                        $('#run_pay5').on("change keyup paste click", function() {
                                          var id2 = $('#payment_id3').val();
                                          var int_id = $('#int_id').val();
                                          var main_p = $('#main_p').val();
                                          var idx2 = $('#payment_id_x3').val();
                                          //  new
                                          if (idx2 != '' && id2 != '') {
                                            $.ajax({
                                              url: "ajax_post/payment_pen.php",
                                              method: "POST",
                                              data: {
                                                id2: id2,
                                                int_id: int_id,
                                                main_p: main_p,
                                                idx2: idx2
                                              },
                                              success: function(data) {
                                                $('#show_payment3').html(data);
                                                document.getElementById("ipayment_id3").setAttribute("hidden", "");
                                                document.getElementById("real_payment3").removeAttribute("hidden");
                                              }
                                            })
                                          } else {
                                            //  poor the internet
                                          }
                                        });
                                      });
                                    </script>
                                    <div id="real_payment3"></div>
                                    <div id="ipayment_id3">
                                      <select class="form-control form-control-sm" name="" id="payment_id3">
                                        <option value="">--</option>
                                        <?php echo fill_pen($connection) ?>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="charge" class="form-align ">Income Account</label>
                                    <select class="form-control form-control-sm" name="" id="payment_id_x3">
                                      <option value="">--</option>
                                      <?php echo fill_in($connection) ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" id="run_pay5">Save changes</button>
                              <button type="button" class="btn btn-primary" id="run_pay6" hidden>Save changes</button>
                            </div>
                          </div>
                        </div>
                      </div> -->
                      <!-- </div> -->
                    </div>
                  </div>
                  <!-- Fourth Tab -->
                  <!-- Buttons -->
                  <div style="overflow:auto;">
                    <div style="float:right;">
                      <button class="btn btn-primary pull-right" type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                      <button class="btn btn-primary pull-right" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                    </div>
                  </div>
                  <!-- Steppers -->
                  <!-- Circles which indicates the steps of the form: -->
                  <div style="text-align:center;margin-top:40px;">
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /col-12 -->
  </div>
  <!-- /content -->
</div>
</div>
<!-- make something cool here -->
<style>
  * {
    box-sizing: border-box;
  }

  body {
    background-color: #f1f1f1;
  }

  /* #regForm {
  background-color: #ffffff;
  margin: 100px auto;
  font-family: Raleway;
  padding: 40px;
  width: 70%;
  min-width: 300px;
} */

  h1 {
    text-align: center;
  }

  input {
    padding: 10px;
    width: 100%;
    font-size: 17px;
    font-family: Raleway;
    border: 1px solid #aaaaaa;
  }

  /* Mark input boxes that gets an error on validation: */
  input.invalid {
    background-color: #ffdddd;
  }

  /* Hide all steps by default: */
  .tab {
    display: none;
  }

  button {
    background-color: #a13cb6;
    color: #ffffff;
    border: none;
    padding: 10px 20px;
    font-size: 17px;
    font-family: Raleway;
    cursor: pointer;
  }

  button:hover {
    opacity: 0.8;
  }

  #prevBtn {
    background-color: #bbbbbb;
  }

  /* Make circles that indicate the steps of the form: */
  .step {
    height: 15px;
    width: 15px;
    margin: 0 2px;
    background-color: #bbbbbb;
    border: none;
    border-radius: 50%;
    display: inline-block;
    opacity: 0.5;
  }

  .step.active {
    opacity: 1;
  }

  /* Mark the steps that are finished and valid: */
  .step.finish {
    background-color: #9e38b5;
  }
</style>
<script>
  var currentTab = 0; // Current tab is set to be the first tab (0)
  showTab(currentTab); // Display the current tab

  function showTab(n) {
    // This function will display the specified tab of the form...
    var x = document.getElementsByClassName("tab");
    x[n].style.display = "block";
    //... and fix the Previous/Next buttons:
    if (n == 0) {
      document.getElementById("prevBtn").style.display = "none";
    } else {
      document.getElementById("prevBtn").style.display = "inline";
    }
    if (n == (x.length - 1)) {
      document.getElementById("nextBtn").innerHTML = "Submit";
    } else {
      document.getElementById("nextBtn").innerHTML = "Next";
    }
    //... and run a function that will display the correct step indicator:
    fixStepIndicator(n)
  }

  function nextPrev(n) {
    // This function will figure out which tab to display
    var x = document.getElementsByClassName("tab");
    // Exit the function if any field in the current tab is invalid:
    if (n == 1 && !validateForm()) return false;
    // Hide the current tab:
    x[currentTab].style.display = "none";
    // Increase or decrease the current tab by 1:
    currentTab = currentTab + n;
    // if you have reached the end of the form...
    if (currentTab >= x.length) {
      // ... the form gets submitted:
      document.getElementById("form").submit();
      return false;
    }
    // Otherwise, display the correct tab:
    showTab(currentTab);
  }

  function validateForm() {
    // This function deals with validation of the form fields
    var x, y, i, valid = true;
    x = document.getElementsByClassName("tab");
    y = x[currentTab].getElementsByTagName("input");
    // A loop that checks every input field in the current tab:
    for (i = 0; i < y.length; i++) {
      // If a field is empty...
      if (y[i].value == "") {
        // add an "invalid" class to the field:
        y[i].className += " invalid";
        // and set the current valid status to false
        valid = true; // This was change to true to disable the validation function. Should be reverted to FALSE after testing is complete
      }
    }
    // If the valid status is true, mark the step as finished and valid:
    if (valid) {
      document.getElementsByClassName("step")[currentTab].className += " finish";
    }
    return valid; // return the valid status
  }

  function fixStepIndicator(n) {
    // This function removes the "active" class of all steps...
    var i, x = document.getElementsByClassName("step");
    for (i = 0; i < x.length; i++) {
      x[i].className = x[i].className.replace(" active", "");
    }
    //... and adds the "active" class on the current step:
    x[n].className += " active";
  }
</script>
<?php

include("footer.php");

?>