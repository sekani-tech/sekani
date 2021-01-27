<?php
$page_title = "Wallet Management";
include('header.php');
?>
<!-- Content added here -->
<div class="content">
    <div class="container-fluid">
        <!-- your content here -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Wallet Management</h4>
                        <!-- <p class="category">Category subtitle</p> -->
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-primary card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons">textsms</i>
                                        </div>
                                        <p class="card-category">SMS</p>
                                        <h3 class="card-title">₦200</h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">date_range</i> Last 24 Hours
                                        </div>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                            Refill
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-primary card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons">assignment</i>
                                        </div>
                                        <p class="card-category">Bills</p>
                                        <h3 class="card-title">₦34,245</h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">date_range</i> Last 24 Hours
                                        </div>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                            Refill
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-primary card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons">done_all</i>
                                        </div>
                                        <p class="card-category">BVN</p>
                                        <h3 class="card-title">₦75</h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">date_range</i> Last 24 Hours
                                        </div>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                            Refill
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6">
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-primary card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons">thumb_up</i>
                                        </div>
                                        <p class="card-category">Commission</p>
                                        <h3 class="card-title">₦75</h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">date_range</i> Last 24 Hours
                                        </div>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                            Refill
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6"></div>
                        </div>


                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Fund Your Sekani Wallet to be able to use our service</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <form>
                                            <div class="row">
                                                <div class="col">
                                                    <label>Amount</label>
                                                    <input type="text" class="form-control" placeholder="Enter Amount">
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 20px;">
                                                <div class="col">
                                                    <label>Transaction ID</label>
                                                    <input type="text" class="form-control" placeholder="" readonly>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 20px;">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="">Wallet Type</label>
                                                        <select class="form-control" data-style="btn btn-link" id="exampleFormControlSelect1">
                                                            <option>SMS</option>
                                                            <option>Bills</option>
                                                            <option>BVN</option>
                                                            <option>Commission</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Refill</button>
                                    </div>
                                </div>
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
                        <h4 class="card-title ">Generate Wallet Report</h4>
                        <!-- Insert number users institutions -->
                        <p>View Wallet Transaction report</p>
                    </div>
                    <div class="card-body">
                        <!-- check -->
                        <!-- uncheck -->
                        <!-- <form id="form" method="POST"> -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sdate">Start Date</label>
                                        <input type="date" class="form-control" id="start" value="" required="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="installmentAmount">End Date</label>
                                        <input type="date" class="form-control" id="end" value="" required="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="installmentAmount">Category</label>
                                        <select class="form-control" name="amt">
                                            <option value="refill">All</option>
                                            <option value="sms">Bills</option>
                                            <option value="sms">SMS</option>
                                            <option value="bvn">BVN</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4"><a class="btn btn-primary pull-right" id="run_pay"> <span style="color: white;">Run Report</span> </a></div>
                                <div class="col-md-4"></div>
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
                        <h4 class="card-title">Generated Report</h4>
                        <p class="category">01-03-2021 to 05-9-2021</p>
                    </div>
                    <div class="card-body">
                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Transaction Id</th>
                                    <th>Description</th>
                                    <th>Deposit</th>
                                    <th>Withdrawal</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>2021-01-03</td>
                                    <td>SKWAL63642393SMS5</td>
                                    <td>SMS Charge</td>
                                    <td>₦0.00</td>
                                    <td>₦4.00</td>
                                    <td>₦123,678.00</td>
                                </tr>
                                <tr>
                                    <td>2021-01-03</td>
                                    <td>SKWAL63642393SMS5</td>
                                    <td>SMS Charge</td>
                                    <td>₦0.00</td>
                                    <td>₦4.00</td>
                                    <td>₦123,678.00</td>
                                </tr>

                            </tbody>

                        </table>

                        <script>
                            $(document).ready(function() {
                                $('#example').DataTable();
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






<?php
include('footer.php');
?>