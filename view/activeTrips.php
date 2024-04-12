<?php
session_start();

// ensure user is logged in
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
            color: #2e2ed4; /* Color brand */
            font-size: 24px;
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
    max-height: calc(100vh - 350px);
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
            height: calc(100vh - 100px); /* Adjust as needed */
            max-width: 1300px;
        }

    .right-container{
        display: flex;
        flex-direction: column;
        gap: 20px;
        justify-content: center;
    }

    .tab-content{
        display: flex;
        flex-direction: row;
        gap: 20px;
        justify-content: center;
    }

    h5{
    color: #2e2ed4; /* Color brand */
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

    </style>
</head>
<body>
<nav class="navbar">
    <div class="container_logo">
        <div class="logo">BuddyGo</div>
        <ul class="nav-links">
            <li><a href="home.php">Home</a></li>
            <li><a href="#">Travels</a></li>
            <li><a href="#">Active Trips</a></li>
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

<div class="container">
    <div class="left-container">

        <div class="tab-content">
            <div style="text-align: center; margin-top:50px;">
            <h3>Find a Buddy</h3>

                <input type="text" placeholder="Search for trips" class="search-input" style="width: 500px;">
            </div>
            <div class="right-container">
                <input type="text" placeholder="Search for trips in your location" class="search-input" style="width: 500px;">
                <input type="text" placeholder="Trips to your location" class="search-input" style="width: 500px;">

            </div>
        </div>
        <div class="booked-trips">
            <h3>Booked Trips</h3>
            <div class="cards">
                <?php
                // Example of dynamic content generation
                // // You can replace this with actual data fetched from a database
                // $trips = array(
                //     array("Trip to Beach", "March 20, 2024", "Sunny Beach Resort", "John Doe","8:00 AM","12:00 PM","5"),
                //     array("Mountain Hiking", "March 25, 2024", "Mountain Peak Trail", "Jane Smith","8:00 AM","12:00 PM","5"),
                //     array("Mountain Hiking", "March 25, 2024", "Mountain Peak Trail", "Jane Smith","8:00 AM","12:00 PM","5"),
                //     array("Trip to Beach", "March 20, 2024", "Sunny Beach Resort", "John Doe","8:00 AM","12:00 PM","5"),
                //     array("Mountain Hiking", "March 25, 2024", "Mountain Peak Trail", "Jane Smith","8:00 AM","12:00 PM","5"),
                //     array("Mountain Hiking", "March 25, 2024", "Mountain Peak Trail", "Jane Smith","8:00 AM","12:00 PM","5"),
                //     array("Trip to Beach", "March 20, 2024", "Sunny Beach Resort", "John Doe","8:00 AM","12:00 PM","5"),
                //     array("Mountain Hiking", "March 25, 2024", "Mountain Peak Trail", "Jane Smith","8:00 AM","12:00 PM","5"),
                //     array("Mountain Hiking", "March 25, 2024", "Mountain Peak Trail", "Jane Smith","8:00 AM","12:00 PM","5"),
                //     array("Trip to Beach", "March 20, 2024", "Sunny Beach Resort", "John Doe","8:00 AM","12:00 PM","5"),
                //     array("Mountain Hiking", "March 25, 2024", "Mountain Peak Trail", "Jane Smith","8:00 AM","12:00 PM","5"),
                //     array("Mountain Hiking", "March 25, 2024", "Mountain Peak Trail", "Jane Smith","8:00 AM","12:00 PM","5"),
                //     array("Trip to Beach", "March 20, 2024", "Sunny Beach Resort", "John Doe","8:00 AM","12:00 PM","5"),
                //     array("Mountain Hiking", "March 25, 2024", "Mountain Peak Trail", "Jane Smith","8:00 AM","12:00 PM","5"),
                //     array("Mountain Hiking", "March 25, 2024", "Mountain Peak Trail", "Jane Smith","8:00 AM","12:00 PM","5"),
                // );

                foreach ($trips as $trip) {
                    echo "<div class='card'>
                            <h5>{$trip[0]}</h5>
                            <p>Date: {$trip[1]}</p>
                            <p>Location: {$trip[2]}</p>
                            <p>Buddy: {$trip[3]}</p>
                            <div class='details'>
                            <p>Begin: <strong>{$trip[4]}</strong></p>
                            <p>End: <strong>{$trip[5]}</strong></p>
                            <p>Seats:<strong>{$trip[6]}</strong></p>
                            </div>
                            <button>Reach out</button>        
                          </div>";
                }
                ?>
            </div>
        </div>
    </div>
    
    </div>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Your existing JavaScript functions here
</script>

</body>
</html>
