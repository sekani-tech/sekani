<?php
include('../../../functions/connect.php');

if(isset($_POST["cid"])) {
  $id = $_POST["cid"];
  $out = '';
  $update = true;
  $sessint_id = $_POST["intid"];
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

    $getacctv = mysqli_query($connection, "SELECT * FROM account WHERE client_id='$id' && int_id='$sessint_id'");
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
    $inq = mysqli_query($connection, "SELECT * FROM institutions WHERE int_id='$sessint_id'");
    if (count([$inq]) == 1) {
        $n = mysqli_fetch_array($inq);
        $int_name = $n['int_name'];
    }
$out = '
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
                      <input type="text" name="" id="" style="text-transform: uppercase;" class="form-control" value="'.$display_name.'" readonly name="display_name">
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Account No:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="'.$acc.'" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Account Officer:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="'.$displayname.'" readonly>
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
                      <input type="text" name="" id="" class="form-control" value="'.$abd.'" readonly>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Last Deposit:</label>
                          <input type="text" name="" placeholder="0.000" id="" class="form-control" value="'.$tdd.'" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Last Withdrawal:</label>
                          <input type="text" placeholder="0.000" name="" id="" class="form-control" value="'.$twd.'" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Total Outstanding Loan balance:</label>
                          <input type="text" placeholder="0.000" name="" id="" class="form-control" value="'.$sum.'" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Total Loan Amount payed:</label>
                          <input type="text" placeholder="0.000" name="" id="" class="form-control" value="'.$prd.'" readonly>
                        </div>
                      </div>
                    </div>
                    <a href="lend.php" class="btn btn-primary">Disburse Loan</a>
                    <a href="update_client.php?edit='.$id.'" class="btn btn-primary">Edit CLient</a>
                    <a href="client.php" class="btn btn-primary pull-right">Back</a>
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
                          <h5 class="modal-title">'.$first_name.'</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <img  src="../functions/clients/sign/'.$signature.'"/>
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
                          <h5 class="modal-title">'.$first_name.'</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <img  src="../functions/clients/passport/'.$passport.'"/>
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
                          <h5 class="modal-title">'.$first_name.'</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <img  src="../functions/clients/id/'.$id_img_url.'"/>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- dialog ends -->
                <div class="card card-profile">
                <div class="card-avatar">
                  <a data-toggle="modal" data-target="#pas">
                    <img class="img" src="../functions/clients/passport/'. $passport.'" />
                  </a>
                </div>
                <!-- Get client data -->
                <div class="card-body">
                  <h6 class="card-category text-gray">Clients Profile Picture</h6>
                  <h4 class="card-title">'.$display_name.'</h4>
                  <p class="card-description">
            '.$int_name.'
                  </p>
                  <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
                </div>
              </div>
              <div class="card card-profile">
                <div class="card-avatar">
                  <a data-toggle="modal" data-target="#id">
                    <img class="img" src="../functions/clients/id/'.$id_img_url.'" />
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
                    <img class="img" src="../functions/clients/sign/'.$signature.'" />
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
      ';
      echo $out;
      ?>