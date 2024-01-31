<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flight_booking_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // Fetch existing image data
    $sqlSelect = "SELECT * FROM images WHERE id = $id";
    $resultSelect = $conn->query($sqlSelect);

    if ($resultSelect->num_rows > 0) {
        $row = $resultSelect->fetch_assoc();
        $existingFilenames = unserialize($row['filename']);
    } else {
        echo "Error: No image found for the provided ID.";
        exit;
    }

    // Handle new images
    $newFilenames = [];

    if (!empty($_FILES['new_images']['name'][0])) {
        foreach ($_FILES['new_images']['name'] as $key => $newFilename) {
            $tmpFilePath = $_FILES['new_images']['tmp_name'][$key];
            if (!empty($newFilename)) {
                $newFilenames[] = $newFilename;
                move_uploaded_file($tmpFilePath, "images/" . $newFilename);
            }
        }
    }

    // Combine existing and new filenames
    $allFilenames = array_merge($existingFilenames, $newFilenames);

    // Update the image data in the database
    $serializedFilenames = serialize($allFilenames);
    $sqlUpdate = "UPDATE images SET filename = '$serializedFilenames' WHERE id = $id";

    if ($conn->query($sqlUpdate) === TRUE) {
        echo "Image updated successfully";
        header("Location: image-show.php");
        exit;
    } else {
        echo "Error updating image: " . $conn->error;
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
