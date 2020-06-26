<?php
    session_start();
    if(!$_SESSION["usertype"] == "admin"){
      header("location: ../login.php");
      exit;
  }
  $staff_id = $_SESSION["staff_id"];
?>

<?php
  // get connections for all pages
  include("../functions/connect.php");
  $sessint_id = $_SESSION["int_id"];
  $branch_id = $_SESSION["branch_id"];
  $inq = mysqli_query($connection, "SELECT * FROM institutions WHERE int_id='$sessint_id'");
    if (count([$inq]) == 1) {
      $n = mysqli_fetch_array($inq);
      $int_name = $n['int_name'];
      $img = $n['img'];
    }
?>
<?php
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
  $bch_id = $_SESSION["branch_id"];
}
?>
<?php
// checking if IP has been Blocked
function getIPAddress() {
  //whether ip is from the share internet  
   if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
          $ip = $_SERVER['HTTP_CLIENT_IP'];  
      }  
  //whether ip is from the proxy  
  else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
          $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
   }  
//whether ip is from the remote address  
  else{  
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
     $URL="../ip/block_ip.php";
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
<!doctype html>
<html lang="en">

<head>
  <title><?php echo "$int_name - $page_title"?></title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <!-- <meta http-equiv="refresh" content="1000;url=../functions/logout.php" /> -->
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- Material Kit CSS -->
  <link href="../assets/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
  <!-- accordion -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="../datatable/jquery-3.3.2.js"></script>
  <script src="../datatable/jquery.dataTables.min.js"></script>
  <script src="../datatable/dataTables.bootstrap.min.js"></script>
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.1.3/materia/bootstrap.min.css"> -->
  <style>
    div[data-acc-content] { display: none;  }
    div[data-acc-step]:not(.open) { background: #f2f2f2;  }
    div[data-acc-step]:not(.open) h5 { color: #777;  }
    div[data-acc-step]:not(.open) .badge-primary { background: #ccc;  }
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
      <div class="logo">
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
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="material-icons">dashboard</i>
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
              <i class="material-icons">supervised_user_circle</i>
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
              <i class="material-icons">account_balance_wallet</i>
              Transaction
            </a>
          </li>
          <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" href="#" aria-haspopup="false" aria-expanded="fasle">
              <i class="material-icons">account_balance_wallet</i>
              Transaction
            </a>
            <div class="dropdown-menu">
              <a href="transact.php" class="dropdown-item">Deposit/Withdrawal</a>
              <a href="#" class="dropdown-item">FTD Booking</a>
              <a href="lend.php" class="dropdown-item">Book Loan</a>
              <a href="cheque_book_posting.php" class="dropdown-item">CHQ/Pass Book Posting</a>
              <a href="teller_journal.php" class="dropdown-item">Vault Posting</a>
            </div>
          </li> -->
          <li class="nav-item dropdown">
            <a class="nav-link" href="approval.php">
              <i class="material-icons">library_books</i>
              Approval
            </a>
          </li>
          <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" href="#" aria-haspopup="false" aria-expanded="fasle">
              <i class="material-icons">library_books</i>
              Approval
            </a>
            <div class="dropdown-menu">
              <a href="client_approval.php" class="dropdown-item">Account Opening</a>
              <a href="transact_approval.php" class="dropdown-item">Transactions</a>
              <a href="#" class="dropdown-item">CHQ/Pass Book</a>
              <a href="disbursement_approval.php" class="dropdown-item">Loan disbursement</a>
            </div>
          </li> -->
          <!-- accounting is here -->
          <li class="nav-item dropdown">
            <a class="nav-link" href="accounting.php">
              <i class="material-icons">menu_book</i>
              Accounting
            </a>
          </li>
          <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
              <i class="material-icons">menu_book</i>
              Accounting
            </a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="chart_account.php">Chart Of Accounts</a>
              <div class="dropdown-divider"></div>
              <a href="inventory.php" class="dropdown-item">Inventory Posting</a>
              <a class="dropdown-item" href="#">Asset Register</a>
              <a class="dropdown-item" href="#">Reconciliation</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Accounting Export</a>
              <a class="dropdown-item" href="#">Periodic Accural</a>
              <a class="dropdown-item" href="#">Close Periods</a>
            </div>
          </li> -->
          <!-- ending of accounting -->
          <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
              <i class="material-icons">bubble_chart</i>
              Products Summary
            </a>
            <div class="dropdown-menu">
              <a href="#" class="dropdown-item">Savings Account</a>
              <a href="#" class="dropdown-item">Current Account</a>
              <a href="#" class="dropdown-item">Fixed Desposit</a>
              <a href="#" class="dropdown-item">Shares</a>
              <a href="loans.php" class="dropdown-item">Loans</a>
            </div>
          </li> -->
          <!-- report is here now -->
          <li class="nav-item dropdown">
            <a class="nav-link" href="reports.php">
              <i class="material-icons">content_paste</i>
              Reports
            </a>
          </li>
          <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
              <i class="material-icons">content_paste</i>
              Reports
            </a>
            <div class="dropdown-menu">
              <a href="report_client.php" class="dropdown-item">Client Report</a>
              <a href="report_group.php" class="dropdown-item">Group Report</a>
              <a href="report_savings.php" class="dropdown-item">Savings Report</a>
              <a href="report_current.php" class="dropdown-item">Current Accounts Report</a>
              <a href="report_loan.php" class="dropdown-item">Loan reports</a>
              <a href="report_financial.php" class="dropdown-item">Financial report</a>
              <a href="report_fixed_deposit.php" class="dropdown-item">Fixed Deposit Report</a>
              <a href="report_institution.php" class="dropdown-item">Institutional Report</a>
            </div>
          </li> -->
          <!-- end of report -->
          <li class="nav-item dropdown">
            <a class="nav-link" href="configuration.php">
              <i class="material-icons">settings</i>
              Configuration
            </a>
          </li>
          <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
              <i class="material-icons">settings</i>
              Configuration
            </a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="products_config.php">Products</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="staff_mgmt.php">Staff Mgt.</a>
              <a class="dropdown-item" href="branch.php">Branch</a>
              <a class="dropdown-item" href="#">Alerts</a>
            </div>
          </li> -->
          <!-- another -->
          <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="javascript:;" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>
            
          </li> -->
          <!-- your sidebar here -->
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <?php
              if($page_title == "Dashboard"){
            ?>
            <!-- <a class="btn btn-primary" href="#pablo"><i class="fa fa-caret-left"></i> Back</a> -->
            <?php
              }else{            ?>

              <a class="btn btn-primary" href="javascript:history.go(-1)"><i class="fa fa-caret-left"></i> Back</a>
              
              <?php
                }
              ?>
          
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
            <li class="nav-item dropdown">
            <?php
                $today = date('Y-m-d');
                $fom = mysqli_query($connection, "SELECT * FROM loan WHERE repayment_date = '$today'");
                $dn = mysqli_num_rows($fom);

                $tomorrow = date( 'Y-m-d' , strtotime ( $today . ' + 1 days' ));
                $fodm = mysqli_query($connection, "SELECT * FROM loan WHERE repayment_date = '$tomorrow'");
                $dfn = mysqli_num_rows($fodm);
                $fomd = $dfn + $dn;
                ?>
                <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">notifications</i>
                  <?php if($fomd > 0){?>
                  <span class="badge badge-danger"><?php echo $fomd;?></span>
                  <?php }?>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <a class="dropdown-item" href="report_loan_view.php?view39"><?php echo $dn;?> Loans matured today</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#"><?php echo $dfn;?> Loans due tommorow</a>
                </div>
              </li>
              <!-- user setup -->
              <li class="nav-item dropdown">
                <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">person</i>
                  <!-- Insert user display name here -->
                  <!-- <p class="d-lg-none d-md-block"> -->
                    <?php echo $_SESSION["username"]; ?>
                  <!-- </p> -->
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <a class="dropdown-item" href="#">Profile</a>
                  <a class="dropdown-item" href="#">Settings</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="../functions/logout.php">Log out</a>
                </div>
              </li>
              <!-- your navbar here -->
            </ul>
          </div>
        </div>
      </nav>