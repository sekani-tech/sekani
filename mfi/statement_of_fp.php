<?php

$page_title = "STATEMENT OF FINANCIAL POSITION";
$destination = "report_financial.php";
include('header.php');

?>
<!-- Content added here -->
<!-- print content -->
<div class="content">

  <div class="container-fluid">

    <!-- your content here -->
    <div class="row">

      <div class="col-12">

        <div class="card">

          <div class="card-header card-header-primary">
              <h4 class="card-title">Statement of Financial Position</h4>
          </div>

          <div class="card-body">

            <form action="">

              <div class="row">

                <div class="form-group col-md-3">
                  <label for="">As At:</label>
                  <input type="date" name="" id="date" class="form-control">
                </div>

                <div class="form-group col-md-3">
                  <?php
                    function fill_branch($connection) {
                      $sint_id = $_SESSION["int_id"];
                      $org = "SELECT * FROM branch WHERE int_id = '$sint_id'";
                      $res = mysqli_query($connection, $org);
                      $out = '';

                      while ($row = mysqli_fetch_array($res))
                      {
                        $out .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                      }
                      
                      return $out;
                    }
                  ?>
                  <label for="">Branch</label>
                  <select name="" id="branch_id" class="form-control">
                      <?php echo fill_branch($connection); ?>
                  </select>
                </div>

              </div>

              <button type="reset" class="btn btn-danger">Reset</button>
              <span id="input" type="submit" class="btn btn-success">Run report</span>

            </form>

          </div>

          <script>
            $(document).ready(function () {
              $('#input').on("click", function () {
                var date = $('#date').val();
                var branch_id = $('#branch_id').val();
                $.ajax({
                  url: "ajax_post/reports_post/stmt_of_fp.php", 
                  method: "POST",
                  data:{date:date, branch_id:branch_id},
                  success: function (data) {
                    $('#outjournal').html(data);
                  }
                })
              });
            });
          </script>

        </div>

      </div>

      <div id="outjournal" class="col-md-9">

      </div>

    </div>

  </div>

</div>

<?php

include('footer.php');

?>