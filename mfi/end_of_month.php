<?php

$page_title = "End Of Month";
$destination = "";
include("header.php");
?>
<?php
if (isset($_POST['status']) && isset($_POST['id'])) {
    $status = $_POST['status'];
    $id = $_POST['id'];
    $query = mysqli_query($connection, "UPDATE endofmonth_tb SET status=$status WHERE id=$id");
}
function branch($connection)
{
    $sint_id = $_SESSION["int_id"];
    $guuy = $_SESSION['branch_id'];
    $org = "SELECT * FROM branch WHERE int_id = '$sint_id' AND (id = '$guuy' OR parent_id = '$guuy')";
    $res = mysqli_query($connection, $org);
    $out = '';
    while ($row = mysqli_fetch_array($res)) {
        $out .= '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
    }
    return $out;
}
?>
<?php
if (isset($_GET["message1"])) {
    $key = $_GET["message1"];
    $tt = 0;
    echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Month Successfully closed",
          text: "Day Successfully closed",
          showConfirmButton: false,
          timer: 60000
      })
  });
  </script>
  ';
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
                        <h4 class="card-title">End of Month</h4>
                        <p class="category">Closing of the Business Month</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            
                                
                                <div class="col-md-6">
                                <form action="../functions/endofdayaccount/endofmonth.php" method="POST">
                                    <div class="form-group">
                                        <label>Select Date<span style="color: red;">*</span>:</label>
                                        <input type="date" name="dateclosed" id="" class="form-control" required>
                                    </div>
                                </div>


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
                        <h4 class="card-title">End of Month Report</h4>
                        <p class="category">Generate End of Month Report</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
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
                                                <?php echo branch($connection); ?>

                                            </select>
                                        </div>
                                    </div>

                                    <script>
                                        $(document).ready(function() {
                                            $('#generateDLAR').on("click", function() {
                                                var start = $('#start').val();
                                                var end = $('#end').val();
                                                var branch_id = $('#branch_id').val();

                                                $.ajax({
                                                    url: "ajax_post/end_of_day.php",
                                                    method: "POST",
                                                    data: {
                                                        start: start,
                                                        end: end,
                                                        branch_id: branch_id
                                                    },
                                                    success: function(data) {
                                                        $('#showDisbursedLoans').html(data);
                                                    }
                                                })
                                            });
                                        });
                                    </script>
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                    <span id="runperform" type="submit" class="btn btn-primary">Generate Report</span>
                                </form>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <?php
                                $result = mysqli_query($connection, "SELECT * FROM endofmonth_tb")
                                ?>
                                <table id="eomr" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Date</th>
                                            <th>Closed By</th>
                                            <th>Month</th>
                                            <th>Year</th>
                                            <th>Action</th>
                                        </tr>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                    </thead>
                                    <tbody>
                                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
                                        </script>
                                        <script>
                                            $(document).ready(function() {
                                                $('.btn').click(function() {

                                                    $('.btn').hide();
                                                    $(this).attr('id') === 'open' ? $('#close').show() : $('#open').show()
                                                })
                                            })
                                        </script>
                                        <tr>
                                            <input type="hidden" id="toggleID" value="<?php echo $row['id']; ?>">
                                            <td><?php echo $row['id']; ?> </td>
                                            <td><?php echo $row['dateclosed']; ?></td>
                                            <td><?php echo $row['closed_by']; ?></td>
                                            <td><?php echo $row['monthend']; ?></td>
                                            <td><?php echo $row['yearclosed']; ?></td>
                                            <td><input type="checkbox" checked data-toggle="toggle" data-on="Open" data-off="Closed" data-onstyle="success" data-offstyle="danger">
                                            </td>
                                        </tr>

                                    </tbody>
                                <?php
                                        }
                                ?>
                                </table>
                                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
                                </script>

                                <script>
                                    $(document).ready(function() {
                                        $('#open').click(function() {
                                            const status = 1;
                                            const id = $('#toggleID').val();
                                            $.ajax({
                                                type: 'POST',
                                                url: 'end_of_month.php',
                                                data: {
                                                    status: status,
                                                    id: id
                                                },
                                                success: function(data) {
                                                    alert('Report is now Open');
                                                },
                                                error: function() {
                                                    alert('Sorry there was an error');
                                                }

                                            });
                                        });
                                    });
                                    $(document).ready(function() {
                                        $('#close').click(function() {
                                            const status = 0;
                                            const id = $('#toggleID').val();
                                            $.ajax({
                                                type: 'post',
                                                url: 'end_of_month.php',
                                                data: {
                                                    status: status,
                                                    id: id
                                                },
                                                success: function(data) {
                                                    alert('Report is closed ');
                                                },
                                                error: function() {
                                                    alert('Sorry there was an error');
                                                }
                                            });
                                        });
                                    });
                                </script>
                                </script>
                                <script>
                                    $(document).ready(function() {
                                        $('#eomr').DataTable();
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