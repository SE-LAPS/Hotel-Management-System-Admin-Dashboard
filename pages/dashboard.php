<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
</head>
<body class="bg-content">
    <main class="dashboard d-flex">
        <!-- start sidebar -->
        <?php 
            include "component/sidebar.php";
            include '../conixion.php';
            $nbr_hotels = $con->query("SELECT * FROM hotels_list");
            $nbr_hotels = $nbr_hotels->rowCount();
        ?>
        <!-- end sidebar -->

        <!-- start content page -->
        <div class="container-fluid px">
        <?php 
            include "component/header.php";
        ?>
            
             <!-- start hotel list table -->
             <div class="hotel-list-header d-flex justify-content-between align-items-center py-2">
                <div class="title h6 fw-bold">Hotels list</div>
                <div class="btn-add d-flex gap-3 align-items-center">
                    <div class="short">
                        <i class="far fa-sort"></i>
                    </div>
                    <?php include 'component/popupadd.php'; ?>
                </div>
            </div>

            <!-- Start hotel list table -->
            <div class="table-responsive">
                <table class="table hotel_list table-borderless">
                    <thead>
                        <tr class="align-middle">
                            <th class="opacity-0">vide</th>
                            <th>Hotel Name</th>
                            <th>Stars</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Website</th>
                            <th>Category</th>
                            <th>Total Rooms</th>
                            <th>Amenities</th>
                            <th class="opacity-0">list</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                          include '../conixion.php';
                          $result = $con -> query("SELECT * FROM hotels_list");
                          foreach($result as $value):
                        ?>
                      <tr class="bg-white align-middle">
                        <td><img src="../assets/img/<?php echo $value['img'] ?>" alt="img" height="50" with="50"></td>
                        <td><?php echo $value['HotelName'] ?></td>
                        <td><?php echo $value['Stars'] ?></td>
                        <td><?php echo $value['Address'] ?></td>
                        <td><?php echo $value['City'] ?></td>
                        <td><?php echo $value['Country'] ?></td>
                        <td><?php echo $value['PhoneNumber'] ?></td>
                        <td><?php echo $value['Email'] ?></td>
                        <td><?php echo $value['Website'] ?></td>
                        <td><?php echo $value['Category'] ?></td>
                        <td><?php echo $value['TotalRooms'] ?></td>
                        <td><?php echo $value['Amenities'] ?></td>
                        <td class="d-md-flex gap-3 mt-3">
                          <a href="modifier.php?Id=<?php echo $value['Id']?>"><i class="far fa-pen"></i></a>
                          <a href="remove.php?Id=<?php echo $value['Id']?>"><i class="far fa-trash"></i></a>
                        </td>
                    </tr> 
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- end contentpage -->
    </main>
    <script src="../js/script.js"></script>
    <script src="/js/bootstrap.bundle.js"></script>
    <?php include 'chatbot.php'; ?>
</body>
</html>