<?php

$page_title = "Financial Report";
$destination = "report_financial.php";
    include("header.php");
    session_start();
    $branch = $_SESSION['branch_id'];
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
 if (isset($_GET["view24"])) {
?>

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