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

    public function getUserByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    public function closeConnection() {
        $this->conn->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'portal';

    $db = new Database($host, $username, $password, $database);

    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = $db->getUserByUsername($username);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = ($user['is_admin'] == 'yes') ? true : false;
            header("Location: portal.php");
            exit();
        } else {
            echo "Wrong username or password.";
        }
    } else {
        echo "Wrong username or password.";
    }

    $db->closeConnection();
}
?>
