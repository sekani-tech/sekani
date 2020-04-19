<?php
    include("../functions/connect.php");
    $display = '';

    $id = $_POST['id'];
    $client_id = $_POST['client_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $phone_b = $_POST['phone_b'];
    $h_address = $_POST['h_address'];
    $o_address = $_POST['o_address'];
    $position = $_POST['position'];
    $email = $_POST['email'];

    $org = mysqli_query($connection, "SELECT * FROM client WHERE id = '$client_id'");
    if (count([$org]) == 1) {
      $a = mysqli_fetch_array($org);
      $int_id = $a['int_id'];
     }

    $coll = "INSERT INTO loan_gaurantor (int_id, client_id, first_name, last_name, phone, phone2, home_address, office_address,
    position_held, email) VALUES ( '{$int_id}','{$client_id}','{$firstname}','{$lastname}','{$phone}','{$phone_b}','{$h_address}',
    '{$o_address}','{$position}','{$email}')";

    $query = mysqli_query($connection, $coll);

    if($query){
        $don = "SELECT * FROM loan_gaurantor WHERE client_id = '$client_id'";
        $result = mysqli_query($connection, $don);
        while ($row = mysqli_fetch_array($result)) {
            $display = '
            <tr>
            <td>'.$row["first_name"].'</td>
            <td>'.$row["phone"].'</td>
            <td>'.$row["email"].'</td>
            </tr>
            ';
            echo $display;
        }
        
    }
?>