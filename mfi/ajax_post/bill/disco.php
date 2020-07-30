<?php
// making a good move
include("../../../functions/connect.php");
// porty
session_start();
$int_id = $_SESSION["int_id"];
$int_name = $_SESSION["int_name"];
$branch_id = $_SESSION["branch_id"];
$sender_id = $_SESSION["sender_id"];
$disco = $_POST["disco"];
$meter = $_POST["meter"];
$phonenumber = $_POST["phone"];
$type = $_POST["dis_type"];
$amount = $_POST["amt"];
$name = $_POST["name"];
$address = $_POST["address"];
// MAD
$digits = 9;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
// end the code
// end
if ($disco != "" && $meter != "" && $amount != "" && $int_id != "" && $branch_id != "") {
    // finnin
    $sql_fund = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$int_id' AND branch_id = '$branch_id'");
        $qw = mysqli_fetch_array($sql_fund);
        $balance = $qw["running_balance"];
        $total_with = $qw["total_withdrawal"];
        $total_int_profit = $qw["int_profit"];
        $total_sekani_charge = $qw["sekani_charge"];
        $total_merchant_charge = $qw["merchant_charge"];
        // test
        if ($balance >= $amount) {
            // STAT API
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://shagopayments.com/api/live/b2b",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS =>"{\r\n\"serviceCode\" : \"AOB\",\r\n\"disco\" : \"$disco\",\r\n\"meterNo\": \"$meter\",\r\n\"type\" : \"$type\",\r\n\"amount\": \"$amount\",\r\n\"phonenumber\": \"$phonenumber\",\r\n\"name\": \"$name\",\r\n\"address\":\"$address\",\r\n\"request_id\" : \"$randms\"\r\n}",
              CURLOPT_HTTPHEADER => array(
                "hashKey: ddceb2126614e2b4aec6d0d247e17f746de538fef19311cc4c3471feada85d30",
                "Content-Type: application/json"
              ),
            ));
            
            $response = curl_exec($curl);  
$err = curl_close($curl);
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
    echo "NO INTERNET CONNECTION";
    } else {
        // echo $response;
        // make 
$obj = json_decode($response, TRUE);
$status = $obj['status'];
$msg = $obj['message'];
// repsonse working up.
$token = $obj['token'];
$unit = $obj['unit'];
$taxAmount = $obj['taxAmount'];
$bonusUnit = $obj['bonusUnit'];
$bonusToken = $obj['bonusToken'];
$disco = $obj['disco'];
$transId = $obj['transId'];
// make a move | qwerty
if ($status == "200" && $status != "") {
    // alright
    $cal_bal = $balance - $amount;
    $cal_with = $total_with + $amount;
    $cal_sek = $total_sekani_charge + 0;
    $cal_mch = $total_merchant_charge + $amount;
    $cal_int_prof = $total_int_profit + 0;
    $digits = 9;
    $date = date("Y-m-d");
    $date2 = date('Y-m-d H:i:s');
    $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
    $trans = "SKWAL".$randms."DISCO".$int_id;
    // GD
    $update_transaction = mysqli_query($connection, "UPDATE sekani_wallet SET running_balance = '$cal_bal', total_withdrawal = '$cal_with',
    int_profit = '$cal_int_prof', sekani_charge = '$cal_sek', merchant_charge = '$cal_mch' WHERE int_id = '$int_id' AND branch_id = '$branch_id'");
    if ($update_transaction) {
        // WE ARE DONE
        $insert_transaction = mysqli_query($connection, "INSERT INTO `sekani_wallet_transaction` (`int_id`, `branch_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `wallet_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, 
        `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`,
        `int_profit`, `sekani_charge`, `merchant_charge`)
         VALUES ('{$int_id}', '{$branch_id}', '{$trans}', 'TOKEN: $token, Disco: $disco, Meter: $meter', 'bill_disco', NULL, '0', '{$date}', '{$amount}', '{$cal_bal}', '{$cal_bal}', {$date}, 
         NULL, NULL, '{$date2}', '0', '0.00', '{$amount}', '{$cal_int_prof}', '{$cal_sek}', '{$cal_mch}')");
         if ($insert_transaction) {
            //  go withdra
            echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "success",
            title: "Paid - '.$msg.'",
            text: "TOKEN: '.$token.'",
            showConfirmButton: false,
            timer: 3000
        });
    });
    </script>
    ';
    ?>
    <input type="text" id="int_id" value="<?php echo $int_id;?>" hidden>
    <input type="text" id="branch_id" value="<?php echo $branch_id;?>" hidden>
    <input type="text" id="sender_id" value="<?php echo $sender_id;?>" hidden>
    <input type="text" id="phone" value="<?php echo $phonenumber;;?>" hidden>
    <input type="text" id="client_id" value="<?php echo "0";?>" hidden>
    <input type="text" id="account_no" value="<?php echo "0";?>" hidden>
    <input type="text" id="s_amount" value="<?php echo $amount; ?>" hidden>
    <input type="text" id="s_token" value="<?php echo $token; ?>" hidden>
    <input type="text" id="s_meter" value="<?php echo $meter; ?>" hidden>
    <input type="text" id="s_disco" value="<?php echo $disco; ?>" hidden>
    <input type="text" id="s_int_name" value="<?php echo $int_name; ?>" hidden>
    <input type="text" id="s_date" value="<?php echo $date; ?>" hidden>
    <script>
    $(document).ready(function() {
                    var int_id = $('#int_id').val();
                    var branch_id = $('#branch_id').val();
                    var sender_id = $('#sender_id').val();
                    var phone = $('#phone').val();
                    var client_id = $('#client_id').val();
                    var account_no = $('#account_no').val();
                    // function
                    var amount = $('#s_amount').val();
                    var int_name = $('#s_int_name').val();
                    var date = $('#s_date').val();
                    // Dt
                    var token = $('#s_token').val();
                    var disco = $('#s_disco').val();
                    var meter = $('#s_meter').val();
                    // now we work on the body.
                    var msg = int_name+" "+"Disco"+" \n" + "TOKEN: "+token+" \n DISCO: "+acct_no+"\nMETER: "+meter+" \nDate: "+date+"\nThanks!";
                    $.ajax({
                      url:"ajax_post/sms/sms.php",
                      method:"POST",
                      data:{int_id:int_id, branch_id:branch_id, sender_id:sender_id, phone:phone, msg:msg, client_id:client_id, account_no:account_no },
                      success:function(data){
                        $('#make_display').html(data);
                      }
                    });
                });
    </script>
    <div id="make_display"></div>
    <?php
         } else {
            //  NOTHING AT ALL
            echo "ERROR IN TRANSACTION";
         }
    } else {
        // NOTHING AT ALL
        echo "ERROR IN WALLET";
    }
} else {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "Error Message - '.$msg.'",
            text: "DATA ERROR",
            showConfirmButton: false,
            timer: 5000
        });
    });
    </script>
    ';
}
    }
        } else {
            echo '<script type="text/javascript">
            $(document).ready(function(){
                swal({
                    type: "error",
                    title: "INSUFFICIENT FUND",
                    text: "REFILL YOUR WALLET",
                    showConfirmButton: false,
                    timer: 3000
                });
            });
            </script>
            ';
        }
}
?>