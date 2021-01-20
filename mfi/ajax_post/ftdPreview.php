<?php
include "../../functions/connect.php";
$id = $_POST["id"];
$main_p = $_POST["main_p"];
$longName = $_POST['longName'];
$shortName = $_POST['shortName'];
$int_id = $_POST["int_id"];
$branch_id = $_POST["branch_id"];
$charge_id = $_POST["id"];
$nameOfProduct = $longName . ' ' . $shortName;
?>

<h3> Preview Fixed Deposit Product</h3>

</p>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Name </label>
            <input type="text" name="name" class="form-control" id=""
                   placeholder="Fixed Deposit full name..." readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="shortLoanName">Short Loan Name </label>
            <input type="text" class="form-control" name="short_name"
                   value="" placeholder="Short Name..." readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="loanDescription">Description</label>
            <input type="text" class="form-control" name="description"
                   value="" placeholder="Description...." readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="installmentAmount">Currency</label>
            <input type="text" class="form-control" name="currency"
                   value="" placeholder="currency" readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="interestRate">Deposit Amount </label>
            <div class="row">
                <div class="col-md-4">
                    <input type="text" class="form-control"
                           name="deposita" value=""
                           placeholder="Default" readonly>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control"
                           name="deposita_min" value=""
                           placeholder="Min" readonly>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control"
                           name="deposita_max" value=""
                           placeholder="Max" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="interestRate">Interest Rate </label>
            <div class="row">
                <div class="col-md-4">
                    <input type="text" class="form-control"
                           name="interestRateDefault" value=""
                           placeholder="Default" readonly>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control"
                           name="interestRateMin" value=""
                           placeholder="Min" readonly>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control"
                           name="interestRateMaz" value=""
                           placeholder="Max" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="interestRateApplied">Interest Posting period
                Type</label>
            <input type="text" class="form-control" name="IPPT" value=""
                   placeholder="Interest Posting period Type" readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="installmentAmount">Interest Compounding
                Period</label>

            <input type="text" class="form-control" name="ICP" value=""
                   placeholder="Interest Compounding Period" readonly>
        </div>
    </div>
    <div class="col-md-6" hidden>
        <div class="form-group">
            <label for="interestMethodology">Interest Calculation
                Type</label>
            <input type="text" class="form-control" name="ICT" value=""
                   placeholder="Interest Calculation Type" readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="amortizatioMethody">Interest Calculation Days in
                Year type</label>
            <input type="text" class="form-control" name="ICDiYT"
                   value=""
                   placeholder="Interest Calculation Days in Year type"
                   readonly>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="principal">Minimum Deposit Term </label>
            <div class="row">
                <div class="col-md-4">
                    <input type="number" class="form-control"
                           name="minimum_dep_term" value=""
                           placeholder="Min" readonly>
                </div>
                <div class="col-md-8">
                    <input type="number" class="form-control"
                           name="minimum_dep_time" value=""
                           placeholder="minimum_dep_term_time" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="additionalCharges">Auto Renew on
                maturity</label>
            <input type="number" class="form-control"
                   name="Auto Renew on maturity" value=""
                   placeholder="Auto Renew on maturity" readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="principal">Maximum Deposit Term </label>
            <div class="row">
                <div class="col-md-4">
                    <input type="number" class="form-control"
                           name="maximum_dep_term" value=""
                           placeholder="Max" readonly>
                </div>
                <div class="col-md-8">
                    <input type="number" class="form-control"
                           name="maximum_dep_term_time" value=""
                           placeholder="maximum_dep_term_time" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="additionalCharges">Allow Premature Closing
                Penalty</label>
            <input type="number" class="form-control"
                   name="Allow Premature Closing Penalty" value=""
                   placeholder="Allow Premature Closing Penalty"
                   readonly>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>GL Codes </label>
            <input type="text" class="form-control" name="" value=""
                   placeholder="GL Codes" readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="principal">In Multiples of Deposit Term </label>
            <div class="row">
                <div class="col-md-4">
                    <input type="number" class="form-control"
                           name="inmultiples_dep_term" value=""
                           placeholder="Default" readonly>
                </div>
                <div class="col-md-8">

                    <input type="number" class="form-control"
                           name="inmultiples_dep_term" value=""
                           placeholder="Default" readonly>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- table for charges-->
<div class="row">
    <div class="col-md-12">
        <?php $chargeSelected = selectAll('charges_cache', ['cache_prod_id' => $nameOfProduct]) ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover" style="width:100%">
                <thead class="-primary">
                <tr>
                    <th>sn</th>
                    <th>Name</th>
                    <th>Charge</th>
                    <th>Collected On</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($chargeSelected as $key => $row) { ?>
                    <tr>
                        <td><?php echo $key + 1 ?></td>
                        <td> <?php echo $row["name"] ?></td>
                        <td><?php echo $row["charge"] ?></td>
                        <td> <?php echo $row["collected_on"] ?></td>
                        <input type="text" value="<?php $row["id"] ?>" hidden>
                        <td>
                            <div class="test" data-id='<?= $row['id']; ?>'>
                                <span class="btn btn-danger">Delete</span>
                            </div>
                        </td>
                    </tr>
                    <?php
                } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function () {

// Delete
            $('.test').click(function () {
                var el = this;

                // Delete id
                var id = $(this).data('id');

                var confirmalert = confirm("Delete this charge?");
                if (confirmalert == true) {
                    // AJAX Request
                    $.ajax({
                        url: 'ajax_post/ajax_delete/delete_charge.php',
                        type: 'POST',
                        data: {id: id},
                        success: function (response) {

                            if (response == 1) {
                                // Remove row from HTML Table
                                $(el).closest('tr').css('background', 'tomato');
                                $(el).closest('tr').fadeOut(700, function () {
                                    $(this).remove();
                                });
                            } else {
                                alert('Invalid ID.');
                            }
                        }
                    });
                }
            });
        });
    </script>
</div>
