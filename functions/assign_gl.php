<?php
include("connect.php");
session_start();
?>
<?php
$ssint_id = $_SESSION["int_id"];
$b_id = $_SESSION['branch_id'];
$syste = $_POST['system'];
$class = $_POST['class_type'];
$glcode = $_POST['gl_code'];
$assign = $_POST['assign'];
$submitted_on = date('Y-m-d');
$submited_by = $_SESSION['user_id'];

$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);

$query = "INSERT INTO `acc_gl_post` (`int_id`, `branch_id`,`function`, `gl_code`, `assigned_to`, `assignment_date`, `assigned_by`) 
VALUES ('{$ssint_id}', '{$b_id}', '{$syste}', '{$glcode}', '{$assign}', '{$submitted_on}', '{$submited_by}')";
$result = mysqli_query($connection, $query);

if ($result) {
    if($syste == "1"){
        $sqlcode = "UPDATE `int_vault` SET `gl_code` = '$glcode' WHERE id ='$assign' AND int_id = '$ssint_id'";
        $ok = mysqli_query($connection, $sqlcode);
    }
    else if($syste == "2"){
        $sqlcode = "UPDATE `charge` SET `gl_code` = '$glcode' WHERE id ='$assign' AND int_id = '$ssint_id'";
        $ok = mysqli_query($connection, $sqlcode);
    }
    else if($syste == "3"){
        $sqlcode = "UPDATE `institution_account` SET `gl_code` = '$glcode' WHERE branch_id ='$b_id' AND int_id = '$ssint_id'";
        $ok = mysqli_query($connection, $sqlcode);
    }
    if($ok){
        $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
        echo "error";
       echo header ("Location: ../mfi/gl_template.php?message1=$randms"); 
    } else {
        $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
        echo "error";
       echo header ("Location: ../mfi/gl_template.php?message3=$randms");
         // echo header("location: ../mfi/client.php");
     }
        } else {
           $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
           echo "error";
          echo header ("Location: ../mfi/gl_template.php?message2=$randms");
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