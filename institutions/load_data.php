<?php
include("../functions/connect.php");

$output = '';

if(isset($_POST["id"]))
{
    if($_POST["id"] !='')
    {
        $sql = "SELECT * FROM charge WHERE id = '".$_POST["id"]."'";
    }
    else
    {
        $sql = "SELECT * FROM charge";
    }
    $result = mysqli_query($connection, $sql);

    while ($row = mysqli_fetch_array($result))
    {
        $output = '<p><label>Name: '.$row["name"].' </label> <span></span></p>
        <p><label>Charge: '.$row["amount"].' </label> <span></span></p>
        <p><label>Collected on: '.$row["fee_on_day"].' </label> <span></span></p>';
    }
    echo $output;
}
?>