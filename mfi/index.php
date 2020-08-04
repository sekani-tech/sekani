<?php
    $page_title = "Dashboard";
    include("header.php");
    $br_id = $_SESSION['branch_id'];
?>
<?php
  function branch_opt($connection)
  {  
      $br_id = $_SESSION["branch_id"];
      $sint_id = $_SESSION["int_id"];
      $dff = "SELECT * FROM branch WHERE int_id ='$sint_id' AND id = '$br_id' || parent_id = '$br_id'";
      $dof = mysqli_query($connection, $dff);
      $out = '';
      while ($row = mysqli_fetch_array($dof))
      {
        $do = $row['id'];
      $out .= " OR client.branch_id ='$do'";
      }
      return $out;
  }
  $branches = branch_opt($connection);
?>
<!-- making a new push -->
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
                        $query = "SELECT client.id, client.BVN, client.date_of_birth, client.gender, client.account_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && (client.branch_id ='$br_id'$branches) && client.status = 'Approved'";
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
            <?php
                $query = "SELECT * FROM loan_arrear WHERE int_id = '$sessint_id' AND installment = '1'";
                $result = mysqli_query($connection, $query);
                $resu = mysqli_num_rows($result);

                $dewe = "SELECT SUM(par) AS par FROM loan_arrear WHERE int_id = '$sessint_id' AND installment = '1'";
                $sdd = mysqli_query($connection, $dewe);
                $sdt = mysqli_fetch_array($sdd);
                $pfar = $sdt['par'];
               
                $do = ($resu/$pfar) * 100;
            ?>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">info_outline</i>
                  </div>
                  <p class="card-category">Portfolio at Risk</p>
                  <?php if ($do > 0){
                    ?>
                  <h3 class="card-title"><?php echo number_format($do);?>%</h3>
                   <?php 
                  }
                  else{
                    ?>
                    <h3 class="card-title">0%</h3>
                    <?php
                  }
                  ?>
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
                  <script>
setInterval(function() {
    // alert('I will appear every 4 seconds');
    // we are done now
    var int_id = $('#int_idioioioio').val();
    // which kind vex be this abeg :-}
    var user = $('#usernameoioio').val();
    $.ajax({
      url:"ajax_post/logout/log_staff.php",
      method:"POST",
      data:{int_id:int_id, user: user},
      success:function(data){
        $('#logged_staff').html(data);
      }
    });
}, 1000);   // Interval set to 4 seconds
</script>
                  <h3 class="card-title">
                    <div id="logged_staff">0</div>
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
                  <p class="card-category">Outstanding Loa Balance</p>
                  <!-- Populate with the total value of outstanding loans -->
                  <?php
                  $re = "SELECT SUM(total_outstanding_derived) AS total_outstanding_derived FROM loan JOIN client ON loan.client_id = client.id WHERE loan.int_id = '$sessint_id'";
                  $resultxx = mysqli_query($connection, $re);
                  if (count([$resultxx]) == 1) {
                  $jk = mysqli_fetch_array($resultxx);
                  $sum = $jk['total_outstanding_derived'];
                  ?>
                  
                  <?php
                    $dd = "SELECT SUM(interest_amount) AS interest_amount FROM loan_repayment_schedule WHERE installment >= '1' AND int_id = '$sessint_id'";
                    $sdoi = mysqli_query($connection, $dd);
                    $e = mysqli_fetch_array($sdoi);
                    $interest = $e['interest_amount'];

                    $dfdf = "SELECT SUM(principal_amount) AS principal_amount FROM loan_repayment_schedule WHERE installment >= '1' AND int_id = '$sessint_id'";
                    $sdswe = mysqli_query($connection, $dfdf);
                    $u = mysqli_fetch_array($sdswe);
                    $prin = $u['principal_amount'];

                    $outstanding = $prin + $interest;
                  ?>
                  <h3 class="card-title">NGN - <?php echo number_format(round($outstanding), 2); ?></h3>
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
                  <div class="ct-chart" id=""></div>
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