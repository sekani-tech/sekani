<?php
    session_start();
    $connection = mysqli_connect('localhost', 'sekanisy', '4rWY#JP+rnl67', 'sekanisy_admin');

    $int_id = $_POST['int_id'];
    $branch_id = $_POST['branch_id'];
    $transaction_id = $_POST['transaction_id'];
    // $transaction_id = strtolower(substr(str_replace(' ', '', $item), 0, 3)) . "-" . $_POST['transaction_id'];
    $date = $_POST['date'];
    $datetime = date('Y-m-d H:i:s');
    $item = trim($_POST['item']);
    $quantity = trim($_POST['quantity']);
    $unit = trim($_POST['price']);
    $total = $_POST['total'];
    $charge = trim($_POST['charge']);

    $query = "SELECT * FROM inventory WHERE item = '$item'";  
    $result = mysqli_query($connection, $query);

    if(mysqli_num_rows($result) < 1)  {
        $query = "SELECT id FROM charge WHERE name = '{$charge}'";
        $result = mysqli_query($connection, $query);

        if(mysqli_num_rows($result) == 1) {
            $charge = mysqli_fetch_array($result);
            $charge_id = $charge["id"];

            $addInventoryQuery = "INSERT INTO inventory(int_id, branch_id, transaction_id, date, item, quantity, unit_price, total_price, charge_id)
            VALUES('{$int_id}', '{$branch_id}', '{$transaction_id}', '{$date}', '{$item}', '{$quantity}', '{$unit}', '{$total}', '{$charge_id}') ";
            $addInventory = mysqli_query($connection, $addInventoryQuery);

            if($addInventory) {
                $getInventoryID = mysqli_query($connection, "SELECT id FROM inventory WHERE transaction_id = '{$transaction_id}'");
                $getInventoryID = mysqli_fetch_array($getInventoryID);

                if ($getInventoryID) {
                    $inventory_id = $getInventoryID['id'];
                    $addToInventoryHistoryTbl = "INSERT INTO inventory_history (inventory_id, transaction_id, transaction_type, amount, timestamp)
                                                VALUES('{$inventory_id}', '{$transaction_id}', 'insert', '{$total}', '{$datetime}') ";
                    $addToInventoryHistoryTbl = mysqli_query($connection, $addToInventoryHistoryTbl);

                    if($addToInventoryHistoryTbl) {
                        $_SESSION['success'] = "Inventory Posted Successfully";
                        $URL = "../inventory.php";
                        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';   
                    }
                }
            } else {
                $_SESSION['error'] = "Cannot Add Inventory";
                $URL = "../inventory.php";
                echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
            }

        } else {
            $_SESSION['error'] = "Charge Type Does Not Exist";
            $URL = "../inventory.php";
            echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
        }      
        
    } else {
        $query = "SELECT id FROM charge WHERE name = '{$charge}'";
        $result = mysqli_query($connection, $query);

        if(mysqli_num_rows($result) == 1) {
            $charge = mysqli_fetch_array($result);
            $charge_id = $charge["id"];

            $updateInventoryQuery = "UPDATE inventory SET quantity = '$quantity', unit_price = '$unit', 
                                    total_price = '$total', charge_id = '$charge_id' WHERE item = '$item'";
            $updateInventory = mysqli_query($connection, $updateInventoryQuery);

            if($updateInventory) {
                $getInventoryID = mysqli_query($connection, "SELECT id FROM inventory WHERE transaction_id = '{$transaction_id}'");
                $getInventoryID = mysqli_fetch_array($getInventoryID);

                if ($getInventoryID) {
                    $inventory_id = $getInventoryID['id'];
                    $addToInventoryHistoryTbl = "INSERT INTO inventory_history (inventory_id, transaction_id, transaction_type, amount, timestamp)
                                                VALUES('{$inventory_id}', '{$transaction_id}', 'update', '{$total}', '{$datetime}') ";
                    $addToInventoryHistoryTbl = mysqli_query($connection, $addToInventoryHistoryTbl);

                    if($addToInventoryHistoryTbl) { 
                        $_SESSION['success'] = "Inventory Updated Successfully"; 
                        $URL = "../inventory.php";
                        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                    }
                }
            }
        } else {
            $_SESSION['error'] = "Charge Type Does Not Exist";
            $URL = "../inventory.php";
            echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
        }
    }