<?php
// called database connection
include("connect.php");
// user management
session_start();

?>
<?php
if(isset($_POST['name'])){
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$sessint_id = $_SESSION["int_id"];
$name = $_POST['name'];
$product = $_POST['product'];
$charge_type = $_POST['charge_type'];
$amount = $_POST['amount'];
$charge_payment = $_POST['charge_payment'];
$charge_option = $_POST['charge_option'];

// credit checks and accounting rules
// insertion query for product
$query ="INSERT INTO charge (int_id, name, charge_time_enum, charge_applies_to_enum, charge_calculation_enum, charge_payment_mode_enum, amount)
VALUES ('{$sessint_id}', '{$name}', '{$charge_type}', '{$product}', '{$charge_option}', '{$charge_payment}', '{$amount}')";

$res = mysqli_query($connection, $query);

 if ($res) {
    $_SESSION["Lack_of_intfund_$randms"] = " was updated successfully!";
          echo header ("Location: ../mfi/products_config.php?message1=$randms");
        } else {
           $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
           echo "error";
          echo header ("Location: ../mfi/products_config.php?message2=$randms");
            // echo header("location: ../mfi/client.php");
        }
}
?>