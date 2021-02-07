<?php

$page_title = "Client Report";
$destination = "report_client.php";
include("header.php");

function branch_opt($connection)
{
    $br_id = $_SESSION["branch_id"];
    $sint_id = $_SESSION["int_id"];
    $dff = "SELECT * FROM branch WHERE int_id ='$sint_id' AND id = '$br_id' || parent_id = '$br_id'";
    $dof = mysqli_query($connection, $dff);
    $out = '';
    while ($row = mysqli_fetch_array($dof)) {
        $do = $row['id'];
        $out .= " OR client.branch_id ='$do'";
    }
    return $out;
}

$inst_id = $_SESSION["int_id"];
$br_id = $_SESSION["branch_id"];
$branches = branch_opt($connection);

if (isset($_GET["view1"])) {
?>
    <!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
            <!-- your content here -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Clients Balance Report</h4>

                            <!-- Insert number users institutions -->
                            <p class="card-category"><?php
                            $query = "SELECT client.id, client.account_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved' && (client.branch_id ='$br_id' $branches) ";
                            $result = mysqli_query($connection, $query);
                            if ($result) {
                                $inr = mysqli_num_rows($result);
                                echo $inr;
                            } ?> clients</p>
                        </div>

                        <?php
                            $getInstData = mysqli_query($connection, "SELECT * FROM institutions WHERE int_id = '$inst_id'");
                            foreach($getInstData as $inst) {
                                $instName = $inst['int_name'];
                                $instAddress = $inst['office_address'];
                            }
                            $getBranchData = mysqli_query($connection, "SELECT name FROM branch WHERE id = '$br_id'");
                            foreach($getBranchData as $branch) {
                                $branchName = $branch['name'];
                            }
                        ?>

                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-profile ml-auto mr-auto" style="max-width: 360px; max-height: 360px">
                                        <div class="card-body ">
                                            <h4 class="card-title"> <?php echo $instName; ?> </h4>
                                            <h6 class="card-category text-gray"> <?php echo $branchName; ?> </h6>
                                        </div>
                                        <div class="card-footer justify-content-center">
                                            <b> <?php echo $instAddress; ?> </b>
                                        </div>
                                        <div class="card-footer justify-content-center">
                                            <b> <?php echo date('d F Y', time()); ?> </b> 
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="example" class="display" style="width:100%">
                                            <thead>
                                                <?php
                                                $query = "SELECT client.id, client.account_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved' && (client.branch_id ='$br_id' $branches) ";
                                                $result = mysqli_query($connection, $query);
                                                ?>
                                                <tr>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Account Officer</th>
                                                    <th>Account Type</th>
                                                    <th>Account Number</th>
                                                    <th>Account Balances</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
                                                        <tr>
                                                            <?php $row["id"];
                                                            $idd = $row["id"]; ?>
                                                            <td><?php echo $row["firstname"]; ?></td>
                                                            <td><?php echo $row["lastname"]; ?></td>
                                                            <td><?php echo strtoupper($row["first_name"] . " " . $row["last_name"]); ?></td>
                                                            <?php
                                                            $class = "";
                                                            $row["account_type"];
                                                            $cid = $row["id"];
                                                            $atype = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$cid'");
                                                            if (count([$atype]) == 1) {
                                                                $yxx = mysqli_fetch_array($atype);
                                                                $actype = $yxx['product_id'];
                                                                $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$actype' AND int_id = '$sessint_id'");
                                                                if (count([$spn])) {
                                                                    $d = mysqli_fetch_array($spn);
                                                                    $savingp = $d["name"];
                                                                }
                                                            }

                                                            ?>
                                                            <td><?php echo $savingp; ?></td>
                                                            <?php
                                                            $soc = $row["account_no"];
                                                            $length = strlen($soc);
                                                            if ($length == 1) {
                                                                $acc = "000000000" . $soc;
                                                            } elseif ($length == 2) {
                                                                $acc = "00000000" . $soc;
                                                            } elseif ($length == 3) {
                                                                $acc = "00000000" . $soc;
                                                            } elseif ($length == 4) {
                                                                $acc = "0000000" . $soc;
                                                            } elseif ($length == 5) {
                                                                $acc = "000000" . $soc;
                                                            } elseif ($length == 6) {
                                                                $acc = "0000" . $soc;
                                                            } elseif ($length == 7) {
                                                                $acc = "000" . $soc;
                                                            } elseif ($length == 8) {
                                                                $acc = "00" . $soc;
                                                            } elseif ($length == 9) {
                                                                $acc = "0" . $soc;
                                                            } elseif ($length == 10) {
                                                                $acc = $row["account_no"];
                                                            } else {
                                                                $acc = $row["account_no"];
                                                            }
                                                            ?>
                                                            <td><?php echo $acc; ?></td>
                                                            <?php
                                                            $don = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$idd'");
                                                            $ew = mysqli_fetch_array($don);
                                                            $accountb = $ew['account_balance_derived'];
                                                            ?>
                                                            <td><?php echo $accountb; ?></td>
                                                        </tr>
                                                <?php }
                                                } else {
                                                    // echo "0 Document";
                                                }
                                                ?>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Account Officer</th>
                                                    <th>Account Type</th>
                                                    <th>Account Number</th>
                                                    <th>Account Balances</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    
                                    <div class="form-group mt-4">

                                        <form method="POST" id="convert_form" action="../composer/client_balance.php">

                                            <input hidden name="id" type="text" value="<?php echo $id; ?>"/>
                                            <input hidden name="start" type="text" value="<?php echo $start; ?>"/>
                                            <input hidden name="end" type="text" value="<?php echo $end; ?>"/>
                                            <input type="hidden" name="file_content" id="file_content"/>

                                            <button type="submit" name="exportPDF" class="btn btn-primary">
                                                Download PDF
                                            </button>
                                        
                                            <button type="submit" name="exportExcel" class="btn btn-success">
                                                Download Excel
                                            </button>
                                            
                                        </form>

                                    </div>
                                    
                                </div>
                                
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <script>
            // $(document).ready(function() {
            //     $('#clientbalance').on("click", function() {
            //         swal({
            //             type: "success",
            //             title: "CLIENT BALANCE REPORT",
            //             text: "From " + start1 + " to " + end1 + "Loading...",
            //             showConfirmButton: false,
            //             timer: 5000

            //         })
            //     });
            // });

            // $(document).ready(function() {
            //     $('#convertExcel').click(function() {
            //         var table_content = '<table>';
            //         table_content += $('#table_content').html();
            //         table_content += '</table>';
            //         $('#file_content').val(table_content);
            //         $('#convert_form').submit();
            //     });
            // });

            $(document).ready(function() {
                $('#example').DataTable();
            });
        </script>
    </div>

<?php
} else if (isset($_GET["view2"])) {
?>
    <div class="content">

        <div class="container-fluid">

            <div class="row">

                <div class="col-md-12">

                    <div class="card">

                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Account Analysis</h4>
                            <p class="category">Recent Behaviour and Changes in the clients</p>
                        </div>

                        <?php
                            $getInstData = mysqli_query($connection, "SELECT * FROM institutions WHERE int_id = '$inst_id'");
                            foreach($getInstData as $inst) {
                                $instName = $inst['int_name'];
                                $instAddress = $inst['office_address'];
                            }
                            $getBranchData = mysqli_query($connection, "SELECT name FROM branch WHERE id = '$br_id'");
                            foreach($getBranchData as $branch) {
                                $branchName = $branch['name'];
                            }
                        ?>

                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-profile ml-auto mr-auto" style="max-width: 360px; max-height: 360px">
                                        <div class="card-body ">
                                            <h4 class="card-title"> <?php echo $instName; ?> </h4>
                                            <h6 class="card-category text-gray"> <?php echo $branchName; ?> </h6>
                                        </div>
                                        <div class="card-footer justify-content-center">
                                            <b> <?php echo $instAddress; ?> </b>
                                        </div>
                                        <div class="card-footer justify-content-center">
                                            <b> <?php echo date('d F Y', time()); ?> </b> 
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="acctanalysis" class="display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th><small>Account Types</small></th>
                                                    <th><small>Accounts in debit</small></th>
                                                    <th><small>Accounts in credit</small></th>
                                                    <th><small>Accounts with zero balance</small></th>
                                                    <th><small>Total</small></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php
                                                $savingsProducts = mysqli_query($connection, "SELECT * FROM `savings_product`");
                                                foreach($savingsProducts as $savingsProduct) {
                                                    $productID = $savingsProduct['id'];
                                                ?>
                                                <tr>
                                                    <td><?php echo $savingsProduct['name']; ?></td>
                                                    <td>
                                                    <?php
                                                        $query = "SELECT count(account_no) FROM `account` WHERE product_id = $productID AND account_balance_derived LIKE '%-%'";
                                                        $accountsInDebit = mysqli_query($connection, $query);
                                                        $row = mysqli_fetch_array($accountsInDebit);
                                                        echo $row[0];
                                                    ?>
                                                    </td>
                                                    <td>
                                                    <?php
                                                        $query = "SELECT count(account_no) FROM `account` WHERE (product_id = $productID) AND (account_balance_derived NOT LIKE '%-%' AND account_balance_derived <> 0.00 AND account_balance_derived <> 0)";
                                                        $accountsInCredit = mysqli_query($connection, $query);
                                                        $row = mysqli_fetch_array($accountsInCredit);
                                                        echo $row[0];
                                                    ?>
                                                    </td>
                                                    <td>
                                                    <?php
                                                        $query = "SELECT count(account_no) FROM `account` WHERE (product_id = $productID) AND (account_balance_derived = 0.00 OR account_balance_derived = 0)";
                                                        $accountsInZero = mysqli_query($connection, $query);
                                                        $row = mysqli_fetch_array($accountsInZero);
                                                        echo $row[0];
                                                    ?>
                                                    </td>
                                                    <td>
                                                    <?php
                                                        $query = "SELECT count(account_no) FROM `account` WHERE (product_id = $productID)";
                                                        $totalAccounts = mysqli_query($connection, $query);
                                                        $row = mysqli_fetch_array($totalAccounts);
                                                        echo $row[0];
                                                    ?>
                                                    </td>
                                                    
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th><small>Account Types</small></th>
                                                    <th><small>Accounts in debit</small></th>
                                                    <th><small>Accounts in credit</small></th>
                                                    <th><small>Accounts with zero balance</small></th>
                                                    <th><small>Total</small></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="form-group mt-4">

                                        <form method="POST" action="../composer/account_analysis.php">

                                            <button type="submit" name="exportPDF" class="btn btn-primary pull-left">
                                                Download PDF
                                            </button>
                                            <button type="submit" name="exportExcel" class="btn btn-success">
                                                Download Excel
                                            </button>

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
    <script>
        $(document).ready(function() {
            $('#acctanalysis').DataTable();
        });
    </script>

<?php
} else if (isset($_GET["view3"])) {
?>
    <!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
            <!-- your content here -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Clients</h4>

                            <!-- Insert number users institutions -->
                            <p class="card-category">
                                <?php
                                $query = "SELECT client.id, client.BVN, client.date_of_birth, client.gender, client.account_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved' && (client.branch_id ='$br_id' $branches)  ORDER BY client.firstname ASC";

                                $result = mysqli_query($connection, $query);
                                if ($result) {
                                    $inr = mysqli_num_rows($result);
                                    echo $inr;
                                } 
                                ?> registered clients
                        </div>

                        <div class="card-body">
                            <?php
                                $getInstData = mysqli_query($connection, "SELECT * FROM institutions WHERE int_id = '$inst_id'");
                                foreach($getInstData as $inst) {
                                    $instName = $inst['int_name'];
                                    $instAddress = $inst['office_address'];
                                }
                                $getBranchData = mysqli_query($connection, "SELECT name FROM branch WHERE id = '$br_id'");
                                foreach($getBranchData as $branch) {
                                    $branchName = $branch['name'];
                                }
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-profile ml-auto mr-auto" style="max-width: 360px; max-height: 360px">
                                        <div class="card-body ">
                                            <h4 class="card-title"> <?php echo $instName; ?> </h4>
                                            <h6 class="card-category text-gray"> <?php echo $branchName; ?> </h6>
                                        </div>
                                        <div class="card-footer justify-content-center">
                                            <b> <?php echo $instAddress; ?> </b>
                                        </div>
                                        <div class="card-footer justify-content-center">
                                            <b> <?php echo date('d F Y', time()); ?> </b> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="clients" class="display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th><small>First Name</small></th>
                                                    <th><small>Last Name</small></th>
                                                    <th><small>Account Officer</small></th>
                                                    <th><small>Account Type</small></th>
                                                    <th><small>Account Number</small></th>
                                                    <th><small>Date of Birth</small></th>
                                                    <th><small>Gender</small></th>
                                                    <th><small>Phone</small></th>
                                                    <th><small>BVN</small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
                                                        <tr>
                                                            <?php $row["id"]; ?>
                                                            <td><?php echo $row["firstname"]; ?></td>
                                                            <td><?php echo $row["lastname"]; ?></td>
                                                            <td><?php echo strtoupper($row["first_name"] . " " . $row["last_name"]); ?></td>
                                                            <?php
                                                            $class = "";
                                                            $row["account_type"];
                                                            $cid = $row["id"];
                                                            $atype = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$cid'");
                                                            if (count([$atype]) == 1) {
                                                                $yxx = mysqli_fetch_array($atype);
                                                                $actype = $yxx['product_id'];
                                                                $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$actype' AND int_id = '$sessint_id'");
                                                                if (count([$spn])) {
                                                                    $d = mysqli_fetch_array($spn);
                                                                    $savingp = $d["name"];
                                                                }
                                                            }

                                                            ?>
                                                            <td><?php echo $savingp; ?></td>
                                                            <?php
                                                            $soc = $row["account_no"];
                                                            $length = strlen($soc);
                                                            if ($length == 1) {
                                                                $acc = "000000000" . $soc;
                                                            } elseif ($length == 2) {
                                                                $acc = "00000000" . $soc;
                                                            } elseif ($length == 3) {
                                                                $acc = "00000000" . $soc;
                                                            } elseif ($length == 4) {
                                                                $acc = "0000000" . $soc;
                                                            } elseif ($length == 5) {
                                                                $acc = "000000" . $soc;
                                                            } elseif ($length == 6) {
                                                                $acc = "0000" . $soc;
                                                            } elseif ($length == 7) {
                                                                $acc = "000" . $soc;
                                                            } elseif ($length == 8) {
                                                                $acc = "00" . $soc;
                                                            } elseif ($length == 9) {
                                                                $acc = "0" . $soc;
                                                            } elseif ($length == 10) {
                                                                $acc = $row["account_no"];
                                                            } else {
                                                                $acc = $row["account_no"];
                                                            }
                                                            ?>
                                                            <td><?php echo $acc; ?></td>
                                                            <td><?php echo $row["date_of_birth"]; ?></td>
                                                            <td><?php echo $row["gender"]; ?></td>
                                                            <td><?php echo $row["mobile_no"]; ?></td>
                                                            <td><?php echo $row["BVN"]; ?></td>
                                                        </tr>
                                                <?php }
                                                } else {
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th><small>First Name</small></th>
                                                    <th><small>Last Name</small></th>
                                                    <th><small>Account Officer</small></th>
                                                    <th><small>Account Type</small></th>
                                                    <th><small>Account Number</small></th>
                                                    <th><small>Date of Birth</small></th>
                                                    <th><small>Gender</small></th>
                                                    <th><small>Phone</small></th>
                                                    <th><small>BVN</small></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <script>
                                            $(document).ready(function() {
                                                $('#clients').DataTable();
                                            });
                                        </script>
                                    </div>

                                    <div class="form-group mt-4">
                                        <form method="POST" action="../composer/client_list.php">
                                            <input hidden name="id" type="text" value="<?php echo $id; ?>" />
                                            <input hidden name="start" type="text" value="<?php echo $start; ?>" />
                                            <input hidden name="end" type="text" value="<?php echo $end; ?>" />
                                            <button type="submit" id="clientlist" class="btn btn-primary pull-left">
                                                Download PDF
                                            </button>
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
} else if (isset($_GET["view4"])) {
?>
    <?php
    function fill_client($connection)
    {
        $sint_id = $_SESSION["int_id"];
        $org = "SELECT * FROM client WHERE int_id = '$sint_id' ORDER BY firstname ASC";
        $res = mysqli_query($connection, $org);
        $out = '';
        while ($row = mysqli_fetch_array($res)) {
            $out .= '<option value="' . $row["id"] . '">' . $row["firstname"] . ' ' . $row["lastname"] . '</option>';
        }
        return $out;
    }

    ?>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Client Summary Report</h4>
                        <p class="card-category">Fill in all important data</p>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" hidden required id="intt" value="<?php echo $sessint_id; ?>" />
                                        <label class="bmd-label-floating">Pick Client</label>
                                        <select name="branch" class="form-control" id="input" required>
                                            <option value="">select an option</option>
                                            <?php echo fill_client($connection); ?>
                                        </select>

                                    </div>
                                </div>

                                <div class="clearfix"></div>
                            </div>
                        </form>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('#input').on("change", function() {
                                var cid = $(this).val();
                                var intid = $('#intt').val();
                                $.ajax({
                                    url: "ajax_post/reports_post/client_summary.php",
                                    method: "POST",
                                    data: {
                                        cid: cid,
                                        intid: intid
                                    },
                                    success: function(data) {
                                        $('#outjournal').html(data);
                                    }
                                })
                            });
                        });
                    </script>

                </div>
            </div>
        </div>
        <div id="outjournal"></div>
    </div>
    </div>
    </div>
<?php
} else if (isset($_GET["view5"])) {
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
                            <h4 class="card-title ">Registered Clients</h4>

                            <!-- Insert number users institutions -->
                            <p class="card-category"><?php
                                                        $std = date("Y-m-d");
                                                        $thisyear = date("Y");
                                                        $thismonth = date("m");
                                                        // $end = date('Y-m-d', strtotime('-30 days'));
                                                        $curren = $thisyear . "-" . $thismonth . "-01";
                                                        $query = "SELECT * FROM client WHERE client.int_id = '$sessint_id' && client.status = 'Approved' && submittedon_date BETWEEN '$curren' AND '$std' && (branch_id ='$br_id' $branches)";
                                                        $result = mysqli_query($connection, $query);
                                                        if ($result) {
                                                            $inr = mysqli_num_rows($result);
                                                            $date = date("F");
                                                        } ?>
                            <div id="month_no"><?php echo $inr; ?> Registered Clients this month</div>
                            </p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <form method="POST" action="../composer/registered_client.php">
                                            <label for="">Pick Month</label>
                                            <select id="month" class="form-control" style="text-transform: uppercase;" name="month">
                                                <option value="0"></option>
                                                <option value="1">January</option>
                                                <option value="2">February</option>
                                                <option value="3">March</option>
                                                <option value="4">April</option>
                                                <option value="5">May</option>
                                                <option value="6">June</option>
                                                <option value="7">July</option>
                                                <option value="8">August</option>
                                                <option value="9">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>
                                            </select>

                                            <input hidden name="id" type="text" value="<?php echo $id; ?>" />
                                            <input hidden name="start" type="text" value="<?php echo $start; ?>" />
                                            <input hidden name="end" type="text" value="<?php echo $end; ?>" />
                                            <button type="submit" id="registeredclient" class="btn btn-primary pull-left">Download PDF
                                            </button>
                                            <script>
                                                $(document).ready(function() {
                                                    $('#registeredclient').on("click", function() {
                                                        swal({
                                                            type: "success",
                                                            title: "REGISTERED CLIENT REPORT",
                                                            text: "Printing Successful",
                                                            showConfirmButton: false,
                                                            timer: 5000

                                                        })
                                                    });
                                                });
                                            </script>
                                        </form>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('#month').on("change", function() {
                                            var month = $(this).val();
                                            $.ajax({
                                                url: "ajax_post/reports_post/pick_month_copy.php",
                                                method: "POST",
                                                data: {
                                                    month: month
                                                },
                                                success: function(data) {
                                                    $('#dismonth').html(data);
                                                }
                                            })
                                        });
                                    });
                                </script>
                                <script>
                                    $(document).ready(function() {
                                        $('#month').on("change", function() {
                                            var month = $(this).val();
                                            $.ajax({
                                                url: "ajax_post/reports_post/pick_month.php",
                                                method: "POST",
                                                data: {
                                                    month: month
                                                },
                                                success: function(data) {
                                                    $('#dismonth').html(data);
                                                }
                                            })
                                        });
                                    });
                                </script>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="dismonth" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th><small>First Name</small></th>
                                                <th><small>Last Name</small></th>
                                                <th><small>Account officer</small></th>
                                                <th><small>Account Type</small></th>
                                                <th><small>Account Number</small></th>
                                                <th><small>Phone</small></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
                                                    <tr>
                                                        <?php $row["id"]; ?>
                                                        <td><?php echo $row["firstname"]; ?></td>
                                                        <td><?php echo $row["lastname"]; ?></td>
                                                        <?php $ffd = $row["loan_officer_id"];
                                                        $ds = "SELECT * FROM staff WHERE int_id ='$sessint_id' AND id = '$ffd'";
                                                        $fdi = mysqli_query($connection, $ds);
                                                        $fd = mysqli_fetch_array($fdi);
                                                        $fn = $fd['first_name'];
                                                        $ln = $fd['last_name'];
                                                        ?>
                                                        <td><?php echo strtoupper($fn . " " . $ln); ?></td>
                                                        <?php
                                                        $class = "";
                                                        $row["account_type"];
                                                        $cid = $row["id"];
                                                        $atype = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$cid'");
                                                        if (count([$atype]) == 1) {
                                                            $yxx = mysqli_fetch_array($atype);
                                                            $actype = $yxx['product_id'];
                                                            $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$actype' AND int_id = '$sessint_id'");
                                                            if (count([$spn])) {
                                                                $d = mysqli_fetch_array($spn);
                                                                $savingp = $d["name"];
                                                            }
                                                        }

                                                        ?>
                                                        <td><?php echo $savingp; ?></td>
                                                        <td><?php echo $row["account_no"]; ?></td>
                                                        <td><?php echo $row["mobile_no"]; ?></td>
                                                    </tr>
                                            <?php }
                                            } else {
                                                // echo "0 Document";
                                            }
                                            ?>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th><small>First Name</small></th>
                                                <th><small>Last Name</small></th>
                                                <th><small>Account officer</small></th>
                                                <th><small>Account Type</small></th>
                                                <th><small>Account Number</small></th>
                                                <th><small>Phone</small></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <script>
                                $(document).ready(function() {
                                    $('#dismonth').DataTable();
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