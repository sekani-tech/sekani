<!DOCTYPE html>
<html lang="en">
<?php
//  BEFOR THE SESSION START
session_set_cookie_params(0);
ob_start();
session_start();
include("../functions/connect.php");
require('../functions/tiny_config.php');
$autologout = 1000;
$lastactive = $_SESSION['timestamp'] ?? 0;
if ((time() - $lastactive) > $autologout) {
    // echo header("location: ../functions/logout.php");
    // echo "ALRIGHT";
} else {
    $_SESSION['timestamp'] = time(); //Or reset the timestamp
    // echo "READING...";
}
// defining date range for transactions
$today = Date('Y-m-d');
$minDate = date("Y-m-d", strtotime("-3 year"));
// THE NEW CODES HERE WILL BE FOR THE NEXT INSTANCE
// WRITING A QUICK ALROGRITHM
// 1. GET THE CURRENT TIME
// 2. YOU UPDATE
// 3. YOU CHECK
// Let's make a new move
// ID
if (!$_SESSION["usertype"] == "admin") {
    header("location: ../login.php");
    exit;
}
$staff_id = $_SESSION["staff_id"];
?>
<?php
// get connections for all pages

$sessint_id = $_SESSION["int_id"];

$branch_id = $_SESSION["branch_id"];
$inq = mysqli_query($connection, "SELECT * FROM institutions WHERE int_id='$sessint_id'");
if (count([$inq]) == 1) {
    $n = mysqli_fetch_array($inq);
    $int_name = $n['int_name'];
    $img = $n['img'];
}
// this section is for permissions
$org_role = $_SESSION['org_role'];
$getpermission = mysqli_query($connection, "SELECT * FROM `permission` WHERE role_id = '$org_role' && int_id = '$sessint_id'");
if (count([$getpermission]) == 1) {
    $pms = mysqli_fetch_array($getpermission);
    $can_transact = $pms['trans_appv'];
    $trans_post = $pms['trans_post'];
    $loan_appv = $pms['loan_appv'];
    $acct_appv = $pms['acct_appv'];
    $valut = $pms['valut'];
    $view_report = $pms['view_report'];
    $view_dashboard = $pms['view_dashboard'];
    $vault_email = $pms['vault_email'];
    $acc_op = $pms['acc_op'];
    $staff_cabal = $pms['staff_cabal'];
    $acc_update = $pms['acc_update'];
    $per_con = $pms['configuration'];
    $per_bills = $pms['bills'];
    $bch_id = $_SESSION["branch_id"];
}
?>
<?php
// checking if IP has been Blocked
function getIPAddress()
{
    //whether ip is from the share internet
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } //whether ip is from the proxy
    else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } //whether ip is from the remote address
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

$ip = getIPAddress();
$getip = mysqli_query($connection, "SELECT * FROM ip_blacklist WHERE ip_add = '$ip'");
if (mysqli_num_rows($getip) == 1) {
    if (count([$getip]) == 1) {
        $x = mysqli_fetch_array($getip);
        $vm = $x['trial'];
    }
    if ($vm >= 3) {
        $_SESSION = array();
        // Destroy the session.
        session_destroy();
        $URL = "../ip/block_ip.php";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    }
}
?>
<?php
//active user
$activecode = "Active";
// working on the time stamp right now
$ts = date('Y-m-d H:i:s');
$acuser = $_SESSION["username"];
$_SESSION['last_login_timestamp'] = time();
$timmer_check = $_SESSION['last_login_timestamp'];
// AUTO LOGIN
$activeq = "UPDATE users SET users.status ='$activecode', users.last_logged = '$ts' WHERE users.username ='$acuser'";
$rezz = mysqli_query($connection, $activeq);
?>
<input type="text" value="<?php echo $acuser; ?>" id="usernameoioio" hidden>
<input type="text" value="<?php echo $sessint_id; ?>" id="int_idioioioio" hidden>



<head>
    <title><?php echo "$int_name - $page_title" ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="1000;url=../functions/logout.php" />
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <!--     Fonts and icons     -->
    <!-- <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" /> -->
    <link rel="stylesheet" href="../assets/css/material_icons.css">
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css">
    <!-- Material Kit CSS -->
    <link href="../assets/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
    <!-- Search Query -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> -->
    <!-- accordion -->
    <!-- JAVASCRIPT CHART.JS -->
    <script src="../assets/js/charts/chart.min.js"></script>
    <script src="../assets/js/charts/chart.bundle.js"></script>
    <script src="../assets/js/charts/chart.bundle.min.js"></script>
    <!-- autocomplete -->
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>


    <!-- CHAT BOT -->
    <script type="text/javascript">
        (function(w, d, v3) {
            w.chaportConfig = {
                appId: '5f733d1696c6b40369151056'
            };

            if (w.chaport) return;
            v3 = w.chaport = {};
            v3._q = [];
            v3._l = {};
            v3.q = function() {
                v3._q.push(arguments)
            };
            v3.on = function(e, fn) {
                if (!v3._l[e]) v3._l[e] = [];
                v3._l[e].push(fn)
            };
            var s = d.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = 'https://app.chaport.com/javascripts/insert.js';
            var ss = d.getElementsByTagName('script')[0];
            ss.parentNode.insertBefore(s, ss)
        })(window, document);
    </script>
    <!-- END CHAT BOT -->
    <script src="../assets/js/charts/chart.js"></script>
    <link rel="stylesheet" href="../assets/css/charts/chart.css">
    <link rel="stylesheet" href="../assets/css/charts/chart.min.css">
    <!-- END CHART.JS -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> -->
    <script src="../datatable/sweetalert.min.js"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="../datatable/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../datatable/rowReorder.dataTables.min.css">
    <link rel="stylesheet" href="../datatable/responsive.dataTables.min.css">

    </script>

    <!-- DataTables scripts -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <!-- <script>
        var $j = $.noConflict(true);
    </script> -->
    <!-- DATATABLE CODE -->
    <script src="../datatable/jquery.dataTables.min.js"></script>
    <script src="../datatable/dataTables.rowReorder.min.js"></script>
    <script src="../datatable/dataTables.responsive.min.js"></script>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.1.3/materia/bootstrap.min.css"> -->
    <?php
    if ($page_title = "Loan Report") {
    } else {
    ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <?php
    }
    ?>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-177058907-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-177058907-1');
    </script>

    <style>
        div[data-acc-content] {
            display: none;
        }

        div[data-acc-step]:not(.open) {
            background: #f2f2f2;
        }

        div[data-acc-step]:not(.open) h5 {
            color: #777;
        }

        div[data-acc-step]:not(.open) .badge-primary {
            background: #ccc;
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>

<body>
    <div class="wrapper ">
        <div class="sidebar" data-color="purple" data-background-color="white">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
            <div class="logo" style="background-color: white;">
                <div class="col-xs-2">
                    <div class="card-profile">
                        <div class="card-avatar">
                            <a href="#picasso">
                                <img class="img" src="<?php echo $img; ?>" max-width="200px" width="100%" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sidebar-wrapper" style="background-color: white;">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="material-icons" style="color:#7f3f98">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <!-- <li class="nav-item dropdown">
                  <a class="nav-link" href="manage_client.php">
                    <i class="material-icons">person</i>
                    Register Client
                  </a> -->
                    <!-- <div class="dropdown-menu">
                  <a class="dropdown-item" href="client.php">Client List</a>
                  <a href="manage_client.php" class="dropdown-item">Register Client</a>
                </div> -->
                    <!-- </li> -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="customer_service.php">
                            <i class="material-icons" style="color:#7f3f98">supervised_user_circle</i>
                            Customer Service
                        </a>
                    </li>
                    <!-- <li class="nav-item dropdown">
                  <a class="nav-link" href="#">
                    <i class="material-icons">people</i>
                    Register Group
                  </a> -->
                    <!-- <div class="dropdown-menu">
                  <a class="dropdown-item" href="#">Group List</a>
                  <a href="#" class="dropdown-item">Register Group</a>
                </div> -->
                    <!-- </li> -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="transaction.php">
                            <i class="material-icons" style="color:#7f3f98">account_balance_wallet</i>
                            Transaction
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="approval.php">
                            <i class="material-icons" style="color:#7f3f98">library_books</i>
                            Approval
                        </a>
                    </li>
                    <!-- accounting is here -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="accounting.php">
                            <i class="material-icons" style="color:#7f3f98">menu_book</i>
                            Accounting
                        </a>
                    </li>
                    <!-- report is here now -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="reports.php">
                            <i class="material-icons" style="color:#7f3f98">content_paste</i>
                            Reports
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="bill_airtime.php">
                            <i class="material-icons" style="color:#7f3f98">description</i>
                            Bills & Airtime
                        </a>
                    </li>
                    <!-- end of report -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="configuration.php">
                            <i class="material-icons" style="color:#7f3f98">settings</i>
                            Configuration
                        </a>
                    </li>
                    <!-- Notification and Profile Begins !-->


                    <!-- Notification and Profile ends !-->

                    <!-- your sidebar here -->
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <div id="time_recorder"></div>
            <div id="r_bb" hidden></div>
            <div id="loan_remodel" hidden></div>
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <?php
                        if ($page_title == "Dashboard") {
                        ?>
                            <!-- <a class="btn btn-primary" href="#pablo"><i class="fa fa-caret-left"></i> Back</a> -->
                        <?php
                        } else { ?>

                            <a class="btn btn-primary" href="javascript:history.go(-1)">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-left-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5.5a.5.5 0 0 0 0-1H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5z" />
                                </svg>
                                Back
                            </a>


                            <!-- here -->

                        <?php
                        }
                        ?>
                        <?php
                        $br_id = $_SESSION["branch_id"];
                        ?>
                    </div>
                    <div class="d-inline">


                        <ul class="list-inline">


                            <li class="d-inline dropdown" style="margin-right: 20px;">
                                <!-- Notification for matured loans -->
                                <?php
                                $today = date('Y-m-d');
                                $institution = $_SESSION["int_id"];
                                $fom = mysqli_query($connection, "SELECT * FROM loan_repayment_schedule WHERE int_id = '$institution' AND duedate = '$today'");
                                $dn = mysqli_num_rows($fom);

                                $tomorrow = date('Y-m-d', strtotime($today . ' + 1 days'));
                                $fodm = mysqli_query($connection, "SELECT * FROM loan_repayment_schedule WHERE int_id = '$institution' AND duedate = '$tomorrow'");
                                $dfn = mysqli_num_rows($fodm);
                                ?>
                                <!-- Notification for client approval -->
                                <?php
                                function brii($connection)
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

                                $ghgd = brii($connection);
                                ?>
                                <?php
                                $query = "SELECT * FROM client JOIN staff ON client.loan_officer_id = staff.id 
                                        WHERE client.int_id = '$sessint_id' 
                                        AND client.status = 'Not Approved' AND (client.branch_id ='$br_id'$ghgd)";
                                $result = mysqli_query($connection, $query);
                                $approvd = mysqli_num_rows($result);
                                ?>
                                <!-- Notification for institution transactions -->
                                <?php
                                $sfsf = "SELECT * FROM transact_cache WHERE int_id = '$sessint_id' AND status = 'Pending' AND branch_id = '$br_id' AND transact_type != 'Expense'";
                                $sdwr = mysqli_query($connection, $sfsf);
                                $trans = mysqli_num_rows($sdwr);
                                ?>
                                <!-- Notification for expense transactions -->
                                <?php
                                $sfsfp = "SELECT * FROM transact_cache WHERE int_id = '$sessint_id' AND status = 'Pending' AND branch_id = '$br_id' AND transact_type = 'Expense'";
                                $sdwr = mysqli_query($connection, $sfsfp);
                                $expense = mysqli_num_rows($sdwr);
                                ?>
                                <!-- notification for client fund transfer -->
                                <?php
                                $sdf = "SELECT * FROM transfer_cache WHERE int_id = '$sessint_id' AND status = 'Pending' AND branch_id = '$br_id'";
                                $wyj = mysqli_query($connection, $sdf);
                                $client = mysqli_num_rows($wyj);
                                ?>
                                <!-- Notification for disbursed loans -->
                                <?php
                                $ruyj = "SELECT * FROM loan_disbursement_cache WHERE int_id = '$sessint_id' AND status = 'Pending'";
                                $eroi = mysqli_query($connection, $ruyj);
                                $loan = mysqli_num_rows($eroi);
                                ?>
                                <!-- Notificaion for charges -->
                                <?php
                                $fdef = "SELECT * FROM client_charge WHERE int_id = '$sessint_id' AND (branch_id ='$br_id') AND approved = '0'";
                                $sdf = mysqli_query($connection, $fdef);
                                $charge = mysqli_num_rows($sdf);
                                ?>
                                <!-- Notification for Groups -->
                                <?php
                                $ifdofi = "SELECT * FROM groups WHERE int_id = '$sessint_id' AND (branch_id ='$br_id') AND status = 'Pending'";
                                $fdio = mysqli_query($connection, $ifdofi);
                                $group = mysqli_num_rows($fdio);
                                ?>
                                <!-- Notification for FTD -->
                                <?php
                                $dsod = "SELECT * FROM ftd_booking_account WHERE int_id = '$sessint_id' AND (branch_id ='$br_id') AND status = 'Pending'";
                                $dsoe = mysqli_query($connection, $dsod);
                                $ftd = mysqli_num_rows($dsoe);
                                ?>
                                <!-- Notification for banner -->
                                <?php
                                $fomd = $dfn + $dn + $approvd + $trans + $client + $loan + $charge + $group + $ftd;
                                ?>
                                <a class="d-inline" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons" style="color: black;">notifications</i>
                                    <?php if ($fomd > 0) { ?>
                                        <span class="badge badge-danger"><?php echo $fomd; ?></span>
                                    <?php } ?>
                                </a>
                                <?php if ($fomd > 0) { ?>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                                        <?php
                                        if ($dfn > 0) {
                                        ?>
                                            <a class="dropdown-item" href="report_loan_view.php?view39b=<?php echo $tomorrow; ?>"><?php echo $dfn; ?>
                                                Loan(s) due tommorow</a>
                                        <?php }
                                        if ($dn > 0) {
                                        ?>
                                            <a class="dropdown-item" href="report_loan_view.php?view39=<?php echo $today; ?>"><?php echo $dn; ?>
                                                Loan(s) matured today</a>
                                        <?php }
                                        if ($approvd > 0) {
                                        ?>
                                            <a class="dropdown-item" href="client_approval.php"><?php echo $approvd; ?>
                                                client(s) in need of approval</a>
                                        <?php }
                                        if ($trans > 0) {
                                        ?>
                                            <a class="dropdown-item" href="transact_approval.php"><?php echo $trans; ?>
                                                transaction(s) in need of approval</a>
                                        <?php }
                                        if ($expense > 0) {
                                        ?>
                                            <a class="dropdown-item" href="expense_approval.php"><?php echo $expense; ?>
                                                Expense(s) in need of approval</a>
                                        <?php }
                                        if ($client > 0) {
                                        ?>
                                            <a class="dropdown-item" href="transfer_approval.php"><?php echo $client; ?>
                                                client transfer(s) in need of approval</a>
                                        <?php }
                                        if ($loan > 0) {
                                        ?>
                                            <a class="dropdown-item" href="disbursement_approval.php"><?php echo $loan; ?>
                                                Loans disbursement(s) in need of approval</a>
                                        <?php }
                                        if ($charge > 0) {
                                        ?>
                                            <a class="dropdown-item" href="charge_approval.php"><?php echo $charge; ?>
                                                charge(s) in need of approval</a>
                                        <?php
                                        }
                                        if ($group > 0) {
                                        ?>
                                            <a class="dropdown-item" href="approve_group.php"><?php echo $group; ?> Group(s)
                                                in need of approval</a>
                                        <?php
                                        }
                                        if ($ftd > 0) {
                                        ?>
                                            <a class="dropdown-item" href="ftd_approval.php"><?php echo $ftd; ?> FTD
                                                Accounts in need of approval</a>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                <?php } ?>
                            </li>
                            <!-- user setup -->

                            <li class="d-inline dropdown">
                                <a class="d-inline" style="color: black; margin-right: 25px" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">


                                    <i class="material-icons">person</i>
                                    <!-- Insert user display name here -->
                                    <!-- <p class="d-lg-none d-md-block"> -->
                                    <?php echo $_SESSION["username"]; ?>
                                    <!-- </p> -->
                                </a>
                                <div class="dropdown-menu dropdown-menu-right rgba-red-strong" style="background-color: grey; width:min-content;   height:auto;" aria-labelledby="navbarDropdownProfile">
                                    <a class="dropdown-item" style="color: white;" href="profile.php">Profile</a>
                                    <a class="dropdown-item" style="color: white;" href="settings.php">Settings</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" style="color: white;" href="../functions/logout.php">Log
                                        out</a>
                                </div>
                            </li>

                            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="navbar-toggler-icon icon-bar"></span>
                                <span class="navbar-toggler-icon icon-bar"></span>
                                <span class="navbar-toggler-icon icon-bar"></span>
                            </button>

                            <!-- your navbar here -->
                        </ul>
                    </div>
                </div>
            </nav>