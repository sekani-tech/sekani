<?php

$page_title = "Create User";
$destination = "users.php";
    include("header.php");
?>
<?php
// load user role data
// $sint_id = $_SESSION["int_id"];
// $org = "SELECT * FROM org_role WHERE int_id = '$sint_id'";
// $res = mysqli_query($connection, $org);
// while ( $results[] = mysqli_fetch_object ( $res ) );
//   array_pop ( $results );
?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Create new Staff</h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                  <form action="../functions/int_staff_upload.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-md-5">
                        <div class="form-group">
                          <label class="bmd-label-floating">Institution</label>
                          <input readonly value="<?php echo $int_name; ?>" type="text" name="int_name" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Username</label>
                          <script>
                            $(document).ready(function(){
                              $('#usernamewarn').on("change keyup paste click", function(){
                                var usern = $(this).val();
                                $.ajax({
                                  url: "verify_user.php",
                                  method: "POST",
                                  data: {usern:usern},
                                  success: function(data){
                                    $('#warnuser').html(data);
                                  }
                                });
                              });
                            });
                          </script>
                          <input type="text" class="form-control" name="username" id="usernamewarn">
                          <span class="help-block" style="color: red;"><div id="warnuser"></div></span>
                        </div>
                      </div>
                      <?php
                      function fill_branch($connection)
                      {
                      $sint_id = $_SESSION["int_id"];
                      $dks = $_SESSION["branch_id"];
                      $org = "SELECT * FROM branch WHERE int_id = '$sint_id' AND id = '$dks' OR parent_id = '$dks'";
                      $res = mysqli_query($connection, $org);
                      $out = '';
                      while ($row = mysqli_fetch_array($res))
                      {
                        $out .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                      }
                      return $out;
                      }
                      ?>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Branch</label>
                          <select name="branch" id="branch" class="form-control">
                            <?php echo fill_branch($connection);?>
                        </select>
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
                          <label class="bmd-label-floating">Password: (default - password1)</label>
                          <input type="password" value="password1" name="password" class="form-control">
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
                      <?php
                  function fill_role($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM org_role WHERE int_id = '$sint_id' ORDER BY id ASC";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["id"].'">' .$row["role"]. '</option>';
                  }
                  return $out;
                  }
                  ?>
                        <div class="form-group">
                          <label for="role" class="bmd-label-floating">Organization Role:</label>
                          <select name="org_role" id="" class="form-control">
                              <option value="">...</option>
                              <?php echo fill_role($connection); ?>
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
                    <div class="col-md-8">
                    <!-- insert passport -->
                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <div class="fileinput-new thumbnail img-raised">
                            <!-- <img src="http://style.anu.edu.au/_anu/4/images/placeholders/person_8x10.png" rel="nofollow" alt="..."> -->
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
                    <input id ="file-upload" name="img" type="file" class="inputFileHidden"/>
                    <label> Select Images</label>
                    </div>
                    </div>
                  </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">UserType</label>
                          <select name="user_t" id="" class="form-control">
                          <option value="staff">...</option>
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
          </div>
          <!-- /content -->
        </div>
      </div>

<?php

    include("footer.php");

?>