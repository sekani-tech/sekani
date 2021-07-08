<?php
include("../../functions/connect.php");
session_start();
$output = '';
$sint_id = $_SESSION['int_id'];

if(isset($_POST["paymentgl"]))
{
    $paymentgl = $_POST['paymentgl'];
    $accountgl = $_POST['accountgl'];
    $prod = $_POST['prod_id'];
    $dmsim = "SELECT * FROM prod_acct WHERE prod_id = '$prod' AND gl_code = '$paymentgl' && type ='pay'";
    $dsi = mysqli_query($connection, $dmsim);
    $i = mysqli_fetch_array($dsi);
    $dfe = $i['gl_code'];
    

    if($paymentgl == $dfe)
    {
        $prod = $_POST['prod_id'];
        
        $sql1 = "SELECT * FROM `acc_gl_account` WHERE gl_code = '$paymentgl' && int_id = '$sint_id'";
        $sql2 = "SELECT * FROM `acc_gl_account` WHERE gl_code = '$accountgl' && int_id = '$sint_id'";
        $xs = '';
        $chg = '';
          $result = mysqli_query($connection, $sql1);
          $result2x = mysqli_query($connection, $sql2);
          $o = mysqli_fetch_array($result);
          $ox = mysqli_fetch_array($result2x);
  
          $gl_name = $o["name"];
          $gl_name2 = $ox["name"];
          $inload = mysqli_query($connection, "UPDATE `prod_acct` SET `gl_code` = '{$paymentgl}', `name` = '{$gl_name}', `acct_gl_code` = '{$accountgl}', `acct` = '{$gl_name2}'
          WHERE int_id = '{$sint_id}' AND `gl_code` = '{$paymentgl}'");
         
          // $sql = "SELECT * FROM charge WHERE id = '".$_POST["id"]."'";
          $dis = "Updated";
    }
    else
    {
        $prod = $_POST['prod_id'];
        
      $sql1 = "SELECT * FROM `acc_gl_account` WHERE gl_code = '$paymentgl' && int_id = '$sint_id'";
      $sql2 = "SELECT * FROM `acc_gl_account` WHERE gl_code = '$accountgl' && int_id = '$sint_id'";
      $xs = '';
      $chg = '';
        $result = mysqli_query($connection, $sql1);
        $result2x = mysqli_query($connection, $sql2);
        $o = mysqli_fetch_array($result);
        $ox = mysqli_fetch_array($result2x);

        $gl_name = $o["name"];
        $gl_name2 = $ox["name"];
        $inload = mysqli_query($connection, "INSERT INTO `prod_acct` (`int_id`, `gl_code`, `name`, `acct_gl_code`, `acct`, `prod_id`, `type`)
         VALUES ('{$sint_id}', '{$paymentgl}', '{$gl_name}', '{$accountgl}', '{$gl_name2}', '{$prod}', 'pay')");
       
        // $sql = "SELECT * FROM charge WHERE id = '".$_POST["id"]."'";
        $dis = "Created";
    }
    $sqlx = "SELECT * FROM prod_acct WHERE prod_id = '$prod' && type ='pay'";
    $rmes = mysqli_query($connection, $sqlx);
    ?>
<div class="table-responsive">
<table id="tabledat" class="table" cellspacing="0" style="width:100%">
         <thead>
         <?php echo $dis;?>
           <th> <b> Payment Type </b></th>
           <th> <b>Assets Account <b></th>
         </thead>
  <tbody>
    <?php if (mysqli_num_rows($rmes) > 0) {
      while($roz = mysqli_fetch_array($rmes, MYSQLI_ASSOC)) {?> 
      <tr>
        <th> <?php echo $roz["name"] ?></th>
        <th><?php echo $roz["acct"] ?></th>
        <td><a class="btn btn-danger">Delete</a></td>
      </tr>
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
else if(isset($_POST["penaltygl"])){
    $penaltygl = $_POST['penaltygl'];
    $incomegl = $_POST['incomegl'];
    $prod = $_POST['prod_id'];
    $dmsim = "SELECT * FROM prod_acct WHERE prod_id = '$prod' AND gl_code = '$penaltygl' && type ='pen'";
    $dsi = mysqli_query($connection, $dmsim);
    $i = mysqli_fetch_array($dsi);
    $dfe = $i['gl_code'];
    

    if($penaltygl == $dfe)
    {
        $prod = $_POST['prod_id'];
        
        $sql1 = "SELECT * FROM `acc_gl_account` WHERE gl_code = '$penaltygl' && int_id = '$sint_id'";
        $sql2 = "SELECT * FROM `acc_gl_account` WHERE gl_code = '$incomegl' && int_id = '$sint_id'";
        $xs = '';
        $chg = '';
          $result = mysqli_query($connection, $sql1);
          $result2x = mysqli_query($connection, $sql2);
          $o = mysqli_fetch_array($result);
          $ox = mysqli_fetch_array($result2x);
  
          $gl_name = $o["name"];
          $gl_name2 = $ox["name"];
          $inload = mysqli_query($connection, "UPDATE `prod_acct` SET `gl_code` = '{$penaltygl}', `name` = '{$gl_name}', `acct_gl_code` = '{$incomegl}', `acct` = '{$gl_name2}'
          WHERE int_id = '{$sint_id}' AND `gl_code` = '{$penaltygl}'");
         
          // $sql = "SELECT * FROM charge WHERE id = '".$_POST["id"]."'";
          $dis = "Updated";
    }
    else
    {
        $prod = $_POST['prod_id'];
        
      $sql1 = "SELECT * FROM `acc_gl_account` WHERE gl_code = '$penaltygl' && int_id = '$sint_id'";
      $sql2 = "SELECT * FROM `acc_gl_account` WHERE gl_code = '$incomegl' && int_id = '$sint_id'";
      $xs = '';
      $chg = '';
        $result = mysqli_query($connection, $sql1);
        $result2x = mysqli_query($connection, $sql2);
        $o = mysqli_fetch_array($result);
        $ox = mysqli_fetch_array($result2x);

        $gl_name = $o["name"];
        $gl_name2 = $ox["name"];
        $inload = mysqli_query($connection, "INSERT INTO `prod_acct` (`int_id`, `gl_code`, `name`, `acct_gl_code`, `acct`, `prod_id`, `type`)
         VALUES ('{$sint_id}', '{$penaltygl}', '{$gl_name}', '{$incomegl}', '{$gl_name2}', '{$prod}', 'pen')");
       
        // $sql = "SELECT * FROM charge WHERE id = '".$_POST["id"]."'";
        $dis = "Created";
    }
    $sqlx = "SELECT * FROM prod_acct WHERE prod_id = '$prod' && type ='pen'";
    $rmes = mysqli_query($connection, $sqlx);
    ?>
<div class="table-responsive">
<table id="tabledat" class="table" cellspacing="0" style="width:100%">
         <thead>
         <?php echo $dis;?>
           <th> <b> Payment Type </b></th>
           <th> <b>Assets Account <b></th>
         </thead>
  <tbody>
    <?php if (mysqli_num_rows($rmes) > 0) {
      while($roz = mysqli_fetch_array($rmes, MYSQLI_ASSOC)) {?> 
      <tr>
        <th> <?php echo $roz["name"] ?></th>
        <th><?php echo $roz["acct"] ?></th>
        <td><a class="btn btn-danger">Delete</a></td>
      </tr>
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
<!-- posting now -->
