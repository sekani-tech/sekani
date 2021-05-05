<?php
    session_start();
    $connection = mysqli_connect('localhost', 'sekanisy', '4rWY#JP+rnl67', 'sekanisy_admin');

    $sessint_id = $_SESSION['int_id'];

    if(isset($_POST["item"]))  
    {  
        $output = '';  
        $query = "SELECT item FROM inventory WHERE int_id = '$sessint_id' AND item LIKE '%".trim($_POST["item"])."%'";  
        $result = mysqli_query($connection, $query);
        
        if(mysqli_num_rows($result) > 0)  
        {
            $output = '<ul class="list-group">'; 
            while($row = mysqli_fetch_array($result))  
            {  
                $output .= '<li class="list-group-item inv-item">'.$row["item"].'</li>';  
            }
            $output .= '</ul>';
        }
          
        echo $output;  
    }

    if(isset($_POST["existingItem"]))  
    {  
        $output = '';  
        $query = "SELECT * FROM inventory WHERE int_id = '$sessint_id' AND item LIKE '%".$_POST["existingItem"]."%'";  
        $result = mysqli_query($connection, $query);
        $inventory = mysqli_fetch_array($result);

        $date = $inventory["date"];
        $transaction_id = $inventory["transaction_id"];
        $quantity = $inventory["quantity"];
        $unit_price = $inventory["unit_price"];
        $total_price = $inventory["total_price"];
        $is_book = $inventory["is_book"];
        $charge_id = $inventory["charge_id"];

        $get_charge_name = mysqli_query($connection, "SELECT name FROM charge WHERE id = '{$charge_id}'");
        $charge = mysqli_fetch_array($get_charge_name);
        $charge_name = $charge["name"];
        
        $inventoryDetails = array("is_book" => $is_book, "charge" => $charge_name, "charge_id" => $charge_id, "date" => $date, "transaction_id" => $transaction_id, "quantity" => $quantity, "unit_price" => $unit_price, "total_price" => $total_price);

        // Encoding array in JSON format
        echo json_encode($inventoryDetails);
    }
 ?>  