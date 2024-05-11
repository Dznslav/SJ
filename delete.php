<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!$_SESSION['is_admin']) {
    header("Location: portal.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'portal';

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $delete_id = $_POST['delete_id'];
    $sql_delete = "DELETE FROM photos WHERE id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "<script>alert('Deleted');</script>";
    } else {
        echo "<script>alert('Error');</script>";
    }
    $stmt->close();
    $conn->close();
}

header("Location: portal.php");
exit();
?>
