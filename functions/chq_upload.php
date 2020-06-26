<?php
// called database connection
include("connect.php");
// user management
session_start();

?>
<?php
if(isset($_POST['acc_name'])){
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$sessint_id = $_SESSION["int_id"];
$branch = $_SESSION["branch_id"];
$name = $_POST['acc_name'];
$account_no = $_POST['acc_no'];
$book = $_POST['book_type'];
$leaves_no = $_POST['no_leaves'];
$range = $_POST['range'];
$date = date('Y-m-d');

// credit checks and accounting rules
// insertion query for product
$query ="INSERT INTO chq_book(int_id, name, branch_id, account_no, book_type, leaves_no, range_amount, date, status)
VALUES ('{$sessint_id}', '{$name}','{$branch}', '{$account_no}', '{$book}', '{$leaves_no}', '{$range}', '{$date}', 'Pending')";

$res = mysqli_query($connection, $query);
// if ($connection->error) {
//   try {   
//       throw new Exception("MySQL error $connection->error <br> Query:<br> $query", $mysqli->error);   
//   } catch(Exception $e ) {
//       echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
//       echo nl2br($e->getTraceAsString());
//   }
// }
 if ($res) {
        $_SESSION["Lack_of_intfund_$randms"] = " was updated successfully!";
        echo header ("Location: ../mfi/cheque_book_posting.php?message1=$randms");
        } 
        else {
           $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
           echo "error";
          echo header ("Location: ../mfi/cheque_book_posting.php?message2=$randms");
            // echo header("location: ../mfi/client.php");
        }
}
?>