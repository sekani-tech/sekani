<?php include("connect.php")?>
<?php
if (isset($_POST['id'])) {
    $digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$id = $_POST['id'];
$int_id = $_POST['int_id'];
$name = $_POST['name'];
$desc = $_POST['desc'];
$gl_code = $_POST['gl_code'];
$default = $_POST['default'];

if(isset($_POST['is_bank'])){
    $is_bank = "1";
}
else{
    $is_bank = "0";
}
if(isset($_POST['is_cash'])){
    $is_cash = "1";
}
else{
    $is_cash = "0";
}
  $query = "UPDATE payment_type SET value = '$name', description = '$desc', gl_code = '$gl_code',
  is_cash_payment = '$is_cash', is_bank = '$is_bank', order_position = '$default' WHERE id = '$id'";
  $result = mysqli_prepare($connection, $query);
  if(mysqli_stmt_execute($result)) {
    // If 'result' is successful, it will send the required message to client.php
    $_SESSION["Lack_of_intfund_$randms"] = " <php echo = $display_name?> was updated successfully!";
          echo header ("Location: ../mfi/products_config.php?message9=$randms");
        } else {
           $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
           echo "error";
          echo header ("Location: ../mfi/products_config.php?message10=$randms");
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
}
mysqli_close($connection);
?>