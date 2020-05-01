<?php
include("../../functions/connect.php");
$output = '';

if (isset($_POST["id"]) && isset($_POST["int_id"]))
{
    $branch_id = $_POST['id'];
    $int_id = $_POST['int_id'];
    $me = strtoupper($_POST['me']);
    if($_POST["id"] != '' && $_POST["int_id"] != '')
    {
        $gettell = "SELECT * FROM tellers WHERE int_id = '$int_id' && branch_id = '$branch_id' && description = '$me'";
        $getres = mysqli_query($connection, $gettell);
        $mx = mysqli_fetch_array($getres);
        $mee = strtoupper($mx['description']);
        if ($me == $mee && $me != "") {
            $output = '<p style="color: red">This Teller Description is Taken</p>';
        } else if ($me == "") {
            $output = '<p style="color: red">Please input Teller Description</p>';
        } else {
            // checking if keyword teller 
            $output = '<p style="color: green">Correct</p>';
        }
        echo $output;
    }
}
?>