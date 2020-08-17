<?php
include("../../functions/connect.php");
session_start();
$fof = $_SESSION['int_id'];

if(isset($_POST['id'])){
    $state = $_POST['id'];

    if($state == "1")
    {
        function fill_portal($connection, $fof)
                  {
                    $stateg = "SELECT * FROM int_vault WHERE int_id = '$fof'";
                    $state1 = mysqli_query($connection, $stateg);
                    $out = '';
                    while ($row = mysqli_fetch_array($state1))
                    {
                        $brid = $row['branch_id'];
                        $sdsdsd = "SELECT * FROM branch WHERE id = '$brid' AND int_id = '$fof'";
                        $wrer = mysqli_query($connection, $sdsdsd);
                        $dc = mysqli_fetch_array($wrer);
                        $bname = $dc['name'];
                    $out .= '
                    <option value="'.$row["id"].'">'.$bname.' vault</option>';
                    }
                  return $out;
                  }
                  $dom = '
                  <div class="row">
                  <div class="col-md-6">
                  <div class="form-group">
                      <label class="bmd-label-floating">Portal</label>
                      <input type="text" id="wewe" value="'.$state.'" readonly hidden/>
                      <select id ="selectds" name="assign" class="form-control">
                      <option hidden>select an option</option>
                      '.fill_portal($connection, $fof).'
                      </select>
                    </div>
                  </div>
                  <div id="worl" class="col-md-6">

                  </div>
                  </div>
            ';
            echo $dom;
    }
    else if($state == "2")
    {
      function fill_portal($connection, $fof)
      {
        $stateg = "SELECT * FROM charge WHERE int_id = '$fof'";
        $state1 = mysqli_query($connection, $stateg);
        $out = '';
        while ($row = mysqli_fetch_array($state1))
        {
        $out .= '
        <option value="'.$row["id"].'">'.$row["name"].'</option>';
        }
      return $out;
      }
      $dom = '
      <div class="row">
      <div class="col-md-6">
      <div class="form-group">
          <label class="bmd-label-floating">Portal</label>
          <input type="text" id="wewe" value="'.$state.'" readonly hidden/>
          <select id ="selectds" name="assign" class="form-control">
          <option hidden>select an option</option>
          '.fill_portal($connection, $fof).'
          </select>
        </div>
      </div>
      <div id="worl" class="col-md-6">

      </div>
      </div>
';
echo $dom;
    }
    else if($state == "3")
    {
      $dfdff = "SELECT * FROM institution_account WHERE int_id = '$fof'";
      $eroer = mysqli_query($connection, $dfdff);
      $dk = mysqli_fetch_array($eroer);
      $sdd = $dk['gl_code'];

      $tjnt = "SELECT * FROM acc_gl_account WHERE int_id = '$fof' AND gl_code = '$sdd'";
      $sdsddc = mysqli_query($connection, $tjnt);
      $as = mysqli_fetch_array($sdsddc);
      $dss = $as['name'];

      $dom = '
      <div class="row">
      <div class="col-md-6">
      <div class="form-group">
      <label class="bmd-label-floating">Current Gl Assigned to:</label>
      <input class="form-control" type="text" value="'.$dss.'" readonly/>
      </div>
      </div>
      </div>
      ';
      echo $dom;
    }
    }
    else {
        echo 'ID not posted';
    }
?>
<script>
  $(document).ready(function () {
    $('#selectds').on("change", function () {
      var id = $(this).val();
      var type = $('#wewe').val();
      $.ajax({
        url: "ajax_post/view_current_gl.php", 
        method: "POST",
        data:{id:id, type:type},
        success: function (data) {
          $('#worl').html(data);
        }
      })
    });
  });
</script>