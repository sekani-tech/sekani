<?php
$page_title = "Wallet Management";
include('header.php');
?>
<!-- Content added here -->
<div class="content">
    <div class="container-fluid">
    <input type="text" value="<?php echo $int_id; ?>" id="int_id" hidden>
          <input type="text" value="<?php echo $branch_id;?>" id="branch_id" hidden>
        <!-- your content here -->
        <?php
           $digits = 9;
           $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
           $transaction_id = "SKWAL".$randms."LET".$int_name;
        //    next
          $int_id = $_SESSION["int_id"];
          $branch_id = $_SESSION["branch_id"];
          $sql_on = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$int_id'");
          $xm = mysqli_num_rows($sql_on);
          if ($xm >= 1) {
          ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Wallet Management</h4>
                        <!-- <p class="category">Category subtitle</p> -->
                    </div>
                    <div class="card-body">
                        <div class="row">
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
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-primary card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons">textsms</i>
                                        </div>
                                        <p class="card-category">SMS</p>
                                        <h3 class="card-title">₦ <?php echo number_format($sms_bal,2); ?></h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">date_range</i> Last 24 Hours
                                        </div>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                            Refill
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-primary card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons">assignment</i>
                                        </div>
                                        <p class="card-category">Bills</p>
                                        <h3 class="card-title"> <?php echo number_format($bills_bal,2); ?></h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">date_range</i> Last 24 Hours
                                        </div>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                            Refill
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-primary card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons">done_all</i>
                                        </div>
                                        <p class="card-category">BVN</p>
                                        <h3 class="card-title">₦ <?php echo number_format($bvn_bal,2); ?></h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">date_range</i> Last 24 Hours
                                        </div>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                            Refill
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6">
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-primary card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons">thumb_up</i>
                                        </div>
                                        <p class="card-category">Commission</p>
                                        <h3 class="card-title">₦--</h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">date_range</i> Last 24 Hours
                                        </div>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                            Refill
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6"></div>
                        </div>


                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Fund Your Sekani Wallet to be able to use our service</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <form id="form" action="flutter/initialize.php" method="POST">
                                            <div class="row">
                                                <div class="col">
                                                    <label>Amount</label>
                                                    <input type="number" class="form-control" name="amt" value="" required>
                                                    <input type="text" class="form-control" name="int_id_transaction" value="<?php echo $int_id; ?>" hidden required>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 20px;">
                                                <div class="col">
                                                    <label>Transaction ID</label>
                                                    <input  type="text" class="form-control" name="trans" value="<?php echo $transaction_id; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 20px;">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="">Wallet Type</label>
                                                        <select class="form-control" data-style="btn btn-link" name="wallet">
                                                        <option value="all" disabled>All Wallet Amount</option>
                                                        <option value="sms">SMS Wallet</option>
                                                        <option value="bvn">BVN Wallet</option>
                                                        <option value="bills">Bills & Airtime Wallet</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                      <label for="installmentAmount" >Description</label>
                      <input type="text" class="form-control" name="desc" value="" required>
                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <input type="submit" class="btn btn-primary" value="Refill"/>
                                    </div>
                                        </form>

                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Generate Wallet Report</h4>
                        <!-- Insert number users institutions -->
                        <p>View Wallet Transaction report</p>
                    </div>
                    <div class="card-body">
                        <!-- check -->
                        <!-- uncheck -->
                        <!-- <form id="form" method="POST"> -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sdate">Start Date</label>
                                        <input type="date" class="form-control" id="start" value="" required="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="installmentAmount">End Date</label>
                                        <input type="date" class="form-control" id="end" value="" required="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="installmentAmount">Category</label>
                                        <select class="form-control" name="amt">
                                            <option value="refill">All</option>
                                            <option value="sms">Bills</option>
                                            <option value="sms">SMS</option>
                                            <option value="bvn">BVN</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4"><a class="btn btn-primary pull-right" id="run_pay"> <span style="color: white;">Run Report</span> </a></div>
                                <div class="col-md-4"></div>
                            </div>

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
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
        <div id="view_report_me">
              </div>
            <!-- <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Generated Report</h4>
                        <p class="category">01-03-2021 to 05-9-2021</p>
                    </div>
                    <div class="card-body">
                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Transaction Id</th>
                                    <th>Description</th>
                                    <th>Deposit</th>
                                    <th>Withdrawal</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>2021-01-03</td>
                                    <td>SKWAL63642393SMS5</td>
                                    <td>SMS Charge</td>
                                    <td>₦0.00</td>
                                    <td>₦4.00</td>
                                    <td>₦123,678.00</td>
                                </tr>
                                <tr>
                                    <td>2021-01-03</td>
                                    <td>SKWAL63642393SMS5</td>
                                    <td>SMS Charge</td>
                                    <td>₦0.00</td>
                                    <td>₦4.00</td>
                                    <td>₦123,678.00</td>
                                </tr>

                            </tbody>

                        </table>

                        <script>
                            $(document).ready(function() {
                                $('#example').DataTable();
                            });
                        </script>
                    </div>
                </div>
            </div> -->
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
    </div>

</div>
</div>






</div>
</div>






<?php
include('footer.php');
?>