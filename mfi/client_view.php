<?php

$page_title = "View Client";
include('header.php');

?>

<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Account</h4>
                </div>
                <div class="card-body">
                  <form action="">
                    <div class="form-group">
                      <label for="">Name:</label>
                      <input type="text" name="" id="" class="form-control" value="Client's Name" readonly>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Account No:</label>
                          <input type="text" name="" id="" class="form-control" value="10393903" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Account Officer:</label>
                          <input type="text" name="" id="" class="form-control" value="Tunde Bashiro" readonly>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Account Summary</h4>
                </div>
                <div class="card-body">
                <form action="">
                    <div class="form-group">
                      <label for="">Current Balance:</label>
                      <input type="text" name="" id="" class="form-control" value="200000" readonly>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Last Deposit:</label>
                          <input type="text" name="" id="" class="form-control" value="0" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Last Withdrawal:</label>
                          <input type="text" name="" id="" class="form-control" value="2500" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Quaterly Fee Owed:</label>
                          <input type="text" name="" id="" class="form-control" value="2500" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Total Deposit:</label>
                          <input type="text" name="" id="" class="form-control" value="2500" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Total Withdrawal:</label>
                          <input type="text" name="" id="" class="form-control" value="2500" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Total Charges:</label>
                          <input type="text" name="" id="" class="form-control" value="2500" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Total Interest Posted:</label>
                          <input type="text" name="" id="" class="form-control" value="2500" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Total Interest Earned:</label>
                          <input type="text" name="" id="" class="form-control" value="2500" readonly>
                        </div>
                      </div>
                    </div>
                    <a href="lend.php" class="btn btn-primary">Disburse Loan</a>
                    <a href="#" class="btn btn-primary">Generate Account Report</a>
                    <a href="lend.php" class="btn btn-primary">Edit CLient</a>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card card-profile">
                <div class="card-avatar">
                  <a href="#pablo">
                    <img class="img" src="assets/img/faces/marc.jpg" />
                  </a>
                </div>
                <!-- Get session data and populate user profile -->
                <div class="card-body">
                  <h6 class="card-category text-gray">Account Name</h6>
                  <h4 class="card-title">Client Name</h4>
                  <p class="card-description">
                    Account Balance
                  </p>
                  <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

<?php

include('footer.php');

?>