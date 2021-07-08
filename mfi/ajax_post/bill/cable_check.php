<?php
// making a good move
include("../../../functions/connect.php");
// porty
session_start();
$int_id = $_SESSION["int_id"];
$branch_id = $_SESSION["branch_id"];
$cable = $_POST["cable"];
$smart = $_POST["smart"];
// QWERTY
$digits = 9;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
// end the code
// end
if ($cable != "" && $smart != "" && $int_id != "" && $branch_id != "") {
    // finnin
    $sql_fund = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$int_id'");
        $qw = mysqli_fetch_array($sql_fund);
        $balance = $qw["bills_balance"];
        $total_with = $qw["total_withdrawal"];
        $total_int_profit = $qw["int_profit"];
        $total_sekani_charge = $qw["sekani_charge"];
        $total_merchant_charge = $qw["merchant_charge"];
        // test
        if ($balance == $balance) {
            // STAT API
            $curl = curl_init();

            curl_setopt_array($curl, array(
              // CURLOPT_URL => "http://34.68.51.255/shago/public/api/test/b2b",
              CURLOPT_URL => "https://shagopayments.com/api/live/b2b",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS =>"{\r\n\"serviceCode\" : \"GDS\",\r\n\"smartCardNo\" : \"$smart\",\r\n\"type\" : \"$cable\"\r\n}",
              CURLOPT_HTTPHEADER => array(
                "hashKey: ddceb2126614e2b4aec6d0d247e17f746de538fef19311cc4c3471feada85d30",
                "Content-Type: application/json",
                // "email: test@shagopayments.com",
                // "password: test123"
              ),
            ));
            
            $response = curl_exec($curl);
            // echo $response;
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
        // make 
$obj = json_decode($response, TRUE);
$status = $obj['status'];
$msg = $obj['message'];
$customer = $obj['customerName'];
$acct_status = $obj['accountStatus'];
$dd = $obj['dueDate'];
$customerNumber = $obj['customerNumber'];
$balance = $obj['balance'];
// make a 
$product = $obj['product'];
// make a move
$_SESSION['customerName'] = $customer;
$me = json_encode($product);
// echo "-------------------";
// echo $me;
if ($status == "200" && $status != "") {
        // echo $someArray[0]["code"];
    ?>
     <label class="bmd-label-floating" style="color: white;">Select Product<div id="data_ress"></div></label>
    <select id="see" style="color: white;" class="form-control" style="text-transform: uppercase;">
        <option value="">SELECT PRODUCT</option>
    <?php
    $someArray = json_decode($me, true);
    foreach ($someArray as $key => $value) {
            echo "<option style='color:black;' value=".preg_replace('/\s+/', '', $value["name"])."&".$value["code"]."&".$value["month"]."&".$value["price"]."&".$value["period"]."> " . " ". $value["name"] ." &#8358;". number_format($value["price"], 2) . " TERM: ". $value["month"] . "Month(S)". "</option>";
          }
          ?>
    </select>
    <!-- ow te script -->
    <p>Customer Name: <?php echo $customer; ?></p>
    <p>Account Status: <?php echo $acct_status; ?></p>
    <p>Due Date: <?php echo $dd; ?></p>
    <p>Customer Number: <?php echo $customerNumber; ?></p>
    <p>Customer Balance: <?php echo $balance; ?></p>
    <!-- inout -->
    <script>
                $(document).ready(function() {
                                $('#see').on("change keyup paste click", function() {
                                  var datac = $('#see').val();
                                    $.ajax({
                                      url:"ajax_post/bill/cable_tv.php",
                                      method:"POST",
                                      data:{datac:datac},
                                      success:function(data){
                                      $('#data_ress').html(data);
                                    }
                                  });
                                });
                              });
                            </script>
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