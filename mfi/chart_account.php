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
                   }?> Chart of Accounts || <a style = "color: white;" href="add_chart_account.php">Add Account</a></p>
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
                        $query = "SELECT * FROM acc_gl_account WHERE int_id ='$sessint_id'";
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
                          <th><?php echo $row["name"]; ?></th>
                          <th><?php echo $row["account_type"]; ?></th>
                          <th><?php echo $row["tag_id"]; ?></th>
                          <th><?php echo $row["organization_running_balance_derived"]; ?></th>
                          <th><?php echo $row["reconciliation_enabled"]; ?></th>
                          <td><a onclick="showDialog()" class="btn btn-info" ><i style="color:#ffffff;" class="material-icons">create</i></a></td>
                        </tr>
                        <?php }
                          }
                          else {
                            echo "0 Staff";
                          }
                          ?>
                      </tbody>
                    </table>
                    <div class="form-group">
                      <div id="background">
                      </div>
                      <div id="diallbox">
                      <form action="" method="POST" enctype="multipart/form-data">
                      <h3>Edit Account</h3>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label >Account name</label>
                      <input type="text" style="text-transform: uppercase;" class="form-control" name="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label >GL Code</label>
                      <input type="text" style="text-transform: uppercase;" class="form-control" name="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label >Account Type</label>
                      <select class="form-control" name="" id="">
                        <option value="">Select an option</option>
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
                      <select class="form-control" name="" id="">
                        <option value="">Select an option</option>
                      </select>                    
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label >Account Usage</label>
                      <select class="form-control" name="" id="">
                        <option value="">Select an option</option>
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
                        <span class="btn btn-primary pull-right" id="clickit" onclick="AddDlg()">Edit</span>
                        <span class="btn btn-danger pull-right" id="clickit" onclick="AddDlg()">Delete</span>
                        <button class="btn pull-right" onclick="AddDlg()">Close</button>
                      </div>
                      </form>
                        <!-- </form> -->
                        <script>
                              $(document).ready(function() {
                                $('#clickit').on("change keyup paste click", function(){
                                  var id = $(this).val();
                                  var client_id = $('#client_name').val();
                                  var colval = $('#colname').val();
                                  var colname = $('#col_val').val();
                                  var coldes = $('#col_descr').val();
                                  $.ajax({
                                    url:"collateral_upload.php",
                                    method:"POST",
                                    data:{id:id, client_id:client_id, colval:colval, colname:colname, coldes:coldes},
                                    success:function(data){
                                      $('#coll').html(data);
                                    }
                                  })
                                });
                              });
                            </script>
<script>
    function AddDlg(){
        var bg = document.getElementById("background");
        var dlg = document.getElementById("diallbox");
        bg.style.display = "none";
        dlg.style.display = "none";
    }
    
    function showDialog(){
        var bg = document.getElementById("background");
        var dlg = document.getElementById("diallbox");
        bg.style.display = "block";
        dlg.style.display = "block";
        
        var winWidth = window.innerWidth;
        var winHeight = window.innerHeight;
        
        dlg.style.left = (winWidth/2) - 480/2 + "px";
        dlg.style.top = "120px";
    }
</script>
<style>
    #background{
        display: none;
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0px;
        left: 0px;
        background-color: black;
        opacity: 0.7;
        z-index: 9999;
    }
    
    #diallbox{
        /*initially dialog box is hidden*/
        display: none;
        position: fixed;
        width: 480px;
        z-index: 9999;
        border-radius: 10px;
        padding:20px;
        background-color: #ffffff;
    }
</style>
                      </div>
                    </div>
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