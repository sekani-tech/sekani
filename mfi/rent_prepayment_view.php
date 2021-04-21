<?php

$page_title = "Rent Prepayment View";
$destination = "";
include("header.php");
?>



<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Rent Repayment</h4>
                        <!-- <p class="category">Category subtitle</p> -->
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="card card-profile ml-auto mr-auto" style="max-width: 370px; max-height: 360px">
                                <div class="card-body ">
                                    <h4 class="card-title"><b>₦200,000</b></h4>
                                    <h6 class="card-category text-gray">YEAR: 2021</h6>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <table id="rent" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            
                                            <th>Month</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            
                                            <td>June</td>
                                            <td>₦300,000</td>
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
        $('#rent').DataTable();
    });
</script>



<?php
include("footer.php");
?>