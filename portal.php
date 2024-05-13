<?php
include 'database.php';
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
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            background-color: gray;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .delete-button:hover {
            background-color: #d32f2f;
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

<!-- big div -->
<div class="photo-container">
    <?php
    // extracting photo and comment from db
    $sql = "SELECT * FROM photos";
    $result = $conn->query($sql);

    $blocks_per_page = 9;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page - 1) * $blocks_per_page;
    $end = $start + $blocks_per_page - 1;
    $counter = 0;

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $counter++;
            if ($counter > $end) break;
            if ($counter >= $start) {
                echo "<div class='photo-block'>";
                echo "<img src='" . $row['filepath'] . "' alt='Photo'>";
                echo "<p>" . $row['comment'] . "</p>";
                if ($_SESSION['is_admin']) {            // admin check
                    echo "<form action='delete.php' method='post'>";
                    echo "<input type='hidden' name='delete_id' value='" . $row['id'] . "'>";
                    echo "<button type='submit' class='delete-button'>Delete</button>";
                    echo "</form>";
                }
                echo "</div>";
            }
        }
    } else {
        echo "Nothing to display. Upload some photos to change this!";
    }
    ?>
</div>

<!-- pagination -->
<div class="pagination">
    <?php
    // page buttons
    $total_pages = ceil($result->num_rows / $blocks_per_page);
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='portal.php?page=$i' class='page-button'>$i</a>";
    }
    ?>
</div>

<!-- logout button -->
<div class="logoutbut">
    <form action="logout.php" method="post">
        <button type="submit" class="logout-button">Logout</button>
    </form>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-1BmE4kWBq4u5j7Z3zGzFp2Z1fF
6VbZl3Jw2m6Xz2nFh4Jjzr4z+Jm9c
2Z6zvJz" crossorigin="anonymous"></script>
</body>
</html>
