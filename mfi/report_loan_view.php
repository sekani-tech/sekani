<?php

$page_title = "Client Report";
$destination = "report_loan.php";
    include("header.php");
?>
<?php
 if (isset($_GET["view15"])) {
?>
<!-- Data for clients registered this month -->
<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Disbursed Loans</h4>
                  <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script>
                  <!-- Insert number users institutions -->
                  <p class="card-category">
                      <?php
                        $query = "SELECT * FROM loan_disbursement_cache WHERE int_id = '$sessint_id'";
                        // $query = "SELECT * FROM client JOIN staff ON client.loan_officer_id = staff.id WHERE client.int_id = '$sessint_id' && client.status = 'Approved'";
                        $result = mysqli_query($connection, $query);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     echo $inr;
                     $date = date("F");
                   }?> Disbursed Loans</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="tabledat2" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM loan_disbursement_cache WHERE int_id = '$sessint_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <th>
                          Client Name
                        </th>
                        <th>
                          Loan Amount
                        </th>
                        <th>
                          Loan Term
                        </th>
                        <th>
                          Disbursement Date
                        </th>
                        <th>
                          Maturity Date
                        </th>
                        <th>
                          Interest Rate
                        </th>
                        <th>
                          Monthly Interest
                        </th>
                        <th>
                          Total Interest
                        </th>
                        <th>
                          Fee
                        </th>
                        <th>
                          Total Income
                        </th>
                        <!-- <th>Phone</th> -->
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                        <?php 
                            $name = $row['client_id'];
                            $anam = mysqli_query($connection, "SELECT firstname, lastname FROM client WHERE id = '$name'");
                            $f = mysqli_fetch_array($anam);
                            $nae = strtoupper($f["firstname"]." ".$f["lastname"]);
                        ?>
                          <th><?php echo $nae; ?></th>
                          <th><?php echo $row["account_no"]; ?></th>
                          <th><?php echo $row["principal_amount"]; ?></th>
                          <th><?php echo $row["repayment_date"];?></th>
                          <th><?php echo $row["total_outstanding_derived"]; ?></th>
                          <th><?php echo $row["status"]; ?></th>
                          <td><a href="client_view.php?edit=<?php echo $cid;?>" class="btn btn-info">View</a></td>
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
                <div class="card-body">
                  <button href="" class="btn btn-primary">PRINT PDF</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

<?php
 }
 else if(isset($_GET["view16"])){
?>
<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Loans</h4>
                  <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script>
                  <!-- Insert number users institutions -->
                  <p class="card-category"><?php
                        $query = "SELECT * FROM loan WHERE int_id = '$sessint_id'";
                        $result = mysqli_query($connection, $query);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     echo $inr;
                   }?> Loans || <a style = "color: white;" href="lend.php">Create New Loan</a></p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="tabledats" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM loan WHERE int_id = '$sessint_id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <th>
                          Client Name
                        </th>
                        <th>
                          Account No
                        </th>
                        <th>
                          Principal Amount
                        </th>
                        <th>
                          Repayment Date
                        </th>
                        <th>
                          Outstanding Loan Balances
                        </th>
                        <th>View</th>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                        <?php 
                            $name = $row['client_id'];
                            $anam = mysqli_query($connection, "SELECT firstname, lastname FROM client WHERE id = '$name'");
                            $f = mysqli_fetch_array($anam);
                            $nae = strtoupper($f["firstname"]." ".$f["lastname"]);
                        ?>
                          <th><?php echo $nae; ?></th>
                          <th><?php echo $row["account_no"]; ?></th>
                          <th><?php echo $row["principal_amount"]; ?></th>
                          <th><?php echo $row["repayment_date"];?></th>
                          <th><?php echo $row["total_outstanding_derived"]; ?></th>
                          <th><?php echo $row["loan_term"]; ?></th>
                          <td><a href="client_view.php?edit=<?php echo $cid;?>" class="btn btn-info">View</a></td>
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
