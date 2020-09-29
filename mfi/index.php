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
<?php
  if($view_dashboard == 1 || $view_dashboard == "1"){
    echo 'can view dashboard';
?>

    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <!-- Card displays clients -->
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">people</i>
                  </div>
                  <p class="card-category">Client</p>
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
                $dd = "SELECT SUM(interest_amount) AS interest_amount FROM loan_repayment_schedule WHERE installment >= '1' AND int_id = '$sessint_id'";
                $sdoi = mysqli_query($connection, $dd);
                $e = mysqli_fetch_array($sdoi);
                $interest = $e['interest_amount'];

                $dfdf = "SELECT SUM(principal_amount) AS principal_amount FROM loan_repayment_schedule WHERE installment >= '1' AND int_id = '$sessint_id'";
                $sdswe = mysqli_query($connection, $dfdf);
                $u = mysqli_fetch_array($sdswe);
                $prin = $u['principal_amount'];

                $outstanding = $prin + $interest;

                // Arrears
                $ldfkl = "SELECT SUM(interest_amount) AS interest_amount FROM loan_arrear WHERE installment >= '1' AND int_id = '$sessint_id'";
                $fosdi = mysqli_query($connection, $ldfkl);
                $l = mysqli_fetch_array($fosdi);
                $interesttwo = $l['interest_amount'];

                $sdospd = "SELECT SUM(principal_amount) AS principal_amount FROM loan_arrear WHERE installment >= '1' AND int_id = '$sessint_id'";
                $sodi = mysqli_query($connection, $sdospd);
                $s = mysqli_fetch_array($sodi);
                $printwo = $s['principal_amount'];

                $outstandingtwo = $printwo + $interesttwo;
                $ttout = $outstanding + $outstandingtwo;

                  //  30 days in arrears
                $dewe = "SELECT SUM(bank_provision) AS bank_provision FROM loan_arrear WHERE int_id = '$sessint_id' AND installment = '1' AND counter < '30'";
                $sdd = mysqli_query($connection, $dewe);
                $sdt = mysqli_fetch_array($sdd);
                $bnk_provsix = $sdt['bank_provision'];

                // 60 days in arrears
                $dewe = "SELECT SUM(bank_provision) AS bank_provision FROM loan_arrear WHERE int_id = '$sessint_id' AND installment = '1' AND counter < '60' AND counter > 30";
                $sdd = mysqli_query($connection, $dewe);
                $sdt = mysqli_fetch_array($sdd);
                $bnk_provthree = $sdt['bank_provision'];

                $pfarthree = ($bnk_provthree/$ttout) * 100;
                $pfarsix = ($bnk_provsix/$ttout) * 100;
            ?>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">info_outline</i>
                  </div>
                  <p class="card-category">PAR</p>
                  <?php if ($bnk_provthree > 0 || $bnk_provsix > 0){
                    ?>
                  <h4 class="card-title">30 days - <?php echo number_format($pfarthree, 2);?>%</h4>
                  <h4 class="card-title">60 days - <?php echo number_format($pfarsix, 2);?>%</h4>
                   <?php 
                  }
                  else{
                    ?>
                    <h4 class="card-title">30 days - 0%</h4>
                    <h4 class="card-title">60 days - 0%</h4>
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
                    <i class="material-icons">person</i>
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
                  <p class="card-category">Outstanding Loan Balance</p>
                  <!-- Populate with the total value of outstanding loans -->
                  <?php
                  // if($sessint_id != 13){
                  //   $dd = "SELECT SUM(interest_amount) AS interest_amount FROM loan_repayment_schedule WHERE installment >= '1' AND int_id = '$sessint_id'";
                  //   $sdoi = mysqli_query($connection, $dd);
                  //   $e = mysqli_fetch_array($sdoi);
                  //   $interest = $e['interest_amount'];

                  //   $dfdf = "SELECT SUM(principal_amount) AS principal_amount FROM loan_repayment_schedule WHERE installment >= '1' AND int_id = '$sessint_id'";
                  //   $sdswe = mysqli_query($connection, $dfdf);
                  //   $u = mysqli_fetch_array($sdswe);
                  //   $prin = $u['principal_amount'];

                  //   $outstanding = $prin + $interest;

                  //   // Arrears
                  //   $ldfkl = "SELECT SUM(interest_amount) AS interest_amount FROM loan_arrear WHERE installment >= '1' AND int_id = '$sessint_id'";
                  //   $fosdi = mysqli_query($connection, $ldfkl);
                  //   $l = mysqli_fetch_array($fosdi);
                  //   $interesttwo = $l['interest_amount'];

                  //   $sdospd = "SELECT SUM(principal_amount) AS principal_amount FROM loan_arrear WHERE installment >= '1' AND int_id = '$sessint_id'";
                  //   $sodi = mysqli_query($connection, $sdospd);
                  //   $s = mysqli_fetch_array($sodi);
                  //   $printwo = $s['principal_amount'];

                  //   $outstandingtwo = $printwo + $interesttwo;
                  //   $ttout = $outstanding + $outstandingtwo;
                  //   }
                  //   else if($sessint_id == 13 || $sessint_id == 12){
                      
                  //   }
                    $prin_query = "SELECT SUM(principal_amount) AS total_out_prin FROM loan_repayment_schedule WHERE int_id = '$sessint_id' AND installment >= 1";
                    $int_query = "SELECT SUM(interest_amount) AS total_int_prin FROM loan_repayment_schedule WHERE int_id = '$sessint_id' AND installment >= 1";
                    // LOAN ARREARS
                    $arr_query1 = mysqli_query($connection, "SELECT SUM(principal_amount) AS arr_out_prin FROM loan_arrear WHERE int_id = '$sessint_id' AND installment >= 1");
                    $arr_query2 = mysqli_query($connection, "SELECT SUM(interest_amount) AS arr_out_int FROM loan_arrear WHERE int_id = '$sessint_id' AND installment >= 1");
                    // check the arrears
                    $ar = mysqli_fetch_array($arr_query1);
                    $arx = mysqli_fetch_array($arr_query2);
                    $arr_p = $ar["arr_out_prin"];
                    $arr_i = $arx["arr_out_int"];
                      $pq = mysqli_query($connection, $prin_query);
                      $iq = mysqli_query($connection, $int_query);
                      $pqx = mysqli_fetch_array($pq);
                      $iqx = mysqli_fetch_array($iq);
                      // check feedback
                      $print = $pqx['total_out_prin'];
                      $intet = $iqx['total_int_prin'];
                      $fde = ($print + $intet) + ($arr_p + $arr_i);
                      // DGMFB
                  ?>
                  <h3 class="card-title">NGN - <?php echo number_format(round($fde), 2); ?></h3>
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
                <canvas id="myChart" width="600" height="400"></canvas>
                <?php
                // finish
                $current_date = date('Y-m-d');
                $qtr_date = date('Y-m-d', strtotime("-1 months", strtotime($current_date)));
                // repayment
                $get_qtr = mysqli_query($connection, "SELECT * FROM loan_repayment_schedule WHERE int_id = '$sessint_id' AND ((duedate >= '$qtr_date') AND (duedate <= '$current_date')) AND installment = '0' ORDER BY id DESC LIMIT 6");
                while($row = mysqli_fetch_array($get_qtr))
                  {
                    $total_amount = $row["principal_amount"] + $row["interest_amount"];
                    $getall[] = array($total_amount);
                  }
                  $remodel = str_replace("".'"'."","", json_encode($getall)); 
                  $final_l = str_replace("[","", $remodel); 
                  $final_r = str_replace("]","", $final_l); 
                ?>
                <script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['1st', '2nd', '3rd', '4th', '5th', '6th'],
        datasets: [{
            label: 'Loan Collection',
            data: [<?php echo $final_r ?>],
            backgroundColor: [
                'rgba(255, 255, 251, 0.2)',
                'rgba(255, 255, 251, 0.2)',
                'rgba(255, 255, 251, 0.2)',
                'rgba(255, 255, 251, 0.2)',
                'rgba(255, 255, 251, 0.2)',
                'rgba(255, 255, 251, 0.2)',
                'rgba(255, 255, 251, 0.2)'
            ],
            borderColor: [
                'rgba(255, 255, 255, 1)',
                'rgba(255, 255, 255, 1)',
                'rgba(255, 255, 255, 1)',
                'rgba(255, 255, 255, 1)',
                'rgba(255, 255, 255, 1)'
            ],
            borderWidth: 1
        }]
    }
});
</script>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Monthly Loan Collection</h4>
                  <p class="card-category">
                    <span class="text-success"><i class="fa fa-long-arrow-up"></i> 54% </span> increase in loan collections</p>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <!-- <i class="material-icons">access_time</i> updated 4 minutes ago -->
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div>
            <?php
            // $dob = '1976-09-11';
            // $check_DOB = date('d-M-y', strtotime($dob));
            // echo $check_DOB;
            ?>
            <!-- <img src="data:image/png;base64,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" alt="" srcset="" height="400px" width="400px"> -->
          </div>
          <!-- /row -->
        </div>
      </div>

<?php

    include("footer.php");

?>
<?php
  }
?>