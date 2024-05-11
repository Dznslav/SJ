<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Photo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
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

        .upload-form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            resize: vertical;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-secondary:hover {
            background-color: #495057;
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
            <a class="nav-link" aria-current="page" href="portal.php">Portal</a>
            <a class="nav-link" href="upload.php">Upload</a>
            <a class="nav-link active" href="logreg.php">Login/Registration</a>
            <a class="nav-link active" href="index.html">Main Page</a>
          </div>
        </div>
      </div>
    </nav>
</header>

<h1>Upload Photo</h1>

<form action="uploadprocessing.php" method="post" enctype="multipart/form-data" class="upload-form">
    <div class="form-group">
        <label for="photo" class="form-label">Select image to upload:</label>
        <input type="file" name="photo" id="photo" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="comment" class="form-label">Enter a comment:</label>
        <textarea id="comment" name="comment" rows="4" class="form-control" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Upload Image</button>
</form>

<form action="logout.php" method="post">
    <button class="btn btn-secondary" type="submit">Выйти</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-1BmE4kWBq4u5j7Z3zGzFp2Z1fF
6VbZl3Jw2m6Xz2nFh4Jjzr4z+Jm9c
2Z6zvJz" crossorigin="anonymous"></script>
</body>
</html>
