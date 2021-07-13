<?php
ob_start();
include('../functions/loans/auto_function/loan_collection.php');
$page = ob_get_clean();
echo $page;
?>








