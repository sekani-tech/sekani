<?php
    session_start();
    include "path.php";
    if(!$_SESSION["usertype"] == "super_admin"){
      header("location: login.php");
      exit;
  }
  if ($_SESSION["usertype"] == "admin") {
    header("location: mfi/index.php");
    exit;
  } else if ($_SESSION["usertype"] == "staff") {
    header("location: mfi/index.php");
    exit;
  }

  // get connections for all pages
  include(ROOT_PATH."/functions/connect.php");

//active user
$activecode = "Active";
// working on the time stamp right now
$ts = date('Y-m-d H:i:s');
$acuser = $_SESSION["username"];
$tableName = "users";
$condtions = ['status' => $activecode,
    'last_logged' => $ts,
    ];
// $rezz = update("users", $acuser, "username", $condtions);
$activeq = "UPDATE users SET users.status ='$activecode', users.last_logged = '$ts' WHERE users.username ='$acuser'";
$rezz = mysqli_query($connection, $activeq);

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
if (mysqli_num_rows($getip) === 1) {
  $gtp = mysqli_query($connection, "SELECT * FROM ip_blacklist WHERE ip_add = '$ip'");
            if (count([$gtp]) === 1) {
            $x = mysqli_fetch_array($gtp);
            $vm = $x['trial'];
            }
  
  if ($vm >= 3) {
      $_SESSION = array();
     // Destroy the session.
     session_destroy();
     $URL="ip/block_ip.php";
     echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <title>Sekani</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" href="assets/css/material_icons.css">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
  <!-- <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" /> -->
  <link rel="stylesheet" href="assets/css/all.css">
  <!-- Material Kit CSS -->
  <link href="assets/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
  <script src="datatable/sweetalert.min.js"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="datatable/jquery.dataTables.min.css">
    <link rel="stylesheet" href="datatable/rowReorder.dataTables.min.css">
    <link rel="stylesheet" href="datatable/responsive.dataTables.min.css">
    
    <!-- DATATABLE CODE -->
    <script src="datatable/jquery.dataTables.min.js"></script>
    <script src="datatable/dataTables.rowReorder.min.js"></script>
    <script src="datatable/dataTables.responsive.min.js"></script>
  <script src="datatable/DropdownSelect.js"></script>
  <script src="datatable/stepper.js"></script>
</head>

<body>
  <div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="white">
      <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
      <!-- <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          CT
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          Creative Tim
        </a>
      </div> -->
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="material-icons">dashboard</i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="users.php">
            <i class="material-icons">person</i>
              <p>Staff</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="institution.php">
              <i class="material-icons">house</i>
              <p>Institutions</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="general_refill.php">
              <i class="material-icons">business</i>
              <p>Wallet Refill</p>
            </a>
          </li>
          <!-- your sidebar here -->
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <!-- <a class="navbar-brand" href="#pablo">Dashboard</a> -->
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
              <!-- user config -->
              <li class="nav-item dropdown">
                <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">person</i>
                  <!-- insert user name here -->
                  <p class="d-lg-none d-md-block">
                    User
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <a class="dropdown-item" href="#">Profile</a>
                  <a class="dropdown-item" href="#">Settings</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="functions/logout.php">Log out</a>
                </div>
              </li>
              <!-- your navbar here -->
            </ul>
          </div>
        </div>
      </nav>