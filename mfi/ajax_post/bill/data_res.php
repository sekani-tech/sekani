<?php
session_start();
$data_res = $_POST["datac"];
if ($data_res != "") {
    list($bundle, $package, $price) = explode(":", $data_res);
    $_SESSION["bundle"] = $bundle;
    $_SESSION["package"] = $package;
    $_SESSION["price"] = $price;
    ?>
    <input type="text" value="<?php echo $bundle; ?>" hidden id="bundle">
    <input type="text" value="<?php echo $package; ?>" hidden id="package">
    <input type="text" value="<?php echo $price; ?>" hidden id="price">
    <script>
    $(document).ready(function() {
        $("#data_pay").prop("disabled", false);
    })
    </script>
    
    <?php
}
?>