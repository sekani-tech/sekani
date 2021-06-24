<?php 
include("../../functions/connect.php");
session_start();

$int_id = $_SESSION["int_id"];

if(!empty($_POST["start"]) && !empty($_POST["end"])) {
  $start = $_POST["start"];
  $end = $_POST["end"];
  $branch_id = $_POST["branch_id"];
  $zerobalances_hide = $_POST["zerobalances_hide"];
  $logo = $_SESSION["int_logo"];
  $int_name = $_SESSION["int_name"];

  $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $int_id AND id = $branch_id");
  while ($result = mysqli_fetch_array($getParentID)) {
      $parent_id = $result['parent_id'];
  }

  if ($parent_id == 0) {
      $individual = mysqli_query($connection, "SELECT COUNT(client_type) AS client_type_count FROM client c JOIN loan l ON c.id = l.client_id WHERE c.int_id = '$int_id' AND c.client_type = 'individual' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
      $individual = mysqli_fetch_array($individual);
      $individualCount = $individual["client_type_count"];

      $individual = mysqli_query($connection, "SELECT SUM(total_outstanding_derived) AS outstanding_loans FROM loan l JOIN client c ON l.client_id = c.id WHERE c.int_id = '$int_id' AND c.client_type = 'individual' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
      $individual = mysqli_fetch_array($individual);
      $individualAmount = $individual["outstanding_loans"];


      $joint = mysqli_query($connection, "SELECT COUNT(client_type) AS client_type_count FROM client c JOIN loan l ON c.id = l.client_id WHERE c.int_id = '$int_id' AND c.client_type = 'joint' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
      $joint = mysqli_fetch_array($joint);
      $jointCount = $joint["client_type_count"];

      $joint = mysqli_query($connection, "SELECT SUM(total_outstanding_derived) AS outstanding_loans FROM loan l JOIN client c ON l.client_id = c.id WHERE c.int_id = '$int_id' AND c.client_type = 'joint' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
      $joint = mysqli_fetch_array($joint);
      $jointAmount = $joint["outstanding_loans"];


      $corporate = mysqli_query($connection, "SELECT COUNT(client_type) AS client_type_count FROM client c JOIN loan l ON c.id = l.client_id WHERE c.int_id = '$int_id' AND c.client_type = 'corporate' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
      $corporate = mysqli_fetch_array($corporate);
      $corporateCount = $corporate["client_type_count"];

      $corporate = mysqli_query($connection, "SELECT SUM(total_outstanding_derived) AS outstanding_loans FROM loan l JOIN client c ON l.client_id = c.id WHERE c.int_id = '$int_id' AND c.client_type = 'corporate' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
      $corporate = mysqli_fetch_array($corporate);
      $corporateAmount = $corporate["outstanding_loans"];

      
      $group = mysqli_query($connection, "SELECT COUNT(client_type) AS client_type_count FROM client c JOIN loan l ON c.id = l.client_id WHERE c.int_id = '$int_id' AND c.client_type = 'group' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
      $group = mysqli_fetch_array($group);
      $groupCount = $group["client_type_count"];

      $group = mysqli_query($connection, "SELECT SUM(total_outstanding_derived) AS outstanding_loans FROM loan l JOIN client c ON l.client_id = c.id WHERE c.int_id = '$int_id' AND c.client_type = 'group' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
      $group = mysqli_fetch_array($group);
      $groupAmount = $group["outstanding_loans"];


      $staff = mysqli_query($connection, "SELECT COUNT(*) AS staff_count FROM client c JOIN loan l ON c.id = l.client_id WHERE c.int_id = '$int_id' AND c.is_staff = '1'");
      $staff = mysqli_fetch_array($staff);
      $staffCount = $staff["staff_count"];

      $staff = mysqli_query($connection, "SELECT SUM(total_outstanding_derived) AS outstanding_loans FROM loan l JOIN client c ON l.client_id = c.id WHERE c.int_id = '$int_id' AND c.is_staff = '1' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
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
      } else {
        $individualPercentage = 0;
        $jointPercentage = 0;
        $corporatePercentage = 0;
        $groupPercentage = 0;
        $staffPercentage = 0;
      }

  } else {
      $individual = mysqli_query($connection, "SELECT COUNT(client_type) AS client_type_count FROM client c JOIN loan l ON c.id = l.client_id WHERE c.int_id = '$int_id' AND c.branch_id = '$branch_id' AND c.client_type = 'individual' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
      $individual = mysqli_fetch_array($individual);
      $individualCount = $individual["client_type_count"];

      $individual = mysqli_query($connection, "SELECT SUM(total_outstanding_derived) AS outstanding_loans FROM loan l JOIN client c ON l.client_id = c.id WHERE c.int_id = '$int_id' AND c.branch_id = '$branch_id' AND c.client_type = 'individual' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
      $individual = mysqli_fetch_array($individual);
      $individualAmount = $individual["outstanding_loans"];


      $joint = mysqli_query($connection, "SELECT COUNT(client_type) AS client_type_count FROM client c JOIN loan l ON c.id = l.client_id WHERE c.int_id = '$int_id' AND c.branch_id = '$branch_id' AND c.client_type = 'joint' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
      $joint = mysqli_fetch_array($joint);
      $jointCount = $joint["client_type_count"];

      $joint = mysqli_query($connection, "SELECT SUM(total_outstanding_derived) AS outstanding_loans FROM loan l JOIN client c ON l.client_id = c.id WHERE c.int_id = '$int_id' AND c.branch_id = '$branch_id' AND c.client_type = 'joint' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
      $joint = mysqli_fetch_array($joint);
      $jointAmount = $joint["outstanding_loans"];

      
      $corporate = mysqli_query($connection, "SELECT COUNT(client_type) AS client_type_count FROM client c JOIN loan l ON c.id = l.client_id WHERE c.int_id = '$int_id' AND c.branch_id = '$branch_id' AND c.client_type = 'corporate' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
      $corporate = mysqli_fetch_array($corporate);
      $corporateCount = $corporate["client_type_count"];

      $corporate = mysqli_query($connection, "SELECT SUM(total_outstanding_derived) AS outstanding_loans FROM loan l JOIN client c ON l.client_id = c.id WHERE c.int_id = '$int_id' AND c.branch_id = '$branch_id' AND c.client_type = 'corporate' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
      $corporate = mysqli_fetch_array($corporate);
      $corporateAmount = $corporate["outstanding_loans"];

      
      $group = mysqli_query($connection, "SELECT COUNT(client_type) AS client_type_count FROM client c JOIN loan l ON c.id = l.client_id WHERE c.int_id = '$int_id' AND c.branch_id = '$branch_id' AND c.client_type = 'group' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
      $group = mysqli_fetch_array($group);
      $groupCount = $group["client_type_count"];

      $group = mysqli_query($connection, "SELECT SUM(total_outstanding_derived) AS outstanding_loans FROM loan l JOIN client c ON l.client_id = c.id WHERE c.int_id = '$int_id' AND c.branch_id = '$branch_id' AND c.client_type = 'group' AND c.is_staff = '0' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
      $group = mysqli_fetch_array($group);
      $groupAmount = $group["outstanding_loans"];


      $staff = mysqli_query($connection, "SELECT COUNT(*) AS staff_count FROM client c JOIN loan l ON c.id = l.client_id WHERE c.int_id = '$int_id' AND c.branch_id = '$branch_id' AND c.is_staff = '1' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
      $staff = mysqli_fetch_array($staff);
      $staffCount = $staff["staff_count"];

      $staff = mysqli_query($connection, "SELECT SUM(total_outstanding_derived) AS outstanding_loans FROM loan l JOIN client c ON l.client_id = c.id WHERE c.int_id = '$int_id' AND c.branch_id = '$branch_id' AND c.is_staff = '1' AND (l.disbursement_date BETWEEN '$start' AND '$end')");
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
      } else {
        $individualPercentage = 0;
        $jointPercentage = 0;
        $corporatePercentage = 0;
        $groupPercentage = 0;
        $staffPercentage = 0;
      }
      
  }
?>
  <div class="col-12">
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title">Micro Loans by Lending Models</h4>
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <th style="font-weight:bold;">LENDING MODEL</th>
            <th style="font-weight:bold; text-align: center;">NUMBER</th>
            <th style="font-weight:bold; text-align: center;">AMOUNT (&#x20A6;)</th>
            <th style="font-weight:bold; text-align: center;">% <br> (PER LENDING MODEL)</th>
          </thead>
          <tbody>
            <?php if(!($zerobalances_hide == 'yes' && $individualCount == 0)) {?>
            <tr>
                <td>Individual Account</td>
                <td class="text-center"><?php echo $individualCount; ?></td>
                <td class="text-center"><?php echo number_format(round($individualAmount), 2); ?></td>
                <td class="text-center" style="background-color:bisque;"><?php echo round($individualPercentage, 2); ?></td>
            </tr>
            <?php } ?>

            <?php if(!($zerobalances_hide == 'yes' && $jointCount == 0)) {?>
            <tr>
                <td>Joint Account</td>
                <td class="text-center"><?php echo $jointCount; ?></td>
                <td class="text-center"><?php echo number_format(round($jointAmount), 2); ?></td>
                <td class="text-center" style="background-color:bisque;"><?php echo round($jointPercentage, 2); ?></td>
            </tr>
            <?php } ?>

            <?php if(!($zerobalances_hide == 'yes' && $corporateCount == 0)) {?>
            <tr>
                <td>Corporate Account</td>
                <td class="text-center"><?php echo $corporateCount; ?></td>
                <td class="text-center"><?php echo number_format(round($corporateAmount), 2); ?></td>
                <td class="text-center" style="background-color:bisque;"><?php echo round($corporatePercentage, 2); ?></td>
            </tr>
            <?php } ?>

            <?php if(!($zerobalances_hide == 'yes' && $groupCount == 0)) {?>
            <tr>
                <td>Group Account</td>
                <td class="text-center"><?php echo $groupCount; ?></td>
                <td class="text-center"><?php echo number_format(round($groupAmount), 2); ?></td>
                <td class="text-center" style="background-color:bisque;"><?php echo round($groupPercentage, 2); ?></td>
            </tr>
            <?php } ?>

            <?php if(!($zerobalances_hide == 'yes' && $staffCount == 0)) {?>
            <tr>
                <td>Staff Account</td>
                <td class="text-center"><?php echo $staffCount; ?></td>
                <td class="text-center"><?php echo number_format(round($staffAmount), 2); ?></td>
                <td class="text-center" style="background-color:bisque;"><?php echo round($staffPercentage, 2); ?></td>
            </tr>
            <?php } ?>

            <tr>
                <td>Total</td>
                <td class="text-center" style="background-color:bisque;"><?php echo $totalCount; ?></td>
                <td class="text-center" style="background-color:bisque;"><?php echo number_format(round($totalAmount), 2); ?></td>
                <td class="text-center" style="background-color:bisque;">100</td>
            </tr>
          </tbody>
        </table>
        <div class="form-group mt-4">
          <form method="POST" action="../composer/loan_structure.php">
            <input hidden name="start" type="text" value="<?php echo $start; ?>" />
            <input hidden name="end" type="text" value="<?php echo $end; ?>" />
            <input hidden name="branch_id" type="text" value="<?php echo $branch_id; ?>" />
            <button type="submit" name="downloadPDF" class="btn btn-primary">DOWNLOAD PDF</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php
}
?>