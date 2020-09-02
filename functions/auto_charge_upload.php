<?php
// called database connection
include("connect.php");
// user management
session_start();
$int_id = $_SESSION['int_id'];
?>
<?php
if(isset($_POST['name'])){
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$sessint_id = $_SESSION["int_id"];
$ch_id = $_POST['name'];
$naming = $_POST['name'];
$fio = $_POST['fio'];
$charge_type = $_POST['charge_type'];
$amount = $_POST['amount'];
$day = $_POST['days'];
$charge_payment = $_POST['charge_option'];
$income_gl = $_POST["Income_gl"];
if(isset($_POST['is_active'])){
  $is_active = '1';
}
else{
  $is_active = '0';
}
if(isset($_POST['allow_over'])){
  $allow_over = '1';
}
else{
  $allow_over = '0';
}
$ifod = "SELECT * FROM charge WHERE int_id = '$int_id' AND id = '$ch_id'";
$fo = mysqli_query($connection, $ifod);
$fi = mysqli_fetch_array($fo);
$name = $fi['name'];

// credit checks and accounting rules
// insertion query for product
$fio = 1;
if($fio == '1'){
    $query = "INSERT INTO `auto_charge` (`int_id`, `charge_id`, `name`, `currency_code`, `charge_type`, `amount`, `fee_on_day`, `charge_cal`,
 `is_active`, `allow_override`, `gl_code`) VALUES ('$int_id', '$ch_id', '$name', 'NGN', '$charge_type', '$amount', '$day', '$charge_payment', '$is_active', '$allow_over', '$income_gl')";

$res = mysqli_query($connection, $query);

 if ($res) {
    $_SESSION["Lack_of_intfund_$randms"] = " was updated successfully!";
          echo header ("Location: ../mfi/products_config.php?message1=$randms");
        } else {
           $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
           echo "error";
        //    if ($connection->error) {
        //     try {   
        //         throw new Exception("MySQL error $connection->error <br> Query:<br> $query", $mysqli->error);   
        //     } catch(Exception $e ) {
        //         echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
        //         echo nl2br($e->getTraceAsString());
        //     }
        // }
          echo header ("Location: ../mfi/products_config.php?message2=$randms");
            // echo header("location: ../mfi/client.php");
        }
}
else if($fio == '2'){
    $query = "UPDATE `auto_charge` SET  `name` = '$naming', `charge_type` = '$charge_type', `amount` = '$amount', `fee_on_day` = '$day', `charge_cal` = '$charge_payment',
 `is_active` = '$is_active', `allow_override` = '$allow_over', `gl_code` = '$income_gl') WHERE int_id = '$int_id' AND id = '$ch_id'";

$res = mysqli_query($connection, $query);

 if ($res) {
    $_SESSION["Lack_of_intfund_$randms"] = " was updated successfully!";
          echo header ("Location: ../mfi/products_config.php?message1=$randms");
        } else {
           $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
           echo "error";
        //    if ($connection->error) {
        //     try {   
        //         throw new Exception("MySQL error $connection->error <br> Query:<br> $query", $mysqli->error);   
        //     } catch(Exception $e ) {
        //         echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
        //         echo nl2br($e->getTraceAsString());
        //     }
        // }
          echo header ("Location: ../mfi/products_config.php?message2=$randms");
            // echo header("location: ../mfi/client.php");
        }
}

}
?>