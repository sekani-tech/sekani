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
                            <h2 class="card-title">₦<?php echo number_format(round($fde), 2); ?></h2>

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
                if (!$sdd) {
                    printf("Error: %s\n", mysqli_error($connection));//checking for errors
                    exit();
                }else{
                    $sdt = mysqli_fetch_array($sdd);
                    $bnk_provsix = $sdt['bank_provision'];
                }
                

                // 60 days in arrears
                $dewe = "SELECT SUM(bank_provision) AS bank_provision FROM loan_arrear WHERE int_id = '$sessint_id' AND installment = '1' AND counter < '60' AND counter > 30";
                $sdd = mysqli_query($connection, $dewe);
                $sdt = mysqli_fetch_array($sdd);
                $bnk_provthree = $sdt['bank_provision'];

                $pfarthree = ($bnk_provthree / $ttout) * 100;
                $pfarsix = ($bnk_provsix / $ttout) * 100;
                ?>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">info_outline</i>
                            </div>
                            <p class="card-category"><b>PAR</b></p>
                            <?php if ($bnk_provthree > 0 || $bnk_provsix > 0) {
                                ?>
                                <h4 class="card-title">30 days - <?php echo number_format($pfarthree, 2); ?>%</h4>
                                <h4 class="card-title">60 days - <?php echo number_format($pfarsix, 2); ?>%</h4>
                                <?php
                            } else {
                                ?>
                                <h4 class="card-title">30 days - 0%</h4>
                                <h4 class="card-title">60 days - 0%</h4>
                                <?php
                            }
                            ?>
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
                                $getall[] = array($total_amount);
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
                                <span class="text-success"><i class="fa fa-long-arrow-up"></i> 54% </span> increase in
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