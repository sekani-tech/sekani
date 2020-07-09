<?php
    $page_title = "Dashboard";
    include("header.php");
?>
<!-- Content added here -->
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
                  <h3 class="card-title"><?php
                   $query = "SELECT * FROM client WHERE int_id = '$sessint_id' AND status ='Approved'";
                   $result = mysqli_query($connection, $query);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     echo $inr;
                   }?></h3>
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
                  <p class="card-category">Portfolio at Risk</p>
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
                  <h3 class="card-title"><?php
                   $query = "SELECT * FROM users WHERE int_id = '$sessint_id' && status = 'Active'";
                   $result = mysqli_query($connection, $query);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     echo $inr;
                   }?></h3>
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
                  <?php
                  $re = "SELECT SUM(total_outstanding_derived) AS total_outstanding_derived FROM loan JOIN client ON loan.client_id = client.id WHERE loan.int_id = '$sessint_id'";
                  $resultxx = mysqli_query($connection, $re);
                  if (count([$resultxx]) == 1) {
                  $jk = mysqli_fetch_array($resultxx); 
                  $sum = $jk['total_outstanding_derived'];
                  ?>
                  <h3 class="card-title">NGN - <?php echo number_format(round($sum), 2); ?></h3>
                  <?php
                  }
                  ?>
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
          <div class="row">
            <!-- populate with frequency of loan disbursement -->
            <div class="col-md-4">
              <div class="card card-chart">
                <div class="card-header card-header-success">
                  <div class="ct-chart" id="dailySalesChart"></div>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Daily Loan Collection</h4>
                  <p class="card-category">
                    <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in loan collections</p>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <!-- <i class="material-icons">access_time</i> updated 4 minutes ago -->
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /row -->
        </div>
      </div>

<?php

    include("footer.php");

?>