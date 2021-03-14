<?php
session_start();
include('../../functions/connect.php');

$sessint_id = $_SESSION['int_id'];

if(isset($_POST['branch_id'])) {
    $branch_id = $_POST['branch_id'];

    $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
    while ($row = mysqli_fetch_array($getParentID)) {
        $parent_id = $row['parent_id'];
    }

    if($parent_id == 0) {
        $result = mysqli_query($connection, "SELECT * FROM loan WHERE int_id = '$sessint_id'");
    } else {
        $result = mysqli_query($connection, "SELECT * FROM loan WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id)");
    }
?>
    <div class="card">
        <div class="card-header card-header-primary">
            <h4 class="card-title">Provisioning</h4>
            <!-- Insert number users institutions -->
            <p class="card-category">
                
            </p>
        </div>
        <div class="card-body">        
            <div class="table-responsive">
                <table id="provision" class="display" style="width:100%">
                    <thead>
                        <tr>
                        <th><small>Customer Name</small></th>
                        <th><small>Principal Due</small></th>
                        <th><small>Interest Due</small></th>
                        <th><small>1-30 days</small></th>
                        <th><small>31-60 days</small></th>
                        <th><small>61-90 days</small></th>
                        <th><small>91-180 days</small></th>
                        <th><small>180 & Above</small></th>
                        <th><small>Total NPL</small></th>
                        <th><small>Provision</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_array($result)) {
                            $cid = $row['client_id'];
                            $get_client_name = mysqli_query($connection, "SELECT display_name FROM client WHERE id = '$cid'");
                            $client = mysqli_fetch_array($get_client_name);
                            $client_name = $client['display_name'];

                            $get_loan_id = mysqli_query($connection, "SELECT id FROM loan WHERE client_id = '$cid'");
                            $loan = mysqli_fetch_array($get_loan_id);
                            $loan_id = $loan['id'];

                            // principal_amount holds the principal outstanding of a loan
                            $query_principal_due =  mysqli_query($connection, "SELECT SUM(principal_amount) AS principal_due FROM `loan_repayment_schedule` WHERE int_id = '$sessint_id' AND loan_id = '$loan_id'");
                            $principal_due = mysqli_fetch_array($query_principal_due);
                            $principal_due = $principal_due['principal_due'];

                            // interest_amount holds the interest outstanding of a loan
                            $query_interest_due =  mysqli_query($connection, "SELECT SUM(interest_amount) AS interest_due FROM `loan_repayment_schedule` WHERE int_id = '$sessint_id' AND loan_id = '$loan_id'");
                            $interest_due = mysqli_fetch_array($query_interest_due);
                            $interest_due = $interest_due['interest_due'];
                    

                            $query_principal_due2 =  mysqli_query($connection, "SELECT sum(principal_amount) as principal_due FROM `loan_arrear` WHERE int_id = '$sessint_id' AND loan_id = '$loan_id'");
                            $principal_due2 = mysqli_fetch_array($query_principal_due2);
                            $principal_due2 = $principal_due2['principal_due'];

                            $query_interest_due2 =  mysqli_query($connection, "SELECT SUM(interest_amount) AS interest_due FROM `loan_arrear` WHERE int_id = '$sessint_id' AND loan_id = '$loan_id'");
                            $interest_due2 = mysqli_fetch_array($query_interest_due2);
                            $interest_due2 = $interest_due2['interest_due'];

                            $repayment_due = $principal_due2 + $interest_due2;

                            $counter_query = mysqli_query($connection, "SELECT counter FROM loan_arrear WHERE loan_id = '$loan_id'");
                            $counter = mysqli_fetch_array($counter_query);
                            $counter = $counter['counter'];
                        ?>
                        <tr>
                            <td>
                                <?php
                                echo $client_name;
                                ?>
                            </td>
                            <td>
                                <?php
                                echo "₦ ".number_format(round($principal_due), 2);
                                ?>
                            </td>
                            <td>
                                <?php
                                echo "₦ ".number_format(round($interest_due), 2);
                                ?>
                            </td>
                            <td>
                                <?php
                                if($counter <= 30) {
                                    echo "₦ ".number_format(round($repayment_due), 2);
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if($counter > 30 && $counter <= 60) {
                                    echo "₦ ".number_format(round($repayment_due), 2);
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if($counter > 60 && $counter <= 90) {
                                    echo "₦ ".number_format(round($repayment_due), 2);
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if($counter > 91 && $counter <= 180) {
                                    echo "₦ ".number_format(round($repayment_due), 2);
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if($counter > 180) {
                                    echo "₦ ".number_format(round($repayment_due), 2);
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $totalNPL = round($principal_due2) + $interest_due2;
                                echo "₦ ".number_format($totalNPL, 2);
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($counter <= 30) {
                                    $provision = $repayment_due * 0.02;
                                    echo "₦ ".number_format($provision, 2);
                                    
                                } else if ($counter > 30 && $counter <= 60) {
                                    $provision = $repayment_due * 0.05;
                                    echo "₦ ".number_format($provision, 2);

                                } else if ($counter > 60 && $counter <= 90) {
                                    $provision = $repayment_due * 0.2;
                                    echo "₦ ".number_format($provision, 2);

                                } else if ($counter > 91 && $counter <= 180) {
                                    $provision = $repayment_due  * 0.5;
                                    echo "₦ ".number_format($provision, 2);

                                } else {
                                    $provision = $repayment_due;
                                    echo "₦ ".number_format($provision, 2);
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <div class="form-group mt-4">
                    <form method="POST" action="../composer/provision.php">
                        <button type="submit" id="currentlist" class="btn btn-primary pull-left">Download PDF</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>

<script>
    $(document).ready(function() {
        $('#provision').DataTable();
    });
</script>