<?php
session_start();
include('../../functions/connect.php');
$sint = $_SESSION['int_id'];
?>
<?php
if(isset($_POST['type']) && isset($_POST['dso'])){
    $dsd = $_POST['type'];
    $acc_use = $_POST['dso'];
    $parent_id = $_POST['pid'];
    if($acc_use == '1'){
        $sdf = "SELECT * FROM acc_gl_account WHERE int_id = '$sint' AND parent_id = '0' AND id = '$parent_id'";
        $odmw = mysqli_query($connection, $sdf);
        $sd = mysqli_fetch_array($odmw);
        $ser = $sd['int_id_no'];
        $fid = $sd['id'];
        $ido = mysqli_num_rows($odmw);
        $we = $ser * 100;
        if($we == '0'){
            $piid == $ser + 100;
        }
        elseif($we != 0){
            $piid == $ser * 100;
        }

        if($piid){
            $sdf = "SELECT * FROM acc_gl_account WHERE int_id = '$sint' AND classification_enum = '$dsd' AND parent_id = '$fid'";
            $odmw = mysqli_query($connection, $sdf);
            $spdo = mysqli_num_rows($odmw);

            $gl_code = ($dsd * 10).$piid+($spdo + 1);
        }
        else{
            $gl_code = ($dsd * 10).'100';
        }
    }
    elseif($acc_use == '2'){
        $sdf = "SELECT * FROM acc_gl_account WHERE int_id = '$sint' AND classification_enum = '$dsd' AND parent_id = '0'";
        $odmw = mysqli_query($connection, $sdf);
        $sprtydo = mysqli_num_rows($odmw);
        if($sprtydo){
            $gl_code = ($dsd * 10).(($sprtydo + 1) * 100);
        }
        else{
            $gl_code = ($dsd * 10) + 100;
        }
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