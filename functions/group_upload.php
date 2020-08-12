<?php
include("connect.php");
session_start();
?>
<?php
$user = $_SESSION['user_id'];
$ssint_id = $_SESSION["int_id"];
$gname = $_POST['gname'];
$acc_type = $_POST['acct_type'];
$pc_phone = $_POST['pc_phone'];
$group = $_POST['group_cache_id'];
$branch_id = $_POST['branch_id'];
$acc_off = $_POST['acc_off'];
$reg_date = $_POST['reg_date'];
$reg_type = $_POST['reg_type'];
$meet_day = $_POST['meet_day'];
$meet_frequency = $_POST['meet_frequency'];
$meet_address = $_POST['meet_address'];
$meet_time = $_POST['meet_time'];
$submitted_on = date('Y-m-d');
$digit = 8;
$randms = str_pad(rand(0, pow(10, $digit)-1), 7, '0', STR_PAD_LEFT);

$inttest = str_pad($branch_id, 3, '0', STR_PAD_LEFT);
$digit = 4;
$randms = str_pad(rand(0, pow(10, $digit)-1), 7, '0', STR_PAD_LEFT);
$account_no = $inttest."".$randms;

$queryd = mysqli_query($connection, "SELECT * FROM savings_product WHERE id='$acc_type'");
$res = mysqli_fetch_array($queryd);
$accttname = $res['name'];
$type_id = $res['accounting_type'];

$qurry = "INSERT INTO `groups` (`int_id`, `branch_id`,`g_name`, `account_no`, `account_type`, `loan_officer`, `reg_date`, `reg_type`, `meeting_day`, `meeting_frequency`, `meeting_time`, `meeting_location`, `submittedon_date`, `submittedon_userid`, `pc_phone`, `status`)
 VALUES ('{$ssint_id}', '{$branch_id}', '{$gname}', '{$acc_type}', '{$account_no}', '{$acc_off}', '{$reg_date}', '{$reg_type}', '{$meet_day}', '{$meet_frequency}', '{$meet_time}', '{$meet_address}', '{$submitted_on}', '{$user}', '{$pc_phone}', 'Pending')";
$fodf = mysqli_query($connection, $qurry);

if($fodf){
$ddfd = "SELECT * FROM groups WHERE int_id = '$ssint_id' AND g_name ='$gname'";
$idofim = mysqli_query($connection, $ddfd);
$ds = mysqli_fetch_array($idofim);
$grou_id = $ds['id'];

$ddsid = "SELECT * FROM group_client_cache WHERE int_id = '$ssint_id' AND group_cache_id ='$group'";
$sdsds = mysqli_query($connection, $ddsid);
while($ew = mysqli_fetch_array($sdsds)){

    $clidd = $ew['client_id'];
    $grclcaid = $ew['id'];

    $sdsdf = "SELECT * FROM client WHERE int_id = '$ssint_id' AND id ='$clidd'";
    $sdsdc = mysqli_query($connection, $sdsdf);
    $rtr = mysqli_fetch_array($sdsdc);
    $namec = $rtr['firstname']." ".$rtr['lastname'];

    $dof = "INSERT INTO `group_clients` (`int_id`, `group_name`, `branch_id`, `client_id`, `client_name`, `group_id`)
     VALUES ('{$ssint_id}', '{$gname}', '{$branch_id}', '{$clidd}', '{$namec}', '{$grou_id}')";
     $codf = mysqli_query($connection, $dof);

     $rivm = "UPDATE client SET client_type = 'GROUP' WHERE int_id='$ssint_id' AND id='$clidd'";
     $fid = mysqli_query($connection, $rivm);
     if($codf){
         $dso = "DELETE FROM `group_client_cache` WHERE id = '$grclcaid'";
         $sodkfo = mysqli_query($connection, $dso);
     }
}
    if ($sodkfo) {
        $account_balance_derived = '0.00';
        $currency_code = "NGN";
        $accountins = "INSERT INTO account (int_id, branch_id, account_no, account_type,
        type_id, product_id, client_id, field_officer_id, submittedon_date, submittedon_userid,
        currency_code, activatedon_date, activatedon_userid,
        account_balance_derived) VALUES ('{$ssint_id}', '{$branch_id}', '{$account_no}',
        '{$accttname}', '{$type_id}', '{$acc_type}', '{$grou_id}', '{$acc_off}', '{$submitted_on}',
        '{$user}', '{$currency_code}', '{$submitted_on}', '{$user}', '{$account_balance_derived}')";
        $fif = mysqli_query($connection, $accountins);

        if($fif){
            $_SESSION["Lack_of_intfund_$randms"] = "Registration Successful!";
        echo header ("Location: ../mfi/groups.php?message1=$randms");
        }
        else {
            $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
            echo "error";
            echo header ("Location: ../mfi/groups.php?message1=$randms");
            // echo header("location: ../mfi/client.php");
        }
        
    }
}
?>