<?php
session_start();
include '../functions/get_travel_data_t.php';
// ensure user is logged in
if (!(isset($_SESSION["user_id"]))) {
    // redirect to login
    header("Location: ../login/login_view.php");
    exit();
}
// echo $_SESSION["user_id"];

// $trips = getTripsWithUserData();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traveling Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>

.navbar {
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

.search-button {
padding: 15px 20px;
border: 1px solid #ccc;
border-radius: 10px;
font-size: 1rem;
max-width: 100px;
color: #04040b; /* Dark text */
/* background-color: #fbfbfe; Light background */
/* width: 600px; */

/* max-width: 300px; Adjust as needed */
box-sizing: border-box; /* Ensure padding and border are included in width */
outline: none; /* Remove the outline when clicked */

}

.search-input{
    max-width: 500px;
    padding: 15px 20px;
border: 1px solid #ccc;
border-radius: 10px;
color: #04040b; /* Dark text */
box-sizing: border-box; /* Ensure padding and border are included in width */
outline: none; /* Remove the outline when clicked */

}

.search-input::placeholder {
color: #999; /* Placeholder text color */
}


.location-header,
.destination-header {
    font-size: 1.2rem;
    color: #2e2ed4;
    margin-top: 20px;
}

.location-select,
.destination-select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 20px;
}



.container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 90px;
            height: calc(100vh - 70px); /* Adjust as needed */
            max-width: 1300px;
        }

    /* .right-container{
        display: flex;
        flex-direction: column;
        gap: 20px;
        justify-content: center;
    } */

    .tab-content{
        display: flex;
        flex-direction: row;
        gap: 20px;
        justify-content: center;
        align-items: center;
    }

    h5{
    color: #2e2ed4; /* Color brand */
}

.wide-card {
    display: flex;
    /* width: 600px; */
    border: 1px solid #ccc;
    border-radius: 1px;
    margin-bottom: 20px;
    justify-content: center;
    position: fixed;
    align-items: center;
    background-color: #fff;
    transform: translate(-50%, -50%);
    padding: 20px;
    border-radius: 8px;
    top: 50%;
    left: 50%; 
    gap:20px;
}

.left-section {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    width: 60%;
    padding-top: 100px;
    background-color: #f0f0f0;
    max-height: 200px; /* Adjust max-height as needed */
    overflow-y: scroll; /* Use 'scroll' to always show the scrollbar */
    overflow-x: hidden; /* Hide horizontal scrollbar */
    direction: rtl; /* Set direction to right-to-left */
}

/* Track */
.left-section::-webkit-scrollbar {
    width: 6px; /* Adjust as needed for the thickness */
    background-color: transparent;
}

/* Thumb */
.left-section::-webkit-scrollbar-thumb {
    background-color: #2e2ed4;
    border-radius: 3px; /* Adjust as needed for the roundness */
}

/* Hover/Focus styles for the thumb */
.left-section::-webkit-scrollbar-thumb:hover,
.left-section::-webkit-scrollbar-thumb:focus {
    background-color: #3d3ddc;
}

/* Transition */
.left-section::-webkit-scrollbar-thumb {
    transition: background-color 0.3s ease;
}


.right-section {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 40%;
    padding: 20px;
}

.details {
    display: flex;
}

.avatar-icon img {
    width: 80px; /* Adjust size as needed */
    height: 80px; /* Adjust size as needed */
    border-radius: 50%;
    margin-right: 20px;
}

.info {
    flex-grow: 1;
}

.stars {
    margin-top: 10px;
}

.star {
    color: gold; /* Assuming star color is gold */
}

.message-request-button {
    background-color: #2e2ed4;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
    transition: background-color 0.3s;
    font-size: 0.5rem;
}

.message-request-button:hover {
    background-color: #5959ef;
}

#popup-overlay {
    position: fixed;
    top: 0px;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
    display: none; /* Initially hidden */
    justify-content: center;
    align-items: center;
}

.close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: transparent;
    border: none;
    cursor: pointer;
}

/* Additional styling for the close button */
.close-btn:hover {
    color: red;
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

        #review-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 20px;
        }

        /* Style for individual review card */
        .review-card {
            width: 300px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;

            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Style for review info within the card */
        .review-info {
            margin-bottom: 10px;
        }

        .reviewer-name {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .review-text {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .review-date {
            font-size: 12px;
            color: #888;
            margin-top: 5px;
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

<div class="container">
    <div class="left-container">
    <h3 style="text-align: center;">Find a Buddy</h3>

        <div class="tab-content">
            <!-- <div style="text-align: center; margin-top:50px;"> -->

                <!-- <input type="text" placeholder="Search for trips" class="search-input" style="width: 500px;"> -->
            <!-- </div> -->
            <!-- <div class="right-container"> -->
                <input type="text" id='myloc' placeholder="Search a trip to your destination or from your location" class="search-input" style="width: 100%;">
                <!-- <input type="text" id='finaloc' placeholder="Trips to your location" class="search-input" style="width: 500px;"> -->
            <!-- </div> -->
            <!-- <input type="button" value="Active Trips" class="search-button" style="width: 500px; max-height: 60px; color:#2e2ed4"> -->
            <input type="button" onclick="submitSearch()" value="Submit" class="search-button" style="width: 500px; max-height: 60px; color:#2e2ed4">

        </div>
        <div class="booked-trips">
            <h3>Booked Trips</h3>
            <div class="cards">
    <?php
    // Check if there are trips available
    if (!empty($trips)) {
        // Iterate over each trip
        foreach ($trips as $trip) {
            echo "<div class='card' onclick='getUserInfo({$trip['UserID']})'>
                    <h5>{$trip['Destination']}</h5>
                    <p>Date: {$trip['Date']}</p>
                    <p id='the_person_destination'>Location: {$trip['Location']}</p>
                    <p>Buddy: {$trip['Username']}</p>
                    <div class='details'>
                        <p>Start: <strong>{$trip['Start']}</strong></p>
                        <p>End: <strong>{$trip['End']}</strong></p>
                        <p>Seats: <strong id='tripseats'>{$trip['SeatsAvailable']}</strong></p>
                        <input type='hidden' id='UserInfo' value='{$trip['UserID']}'>
                        <input type='hidden' class='tripID' value='{$trip['TripID']}'>
                    </div>";

            // Check if the current trip's userID is not the same as the logged-in user's userID
            if ($trip['UserID'] != $_SESSION['user_id']) {
                echo "<button onclick='openWideCard({$trip['TripID']}, {$trip['UserID']})'>Reach out</button>";
            }

            echo "</div>"; // Close the card div
        }
    } else {
        // No trips found
        echo "<p>No trips found.</p>";
    }
    ?>
</div>

        </div>
    </div>
    
    </div>
    <div id="popup-overlay">
    <div class="wide-card">
    <button class="close-btn" onclick="closeWideCard()">&times;</button>

    <div class="left-section">
        <!-- Left section content (person's review) -->
        <h4>Review</h4>


    </div>
    <div class="right-section">
        <!-- Right section content (person's details) -->
        <div class="details">
            
            <div class="info">
                <!-- Name -->
                <h4></h4>
                <!-- Bio -->
                <p></p>
                <!-- Stars (assuming star rating system) -->
                <div class="stars">
                </div>
                <!-- Message request button -->
                <div>
                <button onclick='makeARequest()' class="message-request-button">Send Request</button>
                <!-- <button class="message-request-button">Close</button> -->

                </div>
            </div>
            <div class="avatar-icon" style="display: flex; align-items:center">
                <!-- Avatar icon -->
                <img src="../assets/icons/gamer.png" alt="Avatar" style="width: 100px; height:auto ">
            </div>
        </div>
    </div>
    </div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>



function submitSearch() {
        // Retrieve the user input from the myloc input field
        var userInput = document.getElementById('myloc').value.trim().toLowerCase();
        // Find all trip cards
        var tripCards = document.querySelectorAll('.card');

        // Iterate through each trip card
        tripCards.forEach(function(card) {
            // Retrieve the trip's destination from the card
            var tripDestination = card.querySelector('h5').textContent.toLowerCase();
            var myloc = card.querySelector('#the_person_destination').textContent.toLowerCase();

            // Check if the trip's destination matches the user input
            if (tripDestination.includes(userInput) || myloc.includes(userInput)) {
                // Show the trip card if it matches
                card.style.display = 'block';
            } else {
                // Hide the trip card if it doesn't match
                card.style.display = 'none';
                //when result find no trip show not trip was found
                // var noTrip = document.createElement('p');
                //  noTrip.textContent = 'No trip was found';
                //  card.appendChild(noTrip);
                           
            }
            // when results is zero show no trip was found
            if (tripDestination.includes(userInput) == 0) {
                var noTrip = document.createElement('p');
                noTrip.textContent = 'No trip was found';
                card.appendChild(noTrip);
            }

        });
    }

function getUserReviews(user) {
    $.ajax({
        url: '../functions/get_trip_review.php',
        type: 'GET',
        data: { userID: user },
        dataType: 'json',
        success: function(data) {
            console.log('Response:', data);

            // Find the review container within the wide-card section
            var reviewContainer = document.querySelector('.wide-card .left-section');

            if (reviewContainer) {
                // Clear any existing content within the review container
                reviewContainer.innerHTML = '';

                if (data.reviews.length === 0) {
                    // Display a message if no reviews are found
                    var noReviewsMessage = document.createElement('p');
                    noReviewsMessage.textContent = 'No reviews found for this user.';
                    reviewContainer.appendChild(noReviewsMessage);
                    return;
                }

                // Populate review cards if reviews are found in the data
                data.reviews.forEach(function(review) {
                    console.log('Review:', review);

                    // Create a new review card element
                    var reviewCard = document.createElement('div');
                    reviewCard.classList.add('review-card');

                    // Create elements for review information
                    var reviewerNameContainer = document.createElement('p');
                    reviewerNameContainer.classList.add('reviewer-name-container');

                    // Create a span for "From" prefix and smaller font size
                    var fromText = document.createElement('span');
                    fromText.textContent = 'From ';
                    fromText.style.fontWeight = 'normal';
                    fromText.style.fontSize = 'smaller';

                    var reviewerName = document.createElement('span');
                    reviewerName.textContent = review.ReviewerName;
                    reviewerName.style.fontWeight = 'bold'; // Optionally, adjust font weight for reviewer's name

                    // Append "From" prefix and reviewer's name to the container
                    reviewerNameContainer.appendChild(fromText);
                    reviewerNameContainer.appendChild(reviewerName);

                    var reviewText = document.createElement('p');
                    reviewText.classList.add('review-text');
                    reviewText.textContent = review.ReviewText;

                    var reviewDate = document.createElement('p');
                    reviewDate.classList.add('review-date');
                    reviewDate.textContent = review.ReviewDate;

                    // Append review information to the review card
                    reviewCard.appendChild(reviewerNameContainer);
                    reviewCard.appendChild(reviewText);
                    reviewCard.appendChild(reviewDate);

                    // Append the review card to the review container
                    reviewContainer.appendChild(reviewCard);
                });
            } else {
                console.error('Review container not found within wide-card.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching reviews:', error);
            // Handle error case
        }
    });
}



let tripId=''
function getUserInfo(user) {
    // var userID = document.getElementById('UserInfo').value;
    // console.log(user);
    // AJAX request to fetch user information
    getUserReviews(user);

    $.ajax({
        url: '../functions/get_buddy_info.php',
        type: 'GET',
        data: { userID: user },
        dataType: 'json',
        success: function(data) {
            console.log(data);
            // Update HTML content with fetched user information
            $('.info h4').text('Name: ' + data.Username);
            $('.info p').text('Bio: ' + data.Bio);
            $('.stars').empty(); // Clear existing stars
            // Display star icons based on the number of stars
            for (let i = 0; i < data.Stars; i++) {
                $('.stars').append('<span class="star">&#9733;</span>');
            }
            // Append empty star icons for remaining stars
            for (let i = data.Stars; i < 5; i++) {
                $('.stars').append('<span class="star">&#9734;</span>');
            }
            // console.log(data)
            // alert('User information fetched successfully!')
        },
        error: function(xhr, status, error) {
            console.error(error);
            // Handle error case
        }
    });
}


    function closeWideCard() {
    document.getElementById('popup-overlay').style.display = 'none';
}
function openWideCard(tripID,user) {
    console.log('Clicked on TripID:', tripId);
    console.log('Associated UserID:', user);
    tripId=tripID;
    console.log('Clicked on TripID:', tripId);
    getUserInfo(user);
    document.getElementById('popup-overlay').style.display = 'block';
}

function toggleDropdown() {
        var dropdownMenu = document.getElementById('dropdown-menu');
        dropdownMenu.classList.toggle('show');
    }
    function makeARequest() {
    console.log('Clicked on TripID:', tripId);

    // AJAX request to send trip request
    $.ajax({
        url: '../action/send_trip_request.php', // PHP script to handle the request
        type: 'POST',
        data: { tripID: tripId },
        success: function(response) {
            // Handle success response
            console.log(response);
            // Display SweetAlert notification
            Swal.fire({
                icon: 'success',
                title: 'Trip Request Sent!',
                text: response,
                showConfirmButton: false,
                timer: 2000, // Auto close after 2 seconds
                allowOutsideClick: false // Prevent dismissing by clicking outside
            }).then(() => {
                // Redirect to notification page
                window.location.href = 'notification.php';
            });
        },
        error: function(xhr, status, error) {
            // Handle error
            console.error(error);
            // Display SweetAlert error notification
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to send trip request. Please try again later.',
                confirmButtonText: 'OK'
            });
        }
    });
}
</script>

</body>
</html>
