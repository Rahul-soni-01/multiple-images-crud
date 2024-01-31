<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flight_booking_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!empty($_FILES['images']['name'][0])) {
    $location = "C:/wamp64/www/Airline-Reservation-System-PHP-Project-Source-Code/flight/admin/images/";

    $uploadedFilenames = [];

    foreach ($_FILES['images']['name'] as $key => $val) {
        $timestamp = time();
        $newFilename = $timestamp . '_' . $val;
        $targetPath = $location . $newFilename;
        $imageFileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
        $allowedExtensions = array("jpg", "jpeg", "png", "gif");

        if (in_array($imageFileType, $allowedExtensions)) {
            move_uploaded_file($_FILES['images']['tmp_name'][$key], $targetPath);
            $uploadedFilenames[] = $newFilename;
        } else {
            echo "Invalid file type for $val. Only JPG, JPEG, PNG, and GIF files are allowed.";
        }
    }

    $serializedFilenames = serialize($uploadedFilenames);
    $sql = "INSERT INTO images (filename) VALUES ('$serializedFilenames')";
    $conn->query($sql);

    echo "Images uploaded successfully!";
} else {
    echo "No images selected for upload.";
}

$conn->close();
?>
