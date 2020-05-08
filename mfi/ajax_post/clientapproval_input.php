<?php
include("../../functions/connect.php");
?>
<?php
 session_start();
    if(isset($_POST["id"]))
     {
        if($_POST["id"]=="0" || $_POST["id"] == "")
        {
        $_SESSION['branchid'] = "0";
        $_SESSION['acc_id'] ="0";
            }  
        else {
            $_SESSION['branchid'] = $_POST["branchid"];
            $_SESSION['acc_id'] = $_POST["acctid"];
        }
     }
?>