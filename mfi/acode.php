<?php
include("../functions/connect.php");
session_start();
$output = '';
?>
<?php
// CODE TO SORT BY UD AND ADD ACCOUNT NUMBER
// $dif = "SELECT * FROM `current` ORDER BY name ASC";
// $sdf = mysqli_query($connection, $dif);
// while($a = mysqli_fetch_array($sdf)){
//     $name = $a['name'];

    // $dsio = "SELECT * FROM previous WHERE name LIKE '%$name%'";
    // $fdf = mysqli_query($connection, $dsio);
    // $d = mysqli_fetch_array($fdf);
    // $id = $d['id'];
    // $id_two = $d['id_two'];
    // $name2 = $d['name'];
    // $accno = $d['account_no'];

    // echo $name." has ".$id_two."</br>";


    // $os = "UPDATE current SET account_no = '$accno', id_two = '$id_two' WHERE name LIKE '%$name%'";
    // $fdf = mysqli_query($connection, $os);

    // if($fdf){
    //     // echo $name2." is set bruhh!!</br>";
    // }
// }

// CODE TO ADD PARENT ID TO GL TRANSACTIONS
$dio = "SELECT * FROM post";
$iod = mysqli_query($connection, $dio);
while($ids = mysqli_fetch_array($iod)){
    $first = $ids['first_name'];
    $last = $ids['last_name'];
    $d = $ids['id'];
    $old = '-'.$ids['amount'];

    $fis = mysqli_query($connection, "SELECT * FROM client WHERE firstname LIKE '%$first%' AND lastname LIKE '%$last%' AND int_id = '10'");
    if($fis){
    $iwr = mysqli_fetch_array($fis);
    $firsst = $iwr['firstname'];
    $lasst = $iwr['lastname'];
    $client_id = $iwr['id'];

    echo 'Client found for '.$d.', '.$first.'. Client name is '.$firsst.' '.$lasst.' with id '.$client_id.'!</br>';

    $see = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$client_id'");
        if($see){
            $abc = mysqli_fetch_array($see);
            $account = $abc['account_balance_derived'];
            $id = $abc['id'];
            $last = mysqli_query($connection, "UPDATE account SET account_balance_derived = '$old' WHERE id = '$id'");
            if($last){
            echo 'account Updated</br>';
            }
        }
        else{
            echo 'but couldnt find account</br>';
        }

    // $spf = mysqli_query($connection, "UPDATE gl_account_transaction SET gl_code = '$gl_code' WHERE parent_id = '$parent_id' AND int_id = '$int_id' AND id = '$id'");
    // if($spf){
    //     echo 'id = '.$id.', gl_code =  '.$gl_code.', DONE</br>';
    // }
}
else{
    echo 'Client with '.$d.', '.$first.'. not found</br>';
}
}
?>