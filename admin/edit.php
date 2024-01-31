<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flight_booking_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch image filenames from the database based on the ID
    $sql = "SELECT * FROM images WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $imageData = $result->fetch_assoc();
        $filenames = unserialize($imageData['filename']);
    } else {
        $filenames = [];
    }
} else {
    // Handle the case when the ID is not provided in the URL
    echo "Invalid request. Please provide an ID.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Image</title>
    <style>
           body {
            font-family: Arial, sans-serif;
        }

        h2 {
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            max-width: 100%;
            height: 300px;
        }

        p {
            color: #777;
        }

        a {
            text-decoration: none;
            color: #3498db;
        }
    </style>
</head>
<body>
    <h2>Edit Image</h2>
    <?php if (!empty($filenames)): ?>
        <form action="update.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <table>
                <tr>
                    <th>Current Images</th>
                    
                </tr>
                <tr>
                    <?php foreach ($filenames as $filename): ?>
                    <td>
                            <img src="images/<?php echo $filename; ?>" alt="Image"><br>
                    </td>
                    <?php endforeach; ?>
                    <td>
                        <input type="file" name="new_images[]" multiple accept="image/*">
                    </td>
                </tr>
            </table>
            <br>
            <button type="submit">Update Image</button>
        </form>
    <?php else: ?>
        <p>No image found for the provided ID.</p>
    <?php endif; ?>


    <br>
    <a href="image-show.php">Back to Image Display</a>
</body>
</html>
