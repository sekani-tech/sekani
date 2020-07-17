<?php
include("connect.php");
session_start();
?>
<?php
$ssint_id = $_SESSION["int_id"];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$incomegl = $_POST['income_gl'];
$location = $_POST['location'];
$submitted_on = date('Y-m-d h:m:s');

$query = "INSERT INTO branch (int_id, name, email, phone, location) VALUES ('{$ssint_id}',
'{$name}', '{$email}', '{$phone}', '{$location}')";
$result = mysqli_query($connection, $query);

if ($result) {
    $brna = mysqli_query($connection, "SELECT * FROM branch WHERE name = '{$name}'");
    $gom = mysqli_fetch_array($brna);
    $br_id = $gom['id']; 
        $mvamt = 10000000.00;
        $bal = 0.00;
        $queryx = "INSERT INTO int_vault (int_id, branch_id, movable_amount, balance, date, last_withdrawal, last_deposit, gl_code) VALUES ('{$ssint_id}',
    '{$br_id}', '{$mvamt}', '{$bal}', '{$submitted_on}', '{$bal}', '{$bal}', '{$incomegl}')";
    $gogoo = mysqli_query($connection, $queryx);
    // If 'result' is successful, it will send the required message to client.php
    $_SESSION["Lack_of_intfund_$randms"] = " <php echo = $display_name?> was updated successfully!";
          echo header ("Location: ../mfi/branch.php?message1=$randms");
        } else {
           $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
           echo "error";
          echo header ("Location: ../mfi/branch.php?message2=$randms");
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