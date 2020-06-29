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
          $int_email = $_SESSION["int_email"];
          $int_name = $_SESSION["int_name"];
          $sql_on = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$int_id' AND branch_id = '$branch_id'");
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
            <button type="button" class="btn btn-primary pull-right" id="run_pay" >Run Report</button>
                </form>
                  <!-- check -->
                  <!-- javascript to display wallet transaction -->
                  <!-- javascript to end wallet transaction -->
                </div>
              </div>
            </div>
            <!-- WE ARE DONE -->
            <?php
            $digits = 10;
            $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
            $transaction_id = "SKWAL".$randms."LET".$int_name;

            $get_id = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$int_id' AND branch_id = '$branch_id'");
            $sw = mysqli_fetch_array($get_id);
            $wallet_bal = $sw["running_balance"];
            $total_spent = $sw["total_withdrawal"];
            $total_deposit = $sw["total_deposit"];
            ?>
            <div class="col-md-4">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">WALLET BALANCE</h4>
                  <p>Fund Your Sekani Wallet to be able to us our service</p>
                  <!-- Insert number users institutions -->
                </div>
                <form id="paymentForm">
                <div class="card-body">
                <div class = "row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="installmentAmount" >Amount</label>
                      <input type="tel" class="form-control" id="amount" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                      <label for="installmentAmount">Transaction Id</label>
                      <input type="text" class="form-control" id="transaction_id" value="<?php echo $transaction_id; ?>" readonly>
                    </div>
                </div>
                 <div class="col-md-12">
                    <div class="form-group">
                      <label for="installmentAmount" >Description</label>
                      <input type="text" class="form-control" id="description" value="" required>
                    </div>
                </div>
                <input type="text" value="<?php echo $int_id; ?>" id="int_id" hidden>
          <input type="text" value="<?php echo $branch_id;?>" id="branch_id" hidden>
          <input type="text" value="<?php echo $int_email;?>" id="int_email" hidden>
          <input type="text" value="<?php echo $int_name;?>" id="int_name" hidden>
                </div>
                </div>
                <div class="card-body">
                    <div class="col-md-12">
                      Balance: <div style="float: right;">NGN <?php echo number_format($wallet_bal,2); ?></div>
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
            <button type="submit" onclick="payWithPaystack()" class="btn btn-primary pull-right">Refill</button>
            <br>
                </div>
                </form>
                <script src="https://js.paystack.co/v2/inline.js"></script>
                <script>
//                  var paymentForm = document.getElementById('paymentForm');
// paymentForm.addEventListener("submit", payWithPaystack, false);
// function payWithPaystack(e) {
//   e.preventDefault();
//   var config = {
//     key: 'pk_live_9b8524a2f646855944ad776bc67c1b80b6449a3b', // Replace with your public key
//     email: document.getElementById("int_email").value,
//     amount: document.getElementById("amount").value * 100,
//     firstname: document.getElementById("int_name").value,
//     lastname: 'WALLET',
//     currency: "NGN", //GHS for Ghana Cedis
//     reference: document.getElementById("transaction_id").value, //use your reference or leave empty to have a reference generated for you
//     // label: "Optional string that replaces customer email"
//     onClose: function(){
//       alert('Window closed.');
//     },
//     callback: function(response){
//       var message = 'Payment complete! Reference: ' + response.reference;
//       alert(message);
//     }
//   };
//   var paystackPopup = new Popup(config);
//   paystackPopup.open();
// }
var paymentForm = document.getElementById('paymentForm');
paymentForm.addEventListener('submit', payWithPaystack, false);
function payWithPaystack() {
  var handler = PaystackPop.setup({
    key: 'pk_live_9b8524a2f646855944ad776bc67c1b80b6449a3b', // Replace with your public key
    email: document.getElementById("int_email").value,
    amount: document.getElementById("amount").value * 100,
    firstname: document.getElementById("int_name").value,
    lastname: 'WALLET',
    currency: "NGN", //GHS for Ghana Cedis
    reference: document.getElementById("transaction_id").value, 
    callback: function(response) {
      //this happens after the payment is completed successfully
      var reference = response.reference;
      alert('Payment complete! Reference: ' + reference);
      // Make an AJAX call to your server with the reference to verify the transaction
    },
    onClose: function() {
      alert('Transaction was not completed, window closed.');
    },
  });
  handler.openIframe();
  // making popping
}
                </script>
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
          <div id="wallet_result"></div>
        </div>
      </div>

<?php

    include("footer.php");

?>