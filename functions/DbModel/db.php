<?php
<<<<<<< HEAD
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'sekanisy');
define('DB_PASSWORD', '4rWY#JP+rnl67');
=======
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no pssword) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'sekanisy');
define('DB_PASSWORD', '4r6WY#JP+rnl67');
>>>>>>> e32fa236daf240016d789011fcaf652f1c9e0bc1
define('DB_CHARSET', 'utf-8');
define('DB_NAME', 'sekanisy_admin');
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