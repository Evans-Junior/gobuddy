<?php
include '../settings/connection.php';

// Get the user ID from the session
$userID = $_SESSION["user_id"];

// Fetch trips from the database for the specific user
$selectQuery = "SELECT * FROM Trips WHERE UserID = $userID AND TimeCreated < NOW() ORDER BY TripID DESC";
$result = $con->query($selectQuery);

// Initialize an empty array to store trip data
$trips = [];

// Check if there are any trips found
if ($result->num_rows > 0) {
    // Fetch each row as an associative array and add it to the trips array
    while ($row = $result->fetch_assoc()) {
        $trips[] = $row;
    }
}

// Return the trips data as JSON
echo json_encode($trips);
?>
