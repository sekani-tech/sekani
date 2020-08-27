<?php
    include("../functions/connect.php");
    $display = '';
    $col_id = $_POST['id'];
    $clientid = $_POST['client_id'];
    $colval = $_POST['colval'];
    $colname = $_POST['colname'];
    $coldes = $_POST['coldes']; 
    $coldate = date('Y-m-d h:i:sa');

    $org = mysqli_query($connection, "SELECT * FROM client WHERE id = '$clientid'");
    if (count([$org]) == 1) {
      $a = mysqli_fetch_array($org);
      $int_id = $a['int_id'];
     }

    $coll = mysqli_query($connection, "INSERT INTO collateral (int_id, client_id, date, type, value, description) VALUES ('{$int_id}',
    '{$clientid}', '{$coldate}', '{$colval}', '{$colname}', '{$coldes}')");
    if ($coll) {
        // 
    }    
?>