<?php
include("../../functions/connect.php");
session_start();
$sint_id = $_SESSION['int_id'];
    if(isset($_POST["id"]))
{
    $g_id = $_POST["id"];
    $dids = mysqli_query($conncetion, "SELECT * FROM group_clients WHERE int_id = '$sint_id' AND group_id = '$g_id'");
    while($g = mysqli_fetch_array($dids)){
        $c_name = $_POST['client_name'];
        $out = '
        <tr>
        <td>'.$c_name.'</td>
        <td></td>
        <td></td>
        </tr>
        ';
    }
}
?>