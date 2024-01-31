<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flight_booking_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch image filenames from the database
$sql = "SELECT * FROM images";
$result = $conn->query($sql);

$allImageData = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $allImageData[] = $row; // Fetch the entire row
    }

}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Display</title>
</head>
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
<body>
    <h2>Uploaded Images</h2>

 <?php if (!empty($allImageData)): ?>
    <table>
        <tr>
            <th>Images</th>
            <th>Edit</th>
        </tr>
        <?php foreach ($allImageData as $imageData): ?>
            <tr>
                <td>
                    <?php
                    $filenames = unserialize($imageData['filename']);
                    foreach ($filenames as $filename) {
                        echo '<img src="images/' . $filename . '" alt="Image">';
                    }
                    ?>
                </td>
                <td>
                    <a href="edit.php?id=<?php echo $imageData['id']; ?>">
                        <button class="edit-button">Edit</button>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <br>
<?php else: ?>
    <p>No images uploaded yet.</p>
<?php endif; ?>

    <br>
    <a href="insert.php">Back to Upload Form</a>
</body>
</html>
