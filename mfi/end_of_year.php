<?php

$page_title = "End Of Year";
$destination = "";
include("header.php");
?>
<<<<<<< HEAD
<?php
    $exp_error = "";
    if(isset($_GET['message'])) {
        $key = $_GET['message'];
        $tt = 0;
        // $out = $_SESSION['end_of_Year_$key'];
        echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "success",
                        title: "Success",
                        text: "'.$_SESSION['feedback'].'",
                        showConfirmButton: true,
                        timer: 7000
                    })
                });
                </script>
        ';
    } else if(isset($_GET['message1'])) {
        $key = $_GET['message1'];
        $tt = 0;
        // $out = $_SESSION['end_of_Year_$key'];
        echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "error",
                        title: "Error",
                        text: "'.$_SESSION['feedback'].'",
                        showConfirmButton: true,
                        timer: 7000
                    })
                });
                </script>
        ';
    }
?>

<script src="../assets/js/bootstrap4-toggle.min.js"></script>
<link href="../assets/css/bootstrap4-toggle.min.css" rel="stylesheet">
=======

<script src="../assets/js/bootstrap4-toggle.min.js"></script>
<link href = "../assets/css/bootstrap4-toggle.min.css"   rel ="stylesheet">
>>>>>>> Victor
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
<<<<<<< HEAD
                                        <input type="date" min="<?php echo $minDate; ?>" max="<?php echo $today; ?>" name="closedDate" id="" class="form-control" required>
=======
                                        <input type="date" name="dateclosed" id="" class="form-control" required>
>>>>>>> Victor
                                    </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span style="color: red;"></span></label><br>
                                    <button type="submit" name="endofyear" class="btn btn-primary btn-round">End Year</button>
                                </div>

                                </form>
<<<<<<< HEAD
                                
                            </div>


                        </div>
                        
                     

=======
                            </div>
                        </div>
                        
>>>>>>> Victor
                    </div>
                </div>
            </div>
        </div>


<<<<<<< HEAD
        <div class="row" id = "toShow">
=======
        <div class="row">
>>>>>>> Victor
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">End of Year Report</h4>
                        <p class="category">Generate End of Year Report</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
<<<<<<< HEAD
                                <form>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="">Start Date</label>
                                            <input type="date" name="startDate" id="startDate" class="form-control" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">End Date</label>
                                            <input type="date" name="endDate" id="endDate" class="form-control" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Branch</label>
                                            <select name="branch" id="branch" class="form-control" required>
                                            <option disabled="" selected value="">Choose branch</option>
                                            
                                            <?php
                                                $branches = selectAll('branch',['int_id'=>$_SESSION['int_id']]);
                                                foreach($branches as $branch) {
                                                    if(isset($_POST['branch'])) {
                                                            if($_POST['branch'] == $branch['id']) {
                                                        ?>
                                                            <option value = "<?=$branch['id'];?>" selected><?=$branch['name'];?></option>
                                                        <?php
                                                    }
                                                    } else {
                                            ?>
                                                
                                                <option value = "<?=$branch['id'];?>"><?=$branch['name'];?></option>
                                            <?php
                                                    }
                                                }
                                            ?>
                                            </select>
                                        </div>
                                    </div>


                                    <button id = "reset" type="reset" class="btn btn-danger">Reset</button>
                                    <button id="runperform" name = "generateReport" type="submit" class="btn btn-primary">Generate Report</button>
                                </form>
                            </div>
                        </div>
                        <div class="row mt-4" id = "toShow">
                            <div class="col-md-12">

                                <table id="eodr" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                        <th>ID</th>
                                            <th>Date</th>
                                            <th>Closed By</th>
                                            <th>Closed Year</th>
                                            <!-- <th>Action</th> -->
                                        </tr>

                                    </thead>
                                    <tbody id = "eod_set">
                                        <!-- <tr>
                                            <input type="hidden" id="toggleID" value="">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr> -->
                                    </tbody>


                                </table>


                            </div>
                        </div>

=======
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
>>>>>>> Victor
                    </div>
                </div>
            </div>
        </div>
<<<<<<< HEAD


    </div>

</div>
<script>
    $(document).ready(function() {
        $('#eodr').DataTable();

        $("#reset").click(function(){
            $("#runperform").show();
            $("#eod_set").children().remove();
        })

        $("#runperform").click(function(e){
            e.preventDefault();

            
            var startDate = $("#startDate").val();
            var endDate =  $("#endDate").val();
            var branch = $("#branch").val();

            if(startDate.trim() == '' || endDate.trim() == '' || branch.trim() == '') {
                alert("Start date, end date and branch required!");
            } else {
                    $.ajax({
                    url:'../functions/endofdayaccount/endofYear.php',
                    method: 'POST',
                    data: {startDate,endDate, branch},
                    dataType: 'json',
                    cache: false,
                    success: function(res) {
                        $('.odd').hide();
                        $('#runperform').hide();
                        res.forEach(({id,created_on,staff_name,year})=>{
                            $("#eod_set").append(`
                                <tr>
                                    <input type="hidden" id="toggleID" value="">
                                    <td>${id}</td>
                                    <td>${created_on}</td>
                                    <td>${staff_name}</td>
                                    <td>${year}</td>
                                </tr>
                            `)
                            
                        $('#eodr').DataTable();

                        
                        })
                        $('html,body').animate({
                            scrollTop: $("#toShow").offset().top
                        },500);
                    },  
                    error: function(err) {
                        swal({
                            type: "error",
                            title: "Error",
                            text: "An error occurred while generating report",
                            showConfirmButton: true,
                            timer: 7000
                        })
                    }
                })
            }
            
 
        })
    });
    </script>


=======
    </div>
</div>
</div>
</div>
>>>>>>> Victor
<?php
include("footer.php");
?>