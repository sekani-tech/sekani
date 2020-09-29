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
$dio = "SELECT * FROM gl_account_transaction";
$iod = mysqli_query($connection, $dio);
while($ids = mysqli_fetch_array($iod)){
    $id = $ids['id'];
    $int_id = $ids['int_id'];
    $parent_id = $ids['parent_id'];

    $fis = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE id = '$parent_id' AND int_id = '$int_id'");
    if($fis){
    $iwr = mysqli_fetch_array($fis);
    $gl_code = $iwr['gl_code'];
    
    $spf = mysqli_query($connection, "UPDATE gl_account_transaction SET gl_code = '$gl_code' WHERE parent_id = '$parent_id' AND int_id = '$int_id' AND id = '$id'");
    if($spf){
        echo 'id = '.$id.', gl_code =  '.$gl_code.', DONE</br>';
    }
}
else{
    echo 'Appropriate Head gl not Found!</br>';
}
}
?>