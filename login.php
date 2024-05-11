<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'portal';

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    // extracting username and password from database
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // password check
        if (password_verify($password, $row['password'])) {
            // set session if password is ok
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            // check if user is admin
            $_SESSION['is_admin'] = ($row['is_admin'] == 'yes') ? true : false;
            // redir to portal
            header("Location: portal.php");
            exit();
        } else {
            // if username or password is wrong
            echo "Wrong username or password.";
        }
    } else {
        // if username or password is wrong
        echo "Wrong username or passqord.";
    }

    $stmt->close();
    $conn->close();
}
?>
