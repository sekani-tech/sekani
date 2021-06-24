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
    while ($row = mysqli_fetch_array($dof)) {
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
if ($view_dashboard == 1) {
    // echo 'can view dashboard';

    ?>

    <div class="content">
        <div class="container-fluid">

            <!-- your content here -->
            <div class="row">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h2 class="card-title text-center">Dashboard</h2>
                        <p class="card-category text-center"></p>
                    </div>
                </div>

                <!-- loan balance -->
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="card card-stats">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">account_balance_wallet</i>
                            </div>
                            <p class="card-category"><b>Outstanding Loan Balance</b></p>
                            <!-- Populate with the total value of outstanding loans -->

                            <?php
                            $accountquery = "SELECT SUM(total_outstanding_derived) AS total_outstanding_derived FROM `loan` WHERE int_id = '$sessint_id'";
                            $result = mysqli_query($connection, $accountquery);
                            $totalOutstandingLoans = mysqli_fetch_array($result)['total_outstanding_derived'];
                            ?>
                            <h2 class="card-title">₦<?php echo number_format(round($totalOutstandingLoans), 2); ?></h2>

                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <!-- Get current update time and display -->
                                <!-- new noe -->
                                <i class="material-icons text-primary">alarm</i> Currently
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Portfolio at risk -->
                <?php
                $allpar = mysqli_query($connection, "SELECT * FROM loan_arrear WHERE int_id = '$sessint_id' AND installment >= '1' GROUP BY loan_id ORDER BY loan_id");

                $valueofpar31to60 = 0;
                $par31to60_percentage = 0;
                $valueofpar61to90 = 0;
                $par61to90_percentage = 0;

                while($eachpar = mysqli_fetch_array($allpar)) {
                    if($eachpar['counter'] >= '31' && $eachpar['counter'] <= '60') {
                        /*  31 to 60 days in arrears */
                        $loan_id = $eachpar['loan_id'];
                        $getpar31to60 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount, SUM(interest_amount) AS interest_amount FROM loan_repayment_schedule WHERE int_id = '$sessint_id' AND loan_id = '$loan_id' AND installment >= '1'");
                        $par31to60 = mysqli_fetch_array($getpar31to60);
                        $principal = $par31to60['principal_amount'];
                        $interest = $par31to60['interest_amount'];
                        $valueofpar31to60 += $principal + $interest;
                        $par31to60_percentage = ($valueofpar31to60/$totalOutstandingLoans) * 100;
            
                    } else if ($eachpar['counter'] >= '61' && $eachpar['counter'] <= '90') {
                        /* 61 to 90 days in arrears */
                        $loan_id = $eachpar['loan_id'];
                        $getpar61to90 = mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_amount, SUM(interest_amount) AS interest_amount FROM loan_repayment_schedule WHERE int_id = '$sessint_id' AND loan_id = '$loan_id' AND installment >= '1'");
                        $par61to90 = mysqli_fetch_array($getpar61to90);
                        $principal = $par61to90['principal_amount'];
                        $interest = $par61to90['interest_amount'];
                        $valueofpar61to90 += $principal + $interest;
                        $par61to90_percentage = ($valueofpar61to90/$totalOutstandingLoans) * 100;
                    }
                }
                
                ?>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">info_outline</i>
                            </div>
                            <p class="card-category"><b>PAR</b></p>
                            <h4 class="card-title">60 days - <?php echo number_format($par31to60_percentage, 2); ?>%</h4>
                            <h4 class="card-title">90 days - <?php echo number_format($par61to90_percentage, 2); ?>%</h4>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons text-primary">alarm</i> Last 24 Hours
                                <!-- <i class="material-icons">warning</i> Just Updated -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /par -->
            </div>


            <div class="row">
                <!-- Card displays clients -->
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">people</i>
                            </div>
                            <p class="card-category"><b>Clients</b></p>
                            <!-- Populate with number of existing clients -->
                            <h2 class="card-title"><?php
                                $query = "SELECT COUNT(firstname) FROM client WHERE int_id = '$sessint_id' AND status = 'Approved'";
                                $result = mysqli_query($connection, $query);
                                if ($result) {
                                    $inr = mysqli_fetch_array($result);
                                    echo $inr['COUNT(firstname)'];
                                } ?></h2>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons text-primary">alarm</i> Last 24 Hours
                                <!-- Get current update time and display -->
                                <!-- <i class="material-icons">update</i> Just Updated -->
                            </div>
                        </div>
                    </div>
                </div>


                <!-- /clients -->

                <!-- logged in users -->
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">person</i>
                            </div>
                            <p class="card-category"><b>Logged in Staff</b></p>
                            <!-- Populate with number of logged in staff -->
                            <script>
                                setInterval(function () {
                                    // alert('I will appear every 4 seconds');
                                    // we are done now
                                    var int_id = $('#int_idioioioio').val();
                                    // which kind vex be this abeg :-}
                                    var user = $('#usernameoioio').val();
                                    $.ajax({
                                        url: "ajax_post/logout/log_staff.php",
                                        method: "POST",
                                        data: {int_id: int_id, user: user},
                                        success: function (data) {
                                            $('#logged_staff').html(data);
                                        }
                                    });
                                }, 1000);   // Interval set to 4 seconds
                            </script>
                            <h2 class="card-title">
                                <div id="logged_staff">0</div>
                            </h2>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons text-primary">alarm</i> Last 5 Minutes
                                <!-- Get current update time and display -->
                                <!-- <i class="material-icons">update</i> Just Updated -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /users -->

                <!-- /lb -->
            </div>
            <!-- /row -->
            <div class="row">
                <!-- populate with frequency of loan disbursement -->
                <div class="col-md-6">
                    <div class="card card-chart">
                        <div class="card-header card-header">
                            <canvas id="myChart" width="600" height="400"></canvas>
                            <?php
                            // finish
                            $current_date = date('Y-m-d');
                            $qtr_date = date('Y-m-d', strtotime("-1 months", strtotime($current_date)));
                            // repayment
                            $get_qtr = mysqli_query($connection, "SELECT * FROM loan_repayment_schedule WHERE int_id = '$sessint_id' AND ((duedate >= '$qtr_date') AND (duedate <= '$current_date')) AND installment = '0' ORDER BY id DESC LIMIT 20");
                            while ($row = mysqli_fetch_array($get_qtr)) {
                                $total_amount = $row["principal_amount"] + $row["interest_amount"];
                                $getall = array($total_amount);
                            }
                            $remodel = str_replace("" . '"' . "", "", json_encode($getall));
                            $final_l = str_replace("[", "", $remodel);
                            $final_r = str_replace("]", "", $final_l);
                            ?>
                            <script>
                                var ctx = document.getElementById('myChart').getContext('2d');
                                var myChart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: [
                                            '1st', '2nd', '3rd',
                                            '4th', '5th', '6th',
                                            '7th', '8th', '9th',
                                            '10th', '11th', '12th',
                                            '13th', '14th', '15th',
                                            '16th', '17th', '18th',
                                            '19th', '20th'],
                                        datasets: [{
                                            label: 'Loan Collection',
                                            data: [<?php echo $final_r ?>],
                                            backgroundColor: [
                                                'black', 'black', 'black', 'black',
                                                'black', 'black', 'black', 'black',
                                                'black', 'black', 'black', 'black',
                                                'black', 'black', 'black', 'black',
                                                'black', 'black', 'black', 'black',
                                                'black', 'black', 'black', 'black',
                                                'black', 'black', 'black'
                                            ],
                                            borderColor: [
                                                'black', 'black', 'black', 'black',
                                                'black', 'black', 'black', 'black',
                                                'black', 'black', 'black', 'black',
                                                'black', 'black', 'black', 'black',
                                                'black', 'black', 'black', 'black',
                                                'black', 'black', 'black', 'black',
                                                'black', 'black', 'black'
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
                                <span class="text-success"><i class="fa fa-long-arrow-up"></i> </span> increase in
                                loan collections</p>
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