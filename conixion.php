<?php
try {

  // Try to establish a connection to the MySQL database using PDO
  $con = new PDO("mysql:host=localhost;dbname=hotel_mng", "root", "");

  // Set the PDO error mode to exception to enable error handling
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

// Catch any PDOExceptions that are thrown if the connection fails
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>