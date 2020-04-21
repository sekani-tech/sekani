
<?php

$page_title = "New Client";
$destination = "client.php";
include("header.php");

?>
<!-- Content added here -->
<div class="content">
    <div class="container-fluid">
      <!-- your content here -->
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Create new Client</h4>
              <p class="card-category">Fill in all important data</p>
            </div>
            <div class="card-body">
              <form action="../functions/institution_client_upload.php" method="post" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Account Type</label>
                        <select name="acct_type" class="form-control" data-style="btn btn-link" id="collat">
                          <option value="">select a Account Type</option>
                          <option value="savings">Savings Account</option>
                          <option value="current">Current Account</option>
                        </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Client Type</label>
                      <select name="ctype" class="form-control" id="collat">
                          <option value="Individual">Individual</option>
                          <option value="Joint">Joint Account</option>
                          <option value="Student">Cooperate Account</option>
                        </select>
                    </div>
                  </div>
                  <!-- </div> -->
                  <div class="col-md-4">
                    <div class="form-group">
                      <label >Display name</label>
                      <input type="text" style="text-transform: uppercase;" class="form-control" name="display_name">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label >First Name</label>
                      <input type="text" style="text-transform: uppercase;" class="form-control" name="firstname">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label >Middle Name</label>
                      <input type="text" style="text-transform: uppercase;" class="form-control" name="middlename">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label >Last Name</label>
                      <input type="text" style="text-transform: uppercase;" class="form-control" name="lastname">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label >Phone No</label>
                      <input type="tel" class="form-control" name="phone">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label >Phone No2</label>
                      <input type="tel" class="form-control" name="phone2">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label >Email address</label>
                      <input type="email" class="form-control" name="email">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label >Address</label>
                      <input type="text" style="text-transform: uppercase;" class="form-control" name="address">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label >Gender:</label>
                      <select class="form-control" name="gender" id="">
                        <option value="MALE">MALE</option>
                        <option value="FEMALE">FEMALE</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="">Date of Birth:</label>
                      <input type="date" class="form-control" name="date_of_birth">
                    </div>
                  </div>
                  <div class="col-md-4">
                  <?php
                  function fill_branch($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM branch WHERE int_id = '$sint_id'";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                  }
                  return $out;
                  }
                  ?>
                    <div class="form-group">
                      <label class="">Branch:</label>
                      <select name="branch" class="form-control " id="collat">
                          <option value="">select a Branch</option>
                          <?php echo fill_branch($connection); ?>
                        </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="">Country:</label>
                      <input type="text" style="text-transform: uppercase;" class="form-control" value = "NIGERIA" name="country">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="">State:</label>
                      <select class="form-control " style="text-transform: uppercase;" name="state" id="selState" onchange="configureDropDownLists()">
                      </select>
                      
                    </div>
                  </div>
                  <!-- <div class="col-md-4">
                    <label for="">State:</label>
                    <input type="text"  class="form-control" id="">
                  </div> -->
                  <div class="col-md-4">
                    <label for="">LGA:</label>
                      <select  class="form-control" style="text-transform: uppercase;" name="lga" id="selCity">
                      </select>
                  </div>
                  <div class="col-md-4">
                    <label for="">BVN:</label>
                    <input type="text" style="text-transform: uppercase;" name="bvn" class="form-control" id="">
                  </div>
                  <div class="col-md-4">
                    <p><label for="">Active Alerts:</label></p>
                    <div class="form-check form-check-inline">
                      <label class="form-check-label">
                          <input class="form-check-input" name="sms_active" type="checkbox" value="1">
                          SMS
                          <span class="form-check-sign">
                            <span class="check"></span>
                          </span>
                      </label>
                    </div>
                    <div class="form-check form-check-inline">
                      <label class="form-check-label">
                          <input class="form-check-input" name="email_active" type="checkbox" value="">
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
                      <select name="acct_of" class="form-control" id="">
                        <option value="">select account officer</option>
                        <?php echo fill_officer($connection); ?>
                      </select>
                    </div>
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
                      <div class="col-md-4">
                    <label for="file-upload" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input id ="file-upload" name="passport" type="file" class="inputFileHidden"/>
                    <label> Select Passport</label>
                    </div>
                    
                    <div class="col-md-4">
                    <label for="file-insert" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input id ="file-insert" name="signature" type="file" class="inputFileHidden"/>
                    <label> Select Signature</label>
                    </div>
                    
                    <div class="col-md-4">
                    <label for="file-enter" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input id ="file-enter" type="file" name="id_img_url" class="inputFileHidden"/>
                    <label> Select ID</label>
                    </div>
                  <div class="col-md-4">
                    <label for="">Id Type</label>
                    <select name="id_card" class="form-control " id="">
                      <option value="National ID">National ID</option>
                      <option value="Voters ID">Voters ID</option>
                      <option value="International Passport">International Passport</option>
                      <!-- <option value="Drivers Liscense"></option> -->
                    </select>
                  </div>
                </div>
                <a href="client.php" class="btn btn-danger">Back</a>
                <button type="submit" name="submit" id="submit" class="btn btn-primary pull-right">Create Client</button>
                <div class="clearfix"></div>
              </form>
            </div>
          </div>
        </div>
        <!-- /form card -->
      </div>
      <!-- /content -->
    </div>
  </div>

<?php

include("footer.php");

?>
