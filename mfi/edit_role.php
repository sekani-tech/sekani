<?php

$page_title = "Edit Permissions";
$destination = "staff_mgmt.php";
    include("header.php");

?>
<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
   $rom = mysqli_query($connection, "SELECT * FROM org_role WHERE id = '$id' && int_id = '$sessint_id'");
   $v = mysqli_fetch_array($rom);
   $rolename= $v['role'];
   $desc = $v['description'];
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // check the button value
 if($_POST['sumbit'] = 'edit_permission'){
     $name = $_POST['rname'];
     $des = $_POST['desx'];
   
   $rod = "UPDATE org_role SET role = '$name', description = '$des' WHERE id = '$id' && int_id = '$sessint_id'";
    $rox = mysqli_query($connection, $rod);
    if($rox){
      $URL="staff_mgmt.php";
      echo '<script type="text/javascript">
      $(document).ready(function(){
          swal({
              type: "success",
              title: "Successful",
              text: "The role has been edited",
              showConfirmButton: false,
              timer: 2000
          })
      });
      </script>
      ';
      echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    }
    else{
      echo '<script type="text/javascript">
              $(document).ready(function(){
                  swal({
                      type: "error",
                      title: "Error",
                      text: "not working",
                      showConfirmButton: false,
                      timer: 2000
                  })
              });
              </script>
              ';
    }
 }
}
?>
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Edit Roles</h4>
                </div>
                <div class="card-body">
                    <form method = "POST">
                <div class="col-md-6">
                    <div class="form-group">
                    <label>Role Name</label>
                    <input type="text" value="<?php echo $rolename;?>" style="text-transform: uppercase;" class="form-control" name="rname" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Description</label>
                      <input type="text" value="<?php echo $desc;?>" style="text-transform: uppercase;" class="form-control" name="desx" required>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary pull-right">Update Role</button>
                </div>
              </div>
            </div>
          </div>
        </div>
</div>
