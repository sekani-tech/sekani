<?php

$page_title = "View Client";
$destination = "client.php";
include('header.php');

?>
<?php
if(isset($_GET["edit"])) {
  $id = $_GET["edit"];
  $update = true;
  $person = mysqli_query($connection, "SELECT * FROM client WHERE id='$id'");
  if (count([$person]) == 1) {
    $n = mysqli_fetch_array($person);
    $ctype = $n['client_type'];
    $display_name = $n['display_name'];
    $first_name = $n['firstname'];
    $middle_name = $n['middlename'];
    $last_name = $n['lastname'];
    $acc_no = $n['account_no'];
    $loanofficer_id =$n['loan_officer_id'];
    $phone = $n['mobile_no'];
    $phone2 = $n['mobile_no_2'];
    $email = $n['email_address'];
    $address = $n['ADDRESS'];
    $gender = $n['gender'];
    $date_of_birth = $n['date_of_birth'];
    $branch = $n['branch_id'];
    $country = $n['COUNTRY'];
    $state = $n['STATE_OF_ORIGIN'];
    $lga = $n['LGA'];
    $bvn = $n['BVN'];
    $sms_active = $n['SMS_ACTIVE'];
    $email_active = $n['EMAIL_ACTIVE'];
    $id_card = $n['id_card'];
    $passport = $n['passport'];
    $acount = mysqli_query($connection, "SELECT * FROM staff WHERE user_id='$loanofficer_id'");
    if (count([$acount]) == 1) {
      $j = mysqli_fetch_array($acount);
      $displayname = $j['display_name'];
    }
    // $signature = $n['signature'];
    // $id_img_url = $n['id_img_url'];
  }
}
?>
<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Account</h4>
                </div>
                <div class="card-body">
                  <form action="">
                    <div class="form-group">
                      <label for="">Name:</label>
                      <input type="text" name="" id="" class="form-control" value="<?php echo $display_name; ?>" readonly name="display_name">
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Account No:</label>
                          <input type="text" name="" id="" class="form-control" value="<?php echo $acc_no; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Account Officer:</label>
                          <input type="text" name="" id="" class="form-control" value="<?php echo $displayname; ?>" readonly>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Account Summary</h4>
                </div>
                <div class="card-body">
                <form action="">
                    <div class="form-group">
                      <label for="">Current Balance:</label>
                      <input type="text" name="" id="" class="form-control" value="200000" readonly>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Last Deposit:</label>
                          <input type="text" name="" id="" class="form-control" value="0" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Last Withdrawal:</label>
                          <input type="text" name="" id="" class="form-control" value="2500" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Quaterly Fee Owed:</label>
                          <input type="text" name="" id="" class="form-control" value="2500" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Total Deposit:</label>
                          <input type="text" name="" id="" class="form-control" value="2500" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Total Outstanding Loan balance:</label>
                          <input type="text" name="" id="" class="form-control" value="2500" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Total Withdrawal:</label>
                          <input type="text" name="" id="" class="form-control" value="2500" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Total Amoount payed:</label>
                          <input type="text" name="" id="" class="form-control" value="2500" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Total Charges:</label>
                          <input type="text" name="" id="" class="form-control" value="2500" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Total Interest Earned:</label>
                          <input type="text" name="" id="" class="form-control" value="2500" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Amount in Arrears</label>
                          <input type="text" name="" id="" class="form-control" value="2500" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Days in Arrears</label>
                          <input type="text" name="" id="" class="form-control" value="2500" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Collateral Value</label>
                          <input type="text" name="" id="" class="form-control" value="2500" readonly>
                        </div>
                      </div>
                    </div>
                    <a href="lend.php" class="btn btn-primary">Disburse Loan</a>
                    <a href="#" class="btn btn-primary">Generate Account Report</a>
                    <a href="update_client.php?edit=<?php echo $id;?>" class="btn btn-primary">Edit CLient</a>
                    <a href="client.php" class="btn btn-primary pull-right">Back</a>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card card-profile">
                <div class="card-avatar">
                  <a href="#pablo">
                    <img class="img" src="../functions/clients/<?php echo $passport;?>" />
                  </a>
                </div>
                <!-- Get session data and populate user profile -->
                <div class="card-body">
                  <h6 class="card-category text-gray">Account Name</h6>
                  <h6><?php echo $display_name; ?></h6>
                  <h4 class="card-title">Client Name</h4>
                  <h4><?php echo $display_name; ?></h4>
                  <p class="card-description">
                    Account Balance
                  </p>
                  <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

<?php

include('footer.php');

?>