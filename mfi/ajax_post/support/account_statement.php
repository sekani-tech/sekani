<?php
include('../../../functions/connect.php');
if (isset($_POST['account_no']) && isset($_POST['int_id'])) {
    $accountNo = $_POST['account_no'];
    $institutionId = $_POST['int_id'];

    $accountStatementConditions = [
        'int_id' => $institutionId,
        'account_no' => $accountNo
    ];
    $accountSatement = selectAllWithOrder("account_transaction", $accountStatementConditions, 'transaction_date', 'ASC');
    foreach ($accountSatement as $keys => $rows) {
?>
        <tr>
            <td><?php echo $rows['transaction_date'] ?></td>
            <td><?php echo $rows['created_date'] ?></td>
            <td><?php echo $rows['description'] ?></td>
            <td><?php echo $rows['debit'] ?></td>
            <td><?php echo $rows['credit'] ?></td>
            <td><?php echo $rows['running_balance_derived'] ?></td>
            <td>
                <div class="test" data-id="<?php echo $rows['id'] ?>"><span class="btn btn-danger">Delete</span></div>
            </td>
        </tr>
<?php
    }
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

        var confirmalert = confirm("Delete this Transaction?");
        if (confirmalert == true) {
            // AJAX Request
            $.ajax({
                url: 'ajax_post/ajax_delete/delete_transaction.php',
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