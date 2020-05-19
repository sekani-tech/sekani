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
$name = $a['name'];
$entity = $a['related_entity_enum_value'];
$severity = $a['severity_level_enum_value'];
$rating = $a['rating_type'];
$value = $a['is_active'];

// credit checks and accounting rules
// insertion query for product
$query ="INSERT INTO charge (int_id, name, related_entity_enum_value, severity_level_enum_value, rating_type, is_active)
VALUES ('{$sessint_id}', '{$name}', '{$entity}', '{$severity}', '{$rating}', '{$value}')";

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