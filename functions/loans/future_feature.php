<input type="text" name="amount" id="amount" value="<?php echo $amount ?>">
<input type="text" name="account_no" id="account_no" value="<?php echo $accountNo ?>">
<input type="text" name="description" id="description" value="<?php echo $description ?>">
<input type="text" name="int_id" id="int_id" value="<?php echo $institutionId ?>">
<input type="text" name="branch_id" id="branch_id" value="<?php echo $branchId ?>">
<input type="text" name="transaction_id" id="transaction_id" value="<?php echo $transactionId ?>">
<input type="text" name="trans_date" id="trans_date" value="<?php echo $manualPaymentDate ?>">
<input type="text" name="user_id" id="user_id" value="<?php echo $userId ?>">
<script>
    $(document).ready(function() {
        var int_id = $('#int_id').val();
        var branch_id = $('#branch_id').val();
        var account_no = $('#account_no').val();
        var amount = $('#amount').val();
        var description = $('#description').val();
        var trans_date = $('#trans_date').val();
        var user_id = $('#user_id').val();
        var transaction_id = $('#transaction_id').val();

        $.ajax({
            url: "../transactions/process/debit.php",
            method: "POST",
            data: {
                int_id: int_id,
                branch_id: branch_id,
                user_id: user_id,
                transaction_id: transaction_id,
                amount: amount,
                trans_date: trans_date,
                account_no: account_no,
                description: description
            },
            success: function(data) {
                $('#feedback').val(data);
            }
        });
    });
</script>