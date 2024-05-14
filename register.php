<?php
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

    public function closeConnection() {
        $this->conn->close();
    }
}

class Registration {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function registerUser($username, $password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("INSERT INTO users (username, password, is_admin) VALUES (?, ?, 'no')");
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute() === TRUE) {
            echo "Successful registration!";
        } else {
            echo "Registration error: " . $this->conn->error;
        }

        $stmt->close();
    }
}

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'portal';

$db = new Database($host, $username, $password, $database);
$conn = $db->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $registration = new Registration($conn);

    $username = $_POST['username'];
    $password = $_POST['password'];

    $registration->registerUser($username, $password);
}

$db->closeConnection();
?>
