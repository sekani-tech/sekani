<?php

$page_title = "FTD Schedule";
$destination = "";
include("header.php");

$sessint_id = $_SESSION['int_id'];
$sessbranch_id = $_SESSION['branch_id'];
$ftd_booking_id = $_GET['id'];

$q = "SELECT c.id as client_id, c.display_name, f.ftd_no, f.linked_savings_account, f.booked_date, f.term, f.int_rate, f.status, f.is_paid 
    FROM ftd_booking_account f 
    JOIN client c ON f.client_id = c.id 
    WHERE f.int_id = '$sessint_id' AND f.id = '$ftd_booking_id'";

$ftd_acc_query = mysqli_query($connection, $q);
$ftd_acc = mysqli_fetch_array($ftd_acc_query);
$client_name = $ftd_acc['display_name'];
$ftd_no = $ftd_acc['ftd_no'];
$linked_savings_acc = $ftd_acc['linked_savings_account'];
$booked_date = $ftd_acc['booked_date'];
$tenure = $ftd_acc['term'];
$maturity_date = date('d-m-Y', strtotime('+'. $tenure .' Days', strtotime($booked_date)));
$status = $ftd_acc['status'];
$is_paid = $ftd_acc['is_paid'];

$interest_query = mysqli_query($connection, "SELECT SUM(interest_amount) as interest_amount FROM `ftd_interest_schedule` WHERE int_id = {$sessint_id} AND client_id = {$ftd_acc['client_id']}");
$interest = mysqli_fetch_array($interest_query)['interest_amount'];

?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <ul class="nav nav-tabs" data-tabs="tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#home" data-toggle="tab"><i class="material-icons">analytics</i>SUMMARY</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#updates" data-toggle="tab"><i class="material-icons">table_view</i>REPAYMENT SCHEDULE</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="tab-content text-center">
                            <div class="tab-pane active" id="home">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card text-left" style="width: 20rem;">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item"><b>Client Name: </b><?php echo $client_name; ?></li>
                                                <li class="list-group-item"><b>FTD No: </b><?php echo $ftd_no; ?></li>
                                                <li class="list-group-item"><b>Linked Account: </b><?php echo $linked_savings_acc; ?></li>
                                                <li class="list-group-item"><b>Interest Repayment: </b><?php echo '₦ '. number_format($interest, 2); ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card text-left" style="width: 20rem;">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item"><b>Booking Date: </b><?php echo date('d-m-Y', strtotime($booked_date)); ?></li>
                                                <li class="list-group-item"><b>Maturity Date: </b><?php echo $maturity_date; ?></li>
                                                <li class="list-group-item"><b>Tenure: </b><?php echo $tenure; ?> Days</li>
                                                <?php 
                                                if($status == "Approved" && $is_paid == "0")
                                                    $displayedStatus = "Active";
                                                else if($status == "Approved" && $is_paid == "1")
                                                    $displayedStatus = "Closed";
                                                else
                                                    $displayedStatus = "Terminated";
                                                ?>
                                                <li class="list-group-item"><b>Status: </b><?php echo $displayedStatus; ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                        $is_paid_query = mysqli_query($connection, "SELECT is_paid FROM `ftd_booking_account` WHERE int_id = {$sessint_id} AND id = {$ftd_booking_id}");
                                        $is_paid = mysqli_fetch_array($is_paid_query)['is_paid'];

                                        if($is_paid == 0) {
                                        ?>

                                        <form action="../functions/ftd/ftd_terminate.php" method="POST">
                                            <input type="hidden" name="ftd_id" value="<?php echo $ftd_booking_id; ?>" >
                                            <button type="submit" class="btn btn-danger" style="margin-top: 100px;" onclick="return confirm('Are you sure you want to terminate this FTD?');">Terminate FTD</button>
                                        </form>

                                        <?php
                                        }

                                        if($is_paid == 1) {
                                        ?>

                                        <div class="card border border-success shadow-0 mb-4" style="width: 20rem">
                                            <div class="card-body">
                                                <h5 class="card-title text-success">Completed</h5>
                                            </div>
                                        </div>

                                        <?php
                                        }

                                        if($is_paid == 2) {
                                        ?>
                                        
                                        <div class="card border border-danger shadow-0 mb-4" style="width: 20rem">
                                            <div class="card-body">
                                                <h5 class="card-title text-danger">Terminated</h5>
                                            </div>
                                        </div>

                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Contract</th>
                                                <th>Paid</th>
                                                <th>Outstanding</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $principal_query = mysqli_query($connection, "SELECT account_balance_derived FROM `ftd_booking_account` WHERE int_id = {$sessint_id} AND client_id = {$ftd_acc['client_id']} AND id = {$ftd_booking_id}");
                                            $principal = mysqli_fetch_array($principal_query)['account_balance_derived'];

                                            $paid_principal_query = mysqli_query($connection, "SELECT is_paid FROM `ftd_booking_account` WHERE int_id = {$sessint_id} AND client_id = {$ftd_acc['client_id']} AND id = {$ftd_booking_id}");
                                            $paid_principal = mysqli_fetch_array($paid_principal_query)['is_paid'];
                                            if($paid_principal == 1) {
                                                $paid_principal = $principal;
                                            } else {
                                                $paid_principal = 0;
                                            }

                                            $outstanding_principal = $principal - $paid_principal;

                                            $paid_interest_query = mysqli_query($connection, "SELECT SUM(interest_amount) as interest_amount FROM `ftd_interest_schedule` WHERE int_id = {$sessint_id} AND client_id = {$ftd_acc['client_id']}  AND ftd_id = {$ftd_booking_id} AND interest_repayment = '1'");
                                            $paid_interest = mysqli_fetch_array($paid_interest_query)['interest_amount'];

                                            $outstanding_interest = $interest - $paid_interest;

                                            ?>
                                            <tr>
                                                <th>Principal</th>
                                                <th><?php echo '₦ '. number_format($principal, 2); ?></th>
                                                <th><?php echo '₦ '. number_format($paid_principal, 2); ?></th>
                                                <th><?php echo '₦ '. number_format($outstanding_principal, 2); ?></th>
                                            </tr>
                                            <tr>
                                                <th>Interest</th>
                                                <th><?php echo '₦ '. number_format($interest, 2); ?></th>
                                                <th><?php echo '₦ '. number_format($paid_interest, 2); ?></th>
                                                <th><?php echo '₦ '. number_format($outstanding_interest, 2); ?></th>
                                            </tr>
                                            <tr>
                                                <th>Fees</th>
                                                <th>₦ 0.00</th>
                                                <th>₦ 0.00</th>
                                                <th>₦ 0.00</th>
                                            </tr> 
                                            <tr> 
                                                <th>Penalties</th>
                                                <th>₦ 0.00</th>
                                                <th>₦ 0.00</th>
                                                <th>₦ 0.00</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="updates">
                                <div class="card">
                                    <!-- end -->
                                    <div class="card card-profile ml-auto mr-auto" style="max-width: 360px; max-height: 360px">
                                        <div class="card-body ">
                                            <h4 class="card-title"><?php echo $client_name; ?></h4>
                                            <h6 class="card-category">FTD Number: <?php echo $ftd_no; ?></h6>
                                        </div>
                                        <div class="card-footer justify-content-center">
                                        </div>
                                    </div>
                                    <!-- end new card profile -->
                                    <div class="card-body">
                                        <table class="table table-bordered" style="width:100%">
                                            <thead class="text-primary">
                                                <tr>
                                                    <th>Term</th>
                                                    <th>Principal</th>
                                                    <th>Interest</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                $interest_schedule = mysqli_query($connection, "SELECT installment, interest_amount FROM `ftd_interest_schedule` WHERE int_id = {$sessint_id} AND client_id = {$ftd_acc['client_id']} AND ftd_id = {$ftd_booking_id}");
                                                $num_of_rows = mysqli_num_rows($interest_schedule);
                                                while($row = mysqli_fetch_array($interest_schedule)) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <?php
                                                        $principal = ($i == $num_of_rows) ? $row['installment'] : 0;
                                                    ?>
                                                    <td>₦ <?php echo number_format($principal, 2); ?></td>
                                                    <td>₦ <?php echo number_format($row['interest_amount'], 2); ?></td>
                                                    <td>₦ <?php echo number_format($principal + $row['interest_amount'], 2); ?></td>
                                                </tr>
                                                <?php
                                                $i++;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("footer.php");
?>