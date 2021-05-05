<?php
include("../../../functions/connect.php");
session_start();
$institutionId = $_SESSION['int_id'];

$paymmentMethod = $_POST['id'];
$findType = mysqli_query($connection, "SELECT * FROM payment_type WHERE int_id = '$institutionId' AND id = '$paymmentMethod'");
$findings  = mysqli_fetch_array($findType);
$isBank = $findings['is_bank'];
if ($isBank == 1) {
?>
    <div class="form-group">
        <label for="">Transaction ID (Insert Bank's Deposit slip ID or Transaction ID):</label>
        <input type="text" name="transid" class="form-control">
    </div>
<?php
} else {
?>
    <div class="form-group">
        <label for="">Transaction ID(Cheque no, Transfer Id, Deposit Id):</label>
        <input type="text" value="<?php echo $transid1; ?>" name="transid" class="form-control" readonly>
    </div>
<?php
}
?>