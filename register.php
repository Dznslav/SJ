<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'portal';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ddata processing from form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // pwd hashing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // insert into db
    $stmt = $conn->prepare("INSERT INTO users (username, password, is_admin) VALUES (?, ?, 'no')");
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute() === TRUE) {
        echo "Регистрация прошла успешно.";
    } else {
        echo "Ошибка при регистрации: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
