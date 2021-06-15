<?php

$page_title = "Approval";
$destination = "approval.php";
include("header.php");

$exp_error = "";
$message = $_SESSION['feedback'];
if ($message != "") {
?>
    <input type="text" value="<?php echo $message ?>" id="feedback" hidden>
<?php
}
// feedback messages 0 for success and 1 for errors

if (isset($_GET["message0"])) {
    $key = $_GET["message0"];
    $tt = 0;

    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
      $(document).ready(function(){
        let feedback =  document.getElementById("feedback").value;
          swal({
              type: "success",
              title: "Success",
              text: feedback,
              showConfirmButton: true,
              timer: 7000
          })
      });
      </script>
      ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["message1"])) {
    $key = $_GET["message1"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
      $(document).ready(function(){
        let feedback =  document.getElementById("feedback").value;
          swal({
              type: "error",
              title: "Error",
              text: feedback,
              showConfirmButton: true,
              timer: 7000
          })
      });
      </script>
      ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
}
// right now we will program
// first step - check if this person is authorized

if ($can_transact == 1 || $can_transact == "1") {
?>
    <!-- <link href="vendor/css/addons/datatables.min.css" rel="stylesheet">
    <script type="text/javascript" src="vendor/js/addons/datatables.min.js"></script> -->
    <!-- Content added here -->
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
            $out .= " OR branch_id ='$do'";
        }
        return $out;
    }

    $br_id = $_SESSION["branch_id"];
    $branches = branch_opt($connection);
    ?>
    <div class="content">
        <div class="container-fluid">
            <!-- your content here -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">

                            <h4 class="card-title ">Transactions</h4>

                            <!-- Insert number users institutions -->
                            <p class="card-category">
                                <?php
                                //                                $query = "SELECT * FROM transact_cache WHERE int_id='$sessint_id' && status = 'Pending'";
                                $result = selectAll('transact_cache', ['int_id' => $sessint_id, 'status' => 'Pending', 'transact_type' => 'Expense']);
                                if ($result) {
                                    $totalResult = count($result);
                                    if ($totalResult == '0') {
                                        echo 'No Transactions need of approval';
                                    } else {
                                        echo '' . $totalResult . ' Transactions on the platform';
                                    }
                                }
                                ?> || Approve Transaction</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <form action="bulkWork/bulk_approval.php" method="post">
                                    <table id="sent" class="table table-striped table-bordered">

                                        <thead>
                                            <?php
                                            $results = selectAll('transact_cache', ['int_id' => $sessint_id, 'status' => 'Pending', 'transact_type' => 'Expense']);
                                            ?>
                                            <!-- <tr> -->

                                            <th>S/N</th>
                                            <th>
                                                Branch
                                            </th>
                                            <th>
                                                Transaction Type
                                            </th>
                                            <th>
                                                Narration
                                            </th>
                                            <th>
                                                Amount
                                            </th>
                                            <th>
                                                Date
                                            </th>
                                            <th>
                                                Posted By
                                            </th>
                                            <th>
                                                Client
                                            </th>

                                            <th>Status</th>
                                            <th>Approval</th>
                                            <!-- </tr> -->
                                            <!-- <th>Phone</th> -->
                                        </thead>
                                        <tbody>
                                            <?php if ($results) {

                                                foreach ($results as $key => $row) {
                                            ?>
                                                    <tr>
                                                        <?php $row["id"]; ?>
                                                        <?php
                                                        //                                                    changing branch id to name
                                                        $branchId = $row["branch_id"];
                                                        $branchName = selectSpecificData('branch', ['name'], ['id' => $branchId, 'int_id' => $sessint_id]);
                                                        $showBranchName = $branchName['name'];

                                                        //                                                    changing staff id to name
                                                        $staffId = $row['staff_id'];
                                                        $staffName = selectSpecificData('staff', ['display_name'], ['id' => $staffId, 'int_id' => $sessint_id]);
                                                        $showStaffName = $staffName['display_name'];

                                                        ?>

                                                        <td><?php echo $key + 1 ?></td>
                                                        <td><?php echo $showBranchName; ?></td>
                                                        <td><?php echo $row["transact_type"]; ?></td>
                                                        <td>
                                                            <?php if ($row["is_bank"] == 1) {
                                                                echo "Bank";
                                                            } else if ($row["is_bank"] == 0) {
                                                                echo "Cash";
                                                            } else if ($row["is_bank"] == 2) {
                                                                echo "Salary";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php echo number_format($row["amount"], 2); ?></td>
                                                        <td><?php
                                                            $dateString = strtotime($row["date"]);
                                                            echo $date = date('Y/m/d', $dateString);
                                                            ?></td>
                                                        <td><?php echo $showStaffName; ?></td>
                                                        <td><?php echo $row["client_name"]; ?></td>
                                                        <td><?php echo $row["status"]; ?></td>
                                                        <td><a href="approve_Expense.php?approve=<?php echo $row["id"]; ?>" class="btn btn-info">View</a></td>
                                                    </tr>
                                                    <!-- <th></th> -->
                                            <?php }
                                            } else {
                                                // echo "0 Staff";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </form>
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
<?php
} else {
    echo '<script type="text/javascript">
  $(document).ready(function(){
   swal({
    type: "error",
    title: "Transaction Authorization",
    text: "You Dont Have permission to Approve",
   showConfirmButton: false,
    timer: 2000
    }).then(
    function (result) {
      history.go(-1);
    }
    )
    });
   </script>
  ';
    // $URL="transact.php";
    // echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}

?>
<script>
    $(document).ready(function() {
        $('#sent').DataTable();
    });
</script>