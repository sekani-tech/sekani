<?php
$int_id = $_SESSION["int_id"];
$output = '';
if(isset($_POST["id"]))
{
    if($_POST["id"] !='')
    {
        $sql = "SELECT client.id, client.firstname, client.middlename, client.lastname FROM client JOIN account ON account.client_id = client.id && client.int_id = '".$_POST["ist"]."' && account.account_no = '".$_POST["id"]."'";
    }
    $output = '<div>"'.$rd = "".'"</div>';
    echo $output;
}
?>