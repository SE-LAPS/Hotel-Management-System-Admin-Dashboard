<?php
include '../../conixion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $uploadDir = '../../assets/img/user_images/';
    
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
    $uploadFile = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
        $image_path = '/Hotel_Mng_Dashboard/assets/img/user_images/' . $fileName;

        $query = "INSERT INTO user_images (user_id, image_path) VALUES (:user_id, :image_path)";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':image_path', $image_path);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'image_path' => $image_path]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error saving image to database']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error uploading file']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}