<?php

$page_title = "General Refill";
$destination = "index.php";
    include("header.php");
?>
<style>
    td{
        text-align: right;
    }
</style>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
            <?php
             $digits = 9;
             $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
             $transaction_id = "REFILL".$randms."SELF";
            $sql_on = mysqli_query($connection, "SELECT SUM(running_balance) AS running_balance FROM sekani_wallet");
            $xm = mysqli_fetch_array($sql_on);
            $r_n_b = $xm["running_balance"];
            ?>
          <!-- your content here -->
            <div class="row">
  <div class="col-md-4 ml-auto mr-auto">
    <div class="card card-pricing bg-primary"><div class="card-body">
        <div class="card-icon">
            <i class="material-icons">business</i>
        </div>
        <h3 class="card-title">NGN <?php echo number_format($r_n_b, 2); ?></h3>
        <p class="card-description">
            Balance ( <b>Note: This amount must be available</b> )
        </p>
        <p>Fund The Online Wallet with that amount</p>
        <form id="form" action="paystack_general/initialize.php" method="POST">
                <div class="card-body">
                <div class = "row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="installmentAmount" style="color: white;" >Amount</label>
                      <input type="number" class="form-control" style="color: white;" name="amt" value="<?php echo $r_n_b; ?>" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                      <label for="installmentAmount" style="color: white;">Transaction Id</label>
                      <input type="text" class="form-control" name="trans" value="<?php echo $transaction_id; ?>">
                    </div>
                </div>
                </div>
                </div>
                <button type="submit" class="btn btn-white btn-round pull-right" style="color:black;">General Refill</button>
                </form>
        </div>
    </div>
  </div>
</div>
    </div>
    </div>

<?php

    include("footer.php");

?>