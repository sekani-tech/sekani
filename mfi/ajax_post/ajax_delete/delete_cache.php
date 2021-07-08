<?php
include('../../../functions/connect.php');

$id = 0;
//dd($_POST['id']);
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    if ($id > 0) {
        // Check record exists
        $deleteRecord = delete('charges_cache', $id, 'id');
        if ($deleteRecord) {
            echo 1;
            exit;
        } else {
            echo 0;
            exit;
        }
    }
    echo 0;
    exit;
}