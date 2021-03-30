<?php

$page_title = "End Of Day";
$destination = "";
include("header.php");
?>


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
                        <table id="eod" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <form>
                                    <td></td>
                                    <td><input type="date" name="" id="" class="form-control" required></td>
                                    <td><button class="btn btn-primary btn-round">End Day</button></td>
                                </form>
                                </tr>

                            </tbody>
                        </table>
                        <script>
                            $(document).ready(function() {
                                $('#eod').DataTable();
                            });

                        </script>
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
                                        <div class="form-group col-md-6">
                                            <label for="">Date</label>
                                            <input type="date" name="" id="" class="form-control">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Branch</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Head Office</option>   
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
                                            <td></td>
                                            <td><input type="date" name="" id="" class="form-control"></td>
                                            <td></td>
                                            <td><button class="btn btn-primary btn-round">Open</button><button class="btn btn-primary btn-round">Close</button></td>
                                        </tr>

                                    </tbody>
                                </table>

                                <script>
                                    $(document).ready(function() {
                                        $('#eodr').DataTable();
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