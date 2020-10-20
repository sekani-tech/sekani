<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'sekanisy');
define('DB_PASSWORD', '4r6WY#JP+rnl67');
define('DB_CHARSET', 'utf8');
define('DB_NAME', 'sekanisy_admin');
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!$connection){
	echo "Failed to connect database" . die(mysqli_error($connection));;
}
$dbselect = mysqli_select_db($connection, DB_NAME);
if(!$dbselect){
	echo "Failed to Select database" . die(mysqli_error($connection));
}
?>