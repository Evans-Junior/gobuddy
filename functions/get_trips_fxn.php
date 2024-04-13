<?php
session_start(); // Start the session if not already started
include '../settings/connection.php';

// Get the logged-in user's ID from the session
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Fetch trips from the database where the logged-in user is the trip creator or requester
    $selectQuery = "SELECT * FROM Trips
    WHERE (UserID = $userId
           OR TripID IN (SELECT TripID FROM TripRequests WHERE RequesterUserID = $userId AND Status = 'Accepted'))
    AND TripStatus != 'Completed'  -- Exclude trips with TripStatus = 'Completed'
    AND TimeCreated < NOW()
    ORDER BY TripID ASC;";

    // Use prepared statement to execute the query
    $stmt = $con->prepare($selectQuery);
    $stmt->execute();
    $result = $stmt->get_result();

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
} else {
    // If user ID is not found in session, return an error
    echo json_encode(['error' => 'User session not found']);
}
?>