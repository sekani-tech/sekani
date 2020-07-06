<?php
include("../../../functions/connect.php");
// FIRST GET THE POSTED DATA
// CHECK IF LENGTH IS UP TO ELEVEN - YES(CONTINUE) / NO(KEEP CHECKING)
// CHECK IF THE BVN EXIST - YES (OUTPUT ERROR, DONT SUBMIT FORM) / NO (CONTINUE)
// CHECK BVN AND GET OUTPUT
// MATCH OUT PUT DATA
if ($_POST["dob"] != "" && $_POST["first"] != "" && $_POST["last"] != "" && $_POST["phone"] != "" && $_POST["int_id"]) {
// check the length
$int_id = $_POST["int_id"];
$branch_id = $_POST["branch_id"];
// echo $int_id;
$bvn = $_POST["bvn"];
$dob = $_POST["dob"];
$check_DOB = date('d-F-y', strtotime($dob));
// echo "$check_DOB";
$first = strtoupper($_POST["first"]); 
$last = strtoupper($_POST["last"]); 
$phone = $_POST["phone"]; 
// MOVING TO THE NEXT
$bvn_length = strlen($bvn);
// CHECK
if ($bvn_length == 11) {
    // check if it exsit
    $sql_check = mysqli_query($connection, "SELECT * FROM client WHERE BVN = '$bvn' AND int_id = '$int_id'");
    if (mysqli_num_rows($sql_check) <= 0) {
        // next code 
        // check if there is fund in the acoint
        $sql_fund = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$int_id' AND branch_id = '$branch_id'");
        $qw = mysqli_fetch_array($sql_fund);
        $balance = $qw["running_balance"];
        $total_with = $qw["total_withdrawal"];
        $total_int_profit = $qw["int_profit"];
        $total_sekani_charge = $qw["sekani_charge"];
        $total_merchant_charge = $qw["merchant_charge"];
        if ($balance >= 50) {
            // BIG CODE START BVN PAYSTACK VERIFICATION
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.paystack.co/bank/resolve_bvn/$bvn",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "Authorization: Bearer sk_live_626100308622d4ecd00a6bcf0a95d1b452b9306a",
          "Cache-Control: no-cache",
        ),
        ));
  
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
  
        if ($err) {
        //    echo "cURL Error #:" . $err;
        echo '<script type="text/javascript">
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
           echo $response;
           $obj = json_decode($response, TRUE);
           $status = $obj['status'];
           $bvn_fn = "";
           if ($status != false) {
           $bvn_fn = $obj['data']['first_name'];
           $bvn_ln = $obj['data']['last_name'];
           $bvn_dob = $obj['data']['formatted_dob'];
           $bvn_phone = $obj['data']['mobile'];
           $bvn_bvn = $obj['data']['bvn'];
           }
        //    echo $bvn_fn."firstname".$bvn_ln."Lastname".$dob."DATE OF BIRTH";
        if ($bvn_fn == $first && $bvn_ln == $last && $bvn_dob == $dob && $bvn_phone == $phone) {
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
    $update_transaction = mysqli_query($connection, "UPDATE sekani_wallet SET running_balance = '$cal_bal', total_withdrawal = '$cal_with',
    int_profit = '$cal_int_prof', sekani_charge = '$cal_sek', merchant_charge = '$cal_mch' WHERE int_id = '$int_id' AND branch_id = '$branch_id'");
    if ($update_transaction) {
        // update
        $insert_transaction = mysqli_query($connection, "INSERT INTO `sekani_wallet_transaction` (`int_id`, `branch_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `wallet_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, 
        `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`,
        `int_profit`, `sekani_charge`, `merchant_charge`)
         VALUES ('{$int_id}', '{$branch_id}', '{$trans}', 'BVN charge', 'bvn', NULL, '0', '{$date}', '50', '{$cal_bal}', '{$cal_bal}', {$date}, 
         NULL, NULL, '{$date2}', '0', '0.00', '50.00', '{$cal_int_prof}', '{$cal_sek}', '{$cal_mch}')");
         if ($insert_transaction) {
            //  echo remaining ending
            echo '<script type="text/javascript">
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
            });
            </script>
            ';
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
                    $(":input[type=submit]").prop("disabled", true);
                });
                </script>
                ';
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
    $update_transaction = mysqli_query($connection, "UPDATE sekani_wallet SET running_balance = '$cal_bal', total_withdrawal = '$cal_with',
    int_profit = '$cal_int_prof', sekani_charge = '$cal_sek', merchant_charge = '$cal_mch' WHERE int_id = '$int_id' AND branch_id = '$branch_id'");
    if ($update_transaction) {
        // update
        $insert_transaction = mysqli_query($connection, "INSERT INTO `sekani_wallet_transaction` (`int_id`, `branch_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `wallet_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, 
        `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`,
        `int_profit`, `sekani_charge`, `merchant_charge`)
         VALUES ('{$int_id}', '{$branch_id}', '{$trans}', 'BVN charge', 'bvn', NULL, '0', '{$date}', '50', '{$cal_bal}', '{$cal_bal}', {$date}, 
         NULL, NULL, '{$date2}', '0', '0.00', '50.00', '{$cal_int_prof}', '{$cal_sek}', '{$cal_mch}')");
         if ($insert_transaction) {
            //  echo remaining ending
            echo '<script type="text/javascript">
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
            type: "error",
            title: "DATA REFILL",
            text: "DATA HAS BEEN REFILLED",
            showConfirmButton: false,
            timer: 3000
        });
        document.getElementById("wbvn").setAttribute("hidden", "");
        document.getElementById("cbvn").removeAttribute("hidden");
        $(":input[type=submit]").prop("disabled", false);
        document.getElementById("bvn_on_meet").setAttribute("hidden", "");
       });
    </script>
        <?php
    } else {
        echo '<script type="text/javascript">
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
    }
    ?>
    <div class="card card-nav-tabs" style="width: 20rem;">
  <div class="card-header card-header-danger">
    Verifiy The Data
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">Firstname: <?php echo $bvn_fn;?></li>
    <li class="list-group-item">Lastname:<?php echo $bvn_ln;?></li>
    <li class="list-group-item">Phone: <?php echo $bvn_phone;?></li>
    <li class="list-group-item">DOB: <?php echo $bvn_dob;?></li>
  </ul>
</div>
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
        }
        // END OF PAYSACK BVN VERIFICATION
    } else {
        echo "<span style='color: red'>THIS CLIENT EXSIST</span>";
        // STOP FORM FROM SUBMITTING
        echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "error",
                title: "CLIENT EXSIST",
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
} else {
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
}
} else {
    echo '<script type="text/javascript">
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
    // STOP THE FORM
}
?>