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
                  <div class="list-group">

                    <div class="list-group-item py-3" data-acc-step>
                      <h5 class="mb-0" data-acc-title>New Product</h5>
                      <div data-acc-content>
                        <div class="my-3">
                          <div class="form-group">
                            <label>Name *:</label>
                            <input type="text" required name="name" class="form-control" required id="">
                          </div>
                          <div class="form-group">
                                                        <label for="shortLoanName" >Short Loan Name *</label>
                                                        <input type="text" class="form-control" name="short_name" value="" placeholder="Short Name..." required>
                                                      </div>
                                                      

                                                      <div class="form-group">
                                                        <label for="loanDescription" >Description *</label>
                                                        <input type="text" class="form-control" name="description" value="" placeholder="Description...." required>
                                                      </div>

                                                    <div class="form-group">
                                                      <label for="fundOrigin">Origin of Funding*</label>
                                                      <select class="form-control" name="fund_id" required>
                                                        <option value="1">Bank</option>
                                                        <option value="2"> Cash </option>
                                                      </select>
                                                    </div>

    <!--                                                <div class="form-group">
                                                      <label for="currency" >Currency *</label>
                                                      <select class="form-control" name="" required>
                                                        <option value=""> -- Select an option -- </option>
                                                        <option value="">Nigeria Naira [NGN]</option>
                                                      </select>
                                                    </div>-->

    <!--                                                <div class="form-group">
                                                      <label for="decimal" >To Decimal Place</label>
                                                      <input type="text" class="form-control" name="" value="">
                                                    </div>-->

                                                    <div class="form-group">
                                                      <label for="installmentAmount" >Installment Amount in Multiples</label>
                                                      <input type="text" class="form-control" name="in_amt_multiples" value="">
                                                    </div>

                                                    <div class="form-group">
                                                      <label for="principal" >Principal</label>
                                                      <input type="text" class="form-control" name="principal_amount" value="" placeholder="Default" required>
                                                      <input type="text" class="form-control" name="min_principal_amount" value="" placeholder="Min" required>
                                                      <input type="text" class="form-control" name="max_principal_amount" value="" placeholder="Max" required>
                                                    </div>

                                                    <div class="form-group">
                                                      <label for="loanTerms" >Loan Term</label>
                                                      <input type="text" class="form-control" name="loan_term" value="" placeholder="Default" required>
                                                      <input type="text" class="form-control" name="min_loan_term" value="" placeholder="Min" required>
                                                      <input type="text" class="form-control" name="max_loan_term" value="" placeholder="Max" required>
                                                    </div>

                                                    <div class="form-group">
                                                      <label for="repaymentFrequency" >Repayment Frequency *</label>
                                                        <!-- <input type="text" class="form-control " name="repayment_frequency" value=""required> -->

                                                        <select class="form-control" name="repayment_every">
                                                          <option value="day">Day</option>
                                                          <option value="week">Week</option>
                                                          <option value="month">Month</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                      <label for="interestRate" >Interest Rate</label>
                                                      <input type="text" class="form-control" name="interest_rate" value="" placeholder="Default" required>
                                                      <input type="text" class="form-control" name="min_interest_rate" value="" placeholder="Min" required>
                                                      <input type="text" class="form-control" name="max_interest_rate" value="" placeholder="Max" required>
                                                    </div>

                                                    <div class="form-group">
                                                      <label for="interestRateApplied" >Interest Rate Applied *</label>
                                                      <select class="form-control" name="interest_rate_applied" required>
                                                        <option value="per_month">Per Month</option>
                                                        <option value="per_year">Per Year</option>
                                                      </select>
                                                    </div>
                                                
                                                <div class="form-group">
                                                  <label for="interestMethodology" >Interest Methodology *</label>
                                                  <select class="form-control" name="interest_rate_methodoloy" required>
                                                    <option value="1">Flat</option>
<!--                                                    <option value="">Declining Balance</option>-->
                                                  </select>
                                                </div>


                                              </div>

                                              <!-- <div class="row"> -->
<!--                                                <div class="input-group">
                                                  <label for="allowGracePeriod" >Allow Different Grace Period</label>
                                                  <input type="checkbox" name="" value="">
                                                </div>

                                                <div class="input-group">
                                                  <label for="standingInstruction" > Allow Standing Instruction </label>
                                                  <input type="checkbox" name="" value="">
                                                </div>

                                                <div class="input-group">
                                                  <label for="topUpLoan" > Is allowed to be used for providing Topup Loans </label>
                                                  <input type="checkbox" name="" value="">
                                                </div>                                              -->


                                                <div class="form-group">
                                                  <label for="amortizatioMethody" >Amortization Method *</label>
                                                  <select class="form-control" name="ammortization_method" required>
                                                    <option value="equal_installment">Equal Installments</option>
                                                    <option value="equal_principal_payment">Equal Principal Payment</option>
                                                  </select>
                                              </div>
                                              <div class="clearfix"></div>


<!--                                                <div class="form-group">
                                                  <label for="amortizatioMethody" >Interest Calculation Period Type *</label>
                                                  <select class="form-control" name="" required>
                                                    <option value="">Daily</option>
                                                    <option value="">Same as Repayment Period</option>
                                                  </select>
                                                </div>-->

<!--                                                <div class="form-group">
                                                  <label for="daysYear" >Days In Year *</label>
                                                  <select class="form-control" name="" required>
                                                    <option value="">Actual</option>
                                                    <option value="">360 Days</option>
                                                    <option value="">364 Days</option>
                                                    <option value="">365 Days</option>
                                                    <option value="">366 Days</option>
                                                  </select>
                                                </div>

                                                <div class="form-group">
                                                  <label for="daysMonthType" >Days In Month Type</label>
                                                  <select class="form-control" name="" required>
                                                    <option value="">Actual</option>
                                                    <option value="">30 Days</option>
                                                  </select>
                                                </div>-->

<!--                                                <div class="form-group">
                                                  <label for="processingStrategy" >Transaction Processing Strategy *</label>
                                                  <select class="form-control" name="" required>
                                                    <option value="">Penalties, Fees, Interest, Principal Order</option>
                                                    <option value="">Principal, Interest, Penalties, Fees Order</option>
                                                    <option value="">Interest, Principal, Penalties, Fees Order</option>
                                                  </select>
                                                </div>-->

                                                <div class="form-group">
                                                  <label for="loanCycleCount" >Include In Loan Cycle Count </label>
                                                  <select class="form-control" name="cycle_count" required>
                                                    <option value="no">No</option>
                                                    <option value="yes">Yes</option>
                                                  </select>
                                                </div>

<!--                                                <div class="form-group">
                                                  <label for="lockGuaranteeFunds" >Lock Guarantee Funds </label>
                                                  <select class="form-control" name="" required>
                                                    <option value="">No</option>
                                                    <option value="">Yes</option>
                                                  </select>
                                                </div>-->

                                                <div class="form-group">
                                                  <label for="overPayment" >Automatically Allocate Overpayment </label>
                                                  <select class="form-control" name="auto_allocate_overpayment" required>
                                                    <option value="no">No</option>
                                                    <option value="yes">Yes</option>
                                                  </select>
                                                </div>

                                                <div class="form-group">
                                                  <label for="additionalCharges" >Allow Additional Charges </label>
                                                  <select class="form-control" name="additional_charge" required>
                                                    <option value="no">No</option>
                                                    <option value="yes">Yes</option>
                                                  </select>
                                                </div>

                                                <div class="form-group">
                                                  <label for="autoDisburse" >Auto Disburse </label>
                                                  <select class="form-control" name="auto_disburse" required>
                                                    <option value="no">No</option>
                                                    <option value="yes">Yes</option>
                                                  </select>
                                                </div>

<!--                                                <div class="form-group">
                                                  <label for="restrictsavingsProductType" >Restrict Linked Savings Product Type </label>
                                                  <select class="form-control" name="" required>
                                                    <option value="">Abuja Savings Group</option>
                                                    <option value="">Lagos Savings Group</option>
                                                  </select>
                                                </div>-->
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
                                                <div class="form-group">
                                                  <label for="requireSavingsAcct" >Requires Linked Savings Account </label>
                                                  <select class="form-control" name="linked_savings_acct" required>
                                                    <option value="Abuja Savings Group">Abuja Savings Group</option>
                                                    <option value="Lagos Savings Group">Lagos Savings Group</option>
                                                  </select>
                                                </div>
                        <!-- </div> -->
                      </div>
                    </div>

                    <div class="list-group-item py-3" data-acc-step>
                      <h5 class="mb-0" data-acc-title>Charges</h5>
                      <div data-acc-content>
                        <div class="my-3">
                          <div class="form-group">
                          <div id="show_charges">
                            <!-- reveals those stuffsh -->
                          </div>
                          </div>
                          <div class="form-group">
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
                            <label>Charges:</label>
                            <select name="charge_id"class="form-control" id="charges">
                              <option value="">select an option</option>
                              <?php echo fill_charges($connection); ?>
                            </select>
                          </div>

                          <button class="btn btn-primary">Add To Product</button>
                        </div>
                      </div>
                    </div>

                    <div class="list-group-item py-3" data-acc-step>
                      <h5 class="mb-0" data-acc-title>Credit Checks</h5>
                      <div data-acc-content>
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
                    </div>

                    <!-- group 4 -->

                    <div class="list-group-item py-3" data-acc-step>
                      <h5 class="mb-0" data-acc-title>Accounting</h5>
                      <div data-acc-content>
                        <div class="my-3">
                          <!-- replace values with loan data -->
                          <div class=" col-md-6">

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

                                                    <h5 class="card-title">Expenses</h5>
                                                    <div class="position-relative form-group">
                                                        
                                                            <div class="form-group">
                                                                <label for="charge" class="form-align ">Losses Written Off</label>
                                                                <select class="form-control form-control-sm" name="">
                                                                  <option value="">--</option>
                                                                </select>
                                                                
                                                              </div>
                                                        
                                                    </div>

                                                    <h5 class="card-title">Advanced Accounting Rules</h5>
                                                    <div class="position-relative form-group">
                                                        
                                                            <div class="form-group">
                                                                <label for="charge" > Add Configure Fund sources for payment channels</label>
                                                                <button class="btn btn-primary-sm btn-primary " name="" type="button" ><i class="fa fa-plus"></i> Add</button>
                                                              
                                                              <table class="table table-striped table-bordered">
                                                                  <thead>
                                                                      <tr>
                                                                          <th>Payment Type</th>
                                                                          <th>Fund Source</th>
                                                                      </tr>
                                                                  </thead>
                                                                  <tbody>
                                                                      <tr>
                                                                          <td>Cash</td>
                                                                          <td>--</td>
                                                                      </tr>
                                                                  </tbody>
                                                              </table>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="charge" class=" "> Add Map Fees to Specific Income accounts</label>
                                                                <button class="btn btn-primary-sm btn-primary " name="" type="button" ><i class="fa fa-plus"></i> Add</button>
                                                              
                                                              <table class="table table-striped table-bordered">
                                                                  <thead>
                                                                      <tr>
                                                                          <th>Fee</th>
                                                                          <th>Income Account</th>
                                                                      </tr>
                                                                  </thead>
                                                                  <tbody>
                                                                      <tr>
                                                                          <td>Cash</td>
                                                                          <td>--</td>
                                                                      </tr>
                                                                  </tbody>
                                                              </table>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="charge" > Add Map Penalties to Specific income accounts</label>
                                                                <button class="btn btn-primary-sm btn-primary " name="" type="button" ><i class="fa fa-plus"></i> Add</button>
                                                              
                                                              <table class="table table-striped table-bordered">
                                                                  <thead>
                                                                      <tr>
                                                                          <th>Penalty</th>
                                                                          <th>Income Account</th>
                                                                      </tr>
                                                                  </thead>
                                                                  <tbody>
                                                                      <tr>
                                                                          <td>Cash</td>
                                                                          <td>--</td>
                                                                      </tr>
                                                                  </tbody>
                                                              </table>
                                                            </div>                                                            
                                                        
                                                    </div>
                                                    
                                            </div>
                          <!-- / -->
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
<?php

    include("footer.php");

?>