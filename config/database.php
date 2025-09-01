<?php
$host = 'sql107.infinityfree.com';
$db   = 'if0_39545670_toetsweek';
$user = 'if0_39545670';
$pass = 'Momo7318';

$conn = new mysqli($host, $user, $pass, $db);

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
