<?php
session_start();
include('../../functions/connect.php');

$sessint_id = $_SESSION['int_id'];
?>
<?php
if(isset($_POST['acc_name']))
{
    $acc_name = $_POST['acc_name'];
    $result = mysqli_query($connection, "SELECT * FROM client WHERE int_id = '$sessint_id' AND display_name LIKE '%".trim($acc_name)."%'");
    $output = '';

    if(mysqli_num_rows($result) > 0)  
    {
        $output = '<ul class="list-group">'; 
        while($row = mysqli_fetch_array($result))  
        {  
            $output .= '<li class="list-group-item acc-name">'.$row["display_name"].'</li>';  
        }
        $output .= '</ul>';
    }
        
    echo $output;
}

if(isset($_POST["existing_acc_name"]))  
{  
    $acc_name = $_POST['existing_acc_name'];
    $query = "SELECT account_no FROM client WHERE int_id = '$sessint_id' AND display_name = '$acc_name'";  
    $result = mysqli_query($connection, $query);
    $output = '';

    if(mysqli_num_rows($result) > 0)  
    {
        while($row = mysqli_fetch_array($result))
        {
            $output .= '<option value="'.$row["account_no"].'">'.$row["account_no"].'</option>';  
        }
    }

    echo $output;
}
?>