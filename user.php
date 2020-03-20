<?php

    include("header.php");
?>
<?php
// load user role data
$sint_id = $_SESSION["int_id"];
$org = "SELECT * FROM org_role WHERE int_id = '$sint_id'";
$res = mysqli_query($connection, $org);
while ( $results[] = mysqli_fetch_object ( $res ) );
  array_pop ( $results );
?>
<!-- Content added here -->
<?php
// action for the form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $inst_id = $_POST["inst_id"];
  $username = $_POST['username'];
$user_t = $_POST['user_t'];
$display_name = $_POST['display_name'];
$email = $_POST['email'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$password = $_POST['password'];
$hash = password_hash($password, PASSWORD_DEFAULT);
$description = $_POST['description'];
$address = $_POST['address'];
$date_joined = $_POST['date_joined'];
$org_role = $_POST['org_role'];
$std = "Not Active";
$phone = $_POST['phone'];

// random number for image
$digits = 10;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);

$image3 = $_FILES['passport']["name"];
$target3 = "instimg/".basename($image3);
$personx = mysqli_query($connection, "SELECT * FROM institutions WHERE int_id = '$inst_id'");
if (count([$personx]) == 1) {
  $x = mysqli_fetch_array($personx);
  $int_namex = $x['int_name'];
}
$person = mysqli_query($connection, "SELECT * FROM users");
if (count([$person]) == 1) {
  $x = mysqli_fetch_array($person);
  $usn = $x['username'];
  if ($username == $usn) {
    $usext = "Please Change the Username It Exists";
  } else {
    $usext = "";
    if (move_uploaded_file($_FILES['passport']["tmp_name"], $target3)) {
      $imgmsg = "Image uploaded successfully";
    }else{
      $imgmsg = "Failed to upload image";
    }
    // then query for the users
    $queryuser = "INSERT INTO users (int_id, username, fullname, password, usertype, status, time_created, pics)
VALUES ('{$inst_id}', '{$username}', '{$display_name}', '{$hash}', '{$user_t}', '{$std}', '{$date_joined}', '{$image3}')";

$result = mysqli_query($connection, $queryuser);

if ($result) {
$qrys = "SELECT id FROM users WHERE username = '$username'";
$res = mysqli_query($connection, $qrys);
$row = mysqli_fetch_array($res);
$ui = $row["id"];
 if ($res) {
    $qrys = "INSERT INTO staff (int_id, int_name user_id, username, display_name, email, first_name, last_name,
description, address, date_joined, org_role, phone) VALUES ('{$inst_id}', '{$int_name}', '{$ui}', '{$username}', '{$display_name}', '{$email}',
'{$first_name}', '{$last_name}', '{$description}', '{$address}', '{$date_joined}', '{$org_role}', '{$phone}')";

$result = mysqli_query($connection, $qrys);
if ($connection->error) {
  try {
      throw new Exception("MYSQL error $connection->error <br> $qrys ", $mysqli->error);
  } catch (Exception $e) {
      echo "Error No: ".$e->getCode()." - ".$e->getMessage() . "<br>";
      echo n12br($e->getTraceAsString());
  }
}
if ($result) {
  $URL="users.php";
  echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    exit;
} else {
   echo "<p>Error</p>";
   $imgmsg = "";
}
 } else {
     echo "<p>ERROR</p>";
     $imgmsg = "";
 }
} else {
   echo "<p>Error</p>";
   $imgmsg = "";
}
// if ($connection->error) {
//     try {   
//         throw new Exception("MySQL error $connection->error <br> Query:<br> $queryuser", $msqli->errno);   
//     } catch(Exception $e ) {
//         echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
//         echo nl2br($e->getTraceAsString());
//     }
// }
  }
}
} else {
  $usext = "";
  $imgmsg = "";
}
?>
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Create new Staff</h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                  <form method="POST">
                    <div class="row">
                      <div class="col-md-5">
                        <div class="form-group">
                        <?php
                  function fill_int($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM institutions";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["int_id"].'">' .$row["int_name"]. '</option>';
                  }
                  return $out;
                  }
                  ?>
                          <label class="bmd-label-floating">Institution</label>
                          <select name="inst_id" class="form-control">
                        <option value="">select Institution</option>
                        <?php echo fill_int($connection); ?>
                      </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Username</label>
                          <input type="text" class="form-control" name="username">
                          <span class="help-block" style="color: red;"><?php echo $usext;?></span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Display name</label>
                          <input type="text" class="form-control" name="display_name">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Email address</label>
                          <input type="email" class="form-control" name="email">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">First Name</label>
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
                          <label class="bmd-label-floating">Password: (default - bateis1)</label>
                          <input type="password" value="bateis1" name="password" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Description</label>
                          <input type="text" class="form-control" name="description">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Address</label>
                          <input type="text" class="form-control" name="address">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Date Joined:</label>
                          <input type="date" class="form-control" name="date_joined">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="role" class="bmd-label-floating">Organization Role:</label>
                          <select name="org_role" id="" class="form-control">
                              <option value="">...</option>
                              <?php foreach ( $results as $option ) : ?>
                              <option value="<?php echo $option->role; ?>"><?php echo $option->role; ?></option>
                              <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Phone no</label>
                          <input type="tel" class="form-control" name="phone">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                    <span class="help-block" style="color: red;"><?php echo $imgmsg;?></span>
                    <!-- insert passport -->
                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <div class="fileinput-new thumbnail img-raised">
                            <!-- <img src="http://style.anu.edu.au/_anu/4/images/placeholders/person_8x10.png" rel="nofollow" alt="..."> -->
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                        <div>
                            <span class="btn btn-raised btn-round btn-default btn-file">
                                <span class="fileinput-new">Select Image</span>
                                <span class="fileinput-exists">Change</span>
                                <input type="file" name="passport" id="passport" />
                            </span>
                            <a href="javascript:;" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                        </div>
                    </div>
                  </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">UserType</label>
                          <select name="user_t" id="" class="form-control">
                          <option value="">...</option>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">Create Profile</button>
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
          <!-- /content -->
        </div>
      </div>

<?php

    include("footer.php");

?>