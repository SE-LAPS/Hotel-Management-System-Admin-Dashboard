<?php
include 'conixion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];
    $image = $_FILES['image'];

    // Process and move the uploaded file to a desired location
    $uploadDir = 'uploads/';
    $imagePath = $uploadDir . basename($image['name']);
    if (move_uploaded_file($image['tmp_name'], $imagePath)) {
        // Insert the image path into the user_images table
        $query = "INSERT INTO user_images (user_id, image_path) VALUES (:userId, :imagePath)";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':imagePath', $imagePath);
        $stmt->execute();

        // Store the uploaded image path in the session
        $_SESSION['image_path'] = $imagePath;

        echo 'Image uploaded successfully';
    } else {
        echo 'Error uploading image';
    }
}
?>