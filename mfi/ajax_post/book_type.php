<?php
session_start();
include('../../functions/connect.php');
?>
<?php
if(isset($_POST['id'])){
$id = $_POST['id'];
    if($id == "2"){
        $out = '<label class="bmd-label-floating">No of Leaves</label>
        <select name="no_leaves" class="form-control" id="">
            <option value="">select an option</option>
            <option value="50">1-50</option>
            <option value="100">1-100</option>
            <option value="150">1-150</option>
            <option value="200">1-200</option>
        </select>
        ';
       echo $out;
    }
    else if($id == "1"){
        $out = '
        ';
       echo $out;
    }
}
?>