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
          <?php
          $int_id = $_SESSION["int_id"];
          $branch_id = $_SESSION["branch_id"];
          $sql_on = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$int_id'");
          $xm = mysqli_num_rows($sql_on);
          if ($xm >= 1) {
          ?>
          <!-- NOW DO SOMETHING -->
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
                  <script>
    $(document).ready(function() {
        $('#run_pay').on("click", function(){
            var int_id = $('#int_id').val();
            var branch_id = $('#branch_id').val();
            var start = $('#start').val();
            var end = $('#end').val();
            $.ajax({
                url:"ajax_post/wallet_transaction.php",
                method:"POST",
            data:{int_id:int_id, branch_id: branch_id, start:start, end:end},
            success:function(data){
            $('#view_report_me').html(data)
            }
        })
    });
});
</script>
                  <!-- uncheck -->
                  <!-- <form id="form" method="POST"> -->
                <div class="card-body">
                <div class = "row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="sdate" >Start Date</label>
                      <input type="date" class="form-control" id="start" value="" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="installmentAmount">End Date</label>
                      <input type="date" class="form-control" id="end" value="" required>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="form-group">
                      <label for="installmentAmount" >Category</label>
                      <select class="form-control" name="amt">
                        <option value="refill">All</option>
                        <option value="bvn">BVN</option>
                        <option value="sms">SMS</option>
                      </select>
                    </div>
                </div>
                </div>
                </div>
            <a class="btn btn-primary pull-right" id="run_pay"> <span style="color: white;">Run Report</span> </a>
                <!-- </form> -->
                  <!-- check -->
                  <!-- javascript to display wallet transaction -->
                  <!-- javascript to end wallet transaction -->
                </div>
              </div>
              <!-- NOTHING THE WAY -->
              <div id="view_report_me">
              </div>
            </div>
            <!-- WE ARE DONE -->
            <?php
            $digits = 9;
            $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
            $transaction_id = "SKWAL".$randms."LET".$int_name;
            ?>
            <div class="col-md-4">
            <?php
            // GET THE CURRENT BALANCE OF THE INSTITUTION
            $get_id = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$int_id'");
            $sw = mysqli_fetch_array($get_id);
            $wallet_bal = $sw["running_balance"];
            $sms_bal = $sw["sms_balance"];
            $bvn_bal = $sw["bvn_balance"];
            $bills_bal = $sw["bills_balance"];
            $total_spent = $sw["total_withdrawal"];
            $total_deposit = $sw["total_deposit"];
            ?>
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">WALLET BALANCE</h4>
                  <p>Fund Your Sekani Wallet to be able to use our service</p>
                  <!-- Insert number users institutions -->
                </div>
                <form id="form" action="flutter/initialize.php" method="POST">
                <div class="card-body">
                <div class = "row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="installmentAmount" >Amount</label>
                      <input type="number" class="form-control" name="amt" value="" required>
                      <input type="text" class="form-control" name="int_id_transaction" value="<?php echo $int_id; ?>" hidden required>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                      <label for="installmentAmount">Transaction Id</label>
                      <input type="text" class="form-control" name="trans" value="<?php echo $transaction_id; ?>" readonly>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                      <label for="installmentAmount" >Wallet</label>
                      <select class="form-control" name="wallet">
                      <option value="all" disabled>All Wallet Amount</option>
                      <option value="sms">SMS Wallet</option>
                      <option value="bvn">BVN Wallet</option>
                      <option value="bills">Bills & Airtime Wallet</option>
                      </select>
                    </div>
                </div>
                 <div class="col-md-12">
                    <div class="form-group">
                      <label for="installmentAmount" >Description</label>
                      <input type="text" class="form-control" name="desc" value="" required>
                    </div>
                </div>
                </div>
                </div>
                <div class="card-body">
                    <div class="col-md-12">
                      General Balance: <div style="float: right;">NGN <?php echo number_format($wallet_bal,2); ?></div>
                    </div>
                    <div class="col-md-12">
                      SMS Balance: <div style="float: right;">NGN <?php echo number_format($sms_bal,2); ?></div>
                    </div>
                    <div class="col-md-12">
                      BVN Balance: <div style="float: right;">NGN <?php echo number_format($bvn_bal,2); ?></div>
                    </div>
                    <div class="col-md-12">
                      Bills & Airtime Balance: <div style="float: right;">NGN <?php echo number_format($bills_bal,2); ?></div>
                    </div>
                    <hr>
                    <div class="col-md-12">
                      Total Spent:  <div style="float: right;">NGN <?php echo number_format($total_spent,2); ?></div>
                    </div>
                    <hr>
                    <div class="col-md-12">
                      Total Deposited: <div style="float: right;">NGN <?php echo number_format($total_deposit,2); ?></div>
                    </div>
                  <!-- check -->
                  <br>
                  <!-- open paystack transaction -->
                  <!-- end paystack transaction -->
            <button type="submit" class="btn btn-primary pull-right" id="run_pay6" >Refill</button>
            <br>
                </div>
                </form>
              </div>
              <!-- if no record of institution/ Display add wallet -->
            </div>
          </div>
          <?php
          } else {
            ?>
            <div class="row">
  <div class="col-md-4 ml-auto mr-auto">
    <div class="card card-pricing bg-primary"><div class="card-body">
        <div class="card-icon">
            <i class="material-icons">business</i>
        </div>
        <h3 class="card-title">NGN 0.00</h3>
        <p class="card-description">
            Create Institution Account Wallet
        </p>
        <p>1. Fund the Wallet</p>
        <p>2. Start Making BVN CHECK, SMS</p>
        <p>3. Print Report</p>
        <button id="wall" class="btn btn-white btn-round pull-right" style="color:black;">Create Wallet</button>
        </div>
    </div>
  </div>
</div>
<!-- next script -->
<script>
    $(document).ready(function() {
        $('#wall').on("click", function(){
            var int_id = $('#int_id').val();
            var branch_id = $('#branch_id').val();
            $.ajax({
                url:"ajax_post/wallet.php",
                method:"POST",
            data:{int_id:int_id, branch_id: branch_id},
            success:function(data){
            $('#wallet_result').html(data)
            location.reload();
            }
        })
    });
});
</script>
            <?php
          }
          ?>
          <!-- END IT NOW -->
          <input type="text" value="<?php echo $int_id; ?>" id="int_id" hidden>
          <input type="text" value="<?php echo $branch_id;?>" id="branch_id" hidden>
          <div id="wallet_result"></div>
        </div>
      </div>

<?php

    include("footer.php");

?>