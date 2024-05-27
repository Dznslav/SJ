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

    public function closeConnection() {
        $this->conn->close();
    }
}

class UploadProcessing {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function processUpload() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["photo"]["name"]);

                if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                    $comment = $_POST["comment"];
                    $filename = $_FILES["photo"]["name"];
                    $filepath = $target_file;

                    $sql = "INSERT INTO photos (filename, filepath, comment) VALUES (?, ?, ?)";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bind_param("sss", $filename, $filepath, $comment);

                    if ($stmt->execute()) {
                        header("Location: portal.php");
                        exit();
                    } else {
                        echo "Saving error! " . $this->conn->error;
                    }

                    $stmt->close();
                } else {
                    echo "Upload error!";
                }
            } else {
                echo "No file chosen!";
            }
        } else {
            echo "Error.";
            exit();
        }
    }
}

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'portal';

$db = new Database($host, $username, $password, $database);
$conn = $db->getConnection();

$uploadProcessing = new UploadProcessing($conn);
$uploadProcessing->processUpload();

$db->closeConnection();
?>
