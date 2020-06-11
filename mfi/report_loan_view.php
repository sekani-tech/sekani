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
                        $query = "SELECT * FROM loan WHERE int_id = '$sessint_id'";
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
                    <table id="tabledat" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM loan WHERE int_id = '$sessint_id'";
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
                        <th>View</th>
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
                          <th><?php echo $row["principal_amount"]; ?></th>
                          <th><?php echo $row["loan_term"]; ?></th>
                          <th><?php echo $row["disbursement_date"]; ?></th>
                          <th><?php echo $row["repayment_date"];?></th>
                          <th><?php echo $row["interest_rate"]; ?></th>
                          <?php
                          $int_rate = $row["interest_rate"];
                          $prina = $row["principal_amount"];
                          $intr = $int_rate/100;
                          $final = $intr * $prina;
                          ?>
                          <th><?php echo $final; ?></th>
                          <?php
                            $loant = $row["loan_term"];
                            $total = $loant * $final;
                          ?>
                          <th><?php echo $total; ?></th>
                          <th><?php echo $row["fee_charges_charged_derived"]; ?></th>
                          <?php
                          $fee = $row["fee_charges_charged_derived"];
                          $income = $fee + $total;
                          ?>
                          <th><?php echo  $income; ?></th>
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
                  <form method="POST" action="../composer/disbursedloan.php">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Start Date</label>
                          <input type="date" value="" name="start" class="form-control" id="start">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">End Date</label>
                          <input type="date" value="" name="end" class="form-control" id="end">
                          <input type="text" id="int_id" hidden name="" value="<?php echo $sessint_id;?>" class="form-control" readonly>
                        </div>
                      </div>
                    </div>
                    <button type="reset" class="btn btn-danger pull-right">Reset</button>
                  <button type="submit" id="runi" class="btn btn-primary pull-right">Print PDF</button>
                  </form>
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
                          <td><a href="loan_report_view.php?edit=<?php echo $row["id"];?>" class="btn btn-info">View</a></td>
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
 else if(isset($_GET["view17"])){
 ?>
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                <h4 class="card-title">Loan Report</h4>
            </div>
                <div class="card-body">
                  <form>
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label for="">Start Date</label>
                        <input type="date" name="" id="" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">End Date</label>
                        <input type="date" name="" id="" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Branch</label>
                        <select name="" id="" class="form-control">
                            <option value="">Head Office</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Break Down per Branch</label>
                        <select name="" id="" class="form-control">
                            <option value="">No</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Hide Zero Balances</label>
                        <select name="" id="" class="form-control">
                            <option value="">No</option>
                        </select>
                      </div>
                    </div>
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <span id="runanalysis" class="btn btn-primary">Run report</span>
                  </form>
                </div>
              </div>
              <script>
                    $(document).ready(function () {
                      $('#runanalysis').on("click", function () {
                        var start = $('#start').val();
                        var end = $('#end').val();
                        var branch = $('#input').val();
                        var teller = $('#till').val();
                        var int_id = $('#int_id').val();
                        $.ajax({
                          url: "items/analysis.php",
                          method: "POST",
                          data:{start:start, end:end, branch:branch, teller:teller, int_id:int_id},
                          success: function (data) {
                            $('#shanalysis').html(data);
                          }
                        })
                      });
                    });
                  </script>
              <div id="shanalysis" class="card">

              </div>
            </div>
          </div>
        </div>
</div>
 <?php
 }
 else if(isset($_GET["view18"])){
 ?>
 <div class="content">
        <div class="container-fluid">
                    <!-- your content here -->
                    <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                <h4 class="card-title">Loan Classification Report</h4>
            </div>
                <div class="card-body">
                  <form action="">
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label for="">Start Date</label>
                        <input type="date" name="" id="" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">End Date</label>
                        <input type="date" name="" id="" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Branch</label>
                        <select name="" id="" class="form-control">
                            <option value="">Head Office</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Break Down per Branch</label>
                        <select name="" id="" class="form-control">
                            <option value="">No</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Hide Zero Balances</label>
                        <select name="" id="" class="form-control">
                            <option value="">No</option>
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
                        var branch = $('#input').val();
                        var teller = $('#till').val();
                        var int_id = $('#int_id').val();
                        $.ajax({
                          url: "items/loan_class.php",
                          method: "POST",
                          data:{start:start, end:end, branch:branch, teller:teller, int_id:int_id},
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
 else if(isset($_GET["view19"])){
 ?>
 <div class="content">
        <div class="container-fluid">

        </div>
 </div>
 <?php
 }
 else if(isset($_GET["view20"])){
 ?>
 <div class="content">
        <div class="container-fluid">
                    <!-- your content here -->
                    <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                <h4 class="card-title">Loan Maturity Report</h4>
            </div>
                <div class="card-body">
                  <form action="">
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label for="">Start Date</label>
                        <input type="date" name="" id="" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">End Date</label>
                        <input type="date" name="" id="" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Branch</label>
                        <select name="" id="" class="form-control">
                            <option value="">Head Office</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Break Down per Branch</label>
                        <select name="" id="" class="form-control">
                            <option value="">No</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Hide Zero Balances</label>
                        <select name="" id="" class="form-control">
                            <option value="">No</option>
                        </select>
                      </div>
                    </div>
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <span id="runmature" type="submit" class="btn btn-primary">Run report</span>
                  </form>
                </div>
              </div>
              <script>
                    $(document).ready(function () {
                      $('#runmature').on("click", function () {
                        var start = $('#start').val();
                        var end = $('#end').val();
                        var branch = $('#input').val();
                        var teller = $('#till').val();
                        var int_id = $('#int_id').val();
                        $.ajax({
                          url: "items/maturity_profile.php",
                          method: "POST",
                          data:{start:start, end:end, branch:branch, teller:teller, int_id:int_id},
                          success: function (data) {
                            $('#shmature').html(data);
                          }
                        })
                      });
                    });
                  </script>
              <div id="shmature" class="card">

              </div>
            </div>
          </div>

        </div>
 </div>
 <?php
 }
 else if(isset($_GET["view21"])){
 ?>
 <div class="content">
        <div class="container-fluid">
                    <!-- your content here -->
                    <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Loan Performance Report</h4>
                </div>
                <div class="card-body">
                  <form action="">
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label for="">Start Date</label>
                        <input type="date" name="" id="" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">End Date</label>
                        <input type="date" name="" id="" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Branch</label>
                        <select name="" id="" class="form-control">
                            <option value="">Head Office</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Break Down per Branch</label>
                        <select name="" id="" class="form-control">
                            <option value="">No</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Hide Zero Balances</label>
                        <select name="" id="" class="form-control">
                            <option value="">No</option>
                        </select>
                      </div>
                    </div>
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <span id ="runperform" type="submit" class="btn btn-primary">Run report</span>
                  </form>
                </div>
              </div>
              <script>
                    $(document).ready(function () {
                      $('#runperform').on("click", function () {
                        var start = $('#start').val();
                        var end = $('#end').val();
                        var branch = $('#input').val();
                        var teller = $('#till').val();
                        var int_id = $('#int_id').val();
                        $.ajax({
                          url: "items/perform.php",
                          method: "POST",
                          data:{start:start, end:end, branch:branch, teller:teller, int_id:int_id},
                          success: function (data) {
                            $('#shperform').html(data);
                          }
                        })
                      });
                    });
                  </script>
              <div id="shperform" class="card">

              </div>
            </div>
          </div>
        </div>
 </div>
 <?php
 }
 else if(isset($_GET["view23"])){
 ?>
 <div class="content">
        <div class="container-fluid">
                    <!-- your content here -->
                    <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                <h4 class="card-title">Loan Structure Report</h4>
            </div>
                <div class="card-body">
                  <form action="">
                    <div class="row">
                      <div class="form-group col-md-3">
                        <label for="">Start Date</label>
                        <input type="date" name="" id="" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">End Date</label>
                        <input type="date" name="" id="" class="form-control">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Branch</label>
                        <select name="" id="" class="form-control">
                            <option value="">Head Office</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Break Down per Branch</label>
                        <select name="" id="" class="form-control">
                            <option value="">No</option>
                        </select>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="">Hide Zero Balances</label>
                        <select name="" id="" class="form-control">
                            <option value="">No</option>
                        </select>
                      </div>
                    </div>
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <button type="submit" class="btn btn-primary">Run report</button>
                  </form>
                </div>
              </div>
              <div class="card">
                <div class="card-body">
                  <div style="margin:auto; text-align:center;">
                  <img src="op.jpg" alt="sf">
                  <h2>Institution name</h2>
                  <p>Address</p>
                  <h4>Schedule of Loans Structure and Maturity Profile</h4>
                  <h4>Branch</h4>
                  <P>From: 24/05/2020  ||  To: 24/05/2020</P>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Schedule of Loans Structure and Maturity Profile</h4>
                </div>
                <div class="card-body">
                  <table class="table">
                    <thead>
                    <thead>
                      <th style="font-weight:bold;">TYPE OF DEPOSIT</th>
                      <th style="font-weight:bold; text-align: center;">1- 30 Days <br> &#x20A6</th>
                      <th style="font-weight:bold; text-align: center;">31- 60 Days <br> &#x20A6</th>
                      <th style="text-align: center; font-weight:bold;">61- 90 Days <br> &#x20A6</th>
                      <th style="text-align: center; font-weight:bold;">91- 180 Days <br> &#x20A6 </th>
                      <th style="text-align: center; font-weight:bold;"> 181- 360 Days <br> &#x20A6</th>
                      <th style="text-align: center; font-weight:bold;"> Above 360 Days <br> &#x20A6</th>
                      <th style="text-align: center; font-weight:bold;"> TOTAL <br> &#x20A6</th>
                    </thead>
                    </thead>
                    <tbody>
                      <tr>
                        <td style="font-weight:bold;">MICRO-LOANS</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Number of Account</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Amount (&#x20A6)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td style="font-weight:bold;">SMALL & MEDUIM</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Number of Account</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Amount (&#x20A6)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td style="font-weight:bold;">HIRE PURCHASE</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Number of Account</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Amount (&#x20A6)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td style="font-weight:bold;">MICRO-LEASES</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Number of Account</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Amount (&#x20A6)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td style="font-weight:bold;">OTHER LOANS</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Number of Account</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Amount (&#x20A6)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td style="font-weight:bold;">STAFF LOANS</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Number of Account</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Amount (&#x20A6)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td style="font-weight:bold; background-color:bisque;">TOTAL</td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                      </tr>
                      <tr>
                        <td style="background-color:bisque;">Number of Account</td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                      </tr>
                      <tr>
                        <td style="background-color:bisque;">Amount (&#x20A6)</td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                        <td style="background-color:bisque;"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!--//report ends here -->
              <div class="card">
                 <div class="card-body">
                  <a href="" class="btn btn-primary">Back</a>
                  <a href="" class="btn btn-success btn-left">Print</a>
                 </div>
               </div> 
            </div>
          </div>

        </div>
 </div>
 <?php
 }
 ?>