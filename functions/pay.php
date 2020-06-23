<?php
session_start();
    include("connect.php");
?>
<?php
$sok = $_POST['submit'];
  if ($sok) {
    $sessint_id = $_SESSION['int_id'];
    // check the button value
    $rog = $_POST['submit'];
    $add_pay = $_POST['submit'];
    if ($add_pay == 'add_payment'){
     $class = $_POST['acct_type']; 
      $name = $_POST['name'];
      $bran = $_SESSION["branch_id"];
      $desc = $_POST['des'];
      $default = $_POST['default'];
      $gl_type = $_POST['gl_type'];
      $gl_code = $_POST['gl_code'];

      $resu = "SELECT * FROM acc_gl_account WHERE int_id = '$sessint_id' AND parent_id = '$gl_type'";
      $relt = mysqli_query($connection, $resu);
      if ($relt) {
        $inr = mysqli_num_rows($relt);
        $gl_o = $inr + 1;
        $gl_no = '.'.$gl_o.'.';
    }
    if(isset($_POST['is_bank'])){
      $is_bank = 1;
    }else{
      $is_bank = 0;
    }
      if(isset($_POST['is_cash'])){
        $is_cash = 1;
      }else{
        $is_cash = 0;
      }
      $quoery = mysqli_query($connection, "INSERT INTO payment_type (int_id, branch_id, value, description, gl_code, is_cash_payment,
       is_bank, order_position)
      VALUES('{$sessint_id}', '{$bran}','{$name}', '{$desc}', '{$gl_code}', '{$is_cash}', '{$is_bank}', '{$default}')");
              echo header ("Location: ../mfi/products_config.php?message4=$randms");

      if($quoery){
        $glq ="INSERT INTO `acc_gl_account`(`int_id`, `branch_id`, `name`, `parent_id`, `hierarchy`, `gl_code`, `disabled`,
         `manual_journal_entries_allowed`, `account_usage`, `classification_enum`, `tag_id`, `description`, `reconciliation_enabled`,
          `organization_running_balance_derived`, `last_entry_id_derived`) VALUES ('{$sessint_id}', '{$bran}', '{$name}', '.{$gl_type}.',
           '{$gl_no}', '{$gl_code}', '0', '1', '1', '{$class}', NULL, '{$desc}', '0', '0.00', NULL)";

        $glw = mysqli_query($connection, $glq);
        if($glw){
        echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "success",
                title: "Created Successfully",
                text: " Payment type Created",
                showConfirmButton: false,
                timer: 2000
            })
        });
        </script>
        ';
        echo header ("Location: ../mfi/products_config.php?message4=$randms");
    }
      else{
        echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "error",
                title: "Failed",
                text: " Payment type failed",
                showConfirmButton: false,
                timer: 2000
            })
        });
        </script>
        ';
      }
      }
    }
  }
?>