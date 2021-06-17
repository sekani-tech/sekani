<?php

$page_title = "Approval";
$destination = "approval.php";
include("header.php");

if (isset($_GET["message1"])) {
    $key = $_GET["message1"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Success",
          text: "Transaction Successfully Approved",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["message2"])) {
    $key = $_GET["message2"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Error",
          text: "Error updating Cache",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["message3"])) {
    $key = $_GET["message2"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Error",
          text: "' . $out = $_SESSION["lack_of_intfund_$key"] . '",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["message4"])) {
    $key = $_GET["message4"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        // $out = $_SESSION["lack_of_intfund_$key"];
        echo '<script type="text/javascript">
$(document).ready(function(){
    swal({
        type: "error",
        title: "No Transaction Checked",
        text: "Sorry Please Select Some Transactions",
        showConfirmButton: true,
        timer: 60000
    })
});
</script>
';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["message8"])) {
    $key = $_GET["message8"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Success",
          text: "Transaction Has Been Declined",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["messageBulkApp1"])) {
    $key = $_GET["messageBulkApp1"];
    $tt = 0;
    //    dd($_SESSION["lack_of_intfund_$key"]);
    if ($tt !== $_GET["messageBulkApp1"]) {
?>
        <input type="text" hidden value="<?php echo $key ?>" id="showNumber">
    <?php
        echo '<script type="text/javascript">
$(document).ready(function(){
    let showNumber = document.getElementById("showNumber").value;
    swal({
        type: "error",
        title: "Repeated Transaction",
        text: "Sorry Number "+ showNumber + " is already done",
        showConfirmButton: true,
        timer: 60000
    })
});
</script>
';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["messageBulkApp2"])) {
    $key = $_GET["messageBulkApp2"];
    $tt = 0;
    if ($tt !== $key) {
    ?>
        <input type="text" hidden value="<?php echo $key ?>" id="showNumber">
    <?php
        echo '<script type="text/javascript">
$(document).ready(function(){
    let showNumber = document.getElementById("showNumber").value;
    swal({
        type: "error",
        title: "Wrong Account Number",
        text: "Sorry Account Number for Serial Number "+ showNumber + " is not Found",
        showConfirmButton: true,
        timer: 60000
    })
});
</script>
';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["messageBulkApp3"])) {
    $key = $_GET["messageBulkApp3"];
    $tt = 0;
    if ($tt !== $key) {
    ?>
        <input type="text" hidden value="<?php echo $key ?>" id="showNumber">
    <?php
        echo '<script type="text/javascript">
$(document).ready(function(){
    let showNumber = document.getElementById("showNumber").value;
    swal({
        type: "error",
        title: "Wrong Payment Type",
        text: "Sorry Payment Type for Serial Number "+ showNumber + " is not Defined",
        showConfirmButton: true,
        timer: 60000
    })
});
</script>
';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["messageBulkApp4"])) {
    $key = $_GET["messageBulkApp4"];
    $tt = 0;
    if ($tt !== $key) {
    ?>
        <input type="text" hidden value="<?php echo $key ?>" id="showNumber">
    <?php
        echo '<script type="text/javascript">
$(document).ready(function(){
    let showNumber = document.getElementById("showNumber").value;
    swal({
        type: "error",
        title: "Wrong Institution",
        text: "Sorry Institution for Serial Number "+ showNumber + " is not Defined",
        showConfirmButton: true,
        timer: 60000
    })
});
</script>
';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["messageBulkApp5"])) {
    $key = $_GET["messageBulkApp5"];
    $tt = 0;
    if ($tt !== $key) {
    ?>
        <input type="text" hidden value="<?php echo $key ?>" id="showNumber">
    <?php
        echo '<script type="text/javascript">
$(document).ready(function(){
    let showNumber = document.getElementById("showNumber").value;
    swal({
        type: "success",
        title: "Transaction Successful",
        text: "Transaction Approved",
        showConfirmButton: true,
        timer: 60000
    })
});
</script>
';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["messageBulkApp6"])) {
    $key = $_GET["messageBulkApp6"];
    $tt = 0;
    if ($tt !== $key) {
    ?>
        <input type="text" hidden value="<?php echo $key ?>" id="showNumber">
    <?php
        echo '<script type="text/javascript">
$(document).ready(function(){
    let showNumber = document.getElementById("showNumber").value;
    swal({
        type: "success",
        title: "Transaction Successful",
        text: "The total of "+ showNumber +" Transactions Declined",
        showConfirmButton: true,
        timer: 60000
    })
});
</script>
';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["messageBulkApp7"])) {
    $key = $_GET["messageBulkApp7"];
    $tt = 0;
    if ($tt !== $key) {
        echo '<script type="text/javascript">
$(document).ready(function(){
    swal({
        type: "warning",
        title: "No Transaction",
        text: "No Withdrawal Transaction Found",
        showConfirmButton: true,
        timer: 60000
    })
});
</script>
';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["messageBulkApp8"])) {
    $key = $_GET["messageBulkApp8"];
    $tt = 0;
    if ($tt !== $key) { ?>
        <input type="text" hidden value="<?php echo $key ?>" id="showNumber">
    <?php
        echo '<script type="text/javascript">
$(document).ready(function(){
    let showNumber = document.getElementById("showNumber").value;
    swal({
        type: "warning",
        title: "Insufficient Fund",
        text: "This Account on " +showNumber + " has Insufficient Fund",
        showConfirmButton: true,
        timer: 60000
    })
});
</script>
';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["messageBulkApp9"])) {
    $key = $_GET["messageBulkApp9"];
    $tt = 0;
    if ($tt !== $key) { ?>
        <input type="text" hidden value="<?php echo $key ?>" id="showNumber">
    <?php
        echo '<script type="text/javascript">
$(document).ready(function(){
    let showNumber = document.getElementById("showNumber").value;
    swal({
        type: "warning",
        title: "Branch Not Found",
        text: "This Serial Number " + showNumber + " Branch is Not Found",
        showConfirmButton: true,
        timer: 60000
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
                                $result = selectAllandNot('transact_cache', ['int_id' => $sessint_id, 'status' => 'Pending'], ['transact_type' => 'Expense']);
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
                                    <table class="rtable display nowrap" style="width:100%;">
                                        <div class="row">
                                            <div class="col-md-4 p-3" id="bulkOptionsContainer">
                                                <label for="">Select Action</label>
                                                <select class="form-control custom-select" name="bulk_options" id="" required>
                                                    <option value="">Select Options</option>
                                                    <option value="Approval">Approval</option>
                                                    <option value="Decline">Decline</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 p-3" id="bulkOptionsContainer">
                                                <label for="">Action Type</label>
                                                <select class="form-control custom-select" name="bulk_options_type" id="" required>
                                                    <option value="">Select Action Type</option>
                                                    <option value="Deposit">Deposit</option>
                                                    <option value="Withdrawal">Withdrawal</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 p-3">
                                                <input type="submit" name="submit" class="btn btn-success" value="Apply">
                                            </div>
                                        </div>

                                        <thead class=" text-primary">
                                            <?php
                                            $results = selectAllandNot('transact_cache', ['int_id' => $sessint_id, 'status' => 'Pending'], ['transact_type' => 'Expense']);
                                            ?>
                                            <tr>
                                                <th><input id="selectAllBoxes" type="checkbox"></th>
                                                <th>S/N</th>
                                                <th class="th-sm">
                                                    Branch
                                                </th>
                                                <th class="th-sm">
                                                    Transaction Type
                                                </th>
                                                <th class="th-sm">
                                                    Narration
                                                </th>
                                                <th class="th-sm">
                                                    Amount
                                                </th>
                                                <th class="th-sm">
                                                    Date
                                                </th>
                                                <th class="th-sm">
                                                    Posted By
                                                </th>
                                                <th class="th-sm">
                                                    Client
                                                </th>

                                                <th class="th-sm">Status</th>
                                                <th>Approval</th>
                                            </tr>
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

                                                        <td><input class='checkBox' type='checkbox' name='checkBoxArray[]' value='<?php echo $row["id"] ?>'></td>
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
                                                        <td><a href="approve.php?approve=<?php echo $row["id"]; ?>" class="btn btn-info">View</a></td>
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
    <script>
        //        to check
        function check(checked = true) {
            const cbs = document.querySelectorAll('input[class="checkBox"]');
            cbs.forEach((cb) => {
                cb.checked = checked;
            });
        }

        function checkAll() {
            check();
            // reassign click event handler
            this.onclick = uncheckAll;
        }

        function uncheckAll() {
            check(false);
            // reassign click event handler
            this.onclick = checkAll;
        }

        const checkMultiple = document.querySelector('#selectAllBoxes');
        checkMultiple.onclick = checkAll;
    </script>
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