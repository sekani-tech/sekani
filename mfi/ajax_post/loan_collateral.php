<?php
session_start();
include('../../functions/connect.php');

$sessint_id = $_SESSION['int_id'];

if(!empty($_POST["start"]) && !empty($_POST["end"])) {
    $start = $_POST["start"];
    $end = $_POST["end"];
    $branch_id = $_POST["branch_id"];
?>
    <div class="col-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title ">Loan Collateral's Schedule</h4>
                <p class="card-category">
                <?php
                $getParentID = mysqli_query($connection, "SELECT parent_id FROM `branch` WHERE int_id = $sessint_id AND id = $branch_id");
                while ($result = mysqli_fetch_array($getParentID)) {
                    $parent_id = $result['parent_id'];
                }

                if ($parent_id == 0) {
                    // Select loan collateral schedule data from all branches
                    $query = "SELECT * FROM collateral WHERE int_id = '$sessint_id' AND date BETWEEN '$start' AND '$end'";
                    $result = mysqli_query($connection, $query);
                } else {
                    $query = "SELECT * FROM collateral WHERE int_id = '$sessint_id' AND client_id IN (SELECT id FROM client WHERE branch_id = $branch_id) AND date BETWEEN '$start' AND '$end'";
                    $result = mysqli_query($connection, $query);
                }

                if ($result) {
                    $inr = mysqli_num_rows($result);
                    echo $inr;
                } ?> Collaterals </p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="mytable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th><small>Date</small></th>
                                <th><small>Client Name</small></th>
                                <th><small>Type</small></th>
                                <th><small>Value</small></th>
                                <th><small>Description</small></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
                                    <tr>
                                        <?php $row["id"]; ?>
                                        <?php
                                        $name = $row['client_id'];
                                        $anam = mysqli_query($connection, "SELECT firstname, lastname FROM client WHERE id = '$name'");
                                        $f = mysqli_fetch_array($anam);
                                        $nae = strtoupper($f["firstname"] . " " . $f["lastname"]);
                                        ?>
                                        <td><?php echo date('d-m-Y', strtotime($row["date"])); ?></td>
                                        <td><?php echo $nae; ?></td>
                                        <td><?php echo $row["type"]; ?></td>
                                        <td><?php echo $row["value"]; ?></td>
                                        <td><?php echo $row["description"]; ?></td>
                                    </tr>
                            <?php }
                            } else {
                                // echo "0 Document";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="form-group mt-4">
                    <form method="POST" action="../composer/loan_collateral.php">
                        <input hidden name="start" type="text" value="<?php echo $start; ?>" />
                        <input hidden name="end" type="text" value="<?php echo $end; ?>" />
                        <input hidden name="branch_id" type="text" value="<?php echo $branch_id; ?>" />
                        <button type="submit" name="downloadPDF" class="btn btn-primary pull-left">Download PDF</button>
                        <button type="submit" name="downloadExcel" class="btn btn-primary pull-left">Download Excel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#mytable').DataTable();
        });
    </script>
<?php
}
?>