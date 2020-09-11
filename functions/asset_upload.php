<?php
include("connect.php");
session_start();
?>
<?php
$ssint_id = $_SESSION["int_id"];
$b_id = $_POST['branch'];
$user_id = $_SESSION['user_id'];
$assname = $_POST['assname'];
$asstype = $_POST['asstype'];

$org = "SELECT * FROM asset_type WHERE int_id = '$ssint_id' AND id = '$asstype'";
$kfdlf = mysqli_query($connection, $org);
$gdi = mysqli_fetch_array($kfdlf);
$asset_name = $gdi['asset_name'];

$qty = $_POST['qty'];
$price = $_POST['price'];
$ass_no = $_POST['ass_no'];
$location = $_POST['location'];
$depre = $_POST['depre'];
$purdate = $_POST['purdate'];
$amount = $price * $qty;

$submitted_on = date('Y-m-d h:m:s');
$submited_by = $_SESSION['user_id'];

$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);

$query = "INSERT INTO `assets` (`int_id`, `branch_id`, `asset_name`, `asset_type_id`, `type`, `qty`,
 `unit_price`, `asset_no`, `location`,  `amount`, `date`, `depreciation_value`, `appuser_id`) 
 VALUES ('{$ssint_id}', '{$b_id}', '{$assname}', '{$asstype}', '{$asset_name}', '{$qty}', '{$price}', '{$ass_no}',
  '{$location}', '{$amount}', '{$purdate}', '{$depre}', '{$user_id}')";
$result = mysqli_query($connection, $query);

if ($result) {
        $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
        echo "error";
       echo header ("Location: ../mfi/asset_register.php?message1=$randms"); 
    } else {
        $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
        echo "error";
       echo header ("Location: ../mfi/asset_register.php?message2=$randms");
         // echo header("location: ../mfi/client.php");
     }
if ($connection->error) {
    try {   
        throw new Exception("MySQL error $connection->error <br> Query:<br> $query", $mysqli->error);   
    } catch(Exception $e ) {
        echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
        echo nl2br($e->getTraceAsString());
    }
}
?>