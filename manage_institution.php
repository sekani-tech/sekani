<?php

    include("header.php");

?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
        <?php
          if (isset($_GET["edit"])) {
            $int_id = $_GET["edit"];
            $update = true;
            $person = mysqli_query($connection, "SELECT * FROM institutions WHERE int_id='$int_id'");

            if (count([$person]) == 1) {
              $n = mysqli_fetch_array($person);
              $int_id = $n['int_id'];
              $int_name = $n['int_name'];
              $rcn = $n['rcn'];
              $lga = $n['lga'];
              $int_state = $n['int_state'];
              $email = $n['email'];
              $office_address = $n['office_address'];
              $website = $n['website'];
              $office_phone = $n['office_phone'];
              $pc_title = $n['pc_title'];
              $pc_surname = $n['pc_surname'];
              $pc_other_name = $n['pc_other_name'];
              $pc_designation = $n['pc_designation'];
              $pc_phone = $n['pc_phone'];
              $pc_email = $n['pc_email'];
              $img = $n['img'];
              $int_img = $n['img'];
              $sender_id = $n['sender_id'];
              $facebook = $n['facebook'];
              $twitter = $n['twitter'];
              $instagram = $n['instagram'];
            }
          }
        ?>
          <!-- your content here -->
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Institutions</h4>
                  <p class="card-category">Complete institution profile</p>
                </div>
                <div class="card-body">
                  <form action="functions/update_institution.php" method="POST"  enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-md-1">
                        <div class="form-group">
                          <label class="bmd-label-floating">ID</label>
                          <input type="text" readonly value="<?php echo $int_id; ?>" class="form-control" name="int_id">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Name</label>
                          <input type="text" value="<?php echo $int_name; ?>" class="form-control" name="int_name">
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <label class="bmd-label-floating">Full Name</label>
                          <input type="text" value="<?php echo $int_name; ?>" class="form-control" name="int_name">
                        </div>
                      </div>
                      <?php
                          function fill_state($connection)
                            {
                            $org = "SELECT * FROM states";
                            $res = mysqli_query($connection, $org);
                            $out = '';
                            while ($row = mysqli_fetch_array($res))
                            {
                              $out .= '<option value="'.$row["name"].'">' .$row["name"]. '</option>';
                            }
                            return $out;
                            }?>
                      <script>
                    $(document).ready(function() {
                      $('#static').on("change", function(){
                        var id = $(this).val();
                        $.ajax({
                          url:"mfi/ajax_post/lga.php",
                          method:"POST",
                          data:{id:id},
                          success:function(data){
                            $('#showme').html(data);
                          }
                        })
                      });
                    });
                </script>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">State:</label>
                          <select id="static" class="form-control" style="text-transform: uppercase;" name="state">
                          <option value="<?php echo $int_state;?>" hidden><?php echo $int_state;?></option>
                          <?php echo fill_state($connection);?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-check-label">LGA</label>
                          <option value="<?php echo $lga;?>" hidden><?php echo $lga;?></option>
                          <select id="showme" class="form-control" style="text-transform: uppercase;" name="lga">
                          </select>
                        </div>
                      </div>
                  <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">RCN</label>
                          <input type="text" value="<?php echo $rcn; ?>" class="form-control" name="rcn">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">E-mail</label>
                          <input type="email" value="<?php echo $email; ?>" class="form-control" name="email">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Office Address</label>
                          <input type="text" value="<?php echo $office_address; ?>" class="form-control" name="office_address">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Website</label>
                          <input type="text" value="<?php echo $website; ?>" class="form-control" name="website">
                        </div>
                      </div>
                      <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Phone</label>
                                <input type="text" value="<?php echo $office_phone; ?>" name="office_phone" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Sender ID</label>
                                <input type="text" value="<?php echo $sender_id; ?>" name="sender_id" class="form-control" id="">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Title</label>
                                <select name="pc_title" value="<?php echo $pc_title; ?>" class="form-control" id="">
                                    <option value="Mr">Mr</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Miss">Miss</option>
                                    <option value="Master">Master</option>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="clearfix"></div> -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Primary Contact Surname</label>
                                <input type="text" value="<?php echo $pc_surname; ?>" name="pc_surname" class="form-control" id="">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Primary Contact Other Names</label>
                                <input type="text" value="<?php echo $pc_other_name; ?>" name="pc_other_name" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Primary Contact Designation</label>
                                <input type="text" value="<?php echo $pc_designation; ?>" name="pc_designation" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Primary Contact Phone</label>
                                <input type="tel" value="<?php echo $pc_phone; ?>" name="pc_phone" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Primary Contact Email</label>
                                <input type="email" value="<?php echo $pc_email; ?>" name="pc_email" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Facebook</label>
                                <input type="text" value="<?php echo $facebook; ?>" name="face" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Twitter</label>
                                <input type="text" value="<?php echo $twitter; ?>" name="tweet" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Instagram</label>
                                <input type="text" value="<?php echo $instagram; ?>" name="ingram" class="form-control" id="">
                            </div>
                        </div>
                        <style>
                        input[type="file"]{
                          display: none;
                        }
                        .custom-file-upload{
                          border: 1px solid #ccc;
                          display: inline-block;
                          padding: 6px 12px;
                          cursor: pointer;
                        }
                      </style>
                      <div class="col-md-4">
                    <label for="file-upload" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input id ="file-upload" name="passport" type="file" class="inputFileHidden"/>
                    <input type="text" hidden value="<?php echo $int_img;?>" name="int_img">
                    <label> Select Logo</label>
                    </div>
                    <script>
                      var changeq = document.getElementById( 'file-insert' );
                      var check = document.getElementById( 'iup' );
                      changeq.addEventListener( 'change', showme );
                      function showme( event ) {
                        var one = event.srcElement;
                        var fname = one.files[0].name;
                        check.textContent = 'File name: ' + fname;
                      }
                    </script>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">Update Profile</button>
                    <button type="reset" class="btn btn_default">Reset</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card card-profile">
                <div class="card-avatar">
                  <a href="#pablo">
                    <img class="img" src="<?php echo $img; ?>" />
                  </a>
                </div>
                <?php
                $sessint_id = $_SESSION["int_id"];
                $new = $int_name;
                $org_role = $_SESSION["org_role"];
                $inq = mysqli_query($connection, "SELECT * FROM institutions WHERE int_id='$sessint_id'");
                if (count([$inq]) == 1) {
                  $n = mysqli_fetch_array($inq);
                  $int_namex = $n['int_name'];
                }
                ?>
                <div class="card-body">
                  <h6 class="card-category text-gray"><?php echo $new; ?></h6>
                  <h4 class="card-title"> <?php echo $website; ?></h4>
                  <p class="card-description">
                  <?php echo $int_namex ?>
                  </p>
                  <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

<?php

    include("footer.php");

?>