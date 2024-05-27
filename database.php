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

    public function getConnection() {
        return $this->conn;
    }
}

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

$db = new Database($host, $username, $password, $database);
$conn = $db->getConnection();
?>
