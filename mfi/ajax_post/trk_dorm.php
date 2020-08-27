<?php
include("../../functions/connect.php");
$output = '';
session_start();
// Declare Variables
$int_name = $_SESSION['int_name'];
$branch_id = $_POST['bran'];
$dorm_days = $_POST['dorm'];
$dss = mysqli_query($connection, "SELECT * FROM branch WHERE id = '$branch_id'");
$fdo = mysqli_fetch_array($dss);
$branch = $fdo['name'];

$output = '<div class="col-md-12">
<div class="card">
  <div class="card-header card-header-primary">
    <h4 class="card-title">'.$int_name." ".$branch.'</h4>
    <p class="card-category">Accounts Dormant for '.$dorm_days.' days</p>
  </div>
  <div class="card-body">
    <!-- sup -->
    <!-- hello -->
    <form action="../composer/inventory_schedule.php" method="POST">
      <div class="clearfix"></div>
    
    <div class="table-responsive">
      <table id="tabledat4" class="table table-bordered" style="width: 100%;">
      <thead class=" text-primary">
      <tr>
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
      Phone
    </th>
    <th>
      Days Dormant
    </th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
    <hr>
    <p>
    <div id=""></div>
    </p>
    </form>
  </div>
</div>
</div>
';
echo $output;
?>