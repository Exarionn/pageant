<?php

// Read the INI file
$config = parse_ini_file('config.ini', true);

// connect to database
$db_host = $config['Database']['db_host'];
$db_user = $config['Database']['db_user'];
$db_password = $config['Database']['db_password'];
$db_name = $config['Database']['db_name'];
$db = mysqli_connect($db_host, $db_user, $db_password, $db_name);

// check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
    $_SESSION['status'] = "Error Database Handshake!";
    $_SESSION['status_code'] = "Error";
    header('location: ../500.php');
}

// Set the character set to UTF-8
mysqli_set_charset($db, "utf8");

session_start();
?>
