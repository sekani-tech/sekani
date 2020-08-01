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
$income_gl = $_POST["Income_gl"];
if(isset($_POST['is_active'])){
  $is_active = '1';
}
else{
  $is_active = '0';
}
if(isset($_POST['is_pen'])){
  $is_pen = '1';
}
else{
  $is_pen = '0';
}
if(isset($_POST['allow_over'])){
  $allow_over = '1';
}
else{
  $allow_over = '0';
}
// credit checks and accounting rules
// insertion query for product
$query ="INSERT INTO charge (int_id, name, charge_time_enum, charge_applies_to_enum, charge_calculation_enum, charge_payment_mode_enum, amount, gl_code, is_active, is_penalty, allow_override)
VALUES ('{$sessint_id}', '{$name}', '{$charge_type}', '{$product}', '{$charge_option}', '{$charge_payment}', '{$amount}', '{$income_gl}', '{$is_active}', '{$is_pen}', '{$allow_over}')";

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