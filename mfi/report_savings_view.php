<?php

$page_title = "Client Report";
$destination = "report_savings.php";
    include("header.php");
?>

<style>
  .total-balances .form-control:read-only{
    font-size: 1.8rem;
    background-image:none;
    background: transparent;
    text-align:center;
  }

  .dataTable>thead>tr>th, .dataTable>tbody>tr>th, .dataTable>tfoot>tr>th, .dataTable>thead>tr>td, .dataTable>tbody>tr>td, .dataTable>tfoot>tr>td {
    padding: 0.6rem 0 0.6rem 0.2rem !important;
    font-weight: 400;
}

.dataTable>thead>tr>th {
    font-size: 0.9rem;
}
</style>
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
 if (isset($_GET["view10"])) {

   if ($_SESSION["int_id"] == 0) {

        ?>
              <div class="content">
                <div class="container-fluid">
                  <!-- your content here -->
                  <div class="row">
                    <div class="col-md-12">
                      <div class="card">
                          <div class="card-header card-header-primary">
                            <h4 class="card-title ">Savings Accounts</h4>
                          </div>
                        <div class="card-body">
                          <div class="form-group">
                            <form method = "POST" action = "../composer/savings_account.php">
                              <div class="col-md-6">
                                  <input hidden name ="acc_bal" type="text" value="<?php echo $ttlacc;?>"/>
                                <div class="form-group">
                                  <label class="bmd-label-floating">Total Account Balances</label>
                                  <input type="text" readonly class="form-control" value="<?php echo number_format($ttlacc, 2); ?>" name="">
                                </div>
                              </div>
                            <button type="submit" id="clientlist" class="btn btn-primary pull-left">Download PDF</button>
                            <script>
                            $(document).ready(function () {
                              
                            $('#clientlist').on("click", function () {
                              swal({
                                  type: "success",
                                  title: "SAVINGS ACCOUNT REPORT",
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
                            <table class="rtable display nowrap" style="width:100%">
                              <thead class=" text-primary">
                                <th>
                                  Client Name
                                </th>
                                <th>
                                  Client Type
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
                                <?php
                                  $tableJoinSavings = "
                                  SELECT * FROM saving_balances_migration
                                  INNER JOIN 
                                    clients_branch_migrate 
                                  ON saving_balances_migration.Client_Name=clients_branch_migrate.name
                                ";
                                $savingsResult = mysqli_query($connection, $tableJoinSavings);
                                while ($resultRow = mysqli_fetch_array($savingsResult, MYSQLI_ASSOC))
                                {
                                ?>
                                  <tr>
                                      <td><?php echo $resultRow['Client_Name'];?></td>
                                      <td>INDIVIDUAL</td>
                                      <td>SAVINGS</td>
                                      <td><?php echo $resultRow['Account_No'];?></td>
                                      <td><?php echo $resultRow['available_balance'];?></td>
                                  </tr>
                                  <?php 

          }//END OF WHILE LOOP

   ?>
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
   }else {  
    ?>
    <?php
      $query = "SELECT client.client_type, client.id, client.account_type, client.account_no, client.mobile_no, client.firstname, client.lastname FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND account.type_id = '2' && (client.branch_id ='$br_id' $branches)";
      $result = mysqli_query($connection, $query);
      while($d = mysqli_fetch_array($result)){
        $clid = $d['id'];
        $don = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$clid'");
        $ew = mysqli_fetch_array($don);
        $accountb = $ew['account_balance_derived'];
        @$ttlacc +=$accountb;
      }
      
  ?>

<!-- Content added here for savings account reports -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
              <?php 
  // $savingBalance = "
  //   SELECT * FROM saving_balances_migration
  //   // INNER JOIN 
  //   //   clients_branch_migrate 
  //   // ON saving_balances_migration.Client_Name=clients_branch_migrate.name
  // ";

  // $quert2 = "
  //       SELECT outstanding_report_migrate.account, outstanding_report_migrate.loan_principal, outstanding_report_migrate.outstanding_principal,
  //       outstanding_report_migrate.interest, outstanding_report_migrate.fees, outstanding_report_migrate.total, clients_branch_migrate.repaid,
  //        clients_branch_migrate.overdue, clients_branch_migrate.group_name
  //     FROM outstanding_report_migrate
  //     LEFT JOIN clients_branch_migrate ON outstanding_report_migrate.client_name = clients_branch_migrate.name;
  // ";

?>
             <div class="card-header card-header-primary">
                  <h4 class="card-title ">Savings Accounts</h4>
                  
                  <!-- Insert number users institutions -->
                  <p class="card-category"><?php
                          $querys = "SELECT client.id, client.account_type, client.account_no, client.mobile_no, client.display_name, client.firstname, client.lastname FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND account.type_id = '2' && (client.branch_id ='$br_id' $branches)";
                          $result = mysqli_query($connection, $querys);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     echo $inr;
                   }?> savings Accounts</p>
                </div>
                <div class="card-body">
                <div class="d-flex justify-content-center">
                  <div class="text-center">
                    <div class="card">
                      <div class="card-body">
                        <div class="form-group">
                          <form method = "POST" action = "../composer/savings_account.php">
                            <input hidden name ="acc_bal" type="text" value="<?php echo $ttlacc;?>"/>
                            <div class="form-group total-balances p-0">
                                <label class="bmd-label-floating mt-0">Total Account Balances</label>
                                <input type="text" readonly class="form-control" value="<?php echo number_format($ttlacc, 2); ?>" name="">
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
             <script>
              $(document).ready(function () {
                
                 // savings account datatable
                $('#savings-accounts').DataTable(); 

              $('#clientlist').on("click", function () {
                swal({
                    type: "success",
                    title: "SAVINGS ACCOUNT REPORT",
                    text: "Printing Successful",
                    showConfirmButton: false,
                    timer: 5000
                          
                  })
              });
            });
     </script>
                           
                
                  <div class="table-responsive">
                    <table id="savings-accounts" class="table table-striped table-bordered" style="width:100%">
                      <thead class="">
                      <?php
                          $query = "SELECT client.client_type, client.id, client.account_type, client.account_no, client.mobile_no, client.display_name, client.firstname, client.lastname FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND account.type_id = '2' && (client.branch_id ='$br_id' $branches)";
                          $result = mysqli_query($connection, $query);
                      ?>
                        <th>
                          Client Name
                        </th>
                        <!-- <th>
                          Account Type
                        </th> -->
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
                          <th><?php echo $row["display_name"]; ?></th>
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
                          $don = mysqli_query($connection, "SELECT SUM(account_balance_derived) AS account_balance_derived FROM account WHERE client_id = '$idd'");
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

                    <div>
                      <button type="submit" id="clientlist" class="btn btn-primary pull-left">Download PDF</button>
                    </div>
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
<?php
}
 else if (isset($_GET["view11"])) {
?>

<?php
      $query = "SELECT client.client_type, client.id, client.account_type, client.account_no, client.mobile_no, client.firstname, client.lastname FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND account.type_id = '2' && (client.branch_id ='$br_id' $branches)";
      $result = mysqli_query($connection, $query);
      while($d = mysqli_fetch_array($result)){
        $clid = $d['id'];
        $don = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$clid'");
        $ew = mysqli_fetch_array($don);
        $accountb = $ew['account_balance_derived'];
        @$ttlacc +=$accountb;
      }
      
  ?>
<!-- Content added here for savings account reports -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
              <?php 
  // $savingBalance = "
  //   SELECT * FROM saving_balances_migration
  //   // INNER JOIN 
  //   //   clients_branch_migrate 
  //   // ON saving_balances_migration.Client_Name=clients_branch_migrate.name
  // ";

  // $quert2 = "
  //       SELECT outstanding_report_migrate.account, outstanding_report_migrate.loan_principal, outstanding_report_migrate.outstanding_principal,
  //       outstanding_report_migrate.interest, outstanding_report_migrate.fees, outstanding_report_migrate.total, clients_branch_migrate.repaid,
  //        clients_branch_migrate.overdue, clients_branch_migrate.group_name
  //     FROM outstanding_report_migrate
  //     LEFT JOIN clients_branch_migrate ON outstanding_report_migrate.client_name = clients_branch_migrate.name;
  // ";

?>
             <div class="card-header card-header-primary">
                  <h4 class="card-title ">Savings Account Analysis</h4>
                  
                  <!-- Insert number users institutions -->
                  <p class="card-category"><?php
                          $querys = "SELECT client.id, client.account_type, client.account_no, client.mobile_no, client.display_name, client.firstname, client.lastname FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND account.type_id = '2' && (client.branch_id ='$br_id' $branches)";
                          $result = mysqli_query($connection, $querys);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     echo $inr;
                   }?> savings Accounts</p>
                </div>
                <div class="card-body">
                <div class="">
                  <div class="row text-center">
                  <div class="col-md-5">
                    <div class="card mr-3">
                      <div class="card-body">
                        <div class="form-group">
                          <form method = "POST" action = "../composer/savings_account.php">
                            <input hidden name ="acc_bal" type="text" value="<?php echo $ttlacc;?>"/>
                            <div class="form-group total-balances p-0">
                                <label class="bmd-label-floating mt-0">Total credits</label>
                                <input type="text" readonly class="form-control text-success" value="<?php echo number_format($ttlacc, 2); ?>" name="">
                            </div>
                          </form>
                        </div>
                      </div>
                    </div></div>
                    <div class="col-md-5">
                    <div class="card">
                      <div class="card-body">
                        <div class="form-group">
                          <form method = "POST" action = "../composer/savings_account.php">
                            <input hidden name ="acc_bal" type="text" value="<?php echo $ttlacc;?>"/>
                            <div class="form-group total-balances p-0">
                                <label class="bmd-label-floating mt-0">Total Debits</label>
                                <input type="text" readonly class="form-control text-danger" value="<?php echo number_format($ttlacc, 2); ?>" name="">
                            </div>
                          </form>
                        </div>
                      </div>
                    </div></div>
                  </div>
                </div>
             <script>
              $(document).ready(function () {
                
                 // savings account datatable
                $('#savings-accounts').DataTable(); 

              $('#clientlist').on("click", function () {
                swal({
                    type: "success",
                    title: "SAVINGS ACCOUNT REPORT",
                    text: "Printing Successful",
                    showConfirmButton: false,
                    timer: 5000
                          
                  })
              });
            });
     </script>
                           
                
                  <div class="table-responsive">
                    <table id="savings-accounts" class="table table-striped table-bordered" style="width:100%">
                      <thead class="">
                      <?php
                          $query = "SELECT client.client_type, client.id, client.account_type, client.account_no, client.mobile_no, client.display_name, client.firstname, client.lastname FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND account.type_id = '2' && (client.branch_id ='$br_id' $branches)";
                          $result = mysqli_query($connection, $query);
                      ?>
                        <th>
                          Client Name
                        </th>
                    
                        <th>
                          Credit
                        </th>
                        <th>
                          Debit
                        </th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; 
                        $idd = $row["id"];?>
                          <th><?php echo $row["display_name"]; ?></th>
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
                          
                          <?php
                          $don = mysqli_query($connection, "SELECT SUM(account_balance_derived) AS account_balance_derived FROM account WHERE client_id = '$idd'");
                          $ew = mysqli_fetch_array($don);
                          $accountb = $ew['account_balance_derived'];
                          ?>
                          <th><?php echo $accountb; ?></th>
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

                    <div>
                      <button type="submit" id="clientlist" class="btn btn-primary pull-left">Download PDF</button>
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

<?php
}
 else if (isset($_GET["view41"])) {
?>


 <?php
      $query = "SELECT client.client_type, client.id, client.account_type, client.account_no, client.mobile_no, client.firstname, client.lastname FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND account.type_id = '2' && (client.branch_id ='$br_id' $branches)";
      $result = mysqli_query($connection, $query);
      while($d = mysqli_fetch_array($result)){
        $clid = $d['id'];
        $don = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$clid'");
        $ew = mysqli_fetch_array($don);
        $accountb = $ew['account_balance_derived'];
        @$ttlacc +=$accountb;
      }
      
  ?>

<!-- Content added here for savings account reports -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
              <?php 
  // $savingBalance = "
  //   SELECT * FROM saving_balances_migration
  //   // INNER JOIN 
  //   //   clients_branch_migrate 
  //   // ON saving_balances_migration.Client_Name=clients_branch_migrate.name
  // ";

  // $quert2 = "
  //       SELECT outstanding_report_migrate.account, outstanding_report_migrate.loan_principal, outstanding_report_migrate.outstanding_principal,
  //       outstanding_report_migrate.interest, outstanding_report_migrate.fees, outstanding_report_migrate.total, clients_branch_migrate.repaid,
  //        clients_branch_migrate.overdue, clients_branch_migrate.group_name
  //     FROM outstanding_report_migrate
  //     LEFT JOIN clients_branch_migrate ON outstanding_report_migrate.client_name = clients_branch_migrate.name;
  // ";

?>
             <div class="card-header card-header-primary">
                  <h4 class="card-title ">Savings Accounts in Debits</h4>
                  
                  <!-- Insert number users institutions -->
                  <p class="card-category"><?php
                          $querys = "SELECT client.id, client.account_type, client.account_no, client.mobile_no, client.firstname, client.lastname FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND account.type_id = '2' && (client.branch_id ='$br_id' $branches)";
                          $result = mysqli_query($connection, $querys);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     echo $inr;
                   }?> savings Accounts</p>
                </div>
                <div class="card-body">
                <div class="d-flex justify-content-center">
                  <div class="text-center">
                    <div class="card">
                      <div class="card-body">
                        <div class="form-group">
                          <form method = "POST" action = "../composer/savings_account.php">
                            <input hidden name ="acc_bal" type="text" value="<?php echo $ttlacc;?>"/>
                            <div class="form-group total-balances p-0">
                                <label class="bmd-label-floating mt-0">Total Balances in Debits</label>
                                <div class="d-flex">
                            <!-- <span>N</span>     -->
                            <input type="text" readonly class="form-control" value="<?php echo number_format($ttlacc, 2); ?>" name="">
                            </div></div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
             <script>
              $(document).ready(function () {
                
                 // savings account datatable
                $('#savings-accounts').DataTable(); 

              $('#clientlist').on("click", function () {
                swal({
                    type: "success",
                    title: "SAVINGS ACCOUNT REPORT",
                    text: "Printing Successful",
                    showConfirmButton: false,
                    timer: 5000
                          
                  })
              });
            });
     </script>
                           
                
                  <div class="table-responsive">
                    <table id="savings-accounts" class="table table-striped table-bordered" style="width:100%">
                      <thead class="">
                      <?php
                          $query = "SELECT client.client_type, client.id, client.account_type, client.account_no, client.mobile_no, client.display_name, client.firstname, client.lastname FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND account.type_id = '2' && (client.branch_id ='$br_id' $branches)";
                          $result = mysqli_query($connection, $query);
                      ?>
                        <th>
                          Client Name
                        </th>
                        <!-- <th>
                          Last Name
                        </th> -->
                        <th>
                          Client Type
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
                          <th><?php echo $row["display_name"]; ?></th>
                          <!-- <th><?php echo $row["lastname"]; ?></th> -->
                          <th><?php echo strtoupper($row["client_type"])?></th>
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
                          $don = mysqli_query($connection, "SELECT SUM(account_balance_derived) AS account_balance_derived FROM account WHERE client_id = '$idd'");
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

                    <div>
                      <button type="submit" id="clientlist" class="btn btn-primary pull-left">Download PDF</button>
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

<?php
 } else {

 }
 ?>
