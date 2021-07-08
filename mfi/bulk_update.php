<?php

$page_title = "Bulk Update";
$destination = "configuration.php";
include("header.php");
//  function to check likes
function like($str, $searchTerm)
{
    $searchTerm = strtolower($searchTerm);
    $str = strtolower($_SESSION['username']);
    $pos = strpos($str, $searchTerm);
    if ($pos === false)
        return false;
    else
        return true;
}

?>


<!-- Content added here -->
<div class="content">
    <div class="container-fluid">
        <!-- your content here -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Bulk Update</h4>

                        <!-- Insert number users institutions -->
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="rtable display nowrap" style="width:100%">
                                <thead class=" text-primary">
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php


                                    $found = like('it-support', 'it-su'); //returns true
                                    if ($found) {
                                    ?>
                                        <tr>
                                            <th>Update Account Number</th>
                                            <th>this add zeros to a number to make it 10</th>
                                            <td>
                                                <a href="update00.php" class="btn btn-info">
                                                    <i class="material-icons" style="margin: auto;">description</i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Banks to Institutions</th>
                                            <th>These adds banks to institution accounts</th>
                                            <td>
                                                <a href="update_bank.php" class="btn btn-info">
                                                    <i class="material-icons" style="margin: auto;">description</i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <!-- LOAN RESTRUCTURING -->
                                        <tr>

                                            <th>Loan Repayment Schedule</th>
                                            <th>Auto run code for Loan Schedule</th>
                                            <td><a target="_blank" href="../functions/loans/schedule.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a>
                                            </td>
                                        </tr>
                                        <!-- LOAN REPAYMENT -->
                                        <tr>

                                            <th>Loan Repayment</th>
                                            <th>Auto run code for Loan Repayment</th>
                                            <td><a target="_blank" href="../loan_repayment/repayment_script.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a>
                                            </td>
                                        </tr>
                                        <!-- LOAN ARREARS CHECK -->
                                        <tr>

                                            <th>Loan Arrears Check</th>
                                            <th>Auto run code for Arrears Check</th>
                                            <td><a target="_blank" href="../functions/loans/arrears.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a>
                                            </td>
                                        </tr>
                                        <!-- LOAN ARREARS -->
                                        <tr>

                                            <th>Loan Arrears Collection</th>
                                            <th>Auto run code for Arrears Collection</th>
                                            <td><a target="_blank" href="../loan_repayment/temp_arrears.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <th>Charge Data</th>
                                    <th>Upload Institution Charge data</th>
                                    <td><a href="bulk_charge_data.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a>
                                    </td>
                                    </tr>
                                    <tr>
                                        <th>Client Data</th>
                                        <th>Upload Institution Client data</th>
                                        <td><a href="bulk_client_data.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a>
                                        </td>
                                    </tr>
                                    <tr>

                                        <th>General Lender Data</th>
                                        <th>Upload Institution General Lender data</th>
                                        <td><a href="bulk_general_lender_data.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a>
                                        </td>
                                    </tr>
                                    <tr>

                                        <th>Group Data</th>
                                        <th>Upload Institution Group data</th>
                                        <td><a href="bulk_group_data.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a>
                                        </td>
                                    </tr>
                                    <tr>

                                        <th>Loan Data</th>
                                        <th>Upload Institution Loan data</th>
                                        <td><a href="bulk_loan_data.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a>
                                        </td>
                                    </tr>
                                    <tr>

                                        <th>Products Data</th>
                                        <th>Upload Institution Products data</th>
                                        <td><a href="bulk_product_data.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a>
                                        </td>
                                    </tr>
                                    <tr>

                                        <th>Report Data</th>
                                        <th>Upload Institution Report data</th>
                                        <td><a href="bulk_report_data.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a>
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
</div>


<?php

include("footer.php");

?>