<style>
    /* General Styles */
    .form-control {
      border: 1px solid #ccc;
      border-radius: 4px;
      padding: 8px 12px;
      font-size: 16px;
      transition: border-color 0.3s ease-in-out;
    }

    .form-control:focus {
      outline: none;
      border-color: #6c63ff;
      box-shadow: 0 0 5px rgba(108, 99, 255, 0.3);
    }

    .btn {
      border-radius: 4px;
      font-size: 16px;
      padding: 8px 16px;
      cursor: pointer;
      transition: background-color 0.3s ease-in-out;
    }

    .btn-primary {
      background: linear-gradient(to left, #0acffe 0%, #4400fe 100%); 
      border:none;
      color: white;
    }

    .btn-primary:hover {
      background-color: #5a4dff;
    }

    .btn-secondary {
      background-color: #ccc;
      color: #333;
      border: none;
    }

    .btn-secondary:hover {
      background-color: #bbb;
    }

    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 9999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
      max-width: 600px;
      width: 90%;
      margin: 10% auto;
    }

    .modal-header {
      background-color: #6c63ff;
      color: #fff;
      padding: 16px;
      border-top-left-radius: 8px;
      border-top-right-radius: 8px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .modal-title {
      margin: 0;
      font-size: 20px;
    }

    .close-btn {
      background-color: transparent;
      border: none;
      color: #fff;
      font-size: 24px;
      cursor: pointer;
      opacity: 0.5;
      transition: opacity 0.3s ease-in-out;
    }

    .close-btn:hover {
      opacity: 1;
    }

    .modal-body {
      padding: 24px;
      max-height: 70vh;
      overflow-y: auto;
    }

    .form-group {
      margin-bottom: 16px;
    }

    .form-label {
      display: block;
      font-weight: bold;
      margin-bottom: 8px;
    }

    .modal-footer {
      padding: 16px;
      border-top: 1px solid #ccc;
      display: flex;
      justify-content: flex-end;
    }
</style>

<div class="button-add-hotel">
  <button type="button" class="btn btn-primary" id="openModal">Add Hotel</button>
  <div class="modal" id="myModal">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Hotel</h5>
        <button type="button" class="close-btn" id="closeModal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="addhotel.php" enctype="multipart/form-data">
          <div class="form-group">
            <label for="image" class="form-label">Hotel Image</label>
            <input type="file" class="form-control" id="image" accept=".jpg,.png,.jpeg" name="img">
          </div>
          <div class="form-group">
            <label for="hotelName" class="form-label">Hotel Name</label>
            <input type="text" class="form-control" id="hotelName" name="HotelName">
          </div>
          <div class="form-group">
            <label for="stars" class="form-label">Stars</label>
            <input type="number" class="form-control" id="stars" name="Stars" min="1" max="5">
          </div>
          <div class="form-group">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="Address">
          </div>
          <div class="form-group">
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control" id="city" name="City">
          </div>
          <div class="form-group">
            <label for="country" class="form-label">Country</label>
            <input type="text" class="form-control" id="country" name="Country">
          </div>
          <div class="form-group">
            <label for="phoneNumber" class="form-label">Phone Number</label>
            <input type="tel" class="form-control" id="phoneNumber" name="PhoneNumber">
          </div>
          <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="Email">
          </div>
          <div class="form-group">
            <label for="website" class="form-label">Website</label>
            <input type="url" class="form-control" id="website" name="Website">
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
                  <option value="luxury">Luxury</option>
                  <option value="business">Business</option>
                  <option value="resort">Resort</option>
                  <option value="budget">Budget</option>
              </select>
              </div>
          </div>
          <div class="form-group">
            <label for="totalRooms" class="form-label">Total Rooms</label>
            <input type="number" class="form-control" id="totalRooms" name="TotalRooms">
          </div>
          <div class="form-group">
            <label for="amenities" class="form-label">Amenities</label>
            <textarea class="form-control" id="amenities" name="Amenities" rows="3"></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="closeModal">Close</button>
            <button type="submit" name="submit" class="btn btn-primary">Add Hotel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  // Get the modal
  var modal = document.getElementById("myModal");

  // Get the button that opens the modal
  var btn = document.getElementById("openModal");

  // Get the close buttons
  var closeBtns = document.getElementsByClassName("close-btn");
  var closeModalBtns = document.getElementsByClassName("btn-secondary");

  // Hide the modal initially
  modal.style.display = "none";

  // Open the modal when the button is clicked
  btn.onclick = function() {
    modal.style.display = "block";
  }

  // Close the modal when the close button is clicked
  for (var i = 0; i < closeBtns.length; i++) {
    closeBtns[i].onclick = function() {
      modal.style.display = "none";
    }
  }

  // Close the modal when the close modal button is clicked
  for (var i = 0; i < closeModalBtns.length; i++) {
    closeModalBtns[i].onclick = function() {
      modal.style.display = "none";
    }
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
</script>