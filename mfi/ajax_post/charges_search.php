<?php
    session_start();
    $connection = mysqli_connect('localhost', 'sekanisy', '4rWY#JP+rnl67', 'sekanisy_admin');

    $sessint_id = $_SESSION['int_id'];

    if(isset($_POST["charge_name"]))  
    {  
        $output = '';  
        $query = "SELECT name FROM charge WHERE int_id = '$sessint_id' AND name LIKE '%".trim($_POST["charge_name"])."%'"; 
        $result = mysqli_query($connection, $query);
        
        if(mysqli_num_rows($result) > 0)  
        {
            $output = '<ul class="list-group">'; 
            while($row = mysqli_fetch_array($result))  
            {  
                $output .= '<li class="list-group-item charge-item">'.$row["name"].'</li>';  
            }
            $output .= '</ul>';
        }
          
        echo $output;  
    }

    if(isset($_POST["charge_selected"]))  
    {  
        $output = '';  
        $query = "SELECT id FROM charge WHERE int_id = '$sessint_id' AND name = '".trim($_POST['charge_selected'])."'";  
        $result = mysqli_query($connection, $query);
        $charge = mysqli_fetch_array($result);

        $charge_id = $charge["id"];
        
        echo $charge_id;
    }
?>