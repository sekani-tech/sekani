<?php
include("connect.php");
session_start();
?>
<?php
$institutionId = $_SESSION["int_id"];
echo $branchId = $_POST['branch'];
// die();
$user_id = $_SESSION['user_id'];
$assname = $_POST['assname'];
$asstype = $_POST['asstype'];
<<<<<<< HEAD
$expense_gl = $_POST['expense_gl'];
=======
>>>>>>> Victor

$org = "SELECT * FROM asset_type WHERE int_id = '$institutionId' AND id = '$asstype'";
$kfdlf = mysqli_query($connection, $org);
$gdi = mysqli_fetch_array($kfdlf);
$asset_name = $gdi['asset_name'];

$qty = $_POST['qty'];
$price = $_POST['price'];
$ass_no = $_POST['ass_no'];
$location = $_POST['location'];
$depre = $_POST['depre'];
$purdate = $_POST['purdate'];
$glCode = $_POST['gl_code'];
$amount = $price * $qty;

$submitted_on = date('Y-m-d h:m:s');
$submited_by = $_SESSION['user_id'];

$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
$description = "ASST_RE_".$randms.$asset_name;
$transactionId = "ASST_RE" . $randms;
// collect gl account data
$assetGlConditions = [
    'int_id' => $institutionId,
    'branch_id' => $branchId,
    'gl_code' => $glCode
];
$findAssetGl = selectOne("acc_gl_account", $assetGlConditions);
if (!$findAssetGl) {
    $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
    $_SESSION["feedback"] = "Could not find Asset GL  - " . $error;
    $_SESSION["Lack_of_intfund_$randms"] = "0";
    echo header("Location: ../mfi/asset_register.php?message1=$randms-1");
    exit();
}
$currentAssetBalance = $findAssetGl['organization_running_balance_derived'];
$assetParentId = $findAssetGl['parent_id'];
$assetGlId = $findAssetGl['id'];

$newBalance = $currentAssetBalance + $amount;

$query = "INSERT INTO `assets` (`int_id`, `branch_id`, `asset_name`, `asset_type_id`, `type`, `qty`,
<<<<<<< HEAD
 `unit_price`, `asset_no`, `location`,  `amount`, `date`, `depreciation_value`, `appuser_id`, `gl_code`, `expense_gl`) 
 VALUES ('{$institutionId}', '{$branchId}', '{$assname}', '{$asstype}', '{$asset_name}', '{$qty}', '{$price}', '{$ass_no}',
  '{$location}', '{$amount}', '{$purdate}', '{$depre}', '{$user_id}', '{$glCode}', '{$expense_gl}')";
=======
 `unit_price`, `asset_no`, `location`,  `amount`, `date`, `depreciation_value`, `appuser_id`, `gl_code`) 
 VALUES ('{$institutionId}', '{$branchId}', '{$assname}', '{$asstype}', '{$asset_name}', '{$qty}', '{$price}', '{$ass_no}',
  '{$location}', '{$amount}', '{$purdate}', '{$depre}', '{$user_id}', '{$glCode}')";
>>>>>>> Victor
$result = mysqli_query($connection, $query);

if (!$result) {
    $_SESSION["feedback"] = " Could not fund Assetment GL - " . $error;
    $_SESSION["Lack_of_intfund_$randms"] = "1";
    echo header("Location: ../mfi/asset_register.php?message1=$randms-2");
    exit();
} else {
    
    $updateGlDetails = [
        'organization_running_balance_derived' => $newBalance
    ];
    $updateAssetGL = update('acc_gl_account', $assetGlId, 'id', $updateGlDetails);
    if (!$updateAssetGL) {
        $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = " Could not fund Asset GL - " . $error;
        $_SESSION["Lack_of_intfund_$randms"] = "1";
        echo header("Location: ../mfi/asset_register.php?message1=$randms-3");
        exit();
    }else{
        $assetTransactionDetails = [
            'int_id' => $institutionId,
            'branch_id' => $branchId,
            'gl_code' => $glCode,
            'parent_id' => $assetParentId,
            'transaction_id' => $transactionId,
            'description' => $description,
            'transaction_type' => "Credit",
            'transaction_date' => $purdate,
            'amount' => $amount,
            'gl_account_balance_derived' => $newBalance,
            'overdraft_amount_derived' => $amount,
            'cumulative_balance_derived' => $newBalance,
            'credit' => $amount
        ];

        $storeAssetTransaction = insert('gl_account_transaction', $assetTransactionDetails);
        if (!$storeAssetTransaction) {
            $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
            $_SESSION["feedback"] = " Could not store Asset transaction details - " . $error;
            $_SESSION["Lack_of_intfund_$randms"] = "1";
            echo header("Location: ../mfi/asset_register.php?message1=$randms-4");
            exit();
        }else{
            $_SESSION["feedback"] = " Asset Successfully Booked ";
            $_SESSION["Lack_of_intfund_$randms"] = "1";
            echo header("Location: ../mfi/asset_register.php?message0=$randms");
            exit();
        }
    }
}
?>