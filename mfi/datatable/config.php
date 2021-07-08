<?php

$host = "localhost"; /* Host name */
$user = "sekanisy"; /* User */
$password = "4r6WY#JP+rnl67"; /* Password */
$dbname = "sekanisy_admin"; /* Database name */

$con = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$con) {
 die("Connection failed: " . mysqli_connect_error());
}