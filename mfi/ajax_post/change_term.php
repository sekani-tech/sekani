<?php
$output = "";
if (isset($_POST["id"]))
{
    $id = $_POST["id"];
    if ($id == "day") {
        $output = '<label>Day(s)</label>';
    } else if ($id == "month") {
        $output = '<label>Time(s) Per Month</label>';
    } else if ($id == "year") {
        $output = '<label>Time(s) Per Year</label>';
    } else if ($id == "week") {
        $output = '<label>Time(s) Per Week</label>';
    }
    echo $output;
}
?>