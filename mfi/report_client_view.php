<?php

$page_title = "Client Report";
$destination = "report_client.php";
    include("header.php");
?>
<?php
 if (isset($_GET["view1"])) {
?>
<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Clients Balance Report</h4>
                  <script>
                  $(document).ready(function() {
                  $('#tabledaot').DataTable();
                  });
                  </script>
                  <!-- Insert number users institutions -->
                  <p class="card-category"><?php
                   $query = "SELECT * FROM client WHERE int_id = '$sessint_id' && status = 'Approved'";
                   $result = mysqli_query($connection, $query);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     echo $inr;
                   }?> clients</p>
                </div>
                <div class="card-body">
                <div class="form-group">
                <form method = "POST" action = "../composer/client_balance.php">
              <input hidden name ="id" type="text" value="<?php echo $id;?>"/>
              <input hidden name ="start" type="text" value="<?php echo $start;?>"/>
              <input hidden name ="end" type="text" value="<?php echo $end;?>"/>
              <button type="submit" id="clientbalance" class="btn btn-primary pull-left">Download PDF</button>
              <script>
        $(document).ready(function () {
        $('#clientbalance').on("click", function () {
          swal({
              type: "success",
              title: "CLIENT BALANCE REPORT",
              text: "From " + start1 + " to " + end1 + "Loading...",
              showConfirmButton: false,
              timer: 5000
                    
            })
         });
       });
     </script>
            </form>
            </div>
                  <div class="table-responsive">
                    <table id="tabledat" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT client.id, client.account_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <th>
                          First Name
                        </th>
                        <th>
                          Last Name
                        </th>
                        <th>
                          Account officer
                        </th>
                        <th>
                          Account Type
                        </th>
                        <th>
                          Account Number
                        </th>
                        <th>
                          Account Balances
                        </th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; 
                        $idd = $row["id"];?>
                          <th><?php echo $row["firstname"]; ?></th>
                          <th><?php echo $row["lastname"]; ?></th>
                          <th><?php echo strtoupper($row["first_name"]." ".$row["last_name"]); ?></th>
                          <?php
                            $class = "";
                            $row["account_type"];
                            $cid= $row["id"];
                            $atype = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$cid'");
                            if (count([$atype]) == 1) {
                                $yxx = mysqli_fetch_array($atype);
                                $actype = $yxx['product_id'];
                              $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$actype'");
                           if (count([$spn])) {
                             $d = mysqli_fetch_array($spn);
                             $savingp = $d["name"];
                           }
                            }
                           
                            ?>
                          <th><?php echo $savingp; ?></th>
                          <?php
                          $soc = $row["account_no"];
                          $length = strlen($soc);
                          if ($length == 1) {
                            $acc ="000000000" . $soc;
                          }
                          elseif ($length == 2) {
                            $acc ="00000000" . $soc;
                          }
                          elseif ($length == 3) {
                            $acc ="00000000" . $soc;
                          }
                          elseif ($length == 4) {
                            $acc ="0000000" . $soc;
                          }
                          elseif ($length == 5) {
                            $acc ="000000" . $soc;
                          }
                          elseif ($length == 6) {
                            $acc ="0000" . $soc;
                          }
                          elseif ($length == 7) {
                            $acc ="000" . $soc;
                          }
                          elseif ($length == 8) {
                            $acc ="00" . $soc;
                          }
                          elseif ($length == 9) {
                            $acc ="0" . $soc;
                          }
                          elseif ($length == 10) {
                            $acc = $row["account_no"];
                          }else{
                            $acc = $row["account_no"];
                          }
                          ?>
                          <th><?php echo $acc; ?></th>
                          <?php
                          $don = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$idd'");
                          $ew = mysqli_fetch_array($don);
                          $accountb = $ew['account_balance_derived'];
                          ?>
                          <th><?php echo $accountb; ?></th>
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
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
 }
 else if(isset($_GET["view3"])){
?>
<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Clients</h4>
                  <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script>
                  <!-- Insert number users institutions -->
                  <p class="card-category"><?php
                   $query = "SELECT * FROM client WHERE int_id = '$sessint_id' && status = 'Approved'";
                   $result = mysqli_query($connection, $query);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     echo $inr;
                   }?> registered clients || <a style = "color: white;" href="manage_client.php">Create New client</a></p>
                </div>
                <div class="card-body">
                <div class="form-group">
                <form method = "POST" action = "../composer/client_list.php">
              <input hidden name ="id" type="text" value="<?php echo $id;?>"/>
              <input hidden name ="start" type="text" value="<?php echo $start;?>"/>
              <input hidden name ="end" type="text" value="<?php echo $end;?>"/>
              <button type="submit" id="clientlist" class="btn btn-primary pull-left">Download PDF</button>
              <script>
              $(document).ready(function () {
              $('#clientlist').on("click", function () {
                swal({
                    type: "success",
                    title: "CLIENT REPORT",
                    text: "Printing Successful",
                    showConfirmButton: false,
                    timer: 5000
                          
                  })
              });
            });
     </script>
            </form>
            </div>
                  <div class="table-responsive">
                    <table id="tableddat" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT client.id, client.BVN, client.date_of_birth, client.gender, client.account_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved' ORDER BY client.firstname ASC";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <th>
                          First Name
                        </th>
                        <th>
                          Last Name
                        </th>
                        <th>
                          Account officer
                        </th>
                        <th>
                          Account Type
                        </th>
                        <th>
                          Account Number
                        </th>
                        <th>
                         Date of Birth
                        </th>
                        <th>
                          Gender
                        </th>
                        <th>
                          Phone
                        </th>
                        <th>
                          BVN
                        </th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo $row["firstname"]; ?></th>
                          <th><?php echo $row["lastname"]; ?></th>
                          <th><?php echo strtoupper($row["first_name"]." ".$row["last_name"]); ?></th>
                          <?php
                            $class = "";
                            $row["account_type"];
                            $cid= $row["id"];
                            $atype = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$cid'");
                            if (count([$atype]) == 1) {
                                $yxx = mysqli_fetch_array($atype);
                                $actype = $yxx['product_id'];
                              $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$actype'");
                           if (count([$spn])) {
                             $d = mysqli_fetch_array($spn);
                             $savingp = $d["name"];
                           }
                            }
                           
                            ?>
                          <th><?php echo $savingp; ?></th>
                          <?php
                          $soc = $row["account_no"];
                          $length = strlen($soc);
                          if ($length == 1) {
                            $acc ="000000000" . $soc;
                          }
                          elseif ($length == 2) {
                            $acc ="00000000" . $soc;
                          }
                          elseif ($length == 3) {
                            $acc ="00000000" . $soc;
                          }
                          elseif ($length == 4) {
                            $acc ="0000000" . $soc;
                          }
                          elseif ($length == 5) {
                            $acc ="000000" . $soc;
                          }
                          elseif ($length == 6) {
                            $acc ="0000" . $soc;
                          }
                          elseif ($length == 7) {
                            $acc ="000" . $soc;
                          }
                          elseif ($length == 8) {
                            $acc ="00" . $soc;
                          }
                          elseif ($length == 9) {
                            $acc ="0" . $soc;
                          }
                          elseif ($length == 10) {
                            $acc = $row["account_no"];
                          }else{
                            $acc = $row["account_no"];
                          }
                          ?>
                          <th><?php echo $acc; ?></th>
                          <th><?php echo $row["date_of_birth"]; ?></th>
                          <th><?php echo $row["gender"]; ?></th>
                          <th><?php echo $row["mobile_no"]; ?></th>
                          <th><?php echo $row["BVN"]; ?></th>
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
              </div>
            </div>
          </div>
        </div>
      </div>

<?php
 }
 else if(isset($_GET["view4"])){
?>
    <?php
function fill_client($connection) {
  $sint_id = $_SESSION["int_id"];
  $org = "SELECT * FROM client WHERE int_id = '$sint_id'";
  $res = mysqli_query($connection, $org);
  $out = '';
  while ($row = mysqli_fetch_array($res))
  {
    $out .= '<option value="'.$row["id"].'">'.$row["firstname"].' '.$row["lastname"].'</option>';
  }
  return $out;
}
?>
Content added here
    <div class="content">
        <div class="container-fluid">
         your content here
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Client Summary Report</h4>
                 <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                  <form>
                    <div class="row">
                      <div class="col-md-8">
                        <div class="form-group">
                            <input type="text" hidden required id="intt" value = "<?php echo $sessint_id;?>"/>
                        <label class="bmd-label-floating">Pick Client</label>
                          <select name="branch" class="form-control" id="input" required>
                          <option value="">select an option</option>
                          <?php echo fill_client($connection); ?>
                          </select>
                          
                        </div>
                      </div>
                      
                      <div class="clearfix"></div>
                    </div>
                  </form>
                      </div>
                  <script>
                    $(document).ready(function () {
                      $('#input').on("change", function () {
                        var cid = $(this).val();
                        var intid = $('#intt').val();
                        $.ajax({
                          url: "ajax_post/reports_post/client_summary.php", 
                          method: "POST",
                          data:{cid:cid, intid:intid},
                          success: function (data) {
                            $('#outjournal').html(data);
                          }
                        })
                      });
                    });
                  </script>
                  
                </div>
              </div>
            </div>
            <div id="outjournal"></div>
          </div>
        </div>
      </div>
<?php
}
 else if (isset($_GET["view5"])) {
?>
<!-- Data for clients registered this month -->
<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-10">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Registered Clients</h4>
                  <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script>
                  <!-- Insert number users institutions -->
                  <p class="card-category"><?php
                  $std = date("Y-m-d");
                  $thisyear = date("Y");
                  $thismonth = date("m");
                  // $end = date('Y-m-d', strtotime('-30 days'));
                  $curren = $thisyear."-".$thismonth."-01";
                        $query = "SELECT client.id, client.account_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved' && submittedon_date BETWEEN '$curren' AND '$std'";
                        $result = mysqli_query($connection, $query);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     $date = date("F");
                   }?><div id="month_no"><?php echo $inr;?> Registered Clients this month</div></p>
                </div>
                <div class="card-body">
                <div class="row">
                  <div class="col-md-3">
                  <div class="form-group">
                <form method = "POST" action = "../composer/registered_client.php">
                    <label for="">Pick Month</label>
                    <select id="month" class="form-control" style="text-transform: uppercase;" name="month">
                    <option value="0"></option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                    </select>
                  
              <input hidden name ="id" type="text" value="<?php echo $id;?>"/>
              <input hidden name ="start" type="text" value="<?php echo $start;?>"/>
              <input hidden name ="end" type="text" value="<?php echo $end;?>"/>
              <button type="submit" id="registeredclient" class="btn btn-primary pull-left">Download PDF</button>
              <script>
              $(document).ready(function () {
              $('#registeredclient').on("click", function () {
                swal({
                    type: "success",
                    title: "REGISTERED CLIENT REPORT",
                    text: "Printing Successful",
                    showConfirmButton: false,
                    timer: 5000
                          
                  })
              });
            });
     </script>
            </form>
            </div>
            </div>
            <script>
                    $(document).ready(function () {
                      $('#month').on("change", function () {
                        var month = $(this).val();
                        $.ajax({
                          url: "ajax_post/reports_post/pick_month_copy.php", 
                          method: "POST",
                          data:{month:month},
                          success: function (data) {
                            $('#month_no').html(data);
                          }
                        })
                      });
                    });
                  </script>
                  <script>
                    $(document).ready(function () {
                      $('#month').on("change", function () {
                        var month = $(this).val();
                        $.ajax({
                          url: "ajax_post/reports_post/pick_month.php", 
                          method: "POST",
                          data:{month:month},
                          success: function (data) {
                            $('#dismonth').html(data);
                          }
                        })
                      });
                    });
                  </script>
                  </div>
                  <div class="table-responsive">
                    <div ></div>
                    <table id="dismonth" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT client.id, client.account_type, client.account_no, client.mobile_no, client.firstname, client.lastname,  staff.first_name, staff.last_name FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved' && submittedon_date BETWEEN '$curren' AND '$std'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <th>
                          First Name
                        </th>
                        <th>
                          Last Name
                        </th>
                        <th>
                          Account officer
                        </th>
                        <th>
                          Account Type
                        </th>
                        <th>
                          Account Number
                        </th>
                        <th>
                          Phone
                        </th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo $row["firstname"]; ?></th>
                          <th><?php echo $row["lastname"]; ?></th>
                          <th><?php echo strtoupper($row["first_name"]." ".$row["last_name"]); ?></th>
                          <?php
                            $class = "";
                            $row["account_type"];
                            $cid= $row["id"];
                            $atype = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$cid'");
                            if (count([$atype]) == 1) {
                                $yxx = mysqli_fetch_array($atype);
                                $actype = $yxx['product_id'];
                              $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$actype'");
                           if (count([$spn])) {
                             $d = mysqli_fetch_array($spn);
                             $savingp = $d["name"];
                           }
                            }
                           
                            ?>
                          <th><?php echo $savingp; ?></th>
                          <th><?php echo $row["account_no"]; ?></th>
                          <th><?php echo $row["mobile_no"]; ?></th>
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
              </div>
            </div>
          </div>
        </div>
      </div>
<?php
 }
 ?>
