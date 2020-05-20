<?php

$page_title = "New Product";
$destination = "index.php";
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
                  <h4 class="card-title">Create new Product</h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                <form id="form" action="../functions/int_product_upload.php" method="POST">
                <div class = "row">
                    <div class = "col-md-12">
                      <div class = "form-group">
                        <!-- Each tab equals a stepper page -->
                  <!-- First Tab -->
                  <div class="tab">
                  <h3> New Product:</h3>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Name *:</label>
                        <input type="text"  name="name" class="form-control"  id="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="shortLoanName" >Short Loan Name *</label>
                        <input type="text" class="form-control" name="short_name" value="" placeholder="Short Name..." >
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="loanDescription" >Description *</label>
                        <input type="text" class="form-control" name="description" value="" placeholder="Description...." >
                      </div>
                    </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="installmentAmount" >Installment Amount in Multiples</label>
                          <input type="text" class="form-control" name="in_amt_multiples" value="">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="principal" >Principal</label>
                          <div class="row">
                            <div class="col-md-4">
                              <input type="text" class="form-control" name="principal_amount" value="" placeholder="Default" >
                            </div>
                            <div class="col-md-4">
                             <input type="text" class="form-control" name="min_principal_amount" value="" placeholder="Min" >
                            </div>
                            <div class="col-md-4">
                              <input type="text" class="form-control" name="max_principal_amount" value="" placeholder="Max" >
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="loanTerms" >Loan Term</label>
                          <div class="row">
                            <div class="col-md-4">
                              <input type="text" class="form-control" name="loan_term" value="" placeholder="Default" >
                            </div>
                            <div class="col-md-4">
                              <input type="text" class="form-control" name="min_loan_term" value="" placeholder="Min" >
                          </div>
                            <div class="col-md-4">
                              <input type="text" class="form-control" name="max_loan_term" value="" placeholder="Max" >
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                        <label for="repaymentFrequency" >Repayment Frequency *</label>
                        <div class="row">
                        <div class="col-md-8">
                          <input type="text" class="form-control " name="repayment_frequency" value="" >
                        </div>
                        <div class="col-md-4">
                        <select class="form-control" name="repayment_every">
                          <option value="day">Days</option>
                          <option value="week">Weeks</option>
                          <option value="month">Months</option>
                        </select>
                        </div>
                        </div>
                        </div>
                      </div>                     
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="interestRate" >Interest Rate</label>
                          <div class="row">
                            <div class="col-md-4">
                              <input type="text" class="form-control" name="interest_rate" value="" placeholder="Default" >
                            </div>
                            <div class="col-md-4">
                              <input type="text" class="form-control" name="min_interest_rate" value="" placeholder="Min" >
                            </div>
                            <div class="col-md-4">
                              <input type="text" class="form-control" name="max_interest_rate" value="" placeholder="Max" >
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="interestRateApplied" >Interest Rate Applied *</label>
                          <select class="form-control" name="interest_rate_applied" >
                            <option value="per_month">Per Month</option>
                            <option value="per_year">Per Year</option>
                          </select>
                        </div>
                      </div>

                        <div class="col-md-6">
                        <div class="form-group">
                          <label for="interestRateApplied" >Enable Balloon repayment</label>
                          <select class="form-control" name="enable" >
                           <option value="no">No</option>
                            <option value="yes">Yes</option>
                          </select>
                        </div>
                      </div>
                    <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-4">
                     
                      <div class="form-group">
                        <label for="loanDescription" >Grace on principal payment</label>
                        <input type="text" class="form-control" name="grace_on_principal" value="">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="loanDescription" >Grace on interest payment</label>
                        <input type="text" class="form-control" name="grace_on_interest" value="">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="loanDescription" >Grace on interest charged</label>
                        <input type="text" class="form-control" name="grace_on_interest_charged" value="">
                      </div>
                    </div>
                    </div>
                    </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="interestMethodology" >Interest Methodology *</label>
                          <select class="form-control" name="interest_rate_methodoloy" >
                            <option value="1">Flat</option>
                            <option value="">Declining Balance</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="amortizatioMethody" >Amortization Method *</label>
                          <select class="form-control" name="ammortization_method" required>
                            <option value="equal_installment">Equal Installments</option>
                            <option value="equal_principal_payment">Equal Principal Payment</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="loanCycleCount" >Include In Loan Cycle Count </label>
                          <select class="form-control" name="cycle_count" required>
                            <option value="no">No</option>
                            <option value="yes">Yes</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="overPayment" >Automatically Allocate Overpayment </label>
                          <select class="form-control" name="auto_allocate_overpayment" required>
                            <option value="no">No</option>
                            <option value="yes">Yes</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                       <div class="form-group">
                          <label for="additionalCharges" >Allow Additional Charges </label>
                          <select class="form-control" name="additional_charge" required>
                            <option value="no">No</option>
                            <option value="yes">Yes</option>
                          </select>
                        </div>
                      </div>
                      <!-- auto desburse should be disabled -->
                      <div class="col-md-6" hidden>
                        <div class="form-group">
                          <label for="autoDisburse" >Auto Disburse </label>
                          <select class="form-control" name="auto_disburse" required>
                            <option value="yes">yes</option>
                          </select>
                        </div>
                      </div>
                      <!-- <div class="col-md-6">
                        <div class="form-group">
                            <label for="requireSavingsAcct" >Requires Linked Savings Account </label>
                            <select class="form-control" name="linked_savings_acct" required>
                              <option value="Abuja Savings Group">Abuja Savings Group</option>
                              <option value="Lagos Savings Group">Lagos Savings Group</option>
                            </select>
                          </div>
                      </div> -->
                  </div>
                  </div>
                  <!-- First Tab -->
                  <!-- Second Tab -->
                  <div class="tab">
                    <h3>Charges</h3>
                    <input type="text" hidden readonly id="int_id" value="<?php echo $sessint_id; ?>">
                    <input type="text" hidden readonly id="branch_id" value="<?php echo $branch_id; ?>">
                    <script>
                      $(document).ready(function() {
                        $('#charges').change(function(){
                          var id = $(this).val();
                          var int_id = $('#int_id').val();
                          var branch_id = $('#branch_id').val();
                          var main_p = $('#main_p').val();
                          $.ajax({
                            url:"load_data.php",
                            method:"POST",
                            data:{id:id, int_id:int_id, branch_id:branch_id, main_p: main_p},
                            success:function(data){
                              $('#show_charges').html(data);
                              document.getElementById("takeme").setAttribute("hidden", "");
                              document.getElementById("damn_men").removeAttribute("hidden");
                            }
                          })
                        });
                      })
                    </script>
                    <div class="form-group">
                      <?php
                      $digits = 6;
                      $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
                      $_SESSION["product_temp"] = $randms;
                      $main_p = $_SESSION["product_temp"];
                      ?>
                    </div>
                    <div class="form-group">
                      <div class="row">
                      <div class="col-md-4">
                      <label>Charges:</label>
                      <div id="damn_men" hidden>
                      </div>
                      <div id="takeme">
                      <input type="text" hidden value="<?php echo $main_p; ?>" id="main_p">
                      <select name="charge_id"class="form-control" id="charges">
                        <option value="">select an option</option>
                        <?php echo fill_charges($connection); ?>
                      </select>
                      </div>
                      </div>
                      <div class="col-md-6">
                      <div id="show_charges">
                      </div>
                      </div>
                      </div>
                    </div>
                    <?php
                      // load user role data
                      function fill_charges($connection)
                      {
                      $sint_id = $_SESSION["int_id"];
                      $main_p  = $_SESSION["product_temp"];
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
                      <script>
                              $(document).ready(function() {
                                $('#credit').on("change keyup paste click", function(){
                                  var id = $(this).val();
                                  $.ajax({
                                    url:"credit_check.php",
                                    method:"POST",
                                    data:{id:id},
                                    success:function(data){
                                      $('#show_credit').html(data);
                                    }
                                  })
                                });
                              });
                            </script>
                  </div>
                  <!-- Second Tab -->
                  <!-- Third Tab -->
                  <div class="tab">
                    <h3>Credit Checks</h3>
                    <div class="row">
                     <div class="col-md-8">
        <h4>SUBJECTIVE/STATISTIC SCOREING CREDIT CHECK MODEL</h4>
        <p>Read the Guide in Running this Model</p>
        <p>Have it in <b>MIND</b> this scoring model is used for new customers or Manual Entries by Loan Officers</p>
        </div>
        <div class="col-md-12">
        <p>Find Details Below</p>
        <script>
    $(document).ready(function() {
    $('#tabledat').DataTable();
    });
</script>
         <table id="tabledat" class="table" cellspacing="0" style="width:100%">
         <thead>
           <th> <b> Name </b></th>
           <th> <b>Risk Level <b></th>
           <th> <b>Severity Level <b></th>
           <th> <b> Description <b></th>
         </thead>
         <tbody>
           <tr>
             <th> <h5> Delinquency Counter </h5></th>
             <th> <h5>High </h5></th>
             <th> <h5>Warning</h5></th>
             <th> <h5>Counting Over Due Repayment</h5> </th>
           </tr>
           <tr>
             <th> <h5>Loan History Status</h5> </th>
             <th> <h5>High</h5> </th>
             <th> <h5>Warning</h5> </th>
             <th> <h5>Check Hisotry of collection, Closed, Written off, Active and Same Product</h5> </th>
           </tr>
           <tr>
             <th> <h5>Psychometric Data</h5> </th>
             <th> <h5>Normal</h5> </th>
             <th> <h5>Warning</h5> </th>
             <th> <h5>Amplitude Test for measuring intelligence</h5> </th>
           </tr>
           <tr>
             <th> <h5>Savings Behaviour</h5> </th>
             <th> <h5>High</h5> </th>
             <th> <h5>Block Loan</h5> </th>
             <th> <h5>Study of Avg. Savings and also Transaction Cycle of the Applicant</h5> </th>
           </tr>
           <tr>
             <th> <h5>Guarantors Savings Behaviour</h5> </th>
             <th> <h5>Normal</h5> </th>
             <th> <h5>Pass</h5> </th>
             <th> <h5>Track Guarantors Transaction and Give Feedback</h5> </th>
           </tr>
           <tr>
             <th> <h5>Outstanding Loan Balance</h5> </th>
             <th> <h5>Normal</h5> </th>
             <th> <h5>Warning</h5> </th>
             <th> <h5>Check for Any Loan Outstanding Balance, Reduction of Lend Limit</h5> </th>
           </tr>
           <tr>
             <th> <h5>KYC</h5> </th>
             <th> <h5>High</h5> </th>
             <th> <h5>Block</h5> </th>
             <th> <h5>Checks for Important Details of Customers Bio Data</h5> </th>
           </tr>
          <!-- <tr>
             <th> <h5></h5> </th>
             <th> <h5></h5> </th>
             <th> <h5></h5> </th>
             <th> <h5></h5> </th>
           </tr>
           <tr>
             <th> <h5></h5> </th>
             <th> <h5></h5> </th>
             <th> <h5></h5> </th>
             <th> <h5></h5> </th>
           </tr>  -->
         </tbody>
         </table>
        <p>Table Description</p>
        </div>
                    </div>
                  </div>
                  <!-- Third Tab -->
                  <!-- Fourth Tab -->
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
                        <h5 class="card-title">Assets</h5>
                          <div class="position-relative form-group">
                            <div class="form-group">
                              <label for="charge" class="form-align ">Fund Source</label>
                              <select class="form-control form-control-sm" name="">
                                <option value="">--</option>
                              </select>
                              <!-- <span>
                              <a type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="
The Fund Source is the pool of funds used to disburse loans from (such as your bank account). This account is credited when the loan is disbursed and debited when a repayment is made.">
                                Read
                              </a>
                                </span> -->
                              <!-- <span class="input-group-btn">
                                     <button type="button" class="btn btn-fab btn-round btn-primary">
                                      <i class="material-icons">attach_file</i>
                                     </button>
                                     </span> -->
                            </div>
                            <div class="form-group">
                            <label for="charge" class="form-align ">Loan Portfolio</label>
                            <select class="form-control form-control-sm" name="">
                              <option value="">--</option>
                            </select>
                          </div>
                          </div>
                      <h5 class="card-title">Liabilities</h5>
                      <div class="position-relative form-group">
                        <div class="form-group">
                            <label for="charge" class="form-align ">Overpayments</label>
                            <select class="form-control form-control-sm" name="">
                              <option value="">--</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="charge" class="form-align ">Suspended Income</label>
                            <select class="form-control form-control-sm" name="">
                              <option value="">--</option>
                            </select>
                          </div>
                      </div>                 
                          </div>
                          <div class="col-md-6">            
                      <h5 class="card-title">Income</h5>
                      <div class="position-relative form-group">
                          <div class="form-group">
                              <label for="charge" class="form-align ">Income for Interest</label>
                              <select class="form-control form-control-sm" name="">
                                <option value="">--</option>
                              </select> 
                          </div>
                          <div class="form-group">
                              <label for="charge" class="form-align ">Income from Fees</label>
                              <select class="form-control form-control-sm" name="">
                                <option value="">--</option>
                              </select>
                          </div>
                          <div class="form-group">
                              <label for="charge" class="form-align ">Income from Penalties</label>
                              <select class="form-control form-control-sm" name="">
                                <option value="">--</option>
                              </select>
                          </div>
                          <div class="form-group">
                              <label for="charge" class="form-align ">Income from Recovery</label>
                              <select class="form-control form-control-sm" name="">
                                <option value="">--</option>
                              </select>
                          </div>
                          <div class="form-group">
                              <label for="charge" class="form-align ">Income from Recovery</label>
                              <select class="form-control form-control-sm" name="">
                                <option value="">--</option>
                              </select>
                          </div>
                        </div>
                      </div>
                          <div class="col-md-6">
                      <h5 class="card-title">Expenses</h5>
                        <div class="position-relative form-group">
                          <div class="form-group">
                              <label for="charge" class="form-align ">Losses Written Off</label>
                              <select class="form-control form-control-sm" name="">
                                <option value="">--</option>
                              </select> 
                          </div>
                          <div class="form-group">
                              <label for="charge" class="form-align ">Interest Written Off</label>
                              <select class="form-control form-control-sm" name="">
                                <option value="">--</option>
                              </select>
                          </div>
                        </div>
                          </div>
                        </div>
                        <br> <br>
                        <p>
                        <b style="font-size: 20px">
                        Advanced Accounting Rules
                      </b>
                        </p>
                        <div class="row">
                          
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
                            <div class="col-md-6">
                              <button class="btn btn-dark" type="button" data-toggle="modal" data-target="#exampleModal"><i class="material-icons">add</i></button>
                              <span>
                              Configure Fund sources for payment channels
                              </span>
                              <table id="tabledat" class="table" cellspacing="0" style="width:100%">
         <thead>
           <th> <b> Payment Type </b></th>
           <th> <b>Fund Source <b></th>
         </thead>
         <tbody>
           <tr>
             <th> <h5> Eco Bank </h5></th>
             <th> <h5>GL </h5></th>
           </tr>
         </tbody>
         </table>
                            </div>
                            <div class="col-md-6">
                            <button class="btn btn-dark" type="button"><i class="material-icons">add</i></button>
                            <span>
                            Map Fees to Specific Income accounts
                            </span>
                              <table id="tabledat" class="table" cellspacing="0" style="width:100%">
         <thead>
           <th> <b> Fee </b></th>
           <th> <b>Income Account <b></th>
         </thead>
         <tbody>
           <tr>
             <th> <h5> Eco Bank </h5></th>
             <th> <h5>GL </h5></th>
           </tr>
         </tbody>
         </table>
                            </div>
                            <div class="col-md-6">
                            <button class="btn btn-dark" type="button"><i class="material-icons">add</i></button>
                            <span>
                            Map Penalties to Specific income accounts
                            </span>
                              <table id="tabledat" class="table" cellspacing="0" style="width:100%">
         <thead>
           <th> <b> Penalty </b></th>
           <th> <b> Income Account <b></th>
         </thead>
         <tbody>
           <tr>
             <th> <h5> Eco Bank </h5></th>
             <th> <h5>GL </h5></th>
           </tr>
         </tbody>
         </table>
                            </div>
                          </div>
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