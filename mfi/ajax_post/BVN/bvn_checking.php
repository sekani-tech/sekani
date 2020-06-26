<?php
include("../../../functions/connect.php");
// FIRST GET THE POSTED DATA
// CHECK IF LENGTH IS UP TO ELEVEN - YES(CONTINUE) / NO(KEEP CHECKING)
// CHECK IF THE BVN EXIST - YES (OUTPUT ERROR, DONT SUBMIT FORM) / NO (CONTINUE)
// CHECK BVN AND GET OUTPUT
// MATCH OUT PUT DATA
if ($_POST["dob"] != "" && $_POST["first"] != "" && $_POST["last"] != "" && $_POST["phone"] != "") {
// check the length
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
    $sql_check = mysqli_query($connection, "SELECT * FROM client WHERE BVN = '$bvn'");
    if (mysqli_num_rows($sql_check) <= 0) {
        // next code 
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
          "Authorization: Bearer sk_live_97fe98ff50caf80f6c0b00507fbf98f056689c22",
          "Cache-Control: no-cache",
        ),
        ));
  
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
  
        if ($err) {
           echo "cURL Error #:" . $err;
        } else {
           echo $response;
           $obj = json_decode($response, TRUE);
           $bvn_fn = $obj['data']['first_name'];
           $bvn_ln = $obj['data']['last_name'];
           $bvn_dob = $obj['data']['dob'];
           $bvn_phone = $obj['data']['mobile'];
           $bvn_bvn = $obj['data']['bvn'];
        //    echo $bvn_fn."firstname".$bvn_ln."Lastname".$bvn_dob."DATE OF BIRTH";
        if ($bvn_fn == $first && $bvn_ln == $last && $bvn_dob == $check_DOB && $bvn_phone == $phone){
            // BVN VERIFIED
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
            // OUTPUT WRONG DATA, BVN NOT VERIFIED
            echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "WRONG BVN DATA",
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
        }
        }
        // END OF PAYSACK BVN VERIFICATION
    } else {
        echo "<span style='color: red'>THIS CLIENT EXSIST</span>";
        // STOP FORM FROM SUBMITTING
    }
} else {
    // bvn not up to eleven
    echo "BVN NOT UP TO ELEVEN NUMBERS";
}
} else {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "FILL DATA PROPERLY",
            text: "Please check if FirstName, LastName, Date of Birth and Phone Number field has been filled correctly",
            showConfirmButton: false,
            timer: 4000
        });
        $(":input[type=submit]").prop("disabled", true);
    });
    </script>
    ';
    // STOP THE FORM
}
?>