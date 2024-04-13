<?php
// Start session
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            /* display: flex;
            flex-direction: column; */
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

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

        .logo {
            font-size: 1.5rem;
            color: #2e2ed4; /* White text */ 
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            /* gap: 90px; */
            height: calc(100vh - 100px); /* Adjust as needed */
            max-width: 1200px;
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

.notification-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            /* max-width: 400px; */
            width: 90%;
            /* margin-top: 50px; */
            overflow-y: auto;
            max-height: 600px;
        }

        .notification-container::-webkit-scrollbar {
    width: 5px; /* Set the width of the scrollbar */
}

.notification-container::-webkit-scrollbar-track {
    background: #f1f1f1; /* Color of the scrollbar track */
}

.notification-container::-webkit-scrollbar-thumb {
    background: #888; /* Color of the scrollbar thumb */
    border-radius: 5px; /* Round the corners of the scrollbar thumb */
}

        h1 {
            color: #333333;
            margin-bottom: 20px;
        }

        .topic {
            cursor: pointer;
            color: #007bff;
            margin-bottom: 10px;
        }

        .topic:hover {
            text-decoration: underline;
        }

        .details {
            display: flex;
            flex-direction: column;
            margin-top: 20px;
            margin-bottom: 20px;
            padding: 20px; /* Add padding for space inside the card */
            width: 100%;
            background-color: #b3d3f4; /* Set background color to white */
            box-shadow: 0px 0px 10px rgba(101, 172, 219, 0.1); /* Add box shadow for visual separation */
            border-radius: 8px; /* Add border radius for rounded corners */
            justify-content: center;
            align-items: center;

        }

        .sender-info {
            color: black;
            font-weight: bold;
            margin-bottom: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            
        }

        .time-info {
            color: black;
            font-size: 14px;
            font-weight: normal;
            /* float: right; */
        }

        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            margin-bottom: 20px;
            width: 100%;
            gap: 10px;
        }

        .button-left {
            display: flex;
            width: 70%;
            text-align: center;
            justify-content: center;
            align-items: center;
        }

        .button-left p {
            font-size: 14px;
            margin: 0;
            /* font-weight: bold; */
        }

        .button-right{
            width: 30%;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            height: 100%;
        }

        .notification-button {
            background-color: #0056b3;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 13px;
        }

        .notification-button:hover {
            background-color: #004080;
        }

        .close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: transparent;
    border: none;
    cursor: pointer;
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

/* Additional styling for the close button */
.close-btn:hover {
    color: red;
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
    width: 100%;
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
}

.message-request-button:hover {
    background-color: #5959ef;
}

.details2{
    display: flex;
    flex-direction: row;
    gap: 8px;

}

.details2 p{
    /* font-weight: bold; */
    font-size: 0.7rem;
    color: #444; /* Dark text */
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
            <li><a href="#">Notifications</a></li>
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
<div class='container'>
<h1>Notifications</h1>
<div class="notification-container">
   
    
    <!-- <div class="topic" onclick="toggleDetails('sent-request')">Sent Request</div> -->
    <div id="sent-request-details">

    </div>

</div>
</div>

<div id="popup-overlay">
    <div class="wide-card">
    <button class="close-btn" onclick="closeWideCard()">&times;</button>

    <div class="left-section">
        <!-- Left section content (person's review) -->
        <h4>Review</h4>
        <p>This person is awesome!</p>
    </div>
    <div class="right-section">
        <!-- Right section content (person's details) -->
        <div class="details2">
            
            <div class="info">
                <!-- Name -->
                <h4></h4>
                <!-- Bio -->
                <p></p>
                <!-- Stars (assuming star rating system) -->
                <div class="stars">
                    <!-- Display star icons based on rating -->
                    <!-- <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9734;</span> -->
                </div>
                <!-- Message request button -->
                <!-- <div> -->
                <!-- <button onclick='makeARequest()' class="message-request-button">Message</button> -->
                <!-- <button class="message-request-button">Close</button> -->

                </div>
            </div>
            
        </div>
        <div class="avatar-icon" style="display: flex; align-items:center">
                <!-- Avatar icon -->
                <img src="../assets/icons/gamer.png" alt="Avatar" style="width: 100px; height:auto ">
            </div>
    </div>
    </div>
</div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>

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



function rejectTrip(requestID) {
    // AJAX request to update TripRequest status to 'Rejected'
    $.ajax({
        url: '../functions/update_trip_request_status.php', // Replace with your PHP script URL
        type: 'POST', // Use POST method to send data
        data: { requestID: requestID, status: 'Rejected' }, // Pass requestID and new status
        dataType: 'json', // Expect JSON response from the server
        success: function(response) {
            // Handle success response
            // console.log('Trip request rejected successfully');
            alert('Trip request rejected successfully');
            Swal.fire({
                    icon: 'success',
                    title: 'Trip request rejected successfully',
                    text: '',
                    showConfirmButton: false,
            });
            fetchTripRequests()
            // Optionally, update UI or show a message indicating success
        },
        error: function(xhr, status, error) {
            // Handle error response
            console.error('Error rejecting trip request:', error);
            // alert('Error rejecting trip request');
            Swal.fire({
                    icon: 'error',
                    title: 'Error rejecting trip request',
                    text: '',
                    showConfirmButton: false,
            });
            // Optionally, display an error message or handle the error
        }
    });
}

function cancelRequest(requestID) {
    // userName= $('.info h4').val
    confirm('Are you sure you want to cancel this request ');
    console.log('I am here: ',requestID);
    // AJAX request to delete TripRequest
    $.ajax({
        url: '../functions/cancel_trip_request.php', // Replace with your PHP script URL
        type: 'POST', // Use POST method to send data
        data: { requestID: requestID }, // Pass the requestID to be canceled
        dataType: 'json', // Expect JSON response from the server
        success: function(response) {
            if (response.success) {
                alert('Trip request canceled successfully');
                fetchTripRequests()
            } else {
                console.error('Failed to cancel trip request');

                // Optionally, display an error message
            }
        },
        error: function(xhr, status, error) {
            console.error('Error canceling trip request:', error);
            // Optionally, display an error message or handle the error
        }
    });
}

function CancelTrip(requestID) {
    confirm('Are you sure you want to cancel this trip?');
    // AJAX request to update TripRequest status to 'Rejected'
    $.ajax({
        url: '../functions/update_trip_request_status.php', // Replace with your PHP script URL
        type: 'POST', // Use POST method to send data
        data: { requestID: requestID, status: 'Rejected' }, // Pass requestID and new status
        dataType: 'json', // Expect JSON response from the server
        success: function(response) {
            // Handle success response
            // console.log('Trip request rejected successfully');
            // alert('Trip request rejected successfully');
            Swal.fire({
                    icon: 'success',
                    title: 'Trip request rejected successfully',
                    text: '',
                    showConfirmButton: false,
            });
            fetchTripRequests()
            // Optionally, update UI or show a message indicating success
        },
        error: function(xhr, status, error) {
            // Handle error response
            Swal.fire({
                    icon: 'error',
                    title: 'Error rejecting trip request',
                    text: '',
                    showConfirmButton: false,
            });
            console.error('Error rejecting trip request:', error);
            // alert('Error rejecting trip request');

            // Optionally, display an error message or handle the error
        }
    });
}





function acceptTrip(requestID) {
    // userName= $('.info h4').val
    // confirm(`Accepting Trip`);

    $.ajax({
        url: '../functions/update_trip_request_status.php', // Replace with your PHP script URL
        type: 'POST', // Use POST method to send data
        data: { requestID: requestID, status: 'Accepted' }, // Pass requestID and new status
        dataType: 'json', // Expect JSON response from the server
        success: function(response) {
            // Handle success response
            // console.log('Trip request rejected successfully');
            Swal.fire({
                    icon: 'success',
                    title: 'Status changed successfully',
                    text: '',
                    showConfirmButton: false,
            });
            // alert('Status changed successfully');
            fetchTripRequests()
            // Optionally, update UI or show a message indicating success
        },
        error: function(xhr, status, error) {
            // Handle error response
            console.error('Error rejecting trip request:', error);
            Swal.fire({
                    icon: 'error',
                    title: 'Error rejecting trip request',
                    text: '',
                    showConfirmButton: false,
            });
            // alert('Error rejecting trip request');
            
            // Optionally, display an error message or handle the error
        }
    });
}

function fetchTripRequests() {
    var detailsContainer = document.getElementById('sent-request-details');
    detailsContainer.innerHTML = ''; // Clear existing notifications

    // Make an AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../functions/fetch_trip_requests_notification.php', true);

    xhr.onload = function() {
        if (xhr.status == 200) {
            var tripRequests = JSON.parse(xhr.responseText);
            console.log(tripRequests);
            // Check if tripRequests array is empty
            if (tripRequests.length === 0) {
                // Create a message element to display no notifications
                var messageElement = document.createElement('p');
                messageElement.textContent = 'You do not have any notifications.';
                messageElement.style.fontWeight = 'bold';
                messageElement.style.color = '#888';

                // Append the message to the detailsContainer
                detailsContainer.appendChild(messageElement);
            } else {
                // Loop through each trip request and display notifications
                tripRequests.forEach(function(request) {
                    // Skip requests with Status 'Accepted' and not matching specific user criteria
                    if (
                        (request.RequesterUserID != <?php echo $_SESSION['user_id']; ?> &&
                        request.TripOwnerID != <?php echo $_SESSION['user_id']; ?>)) {
                        return; // Skip this request
                    }

                    // Construct sender information based on request data
                    var currentUID = <?php echo $_SESSION['user_id']; ?> == request.TripOwnerID;
                    var viewerId = request.RequesterUserID == <?php echo $_SESSION['user_id']; ?> ? request.TripOwnerID : request.RequesterUserID;
                    var userName=request.RequesterUserID == <?php echo $_SESSION['user_id']; ?> ? request.TripOwnerName : request.RequesterName;
                    console.log('TripOwnerName:', request.TripOwnerName);
                    console.log('RequesterName:', request.RequesterName);
                    console.log('userName:', userName);
                 
                    var isRequester = request.RequesterUserID == <?php echo $_SESSION['user_id']; ?>;
    // Determine if the current user is the trip owner
    var isTripOwner = request.TripOwnerID == <?php echo $_SESSION['user_id']; ?>;
    // Determine if the request status is 'Accepted'
    var isAccepted = request.Status === 'Accepted';
    // Determine if the request status is 'Rejected'
    var isRejected = request.Status === 'Rejected';

    // Construct sender information based on request data
    var userName = isRequester ? request.TripOwnerName : request.RequesterName;

    // Generate button HTML based on user role and request status
    var buttonHTML = `
        <button class="notification-button" onclick="showReview('${isRequester ? request.TripOwnerID : request.RequesterUserID}', 'Excellent experience with the buddy!')">Buddy Review</button>
    `;

    if (isRequester) {
        // Display cancel request button for the requester
        buttonHTML += `
            <button class="notification-button" onclick="cancelRequest('${request.RequestID}')">Cancel Request</button>
        `;
    } else if (!isAccepted && !isRejected) {
        // Display accept and reject buttons for the trip owner if request is neither accepted nor rejected
        buttonHTML += `
            <button class="notification-button" onclick="acceptTrip('${request.RequestID}')">Accept Trip</button>
            <button class="notification-button" onclick="rejectTrip('${request.RequestID}')">Reject Trip</button>
        `;
    }

    // Display cancel trip button for the trip owner if request is accepted
    if (isTripOwner && isAccepted) {
        buttonHTML += `
            <button class="notification-button" onclick="CancelTrip('${request.RequestID}')">Cancel Trip</button>
        `;
    }


                    var senderInfo = `
                        <div class="sender-info">
                            <span style="font-size: 13px;">${request.RequesterUserID == <?php echo $_SESSION['user_id']; ?> ? 'Request sent' : 'Request received from'}</span>
                            <span>${request.RequesterUserID == <?php echo $_SESSION['user_id']; ?> ? request.TripOwnerName : request.RequesterName}</span>
                            <span class="time-info"><span>At:</span> ${request.TimeCreated}</span>
                        </div>
                        <div class="button-container">
                            <div class="button-left">
                                <p>Trip Details: <strong>From:</strong> ${request.Destination}, <strong>To:</strong> ${request.Location}, <strong>Time:</strong> ${request.Date} ${request.Start}, <strong>Status:</strong> ${request.Status}</p>
                            </div>
                            <div class="button-right">
                            ${buttonHTML}
                        </div>
                        </div>
                    `;

                    // Create a new notification container for each trip request
                    var notificationDiv = document.createElement('div');
                    notificationDiv.className = 'details';
                    notificationDiv.innerHTML = senderInfo;

                    // Append the notification container to the detailsContainer
                    detailsContainer.appendChild(notificationDiv);
                });
            }
        } else {
            console.error('Error fetching trip requests: ' + xhr.status);
        }
    };

    xhr.send();
}

onload = fetchTripRequests;

function toggleDropdown() {
        var dropdownMenu = document.getElementById('dropdown-menu');
        dropdownMenu.classList.toggle('show');
    }

    function toggleDetails(topic) {
        const detailsElement = document.getElementById(`${topic}-details`);
        if (detailsElement.style.display === 'block') {
            detailsElement.style.display = 'none';
        } else {
            detailsElement.style.display = 'block';
        }
    }

    function getUserInfo(user) {
    // var userID = document.getElementById('UserInfo').value;
    console.log(user);
    getUserReviews(user);
    // AJAX request to fetch user information
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

    function showReview(id, review) {
        document.getElementById('popup-overlay').style.display = 'block';
        getUserInfo(id);
        
        // alert(`Buddy Review from ${id}:\n${review}`);
    }


</script>

</body>
</html>
