<?php
include("connect.php");
session_start();
?>
<?php
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$sint_id = $_SESSION['int_id'];

if (isset($_POST['transact_id']) && isset($_POST['type'])) {
    $type = $_POST['type'];
    $branch = $_POST['branch'];
    $bch_name =  mysqli_query($connection, "SELECT * FROM branch WHERE name = '$branch' && int_id = '$sint_id'");
    $grn = mysqli_fetch_array($bch_name);
    $bch_id = $grn['id'];

    $name = $_POST['teller_name'];
    $amount = $_POST['amount'];
    $balance =$_POST['balance'];
    $transact_id = $_POST['transact_id'];

    if($type == "vault_in"){
        $query2 = "SELECT * FROM tellers WHERE int_id = '$sint_id' && branch_id = '$bch_id'";
        $grn = mysqli_fetch_array($query2);

        $iat2 = "INSERT INTO institution_account_transaction (int_id, branch_id,
        client_id, transaction_id, transaction_type, teller_id, is_reversed,
        transaction_date, amount, running_balance_derived, overdraft_amount_derived,
        created_date, appuser_id, credit) VALUES ('{$sessint_id}', '{$branch_id}',
        '{$client_id}', '{$transid}', '{$trans_type}', '{$staff_id}', '{$irvs}',
        '{$gen_date}', '{$amt}', '{$new_int_bal}', '{$amt}',
        '{$gen_date}', '{$appuser_id}', '{$amt}')";
    }
    else if($type == "vault_out"){

    }
}
?>