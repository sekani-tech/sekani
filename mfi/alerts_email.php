<?php

$page_title = "SMS";
$destination = "../../index.php";
    include("header.php");

?>
<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <!-- <span class="nav-tabs-title">Configuration:</span> -->
                      <ul class="nav nav-tabs" data-tabs="tabs">
                        <!-- <li class="nav-item">
                          <a class="nav-link active" href="#profile" data-toggle="tab">
                            <i class="material-icons">bug_report</i> Password Settings
                            <div class="ripple-container"></div>
                          </a>
                        </li> -->
                        <li class="nav-item">
                          <a class="nav-link active" href="#products" data-toggle="tab">
                          <!-- visibility -->
                            <i class="material-icons">attach_money</i> Campaign
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#holiday" data-toggle="tab">
                            <i class="material-icons">supervisor_account</i> Holiday
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#loans" data-toggle="tab">
                            <i class="material-icons">supervisor_account</i> Loans
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#fixed-deposits" data-toggle="tab">
                            <i class="material-icons">supervisor_account</i> Fixed Deposits
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="products">
                    <div id="coll"></div>
                    <!-- <button type="button" class="btn btn-primary" name="button" onclick="showDialog()"> <i class="fa fa-plus"></i> Create SMS</button> -->
                      <?php include("items/campaign_email.php"); ?>
                      <!-- items report -->
                    </div>
                    <!-- test SMS -->
                    <div class="form-group">
                      <div id="background">
                      </div>
                      <div id="diallbox">
                        <!-- <form method="POST" action="lend.php" > -->
                <h3>Send SMS</h3>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class = "bmd-label-floating" class="md-3 form-align " for="">Sender ID:</label>
                        <input type="text" name="col_name" id="send_id" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class = "bmd-label-floating" for=""> Phone</label>
                        <input type="text" name="col_value" id="phone" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class = "bmd-label-floating" for=""> Message (160 characters):</label>
                        <textarea name="msg" id="message" cols="30" rows="5" class="form-control"></textarea>
                      </div>
                    </div>
                  <div style="float:right;">
                        <span class="btn btn-primary pull-right" id="clickit" onclick="AddDlg()">Add</span>
                        <span class="btn btn-primary pull-right" onclick="AddDlg()">Cancel</span>
                      </div>
                        <!-- </form> -->
                        <script>
                              $(document).ready(function() {
                                $('#clickit').on("change keyup paste click", function() {
                                  var sender_id = $('#send_id').val();
                                  var phone = $('#phone').val();
                                  var msg = $('#message').val();
                                  $.ajax({
                                    url:"ajax_post/sms/sms.php",
                                    method:"POST",
                                    data:{sender_id:sender_id, phone:phone, msg:msg},
                                    success:function(data){
                                      $('#coll').html(data);
                                    }
                                  })
                                });
                              });
                            </script>
                        <!-- end script -->
<script>
    function AddDlg(){
        var bg = document.getElementById("background");
        var dlg = document.getElementById("diallbox");
        bg.style.display = "none";
        dlg.style.display = "none";
    }
    
    function showDialog(){
        var bg = document.getElementById("background");
        var dlg = document.getElementById("diallbox");
        bg.style.display = "block";
        dlg.style.display = "block";
        
        var winWidth = window.innerWidth;
        var winHeight = window.innerHeight;
        
        dlg.style.left = (winWidth/2) - 480/2 + "px";
        dlg.style.top = "150px";
    }
</script>
<style>
    #background{
        display: none;
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0px;
        left: 0px;
        background-color: black;
        opacity: 0.7;
        z-index: 9999;
    }
    
    #diallbox{
        /*initially dialog box is hidden*/
        display: none;
        position: fixed;
        width: 480px;
        z-index: 9999;
        border-radius: 10px;
        padding:20px;
        background-color: #ffffff;
    }
</style>
                      </div>
                    </div>
                    <!-- ebd SMS test -->
                    <!-- /items report-->
                    <div class="tab-pane" id="holiday">
                    <!-- <a href="create_charge.php" class="btn btn-primary"> Schedule of Deposit Structure and Maturity Profile</a> -->
                      <?php include("items/holiday_email.php"); ?>
                    </div>
                    <div class="tab-pane" id="loans">
                    <!-- <a href="create_charge.php" class="btn btn-primary"> Schedule of Deposit Structure and Maturity Profile</a> -->
                      <?php include("items/loans_email.php"); ?>
                    </div>
                    <div class="tab-pane" id="fixed-deposits">
                    <!-- <a href="create_charge.php" class="btn btn-primary"> Schedule of Deposit Structure and Maturity Profile</a> -->
                      <?php include("items/fixed_deposits_email.php"); ?>
                    </div>
                    <!-- nxt -->
                    <!-- /maturity profile -->
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- / -->
        </div>
      </div>

<?php

    include("footer.php");

?>