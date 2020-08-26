<?php
include("../functions/connect.php");
$output = '';
session_start();
// work
if(isset($_POST["id"]))
{
    $id = $_POST["id"];
    $int_id = $_POST["int_id"];
    $branch_id = $_POST["branch_id"];
    $main_p = $_POST["main_p"];
    if($_POST["id"] !='')
    {
     $dssdd = $_POST["id"];
     $dso = "SELECT * FROM charges_cache WHERE charge_id ='".$_POST["id"]."'";
     $dssa = mysqli_query($connection, $dso);
     $sdp = mysqli_fetch_array($dssa);
     if(isset($sdp)){
     $cha = $sdp['charge_id'];
     }
     else{
        $cha = 'okay';
     }
     if($dssdd == $cha){
        echo 'Charge already Applied';
     }
     else {
      $sql1 = "SELECT * FROM charge WHERE id = '".$_POST["id"]."'";
      $xs = '';
      $chg = '';
        $result = mysqli_query($connection, $sql1);
        $o = mysqli_fetch_array($result);
        $values = $o["charge_time_enum"];
        $nameofc = $o["name"];
        $forp = $o["charge_calculation_enum"];
        $main_p = $_SESSION["savings_temp"];
        $amt = number_format($o["amount"], 2);
        if ($forp == 1) {
          $chg = $amt." Flat";
        } else {
          $chg = $amt. "% of Loan Principal";
        }
        if ($values == 1) {
            $xs = "Disbursement";
          } else if ($values == 2) {
            $xs = "Manual Charge";
          } else if ($values == 3) {
            $xs = "Savings Activiation";
          } else if ($values == 5) {
            $xs = "Deposit Fee";
          } else if ($values == 6) {
            $xs = "Annual Fee";
          } else if ($values == 8) {
            $xs = "Installment Fees";
          } else if ($values == 9) {
            $xs = "Overdue Installment Fee";
          } else if ($values == 12) {
            $xs = "Disbursement - Paid With Repayment";
          } else if ($values == 13) {
            $xs = "Loan Rescheduling Fee";
          } 
        $int_id = $_POST["int_id"];
        $branch_id = $_POST["branch_id"];
        $charge_id = $_POST["id"];
        $colon = date('Y-m-d H:i:s');
        // $date_p = date('Y-m-d h:i:sa');
        $inload = mysqli_query($connection, "INSERT INTO charges_cache 
        (`int_id`, `branch_id`, `charge_id`, `name`, `charge`, `collected_on`,
        `date`, `is_status`, `cache_prod_id`)
        VALUES ('{$int_id}', '{$branch_id}', '{$charge_id}',
        '{$nameofc}', '{$chg}', '{$xs}', '{$colon}', '0', '{$main_p}')");
        $sql = "SELECT * FROM charge WHERE id = '".$_POST["id"]."'";
        echo 'Charge Added';
     }
    }
    else
    {
        $sql = "SELECT * FROM charges_cache WHERE int_id = '$int_id' && cache_prod_id = '$main_p' ";
    }
    $sql = "SELECT * FROM charges_cache WHERE int_id = '$int_id' && cache_prod_id = '$main_p' ";
    $result = mysqli_query($connection, $sql);
    ?>
    <input type="text" id="idq" value="<?php echo $charge_id; ?>" hidden>
    <input type="text" id="int_idq" value="<?php echo $int_id; ?>" hidden>
    <input type="text" id="main_pq" value="<?php echo $main_p; ?>" hidden>

    <div class="table-responsive">
  <table id="tabledat" class="table" cellspacing="0" style="width:100%">
  <thead class=" text-primary">
    <th>Name</th>
    <th>Charge</th>
    <th>Collected On</th>
    <th>Delete</th>
  </thead>
  <tbody>
    <?php if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?> 
      <tr>
        <th> <?php echo $row["name"] ?></th>
        <th><?php echo $row["charge"] ?></th>
        <th> <?php echo $row["collected_on"] ?></th>
        <input type="text" value="<?php $row["id"] ?>" hidden>
        <th> <button id="del" type="button" name="delete" class="btn btn-info">delete</button> </th>
      </tr>
      <script>
     $(document).ready(function () {
      $('#del').click();
     });
     </script>
      <?php
      }
    } else {
      // echo something
    }?>
  </tbody>
</table>
</div>
  <?php
    echo $output;
}
?>
<?php
if ($_GET) {
  if(isset($_GET['delete'])){
    $id = $row["id"];
      delete($connection, $id);
  }//elseif(isset($_GET['select'])){
      //select();
  //}
}
function delete($connection, $id)
    {
    	$delete1 = mysqli_query($connection, "DELETE FROM `charges_cache` WHERE id = '$id'");
        
	echo "record deleted";
    }
?>