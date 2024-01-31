<?php include 'db_connect.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload Form</title>
</head>
<body>
    <h2>
        Image upload with insert
    </h2>
    <form action="process.php" method="post" enctype="multipart/form-data">
        <label for="images">Select Multiple Images:</label>
        <input type="file" name="images[]" id="images" multiple accept="image/*" required>
        <br>
        <input type="submit" value="Upload Images">
    </form>
    <br>
    <a href="image-show.php"><button>Show Images</button></a>
</body>
</html>
