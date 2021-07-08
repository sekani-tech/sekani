<?php

include("../connect.php");

if (isset($_POST['client_id'])) {
    $clientId = $_POST['client_id'];
    $idType = $_POST['id_type'];
    if (isset($_FILES['id_card']) || !empty($_FILES['id_card']['tmp_name'])) {
        $temp2 = explode(".", $_FILES['id_card']['name']);
        $digits = 10;
        $randms2 = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
        $clientIdCard = $clientId . '.' . $randms2 . '.' . end($temp2);

        if (move_uploaded_file($_FILES['id_card']['tmp_name'], "../clients/id/" . $clientIdCard)) {
            echo $msg = "Image uploaded successfully";
        } else {
            echo $msg = "Image Failed";
        }
        $updateCondition = [
            'id_img_url' => $clientIdCard,
            'id_card' => $idType
        ];
        $updateMandate = update('client', $clientId, 'id', $updateCondition);
        if (!$updateMandate) {
            $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
            // could not update client info 
            // otherwise file upload was successful
            $_SESSION["error"] = "Something went wrong - $error";
            echo header("Location: ../../mfi/client_view.php?edit=$clientId");
            exit();
        } else {
            //output
            $_SESSION['success'] = 'Mandate Successfully Updated';
            header("Location: ../../mfi/client_view.php?edit={$clientId}");
        }
    } else if (isset($_FILES['signature']) || !empty($_FILES['signature']['tmp_name'])) {
        $clientId = $_POST['client_id'];
        $temp2 = explode(".", $_FILES['signature']['name']);
        $digits = 10;
        $randms2 = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
        $clientIdCard = $clientId . '.' . $randms2 . '.' . end($temp2);

        if (move_uploaded_file($_FILES['signature']['tmp_name'], "../clients/sign/" . $clientIdCard)) {
            echo $msg = "Image uploaded successfully";
        } else {
            echo $msg = "Image Failed";
        }
        $updateCondition = [
            'signature' => $clientIdCard
        ];
        $updateMandate = update('client', $clientId, 'id', $updateCondition);
        if (!$updateMandate) {
            $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
            // could not update client info 
            // otherwise file upload was successful
            $_SESSION["error"] = "Something went wrong - $error";
            echo header("Location: ../../mfi/client_view.php?edit=$clientId");
            exit();
        } else {
            //output
            $_SESSION['success'] = 'Mandate Successfully Updated';
            header("Location: ../../mfi/client_view.php?edit={$clientId}");
        }
    } else if (isset($_FILES['passport']) || !empty($_FILES['passport']['tmp_name'])) {
        $clientId = $_POST['client_id'];
        $temp2 = explode(".", $_FILES['passport']['name']);
        $digits = 10;
        $randms2 = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
        $clientIdCard = $clientId . '.' . $randms2 . '.' . end($temp2);

        if (move_uploaded_file($_FILES['passport']['tmp_name'], "../clients/passport/" . $clientIdCard)) {
            echo $msg = "Image uploaded successfully";
        } else {
            echo $msg = "Image Failed";
        }
        $updateCondition = [
            'passport' => $clientIdCard
        ];
        $updateMandate = update('client', $clientId, 'id', $updateCondition);
        if (!$updateMandate) {
            $error = "Error: %s\n" . mysqli_error($connection); //checking for errors
            // could not update client info 
            // otherwise file upload was successful
            $_SESSION["error"] = "Something went wrong - $error";
            echo header("Location: ../../mfi/client_view.php?edit=$clientId");
            exit();
        } else {
            //output
            $_SESSION['success'] = 'Mandate Successfully Updated';
            header("Location: ../../mfi/client_view.php?edit={$clientId}");
        }
    } else {
        $_SESSION["error"] = "File Upload suddenly Halted";
        echo header("Location: ../../mfi/client_view.php?edit=$clientId");
    }
} else {
    $_SESSION["error"] = "No file posted";
    echo header("Location: ../../mfi/client_view.php?edit=$clientId");
}
