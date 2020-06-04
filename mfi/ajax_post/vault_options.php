<?php
include("../../functions/connect.php");
session_start();
$output = '';
$val = $_POST['id'];
  // we are gonna post to get the name of the button
  if ($val == 'vault_in' || $val == 'vault_out') {
    $name = $_POST['id'];

    function fill_teller($connection) {
      $bch_id = $_SESSION["branch_id"];
      $sint_id = $_SESSION["int_id"];
      $org = "SELECT * FROM tellers WHERE int_id = '$sint_id' && branch_id = '$bch_id'";
      $res = mysqli_query($connection, $org);
      $out = '';
      while ($row = mysqli_fetch_array($res))
      {
        $out .= '<option value="'.$row["name"].'">'.$row["description"].'</option>';
      }
      return $out;
    }
$output='
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
  <!-- populate from db -->
    <label class="bmd-label-floating"> Teller Name</label>
    <select name="teller_id" id="tell" class="form-control">
      <option value="0">SELECT A TELLER</option>
        '.fill_teller($connection).'
    </select>
    </div>
</div>
<div id = "tell_acc"></div>
</div>';
    echo $output;
  }
    else if($val == 'from_bank' || $val == 'to_bank'){

      function fill_payment($connection)
                  {
                  $sint_id = $_SESSION["int_id"];
                  $org = "SELECT * FROM payment_type WHERE int_id = '$sint_id'";
                  $res = mysqli_query($connection, $org);
                  $out = '';
                  while ($row = mysqli_fetch_array($res))
                  {
                    $out .= '<option value="'.$row["gl_code"].'">'.$row["value"].'</option>';
                  }
                  return $out;
                  }

      $output='
    <div class="form-group">
    <label class="bmd-label-floating">Bank</label>
    <select name="bank_type" id="tell" class="form-control">
      <option value="0">Select Bank</option>
        '.fill_payment($connection).'
    </select>
    </div>';
    echo $output;
    }
    else{
      echo '';
    }

    ?>
    <script>
    $(document).ready(function() {
      $('#tell').change(function(){
        var id = $(this).val();
        $.ajax({
          url:"ajax_post/sub_ajax/teller_balance.php",
          method:"POST",
          data:{id:id},
          success:function(data){
            $('#tell_acc').html(data);
          }
        })
      });
    })
  </script>