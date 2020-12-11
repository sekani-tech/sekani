<?php
include("../../functions/connect.php");
session_start();
$sint_id = $_SESSION['int_id'];

if (isset($_POST["id"])) {

// get group clients
    $g_id = $_POST["id"];
//    dd($g_id);
    $groupClientTable = "group_clients";
    $condition = ['int_id' => $sint_id, 'group_id' => $g_id];
    $groupClients = selectAll($groupClientTable, $condition);
// dd($groupClients);
    $i = 1;
    foreach ($groupClients as $key => $groupClient) {
        $c_name = $groupClient['client_name'];
        $cl_id = $groupClient['client_id'];
        $clientAccountNumber = $groupClient['account_no'];
//        selecting from account with clients Account Number
        if (strlen($clientAccountNumber) < 10) {
            $accountBalCont = "00" . $clientAccountNumber;
        } else {
            $accountBalCont = $clientAccountNumber;
        }


        $accountBal = selectAll('account', ['client_id' => $cl_id]);
//        dd($accountBal);
        ?>
        //        $accountNumb_id = $accountBalCont['id'];

        <tr>
            <td class="text-center"><?php echo $key + 1; ?></td>
            <td><?php echo $c_name ?></td>

            <td>
                <select id="account" name="account[]" class="form-control" required>
                    <option value="">Select An Account</option>
                    <?php foreach ($accountBal as $value) {
                        $product_type = $value["product_id"];
//            dd($product_type);
//            //        get user account details
                        $savingProductCon = ['id' => $product_type];
                        $savingProduct = selectOne('savings_product', $savingProductCon);
////        dd($savingProduct);
                        $accountNumb_name = $savingProduct['name'];
                        ?>
                        <option value="<?php echo $value['account_no'] ?>"><?php echo $value['account_no'] . ' - ' . $accountNumb_name ?></option>
                    <?php } ?>
                </select>
            </td>
            <td></td>
            <td></td>
            <td>
                <input type="text" hidden name="customerID[]" value="<?php echo $cl_id ?>">
                <input type="text" hidden name="customerName[]" value="<?php echo $c_name ?>">
                <input type="text" name="amount[]" id="" style="text-transform: uppercase;"
                       class="form-control total_price"
                       value="">
            </td>
        </tr>
        <?php
    }

} else {
    echo "Id not set so no information";
}