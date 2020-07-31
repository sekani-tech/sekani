<?php
include("../functions/connect.php");

$delete_charge_cache = mysqli_query($connection, "TRUNCATE TABLE `charges_cache`");
if ($delete_charge_cache) {
    echo "cleared cache";
} else {
    echo "error clearing cache";
}
?>