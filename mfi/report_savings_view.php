<?php

$page_title = "Client Report";
$destination = "report_savings.php";
    include("header.php");
?>
<?php
 if (isset($_GET["view10"])) {
?>
<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Savings Accounts</h4>
                  <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script>
                  <!-- Insert number users institutions -->
                  <p class="card-category"><?php
                          $querys = "SELECT client.id, client.account_type, client.account_no, client.mobile_no, client.firstname, client.lastname FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND account.type_id = '2'";
                          $result = mysqli_query($connection, $querys);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     echo $inr;
                   }?> savings Accounts</p>
                </div>
                <div class="card-body">
                <div class="form-group">
                <form method = "POST" action = "../composer/savings_account.php">
              <input hidden name ="id" type="text" value="<?php echo $id;?>"/>
              <input hidden name ="start" type="text" value="<?php echo $start;?>"/>
              <input hidden name ="end" type="text" value="<?php echo $end;?>"/>
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
                    <table id="tabledt" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                          $query = "SELECT client.client_type, client.id, client.account_type, client.account_no, client.mobile_no, client.firstname, client.lastname FROM client JOIN account ON client.id = account.client_id WHERE client.int_id = '$sessint_id' AND account.type_id = '2'";
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
 else if (isset($_GET["view5"])) {
?>

<?php
 }
 else if(isset($_GET["view4"])){
?>
 
<?php
 }
 ?>
