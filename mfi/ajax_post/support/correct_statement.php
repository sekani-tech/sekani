<?php

include('../../../functions/connect.php');
if (isset($_POST['account_no']) && isset($_POST['int_id'])) {
    
    $accountNo = $_POST['account_no'];
    $institutionId = $_POST['int_id'];
    $updateStatement = mysqli_query($connection, "UPDATE account_transaction p INNER JOIN (
        SELECT 
            s.id, s.account_no, s.transaction_date, s.running_balance_derived, s.amount, s.debit, s.credit, 
            @b := @b - s.debit + s.credit AS balance
        FROM
            (SELECT @b := 0.0) AS dummy 
          CROSS JOIN
            account_transaction AS s WHERE account_no = '$accountNo' AND int_id = '$institutionId'
        ORDER BY
            transaction_date, id ASC) s on p.id = s.id AND p.account_no = '$accountNo' AND int_id = '$institutionId' SET p.running_balance_derived = s.balance, p.cumulative_balance_derived = s.balance");
    if(!$updateStatement) {
                printf('Error: %s\n', mysqli_error($connection));//checking for errors
                exit();
            }else{
                echo "Sucess";
            }
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
    // $(document).ready(function() {
    //     $('#eodr').DataTable();
    // });
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