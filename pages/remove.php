<?php 

    // Include the database connection file
    include '../conixion.php';

    // Retrieve the 'Id' parameter from the GET request and assign it to a variable
    $id = $_GET['Id'];

   // Check if the 'Id' parameter is set and not empty
    if(isset($id)){
        $stmt = $con ->prepare("DELETE FROM hotels_list WHERE Id=$id");

         // Execute the prepared statement
        $stmt -> execute();

    }

    // Redirect to the 'students_list.php' page after deletion
    header('location:hotels_list.php');
?>