<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no pssword) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'sekanisy');
define('DB_PASSWORD', '4r6WY#JP+rnl67');
define('DB_CHARSET', 'utf8');
define('DB_NAME', 'sekanisy_admin');
<<<<<<< HEAD
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!$connection){
	echo "Failed to connect database" . die(mysqli_error($connection));;
}
$dbselect = mysqli_select_db($connection, DB_NAME);
if(!$dbselect){
	echo "Failed to Select database" . die(mysqli_error($connection));
=======
// hello
error_reporting(E_ALL & ~E_NOTICE);

// LIB PATH
// ! MANUALLY CHANGE THIS IF PHP IS THROWING FILE-NOT-FOUND ERRORS !
define('PATH_LIB', __DIR__ . DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR);
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
>>>>>>> 9d0fd3156bdc4fd5fb71eeb1a773ceddefb017dd
}
$caching=10;
?>