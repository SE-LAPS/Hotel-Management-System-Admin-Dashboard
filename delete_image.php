<?php
include 'conixion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];

    // Delete the latest image from the user_images table
    $query = "DELETE FROM user_images WHERE user_id = :userId ORDER BY id DESC LIMIT 1";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();

    // Remove the image path from the session
    unset($_SESSION['image_path']);

    echo 'Image deleted successfully';
}
?>