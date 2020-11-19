<?php
include("../../functions/connect.php");
session_start();
$output = '';
$val = "vault_in";
  // we are gonna post to get the name of the button
  if ($val == 'vault_in' || $val == 'vault_out') {
    $name = $_POST['id'];
    
    $sint_id = $_SESSION["int_id"];
    $bch_id = $_SESSION["branch_id"];
    $head_find = "SELECT parent_id FROM branch WHERE int_id = '$sint_id' and id = '$bch_id'";
    $branch_result = mysqli_query($connection, $head_find);
    if($branch_result){
      $id = mysqli_fetch_array($branch_result);
      $parent_id = $id['parent_id'];
      // var_dump($parent_id);
      // echo $parent_id;
      
    }
    
    if($parent_id == '0'){
      function fill_teller($connection) {
        $sint_id = $_SESSION["int_id"];
        $orgs = selectAll('tellers', ['int_id'=>$sint_id]);
        
        $out = '';
        foreach ($orgs as $org)
        {
          $out .= '<option value="'.$org["name"].'">'.$org["description"].'</option>';
        }
        return $out;
      }
    }else{
      function fill_teller($connection) {
        $bch_id = $_SESSION["branch_id"];
        $sint_id = $_SESSION["int_id"];
        $org = "SELECT * FROM tellers WHERE int_id = '$sint_id' AND branch_id = '$bch_id'";
        $res = mysqli_query($connection, $org);
        $out = '';
        while ($row = mysqli_fetch_array($res))
        {
          $out .= '<option value="'.$row["name"].'">'.$row["description"].'</option>';
        }
        return $out;
      }
    }
?>
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
    <label class="bmd-label-floating"> Teller Name</label>
    <input type="text" hidden name ="cash" value =""/>
    <select name="teller_id" id="tell" class="form-control">
      <option value="0">SELECT A TELLER</option>
        <?php echo fill_teller($connection) ?>
    </select>
    </div>
</div>
<div id = "tell_acc"></div>
</div><?php
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
      <div class="row">
      <div class="col-md-6">
      <div class="form-group">
      <label class="bmd-label-floating">Bank</label>
      <select name="bank_type" id="bnk" class="form-control">
        <option value="0">Select Bank</option>
          '.fill_payment($connection).'
      </select>
      </div>
    </div>
    <div id = "bank_acc"></div>
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

    $(document).ready(function() {
      $('#bnk').change(function(){
        var ib = $(this).val();
        $.ajax({
          url:"ajax_post/sub_ajax/teller_balance.php",
          method:"POST",
          data:{ib:ib},
          success:function(data){
            $('#bank_acc').html(data);
          }
        })
      });
    })
  </script>