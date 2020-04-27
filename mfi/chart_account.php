<?php

$page_title = "Chart of Account";
$destination = "index.php";
    include("header.php");
?>
<?php
//  Sweet alert Function

// If it is successfull, It will show this message
  if (isset($_GET["message1"])) {
    $key = $_GET["message1"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "success",
            title: "Success",
            text: "Registration Successful",
            showConfirmButton: false,
            timer: 2000
        })
    });
    </script>
    ';
    $_SESSION["lack_of_intfund_$key"] = 0;
  }
}
// If it is not successfull, It will show this message
else if (isset($_GET["message2"])) {
  $key = $_GET["message2"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Error",
          text: "Error during Registration",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
}
if (isset($_GET["message3"])) {
  $key = $_GET["message3"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Success",
          text: "Staff was Updated successfully!",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
}
else if (isset($_GET["message4"])) {
$key = $_GET["message4"];
// $out = $_SESSION["lack_of_intfund_$key"];
$tt = 0;
if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
echo '<script type="text/javascript">
$(document).ready(function(){
    swal({
        type: "error",
        title: "Error",
        text: "Error updating Staff!",
        showConfirmButton: false,
        timer: 2000
    })
});
</script>
';
$_SESSION["lack_of_intfund_$key"] = 0;
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
                  <h4 class="card-title ">Chart of Accounts</h4>
                  <!-- Insert number users institutions -->
                  <p class="card-category"><?php
                   $query = "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id'";
                   $result = mysqli_query($connection, $query);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     echo $inr;
                   }?> Chart of Accounts || <a style = "color: white;" data-toggle="modal" data-target=".bd-example-modal-lg" href="#">Add Account</a></p>
                  <!-- Insert number users institutions -->
                  <script>
                  $(document).ready(function() {
                  $('#tabledat2').DataTable();
                  });
                  </script>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="tabledat2" class="table" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM acc_gl_account WHERE int_id ='$sessint_id' ORDER BY classification_enum ASC, name ASC";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <th>
                          GL No
                        </th>
                        <th>
                          Account Name
                        </th>
                        <th>
                          Account Type
                        </th>
                        <th>
                          Account ID
                        </th>
                        <th>
                         Balance
                        </th>
                        <th>Unreconciled Balance</th>
                        <th>Edit</th>
                        <!-- <th>Phone</th> -->
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo $row["gl_code"]; ?></th>
                          <?php
                          // using the parent_id to sort them out
                          $nameofacct = "";
                          $nameid = $row["name"];
                          $pid = $row["parent_id"];
                          if ($pid == "" || $pid == NULL || $pid == 0) {
                            $nameofacct = $nameid;
                          } else {
                            $select_each = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' && parent_id = '$pid'");
                            $tt = mysqli_fetch_array($select_each);
                            $gen = $tt["name"];
                            $nameofacct = $gen." ".$nameid;
                          }
                          ?>
                          <th><?php echo $nameofacct; ?></th>
                          <!-- this is for account type classification_enum -->
                          <?php
                          // get classification for account type using conditions
                          $class = "";
                          $row["classification_enum"];
                          if ($row["classification_enum"] == 1 || $row["classification_enum"] == "1") {
                            $class = "ASSETS";
                          } else if ($row["classification_enum"] == 2 || $row["classification_enum"] == "2") {
                            $class = "LIABILITY";
                          } else if ($row["classification_enum"] == 3 || $row["classification_enum"] == "3") {
                            $class = "EQUITY";
                          } else if ($row["classification_enum"] == 4 || $row["classification_enum"] == "4") {
                            $class = "INCOME";
                          } else if ($row["classification_enum"] == 5 || $row["classification_enum"] == "5") {
                            $class = "EXPENSE";
                          }
                          ?>
                          <th><?php echo $class; ?></th>
                          <th><?php echo $row["tag_id"]; ?></th>
                          <th><?php if ($row["organization_running_balance_derived"] < 0) {
                            echo '<div style="color: red;">'.$row["organization_running_balance_derived"].'</div>';
                          } else {
                            echo $row["organization_running_balance_derived"];
                          } ?></th>
                          <th><?php echo $row["reconciliation_enabled"]; ?></th>
                          <td><a href="edit_chart_account.php?edit=<?php echo $row["id"];?>" class="btn btn-info sm" ><i style="color:#ffffff;" class="material-icons">create</i></a></td>
                        </tr>
                        <?php }
                          }
                          else {
                            echo "0 Staff";
                          }
                          ?>
                      </tbody>
                    </table>
                    <!-- start dialog -->
                    <!-- <button type="button" class="btn btn-primary" >Large modal</button> -->

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title">Add Chart of Account</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
        <div class="modal-body">
         <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label >Account name*</label>
                      <input type="text" style="text-transform: uppercase;" class="form-control" name="acct_name" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label >GL Code*</label>
                      <input type="text" id="tit" style="text-transform: uppercase;" class="form-control" value="" name="gl_code" required readonly>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label >Account Type*</label>
                      <script>
                        // coment on later
                          $(document).ready(function(){
                            $('#give').change(function() {
                              var id = $(this).val();
                              if (id == "") {
                                document.getElementById('tit').readOnly = false;
                                $('#tit').val("choose an account type");
                              } else if (id == "ASSET") {
                                document.getElementById('tit').readOnly = true;
                                $('#tit').val("1" + Math.floor(1000 + Math.random() * 9000));
                              } else if (id == "LIABILITY") {
                                document.getElementById('tit').readOnly = true;
                                $('#tit').val("2" + Math.floor(1000 + Math.random() * 9000));
                              } else if (id == "EQUITY") {
                                document.getElementById('tit').readOnly = true;
                                $('#tit').val("3" + Math.floor(1000 + Math.random() * 9000));
                              } else if (id == "INCOME") {
                                document.getElementById('tit').readOnly = true;
                                $('#tit').val("4" + Math.floor(1000 + Math.random() * 9000));
                              } else if (id == "EXPENSE") {
                                document.getElementById('tit').readOnly = true;
                                $('#tit').val("5" + Math.floor(1000 + Math.random() * 9000));
                              } else {
                                $('#tit').val("Nothing");
                              }
                            });
                          });
                        </script>
                      <select class="form-control" name="acct_type" id="give">
                        <option value="">Select an option</option>
                        <option value="ASSET">ASSET</option>
                        <option value="LIABILITY">LIABILITY</option>
                        <option value="EQUITY">EQUITY</option>
                        <option value="INCOME">INCOME</option>
                        <option value="EXPENSE">EXPENSE</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label >External ID</label>
                      <input type="text" style="text-transform: uppercase;" class="form-control" name="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label >Account Tag</label>
                      <select class="form-control" name="act_tag" id="">
                        <option value="">Select an option</option>
                      </select>                    
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label >Account Usage</label>
                      <select class="form-control" name="acct_use" id="" required>
                        <option value="">Select an option</option>
                        <option value="1">GL ACCOUNT</option>
                        <option value="2">GL GROUP</option>

                      </select>                    
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label >Manual Entires Allowed</label><br/>
                      <div class="form-check form-check-inline">
                      <label class="form-check-label">
                          <input class="form-check-input" name="" type="checkbox" value="1">
                          <span class="form-check-sign">
                            <span class="check"></span>
                          </span>
                      </label>
                    </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label >Allow Bank reconciliation?</label><br/>
                      <div class="form-check form-check-inline">
                      <label class="form-check-label">
                          <input class="form-check-input" name="" type="checkbox" value="1">
                          <span class="form-check-sign">
                            <span class="check"></span>
                          </span>
                      </label>
                    </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label> Description:</label>
                      <input type="text" style="text-transform: uppercase;" class="form-control" name="middlename">  
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                  <div style="float:right;">
                        <span class="btn btn-primary pull-right">Add</span>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                      </form>
      </div>
    </div>
  </div>
</div>
                    <!-- end dialog -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

<?php

    include("footer.php");

?>