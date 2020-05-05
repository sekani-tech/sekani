<?php
include("../functions/connect.php");

$output = '';

if(isset($_POST["id"]))
{
    if($_POST["id"] !='')
    {
        $sql1 = "SELECT * FROM charge WHERE id = '".$_POST["id"]."'";
        $result = mysqli_query($connection, $sql1);
        $o = mysqli_fetch_array($result);
        $values = $o["charge_time_enum"];
        $nameofc = $o["name"];
        $forp = $o["charge_calculation_enum"];
        if ($values == 1) {
            $xs = "Disbursement";
          } else if ($values == 2) {
            $xs = "Specified Due Date";
          } else if ($values == 3) {
            $xs = "Savings Activiation";
          } else if ($values == 5) {
            $xs = "Withdrawal Fee";
          } else if ($values == 6) {
            $xs = "Annual Fee";
          } else if ($values == 8) {
            $xs = "Installment Fees";
          } else if ($values == 9) {
            $xs = "Overdue Installment Fee";
          } else if ($values == 12) {
            $xs = "Disbursement - Paid With Repayment";
          } else if ($values == 13) {
            $xs = "Loan Rescheduling Fee";
          } 
        $int_id = $_POST["int_id"];
        $branch_id = $_POST["branch_id"];
        $charge_id = $_POST["id"];
        $colon = date('Y-m-d H:i:s');
        $inload = mysqli_query($connection, "INSERT INTO charges_cache 
        (`int_id`, `branch_id`, `charge_id`, `name`, `charge`, `collected_on`,
        `date`, `is_status`, `cache_prod_id`)
        VALUES ('{$int_id}', '{$branch_id}', '{$charge_id}',
        '{$nameofc}', '{$charge}', '1', NULL, '0', NULL)");
        $sql = "SELECT * FROM charge WHERE id = '".$_POST["id"]."'";
        $table = "SELECT * FROM `charges_cache` WHERE cache_prod_id = '".$_POST["prod_id"]."'";
    }
    else
    {
        $sql = "SELECT * FROM charge";
    }
    $result = mysqli_query($connection, $sql);

    while ($row = mysqli_fetch_array($result))
    {
        $output = '<p><label>Name: '.$row["name"].' </label> <span></span></p>
        <p><label>Charge: '.$row["amount"].' </label> <span></span></p>
        <p><label>Collected on: '.$row["fee_on_day"].' </label> <span></span></p>';
    }
    echo $output;
}
?>