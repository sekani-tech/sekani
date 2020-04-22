<?php
// connection
include("connect.php");
session_start();
?>
<?php
$sessint_id = $_SESSION["int_id"];
$tel_name = $_POST["tel_name"];
$branch = $_POST["branch"];
$teller_no = strtoupper($_POST['teller_no']);
$post_limit = strtoupper($_POST['post_limit']);

$digits = 10;
$randms = str_pad(rand(0, pow(10, 10)-1), 10, '0', STR_PAD_LEFT);
$till_no = str_pad(rand(0, pow(10, 10)-1), 10, '0', STR_PAD_LEFT);
$query = "INSERT INTO teller (int_id, branch_id, teller_name, posting_limit, teller_no, till_no)
 VALUES ('{$sessint_id}', '{$branch}', '{$tel_name}', '{$post_limit}',
'{$teller_no}', '{$till_no}')";

$res = mysqli_query($connection, $query);
if ($res) {
    $_SESSION["Lack_of_intfund_$randms"] = "Registration Successful!";
    echo header ("Location: ../mfi/create_teller.php?message1=$randms");
  } else {
     $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
     echo "error";
    echo header ("Location: ../mfi/create_teller.php?message2=$randms");
      // echo header("location: ../mfi/client.php");
  }
?>