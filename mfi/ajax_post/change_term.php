<?php
$output = "";
if (isset($_POST["id"]))
{
    $id = $_POST["id"];
    if ($id == "day") {
        $output = '<label>Days</label>';
    } else if ($id == "month") {
        $output = '<label>Months</label>';
    } else if ($id == "year") {
        $output = '<label>Years</label>';
    } else if ($id == "week") {
        $output = '<label>Weeks</label>';
    }
    echo $output;
}
?>