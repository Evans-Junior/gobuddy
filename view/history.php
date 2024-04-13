<?php
session_start();

// ensure user is logged in
if (!(isset($_SESSION["user_id"]))) {
    // redirect to login
    header("Location: ../login/login_view.php");
    exit();
}

include '../functions/get_travel_data.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel History</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar{
           display: flex;
            padding: 10px 0;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .container_logo {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin: 0 90px;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 90px;
            height: calc(100vh - 100px); /* Adjust as needed */
            max-width: 1200px;
        }

        .logo {
            font-size: 1.5rem;
            color: #2e2ed4; /* White text */ 
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nav-links {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            font-weight: 5rem;
            gap:80px;
        }

        .nav-links li {
            display: inline;
        }

        .nav-links li a {
    color: #000; /* White text */
    text-decoration: none;
    padding: 10px 20px;
    border: 1px solid transparent; /* Add a transparent border */
}

.nav-links li a:hover {
    border: 1.4px solid #5959ef; /* Change border color on hover */
    border-radius: 0.7rem;
}

        /* Additional styles for history page */
        .history-container {
            /* max-width: 800px; */
            margin: 0 auto;
            padding: 20px;
        }

        .history-heading {
            text-align: center;
            margin-bottom: 20px;
        }

        .trip {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .trip h4 {
            color: #2e2ed4;
        }

        .trip p {
            color: #444;
            margin-bottom: 10px;
        }

        .trip button {
            background-color: #2e2ed4;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: block;
            margin: 0 auto; /* Center the button */
        }

        .trip button:hover {
            background-color: #5959ef;
        }

        .booked-trips {
    margin-top: 20px;
}

.cards {
    display: flex;
    gap: 20px;
    width: 100%;
    flex-wrap: wrap;
    flex-direction: row;
    border-radius: 5px;
    max-height: calc(100vh - 230px);
    overflow-y: auto;
    justify-content: center;
}


.cards::-webkit-scrollbar {
    width: 5px; /* Set the width of the scrollbar */
}

.cards::-webkit-scrollbar-track {
    background: #f1f1f1; /* Color of the scrollbar track */
}

.cards::-webkit-scrollbar-thumb {
    background: #888; /* Color of the scrollbar thumb */
    border-radius: 5px; /* Round the corners of the scrollbar thumb */
}


.booked-trips h3 {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: #04040b; /* Dark text */
    margin-bottom: 10px;
}

.booked-trips img {
    margin-left: 10px;
}

.card {
    /* width: 100%; */
    align-items: center;
    background-color: #fbfbfe; /* Light background */
    padding: 20px;
    border-radius: 10px;
    border: 1px solid #ccc;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.card h4 {
    color: #2e2ed4; /* Color brand */
}

.card p {
    color: #444; /* Dark text */
    margin-bottom: 5px;
    font-size: 0.9rem;
}

.card button {
    background-color: #2e2ed4; /* Color brand */
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 10px;
    cursor: pointer;
    transition: background-color 0.3s;
    width: 100%;
}

.card button:hover {
    background-color: #5959ef; /* Hover color */
}

.details{
    display: flex;
    flex-direction: row;
    gap: 8px;

}

.details p{
    /* font-weight: bold; */
    font-size: 0.7rem;
    color: #444; /* Dark text */
}

.review-popup {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0,0,0,0.4);
}

.review-popup-content {
  background-color: #fefefe;
  margin: 10% auto;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  width: 50%;
  max-width: 500px;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

h2 {
  margin-top: 0;
}

label {
  display: block;
  margin-bottom: 5px;
}

input[type="text"],
textarea {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

button[type="submit"], .reviewBtn {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

button[type="submit"]:hover, .reviewBtn:hover{
  background-color: #45a049;
}

/* Dropdown menu styles */
.dropdown-menu {
            display: none;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            top: 50px; /* Adjust as needed */
            left: calc(100% - 180px); /* Adjust to align with the profile icon */
            width: 120px; /* Set the width as desired */

        }

        .dropdown-menu.show {
            display: block;
            position: absolute;
        }

        .rating{
            display: flex;
            justify-content: center;
            flex-direction: row-reverse;

            /* margin-bottom: 20px; */
        }

        /* Hide default radio inputs */
.rating input[type="radio"] {
    display: none;
}

/* Star icon style */
.rating label {
    font-size: 30px; /* Adjust size of stars */
    color: #ccc; /* Default color of stars */
    cursor: pointer;
}

/* Star icon when selected */
.rating label:before {
    content: '★'; /* Unicode star character */
}

/* Apply gold color to stars when selected */
.rating input[type="radio"]:checked ~ label {
    color: gold;
}

    </style>
</head>
<body>
<nav class="navbar">
    <div class="container_logo">
        <div class="logo">GoBuddy</div>
        <ul class="nav-links">
            <li><a href="home.php">Home</a></li>
            <li><a href="travels.php">Travels</a></li>
            <li><a href="history.php">History</a></li>
            <li><a href="notification.php">Notifications</a></li>
        </ul>
        <img id="profile-icon" src="../assets/cat.png" alt="User profile" width="40" height="40" onclick="toggleDropdown()">
        <div id="dropdown-menu" class="dropdown-menu">
            <a href="#" class="dropdown-item">Profile</a>
            <a href="#" class="dropdown-item">Settings</a>
            <div class="dropdown-divider"></div>
            <a href="../login/logout_view.php" class="dropdown-item">Logout</a>
        </div>
    </div>
</nav>

<div class="history-container">
    <h2 class="history-heading">Travel History</h2>

    <!-- Example trip cards -->
      <div class="cards">
                <?php

                foreach ($trips as $trip) {
                    echo "<div class='card'>
                            <h5>{$trip['Destination']}</h5>
                            <p>Date: {$trip['Date']}</p>
                            <p>Location: {$trip['Location']}</p>
                            <p>Buddy: {$trip['Username']}</p>
                            <div class='details'>
                            <p>Start: <strong>{$trip['Start']}</strong></p>
                            <p>End: <strong>{$trip['End']}</strong></p>
                            <p>Seats:<strong id='tripseats'>{$trip['SeatsAvailable']}</strong></p>
                            <input type='hidden' id='UserInfo' value='{$trip['UserID']}'>
                            <input type='hidden' class='tripID' id='tripID' value='{$trip['TripID']}'>
                            </div>
                            <div style='display:flex; gap: 7px; '>

                            <button onclick='openReviewPopup({$trip['TripID']}, {$trip['UserID']})'>Review</button>    
                            
                            <button onclick='deleteTrip({$trip['TripID']}, {$trip['UserID']})'>Delete</button>    
                            </div>;
                            </div>";
                }
             ?>
    </div>
</div>


<div id="reviewPopup" class="review-popup">
  <div class="review-popup-content">
    <span class="close" onclick="closeReviewPopup()">&times;</span>
    <h2 style="text-align: center;">Write a Review</h2>
    <form id="reviewForm" >
    <div style="display: flex; justify-content:center; align-items:center; gap: 30px;">
      <label for="reviewerName">Buddy Name:</label>
    <select id="reviewerName" name="reviewerName" required>
    </select>
    </div>
      <label for="reviewText" style="text-align: center;">Review:</label>
      <textarea id="reviewText" name="reviewText" placeholder="Your message goes here" rows="4" required></textarea>
      <div style="display: flex; justify-content:center; align-items:center;
      gap:30px;">
      <label for="rating">Rating:</label>
  <div class="rating">
    <input type="radio" id="star5" name="rating" value="5" required/>
    <label for="star5"></label>
    <input type="radio" id="star4" name="rating" value="4" required/>
    <label for="star4"></label>
    <input type="radio" id="star3" name="rating" value="3" required/>
    <label for="star3"></label>
    <input type="radio" id="star2" name="rating" value="2" required/>
    <label for="star2"></label>
    <input type="radio" id="star1" name="rating" value="1" required/>
    <label for="star1"></label>
  </div>
      <button class='reviewBtn' type="button" onclick="reviewSubmit()">Submit Review</button>
        </div>
    </form>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>

function deleteTrip(tripID, userID) {
    console.log('Trip ID:', tripID);
    console.log('User ID:', userID);

    // AJAX request to delete the trip
    $.ajax({
        url: '../action/delete_completed_trip.php',
        type: 'POST',
        dataType: 'json',
        data: {
            tripID: tripID,
            userID: userID
        },
        success: function(response) {
            console.log('Delete Trip Response:', response);

            if (response && response.success) {
                // xhr.responseText
                // alert('Trip deleted successfully');
                Swal.fire({
                    icon: 'success',
                    title: "Trip deleted successfully",
                    text: '',
                    showConfirmButton: false,
                    timer: 2000 // Auto close after 2 seconds
                });
                // Optionally, update UI or perform additional actions
            } else {
                Swal.fire({
                    icon: 'error',
                    title: "Failed to delete trip",
                    text: '',
                    showConfirmButton: false,
                    timer: 2000 // Auto close after 2 seconds
                });
                // alert('Failed to delete trip');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error deleting trip:', error);
            // alert('An error occurred while deleting the trip');
            Swal.fire({
                    icon: 'error',
                    title: "Please fill out all fields.",
                    text: '',
                    showConfirmButton: false,
                    timer: 2000 // Auto close after 2 seconds
                });
        }
    });
}

function reviewSubmit() {

    var reviewedPID = document.getElementById('reviewerName').value;
    var reviewText = document.getElementById('reviewText').value;
    var rating = document.querySelector('input[name="rating"]:checked').value;
    var tripId = document.getElementById('tripID').value;
     if (!rating) {
        Swal.fire({
                    icon: 'error',
                    title: "Please select a rating",
                    text: '',
                    showConfirmButton: false,
                    timer: 2000 // Auto close after 2 seconds
                });
    // alert('Please select a rating.');
    return;
  }
  
  var ratingValue = rating.value;
  
  // Validate input values (optional)
  if (!reviewerName || !reviewText) {
    Swal.fire({
                    icon: 'error',
                    title: "Please fill out all fields.",
                    text: '',
                    showConfirmButton: false,
                    timer: 2000 // Auto close after 2 seconds
                });
    // alert('Please fill out all fields.');
    return;
  }

    var formData = {
        reviewedPID: reviewedPID,
        reviewText: reviewText,
        rating: rating,
        currentTripID: tripId
    };

    $.ajax({
        url: '../action/submit_review.php',
        type: 'POST',
        dataType: 'json',
        data: formData,
        success: function(response) {
            console.log('Response i AM HERE:', response);

            if (response && response.success) {
                // alert('Review submitted successfully');
                Swal.fire({
                    icon: 'success',
                    title: 'Review submitted successfully',
                    text: '',
                    showConfirmButton: false,
                    timer: 2000 // Auto close after 2 seconds
                });
                // Optionally, update UI or perform additional actions
                // For example, hide the review popup after successful submission
                document.getElementById("reviewPopup").style.display = "none";
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed to submit review',
                    text: '',
                    showConfirmButton: false,
                    timer: 2000 // Auto close after 2 seconds
                });
                // alert('Failed to submit review');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error submitting review:', error);
            Swal.fire({
                    icon: 'error',
                    title: 'An error occurred while submitting the review',
                    text: '',
                    showConfirmButton: false,
                    timer: 2000 // Auto close after 2 seconds
                });
            // alert('An error occurred while submitting the review');
        }
    });
}

// Event listener for form submission
// $('#reviewForm').on('submit', reviewSubmit);
function getUsersForTrip(tripID) {
    var selectDropdown = document.getElementById('reviewerName');

    // Clear existing dropdown options
    selectDropdown.innerHTML = '';

    // Make AJAX request to fetch users associated with the trip
    $.ajax({
        url: '../functions/fetch_travel_buddiescurrent.php',
        type: 'POST',
        dataType: 'json',
        data: { tripID: tripID },
        success: function(response) {
            console.log('Response:', response);

            if (response && response.success) {
                // Extract user IDs and usernames from the response
                var userIds = Object.keys(response.usernames); // Array of user IDs
                var userNames = Object.values(response.usernames); // Array of usernames
                console.log('User IDs:', userIds);
                console.log('Usernames:', userNames);
                var currentUserId = <?php echo $_SESSION['user_id']; ?>;


                if (userIds.length === 0) {
                    // No users found for the trip
                    var option = document.createElement('option');
                    option.value = ''; // Set option value to empty string
                    option.textContent = 'No users found'; // Set option text to a default message

                    // Append the option to the select dropdown
                    selectDropdown.appendChild(option);
                } else {
                    // Iterate through usernames and populate dropdown options
                    userNames.forEach(function(username, index) {
                        var userId = userIds[index];

                        if (userId != currentUserId) {
                            // Create a new <option> element
                            var option = document.createElement('option');
                            option.value = userId; // Set option value to the user ID
                            option.textContent = username; // Set option text to the username

                            // Append the option to the select dropdown
                            selectDropdown.appendChild(option);
                        }
                    });
                }
                // Iterate through usernames and populate dropdown options
                userNames.forEach(function(username, index) {
                    var userId = userIds[index];

                    if (userId != currentUserId) {
                        // Create a new <option> element
                        var option = document.createElement('option');
                        option.value = userId; // Set option value to the user ID
                        option.textContent = username; // Set option text to the username

                        // Append the option to the select dropdown
                        selectDropdown.appendChild(option);
                    }
                });

                // Log current user ID (for debugging)
                var currentUserId = <?php echo $_SESSION['user_id']; ?>;
                console.log('Current user ID:', currentUserId);
            } else {
                console.error('Error fetching users for trip');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            // Handle or log the error
        }
    });
}

function openReviewPopup(tripid, userid) {
    console.log('Trip ID:', tripid);
    getUsersForTrip(tripid);
    document.getElementById("reviewPopup").style.display = "block";
}



function closeReviewPopup() {
  document.getElementById("reviewPopup").style.display = "none";
}
function toggleDropdown() {
        var dropdownMenu = document.getElementById('dropdown-menu');
        dropdownMenu.classList.toggle('show');
    }
</script>
</body>
</html>
