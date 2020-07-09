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
    $email = $_POST['email'];

    $org = mysqli_query($connection, "SELECT * FROM client WHERE id = '$client_id'");
    if (count([$org]) == 1) {
      $a = mysqli_fetch_array($org);
      $int_id = $a['int_id'];
     }

    $get_gau = mysqli_query($connection, "SELECT * FROM loan_gaurantor WHERE client_id = '$client_id' AND phone = '$phone' OR phone2 = '$phone_b' OR email = '$h_address'");
    $mp = mysqli_num_rows($get_gau);
    if ($mp <= 0) {
        $coll = "INSERT INTO loan_gaurantor (int_id, client_id, first_name, last_name, phone, phone2, home_address, office_address, email) VALUES ( '{$int_id}','{$client_id}','{$firstname}','{$lastname}','{$phone}','{$phone_b}','{$h_address}',
        '{$o_address}','{$email}')";
    
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
    } else {
        echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "error",
                title: "Gaurantor Exist",
                text: "Your cant have more than one gaurantor",
                showConfirmButton: false,
                timer: 3000
            });
        });
        </script>
        ';
    }
?>