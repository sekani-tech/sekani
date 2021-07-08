<?php
include("../functions/connect.php");
$output = '';

if(isset($_POST["usern"]))
{
    if($_POST["usern"] != '')
    {
        $sql = "SELECT * FROM users WHERE username = '".$_POST["usern"]."'";
    }
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result) > 0) {
        $output = '<b style="color: red">This Username is Already Taken</b>';
            echo '<script type="text/javascript">
            $(document).ready(function(){
                $(":input[type=submit]").prop("disabled", true);
            });
            </script>
            ';
    } else {
        $output = '';
        echo '<script type="text/javascript">
        $(document).ready(function(){
            $(":input[type=submit]").prop("disabled", false);
        });
        </script>
        ';
    }
        
    echo $output;
}
?>