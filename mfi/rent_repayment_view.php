<?php

$page_title = "Prepayment View";
$destination = "";
include("header.php");

$prepaymentId = $_GET['view'];
$yearSearchConditions = [
    'int_id' => $sessint_id,
    'id' => $prepaymentId
];
$yearSearch = selectOne("prepayment_account", $yearSearchConditions);
$amount = $yearSearch['amount'];
$year = $yearSearch['year'];
?>



<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Prepayment</h4>
                        <!-- <p class="category">Category subtitle</p> -->
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="card card-profile ml-auto mr-auto" style="max-width: 370px; max-height: 360px">
                                <div class="card-body ">
                                    <h4 class="card-title"><b>₦ <?php echo number_format($amount, 2) ?></b></h4>
                                    <h6 class="card-category text-gray">YEAR: <?php echo $year ?></h6>
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
                                        <?php
                                        $searchConditions = [
                                            'int_id' => $sessint_id,
                                            'branch_id' => $branch_id,
                                            'prepayment_account_id' => $prepaymentId
                                        ];
                                        $schedule = selectAllWithOrder("prepayment_schedule", $searchConditions, "expense_date", "ASC");
                                        foreach ($schedule as $keys => $rows) {
                                        ?>
                                            <tr>

                                                <td><?php echo $rows['expense_date'] ?></td>
                                                <!-- <td>date("F", strtotime($rows['expense_date']))</td> -->
                                                <td><?php echo number_format($rows['expense_amount'], 2) ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
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