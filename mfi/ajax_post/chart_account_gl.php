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
        $pdro = "SELECT * FROM acc_gl_account WHERE int_id = '$sint' AND classification_enum = '$dsd' AND id = '$parent_id'";
        $pdok = mysqli_query($connection, $pdro);
        $s = mysqli_fetch_array($pdok);
        $int_no = $s['int_id_no'];
        if($int_no == 0){
            $dsos = $int_no + 100;
        }else{
            $dsos = $int_no * 100;
        }
        

        $sdf = "SELECT * FROM acc_gl_account WHERE int_id = '$sint' AND classification_enum = '$dsd' AND parent_id = '$parent_id'";
        $odmw = mysqli_query($connection, $sdf);
        $sd = mysqli_fetch_array($odmw);
        $ido = mysqli_num_rows($odmw);
        $we = ($ido + 1);

        $gl_code = ($dsd * 10).($dsos + $we);
        }
    elseif($acc_use == '2'){
        $sdf = "SELECT * FROM acc_gl_account WHERE int_id = '$sint' AND classification_enum = '$dsd' AND parent_id = '0'";
        $odmw = mysqli_query($connection, $sdf);
        $sprtydo = mysqli_num_rows($odmw);
        if($sprtydo){
            $gl_code = ($dsd * 10).(($sprtydo + 1) * 100);
        }
        else{
            $gl_code = ($dsd * 10).(($sprtydo + 1) * 100);
        }
    }
    $out = '
    <label>GL Code*</label>
    <input type="text" name="gl_code" style="text-transform: uppercase;" id="" class="form-control" value="'.$gl_code.'" readonly>
    ';
          echo $out;
}
else{
    echo 'id not posted';
}
?>