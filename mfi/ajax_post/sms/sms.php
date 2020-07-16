<?php
// something
include("../../../functions/connect.php");
// Try the sms api
$send_id = $_POST["sender_id"];
$phone = $_POST["phone"];
$msg = $_POST["msg"];
// quick test
$digits = 9;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
// end
if ($send_id != "" && $phone != "" && $msg != "") {
    // sender ID
    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://hordecall.net/sms/postSms.php",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "sender_id=$send_id&mobile=$phone&msg=$msg&msg_id=$randms&username=2348091141288&password=password@111",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/x-www-form-urlencoded"
  ),
));
// checking up the control
$response = curl_exec($curl);
// success
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
    } else {
echo $response;
$obj = json_decode($response, TRUE);
$status = $obj['response'];
if ($status != "" && $status == "success") {
    // end
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "success",
            title: "Message sent Successfully! - '.$status.'",
            text: "API Looks Good!",
            showConfirmButton: false,
            timer: 3000
        });
    });
    </script>
    ';
} else {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "Status Error! - '.$status.'",
            text: "API error",
            showConfirmButton: false,
            timer: 3000
        });
    });
    </script>
    ';
}
    }
    // end
} else {
    // echo Error
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "No Data",
            text: "Input Data",
            showConfirmButton: false,
            timer: 3000
        });
    });
    </script>
    ';
}
?>