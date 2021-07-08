<?php 
$output = '';

if (isset($_POST["id"]) && isset($_POST["check"])) {
    $pass = $_POST["id"];
    $hsh = $_POST["check"];
    if (password_verify($pass, $hsh)) {
        $output = '<i style="color: red">This Password Was Used The Last Time</i>';
    } else {
        $output = '';
    }
    echo $output;
}
?>