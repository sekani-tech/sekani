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
    foreach ($groupClients as $kay => $groupClient) {
        $c_name = $groupClient['client_name'];
        $cl_id = $groupClient['client_id'];
//        selecting from account with clients Account Number

        $accountBalCont = "00".$groupClient['account_no'];
        $accountBal = selectOne('account', ['account_no' => $accountBalCont]);
        $product_type = $accountBal["product_id"];

//        get user account details
        $savingProductCon = ['id' => $product_type];
        $savingProduct = selectOne('savings_product', $savingProductCon);
//        dd($savingProduct);
        $accountNumb_name = $savingProduct['name'];
//        $accountNumb_id = $accountBalCont['id'];


        $out = '
        <tr>
        <td class="text-center">' . $i . '</td>
        <td>' . $c_name . '</td>
        <td>' . $accountBal['account_balance_derived'] . '</td>
        <td>
        <select id="account" name="account[]" class="form-control" required>
        <option value="">Select An Account</option>
        <option value="'.$accountBalCont.'">' . $accountBalCont . ' - ' . $accountNumb_name . '</option>
</select></td>
        <td></td>
        <td>
            <input type ="text" hidden name="customerID[]" value="' . $cl_id . '"  >
            <input type ="text" hidden  name="customerName[]" value="' . $c_name . '"  >
            <input type="text" name="amount[]" id="" style="text-transform: uppercase;" class="form-control total_price" value="">
        </td>
        </tr>
        ';
        $i++;
        echo $out;
    }

} else {
    echo "Id not set so no information";
}


