<?php
include '../../conixion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];

    // Get the current image path
    $query = "SELECT image_path FROM user_images WHERE user_id = :user_id ORDER BY id DESC LIMIT 1";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $image_path = $result['image_path'];
        $full_path = $_SERVER['DOCUMENT_ROOT'] . $image_path;

        // Delete the image file
        if (file_exists($full_path)) {
            unlink($full_path);
        }

        // Delete the image record from the database
        $delete_query = "DELETE FROM user_images WHERE user_id = :user_id AND image_path = :image_path";
        $delete_stmt = $con->prepare($delete_query);
        $delete_stmt->bindParam(':user_id', $user_id);
        $delete_stmt->bindParam(':image_path', $image_path);

        if ($delete_stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting image from database']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No image found for this user']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}