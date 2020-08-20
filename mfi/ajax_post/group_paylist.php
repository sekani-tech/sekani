<?php
include("../../functions/connect.php");
session_start();
$sint_id = $_SESSION['int_id'];
    if(isset($_POST["id"]))
{
    $g_id = $_POST["id"];
    $dids = mysqli_query($connection, "SELECT * FROM group_clients WHERE int_id = '$sint_id' AND group_id = '$g_id'");
    while($fdf = mysqli_fetch_array($dids)){
        $c_name = $fdf['client_name'];
        $cl_id = $fdf['client_id'];
        $idofi = mysqli_query($connection, "SELECT * FROM account WHERE int_id = '$sint_id' AND client_id = '$cl_id'");
        $opo = mysqli_fetch_array($idofi);
        $fd = $opo['account_balance_derived'];
        $out = '
        <tr>
        <td>'.$c_name.'</td>
        <td>'.$fd.'</td>
        <td></td>
        <td></td>
        </tr>
        ';
        echo $out;
    }

}
?>