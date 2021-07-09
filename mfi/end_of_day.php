<?php
$page_title = "End Of Day";
$destination = "";
include("header.php");
<<<<<<< HEAD

if(isset($_GET['message1'])) {
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
=======
if (isset($_GET["response"])) {
$response = $_GET['response'];
 if ($response == 'success'){
    echo '<script type="text/javascript">
      $(document).ready(function(){
          swal({
              type: "success",
              title: "Success",
              text: "EOD successfully added!",
              showConfirmButton: true
          })
      });
      </script>
      ';
 }else if ($response == 'auto_vault'){
    echo '<script type="text/javascript">
      $(document).ready(function(){
          swal({
              type: "warning",
              title: "EOD operation failed!",
              text: "Click \"Continue\" to automatically update Tellers before executing EOD",
              showConfirmButton: true,
              confirmButtonText: "Continue"
          }).then(function() {
            window.location = "update_tellers.php";
        });
      });
      </script>
      ';
 }else if ($response == 'manual_vault'){
    echo '<script type="text/javascript">
      $(document).ready(function(){
          swal({
              type: "error",
              title: "Not Allowed!",
              text: "Kindly balance your books, click \"Proceed\" to run operation!",
              showConfirmButton: true,
              confirmButtonText: "Proceed"
          }).then(function() {
            window.location = "teller_journal.php";
        });
      });
      </script>
      ';
 }

>>>>>>> Victor
}
?>
<script src="../assets/js/bootstrap4-toggle.min.js"></script>
<link href = "../assets/css/bootstrap4-toggle.min.css"   rel ="stylesheet">

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">End of Day</h4>
                        <p class="category">Closing of the Business Day</p>
                    </div>
                    <div class="card-body">
                        <div class="row">


                            <div class="col-md-6">
<<<<<<< HEAD
                                <form action="" method="POST">
                                    <div class="form-group">
                                        <label>Select Date<span style="color: red;">*</span>:</label>
                                        <input type="date" name="dateclosed" id="" class="form-control" required>
                                    </div>
                            </div>


=======
                                <form action="../functions/endofdayaccount/end_of_day.php" method="POST">
                                    <div class="form-group">
                                        <label>Select Date<span style="color: red;">*</span>:</label>
                                        <input type="text" name="dateclosed" id="eod_date" class="form-control" required style="position: relative; z-index: 100000;">
                                    </div>
                            </div>
                            <?php
    if ($stmt = $connection->prepare("SELECT transaction_date FROM endofday_tb")) {
        $stmt->bind_result($name);
        $OK = $stmt->execute();
    }
    //put all of the resulting names into a PHP array
    $result_array = Array();
    while($stmt->fetch()) {
        $result_array[] = $name;
    }
    //convert the PHP array into JSON format, so it works with javascript
    $json_array = json_encode($result_array);?>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        var dates = <?php echo $json_array; ?>

function DisableDates(date) {
    var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
    return [dates.indexOf(string) == -1];
}

$(function() {
     $("#eod_date").datepicker({
         beforeShowDay: DisableDates
     });
});
    </script>
>>>>>>> Victor
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span style="color: red;"></span></label><br>
                                    <button type="submit" name="endofday" class="btn btn-primary btn-round">End Day</button>
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
                        <h4 class="card-title">End of Day Report</h4>
                        <p class="category">Generate End of Day Report</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
<<<<<<< HEAD
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


=======
                                <form  method="POST">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="">Start Date</label>
                                            <input type="date" id="start" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">End Date</label>
                                            <input type="date" id="end" class="form-control">
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
>>>>>>> Victor
                                            </select>
                                        </div>
                                    </div>

                                    <button type="reset" class="btn btn-danger">Reset</button>
                                    <span id="runperform" type="submit" class="btn btn-primary">Generate Report</span>

                                </form>
                            </div>
                        </div>
<<<<<<< HEAD

                        <div class="row mt-4">
                            <div class="col-md-12">

                                <table id="eodr" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Date</th>
                                            <th>Closed By</th>
                                            <th>Action</th>
                                        </tr>

                                    </thead>
                                    <tbody>

                                        <tr>
                                            <input type="hidden" id="toggleID" value="">
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                            <td><input type="checkbox" checked data-toggle="toggle" data-on="Open" data-off="Closed" data-onstyle="success" data-offstyle="danger"></td>
                                        </tr>
                                    </tbody>


                                </table>


=======
                        <script>
                        $(document).ready(function() {
                            $('#runperform').on("click", function() {
                                var start = $('#start').val();
                                var end = $('#end').val();
                                var branch_id = $('#branch').val();
                                $.ajax({
                                    url: "items/end_of_day_data.php",
                                    method: "POST",
                                    data: {
                                        start: start,
                                        end: end,
                                        branch_id: branch_id
                                    },
                                    success: function(data) {
                                        $('#eodr tbody').html(data);
                                    }
                                })
                            });
                        });
                    </script>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <table id="eodr" class="display" style="width:100%">
                                         <thead>
                                            <tr>
                                              <th>ID</th>
                                              <th>Date</th>
                                              <th>Closed By</th>
                                              <th>Action</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            
                                          </tbody>
                                </table>
>>>>>>> Victor
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>

</div>
<script>
<<<<<<< HEAD
                                    $(document).ready(function() {
                                        $('#eodr').DataTable();
                                    });
                                </script>
=======
    $(document).ready(function() {
    $('#eodr').DataTable();
    });
</script>
>>>>>>> Victor

<?php
include("footer.php");
?>