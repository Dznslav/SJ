<?php
session_start();

class Database {
    private $conn;

    public function __construct($host, $username, $password, $database) {
        $this->conn = new mysqli($host, $username, $password, $database);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function deletePhoto($delete_id) {
        $sql_delete = "DELETE FROM photos WHERE id = ?";
        $stmt = $this->conn->prepare($sql_delete);
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute()) {
            echo "<script>alert('Deleted');</script>";
        } else {
            echo "<script>alert('Error');</script>";
        }
        $stmt->close();
    }

    public function closeConnection() {
        $this->conn->close();
    }
}

$db = new Database('localhost', 'root', '', 'portal');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!$_SESSION['is_admin']) {
    header("Location: portal.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $db->deletePhoto($delete_id);
}

$db->closeConnection();

header("Location: portal.php");
exit();
?>
