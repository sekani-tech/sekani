<?php

    include("header.php");

?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Create new Product</h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                <form id="form">
                  <div class="list-group">

                    <div class="list-group-item py-3" data-acc-step>
                      <h5 class="mb-0" data-acc-title>New Product</h5>
                      <div data-acc-content>
                        <div class="my-3">
                          <div class="form-group">
                            <label>Name *:</label>
                            <input type="text" required name="" class="form-control" required id="">
                          </div>
                          <div class="form-group">
                                                        <label for="shortLoanName" >Short Loan Name *</label>
                                                        <input type="text" class="form-control" name="" value="" placeholder="Short Name..." required>
                                                      </div>
                                                      

                                                      <div class="form-group">
                                                        <label for="loanDescription" >Description *</label>
                                                        <input type="text" class="form-control" name="" value="" placeholder="Description...." required>
                                                      </div>

                                                    <div class="form-group">
                                                      <label for="fundOrigin">Origin of Funding*</label>
                                                      <select class="form-control" name="fundOrigin" required>
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
                                                      <input type="text" class="form-control" name="" value="">
                                                    </div>

                                                    <div class="form-group">
                                                      <label for="principal" >Principal</label>
                                                      <input type="text" class="form-control" name="" value="" placeholder="Default" required>
                                                      <input type="text" class="form-control" name="" value="" placeholder="Min" required>
                                                      <input type="text" class="form-control" name="" value="" placeholder="Max" required>
                                                    </div>

                                                    <div class="form-group">
                                                      <label for="loanTerms" >Loan Term</label>
                                                      <input type="text" class="form-control" name="" value="" placeholder="Default" required>
                                                      <input type="text" class="form-control" name="" value="" placeholder="Min" required>
                                                      <input type="text" class="form-control" name="" value="" placeholder="Max" required>
                                                    </div>

                                                    <div class="form-group">
                                                      <label for="repaymentFrequency" >Repayment Frequency *</label>
                                                        <input type="text" class="form-control " name="" value=""required>

                                                        <select class="form-control" name="">
                                                          <option value="">Days</option>
                                                          <option value="">Weeks</option>
                                                          <option value="">Months</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                      <label for="interestRate" >Interest Rate</label>
                                                      <input type="text" class="form-control" name="" value="" placeholder="Default" required>
                                                      <input type="text" class="form-control" name="" value="" placeholder="Min" required>
                                                      <input type="text" class="form-control" name="" value="" placeholder="Max" required>
                                                    </div>

                                                    <div class="form-group">
                                                      <label for="interestRateApplied" >Interest Rate Applied *</label>
                                                      <select class="form-control" name="" required>
                                                        <option value="">Per Month</option>
                                                        <option value="">Per Year</option>
                                                      </select>
                                                    </div>
                                              

<!--                                                <div class="form-group">
                                                  <label for="multipleRepayments" >Enable Multiple Balloon Repayments </label>
                                                  <select class="form-control" name="" required>
                                                    <option value="">No</option>
                                                    <option value=""> Yes</option>
                                                  </select>
                                                </div>

                                                <div class="form-group">
                                                  <label for="paymentSchedule" >Allow Adjustment of Repayment Schedule </label>
                                                  <select class="form-control" name=""required>
                                                    <option value="">No</option>
                                                    <option value=""> Yes</option>
                                                  </select>
                                                </div>-->

<!--                                                <div class="form-group">
                                                  <label for="gracePrincipal" > Grace On Principal Payment *</label>
                                                  <input type="text" class="form-control" name="" value="" required>
                                                </div>

                                                <div class="form-group">
                                                  <label for="graceInterest" > Grace On Interest Payment *</label>
                                                  <input type="text" class="form-control" name="" value="" required>
                                                </div>

                                                <div class="form-group">
                                                  <label for="graceInterestCharged" > Grace On Interest Charged *</label>
                                                  <input type="text" class="form-control" name="" value="" required>
                                                </div>-->
                                                
                                                <div class="form-group">
                                                  <label for="interestMethodology" >Interest Methodology *</label>
                                                  <select class="form-control" name="" required>
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
                                                  <select class="form-control" name="" required>
                                                    <option value="">Equal Installments</option>
                                                    <option value="">Equal Principal Payment</option>
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
                                                  <select class="form-control" name="" required>
                                                    <option value="">No</option>
                                                    <option value="">Yes</option>
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
                                                  <select class="form-control" name="" required>
                                                    <option value="">No</option>
                                                    <option value="">Yes</option>
                                                  </select>
                                                </div>

                                                <div class="form-group">
                                                  <label for="additionalCharges" >Allow Additional Charges </label>
                                                  <select class="form-control" name="" required>
                                                    <option value="">No</option>
                                                    <option value="">Yes</option>
                                                  </select>
                                                </div>

                                                <div class="form-group">
                                                  <label for="autoDisburse" >Auto Disburse </label>
                                                  <select class="form-control" name="" required>
                                                    <option value="">No</option>
                                                    <option value="">Yes</option>
                                                  </select>
                                                </div>

<!--                                                <div class="form-group">
                                                  <label for="restrictsavingsProductType" >Restrict Linked Savings Product Type </label>
                                                  <select class="form-control" name="" required>
                                                    <option value="">Abuja Savings Group</option>
                                                    <option value="">Lagos Savings Group</option>
                                                  </select>
                                                </div>-->

                                                <div class="form-group">
                                                  <label for="requireSavingsAcct" >Requires Linked Savings Account </label>
                                                  <select class="form-control" name="" required>
                                                    <option value="">Abuja Savings Group</option>
                                                    <option value="">Lagos Savings Group</option>
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
                            <p><label for="">Name: </label> <span></span></p>
                            <p><label for="">Charge: </label> <span></span></p>
                            <p><label for="">Collected on: </label> <span></span></p>
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
            <div class="col-md-4">
              <div class="card card-profile">
                <div class="card-avatar">
                  <a href="#pablo">
                    <img class="img" src="../assets/img/faces/marc.jpg" />
                  </a>
                </div>
                <!-- Get session data and populate user profile -->
                <div class="card-body">
                  <h6 class="card-category text-gray">CEO / Co-Founder</h6>
                  <h4 class="card-title">Alec Thompson</h4>
                  <p class="card-description">
                    Sekani Systems
                  </p>
                  <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
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