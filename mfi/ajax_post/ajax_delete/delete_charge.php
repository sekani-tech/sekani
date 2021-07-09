
<?php 
include('../../../functions/connect.php');

$id = 0;
if(isset($_POST['id'])){
   $id = mysqli_real_escape_string($connection, $_POST['id']);
}

if($id > 0){

	// Check record exists
<<<<<<< HEAD
	$checkRecord = mysqli_query($connection,"SELECT * FROM product_loan_charge WHERE id='$id'");
=======
	$checkRecord = mysqli_query($connection,"SELECT * FROM loan_charge WHERE id='$id'");
>>>>>>> Victor
	$totalrows = mysqli_num_rows($checkRecord);

	if($totalrows > 0){
		// Delete record
<<<<<<< HEAD
		$query = "DELETE FROM product_loan_charge WHERE id='$id'";
=======
		$query = "DELETE FROM loan_charge WHERE id='$id'";
>>>>>>> Victor
		mysqli_query($connection,$query);
		echo 1;
		exit;
	}else{
        echo 0;
        exit;
    }
}

echo 0;
exit;