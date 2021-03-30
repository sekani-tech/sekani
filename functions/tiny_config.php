<?php
// session_start();
$config = array();

// Replace this with your api key from the "API Key Manager" at the tiny.cloud account page
$config["apiKey"] = "v1swnrhsmr3y1hiqxfod4nn2m7o6ie9l419y7bqsngp0ft44";

// Replace the contents of the private.key file with the one from the "JWT Key Manager" at the tiny.cloud account page
$config['privateKeyFile'] = "./private.key";

$userName = $_SESSION['username'];
// $password = $_SESSION['password'];
// This is the fake database that the login authenticates against
$config["users"] = [
  ["username" => "$userName"]
];

// If this is enabled the root of Tiny Drive will be within a directory named as the user login
$config["scopeUser"] = false;
