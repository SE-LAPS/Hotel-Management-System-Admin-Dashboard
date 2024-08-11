<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Management System</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <?php
    session_start();
    include '../conixion.php';
    $_SESSION["id"] = $_GET['Id'];
    $id = $_SESSION["id"];
    $statement = $con->prepare("SELECT * FROM hotels_list WHERE Id = $id");
    $statement->execute();
    $table = $statement->fetch();
  ?>
<div class="container w-50">
<form method="POST" action="update.php" enctype="multipart/form-data">
  <br><br>
  <div class="form-group">
    <label for="image" class="form-label">Hotel Image</label>
    <input type="file" class="form-control" id="image" accept=".jpg,.png,.jpeg" name="img">
  </div>
  <div class="form-group">
    <label for="hotelName" class="form-label">Hotel Name</label>
    <input type="text" class="form-control" id="hotelName" name="HotelName" value="<?php echo $table['HotelName']?>">
  </div>
  <div class="form-group">
    <label for="stars" class="form-label">Stars</label>
    <input type="number" class="form-control" id="stars" name="Stars" min="1" max="5" value="<?php echo $table['Stars']?>">
  </div>
  <div class="form-group">
    <label for="address" class="form-label">Address</label>
    <input type="text" class="form-control" id="address" name="Address" value="<?php echo $table['Address']?>">
  </div>
  <div class="form-group">
    <label for="city" class="form-label">City</label>
    <input type="text" class="form-control" id="city" name="City" value="<?php echo $table['City']?>">
  </div>
  <div class="form-group">
    <label for="country" class="form-label">Country</label>
    <input type="text" class="form-control" id="country" name="Country" value="<?php echo $table['Country']?>">
  </div>
  <div class="form-group">
    <label for="phoneNumber" class="form-label">Phone Number</label>
    <input type="tel" class="form-control" id="phoneNumber" name="PhoneNumber" value="<?php echo $table['PhoneNumber']?>">
  </div>
  <div class="form-group">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" name="Email" value="<?php echo $table['Email']?>">
  </div>
  <div class="form-group">
    <label for="website" class="form-label">Website</label>
    <input type="url" class="form-control" id="website" name="Website" value="<?php echo $table['Website']?>">
  </div>
  <div class="form-group">
    <label for="category" class="form-label">
      <i class="fas fa-list-alt"></i> Category
    </label>
    <div class="input-group">
      <div class="input-group-text">
        <i class="fas fa-caret-down"></i>
      </div>
      <select class="form-control" id="category" name="Category">
        <option value="Luxury" <?php if ($table['Category'] == 'Luxury') echo 'selected'; ?>>Luxury</option>
        <option value="Business" <?php if ($table['Category'] == 'Business') echo 'selected'; ?>>Business</option>
        <option value="Resort" <?php if ($table['Category'] == 'Resort') echo 'selected'; ?>>Resort</option>
        <option value="Budget" <?php if ($table['Category'] == 'Budget') echo 'selected'; ?>>Budget</option>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label for="totalRooms" class="form-label">Total Rooms</label>
    <input type="number" class="form-control" id="totalRooms" name="TotalRooms" value="<?php echo $table['TotalRooms']?>">
  </div>
  <div class="form-group">
    <label for="amenities" class="form-label">Amenities</label>
    <textarea class="form-control" id="amenities" name="Amenities" rows="3"><?php echo $table['Amenities']?></textarea>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" id="closeModal">Close</button>
    <button type="submit" name="submit" class="btn btn-primary">Update Hotel</button>
  </div>
</form>
</div>
    <script src="../js/script.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
  $('#closeModal').click(function() {
    window.location.href = 'dashboard.php';
  });
});
</script>
</body>
</html>