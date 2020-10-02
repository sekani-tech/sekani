<?php
// call the connect.php
include("../../../functions/connect.php");
session_start();
// call the institution LAT, LMNMG
$int_lat = $_SESSION["int_lat"];
$int_lng = $_SESSION["int_lng"];

// make a session query.
$staff_lat = $_POST["lat"];
$staff_lng = $_POST["lng"];

// cehck if it exist
if ($staff_lat != "" && $staff_lng != "") {
// API IMPORTATION
if ($int_lat != "" && $int_lng != "") {
    // start the API
    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$staff_lat,$staff_lng&destinations=$int_lat,$int_lng&departure_time=now&key=AIzaSyCPrkS4dgB9aLB0rRB-V3StNCwrY9k-p3g",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
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
        });
    });
    </script>
    ';
    } else {
// echo $response;
$obj = json_decode($response, TRUE);
$status = $obj['status'];
if ($status == "OK") {
    // end it
    $distance = $obj['rows'][0]['elements'][0]['distance']['text'];
    $duration = $obj['rows'][0]['elements'][0]['duration']['text'];
    $req = $obj['rows'][0]['elements'][0]['status'];
    // start anoher
    if ($req == "OK") {
        echo $distance." API DIST";
        echo $duration." API DU";
        // API
        //  END API
    } else {
        ?>
        <script>
        swal({
              type: "error",
              title: "STATUS - '<?php echo $req; ?>'",
              text: "Please activate proper geolocation for institution!",
              showConfirmButton: false,
              timer: 2000
              })
    </script>
    <?php
    }
} else {
    ?>
    <script>
        swal({
              type: "error",
              title: "No Route Found",
              text: "Please activate geolocation for institution!",
              showConfirmButton: false,
              timer: 2000
              })
    </script>
    <?php
}
// END THE API NETWORK ERROR
    }
    // end the API
} else {
    ?>
     <script>
        swal({
              type: "error",
              title: "Institution Geo Location not Found",
              text: "Please activate geolocation for institution!",
              showConfirmButton: false,
              timer: 2000
              })
    </script>
    <?php
}
// END API
} else {
    ?>
    <script>
        swal({
              type: "error",
              title: "Geolocation not found",
              text: "Please activate or allow geolocation on your browser!",
              showConfirmButton: false,
              timer: 2000
              })
              .then(
                function (result) {
                  window.location="../functions/logout.php";
               }
              );
    </script>
    <?php
}
?>