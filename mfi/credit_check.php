<?php
include("../functions/connect.php");

$output = '';
if(isset($_POST["id"]))
{
    if($_POST["id"] !='')
    {
        $sql = "SELECT * FROM credit_check WHERE id = '".$_POST["id"]."'";
    }
    else
    {
        $sql = "SELECT * FROM credit_check";
    }

    $result = mysqli_query($connection, $sql);
    if (count([$result]) == 1) {
        $a = mysqli_fetch_array($result);
        $name = $a['name'];
        $severity = $a['severity_level_enum_value'];
        $order = $a['expected_result'];
       }

       echo '
       <p><label for="">Name: '.$name.' </label> <span></span></p>
        <p><label for="">Security Level: '.$severity.' </label> <span></span></p>
        <p><label for="">Order: </label> '.$order.' <span></span></p>
       ';
}
?>