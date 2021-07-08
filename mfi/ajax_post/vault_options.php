<?php
include("../../functions/connect.php");
session_start();
$output = '';
$val = $_POST['id'];
// we are gonna post to get the name of the button
if ($val == 'vault_in' || $val == 'vault_out') {
    $name = $_POST['id'];

    $sint_id = $_SESSION["int_id"];
    $bch_id = $_SESSION["branch_id"];
    $head_find = selectSpecificData('branch', ['parent_id'], ['id' => $bch_id, 'int_id' => $sint_id]);
    $parent_id = $head_find['parent_id'];
    // var_dump($parent_id);
    // echo $parent_id;

    if ($parent_id == '0') {
        function fill_teller($connection)
        {
            $sint_id = $_SESSION["int_id"];
            $orgs = selectAll('tellers', ['int_id' => $sint_id]);

            $out = '';
            foreach ($orgs as $org) {
                $out .= '<option value="' . $org["name"] . '">' . $org["description"] . '</option>';
            }
            return $out;
        }
    } else {
        function fill_teller($connection)
        {
            $bch_id = $_SESSION["branch_id"];
            $sint_id = $_SESSION["int_id"];
            $orgs = selectAll('tellers', ['int_id' => $sint_id, 'branch_id' => $bch_id]);
            $out = '';
            foreach ($orgs as $org) {
                $out .= '<option value="' . $org["name"] . '">' . $org["description"] . '</option>';
            }
            return $out;
        }
    }
    ?>
    <div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="bmd-label-floating"> Teller Name</label>
            <input type="text" hidden name="cash" value=""/>
            <select name="teller_id" id="tell" class="form-control">
                <option value="0">SELECT A TELLER</option>
                <?php echo fill_teller($connection) ?>
            </select>
        </div>
    </div>
    <div id="tell_acc"></div>
    </div><?php
} else if ($val == 'from_bank' || $val == 'to_bank') {

    function fill_payment($connection)
    {
        $sint_id = $_SESSION["int_id"];
        return selectAll('payment_type', ['int_id' => $sint_id, 'is_bank' => 1]);
    } ?>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="bmd-label-floating">Bank</label>
                <select name="bank_type" id="bnk" class="form-control">
                    <option value="0">Select A Bank</option>
                    <?php $bankList = fill_payment($connection);
                    foreach ($bankList as $row) { ?>
                        <option value="<?php echo $row['gl_code'] ?>"><?php echo $row["value"] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div id="bank_acc"></div>
    </div>
    <?php
}

?>
<script>
    $(document).ready(function () {
        $('#tell').change(function () {
            var id = $(this).val();
            $.ajax({
                url: "ajax_post/sub_ajax/teller_balance.php",
                method: "POST",
                data: {id: id},
                success: function (data) {
                    $('#tell_acc').html(data);
                }
            })
        });
    })

    $(document).ready(function () {
        $('#bnk').change(function () {
            var ib = $(this).val();
            $.ajax({
                url: "ajax_post/sub_ajax/teller_balance.php",
                method: "POST",
                data: {ib: ib},
                success: function (data) {
                    $('#bank_acc').html(data);
                }
            })
        });
    })
</script>