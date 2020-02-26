<?php

    include("header.php");

?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Create new Client</h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                  <form action="../functions/institution_client_upload.php" method="post">
                    <div class="row">
                      <div class="col-md-5">
                        <div class="form-group">
                          <label class="bmd-label-floating">Bank</label>
                          <input type="text" class="form-control" name="bank">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Account No</label>
                          <input type="text" class="form-control" name="acct_no">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Display name</label>
                          <input type="text" class="form-control" name="display_name">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Email address</label>
                          <input type="email" class="form-control" name="email">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Fist Name</label>
                          <input type="text" class="form-control" name="first_name">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Last Name</label>
                          <input type="text" class="form-control" name="last_name">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Phone No</label>
                          <input type="tel" class="form-control" name="phone">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Phone No2</label>
                          <input type="tel" class="form-control" name="phone2">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Address</label>
                          <input type="text" class="form-control" name="addres">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Gender:</label>
                          <select class="form-control" name="gender" id="">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Is staff:</label>
                          <select name="is_staff" id="" class="form-control">
                              <option value="Yes">Yes</option>
                              <option value="No">No</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="">Date of Birth:</label>
                          <input type="date" class="form-control" name="date_of_birth">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Profile Photo</label>
                          <div class="form-group">
                            <label class=""> Use .jpg or png files other file types are not acceptible.</label>
                            <input type="text" name="img" class="form-control" id="">
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
                            <input type="text" name="gau_first_name" id="" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label for=""> Last Name:</label>
                            <input type="text" name="gau_last_name" id="" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="">Phone:</label>
                              <input type="text" name="gau_phone" id="" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="">Phone:</label>
                              <input type="text" name="gau_phone2" id="" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                              <label for="">Home Address:</label>
                              <input type="text" name="gau_home_address" id="" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                              <label for="">Office Address:</label>
                              <input type="text" name="gau_office_address" id="" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="">Position Held:</label>
                              <input type="text" name="gau_position_held" id="" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Email:</label>
                            <input type="text" name="gau_email" id="" class="form-control">
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
                <?php
                $fullname = $_SESSION["fullname"];
                $sessint_id = $_SESSION["int_id"];
                $org_role = $_SESSION["org_role"];
                ?>
                <div class="card-body">
                  <h6 class="card-category text-gray"><?php echo $org_role?></h6>
                  <h4 class="card-title"> <?php echo $fullname?></h4>
                  <p class="card-description">
                  <?php echo $int_name?>
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