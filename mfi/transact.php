<?php

$page_title = "Deposit/ Withdrwal";
$destination = "index.php";
include("header.php");
if (isset($_GET["message"])) {
    $key = $_GET["message"];
    $out = $_SESSION["lack_of_intfund_$key"];
    echo '<script type="text/javascript">';
    echo 'setTimeout(function () { swal("Done!", "'$out'", "success");';
    echo '}, 1000);</script>';
    $_SESSION["lack_of_intfund_$key"]; = null;
} else if (isset($_GET["message2"])) {
    $key = $_GET["message2"];
    $out = $_SESSION["lack_of_intfund_$key"];
    echo '<script type="text/javascript">';
    echo 'setTimeout(function () { swal("Done!", "'$out'", "success");';
    echo '}, 1000);</script>';
    $_SESSION["lack_of_intfund_$key"]; = null;
} else if (isset($_GET["message3"])) {
    $key = $_GET["message3"];
    $out = $_SESSION["lack_of_intfund_$key"];
    echo '<script type="text/javascript">';
    echo 'setTimeout(function () { swal("Done!", "'$out'", "success");';
    echo '}, 1000);</script>';
    $_SESSION["lack_of_intfund_$key"]; = null;
} else if (isset($_GET["message4"])) {
    $key = $_GET["message4"];
    $out = $_SESSION["lack_of_intfund_$key"];
    echo '<script type="text/javascript">';
    echo 'setTimeout(function () { swal("Done!", "'$out'", "success");';
    echo '}, 1000);</script>';
    $_SESSION["lack_of_intfund_$key"]; = null;
} else if (isset($_GET["message5"])) {
    $key = $_GET["message5"];
    $out = $_SESSION["lack_of_intfund_$key"];
    echo '<script type="text/javascript">';
    echo 'setTimeout(function () { swal("Done!", "'$out'", "success");';
    echo '}, 1000);</script>';
    $_SESSION["lack_of_intfund_$key"]; = null;
} else {
    echo "";
}
?>

<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
              <div class="col-md-12">
                  <div class="card">
                      <div class="card-header card-header-primary">
                        <h4 class="card-title">Deposit Cash</h4>
                        <!-- <p class="card-category">Fill in all important data</p> -->
                      </div>
                      <div class="card-body">
                          <form action="../functions/deposittrans.php" method="post">
                              <div class="row">
                                  <div class="col-md-4">
                                      <div class="form-group">
                                         <label class="bmd-label-floating">Account Number</label>
                                         <input type="text" class="form-control" name="test" hidden value="deposit">
                                         <input type="text" class="form-control" name="account_no" value="">
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                         <label class="bmd-label-floating">Amount</label>
                                         <input type="number" class="form-control" name="amount" value="">
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                         <label class="bmd-label-floating">Type</label>
                                         <input type="type" class="form-control" name="pay_type" value="Cash">
                                      </div>
                                  </div>
                              </div>
                              <button type="reset" class="btn btn-danger">Reset</button>
                              <button type="submit" class="btn btn-primary pull-right">Submit</button>
                              <div class="clearfix"></div>
                          </form>
                      </div>
                  </div>
              </div>
              <!-- sweet alert -->
              <!-- <button class="btn btn-primary btn-fill" onclick='swal({ title:"Good job!", text: "You clicked the button!", type: "success", buttonsStyling: false, confirmButtonClass: "btn btn-success"})'>Try me!</button> -->
              <div class="col-md-12">
                  <div class="card">
                  <div class="card-header card-header-primary">
                        <h4 class="card-title">Withdraw Cash</h4>
                        <!-- <p class="card-category">Fill in all important data</p> -->
                      </div>
                      <div class="card-body">
                        <form action="../functions/withdrawtrans.php" method="post">
                              <div class="row">
                                  <div class="col-md-4">
                                      <div class="form-group">
                                         <label class="bmd-label-floating">Account No</label>
                                         <input type="text" class="form-control" name="test2" hidden value="withdraw">
                                         <input type="text" class="form-control" name="account_no2" value="">
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                         <label class="bmd-label-floating">Amount</label>
                                         <input type="number" class="form-control" name="amount2" value="">
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                         <label class="bmd-label-floating">Type</label>
                                         <input type="type" class="form-control" name="pay_type2" value="Cheque">
                                      </div>
                                  </div>
                              </div>
                              <button type="reset" class="btn btn-danger">Reset</button>
                              <button type="submit" class="btn btn-primary pull-right">Submit</button>
                              <div class="clearfix"></div>
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