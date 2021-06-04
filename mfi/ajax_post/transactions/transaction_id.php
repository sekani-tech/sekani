<?php
include("../../../functions/connect.php");
session_start();
$institutionId = $_SESSION['int_id'];

$paymmentMethod = $_POST['id'];
$findType = mysqli_query($connection, "SELECT * FROM payment_type WHERE int_id = '$institutionId' AND id = '$paymmentMethod'");
$findings  = mysqli_fetch_array($findType);
$isBank = $findings['is_bank'];
$digits = 10;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
if ($isBank == 1) {
?>
    <div class="form-group">
        <label for="">Transaction ID (Insert Bank's Deposit slip ID or Transaction ID):</label>
        <input type="text" name="transid" class="form-control" required>
    </div>
<?php
} else {
?>
    <div class="form-group">
        <label for="">Transaction ID(Cheque no, Transfer Id, Deposit Id):</label>
        <input type="text" value="<?php echo $randms; ?>" name="transid" class="form-control" required readonly>
    </div>
<?php
}
?>