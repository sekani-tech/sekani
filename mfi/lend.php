<?php

$page_title = "Loan Disbursement";
$destination = "loans.php";
    include("header.php");

?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
        <?php
          if (isset($_GET["message"])) {
            $key = $_GET["message"];
            $tt = 0;
            if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
              echo '<script type="text/javascript">
                    $(document).ready(function(){
                        swal({
                            type: "success",
                            title: "Success",
                            text: "Loan Submitted Successfully, Awaiting Approval",
                            showConfirmButton: false,
                            timer: 2000
                        })
                    });
                    </script>
                    ';
              $_SESSION["lack_of_intfund_$key"] = 0;
            }
          }else if (isset($_GET["message2"])) {
            $key = $_GET["message2"];
            $tt = 0;
            if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
              echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "Error",
                        text: "Error in Posting For Approval",
                        showConfirmButton: false,
                        timer: 2000
                    })
                });
                </script>
                ';
            $_SESSION["lack_of_intfund_$key"] = 0;
            }
          }else if (isset($_GET["message3"])) {
            $key = $_GET["message3"];
            $tt = 0;
            if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
              echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "Error",
                        text: "This Client Has Been Given Loan Before",
                        showConfirmButton: false,
                        timer: 2000
                    })
                });
                </script>
                ';
            $_SESSION["lack_of_intfund_$key"] = 0;
            }
          }else if (isset($_GET["message4"])) {
            $key = $_GET["message4"];
            $tt = 0;
            if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
              echo '<script type="text/javascript">
                  $(document).ready(function(){
                      swal({
                      type: "error",
                      title: "Error",
                      text: "Insufficent Fund From Institution Account!",
                      showConfirmButton: false,
                      timer: 2000
                  })
              });
              </script>
              ';
            $_SESSION["lack_of_intfund_$key"] = 0;
            }
          }else if (isset($_GET["message5"])) {
            $key = $_GET["message5"];
            $tt = 0;
            if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
            echo '<script type="text/javascript">
            $(document).ready(function(){
                swal({
                    type: "error",
                    title: "Error",
                    text: "Error in Posting For Loan Gaurantor",
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
          <!-- your content here -->
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title">Disburse Loan</h4>
                <p class="card-category">Fill in all important data</p>
              </div>
              <div class="card-body">
              <form id="form" action="../functions/int_lend_upload.php" method="POST">
                  <div class = "row">
                    <div class = "col-md-12">
                      <div class = "form-group">
                        <!-- First Tab Begins -->
                    <div class="tab"><h3> Terms:</h3>
                    <?php
                              // load user role data
                              function fill_product($connection) {
                                $sint_id = $_SESSION["int_id"];
                                $org = "SELECT * FROM product WHERE int_id = '$sint_id'";
                                $res = mysqli_query($connection, $org);
                                $output = '';
                                while ($row = mysqli_fetch_array($res))
                                {
                                  $output .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                                }
                                return $output;
                              }
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
                              // a function for collateral
                              function fill_collateral($connection) {
                                $sint_id = $_SESSION["int_id"];
                                $org = "SELECT * FROM collateral WHERE int_id = '$sint_id'";
                                $res = mysqli_query($connection, $org);
                                $out = '';
                                while ($row = mysqli_fetch_array($res))
                                {
                                  $out .= '<option value="'.$row["id"].'">'.$row["type"].'</option>';
                                }
                                return $out;
                              }
                              // Function for charges
                              function fill_charges($connection) {
                                $sint_id = $_SESSION["int_id"];
                                $org = "SELECT * FROM charge WHERE int_id = '$sint_id'";
                                $res = mysqli_query($connection, $org);
                                $out = '';
                                while ($row = mysqli_fetch_array($res))
                                {
                                  $out .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                                }
                                return $out;
                              }
                            ?>
                            <script>
                              $(document).ready(function() {
                                $('#charges').change(function(){
                                  var id = $(this).val();
                                  $.ajax({
                                    url:"load_data_lend.php",
                                    method:"POST",
                                    data:{id:id},
                                    success:function(data){
                                      $('#show_product').html(data);
                                    }
                                  })
                                });
                              })
                            </script>
                    <div class="col-md-4">
                      <label class = "bmd-label-floating">Client Name *:</label>
                        <select name="client_id" class="form-control" id="client_name">
                          <option value="">select an option</option>
                          <?php echo fill_client($connection); ?>
                        </select>
                        <label class="bmd-label-floating" >Product *:</label>
                        <select name="product_id" class="form-control" id="charges">
                          <option value="">select an option</option>
                          <?php echo fill_product($connection); ?>
                        </select>
                    </div>
                    <div class="col-md-12" id="show_product"></div>
                    </div>
                    <!-- First Tab Ends -->
                    <!-- Second Tab Begins -->
                    <!-- <div class="tab"><h3> Settings:</h3>
                          <div class="row">
                             <div class="my-3"> 
                               replace values with loan data
                              <div class=" col-md-4 form-group">
                                <label class = "bmd-label-floating">Description:</label>
                                <input type="number" value="" name="principal_amount" class="form-control" required id="ls">
                              </div>
                              <div class="col-md-4 form-group">
                                <label class = "bmd-label-floating">Origin of Funding:</label>
                                <select class="form-control" name="" id="">
                                  <option>Bank</option>
                                </select>
                              </div>
                              <div class="col-md-4 form-group">
                                <label class = "bmd-label-floating">Currency:</label>
                                <input type="text" value="" name="repay_every" class="form-control" id="irp">
                              </div>
                              <div class="col-md-4 form-group">
                                <label class = "bmd-label-floating">To Decimal place:</label>
                                <input type="number" name="interest_rate" class="form-control" id="ir">
                              </div>
                              <div class="col-md-4 form-group">
                                <label class = "bmd-label-floating">In Multiples of:</label>
                                <input type="number" name="disbursement_date" class="form-control" id="db">
                              </div>
                              <div class="col-md-4 form-group">
                                <label class = "bmd-label-floating">Installment Amount in Multiples of:</label>
                                <input type="number" name="loan_officer" class="form-control" id="lo">
                              </div>
                              <div class="col-md-4 form-group">
                                <label class = "bmd-label-floating">Principal:</label>
                                <input type="number" name="loan_purpose" class="form-control" id="lp">
                              </div>
                              <div class="col-md-4 form-group">
                                <label class = "bmd-label-floating">Loan Term:</label>
                                <input type="text" name="linked_savings_acct" class="form-control" id="lsa">
                              </div>
                              <div class="col-md-4 form-group">
                                <label class = "bmd-label-floating">Repayment Frequency:</label>
                                <input type="date" name="repay_start" class="form-control" id="rsd">
                              </div>
                              <div class="col-md-4 form-group">
                                <label class = "bmd-label-floating">Repayment Frequency type:</label>
                                <select class="form-control" name="" id="">
                                  <option>Months</option>
                                </select>
                              </div>
                              <div class="col-md-4 form-group">
                                <label class = "bmd-label-floating">Interest Rate:</label>
                                <input type="number" name="repay_start" class="form-control" id="rsd">
                              </div>
                              <div class="col-md-4 form-group">
                                <label class = "bmd-label-floating">Interest Rate Applied:</label>
                                <input type="number" name="repay_start" class="form-control" id="rsd">%
                              </div>
                              <div class="col-md-4 form-group">
                                <label class = "bmd-label-floating">Interest Methodology:</label>
                                <select class="form-control" name="" id="">
                                  <option>Flat</option>
                                </select>
                              </div>
                              <div class="col-md-4 form-group">
                                <label class = "bmd-label-floating">Ammortization Method:</label>
                                <select class="form-control" name="" id="">
                                  <option>Equal installments</option>
                                </select>                              </div>
                              <div class="col-md-4 form-group">
                                <label class = "bmd-label-floating">Days in Year:</label>
                                <input type="date" name="repay_start" class="form-control" id="rsd">
                              </div>
                              <div class="col-md-4 form-group">
                                <label class = "bmd-label-floating">Days in Month Type:</label>
                                <input type="date" name="repay_start" class="form-control" id="rsd">
                              </div>
                              <div class="col-md-4 form-group">
                                <label class = "bmd-label-floating">Transaction Processing Strategy:</label>
                                <input type="date" name="repay_start" class="form-control" id="rsd">
                              </div>
                              <div class="col-md-4 form-group">
                                <label class = "bmd-label-floating">Include Loan cycle:</label>
                                <select class="form-control" name="" id="">
                                  <option>Yes</option>
                                </select> </div>
                             </div>
                          </div>
                    </div>  -->
                    <!-- Second Tab Ends -->
                    <!-- Third Tab Begins -->
                    <div class="tab"><h3> Charges:</h3>
                    <table class="table table-bordered">
                    <?php
                   $query = "SELECT * FROM charge WHERE int_id = '$sessint_id'";
                   $result = mysqli_query($connection, $query);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     echo $inr;
                   }?>
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Charge</th>
                              <th>Amount</th>
                              <th>Collected On</th>
                              <th>Date</th>
                              <th>Payment Mode</th>
                            </tr>
                          </thead>
                          <tbody> 
                          <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <td><?php echo $row["name"]; ?></td>
                          <td><?php echo $row["currency_code"]; ?></td>
                          <td><?php echo $row["amount"]; ?></td>
                          <td><?php echo $row["charge_applies_to_enum"]; ?></td>
                          <td><?php echo $row["charge_time_enum"]; ?></td>
                          <td>Cash</th>
                        </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>   
                          </tbody>
                        </table>
                        <div class="col-md-6">
                        <label class = "bmd-label-floating" for="charge" class="form-align mr-3">Charges</label>
                          <select class="form-control" name="charge"> 
                            <option>select charge to add</option>                                               
                          <?php echo fill_charges($connection); ?>
                          </select>
                          <button type="button" class="btn btn-primary" name="button" onclick="displayCharge()"> <i class="fa fa-plus"></i> Add To Product </button>
                      </div>
                    </div>
                    <!-- Third Tab Ends -->
                    <!-- Fourth Tab Begins -->
                    <div class="tab"><h3> Collateral:</h3>
                    <div class="form-group">
                      <button type="button" class="btn btn-primary" name="button" onclick="showDialog()"> <i class="fa fa-plus"></i> Add</button>
                      </div>
                      <div class="form-group">
                      <table class="table table-bordered">
                          <thead>
                          <?php
                            $query = "SELECT * FROM collateral WHERE int_id = '".$_SESSION["int_id"]."'";
                            $result = mysqli_query($connection, $query);
                            ?>
                            <tr>
                              <th></th>
                              <th>Value</th>
                              <th>Description</th>
                            </tr>
                          </thead>
                          <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <td><?php echo $row["type"]; ?></td>
                          <td><?php echo $row["value"]; ?></td>
                          <td><?php echo $row["description"]; ?></td>
                        </tr>
                        <?php }
                          }
                          else {
                            echo "No collateral Available";
                          }
                          ?>
                      </tbody>
                        </table>
                      </div>
                      <!-- dialog box -->
                      <div class="form-group">
                      <div id="background">
                      </div>
                      <div id="diallbox">
                <h3>Add Collateral</h3>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class = "bmd-label-floating" class="md-3 form-align " for=""> Name:</label>
                        <input type="text" name="col_name" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class = "bmd-label-floating" for=""> Type:</label>
                        <input type="text" name="col_value" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class = "bmd-label-floating" for="">Description:</label>
                        <input type="text" name="col_description" class="form-control">
                      </div>
                    </div>
                  <div style="float:right;">
                        <button class="btn btn-primary pull-right"  onclick="AddDlg()">Add</button>
                        <button class="btn btn-primary pull-right" type="button" id="">Cancel</button>
                      </div>
<script>
    function AddDlg(){
        var bg = document.getElementById("background");
        var dlg = document.getElementById("diallbox");
        bg.style.display = "none";
        dlg.style.display = "none";
    }
    
    function showDialog(){
        var bg = document.getElementById("background");
        var dlg = document.getElementById("diallbox");
        bg.style.display = "block";
        dlg.style.display = "block";
        
        var winWidth = window.innerWidth;
        var winHeight = window.innerHeight;
        
        dlg.style.left = (winWidth/2) - 480/2 + "px";
        dlg.style.top = "150px";
    }
</script>
<style>
    #background{
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
    
    #diallbox{
        /*initially dialog box is hidden*/
        display: none;
        position: fixed;
        width: 480px;
        z-index: 9999;
        border-radius: 10px;
        padding:20px;
        background-color: #ffffff;
    }
</style>
                      </div>
                    </div>
                    </div>
                    <!-- Fourth Tab Ends -->
                    <!-- Fifth Tab Begins -->
                    <div class="tab"><h3> Guarantors:</h3>
                      <div class="form-group">
                      <button type="button" class="btn btn-primary" name="button" onclick="DisplayDialog()"> <i class="fa fa-plus"></i> Add</button>
                      </div>
                      <div class="form-group">
                      <table class="table table-bordered">
                          <thead>
                          <?php
                        $query = "SELECT * FROM loan_gaurantor WHERE int_id ='$sessint_id'";
                        $result = mysqli_query($connection, $query);
                            ?>
                            <tr>
                              <th>Name</th>
                              <th>Guarantor Type</th>
                              <th>Guarantee Amount</th>
                            </tr>
                          </thead>
                          <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <td><?php echo $row["first_name"]; ?></td>
                          <td><?php echo $row["office_address"]; ?></td>
                          <td><?php echo $row["email"]; ?></td>
                        </tr>
                        <?php }
                          }
                          else {
                            echo "No Guarantor Available";
                          }
                          ?>
                      </tbody>
                        </table>
                      </div>
                      <!-- dialog box -->
                      <div class="form-group">
                      <div id="backg">
                      </div>
                      <div id="dlbox">
    <h3>Add Guarantor</h3>
    <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label class = "bmd-label-floating" class="md-3 form-align " for=""> First Name:</label>
            <input type="text" name="gau_first_name" id="" class="form-control">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label class = "bmd-label-floating" for=""> Last Name:</label>
            <input type="text" name="gau_last_name" id="" class="form-control">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label class = "bmd-label-floating" for="">Phone:</label>
            <input type="text" name="gau_phone" id="" class="form-control">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
              <label class = "bmd-label-floating" for="">Phone 2:</label>
              <input type="text" name="gau_phone2" id="" class="form-control">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
              <label class = "bmd-label-floating" for="">Home Address:</label>
              <input type="text" name="gau_home_address" id="" class="form-control">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
              <label class = "bmd-label-floating" for="">Office Address:</label>
              <input type="text" name="gau_office_address" id="" class="form-control">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
              <label class = "bmd-label-floating" for="">Position Held:</label>
              <input type="text" name="gau_position_held" id="" class="form-control">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label class = "bmd-label-floating" class = "bmd-label-floating">Email:</label>
            <input type="text" name="gau_email" id="" class="form-control">
          </div>
        </div>
      </div>
      <div style="float:right;">
            <button class="btn btn-primary pull-right"  onclick="DlgAdd()" type="button" id="">Add</button>
            <button class="btn btn-primary pull-right" type="button" id="">Cancel</button>
          </div>
</div>
<script>
    function DlgAdd(){
        var bg = document.getElementById("backg");
        var dlg = document.getElementById("dlbox");
        bg.style.display = "none";
        dlg.style.display = "none";
    }
    
    function DisplayDialog(){
        var bg = document.getElementById("backg");
        var dlg = document.getElementById("dlbox");
        bg.style.display = "block";
        dlg.style.display = "block";
        
        var winWidth = window.innerWidth;
        var winHeight = window.innerHeight;
        
        dlg.style.left = (winWidth/2) - 480/2 + "px";
        dlg.style.top = "150px";
    }
</script>
<style>
    #backg{
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
    
    #dlbox{
        /*initially dialog box is hidden*/
        display: none;
        position: fixed;
        width: 480px;
        z-index: 9999;
        border-radius: 10px;
        padding:20px;
        background-color: #ffffff;
    }
</style>
                      </div>
                    </div>
                    <!-- Fifth Tab Ends -->
                    <!-- Sixth Tab Begins -->
                    <div class="tab"><h3> Repayment Schedule:</h3>
                      <div class="form-group">
                      <script>
                              $(document).ready(function() {
                                $('#charges').change(function(){
                                  var id = $(this).val();
                                  $.ajax({
                                    url:"loan_calculation_table.php",
                                    method:"POST",
                                    data:{id:id},
                                    success:function(data){
                                      $('#show_table').html(data);
                                    }
                                  })
                                });
                              })
                            </script>
                            <table id = "accname" class="table table-bordered">

                            </table>
                      </div>
                    </div>
                    <!-- Sixth Tab Ends -->
                    <!-- Seventh Tab Begins -->
                    <div class="tab"><h3> Overview:</h3>
                          <div class="row">
                            <!-- <div class="my-3"> -->
                              <!-- replace values with loan data -->
                              <div class=" col-md-6 form-group">
                                <label class = "bmd-label-floating">Loan size:</label>
                                <input type="number" readonly value="" name="principal_amount" class="form-control" required id="ls">
                              </div>
                              <div class="col-md-6 form-group">
                                <label class = "bmd-label-floating">Loan Term:</label>
                                <input readonly type="number" id="lt" name="loan_term" class="form-control" />
                              </div>
                              <div class="col-md-6 form-group">
                                <label class = "bmd-label-floating">Interest Rate per:</label>
                                <input readonly type="text" value="" name="repay_every" class="form-control" id="irp">
                              </div>
                              <div class="col-md-6 form-group">
                                <label class = "bmd-label-floating">Interest Rate:</label>
                                <input readonly type="text" name="interest_rate" class="form-control" id="ir">
                              </div>
                              <div class="col-md-6 form-group">
                                <label class = "bmd-label-floating">Disbusrsement Date:</label>
                                <input readonly type="date" name="disbursement_date" class="form-control" id="db">
                              </div>
                              <div class="col-md-6 form-group">
                                <label class = "bmd-label-floating">Loan Officer:</label>
                                <input readonly type="text" name="loan_officer" class="form-control" id="lo">
                              </div>
                              <div class="col-md-6 form-group">
                                <label class = "bmd-label-floating">Loan Purpose:</label>
                                <input readonly type="text" name="loan_purpose" class="form-control" id="lp">
                              </div>
                              <div class="col-md-6 form-group">
                                <label class = "bmd-label-floating">Linked Savings account:</label>
                                <input readonly type="text" name="linked_savings_acct" class="form-control" id="lsa">
                              </div>
                              <div class="col-md-6 form-group">
                                <label class = "bmd-label-floating">Repayment Start Date:</label>
                                <input readonly type="date" name="repay_start" class="form-control" id="rsd">
                              </div>
                              <div class="col-md-6 form-group">
                                <label class = "bmd-label-floating">Loan End Date:</label>
                                <input readonly type="date" value="<?php echo $actualend_date ?>" name="repay_start" id="end" class="form-control">
                              </div>
                            <!-- </div> -->
                          </div>
                    </div>
                    <!-- Seventh Tab Ends -->
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
                          <!-- <span class="step"></span> -->
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

                  
                  <!-- /stepper  -->
                </div>
              </div>
            </div>
            <!-- <div class="col-md-4">
              <div class="card card-profile">
                <div class="card-avatar">
                  <a href="#pablo">
                    <img class="img" src="../assets/img/faces/marc.jpg" />
                  </a>
                </div>
                 Get session data and populate user profile 
                <div class="card-body">
                  <h6 class="card-category text-gray">CEO / Co-Founder</h6>
                  <h4 class="card-title">Alec Thompson</h4>
                  <p class="card-description">
                    Sekani Systems
                  </p>
                   <a href="#pablo" class="btn btn-primary btn-round">Follow</a> 
                </div>
              </div>
            </div> -->
          </div>
          <!-- /content -->
        </div>
      </div>
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
      valid = true;
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