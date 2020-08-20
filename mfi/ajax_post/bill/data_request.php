<?php
// making a good move
include("../../../functions/connect.php");
// porty
session_start();
$int_id = $_SESSION["int_id"];
$branch_id = $_SESSION["branch_id"];
$network = $_POST["net"];
$phone = $_POST["phone"];
// MAD
$digits = 9;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
// end the code
// end
if ($network != "" && $phone != "" && $int_id != "" && $branch_id != "") {
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
  CURLOPT_POSTFIELDS =>"{\r\n\"serviceCode\" : \"VDA\",\r\n\"phone\" : \"$phone\",\r\n\"network\": \"$network\"\r\n}",
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
$product = $obj['product'];
// make a move
$me = json_encode($product);
if ($status == "200" && $status != "") {
        // echo $someArray[0]["code"];
    ?>
    <label class="bmd-label-floating" style="color: white;">Date Plan <div id="data_ress"></div></label>
    <select id="see" class="form-control" style="text-transform: uppercase; color: white;">
        <option value="">SELECT DATA PLAN</option>
    <?php
    $someArray = json_decode($me, true);
    foreach ($someArray as $key => $value) {
            echo "<option value=".$value["allowance"].":".$value["code"].":".$value["price"]." style='color: black;' > " . " ". $value["allowance"] ." &#8358;". number_format($value["price"], 2) . " TERM: ". $value["validity"] . "</option>";
          }
          ?>
    </select>
    <!-- ow te script -->
    <script>
                $(document).ready(function() {
                                $('#see').on("change", function() {
                                  var datac = $('#see').val();
                                    $.ajax({
                                      url:"ajax_post/bill/data_res.php",
                                      method:"POST",
                                      data:{datac:datac},
                                      success:function(data){
                                      $('#data_ress').html(data);
                                    }
                                  });
                                });
                              });
                            </script>
    <!-- DATA respomze -->
    
    <?php
    
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