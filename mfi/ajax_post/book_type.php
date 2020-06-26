<?php
session_start();
include('../../functions/connect.php');
?>
<?php
if(isset($_POST['id'])){
$id = $_POST['id'];
    if($id == "chq"){
        $out = '<label class="bmd-label-floating">No of Leaves</label>
        <select name="no_leaves" class="form-control" id="">
            <option value="">select an option</option>
            <option value="1_50">1-50</option>
            <option value="51_100">51-100</option>
            <option value="101_150">101-150</option>
            <option value="151_200">151-200</option>
        </select>
        ';
       echo $out;
    }
    else if($id == "pass"){
        $out = '<label class="bmd-label-floating">No of Leaves</label>
        <input type="number" class="form-control" name="no_leaves"/>
        ';
       echo $out;
    }
}
?>