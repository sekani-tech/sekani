<?php

$page_title = "Group Report";
$destination = "report_client.php";
include("header.php");
?>
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
<?php
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
                            <h4 class="card-title ">groups Balance Report</h4>

                            <!-- Insert number users institutions -->
                            <p class="card-category"><?php
                                                        $query = "SELECT * FROM client WHERE int_id = '$sessint_id' && status = 'Approved' && (branch_id ='$br_id' $branches)";
                                                        $result = mysqli_query($connection, $query);
                                                        if ($result) {
                                                            $inr = mysqli_num_rows($result);
                                                            echo $inr;
                                                        } ?> groups</p>
                        </div>
                        <form method="POST" id="convert_form" action="../composer/client_balance.php">
                            <div class="card-body">
                                <div class="form-group">
                                    <input hidden name="id" type="text" value="<?php echo $id; ?>" />
                                    <input hidden name="start" type="text" value="<?php echo $start; ?>" />
                                    <input hidden name="end" type="text" value="<?php echo $end; ?>" />
                                    <input type="hidden" name="file_content" id="file_content" />
                                    <button type="submit" id="clientbalance" class="btn btn-primary pull-left">Download
                                        PDF
                                    </button>
                                    <button type="button" name="convert" id="convertExcel" class="btn btn-success">
                                        Download Excel
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table class="rtable display nowrap" style="width:100%">
                                        <thead class=" text-primary">
                                            <?php
                                            $query = "SELECT client.id, client.account_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved'";
                                            $result = mysqli_query($connection, $query);
                                            ?>
                                            <th>
                                                First Name
                                            </th>
                                            <th>
                                                Last Name
                                            </th>
                                            <th>
                                                Account officer
                                            </th>
                                            <th>
                                                Account Type
                                            </th>
                                            <th>
                                                Account Number
                                            </th>
                                            <th>
                                                Account Balances
                                            </th>
                                        </thead>
                                        <tbody>
                                            <?php if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
                                                    <tr>
                                                        <?php $row["id"];
                                                        $idd = $row["id"]; ?>
                                                        <th><?php echo $row["firstname"]; ?></th>
                                                        <th><?php echo $row["lastname"]; ?></th>
                                                        <th><?php echo strtoupper($row["first_name"] . " " . $row["last_name"]); ?></th>
                                                        <?php
                                                        $class = "";
                                                        $row["account_type"];
                                                        $cid = $row["id"];
                                                        $atype = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$cid'");
                                                        if (count([$atype]) == 1) {
                                                            $yxx = mysqli_fetch_array($atype);
                                                            $actype = $yxx['product_id'];
                                                            $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$actype'");
                                                            if (count([$spn])) {
                                                                $d = mysqli_fetch_array($spn);
                                                                $savingp = $d["name"];
                                                            }
                                                        }

                                                        ?>
                                                        <th><?php echo $savingp; ?></th>
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
                                                        <th><?php echo $acc; ?></th>
                                                        <?php
                                                        $don = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$idd'");
                                                        $ew = mysqli_fetch_array($don);
                                                        $accountb = $ew['account_balance_derived'];
                                                        ?>
                                                        <th><?php echo $accountb; ?></th>
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#clientbalance').on("click", function() {
                    swal({
                        type: "success",
                        title: "CLIENT BALANCE REPORT",
                        text: "From " + start1 + " to " + end1 + "Loading...",
                        showConfirmButton: false,
                        timer: 5000

                    })
                });
            });
            $(document).ready(function() {
                $('#convertExcel').click(function() {
                    var table_content = '<table>';
                    table_content += $('#table_content').html();
                    table_content += '</table>';
                    $('#file_content').val(table_content);
                    $('#convert_form').submit();
                });
            });
        </script>
    </div>
<?php
} else if (isset($_GET["view6"])) {
?>
    <!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
            <!-- your content here -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">General Group Report</h4>

                            <!-- Insert number users institutions -->
                            <p class="card-category"><?php
                                                        $query = "SELECT * FROM groups WHERE int_id = '$sessint_id' && status = 'Approved' && (branch_id ='$br_id' $branches)";
                                                        $result = mysqli_query($connection, $query);
                                                        if ($result) {
                                                            $inr = mysqli_num_rows($result);
                                                            echo $inr;
                                                        } ?> registered groups
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <form method="POST" action="../composer/group_list.php">
                                    <input hidden name="id" type="text" value="<?php echo $id; ?>" />
                                    <input hidden name="start" type="text" value="<?php echo $start; ?>" />
                                    <input hidden name="end" type="text" value="<?php echo $end; ?>" />
                                    <input type="hidden" name="file_content" id="file_content" />
                                    <button type="submit" id="clientlist" class="btn btn-primary pull-left">Download
                                        PDF
                                    </button>
                                    <button type="button" name="convert" id="convertExcel" class="btn btn-success">
                                        Download Excel
                                    </button>

                                </form>
                            </div>

                            <table id="reportgroup" class="display" style="width:100%">
                                <thead>
                                    <?php
                                    $query = "SELECT * FROM groups WHERE int_id = '$sessint_id' AND status = 'Approved' && (branch_id ='$br_id' $branches) ORDER BY g_name ASC";
                                    $result = mysqli_query($connection, $query);
                                    ?>
                                    <tr>
                                        <th> Group Name</th>
                                        <th>Reg Type</th>
                                        <th>Meeting Day</th>
                                        <th>Meeting Frequency</th>
                                        <th>Meeting Time</th>
                                        <th>Meeting Location</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
                                            <tr>
                                                <?php $row["id"]; ?>
                                                <td><?php echo $row["g_name"]; ?></td>
                                                <td><?php echo $row["reg_type"]; ?></td>
                                                <td><?php echo $row["meeting_day"]; ?></td>
                                                <td><?php echo $row["meeting_frequency"]; ?></td>
                                                <td><?php echo $row["meeting_time"]; ?></td>
                                                <td><?php echo $row["meeting_location"]; ?></td>
                                            </tr>
                                    <?php }
                                    } else {
                                        // echo "0 Document";
                                    }
                                    ?>


                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th> Group Name</th>
                                        <th>Reg Type</th>
                                        <th>Meeting Day</th>
                                        <th>Meeting Frequency</th>
                                        <th>Meeting Time</th>
                                        <th>Meeting Location</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    $('#reportgroup').DataTable();
                });
            </script>

            <script>
                $(document).ready(function() {
                    $('#clientbalance').on("click", function() {
                        swal({
                            type: "success",
                            title: "CLIENT BALANCE REPORT",
                            text: "From " + start1 + " to " + end1 + "Loading...",
                            showConfirmButton: false,
                            timer: 5000

                        })
                    });
                });
                $(document).ready(function() {
                    $('#convertExcel').click(function() {
                        var table_content = '<table>';
                        table_content += $('#table_content').html();
                        table_content += '</table>';
                        $('#file_content').val(table_content);
                        $('#convert_form').submit();
                    });
                });
            </script>
        </div>
    </div>

<?php
} else if (isset($_GET["view8"])) {
?>
    <?php
    function fill_client($connection)
    {
        $sint_id = $_SESSION["int_id"];
        $guuy = $_SESSION['branch_id'];
        $org = "SELECT * FROM branch WHERE int_id = '$sint_id' AND (id = '$guuy' OR parent_id = '$guuy')";
        $res = mysqli_query($connection, $org);
        $out = '';
        while ($row = mysqli_fetch_array($res)) {
            $out .= '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
        }
        return $out;
    }

    ?>

    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Group Reports By Branch</h4>
                            <p class="card-category">Fill in all important data</p>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <input type="text" hidden required id="intt" value="<?php echo $sessint_id; ?>" />
                                            <label class="bmd-label-floating">Pick Branch</label>
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
                                        url: "ajax_post/reports_post/groupby_branch.php",
                                        method: "POST",
                                        data: {
                                            cid: cid,
                                            intid: intid
                                        },
                                        success: function(data) {
                                            $('#hdhd').html(data);
                                        }
                                    })
                                });
                            });
                        </script>

                    </div>
                    <div id="hdhd"></div>
                </div>
            </div>
        </div>
    </div>
    </div>
<?php
} else if (isset($_GET["view9"])) {
?>
    <!-- Data for groups registered this month -->
    <!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
            <!-- your content here -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Registered groups</h4>

                            <!-- Insert number users institutions -->
                            <p class="card-category"><?php
                                                        $std = date("Y-m-d");
                                                        $thisyear = date("Y");
                                                        $thismonth = date("m");
                                                        // $end = date('Y-m-d', strtotime('-30 days'));
                                                        $curren = $thisyear . "-" . $thismonth . "-01";
                                                        $query = "SELECT * FROM groups WHERE int_id = '$sessint_id' && status = 'Approved' AND (branch_id ='$br_id' $branches) && submittedon_date BETWEEN '$curren' AND '$std'";
                                                        $result = mysqli_query($connection, $query);
                                                        if ($result) {
                                                            $inr = mysqli_num_rows($result);
                                                            $date = date("F");
                                                        } ?>
                            <div id="month_no"><?php echo $inr; ?> Registered group(s) this month</div>
                            </p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <form method="POST" action="../composer/registered_group.php">
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
                                                url: "ajax_post/reports_post/pick_group_month_copy.php",
                                                method: "POST",
                                                data: {
                                                    month: month
                                                },
                                                success: function(data) {
                                                    $('#month_no').html(data);
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
                                                url: "ajax_post/reports_post/pick_group_month.php",
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
                            <table id="dismonth" class="display" style="width:100%">
                                <thead>
                                <?php
                                    $query = "SELECT * FROM groups WHERE int_id = '$sessint_id' && status = 'Approved'AND (branch_id ='$br_id' $branches)  && submittedon_date BETWEEN '$curren' AND '$std'";
                                    $result = mysqli_query($connection, $query);
                                    ?>
                                    <tr>
                                        <th>Group Name</th>
                                        <th>Reg Type</th>
                                        <th>Meeting Day</th>
                                        <th>Meeting Frequency</th>
                                        <th>Meeting Time</th>
                                        <th>Meeting Location</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
                                    <tr>
                                    <?php $row["id"]; ?>
                                        <td><?php echo $row["g_name"]; ?></td>
                                        <td><?php echo $row["reg_type"]; ?></td>
                                        <td><?php echo $row["meeting_day"]; ?></td>
                                        <td><?php echo $row["meeting_frequency"]; ?></td>
                                        <td><?php echo $row["meeting_time"]; ?></td>
                                        <td><?php echo $row["meeting_location"]; ?></td>
                                    </tr>
                                    <?php }
                                    } else {
                                        // echo "0 Document";
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Group Name</th>
                                        <th>Reg Type</th>
                                        <th>Meeting Day</th>
                                        <th>Meeting Frequency</th>
                                        <th>Meeting Time</th>
                                        <th>Meeting Location</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#dismonth').DataTable();
        });
    </script>
<?php
} else if (isset($_GET["view46"])) {
?>
    <div class="content">
        <div class="container-fluid">
            <!-- your content here -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Collection Report</h4>
                        </div>
                        <?php
                        function fill_branch($connection)
                        {
                            $sint_id = $_SESSION["int_id"];
                            $guuy = $_SESSION['branch_id'];
                            $org = "SELECT * FROM branch WHERE int_id = '$sint_id' AND (id = '$guuy' OR parent_id = '$guuy')";
                            $res = mysqli_query($connection, $org);
                            $out = '';
                            while ($row = mysqli_fetch_array($res)) {
                                $out .= '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
                            }
                            return $out;
                        }

                        function fill_officer($connection)
                        {
                            $sint_id = $_SESSION["int_id"];
                            $org = "SELECT * FROM staff WHERE int_id = '$sint_id' AND employee_status = 'Employed'";
                            $res = mysqli_query($connection, $org);
                            $out = '';
                            while ($row = mysqli_fetch_array($res)) {
                                $out .= '<option value="' . $row["id"] . '">' . $row["display_name"] . '</option>';
                            }
                            return $out;
                        }

                        ?>
                        <script>
                            $(document).ready(function() {
                                $('#brne').on("change click", function() {
                                    var id = $(this).val();
                                    $.ajax({
                                        url: "ajax_post/reports_post/staff.php",
                                        method: "POST",
                                        data: {
                                            id: id
                                        },
                                        success: function(data) {
                                            $('#outstaff').html(data);
                                        }
                                    })
                                });
                            });
                        </script>
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
                                    <div class="form-group col-md-3">
                                        <label for="">Branch</label>
                                        <select name="" id="brne" class="form-control">
                                            <?php echo fill_branch($connection); ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="">Account Officer</label>
                                        <select name="" id="officer" class="form-control">
                                            <option value="all">All</option>
                                            <?php echo fill_officer($connection); ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3" id="sio">
                                    </div>
                                </div>
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <span id="runstaff" type="submit" class="btn btn-primary">Run report</span>
                            </form>
                        </div>
                        <script>
                            $(document).ready(function() {
                                $('#officer').on("change", function() {
                                    var officer = $('#officer').val();
                                    $.ajax({
                                        url: "ajax_post/group_by_acc.php",
                                        method: "POST",
                                        data: {
                                            officer: officer
                                        },
                                        success: function(data) {
                                            $('#sio').html(data);
                                        }
                                    })
                                });
                            });
                        </script>
                        <script>
                            $(document).ready(function() {
                                $('#runstaff').on("click", function() {
                                    var start = $('#start').val();
                                    var end = $('#end').val();
                                    var branch = $('#brne').val();
                                    var officer = $('#officer').val();
                                    var group = $('#group').val();
                                    $.ajax({
                                        url: "ajax_post/reports_post/group_collection.php",
                                        method: "POST",
                                        data: {
                                            start: start,
                                            end: end,
                                            branch: branch,
                                            officer: officer,
                                            group: group
                                        },
                                        success: function(data) {
                                            $('#shstaff').html(data);
                                        }
                                    })
                                });
                            });
                        </script>
                        <div class="card-body">
                            <div class="col-md-8">
                            </div>
                        </div>

                    </div>
                </div>
                <div id="shstaff"></div>
            </div>

        </div>
    </div>
<?php
}
?>