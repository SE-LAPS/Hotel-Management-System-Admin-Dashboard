<?php
include '../conixion.php';
session_start();

// Get the user's ID from the database
$username = $_SESSION['name'];
$query = "SELECT id FROM users WHERE username = :username";
$stmt = $con->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$userId = $result['id'];

// Fetch the most recent image for this user
$query = "SELECT image_path FROM user_images WHERE user_id = :user_id ORDER BY id DESC LIMIT 1";
$stmt = $con->prepare($query);
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$imageResult = $stmt->fetch(PDO::FETCH_ASSOC);
$currentImage = $imageResult ? $imageResult['image_path'] : '../assets/img/img-admin.jpg';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOTEL ADMIN DASHBOARD</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="bg-sidebar vh-100 w-20">
        <div class="log d-flex justify-content-between">
            <h1 class="E-classe text-start ms-5 ps-4 mt-4 h6 fw-bold">HOTEL ADMINISTRATION <center>DASHBOARD</center></h1>
            <i class="far fa-times h6 me-3 close align-self-end d-md-none"></i>
        </div>

        <br><br>
        <div class="img-admin d-flex flex-column align-items-center text-center gap-2">
            <div class="position-relative">
                <img id="admin-img" class="rounded-circle" src="<?php echo $currentImage; ?>" alt="img-admin" height="120" width="120">
                <form id="image-form" enctype="multipart/form-data">
                    <input type="file" id="img-upload" name="image" class="d-none" accept="image/*">
                    <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                </form>

                <br><br><br>
                <button id="add-img-btn" class="btn btn-sm btn-primary position-absolute bottom-0 start-0"><i class="fas fa-plus"></i></button>
                <button id="delete-img-btn" class="btn btn-sm btn-danger position-absolute bottom-0 end-0"><i class="fas fa-trash"></i></button>
            </div>
            <h2 class="h6 fw-bold"><?php echo $_SESSION['name']; ?></h2>
            <b><p class="small mb-0">USER ID: <?php echo $userId; ?></p></b>
            <span class="h8 admin-color">Admin</span>
        </div>
    <br><br>
        <div class="bg-list d-flex flex-column align-items-center fw-bold gap-2 mt-4">
            <ul class="d-flex flex-column list-unstyled">
                <li class="h7"><a class="nav-link text-dark" href="hotels_list.php"><i class="fal fa-home-lg-alt me-2"></i> <span>Home</span></a></li>
                <br>

                <li class="h7"><a class="nav-link text-dark" href="#"><i class="fal fa-file-chart-line me-2"></i> <span>Reports</span></a></li>
                <br> 

                <li class="h7"><a class="nav-link text-dark" href="#"><i class="far fa-credit-card me-2"></i> <span>Payment Gateway</span></a></li>
                <br>

                <li class="h7"><a class="nav-link text-dark" href="#"><i class="fal fa-store me-2"></i> <span>Market Place</span></a></li>
            </ul>

            <br>
            <ul class="logout d-flex justify-content-start list-unstyled">
                <li class="h7"><a class="nav-link text-dark" href="../index.php"><span>Logout</span> <i class="fal fa-sign-out-alt ms-2"></i></a></li>
            </ul>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const imgUpload = document.getElementById('img-upload');
        const addImgBtn = document.getElementById('add-img-btn');
        const deleteImgBtn = document.getElementById('delete-img-btn');
        const adminImg = document.getElementById('admin-img');
        const imageForm = document.getElementById('image-form');
        const defaultImg = '../assets/img/img-admin.jpg';

        addImgBtn.addEventListener('click', function() {
            imgUpload.click();
        });

        imgUpload.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const formData = new FormData(imageForm);
                fetch('../pages/component/upload_image.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        adminImg.src = data.image_path;
                    } else {
                        alert('Error uploading image: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        });

        deleteImgBtn.addEventListener('click', function() {
            fetch('../pages/component/delete_image.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'user_id=' + <?php echo $userId; ?>
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    adminImg.src = defaultImg;
                    imgUpload.value = '';
                } else {
                    alert('Error deleting image: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
    </script>
</body>
</html>