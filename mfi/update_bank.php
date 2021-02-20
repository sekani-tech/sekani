<?php

$page_title = "Bank to Institution Account";
$yes = "true";
$destination = "transaction.php";
include("header.php");
include("ajaxcall.php");

if (isset($_POST["acct_gl"])) {
    $gl_account = $_POST["acct_gl"];
    $inst_id = $_SESSION['int_id'];
    $branch = $_SESSION['branch_id'];
    $currency = "NGN";

    $gl_row = selectOne('acc_gl_account', ['gl_code' => $gl_account]);
    $account_balance = $gl_row['organization_running_balance_derived'];
    $gl_data = [
        'int_id' => $inst_id,
        'branch_id' => $branch,
        'currency_code' => $currency,
        'account_balance_derived' => $account_balance,
        'gl_code' => $gl_account
    ];


    $bankInInstituion = insert("institution_account", $gl_data);
    if (!$bankInInstituion) {
        printf("Error: %s\n", mysqli_error($connection)); //checking for errors
        exit();
    } else {
        echo "Success";
    }
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
                        <h4 class="card-title">Bank to Institution Account</h4>
                        <!-- <p class="card-category">Fill in all important data</p> -->
                    </div>
                    <div class="card-body">
                        <form action="Update_bank.php" method="post">
                            <div class="row">
                                <div class="col-md-4">
                                    <script>
                                        $(document).ready(function() {
                                            $('#acct').on("change keyup paste", function() {
                                                var id = $(this).val();
                                                var ist = $('#int_id').val();
                                                $.ajax({
                                                    url: "acct_rep_bank.php",
                                                    method: "POST",
                                                    data: {
                                                        id: id,
                                                        ist: ist
                                                    },
                                                    success: function(data) {
                                                        $('#accrep').html(data);
                                                    }
                                                })
                                            });
                                        });
                                    </script>
                                    <div class="form-group">
                                        <label for="">GL Number</label>
                                        <input type="text" class="form-control" name="acct_gl" id="acct">
                                        <input type="text" class="form-control" hidden name="" value="<?php echo $sessint_id; ?>" id="int_id">
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div id="accrep"></div>
                                    </div>
                                </div>

                            </div>
                            <button type="submit" class="btn btn-primary pull-right">Add</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php
include("footer.php");
?>