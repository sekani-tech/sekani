<?php
$page_title = "End Of Day";
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
                        <h4 class="card-title">End of Day</h4>
                        <p class="category">Closing of the Business Day</p>
                    </div>
                    <div class="card-body">
                        <div class="row">


                            <div class="col-md-6">
                                <form action="" method="POST">
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
                        <h4 class="card-title">End of Day Report</h4>
                        <p class="category">Generate End of Day Report</p>
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


                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>

</div>
<script>
                                    $(document).ready(function() {
                                        $('#eodr').DataTable();
                                    });
                                </script>

<?php
include("footer.php");
?>