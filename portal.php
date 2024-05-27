<?php
include 'database.php';

class PortalPage {
    private $conn;
    private $blocksPerPage = 10;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function displayPhotos() {
        $sql = "SELECT * FROM photos";
        $result = $this->conn->query($sql);

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $start = ($page - 1) * $this->blocksPerPage;
        $end = $start + $this->blocksPerPage - 1;
        $counter = 0;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $counter++;
                if ($counter > $end) break;
                if ($counter >= $start) {
                    echo "<div class='photo-block'>";
                    echo "<img src='" . $row['filepath'] . "' alt='Photo'>";
                    echo "<p id='comment-{$row['id']}'>" . $row['comment'] . "</p>";
                    if ($_SESSION['is_admin']) {
                        echo "<form action='portal.php' method='post' style='display:inline-block;'>";
                        echo "<input type='hidden' name='delete_id' value='" . $row['id'] . "'>";
                        echo "<button type='submit' name='delete' class='delete-button'>Delete</button>";
                        echo "</form>";
                        echo "<button type='button' class='edit-button' onclick='openEditForm(" . $row['id'] . ", `" . addslashes($row['comment']) . "`)'>Edit</button>";
                    }
                    echo "</div>";
                }
            }
        } else {
            echo "Nothing to display. Upload some photos to change this!";
        }
    }

    public function displayPagination() {
        $sql = "SELECT * FROM photos";
        $result = $this->conn->query($sql);
        $total_pages = ceil($result->num_rows / $this->blocksPerPage);
        
        echo "<div class='pagination'>";
        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<a href='portal.php?page=$i' class='page-button'>$i</a>";
        }
        echo "</div>";
    }

    public function deletePhoto($id) {
        $stmt = $this->conn->prepare("DELETE FROM photos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    public function updateComment($id, $comment) {
        $stmt = $this->conn->prepare("UPDATE photos SET comment = ? WHERE id = ?");
        $stmt->bind_param("si", $comment, $id);
        $stmt->execute();
        $stmt->close();
    }
}

$page = new PortalPage($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        $page->deletePhoto($_POST['delete_id']);
        header("Location: portal.php");
        exit();
    } elseif (isset($_POST['edit'])) {
        $page->updateComment($_POST['photo_id'], $_POST['photo_comment']);
        header("Location: portal.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Портал</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .photo-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .photo-block {
            width: 300px;
            padding: 10px;
            margin-bottom: 20px;
            border: 2px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            background-color: #f9f9f9;
            text-align: center;
            position: relative;
        }

        .photo-block img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .photo-block p {
            margin-top: 10px;
            margin-bottom: 50px;
            font-size: 14px;
            color: #666;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        .pagination {
            text-align: center;
            justify-content: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .page-button {
            display: inline-block;
            justify-content: center;
            align-items: center;
            padding: 5px 10px;
            margin: 0 5px;
            background-color: #f0f0f0;
            color: #333;
            text-decoration: none;
            border-radius: 5px;
        }

        .page-button:hover {
            background-color: #ccc;
        }

        .logoutbut {
            text-align: right;
            justify-content: right;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .logout-button {
            margin-top: 20px;
            align-items: center;
            justify-content: center;
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout-button:hover {
            background-color: #d32f2f;
        }

        .delete-button {
            width: 70px;
            position: absolute;
            bottom: 10px;
            left: 70%;
            transform: translateX(-50%);
            background-color: #e57373;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .edit-button {
            width: 70px;
            position: absolute;
            bottom: 10px;
            right: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }


        .delete-button:hover {
            background-color: #b71c1c;
        }
        .edit-button:hover {
            background-color: black;
        }

        .edit-form {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            background-color: white;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .edit-form textarea {
            width: 100%;
            height: 100px;
            margin-bottom: 10px;
        }

        .edit-form .close-button {
            background-color: #d32f2f;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .edit-form .save-button {
            background-color: #333;
            margin-right: 10px;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit-form .close-button:hover {
            background-color: #a10000;
        }
        .edit-form .save-button:hover {
            background-color: black;
        }
    </style>
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="portal.php">Dzianis Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="portal.php">Portal</a>
                    <a class="nav-link" href="upload.php">Upload</a>
                    <a class="nav-link" href="logreg.php">Login/Registration</a>
                    <a class="nav-link" href="index.html">Main Page</a>
                </div>
            </div>
        </div>
    </nav>
</header>

<div class="container">
    <div class="photo-container">
        <?php $page->displayPhotos(); ?>
    </div>

    <!-- Pagination -->
    <?php $page->displayPagination(); ?>

    <!-- Logout button -->
    <div class="logoutbut">
        <form action="logout.php" method="post">
            <button type="submit" class="logout-button">Logout</button>
        </form>
    </div>
</div>

<footer style="background-color: #ffffff;">
    <hr>
    <div class="container p-4">
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-4">
                <p>
                    “It is an illusion that photos are made with the camera… they are made with the eye, heart, and head.”
                </p>
                <h5 class="mb-3" style="letter-spacing: 2px; color: #000000;">-Henri Cartier-Bresson</h5>
            </div>
        </div>
    </div>
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2024 Copyright:
        <a class="text-dark" href="https://www.instagram.com/dzns_ph/">Dzianis Laurentsyeu</a>
    </div>
</footer>

<div class="edit-form" id="editForm">
    <form action="portal.php" method="post">
        <input type="hidden" name="photo_id" id="editPhotoId">
        <textarea name="photo_comment" id="editPhotoComment"></textarea>
        <button type="submit" name="edit" class="save-button">Save</button>
        <button type="button" class="close-button" onclick="closeEditForm()">Close</button>
    </form>
</div>

<script>
function openEditForm(id, comment) {
    document.getElementById('editPhotoId').value = id;
    document.getElementById('editPhotoComment').value = comment;
    document.getElementById('editForm').style.display = 'block';
}

function closeEditForm() {
    document.getElementById('editForm').style.display = 'none';
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
