<?php

$page_title = "Edit Client";
$destination = "client.php";
    include("header.php");

?>
<?php
  if (isset($_GET["message1"])) {
    $key = $_GET["message1"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "success",
            title: "Success",
            text: "Registration Successful",
            showConfirmButton: false,
            timer: 2000
        })
    });
    </script>
    ';
    $_SESSION["lack_of_intfund_$key"] = null;
}
else if (isset($_GET["message2"])) {
  $key = $_GET["message2"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Error",
          text: "Error during Registration",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = null;
}
?>
<?php
if(isset($_GET["edit"])) {
  $id = $_GET["edit"];
  $update = true;
  $person = mysqli_query($connection, "SELECT * FROM client WHERE id='$id'");

  if (count([$person]) == 1) {
    $n = mysqli_fetch_array($person);
    $ctype = $n['client_type'];
    $acct_type = $n['account_type'];
    $display_name = $n['display_name'];
    $first_name = $n['firstname'];
    $middle_name = $n['middlename'];
    $last_name = $n['lastname'];
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
                  <h4 class="card-title">Update <?php echo $display_name; ?></h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                  <form action="../functions/client_update.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-md-5">
                        <div class="form-group">
                          <label class="bmd-label-floating">Client Type</label>
                          <input type="text" class="form-control" hidden value="<?php echo $id; ?>" name="id">
                          <input type="text" class="form-control" value="<?php echo $ctype; ?>" name="ctype" readonly>
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div class="form-group">
                          <label class="bmd-label-floating">Account Type</label>
                          <input type="text" class="form-control" value="<?php echo $acct_type; ?>" name="acct_type">
                        </div>
                      </div>
                      <!-- </div> -->
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Display name</label>
                          <input type="text" class="form-control" value="<?php echo $display_name; ?>" name="display_name">
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
                          <input type="text" class="form-control" value="<?php echo $last_name; ?>" name="last_name">
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
                          <input type="text" class="form-control" value="<?php echo $address; ?>" name="address">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Gender:</label>
                          <select class="form-control" value="<?php echo $gender; ?>" name="gender" id="">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
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
                    $out .= '<option value="'.$row["id"].'">'.$row["name"]. ' @ ' .$row["location"]. '</option>';
                  }
                  return $out;
                  }
                  ?>
                          <label class="">Branch:</label>
                          <select name="branch" class="form-control" id="collat">
                          <option value="<?php echo $branch; ?>">Update Branch</option>
                          <?php echo fill_branch($connection); ?>
                        </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Country:</label>
                          <input type="text" class="form-control" value="<?php echo $country; ?>" name="country">
                        </div>
                      </div>
                      <div class="col-md-4">
                    <div class="form-group">
                      <label for="">State:</label>
                      <select class="form-control" name="state" id="selState" onchange="configureDropDownLists()">
                      </select>
                      <label for="">LGA:</label>
                      <select  class="form-control"name="lga" id="selCity">
                      </select>
                    </div>
                  </div>
                      <div class="col-md-4">
                        <label for="">BVN:</label>
                        <input type="text" value="<?php echo $bvn; ?>" name="bvn" class="form-control" id="">
                      </div>
                      <div class="col-md-4">
                        <p><label for="">Active Alerts:</label></p>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="<?php echo $sms_active;?>" name="sms_active">
                              SMS
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="<?php echo $email_active;?>" name="email_active">
                              Email
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                          </label>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Account Officer:</label>
                          <select name="" class="form-control" id="">
                            <option value=""></option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                            <div class="fileinput-new thumbnail img-raised">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                            <div>
                                <span class="btn btn-raised btn-round btn-default btn-file">
                                    <span class="fileinput-new">Select passport</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="passport" id="passport" />
                                </span>
                                <a href="javascript:;" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                            </div>
                        </div>
                      </div>
                       <div class="col-md-6">
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                            <div class="fileinput-new thumbnail img-raised">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                            <div>
                                <span class="btn btn-raised btn-round btn-default btn-file">
                                    <span class="fileinput-new">Select signature</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="signature" />
                                </span>
                                <a href="javascript:;" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                            </div>
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-4">
                        <label for="">Select ID</label>
                        <select class="form-control" name="id_card">
                          <option value="<?php echo $id_card ?>"><?php echo $id_card ?></option>
                          <option value="National ID">National ID</option>
                          <option value="Voters ID">Voters ID</option>
                          <option value="International Passport">International Passport</option>
                        </select>
                      </div>
                      <div class="col-md-8">
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                            <div class="fileinput-new thumbnail img-raised">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                            <div>
                                <span class="btn btn-raised btn-round btn-default btn-file">
                                    <span class="fileinput-new">Select Image ID</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="idimg" />
                                </span>
                                <a href="javascript:;" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                            </div>
                        </div>
                      </div>
                    </div>
                    <a href="client.php" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary pull-right">Update Client</button>
                    <div class="clearfix"></div>
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
            </div>
          </div>
          <!-- /content -->
        </div>
      </div>

<?php

    include("footer.php");

?>