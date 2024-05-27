<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $photoId = $_POST['photo_id'];
    $photoComment = $_POST['photo_comment'];

    $stmt = $conn->prepare("UPDATE photos SET comment = ? WHERE id = ?");
    $stmt->bind_param("si", $photoComment, $photoId);
    if ($stmt->execute()) {
        header("Location: portal.php");
        exit();
    } else {
        echo "Error updating comment: " . $stmt->error;
    }
}
?>
