<?php
include("../functions/connect.php");

$output = '';

if(isset($_POST["id"]))
{
    if($_POST["id"] !='')
    {
        $sql = "SELECT * FROM account WHERE account_no = '".$_POST["id"]."'";
        $result = mysqli_query($connection, $sql);
        $res = mysqli_fetch_array($result);
        $prod = $res["product_id"];
        $sql2 = "SELECT * FROM savings_product WHERE id = '$prod'";
    }
}
?>