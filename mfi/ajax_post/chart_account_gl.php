<?php
session_start();
include('../../functions/connect.php');
$sint = $_SESSION['int_id'];
?>
<?php
if(isset($_POST['type'])){
  $dsd = $_POST['type'];

    $sdf = "SELECT * FROM acc_gl_account WHERE int_id = '$sint' AND classification_enum ='$dsd'";
    $odmw = mysqli_query($connection, $sdf);
    $spdo = mysqli_num_rows($odmw);
    if($spdo){
        $gl_code = ($dsd * 10000) + ($spdo + 1);
    }
    $out = '
    <label>GL Code*</label>
    <input type="text" name="gl_code" style="text-transform: uppercase;" id="" class="form-control" value="'.$gl_code.'" readonly>
    ';
          echo $out;
    }
    else {
        echo 'ID not posted';
    }
?>