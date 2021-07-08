<?php

$page_title = "SMS";
$destination = "../../index.php";
include("header.php");

$message = $_SESSION['feedback'];
if($message != ""){
?>
<input type="text" value="<?php echo $message?>" id="feedback" hidden>
<?php
}
// feedback messages 0 for success and 1 for errors

if (isset($_GET["message0"])) {
    $key = $_GET["message0"];
    $tt = 0;
  
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
      echo '<script type="text/javascript">
      $(document).ready(function(){
        let feedback =  document.getElementById("feedback").value;
          swal({
              type: "success",
              title: "Success",
              text: feedback,
              showConfirmButton: true,
              timer: 7000
          })
      });
      </script>
      ';
      $_SESSION["lack_of_intfund_$key"] = 0;
    }
  } else if (isset($_GET["message1"])) {
    $key = $_GET["message1"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
      echo '<script type="text/javascript">
      $(document).ready(function(){
        let feedback =  document.getElementById("feedback").value;
          swal({
              type: "error",
              title: "Error",
              text: feedback,
              showConfirmButton: true,
              timer: 7000
          })
      });
      </script>
      ';
      $_SESSION["lack_of_intfund_$key"] = 0;
    }
  }

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
                    <a class="nav-link" href="#messages" data-toggle="tab">
                      <i class="material-icons">supervisor_account</i> Pending SMS
                      <div class="ripple-container"></div>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#perform" data-toggle="tab">
                      <i class="material-icons">supervisor_account</i> Sent SMS
                      <div class="ripple-container"></div>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#analysis" data-toggle="tab">
                      <i class="material-icons">supervisor_account</i> Delivered SMS
                      <div class="ripple-container"></div>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#structure" data-toggle="tab">
                      <i class="material-icons">supervisor_account</i> Failed SMS
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
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalLong">
                  Send Bulk SMS
                </button>
                <?php include("items/campaign.php"); ?>
                <!-- items report -->
              </div>
              <!-- bul sms -->


              <!-- Modal -->
              <form action="../functions/notifications/sms/bulk_sms.php" method="post" autocomplete="off">
                <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">BULK SMS </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                         
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="shortSharesName">Message <span style="color: red;">*</span></label>
                              <textarea name="message" id="message" cols="30" rows="5" class="form-control" required></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                    </div>

                  </div>
                </div>
              </form>
              <!-- test SMS -->

              <!-- ebd SMS test -->
              <!-- /items report-->
              <div class="tab-pane" id="messages">
                <!-- <a href="create_charge.php" class="btn btn-primary"> Schedule of Deposit Structure and Maturity Profile</a> -->
                <?php include("items/pending_sms.php"); ?>
              </div>
              <div class="tab-pane" id="perform">
                <!-- <a href="create_charge.php" class="btn btn-primary"> Schedule of Deposit Structure and Maturity Profile</a> -->
                <?php include("items/sent_sms.php"); ?>
              </div>
              <div class="tab-pane" id="analysis">
                <!-- <a href="create_charge.php" class="btn btn-primary"> Schedule of Deposit Structure and Maturity Profile</a> -->
                <?php include("items/delivered_sms.php"); ?>
              </div>
              <div class="tab-pane" id="structure">
                <!-- <a href="create_charge.php" class="btn btn-primary"> Schedule of Deposit Structure and Maturity Profile</a> -->
                <?php include("items/failed_sms.php"); ?>
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