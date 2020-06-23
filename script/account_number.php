<?php
// here
// netwr
include("connect.php");

$account_table = mysqli_query($connection, "SELECT * FROM account WHERE int_id = '5'");
// FIRST ONE
while ($row = mysqli_fetch_array($account_table)) {
    $client_id = $row["client_id"];
    $soc = $row["account_no"];
    $acct_id = $row["id"];
    $length = strlen($soc);
    if ($length == 1) {
      $acc ="000000000" . $soc;
    }
    elseif ($length == 2) {
      $acc ="00000000" . $soc;
    }
    elseif ($length == 3) {
      $acc ="00000000" . $soc;
    }
    elseif ($length == 4) {
      $acc ="0000000" . $soc;
    }
    elseif ($length == 5) {
      $acc ="000000" . $soc;
    }
    elseif ($length == 6) {
      $acc ="0000" . $soc;
    }
    elseif ($length == 7) {
      $acc ="000" . $soc;
    }
    elseif ($length == 8) {
      $acc ="00" . $soc;
    }
    elseif ($length == 9) {
      $acc ="0" . $soc;
    }
    elseif ($length == 10) {
      $acc = $row["account_no"];
    }else{
      $acc = $row["account_no"];
    }

    $update_account = mysqli_query($connection, "UPDATE account SET account_no = '$acc' WHERE client_id = '$client_id' && int_id = '5' && id = '$acct_id'");
}

$client_table = mysqli_query($connection, "SELECT * FROM client WHERE int_id = '5'");
// SECOUND ONE
while ($rx = mysqli_fetch_array($client_table)) {
    $id = $rx["id"];
    $soc2 = $rx["account_no"];
    $length = strlen($soc2);
    if ($length == 1) {
      $acc1 ="000000000" . $soc2;
    }
    elseif ($length == 2) {
      $acc1 ="00000000" . $soc2;
    }
    elseif ($length == 3) {
      $acc1 ="00000000" . $soc2;
    }
    elseif ($length == 4) {
      $acc1 ="0000000" . $soc2;
    }
    elseif ($length == 5) {
      $acc1 ="000000" . $soc2;
    }
    elseif ($length == 6) {
      $acc1 ="0000" . $soc2;
    }
    elseif ($length == 7) {
      $acc1 ="000" . $soc2;
    }
    elseif ($length == 8) {
      $acc1 ="00" . $soc2;
    }
    elseif ($length == 9) {
      $acc1 ="0" . $soc2;
    }
    elseif ($length == 10) {
      $acc1 = $rx["account_no"];
    }else{
      $acc1 = $rx["account_no"];
    }

    $update_client = mysqli_query($connection, "UPDATE client SET account_no = '$acc1' WHERE id = '$id' && int_id = '5'");
}
if ($update_account) {
    echo " ACCOUNT TABLE UPDATED";
} else {
    echo "ACCOUNT NOT UPDATED";
}
if ($update_account) {
    echo " CLIENT TABLE UPDATED";
} else {
    echo "CLEINT NOT UPDATED";
}
?>