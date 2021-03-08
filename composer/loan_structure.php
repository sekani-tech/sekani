<?php
include("../functions/connect.php");
session_start();

if(isset($_POST["downloadPDF"])) {

    if (!empty($_POST["start"]) && !empty($_POST["end"]) && !empty($_POST["branch_id"])) {

        $start = $_POST["start"];
        $end = $_POST["end"];
        $sessint_id = $_SESSION['int_id'];
        $branch_id = $_POST["branch_id"];

        $branchquery = mysqli_query($connection, "SELECT * FROM branch WHERE int_id = '$sessint_id' AND id = '$branch_id'");
        if (count([$branchquery]) == 1) {
          $ans = mysqli_fetch_array($branchquery);
          $branch = $ans['name'];
          $branch_email = $ans['email'];
          $branch_location = $ans['location'];
          $branch_phone = $ans['phone'];
        }

        function fill_data($connection, $start, $end, $sessint_id, $branch_id) {

            $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
            while ($result = mysqli_fetch_array($getParentID)) {
                $parent_id = $result['parent_id'];
            }

            if($parent_id == 0) {
                $individual = mysqli_query($connection, "SELECT COUNT(client_type) AS client_type_count FROM client c JOIN loan l ON c.id = l.client_id WHERE c.int_id = '$sessint_id' AND c.client_type = 'individual' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
                $individual = mysqli_fetch_array($individual);
                $individualCount = $individual["client_type_count"];
        
                $individual = mysqli_query($connection, "SELECT SUM(total_outstanding_derived) AS outstanding_loans FROM loan l JOIN client c ON l.client_id = c.id WHERE c.int_id = '$sessint_id' AND c.client_type = 'individual' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
                $individual = mysqli_fetch_array($individual);
                $individualAmount = $individual["outstanding_loans"];
        
        
                $joint = mysqli_query($connection, "SELECT COUNT(client_type) AS client_type_count FROM client c JOIN loan l ON c.id = l.client_id WHERE c.int_id = '$sessint_id' AND c.client_type = 'joint' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
                $joint = mysqli_fetch_array($joint);
                $jointCount = $joint["client_type_count"];
        
                $joint = mysqli_query($connection, "SELECT SUM(total_outstanding_derived) AS outstanding_loans FROM loan l JOIN client c ON l.client_id = c.id WHERE c.int_id = '$sessint_id' AND c.client_type = 'joint' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
                $joint = mysqli_fetch_array($joint);
                $jointAmount = $joint["outstanding_loans"];
        
        
                $corporate = mysqli_query($connection, "SELECT COUNT(client_type) AS client_type_count FROM client c JOIN loan l ON c.id = l.client_id WHERE c.int_id = '$sessint_id' AND c.client_type = 'corporate' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
                $corporate = mysqli_fetch_array($corporate);
                $corporateCount = $corporate["client_type_count"];
        
                $corporate = mysqli_query($connection, "SELECT SUM(total_outstanding_derived) AS outstanding_loans FROM loan l JOIN client c ON l.client_id = c.id WHERE c.int_id = '$sessint_id' AND c.client_type = 'corporate' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
                $corporate = mysqli_fetch_array($corporate);
                $corporateAmount = $corporate["outstanding_loans"];
        
                
                $group = mysqli_query($connection, "SELECT COUNT(client_type) AS client_type_count FROM client c JOIN loan l ON c.id = l.client_id WHERE c.int_id = '$sessint_id' AND c.client_type = 'group' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
                $group = mysqli_fetch_array($group);
                $groupCount = $group["client_type_count"];
        
                $group = mysqli_query($connection, "SELECT SUM(total_outstanding_derived) AS outstanding_loans FROM loan l JOIN client c ON l.client_id = c.id WHERE c.int_id = '$sessint_id' AND c.client_type = 'group' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
                $group = mysqli_fetch_array($group);
                $groupAmount = $group["outstanding_loans"];
        
        
                $staff = mysqli_query($connection, "SELECT COUNT(*) AS staff_count FROM client c JOIN loan l ON c.id = l.client_id WHERE c.int_id = '$sessint_id' AND c.is_staff = '1'");
                $staff = mysqli_fetch_array($staff);
                $staffCount = $staff["staff_count"];
        
                $staff = mysqli_query($connection, "SELECT SUM(total_outstanding_derived) AS outstanding_loans FROM loan l JOIN client c ON l.client_id = c.id WHERE c.int_id = '$sessint_id' AND c.is_staff = '1' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
                $staff = mysqli_fetch_array($staff);
                $staffAmount = $staff["outstanding_loans"];
    
                $totalCount = $individualCount + $jointCount + $corporateCount + $groupCount + $staffCount;
                $totalAmount = $individualAmount + $jointAmount + $corporateAmount + $groupAmount + $staffAmount;
        
                // avoid division by zero
                if($totalCount != 0) {
                    $individualPercentage = $individualCount/$totalCount * 100;
                    $jointPercentage = $jointCount/$totalCount * 100;
                    $corporatePercentage = $corporateCount/$totalCount * 100;
                    $groupPercentage = $groupCount/$totalCount * 100;
                    $staffPercentage = $staffCount/$totalCount * 100;
                } 
                else {
                    $individualPercentage = 0;
                    $jointPercentage = 0;
                    $corporatePercentage = 0;
                    $groupPercentage = 0;
                    $staffPercentage = 0;
                }

            } 
            else {
                $individual = mysqli_query($connection, "SELECT COUNT(client_type) AS client_type_count FROM client c JOIN loan l ON c.id = l.client_id WHERE c.int_id = '$sessint_id' AND c.branch_id = '$branch_id' AND c.client_type = 'individual' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
                $individual = mysqli_fetch_array($individual);
                $individualCount = $individual["client_type_count"];
          
                $individual = mysqli_query($connection, "SELECT SUM(total_outstanding_derived) AS outstanding_loans FROM loan l JOIN client c ON l.client_id = c.id WHERE c.int_id = '$sessint_id' AND c.branch_id = '$branch_id' AND c.client_type = 'individual' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
                $individual = mysqli_fetch_array($individual);
                $individualAmount = $individual["outstanding_loans"];
          
          
                $joint = mysqli_query($connection, "SELECT COUNT(client_type) AS client_type_count FROM client c JOIN loan l ON c.id = l.client_id WHERE c.int_id = '$sessint_id' AND c.branch_id = '$branch_id' AND c.client_type = 'joint' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
                $joint = mysqli_fetch_array($joint);
                $jointCount = $joint["client_type_count"];
          
                $joint = mysqli_query($connection, "SELECT SUM(total_outstanding_derived) AS outstanding_loans FROM loan l JOIN client c ON l.client_id = c.id WHERE c.int_id = '$sessint_id' AND c.branch_id = '$branch_id' AND c.client_type = 'joint' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
                $joint = mysqli_fetch_array($joint);
                $jointAmount = $joint["outstanding_loans"];
          
                
                $corporate = mysqli_query($connection, "SELECT COUNT(client_type) AS client_type_count FROM client c JOIN loan l ON c.id = l.client_id WHERE c.int_id = '$sessint_id' AND c.branch_id = '$branch_id' AND c.client_type = 'corporate' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
                $corporate = mysqli_fetch_array($corporate);
                $corporateCount = $corporate["client_type_count"];
          
                $corporate = mysqli_query($connection, "SELECT SUM(total_outstanding_derived) AS outstanding_loans FROM loan l JOIN client c ON l.client_id = c.id WHERE c.int_id = '$sessint_id' AND c.branch_id = '$branch_id' AND c.client_type = 'corporate' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
                $corporate = mysqli_fetch_array($corporate);
                $corporateAmount = $corporate["outstanding_loans"];
          
                
                $group = mysqli_query($connection, "SELECT COUNT(client_type) AS client_type_count FROM client c JOIN loan l ON c.id = l.client_id WHERE c.int_id = '$sessint_id' AND c.branch_id = '$branch_id' AND c.client_type = 'group' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
                $group = mysqli_fetch_array($group);
                $groupCount = $group["client_type_count"];
          
                $group = mysqli_query($connection, "SELECT SUM(total_outstanding_derived) AS outstanding_loans FROM loan l JOIN client c ON l.client_id = c.id WHERE c.int_id = '$sessint_id' AND c.branch_id = '$branch_id' AND c.client_type = 'group' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
                $group = mysqli_fetch_array($group);
                $groupAmount = $group["outstanding_loans"];
          
          
                $staff = mysqli_query($connection, "SELECT COUNT(*) AS staff_count FROM client c JOIN loan l ON c.id = l.client_id WHERE c.int_id = '$sessint_id' AND c.branch_id = '$branch_id' AND c.is_staff = '1' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
                $staff = mysqli_fetch_array($staff);
                $staffCount = $staff["staff_count"];
          
                $staff = mysqli_query($connection, "SELECT SUM(total_outstanding_derived) AS outstanding_loans FROM loan l JOIN client c ON l.client_id = c.id WHERE c.int_id = '$sessint_id' AND c.branch_id = '$branch_id' AND c.is_staff = '1' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
                $staff = mysqli_fetch_array($staff);
                $staffAmount = $staff["outstanding_loans"];
          
                $totalCount = $individualCount + $jointCount + $corporateCount + $groupCount + $staffCount;
                $totalAmount = $individualAmount + $jointAmount + $corporateAmount + $groupAmount + $staffAmount;
          
                // avoid division by zero
                if($totalCount != 0) {
                  $individualPercentage = $individualCount/$totalCount * 100;
                  $jointPercentage = $jointCount/$totalCount * 100;
                  $corporatePercentage = $corporateCount/$totalCount * 100;
                  $groupPercentage = $groupCount/$totalCount * 100;
                  $staffPercentage = $staffCount/$totalCount * 100;
                } 
                else {
                  $individualPercentage = 0;
                  $jointPercentage = 0;
                  $corporatePercentage = 0;
                  $groupPercentage = 0;
                  $staffPercentage = 0;
                }
            }

            $out = '
                <tr>
                    <td style = "font-size:14px;">Individual Account</td>
                    <td style = "font-size:14px;">'.$individualCount.'</td>
                    <td style = "font-size:14px;">'.number_format(round($individualAmount), 2).'</td>
                    <td style = "font-size:14px;">'.$individualPercentage.'</td>
                </tr>
                <tr>
                    <td style = "font-size:14px;">Joint Account</td>
                    <td style = "font-size:14px;">'.$jointCount.'</td>
                    <td style = "font-size:14px;">'.number_format(round($jointAmount), 2).'</td>
                    <td style = "font-size:14px;">'.$jointPercentage.'</td>
                </tr>
                <tr>
                    <td style = "font-size:14px;">Corporate Account</td>
                    <td style = "font-size:14px;">'.$corporateCount.'</td>
                    <td style = "font-size:14px;">'.number_format(round($corporateAmount), 2).'</td>
                    <td style = "font-size:14px;">'.$corporatePercentage.'</td>
                </tr>
                <tr>
                    <td style = "font-size:14px;">Group Account</td>
                    <td style = "font-size:14px;">'.$groupCount.'</td>
                    <td style = "font-size:14px;">'.number_format(round($groupAmount), 2).'</td>
                    <td style = "font-size:14px;">'.$groupPercentage.'</td>
                </tr>
                <tr>
                    <td style = "font-size:14px;">Staff Account</td>
                    <td style = "font-size:14px;">'.$staffCount.'</td>
                    <td style = "font-size:14px;">'.number_format(round($staffAmount), 2).'</td>
                    <td style = "font-size:14px;">'.$staffPercentage.'</td>
                </tr>
                <tr>
                    <td style = "font-size:14px;">Total</td>
                    <td style = "font-size:14px;">'.$totalCount.'</td>
                    <td style = "font-size:14px;">'.number_format(round($totalAmount), 2).'</td>
                    <td style = "font-size:14px;">100</td>
                </tr>
            ';

            return $out;

        }

    }

    require_once __DIR__ . '/vendor/autoload.php';
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->SetWatermarkImage(''.$_SESSION["int_logo"].'');
    $mpdf->showWatermarkImage = true;
    $mpdf->WriteHTML('<link rel="stylesheet" media="print" href="pdf/style.css" media="all"/>
    <header class="clearfix">
      <div id="logo">
        <img src="'.$_SESSION["int_logo"].'" height="80" width="80">
      </div>
      <h1>'.$_SESSION["int_full"].' <br/>Loan Structure Report</h1>
      <div id="company" class="clearfix">
        <div>'.$branch.'</div>
        <div>'.$branch_location.'</div>
        <div>(+234) '.$branch_phone.'</div>
        <div><a href="mailto:'.$branch_email.'">'.$branch_email.'</a></div>
      </div>
      <div id="project">
        <div><span>BRANCH</span> '.$branch.' </div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr class="table100-head">
            <th style = "font-size:14px;">Lending Model</th>
            <th style = "font-size:14px;">Number</th>
            <th style = "font-size:14px;">Amount</th>
            <th style = "font-size:14px;">% (per lending model)</th>
          </tr>
        </thead>
        <tbody>
          "'.fill_data($connection, $start, $end, $sessint_id, $branch_id).'"
        </tbody>
      </table>
    </main>
    ');

    $file_name = 'loan-structure-report-' . date('d-m-Y', time()) . '.pdf';
    $mpdf->Output($file_name, 'D');
}