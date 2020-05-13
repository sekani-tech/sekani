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
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Charge Type</label>
                          <select name="charge_type" id="" class="form-control">
                              <option value="1">Disbursement</option>
                              <option value="2">Specified Due Date</option>
                              <option value="3">Installment Fees</option>
                              <option value="4">Overdue Installment Fees</option>
                              <option value="5">Disbursement - Paid with Repayment</option>
                              <option value="6">Loan Rescheduliing Fee</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Amount</label>
                          <input type="number" class="form-control" name="amount">
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
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" name="" type="checkbox" value="1">
                                Penalty
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                        </div>
                        <div class=" col-md-4 form-group">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" name="" type="checkbox" value="1">
                                Active
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                        </div>
                        <div class=" col-md-4 form-group">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" name="" type="checkbox" value="1">
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
          <div></div>
          <!-- /content -->
        </div>
      </div>

<?php

    include("footer.php");

?>