<?php

$page_title = "End Of Year";
$destination = "";
include("header.php");
?>

<script src="../assets/js/bootstrap4-toggle.min.js"></script>
<link href = "../assets/css/bootstrap4-toggle.min.css"   rel ="stylesheet">
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">End of Year</h4>
                        <p class="category">Closing of the Business Year</p>
                    </div>
                    <div class="card-body">
                        <div class="row">


                            <div class="col-md-6">
                                <form action="../functions/endofdayaccount/endofyear.php" method="POST">
                                    <div class="form-group">
                                        <label>Select Date<span style="color: red;">*</span>:</label>
                                        <input type="date" name="dateclosed" id="" class="form-control" required>
                                    </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span style="color: red;"></span></label><br>
                                    <button type="submit" name="endofyear" class="btn btn-primary btn-round">End Year</button>
                                </div>

                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">End of Year Report</h4>
                        <p class="category">Generate End of Year Report</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="">Start Date</label>
                                            <input type="date" name="" id="start" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">End Date</label>
                                            <input type="date" name="" id="end" class="form-control">
                                        </div>
                                        <?php
                                    function fill_branch($connection)
                                    {
                                        $sint_id = $_SESSION["int_id"];
                                        $org = "SELECT * FROM branch WHERE int_id = '$sint_id'";
                                        $res = mysqli_query($connection, $org);
                                        $out = '';
                                        while ($row = mysqli_fetch_array($res)) {
                                            $out .= '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
                                        }
                                        return $out;
                                    }
                                    ?>
                                        <div class="form-group col-md-4">
                                            <label for="">Branch</label>
                                            <select name="" id="branch" class="form-control">
                                                <?php echo fill_branch($connection); ?>
                                            </select>
                                        </div>
                                    </div>
                                   
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                    <span id="runperform" type="submit" class="btn btn-primary">Generate Report</span>
                                </form>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                
                                <table id="eoyr" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Date</th>
                                            <th>Closed By</th>
                                            <th>Closed Year</th>
                                            <th>Action</th>
                                        </tr>
                                      
                                    </thead>
                                    <tbody>
                                    
                                    </tbody>
                                        <script>
                        $(document).ready(function() {
                            $('#runperform').on("click", function() {
                                var start = $('#start').val();
                                var end = $('#end').val();
                                var branch_id = $('#branch').val();
                                $.ajax({
                                    url: "items/end_of_year_data.php",
                                    method: "POST",
                                    data: {
                                        start: start,
                                        end: end,
                                        branch_id: branch_id
                                    },
                                    success: function(data) {
                                        $('#eoyr tbody').html(data);
                                    }
                                })
                            });
                        });
                    </script>
                                </table>
                              
                                <script>
                                    $(document).ready(function() {
                                        $('#eoyr').DataTable();
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<?php
include("footer.php");
?>