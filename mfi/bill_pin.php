<?php

$page_title = "Bill & Airtime Pin";
$destination = "bill_airtime.php";
    include("header.php");
    // include("../../functions/connect.php");

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
        <form id="form" action="paystack_general/initialize.php" method="POST">
                <div class="card-body">
                <div class = "row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="installmentAmount" style="color: white;" >New Pin</label>
                      <input type="number" class="form-control" style="color: white;" name="amt" value="<?php echo $r_n_b; ?>" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                      <label for="installmentAmount" style="color: white;">Password</label>
                      <input type="password" class="form-control" style="color: white;" name="password" value="">
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