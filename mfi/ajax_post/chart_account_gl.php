<?php
session_start();
include('../../functions/connect.php');
$sint = $_SESSION['int_id'];
?>
<?php
if(isset($_POST['type'])){
    $dsd = $_POST['type'];
    $acc_use = $_POST['dso'];
    $parent_id = $_POST['pid'];
    if($acc_use == '1'){
        $sdf = "SELECT * FROM acc_gl_account WHERE int_id = '$sint' AND parent_id = '0' AND id = '$parent_id'";
        $odmw = mysqli_query($connection, $sdf);
        $sd = mysqli_fetch_array($odmw);
        $ido = $sd['id'];
        $piid = $ido * 100;

        if($ido){
            $sdf = "SELECT * FROM acc_gl_account WHERE int_id = '$sint' AND classification_enum = '$dsd' AND parent_id = '$ido'";
            $odmw = mysqli_query($connection, $sdf);
            $spdo = mysqli_num_rows($odmw);

            $gl_code = ($dsd * 10000) + $piid + ($spdo + 1);
        }
        else{
            $gl_code = ($dsd * 10000) + $piid + ($spdo + 1);
        }
    }
    elseif($acc_use == '2'){
        $sdf = "SELECT * FROM acc_gl_account WHERE int_id = '$sint' AND classification_enum = '$dsd' AND parent_id = '0'";
        $odmw = mysqli_query($connection, $sdf);
        $spdo = mysqli_num_rows($odmw);
        if($spdo){
            $gl_code = ($dsd * 10000) + (($spdo + 1) * 100);
        }
        else{
            $gl_code = ($dsd * 10000) + 100;
        }
    }
    $out = '
    <label>GL Coding*</label>
    <input type="text" name="gl_code" style="text-transform: uppercase;" id="" class="form-control" value="'.$gl_code.'" readonly>
    ';
          echo $out;
    }
    else {
        echo 'ID not posted';
    }
?>