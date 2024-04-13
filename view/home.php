

<?php
session_start();
// echo $_SESSION['email'];
// echo $_SESSION['username'];
// echo $_SESSION['user_id'];
// echo $_SESSION['email'];
include '../functions/clear_data.php';
if (!(isset($_SESSION["user_id"]))) {
    // redirect to login
    header("Location: ../login/login_view.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traveling Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff; /* White background */
        }

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

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
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

        .tab-content {
            padding: 20px;
        }

        .chat_name, .history{
            font-size: medium;

            color: #000;
            text-align: center;
            /* color: #2e2ed4; */
            text-align: center;
            /* color: #fbfbfe; */
            cursor: pointer;
            padding: 10px 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .chat_name:hover ,.history:hover {
            /* background-color: #5959ef; */
            /* color: #fbfbfe; */
            border: 1.4 solid #2e2ed4;

        }

        

        .history{
            margin-top: 8px
        }
        

        .tab-content h2 {
            color: #2e2ed4; /* Color brand */
        }

        .tab-content p {
            color: #444; /* Dark text */
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .navbar {
                padding: 10px;
            }

            .nav-links li a {
                padding: 10px;
            }
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

        
        /* New styles */
        .left-container {
            width: 70%;
        } 

        .right-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            width: 30%;
            padding-top: 80px;
        }

        .user-list {
            display: none;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
         
        }

        .user {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .user-icon {
            margin-right: 10px;
        }

        .check-last-trip {
            margin-top: 20px;
        }

        .search-input {

    padding: 15px 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    font-size: 1rem;
    color: #04040b; /* Dark text */
    /* background-color: #fbfbfe; Light background */
    width: 600px;
    
    max-width: 300px; /* Adjust as needed */
    box-sizing: border-box; /* Ensure padding and border are included in width */
    outline: none; /* Remove the outline when clicked */

}

.search-input::placeholder {
    color: #999; /* Placeholder text color */
}

.search-input-buddy {

    padding: 10px 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    font-size: 1rem;
    color: #04040b; /* Dark text */
    /* background-color: #fbfbfe; Light background */
    width: 600px;
    margin-bottom: 10px;
    max-width: 300px; /* Adjust as needed */
    box-sizing: border-box; /* Ensure padding and border are included in width */
    outline: none; /* Remove the outline when clicked */

}
.search-input-buddy::placeholder {
    color: #999; /* Placeholder text color */
}
.booked-trips {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    overflow-y: auto; /* Enable vertical scrolling */
    /* max-height: 200px; Set maximum height to enable scrolling */

    /* Track */
    scrollbar-width: thin; /* "auto" or "thin" based on browser support */
    scrollbar-color: #2e2ed4 transparent; /* color of thumb and track */
}




/* Thumb */
.booked-trips::-webkit-scrollbar-thumb {
    /* width: 5px;  */
    background-color: #2e2ed4;
    border-radius: 3px; /* Adjust as needed for the roundness */
}

/* Hover/Focus styles for the thumb */
.booked-trips::-webkit-scrollbar-thumb:hover {
    background-color: #3d3ddc;
}

/* Transition for thumb */
.booked-trips::-webkit-scrollbar-thumb {
    transition: background-color 0.3s ease;
}


.card-container {
    position: relative;
    padding: 0 10px; /* Add some padding for better appearance */
    white-space: nowrap; /* Prevent cards from wrapping */
    width: 700px; /* Set the desired width */
    overflow-x: auto; /* Hide overflow */
    
}


.scroll-button {
    /* position: relative; */
    top: 50%;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 5px;
    font-size: 20px;
    color: #333; /* Button color */
    transition: color 0.3s; /* Transition effect for color change */
    z-index: 9999;
    text-align: center;
    /* width: 800px; */
}

.scroll-button:hover {
    color: #5959ef; /* Hover color */
}

.arrows{
    display: none;
    justify-content: space-between;
    margin-top: 50px;
    width: 500px;
    z-index: -1;

}

.scroll-button,.left {
    cursor: pointer;
    left:20px;
}

.scroll-button,.right {
    right: 20px;
    cursor: pointer;
}


.cards{
    display: flex;
    /* flex-direction: column; */
    gap: 20px;
    /* width: 600px; */
    justify-content: center;
    align-items: center;

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
    flex: 0 0 auto;
    width: 200px; /* Set the width to 100% */
    background-color: #fbfbfe; /* Light background */
    padding: 20px;
    border-radius: 10px;
    border: 1px solid #ccc;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
    justify-content: center;
    align-items: center;
}



.card h4 {
    color: #2e2ed4; /* Color brand */
    padding: 15px;
    background-color: white;
    border-radius: 10px;
}

.card p {
    color: #444; /* Dark text */
    margin-bottom: 7px;
    font-size: small;
}

.card button {
    background-color: #2e2ed4; /* Color brand */
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 10px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.card button:hover {
    background-color: #5959ef; /* Hover color */
}

.messages{
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    max-height: calc(100vh - 350px);
    overflow-y: auto;

}
.messages::-webkit-scrollbar {
    width: 5px; /* Set the width of the scrollbar */
}

.messages::-webkit-scrollbar-track {
    background: #f1f1f1; /* Color of the scrollbar track */
}

.messages::-webkit-scrollbar-thumb {
    background: #888; /* Color of the scrollbar thumb */
    border-radius: 5px; /* Round the corners of the scrollbar thumb */
}

.user_info{
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
    border-bottom: lightgray 1px solid;
    padding: 5px;
    /* max-height: calc(100vh - 600px); */
    margin-bottom: 4px;
}

.unread_messages{
    background-color: #5959ef;
    color: white;
    border-radius: 50%;
    padding: 1px 7px;
    font-size: 0.8rem;
}
 
/* Modal */
.modal {
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

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  /* margin: 10% auto; */
  padding: 20px;
  border: 1px solid #888;
  width: 40%;
  position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999;
}

/* Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

/* Form Group */
.form-group {
  margin-bottom: 20px;
}

.form-group label {
  font-weight: bold;
}

.form-group input {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  width: calc(100% - 18px);
}

.form-group input:focus {
  outline: none;
  border-color: #5959ef;
}

/* Details */
.details {
  display: flex;
  justify-content: space-between;
}

/* Submit Button */
button[type="submit"],.mybtn, .crete_trip_button{
  background-color: #2e2ed4;
  color: white;
  border: none;
  border-radius: 4px;
  padding: 10px 20px;
  cursor: pointer;
  transition: background-color 0.3s;
  
}

button[type="submit"]:hover, .mybtn:hover, .crete_trip_button:hover {
  background-color: #5959ef;
}

/* Popup dialog box */
.dialog {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

/* Dialog content */
.dialog-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 60%;
    max-width: 600px;
    position: relative;
    
}

.group_more{
    display: flex;
    flex-direction: row;
}

/* Close button */
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

/* Participants list */
#tripParticipants {
    list-style-type: none;
    padding: 0;
}

#tripParticipants li {
    margin-bottom: 5px;
}

#succussTripButton{
    background-color: #2e2ed4;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    margin-right: 10px;
}

#succussTripButton:hover {
    background-color: #5959ef;
}

/* Cancel trip button */
#cancelTripButton {
    background-color: #f44336;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    /* float: right; */
}

#cancelTripButton:hover {
    background-color: #d32f2f;
}

.more-info{
    width: 30%;
    display: flex;
    flex-direction: column;
    width: max-content;
    gap: auto;
    margin-bottom: 10px;
}

.more-info p{
    margin-right: 10px;
}
.people_ontrip{
    justify-content: center;
    align-items: center;
    width: 70%;
    margin-top: 10px;
    display: flex;
    flex-direction: column;
}

.people_ontrip h3{
    margin-bottom: 10px;
    font-size: medium;
    font-weight: bolder;
}

.user_info {
    display: flex;
    align-items: center;
    padding: 10px;
    cursor: pointer;
}

.message-interface {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.message-content {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    width: 80%;
    height: 80%;
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    /* overflow-y: auto; */
}

.message-bubbles {
    width: 100%;
    overflow-y: auto;
}

.message-bubble {
    max-width: 70%;
    margin: 10px;
    padding: 10px;
    border-radius: 10px;
    background-color: #e6e6e6;
    clear: both;
}

.message-bubble.from {
    float: right;
    background-color: #a3d2ca;
}

.message-input {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px;
}

.message-input input {
    flex-grow: 1;
    margin-right: 10px;
}

.message-header {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #ccc;
}

.message-header button {
    padding: 5px 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

/* Styles for chat container */
.chats {
    display: none ;
    flex-direction: column;
    height: 400px;
    padding: 10px;
    border: 1px solid #ccc;
    text-align: center;
}

/* Chat header styles */
.chat-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
    border-bottom: solid 1.5px #1a1a7f;
}

#userName {
    width: 100%;
    text-align: center;
}

/* Message container styles */
.chat-messages {
    flex-grow: 1;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    max-height: 300px; /* Example height, adjust as needed */
}


/* Track */
.chat-messages::-webkit-scrollbar {
  width: 6px; /* Adjust as needed for the thickness */
  background-color: transparent;
}

/* Thumb */
.chat-messages::-webkit-scrollbar-thumb {
  background-color: #2e2ed4;
  border-radius: 3px; /* Adjust as needed for the roundness */
}

/* Hover/Focus styles for the thumb */
.chat-messages::-webkit-scrollbar-thumb:hover,
.chat-messages::-webkit-scrollbar-thumb:focus {
  background-color: #3d3ddc;
}

/* Transition */
.chat-messages::-webkit-scrollbar-thumb {
  transition: background-color 0.3s ease;
}


/* Message bubble styles */
.message {
    max-width: 70%;
    padding: 8px 12px;
    margin-bottom: 8px;
    border-radius: 8px;
    word-wrap: break-word;
}

/* Message sent style */
.message.sent {
    background-color: #58588a;
    align-self: flex-end;
    color: white;

}

/* Message received style */
.message.received {
    background-color: #9e9efd;
    align-self: flex-start;
}

/* Message form styles */
#messageForm {
    display: flex;
    align-items: center;
}

#messageInput {
    flex-grow: 1;
    /* margin-right: 10px; */
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    
    align-items: center;
    justify-content: center;
}

#messageForm button {
    padding: 8px 16px;
    border: none;
    background-color: #007BFF;
    color: white;
    border-radius: 4px;
    cursor: pointer;
}

#backButton{
    color:  #007BFF;
    background-color: white;
    border: none;
    font-weight: bolder;
    cursor: pointer;
    transition: background-color 0.3s;
}

.mother_messages{
    display: flex;
    flex-direction: column;
    justify-content:flex-end;
    height: 320px;
    width: 300px;
    /* overflow-y: auto; */

}

.message-timestamp{
    font-size: 0.6rem;
    color: #fff;
    margin-left: 5px;
    white-space: nowrap;
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
        <div class="tab-content">
        <div style="text-align: center;"> <!-- Center the input field -->
            <h2 id="greeting">Welcome to BuddyGo!</h2>
            <p>Plan your future to be safe while you network and reduce cost.</p>
        <input type="text" placeholder="Search for trips" class="search-input" style="width: 80%;"> <!-- Increase width -->
    </div>
        </div>
        <div class="booked-trips">
        <h3>Upcomming Trips </h3>
        <div id='cards-container' class="card-container">

        <div id='cards' class="cards">
        </div>
       
        </div>
        
    </div>
    
        
    </div>
    <!-- </div> -->
    
    <div class="right-container">
    <button type="button" class="mybtn" id="openModalBtn">
        Create a Trip
    </button>
        <h3 class="chat_name" id='chats_header' onclick='show_messages()'> Open Chats</h3>
        <div id='buddies' class="user-list">
            <input id="search" type="text" placeholder="Search for buddies" class="search-input-buddy">
            <div id='messages' class="messages">

            </div>
            <div id="chats" class="chats">
                <!-- Header with back button and user name -->
                <div class="chat-header">
                    <button id="backButton">&times;</button>
                    <h3 id="userName"></h3>
                </div>
                <div class="mother_messages">
                <!-- Chat messages container -->
                <div class="chat-messages" id="chatMessages">
                    <!-- Messages will be dynamically added here -->
                </div>

                <!-- Message form -->
                <form id="messageForm" onsubmit="sendMessage()">
                    <input id="messageInput" placeholder="Type your message..."></input>
                </form>
                </div>
            </div>
            <!-- More user rows can be added here -->
        </div>
        <!-- <h3 class="history" id='history'> Planned Trips</h3> -->


        <!-- <button class="check-last-trip">Check Last Trip</button> -->
    </div>
    <!-- The modal -->
<div id="myModal" class="modal" >
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2 style="text-align: center;">Create a Trip</h2>
    <!-- Your form content goes here -->
    <form id="createTripForm">
      <div class="form-group">
        <label for="tripName">Destination:</label>
        <input type="text" id="tripName" name="tripName" placeholder="Enter destinaiton" required>
      </div>
      <!-- <div class="form-group">
        <label for="tripDate">Date:</label>
        <input type="date" id="tripDate" name="tripDate" required>
      </div> -->
      <div class="form-group">
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" placeholder="Enter location" required>
      </div>
      <div style='display:flex;'>
      <div class="form-group details">
        <label for="begin" style="margin:20px 10px 20px 0px">Date:</label>
        <input type="date" id="begin" name="date" required>
      </div>
      <div class="form-group details">
        <label for="begin"  style="margin:20px 10px 20px 0px">Start:</label>
        <input type="time" id="begin" name="begin" required>
      </div>
      <div class="form-group details">
        <label for="end" style="margin:20px 10px 20px 20px">End:</label>
        <input type="time" id="end" name="end" required>
      </div>
      </div>
      
      <div class="form-group details">
        <label for="seats" style="text-align: center;">Seats:</label>
        <input type="number" id="seats" name="seats" placeholder="Enter number of seats" required>
      </div>
      <div style="display: flex; align-items:center; justify-content:center">
      <button type="button" class="crete_trip_button" onclick="submitForm()">Submit</button>
      </div>
    </form>
  </div>


  <!-- Hidden message interface -->
<div id="messageInterface" style="display: none;">
    <div class="message-header">
        <span id="selectedUserName"></span>
        <button onclick="closeMessageInterface()">&times;</button>
    </div>
    <div class="message-content">
        <div class="message-bubbles" id="messageBubbles">
            <!-- Message bubbles will be populated here -->
        </div>
        <div class="message-input">
            <input type="hidden" id="selectedUserId">
            <input type="text" id="messageInput" placeholder="Type a message...">
        </div>
    </div>
</div>


</div>

<!-- Popup dialog box -->
<div id="tripDetailsDialog" class="dialog" style="display: none;">
    <div class="dialog-content">
        <span class="close" onclick="hideTripDetailsDialog()">&times;</span>
        <h2 style="text-align: center;" id="tripDialogTitle"></h2>
        <div class="group_more">
        <div class='more-info'>
        <p><strong>Date:</strong> <span id="tripDate"></span></p>
        <p><strong>Start Time:</strong> <span id="tripStartTime"></span></p>
        <p><strong>End Time:</strong> <span id="tripEndTime"></span></p>
        </div>
        <div class="people_ontrip">
        <h3 >People on the Trip:</h3>
        <ul id="tripParticipants"></ul>
        </div>
        </div>

        <div id="controlTrip" style="display: none; justify-content:center; align-items:center; gap:10px">            
        <button id="cancelTripButton" >Cancel Trip</button>
        <button id="succussTripButton" >Complete Trip</button>

        </div>
    </div>
</div>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    function scrollRight() {
        console.log('Scrolling right');
        document.getElementById('cards-container').scrollLeft += 100;
    }

    function scrollLeft() {
        console.log('Scrolling left');
        document.getElementById('cards-container').scrollLeft -= 100;
    }

    // Function to open message interface and display selected user's name
function openMessageInterface(userName) {
    document.getElementById('selectedUserName').textContent = userName;
    document.getElementById('messageInterface').style.display = 'block';
}

// Function to close message interface
function closeMessageInterface() {
    document.getElementById('messageInterface').style.display = 'none';
}

function runGetMessagesEvery5Seconds(total) {

    if (selectedId == null || selectedName==null) {
        console.error('Invalid selected ID or name:', selectedId, selectedName);
        return;
    }
    // Call getMessages immediately (at time = 0)
    
    getMessagesD(userId, selectedName);

    // Set interval to call getMessages every 5 seconds
    setTimeout(function() {
        runGetMessagesEvery5Seconds(userId, userName);
    }, 5000); // 5000 milliseconds = 5 seconds
}


function sendMessage() {
    var messageInput = document.getElementById('messageInput').value.trim();
    console.log('Message input:', messageInput);
    console.log('Requester:', selectedId);
    if (messageInput === '') {
        alert('Please enter a message before sending.');
        return;
    }

    var messageData = {
        sendersID: <?php echo $_SESSION['user_id']; ?>,
        receiversID: selectedId,
        message: messageInput
    };

    $.ajax({
        url: '../functions/send_message.php',
        type: 'POST',
        dataType: 'json',
        data: messageData,
        success: function(response) {
            console.log('Message sent:', response);
            if (response && response.success) {
                // Append the sent message to the chat container
            //    getMessages(selectedId,selectedName);
                // Clear the message input field
                document.getElementById('messageInput').value = '';
            } else {
                alert('Failed to send message. Please try again.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error sending message:', error);
            // alert('An error occurred while sending the message.');
        }
    });
}

// Example event listener for user_info click (to open message interface)
document.querySelectorAll('.user_info').forEach(function(user) {
    user.addEventListener('click', function() {
        var userName = this.querySelector('.user_name').textContent;
        openMessageInterface(userName);
    });
});

function displayTravelBuddies(response) {
    console.log('Response:', response);
    var tripParticipantsList = document.getElementById('tripParticipants');
    tripParticipantsList.innerHTML = ''; // Clear existing content

    if (response.success) {
        console.log('Travel buddies:', response.usernames);
        var usernames = response.usernames;
        if (usernames.length === 0) {
            var noParticipants = document.createElement('li');
            noParticipants.textContent = 'No participants found.';
            tripParticipantsList.appendChild(noParticipants);
            return;
        }
        usernames.forEach(function(username) {
            var listItem = document.createElement('li');
            listItem.textContent = username;
            tripParticipantsList.appendChild(listItem);
        });
    } else {
        // Handle error if travel buddies fetching failed
        console.error('Error fetching travel buddies:', response.error);
    }
}

function getCommunity() {
    $.ajax({
        url: '../functions/fetch_travel_buddieschats.php',
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response && response.success && response.usernames) {
                var usernamesByUserId = response.usernames;
                var currentUserId = <?php echo $_SESSION['user_id']; ?>;
                // Clear the existing content of the buddies container
                var buddiesContainer = document.getElementById('messages');
                buddiesContainer.innerHTML = ''; // Clear previous content
                var currentUserId = <?php echo $_SESSION['user_id']; ?>;

                if (Object.keys(usernamesByUserId).length === 0) {
                    var noBuddies = document.createElement('div');
                    noBuddies.textContent = 'No buddies found.';
                    buddiesContainer.appendChild(noBuddies);
                    return;
                }
                console.log('Usernames by user ID:', usernamesByUserId);

                // Iterate over the usernamesByUserId object
                Object.entries(usernamesByUserId).forEach(([userId, username]) => {
                    console.log('User ID:', userId);
                    if (userId != currentUserId) {

                    var userDiv = document.createElement('div');
                    var userDivId = 'user_info_' + userId;
                    userDiv.id = userDivId;
                    userDiv.classList.add('user_info');

                    userDiv.onclick = function() {
                        getMessages(userId, username);
                        console.log('username:', username);
                    };

                    var userIcon = document.createElement('img');
                    userIcon.src = '../assets/icons/man.png'; // Placeholder icon
                    userIcon.alt = 'User icon';
                    userIcon.classList.add('user-icon');
                    userIcon.width = 30;
                    userIcon.height = 30;

                    var userNameSpan = document.createElement('span');
                    userNameSpan.textContent = username;

                    userDiv.appendChild(userIcon);
                    userDiv.appendChild(userNameSpan);

                    buddiesContainer.appendChild(userDiv);
                    }
                });
            } else {
                console.error('Invalid or unsuccessful response:', response);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching data:', error);
            console.log('Response status:', xhr.status);
            console.log('Response text:', xhr.responseText);
        }
    });
}

// getMessages(selectedId,selectedName);

function getMessages(userId, username) {
    selectedId=userId;
      // Hide the buddies container and show the chats container
      document.getElementById('messages').style.display = 'none';
    document.getElementById('search').style.display = 'none';
    document.getElementById('chats').style.display = 'block';
    // Function to fetch and display messages
    function fetchMessages() {
        $.ajax({
            url: '../functions/fetch_messages.php',
            type: 'POST',
            dataType: 'json',
            data: { userId: userId },
            success: function(response) {
                console.log('Response:', response);

                if (response && response.success && response.messages.length > 0) {
                    console.log('Messages:', response.messages);

                    // Clear previous messages in chat area
                    var chatMessagesContainer = document.getElementById('chatMessages');
                    chatMessagesContainer.innerHTML = '';

                    if (response.messages.length === 0) {
                        var noMessages = document.createElement('div');
                        noMessages.textContent = 'No messages found.';
                        chatMessagesContainer.appendChild(noMessages);
                        return;
                    }

                    // Display messages in the chat area
                    response.messages.forEach(function(message) {
                        var messageDiv = createMessageElement(message);
                        chatMessagesContainer.appendChild(messageDiv);
                    });

                    // Scroll to the bottom of the chat area
                    chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
                } else {
                    console.error('No messages found or error in response.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching messages:', error);
            }
        });
    }

    // Initial fetch of messages
    fetchMessages();

    // Set interval to periodically fetch messages (every 5 seconds)
    var messageUpdateInterval = setInterval(fetchMessages, 5000);

    // Attach event listener to back button
    var backButton = document.getElementById('backButton');
    backButton.addEventListener('click', function() {
        // Show the buddies container and hide the chats container
        document.getElementById('messages').style.display = 'block';
        document.getElementById('search').style.display = 'block';
        document.getElementById('chats').style.display = 'none';

        // Clear the message update interval when navigating away
        clearInterval(messageUpdateInterval);
    });

    // Handle message submission
    var messageForm = document.getElementById('messageForm');
    messageForm.addEventListener('submit', function(event) {
        event.preventDefault();

        var messageInput = document.getElementById('messageInput').value.trim();
        // if (messageInput !== '') {
        //     sendMessage(messageInput); // Call sendMessage function with messageInput
        // }

        document.getElementById('messageInput').value = '';
    });
}


// Helper function to create a message element
function createMessageElement(message) {
    var messageDiv = document.createElement('div');
    messageDiv.textContent = message.message;
    messageDiv.classList.add('message');

    // Determine message alignment based on sender's ID
    if (message.sendersID == <?php echo $_SESSION['user_id']; ?>) {
        messageDiv.classList.add('sent');
    } else {
        messageDiv.classList.add('received');
    }

    // Create a small element for displaying the message timestamp
    var timestampElement = document.createElement('small');
    timestampElement.textContent = formatTimestamp(message.created_at);
    timestampElement.classList.add('message-timestamp');

    // Append timestamp before the message content
    messageDiv.appendChild(timestampElement);

    return messageDiv;
}


// Helper function to format timestamp
function formatTimestamp(timestamp) {
    var date = new Date(timestamp);
    return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
}

function getTravelBuddies(tripID) {
    var tripParticipantsList = document.getElementById('tripParticipants');
    tripParticipantsList.innerHTML = ''; // Clear existing content

    $.ajax({
        url: '../functions/fetch_travel_buddiescurrent.php',
        type: 'POST',
        data: { tripID: tripID },
        dataType: 'json',
        success: function(response) {
            console.log('Response:', response);

            // Check if response contains any usernames
            if (Object.keys(response.usernames).length === 0) {
                var noParticipants = document.createElement('li');
                noParticipants.textContent = 'No participants found.';
                tripParticipantsList.appendChild(noParticipants);
            } else {
                // Iterate over the usernames in the response object
                Object.values(response.usernames).forEach(function(username) {
                    var listItem = document.createElement('li');
                    
                    listItem.textContent = username;
                    tripParticipantsList.appendChild(listItem);
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching trip details:', error);
        }
    });
}


 function getTrips() {
            fetch("../functions/get_trips_fxn.php") 
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Failed to fetch trips");
                    }
                    return response.json();
                })
                .then(data => {
                    // console.log('The reponse: ',data);
                    // Call a function to update the HTML with the fetched trips
                    // console.log(<?php echo $_SESSION["user_id"];?>)
                    updateTrips(data);
                })
                .catch(error => {

                    // alert("Error fetching trips: " + error.message);
                    console.error("Error fetching trips:", error.message);
                });
        }


function completeTrip(tripId){
    console.log('TripComplete: ',tripId);
    $.ajax({
        url: '../functions/complete_trip.php',
        type: 'POST',
        data: { tripID: tripId },
        dataType: 'json',
        success: function(response) {
            console.log('Response:', response);
            if (response.success) {
                alert('Trip completed successfully');
                document.getElementById('tripDetailsDialog').style.display = 'none';
                window.location.href='history.php';
                getTrips()
                // Optionally, update UI or perform additional actions
            } else {
                alert('Failed to complete trip');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error completing trip:', error);
            alert('Error completing trip');
        }
    });
}

function deleteTrip(tripID) {
    console.log('TripI--------------D:', tripID);
    // Confirm deletion with user
    if (confirm('Are you sure you want to delete this trip?')) {
        // AJAX request to delete trip
        $.ajax({
            url: '../functions/delete_trip.php', // Replace with your PHP script URL
            type: 'POST', // Use POST method to send data
            data: { tripID: tripID }, // Pass tripID to be deleted
            dataType: 'json', // Expect JSON response from the server
            success: function(response) {
                console.log('Respons-----------------e:', response);
                if (response.success) {
                    alert('Trip deleted successfully');
                    getTrips()
                    document.getElementById('tripDetailsDialog').style.display = 'none';
                    // Optionally, update UI or perform additional actions
                } else {
                    alert('Failed to delete trip');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error deleting trip:', error);
                alert('Error deleting trip');
            }
        });
    }
}

    function showTripDetailsDialog(trip) {

        getTravelBuddies(trip.TripID);

    // Populate trip details in the dialog box
    document.getElementById("tripDialogTitle").textContent = trip.Destination;
    document.getElementById("tripDate").textContent = trip.Date;
    console.log(trip.StartTime)
    console.log(trip.EndTime)
    document.getElementById("tripStartTime").textContent = trip.Start;
    document.getElementById("tripEndTime").textContent = trip.End;
    document.getElementById('cancelTripButton').addEventListener('click', function() {
        // Implement cancel trip functionality here
        deleteTrip(trip.TripID);
    });

    document.getElementById('succussTripButton').addEventListener('click', function() {
        // Implement cancel trip functionality here
        console.log('TripComplete: ',trip.TripID);
        completeTrip(trip.TripID);
    });

    // Populate list of users joined the trip
    // updateParticipantList(trip.Participants);

    // Show the dialog box
    document.getElementById("tripDetailsDialog").style.display = "block";
}

// Function to hide the trip details dialog
function hideTripDetailsDialog() {
    document.getElementById("tripDetailsDialog").style.display = "none";
}


   // Function to update the HTML with the fetched trips
   function updateTrips(trips) {
    var upcomingTripsContainer = document.getElementById("cards");

// Check if upcomingTripsContainer exists and is not null or undefined
if (upcomingTripsContainer) {
    // Clear previous content
    upcomingTripsContainer.innerHTML = "";

    if (trips.length === 0) {
        var noTripsMessage = document.createElement("p");
        noTripsMessage.textContent = "No upcoming trips found.";
        upcomingTripsContainer.appendChild(noTripsMessage);
        return;
    }
    // Loop through each trip and create HTML elements to display trip information
    trips.forEach(function(trip) {
        // Check if the trip belongs to the current user
        // if (trip.UserID == <?php echo $_SESSION["user_id"];?>) {
            var card = document.createElement("div");
            card.classList.add("card");

            var h4 = document.createElement("h4");
            h4.textContent = trip.Destination;

            var dateParagraph = document.createElement("p");
            dateParagraph.textContent = "Date: " + trip.Date;

            var destinationParagraph = document.createElement("p");
            destinationParagraph.textContent = "Destination: " + trip.Destination;

            var locationParagraph = document.createElement("p");
            locationParagraph.textContent = "Location: " + trip.Location;

            var seatsAvailableParagraph = document.createElement("p");
            seatsAvailableParagraph.textContent = "Seats Available: " + trip.SeatsAvailable;

            var button = document.createElement("button");
            button.textContent = "More Details";
            button.addEventListener("click", function() {
                // console.log("Show trip details for trip:", trip);
                // Implement cancel trip functionality here

                // completeTrip(trip.UserID);
                tripForComplete = trip.UserID;
                if (trip.UserID == <?php echo $_SESSION["user_id"];?>) {
                   document.getElementById('controlTrip').style.display = 'flex';
                }
                showTripDetailsDialog(trip);
            });

            card.appendChild(h4);
            card.appendChild(dateParagraph);
            card.appendChild(destinationParagraph);
            card.appendChild(locationParagraph);
            card.appendChild(seatsAvailableParagraph);
            card.appendChild(button);

            upcomingTripsContainer.appendChild(card);
        // }
        setTimeout(function() {
                                var messageContainer = document.getElementById('cards-container');
                                messageContainer.scrollLeft = messageContainer.scrollWidth;
                            }, 250);

    });
    openArrow();
   
}}

function openArrow(){
    var upcomingMainContainer = document.getElementById("cards-container");

    if (upcomingMainContainer.clientWidth >= 700) {
            document.getElementById('arrows').style.display = 'flex';
        } else {
            document.getElementById('arrows').style.display = 'none';
        }
}

    window.onload = function () {
        getCommunity();
        getTrips();
        
    };

  

    
    // Get the modal element
var modal = document.getElementById('myModal');


function submitForm() {
    // Get form data
    var form = document.getElementById("createTripForm");
    
    // Get input values
    var tripName = form.elements["tripName"].value.trim();
    var location = form.elements["location"].value.trim();
    var date = form.elements["date"].value.trim();
    var begin = form.elements["begin"].value.trim();
    var end = form.elements["end"].value.trim();
    var seats = form.elements["seats"].value.trim();
    
    // Define regular expressions for validation
    var nameRegex = /^[a-zA-Z\s]+$/; // Only allow letters and spaces
    var dateRegex = /^\d{4}-\d{2}-\d{2}$/; // Date format YYYY-MM-DD
    var timeRegex = /^(0[0-9]|1[0-9]|2[0-3]):[0-9][0-9]$/; // Time format HH:MM
    var seatsRegex = /^\d+$/; // Only allow positive integers
    
    // Perform validation
    if (!tripName.match(nameRegex)) {
        Swal.fire({
                    icon: 'error',
                    title: 'Please enter a valid destination (letters and spaces only).',
                    text: '',
                    showConfirmButton: false,
            });
        // alert("Please enter a valid destination (letters and spaces only).");
        return;
    }
    if (!location.match(nameRegex)) {
        Swal.fire({
                    icon: 'error',
                    title: 'Please enter a valid location (letters and spaces only).',
                    text: '',
                    showConfirmButton: false,
            });
        // alert("Please enter a valid location (letters and spaces only).");
        return;
    }
    if (!date.match(dateRegex)) {
        Swal.fire({
                    icon: 'error',
                    title: 'Please enter a valid date (YYYY-MM-DD format).',
                    text: '',
                    showConfirmButton: false,
            });
        // alert("Please enter a valid date (YYYY-MM-DD format).");
        return;
    }
    // if (!begin.match(timeRegex)) {
    //     console.log('begin',begin);
    //     Swal.fire({
    //                 icon: 'error',
    //                 title: 'Please enter a valid start time (HH:MM format).',
    //                 text: '',
    //                 showConfirmButton: false,
    //         });
    //     // alert("Please enter a valid start time (HH:MM format).");
    //     return;
    // }
    if (!end.match(timeRegex)) {
        console.log('end',end);

        Swal.fire({
                    icon: 'error',
                    title: 'Please enter a valid end time (HH:MM format).',
                    text: '',
                    showConfirmButton: false,
            });
        // alert("Please enter a valid end time (HH:MM format).");
        return;
    }
    if (!seats.match(seatsRegex)) {
        Swal.fire({
                    icon: 'error',
                    title: 'Please enter a valid number of seats (positive integer only).',
                    text: '',
                    showConfirmButton: false,
            });
        // alert("Please enter a valid number of seats (positive integer only).");
        return;
    }

    // Create FormData object
    var formData = new FormData(form);

    // Send form data via AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../action/create_trip_action.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Handle successful response
            console.log(xhr.responseText);
            alert(xhr.responseText);
            getTrips();
            modal.style.display = "none";
            form.reset();
            // You can do something here, such as displaying a success message
        }
    };
    xhr.send(formData);
}

// Get the button that opens the modal
var btn = document.getElementById("openModalBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

// Form submission (you can handle form submission using AJAX or other methods)
var form = document.getElementById("createTripForm");
form.addEventListener("submit", function(event) {
  event.preventDefault(); // Prevent form submission for now
  // Add your form submission logic here
  // Example: You can use fetch() or XMLHttpRequest to send form data to the server
  console.log("Form submitted!");
  modal.style.display = "none"; // Close the modal after submission
});

function changeBackgroundColor() {
            var chatName = document.querySelector('.chat_name');
            if (chatName.style.backgroundColor === 'rgb(89, 89, 239)') {
                chatName.style.backgroundColor = '#5959ef'; // Change to the desired background color
                // chatName.style.color = '#fbfbfe'; // Change to the desired text color
            } else {
                chatName.style.backgroundColor = '#fbfbfe'; // Change to the desired background color
                // chatName.style.color = '#2e2ed4'; // Change to the desired text color

                
            }
            // chatName.style.backgroundColor = '#5959ef'; // Change to the desired background color
            // chatName.style.color = '#fbfbfe'; // Change to the desired text color
        }
    function show_messages(){
        console.log('open chats')
        var buddies = document.getElementById('buddies');
        var chats = document.getElementById('chats_header');
        var messages=document.getElementById('messages');

        document.getElementById('messages').style.display = 'block';
     document.getElementById('chats').style.display = 'none';

        if (buddies.style.display === 'none') {
            buddies.style.display = 'block';
            chats.textContent = 'Messages';
            chats.style.transition = 'ease-in 1s';
            messages.style.display = 'block';
            document.getElementById('search').style.display = 'block';
            changeBackgroundColor()        
    } else {
            buddies.style.display = 'none';
            chats.textContent = 'Open Chats'; 
            changeBackgroundColor()       

        }
       

    }

    function toggleDropdown() {
        var dropdownMenu = document.getElementById('dropdown-menu');
        dropdownMenu.classList.toggle('show');
    }

        // Function to determine the time of day and update the greeting message
        var userName = '<?php echo $_SESSION["username"];?>';

    function updateTimeOfDay() {
        var now = new Date();
        var hour = now.getHours();
        var greeting = document.getElementById('greeting');

        if (hour >= 0 && hour < 12) {
            greeting.textContent = 'Good morning, ' + userName + '!';
        } else if (hour >= 12 && hour < 16) {
            greeting.textContent = 'Good afternoon, ' + userName + '!';
        } else {
            greeting.textContent = 'Good evening, ' + userName + '!';
        }
    }

    // Call the function when the page loads
    updateTimeOfDay();
</script>

</body>
</html>
