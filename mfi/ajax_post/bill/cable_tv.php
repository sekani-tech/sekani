<?php
session_start();
$data_res = $_POST["datac"];
if ($data_res != "") {
    list($packagename, $code, $month, $price, $period) = explode("&", $data_res);
    $_SESSION["code"] = $code;
    $_SESSION["month"] = $month;
    $_SESSION["price"] = $price;
    $_SESSION["period"] = $period;
    $_SESSION["packagename"] = $packagename;
    ?>
    <script>
    $(document).ready(function() {
        $(":input[type=button]").prop("disabled", false);
    });
    </script>
    <!-- check -->
    <input type="text" value="<?php echo $packagename ?>" id="pn" hidden>
    <input type="text" value="<?php echo $price ?>" id="pr" hidden>
    <input type="text" value="<?php echo $month ?>" id="mn" hidden>
    <?php
}
?>