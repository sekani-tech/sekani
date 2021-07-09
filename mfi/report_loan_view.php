<?php

$page_title = "Loan Report";
$destination = "report_loan.php";
include("header.php");
$getBranch = selectAll('branch', ['int_id' => $_SESSION['int_id']]);

if (isset($_GET["message1"])) {
    $key = $_GET["message1"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        // $out = $_SESSION["lack_of_intfund_$key"];
        echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "No Date Selected",
          text: "Please select Start and End Date ",
          showConfirmButton: false,
          timer: 60000
      })
  });
  </script>
  ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
}
if (isset($_GET["view15"])) { ?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Disbursed Loan Accounts</h4>
                            <!-- <p class="card-category">
                                <?php
                                $query = "SELECT * FROM loan WHERE int_id = '$sessint_id'";
                                // $query = "SELECT * FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved'";
                                $result = mysqli_query($connection, $query);
                                if ($result) {
                                    $inr = mysqli_num_rows($result);
                                    echo $inr;
                                    $date = date("F");
                                } ?> Disbursed Loans
                            </p> -->
                        </div>
                        <div class="card-body">
                            <form method="POST" action="">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Start Date</label>
                                            <input type="date" value="" id="start" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">End Date</label>
                                            <input type="date" value="" id="end" class="form-control">
                                            <input type="text" id="int_id" hidden name="" value="<?php echo $sessint_id; ?>" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="bmd-label-floating">Branch</label>
                                        <select id="branch_id" class="form-control">
                                            <?php foreach ($getBranch as $branch) { ?>
                                                <option value="<?php echo $branch['id'] ?>"><?php echo $branch['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <button type="button" class="btn btn-success" id="generateDLAR">Run Report</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div id="showDisbursedLoans" class="row">
                
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            $('#generateDLAR').on("click", function() {
                var start = $('#start').val();
                var end = $('#end').val();
                var branch_id = $('#branch_id').val();

                $.ajax({
                    url: "ajax_post/disbursedloan.php",
                    method: "POST",
                    data: {
                        start: start,
                        end: end,
                        branch_id: branch_id
                    },
                    success: function(data) {
                        $('#showDisbursedLoans').html(data);
                    }
                })
            });
        });
    </script>
<?php
} else if (isset($_GET["view16"])) {
?>
    <!-- Content added here  -->
    <div class="content">
        <div class="container-fluid">
            <!-- your content here  -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Outstanding Loans Balance Report</h4>
                            <p class="card-category">
                                <?php
                                $query = "SELECT * FROM loan WHERE int_id = '$sessint_id' AND (total_outstanding_derived <> 0)";
                                $result = mysqli_query($connection, $query);
                                if ($result) {
                                    $inr = mysqli_num_rows($result);
                                    echo $inr;
                                }
                                ?> Outstanding Loans
                            </p>
                        </div>
                        <div class="card-body">
                            
                            <div class="card card-profile ml-auto mr-auto" style="max-width: 370px; max-height: 360px">
                                <div class="card-body ">
                                    <?php
                                        $accountquery = "SELECT SUM(total_outstanding_derived) AS total_outstanding_derived FROM `loan` WHERE int_id = '$sessint_id'";
                                        $result = mysqli_query($connection, $accountquery);
                                        $totalOutstandingLoans = mysqli_fetch_array($result)['total_outstanding_derived']
                                    ?>
                                    <h4 class="card-title">Total Outstanding Loans: <b>&#8358;<?php echo number_format(round($totalOutstandingLoans), 2); ?></b></h4>
                                    <!-- <h6 class="card-category text-gray">Head Office</h6> -->
                                </div>
                            </div>

                            <div class="table-responsive">
<<<<<<< HEAD
                                <table id="outstand" class="table table-striped table-bordered" style="width:100%">
=======
                                <table id="outstand" class="rtable display nowrap" style="width:100%">
>>>>>>> Victor
                                    <thead class="text-primary">
                                        <?php
                                        $query = "SELECT * FROM loan WHERE int_id = '$sessint_id' AND (total_outstanding_derived <> 0)";
                                        $result = mysqli_query($connection, $query);
                                        ?>
                                        <th>
<<<<<<< HEAD
                                            <small>Client Name</small> 
                                        </th>
                                        <th>
                                        <small>Account No</small> 
                                        </th>
                                        <th>
                                        <small>Principal Amount</small> 
                                        </th>
                                        <th>
                                        <small>Disbursement Date</small> 
                                        </th>
                                        <th>
                                        <small>Maturity Date</small>
                                        </th>
                                        <th>
                                        <small>Outstanding Balances</small>
=======
                                            Client Name
                                        </th>
                                        <th>
                                            Account No
                                        </th>
                                        <th>
                                            Principal Amount
                                        </th>
                                        <th>
                                            Disbursement Date
                                        </th>
                                        <th>
                                            Maturity Date
                                        </th>
                                        <th>
                                            Outstanding Balances
>>>>>>> Victor
                                        </th>
                                        <th>
                                            
                                        </th>
                                    </thead>
                                    <tbody>
                                        <?php if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                        ?>
                                                <tr>
                                                    <?php 
                                                    $loan_id =  $row["id"];
                                                    $name = $row['client_id'];
                                                    $anam = mysqli_query($connection, "SELECT firstname, lastname FROM client WHERE id = '$name'");
                                                    $f = mysqli_fetch_array($anam);
                                                    $nae = strtoupper($f["firstname"] . " " . $f["lastname"]);
                                                    ?>
                                                    <th>
                                                        <?php echo $nae; ?>
                                                    </th>
                                                    <th>
                                                        <?php echo $row["account_no"]; ?>
                                                    </th>
                                                    <th>
                                                        <?php echo $row["principal_amount"]; ?>
                                                    </th>
                                                    <th>
                                                        <?php echo $row["disbursement_date"]; ?>
                                                    </th>
                                                    <th>
                                                        <?php echo $row["repayment_date"]; ?>
                                                    </th>
                                                    <?php
                                                    // repayment
                                                    // $dd = "SELECT SUM(interest_amount) AS interest_amount FROM loan_repayment_schedule WHERE installment >= '1' AND int_id = '$sessint_id' AND loan_id = '$loan_id'";
                                                    // $sdoi = mysqli_query($connection, $dd);
                                                    // $e = mysqli_fetch_array($sdoi);
                                                    // $interest = $e['interest_amount'];

                                                    // $dfdf = "SELECT SUM(principal_amount) AS principal_amount FROM loan_repayment_schedule WHERE installment >= '1' AND int_id = '$sessint_id' AND loan_id = '$loan_id'";
                                                    // $sdswe = mysqli_query($connection, $dfdf);
                                                    // $u = mysqli_fetch_array($sdswe);
                                                    // $prin = $u['principal_amount'];

                                                    // $outstanding = $prin + $interest;
                                                    // Arrears
                                                    // $ldfkl = "SELECT SUM(interest_amount) AS interest_amount FROM loan_arrear WHERE installment >= '1' AND int_id = '$sessint_id' AND loan_id = '$loan_id'";
                                                    // $fosdi = mysqli_query($connection, $ldfkl);
                                                    // $l = mysqli_fetch_array($fosdi);
                                                    // $interesttwo = $l['interest_amount'];

                                                    // $sdospd = "SELECT SUM(principal_amount) AS principal_amount FROM loan_arrear WHERE installment >= '1' AND int_id = '$sessint_id' AND loan_id = '$loan_id'";
                                                    // $sodi = mysqli_query($connection, $sdospd);
                                                    // $s = mysqli_fetch_array($sodi);
                                                    // $printwo = $s['principal_amount'];

                                                    // $outstandingtwo = $printwo + $interesttwo;
                                                    ?>
                                                    <th>
                                                        <?php
                                                        // $bal = $row["total_outstanding_derived"];
                                                        // $df = $bal;
                                                        // $ttloutstanding = $outstanding + $outstandingtwo;
                                                        // $ttloutbalance = 0;
                                                        // $ttloutbalance += $total_outstanding_bal;
                                                        $query_outstanding = mysqli_query($connection, "SELECT total_outstanding_derived FROM `loan` WHERE int_id = '$sessint_id' AND id = '$loan_id'");
                                                        $desx = mysqli_fetch_array($query_outstanding);
                                                        $outstanding_balance = $desx['total_outstanding_derived'];
                                                        
                                                        echo number_format(round($outstanding_balance), 2);
                                                        ?>
                                                    </th>
                                                    <th><a href="loan_report_view.php?edit=<?php echo $row["id"]; ?>" class="btn btn-info">View</a></th>
                                                </tr>
                                        <?php }
                                        } else {
                                            // echo "0 Document";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    $('#outstand').DataTable();
                                });
                            </script>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mt-4">
                                        <form method="POST" action="../composer/outstanding_loan_balance.php">
                                            <button type="submit" name="downloadPDF" class="btn btn-primary">Download PDF</button>
                                            <button type="submit" name="downloadExcel" class="btn btn-primary">Download Excel</button>
                                        </form>
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
} // Loan Analysis Report
else if (isset($_GET["view17"])) {
?>
    <div class="content">
        <div class="container-fluid">
            <!-- your content here  -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Loan Analysis Report</h4>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="">Start Date</label>
                                        <input type="date" name="" id="start" class="form-control">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="">End Date</label>
                                        <input type="date" name="" id="end" class="form-control">
                                    </div>
                                    <?php
                                    function fill_branch($connection)
                                    {
                                        $sint_id = $_SESSION["int_id"];
                                        $org = "SELECT * FROM branch WHERE int_id = '$sint_id'";
                                        $res = mysqli_query($connection, $org);
                                        $out = '';
                                        while ($row = mysqli_fetch_array($res)) {
                                            $out .= '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
                                        }
                                        return $out;
                                    }
                                    ?>
                                    <div class="form-group col-md-3">
                                        <label for="">Branch</label>
                                        <select name="" id="branch" class="form-control">
                                            <?php echo fill_branch($connection); ?>
                                        </select>
                                    </div>
                                </div>
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <span id="runanalysis" class="btn btn-primary">Run report</span>
                            </form>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('#runanalysis').on("click", function() {
                                var start = $('#start').val();
                                var end = $('#end').val();
                                var hide = $('#hide').val();
                                var branch_id = $('#branch').val();
                                $.ajax({
                                    url: "items/analysis.php",
                                    method: "POST",
                                    data: {
                                        start: start,
                                        end: end,
                                        hide: hide,
                                        branch_id: branch_id
                                    },
                                    success: function(data) {
                                        $('#shanalysis').html(data);
                                    }
                                })
                            });
                        });
                    </script>
                    <div id="shanalysis">

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php

} //    Loan classification Report
else if (isset($_GET["view18"])) {
?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Loan Classification Report</h4>
                        </div>
                        <div class="card-body">
                            <form action="">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="">Date</label>
                                        <input type="date" name="" id="picked_date" class="form-control">
                                    </div>
                                    <?php
                                    function fill_branch($connection)
                                    {
                                        $sint_id = $_SESSION["int_id"];
                                        $org = "SELECT * FROM branch WHERE int_id = '$sint_id'";
                                        $res = mysqli_query($connection, $org);
                                        $out = '';
                                        while ($row = mysqli_fetch_array($res)) {
                                            $out .= '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
                                        }
                                        return $out;
                                    }
                                    ?>
                                    <div class="form-group col-md-3">
                                        <label for="">Branch</label>
                                        <select name="" id="branch_id" class="form-control">
                                            <?php echo fill_branch($connection); ?>
                                        </select>
                                    </div>
                                </div>
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <span id="runclass" type="submit" class="btn btn-primary">Run report</span>
                            </form>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('#runclass').on("click", function() {
                                var picked_date = $('#picked_date').val();
                                var branch_id = $('#branch_id').val();
                                $.ajax({
                                    url: "items/loan_class.php",
                                    method: "POST",
                                    data: {
                                        picked_date: picked_date,
                                        branch_id: branch_id
                                    },
                                    success: function(data) {
                                        $('#shclass').html(data);
                                    }
                                })
                            });
                        });
                    </script>
                </div>
                <div class="col-12">
                    <div id="shclass">

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
} //Loan Collateral Schedule
else if (isset($_GET["view19"])) {
?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Generate Loan Collateral's Schedule</h4>
                            <!-- <p class="card-category">
                                    Disbursed Loans
                            </p> -->
                        </div>
                        <div class="card-body">
                            <form method="POST" action="">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Start Date</label>
                                            <input type="date" value="" name="start" class="form-control" id="start">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">End Date</label>
                                            <input type="date" value="" name="end" class="form-control" id="end">
                                            <input type="text" id="int_id" hidden name="" value="<?php echo $sessint_id; ?>" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                        function fill_branch($connection)
                                        {
                                            $sint_id = $_SESSION["int_id"];
                                            $org = "SELECT * FROM branch WHERE int_id = '$sint_id'";
                                            $res = mysqli_query($connection, $org);
                                            $out = '';
                                            while ($row = mysqli_fetch_array($res)) {
                                                $out .= '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
                                            }
                                            return $out;
                                        }
                                        ?>
                                        <label class="bmd-label-floating">Branch</label>
                                        <select name="branch_id" id="branch_id" class="form-control">
                                            <?php echo fill_branch($connection); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="showDisbursedLoan">
                                    </div>
                                </div>
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <input type="button" class="btn btn-success" id="generateLCS" value="Run Report" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    $('#generateLCS').on("click", function() {
                        var start = $('#start').val();
                        var end = $('#end').val();
                        var branch_id = $('#branch_id').val();
                        $.ajax({
                            url: "ajax_post/loan_collateral.php",
                            method: "POST",
                            data: {
                                start: start,
                                end: end,
                                branch_id: branch_id
                            },
                            success: function(data) {
                                $('#LCSReport').html(data);
                            }
                        })
                    });
                });
            </script>

            <div class="row" id="LCSReport">

            </div>

        </div>
    </div>
<?php
} else if (isset($_GET["view20"])) {
?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Generate Matured Loan Report</h4>
                            <!-- <p class="card-category">
                                 Disbursed Loans
                            </p> -->
                        </div>
                        <div class="card-body">
                            <form method="POST" action="">
                                <div class="row">
                                    <?php
                                    function fill_branch($connection)
                                    {
                                        $sint_id = $_SESSION["int_id"];
                                        $org = "SELECT * FROM branch WHERE int_id = '$sint_id'";
                                        $res = mysqli_query($connection, $org);
                                        $out = '';
                                        while ($row = mysqli_fetch_array($res)) {
                                            $out .= '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
                                        }
                                        return $out;
                                    }
                                    ?>
                                    <div class="col-md-4">
                                        <label class="bmd-label-floating">Branch</label>
                                        <select name="branch_id" id="branch_id" class="form-control">
                                            <?php echo fill_branch($connection); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-3">
                                        <button type="reset" class="btn btn-danger">Reset</button>
                                        <input type="button" class="btn btn-success" id="generateMLR" value="Run Report" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    $('#generateMLR').on("click", function() {
                        var branch_id = $('#branch_id').val();
                        $.ajax({
                            url: "ajax_post/loan_maturity.php",
                            method: "POST",
                            data: {
                                branch_id: branch_id
                            },
                            success: function(data) {
                                $('#MLReport').html(data);
                            }
                        })
                    });
                });
            </script>

            <div class="row" id="MLReport">

            </div>
        </div>
    </div>
<?php
} else if (isset($_GET["view21"])) {
?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Loan Performance Report</h4>
                        </div>
                        <div class="card-body">
                            <form action="">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="">Start Date</label>
                                        <input type="date" name="" id="" class="form-control">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="">End Date</label>
                                        <input type="date" name="" id="" class="form-control">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="">Branch</label>
                                        <select name="" id="" class="form-control">
                                            <option value="">Head Office</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="">Break Down per Branch</label>
                                        <select name="" id="" class="form-control">
                                            <option value="">No</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="">Hide Zero Balances</label>
                                        <select name="" id="" class="form-control">
                                            <option value="">No</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <span id="runperform" type="submit" class="btn btn-primary">Run report</span>
                            </form>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('#runperform').on("click", function() {
                                var start = $('#start').val();
                                var end = $('#end').val();
                                var branch = $('#input').val();
                                var teller = $('#till').val();
                                var int_id = $('#int_id').val();
                                $.ajax({
                                    url: "items/perform.php",
                                    method: "POST",
                                    data: {
                                        start: start,
                                        end: end,
                                        branch: branch,
                                        teller: teller,
                                        int_id: int_id
                                    },
                                    success: function(data) {
                                        $('#shperform').html(data);
                                    }
                                })
                            });
                        });
                    </script>
                    <div id="shperform" class="card">

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
} else if (isset($_GET["view23"])) {
?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Loan Structure Report</h4>
                        </div>
                        <div class="card-body">
                            <form action="">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="">Start Date</label>
                                        <input type="date" name="start" id="start" class="form-control">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="">End Date</label>
                                        <input type="date" name="end" id="end" class="form-control">
                                    </div>
                                    <?php
                                    function fill_branch($connection)
                                    {
                                        $sint_id = $_SESSION["int_id"];
                                        $org = "SELECT * FROM branch WHERE int_id = '$sint_id'";
                                        $res = mysqli_query($connection, $org);
                                        $out = '';
                                        while ($row = mysqli_fetch_array($res)) {
                                            $out .= '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
                                        }
                                        return $out;
                                    }
                                    ?>
                                    <div class="form-group col-md-3">
                                        <label for="">Branch</label>
                                        <select name="branch_id" id="branch_id" class="form-control">
                                            <?php echo fill_branch($connection); ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="">Hide Zero Balances</label>
                                        <select name="zerobalances_hide" id="zerobalances_hide" class="form-control">
                                            <option value="no">No</option>
                                            <option value="yes">Yes</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <span id="runstructure" type="submit" class="btn btn-success">Run report</span>
                            </form>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('#runstructure').on("click", function() {
                                var start = $('#start').val();
                                var end = $('#end').val();
                                var branch_id = $('#branch_id').val();
                                var zerobalances_hide = $('#zerobalances_hide').val();
                                
                                $.ajax({
                                    url: "items/perform.php",
                                    method: "POST",
                                    data: {
                                        start: start,
                                        end: end,
                                        branch_id: branch_id,
                                        zerobalances_hide: zerobalances_hide
                                    },
                                    success: function(data) {
                                        $('#shstructure').html(data);
                                    }
                                })
                            });
                        });
                    </script>
                    <div id="shstructure" class="row">

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
} else if (isset($_GET["view39"])) {
    $main_date = date('Y-m-d');
?>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Expected Loan Repayment</h4>
                            <p class="card-category">
                                <?php
                                $query = "SELECT * FROM loan_repayment_schedule WHERE int_id = '$sessint_id' AND duedate = '$main_date' AND completed_derived = '0'";
                                $result = mysqli_query($connection, $query);
                                $inr = mysqli_num_rows($result);
                                echo $inr . " loans expected to be repayed today";
                                ?>
                            </p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="ple" class="rtable display nowrap" style="width:100%">
                                    <thead class="text-primary">
                                        <?php
                                        $query = "SELECT * FROM loan_repayment_schedule WHERE int_id = '$sessint_id' AND duedate = '$main_date' AND completed_derived = '0'";
                                        $result = mysqli_query($connection, $query);
                                        ?>
                                        <th>
                                            Client Name
                                        </th>
                                        <th>
                                            Principal Due
                                        </th>
                                        <th>
                                            Interest Due
                                        </th>
                                        <th>
                                            Loan Term
                                        </th>
                                        <th>
                                            Disbursement Date
                                        </th>
                                        <th>
                                            Outstanding Balance
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
                                                <tr>
                                                    <?php
                                                    $std = date("Y-m-d");
                                                    $row["id"];
                                                    $loan_id = $row["loan_id"];
                                                    $install = $row["installment"];
                                                    if ($install == 0) {
                                                        $install = "Paid";
                                                    } else {
                                                        $install = "Pending";
                                                    }
                                                    $name = $row['client_id'];
                                                    $anam = mysqli_query($connection, "SELECT firstname, lastname FROM client WHERE id = '$name'");
                                                    $f = mysqli_fetch_array($anam);
                                                    $nae = strtoupper($f["firstname"] . " " . $f["lastname"]);
                                                    ?>
                                                    <th><?php echo $nae; ?></th>
                                                    <?php
                                                    $get_loan = mysqli_query($connection, "SELECT loan_term, total_outstanding_derived FROM loan WHERE id = '$loan_id' AND int_id = '$sessint_id'");
                                                    $mik = mysqli_fetch_array($get_loan);
                                                    $loan_term = $mik["loan_term"];
                                                    $t_o = $mik['total_outstanding_derived'];
                                                    ?>
                                                    <th>NGN <?php echo number_format($row["principal_amount"], 2); ?></th>
                                                    <th>NGN <?php echo number_format($row["interest_amount"], 2); ?></th>
                                                    <th><?php echo $loan_term; ?></th>
                                                    <th><?php echo $row["fromdate"]; ?></th>
                                                    <th>NGN <?php echo number_format($t_o, 2); ?></th>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>

                                <script>
                                    $(document).ready(function() {
                                        $('#ple').DataTable();
                                    });
                                </script>
                            </div>

                            <div class="form-group mt-4">
                                <form method="POST" action="../composer/exp_loan_repay.php">
                                    <input hidden name="id" type="text" value="<?php echo $id; ?>" />
                                    <input hidden name="start" type="text" value="<?php echo $start; ?>" />
                                    <input hidden name="end" type="text" value="<?php echo $main_date; ?>" />
                                    <button type="submit" id="disbursed" class="btn btn-primary pull-left">Download PDF</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
} else if (isset($_GET["view39b"])) {
    $main_date = $_GET["view39b"];
?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Expected Loan Repayment</h4>
                            <p class="card-category">
                                <?php
                                $currentdate = date('Y-m-d');
                                $time = strtotime($currentdate);
                                $yomf = date("Y-m-d", strtotime("+1 day", $time));
                                $query = "SELECT * FROM loan_repayment_schedule WHERE int_id = '$sessint_id' AND repayment_date = '$yomf'";
                                $result = mysqli_query($connection, $query);
                                if ($result) {
                                    $inr = mysqli_num_rows($result);
                                    echo $inr;
                                } ?> loans expected to be repayed tomorrow
                            </p>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <form method="POST" action="../composer/exp_loan_repay.php">
                                    <input hidden name="id" type="text" value="<?php echo $id; ?>" />
                                    <input hidden name="start" type="text" value="<?php echo $start; ?>" />
                                    <input hidden name="end" type="text" value="<?php echo $yomf; ?>" />
                                    <button type="submit" id="disbursed" class="btn btn-primary pull-left">Download PDF</button>
                                    <script>
                                        $(document).ready(function() {
                                            $('#disbursed').on("click", function() {
                                                swal({
                                                    type: "success",
                                                    title: "DISBURSED LOAN REPORT",
                                                    text: "Printing Successful",
                                                    showConfirmButton: false,
                                                    timer: 3000
                                                })
                                            });
                                        });
                                    </script>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="rtable display nowrap" style="width:100%">
                                    <thead class=" text-primary">
                                        <?php
                                        $query = "SELECT * FROM loan_repayment_schedule WHERE int_id = '$sessint_id' AND duedate = '$main_date'";
                                        $result = mysqli_query($connection, $query);
                                        ?>
                                        <th>
                                            Client Name
                                        </th>
                                        <th>
                                            Principal Due
                                        </th>
                                        <th>
                                            Interest Due
                                        </th>
                                        <th>
                                            Loan Term
                                        </th>
                                        <th>
                                            Disbursement Date
                                        </th>
                                        <th>
                                            Outstanding Loan Balance
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                    </thead>
                                    <tbody>
                                        <?php if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
                                                <tr>
                                                    <?php $std = date("Y-m-d");
                                                    ?>
                                                    <?php $row["id"];
                                                    $loan_id = $row["loan_id"];
                                                    $install = $row["installment"];
                                                    if ($install == 0) {
                                                        $install = "Paid";
                                                    } else {
                                                        $install = "Pending";
                                                    }
                                                    ?>
                                                    <?php
                                                    $name = $row['client_id'];
                                                    $anam = mysqli_query($connection, "SELECT firstname, lastname FROM client WHERE id = '$name'");
                                                    $f = mysqli_fetch_array($anam);
                                                    $nae = strtoupper($f["firstname"] . " " . $f["lastname"]);
                                                    ?>
                                                    <th><?php echo $nae; ?></th>
                                                    <?php
                                                    $get_loan = mysqli_query($connection, "SELECT loan_term, total_outstanding_derived FROM loan WHERE id = '$loan_id' AND int_id = '$sessint_id'");
                                                    $mik = mysqli_fetch_array($get_loan);
                                                    $loan_term = $mik["loan_term"];
                                                    $t_o = $mik["total_outstanding_derived"];
                                                    ?>
                                                    <th>NGN <?php echo number_format($row["principal_amount"], 2); ?></th>
                                                    <th>NGN <?php echo number_format($row["interest_amount"], 2); ?></th>
                                                    <th><?php echo $loan_term; ?></th>
                                                    <th><?php echo $row["fromdate"]; ?></th>
                                                    <th>NGN <?php echo number_format($t_o, 2); ?></th>
                                                    <?php

                                                    ?>
                                                </tr>
                                        <?php }
                                        } else {
                                            // echo "0 Document";
                                        }
                                        ?>
                                        <th></th>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
} else if (isset($_GET["view40"])) {

?>

    <div class="content">

        <div class="container-fluid">
        
            <div class="row">

                <div class="col-12">

                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Loan Portfolio Activity</h4>
                            <!-- <p class="category">Loan Portfolio over a period of time</p> -->
                        </div>

                        <div class="card-body">

                            <form method="POST" action="">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Date</label>
                                            <input type="date" value="" class="form-control" name="date" id="date">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                        function fill_branch($connection)
                                        {
                                            $sint_id = $_SESSION["int_id"];
                                            $org = "SELECT * FROM branch WHERE int_id = '$sint_id'";
                                            $res = mysqli_query($connection, $org);
                                            $out = '';
                                            while ($row = mysqli_fetch_array($res)) {
                                                $out .= '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
                                            }
                                            return $out;
                                        }
                                        ?>
                                        <label class="bmd-label-floating">Branch</label>
                                        <select class="form-control" name="branch_id" id="branch_id">
                                            <?php echo fill_branch($connection); ?>
                                        </select>
                                    </div>
                                </div>
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <button type="button" class="btn btn-success" id="runLPAR">Run Report</button>

                            </form>

                        </div>
                    </div>

                </div>

            </div>

            <div id="portfolio-area"></div>

        </div>

    </div>

    
    <script>
        $(document).ready(function() {
            $('#runLPAR').on("click", function() {
                var date = $('#date').val();
                var branch_id = $('#branch_id').val();

                $.ajax({
                    url: "ajax_post/portfolio.php",
                    method: "POST",
                    data: {
                        date: date,
                        branch_id: branch_id
                    },
                    success: function(data) {
                        $('#portfolio-area').html(data);
                    }
                })
            });
        });
    </script>

    </div>
    </div>

<?php
} else if (isset($_GET["view41"])) {

?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Loan Portfolio Aging Schedule</h4>
                            <!-- <p class="category">Category subtitle</p> -->
                        </div>
                        <div class="card-body">
                        

                            <form method="POST" action="">

                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Start Date</label>
                                            <input type="date" value="" name="start" class="form-control" id="start">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">End Date</label>
                                            <input type="date" value="" name="end" class="form-control" id="end">
                                            <input type="text" id="int_id" hidden="" name="" value="9" class="form-control" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="bmd-label-floating">Branch</label>
                                        <select name="branch_id" class="form-control">
                                            <option value="18">Head Office</option>
                                            <option value="19">Head Office Branch</option>
                                            <option value="20">IBADAN BRANCH</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <button type="submit" class="btn btn-success" name="generateDLAR">Run Report</button>
                            </form>


                        </div>
                    </div>
                </div>


            </div>

           

        </div>


    </div>
    </div>



<?php
} else if (isset($_GET["view45"])) {
?>
    <!-- if a customer's loan in arrears has a value of 0.00, it should no longer be displayed -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Loans in Arrears</h4>
                            <p class="card-category">
                                <?php
                                $query = "SELECT * FROM loan_arrear WHERE int_id = '$sessint_id' AND installment >= '1'";
                                $result = mysqli_query($connection, $query);
                                if ($result) {
                                    $inr = mysqli_num_rows($result);
                                    echo $inr;
                                } ?> loan(s) past due date</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="areas" class="rtable display nowrap" style="width:100%">
                                            <thead class="text-primary">
                                                <?php
                                                $query = "SELECT * FROM loan_arrear WHERE int_id = '$sessint_id' AND installment >= '1'";
                                                $result = mysqli_query($connection, $query);
                                                ?>
                                                <th>
                                                    Client Name
                                                </th>
                                                <th>
                                                    Principal Due
                                                </th>
                                                <th>
                                                    Interest Due
                                                </th>
                                                <th>
                                                    Days in Arrears
                                                </th>
                                                <th>
                                                    Loan Term
                                                </th>
                                                <th>
                                                    Maturity Date
                                                    <!-- the due date for a customer to make last repayment of a loan based on disbursement date and loan term values -->
                                                </th>
                                                <th>
                                                    Last Repayment Date
                                                    <!-- the date when a customer made his last repayment -->
                                                </th>
                                                <th>
                                                    Amount in Arrears
                                                </th>
                                            </thead>
                                            <tbody>
                                                <?php if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
                                                        <tr>
                                                            <?php 
                                                            $std = date("Y-m-d");
                                                            $loan_id = $row["loan_id"];
                                                            $name = $row['client_id'];
                                                            $anam = mysqli_query($connection, "SELECT firstname, lastname FROM client WHERE id = '$name'");
                                                            $f = mysqli_fetch_array($anam);
                                                            $nae = strtoupper($f["firstname"] . " " . $f["lastname"]);
                                                            ?>
                                                            <th><?php echo $nae; ?></th>

                                                            <?php
                                                            $get_loan = mysqli_query($connection, "SELECT loan_term, repay_every, maturedon_date, total_outstanding_derived FROM loan WHERE id = '$loan_id' AND int_id = '$sessint_id'");
                                                            $mik = mysqli_fetch_array($get_loan);
                                                            $loan_term = $mik["loan_term"];
                                                            $repay_every = $mik['repay_every'];
                                                            $maturity_date = $mik['maturedon_date'];
                                                            ?>
                                                            <th><?php echo number_format(round($row["principal_amount"]), 2); ?></th>
                                                            <th><?php echo number_format(round($row["interest_amount"]), 2); ?></th>
                                                            <th><?php echo $row["counter"]; ?></th>
                                                            <th><?php echo $loan_term . " " . $repay_every; ?></th>
                                                            <th><?php echo $maturity_date; ?></th>

                                                            <?php
                                                            $get_last_repay_date = mysqli_query($connection, "SELECT transaction_date FROM `loan_transaction` WHERE int_id = '$sessint_id' AND loan_id = '$loan_id' ORDER BY transaction_date DESC LIMIT 1");
                                                            if(mysqli_num_rows($get_last_repay_date) == 1) {
                                                                $last_repay_date = mysqli_fetch_array($get_last_repay_date)['transaction_date'];
                                                            } else {
                                                                $last_repay_date = 'NIL';
                                                            }
                                                            ?>
                                                            <th><?php echo $last_repay_date; ?></th>

                                                            <?php
                                                            $cli_id = $row["client_id"];
                                                            $sf = "SELECT * FROM loan WHERE int_id = '$sessint_id' AND id = '$loan_id' AND client_id = '$cli_id'";
                                                            $do = mysqli_query($connection, $sf);
                                                            while ($sd = mysqli_fetch_array($do)) {
                                                                $outbalance = $sd['total_outstanding_derived'];
                                                            }
                                                            ?>
                                                            <th><?php echo number_format(round($outbalance), 2); ?></th>

                                                            <?php

                                                            ?>
                                                        </tr>
                                                <?php }
                                                } else {
                                                    // echo "0 Document";
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                        <script>
                                            $(document).ready(function() {
                                                $('#areas').DataTable();
                                            });
                                        </script>
                                    </div>

                                    <div class="form-group mt-4">
                                        <form method="POST" action="../composer/arrear_report.php">
                                            <button type="submit" id="disbursed" class="btn btn-primary pull-left">Download PDF</button>
                                        </form>
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
}
?>