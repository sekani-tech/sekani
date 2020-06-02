<?php

$page_title = "Products Configuration";
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
else if (isset($_GET["message5"])) {
  $key = $_GET["message5"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Deleted",
          text: "Charge was Deleted Successfully!",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
  }
  }
  else if (isset($_GET["message6"])) {
    $key = $_GET["message6"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "Error",
            text: "Error deleting Staff!",
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
<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check the button value
    $rog = $_POST['submit'];
    $add_pay = $_POST['submit'];
    if ($add_pay == 'add_payment'){
      $name = $_POST['name'];
      $bran = $_SESSION["branch_id"];
      $desc = $_POST['des'];
      $default = $_POST['default'];
      $gl_type = $_POST['gl_type'];
      $result = "SELECT * FROM acc_gl_account WHERE id = '$gl_type' AND int_id = '$sint_id'";
      $done = mysqli_query($connection, $result);
      $ir = mysqli_fetch_array($done);
      $gl_code = $_POST['gl_code'];

      
      $result = "SELECT * FROM acc_gl_account WHERE int_id = '$sint_id' AND parent_id = '$gl_type'";
      if ($result) {
        $inr = mysqli_num_rows($result);
        $gl_no = $checkx.$inr + 1;
    }

      if(isset($_POST['is_cash'])){
        $is_cash = 1;
      }else{
        $is_cash = 0;
      }
      $query = mysqli_query($connection, "INSERT INTO payment_type (int_id, branch_id, value, description, is_cash_payment, order_position)
      VALUES('{$sessint_id}', '{$bran}','{$name}', '{$desc}', '{$is_cash}', '{$default}')");
      if($query){
        $glq ="INSERT INTO `acc_gl_account` (`int_id`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`,
         `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`,
          `organization_running_balance_derived`, `last_entry_id_derived`) VALUES ('{$sessint_id}', '{$bran}', '{$name}', '{$gl_type}', NULL, '{$gl_code}', NULL, '1', '2', '',
           NULL, NULL, '0', '0.00', NULL)";
        $gl = mysqli_query($connection, $glq);
        echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "success",
                title: "Created Successfully",
                text: " Payment type Created",
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
<?php
// right now we will program
// first step - check if this person is authorized
// $query = "SELECT * FROM org_role WHERE role = '$org_role'";
// $process = mysqli_query($connection, $query);
// $role = mysqli_fetch_array($process);
// $role_id = $role['id'];

if ($per_con == 1 || $per_con == "1") {
?>
  <!-- Content added here -->
  <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <!-- <span class="nav-tabs-title">Configuration:</span> -->
                      <ul class="nav nav-tabs" data-tabs="tabs">
                        <!-- <li class="nav-item">
                          <a class="nav-link active" href="#profile" data-toggle="tab">
                            <i class="material-icons">bug_report</i> Password Settings
                            <div class="ripple-container"></div>
                          </a>
                        </li> -->
                        <li class="nav-item">
                          <a class="nav-link active" href="#products" data-toggle="tab">
                          <!-- visibility -->
                            <i class="material-icons">attach_money</i> Loan Products
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#messages" data-toggle="tab">
                            <i class="material-icons">supervisor_account</i> Charges
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#credit" data-toggle="tab">
                            <i class="material-icons">find_in_page</i> Credit Check
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#cash" data-toggle="tab">
                          <!-- visibility -->
                            <i class="material-icons">account_balance</i> Payment Type
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <!-- <div class="tab-pane active" id="profile">
                      <div class="card-title">Auto Logout</div>
                      <form action="">
                        <div class="form-group">
                          <label for="">Toggle on and off </label>
                          <select name="" class="form-control" id="">
                            <option value="On">On</option>
                            <option value="Off">Off</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="">Duration</label>
                          <input type="number" name="" class="form-control" id="">
                        </div>
                        <button class="btn btn-primary">Update</button>
                      </form>
                    </div> -->
                    <div class="tab-pane active" id="products">
                      <a href="manage_product.php" class="btn btn-primary"> Create New Product</a>
                      <div class="table-responsive">
                  <script>
                  $(document).ready(function() {
                  $('#tabledat4').DataTable();
                  });
                  </script>
                    <table id="tabledat4" class="table" style="width: 100%;">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM product WHERE int_id ='$sessint_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <!-- <th>
                          ID
                        </th> -->
                        <th>Name</th>
                        <th>
                          Description
                        </th>
                        <th>
                          Product Group
                        </th>
                        <th>
                          Edit
                        </th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo $row["name"]; ?></th>
                          <th><?php echo $row["description"]; ?></th>
                          <th><?php echo $row["short_name"]; ?></th>
                          <td><a href="update_product.php?edit=<?php echo $row["id"];?>" class="btn btn-info">Edit</a></td>
                        </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                      </tbody>
                    </table>
                  </div>
                    </div>
                    <div class="tab-pane" id="messages">
                    <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script>
                    <a href="create_charge.php" class="btn btn-primary"> Add Charge</a>
                      <table id="tabledat" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM `charge` WHERE int_id = '$sessint_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <th>
                          Name
                        </th>
                        <th>
                          Product
                        </th>
                        <th>
                         Active
                        </th>
                        <th>
                          Charge Type
                        </th>
                        <th>
                         Amount
                        </th>
                        <th>View</th>
                        <th>Delete</th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                         <?php $row["id"]; ?>
                          <th><?php echo $row["name"]; ?></th>
                          <?php
                          $me="";
                          if ($row["charge_applies_to_enum"] == 1) {
                            $me = "Loan";
                          } else if ($row["charge_applies_to_enum"] == 2) {
                            $me = "Savings";
                          }
                          else if ($row["charge_applies_to_enum"] == 3) {
                            $me = "Shares";
                          }
                         ?>
                         <th><?php echo $me; ?></th>
                          <th><?php echo $row["is_active"]; ?></th>
                          <?php
                          $xs="";
                          if ($row["charge_time_enum"] == 1) {
                            $xs = "Disbursement";
                          } else if ($row["charge_time_enum"] == 2) {
                            $xs = "Manual Charge";
                          } else if ($row["charge_time_enum"] == 3) {
                            $xs = "Savings Activiation";
                          } else if ($row["charge_time_enum"] == 5) {
                            $xs = "Deposit Fee";
                          } else if ($row["charge_time_enum"] == 6) {
                            $xs = "Annual Fee";
                          } else if ($row["charge_time_enum"] == 8) {
                            $xs = "Installment Fees";
                          } else if ($row["charge_time_enum"] == 9) {
                            $xs = "Overdue Installment Fee";
                          } else if ($row["charge_time_enum"] == 12) {
                            $xs = "Disbursement - Paid With Repayment";
                          } else if ($row["charge_time_enum"] == 13) {
                            $xs = "Loan Rescheduling Fee";
                          } 
                         ?>
                         <th><?php echo $xs; ?></th>
                          <th><?php echo $row["amount"]; ?></th>
                          <td><a href="charge_edit.php?edit=<?php echo $row["id"];?>" class="btn btn-info">View</a></td>
                          <td><a href="../functions/charge_delete.php?delete=<?php echo $row["id"];?>" class="btn btn-danger">Delete</a></td>
                        </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                          <!-- <th></th> -->
                      </tbody>
                      </table>
                    </div>
                    <!-- credit checks -->
                    <div class="tab-pane" id="credit">
                    <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script>
                   <!-- <a href="add_credit_check.php" class="btn btn-primary"> Add Credit Check</a> -->
                    <div class="table-responsive">
                    <table id="tabledat" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM credit_check WHERE int_id = '$sessint_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <th>
                          Id
                        </th>
                        <th>
                          Name
                        </th>
                        <th>
                          Entity Name
                        </th>
                        <th>
                         Severity Level
                        </th>
                        <th>
                          Rating Type
                        </th>
                        <th>
                         Value
                        </th>
                        <th>View</th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                         <th><?php echo $row["id"]; ?></th>
                          <th><?php echo $row["name"]; ?></th>
                          <?php
                          if ($row["related_entity_enum_value"] == 1) {
                            $me = "Loan";
                          }
                          ?>
                          <th><?php echo $me; ?></th>
                          <?php
                          if ($row["severity_level_enum_value"] == 1) {
                            $xs = "Block Loan";
                          } else if ($row["severity_level_enum_value"] == 2) {
                            $xs = "Warning";
                          } else if ($row["severity_level_enum_value"] == 3) {
                            $xs = "Pass";
                          } 
                          ?>
                          <th><?php echo $xs; ?></th>
                          <?php
                          if ($row["rating_type"] == 1) {
                            $rt = "Boolean";
                          } else if ($row["rating_type"] == 2) {
                            $rt = "Score";
                          }
                          ?>
                          <th><?php echo $rt; ?></th>
                          <?php
                          if ($row["is_active"] == 1) {
                            $isa = "Active";
                          } else if ($row["is_active"] == 0) {
                            $isa = "Not Active";
                          }
                          ?>
                          <th><?php echo $isa; ?></th>
                          <td><a href="creditcheck_edit.php?edit=<?php echo $row["id"];?>" class="btn btn-info">Edit</a></td>
                        </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                          <!-- <th></th> -->
                      </tbody>
                    </table>
                  </div>
                    </div>
                    <!-- end of credit checkss -->
                    <div class="tab-pane" id="cash">
                    <div class="table-responsive">
                  <button data-toggle="modal" data-target="#exampleModal" class="btn btn-primary pull-left">Add</button>
                      <!-- form of staff -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Payment Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-12">
            <div class="form-group">
               <label class="bmd-label-floating">Name</label>
               <input type = "text" class="form-control" name = "name"/>
              </div>
            </div>
            <div class="col-md-12">
            <div class="form-group">
               <label class="bmd-label-floating">Description</label>
               <input type = "text" class="form-control" name = "des"/>
              </div>
            </div>
            <div class="col-md-6">
            <?php
                  function fill_gl($connection) {
                    $sint_id = $_SESSION["int_id"];
                    $org = "SELECT * FROM acc_gl_account WHERE (int_id = '$sint_id' AND (parent_id = '' OR parent_id = '0'))";
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
               <label class="bmd-label-floating">GL Group</label>
               <select name="gl_type" id="role" class="form-control">
                 <option value="0">choose a gl type</option>
                 <option value="1">CASH ASSET</option>
                 <option value="5">Due From Banks</option>
                 <option value="403">SALARIES ARREARS</option>
                <!-- <?php echo fill_gl($connection); ?> -->
             </select>
             <input type="text" id="int_id" hidden  value="<?php echo $sessint_id; ?>" style="text-transform: uppercase;" class="form-control">
              </div>
            </div>
            <script>
                        // coment on later
                          $(document).ready(function(){
                            $('#give').change(function() {
                              var id = $(this).val();
                              if (id == "") {
                                document.getElementById('tit').readOnly = false;
                                $('#tit').val("choose an account type");
                              } else if (id == "1") {
                                document.getElementById('tit').readOnly = true;
                                $('#tit').val("1" + Math.floor(1000 + Math.random() * 9000));
                              } else if (id == "2") {
                                document.getElementById('tit').readOnly = true;
                                $('#tit').val("2" + Math.floor(1000 + Math.random() * 9000));
                              } else if (id == "3") {
                                document.getElementById('tit').readOnly = true;
                                $('#tit').val("3" + Math.floor(1000 + Math.random() * 9000));
                              } else if (id == "4") {
                                document.getElementById('tit').readOnly = true;
                                $('#tit').val("4" + Math.floor(1000 + Math.random() * 9000));
                              } else if (id == "5") {
                                document.getElementById('tit').readOnly = true;
                                $('#tit').val("5" + Math.floor(1000 + Math.random() * 9000));
                              } else {
                                $('#tit').val("Nothing");
                              }
                            });
                          });
                        </script>
            <div class ="col-md-6">
              <div class="form-group">
              <label class="bmd-label-floating">Account Type</label>
              <select class="form-control" name="acct_type" id="give">
                        <option value="">Select an option</option>
                        <option value="1">ASSET</option>
                        <option value="2">LIABILITY</option>
                        <option value="3">EQUITY</option>
                        <option value="4">INCOME</option>
                        <option value="5">EXPENSE</option>
                      </select>
              </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
               <label class="bmd-label-floating">Default</label>
              <select class="form-control" name= "default">
                <option value="1">Yes</option>
                <option value="0">No</option>
              </select>
              </div>
            </div>  
            <div class="col-md-6">
                    <div class="form-group">
                      <label >GL Code*</label>
                      <input type="text" id="tit" style="text-transform: uppercase;" class="form-control" value="" name="gl_code" required readonly>
                    </div>
                  </div>
            <div class="col-md-6">
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="" name="is_cash">
                Is Cash payment
                <span class="form-check-sign">
                <span class="check"></span>
                </span>
              </label>
           </div>
            </div>
            
            </div>
            <div class="col-md-12">
            <div class="form-group">
               <label class="bmd-label-floating"></label>
               <input type = "text" hidden class="form-control"/>
              </div>
            </div>
           <!-- Next -->
                    </div>
                    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="submit" value="add_payment" type="button" class="btn btn-primary">Save changes</button>
      </div>
                </form>
                </div>
                </div>
            </div>
            </div>
            <script>
                  $(document).ready(function() {
                  $('#tabledat4').DataTable();
                  });
                  </script>
                    <table id="tabledat4" class="table">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM payment_type WHERE int_id ='$sessint_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <!-- <th>
                          ID
                        </th> -->
                        <th>Name</th>
                        <th>
                          Description
                        </th>
                        <th>
                          Default
                        </th>
                        <th>
                         Cash Payment
                        </th>
                        <th>
                          Edit
                        </th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo $row["value"]; ?></th>
                          <th><?php echo $row["description"]; ?></th>
                          <?php 
                          if ($row["order_position"] == 1){
                            $def = "Yes";
                          }
                          else{
                            $def = "No";
                          }
                          ?>
                         <th><?php echo $def; ?></th>
                          <?php 
                          if ($row["is_cash_payment"] == 1){
                            $cash = "Yes";
                          }
                          else{
                            $cash = "No";
                          }
                          ?>
                         <th><?php echo $cash; ?></th>
                          <td><a href="update_branch.php?edit=<?php echo $row["id"];?>" class="btn btn-info">Edit</a></td>
                          </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                      </tbody>
                    </table>
                    </div>
                    <!-- end of cash payment -->
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- / -->
        </div>
      </div>

<?php

    include("footer.php");

?>
<?php
} else {
  echo '<script type="text/javascript">
  $(document).ready(function(){
   swal({
    type: "error",
    title: "Configuration Permission Denied",
    text: "You Dont Have Access to configuration",
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