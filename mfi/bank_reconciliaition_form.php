<?php

$page_title = "Bank Reconciliaition";
$destination = "";
include("header.php");

function fill_banks($connection)
{
    $sessint_id = $_SESSION['int_id'];
    $getBanks = mysqli_query($connection, "SELECT name, gl_code FROM `acc_gl_account` WHERE parent_id = (SELECT id FROM `acc_gl_account` WHERE int_id = '$sessint_id' AND name = 'dues from bank')");
    $out = '';
    while($row = mysqli_fetch_array($getBanks)) {
        extract($row);
        $out .= '<option value="' . $gl_code . '">' . $name. '</option>';
    }
    return $out;
}
?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Bank Reconciliation Form</h4>
                    </div>
                    <div class="card-body">
                        <form action="trans_match.php" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Bank</label>
                                        <select name="gl_code" class="form-control" id="collat" required>
                                            <option value="">Select an option</option>
                                            <?php echo fill_banks($connection); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="exampleInputPassword1">Upload Bank Statement</label>
                                    <div class="input-group">
                                        <input type="file" name="bankStatementData" class="form-control inputFileVisible" placeholder="Single File" required>
                                    </div>
                                    <small id="emailHelp" class="form-text text-muted">Upload Excel File.</small>
                                </div>
                            </div>
                            <button type="submit" name="btnUploadBankStatement" class="btn btn-primary">Submit</button>
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