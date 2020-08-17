
<?php

$page_title = "Add Account";
$destination = "client.php";
include("header.php");
$client_id = $_GET['edit'];
?>
<?php
if ($acc_op == 1 || $acc_op == "1") {
?>
<!-- Content added here -->
<div class="content">
    <div class="container-fluid">
      <!-- your content here -->
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Add an Account</h4>
              <p class="card-category">Fill in all important data</p>
            </div>
            <div class="card-body">
              <form action="../functions/account_upload.php" method="post" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Account Type</label>
                      <?php
                  function fill_savings($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM savings_product WHERE int_id = '$sint_id'";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                  }
                  return $out;
                  }
                  ?>
                  <input type="text" hidden name="client_id" value="<?php echo $client_id;?>"/>
                        <select required name="acct_type" class="form-control" data-style="btn btn-link" id="collat">
                          <option value="">select a Account Type</option>
                          <?php echo fill_savings($connection); ?>
                        </select>
                    </div>
                  </div>
                </div>
                <input type="submit" value="Add Account" name="submit" id="submit" class="btn btn-primary pull-right"/>
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
}
 else {
  echo '<script type="text/javascript">
  $(document).ready(function(){
   swal({
    type: "error",
    title: "Account opening Authorization",
    text: "You Dont Have permission open an account",
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
