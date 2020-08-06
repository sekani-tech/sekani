<?php

$page_title = "Financial Report";
$destination = "report_financial.php";
    include("header.php");
    // session_start();
    $branch = $_SESSION['branch_id'];
    $sessint_id = $_SESSION['int_id'];
?>
<?php
  function branch_opt($connection)
  {  
      $br_id = $_SESSION["branch_id"];
      $sint_id = $_SESSION["int_id"];
      $dff = "SELECT * FROM branch WHERE int_id ='$sint_id' AND id = '$br_id' || parent_id = '$br_id'";
      $dof = mysqli_query($connection, $dff);
      $out = '';
      while ($row = mysqli_fetch_array($dof))
      {
        $do = $row['id'];
      $out .= " OR client.branch_id ='$do'";
      }
      return $out;
  }
  $br_id = $_SESSION["branch_id"];
  $branches = branch_opt($connection);
?>
<?php
 if (isset($_GET["view26"])) {
?>
<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Provisioning</h4>
                  <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script>
                  <!-- Insert number users institutions -->
                  <p class="card-category"><?php
                          $query = "SELECT * FROM loan_arrear WHERE int_id = '$sessint_id' AND installment = '1'";
                          $result = mysqli_query($connection, $query);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     echo $inr;
                   }?> current Accounts</p>
                </div>
                <div class="card-body">
                <div class="form-group">
                <form method = "POST" action = "../composer/current_account.php">
              <input hidden name ="id" type="text" value="<?php echo $id;?>"/>
              <input hidden name ="start" type="text" value="<?php echo $start;?>"/>
              <input hidden name ="end" type="text" value="<?php echo $end;?>"/>
              <input hidden name ="acc_bal" type="text" value="<?php echo $ttlacc;?>"/>
              <div class="col-md-6">
                      </div>
              <button type="submit" id="currentlist" class="btn btn-primary pull-left">Download PDF</button>
              <script>
              $(document).ready(function () {
              $('#currentlist').on("click", function () {
                swal({
                    type: "success",
                    title: "CURRENT ACCOUNT REPORT",
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
                    <table id="tabledt" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                          $query = "SELECT * FROM loan_arrear WHERE int_id = '$sessint_id' AND installment = '1'";
                          $result = mysqli_query($connection, $query);
                      ?>
                        <th>
                          Customer Name
                        </th>
                        <th>
                          Past Due Date
                        </th>
                        <th>
                          Principal Due
                        </th>
                        <th>
                          Interest Due
                        </th>
                        <th>
                          Total NPD
                        </th>
                        <th>
                          1 - 30 days
                        </th>
                        <th>
                        31 - 60 days
                        </th>
                        <th>
                        61 - 90 days
                        </th>
                        <th>
                        91 and Above
                        </th>
                        <th>
                        Bank Provision
                        </th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                          <?php
                            $cid = $row['client_id'];
                            $sdip = "SELECT * FROM client WHERE id = '$cid'";
                            $sdo = mysqli_query($connection, $sdip);
                            $fe = mysqli_fetch_array($sdo);
                            $client_name = $fe['firstname']." ".$fe["lastname"];
                          ?>
                          <th><?php echo $client_name;?></th>
                          <th><?php echo $row['fromdate'];?></th>
                          <th><?php echo number_format($row['principal_amount'], 2);?></th>
                          <th><?php echo number_format($row['interest_amount'], 2);?></th>
                          <th><?php echo number_format(($row['interest_amount'] + $row['principal_amount']), 2);?></th>
                          <?php
                            $days_no = $row['counter'];
                            $thirty = '0.00';
                            $sixty = '0.00';
                            $ninety = '0.00';
                            $above = '0.00';
                            if(30 > $days_no){
                              $thirty = number_format($row['principal_amount'], 2);
                              $ffd = $row['principal_amount'];
                              $bnk_prov = (0.05 * $ffd);
                            }
                            else if(60 > $days_no && $days_no > 30){
                              $sixty = number_format($row['principal_amount'], 2);
                              $fdfdf = $row['principal_amount'];
                              $bnk_prov = (0.2 * $fdfdf);
                            }
                            else if(90 > $days_no && $days_no > 60){
                              $ninety = number_format($row['principal_amount'], 2);
                              $dfgd = $row['principal_amount'];
                              $bnk_prov = (0.5 * $dfgd);
                            }
                            else if($days_no > 90){
                              $above = number_format($row['principal_amount'], 2);
                              $juiui = $row['principal_amount'];
                              $bnk_prov = $juiui;
                            }
                          ?>
                          <th><?php echo $thirty;?></th>
                          <th><?php echo $sixty;?></th>
                          <th><?php echo $ninety;?></th>
                          <th><?php echo $above;?></th>
                          <th><?php echo number_format($bnk_prov, 2);?></th>
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
 else if(isset($_GET["view25"])){
 ?>
 <div class="content">
        <div class="container-fluid">
                    <!-- your content here -->
                    <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                <h4 class="card-title">General Ledger Report</h4>
            </div>
            <?php
                  function fill_gl($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  // $org = "SELECT * FROM acc_gl_account WHERE int_id = '$sint_id' AND (parent_id != '0' || parent_id != '' || parent_id != 'NULL') ORDER BY name ASC";
                  $org = "SELECT * FROM acc_gl_account WHERE parent_id !='0' AND int_id = '$sint_id' ORDER BY name ASC";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["gl_code"].'">'.$row["gl_code"].' - '.$row["name"].'</option>';
                  }
                  return $out;
                  }
                  function fill_branch($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $dks = $_SESSION["branch_id"];
                  $org = "SELECT * FROM branch WHERE int_id = '$sint_id' AND id = '$dks' OR parent_id = '$dks'";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                  }
                  return $out;
                  }
                  ?>
                  
                <div class="card-body">
                  <form action="">
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label for="">Start Date</label>
                        <input type="date" name="" id="start" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">End Date</label>
                        <input type="date" name="" id="end" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Branch</label>
                        <select name="" id="branch" class="form-control">
                            <?php echo fill_branch($connection);?>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">GL account</label>
                        <select name="gl_code" id="glcode" class="form-control">
                        <?php echo fill_gl($connection);?>
                        </select>
                      </div>
                    </div>
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <span id="runstructure" type="submit" class="btn btn-primary">Run report</span>
                  </form>
                </div>
              </div>
              <script>
                    $(document).ready(function () {
                      $('#runstructure').on("click", function () {
                        var start = $('#start').val();
                        var end = $('#end').val();
                        var branch = $('#branch').val();
                        var glcode = $('#glcode').val();
                        $.ajax({
                          url: "items/gl_report.php",
                          method: "POST",
                          data:{start:start, end:end, branch:branch, glcode:glcode},
                          success: function (data) {
                            $('#shstructure').html(data);
                          }
                        })
                      });
                    });
                  </script>
              <div id="shstructure" class="card">

              </div>
            </div>
          </div>

        </div>
 </div>
 <?php
 }
 else if (isset($_GET["view43"])) {
  ?>
  <div class="content">
          <div class="container-fluid">
            <!-- your content here -->
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header card-header-primary">
                    <h4 class="card-title ">Daily Transactions</h4>
                    <script>
                    $(document).ready(function() {
                    $('#tabledat').DataTable();
                    });
                    </script>
                    <!-- Insert number users institutions -->
                    <p class="card-category">
                        <?php
                        $currentdate = date('Y-m-d');
                          $query = "SELECT * FROM institution_account_transaction WHERE branch_id = '$branch' AND int_id = '$sessint_id' AND transaction_date = '$currentdate'";
                          $result = mysqli_query($connection, $query);
                     if ($result) {
                       $inr = mysqli_num_rows($result);
                       echo $inr;
                     }?> transactions made today</p>
                  </div>
                  <div class="card-body">
                  <div class="form-group">
                  <form method = "POST" action = "../composer/today_transaction.php">
                <input hidden name ="id" type="text" value="<?php echo $id;?>"/>
                <input hidden name ="start" type="text" value="<?php echo $start;?>"/>
                <input hidden name ="end" type="text" value="<?php echo $currentdate;?>"/>
                <button type="submit" id="disbursed" class="btn btn-primary pull-left">Download PDF</button>
                <script>
                $(document).ready(function () {
                $('#disbursed').on("click", function () {
                  swal({
                      type: "success",
                      title: "DISBURSED LOAN REPORT",
                      text: "Printing Successful",
                      showConfirmButton: false,
                      timer: 3000
                            
                    })
                });
              });
       </script>
              </form>
                  </div>
                    <div class="table-responsive">
                      <table id="tabledatv" class="table" cellspacing="0" style="width:100%">
                        <thead class=" text-primary">
                        <?php
                          $query = "SELECT * FROM institution_account_transaction WHERE branch_id = '$branch' AND int_id = '$sessint_id' AND transaction_date = '$currentdate'";
                          $result = mysqli_query($connection, $query);
                        ?>
                          <tr class="table100-head">
                            <th>Transaction Type</th>
                            <th>Transaction Date</th>
                            <th>Reference</th>
                            <th>Account Officer</th>
                            <th>Debits(&#8358;)</th>
                            <th>Credits(&#8358;)</th>
                            <th>Account Balance(&#8358;)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (mysqli_num_rows($result) > 0) {
                          while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                          <tr>
                            <th><?php echo $row["transaction_type"];?></th>
                            <th><?php echo $row["transaction_date"];?></th>
                            <th><?php echo $row["description"];?></th>
                          <?php 
                              $name = $row['appuser_id'];
                              $anam = mysqli_query($connection, "SELECT username FROM users WHERE id = '$name'");
                              $f = mysqli_fetch_array($anam);
                              $nae = strtoupper($f["username"]);
                          ?>
                            <th><?php echo $nae; ?></th>
                            <th><?php echo number_format($row["debit"]); ?></th>
                            <th><?php echo number_format($row["credit"]); ?></th>
                            <th><?php echo number_format($row["running_balance_derived"], 2);?></th>
                            <?php
                            
                            ?>
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