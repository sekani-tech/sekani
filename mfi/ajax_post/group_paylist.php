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
        $accountBalCont = "00" . $groupClient['account_no'];
        $accountBal = selectOne('account', ['account_no' => $accountBalCont]);

//        Selecting from arrears table with client id
//        $totalDue = selectOne('loan_arrear', ['client_id' => $cl_id]);
////        dd($totalDue);
//        $totalDueComplete = array_sum($totalDue['principal_amount']) + array_sum($totalDue['interest_amount']);
        $out = '
        <tr>
        <td>' . $i . '</td>
        <td>' . $c_name . '</td>
        <td>' . $accountBal['account_balance_derived'] . '</td>
        <td></td>
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


