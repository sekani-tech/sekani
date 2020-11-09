<?php
session_start();

if (isset($_POST["counter"])) {
    $count = $_POST["counter"];
    $_SESSION["table_counter"] = $count;
} else {
    $_SESSION["table_counter"] = "25";
}