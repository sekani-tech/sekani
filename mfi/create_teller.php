<?php

$page_title = "Create Teller";
$destination = "staff_mgmt.php";
    include("header.php");

    function fill_client($connection) {
      $sint_id = $_SESSION["int_id"];
      $org = "SELECT * FROM staff WHERE int_id = '$sint_id'";
      $res = mysqli_query($connection, $org);
      $out = '';
      while ($row = mysqli_fetch_array($res))
      {
        $out .= '<option value="'.$row["id"].'">'.$row["display_name"].'</option>';
      }
      return $out;
    }

?>
<?php
          if (isset($_GET["message"])) {
            $key = $_GET["message"];
            $tt = 0;
            if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
              echo '<script type="text/javascript">
                    $(document).ready(function(){
                        swal({
                            type: "success",
                            title: "Success",
                            text: "Loan Submitted Successfully, Awaiting Approval",
                            showConfirmButton: false,
                            timer: 2000
                        })
                    });
                    </script>
                    ';
              $_SESSION["lack_of_intfund_$key"] = 0;
            }
          }else if (isset($_GET["message2"])) {
            $key = $_GET["message2"];
            $tt = 0;
            if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
              echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "Error",
                        text: "Error in Posting For Approval",
                        showConfirmButton: false,
                        timer: 2000
                    })
                });
                </script>
                ';
            $_SESSION["lack_of_intfund_$key"] = 0;
            }
          }else if (isset($_GET["message3"])) {
            $key = $_GET["message3"];
            $tt = 0;
            if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
              echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "Error",
                        text: "This Client Has Been Given Loan Before",
                        showConfirmButton: false,
                        timer: 2000
                    })
                });
                </script>
                ';
            $_SESSION["lack_of_intfund_$key"] = 0;
            }
          }else if (isset($_GET["message4"])) {
            $key = $_GET["message4"];
            $tt = 0;
            if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
              echo '<script type="text/javascript">
                  $(document).ready(function(){
                      swal({
                      type: "error",
                      title: "Error",
                      text: "Insufficent Fund From Institution Account!",
                      showConfirmButton: false,
                      timer: 2000
                  })
              });
              </script>
              ';
            $_SESSION["lack_of_intfund_$key"] = 0;
            }
          }else if (isset($_GET["message5"])) {
            $key = $_GET["message5"];
            $tt = 0;
            if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
            echo '<script type="text/javascript">
            $(document).ready(function(){
                swal({
                    type: "error",
                    title: "Error",
                    text: "Error in Posting For Loan Gaurantor",
                    showConfirmButton: false,
                    timer: 2000
                })
            });
            </script>
            ';
            $_SESSION["lack_of_intfund_$key"] = 0;
            }
          }
        ?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Create teller</h4>
                  <p class="card-category">Fill in all important data</p>
                </div>
                <div class="card-body">
                  <form action="../functions/teller_upload.php" method="POST">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Teller Name</label>
                          <select name="tel_name" class="form-control" id="input">
                          <option value="">select an option</option>
                          <?php echo fill_client($connection); ?>
                        </select>
                        </div>
                      </div>
                  <script>
                              $(document).ready(function() {
                                $('#input').change(function(){
                                  var id = $(this).val();
                                  var tell_name = $('#input').val();
                                  $.ajax({
                                    url:"create_teller_branch.php",
                                    method:"POST",
                                    data:{id:id, tell_name:tell_name},
                                    success:function(data){
                                      $('#show_branch').html(data);
                                    }
                                  })
                                });
                              })
                            </script>
                      <div class="col-md-4">
                      <div class="form-group">
                        <label class="bmd-label-floating">Branch</label>
                        <!-- <div id="show_branch"></div> -->
                        <select id="show_branch" name="branch" class="form-control">

                        </select>
                      </div>
                      </div>
                      <div class="col-md-4 form-group">
                          <label class="bmd-label-floating" >Teller No</label>
                          <input type="text" name="teller_no" id="" class="form-control">
                      </div>
                      <div class="col-md-4 form-group">
                          <label class="bmd-label-floating" >Posting Limit</label>
                          <input type="text" name="post_limit" id="" class="form-control">
                      </div>
                      </div>
                      <a href="staff_mgmt.php" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary pull-right">Create Teller</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- /content -->
        </div>
      </div>

<?php

    include("footer.php");

?>