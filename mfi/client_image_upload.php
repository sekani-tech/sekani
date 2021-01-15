<?php
$page_title = "Client Image Upload";
include('header.php');

if(isset($_POST) && !empty($_FILES['image']['name'])){
    $client_id = $_POST['client_id'];
    $branchQuery = mysqli_query($connection, "SELECT branch_id FROM client WHERE id = {$client_id}");
    $clientBranch = mysqli_fetch_array($branchQuery);
        
    $branch_id = $clientBranch["branch_id"];
	$name = $_FILES['image']['name'];
	list($txt, $ext) = explode(".", $name);
	$image_name = time().".".$ext;
    $tmp = $_FILES['image']['tmp_name'];
    $uploaded_at = date('Y-m-d H:i:s');

	if(move_uploaded_file($tmp, 'uploads/'.$image_name)){
		$sql = "INSERT INTO client_uploads (int_id, branch_id, client_id, image, timestamp) 
                VALUES ('{$sessint_id}', '{$branch_id}', '{$client_id}', '{$image_name}', '{$uploaded_at}')";
		mysqli_query($connection, $sql);
		$_SESSION['success'] = 'Image Uploaded Successfully';
        header("Location: /mfi/client_view.php?edit={$client_id}");     
	}else{
		$_SESSION['error'] = 'Image Upload Failed';
		header("Location: /mfi/client_view.php?edit={$client_id}");
	}
}else{
	$_SESSION['error'] = 'Please Select Image';
	header("Location: /mfi/client_view.php?edit={$client_id}");
}

?>