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
            <!-- your content here -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
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
                            ?>
                            <h4 class="card-title ">Disbursed Loans Accounts</h4>

                            <!-- Insert number users institutions -->
                            <p class="card-category">
                                <?php
                                $query = "SELECT * FROM loan WHERE int_id = '$sessint_id'";
                                // $query = "SELECT * FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved'";
                                $result = mysqli_query($connection, $query);
                                if ($result) {
                                    $inr = mysqli_num_rows($result);
                                    echo $inr;
                                    $date = date("F");
                                } ?> Disbursed Loans</p>
                        </div>
                        <div class="card-body">

                            <div class="card card-profile ml-auto mr-auto" style="max-width: 370px; max-height: 360px">
                                <div class="card-body ">
                                    <h4 class="card-title">Total Outstanding Loans: <b>NGN <?php echo number_format(round($fde), 2); ?></b></h4>
                                    <!-- <h6 class="card-category text-gray">Head Office</h6> -->
                                </div>
                                <!-- <div class="card-footer justify-content-center">
                                        <b> 9 Ndjamena Crescent Wuse II, Abuja </b>
                                    </div> -->
                                <!-- <div class="card-footer justify-content-center">
                                        Date: <b> 02-05-2021 </b>
                                    </div> -->
                            </div>

                            <form method="POST" action="../composer/disbursedloan.php">
                                <div class="row">
                                    <!--                                    Start Date Area-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Start Date</label>
                                            <input type="date" value="" name="start" class="form-control" id="start">
                                        </div>
                                    </div>
                                    <!--                                    End date area-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">End Date</label>
                                            <input type="date" value="" name="end" class="form-control" id="end">
                                            <input type="text" id="int_id" hidden name="" value="<?php echo $sessint_id; ?>" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <!--                                    Select Branch area-->
                                    <div class="col-md-4">
                                        <label class="bmd-label-floating">Branch Names <span style="color: red">*</span>:</label>
                                        <select name="group_id" class="form-control" id="group_id">
                                            <option value="">select an option</option>
                                            <?php foreach ($getBranch as $branch) { ?>
                                                <option value="<?php echo $branch['id'] ?>"><?php echo $branch['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="showDisbursedLoan">
                                        <!--                                        this shows the disburse table chosen by the client-->
                                    </div>
                                </div>
                                <button type="reset" class="btn btn-danger pull-right">Reset</button>
                                <button type="submit" id="runi" class="btn btn-primary pull-right">Download PDF</button>
                                <button type="submit" id="excel" class="btn btn-success pull-right">Run Report</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Disbured Loan Accounts Report</h4>
                            <!-- <p class="category">Category subtitle</p> -->
                        </div>
                        <div class="card-body">
                            <div class="table-resposive">
                                <table id="dloan" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th><small>Client Name</small></th>
                                            <th><small>Principal Amount</small></th>
                                            <th><small>Loan Term</small></th>
                                            <th><small>Disbursement Date</small></th>
                                            <th><small>Maturity Date</small></th>
                                            <th><small>Interest Rate</small></th>
                                            <th><small>Interest Amount</small></th>
                                            <th><small>Total Income</small></th>
                                            <th><small>Total Oustanding Bal</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>EMMANUEL OKAFOR</th>
                                            <th>₦100,000.00</th>
                                            <th>3</th>
                                            <th>2020-08-24</th>
                                            <th>2020-08-27</th>
                                            <th>₦3.00</th>
                                            <th>₦30,000.00</th>
                                            <th>₦9.00</th>
                                            <th>₦100,000.00</th>
                                        </tr>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th><small>Client Name</small></th>
                                            <th><small>Principal Amount</small></th>
                                            <th><small>Loan Term</small></th>
                                            <th><small>Disbursement Date</small></th>
                                            <th><small>Maturity Date</small></th>
                                            <th><small>Interest Rate</small></th>
                                            <th><small>Interest Amount</small></th>
                                            <th><small>Total Income</small></th>
                                            <th><small>Total Oustanding Bal</small></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>



                    </div>
                </div>



            </div>

        </div>

    </div>
    <script>
        $(document).ready(function() {
            $('#dloan').DataTable();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#group_id').change(function() {
                var group_id = $(this).val();
                var endDate = $('#end').val();
                var startDate = $('#start').val();
                var sint_id = $('#sint_id').val();
                $.ajax({
                    url: "ajax_post/reportTables/disburseloan.php",
                    method: "POST",
                    data: {
                        group_id: group_id,
                        endDate: endDate,
                        startDate: startDate,
                        sint_id: sint_id
                    },
                    success: function(data) {
                        $('#showDisbursedLoan').html(data);
                    }
                });
            })
        })
        $(document).ready(function() {
            $('#disbursed').on("click", function() {
                swal({
                    type: "success",
                    title: "Disbursed Loans Accounts",
                    text: "Printing Successful",
                    showConfirmButton: false,
                    timer: 3000

                })
            });
        });
    </script>
    </div>
<?php
} else if (isset($_GET["view16"])) {
?>
    <!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
            <!-- your content here -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Outstanding Loan Balance Report</h4>

                            <!-- Insert number users institutions -->
                            <p class="card-category"><?php
                                                        $query = "SELECT * FROM loan WHERE int_id = '$sessint_id'";
                                                        $result = mysqli_query($connection, $query);
                                                        if ($result) {
                                                            $inr = mysqli_num_rows($result);
                                                            echo $inr;
                                                        } ?> Loans</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <!--                    <table class="rtable display nowrap" style="width:100%">-->
                                <!--                      <thead class=" text-primary">-->
                                <!--                      --><?php
                                                                //                        $query = "SELECT * FROM loan WHERE int_id = '$sessint_id'";
                                                                //                        $result = mysqli_query($connection, $query);
                                                                //                      
                                                                ?>
                                <!--                        <th>-->
                                <!--                          Client Name-->
                                <!--                        </th>-->
                                <!--                        <th>-->
                                <!--                          Account No-->
                                <!--                        </th>-->
                                <!--                        <th>-->
                                <!--                          Principal Amount-->
                                <!--                        </th>-->
                                <!--                        <th>-->
                                <!--                          Disbursement Date-->
                                <!--                        </th>-->
                                <!--                        <th>-->
                                <!--                          Maturity Date-->
                                <!--                        </th>-->
                                <!--                        <th>-->
                                <!--                          Outstanding Loan Balances-->
                                <!--                        </th>-->
                                <!--                        <th>View</th>-->
                                <!--                      <tbody>-->
                                <!--                      --><?php //if (mysqli_num_rows($result) > 0) {
                                                                //                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                                                ?>
                                <!--                        <tr>-->
                                <!--                        --><?php //$fi =  $row["id"]; 
                                                                ?>
                                <!--                        --><?php //
                                                                //                            $name = $row['client_id'];
                                                                //                            $anam = mysqli_query($connection, "SELECT firstname, lastname FROM client WHERE id = '$name'");
                                                                //                            $f = mysqli_fetch_array($anam);
                                                                //                            $nae = strtoupper($f["firstname"]." ".$f["lastname"]);
                                                                //                        
                                                                ?>
                                <!--                          <th>--><?php //echo $nae; 
                                                                        ?>
                                <!--</th>-->
                                <!--                          <th>--><?php //echo $row["account_no"]; 
                                                                        ?>
                                <!--</th>-->
                                <!--                          <th>-->
                                <?php //echo $row["principal_amount"]; 
                                ?>
                                <!--</th>-->
                                <!--                          <th>-->
                                <?php //echo $row["disbursement_date"];
                                ?>
                                <!--</th>-->
                                <!--                          <th>--><?php //echo $row["repayment_date"];
                                                                        ?>
                                <!--</th>-->
                                <!--                          --><?php
                                                                    //                            // repaymeny
                                                                    //                              $dd = "SELECT SUM(interest_amount) AS interest_amount FROM loan_repayment_schedule WHERE installment >= '1' AND int_id = '$sessint_id' AND loan_id = '$fi'";
                                                                    //                              $sdoi = mysqli_query($connection, $dd);
                                                                    //                              $e = mysqli_fetch_array($sdoi);
                                                                    //                              $interest = $e['interest_amount'];
                                                                    //
                                                                    //                              $dfdf = "SELECT SUM(principal_amount) AS principal_amount FROM loan_repayment_schedule WHERE installment >= '1' AND int_id = '$sessint_id' AND loan_id = '$fi'";
                                                                    //                              $sdswe = mysqli_query($connection, $dfdf);
                                                                    //                              $u = mysqli_fetch_array($sdswe);
                                                                    //                              $prin = $u['principal_amount'];
                                                                    //
                                                                    //                              $outstanding = $prin + $interest;
                                                                    //                              // Arrears
                                                                    //                              $ldfkl = "SELECT SUM(interest_amount) AS interest_amount FROM loan_arrear WHERE installment >= '1' AND int_id = '$sessint_id' AND loan_id = '$fi'";
                                                                    //                              $fosdi = mysqli_query($connection, $ldfkl);
                                                                    //                              $l = mysqli_fetch_array($fosdi);
                                                                    //                              $interesttwo = $l['interest_amount'];
                                                                    //
                                                                    //                              $sdospd = "SELECT SUM(principal_amount) AS principal_amount FROM loan_arrear WHERE installment >= '1' AND int_id = '$sessint_id' AND loan_id = '$fi'";
                                                                    //                              $sodi = mysqli_query($connection, $sdospd);
                                                                    //                              $s = mysqli_fetch_array($sodi);
                                                                    //                              $printwo = $s['principal_amount'];
                                                                    //
                                                                    //                              $outstandingtwo = $printwo + $interesttwo;
                                                                    //                            
                                                                    ?>
                                <!--                          <th>--><?php //$bal = $row["total_outstanding_derived"];
                                                                        //                          $df = $bal;
                                                                        //                          $ttloutbalance = 0;
                                                                        //                          $ttloustanding = $outstanding + $outstandingtwo;
                                                                        //                           echo number_format($ttloustanding);
                                                                        //                           $ttloutbalance += $ttloustanding;
                                                                        //                            
                                                                        ?>
                                <!--</th>-->
                                <!--                          <td><a href="loan_report_view.php?edit=-->
                                <?php //echo $row["id"];
                                ?>
                                <!--" class="btn btn-info">View</a></td>-->
                                <!--                         </tr>-->
                                <!--                        --><?php //}
                                                                //                          }
                                                                //                          else {
                                                                //                            // echo "0 Document";
                                                                //                          }
                                                                //                          
                                                                ?>
                                <!--                          <!-- <th></th> -->-->
                                <!--                      </tbody>-->
                                <!--                    </table>-->
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
            <!-- your content here -->
            <div class="row">
                <div class="col-md-12">
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
                                var branch = $('#branch').val();
                                $.ajax({
                                    url: "items/analysis.php",
                                    method: "POST",
                                    data: {
                                        start: start,
                                        end: end,
                                        hide: hide,
                                        branch: branch
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
            <!-- your content here -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Loan Classification Report</h4>
                        </div>
                        <div class="card-body">
                            <form action="">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="">Start Date</label>
                                        <input type="date" name="" id="start" class="form-control">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="">End Date</label>
                                        <input type="date" name="" id="end" class="form-control">
                                    </div>
                                    <!-- <div class="form-group col-md-3">
                                      <label for="">Branch</label>
                                      <select name="" id="branch" class="form-control">
                                          <option value="">Head Office</option>
                                      </select>
                                    </div> -->
                                </div>
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <span id="runclass" type="submit" class="btn btn-primary">Run report</span>
                            </form>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('#runclass').on("click", function() {
                                var start = $('#start').val();
                                var end = $('#end').val();
                                $.ajax({
                                    url: "items/loan_class.php",
                                    method: "POST",
                                    data: {
                                        start: start,
                                        end: end
                                    },
                                    success: function(data) {
                                        $('#shclass').html(data);
                                    }
                                })
                            });
                        });
                    </script>
                    <div id="shclass" class="col-md-12">

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
} //Loan Collateral Schedule
else if (isset($_GET["view19"])) {
?>
    <!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
            <!-- your content here -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Loan Collateral's Schedule</h4>

                            <!-- Insert number users institutions -->
                            <p class="card-category"><?php
                                                        $query = "SELECT * FROM collateral WHERE int_id = '$sessint_id'";
                                                        $result = mysqli_query($connection, $query);
                                                        if ($result) {
                                                            $inr = mysqli_num_rows($result);
                                                            echo $inr;
                                                        } ?> Collaterals </p>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <form method="POST" action="../composer/loan_collateral.php">
                                    <input hidden name="id" type="text" value="<?php echo $id; ?>" />
                                    <input hidden name="start" type="text" value="<?php echo $start; ?>" />
                                    <input hidden name="end" type="text" value="<?php echo $end; ?>" />
                                    <button type="submit" id="disbursed" class="btn btn-primary pull-left">Download
                                        PDF
                                    </button>
                                    <script>
                                        $(document).ready(function() {
                                            $('#disbursed').on("click", function() {
                                                swal({
                                                    type: "success",
                                                    title: "LOAN COLLATERAL REPORT",
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
                                <table id="mytable" class="display" style="width:100%">
                                    <thead>
                                        <?php
                                        $query = "SELECT * FROM collateral WHERE int_id = '$sessint_id'";
                                        $result = mysqli_query($connection, $query);
                                        ?>
                                        <tr>
                                            <th>Date</th>
                                            <th>Client Name</th>
                                            <th>Type</th>
                                            <th>Value</th>
                                            <th>Description</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
                                                <tr>
                                                    <?php $row["id"]; ?>
                                                    <?php
                                                    $name = $row['client_id'];
                                                    $anam = mysqli_query($connection, "SELECT firstname, lastname FROM client WHERE id = '$name'");
                                                    $f = mysqli_fetch_array($anam);
                                                    $nae = strtoupper($f["firstname"] . " " . $f["lastname"]);
                                                    ?>
                                                    <td><?php echo $row["date"]; ?></td>
                                                    <td><?php echo $nae; ?></td>
                                                    <td><?php echo $row["value"]; ?></td>
                                                    <td><?php echo $row["type"]; ?></td>
                                                    <td><?php echo $row["description"]; ?></td>
                                                </tr>
                                        <?php }
                                        } else {
                                            // echo "0 Document";
                                        }
                                        ?>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Date</th>
                                            <th>Client Name</th>
                                            <th>Type</th>
                                            <th>Value</th>
                                            <th>Description</th>

                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#mytable').DataTable();
        });
    </script>

<?php
} else if (isset($_GET["view20"])) {
?>
    <!-- Data for clients registered this month -->
    <!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
            <!-- your content here -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Matured Loan Report</h4>

                            <!-- Insert number users institutions -->
                            <p class="card-category">
                                <?php
                                $query = "SELECT * FROM loan WHERE int_id = '$sessint_id'";
                                $result = mysqli_query($connection, $query);
                                if ($result) {
                                    $inr = mysqli_num_rows($result);
                                    //  echo $inr;
                                    $date = date("F");
                                } ?> Matured Loans</p>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <form method="POST" action="../composer/loan_maturity.php">
                                    <input hidden name="id" type="text" value="<?php echo $id; ?>" />
                                    <input hidden name="start" type="text" value="<?php echo $start; ?>" />
                                    <input hidden name="end" type="text" value="<?php echo $end; ?>" />
                                    <button type="submit" id="disbursed" class="btn btn-primary pull-left">Download
                                        PDF
                                    </button>
                                    <script>
                                        $(document).ready(function() {
                                            $('#disbursed').on("click", function() {
                                                swal({
                                                    type: "success",
                                                    title: "MATURED LOAN REPORT",
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
                                <table id="mlr" class="display" style="width:100%">
                                    <thead>
                                        <?php
                                        $query = "SELECT * FROM loan WHERE int_id = '$sessint_id'";
                                        $result = mysqli_query($connection, $query);
                                        ?>
                                        <tr>
                                            <th>Client Name</th>
                                            <th>Principal Amount</th>
                                            <th>Loan Term</th>
                                            <th>Disbursement Date</th>
                                            <th>Maturity Date</th>
                                            <th>Outstanding Loan Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
                                                <tr>
                                                    <?php $std = date("Y-m-d");
                                                    if ($std >= $row["maturedon_date"]) {
                                                    ?>
                                                        <?php $row["id"]; ?>
                                                        <?php
                                                        $name = $row['client_id'];
                                                        $anam = mysqli_query($connection, "SELECT firstname, lastname FROM client WHERE id = '$name'");
                                                        $f = mysqli_fetch_array($anam);
                                                        $nae = strtoupper($f["firstname"] . " " . $f["lastname"]);
                                                        ?>
                                                        <td><?php echo $nae; ?></td>
                                                        <td><?php echo number_format($row["principal_amount"]); ?></td>
                                                        <td><?php echo $row["loan_term"]; ?></td>
                                                        <td><?php echo $row["disbursement_date"]; ?></td>
                                                        <td><?php echo $row["maturedon_date"]; ?></td>
                                                        <td><?php echo number_format($row["total_outstanding_derived"], 2); ?></td>
                                                    <?php } else {
                                                        // echo "0 Document";
                                                    }
                                                    ?>
                                                </tr>
                                        <?php }
                                        } else {
                                            // echo "0 Document";
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Client Name</th>
                                            <th>Principal Amount</th>
                                            <th>Loan Term</th>
                                            <th>Disbursement Date</th>
                                            <th>Maturity Date</th>
                                            <th>Outstanding Loan Balance</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#mlr').DataTable();
        });
    </script>

<?php
} else if (isset($_GET["view21"])) {
?>
    <!-- <div class="content">
           <div class="container-fluid">
                       your content here
                       <div class="row">
               <div class="col-md-12">
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
                       <span id ="runperform" type="submit" class="btn btn-primary">Run report</span>
                     </form>
                   </div>
                 </div>
                 <script>
                       $(document).ready(function () {
                         $('#runperform').on("click", function () {
                           var start = $('#start').val();
                           var end = $('#end').val();
                           var branch = $('#input').val();
                           var teller = $('#till').val();
                           var int_id = $('#int_id').val();
                           $.ajax({
                             url: "items/perform.php",
                             method: "POST",
                             data:{start:start, end:end, branch:branch, teller:teller, int_id:int_id},
                             success: function (data) {
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
    </div> -->
<?php
} else if (isset($_GET["view23"])) {
?>
    <div class="content">
        <div class="container-fluid">
            <!-- your content here -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Loan Structure Report</h4>
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
                                <span id="runstructure" type="submit" class="btn btn-primary">Run report</span>
                            </form>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('#runstructure').on("click", function() {
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
                                        $('#shstructure').html(data);
                                    }
                                })
                            });
                        });
                    </script>
                    <div id="shstructure" class="card">

                    </div>
                </div>
            </div>

        </div>
    </div>

<?php
} else if (isset($_GET["view39"])) {
    $main_date = $_GET["view39"];
    $main_date = date('Y-m-d');
?>

    <div class="content">
        <div class="container-fluid">
            <!-- your content here -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Expected Loan Repayment</h4>

                            <!-- Insert number users institutions -->
                            <p class="card-category">
                                <?php
                                $query = "SELECT * FROM loan_repayment_schedule WHERE int_id = '$sessint_id' AND duedate = '$main_date'";
                                $result = mysqli_query($connection, $query);
                                if ($result) {
                                    $inr = mysqli_num_rows($result);
                                    echo $inr;
                                } ?> loans expected to be repayed today</p>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <form method="POST" action="../composer/exp_loan_repay.php">
                                    <input hidden name="id" type="text" value="<?php echo $id; ?>" />
                                    <input hidden name="start" type="text" value="<?php echo $start; ?>" />
                                    <input hidden name="end" type="text" value="<?php echo $main_date; ?>" />
                                    <button type="submit" id="disbursed" class="btn btn-primary pull-left">Download
                                        PDF
                                    </button>
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
                                        <!-- <th>
                                      Status
                                    </th> -->
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
                                                    $l_n = $mik["loan_term"];
                                                    $t_o = $mik["total_outstanding_derived"];
                                                    ?>
                                                    <th>NGN <?php echo number_format($row["principal_amount"], 2); ?></th>
                                                    <th>NGN <?php echo number_format($row["interest_amount"], 2); ?></th>
                                                    <th><?php echo $l_n; ?></th>
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
                                        <!-- <th></th> -->
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
} else if (isset($_GET["view39b"])) {
    $main_date = $_GET["view39b"];
?>
    <div class="content">
        <div class="container-fluid">
            <!-- your content here -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Expected Loan Repayment</h4>

                            <!-- Insert number users institutions -->
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
                                } ?> loans expected to be repayed tomorrow</p>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <form method="POST" action="../composer/exp_loan_repay.php">
                                    <input hidden name="id" type="text" value="<?php echo $id; ?>" />
                                    <input hidden name="start" type="text" value="<?php echo $start; ?>" />
                                    <input hidden name="end" type="text" value="<?php echo $yomf; ?>" />
                                    <button type="submit" id="disbursed" class="btn btn-primary pull-left">Download
                                        PDF
                                    </button>
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
                                        <!-- <th>
                                      Status
                                    </th> -->
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
                                                    $l_n = $mik["loan_term"];
                                                    $t_o = $mik["total_outstanding_derived"];
                                                    ?>
                                                    <th>NGN <?php echo number_format($row["principal_amount"], 2); ?></th>
                                                    <th>NGN <?php echo number_format($row["interest_amount"], 2); ?></th>
                                                    <th><?php echo $l_n; ?></th>
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
                                        <!-- <th></th> -->
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
} else if (isset($_GET["view45"])) {
?>
    <div class="content">
        <div class="container-fluid">
            <!-- your content here -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Loans in Arrears</h4>

                            <!-- Insert number users institutions -->
                            <p class="card-category">
                                <?php
                                $query = "SELECT * FROM loan_arrear WHERE int_id = '$sessint_id' AND installment >= '1'";
                                $result = mysqli_query($connection, $query);
                                if ($result) {
                                    $inr = mysqli_num_rows($result);
                                    echo $inr;
                                } ?> loans past due date</p>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <form method="POST" action="../composer/arrear_report.php">
                                    <input hidden name="id" type="text" value="<?php echo $id; ?>" />
                                    <input hidden name="start" type="text" value="<?php echo $start; ?>" />
                                    <input hidden name="end" type="text" value="<?php echo $currentdate; ?>" />
                                    <button type="submit" id="disbursed" class="btn btn-primary pull-left">Download
                                        PDF
                                    </button>
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
                                        $query = "SELECT * FROM loan_arrear WHERE int_id = '$sessint_id' AND installment >= '1'";
                                        $result = mysqli_query($connection, $query);
                                        ?>
                                        <th>
                                            Client Name
                                        </th>
                                        <th>
                                            Principal Due
                                        </th>
                                        <th>Days in Arrears</th>
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
                                            Repayment Date
                                        </th>
                                        <th>
                                            Outstanding Loan Balance
                                        </th>
                                        <!-- <th>
                                      Status
                                    </th> -->
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
                                                    $l_n = $mik["loan_term"];
                                                    $eos = $row["installment"];
                                                    if ($eos == 1) {
                                                        $eod = "Not Paid";
                                                    } elseif ($eos == 0) {
                                                        $eod = "Paid";
                                                    }
                                                    ?>
                                                    <th><?php echo number_format($row["principal_amount"], 2); ?></th>
                                                    <th><?php echo $row["counter"]; ?></th>
                                                    <th><?php echo number_format($row["interest_amount"], 2); ?></th>
                                                    <th><?php echo $l_n; ?></th>
                                                    <th><?php echo $row["fromdate"]; ?></th>
                                                    <th><?php echo $row["duedate"]; ?></th>
                                                    <?php
                                                    $cli_id = $row["client_id"];
                                                    $sf = "SELECT * FROM loan WHERE int_id = '$sessint_id' AND id = '$loan_id' AND client_id = '$cli_id'";
                                                    $do = mysqli_query($connection, $sf);
                                                    while ($sd = mysqli_fetch_array($do)) {

                                                        $outbalance = $sd['total_outstanding_derived'];
                                                    }
                                                    ?>
                                                    <th><?php echo number_format($outbalance, 2); ?></th>
                                                    <?php

                                                    ?>
                                                </tr>
                                        <?php }
                                        } else {
                                            // echo "0 Document";
                                        }
                                        ?>
                                        <!-- <th></th> -->
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
}
?>