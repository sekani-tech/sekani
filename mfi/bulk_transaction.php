<?php

$page_title = "Charge data";
$destination = "bulk_update";
include("header.php");
//session_start();
//$digit = 4;
//$randms = str_pad(rand(0, pow(10, $digit) - 1), 7, '0', STR_PAD_LEFT);
// select branch for display
$branchs = selectAll('branch', ['int_id' => $_SESSION['int_id']]);

// tellers information
$tellersCondition = ['int_id' => $_SESSION['int_id']];
$tellers = selectAll("tellers", $tellersCondition);

// tellers information
$paymentsCondition = ['int_id' => $_SESSION['int_id']];
$paymentsType = selectAll("payment_type", $paymentsCondition);

// If it is successfull, It will show this message
if (isset($_GET["message1"])) {
    $key = $_GET["message1"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        // $out = $_SESSION["lack_of_intfund_$key"];
        echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Transaction Successful",
          text: "Transaction Successful",
          showConfirmButton: false,
          timer: 60000
      })
  });
  </script>
  ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} // if not successful due to missing database check
else if (isset($_GET["message2"])) {
    $key = $_GET["message2"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        // $out = $_SESSION["lack_of_intfund_$key"];
        echo '<script type="text/javascript">
$(document).ready(function(){
    swal({
        type: "error",
        title: "Error",
        text: "Contact the Support Team With Error Code Bulk_001",
        showConfirmButton: false,
        timer: 60000
    })
});
</script>
';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} // if not successful due to file input
else if (isset($_GET["message3"])) {
    $key = $_GET["message3"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        // $out = $_SESSION["lack_of_intfund_$key"];
        echo '<script type="text/javascript">
$(document).ready(function(){
    swal({
        type: "error",
        title: "Error",
        text: "Sorry Only Excel file with .xls .csv or .xlsx file allowed",
        showConfirmButton: false,
        timer: 60000
    })
});
</script>
';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} // Sent for Approval
else if (isset($_GET["message4"])) {
    $key = $_GET["message4"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        // $out = $_SESSION["lack_of_intfund_$key"];
        echo '<script type="text/javascript">
$(document).ready(function(){
    swal({
        type: "success",
        title: "Sent For Approval",
        text: "Some Transactions have been Sent for Approval",
        showConfirmButton: false,
        timer: 60000
    })
});
</script>
';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} // Teller Can not Preform this Action
else if (isset($_GET["message5"])) {
    $key = $_GET["message5"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        // $out = $_SESSION["lack_of_intfund_$key"];
        echo '<script type="text/javascript">
$(document).ready(function(){
    swal({
        type: "success",
        title: "Wrong Teller Information",
        text: "Sorry this Teller Can not Preform this Action",
        showConfirmButton: false,
        timer: 60000
    })
});
</script>
';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} // failed to remove header from a file
else if (isset($_GET["message6"])) {
    $key = $_GET["message6"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        // $out = $_SESSION["lack_of_intfund_$key"];
        echo '<script type="text/javascript">
$(document).ready(function(){
    swal({
        type: "success",
        title: "Failed To remove header",
        text: "Sorry Please remove the header from this file",
        showConfirmButton: false,
        timer: 60000
    })
});
</script>
';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} // failed to remove header from a file
else if (isset($_GET["message7"])) {
    $key = $_GET["message7"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        // $out = $_SESSION["lack_of_intfund_$key"];
        echo '<script type="text/javascript">
$(document).ready(function(){
    swal({
        type: "success",
        title: "Failed To Add Payment type",
        text: "Sorry Please add payment type id on the file",
        showConfirmButton: false,
        timer: 60000
    })
});
</script>
';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
}
// transaction type not removed
else if (isset($_GET["message8"])) {
    $key = $_GET["message8"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        // $out = $_SESSION["lack_of_intfund_$key"];
        echo '<script type="text/javascript">
$(document).ready(function(){
    swal({
        type: "error",
        title: "Failed To Add Transaction type",
        text: "Sorry Please add transaction type id on the file",
        showConfirmButton: false,
        timer: 60000
    })
});
</script>
';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
}
// transaction deposit error
else if (isset($_GET["message9"])) {
    $key = $_GET["message9"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        // $out = $_SESSION["lack_of_intfund_$key"];
        echo '<script type="text/javascript">
$(document).ready(function(){
    swal({
        type: "error",
        title: "Wrong Transaction with file",
        text: "Sorry Use only withdrawal file when transaction type is 2",
        showConfirmButton: false,
        timer: 60000
    })
});
</script>
';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
}
// transaction deposit error
else if (isset($_GET["message10"])) {
    $key = $_GET["message10"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        // $out = $_SESSION["lack_of_intfund_$key"];
        echo '<script type="text/javascript">
$(document).ready(function(){
    swal({
        type: "error",
        title: "Wrong Transaction with file",
        text: "Sorry Use only deposit file when transaction type is 1",
        showConfirmButton: false,
        timer: 60000
    })
});
</script>
';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
}
?>


<div class="content">
    <div class="container-fluid">
        <!-- your content here -->
        <!-- Begining of Charge Row !-->

        <div class="row">

            <div class="col-md-12">

                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Bulk Deposit</h4>
                        <p class="category">Make Bulk Deposit in different Branches </p>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <!-- SELECT TELLER TABLE BEGINS -->
                            <div class="col-md-6">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h4 class="card-title text-center">Select Teller </h4>

                                    </div>


                                    <div class="card-body" id="tellerInfo">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class=" text-primary">
                                                <th>ID</th>
                                                <th>Teller Branch</th>
                                                <th>Teller Description</th>
                                                <th>Teller ID</th>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($tellers as $key => $teller) { ?>
                                                    <tr>
                                                        <td><?php echo $key + 1 ?></td>
                                                        <?php
                                                        $branchName = selectOne('branch', ['id' => $teller['branch_id']])
                                                        ?>
                                                        <td><?php echo $branchName['name'] ?></td>
                                                        <td><?php echo $teller['description'] ?></td>
                                                        <td><?php echo $teller['id'] ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- SELECT Payment type TABLE BEGINS -->
                            <div class="col-md-6">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h4 class="card-title text-center">Select Payment Type</h4>

                                    </div>
                                    <div class="card-body" id="tellerInfo">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class=" text-primary">
                                                <th>ID</th>
                                                <th>Payment Description</th>
                                                <th>Payment ID</th>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($paymentsType as $key => $type) { ?>
                                                    <tr>
                                                        <td><?php echo $key + 1 ?></td>
                                                        <td><?php echo $type['value'] ?></td>
                                                        <td><?php echo $type['id'] ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- SELECT TELLER TABLE ENDS -->
                            <div class="col-md-6">
                                <form action="./bulkWork/deposit.php" method="post" enctype="multipart/form-data">

                                    <!-- SELECT BRANCH CARD BEGINS -->
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Select Branch</label>
                                                <select class="form-control selectpicker" required name="branch"
                                                        data-style="btn btn-link"
                                                        id="branchId">
                                                    <option value="">Select A Branch</option>
                                                    <?php foreach ($branchs as $branch) { ?>
                                                        <option value="<?php echo $branch['id'] ?>"
                                                        ><?php echo $branch['name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- SELECT BRANCH CARD ENDS -->
                                    <!-- Transaction Type-->
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="">Type</label>
                                                <select class="form-control" name="transaction" required>
                                                    <option value="">select an option</option>
                                                    <option value="1">Deposit</option>
                                                    <option value="2">Withdraw</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Transaction Type End-->

                                    <!-- UPLOAD SECTION BEGINS -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Upload Excel File</h4>
                                            <p class="category"></p>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="input-group">
                                                    <input type="file" name="excelFile"
                                                           class="form-control inputFileVisible"
                                                           placeholder="Single File" required>
                                                    <span class="input-group-btn">
                                                    <button type="submit" name="submit"
                                                            class="btn btn-fab btn-round btn-primary">
                                                        <i class="material-icons">send</i>
                                                    </button>
                                                </span>
                                                </div>
                                            </div>
                                            <!-- UPLOAD SECTION ENDS -->

                                        </div>

                                    </div>
                                </form>
                            </div>

                            <!-- REQUIREMENTS SAMPLE COLUMN BEGINS -->

                            <div class="col-md-6">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h4 class="card-title"><i class="material-icons">info</i> Requirements </h4>

                                    </div>
                                    <div class="card-body">
                                        <ul>
                                            <li>Files must be in <b>Excel Format</b></li>
                                            <li>Excel files should contain all the columns as stated on the Data
                                                Sample
                                            </li>
                                            <li>The order of the columns should be the same as stated on the Data Sample
                                                with the first rows as header
                                            </li>
                                            <li>You can upload a maximum of 120 rows in 1 file. If you have more rows,
                                                please split them into multiple files.
                                            </li>
                                            <li>
                                                <STRONG style="color: red">
                                                    IMPORTANT: FOR DEPOSIT TRANSACTION USE 1 AND FOR WITHDRAWAL USE 2
                                                    ON THE FIELD CALL TRANSACTION TYPE
                                                </STRONG>
                                            </li>
                                            <li>
                                                <STRONG style="color: red">
                                                    IMPORTANT: Before upLoading your excel file please always remember
                                                    to remove
                                                    the default table header (i.e row 1) completely.
                                                </STRONG>
                                            </li>
                                        </ul>
                                        <div class="card-body text-center">
                                            <a href='bulkWork/getFile.php?name=bulk_deposit1&loc=1'
                                               class="btn btn-primary btn-lg">Download Deposit Data Sample</a>
                                            <a href='bulkWork/getFile.php?name=bulk_withdraw&loc=1'
                                               class="btn btn-success btn-lg">Download Withdrawal Data Sample</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- REQUIREMENTS SAMPLE COLUMN BEGINS -->
                        </div>
                    </div>


                </div>


            </div>
        </div>

    </div>
</div>