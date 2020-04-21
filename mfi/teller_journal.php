<?php

$page_title = "Teller Disbursement";
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
                  <h4 class="card-title">Internal Acct Posting</h4>
                  <!-- <p class="card-category">Fill in all important data</p> -->
                </div>
                <div class="card-body">
                  <form action="" method="post">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                            <!-- populate from db -->
                          <label class="bmd-label-floating"> Teller Name</label>
                          <input type="text" class="form-control" name="name">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Amount</label>
                          <input type="number" name="" id="" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Current Balance</label>
                          <!-- populate available balance -->
                          <input type="text" name="" id="" class="form-control" readonly>
                        </div>
                      </div>
                      </div>
                      <button type="reset" class="btn btn-danger pull-left">Reset</button>
                    <button type="submit" class="btn btn-primary pull-right">Disburse</button>
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