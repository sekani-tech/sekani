<?php
session_start();
include('../../functions/connect.php');

$sessint_id = $_SESSION['int_id'];

if(!empty($_POST['branch_id']) && !empty($_POST['date'])) {
    $branch_id = $_POST['branch_id'];
    $date = $_POST['date'];
    $thirtydaysbefore = date("Y-m-d", strtotime("-30 Days", strtotime($date)));

    $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
    while ($row = mysqli_fetch_array($getParentID)) {
        $parent_id = $row['parent_id'];
    }

    // Disbursed Loans
    if($parent_id == 0) {
        $result = mysqli_query($connection, "SELECT * FROM loan WHERE int_id = '$sessint_id' AND disbursement_date >= '$date'");
    } else {
        $result = mysqli_query($connection, "SELECT * FROM loan WHERE int_id = '$sessint_id' AND disbursement_date >= '$date' AND client_id IN (SELECT id FROM client WHERE branch_id = '$branch_id')");
    }

    $no_of_disbursed_loans = mysqli_num_rows($result);
    $totalDisbursedLoans = 0;

    while ($loan = mysqli_fetch_array($result)) {
        $totalDisbursedLoans += $loan['principal_amount'];
    }


    // Outstanding Loans, BOP
    if($parent_id == 0) {
        $result = mysqli_query($connection, "SELECT * FROM loan WHERE int_id = '$sessint_id' AND disbursement_date >= '$thirtydaysbefore' AND (total_outstanding_derived <> 0)");
    } else {
        $result = mysqli_query($connection, "SELECT * FROM loan WHERE int_id = '$sessint_id' AND disbursement_date >= '$thirtydaysbefore' AND client_id IN (SELECT id FROM client WHERE branch_id = '$branch_id') AND (total_outstanding_derived <> 0)");
    }

    $no_of_outstanding_loans_bop = mysqli_num_rows($result);


    // Outstanding Loans, EOP
    if($parent_id == 0) {
        $result = mysqli_query($connection, "SELECT * FROM loan WHERE int_id = '$sessint_id' AND disbursement_date >= '$date' AND (total_outstanding_derived <> 0)");
    } else {
        $result = mysqli_query($connection, "SELECT * FROM loan WHERE int_id = '$sessint_id' AND disbursement_date >= '$date' AND client_id IN (SELECT id FROM client WHERE branch_id = '$branch_id') AND (total_outstanding_derived <> 0)");
    }

    $no_of_outstanding_loans = mysqli_num_rows($result);
    $totalOutstandingLoans = 0;

    while ($loan = mysqli_fetch_array($result)) {
        $totalOutstandingLoans += $loan['total_outstanding_derived'];
    }

    /* 
    Impairment Loss Allowance, Beginning of Period
    */

    // Portfolio at Risk 1 to 30 days, BOP
    if($parent_id == 0) {
        $par1to30_bop = mysqli_query($connection, "SELECT * FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND counter <= 30 AND l.disbursement_date >= '$thirtydaysbefore'");
        $valueofpar1to30_bop = mysqli_query($connection, "SELECT SUM(la.principal_amount) as principal, SUM(la.interest_amount) as interest FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND counter <= 30 AND l.disbursement_date >= '$thirtydaysbefore'");
    } else {
        $par1to30_bop = mysqli_query($connection, "SELECT * FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND counter <= 30 AND l.disbursement_date >= '$thirtydaysbefore'");
        $valueofpar1to30_bop = mysqli_query($connection, "SELECT SUM(la.principal_amount) as principal, SUM(la.interest_amount) as interest FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND counter <= 30 AND l.disbursement_date >= '$thirtydaysbefore'");
    }

    $no_of_par1to30_bop = mysqli_num_rows($par1to30_bop);
    $valueofpar1to30_bop = mysqli_fetch_array($valueofpar1to30_bop);
    $principal_bop = $valueofpar1to30_bop['principal'];
    $interest_bop = $valueofpar1to30_bop['interest'];
    $valueofpar1to30_bop = $principal_bop + $interest_bop;
    $ila1to30_bop = $valueofpar1to30_bop * 0.02;


    // Portfolio at Risk 31 to 60 days, BOP
    if($parent_id == 0) {
        $par31to60_bop = mysqli_query($connection, "SELECT * FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND (counter BETWEEN 31 AND 60) AND l.disbursement_date >= '$thirtydaysbefore'");
        $valueofpar31to60_bop = mysqli_query($connection, "SELECT SUM(la.principal_amount) as principal, SUM(la.interest_amount) as interest FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND (counter BETWEEN 31 AND 60) AND l.disbursement_date >= '$thirtydaysbefore'");
    } else {
        $par31to60_bop = mysqli_query($connection, "SELECT * FROM loan_arrear WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND (counter BETWEEN 31 AND 60) AND l.disbursement_date >= '$thirtydaysbefore'");
        $valueofpar31to60_bop = mysqli_query($connection, "SELECT SUM(la.principal_amount) as principal, SUM(la.interest_amount) as interest FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND (counter BETWEEN 31 AND 60) AND l.disbursement_date >= '$thirtydaysbefore'");
    }

    $no_of_par31to60_bop = mysqli_num_rows($par31to60_bop);
    $valueofpar31to60_bop = mysqli_fetch_array($valueofpar31to60_bop);
    $principal_bop = $valueofpar31to60_bop['principal'];
    $interest_bop = $valueofpar31to60_bop['interest'];
    $valueofpar31to60_bop = $principal_bop + $interest_bop;
    $ila31to60_bop = $valueofpar31to60_bop * 0.05;
    
    
    // Portfolio at Risk 61 to 90 days, BOP
    if($parent_id == 0) {
        $par61to90_bop = mysqli_query($connection, "SELECT * FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND (counter BETWEEN 61 AND 90) AND l.disbursement_date >= '$thirtydaysbefore'");
        $valueofpar61to90_bop = mysqli_query($connection, "SELECT SUM(la.principal_amount) as principal, SUM(la.interest_amount) as interest FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND (counter BETWEEN 61 AND 90) AND l.disbursement_date >= '$thirtydaysbefore'");
    } else {
        $par61to90_bop = mysqli_query($connection, "SELECT * FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND (counter BETWEEN 61 AND 90) AND l.disbursement_date >= '$thirtydaysbefore'");
        $valueofpar61to90_bop = mysqli_query($connection, "SELECT SUM(la.principal_amount) as principal, SUM(la.interest_amount) as interest FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND (counter BETWEEN 61 AND 90) AND l.disbursement_date >= '$thirtydaysbefore'");
    }

    $no_of_par61to90_bop = mysqli_num_rows($par61to90_bop);
    $valueofpar61to90_bop = mysqli_fetch_array($valueofpar61to90_bop);
    $principal_bop = $valueofpar61to90_bop['principal'];
    $interest_bop = $valueofpar61to90_bop['interest'];
    $valueofpar61to90_bop = $principal_bop + $interest_bop;
    $ila61to90_bop = $valueofpar61to90_bop * 0.2;


    // Portfolio at Risk 91 to 180 days, BOP
    if($parent_id == 0) {
        $par91to180_bop = mysqli_query($connection, "SELECT * FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND (counter BETWEEN 91 AND 180) AND l.disbursement_date >= '$thirtydaysbefore'");
        $valueofpar91to180_bop = mysqli_query($connection, "SELECT SUM(la.principal_amount) as principal, SUM(la.interest_amount) as interest FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND (counter BETWEEN 91 AND 180) AND l.disbursement_date >= '$thirtydaysbefore'");
    } else {
        $par91to180_bop = mysqli_query($connection, "SELECT * FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND (counter BETWEEN 91 AND 180) AND l.disbursement_date >= '$thirtydaysbefore'");
        $valueofpar91to180_bop = mysqli_query($connection, "SELECT SUM(la.principal_amount) as principal, SUM(la.interest_amount) as interest FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND (counter BETWEEN 91 AND 180) AND l.disbursement_date >= '$thirtydaysbefore'");
    }

    $no_of_par91to180_bop = mysqli_num_rows($par91to180_bop);
    $valueofpar91to180_bop = mysqli_fetch_array($valueofpar91to180_bop);
    $principal_bop = $valueofpar91to180_bop['principal'];
    $interest_bop = $valueofpar91to180_bop['interest'];
    $valueofpar91to180_bop = $principal_bop + $interest_bop;
    $ila91to180_bop = $valueofpar91to180_bop * 0.5;


    // Portfolio at Risk 180 days and more, BOP
    if($parent_id == 0) {
        $par180andmore_bop = mysqli_query($connection, "SELECT * FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND counter > 180 AND l.disbursement_date >= '$thirtydaysbefore'");
        $valueofpar180andmore_bop = mysqli_query($connection, "SELECT SUM(la.principal_amount) as principal, SUM(la.interest_amount) as interest FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND counter > 180 AND l.disbursement_date >= '$thirtydaysbefore'");
    } else {
        $par180andmore_bop = mysqli_query($connection, "SELECT * FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND counter > 180 AND l.disbursement_date >= '$thirtydaysbefore'");
        $valueofpar180andmore_bop = mysqli_query($connection, "SELECT SUM(la.principal_amount) as principal, SUM(la.interest_amount) as interest FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND counter > 180 AND l.disbursement_date >= '$thirtydaysbefore'");
    }

    $no_of_par180andmore_bop = mysqli_num_rows($par180andmore_bop);
    $valueofpar180andmore_bop = mysqli_fetch_array($valueofpar180andmore_bop);
    $principal_bop = $valueofpar180andmore_bop['principal'];
    $interest_bop = $valueofpar180andmore_bop['interest'];
    $valueofpar180andmore_bop = $principal_bop + $interest_bop;
    $ila180andmore_bop = $valueofpar180andmore_bop;

    $totalila_bop = round($ila1to30_bop) + round($ila31to60_bop) + round($ila61to90_bop) + round($ila91to180_bop) + round($ila180andmore_bop);



    // Current Portfolio
    if($parent_id == 0) {
        $currentportfolio = mysqli_query($connection, "SELECT * FROM loan WHERE int_id = '$sessint_id' AND id IN (SELECT loan_id FROM loan_repayment_schedule) AND id NOT IN (SELECT loan_id FROM loan_arrear) AND disbursement_date >= '$date'");
        $valueofcurrentportfolio = mysqli_query($connection, "SELECT SUM(lr.principal_amount) as principal, SUM(lr.interest_amount) as interest FROM loan_repayment_schedule lr JOIN loan l ON lr.loan_id = l.id WHERE l.id NOT IN (SELECT loan_id FROM loan_arrear) AND l.int_id = '$sessint_id' AND l.disbursement_date >= '$date'");
    } else {
        $currentportfolio = mysqli_query($connection, "SELECT * FROM loan WHERE int_id = '$sessint_id' AND id IN (SELECT loan_id FROM loan_repayment_schedule) AND id NOT IN (SELECT loan_id FROM loan_arrear) AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND disbursement_date >= '$date'");
        $valueofcurrentportfolio = mysqli_query($connection, "SELECT SUM(lr.principal_amount) as principal, SUM(lr.interest_amount) as interest FROM loan_repayment_schedule lr JOIN loan l ON lr.loan_id = l.id WHERE l.id NOT IN (SELECT loan_id FROM loan_arrear) AND l.int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND l.disbursement_date >= '$date'");
    }
    $no_of_currentportfolio = mysqli_num_rows($currentportfolio);
    $valueofcurrentportfolio = mysqli_fetch_array($valueofcurrentportfolio);
    $principal = $valueofcurrentportfolio['principal'];
    $interest = $valueofcurrentportfolio['interest'];
    $valueofcurrentportfolio = $principal + $interest;

    
    // Portfolio at Risk 1 to 30 days, EOP
    if($parent_id == 0) {
        $par1to30 = mysqli_query($connection, "SELECT * FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND counter <= 30 AND l.disbursement_date >= '$date'");
        $valueofpar1to30 = mysqli_query($connection, "SELECT SUM(la.principal_amount) as principal, SUM(la.interest_amount) as interest FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND counter <= 30 AND l.disbursement_date >= '$date'");
    } else {
        $par1to30 = mysqli_query($connection, "SELECT * FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND counter <= 30 AND l.disbursement_date >= '$date'");
        $valueofpar1to30 = mysqli_query($connection, "SELECT SUM(la.principal_amount) as principal, SUM(la.interest_amount) as interest FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND counter <= 30 AND l.disbursement_date >= '$date'");
    }

    $no_of_par1to30 = mysqli_num_rows($par1to30);
    $valueofpar1to30 = mysqli_fetch_array($valueofpar1to30);
    $principal = $valueofpar1to30['principal'];
    $interest = $valueofpar1to30['interest'];
    $valueofpar1to30 = $principal + $interest;
    // ila stands impairment loss allowance
    $ila1to30 = $valueofpar1to30 * 0.02;


    // Portfolio at Risk 31 to 60 days, EOP
    if($parent_id == 0) {
        $par31to60 = mysqli_query($connection, "SELECT * FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND (counter BETWEEN 31 AND 60) AND l.disbursement_date >= '$date'");
        $valueofpar31to60 = mysqli_query($connection, "SELECT SUM(la.principal_amount) as principal, SUM(la.interest_amount) as interest FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND (counter BETWEEN 31 AND 60) AND l.disbursement_date >= '$date'");
    } else {
        $par31to60 = mysqli_query($connection, "SELECT * FROM loan_arrear WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND (counter BETWEEN 31 AND 60) AND l.disbursement_date >= '$date'");
        $valueofpar31to60 = mysqli_query($connection, "SELECT SUM(la.principal_amount) as principal, SUM(la.interest_amount) as interest FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND (counter BETWEEN 31 AND 60) AND l.disbursement_date >= '$date'");
    }

    $no_of_par31to60 = mysqli_num_rows($par31to60);
    $valueofpar31to60 = mysqli_fetch_array($valueofpar31to60);
    $principal = $valueofpar31to60['principal'];
    $interest = $valueofpar31to60['interest'];
    $valueofpar31to60 = $principal + $interest;
    $ila31to60 = $valueofpar31to60 * 0.05;
    
    
    // Portfolio at Risk 61 to 90 days, EOP
    if($parent_id == 0) {
        $par61to90 = mysqli_query($connection, "SELECT * FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND (counter BETWEEN 61 AND 90) AND l.disbursement_date >= '$date'");
        $valueofpar61to90 = mysqli_query($connection, "SELECT SUM(la.principal_amount) as principal, SUM(la.interest_amount) as interest FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND (counter BETWEEN 61 AND 90) AND l.disbursement_date >= '$date'");
    } else {
        $par61to90 = mysqli_query($connection, "SELECT * FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND (counter BETWEEN 61 AND 90) AND l.disbursement_date >= '$date'");
        $valueofpar61to90 = mysqli_query($connection, "SELECT SUM(la.principal_amount) as principal, SUM(la.interest_amount) as interest FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND (counter BETWEEN 61 AND 90) AND l.disbursement_date >= '$date'");
    }

    $no_of_par61to90 = mysqli_num_rows($par61to90);
    $valueofpar61to90 = mysqli_fetch_array($valueofpar61to90);
    $principal = $valueofpar61to90['principal'];
    $interest = $valueofpar61to90['interest'];
    $valueofpar61to90 = $principal + $interest;
    $ila61to90 = $valueofpar61to90 * 0.2;


    // Portfolio at Risk 91 to 180 days, EOP
    if($parent_id == 0) {
        $par91to180 = mysqli_query($connection, "SELECT * FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND (counter BETWEEN 91 AND 180) AND l.disbursement_date >= '$date'");
        $valueofpar91to180 = mysqli_query($connection, "SELECT SUM(la.principal_amount) as principal, SUM(la.interest_amount) as interest FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND (counter BETWEEN 91 AND 180) AND l.disbursement_date >= '$date'");
    } else {
        $par91to180 = mysqli_query($connection, "SELECT * FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND (counter BETWEEN 91 AND 180) AND l.disbursement_date >= '$date'");
        $valueofpar91to180 = mysqli_query($connection, "SELECT SUM(la.principal_amount) as principal, SUM(la.interest_amount) as interest FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND (counter BETWEEN 91 AND 180) AND l.disbursement_date >= '$date'");
    }

    $no_of_par91to180 = mysqli_num_rows($par91to180);
    $valueofpar91to180 = mysqli_fetch_array($valueofpar91to180);
    $principal = $valueofpar91to180['principal'];
    $interest = $valueofpar91to180['interest'];
    $valueofpar91to180 = $principal + $interest;
    $ila91to180 = $valueofpar91to180 * 0.5;


    // Portfolio at Risk 180 days and more, EOP
    if($parent_id == 0) {
        $par180andmore = mysqli_query($connection, "SELECT * FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND counter > 180 AND l.disbursement_date >= '$date'");
        $valueofpar180andmore = mysqli_query($connection, "SELECT SUM(la.principal_amount) as principal, SUM(la.interest_amount) as interest FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND counter > 180 AND l.disbursement_date >= '$date'");
    } else {
        $par180andmore = mysqli_query($connection, "SELECT * FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND counter > 180 AND l.disbursement_date >= '$date'");
        $valueofpar180andmore = mysqli_query($connection, "SELECT SUM(la.principal_amount) as principal, SUM(la.interest_amount) as interest FROM loan_arrear la JOIN loan l ON la.loan_id = l.id WHERE l.int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND counter > 180 AND l.disbursement_date >= '$date'");
    }

    $no_of_par180andmore = mysqli_num_rows($par180andmore);
    $valueofpar180andmore = mysqli_fetch_array($valueofpar180andmore);
    $principal = $valueofpar180andmore['principal'];
    $interest = $valueofpar180andmore['interest'];
    $valueofpar180andmore = $principal + $interest;
    $ila180andmore = $valueofpar180andmore;

    $totalvalueofpar = round($valueofpar1to30) + round($valueofpar31to60) + round($valueofpar61to90) + round($valueofpar91to180) + round($valueofpar180andmore);
    $totalILA = round($ila1to30) + round($ila31to60) + round($ila61to90) + round($ila91to180) + round($ila180andmore);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Loan Portfolio Activity Report</h4>
                <!-- <p class="category"></p> -->
            </div>
            <div class="card-body">
                <div class="row mt-4">
                    <div class="col-12">
                        <table id="lp" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th><small>Account Name</small></th>
                                    <th><small>Name</small></th>
                                    <th class="text-center"><small>Number of Loans</small></th>
                                    <th class="text-center"><small>Value of Portfolio</small></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Loans Disbursed</td>
                                    <td><b>Portfolio Activity</b></td>
                                    <td class="text-center"><?php echo $no_of_disbursed_loans; ?></td>
                                    <td class="text-center"><?php echo "₦ ".number_format($totalDisbursedLoans, 2); ?></td>
                                </tr>
                                <tr>
                                    <td>Loans Outstanding</td>
                                    <td><b>Portfolio Activity</b></td>
                                    <td class="text-center"><?php echo $no_of_outstanding_loans; ?></td>
                                    <td class="text-center"><?php echo "₦ ".number_format($totalOutstandingLoans, 2); ?></td>
                                </tr>
                                <tr>
                                    <td>Impairment Loss Allowance, Beginning of Period</td>
                                    <td><b>Movement in Impairment Loss Allowance</b></td>
                                    <td class="text-center"><?php echo $no_of_outstanding_loans_bop; ?></td>
                                    <td class="text-center"><?php echo "₦ ".number_format($totalila_bop, 2); ?></td>
                                </tr>
                                <tr>
                                    <td>Impairment Loss Allowance, End of Period</td>
                                    <td><b>Movement in Impairment Loss Allowance</b></td>
                                    <td class="text-center"><?php echo $no_of_outstanding_loans; ?></td>
                                    <td class="text-center"><?php echo "₦ ".number_format($totalILA, 2); ?></td>
                                </tr>
                                <tr>
                                    <td>Loans Written off</td>
                                    <td><b>Movement in Impairment Loss Allowance</b></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                </tr>
                                <tr>
                                    <td>Provision of Loans Impairment</td>
                                    <td><b>Movement in Impairment Loss Allowance</b></td>
                                    <td class="text-center"><?php echo $no_of_outstanding_loans; ?></td>
                                    <td class="text-center"><?php echo "₦ ".number_format($totalvalueofpar, 2); ?></td>
                                </tr>
                                <tr>
                                    <td>Loans in Recovery or Recovered</td>
                                    <td><b>Movement in Impairment Loss Allowance</b></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                </tr>
                            </tbody>
                        </table>
                        <script>
                            $(document).ready(function() {
                                var groupColumn = 1;
                                var table = $('#lp').DataTable({

                                    "columnDefs": [{
                                        "visible": false,
                                        "targets": groupColumn
                                    }],
                                    "ordering": false,
                                    "order": [],
                                    "displayLength": 25,
                                    "drawCallback": function(settings) {
                                        var api = this.api();
                                        var rows = api.rows({
                                            page: 'current'
                                        }).nodes();
                                        var last = null;

                                        api.column(groupColumn, {
                                            page: 'current'
                                        }).data().each(function(group, i) {
                                            if (last !== group) {
                                                $(rows).eq(i).before(
                                                    '<tr class="group text-center"><td colspan="5">' + group + '</td></tr>'
                                                );

                                                last = group;
                                            }
                                        });
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Loan Portfolio Aging Schedule Report</h4>
                <!-- <p class="category">Category subtitle</p> -->
            </div>
            <div class="card-body">
                <div class="row mt-4">
                    <div class="col-12">
                        <table id="pas" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th><small>Account Name</small></th>
                                    <th class="text-center"><small>Number of Loans</small></th>
                                    <th class="text-center"><small>Value of Portfolio</small></th>
                                    <th class="text-center"><small>Loss Allowance Rate %</small></th>
                                    <th class="text-center"><small>Impairment Loss Allowance</small></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Current Portfolio</td>
                                    <td class="text-center"><?php echo $no_of_currentportfolio; ?></td>
                                    <td class="text-center"><?php echo "₦ ".number_format(round($valueofcurrentportfolio), 2); ?></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                </tr>
                                <tr>
                                    <td>Portfolio at Risk 1 to 30 days</td>
                                    <td class="text-center"><?php echo $no_of_par1to30; ?></td>
                                    <td class="text-center"><?php echo "₦ ".number_format(round($valueofpar1to30), 2); ?></td>
                                    <td class="text-center">2</td>
                                    <td class="text-center"><?php echo "₦ ".number_format(round($ila1to30), 2); ?></td>
                                </tr>
                                <tr>
                                    <td>Portfolio at Risk 31 to 60 days</td>
                                    <td class="text-center"><?php echo $no_of_par31to60; ?></td>
                                    <td class="text-center"><?php echo "₦ ".number_format(round($valueofpar31to60), 2); ?></td>
                                    <td class="text-center">5</td>
                                    <td class="text-center"><?php echo "₦ ".number_format(round($ila31to60), 2); ?></td>
                                </tr>
                                <tr>
                                    <td>Portfolio at Risk 61 to 90 days</td>
                                    <td class="text-center"><?php echo $no_of_par61to90; ?></td>
                                    <td class="text-center"><?php echo "₦ ".number_format(round($valueofpar61to90), 2); ?></td>
                                    <td class="text-center">20</td>
                                    <td class="text-center"><?php echo "₦ ".number_format(round($ila61to90), 2); ?></td>
                                </tr>
                                <tr>
                                    <td>Portfolio at Risk 91 to 180 days</td>
                                    <td class="text-center"><?php echo $no_of_par91to180; ?></td>
                                    <td class="text-center"><?php echo "₦ ".number_format(round($valueofpar91to180), 2); ?></td>
                                    <td class="text-center">50</td>
                                    <td class="text-center"><?php echo "₦ ".number_format(round($ila91to180), 2); ?></td>
                                </tr>
                                <tr>
                                    <td>Portfolio at Risk 180 days and more</td>
                                    <td class="text-center"><?php echo $no_of_par180andmore; ?></td>
                                    <td class="text-center"><?php echo "₦ ".number_format(round($valueofpar180andmore), 2); ?></td>
                                    <td class="text-center">100</td>
                                    <td class="text-center"><?php echo "₦ ".number_format(round($ila180andmore), 2); ?></td>
                                </tr>
                                <tr>
                                    <td><b>Loans Outstanding</b></td>
                                    <td class="text-center"><b><?php echo $no_of_outstanding_loans; ?></b></td>
                                    <td class="text-center"><b><?php echo "₦ ".number_format($totalvalueofpar, 2); ?></b></td>
                                    <td class="text-center"><b></b></td>
                                    <td class="text-center"><b><?php echo "₦ ".number_format($totalILA, 2); ?></b></td>
                                </tr>
                            </tbody>
                        </table>

                        <script>
                            $(document).ready(function() {
                                $('#pas').DataTable({
                                    "ordering": false
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
}
?>