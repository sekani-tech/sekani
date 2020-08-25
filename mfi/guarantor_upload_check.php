<?php
include("../functions/connect.php");
$display = '';
$client_id = $_POST['client_id'];
$don = "";

if ($client_id != "") {
        $don = "SELECT * FROM loan_gaurantor WHERE client_id = '$client_id'";
            $result = mysqli_query($connection, $don);
            if (mysqli_num_rows($result) >= 1) {
            while ($row = mysqli_fetch_array($result)) {
                $display = '
                <tr>
                <td>'.$row["first_name"].'</td>
                <td>'.$row["phone"].'</td>
                <td>'.$row["email"].'</td>
                </tr>
                ';
                echo $display;
            }
        } else {
            $display = '
            <tr>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            </tr>
            ';
            echo $display;

        }
    }
?>