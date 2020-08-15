<?php
include("../../functions/connect.php");
session_start();
$sint_id = $_SESSION['int_id'];

// Depreciation
if(isset($_POST['id'])){
    $state = $_POST['id'];

            $stateg = "SELECT * FROM asset_type WHERE id = '$state' AND int_id = '$sint_id'";
            $state1 = mysqli_query($connection, $stateg);
            $out = '';
            while ($row = mysqli_fetch_array($state1))
            {
                $dep = $row['depreciation_value'];
            $out .= '
                <div class="form-group">
                    <label class="bmd-label-floating">Depreciation(%)</label>
                    <input type="number" value="'.$dep.'"class="form-control" name="depre">
                </div>
            ';
            }
            echo $out;
    }
    // Asset no
    if(isset($_POST['asset_no'])){
        $asse = $_POST['asset_no'];

        $rer = "SELECT * FROM assets WHERE asset_type_id = '$asse' AND int_id = '$sint_id'";
        $sdfoidf = mysqli_query($connection, $rer);
        $fdio = mysqli_num_rows($sdfoidf);
        $no = $fdio + 1;
        $asset_no = $sint_id."00".$asse."0".$no;

        $fddpfs = '
        <div class="form-group">
            <label class="bmd-label-floating">Asset No</label>
            <input type="number" value="'.$asset_no.'" class="form-control" name="ass_no">
        </div>
        ';
        echo $fddpfs;
    }
?>