<?php
$page_title = "Client Image Delete";
include('header.php');

if(isset($_POST) && !empty($_POST['id']) && !empty($_POST['client_id'])) {
    $image_id = $_POST['id'];
    $client_id = $_POST['client_id'];

    // Delete image file from server
    $sql = "SELECT image FROM client_uploads WHERE id = {$image_id}";
    $image_data = mysqli_query($connection, $sql);
    $image = mysqli_fetch_array($image_data)["image"];
    unlink('uploads/'.$image);

    // Delete image upload record from database
    $sql = "DELETE FROM client_uploads WHERE id = {$image_id}";
    mysqli_query($connection, $sql);

    $_SESSION['success'] = 'Image Deleted Successfully';
    header("Location: /mfi/client_view.php?edit={$client_id}");
}else{
	$_SESSION['error'] = 'Please Select Image';
	header("Location: /mfi/client_view.php?edit={$client_id}");
}

?>