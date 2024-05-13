<?php
session_start();

// session check
if (!isset($_SESSION['user_id'])) {
    // redirect to login if not logged in
    header("Location: logreg.php");
    exit();
}

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'portal';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>