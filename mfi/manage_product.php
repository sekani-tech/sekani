<?php

$page_title = "New Product";
$destination = "config.php";
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
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Name *:</label>
                        <input type="text"  name="name" class="form-control"  id="">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="shortLoanName" >Short Loan Name *</label>
                        <input type="text" class="form-control" name="short_name" value="" placeholder="Short Name..." >
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="loanDescription" >Description *</label>
                        <input type="text" class="form-control" name="description" value="" placeholder="Description...." >
                      </div>
                    </div>
                    <div class="col-md-4"> 
                      <div class="form-group">
                        <label for="fundOrigin">Origin of Funding*</label>
                        <select class="form-control" name="fund_id" >
                          <option value="1">Bank</option>
                          <option value="2"> Cash </option>
                        </select>
                      </div>
                    </div>                            
                    <!--<div class="col-md-4">
                        <div class="form-group">
                            <label for="currency" >Currency *</label>
                            <select class="form-control" name="" >
                              <option value=""> -- Select an option -- </option>
                              <option value="">Nigeria Naira [NGN]</option>
                            </select>
                          </div>
                        </div>-->
                      <!-- <div class="form-group">
                        <label for="decimal" >To Decimal Place</label>
                        <input type="text" class="form-control" name="" value="">
                      </div>-->
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="installmentAmount" >Installment Amount in Multiples</label>
                          <input type="text" class="form-control" name="in_amt_multiples" value="">
                        </div>
                      </div>
                      <div class="col-md-4">
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
                      <div class="col-md-4">
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
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="repaymentFrequency" >Repayment Frequency *</label>
                          <input type="text" class="form-control " name="repayment_frequency" value="" >
                        </div>
                      </div>
                      <div class="col-md-4">
                      <label for="repayment_every" >Repayment Every</label>
                        <select class="form-control" name="repayment_every">
                          <option value="day">Day</option>
                          <option value="week">Week</option>
                          <option value="month">Month</option>
                        </select>
                      </div>                     
                      <div class="col-md-4">
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
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="interestRateApplied" >Interest Rate Applied *</label>
                          <select class="form-control" name="interest_rate_applied" >
                            <option value="per_month">Per Month</option>
                            <option value="per_year">Per Year</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="interestMethodology" >Interest Methodology *</label>
                          <select class="form-control" name="interest_rate_methodoloy" >
                            <option value="1">Flat</option>
                            <option value="">Declining Balance</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="amortizatioMethody" >Amortization Method *</label>
                          <select class="form-control" name="ammortization_method" required>
                            <option value="equal_installment">Equal Installments</option>
                            <option value="equal_principal_payment">Equal Principal Payment</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="loanCycleCount" >Include In Loan Cycle Count </label>
                          <select class="form-control" name="cycle_count" required>
                            <option value="no">No</option>
                            <option value="yes">Yes</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="overPayment" >Automatically Allocate Overpayment </label>
                          <select class="form-control" name="auto_allocate_overpayment" required>
                            <option value="no">No</option>
                            <option value="yes">Yes</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                       <div class="form-group">
                          <label for="additionalCharges" >Allow Additional Charges </label>
                          <select class="form-control" name="additional_charge" required>
                            <option value="no">No</option>
                            <option value="yes">Yes</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="autoDisburse" >Auto Disburse </label>
                          <select class="form-control" name="auto_disburse" required>
                            <option value="no">No</option>
                            <option value="yes">Yes</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <label for="requireSavingsAcct" >Requires Linked Savings Account </label>
                            <select class="form-control" name="linked_savings_acct" required>
                              <option value="Abuja Savings Group">Abuja Savings Group</option>
                              <option value="Lagos Savings Group">Lagos Savings Group</option>
                            </select>
                          </div>
                      </div>
                  </div>
                  </div>
                  <!-- First Tab -->
                  <!-- Second Tab -->
                  <div class="tab">
                    <h3>Charges</h3>
                    <script>
                      $(document).ready(function() {
                        $('#charges').change(function(){
                          var id = $(this).val();
                          $.ajax({
                            url:"load_data.php",
                            method:"POST",
                            data:{id:id},
                            success:function(data){
                              $('#show_charges').html(data);
                            }
                          })
                        });
                      })
                    </script>
                    <div class="form-group">
                    <div id="show_charges">
                            <!-- reveals those stuffsh -->
                    </div>
                    </div>
                    <div class="form-group">
                      <label>Charges:</label>
                      <select name="charge_id"class="form-control" id="charges">
                        <option value="">select an option</option>
                        <?php echo fill_charges($connection); ?>
                      </select>
                    </div>
                    <?php
                      // load user role data
                      function fill_charges($connection)
                      {
                      $sint_id = $_SESSION["int_id"];
                      $org = "SELECT * FROM charge WHERE int_id = '$sint_id'";
                      $res = mysqli_query($connection, $org);
                      $output = '';
                      while ($row = mysqli_fetch_array($res))
                      {
                        $output .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                      }
                      return $output;
                      }
                      ?>
                  </div>
                  <!-- Second Tab -->
                  <!-- Third Tab -->
                  <div class="tab">
                    <h3>Credit Checks</h3>
                    <div class="my-3">
                        <div class="form-group">
                            <p><label for="">Name: </label> <span></span></p>
                            <p><label for="">Security Level: </label> <span></span></p>
                            <p><label for="">Order: </label> <span></span></p>
                          </div>
                          <div class="form-group">
                            <label>Charges:</label>
                            <select name=""class="form-control" id="">
                              <option value="">select an option</option>
                            </select>
                          </div>

                          <button class="btn btn-primary">Add To Product</button>
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
                                    <input type="radio" id="cashBased" name="acc" class="custom-control-input">
                                    <label class="custom-control-label" for="cashBased">Cash Based</label>
                                </div>
                                <div class="custom-radio custom-control">
                                    <input type="radio" id="accuralP" name="acc" class="custom-control-input">
                                    <label class="custom-control-label" for="accuralP">Accural (Periodic)</label>
                                </div>
                                <div class="custom-radio custom-control">
                                    <input type="radio" id="accuralU" name="acc" class="custom-control-input">
                                    <label class="custom-control-label" for="accuralU">Accural (Upfront)</label>
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title">Expenses</h5>
                          <div class="position-relative form-group">
                            <div class="form-group">
                              <label for="charge" class="form-align ">Losses Written Off</label>
                              <select class="form-control form-control-sm" name="">
                                <option value="">--</option>
                              </select>
                            </div>
                          </div>
                      <h5 class="card-title">Assets</h5>
                      <div class="position-relative form-group">
                        <div class="form-group">
                            <label for="charge" class="form-align ">Fund Source</label>
                            <select class="form-control form-control-sm" name="">
                              <option value="">--</option>
                            </select>
                          </div>
                          <div class=" input-group">
                            <label for="charge" class="form-align ">Loan Portfolio</label>
                            <select class="form-control form-control-sm" name="">
                              <option value="">--</option>
                            </select>
                          </div>
                      </div>                             
                      <h5 class="card-title">Liabilities</h5>
                      <div class="position-relative form-group">
                        <div class="form-group">
                          <label for="charge" class="form-align ">Over Payment</label>
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