<?php
include("../../../functions/connect.php");
// FIRST GET THE POSTED DATA
// CHECK IF LENGTH IS UP TO ELEVEN - YES(CONTINUE) / NO(KEEP CHECKING)
// CHECK IF THE BVN EXIST - YES (OUTPUT ERROR, DONT SUBMIT FORM) / NO (CONTINUE)
// CHECK BVN AND GET OUTPUT
// MATCH OUT PUT DATA
<<<<<<< HEAD
if (isset($_POST["int_id"])) {
  // check the length
  $int_id = $_POST["int_id"];
  $branch_id = $_POST["branch_id"];
  // echo $int_id;
  $bvn = $_POST["bvn"];
  $dob = $_POST["dob"];
  $check_DOB = date('d-M-y', strtotime($dob));
  // echo "$check_DOB";
  $first = strtoupper($_POST["first"]);
  $last = strtoupper($_POST["last"]);
  $phone = $_POST["phone"];
  // MAKE A NEW MOVE
  $token_key = "15314b54abb9e8705358c0f6e0e50f956f46564b5fd17a598e9c0f591feb0d469c10" . $bvn;
  // token harsh key generation
  $token_hash = hash('sha256', $token_key);
  // echo $token_hash;
  // end token harsh
  // MOVING TO THE NEXT
  $bvn_length = strlen($bvn);
  // CHECK
  if ($bvn_length == 11) {
    // check if it exsit
    $sql_check = mysqli_query($connection, "SELECT * FROM client WHERE BVN = '$bvn' AND int_id = '$int_id'");
    if (mysqli_num_rows($sql_check) <= 0 && $bvn != "") {
      // next code 
      // check if there is fund in the acoint
      $sql_fund = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$int_id'");
      $qw = mysqli_fetch_array($sql_fund);
      // $balance = $qw["bvn_balance"];
      $balance = 50;
      $total_with = $qw["total_withdrawal"];
      $total_int_profit = $qw["int_profit"];
      $total_sekani_charge = $qw["sekani_charge"];
      $total_merchant_charge = $qw["merchant_charge"];
      if ($balance >= 50) {
        // BIG CODE START BVN PAYSTACK VERIFICATION
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://confirmme.com/api/verifybvn?bvn=' . $bvn . '',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'CLIENTID: 1531',
            'HASHTOKEN: ' . $token_hash . ''
          ),
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);
        // curl_close($curl);

        if ($err) {
          //    echo "cURL Error #:" . $err;
          echo '<script type="text/javascript">
=======
if ($_POST["dob"] != "" && $_POST["first"] != "" && $_POST["last"] != "" && $_POST["phone"] != "" && $_POST["int_id"]) {
// check the length
$int_id = $_POST["int_id"];
$branch_id = $_POST["branch_id"];
// echo $int_id;
$bvn = $_POST["bvn"];
$dob = $_POST["dob"];
$check_DOB = date('d-M-y', strtotime($dob));
// echo "$check_DOB";
$first = strtoupper($_POST["first"]); 
$last = strtoupper($_POST["last"]); 
$phone = $_POST["phone"];
// MAKE A NEW MOVE
$token_key = "15314b54abb9e8705358c0f6e0e50f956f46564b5fd17a598e9c0f591feb0d469c10".$bvn;
// token harsh key generation
$token_hash = hash('sha256', $token_key);
// echo $token_hash;
// end token harsh
// MOVING TO THE NEXT
$bvn_length = strlen($bvn);
// CHECK
if ($bvn_length == 11) {
    // check if it exsit
    $sql_check = mysqli_query($connection, "SELECT * FROM client WHERE BVN = '$bvn' AND int_id = '$int_id'");
    if (mysqli_num_rows($sql_check) <= 0 && $bvn != "") {
        // next code 
        // check if there is fund in the acoint
        $sql_fund = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$int_id'");
        $qw = mysqli_fetch_array($sql_fund);
        $balance = $qw["bvn_balance"];
        $total_with = $qw["total_withdrawal"];
        $total_int_profit = $qw["int_profit"];
        $total_sekani_charge = $qw["sekani_charge"];
        $total_merchant_charge = $qw["merchant_charge"];
        if ($balance >= 50) {
            // BIG CODE START BVN PAYSTACK VERIFICATION
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://confirmme.com/api/verifybvn?bvn='.$bvn.'',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
              CURLOPT_HTTPHEADER => array(
                'CLIENTID: 1531',
                'HASHTOKEN: '.$token_hash.''
              ),
            ));
            
            $response = curl_exec($curl);
            
        $err = curl_error($curl);
        // curl_close($curl);
  
        if ($err) {
        //    echo "cURL Error #:" . $err;
        echo '<script type="text/javascript">
>>>>>>> Victor
        $(document).ready(function(){
            swal({
                type: "error",
                title: "CONNECTION ERROR",
                text: "TIMED OUT",
                showConfirmButton: false,
                timer: 3000
            })
            document.getElementById("cbvn").setAttribute("hidden", "");
            document.getElementById("wbvn").removeAttribute("hidden");
            $(":input[type=submit]").prop("disabled", true);
        });
        </script>
        ';
        } else {
<<<<<<< HEAD
          //    echo $response;
          $obj = json_decode($response, TRUE);
          $status = $obj['ResponseCode'];
          $bvn_fn = "";
          if ($status == "00") {
            $bvn_fn = $obj['Data']['FirstName'];
            $bvn_ln = $obj['Data']['LastName'];
            $bvn_dob = $obj['Data']['DateOfBirth'];
            $bvn_phone = $obj['Data']['PhoneNumber'];
            $bvn_bvn = $obj['Data']['BVN'];
            $bvn_gend = $obj['Data']['Gender'];
            $bvn_image = $obj['Data']['ImageBase64'];
          }
          //    echo $bvn_fn."firstname".$bvn_ln."Lastname".$dob."DATE OF BIRTH";
          if ($bvn_dob == $check_DOB && $bvn_phone == $phone) {
            // BVN VERIFIED
            // UPDATE THE WITHDRAWAL
            // CALCULATION
            $cal_bal = $balance - 50;
            $cal_with = $total_with + 50;
            $cal_sek = $total_sekani_charge + 20;
            $cal_mch = $total_merchant_charge + 20;
            $cal_int_prof = $total_int_profit + 10;
            $digits = 9;
            $date = date("Y-m-d");
            $date2 = date('Y-m-d H:i:s');
            $randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
            $trans = "SKWAL" . $randms . "LET" . $int_id;
            $update_transaction = mysqli_query($connection, "UPDATE sekani_wallet SET bvn_balance = '$cal_bal', total_withdrawal = '$cal_with',
    int_profit = '$cal_int_prof', sekani_charge = '$cal_sek', merchant_charge = '$cal_mch' WHERE int_id = '$int_id' AND branch_id = '$branch_id'");
            if ($update_transaction) {
              // update
              $insert_transaction = mysqli_query($connection, "INSERT INTO `sekani_wallet_transaction` (`int_id`, `branch_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `wallet_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, 
=======
        //    echo $response;
           $obj = json_decode($response, TRUE);
           $status = $obj['ResponseCode'];
           $bvn_fn = "";
           if ($status == "00") {
           $bvn_fn = $obj['Data']['FirstName'];
           $bvn_ln = $obj['Data']['LastName'];
           $bvn_dob = $obj['Data']['DateOfBirth'];
           $bvn_phone = $obj['Data']['PhoneNumber'];
           $bvn_bvn = $obj['Data']['BVN'];
           $bvn_gend = $obj['Data']['Gender'];
           $bvn_image = $obj['Data']['ImageBase64'];
           }
        //    echo $bvn_fn."firstname".$bvn_ln."Lastname".$dob."DATE OF BIRTH";
        if ($bvn_dob == $check_DOB && $bvn_phone == $phone) {
            // BVN VERIFIED
    // UPDATE THE WITHDRAWAL
    // CALCULATION
    $cal_bal = $balance - 50;
    $cal_with = $total_with + 50;
    $cal_sek = $total_sekani_charge + 20;
    $cal_mch = $total_merchant_charge + 20;
    $cal_int_prof = $total_int_profit + 10;
    $digits = 9;
    $date = date("Y-m-d");
    $date2 = date('Y-m-d H:i:s');
    $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
    $trans = "SKWAL".$randms."LET".$int_id;
    $update_transaction = mysqli_query($connection, "UPDATE sekani_wallet SET bvn_balance = '$cal_bal', total_withdrawal = '$cal_with',
    int_profit = '$cal_int_prof', sekani_charge = '$cal_sek', merchant_charge = '$cal_mch' WHERE int_id = '$int_id' AND branch_id = '$branch_id'");
    if ($update_transaction) {
        // update
        $insert_transaction = mysqli_query($connection, "INSERT INTO `sekani_wallet_transaction` (`int_id`, `branch_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `wallet_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, 
>>>>>>> Victor
        `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`,
        `int_profit`, `sekani_charge`, `merchant_charge`)
         VALUES ('{$int_id}', '{$branch_id}', '{$trans}', 'BVN charge', 'bvn', NULL, '0', '{$date}', '50', '{$cal_bal}', '{$cal_bal}', {$date}, 
         NULL, NULL, '{$date2}', '0', '0.00', '50.00', '{$cal_int_prof}', '{$cal_sek}', '{$cal_mch}')");
<<<<<<< HEAD
              if ($insert_transaction) {
                //  echo remaining ending
                echo '<script type="text/javascript">
=======
         if ($insert_transaction) {
            //  echo remaining ending
            echo '<script type="text/javascript">
>>>>>>> Victor
            $(document).ready(function(){
                swal({
                    type: "success",
                    title: "BVN VERIFIED",
                    text: "Customers Data is Correct, and will be charged NGN 50.00",
                    showConfirmButton: false,
                    timer: 3000
                })
                document.getElementById("wbvn").setAttribute("hidden", "");
                document.getElementById("cbvn").removeAttribute("hidden");
                $(":input[type=submit]").prop("disabled", false);
                $("#myModal").modal("show");
            });
            </script>
            ';
<<<<<<< HEAD
?>
                <!-- popup -->
                <!-- QWERTY -->
                <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="card card-signup card-plain">
                        <div class="modal-header">
                          <h5 class="modal-title card-title">BVN CHECK</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="material-icons">clear</i>
                          </button>
                        </div>
                        <!-- chill -->
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-5 ml-auto">
                              <div class="info info-horizontal">
                                <div class="icon icon-rose">
                                  <i class="material-icons">timeline</i>
                                </div>
                                <div class="description">
                                  <h4 class="info-title">Customer Details</h4>
                                  <p class="description">
                                    First Name: <?php echo $bvn_fn; ?>
                                  </p>
                                  <p class="description">
                                    Last Name: <?php echo $bvn_ln; ?>
                                  </p>
                                  <p class="description">
                                    Phone: <?php echo $bvn_phone; ?>
                                  </p>
                                  <p class="description">
                                    Date of Birth: <?php echo $bvn_dob; ?>
                                  </p>
                                </div>
                              </div>
                            </div>
                            <!-- profile picture -->
                            <div class="col-md-5 mr-auto">
                              <img src="data:image/png;base64,<?php echo $bvn_image; ?>" alt="" srcset="" height="250px" width="250px">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- end popup -->
                <?php
              } else {
                //  echo wrong
                echo "WRONG TRANSACTION";
              }
            } else {
              // echo out a problem witht the 
              echo "WRONG UPDATE";
            }
            //  UPDATE THE ACCOUNT
            // TAKE QWERTY
          } else {
            // OUTPUT WRONG DATA, BVN NOT VERIFIED
            if ($status == false) {
              echo '<script type="text/javascript">
=======
            ?>
            <!-- popup -->
            <!-- QWERTY -->
            <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="card card-signup card-plain">
                      <div class="modal-header">
                      <h5 class="modal-title card-title">BVN CHECK</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">clear</i>
                    </button>
                 </div>
                 <!-- chill -->
                 <div class="modal-body">
          <div class="row">
            <div class="col-md-5 ml-auto">
              <div class="info info-horizontal">
                <div class="icon icon-rose">
                  <i class="material-icons">timeline</i>
                </div>
                <div class="description">
                  <h4 class="info-title">Customer Details</h4>
                  <p class="description">
                  First Name: <?php echo $bvn_fn; ?>
                  </p>
                  <p class="description">
                  Last Name: <?php echo $bvn_ln; ?>
                  </p>
                  <p class="description">
                  Phone: <?php echo $bvn_phone; ?>
                  </p>
                  <p class="description">
                  Date of Birth: <?php echo $bvn_dob; ?>
                  </p>
                </div>
              </div>
            </div>
            <!-- profile picture -->
            <div class="col-md-5 mr-auto">
                <img src="data:image/png;base64,<?php echo $bvn_image; ?>" alt="" srcset="" height="250px" width="250px">
            </div>
          </div>
                </div>
              </div>
             </div>
            </div>
            </div>
            <!-- end popup -->
            <?php
         } else {
            //  echo wrong
            echo "WRONG TRANSACTION";
         }
    } else {
        // echo out a problem witht the 
        echo "WRONG UPDATE";
    }
    //  UPDATE THE ACCOUNT
    // TAKE QWERTY
        } else {
            // OUTPUT WRONG DATA, BVN NOT VERIFIED
            if ($status == false) {
                echo '<script type="text/javascript">
>>>>>>> Victor
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "INSUFFICIENT FUND IN WALLET",
                        text: "Wallet Doesnt Have enough Fund",
                        showConfirmButton: false,
                        timer: 3000
                    });
                    document.getElementById("cbvn").setAttribute("hidden", "");
                    document.getElementById("wbvn").removeAttribute("hidden");
                    $(":input[type=submit]").prop("disabled", false);
                });
                </script>
                ';
<<<<<<< HEAD
              // TAKE YOUR CHARGE

              // RECORD THE TRANSACTION
              // KEEP IN THE GLS
            } else {
              // AIIT
              // CALCULATION
              $cal_bal = $balance - 50;
              $cal_with = $total_with + 50;
              $cal_sek = $total_sekani_charge + 20;
              $cal_mch = $total_merchant_charge + 20;
              $cal_int_prof = $total_int_profit + 10;
              $digits = 9;
              $date = date("Y-m-d");
              $date2 = date('Y-m-d H:i:s');
              $randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
              $trans = "SKWAL" . $randms . "LET" . $int_id;
              $update_transaction = mysqli_query($connection, "UPDATE sekani_wallet SET bvn_balance = '$cal_bal', total_withdrawal = '$cal_with',
    int_profit = '$cal_int_prof', sekani_charge = '$cal_sek', merchant_charge = '$cal_mch' WHERE int_id = '$int_id' AND branch_id = '$branch_id'");
              if ($update_transaction) {
                // update
                $insert_transaction = mysqli_query($connection, "INSERT INTO `sekani_wallet_transaction` (`int_id`, `branch_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `wallet_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, 
=======
                // TAKE YOUR CHARGE
                
                // RECORD THE TRANSACTION
                // KEEP IN THE GLS
            } else {
                // AIIT
                  // CALCULATION
    $cal_bal = $balance - 50;
    $cal_with = $total_with + 50;
    $cal_sek = $total_sekani_charge + 20;
    $cal_mch = $total_merchant_charge + 20;
    $cal_int_prof = $total_int_profit + 10;
    $digits = 9;
    $date = date("Y-m-d");
    $date2 = date('Y-m-d H:i:s');
    $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
    $trans = "SKWAL".$randms."LET".$int_id;
    $update_transaction = mysqli_query($connection, "UPDATE sekani_wallet SET bvn_balance = '$cal_bal', total_withdrawal = '$cal_with',
    int_profit = '$cal_int_prof', sekani_charge = '$cal_sek', merchant_charge = '$cal_mch' WHERE int_id = '$int_id' AND branch_id = '$branch_id'");
    if ($update_transaction) {
        // update
        $insert_transaction = mysqli_query($connection, "INSERT INTO `sekani_wallet_transaction` (`int_id`, `branch_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `wallet_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, 
>>>>>>> Victor
        `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`,
        `int_profit`, `sekani_charge`, `merchant_charge`)
         VALUES ('{$int_id}', '{$branch_id}', '{$trans}', 'BVN charge', 'bvn', NULL, '0', '{$date}', '50', '{$cal_bal}', '{$cal_bal}', {$date}, 
         NULL, NULL, '{$date2}', '0', '0.00', '50.00', '{$cal_int_prof}', '{$cal_sek}', '{$cal_mch}')");
<<<<<<< HEAD
                if ($insert_transaction) {
                  //  echo remaining ending
                  echo '<script type="text/javascript">
=======
         if ($insert_transaction) {
            //  echo remaining ending
            echo '<script type="text/javascript">
>>>>>>> Victor
    $(document).ready(function(){
        swal({
            type: "error",
            title: "WRONG BVN DATA FORMAT",
            text: "BVN not Verified, check the data provided - Firstname, Lastname, Phone Number and Date of Birth",
            showConfirmButton: false,
            timer: 3000
        });
        document.getElementById("cbvn").setAttribute("hidden", "");
        document.getElementById("wbvn").removeAttribute("hidden");
        $(":input[type=submit]").prop("disabled", true);
    });
    </script>
    ';
<<<<<<< HEAD
                  // DISPLAY DATA
                ?>
                  <?php
                  if ($bvn_bvn == $bvn) {
                  ?>
                    <input type="text" id="fnx" value="<?php echo $bvn_fn; ?>" hidden>
                    <input type="text" id="lnx" value="<?php echo $bvn_ln; ?>" hidden>
                    <input type="text" id="phx" value="<?php echo $bvn_phone; ?>" hidden>
                    <input type="text" id="dobx" value="<?php echo $bvn_dob; ?>" hidden>
                    <script>
                      $(document).ready(function() {
                        var qfn = $('#fnx').val();
                        var qln = $('#lnx').val();
                        var qph = $('#phx').val();
                        var qdob = $('#dobx').val();
                        $('#first').val(qfn);
                        $('#last').val(qln);
                        $('#phone').val(qph);
                        $('#dob').val(qdob);
                        // output something
                        swal({
                          type: "success",
                          title: "DATA REFILL",
                          text: "DATA HAS BEEN REFILLED",
                          showConfirmButton: false,
                          timer: 3000
                        });
                        document.getElementById("wbvn").setAttribute("hidden", "");
                        document.getElementById("cbvn").removeAttribute("hidden");
                        $(":input[type=submit]").prop("disabled", false);
                        document.getElementById("bvn_on_meet").setAttribute("hidden", "");
                        $("#myModal").modal("show");
                      });
                    </script>
                    <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="card card-signup card-plain">
                            <div class="modal-header">
                              <h5 class="modal-title card-title">BVN CHECK</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="material-icons">clear</i>
                              </button>
                            </div>
                            <!-- chill -->
                            <div class="modal-body">
                              <div class="row">
                                <div class="col-md-5 ml-auto">
                                  <div class="info info-horizontal">
                                    <div class="icon icon-rose">
                                      <i class="material-icons">timeline</i>
                                    </div>
                                    <div class="description">
                                      <h4 class="info-title">Customer Details</h4>
                                      <p class="description">
                                        First Name: <?php echo $bvn_fn; ?>
                                      </p>
                                      <p class="description">
                                        Last Name: <?php echo $bvn_ln; ?>
                                      </p>
                                      <p class="description">
                                        Phone: <?php echo $bvn_phone; ?>
                                      </p>
                                      <p class="description">
                                        Date of Birth: <?php echo $bvn_dob; ?>
                                      </p>
                                    </div>
                                  </div>
                                </div>
                                <!-- profile picture -->
                                <div class="col-md-5 mr-auto">
                                  <div class="image-box">
                                    <img src="data:image/png;base64,<?php echo $bvn_image; ?>" alt="" srcset="" height="400px" width="400px">
                                  </div>
                                </div>
                                <style>
                                  img {
                                    max-width: 100%;
                                    max-height: 100%;
                                    object-fit: contain;
                                  }

                                  .image-box {
                                    height: 444px;
                                    width: 770px;
                                  }
                                </style>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php
                  } else {
                    echo '<script type="text/javascript">
=======
    // DISPLAY DATA
    ?> 
    <?php
    if ($bvn_bvn == $bvn) {
        ?>
<input type="text" id="fnx" value="<?php echo $bvn_fn;?>" hidden>
    <input type="text" id="lnx" value="<?php echo $bvn_ln;?>" hidden>
    <input type="text" id="phx" value="<?php echo $bvn_phone;?>" hidden>
    <input type="text" id="dobx" value="<?php echo $bvn_dob;?>" hidden>
    <script>
       $(document).ready(function(){ 
           var qfn = $('#fnx').val();
           var qln = $('#lnx').val();
           var qph = $('#phx').val();
           var qdob = $('#dobx').val();
        $('#first').val(qfn);
        $('#last').val(qln);
        $('#phone').val(qph);
        $('#dob').val(qdob);
        // output something
        swal({
            type: "success",
            title: "DATA REFILL",
            text: "DATA HAS BEEN REFILLED",
            showConfirmButton: false,
            timer: 3000
        });
        document.getElementById("wbvn").setAttribute("hidden", "");
        document.getElementById("cbvn").removeAttribute("hidden");
        $(":input[type=submit]").prop("disabled", false);
        document.getElementById("bvn_on_meet").setAttribute("hidden", "");
        $("#myModal").modal("show");
       });
    </script>
    <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="card card-signup card-plain">
                      <div class="modal-header">
                      <h5 class="modal-title card-title">BVN CHECK</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="material-icons">clear</i>
                    </button>
                 </div>
                 <!-- chill -->
                 <div class="modal-body">
          <div class="row">
            <div class="col-md-5 ml-auto">
              <div class="info info-horizontal">
                <div class="icon icon-rose">
                  <i class="material-icons">timeline</i>
                </div>
                <div class="description">
                  <h4 class="info-title">Customer Details</h4>
                  <p class="description">
                  First Name: <?php echo $bvn_fn; ?>
                  </p>
                  <p class="description">
                  Last Name: <?php echo $bvn_ln; ?>
                  </p>
                  <p class="description">
                  Phone: <?php echo $bvn_phone; ?>
                  </p>
                  <p class="description">
                  Date of Birth: <?php echo $bvn_dob; ?>
                  </p>
                </div>
              </div>
            </div>
            <!-- profile picture -->
            <div class="col-md-5 mr-auto">
              <div class="image-box">
              <img src="data:image/png;base64,<?php echo $bvn_image; ?>" alt="" srcset="" height="400px" width="400px">
              </div>
            </div>
            <style>
            img {
max-width: 100%;
max-height: 100%;
object-fit: contain;
}
.image-box {
height: 444px;
width: 770px;
}
        </style>
          </div>
                </div>
              </div>
             </div>
            </div>
            </div>
        <?php
    } else {
        echo '<script type="text/javascript">
>>>>>>> Victor
        $(document).ready(function(){
            swal({
                type: "error",
                title: "BVN doesnt match",
                text: "no match for bvn",
                showConfirmButton: false,
                timer: 3000
            });
            document.getElementById("cbvn").setAttribute("hidden", "");
            document.getElementById("wbvn").removeAttribute("hidden");
            $(":input[type=submit]").prop("disabled", true);
        });
        </script>
        ';
<<<<<<< HEAD
                  }
                  ?>
                  <script>
                    $(document).ready(function() {
                      var fn_con = $("#f_n_com").val();
                      var ln_con = $("#l_n_com").val();
                      var phone_con = $("#phone_com").val();
                      if (fn_con != "" && phone_con != "" && ln_con != "") {
                        $("#first").val(fn_con);
                        $("#last").val(ln_con);
                        $("#phone").val(phone_con);
                        // activate button
                        $("#submit").prop("disabled", false);
                      } else {
                        // move
                        // $("#net_com").val("please input missing field");
                        // $("#phone_com").val("please input missing field");
                        // $("#amt_com").val("please input missing field");
                        // deactivate button
                        $("#submit").prop("disabled", true);
                      }
                    });
                  </script>
<?php
                } else {
                  //  echo wrong
                  echo "WRONG TRANSACTION";
                }
              } else {
                // echo out a problem witht the 
                echo "WRONG UPDATE";
              }
              // NOW TAKE CHARGE
            }
          }
        }
      } else {
        // echo insufficient fund
        echo '<script type="text/javascript">
=======
    }
    ?>
  <script>
              $(document).ready(function() {
                  var fn_con = $("#f_n_com").val();
                  var ln_con = $("#l_n_com").val();
                  var phone_con = $("#phone_com").val();
                  if (fn_con != "" && phone_con != "" && ln_con != "") {
                    $("#first").val(fn_con);
                    $("#last").val(ln_con);
                    $("#phone").val(phone_con);
                    // activate button
                    $("#submit").prop("disabled", false);
                  } else {
                    // move
                    // $("#net_com").val("please input missing field");
                    // $("#phone_com").val("please input missing field");
                    // $("#amt_com").val("please input missing field");
                    // deactivate button
                    $("#submit").prop("disabled", true);
                  }
              });
            </script>
    <?php
         } else {
            //  echo wrong
            echo "WRONG TRANSACTION";
         }
    } else {
        // echo out a problem witht the 
        echo "WRONG UPDATE";
    }
    // NOW TAKE CHARGE
}
        }
        }
        } else {
            // echo insufficient fund
            echo '<script type="text/javascript">
>>>>>>> Victor
    $(document).ready(function(){
        swal({
            type: "error",
            title: "INSUFFICIENT FUND",
            text: "Fund your Institution Sekani Wallet",
            showConfirmButton: false,
            timer: 3000
        });
        document.getElementById("cbvn").setAttribute("hidden", "");
        document.getElementById("wbvn").removeAttribute("hidden");
        $(":input[type=submit]").prop("disabled", true);
    });
    </script>
    ';
<<<<<<< HEAD
      }
      // END OF PAYSACK BVN VERIFICATION
    } else {
      echo "<span style='color: red'>THIS CLIENT EXIST</span>";
      // STOP FORM FROM SUBMITTING
      echo '<script type="text/javascript">
=======
        }
        // END OF PAYSACK BVN VERIFICATION
    } else {
        echo "<span style='color: red'>THIS CLIENT EXIST</span>";
        // STOP FORM FROM SUBMITTING
        echo '<script type="text/javascript">
>>>>>>> Victor
        $(document).ready(function(){
            swal({
                type: "error",
                title: "CLIENT EXIST",
                text: "Check if the client has been rejected or Pending approval",
                showConfirmButton: false,
                timer: 3000
            })
            document.getElementById("cbvn").setAttribute("hidden", "");
            document.getElementById("wbvn").removeAttribute("hidden");
            $(":input[type=submit]").prop("disabled", true);
        });
        </script>
        ';
    }
<<<<<<< HEAD
  } else {
=======
} else {
>>>>>>> Victor
    // bvn not up to eleven
    echo "<span style='color:red'>BVN NOT UP TO ELEVEN NUMBERS</span>";
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "MORE OR NOT UP TO ELEVEN NUMBERS",
            text: "Check the BVN length",
            showConfirmButton: false,
            timer: 3000
        })
        document.getElementById("cbvn").setAttribute("hidden", "");
        document.getElementById("wbvn").removeAttribute("hidden");
        $(":input[type=submit]").prop("disabled", true);
    });
    </script>
    ';
<<<<<<< HEAD
  }
} else {
  echo '<script type="text/javascript">
=======
}
} else {
    echo '<script type="text/javascript">
>>>>>>> Victor
    $(document).ready(function(){
        swal({
            type: "error",
            title: "FILL DATA PROPERLY",
            text: "Please check if FirstName, LastName, Date of Birth and Phone Number field has been filled correctly",
            showConfirmButton: false,
            timer: 5000
        });
        $(":input[type=submit]").prop("disabled", true);
    });
    </script>
    ';
<<<<<<< HEAD
  // STOP THE FORM
=======
    // STOP THE FORM
>>>>>>> Victor
}
?>