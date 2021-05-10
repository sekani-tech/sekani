<?php

$page_title = "Inventory Schedule";
$destination = "";
include("header.php")
?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Inventory Schedule</h4>
                        <!-- <p class="category">Category subtitle</p> -->
                    </div>
                    <div class="card-body">

                        <!-- Button trigger modal -->
                        <button style="float: left;" type="button mb-4" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
                            Add Item
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add an Item to the Inventory Schedule</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    
                                                        <label>Name of Item<span style="color: red;">*</span>:</label>
                                                        <input type="name" class="form-control" name="nameofitem" value="" placeholder="Enter Name of Item..." required="">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="shortSharesName">Quantity of Item <span style="color: red;">*</span></label>
                                                    <input type="number" class="form-control" name="amount" value="" placeholder="Enter Quantity of Item..." required="">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                        <label>Price<span style="color: red;">*</span>:</label>
                                                        <input type="name" class="form-control" name="priceofitem" value="" placeholder="Enter Price of Item..." required="">
                                            </div>

                                            <div class="col-md-6">
                                            
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <table id="is" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Item</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>01</td>
                                    <td>Desk</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>
                                        <a href="inventory_schedule_view.php" class="btn btn-info">View</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        $('#is').DataTable();
    });
</script>

<?php
include("footer.php");
?>