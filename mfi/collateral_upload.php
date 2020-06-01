<?php
    include("../functions/connect.php");
    $display = '';
    $col_id = $_POST['id'];
    $clientid = $_POST['client_id'];
    $colval = $_POST['colval'];
    $colname = $_POST['colname'];
    $coldes = $_POST['coldes']; 

    $org = mysqli_query($connection, "SELECT * FROM client WHERE id = '$clientid'");
    if (count([$org]) == 1) {
      $a = mysqli_fetch_array($org);
      $int_id = $a['int_id'];
     }

    $coll = "INSERT INTO collateral (int_id, client_id, type, value, description) VALUES ( '{$int_id}',
    '{$clientid}', '{$colname}', '{$colval}', '{$coldes}')";

    $query = mysqli_query($connection, $coll);

    if($query){
        $don = "SELECT * FROM collateral WHERE client_id = '$clientid'";
        $result = mysqli_query($connection, $don);
        while ($row = mysqli_fetch_array($result)) {
            $display = '
            <tr>
            <td>'.$row["value"].'</td>
            <td>&#x20a6; '.number_format($row["type"], 2).'</td>
            <td>'.$row["description"].'</td>
            </tr>
            ';
            echo $display;
        }
        
    }
?>