<?php
include("../../functions/connect.php");
session_start();
$fof = $_SESSION['int_id'];

if(isset($_POST['id'])){
    $domd = $_POST['type'];
    $idd = $_POST['id'];

    if($domd == "1")
    {
        $dfdff = "SELECT * FROM int_vault WHERE int_id = '$fof' AND id = '$idd'";
        $eroer = mysqli_query($connection, $dfdff);
        $dk = mysqli_fetch_array($eroer);
        $sdd = $dk['gl_code'];

        $tjnt = "SELECT * FROM acc_gl_account WHERE int_id = '$fof' AND gl_code = '$sdd'";
        $sdsddc = mysqli_query($connection, $tjnt);
        $as = mysqli_fetch_array($sdsddc);
        $dss = $as['name'];

        $dom = '
        <div class="form-group">
        <label class="bmd-label-floating">Current Gl Assigned to:</label>
        <input class="form-control" type="text" value="'.$dss.'" readonly/>
        </div>
        ';
        echo $dom;
    }
    else if($domd == "2")
    {
        $dfdff = "SELECT * FROM charge WHERE int_id = '$fof' AND id = '$idd'";
        $eroer = mysqli_query($connection, $dfdff);
        $dk = mysqli_fetch_array($eroer);
        $sdd = $dk['gl_code'];

        $tjnt = "SELECT * FROM acc_gl_account WHERE int_id = '$fof' AND gl_code = '$sdd'";
        $sdsddc = mysqli_query($connection, $tjnt);
        $as = mysqli_fetch_array($sdsddc);
        $dss = $as['name'];

        $dom = '
        <div class="form-group">
        <label class="bmd-label-floating">Current Gl Assigned to:</label>
        <input class="form-control" type="text" value="'.$dss.'" readonly/>
        </div>
        ';
        echo $dom;
    }
    else if($domd == "3")
    {
        
    }
    }
    else {
        echo 'ID not posted';
    }
?>
<script>
$(document).ready(function () {
    $('#sel').on("change", function () {
    var id = $(this).val();
    $.ajax({
        url: "view_current_gl.php", 
        method: "POST",
        data:{id:id},
        success: function (data) {
        $('#rerer').html(data);
        }
    })
    });
});
</script>