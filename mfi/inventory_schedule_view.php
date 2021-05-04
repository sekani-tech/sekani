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
                        <table id="isv" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Units</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>01</td>
                                    <td>Desk</td>
                                    <td>N800,000.00</td>
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
        $('#isv').DataTable();
    });
</script>

<?php
include("footer.php");
?>