<?php
// called database connection
include("connect.php");
// user management
session_start();

?>
<?php
if(isset($_GET['delete'])){
$delete = $_GET['delete'];
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
// credit checks and accounting rules
// insertion query for product
$query ="DELETE FROM charge WHERE id = '$delete'";

$res = mysqli_query($connection, $query);

 if ($res) {
    $_SESSION["Lack_of_intfund_$randms"] = " was updated successfully!";
          echo header ("Location: ../mfi/products_config.php?message5=$randms");
        } else {
           $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
           echo "error";
          echo header ("Location: ../mfi/products_config.php?message6=$randms");
            // echo header("location: ../mfi/client.php");
        }
}
?>