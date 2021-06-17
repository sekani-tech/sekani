<?php

$page_title = "End Of Month";
$destination = "";
include("header.php");
?>

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
                                        <input type="date" min="<?php echo $minDate; ?>" max="<?php echo $today; ?>" name="closedDate" id="" class="form-control" required>
                                    </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span style="color: red;"></span></label><br>
                                    <button type="submit" name="endofmonth" class="btn btn-primary btn-round">End Month</button>
                                </div>

                                </form>
                                
                            </div>


                        </div>
                        
                        <?=isset($_GET['message1']) ? '<p style = "color:green">Month successfully ended</p>' : '';?>
                        <p style = "color:red"><?=isset($_GET['error']) ? $_GET['error'] : '';?></p>

                    </div>
                </div>
            </div>
        </div>


        <div class="row" id = "toShow">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">End of Month Report</h4>
                        <p class="category">Generate End of Month Report</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="">Start Date</label>
                                            <input type="date" name="startDate" value = "<?=isset($_POST['startDate']) ? $_POST['startDate'] : ''; ?>" id="startDate" class="form-control" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">End Date</label>
                                            <input type="date" name="endDate" value = "<?=isset($_POST['endDate']) ? $_POST['endDate'] : ''; ?>" id="endDate" class="form-control" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Branch</label>
                                            <select name="branch" id="branch" class="form-control" required>
                                            <option disabled="" selected value="">Choose branch</option>
                                            
                                            <!-- Get branches they can choose from -->
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
                        <div class="row mt-4">
                            <div class="col-md-12">

                                <table id="eomr" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Date</th>
                                            <th>Closed By</th>
                                            <th>Month</th>
                                            <th>Year</th>
                                            <!-- <th>Action</th> -->
                                        </tr>

                                    </thead>
                                    <tbody>
                                    <?php
                                        if(isset($_POST['generateReport'])) {
                                                // Generate End of Month Report
                                            $startDate = $_POST['startDate'];
                                            $endDate = $_POST['endDate'];
                                            $branch = $_POST['branch'];

                                            // convert to timestamp
                                            $startDate_timestamp = strtotime($startDate.' 00:00:00');
                                            $endDate_timestamp = strtotime($endDate.' 24:00:00');

                                            // if(trim($branch) !== "") {
                                            $result = selectAll('endofmonth_tb',['branch_id'=>$branch]);
                                            // } else {
                                            //     $result = selectAll('endofmonth_tb');
                                            // }

                                            // $generated_data = [];
                                            $generatedData = [];

                                            foreach($result as $r) {
                                                $created_on = strtotime($r['created_on']);
                                                if($created_on >= $startDate_timestamp && $created_on <= $endDate_timestamp) {
                                                    // Get staff name
                                                    $staff = selectAll('staff', ['id'=>$r['staff_id']]);
                                                    $r['staff_name'] = $staff[0]['display_name'];
                                                    // push data
                                                    array_push($generatedData, $r);
                                                }
                                            }
                                            foreach($generatedData as $row) {
                                                ?>
                                                <tr>
                                                    <td><?=$row['id']?></td>
                                                    <td><?=explode(' ',$row['created_on'])[0];
                                                    ?></td>
                                                    <td><?=$row['staff_name'];?></td>
                                                    <td><?=$row['month'];?></td>
                                                    <td><?=$row['year'];?></td>
                                                    <!-- <td><input onclick="action" class="action" data-id="<?=$row['id']?>" type="checkbox" checked="" data-toggle="toggle" data-on="Closed" data-off="Open" data-onstyle="danger" data-offstyle="success"></td> -->
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                                <script>
                                                $(function(){
                                                    $('html,body').animate({
                                                        scrollTop: $("#toShow").offset().top
                                                    },1000);
                                                })
                                                </script>
                                            <?php
                                        } 
                                    ?>

                                    </tbody>

                                </table>

                                <script>
                                    $(document).ready(function() {
                                        $('#eomr').DataTable();
                                        var btn = $("#runperform");
                                        var rst = $("#reset");
                                        var dbody = $("#eomr>tbody");
                                        // rst.click(function(){
                                        //     // dbody.hide();

                                        // })
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


<?php
include("footer.php");
?>