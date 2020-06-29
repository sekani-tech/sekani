<?php

$page_title = "View Group";
$destination = "branch.php";
    include("header.php");

?>
<?php
 if (isset($_GET["edit"])) {
  $user_id = $_GET["edit"];
  $update = true;
  $value = mysqli_query($connection, "SELECT * FROM group WHERE id='$user_id'");

  if (count([$value] == 1)) {
    $n = mysqli_fetch_array($value);
    $name = $n['g_name'];
    $email = $n['meeting_day'];
    $email = $n['meeting_time'];
    $phone = $n['meeting_location'];
    $location = $n['location'];
  }
}
?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Edit</h4>
                  <p class="card-category">Modify Branch Data</p>
                </div>
                <div class="card-body">
                  <form action="../functions/branch_update.php" method="post">
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">ID</label>
                          <input type="text"  readonly class="form-control" value="<?php echo $user_id; ?>" name="id">
                        </div>
                    </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Name</label>
                          <input type="text" class="form-control" value="<?php echo $name; ?>" name="name">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Email</label>
                          <input type="text" class="form-control" value="<?php echo $email; ?>" name="email">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Phone</label>
                          <input type="text" class="form-control" value="<?php echo $phone; ?>" name="phone">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Location</label>
                          <input type="text" class="form-control" value="<?php echo $location; ?>" name="location">
                        </div>
                      </div>
                      </div>
                    <button type="submit" class="btn btn-primary pull-right">Update Branch</button>
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