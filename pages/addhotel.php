<?php 
include '../conixion.php';

if(isset($_POST['submit'])){
    $image = $_FILES['img']['name'];
    $tempname = $_FILES['img']['tmp_name'];  
    $folder = "../assets/img/".$image;
    
    if(move_uploaded_file($tempname,$folder)){
        echo 'Image uploaded successfully';
    }

    $HotelName = $_POST['HotelName'];
    $Stars = $_POST['Stars'];
    $Address = $_POST['Address'];
    $City = $_POST['City'];
    $Country = $_POST['Country'];
    $PhoneNumber = $_POST['PhoneNumber'];
    $Email = $_POST['Email'];
    $Website = $_POST['Website'];
    $Category = $_POST['Category'];
    $TotalRooms = $_POST['TotalRooms'];
    $Amenities = $_POST['Amenities'];

    $requete = $con->prepare("INSERT INTO hotels_list (img, HotelName, Stars, Address, City, Country, PhoneNumber, Email, Website, Category, TotalRooms, Amenities) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $requete->execute([$image, $HotelName, $Stars, $Address, $City, $Country, $PhoneNumber, $Email, $Website, $Category, $TotalRooms, $Amenities]);

    header('location: hotels_list.php');
    exit();
}
?>