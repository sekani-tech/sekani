<?php
session_start();
include('../../functions/connect.php');
$sint = $_SESSION['int_id'];
?>
<?php
if(isset($_POST['id']) AND $_POST['id'] != ""){
  $dsd = $_POST['id'];
//   echo $dsd;
    $sdf = "SELECT * FROM account WHERE int_id = '$sint' AND account_no ='$dsd'";
    $odmw = mysqli_query($connection, $sdf);
    $d = mysqli_fetch_array($odmw);
    $account_balance = $d['account_balance_derived'];
    $last_dep = $d['last_deposit'];
    $last_wit = $d['last_withdrawal'];
    
    $out = '
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Account Balance:</label>
            <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="'.$account_balance.'" readonly>
        </div>
        </div> 
        <div class="col-md-6">
        <div class="form-group">
            <label for="">Last Deposit:</label>
            <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="'.$last_dep.'" readonly>
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
            <label for="">Last Withdrawal:</label>
            <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="'.$last_wit.'" readonly>
        </div>
        </div>
    ';
          echo $out;
    }
    else {
        echo 'ID not posted';
    }
?>