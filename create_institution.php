<?php
  include("header.php");
?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Institutions</h4>
                  <p class="card-category">Create New institution profile</p>
                </div>
                <div class="card-body">
                  <form action="functions/institution_data.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-check-label">Short Name</label>
                          <input type="text" class="form-control" name="int_name">
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <label class="form-check-label">Full Name</label>
                          <input type="text" class="form-control" name="int_full">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>RCN</label>
                          <input type="text" class="form-control" name="rcn">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-check-label">E-mail</label>
                          <input type="email" class="form-control" name="email">
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
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">State:</label>
                          <select id="static" class="form-control" style="text-transform: uppercase;" name="int_state">
                          <?php echo fill_state($connection);?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-check-label">LGA</label>
                          <select id="showme" class="form-control" style="text-transform: uppercase;" name="lga">
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-check-label">Title</label>
                                <select name="pc_title" class="form-control" id="">
                                    <option value="Mr">Mr</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Miss">Miss</option>
                                    <option value="Master">Master</option>
                                </select>
                            </div>
                        </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-check-label">Office Address</label>
                          <input type="text" class="form-control" name="office_address">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-check-label">Website</label>
                          <input type="text" class="form-control" name="website">
                        </div>
                      </div>
                      <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-check-label">Phone</label>
                                <input type="number" name="office_phone" class="form-control" id="">
                            </div>
                        </div>
                        <!-- <div class="clearfix"></div> -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-check-label">Primary Contact Surname</label>
                                <input type="text" name="pc_surname" class="form-control" id="">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-check-label">Primary Contact Other Names</label>
                                <input type="text" name="pc_other_name" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-check-label">Primary Contact Designation</label>
                                <input type="text" name="pc_designation" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-check-label">Primary Contact Phone</label>
                                <input type="tel" name="pc_phone" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-check-label">Primary Contact Email</label>
                                <input type="email" name="pc_email" class="form-control" id="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-check-label">Sender ID</label>
                                <input type="text" name="sender_id" class="form-control" id="">
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
                    <label for="file-insert" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input id ="file-insert" name="int_logo" type="file" class="inputFileHidden"/>
                    <label> Select Logo</label>
                    <div id="iup"></div>
                    </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">Create Institution</button>
                    <button type="reset" class="btn btn_danger">Reset</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

<?php

    include("footer.php");

?>