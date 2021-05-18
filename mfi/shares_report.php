<?php

$page_title = "Shares Report";
$destination = "";
include("header.php");
?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Schedule for Sharesholders</h4>
                        <p class="category"></p>
                    </div>
                    <div class="card-body">
                    <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-profile ml-auto mr-auto" style="max-width: 360px; max-height: 360px">
                                        <div class="card-body ">
                                            <!-- <h4 class="card-title"> TEST </h4> -->
                                            <h4 class="card-category">Authorised Shares - </h4>
                                            <h4 class="card-category"> Allocated Shares - </h4>
                                            <h4 class="card-category"> Availabe Shares - </h4>
                                        </div>
                                        <!-- <div class="card-footer justify-content-center">
                                            <b> No 4, Alekuwodo area, Okefia, Osun state </b>
                                        </div>
                                        <div class="card-footer justify-content-center">
                                            <b> 03 May 2021 </b> 
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Shareholders Name</th>
                                    <th>Unit of Shares</th>
                                    <th>Value of Shares</th>
                                    <th>% of Shareholding</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr> 
                            </tbody>
                        </table>

                        <div class="row">
                        <button type="button" class="btn btn-success">Download Excel</button>
<button type="button" class="btn btn-success">Download PDF</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>    

$(document).ready(function() {
    $('#example').DataTable();
} )

</script>

<?php
include("footer.php");
?>