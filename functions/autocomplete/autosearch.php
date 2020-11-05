<?php
// CONNECT TO DATABASE
$host = 'localhost';
$dbname = 'sekanisy_admin';
$user = 'sekanisy';
$password = '4r6WY#JP+rnl67';
$charset = 'utf8';
$pdo = new PDO(
	"mysql:host=$host;dbname=$dbname;charset=$charset", $user, $password, [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false,
	]
);

session_start();
$int_id = $_SESSION['int_id'];
$branch_id = $_SESSION["branch_id"];
// SEARCH AND OUTPUT RESULTS
$stmt = $pdo->prepare("SELECT * FROM client WHERE int_id = '$int_id' AND status = 'Approved' AND (firstname LIKE ?  OR  middlename LIKE ? or lastname LIKE ? or display_name LIKE ?)");
$stmt->execute(["%" . $_GET['term'] . "%"]);
$data = [];
while ($row = $stmt->fetch(PDO::FETCH_NAMED)) {
	$data[] = $row['display_name'];
}
$pdo = null;
echo json_encode($data);
?>