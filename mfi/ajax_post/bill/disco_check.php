<?php
// making a good move
include("../../../functions/connect.php");
// porty
session_start();
$int_id = $_SESSION["int_id"];
$branch_id = $_SESSION["branch_id"];
$disco = $_POST["disco"];
$meter = $_POST["meter"];
$dis_type = $_POST["dis_type"];
// MAD
$digits = 9;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
// end the code
// end
if ($disco != "" && $meter != "" && $int_id != "" && $branch_id != "") {
    // finnin
    $sql_fund = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$int_id' AND branch_id = '$branch_id'");
        $qw = mysqli_fetch_array($sql_fund);
        $balance = $qw["running_balance"];
        $total_with = $qw["total_withdrawal"];
        $total_int_profit = $qw["int_profit"];
        $total_sekani_charge = $qw["sekani_charge"];
        $total_merchant_charge = $qw["merchant_charge"];
        // test
        if ($balance == $balance) {
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
  CURLOPT_POSTFIELDS =>"{\r\n\"serviceCode\" : \"AOV\",\r\n\"disco\" : \"$disco\",\r\n\"meterNo\": \"$meter\",\r\n\"type\" : \"$dis_type\"\r\n}",
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
$customer = $obj['customerName'];
$customerAddress = $obj['customerAddress'];
$customerDistrict = $obj['customerDistrict'];
$phoneNumber = $obj['phoneNumber'];
// make a move
if ($status == "200" && $status != "") {
        // echo $someArray[0]["code"];
    ?>
    <div class="row">
    <div class="col-md-12">
            <div class="form-group">
               <label class="bmd-label-floating" style="color: white;">Amount</label>
               <input type = "text" value="" id="amount" style="color: white;" class="form-control" name = ""/>
              </div>
    </div>
    <div class="col-md-12">
            <div class="form-group">
               <label class="bmd-label-floating" style="color: white;">Customer Name</label>
               <input type = "text" style="color: black;" value="<?php echo $customer ?>" id="name" class="form-control" name = "" readonly/>
              </div>
    </div>
    <!-- ow te script -->
    <div class="col-md-12">
            <div class="form-group">
               <label class="bmd-label-floating" style="color: white;">Customer Phone</label>
               <input type = "text" style="color: white;" value="<?php echo $phoneNumber ?>" id="phonenumber" class="form-control" name = ""/>
              </div>
    </div>
    <!-- DATA respomze -->
    <div class="col-md-12">
            <div class="form-group">
               <label class="bmd-label-floating" style="color: white;">Customer Address</label>
               <input type = "text" style="color: white;" value="<?php echo $customerAddress ?>" id="customerAddress" class="form-control" name = ""/>
              </div>
    </div>
    </div>
    <?php
    
} else {
    echo "Finding User..." ;
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