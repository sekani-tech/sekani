<?php

$page_title = "Charges";
$destination = "index.php";
    include("header.php");

?>
<?php
//  Sweet alert Function

// If it is successfull, It will show this message
  if (isset($_GET["message1"])) {
    $key = $_GET["message1"];
    // $out = $_SESSION["lack_of_intfund_$key"];
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
    $_SESSION["lack_of_intfund_$key"] = null;
}
// If it is not successfull, It will show this message
else if (isset($_GET["message2"])) {
  $key = $_GET["message2"];
  // $out = $_SESSION["lack_of_intfund_$key"];
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
  $_SESSION["lack_of_intfund_$key"] = null;
}
if (isset($_GET["message3"])) {
  $key = $_GET["message3"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Success",
          text: "Client was Updated successfully!",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = null;
}
else if (isset($_GET["message4"])) {
$key = $_GET["message4"];
// $out = $_SESSION["lack_of_intfund_$key"];
echo '<script type="text/javascript">
$(document).ready(function(){
    swal({
        type: "error",
        title: "Error",
        text: "Error updating client!",
        showConfirmButton: false,
        timer: 2000
    })
});
</script>
';
$_SESSION["lack_of_intfund_$key"] = null;
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
                  <h4 class="card-title ">Charges</h4>
                  <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script>
                  <!-- Insert number users institutions -->
                  <p class="card-category"> Current Charges || <a style = "color: white;" href="create_charge.php">Create New Charge</a></p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="tabledat" class="table" cellspacing="1" style="width:100%">
                      <thead class=" text-primary">
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
                        <!-- <th>Phone</th> -->
                      </thead>
                      <tbody>
                        <tr>
                          <td>Account Re-creation</td>
                          <td>Savings</td>
                          <td>1</td>
                          <td>Specified Due</td>
                          <td>500 Flat</td>
                          <td><a onclick="showDialog()" class="btn btn-info" ><i style="color:#ffffff;" class="material-icons">create</i></a></td>
                        </tr>
                        <tr>
                          <td>Cash Handing Charge</td>
                          <td>Savings</td>
                          <td>1</td>
                          <td>Disbursement Date</td>
                          <td>500 Flat</td>
                          <td><a onclick="showDialog()" class="btn btn-info" ><i style="color:#ffffff;" class="material-icons">create</i></a></td>

                        </tr>
                        <tr>
                          <td>Commision on Stamp</td>
                          <td>Savings</td>
                          <td>1</td>
                          <td>Specified Due</td>
                          <td>500 Flat</td>
                          <td><a onclick="showDialog()" class="btn btn-info" ><i style="color:#ffffff;" class="material-icons">create</i></a></td>

                        </tr>
                        <tr>
                          <td>Commision on Daily Savings</td>
                          <td>Savings</td>
                          <td>1</td>
                          <td>Disbursement Date</td>
                          <td>500 Flat</td>
                          <td><a onclick="showDialog()" class="btn btn-info" ><i style="color:#ffffff;" class="material-icons">create</i></a></td>
                        </tr>
                        <tr>
                          <td>Account Re-creation</td>
                          <td>Savings</td>
                          <td>1</td>
                          <td>Disbursement Date</td>
                          <td>500 Flat</td>
                          <td><a onclick="showDialog()" class="btn btn-info" ><i style="color:#ffffff;" class="material-icons">create</i></a></td>
                        </tr>
                      </tbody>
                      <!-- <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo $row["firstname"]; ?></th>
                          <th><?php echo $row["lastname"]; ?></th>
                          <th><?php echo $row["loan_officer_id"]; ?></th>
                          <th><?php echo $row["account_type"]; ?></th>
                          <td><a href="client_view.php?edit=<?php echo $row["id"];?>" class="btn btn-info">View</a></td>
                          <td><a href="update_client.php?edit=<?php echo $row["id"];?>" class="btn btn-info">Edit</a></td>
                        </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                           <th></th>
                      </tbody>  -->
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
        dlg.style.top = "150px";
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
            <!-- /col-md-12 -->
          </div>
        </div>
      </div>

<?php

    include("footer.php");

?>