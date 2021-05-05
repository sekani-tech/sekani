<?php

$page_title = "Fixed Deposits";
$destination = "report_current.php";
    include("header.php");

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

 if (isset($_GET["view31"])) {
?>
<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Fixed Deposit Accounts</h4>
                  <!-- Insert number users institutions -->
                  <p class="card-category">
                    <?php
                    $querys = "SELECT * FROM `ftd_booking_account` WHERE int_id = '$sessint_id' AND status = 'Approved'";
                    $result = mysqli_query($connection, $querys);
                    if ($result) {
                      $inr = mysqli_num_rows($result);
                      echo $inr;
                    }
                    ?> FTD Account(s)
                  </p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="ftd" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <?php
                        $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $br_id");
                        while ($result = mysqli_fetch_array($getParentID)) {
                            $parent_id = $result['parent_id'];
                        }

                        if ($parent_id == 0) {
                            $query = "SELECT c.firstname, c.lastname, c.client_type, f.id, f.product_id, f.account_no, f.account_balance_derived, f.is_paid FROM ftd_booking_account f JOIN client c ON f.client_id = c.id JOIN account a ON c.id = a.client_id WHERE f.int_id = '$sessint_id' AND f.status = 'Approved' ORDER BY c.firstname ASC";
                            $result = mysqli_query($connection, $query);
                        } else {
                            $query = "SELECT c.firstname, c.lastname, c.client_type, f.id, f.product_id, f.account_no, f.account_balance_derived, f.is_paid FROM ftd_booking_account f JOIN client c ON f.client_id = c.id JOIN account a ON c.id = a.client_id WHERE f.int_id = '$sessint_id' AND f.branch_id = '$br_id' AND f.status = 'Approved' ORDER BY c.firstname ASC";
                            $result = mysqli_query($connection, $query);
                        }
                        ?>
                        <tr>
                          <th>Display Name</th>
                          <th>Client Type</th>
                          <th>Account Type</th>
                          <th>Account Number</th>
                          <th>Account Balance</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        if (mysqli_num_rows($result) > 0) {
                          while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                            <tr>
                              <td><?php echo $row["firstname"] . " ". $row["lastname"]; ?></td>
                              <td><?php echo strtoupper($row["client_type"])?></td>
                              <?php
                              $prod = $row["product_id"];
                              $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$prod'");
                              if (count([$spn])) {
                                $d = mysqli_fetch_array($spn);
                                $savings_product = $d["name"];
                              }
                        ?>
                              <td><?php echo $savings_product; ?></td>
                              <td><?php echo $row["account_no"]; ?></td>
                              <td>
                                <?php
                                  if($row["is_paid"] == 1 || $row["is_paid"] == 2) {
                                      echo '0.00';
                                  } else {
                                      echo $row["account_balance_derived"]; 
                                  }
                                ?>
                              </td>
                              <td>
                                <?php 
                                if($row["is_paid"] == 0) {
                                    echo "Active";
                                } elseif($row["is_paid"] == 1) {
                                    echo "Completed";
                                } else {
                                    echo "Terminated";
                                }
                                ?>
                              </td>
                              <td><a href="ftd_schedule.php?id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-info">View</button></a></td>
                            </tr> 
                        <?php 
                          }
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>

                  <div class="form-group mt-4">
                    <form method="POST" action="../composer/ftd_account.php">
                      <input hidden name="id" type="text" value="<?php echo $id;?>"/>
                      <button type="submit" class="btn btn-primary pull-left">Download PDF</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

<?php
}
 else if (isset($_GET["view42"])) {
?>
<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Current Accounts in Debit</h4>
                  
                  <!-- Insert number users institutions -->
                  <p class="card-category"><?php
                          $querys = "SELECT client.id, client.account_type, client.account_no, client.mobile_no, client.firstname, client.lastname FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND account.type_id = '1' AND account.account_balance_derived < '0.00'";
                          $result = mysqli_query($connection, $querys);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     echo $inr;
                   }?> current Accounts</p>
                </div>
                <div class="card-body">
                <div class="form-group">
                <form method = "POST" action = "../composer/current_account.php">
              <input hidden name ="rer" type="text" value="sdsdsd"/>
              <input hidden name ="start" type="text" value="<?php echo $start;?>"/>
              <input hidden name ="end" type="text" value="<?php echo $end;?>"/>
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
                    <table class="rtable display nowrap" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                          $query = "SELECT client.client_type, client.id, client.account_type, client.account_no, client.mobile_no, client.firstname, client.lastname FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND account.type_id = '1' AND account.account_balance_derived < '0.00'";
                          $result = mysqli_query($connection, $query);
                      ?>
                        <th>
                          First Name
                        </th>
                        <th>
                          Last Name
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
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; 
                        $idd = $row["id"];?>
                          <th><?php echo $row["firstname"]; ?></th>
                          <th><?php echo $row["lastname"]; ?></th>
                          <th><?php echo strtoupper($row["client_type"]." "."")?></th>
                          <?php
                            $class = "";
                            $row["account_type"];
                            $cid= $row["id"];
                            $atype = mysqli_query($connection, "SELECT * FROM account WHERE product_id = '1' AND client_id = '$cid'");
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
 ?>
