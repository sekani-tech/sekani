<?php
include("../functions/connect.php");
session_start();
// work
if (isset($_POST["id"])) {
    $id = $_POST["id"];
    $main_p = $_POST["main_p"];
    $longName = $_POST['longName'];
    $shortName = $_POST['shortName'];
    $int_id = $_POST["int_id"];
    $branch_id = $_POST["branch_id"];
    $charge_id = $_POST["id"];
    $colon = date('Y-m-d H:i:s');
    if (!empty($id)) {
        if (!isset($longName, $shortName)) { ?>
            <div class="p-3 mb-2 bg-danger text-white">Pls provide name for the product</div>
            <?php exit();
        } else {
            $nameOfProduct = $longName . ' ' . $shortName;
            $chargeCacheDetails = selectOne('charges_cache', ['charge_id' => $id, 'cache_prod_id' => $nameOfProduct]);
            if ($chargeCacheDetails) { ?>
                 <div class="p-3 mb-2 bg-warning text-white">Charge already Applied</div>
                <?php
                $charge = selectAll('charges_cache', ['cache_prod_id' => $nameOfProduct]);
//                dd($charge);
                ?>
                <input type="text" id="idq" value="<?php echo $charge_id; ?>" hidden>
                <input type="text" id="int_idq" value="<?php echo $int_id; ?>" hidden>
                <input type="text" id="main_pq" value="<?php echo $main_p; ?>" hidden>

                <div class="table-responsive">
                    <table class="rtable display nowrap" style="width:100%">
                        <thead class=" text-primary">
                        <th>sn</th>
                        <th>Name</th>
                        <th>Charge</th>
                        <th>Collected On</th>
                        <th>Delete</th>
                        </thead>
                        <tbody>
                        <?php foreach ($charge as $key => $row) { ?>
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

                <?php
                exit();
            }

//           select the picked charges
            $chargeDetails = selectOne('charge', ['id' => $id]);
            $xs = '';
            $chg = '';

            $values = $chargeDetails["charge_time_enum"];
            $nameOfCharge = $chargeDetails["name"];
            $forP = $chargeDetails["charge_calculation_enum"];
            $amt = number_format($chargeDetails["amount"], 2);
            if ($forP === 1) {
                $chg = $amt . " Flat";
            } else {
                $chg = $amt . "% of Loan Principal";
            }
            if ($values === 1) {
                $xs = "Disbursement";
            } else if ($values === 2) {
                $xs = "Manual Charge";
            } else if ($values === 3) {
                $xs = "Savings Activation";
            } else if ($values === 5) {
                $xs = "Deposit Fee";
            } else if ($values === 6) {
                $xs = "Annual Fee";
            } else if ($values === 8) {
                $xs = "Installment Fees";
            } else if ($values === 9) {
                $xs = "Overdue Installment Fee";
            } else if ($values === 12) {
                $xs = "Disbursement - Paid With Repayment";
            } else if ($values === 13) {
                $xs = "Loan Rescheduling Fee";
            }

            //            create charges in cache for adding later
            $chargeCondition = [
                'int_id' => $int_id,
                'branch_id' => $branch_id,
                'charge_id' => $charge_id,
                'name' => $nameOfCharge,
                'charge' => $chg,
                'collected_on' => $xs,
                'date' => $colon,
                'is_status' => 0,
                'cache_prod_id' => $nameOfProduct
            ];
            $loadCharges = create('charges_cache', $chargeCondition);
//            $charge = "SELECT * FROM charge WHERE id = '" . $_POST["id"] . "'";
            $charge = selectAll('charges_cache', ['cache_prod_id' => $nameOfProduct]);
            ?>
            <input type="text" id="idq" value="<?php echo $charge_id; ?>" hidden>
            <input type="text" id="int_idq" value="<?php echo $int_id; ?>" hidden>
            <input type="text" id="main_pq" value="<?php echo $main_p; ?>" hidden>

            <div class="table-responsive">
                <table class="rtable display nowrap" style="width:100%">
                    <thead class=" text-primary">
                    <th>sn</th>
                    <th>Name</th>
                    <th>Charge</th>
                    <th>Collected On</th>
                    <th>Delete</th>
                    </thead>
                    <tbody>
                    <?php foreach ($charge as $key => $row) { ?>
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
            <?php
        }
    } else { ?>
        <div class="p-3 mb-2 bg-danger text-white">Please Provide A Charge</div>
    <?php }
}
?>
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