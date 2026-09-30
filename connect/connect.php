<?php
error_reporting(0);

// Credentials live in connect/config.php (git-ignored). See config.example.php.
// Without it, only localhost falls back to the default local XAMPP/MAMP settings.
$config = is_file(__DIR__ . '/config.php') ? require __DIR__ . '/config.php' : null;

if ($config === null) {
    $serverName = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost';
    $serverName = explode(':', $serverName)[0];
    if (!in_array($serverName, ['localhost', '127.0.0.1', '::1'], true)) {
        die('Missing connect/config.php');
    }
    $config = [
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'student_internship',
    ];
}

$host = $config['host'];
$username = $config['username'];
$password = $config['password'];
$database_name = $config['database'];

$conn = new mysqli($host, $username, $password, $database_name);

if ($conn->connect_errno) {
    die('Connect failed ' . $conn->connect_errno);
}

$conn->set_charset('UTF8');
?>
