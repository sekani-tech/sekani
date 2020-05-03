<?php
include("../../functions/connect.php");
$output = '';
$sessint_id = $_POST["int_id"];
$branch_id = $_POST["id"];
$query = "SELECT * FROM tellers WHERE int_id = '$sessint_id' && branch_id = '$branch_id'";
    $result = mysqli_query($connection, $query);
        if ($result) {
            $inr = mysqli_num_rows($result);
            $xp = "Teller ".($inr + 1);
       }
       $output .= '
        <label class="bmd-label-floating" >Description</label>
        <input type="text" name="teller_no" readonly value="' .$xp. '" id="tell_desc" class="form-control" required>
        ';
        echo $output;
?>