<?php

$page_title = "Client Statement";
$destination = "client.php";
include('header.php');

if(isset($_GET["edit"])) {
  $id = $_GET["edit"];
  $person = mysqli_query($connection, "SELECT * FROM client WHERE id='$id' && int_id ='$sessint_id'");
  if (count([$person]) == 1) {
    $n = mysqli_fetch_array($person);
    $ctype = $n['client_type'];
    $branch = $n['branch_id'];
    $display_name = $n['display_name'];
    $first_name = $n['firstname'];
    $middle_name = $n['middlename'];
    $last_name = $n['lastname'];
    $acc_no = $n['account_no'];
    $actype = $n['account_type'];
    $phone = $n['mobile_no'];
    $phone2 = $n['mobile_no_2'];
    $email = $n['email_address'];
    $date_of_birth = $n['date_of_birth'];
    $sms_active = $n['SMS_ACTIVE'];
    $email_active = $n['EMAIL_ACTIVE'];
    $branchid = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch'");
    if (count([$branchid]) == 1) {
      $a = mysqli_fetch_array($branchid);
      $branch_name = strtoupper($a['name']);
      $branch_address = $a['location'];
    }
    $acount = mysqli_query($connection, "SELECT * FROM account WHERE account_no='$acc_no'");
    if (count([$acount]) == 1) {
      $b = mysqli_fetch_array($acount);
      $currtype = $b['currency_code'];
    }
  }
}
session_start();
                            
    // Store data in session variables
    session_regenerate_id();
    $_SESSION["loggedin"] = true;
    $_SESSION["client_id"] = $id;
?>

<!-- Content added here -->
<!-- print content -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
            <div class="col-md-12">
                <div style="padding-left:20px;" class="card">
                  <div class="row">
                      <div class="col-md-6">
                        <h6 class="card-category text-gray">Branch name</h6>
                          <h4><?php echo $branch_name;?></h4>
                        <h6 class="card-category text-gray">Client name</h6>
                          <h4><?php echo $first_name," ", $last_name;?></h4>
                          <h6 class="card-category text-gray">Client Number</h6>
                          <h4><?php echo $phone;?></h4>
                        <h6 class="card-category text-gray">Currency</h6>
                          <h4><?php echo $currtype;?></h4>
                        <h6 class="card-category text-gray">Total debit</h6>
                          <!-- <h4><?php echo $actype;?></h4> -->
                          <h4>N 13145500</h4>
                        <h6 class="card-category text-gray">Total credit</h6>
                          <!-- <h4><?php echo $actype;?></h4> -->
                          <h4>N 12167500</h4>
                    </div>

                    <div class="col-md-6">
                      <h6 class="card-category text-gray">Branch address</h6>
                        <h4><?php echo $branch_address?></h4>
                        <h6 class="card-category text-gray">Email</h6>
                        <h4><?php echo $email;?></h4>
                      <h6 class="card-category text-gray">Account number</h6>
                        <h4><?php echo $acc_no;?></h4>
                      <h6 class="card-category text-gray">Opening balance</h6>
                        <!-- <h4><?php echo $actype;?></h4> -->
                        <h4>N 503965</h4>
                      <h6 class="card-category text-gray">Closing balance</h6>
                      <!-- <h4><?php echo $actype;?></h4> -->
                      <h4>N 493824</h4>
                      <h6 class="card-category text-gray">Statement period</h6>
                      <h4>01/01/2020 - 01/30/2020</h4>
                    </div>
                  </div>
                <!-- /account statement -->
                <br>
              </div>
          </div>
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Account Statement</h4>
                </div>
                <div class="card-body">
                <div class="form-group">
                  <form method="POST" action="../TCPDF/dbtable.php">
                      <label for="">Name:</label>
                      <input class="form-control" type="text" value=<?php echo $first_name," ", $last_name;?> readonly/>
                    
                  <a href="../TCPDF/pdf.php?edit=<?php echo $id;?>" class="btn btn-primary pull-left">Download PDF</a>
                  </form>
                    </div>
                    <div class="table-responsive">
                    <script>
                  $(document).ready(function() {
                  $('#tabledat2').DataTable();
                  });
                  </script>
                    <table id="tabledat2" class="table" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT users.id, users.int_id, display_name, users.username, staff.int_name, staff.email, users.status, staff.employee_status FROM staff JOIN users ON users.id = staff.user_id WHERE users.int_id ='$sessint_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <!-- <th>
                          ID
                        </th> -->
                        <th>Transaction Date</th>
                        <th>Value Date</th>
                        <th>Reference</th>
                        <th>Debits</th>
                        <th>Credits</th>
                        <th>Balance</th>
                        <!-- <th>Phone</th> -->
                      </thead>
                      <tbody>
                        <tr>
                          <th>01/04/2020</th>
                          <th>01/04/2020</th>
                          <th>Credit transaction</th>
                          <th>34500</th>
                          <th></th>
                          <th>497965</th>
                        </tr>
                        <tr>
                          <th>01/07/2020</th>
                          <th>01/07/2020</th>
                          <th>Function Party</th>
                          <th></th>
                          <th>35000</th>
                          <th>463965</th>
                        </tr>
                      <!-- <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo $row["display_name"]; ?></th>
                          <th><?php echo $row["username"]; ?></th>
                          <th><?php echo $row["int_name"]; ?></th>
                          <th><?php echo $row["email"]; ?></th>
                          <th><?php echo $row["status"]; ?></th>
                          <th><?php echo $row["employee_status"]; ?></th>
                        </tr>
                        <?php }
                          }
                          else {
                            echo "0 Staff";
                          }
                          ?> -->
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            
        </div>
      </div>

<?php

include('footer.php');

?>