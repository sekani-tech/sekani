<?php

$page_title = "Bills Payment";
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
    else if (isset($_GET["message7"])) {
      $key = $_GET["message7"];
      // $out = $_SESSION["lack_of_intfund_$key"];
      $tt = 0;
      if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
      echo '<script type="text/javascript">
      $(document).ready(function(){
          swal({
              type: "success",
              title: "Success",
              text: "Product Updated!",
              showConfirmButton: false,
              timer: 2000
          })
      });
      </script>
      ';
      $_SESSION["lack_of_intfund_$key"] = 0;
      }
      }
      else if (isset($_GET["message8"])) {
        $key = $_GET["message8"];
        // $out = $_SESSION["lack_of_intfund_$key"];
        $tt = 0;
        if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "error",
                title: "Error",
                text: "Error Updating product!",
                showConfirmButton: false,
                timer: 2000
            })
        });
        </script>
        ';
        $_SESSION["lack_of_intfund_$key"] = 0;
        }
        }
        else if (isset($_GET["message9"])) {
          $key = $_GET["message9"];
          // $out = $_SESSION["lack_of_intfund_$key"];
          $tt = 0;
          if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
          echo '<script type="text/javascript">
          $(document).ready(function(){
              swal({
                  type: "success",
                  title: "Success",
                  text: "Payment Type Updated!",
                  showConfirmButton: false,
                  timer: 2000
              })
          });
          </script>
          ';
          $_SESSION["lack_of_intfund_$key"] = 0;
          }
          }
          else if (isset($_GET["message10"])) {
            $key = $_GET["message9"];
            // $out = $_SESSION["lack_of_intfund_$key"];
            $tt = 0;
            if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
            echo '<script type="text/javascript">
            $(document).ready(function(){
                swal({
                    type: "error",
                    title: "Error",
                    text: "Error Updating Payment Type!",
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
    $sesint_id = $_SESSION['int_id'];
    // check the button value
    $rog = $_POST['submit'];
    $add_pay = $_POST['submit'];
    if ($add_pay == 'add_payment'){
     $class = $_POST['acct_type']; 
      $value = $_POST['nameo'];
      $bran = $_SESSION["branch_id"];
      $desc = $_POST['des'];
      $default = $_POST['default'];
      $gl_code = $_POST['gl_code'];

    }
    if(isset($_POST['is_bank'])){
      $is_bank = 1;
    }else{
      $is_bank = 0;
    }
      if(isset($_POST['is_cash'])){
        $is_cash = 1;
      }else{
        $is_cash = 0;
      }
     
        $wen = "INSERT INTO payment_type (int_id, branch_id, value, description, gl_code, is_cash_payment, is_bank, order_position)
        VALUES('{$sesint_id}', '{$bran}', '{$value}', '{$desc}', '{$gl_code}', '{$is_cash}', '{$is_bank}', '{$default}')";
        $quoery = mysqli_query($connection, $wen);

        if($quoery){
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
      else{
        echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "error",
                title: "Failed",
                text: " Payment type failed",
                showConfirmButton: false,
                timer: 2000
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
                            Electricity Bills
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#saving" data-toggle="tab">
                            Cable Tv
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
                        <center>
                      <button data-toggle="modal" data-target="#exampleModal" class="btn btn-primary"> Pay Electricity Bills</button>
                      </center>
                      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Electricity Bills</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <!-- action="../functions/pay.php" -->
      <form method="POST"  enctype="multipart/form-data">
          <div class="row">
          <div class="col-md-12">
              <div class="form-group">
               <label class="bmd-label-floating">Select a Disco</label>
               <select name="" id="disco" class="form-control" style="text-transform:uppercase">
                 <option value="AEDC">AEDC: Abuja</option>
                 <option value="KAEDC">KAEDC: Kaduna</option>
                 <option value="JEDC">JEDC: Jos</option>
                 <option value="IKEDC">IKEDC: Ikeja</option>
                 <option value="EKEDC">EKEDC: Eko</option>
                 <option value="KEDC">KEDC: Kano</option>
                 <option value="EEDC">EEDC: Enugu</option>
                 <option value="PHEDC">PHEDC: Phortharcout</option>
                 <option value="IBEDC">IBEDC: Ibadan</option>
             </select>
             <input type="text" id="int_id" hidden  value="<?php echo $sessint_id; ?>" style="text-transform: uppercase;" class="form-control">
              </div>
            </div>
            <div class="col-md-12">
            <div class="form-group">
               <label class="bmd-label-floating">Type</label>
               <select name="" id="dis_type" class="form-control" style="text-transform:uppercase">
               <option value="PREPAID">PREPAID</option>
               <option value="POSTPAID">POSTPAID</option>
               </select>
              </div>
            </div>
            <div class="col-md-12">
            <div class="form-group">
               <label class="bmd-label-floating">Meter No</label>
               <input type = "text" id="meter_no" class="form-control" name = ""/>
              </div>
            </div>
            <div id="m_check"></div>
            <div id="make_display"></div>
            </div>
                           <script>
                              $(document).ready(function() {
                                $('#meter_no').on("change keyup paste click", function() {
                                  var disco = $('#disco').val();
                                  var dis_type = $('#dis_type').val();
                                  var meter = $('#meter_no').val();
                                  $.ajax({
                                    url:"ajax_post/bill/disco_check.php",
                                    method:"POST",
                                    data:{disco:disco, meter:meter, dis_type:dis_type},
                                    success:function(data){
                                      $('#m_check').html(data);
                                    }
                                  });
                                });
                                $('#disco').on("change keyup paste click", function() {
                                  var disco = $('#disco').val();
                                  var dis_type = $('#dis_type').val();
                                  var meter = $('#meter_no').val();
                                  $.ajax({
                                    url:"ajax_post/bill/disco_check.php",
                                    method:"POST",
                                    data:{disco:disco, meter:meter, dis_type:dis_type},
                                    success:function(data){
                                      $('#m_check').html(data);
                                    }
                                  });
                                });
                                $('#dis_type').on("change keyup paste click", function() {
                                  var disco = $('#disco').val();
                                  var dis_type = $('#dis_type').val();
                                  var meter = $('#meter_no').val();
                                  $.ajax({
                                    url:"ajax_post/bill/disco_check.php",
                                    method:"POST",
                                    data:{disco:disco, meter:meter, dis_type:dis_type},
                                    success:function(data){
                                      $('#m_check').html(data);
                                    }
                                  });
                                });
                              });
                            </script>
                            <script>
                              $(document).ready(function() {
                                $('#submitme').on("change keyup paste click", function() {
                                  var disco = $('#disco').val();
                                  var dis_type = $('#dis_type').val();
                                  var meter = $('#meter_no').val();
                                  var amt = $('#amount').val();
                                  var name = $('#name').val();
                                  var phone = $('#phonenumber').val();
                                  var address = $('#customerAddress').val();
                                  $.ajax({
                                    url:"ajax_post/bill/disco.php",
                                    method:"POST",
                                    data:{disco:disco, dis_type:dis_type, meter:meter, amt:amt, name:name, phone:phone, address:address},
                                    success:function(data){
                                      $('#coll').html(data);
                                    }
                                  });
                                });
                              });
                            </script>
            <!-- <div class="col-md-12">
            <div class="form-group">
               <label class="bmd-label-floating"></label>
               <input type = "text" hidden class="form-control"/>
              </div>
            </div> -->
           <!-- Next -->
           <div id="coll"></div>
                    </div>
                    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="submitme" name="submit" value="add_payment" type="button" class="btn btn-primary">Buy</button>
      </div>
                </form>
                </div>
                </div>
            </div>
                      <hr>
                      <div class="table-responsive">
                  <script>
                  $(document).ready(function() {
                  $('#tabledatc4').DataTable();
                  });
                  </script>
                    <table id="tabledatc4" class="table" style="width: 100%;">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM `sekani_wallet_transaction` WHERE int_id ='$sessint_id' AND branch_id = '$bch_id' AND transaction_type = 'bill_disco' ORDER BY id DESC";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <!-- <th>
                          ID
                        </th> -->
                        <th>Type</th>
                        <th></th>
                        <th>
                          Amount
                        </th>
                        <th>
                          Balance
                        </th>
                        <th>
                          Date
                        </th>
                        <th>
                        Print
                        </th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                        <th><?php echo $row["description"]; ?></th>
                        <?php
                        $harsh = $hash = password_hash($row["id"], PASSWORD_DEFAULT);
                        ?>
                        <th></th>
                          <th><?php echo number_format($row["amount"], 2); ?></th>
                          <th><?php echo number_format($row["wallet_balance_derived"], 2); ?></th>
                          <td><?php echo $row["created_date"];?></td>
                          <td><a href="../composer/bill.php?id=<?php echo $harsh;?>&x=<?php echo $row["id"]; ?>" class="btn btn-info">print</a></td>
                        </tr>
                        <?php }
                          }
                          else {
                            echo "NO TRANSACTION";
                          }
                          ?>
                      </tbody>
                    </table>
                  </div>
                    </div>
                    <div class="tab-pane" id="saving">
                    <center>
                      <button data-toggle="modal" data-target="#exampleModal1" class="btn btn-primary"> Cable Tv</button>
                      </center>
                      <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cable Tv - NOTE: WITHOUT AD ONS FOR NOW</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <!-- action="../functions/pay.php" -->
      <form method="POST"  enctype="multipart/form-data">
          <div class="row">
          <div class="col-md-12">
            <div class="form-group">
               <label class="bmd-label-floating">Smart Card No</label>
               <input type = "text" id="smartcard" class="form-control" name = ""/>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
               <label class="bmd-label-floating">Select a Network</label>
               <select name="" id="cabletv" class="form-control">
                 <option value="">select a cable Tv</option>
                 <option value="DSTV">DSTV</option>
                 <option value="GOTV">GOTV</option>
                 <option value="STARTIMES">STARTIMES</option>
             </select>
              </div>
            </div>
            <div class="col-md-12">
            <div class="form-group">
            <div id="qwerty"></div>
              </div>
            </div>
            <div class="col-md-12">
            <p id="msg"></p>
            </div>
            </div>
                         <script>
                              $(document).ready(function() {
                                $('#cabletv').on("change", function() {
                                  var cable = $('#cabletv').val();
                                  if (cable != "") {
                                    var smart = $('#smartcard').val();
                                    $.ajax({
                                      url:"ajax_post/bill/cable_check.php",
                                      method:"POST",
                                      data:{cable:cable, smart:smart},
                                      success:function(data){
                                      $('#qwerty').html(data);
                                    }
                                  });
                                  }
                                });
                              });
                            </script>
            <!-- <div class="col-md-12">
            <div class="form-group">
               <label class="bmd-label-floating"></label>
               <input type = "text" hidden class="form-control"/>
              </div>
            </div> -->
            
           <!-- Next -->
           <script>
        $(document).ready(function() {
            $('#cable_pay').on("click", function() {
                                  var cable = $('#cabletv').val();
                                  var smart = $('#smartcard').val();
                                  $.ajax({
                                    url:"ajax_post/bill/cable_go.php",
                                    method:"POST",
                                    data:{ cable:cable, smart:smart},
                                    success:function(data){
                                      $('#finish_buying').html(data);
                                    }
                                  });
                                });
                              });
                            </script>
                            <div id="finish_buying"></div>
                    </div>
                    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="cable_pay" name="submit" disabled value="add_payment" type="button" class="btn btn-primary">Buy</button>
      </div>
                </form>
                </div>
                </div>
            </div>
                      <hr>
                    <div class="table-responsive">
                  <script>
                  $(document).ready(function() {
                  $('#tabledatcc4').DataTable();
                  });
                  </script>
                    <table id="tabledatcc4" class="table" style="width: 100%;">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM `sekani_wallet_transaction` WHERE int_id ='$sessint_id' AND branch_id = '$bch_id' AND transaction_type = 'bill_cable' ORDER BY id DESC";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <!-- <th>
                          ID
                        </th> -->
                        <th>Type</th>
                        <th></th>
                        <th>
                          Amount
                        </th>
                        <th>
                          Balance
                        </th>
                        <th>
                          Date
                        </th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                        <th><?php echo $row["description"]; ?></th>
                        <th></th>
                          <th><?php echo number_format($row["amount"], 2); ?></th>
                          <th><?php echo number_format($row["wallet_balance_derived"], 2); ?></th>
                          <td><?php echo $row["created_date"];?></td>
                        </tr>
                        <?php }
                          }
                          else {
                            echo "NO TRANSACTION";
                          }
                          ?>
                      </tbody>
                    </table>
                  </div>
                    </div>
                    <!-- credit checks -->
                    <!-- end of credit checkss -->
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