<?php
if (isset($_POST['submit'])){

    // Includes the database connection file
    include './pages/conixion.php';

    // Retrieves username & email from POST data
    $username = $_POST['username'];
    $email = $_POST['email'];

    // SQL query to select user based on username and email
    $requete = "SELECT * FROM users WHERE username = '$username' and Email = '$email'";

    // Prepare and execute the SQL statement
    $statment = $con -> prepare($requete);
    $statment -> execute();
    $result = $statment -> fetch();

    // Check if the retrieved username and email match the input values
    if ($username == $result['username'] && $email == $result['Email']){
        //header("location:newpass.php");
        echo $result['username'];
        echo $result['Email'];
    }
    }
?>