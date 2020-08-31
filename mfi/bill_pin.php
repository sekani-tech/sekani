<?php

$page_title = "Bill & Airtime Pin";
$destination = "settings.php";
    include("header.php");
    // include("../../functions/connect.php");

?>
<?php
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  //  check the new field out
  $pin = $_POST["newpin"];
  $password = $_POST["passkey"];
  $new = password_hash($pin, PASSWORD_DEFAULT);
  $user_email = $_SESSION["email"];
 //  select the db
 $username = $_SESSION["username"];

 $query_pass = mysqli_query($connection, "SELECT * FROM users WHERE username = '$username'");
   $x = mysqli_fetch_array($query_pass);
   $id_user = $x["id"];
   $user_pass = $x["password"];
   // making a change
   if (password_verify($password, $user_pass)) {
    //  new change
    $update_query = mysqli_query($connection, "UPDATE `users` SET `pin` = '$new' WHERE `users`.`id` = '$id_user'");
    // tell me the time dont build me the clock
    if ($update_query) {
      echo '<script type="text/javascript">
                  $(document).ready(function(){
                      swal({
                          type: "success",
                          title: "Transaction Pin Change Successful",
                          text: "Your pin is now '.$pin.'",
                          showConfirmButton: false,
                          timer: 5000
                      })
                  });
                  </script>
      ';
    } else {
      echo '<script type="text/javascript">
      $(document).ready(function(){
          swal({
              type: "error",
              title: "Entry Error",
              text: "Please Check Your Password Character",
              showConfirmButton: false,
              timer: 4000
          })
      });
      </script>
';
    }
   } else {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "Wrong Password",
            text: "you need to insert correct password to change your tansaction pin",
            showConfirmButton: false,
            timer: 4000
        })
    });
    </script>
';
   }
 }
   ?>
<?php
// right now we will program
// first step - check if this person is authorized
// $query = "SELECT * FROM org_role WHERE role = '$org_role'";
// $process = mysqli_query($connection, $query);
// $role = mysqli_fetch_array($process);
// $role_id = $role['id'];

if ($per_bills == 1 || $per_bills == "1") {
?>
<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
        <div class="row">
  <div class="col-md-4 ml-auto mr-auto">
    <div class="card card-pricing bg-primary"><div class="card-body">
        <!-- <div class="card-icon">
            <i class="material-icons">business</i>
        </div> -->
        <p>Change your Transaction Pin (defualt - 1234)</p>
        <form id="form" method="POST">
                <div class="card-body">
                <div class = "row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="installmentAmount" style="color: white;" >New Pin</label>
                      <input type="number" class="form-control" style="color: white;" name="newpin" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                      <label for="installmentAmount" style="color: white;">Password</label>
                      <input type="password" class="form-control" style="color: white;" name="passkey" value="">
                    </div>
                </div>
                </div>
                </div>
                <button type="submit" class="btn btn-white btn-round pull-right" style="color:black;">Update</button>
                </form>
        </div>
    </div>
  </div>
</div>
        </div>
</div>
<?php
} else {
  echo '<script type="text/javascript">
  $(document).ready(function(){
   swal({
    type: "error",
    title: "You Dont Have Airtime Access",
    text: "Your are not permitted",
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
<?php
include("footer.php");
?>