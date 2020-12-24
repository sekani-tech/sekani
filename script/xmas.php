<?php
// run connect file
include("../functions/connect.php");
require_once "../bat/phpmailer/PHPMailerAutoload.php";


// now import email phpmailer
$get_all_client_email = mysqli_query($connection, "SELECT * FROM `client` WHERE status = 'Approved'");

if (mysqli_num_rows($get_all_client_email) > 0) {
    // now dispaly
    while ($row = mysqli_fetch_array($get_all_client_email)) {
        $int_id = $row["int_id"];
        $firstname = $row["firstname"];
        $lastname = $row["lastname"];
        $middlename = $row["middlename"];
        // arrange the client name
        $fullname = $firstname." ".$middlename." ".$lastname;
        // get the nec from the details
        $email = $row["email_address"];

        // get the instituiton information
        $query_int = mysqli_query($connection, "SELECT * FROM `institutions` WHERE int_id = '$int_id'");
        if (mysqli_num_rows($query_int) > 0) {
            $icn = mysqli_fetch_array($query_int);
            $int_name = $icn["int_name"];
            $int_full = $icn["int_full"];
            $office_address = $icn["office_address"];
            $int_email = $icn["email"];
            $int_logo = $icn["img"];
            $pc_phone = $icn["pc_phone"];
            $pc_designation = $icn["pc_designation"];

            // form a full
            $pc_title = $icn["pc_title"];
            $pc_surname = $icn["pc_surname"];
            $pc_other_name = $icn["pc_other_name"];

            // full mixer
            $primary_contact = $pc_title." ".$pc_surname." ".$pc_other_name;

            // Next is the email
            $current_date = date('Y-m-d');
            $x_mas = "2020-12-25";

            if ($current_date == $x_mas) {
                // Trigger Email with Entity
            } else {
                // End email trigger
            }
            // End the email
        } else {
            echo "Cant find institution";
        }


    }
} else {
    echo "No email";
}
?>