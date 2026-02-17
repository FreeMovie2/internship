<?php
error_reporting(0);

$host = 'localhost';
$serverName = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost';
$serverName = explode(':', $serverName)[0];
$isLocal = in_array($serverName, ['localhost', '127.0.0.1', '::1'], true);

if ($isLocal) {
    $username = 'root';
    $password = '';
    $database_name = 'student_internship';
} else {
    $username = 'idwebonl_intership';
    $password = 'kY95RZZNKerh6aehu6dE';
    $database_name = 'idwebonl_intership';
}

$conn = new mysqli($host, $username, $password, $database_name);

if ($conn->connect_errno) {
    die('Connect failed ' . $conn->connect_errno);
}

$conn->set_charset('UTF8');
?>