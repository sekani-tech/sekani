<?php

$page_title = "Edit Client";
$destination = "client.php";
    include("header.php");

?>
<?php
// right now we will program
// first step - check if this person is authorized
if ($acc_update == 1 || $acc_update == "1") {
?>
<?php
  $id = $_GET["edit"];
  $update = true;
  $person = mysqli_query($connection, "SELECT * FROM client WHERE id='$id' && int_id='$sessint_id'");
  $n = mysqli_fetch_array($person);
    $ctype = $n['client_type'];
if($ctype =='INDIVIDUAL')
{
  ?>
  <?php
if(isset($_GET["edit"])) {
  if (count([$person]) == 1) {
    $sint_id = $_SESSION["int_id"];

    $vd = $n['id'];
    $acct_type = $n['account_type'];
    $account_no = $n['account_no'];
    $display_name = $n['display_name'];
    $first_name = $n['firstname'];
    $middle_name = $n['middlename'];
    $account_officer = $n['loan_officer_id'];
    $checkl = "SELECT * FROM staff WHERE user_id = '$account_officer'";
    $resxx = mysqli_query($connection, $checkl);
    $xf = mysqli_fetch_array($resxx);
    $acctn = strtoupper($xf['first_name'] ." ". $xf['last_name']);
    $last_name = $n['lastname'];
    $phone = $n['mobile_no'];
    $occupation = $n['occupation'];
    $phone2 = $n['mobile_no_2'];
    $email = $n['email_address'];
    $address = $n['ADDRESS'];
    $gender = $n['gender'];
    $date_of_birth = $n['date_of_birth'];
    $branch = $n['branch_id'];
    $checkli = "SELECT * FROM branch WHERE id = '$branch'";
    $resx = mysqli_query($connection, $checkli);
    $xfc = mysqli_fetch_array($resx);
    $bname = $xfc['name'];
    $country = $n['COUNTRY'];
    $state = $n['STATE_OF_ORIGIN'];
    $lga = $n['LGA'];
    $bvn = $n['BVN'];
    $sms_active = $n['SMS_ACTIVE'];
    $email_active = $n['EMAIL_ACTIVE'];
    $id_card = $n['id_card'];
    // These extra array is to put whatever is in DB but not being used
    $passport = $n['passport'];
    $signature = $n['signature'];
    $id_img_url = $n['id_img_url'];
    // These extra array is to put whatever is in DB
    $sign = $n['signature'];
    $passportbk = $n['passport'];
    $idimg = $n['id_img_url'];
  }
  function fill_state($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM states";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["name"].'">' .$row["name"]. '</option>';
                  }
                  return $out;
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
                  <h4 class="card-title">Update <?php echo $display_name; ?></h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                  <form action="../functions/client_update.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-md-5">
                        <div class="form-group">
                          <label class="bmd-label-floating">Client Type</label>
                          <input type="text" style="text-transform: uppercase;" class="form-control" hidden value="<?php echo $id; ?>" name="id">
                          <input type="text" style="text-transform: uppercase;" class="form-control" value="<?php echo $ctype; ?>" name="ctype" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                        <?php
                  function fill_savings($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM savings_product WHERE int_id = '$sint_id'";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                  }
                  return $out;
                  }
                  ?>
                          <label class="">Account Type:</label>
                          <select name="account_type" class="form-control " id="collat">
                            <?php
                            $queryd = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$id' && account_no ='$account_no' && int_id = '$sint_id'");
                            $resx = mysqli_fetch_array($queryd);
                            $prod = $resx['product_id'];
                            $sql2 = "SELECT * FROM savings_product WHERE id = '$prod' && int_id = '$sint_id'";
                            $res2 = mysqli_query($connection, $sql2);
                            $poi = mysqli_fetch_array($res2);
                            $accttypp = $poi["id"];
                            $accttname = $poi["name"];
                            ?>
                          <option value="<?php echo $accttypp; ?>"><?php echo $accttname; ?></option>
                          <?php echo fill_savings($connection); ?>
                        </select>
                        </div>
                      </div>
                      <!-- </div> -->
                      <div class="col-md-4">
                        <div class="form-group">
                        <?php
                  function fill_account($connection, $vd)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $orgs = "SELECT * FROM account WHERE int_id = '$sint_id' && client_id ='$vd'";
                  $resx = mysqli_query($connection, $orgs);
                  $out = '';
                  while ($row = mysqli_fetch_array($resx))
                  {
                    $out .= '<option value="'.$row["account_no"].'">'.$row["account_no"].'</option>';
                  }
                  return $out;
                  }
                  ?>
                          <label class="">Account No</label>
                          <select name="account_no" class="form-control " id="collat">
                          <option value="<?php echo $account_no; ?>"><?php echo $account_no; ?></option>
                          <?php echo fill_account($connection, $vd); ?>
                        </select>
                        </div>
                      </div>
                      <!-- acctnnnjni -->
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Display name</label>
                          <input type="text" style="text-transform: uppercase;" class="form-control" value="<?php echo $display_name; ?>" name="display_name">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">First Name</label>
                          <input type="text" class="form-control" value="<?php echo $first_name; ?>" name="first_name">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Middle Name</label>
                          <input type="text" class="form-control" value="<?php echo $middle_name; ?>" name="middle_name">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Last Name</label>
                          <input type="text" style="text-transform: uppercase;" class="form-control" value="<?php echo $last_name; ?>" name="last_name">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Phone No</label>
                          <input type="tel" class="form-control" value="<?php echo $phone; ?>" name="phone">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Phone No2</label>
                          <input type="tel" class="form-control" value="<?php echo $phone2; ?>" name="phone2">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Email address</label>
                          <input type="email" class="form-control" value="<?php echo $email; ?>" name="email">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Address</label>
                          <input type="text" style="text-transform: uppercase;" class="form-control" value="<?php echo $address; ?>" name="address">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Gender:</label>
                          <select class="form-control " value="<?php echo $gender; ?>" name="gender" id="">
                            <option value="MALE">MALE</option>
                            <option value="FEMALE">FEMALE</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="">Date of Birth:</label>
                          <input type="date" class="form-control" value="<?php echo $date_of_birth; ?>" name="date_of_birth">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                        <?php
                  function fill_branch($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM branch WHERE int_id = '$sint_id'";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["id"].'">'.$row["name"]. '</option>';
                  }
                  return $out;
                  }
                  ?>
                          <label class="">Branch:</label>
                          <select name="branch" class="form-control" id="collat">
                          <option value="<?php echo $branch; ?>"><?php echo $bname; ?></option>
                          <?php echo fill_branch($connection); ?>
                        </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Country:</label>
                          <input type="text" style="text-transform: uppercase;" class="form-control" value="NIGERIA" name="country">
                        </div>
                      </div>
                      <div class="col-md-4">
                    <div class="form-group">
                      <label for="">State:</label>
                      <select id="tom" class="form-control" style="text-transform: uppercase;" name="state">
                      <option value="<?php echo $state;?>"><?php echo $state;?></option>
                      <?php echo fill_state($connection);?>
                      </select>
                    </div>
                  </div>
                  <script>
                    $(document).ready(function() {
                      $('#tom').on("change", function(){
                        var id = $(this).val();
                        $.ajax({
                          url:"ajax_post/lga.php",
                          method:"POST",
                          data:{id:id},
                          success:function(data){
                            $('#sholga').html(data);
                          }
                        })
                      });
                    });
                </script>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="">LGA:</label>
                      <select id="sholga" class="form-control" name="lga">
                      <option value="<?php echo $lga;?>"><?php echo $lga;?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                        <label for="">Occupation:</label>
                        <input type="text" value="<?php echo $occupation; ?>" name="occupation" class="form-control" id="">
                      </div>
                      <div class="col-md-4">
                        <label for="">BVN:</label>
                        <input type="text" value="<?php echo $bvn; ?>" name="bvn" class="form-control" id="">
                      </div>
                      <div class="col-md-4">
                        <p><label for="">Active Alerts: </label></p>
                        <input type="text" hidden value="<?php echo $sms_active;?>" id="opo">
                        <input type="text" hidden value="<?php echo $email_active;?>" id="opo2">
                        <script>
                            $(document).ready(function() {
                              var xc = document.getElementById("opo").value;
                              var xc2 = document.getElementById("opo2").value;
                              if (xc == '1' && xc2 == '0') {
                                document.getElementById('sms').checked = true;
                                document.getElementById('eml').checked = false;
                                $('sms').click(function() {
                                 document.getElementById('sms').checked = true;
                                });
                                $('eml').click(function() {
                                 document.getElementById('eml').checked = true;
                                });
                              } else if (xc == '0' && xc2 == '1') {
                                document.getElementById('sms').checked = false;
                                document.getElementById('eml').checked = true;
                                $('sms').click(function() {
                                 document.getElementById('sms').checked = true;
                                });
                                $('eml').click(function() {
                                 document.getElementById('eml').checked = true;
                                });
                              } else if (xc == '1' && xc2 == '1') {
                                document.getElementById('sms').checked = true;
                                document.getElementById('eml').checked = true;
                                $('sms').click(function() {
                                 document.getElementById('sms').checked = true;
                                });
                                $('eml').click(function() {
                                 document.getElementById('eml').checked = true;
                                });
                              } else {
                                document.getElementById('sms').checked = false;
                                document.getElementById('eml').checked = false;
                                $('emp').click(function() {
                                 document.getElementById('sms').checked = true;
                                });
                                $('dec').click(function() {
                                 document.getElementById('eml').checked = true;
                                });
                              }
                            });
                          </script>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="<?php echo $sms_active;?>" name="sms_active" id="sms">
                              SMS
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="<?php echo $email_active;?>" name="email_active" id="eml">
                              Email
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-4">
                      <?php
                  function fill_officer($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM staff WHERE int_id = '$sint_id' ORDER BY staff.display_name ASC";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["id"].'">' .$row["display_name"]. '</option>';
                  }
                  return $out;
                  }
                  ?>
                        <div class="form-group">
                          <label for="">Account Officer:</label>
                          <select name="acct_off" class="form-control " id="">
                            <option value="<?php echo $account_officer;?>">...</option>
                            <?php echo fill_officer($connection); ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <style>
                        input[type="file"]{
                          display: none;
                        }
                        .custom-file-upload{
                          border: 1px solid #ccc;
                          display: inline-block;
                          padding: 6px 12px;
                          cursor: pointer;
                        }
                      </style>
                      <div class="col-md-4">
                    <label for="file-upload" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input id ="file-upload" name="passport" type="file" class="inputFileHidden"/>
                    <input type="text" hidden value="<?php echo $passportbk;?>" name="passportbk">
                    <label> Select Passport</label>
                    </div>
                    
                    <div class="col-md-4">
                    <label for="file-insert" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input id ="file-insert" name="signature" type="file" class="inputFileHidden"/>
                    <input type="text" hidden value="<?php echo $sign;?>" name="sign">
                    <label> Select Signature</label>
                    </div>
                    
                    <div class="col-md-4">
                    <label for="file-enter" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input id ="file-enter" type="file" name="id_img_url" class="inputFileHidden"/>
                    <input type="text" hidden value="<?php echo $idimg;?>" name="idimg">
                    <label> Select ID</label>
                    </div>
                      <div class="col-md-4">
                        <label for="">Select ID</label>
                         <select class="form-control" name="id_card">
                          <option value="<?php echo $id_card ?>"><?php echo $id_card ?></option>
                          <option value="National ID">National ID</option>
                          <option value="Voters ID">Voters ID</option>
                          <option value="International Passport">International Passport</option>
                          <option value="Drivers Liscense">Drivers Liscense</option>
                        </select>
                      </div>
                    </div>
                    <a href="client.php" class="btn btn-danger">Back</a>
                    <button type="submit" class="btn btn-primary pull-right">Update Client</button>
                    <div class="clearfix"></div>
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
                        <img class="img-fluid"  src="../functions/clients/passport/<?php echo $passport;?>"/>
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
                  <?php
                $inq = mysqli_query($connection, "SELECT * FROM institutions WHERE int_id='$sessint_id'");
                if (count([$inq]) == 1) {
                  $n = mysqli_fetch_array($inq);
                  $int_name = $n['int_name'];
                }
              ?>
            <?php echo $int_name; ?>
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
          <!-- /content -->
        </div>
      </div>

<?php

    include("footer.php");

?>
<?php
}
else if($ctype = 'CORPORATE'){
  if(isset($_GET["edit"])) {
    $person = mysqli_query($connection, "SELECT * FROM client WHERE id='$id' && int_id='$sessint_id'");
    $sint_id = $_SESSION["int_id"];

    if (count([$person]) == 1) {
      $n = mysqli_fetch_array($person);
      $vd = $n['id'];
      $acct_type = $n['account_type'];
      $account_no = $n['account_no'];
      $display_name = $n['display_name'];
      $regdate = $n['date_of_birth'];
      $first_name = $n['firstname'];
      $rcno = $n['rc_number'];
      $regname = $n['display_name'];
      $regemail = $n['email_address'];
      $regaddress = $n['ADDRESS'];
      $bran = $n['branch_id'];
      $account_officer = $n['loan_officer_id'];
      $checkl = "SELECT * FROM staff WHERE user_id = '$account_officer'";
      $resxx = mysqli_query($connection, $checkl);
      $xf = mysqli_fetch_array($resxx);
      $acctn = strtoupper($xf['first_name'] ." ". $xf['last_name']);
      $signame1 = $n['sig_one'];
      $signame2 = $n['sig_two'];
      $signame3 = $n['sig_three'];
      $address1 = $n['sig_address_one'];
      $address2 = $n['sig_address_two'];
      $address3 = $n['sig_address_three'];
      $phone1 = $n['sig_phone_one'];
      $phone2 = $n['sig_phone_two'];
      $phone3 = $n['sig_phone_three'];
      $gender1 = $n['sig_gender_one'];
      $gender2 = $n['sig_gender_two'];
      $gender3 = $n['sig_gender_three'];
      $state1 = $n['sig_state_one'];
      $state2 = $n['sig_state_two'];
      $state3 = $n['sig_state_three'];
      $occu1 = $n['sig_occu_one'];
      $occu2 = $n['sig_occu_two'];
      $occu3 = $n['sig_occu_three'];
      $lga1 = $n['sig_lga_one'];
      $lga2 = $n['sig_lga_two'];
      $lga3 = $n['sig_lga_three'];
      $bvn1 = $n['sig_bvn_one'];
      $bvn2 = $n['sig_bvn_two'];
      $bvn3 = $n['sig_bvn_three'];
      $smsactive1 = $n['sms_active_one'];
      $smsactive2 = $n['sms_active_two'];
      $smsactive3 = $n['sms_active_three'];
      $emailactive1 = $n['email_active_one'];
      $emailactive2 = $n['email_active_two'];
      $emailactive3 = $n['email_active_three'];
      $pas1 = $n['sig_passport_one'];
      $pas2 = $n['sig_passport_two'];
      $pas3 = $n['sig_passport_three'];
      $sig1 = $n['sig_signature_one'];
      $sig2 = $n['sig_signature_two'];
      $sig3 = $n['sig_signature_three'];
      $id1 = $n['sig_id_img_one'];
      $id2 = $n['sig_id_img_two'];
      $id3 = $n['sig_id_img_three'];
      $sigid1 = $n['sig_id_card_one'];
      $sigid2 = $n['sig_id_card_two'];
      $sigid3 = $n['sig_id_card_three'];
      $acc_no = $n['account_no'];
    }
    function fill_state($connection)
                    {
                    $org = "SELECT * FROM states";
                    $res = mysqli_query($connection, $org);
                    $out = '';
                    while ($row = mysqli_fetch_array($res))
                    {
                      $out .= '<option value="'.$row["name"].'">' .$row["name"]. '</option>';
                    }
                    return $out;
                    }
  }
  ?>
  <script>
    $(document).ready(function() {
        $('#static').on("change", function(){
        var id = $(this).val();
        $.ajax({
            url:"ajax_post/lga.php",
            method:"POST",
            data:{id:id},
            success:function(data){
            $('#showme').html(data);
            }
        })
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#sig_one').on("change keyup paste click", function(){
        var id = $(this).val();
        $.ajax({
            url:"ajax_post/lga.php",
            method:"POST",
            data:{id:id},
            success:function(data){
            $('#sigone').html(data);
            }
        })
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#sig_two').on("change keyup paste click", function(){
        var id = $(this).val();
        $.ajax({
            url:"ajax_post/lga.php",
            method:"POST",
            data:{id:id},
            success:function(data){
            $('#sigtwo').html(data);
            }
        })
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#sig_three').on("change keyup paste click", function(){
        var id = $(this).val();
        $.ajax({
            url:"ajax_post/lga.php",
            method:"POST",
            data:{id:id},
            success:function(data){
            $('#sigthree').html(data);
            }
        })
        });
    });
</script>
  <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-8">
            <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Update <?php echo $regname; ?></h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                  <form action="../functions/client_update.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                    <div class="row">
                      <div class="col-md-6">
                      <div class="form-group">
                        <label >Client type</label>
                        <input value="<?php echo $ctype;?>" type="text" readonly  style="text-transform: uppercase;" class="form-control" name="ctype">
                        <input type="text" style="text-transform: uppercase;" class="form-control" hidden value="<?php echo $vd; ?>" name="id">
                      </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                        <?php
                  function fill_savings($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM savings_product WHERE int_id = '$sint_id'";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                  }
                  return $out;
                  }
                  ?>
                          <label class="">Account Type:</label>
                          <select name="account_type" class="form-control " id="collat">
                          <?php
                            $queryd = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$id' && account_no ='$account_no' && int_id = '$sint_id'");
                            $resx = mysqli_fetch_array($queryd);
                            $prod = $resx['product_id'];
                            $sql2 = "SELECT * FROM savings_product WHERE id = '$prod' && int_id = '$sint_id'";
                            $res2 = mysqli_query($connection, $sql2);
                            $poi = mysqli_fetch_array($res2);
                            $accttypp = $poi["id"];
                            $accttname = $poi["name"];
                            ?>
                          <option value="<?php echo $accttypp; ?>"><?php echo $accttname; ?></option>
                          <?php echo fill_savings($connection); ?>
                        </select>
                        </div>
                      </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label >RC Number</label>
                        <input  type="text" value="<?php echo $rcno;?>" style="text-transform: uppercase;" class="form-control" name="rc_number">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="">Date of Registration:</label>
                        <input value="<?php echo $regdate;?>" type="date" class="form-control" name="date_of_birtha">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="form-group">
                <label >Registered Name</label>
                <input value="<?php echo $regname;?>" type="text"  style="text-transform: uppercase;" class="form-control" name="display_namea">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label >Email address</label>
                <input value="<?php echo $regemail;?>" type="email" class="form-control" name="emaila">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label >Registered Address</label>
                <input type="text" value="<?php echo $regaddress;?>" style="text-transform: uppercase;" class="form-control" name="addressa">
            </div>
        </div>
        <?php
                  function fill_branch($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM branch WHERE int_id = '$sint_id'";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["id"].'">'.$row["name"]. '</option>';
                  }
                  return $out;
                  }
                  ?>
        <div class="col-md-4">
        <div class="form-group">
        <label class="">Branch:</label>
        <select  name="brancha" class="form-control " id="collat">
            <option value="<?php echo $bran;?>">select a Branch</option>
            <?php echo fill_branch($connection);?>
        </select>
    </div>
        </div>
        <?php
          function fill_officer($connection)
          {
          $sint_id = $_SESSION["int_id"];
          $org = "SELECT * FROM staff WHERE int_id = '$sint_id' ORDER BY staff.display_name ASC";
          $res = mysqli_query($connection, $org);
          $out = '';
          while ($row = mysqli_fetch_array($res))
          {
            $out .= '<option value="'.$row["id"].'">' .$row["display_name"]. '</option>';
          }
          return $out;
          }
          ?>
        <div class="col-md-4">
            <div class="form-group">
                <div class="form-group">
                <label for="">Account Officer:</label>
                <select  name="acct_ofa" class="form-control" id="">
                <option value="<?php echo $account_officer;?>">select account officer</option>
                <?php echo fill_officer($connection);?>
                </select>
            </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label >Account No:</label>
                <input type="text" name="acc_no" value="<?php echo $acc_no;?>" style="text-transform: uppercase;" class="form-control">
            </div>
        </div>
        <div class ="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <div class="col-md-12">
                    <div class="form-group">
                    <label>Name of Signatries NO.1</label>
                    <input value="<?php echo $signame1;?>" type="text" style="text-transform: uppercase;" class="form-control" name="sig_one">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label >Address</label>
                    <input value="<?php echo $address1;?>" type="text" style="text-transform: uppercase;" class="form-control" name="sig_address_one">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label >Phone</label>
                    <input value="<?php echo $phone1;?>" type="text" style="text-transform: uppercase;" class="form-control" name="sig_phone_one">
                    </div>
                </div>
                <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Gender:</label>
                          <select class="form-control "  name="gender" id="">
                            <option value="<?php echo $gender1;?>">select gender</option>
                            <option value="MALE">MALE</option>
                            <option value="FEMALE">FEMALE</option>
                          </select>
                        </div>
                      </div>
                <div class="col-md-12">
            <div class="form-group">
              <label for="">State:</label>
              <select id="sig_one" class="form-control" style="text-transform: uppercase;" name="sig_state_one">
              <option value="<?php echo $state1;?>">select state</option>
              <?php echo fill_state($connection);?>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="">LGA:</label>
              <select class="form-control" name="sig_lga_one" id="sigone">
              </select>
            </div>
          </div>
          <div class="col-md-12">
                    <div class="form-group">
                    <label >Occupation</label>
                    <input value="<?php echo $occu1;?>" type="text" style="text-transform: uppercase;" class="form-control" name="sig_occu_one">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label >BVN</label>
                    <input value="<?php echo $bvn1;?>" type="text" style="text-transform: uppercase;" class="form-control" name="sig_bvn_one">
                    </div>
                </div>
                <div class="col-md-12">
                        <p><label for="">Active Alerts: </label></p>
                        <input type="text" hidden value="<?php echo $smsactive1;?>" id="sms1">
                        <input type="text" hidden value="<?php echo $emailactive1;?>" id="email1">
                        <script>
                            $(document).ready(function() {
                              var xc = document.getElementById("sms1").value;
                              var xc2 = document.getElementById("email1").value;
                              if (xc == '1' && xc2 == '0') {
                                document.getElementById('smsa').checked = true;
                                document.getElementById('emla').checked = false;
                                $('smsa').click(function() {
                                 document.getElementById('smsa').checked = true;
                                });
                                $('emla').click(function() {
                                 document.getElementById('emla').checked = true;
                                });
                              } else if (xc == '0' && xc2 == '1') {
                                document.getElementById('smsa').checked = false;
                                document.getElementById('emla').checked = true;
                                $('smsa').click(function() {
                                 document.getElementById('smsa').checked = true;
                                });
                                $('emla').click(function() {
                                 document.getElementById('emla').checked = true;
                                });
                              } else if (xc == '1' && xc2 == '1') {
                                document.getElementById('smsa').checked = true;
                                document.getElementById('emla').checked = true;
                                $('smsa').click(function() {
                                 document.getElementById('sms').checked = true;
                                });
                                $('emla').click(function() {
                                 document.getElementById('emla').checked = true;
                                });
                              } else {
                                document.getElementById('smsa').checked = false;
                                document.getElementById('emla').checked = false;
                                $('empa').click(function() {
                                 document.getElementById('smsa').checked = true;
                                });
                                $('deca').click(function() {
                                 document.getElementById('eml').checked = true;
                                });
                              }
                            });
                          </script>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" name="sms_active_one" id="smsa">
                              SMS
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" name="email_active_one" id="emla">
                              Email
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                      </div>
                <div class="col-md-12">
                    <label for="file-upload-a" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input hidden type="text" value="<?php echo $pas1;?>" name="pas1">
                    <input id ="file-upload-a" name="sig_passport_one" type="file" class="inputFileHidden"/>
                    <label id="upload-a"> Select Passport</label>
                    <div id="upload-a"></div>
                </div>
            
                <div class="col-md-12">
                    <label for="file-insert-a" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input hidden type="text" value="<?php echo $sig1;?>" name="sig1">
                    <input id ="file-insert-a" name="sig_signature_one" type="file" class="inputFileHidden"/>
                    <label id="iup-a"> Select Signature</label>
                    <div id="iup-a"></div>
                </div>
            
                <div class="col-md-12">
                    <label for="file-enter-a" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input hidden type="text" value="<?php echo $id1;?>" name="id1">
                    <input id ="file-enter-a" type="file" name="sig_id_img_one" class="inputFileHidden"/>
                    <label id="rated-a"> Select ID</label>
                    <div id="rated-a"></div>
                </div>
                <style>
            input[type="file"]{
                display: none;
            }
            .custom-file-upload{
                border: 1px solid #ccc;
                display: inline-block;
                padding: 6px 12px;
                cursor: pointer;
            }
            </style>
                <div class="col-md-12">
                    <label for="">Id Type</label>
                    <select  name="sig_id_card_one" class="form-control " id="">
                    <option value="<?php echo $sigid1;?>">select ID</option>
                        <option value="National ID">National ID</option>
                        <option value="Voters ID">Voters ID</option>
                        <option value="International Passport">International Passport</option>
                        <option value="Drivers License">Drivers license</option>
                      </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="col-md-12">
                    <div class="form-group">
                    <label >Name of Signatries NO.2</label>
                    <input value="<?php echo $signame2;?>" type="text" style="text-transform: uppercase;" class="form-control" name="sig_two">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label >Address</label>
                    <input value="<?php echo $address2;?>" type="text" style="text-transform: uppercase;" class="form-control" name="sig_address_two">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label >Phone</label>
                    <input value="<?php echo $phone2;?>" type="text" style="text-transform: uppercase;" class="form-control" name="sig_phone_two">
                    </div>
                </div>
                <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Gender:</label>
                          <select class="form-control "  name="gender" id="">
                            <option value="<?php echo $gender2;?>">select gender</option>
                            <option value="MALE">MALE</option>
                            <option value="FEMALE">FEMALE</option>
                          </select>
                        </div>
                      </div>
                <div class="col-md-12">
            <div class="form-group">
              <label for="">State:</label>
              <select id="sig_two" class="form-control" style="text-transform: uppercase;" name="sig_state_two">
              <option value="<?php echo $state2;?>">select state</option>
              <?php echo fill_state($connection);?>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="">LGA:</label>
              <select class="form-control" name="sig_lga_two" id="sigtwo">
              </select>
            </div>
          </div>
          <div class="col-md-12">
                    <div class="form-group">
                    <label >Occupation</label>
                    <input value="<?php echo $occu2;?>" type="text" style="text-transform: uppercase;" class="form-control" name="sig_occu_two">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label >BVN</label>
                    <input value="<?php echo $bvn2;?>" type="text" style="text-transform: uppercase;" class="form-control" name="sig_bvn_two">
                    </div>
                </div>
                <div class="col-md-12">
                        <p><label for="">Active Alerts: </label></p>
                        <input type="text" hidden value="<?php echo $smsactive2;?>" id="sms2">
                        <input type="text" hidden value="<?php echo $emailactive2;?>" id="email2">
                        <script>
                            $(document).ready(function() {
                              var xc = document.getElementById("sms2").value;
                              var xc2 = document.getElementById("email2").value;
                              if (xc == '1' && xc2 == '0') {
                                document.getElementById('smsb').checked = true;
                                document.getElementById('emlb').checked = false;
                                $('smsb').click(function() {
                                 document.getElementById('smsb').checked = true;
                                });
                                $('emlb').click(function() {
                                 document.getElementById('emlb').checked = true;
                                });
                              } else if (xc == '0' && xc2 == '1') {
                                document.getElementById('smsb').checked = false;
                                document.getElementById('emlb').checked = true;
                                $('smsb').click(function() {
                                 document.getElementById('smsb').checked = true;
                                });
                                $('emlb').click(function() {
                                 document.getElementById('emlb').checked = true;
                                });
                              } else if (xc == '1' && xc2 == '1') {
                                document.getElementById('smsb').checked = true;
                                document.getElementById('emlb').checked = true;
                                $('smsb').click(function() {
                                 document.getElementById('smsb').checked = true;
                                });
                                $('emlb').click(function() {
                                 document.getElementById('emlb').checked = true;
                                });
                              } else {
                                document.getElementById('smsb').checked = false;
                                document.getElementById('emlb').checked = false;
                                $('empb').click(function() {
                                 document.getElementById('smsb').checked = true;
                                });
                                $('deca').click(function() {
                                 document.getElementById('emlb').checked = true;
                                });
                              }
                            });
                          </script>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" name="sms_active_two" id="smsb">
                              SMS
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" name="email_active_two" id="emlb">
                              Email
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                      </div>
                <div class="col-md-12">
                    <label for="file-upload-b" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input hidden type="text" value="<?php echo $pas2;?>" name="pas2">
                    <input id ="file-upload-b" name="sig_passport_two" type="file" class="inputFileHidden"/>
                    <label id="upload-b"> Select Passport</label>
                    <div id="upload-b"></div>
                </div>
            
                <div class="col-md-12">
                    <label for="file-insert-b" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input hidden type="text" value="<?php echo $sig2;?>" name="sig2">
                    <input id ="file-insert-b" name="sig_signature_two" type="file" class="inputFileHidden"/>
                    <label id="iup-b"> Select Signature</label>
                    <div id="iup-b"></div>
                </div>
            
                <div class="col-md-12">
                    <label for="file-enter-b" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input hidden type="text" value="<?php echo $id2;?>" name="id2">
                    <input id ="file-enter-b" type="file" name="sig_id_img_two" class="inputFileHidden"/>
                    <label id="rated-b"> Select ID</label>
                    <div id="rated-b"></div>
                </div>
                <style>
            input[type="file"]{
                display: none;
            }
            .custom-file-upload{
                border: 1px solid #ccc;
                display: inline-block;
                padding: 6px 12px;
                cursor: pointer;
            }
            </style>
                <div class="col-md-12">
                    <label for="">Id Type</label>
                    <select  name="sig_id_card_two" class="form-control " id="">
                    <option value="<?php echo $sigid2;?>">select ID</option>    
                        <option value="National ID">National ID</option>
                        <option value="Voters ID">Voters ID</option>
                        <option value="International Passport">International Passport</option>
                        <option value="Drivers License">Drivers license</option>
                      </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="col-md-12">
                    <div class="form-group">
                    <label >Name of Signatries NO.3</label>
                    <input value="<?php echo $signame3;?>" type="text" style="text-transform: uppercase;" class="form-control" name="sig_three">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label >Address</label>
                    <input value="<?php echo $address3;?>" type="text" style="text-transform: uppercase;" class="form-control" name="sig_address_three">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label >Phone</label>
                    <input value="<?php echo $phone3;?>" type="text" style="text-transform: uppercase;" class="form-control" name="sig_phone_three">
                    </div>
                </div>
                <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Gender:</label>
                          <select class="form-control "  name="gender" id="">
                            <option value="<?php echo $gender3;?>">select gender</option>
                            <option value="MALE">MALE</option>
                            <option value="FEMALE">FEMALE</option>
                          </select>
                        </div>
                      </div>
                <div class="col-md-12">
            <div class="form-group">
              <label for="">State:</label>
              <select id="sig_three" class="form-control" style="text-transform: uppercase;" name="sig_state_three">
              <option value="<?php echo $state3;?>">select state</option>
              <?php echo fill_state($connection);?>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="">LGA:</label>
              <select class="form-control" name="sig_lga_three" id="sigthree">
              </select>
            </div>
          </div>
          <div class="col-md-12">
                    <div class="form-group">
                    <label >Occupation</label>
                    <input value="<?php echo $occu3;?>" type="text" style="text-transform: uppercase;" class="form-control" name="sig_occu_three">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label >BVN</label>
                    <input value="<?php echo $bvn3;?>" type="text" style="text-transform: uppercase;" class="form-control" name="sig_bvn_three">
                    </div>
                </div>
                <div class="col-md-12">
                        <p><label for="">Active Alerts: </label></p>
                        <input type="text" hidden value="<?php echo $smsactive3;?>" id="sms3">
                        <input type="text" hidden value="<?php echo $emailactive3;?>" id="email3">
                        <script>
                            $(document).ready(function() {
                              var xc = document.getElementById("sms3").value;
                              var xc2 = document.getElementById("email3").value;
                              if (xc == '1' && xc2 == '0') {
                                document.getElementById('smsc').checked = true;
                                document.getElementById('emlc').checked = false;
                                $('smsc').click(function() {
                                 document.getElementById('smsa').checked = true;
                                });
                                $('emlc').click(function() {
                                 document.getElementById('emlc').checked = true;
                                });
                              } else if (xc == '0' && xc2 == '1') {
                                document.getElementById('smsc').checked = false;
                                document.getElementById('emlc').checked = true;
                                $('smsc').click(function() {
                                 document.getElementById('smsa').checked = true;
                                });
                                $('emlc').click(function() {
                                 document.getElementById('emlc').checked = true;
                                });
                              } else if (xc == '1' && xc2 == '1') {
                                document.getElementById('smsc').checked = true;
                                document.getElementById('emlc').checked = true;
                                $('smsc').click(function() {
                                 document.getElementById('smsc').checked = true;
                                });
                                $('emlc').click(function() {
                                 document.getElementById('emlc').checked = true;
                                });
                              } else {
                                document.getElementById('smsc').checked = false;
                                document.getElementById('emlc').checked = false;
                                $('empc').click(function() {
                                 document.getElementById('smsc').checked = true;
                                });
                                $('decc').click(function() {
                                 document.getElementById('emlc').checked = true;
                                });
                              }
                            });
                          </script>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" name="sms_active_three" id="smsc">
                              SMS
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" name="email_active_three" id="emlc">
                              Email
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                      </div>
                <div class="col-md-12">
                    <label for="file-upload-c" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input hidden value="<?php echo $pas3;?>" name="pas3"/>
                    <input id ="file-upload-c" name="sig_passport_three" type="file" class="inputFileHidden"/>
                    <label id="upload-c"> Select Passport</label>
                    <div id="upload-c"></div>
                </div>
            
                <div class="col-md-12">
                    <label for="file-insert-c" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input hidden value="<?php echo $sig3;?>" name="sig3"/>
                    <input id ="file-insert-c" name="sig_signature_three" type="file" class="inputFileHidden"/>
                    <label id="iup-c"> Select Signature</label>
                    <div id="iup-c"></div>
                </div>
            
                <div class="col-md-12">
                    <label for="file-enter-c" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input hidden value="<?php echo $id3;?>" name="id3"/>
                    <input id ="file-enter-c" type="file" name="sig_id_img_three" class="inputFileHidden"/>
                    <label id="rated-c"> Select ID</label>
                    <div id="rated-c"></div>
                </div>
                <style>
            input[type="file"]{
                display: none;
            }
            .custom-file-upload{
                border: 1px solid #ccc;
                display: inline-block;
                padding: 6px 12px;
                cursor: pointer;
            }
            </style>
                <div class="col-md-12">
                    <label for="">Id Type</label>
                    <select  name="sig_id_card_three" class="form-control " id="">
                      <option value="<?php echo $sigid3;?>">select ID</option>    
                      <option value="National ID">National ID</option>
                        <option value="Voters ID">Voters ID</option>
                        <option value="Drivers License">Drivers license</option>
                        <option value="International Passport">International Passport</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
                    </div>
                    <a href="client.php" class="btn btn-danger">Back</a>
                    <button type="submit" class="btn btn-primary pull-right">Update Client</button>
                    <div class="clearfix"></div>
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
                  <?php
                $inq = mysqli_query($connection, "SELECT * FROM institutions WHERE int_id='$sessint_id'");
                if (count([$inq]) == 1) {
                  $n = mysqli_fetch_array($inq);
                  $int_name = $n['int_name'];
                }
              ?>
            <?php echo $int_name; ?>
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
}
?>
<?php
} else {
  echo '<script type="text/javascript">
  $(document).ready(function(){
   swal({
    type: "error",
    title: "Client Update Authority",
    text: "You Dont Have permission to Update clients",
   showConfirmButton: false,
    timer: 2000
    }).then(
    function (result) {
      history.go(-1);
    }
    )
    });
   </script>
  ';
  // $URL="transact.php";
  // echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}

?>
