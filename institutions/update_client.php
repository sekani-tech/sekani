<?php

    include("header.php");

?>
<?php
if(isset($_GET["edit"])) {
  $id = $_GET["edit"];
  $update = true;
  $person = mysqli_query($connection, "SELECT * FROM clients WHERE id='$id'");

  if (count([$person]) == 1) {
    $n = mysqli_fetch_array($person);
    $bank = $n['bank'];
    $acct_no = $n['acct_no'];
    $display_name = $n['display_name'];
    $email = $n['email'];
    $first_name = $n['first_name'];
    $last_name = $n['last_name'];
    $phone = $n['phone'];
    $phone2 = $n['phone2'];
    $address = $n['addres'];
    $gender = $n['gender'];
    $is_staff = $n['is_staff'];
    $date_of_birth = $n['date_of_birth'];
    $img = $n['img'];
// gaurantors part
$gau_first_name = $n['gau_first_name'];
$gau_last_name = $n['gau_last_name'];
$gau_phone = $n['gau_phone'];
$gau_phone2 = $n['gau_phone2'];
$gau_home_address = $n['gau_home_address'];
$gau_office_address = $n['gau_office_address'];
$gau_position_held = $n['gau_position_held'];
$gau_email = $n['gau_email'];
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
                  <h4 class="card-title">Update Client</h4>
                  <p class="card-category">Modify Client Proile</p>
                </div>
                <div class="card-body">
                  <form action="../functions/update_client.php" method="post">
                    <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                          <label class="bmd-label-floating">ID</label>
                          <input type="text" readonly value="<?php echo $id; ?>" name="id" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div class="form-group">
                          <label class="bmd-label-floating">Bank</label>
                          <input type="text" value="<?php echo $bank; ?>" name="bank" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Account No</label>
                          <input type="text" value="<?php echo $acct_no; ?>" name="acct_no" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Display name</label>
                          <input type="text" value="<?php echo $display_name; ?>" name="display_name" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Email address</label>
                          <input type="email" value="<?php echo $email; ?>" name="email" class="form-control">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">First Name</label>
                          <input type="text" value="<?php echo $first_name; ?>" name="first_name" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Last Name</label>
                          <input type="text" value="<?php echo $last_name; ?>" name="last_name" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Phone No</label>
                          <input type="tel" value="<?php echo $phone; ?>" name="phone" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Phone No2</label>
                          <input type="tel" class="form-control">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Address</label>
                          <input type="text" value="<?php echo $phone2; ?>" name="phone2" class="form-control">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Gender:</label>
                          <select class="form-control" name="gender" id="">
                          <option value="<?php echo $gender; ?>"><?php echo $gender; ?></option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Is staff:</label>
                          <select name="is_staff" id="" class="form-control">
                          <option value="<?php echo $is_staff; ?>"><?php echo $is_staff; ?></option>
                              <option value="">Yes</option>
                              <option value="">No</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="">Date of Birth:</label>
                          <input type="date" value="<?php echo $date_of_birth; ?>" name="date_of_birth" class="form-control">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Profile Photo</label>
                          <div class="form-group">
                            <label class=""> Use .jpg or png files other file types are not acceptible.</label>
                            <input type="text" value="<?php echo $img; ?>" name="img" class="form-control" id="">
                          </div>
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div class="card-header card-header-primary">
                      <h5 class="card-title">Gaurantor</h5>
                    </div>
                    <hr>
                    <!-- guarantor -->
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <label for=""> First Name:</label>
                            <input type="text" value="<?php echo $gau_first_name; ?>" name="gau_first_name" id="" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label for=""> Last Name:</label>
                            <input type="text" value="<?php echo $gau_last_name; ?>" name="gau_last_name" id="" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="">Phone:</label>
                              <input type="text" value="<?php echo $gau_phone; ?>" name="gau_phone" id="" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="">Phone:</label>
                              <input type="text" value="<?php echo $gau_phone2; ?>" name="gau_phone2" id="" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                              <label for="">Home Address:</label>
                              <input type="text" value="<?php echo $gau_home_address; ?>" name="gau_home_address" id="" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                              <label for="">Office Address:</label>
                              <input type="text" value="<?php echo $gau_office_address; ?>" name="gau_office_address" id="" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="">Position Held:</label>
                              <input type="text" value="<?php echo $gau_position_held; ?>" name="gau_position_held" id="" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Email:</label>
                            <input type="text" value="<?php echo $gau_email; ?>" name="gau_email" id="" class="form-control">
                        </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">Create Client</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card card-profile">
                <div class="card-avatar">
                  <a href="#pablo">
                    <img class="img" src="../assets/img/faces/marc.jpg" />
                  </a>
                </div>
                <!-- Get session data and populate user profile -->
                <div class="card-body">
                  <h6 class="card-category text-gray">CEO / Co-Founder</h6>
                  <h4 class="card-title">Alec Thompson</h4>
                  <p class="card-description">
                    Sekani Systems
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