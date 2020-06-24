<?php
session_start();
include('../../functions/connect.php');
?>
<?php
if(isset($_POST['id'])){
    $state = $_POST['id'];
    $sint_id = $_SESSION['int_id'];

            $select = "SELECT * FROM account WHERE int_id = '$sint_id' AND client_id = '$state'";
            $state1 = mysqli_query($connection, $select);
            $out = '';
            while ($row = mysqli_fetch_array($state1))
            {
                $prod = $row['product_id'];
                $don = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$prod'");
                $fdo = mysqli_fetch_array($don);
                $fiof = $fdo['name'];
            $out .= '
            <option value="'.$row["account_no"].'">'.$row["account_no"].'- '.$fiof.'</option>';
            }
            echo $out;
    }
    else {
        echo 'ID not posted';
    }
?>