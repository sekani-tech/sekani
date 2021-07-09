<?php

$page_title = "End Of Month";
$destination = "";
include("header.php");
?>
<<<<<<< HEAD
<?php
    $exp_error = "";
    if(isset($_GET['message'])) {
        $key = $_GET['message'];
        $tt = 0;
        // $out = $_SESSION['end_of_month_$key'];
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
        $_SESSION['end_of_month_$key'] = 0;
    } else if(isset($_GET['message1'])) {
        $key = $_GET['message1'];
        $tt = 0;
        // $out = $_SESSION['end_of_month_$key'];
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
        $_SESSION['end_of_month_$key'] = 0;
    }  else if(isset($_GET['message2'])) {
        $key = $_GET['message2'];
        $tt = 0;
        // $out = $_SESSION['end_of_month_$key'];
        echo '<script type="text/javascript">
                $(document).ready(function(){
                    swal({
                        type: "warning",
                        title: "Warning",
                        text: "'.$_SESSION['feedback'].'",
                        showConfirmButton: true,
                        timer: 7000
                    })
                });
                </script>
        ';
        $_SESSION['end_of_month_$key'] = 0;
            }
?>
=======
>>>>>>> Victor

<script src="../assets/js/bootstrap4-toggle.min.js"></script>
<link href="../assets/css/bootstrap4-toggle.min.css" rel="stylesheet">
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">End of Month</h4>
                        <p class="category">Closing of the Business Month</p>
                    </div>
                    <div class="card-body">
                        <div class="row">


                            <div class="col-md-6">
                                <form action="../functions/endofdayaccount/endofmonth.php" method="POST">
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
                                    <button type="submit" name="endofmonth" class="btn btn-primary btn-round">End Month</button>
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
                        <h4 class="card-title">End of Month Report</h4>
                        <p class="category">Generate End of Month Report</p>
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
=======
                                <form action="">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="">Start Date</label>
                                            <input type="date" name="" id="" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">End Date</label>
                                            <input type="date" name="" id="" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Branch</label>
                                            <select name="" id="" class="form-control">


>>>>>>> Victor
                                            </select>
                                        </div>
                                    </div>


<<<<<<< HEAD
                                    <button id = "reset" type="reset" class="btn btn-danger">Reset</button>
                                    <button id="runperform" name = "generateReport" type="submit" class="btn btn-primary">Generate Report</button>
                                </form>
                            </div>
                        </div>
                        <div class="row mt-4" id = "toShow">
                            <div class="col-md-12">

                                <table id="eodr" class="display" style="width:100%">
=======
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                    <span id="runperform" type="submit" class="btn btn-primary">Generate Report</span>
                                </form>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">

                                <table id="eomr" class="display" style="width:100%">
>>>>>>> Victor
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Date</th>
                                            <th>Closed By</th>
                                            <th>Month</th>
                                            <th>Year</th>
<<<<<<< HEAD
                                            <!-- <th>Action</th> -->
                                        </tr>

                                    </thead>
                                    <tbody id = "eod_set">
                                        <!-- <tr>
                                            <input type="hidden" id="toggleID" value="">
                                            <td></td>
=======
                                            <th>Action</th>
                                        </tr>

                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td> </td>
>>>>>>> Victor
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
<<<<<<< HEAD
                                        </tr> -->
                                    </tbody>


                                </table>

=======
                                            <td><input type="checkbox" checked data-toggle="toggle" data-on="Open" data-off="Closed" data-onstyle="success" data-offstyle="danger">
                                            </td>
                                        </tr>

                                    </tbody>

                                </table>

                                <script>
                                    $(document).ready(function() {
                                        $('#eomr').DataTable();
                                    });
                                </script>
>>>>>>> Victor

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>

</div>
<<<<<<< HEAD
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
                    url:'../functions/endofdayaccount/endofmonth.php',
                    method: 'POST',
                    data: {startDate,endDate, branch},
                    dataType: 'json',
                    cache: false,
                    success: function(res) {
                        $('.odd').hide();
                        $('#runperform').hide();
                        res.forEach(({id,created_on,staff_name,month,year})=>{
                            $("#eod_set").append(`
                                <tr>
                                    <input type="hidden" id="toggleID" value="">
                                    <td>${id}</td>
                                    <td>${created_on}</td>
                                    <td>${staff_name}</td>
                                    <td>${month}</td>
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
>>>>>>> Victor


<?php
include("footer.php");
?>