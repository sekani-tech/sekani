<?php
include("../functions/connect.php");
$display2 = '';
$client_id = $_POST['client_id'];
$don = "";

if ($client_id != "") {
    $don = "SELECT * FROM collateral WHERE client_id = '$client_id' ORDER BY id DESC";
        $result = mysqli_query($connection, $don);
        if (mysqli_num_rows($result) >= 1) {
        while ($pox = mysqli_fetch_array($result)) {
            $display2 = '
            <tr>
            <td>'.$pox["value"].'</td>
            <td>'.number_format($pox["type"], 2).'</td>
            <td>'.$pox["description"].'</td>
            </tr>
            ';
            echo $display2;
        }
    } else {
        $display2 = '
        <tr>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        </tr>
        ';
        echo $display2;

    }
}
?>