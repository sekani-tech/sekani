<?php
include("header.php");
?>
<!-- ok here i am -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <!-- Card displays clients -->
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="fa fa-users"></i>
                  </div>
                  <p class="card-category">Clients</p>
                  <!-- Populate with number of existing clients -->
                  <h3 class="card-title">BILL</h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <!-- Get current update time and display -->
                    <!-- <i class="material-icons">update</i> Just Updated -->
                  </div>
                </div>
              </div>
            </div>
            <!-- /clients -->
            <!-- Portfolio at risk -->
            <!-- not in use yet -->
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">info_outline</i>
                  </div>
                  <p class="card-category">BLA</p>
                  <h3 class="card-title">NA</h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <!-- <i class="material-icons">warning</i> Just Updated -->
                  </div>
                </div>
              </div>
            </div>
            <!-- /par -->
            <!-- logged in users -->
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="fa fa-users"></i>
                  </div>
                  <p class="card-category">Logged in Staff</p>
                  <!-- Populate with number of logged in staff -->
                  <h3 class="card-title">
                    <div id="logged_staff">BLA</div>
                   </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <!-- Get current update time and display -->
                    <!-- <i class="material-icons">update</i> Just Updated -->
                  </div>
                </div>
              </div>
            </div>
            <!-- /users -->
            <!-- loan balance -->
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">account_balance_wallet</i>
                  </div>
                  <p class="card-category">Outstanding Loan Balance</p>
                  <!-- Populate with the total value of outstanding loans -->
                  <h3 class="card-title">M </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <!-- Get current update time and display -->
                    <!-- new noe -->
                  </div>
                </div>
              </div>
            </div>
            <!-- /lb -->
          </div>
          <!-- /row -->
          <!-- /row -->
        </div>
      </div>
<!-- done with it -->
<?php
include("footer.php");
?>