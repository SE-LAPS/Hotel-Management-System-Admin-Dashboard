<?php
session_start();
$id = $_SESSION['id'];
include '../conixion.php';

if (isset($_POST['submit'])){
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
   
    $requete = $con->prepare("UPDATE hotels_list 
    SET 
    HotelName = :HotelName,
    Stars = :Stars,
    Address = :Address,
    City = :City,
    Country = :Country,
    PhoneNumber = :PhoneNumber,
    Email = :Email,
    Website = :Website,
    Category = :Category,
    TotalRooms = :TotalRooms,
    Amenities = :Amenities
    WHERE Id = :id");

$requete->bindParam(':HotelName', $HotelName);
$requete->bindParam(':Stars', $Stars);
$requete->bindParam(':Address', $Address);
$requete->bindParam(':City', $City);
$requete->bindParam(':Country', $Country);
$requete->bindParam(':PhoneNumber', $PhoneNumber);
$requete->bindParam(':Email', $Email);
$requete->bindParam(':Website', $Website);
$requete->bindParam(':Category', $Category);
$requete->bindParam(':TotalRooms', $TotalRooms);
$requete->bindParam(':Amenities', $Amenities);
$requete->bindParam(':id', $id, PDO::PARAM_INT);

$res = $requete->execute();
    header("location:hotels_list.php");
}
?>