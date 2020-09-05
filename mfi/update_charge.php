<?php

$page_title = "Update Charge";
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
                  <h4 class="card-title">Update Charge</h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                  <form action="" method="post">
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
                          <select name="" id="" class="form-control">
                              <option value="">Loan</option>
                              <option value="">Savings</option>
                              <option value="">Shares</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Charge Type</label>
                          <select name="" id="" class="form-control">
                              <option value="">Disbursement</option>
                              <option value="">Specified Due Date</option>
                              <option value="">Installment Fees</option>
                              <option value="">Overdue Installment Fees</option>
                              <option value="">Disbursement - Paid with Repayment</option>
                              <option value="">Loan Rescheduliing Fee</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Amount</label>
                          <input type="number" step=".01" class="form-control" name="location">
                        </div>
                      </div>
                      <div class=" col-md-4 form-group">
                          <label for="bmd-label-floating">Charge Option</label>
                          <select name="" id="" class="form-control">
                              <option value="">Flat</option>
                              <option value="">Principal Due</option>
                              <option value="">Principal + Interest Due on Installment</option>
                              <option value="">Interest Due on Installment</option>
                              <option value="">Total Oustanding Loan Principal</option>
                              <option value="">Original Loan Principal</option>
                          </select>
                      </div>
                      <div class=" col-md-4 form-group">
                          <label for="bmd-label-floating">Charge Payment Mode</label>
                          <select name="" id="" class="form-control">
                              <option value="">Regular</option>
                              <option value="">Account Transfer</option>
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
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" name="" type="checkbox" value="1">
                                Active
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
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
          <!-- /content -->
        </div>
      </div>

<?php

    include("footer.php");

?>