<?php
session_start();
include('../../functions/connect.php');
?>
<?php
if(isset($_POST['id'])){
  $dsd = $_POST['id'];
  if($dsd == "000"){
    $out = '<select name="acctdi" class="form-control">
    <option value="000">All Clients</option>
  </select>
    ';
          echo $out;
  }
else{
    function fill_account($connection) {
        $int_id = $_POST['ist'];
         $client_id = $_POST['id'];
         $pen = "SELECT * FROM account WHERE client_id = '$client_id'";
        $res = mysqli_query($connection, $pen);
        $out = '';
        while ($row = mysqli_fetch_array($res))
        {
          $product_type = $row["product_id"];
          $get_product = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$product_type' AND int_id = '$int_id'");
         while ($mer = mysqli_fetch_array($get_product)) {
           $p_n = $mer["name"];
           $out .= '<option value="'.$row["account_no"].'">'.$row["account_no"].' - '.$p_n.'</option>';
         }
        }
        return $out;
      }
      $out = '<select name="acct_no" class="form-control">
      '.fill_account($connection).'
    </select>
      ';
    
            echo $out;
    }
    }
    else {
        echo 'ID not posted';
    }
?>