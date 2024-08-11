<?php
session_start();

// Include the database connection file
include 'conixion.php'; 

if(isset($_POST['submit'])){

    // Retrieve email and password from the POST request
    $email = $_POST['email'];
    $password = $_POST['pass'];

    // Prepare SQL query to select user based on email and password
    $requete = "SELECT * FROM users WHERE Email = '$email' and Password = '$password'";

     // Prepare and execute the SQL statement
    $statment = $con->prepare($requete);
    $statment->execute();

    // Fetch the result row as an associative array
    $result = $statment->fetch();

    // Check if a user with the given email and password exists
    if($result['Email'] === $email && $result['Password'] === $password){
        $_SESSION['name'] = $result['username'];
        $_SESSION['email'] = $result['Email'];
        $_SESSION['password'] = $result['Password'];

    // Check if 'Remember Me' checkbox is checked
        if(isset($_POST['check'])){
            setcookie('email', $_SESSION['email'], time() + 3600);
            setcookie('password', $_SESSION['password'], time() + 3600);
        }
        header("location:./pages/dashboard.php");
    }
    else if(empty($email) || empty($password)){
        header("location:index.php?error=please enter your email or password");
    }
    else {
        header("location:index.php?error=email or password not found");
    }
}
?>