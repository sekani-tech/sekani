<?php
session_start();
include('../../functions/connect.php');
?>
<?php
if(isset($_POST['id'])){
$id = $_POST['id'];

    if($id == "2"){
        function fill_charge($connection) {
            $sint_id = $_SESSION["int_id"];
            $org = "SELECT * FROM charge WHERE int_id = '$sint_id' AND ((name LIKE '%cheque%') OR (name LIKE '%chq%') OR (name LIKE '%check%'))";
            $res = mysqli_query($connection, $org);
            $out = '';
            while ($row = mysqli_fetch_array($res))
            {
              $out .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
            }
            return $out;
          }
        $out = '<div class="col-md-6">
        <div id="done" class="form-group">
          <label class="bmd-label-floating">No of Leaves</label>
          <select name="no_leaves" class="form-control">
          <option hidden value="0">select an option</option>
          <option value="50">1-50</option>
          <option value="100">1-100</option>
          <option value="150">1-150</option>
          <option value="200">1-200</option>
        </select>
        </div>
      </div>
      <div class="col-md-6">
        <div id="" class="form-group">
          <label class="bmd-label-floating">Charge Applied</label>
          <select name="no_leaves" class="form-control" id="acc_name">
          <option hidden value="0">select an option</option>
          '.fill_charge($connection).'
        </select>
        </div>
      </div>
        ';
       echo $out;
    }
    else if($id == "1"){
        function fill_charge($connection) {
            $sint_id = $_SESSION["int_id"];
            $org = "SELECT * FROM charge WHERE int_id = '$sint_id' AND ((name LIKE '%pass%') OR (name LIKE '%pas%') OR (name LIKE '%passbook%'))";
            $res = mysqli_query($connection, $org);
            $out = '';
            while ($row = mysqli_fetch_array($res))
            {
              $out .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
            }
            return $out;
          }
        $out = '
        <div class="col-md-6">
        <div id="" class="form-group">
          <label class="bmd-label-floating">Charge Applied</label>
          <select name="charge_app" class="form-control">
          '.fill_charge($connection).'
        </select>
        </div>
      </div>
        ';
       echo $out;
    }
}
?>