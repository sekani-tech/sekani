<?php
    session_start();
    if(!$_SESSION["usertype"] == "admin"){
      header("location: ../login.php");
      exit;
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
if (count([$getip]) == 1) {
  $x = mysqli_fetch_array($getip);
  $vm = $n['trial'];
  
  if ($vm >= 3) {
      $_SESSION = array();
     // Destroy the session.
     session_destroy();
     $URL="ip/block_ip.php";
     echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
  } else {
      $newcode = $vm + 1;
      $mmm = mysqli_query($connection, "UPDATE ip_blacklist SET trial = '$newcode' WHERE ip_add = '$ip'");
  }
}
?>
<?php
  // get connections for all pages
  include("../functions/connect.php");
  $sessint_id = $_SESSION["int_id"];
  $inq = mysqli_query($connection, "SELECT * FROM institutions WHERE int_id='$sessint_id'");
    if (count([$inq]) == 1) {
      $n = mysqli_fetch_array($inq);
      $int_name = $n['int_name'];
      $img = $n['img'];
    }
?>
<?php
//active user
$activecode = "Active";
// working on the time stamp right now
$ts = date('Y-m-d H:i:s');
$acuser = $_SESSION["username"];
$activeq = "UPDATE users SET users.status ='$activecode', users.last_logged = '$ts' WHERE users.username ='$acuser'";
$rezz = mysqli_query($connection, $activeq);
?>
<!doctype html>
<html lang="en">

<head>
  <title><?php echo "$int_name - $page_title"?></title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
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
  <script src="../datatable/DropdownSelect.js"></script>
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
                    <img class="img" src="../instimg/<?php echo $img; ?>" />
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
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" href="#" aria-haspopup="true" aria-expanded="false">
              <i class="material-icons">person</i>
              Client
            </a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="client.php">Client List</a>
              <a href="manage_client.php" class="dropdown-item">Register Client</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" href="#" aria-haspopup="true" aria-expanded="false">
              <i class="material-icons">people</i>
              Group
            </a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="#">Group List</a>
              <a href="#" class="dropdown-item">Register Group</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" href="#" aria-haspopup="false" aria-expanded="fasle">
              <i class="material-icons">account_balance_wallet</i>
              Transaction
            </a>
            <div class="dropdown-menu">
              <a href="transact.php" class="dropdown-item">Deposit/Withdrwal</a>
              <a href="#" class="dropdown-item">FTD Booking</a>
              <a href="lend.php" class="dropdown-item">Book Loan</a>
              <a href="#" class="dropdown-item">Expense Posting</a>
              <a href="teller_journal.php" class="dropdown-item">Internal Posting</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" href="#" aria-haspopup="false" aria-expanded="fasle">
              <i class="material-icons">library_books</i>
              Approval
            </a>
            <div class="dropdown-menu">
              <a href="#" class="dropdown-item">Account Opening</a>
              <a href="transact_approval.php" class="dropdown-item">Transactions</a>
              <a href="disbursement_approval.php" class="dropdown-item">Loan disbursement</a>
            </div>
          </li>
          <!-- accounting is here -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
              <i class="material-icons">menu_book</i>
              Accounting
            </a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="chart_account.php">Chart Of Accounts</a>
              <!-- <a class="dropdown-item" href="config.php">Configuration</a> -->
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Journals</a>
              <a class="dropdown-item" href="#">Journal Template</a>
              <!-- <a class="dropdown-item" href="#">Group</a> -->
              <a class="dropdown-item" href="#">Reconciliation</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Teller Management</a>
              <a class="dropdown-item" href="#">Accounting Export</a>
              <a class="dropdown-item" href="#">Periodic Accural</a>
              <a class="dropdown-item" href="#">Close Periods</a>
            </div>
          </li>
          <!-- ending of accounting -->
          <li class="nav-item dropdown">
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
          </li>
          <!-- report is here now -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
              <i class="material-icons">content_paste</i>
              Reports
            </a>
            <div class="dropdown-menu">
              <a href="#" class="dropdown-item">Client Report</a>
              <a href="#" class="dropdown-item">Group Report</a>
              <a href="#" class="dropdown-item">Savings Report</a>
              <a href="#" class="dropdown-item">Current Accounts Report</a>
              <a href="loans.php" class="dropdown-item">Loan reoprts</a>
              <a href="#" class="dropdown-item">Finacial reoprt</a>
              <a href="#" class="dropdown-item">Audit</a>
              <a href="teller.php" class="dropdown-item">Teller</a>
            </div>
          </li>
          <!-- end of report -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
              <i class="material-icons">settings</i>
              Configuration
            </a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="products_config.php">Products</a>
              <!-- <a class="dropdown-item" href="config.php">Configuration</a> -->
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="staff_mgmt.php">Staff Mgt.</a>
              <a class="dropdown-item" href="branch.php">Branch</a>
              <!-- <a class="dropdown-item" href="#">Group</a> -->
              <!-- <a class="dropdown-item" href="chart_account.php">Accounting</a> -->
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Alerts</a>
            </div>
          </li>
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

              <a class="btn btn-primary" href="<?php echo $destination ?>"><i class="fa fa-caret-left"></i> Back</a>
              
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
              <li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <i class="material-icons">notifications</i>
                </a>
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