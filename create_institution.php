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
                  <h4 class="card-title">Institutions</h4>
                  <p class="card-category">Create New institution profile</p>
                </div>
                <div class="card-body">
                  <form action="functions/institution_data.php" method="post">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Name</label>
                          <input type="text" class="form-control" name="int_name">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">RCN</label>
                          <input type="text" class="form-control" name="rcn">
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <label class="bmd-label-floating">LGA</label>
                          <input type="text" class="form-control" name="lga">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">State</label>
                          <input type="text" class="form-control" name="int_state">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">E-mail</label>
                          <input type="email" class="form-control" name="email">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Office Address</label>
                          <input type="text" class="form-control" name="office_address">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Website</label>
                          <input type="text" class="form-control" name="website">
                        </div>
                      </div>
                      <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Phone</label>
                                <input type="text" name="office_phone" class="form-control" id="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="bmd-label-floating">Title</label>
                                <select name="pc_title" class="form-control" id="">
                                    <option value="Mr">Mr</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Miss">Miss</option>
                                    <option value="Master">Master</option>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="clearfix"></div> -->
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="bmd-label-floating">Primary Contact Surname</label>
                                <input type="text" name="pc_surname" class="form-control" id="">
                            </div>
                        </div>
                        
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="bmd-label-floating">Primary Contact Other Names</label>
                                <input type="text" name="pc_other_name" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="bmd-label-floating">Primary Contact Designation</label>
                                <input type="text" name="pc_designation" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Primary Contact Phone</label>
                                <input type="tel" name="pc_phone" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="bmd-label-floating">Primary Contact Email</label>
                                <input type="email" name="pc_email" class="form-control" id="">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">Create Profile</button>
                    <button type="reset" class="btn btn_danger">Reset</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card card-profile">
                <div class="card-avatar">
                  <a href="#pablo">
                    <img class="img" src="assets/img/faces/marc.jpg" />
                  </a>
                </div>
                <!-- Get session data and populate user profile -->
                <?php
                $fullname = $_SESSION["fullname"];
                $sessint_id = $_SESSION["int_id"];
                $org_role = $_SESSION["org_role"];
                $inq = mysqli_query($connection, "SELECT * FROM institutions WHERE int_id='$sessint_id'");
                if (count([$inq]) == 1) {
                  $n = mysqli_fetch_array($inq);
                  $int_name = $n['int_name'];
                }
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
        </div>
      </div>

<?php

    include("footer.php");

?>