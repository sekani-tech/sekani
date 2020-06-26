<?php

$page_title = "Wallet";
$destination = "index.php";
    include("header.php");
    // include("../../functions/connect.php");

?>
<style>
    td{
        text-align: right;
    }
</style>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">SEKANI WALLET</h4>
                  <!-- Insert number users institutions -->
                  <p>View Wallet Transaction report</p>
                </div>
                <div class="card-body">
                  <!-- check -->
                  <form id="form" method="POST">
                <div class="card-body">
                <div class = "row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="sdate" >Start Date</label>
                      <input type="date" class="form-control" name="sdate" value="" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="installmentAmount">End Date</label>
                      <input type="date" class="form-control" name="edate" value="" required>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="form-group">
                      <label for="installmentAmount" >Category</label>
                      <select class="form-control" name="amt">
                        <option value="1">All</option>
                        <option value="2">BVN</option>
                        <option value="3">SMS</option>
                      </select>
                    </div>
                </div>
                </div>
                </div>
            <button type="button" class="btn btn-primary pull-right" id="run_pay6" >Run Report</button>
                </form>
                  <!-- check -->
                </div>
              </div>
            </div>
            <!-- WE ARE DONE -->
            <?php
            $digits = 15;
            $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
            $transaction_id = "SKWAL".$randms."LET".$int_name;
            ?>
            <div class="col-md-4">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">WALLET BALANCE</h4>
                  <p>Fund Your Sekani Wallet to be able to us our service</p>
                  <!-- Insert number users institutions -->
                </div>
                <form id="form" method="POST">
                <div class="card-body">
                <div class = "row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="installmentAmount" >Amount</label>
                      <input type="number" class="form-control" name="amt" value="" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                      <label for="installmentAmount">Transaction Id</label>
                      <input type="text" class="form-control" name="amt" value="<?php echo $transaction_id; ?>" readonly>
                    </div>
                </div>
                 <div class="col-md-12">
                    <div class="form-group">
                      <label for="installmentAmount" >Description</label>
                      <input type="text" class="form-control" name="amt" value="" required>
                    </div>
                </div>
                </div>
                </div>
                <div class="card-body">
                    <div class="col-md-12">
                      Balance: <div style="float: right;">NGN 19,000,000.00</div>
                    </div>
                    <hr>
                    <div class="col-md-12">
                      Total Spent:  <div style="float: right;">NGN 19,000,000.00</div>
                    </div>
                    <hr>
                    <div class="col-md-12">
                      Total Deposited: <div style="float: right;">NGN 19,000,000.00</div>
                    </div>
                  <!-- check -->
                  <br>
            <button type="button" class="btn btn-primary pull-right" id="run_pay6" >Refill</button>
            <br>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

<?php

    include("footer.php");

?>