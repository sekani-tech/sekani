<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'sekanisy');
define('DB_PASSWORD', '4rWY#JP+rnl67');
define('DB_CHARSET', 'utf-8');
define('DB_NAME', 'sekanisy_demo');
// connect to the database with the defined values
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
// if there's an error
if (!$connection) {
    echo "Failed to connect database" . die(mysqli_error($connection));
}
$dbselect = mysqli_select_db($connection, DB_NAME);
if (!$dbselect) {
    echo "Failed to select database" . die(mysqli_error($connection));
}