<?php
include("../functions/connect.php");
$output = '';

if(isset($_POST["usern"]))
{
    if($_POST["usern"] != '')
    {
        $sql = "SELECT * FROM users WHERE username = '".$_POST["usern"]."'";
    }
    $result = mysqli_query($connection, $sql);

    while ($row = mysqli_fetch_array($result))
    {
        $newu = $row["username"];
        $testq = $_POST["usern"];
        if ($newu == $testq) {
            $output = '<b style="color: red">This Username is Already Taken</b>';
        }  else {
            $output = '';
        }
    }
    echo $output;
}
?>