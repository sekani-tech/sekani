<?php

$page_title = "Edit Product";
$destination = "connect.php";
    include("header.php");

?>
<?php
 if (isset($_GET["edit"])) {
  $user_id = $_GET["edit"];
  $update = true;
  $value = mysqli_query($connection, "SELECT * FROM savings_product WHERE id='$user_id' && int_id='$sessint_id'");

  if ($value) {
    $n = mysqli_fetch_array($value);
    $int_id = $n['int_id'];
    $name = $n['name'];
    $short_name = $n['short_name'];
    $description = $n['description'];
    $accounting_type = $n['accounting_type'];
    $deposit = $n['deposit_amount'];
    $depositmin = $n['min_deposit_amount'];
    $depositmax = $n['max_deposit_amount'];
    $interest_compounding_period_enum = $n['interest_compounding_period_enum'];
    $interest_posting_period_enum = $n['interest_posting_period_enum'];
    $interest_calculation_type_enum = $n['interest_calculation_type_enum'];
    $interest_calculation_days_in_year_type_enum = $n['interest_calculation_days_in_year_type_enum'];
    $min_balance_for_interest_calculation = $n['min_balance_for_interest_calculation'];
    $lockin_period_frequency = $n['lockin_period_frequency'];
    $lockin_period_frequency_enum = $n['lockin_period_frequency_enum'];
    $allow_overdraft = $n['allow_overdraft'];
    $minimum_deposit_term = $n['minimum_deposit_term'];
    $minimum_deposit_term_time = $n['minimum_deposit_term_time'];
    $maximum_deposit_term = $n['maximum_deposit_term'];
    $maximum_deposit_term_time = $n['maximum_deposit_term_time'];
    $in_multiples_deposit_term = $n['in_multiples_deposit_term'];
    $auto_renew = $n['auto_renew_on_closure'];
    $in_multiples_deposit_term_time = $n['in_multiples_deposit_term_time'];

    if($auto_renew == "1"){
      $auto_ren = "Yes";
    }
    else if($auto_renew == "2"){
      $auto_ren = "No";
    }

    if($interest_compounding_period_enum == "1"){
      $compound_period = "Daily";
    }
    else if($interest_compounding_period_enum == "2"){
      $compound_period = "Monthly";
    }
    else if($interest_compounding_period_enum == "3"){
      $compound_period = "Quarterly";
    }
    else if($interest_compounding_period_enum == "4"){
      $compound_period = "Bi-Annually";
    }
    else if($interest_compounding_period_enum == "5"){
      $compound_period = "Annually";
    }

    if($interest_posting_period_enum == "1"){
      $int_post_type = "Daily";
    }
    else if($interest_posting_period_enum == "30"){
      $int_post_type = "Monthly";
    }
    else if($interest_posting_period_enum == "90"){
      $int_post_type = "Quarterly";
    }
    else if($interest_posting_period_enum == "180"){
      $int_post_type = "Bi-Annually";
    }
    else if($interest_posting_period_enum == "365"){
      $int_post_type = "Annually";
    }

    if($interest_calculation_type_enum == "1"){
      $int_cal_type = "Daily Balance";
    }
    else if($interest_calculation_type_enum == "2"){
      $int_cal_type = "Average Daily Balance";
    }

    if($interest_calculation_days_in_year_type_enum == "30"){
      $int_cal_days = "30 days";
    }
    else if($interest_calculation_days_in_year_type_enum == "60"){
      $int_cal_days = "60 days";
    }
    else if($interest_calculation_days_in_year_type_enum == "90"){
        $int_cal_days = "90 days";
      }
      else if($interest_calculation_days_in_year_type_enum == "180"){
        $int_cal_days = "180 days";
      }
      else if($interest_calculation_days_in_year_type_enum == "365"){
        $int_cal_days = "365 days";
      }
      else if($interest_calculation_days_in_year_type_enum == "366"){
        $int_cal_days = "366 days";
      }

    if($lockin_period_frequency_enum == "1"){
      $lock_per_freq_time = "Days";
    }
    else if($lockin_period_frequency_enum == "2"){
      $lock_per_freq_time = "Weeks";
    }
    else if($lockin_period_frequency_enum == "3"){
      $lock_per_freq_time = "Months";
    }
    else if($lockin_period_frequency_enum == "4"){
      $lock_per_freq_time = "Years";
    }

    if($minimum_deposit_term_time == "1"){
        $min_dep_time = "Days";
      }
      else if($minimum_deposit_term_time == "2"){
        $min_dep_time = "Weeks";
      }
      else if($minimum_deposit_term_time == "3"){
        $min_dep_time = "Months";
      }
      else if($minimum_deposit_term_time == "4"){
        $min_dep_time = "Years";
      }

      if($maximum_deposit_term_time == "1"){
        $max_dep_time = "Days";
      }
      else if($maximum_deposit_term_time == "2"){
        $max_dep_time = "Weeks";
      }
      else if($maximum_deposit_term_time == "3"){
        $max_dep_time = "Months";
      }
      else if($maximum_deposit_term_time == "4"){
        $max_dep_time = "Years";
      }

      if($in_multiples_deposit_term_time == "1"){
        $in_multiples = "Days";
      }
      else if($in_multiples_deposit_term_time == "2"){
        $in_multiples = "Weeks";
      }
      else if($in_multiples_deposit_term_time == "3"){
        $in_multiples = "Months";
      }
      else if($in_multiples_deposit_term_time == "4"){
        $in_multiples = "Years";
      }

  }

  $dsopq = "SELECT * FROM ftd_acct_rule WHERE int_id = '$sessint_id' AND ftd_id = '$user_id'";
  $fdq = mysqli_query($connection, $dsopq);
  $l = mysqli_fetch_array($fdq);
    $asst_loan_port = $l['asst_loan_port'];
    $li_overpayment = $l['li_overpayment'];
    $li_suspended_income = $l['li_suspended_income'];
    $inc_interest = $l['inc_interest'];
    $inc_fees = $l['inc_fees'];
    $inc_penalties = $l['inc_penalties'];
    $inc_recovery = $l['inc_recovery'];
    $bvn_income = $l['bvn_income'];
    $bvn_expense = $l['bvn_expense'];
    $exp_loss_written_off = $l['exp_loss_written_off'];
    $exp_interest_written_off = $l['exp_interest_written_off'];
    $insufficient_repayment = $l['insufficient_repayment'];

    $abc = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '$asst_loan_port'");
  $a = mysqli_fetch_array($abc);
  $ast_ln_prt = $a['name'];

  $def = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '$li_overpayment'");
  $b = mysqli_fetch_array($def);
  $li_overnt = $b['name'];

  $ghi = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '$li_suspended_income'");
  $c = mysqli_fetch_array($ghi);
  $li_susd_ime = $c['name'];

  $jkl = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '$inc_interest'");
  $d = mysqli_fetch_array($jkl);
  $inc_inst = $d['name'];

  $mno = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '$inc_fees'");
  $e = mysqli_fetch_array($mno);
  $inc_fes = $e['name'];

  $pqr = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '$inc_penalties'");
  $f = mysqli_fetch_array($pqr);
  $inc_pees = $f['name'];

  $stu = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '$inc_recovery'");
  $g = mysqli_fetch_array($stu);
  $inc_reco = $g['name'];

  $vw = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '$exp_loss_written_off'");
  $h = mysqli_fetch_array($vw);
  $exp_los_wttn_off = $h['name'];

  $xy = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '$exp_interest_written_off'");
  $i = mysqli_fetch_array($xy);
  $exp_int_wttn_off = $i['name'];

  $op = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '$insufficient_repayment'");
  $k = mysqli_fetch_array($op);
  $insuf_rymnt = $k['name'];

  $op = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '$bvn_income'");
  $t = mysqli_fetch_array($op);
  $bvn_incme = $t['name'];

  $op = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND gl_code = '$bvn_expense'");
  $f = mysqli_fetch_array($op);
  $bvn_exp = $f['name'];
}
?>
 <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Update Product</h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <form id="form" action="../functions/product_ftd_update.php" method="POST">
                <div class="card-body">
                <div class = "row">
                    <div class = "col-md-12">
                      <div class = "form-group">
                        <!-- First tab -->
                        <div class="tab">
                  <h3> New Fixed Deposit Term Product:</h3>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Name *:</label>
                        <input type="text" value="<?php echo $name?>"  name="name" class="form-control"  id="" required>
                        <input type="text" hidden value="<?php echo $user_id?>" name="ftd_id" class="form-control"  id="ftd_id" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="shortLoanName" >Short Loan Name *</label>
                        <input type="text" value="<?php echo $short_name?>"class="form-control" name="short_name" value="" placeholder="Short Name..." required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="loanDescription" >Description *</label>
                        <input type="text" value="<?php echo $description?>"class="form-control" name="description" value="" placeholder="Description...." required>
                      </div>
                    </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="installmentAmount" >Product Group id</label>
                          <select class="form-control" name="product_type" >
                            <option value="3">Fixed-Deposit</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="installmentAmount" >Currency</label>
                          <select class="form-control" name="currency" >
                           <option value="NGN">Nigerian Naira(NGN)</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="interestRate" >Deposit Amount</label>
                          <div class="row">
                            <div class="col-md-4">
                              <input type="text" value="<?php echo $deposit?>"class="form-control" name="deposita" value="" placeholder="Default" required>
                            </div>
                            <div class="col-md-4">
                              <input type="text" value="<?php echo $depositmin?>"class="form-control" name="deposita_min" value="" placeholder="Min" required>
                            </div>
                            <div class="col-md-4">
                              <input type="text" value="<?php echo $depositmax?>"class="form-control" name="deposita_max" value="" placeholder="Max" required>
                            </div>
                          </div>
                        </div>
                      </div>    
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="interestRate" >Interest </label>
                          <div class="row">
                            <div class="col-md-4">
                              <input type="text" value=""class="form-control" name="deposita" value="" placeholder="Default" required>
                            </div>
                            <div class="col-md-4">
                              <input type="text" value=""class="form-control" name="deposita_min" value="" placeholder="Min" required>
                            </div>
                            <div class="col-md-4">
                              <input type="text" value=""class="form-control" name="deposita_max" value="" placeholder="Max" required>
                            </div>
                          </div>
                        </div>
                      </div>           
                        <div class="col-md-6">
                        <div class="form-group">
                          <label for="interestRateApplied" >Interest Posting period Type</label>
                          <select class="form-control"  name="int_post_type" >
                          <option hidden value="<?php echo $interest_posting_period_enum;?>"><?php echo $int_post_type;?></option>
                           <option value="30">Monthly</option>
                           <option value="90">Quarterly</option>
                           <option value="180">Bi-Annually</option>
                           <option value="365">Annually</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="installmentAmount" >Interest Compounding Period</label>
                          <select class="form-control" name="compound_period">
                          <option hidden value="<?php echo $interest_compounding_period_enum;?>"><?php echo $compound_period;?></option>
                           <option value="2">Monthly</option>
                           <option value="3">Quarterly</option>
                           <option value="4">Bi-Annually</option>
                           <option value="5">Annually</option>
                          </select>
                        </div>
                      </div>    
                      <div class="col-md-6" hidden>
                        <div class="form-group">
                          <label for="interestMethodology" >Interest Calculation Type</label>
                          <select class="form-control" name="int_cal_type" >
                          <option hidden value="<?php echo $interest_calculation_type_enum;?>"><?php echo $int_cal_type;?></option>
                            <option value="1">Daily Balance</option>
                            <option value="2">Average Daily Balance</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="amortizatioMethody" >Interest Calculation Days in Year type</label>
                          <select class="form-control" name="int_cal_days" required>
                          <option hidden value="<?php echo $interest_calculation_days_in_year_type_enum;?>"><?php echo $int_cal_days;?></option>
                            <option value="30">30 days</option>
                            <option value="60">60 days</option>
                            <option value="90">90 days</option>
                            <option value="180">180 days</option>
                            <option value="365">365 days</option>
                            <option value="366">366 days</option>
                          </select>
                        </div>
                      </div>
                    <div class="col-md-6" hidden>
                        <div class="form-group">
                          <label for="principal" >Lockin Period Frequency</label>
                          <div class="row">
                            <div class="col-md-4">
                              <input type="number" class="form-control" name="lock_per_freq" value="<?php echo $lockin_period_frequency; ?>" placeholder="Default" required>
                            </div>
                            <div class="col-md-8">
                          <select class="form-control" name="lock_per_freq_time" >
                          <option hidden value="<?php echo $lockin_period_frequency_enum;?>"><?php echo $lock_per_freq_time;?></option>
                            <option value="1">Days</option>
                            <option value="3">Months</option>
                            <option value="4">Years</option>
                          </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="principal" >Minimum Deposit Term</label>
                          <div class="row">
                            <div class="col-md-4">
                              <input type="number" class="form-control" name="minimum_dep_term" value="<?php echo $minimum_deposit_term;?>" placeholder="Min" required>
                            </div>
                            <div class="col-md-8">
                          <select class="form-control" name="minimum_dep_term_time" >
                          <option hidden value="<?php echo $minimum_deposit_term_time;?>"><?php echo $min_dep_time;?></option>
                            <option value="1">Days</option>
                            <option value="3">Months</option>
                            <option value="4">Years</option>
                          </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                       <div class="form-group">
                          <label for="additionalCharges" >Auto Renew on maturity</label>
                          <select class="form-control" name="auto_renew" required>
                          <option hidden value="<?php echo $auto_renew;?>"><?php echo $auto_ren;?></option>
                            <option value="2">No</option>
                            <option value="1">Yes</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="principal" >Maximum Deposit Term</label>
                          <div class="row">
                            <div class="col-md-4">
                              <input type="number" class="form-control" name="maximum_dep_term" value="<?php echo $minimum_deposit_term;?>" placeholder="Max" required>
                            </div>
                            <div class="col-md-8">
                          <select class="form-control" name="maximum_dep_term_time" >
                          <option hidden value="<?php echo $maximum_deposit_term_time;?>"><?php echo $max_dep_time;?></option>
                            <option value="1">Days</option>
                            <option value="3">Months</option>
                            <option value="4">Years</option>
                          </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                       <div class="form-group">
                          <label for="additionalCharges" >Allow Premature Closing Penalty</label>
                          <select class="form-control" name="allover" required>
                            <option value="2">No</option>
                            <option value="1">Yes</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="principal" >In Multiples of Deposit Term</label>
                          <div class="row">
                            <div class="col-md-4">
                              <input type="number" class="form-control" name="inmultiples_dep_term" value="<?php echo $minimum_deposit_term;?>" placeholder="Default" required>
                            </div>
                            <div class="col-md-8">
                          <select class="form-control" name="inmultiples_dep_term_time" >
                          <option hidden value="<?php echo $in_multiples_deposit_term_time;?>"><?php echo $in_multiples;?></option>
                            <option value="1">Days</option>
                            <option value="3">Months</option>
                            <option value="4">Years</option>
                          </select>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                  </div>
                        <!-- First tab -->
                         <!-- Second tab -->
                         <div class="tab">
                         <h3> Interest Rate Chart:</h3>
                    <div class="form-group">
                      <button type="button" class="btn btn-primary" name="button" onclick="showDialog()"> <i class="fa fa-plus"></i> Add</button>
                      </div>
                      <div class="form-group">
                      <script>
                              $(document).ready(function() {
                                $('#clickit').on("change keyup paste click", function() {
                                  var id = $('#ftd_id').val();
                                  var name = $('#nam').val();
                                  var start = $('#start').val();
                                  var end = $('#end').val();
                                  var intrate = $('#intrate').val();
                                  var term = $('#term').val();
                                  var amount = $('#amount').val();
                                  var desc = $('#desc').val();
                                  $.ajax({
                                    url:"ajax_post/update_int_rate_chart.php",
                                    method:"POST",
                                    data:{id:id, name:name, start:start, end:end, intrate:intrate, desc:desc, term:term, amount:amount},
                                    success:function(data){
                                      $('#coll').html(data);
                                    }
                                  })
                                });
                              });
                            </script>
                      <!-- <button class="btn btn-primary pull-right" id="clickit">Add</button> -->
                      <div id="coll">     
                      <table class = "table table-bordered">
                              <thead>
                              <?php
                        $query = "SELECT * FROM interest_rate_chart WHERE int_id = '$sessint_id' AND savings_id = '$user_id' ORDER BY id DESC";
                        $result = mysqli_query($connection, $query);
                      ?>
                                <tr>
                                  <th>Name</th>
                                  <th>From Date</th>
                                  <th>End Date</th>
                                  <th>Interest Rate</th>
                                  <th>Description</th>
                                  <th>Delete</th>
                                </tr>
                              </thead>
                              <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo $row["name"]; ?></th>
                        
                          <th><?php echo $row["start_date"]; ?></th>
                          <th><?php echo $row["end_date"]; ?></th>
                          <th><?php echo $row["interest_rate"]; ?></th>
                          <th><?php echo $row["description"]; ?></th>
                          <td><a href="" class="btn btn-danger">Delete</a></td>
                        </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                          <!-- <th></th> -->
                      </tbody>
                            </table>
                            </div>

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
                        <label class = "bmd-label-floating" class="md-3 form-align " for=""> Name:</label>
                        <input type="text" value="" name="col_name" id="nam" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class = "bmd-label-floating" for="">Start Date</label>
                        <input type="date" name="col_value" id="start" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class = "bmd-label-floating" for="">End Date:</label>
                        <input type="date" name="col_description" id="end" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class = "bmd-label-floating" for="">Interest Rate:</label>
                        <input type="number" name="col_value" id="intrate" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class = "bmd-label-floating" for="">Term:</label>
                        <input type="number" name="col_value" id="term" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class = "bmd-label-floating" for="">Amount:</label>
                        <input type="number" name="col_value" id="amount" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class = "bmd-label-floating" for="">Description:</label>
                        <input type="text" value="" name="col_value" id="desc" class="form-control">
                      </div>
                    </div>
                  <div style="float:right;">
                        <span class="btn btn-primary pull-right" id="clickit" onclick="AddDlg()">Add</span>
                        <span class="btn btn-primary pull-right" onclick="AddDlg()">Cancel</span>
                      </div>
                        <!-- </form> -->
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
        dlg.style.top = "50px";
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
                          <!-- Second tab -->
                           <!-- Third tab -->
                           <div class="tab">
                         <?php
                      // load user role data
                      function fill_charges($connection)
                      {
                      $sint_id = $_SESSION["int_id"];
                      $org = "SELECT * FROM charge WHERE int_id = '$sint_id' && charge_applies_to_enum = '1' && is_active = '1'";
                      $res = mysqli_query($connection, $org);
                      $output = '';
                      while ($row = mysqli_fetch_array($res))
                      {
                        $output .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                      }
                      return $output;
                      }
                      ?>
                         <h3>Charges</h3>
                    <div class="form-group">
                      <div class="row">
                      <div class="col-md-4">
                      <label>Charges:</label>
                      <input id="sde" type="text" value="<?php echo $name?>"value="<?php echo $user_id;?>" hidden /> 
                      <select name="charge_id" class="form-control" id="charges">
                        <option value="">select an option</option>
                        <?php echo fill_charges($connection); ?>
                      </select>
                      </div>
                      <script>
                              $(document).ready(function() {
                                $('#charges').on("change", function(){
                                  var id = $(this).val();
                                  var user = $('#ftd_id').val();
                                  $.ajax({
                                    url:"ajax_post/update_ftd_product_table.php",
                                    method:"POST",
                                    data:{id:id, user:user},
                                    success:function(data){
                                      $('#idd').html(data);
                                    }
                                  })
                                });
                              });
                            </script>
                      <div id="idd" class="col-md-12">
                      <table id="tabledat4" class="table" style="width: 100%;">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM ftd_product_charge WHERE int_id ='$sessint_id' AND ftd_id = '$user_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                      <th>Name</th>
                      <th>Charge</th>
                      <th>Collected On</th>
                      <th>Delete</th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                          <?php
                          $did = $row['id'];
                          $charge_id = $row['charge_id'];
                            $fid = "SELECT * FROM charge WHERE int_id = '$sessint_id' AND id ='$charge_id'";
                            $dfdf = mysqli_query($connection, $fid);
                            $d = mysqli_fetch_array($dfdf);
                            $name = $d['name'];
                            $amt = $d['amount'];
                            $ds = $d['charge_calculation_enum'];
                            $values = $d["charge_time_enum"];
                            if ($ds == 1) {
                              $chg = $amt." Flat";
                            } else {
                              $chg = $amt. "% of Loan Principal";
                            }
                            if ($values == 1) {
                              $xs = "Disbursement";
                            } else if ($values == 2) {
                              $xs = "Manual Charge";
                            } else if ($values == 3) {
                              $xs = "Savings Activiation";
                            } else if ($values == 5) {
                              $xs = "Deposit Fee";
                            } else if ($values == 6) {
                              $xs = "Annual Fee";
                            } else if ($values == 8) {
                              $xs = "Installment Fees";
                            } else if ($values == 9) {
                              $xs = "Overdue Installment Fee";
                            } else if ($values == 12) {
                              $xs = "Disbursement - Paid With Repayment";
                            } else if ($values == 13) {
                              $xs = "Loan Rescheduling Fee";
                            } 
                          ?>
                          <th><?php echo $name; ?></th>
                          <th><?php echo $chg; ?></th>
                          <th><?php echo $xs; ?></th>
                          <td><div data-id='<?= $did; ?>' class ="test"><a class="btn btn-danger">Delete</a></div></td>
                        </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                      </tbody>
                    </table>
                      </div>
                      </div>
                    </div>
                          </div>
                          <!-- Third tab -->
                           <!-- Fourth tab -->
                           <div class="tab">
                    <div class="row">
                          <!-- replace values with loan data -->
                          <div class="col-md-12">
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
                            <br>
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
                                while ($row = mysqli_fetch_array($res))
                                {
                                  $output .= '<option value = "'.$row["gl_code"].'"> '.strtoupper($row["name"]).' </option>';
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
                              <option hidden value="<?php echo $asst_loan_port;?>"><?php echo $ast_ln_prt;?></option>
                              <?php echo fill_asset($connection) ?>
                            </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-8">
                            <label for="charge" class="form-align">Insufficient Repayment</label>
                            <select class="form-control form-control-sm" name="insufficient_repayment">
                            <option hidden value="<?php echo $insufficient_repayment;?>"><?php echo $insuf_rymnt;?></option>
                              <?php echo fill_asset($connection) ?>
                            </select>
                            </div>
                          </div>
                          </div>
                      <h5 class="card-title">Liabilities</h5>
                      <?php
                              function fill_lia($connection)
                              {
                                $sint_id = $_SESSION["int_id"];
                                $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' && classification_enum = '2' ORDER BY name ASC";
                                $res = mysqli_query($connection, $org);
                                $output = '';
                                while ($row = mysqli_fetch_array($res))
                                {
                                  $output .= '<option value = "'.$row["gl_code"].'"> '.strtoupper($row["name"]).' </option>';
                                }
                                return $output;
                              }
                              ?>
                      <div class="position-relative form-group">
                        <div class="form-group">
                        <div class="col-md-8">
                            <label for="charge" class="form-align ">Overpayments</label>
                            <select class="form-control form-control-sm" name="li_overpayment">
                            <option hidden value="<?php echo $li_overpayment;?>"><?php echo $li_overnt;?></option>
                              <?php echo fill_lia($connection)?>
                            </select>
                        </div>
                          </div>
                          <div class="form-group">
                          <div class="col-md-8">
                            <label for="charge" class="form-align ">Suspended Income</label>
                            <select class="form-control form-control-sm" name="li_suspended_income">
                            <option hidden value="<?php echo $li_suspended_income;?>"><?php echo $li_susd_ime;?></option>
                              <?php echo fill_lia($connection)?>
                            </select>
                          </div>
                          </div>
                      </div> 
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
                                while ($row = mysqli_fetch_array($res))
                                {
                                  $output .= '<option value = "'.$row["gl_code"].'"> '.strtoupper($row["name"]).' </option>';
                                }
                                return $output;
                              }
                              ?>
                          <div class="col-md-8">
                              <label for="charge" class="form-align ">Income for Interest</label>
                              <select class="form-control form-control-sm" name="inc_interest">
                              <option hidden value="<?php echo $inc_interest;?>"><?php echo $inc_inst;?></option>
                                <?php echo fill_in($connection) ?>
                              </select>
                          </div>
                          </div>
                          <div class="form-group">
                          <div class="col-md-8">
                              <label for="charge" class="form-align ">Income from Fees</label>
                              <select class="form-control form-control-sm" name="inc_fees">
                              <option hidden value="<?php echo $inc_fees;?>"><?php echo $inc_fes;?></option>
                                <?php echo fill_in($connection) ?>
                              </select>
                          </div>
                          </div>
                          <div class="form-group">
                          <div class="col-md-8">
                              <label for="charge" class="form-align ">Income from Penalties</label>
                              <select class="form-control form-control-sm" name="inc_penalties">
                              <option hidden value="<?php echo $inc_penalties;?>"><?php echo $inc_pees;?></option>
                                <?php echo fill_in($connection) ?>
                              </select>
                          </div>
                          </div>
                          <div class="form-group">
                          <div class="col-md-8">
                              <label for="charge" class="form-align ">Income from Recovery</label>
                              <select class="form-control form-control-sm" name="inc_recovery">
                              <option hidden value="<?php echo $inc_recovery;?>"><?php echo $inc_reco;?></option>
                                <?php echo fill_in($connection) ?>
                              </select>
                          </div>
                          </div>
                          <div class="form-group">
                          <div class="col-md-8">
                              <label for="charge" class="form-align ">BVN Income</label>
                              <select class="form-control form-control-sm" name="bvn_income">
                              <option hidden value="<?php echo $bvn_income;?>"><?php echo $bvn_incme;?></option>
                                <?php echo fill_in($connection) ?>
                              </select>
                          </div>
                          </div>
                          
                          <!-- <div class="form-group">
                          <div class="col-md-8">
                              <label for="charge" class="form-align ">Income from Recovery</label>
                              <select class="form-control form-control-sm" name="">
                                <option value="">--</option>
                              </select>
                          </div>
                          </div> -->
                        </div>
                        <!-- next -->
                        <h5 class="card-title">Expenses</h5>
                        <div class="position-relative form-group">
                        <?php 
                              function fill_exp($connection)
                              {
                                $sint_id = $_SESSION["int_id"];
                                $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' && classification_enum = '5' ORDER BY name ASC";
                                $res = mysqli_query($connection, $org);
                                $output = '';
                                while ($row = mysqli_fetch_array($res))
                                {
                                  $output .= '<option value = "'.$row["gl_code"].'"> '.$row["name"].' </option>';
                                }
                                return $output;
                              }
                              ?>
                          <div class="form-group">
                          <div class="col-md-8">
                              <label for="charge" class="form-align ">Losses Written Off</label>
                              <select class="form-control form-control-sm" name="exp_loss_written_off">
                              <option hidden value="<?php echo $exp_loss_written_off;?>"><?php echo $exp_los_wttn_off;?></option>
                                <?php echo fill_exp($connection) ?>
                              </select> 
                          </div>
                          </div>
                          <div class="form-group">
                          <div class="col-md-8">
                              <label for="charge" class="form-align ">Interest Written Off</label>
                              <select class="form-control form-control-sm" name="exp_interest_written_off">
                              <option hidden value="<?php echo $exp_interest_written_off;?>"><?php echo $exp_int_wttn_off;?></option>
                                <?php echo fill_exp($connection) ?>
                              </select>
                          </div>
                          </div>
                          <div class="form-group">
                          <div class="col-md-8">
                              <label for="charge" class="form-align ">BVN Expense</label>
                              <select class="form-control form-control-sm" name="bvn_expense">
                              <option hidden value="<?php echo $bvn_expense;?>"><?php echo $bvn_exp;?></option>
                                <?php echo fill_exp($connection) ?>
                              </select>
                          </div>
                          </div>
                        </div>                
                          </div>
                      <div class="col-md-6">
                      <p>
                        <b style="font-size: 20px">
                        Accounting Instruction
                      </b>
                        </p>
                              <button class="btn btn-dark" type="button" data-toggle="modal" data-target="#exampleModal"><i class="material-icons">add</i></button>
                              <span>
                              Configure Fund sources for payment channels
                              </span>
                              <div id="fdof">
                              <div class="table-responsive">
                              <table id="tabledat" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM ftd_acct WHERE int_id ='$sessint_id' AND ftd_id = '$user_id' AND type ='pay'";
                        $result = mysqli_query($connection, $query);
                      ?>
                            <th> <b> Payment Type </b></th>
                            <th> <b>Assets Account <b></th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                          <th><?php echo $row['name']; ?></th>
                          <th><?php echo $row['acct']; ?></th>
                          <td><a class="btn btn-danger">Delete</a></td>
                        </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                      </tbody>
                    </table>
  </div>
  </div>
  <script>
                    $(document).ready(function() {
                      $('#run_pay').on("click", function(){
                        var paymentgl = $('#payment_gl').val();
                        var accountgl = $('#account_gl').val();
                        var prod_id = $('#ftd_id').val();
                        $.ajax({
                          url:"ajax_post/update_ftd_payment.php",
                          method:"POST",
                          data:{paymentgl:paymentgl, accountgl:accountgl, prod_id:prod_id},
                          success:function(data){
                            $('#fdof').html(data);
                          }
                        })
                      });
                    });

                    $(document).ready(function() {
                      $('#ediw').on("click", function(){
                        var penaltygl = $('#penaltygl').val();
                        var incomegl = $('#incomegl').val();
                        var prod_id = $('#ftd_id').val();
                        $.ajax({
                          url:"ajax_post/update_ftd_payment.php",
                          method:"POST",
                          data:{penaltygl:penaltygl, incomegl:incomegl, prod_id:prod_id},
                          success:function(data){
                            $('#qoem').html(data);
                          }
                        })
                      });
                    });
                </script>
                            <!-- <span>
                            Map Fees to Specific Income accounts
                            </span> -->
                            <button class="btn btn-dark" type="button" data-toggle="modal" data-target="#exampleModal3"><i class="material-icons">add</i></button>
                            <span>
                            Map Penalties to Specific income accounts
                            </span>
                            <div id="qoem">
                              <div class="table-responsive">
                              <table id="tabledat" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM ftd_acct WHERE int_id ='$sessint_id' AND ftd_id = '$user_id' AND type ='pen'";
                        $result = mysqli_query($connection, $query);
                      ?>
                            <th> <b> Penalty </b></th>
                            <th> <b> Income Account <b></th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                          <th><?php echo $row['name']; ?></th>
                          <th><?php echo $row['acct']; ?></th>
                          <td><a class="btn btn-danger">Delete</a></td>
                        </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                      </tbody>
                    </table>
                              </div>
                            </div>
                            </div>
                        </div>
                          
<!-- Modal -->
<?php 
                              function fill_all($connection)
                              {
                                $sint_id = $_SESSION["int_id"];
                                $org = "SELECT * FROM `acc_gl_account` WHERE int_id = '$sint_id' ORDER BY name ASC";
                                $res = mysqli_query($connection, $org);
                                $output = '';
                                while ($row = mysqli_fetch_array($res))
                                {
                                  $output .= '<option value = "'.$row["gl_code"].'"> '.$row["name"].' </option>';
                                }
                                return $output;
                              }
                              ?>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Accounting Instruction</h5>
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
                                while ($row = mysqli_fetch_array($res))
                                {
                                  $output .= '<option value = "'.$row["gl_code"].'"> '.$row["name"].' </option>';
                                }
                                return $output;
                              }
                              ?>
         <label for="charge" class="form-align ">Payment</label>
         <div id="real_payment" hidden></div>
         <div id="ipayment_id">
              <select id="payment_gl" class="form-control form-control-sm" name="">
              <option value="">--</option>
              <?php echo fill_payment($connection)?>
            </select>
         </div>
          </div>
          </div>
          <div class="col-md-6">
          <div class="form-group">
         <label for="charge" class="form-align">Asset Account</label>
              <select class="form-control form-control-sm" name="" id="account_gl">
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
      </div>
    </div>
  </div>
</div>
<!-- Modal2 -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
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
                                while ($row = mysqli_fetch_array($res))
                                {
                                  $output .= '<option value = "'.$row["gl_code"].'"> '.$row["name"].' </option>';
                                }
                                return $output;
                              }
                              ?>
         <label for="charge" class="form-align ">Fee</label>
         <div id="">
         <select class="form-control form-control-sm" name="" id="penalty_gl">
              <option value="">--</option>
              <?php echo fill_fee($connection) ?>
            </select>
         </div>
          </div>
          </div>
          <div class="col-md-6">
          <div class="form-group">
         <label for="charge" class="form-align ">Income Account</label>
              <select class="form-control form-control-sm" name="" id="income_gl">
              <option value="">--</option>
              <?php echo fill_in($connection) ?>
            </select> 
          </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="">Save changes</button>
      </div>
    </div>
  </div>
</div>
  <!-- Modal3 -->
<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
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
                                while ($row = mysqli_fetch_array($res))
                                {
                                  $output .= '<option value = "'.$row["gl_code"].'"> '.$row["name"].' </option>';
                                }
                                return $output;
                              }
                              ?>
         <label for="charge" class="form-align ">Penalty</label>
         <div id="real_payment3"></div>
         <div id="ipayment_id3">
         <select class="form-control form-control-sm" name="" id="penaltygl">
              <option value="">--</option>
              <?php echo fill_pen($connection) ?>
            </select> 
         </div>
          </div>
          </div>
          <div class="col-md-6">
          <div class="form-group">
         <label for="charge" class="form-align ">Income Account</label>
              <select class="form-control form-control-sm" name="" id="incomegl">
              <option value="">--</option>
              <?php echo fill_in($connection) ?>
            </select> 
          </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="ediw">Save changes</button>
      </div>
    </div>
  </div>
</div>
                          <!-- </div> -->
                      </div>
                  </div>
                          <!-- Fourth tab -->
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
                </div>
                </form>
              </div>
            </div>
          </div>
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
    document.getElementById("nextBtn").innerHTML = "Update";
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
                    <script>
  $(document).ready(function(){

// Delete 
$('.test').click(function(){
    var el = this;

    // Delete id
    var id = $(this).data('id');
    
    var confirmalert = confirm("Delete this charge?");
    if (confirmalert == true) {
        // AJAX Request
        $.ajax({
            url: 'ajax_post/ajax_delete/delete_ftd_charge.php',
            type: 'POST',
            data: { id:id },
            success: function(response){

                if(response == 1){
                    // Remove row from HTML Table
                    $(el).closest('tr').css('background','tomato');
                    $(el).closest('tr').fadeOut(700,function(){
                        $(this).remove();
                    });
                }else{
                    alert('Invalid ID.');
                }
            }
        });
    }
});
});
</script>