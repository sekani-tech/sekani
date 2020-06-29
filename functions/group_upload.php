<?php
include("connect.php");
session_start();
?>
<?php
$user = $_SESSION['user_id'];
$ssint_id = $_SESSION["int_id"];
$gname = $_POST['gname'];
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

$qurry = "INSERT INTO `groups` (`int_id`, `branch_id`,`g_name`, `loan_officer`, `reg_date`, `reg_type`, `meeting_day`, `meeting_frequency`, `meeting_time`, `meeting_location`, `submittedon_date`, `submittedon_userid`, `status`)
 VALUES ('{$ssint_id}', '{$branch_id}', '{$gname}', '{$acc_off}', '{$reg_date}', '{$reg_type}', '{$meet_day}', '{$meet_frequency}', '{$meet_time}', '{$meet_address}', '{$submitted_on}', '{$user}', 'Pending')";
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

     if($codf){
         $dso = "DELETE FROM `group_client_cache` WHERE id = '$grclcaid'";
         $sodkfo = mysqli_query($connection, $dso);
     }
}
    if ($sodkfo) {
        $_SESSION["Lack_of_intfund_$randms"] = "Registration Successful!";
        echo header ("Location: ../mfi/groups.php?message1=$randms");
    } else {
        $_SESSION["Lack_of_intfund_$randms"] = "Registration Failed";
        echo "error";
        echo header ("Location: ../mfi/groups.php?message1=$randms");
        // echo header("location: ../mfi/client.php");
    }
}
?>