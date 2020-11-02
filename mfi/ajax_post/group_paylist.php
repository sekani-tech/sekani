<?php
include("../../functions/connect.php");
session_start();
$sint_id = $_SESSION['int_id'];
    if(isset($_POST["id"]))
{
    // $g_id = $_POST["id"];
    // $dids = mysqli_query($connection, "SELECT * FROM group_clients WHERE int_id = '$sint_id' AND group_id = '$g_id'");
    // $i = 1;
    // while($fdf = mysqli_fetch_array($dids)){
    //     $c_name = $fdf['client_name'];
    //     $cl_id = $fdf['client_id'];
    //     $idofi = mysqli_query($connection, "SELECT * FROM account WHERE int_id = '$sint_id' AND client_id = '$cl_id'");
    //     $opo = mysqli_fetch_array($idofi);
    //     $balDervied = mysqli_query($connection, "SELECT total_outstanding_derived FROM loan WHERE int_id = '$sint_id' AND client_id = '$cl_id'");
    //     $balResult = mysqli_fetch_array($balDervied);
    //     $bal = $balResult;
    //     $fd = $opo['account_balance_derived'];
    //     $out = '
    //     <tr>
    //     <td>'.$i.'</td>
    //     <td>'.$c_name.'</td>
    //     <td>'.$bal.'</td>
    //     <td></td>
    //     <td></td>
    //     <td><input type="text" name="" id="" style="text-transform: uppercase;" class="form-control"
    //                                   value=""></td>
    //     </tr>
    //     ';
    //     $i++;
    //     echo $out;
    // }
    
    // get group clients
    $g_id = $_POST["id"];
    $groupClientTable = "group_clients";
    $condition = ['int_id' => $sint_id, 'group_id' => $g_id];
    $groupClients = selectAll($groupClientTable, $condition);
    // dd($groupClients);
    $i = 1;
    foreach($groupClients as $kay => $groupClient){
        $c_name = $groupClient['client_name'];
        $cl_id = $groupClient['client_id'];
        $out = '
        <tr>
        <td>'.$i.'</td>
        <td>'.$c_name.'</td>
        <td>'.$bal.'</td>
        <td></td>
        <td></td>
        <td><input type="text" name="" id="" style="text-transform: uppercase;" class="form-control total_price" value=""></td>
        </tr>
        ';
        $i++;
        echo $out;
    }
}
?>