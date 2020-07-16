<?php

$page_title = "View Client";
$destination = "client.php";
include('header.php');
session_start();

?>
<?php
if(isset($_GET["edit"])) {
  $id = $_GET["edit"];
  $update = true;
  $person = mysqli_query($connection, "SELECT * FROM client WHERE id='$id' && int_id ='$sessint_id'");
  if (count([$person]) == 1) {
    $n = mysqli_fetch_array($person);
    $ctype = $n['client_type'];
    $display_name = $n['display_name'];
    $first_name = $n['firstname'];
    $middle_name = $n['middlename'];
    $last_name = $n['lastname'];
    $acc_no = $n['account_no'];
    $loanofficer_id = $n['loan_officer_id'];
    $phone = $n['mobile_no'];
    $phone2 = $n['mobile_no_2'];
    $email = $n['email_address'];
    $address = $n['ADDRESS'];
    $gender = $n['gender'];
    $date_of_birth = $n['date_of_birth'];
    $branch = $n['branch_id'];
    $fo = mysqli_query($connection, "SELECT name FROM branch WHERE id = '$branch'");
    $e = mysqli_fetch_array($fo);
    $branch_name = $e['name'];
    $country = $n['COUNTRY'];
    $state = $n['STATE_OF_ORIGIN'];
    $lga = $n['LGA'];
    $bvn = $n['BVN'];
    $sms_active = $n['SMS_ACTIVE'];
    $email_active = $n['EMAIL_ACTIVE'];
    $id_card = $n['id_card'];
    $passport = $n['passport'];
    $acount = mysqli_query($connection, "SELECT * FROM staff WHERE id='$loanofficer_id'");
    if (count([$acount]) == 1) {
      $j = mysqli_fetch_array($acount);
      $displayname = strtoupper($j['first_name'] ." ". $j['last_name']);
    }
    $signature = $n['signature'];
    $id_img_url = $n['id_img_url'];

    $getacctv = mysqli_query($connection, "SELECT * FROM account WHERE account_no='$acc_no' && int_id='$sessint_id'");
    if (count([$getacctv]) == 1) {
      $xrx = mysqli_fetch_array($getacctv);
      $abd = $xrx['account_balance_derived'];
      $tdd = $xrx['last_deposit'];
      $twd = $xrx['last_withdrawal'];
      $gogo = mysqli_query($connection, "SELECT * FROM loan WHERE client_id = '$id' && int_id='$sessint_id'");
      if (count([$gogo]) == 1) {
        $ppo = mysqli_fetch_array($gogo);
        $sum = $ppo['total_outstanding_derived'];
        $olb = $ppo['principal_amount'];
        $prd = $ppo['principal_repaid_derived'];
        $cv = "Null";
      }
    }

      $soc = $n["account_no"];
      $length = strlen($soc);
      if ($length == 1) {
        $acc ="000000000" . $soc;
      }
      elseif ($length == 2) {
        $acc ="00000000" . $soc;
      }
      elseif ($length == 3) {
        $acc ="00000000" . $soc;
      }
      elseif ($length == 4) {
        $acc ="0000000" . $soc;
      }
      elseif ($length == 5) {
        $acc ="000000" . $soc;
      }
      elseif ($length == 6) {
        $acc ="0000" . $soc;
      }
      elseif ($length == 7) {
        $acc ="000" . $soc;
      }
      elseif ($length == 8) {
        $acc ="00" . $soc;
      }
      elseif ($length == 9) {
        $acc ="0" . $soc;
      }
      elseif ($length == 10) {
        $acc = $n["account_no"];
      }else{
        $acc = $n["account_no"];
      }
  }
}
?>
<?php
    function fill_account($connection) {
      $int_id = $_SESSION['int_id'];
       $client_id = $_GET['edit'];
       $pen = "SELECT * FROM account WHERE client_id = '$client_id'";
      $res = mysqli_query($connection, $pen);
      $out = '';
      while ($row = mysqli_fetch_array($res))
      {
        $product_type = $row["product_id"];
        $get_product = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$product_type' AND int_id = '$int_id'");
       while ($mer = mysqli_fetch_array($get_product)) {
         $p_n = $mer["name"];
         $out .= '<option value="'.$row["id"].'">'.$row["account_no"].' - '.$p_n.'</option>';
       }
      }
      return $out;
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
                <?php
                if($ctype == 'INDIVIDUAL' || $ctype == 'GROUP')
                {
                  ?>
                <div class="card-body">
                  <form action="">
                    <div class="form-group">
                      <label for="">Name:</label>
                      <input type="text" name="" id="" style="text-transform: uppercase;" class="form-control" value="<?php echo $display_name; ?>" readonly name="display_name">
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Account No:</label>
                            <select class="form-control">
                              <?php echo fill_account($connection);?>
                            </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Account Officer:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $displayname; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Account Type:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $ctype; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Date of Birth:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $date_of_birth; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Gender:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $gender; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Address:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $address; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Mobile Number:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $phone; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Email Address:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $email; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">State:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $state; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">LGA:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $lga; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">BVN:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $bvn; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Account:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $bvn; ?>" readonly>
                        </div>
                      </div>
                    </div>
                    <a href="update_client.php?edit=<?php echo $id;?>" class="btn btn-primary">Edit Client</a>
                    <a href="add_account.php?edit=<?php echo $id;?>" class="btn btn-primary">Add Account to client</a>
                  </form>
                </div>
                <?php
                }
                else if($ctype == 'CORPORATE')
                {
                  $id = $_GET["edit"];
                  $update = true;
                  $person = mysqli_query($connection, "SELECT * FROM client WHERE id='$id' && int_id ='$sessint_id'");
                  if (count([$person]) == 1) {
                    $t = mysqli_fetch_array($person);
                    $emaila = $t['email_address'];
                    $dob = $t['date_of_birth'];
                    $rc_number = $t['rc_number'];
                    $sig_one = $t['sig_one'];
                    $sig_two = $t['sig_two'];
                    $sig_three = $t['sig_three'];
                    $sig_address_one = $t['sig_address_one'];
                    $sig_address_two = $t['sig_address_two'];
                    $sig_address_three = $t['sig_address_three'];
                    $sig_phone_one = $t['sig_phone_one'];
                    $sig_phone_two = $t['sig_phone_two'];
                    $sig_phone_three = $t['sig_phone_three'];
                    $sig_gender_one = $t['sig_gender_one'];
                    $sig_gender_two = $t['sig_gender_two'];
                    $sig_gender_three = $t['sig_gender_three'];
                    $sig_state_one = $t['sig_state_one'];
                    $sig_state_two = $t['sig_state_two'];
                    $sig_state_three = $t['sig_state_three'];
                    $sig_lga_one = $t['sig_lga_one'];
                    $sig_lga_two = $t['sig_lga_two'];
                    $sig_lga_three = $t['sig_lga_three'];
                    $sig_occu_one = $t['sig_occu_one'];
                    $sig_occu_two = $t['sig_occu_two'];
                    $sig_occu_three = $t['sig_occu_three'];
                    $sig_bvn_one = $t['sig_bvn_one'];
                    $sig_bvn_two = $t['sig_bvn_two'];
                    $sig_bvn_three = $t['sig_bvn_three'];
                    $l_officer = $t['loan_officer_id'];
                    $acount = mysqli_query($connection, "SELECT * FROM staff WHERE id='$l_officer'");
                    if (count([$acount]) == 1) {
                      $r = mysqli_fetch_array($acount);
                      $acc_off = strtoupper($r['first_name'] ." ". $j['last_name']);
                    }
                  }
                  ?>
                <div class="card-body">
                <div class="form-group">
                      <label for="">Registered Name:</label>
                      <input type="text" name="" id="" style="text-transform: uppercase;" class="form-control" value="<?php echo $display_name; ?>" readonly name="display_name">
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">RC Number:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $rc_number; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Account Number:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $acc; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Date of Registration:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $dob; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Email Address:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $emaila; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Account Officer:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $acc_off; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="">Registered Address:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $address; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Name of Signatries NO1:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_one; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Name of Signatries NO2:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_two; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Name of Signatries NO3:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_three; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Address:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_address_one; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Address:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_address_two; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Address:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_address_three; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Phone No:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_phone_one; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Phone No:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_phone_two; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Phone No:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_phone_three; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Gender:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_gender_one; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Gender:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_gender_two; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Gender:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_gender_three; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">State:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_state_one; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">State:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_state_two; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">State:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_state_three; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">LGA:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_lga_one; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">LGA:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_lga_two; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">LGA:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_lga_three; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">BVN:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_bvn_one; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">BVN:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_bvn_two; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">BVN:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_bvn_three; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Occupation:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_occu_one; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Occupation:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_occu_two; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Occupation:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_occu_three; ?>" readonly>
                        </div>
                      </div>
                      <a href="update_client.php?edit=<?php echo $id;?>" class="btn btn-primary">Edit CLient</a>
                    </div>
                </div>
                <?php
                }?>
                
              </div>
              <!-- <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Account Summary</h4>
                </div>
                <div class="card-body">
                <form action="">
                    <div class="form-group">
                      <label for="">Current Balance:</label>
                      <input type="text" name="" id="" class="form-control" value="<?php echo $abd; ?>" readonly>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Last Deposit:</label>
                          <input type="text" name="" placeholder="0.000" id="" class="form-control" value="<?php echo $tdd; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Last Withdrawal:</label>
                          <input type="text" placeholder="0.000" name="" id="" class="form-control" value="<?php echo $twd; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Total Outstanding Loan balance:</label>
                          <input type="text" placeholder="0.000" name="" id="" class="form-control" value="<?php echo $sum; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Total Loan Amount payed:</label>
                          <input type="text" placeholder="0.000" name="" id="" class="form-control" value="<?php echo $prd; ?>" readonly>
                        </div>
                      </div>
                    </div>
                    <a href="lend.php" class="btn btn-primary">Disburse Loan</a>
                    <a href="update_client.php?edit=<?php echo $id;?>" class="btn btn-primary">Edit CLient</a>
                    <a href="client.php" class="btn btn-primary pull-right">Back</a>
                  </form>
                </div>
              </div> -->
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Generate Account Report</h4>
                </div>
                <div class="card-body">
                <form method = "POST" action="client_statement.php">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Start Date:</label>
                          <input type="text" name="id" class="form-control" hidden value="<?php echo $id;?>">
                          <input type="date" name="start" id="" class="form-control" value="">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">End Date:</label>
                          <input type="date" name="end" id="" class="form-control" value="">
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Generate Account Report</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <!-- Dialog box for signature -->
              <div id="sig" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title"><?php echo $first_name; ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <img  src="../functions/clients/sign/<?php echo $signature;?>"/>
                      </div>
                    </div>
                  </div>      
                </div>
                <!-- dialog ends -->
                <!-- Dialog box for passport -->
              <div id="pas" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title"><?php echo $first_name; ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <img  src="../functions/clients/passport/<?php echo $passport;?>"/>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- dialog ends -->
                <!-- Dialog box for id img -->
              <div id="id" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title"><?php echo $first_name; ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <img  src="../functions/clients/id/<?php echo $id_img_url;?>"/>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- dialog ends -->
                <div class="card card-profile">
                <div class="card-avatar">
                  <a data-toggle="modal" data-target="#pas">
                    <img class="img" src="../functions/clients/passport/<?php echo $passport;?>" />
                  </a>
                </div>
                <!-- Get client data -->
                <div class="card-body">
                  <h6 class="card-category text-gray">Clients Profile Picture</h6>
                  <h4 class="card-title"><?php echo $display_name; ?></h4>
                  <p class="card-description">
            <?php echo $branch_name; ?>
                  </p>
                  <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
                </div>
              </div>
              <div class="card card-profile">
                <div class="card-avatar">
                  <a data-toggle="modal" data-target="#id">
                    <img class="img" src="../functions/clients/id/<?php echo $id_img_url;?>" />
                  </a>
                </div>
                <!-- Get session data and populate user profile -->
                <div class="card-body">
                  <h6 class="card-category text-gray">ID Card</h6>
                  <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
                </div>
              </div>
                <!-- /id card -->
                <div class="card card-profile">
                <div class="card-avatar">
                  <a data-toggle="modal" data-target="#sig">
                    <img class="img" src="../functions/clients/sign/<?php echo $signature;?>" />
                  </a>
                </div>
                <!-- Get session data and populate user profile -->
                <div class="card-body">
                  <h6 class="card-category text-gray">Signature</h6>
                  <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
                </div>
              </div>
                <!-- signature -->
            </div>
          </div>
        </div>
      </div>

<?php

include('footer.php');

?>