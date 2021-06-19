<?php
include("../../../functions/connect.php");
session_start();
$insitutionId = $_SESSION['int_id'];
if (isset($_POST['product'])) {
    // echo "Yes";
    $cacheChargeConditions = [
        'int_id' => $insitutionId,
        'savings_id' => $_POST['product']
    ];
    $cacheCharged = selectAll("savings_product_charge", $cacheChargeConditions);
    // dd($cacheCharged);
    foreach ($cacheCharged as $keys => $rows) {
        $findchargeConditions = [
            'id' => $rows['charge_id']
        ];
        $findCharge = selectOne('charge', $findchargeConditions);
?>
        <tr>
            <td><?php echo $findCharge['name'] ?></td>
            <td>
                <?php
                $values = $findCharge['charge_time_enum'];
                if ($values == 1) {
                    $xs = "Disbursement";
                } else if ($values == 2) {
                    $xs = "Specified Due Date";
                } else if ($values == 3) {
                    $xs = "Installment Fees";
                } else if ($values == 4) {
                    $xs = "Overdue Installment Fees";
                } else if ($values == 5) {
                    $xs = "Disbursement - Paid with Repayment";
                } else if ($values == 6) {
                    $xs = "Loan Rescheduliing Fee";
                } else if ($values == 7) {
                    $xs = "Transaction";
                }
                echo $xs;
                ?>
            </td>
            <td>
                <?php
                $collectedOn = $findCharge['charge_calculation_enum'];
                $amt = number_format($findCharge["amount"], 2);
                if ($collectedOn == 1) {
                    $chg = $amt . " Flat";
                } else {
                    $chg = $amt . "% of Loan Principal";
                }
                echo $chg;
                ?>
            </td>
            <td>
                <div class="test" data-id="<?php echo $rows['id'] ?>"><span class="btn btn-danger">Delete</span></div>
            </td>
        </tr>
<?php
    }
}else{
    echo "No";
}
?>

<script>
    $(document).ready(function() {
        $('#eodr').DataTable();
    });
    $('.test').click(function() {
        var el = this;

        // Delete id
        var id = $(this).data('id');

        var confirmalert = confirm("Delete this Charge?");
        if (confirmalert == true) {
            // AJAX Request
            $.ajax({
                url: 'ajax_post/ajax_delete/delete_savings_charge.php',
                type: 'POST',
                data: {
                    id: id
                },
                success: function(response) {

                    if (response == 1) {
                        // Remove row from HTML Table
                        $(el).closest('tr').css('background', 'tomato');
                        $(el).closest('tr').fadeOut(700, function() {
                            $(this).remove();
                        });
                    } else {
                        alert('Invalid ID.');
                    }
                }
            });
        }
    });
</script>