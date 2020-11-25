<?php
include 'vendor/autoload.php';

$digit = 4;
$randms = str_pad(rand(0, pow(10, $digit) - 1), 7, '0', STR_PAD_LEFT);

if (isset($_GET['name'])) {
    $name = "files/" . $_GET['name'] . ".xlsx";
    if (file_exists($name)) {
//        header('Content-Description: File Transfer');
//        header('Content-Type: application/force-download');
//        header("Content-Disposition: attachment; filename=\"" . basename($name) . "\";");
//        header('Content-Transfer-Encoding: binary');
//        header('Expires: 0');
//        header('Cache-Control: must-revalidate');
//        header('Pragma: public');
//        header('Content-Length: ' . filesize($name));
//        ob_clean();
//        flush();
//        readfile("files/" . $name); //showing the path to the server where the file is to be download
        header("location: $name");
        exit;
    } elseif ($_GET['loc'] == 1) {
        $_SESSION["Lack_of_intfund_$randms"] = "File Input Rejected!";
        header("Location: ../bulk_deposit.php?message1=$randms");
        exit();
    } elseif ($_GET['loc'] == 2) {
        $_SESSION["Lack_of_intfund_$randms"] = "File Input Rejected!";
        header("Location: ../bulk_client_data.php?message1=$randms");
        exit();
    }
}
