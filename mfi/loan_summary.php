<?php

$page_title = "Loan Summary";
$destination = "loans.php";
    include("header.php");

    if(isset($_GET["loancoll"])) {
      $id = $_GET["loancoll"];
    }

    // Query for the loan & client
    $query = "SELECT passport, signature, id_img_url, client.id, loan_officer, loan.col_description, principal_amount, loan.total_repayment_derived, loan.account_no, client.display_name, loan.interest_rate FROM loan JOIN client ON loan.client_id = client.id WHERE client.int_id ='$sessint_id' && client.loan_status = 'Active'";
    $result = mysqli_query($connection, $query);
    if (count([$query]) == 1) {
    $n = mysqli_fetch_array($result);
    $name = $n['display_name'];
    $accountno = $n['account_no'];
    $passport = $n['passport'];
    $sign = $n['signature'];
    $idimg = $n['id_img_url'];
    $loanofficer = $n['loan_officer'];;
    $loan_amount = $n['principal_amount'];
    $amount_payed = $n['total_repayment_derived'];
    $OLoan_balance = $n['total_repayment_derived'];
    $collateral = $n['col_description'];
    }

?>

<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Account</h4>
                </div>
                <div class="card-body">
                  <form action="">
                    <div class="form-group">
                      <label for="">Name:</label>
                      <input type="text" name="" id="" style="text-transform: uppercase;" class="form-control" value="<?php echo $name; ?>" readonly name="display_name">
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Account No:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $accountno; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Account Officer:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $loanofficer ?>" readonly>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Loan Summary</h4>
                </div>
                <div class="card-body">
                <form action="">
                    <div class="form-group">
                          <label for="">Loan Amount:</label>
                          <input type="text" name="" id="" class="form-control" value="<?php echo $loan_amount; ?>" readonly>
                        </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Total Outstanding Loan balance:</label>
                          <input type="text" name="" id="" class="form-control" value="<?php echo $amount_payed; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Total Loan Amount payed:</label>
                          <input type="text" name="" id="" class="form-control" value="<?php echo $OLoan_balance; ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Collateral Value</label>
                          <input type="text" name="" id="" class="form-control" value="<?php echo $collateral; ?>" readonly>
                        </div>
                      </div>
                    </div>
                    <!-- Loan collection -->
                    <div class="table-responsive">
                    <table id="tabledat3" class="table" style="width: 100%;">
                      <thead class=" text-primary">
                        <!-- <th>
                          ID
                        </th> -->
                        <?php
                        $query = "SELECT client.id, principal_amount, client.display_name, loan.interest_rate FROM loan JOIN client ON loan.client_id = client.id WHERE client.int_id ='$sessint_id' && client.loan_status = 'Active'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <th>Name</th>
                        <th>
                          Principal
                        </th>
                        <th>
                          Interest Value
                        </th>
                        <th>
                          Collect Loan
                        </th>
                        <th></th>
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo $row["display_name"]; ?></th>
                          <th><?php echo $row["principal_amount"]; ?></th>
                          <th><?php echo $row["interest_rate"]; ?></th>
                          <td><a href="loan_collection.php?loancoll=<?php echo $row["id"];?>" class="btn btn-info">Collect</a></td>
                          </tr>
                          <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                      </tbody>
                    </table>
                  </div>
                    <!-- lc -->
                    <!-- <a href="lend.php" class="btn btn-primary">Disburse Loan</a> -->
                    <!-- <a href="#" class="btn btn-primary">Generate Account Report</a> -->
                    <!-- <a href="client.php" class="btn btn-primary pull-right">Back</a> -->
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card card-profile">
                <div class="card-avatar">
                  <a href="#pablo">
                    <img class="img" src="../functions/clients/<?php echo $passport;?>" />
                  </a>
                </div>
                <!-- Get session data and populate user profile -->
                <div class="card-body">
                  <h6 class="card-category text-gray">Passport</h6>
                  
                  <!-- <p class="card-description">
                    Account Balance
                  </p> -->
                  <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
                </div>
                <!-- passport -->
              </div>
              <div class="card card-profile">
                <div class="card-avatar">
                  <a href="#pablo">
                    <img class="img" src="../functions/clients/<?php echo $idimg;?>" />
                  </a>
                </div>
                <!-- Get session data and populate user profile -->
                <div class="card-body">
                  <h6 class="card-category text-gray">ID Card</h6>
                  <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
                </div>
              </div>
                <!-- /id card -->
                <div class="card card-profile">
                <div class="card-avatar">
                  <a href="#pablo">
                    <img class="img" src="../functions/clients/<?php echo $sign;?>" />
                  </a>
                </div>
                <!-- Get session data and populate user profile -->
                <div class="card-body">
                  <h6 class="card-category text-gray">Signature</h6>
                  <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
                </div>
              </div>
                <!-- signature -->
            </div>
          </div>
        </div>
      </div>

<?php

include("footer.php");

?>