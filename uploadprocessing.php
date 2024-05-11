<?php
session_start(); // session start

// check if form was sent
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // check if file chosen
    if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
        // database connection
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'portal';

        $conn = new mysqli($host, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // upload photo to server
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);

        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            // receiving data from form if uploaded
            $comment = $_POST["comment"];
            $filename = $_FILES["photo"]["name"];
            $filepath = $target_file;

            // insertion into database
            $sql = "INSERT INTO photos (filename, filepath, comment) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $filename, $filepath, $comment);

            if ($stmt->execute()) {
                // if inserted then redirect to portal.php
                header("Location: portal.php");
                exit();
            } else {
                // if error then show error message
                echo "Ошибка при сохранении данных: " . $conn->error;
            }

            $stmt->close();
        } else {
            // error if file not uploaded
            echo "Ошибка при загрузке файла.";
        }

        $conn->close();
    } else {
        // if file not chosen
        echo "Файл не был выбран.";
    }
} else {
    // if sent by GET method
    header("Location: error.php");
    exit();
}
?>
