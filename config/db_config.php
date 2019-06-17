<?php

// DB configuration
$server = "127.0.0.1";
$username = "root";
$db = "bigapple";
$password = 'Shraddha12345';
ob_start();
@
session_start();

$con = mysqli_connect($server, $username, $password, $db);

if (mysqli_connect_errno()) {
    echo 'Connection Failed to DB' . mysqli_connect_errno();
}

?>