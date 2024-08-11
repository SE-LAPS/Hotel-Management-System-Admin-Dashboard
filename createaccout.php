<?php

// Include the database connection file
include 'conixion.php'; // Replace with the actual path to your conixion.php file

// Check if the form has been submitted
if(isset($_POST['submit'])){
    $userName = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $conPass = $_POST['conPass'];

    // Check if the password and confirmation password match
    if($pass === $conPass){
        var_dump($userName);
        $stmt = $con->prepare("INSERT INTO users(username, Email, Password) VALUES(:username, :email, :password)");
        $stmt->bindParam(':username', $userName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $pass);

        // Execute the prepared statement
        $stmt->execute();
        header('location:index.php');
    }
    else{
        header("location:index.php?error=password not found");
    }
}
?>