<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    exit(json_encode(['error' => 'User not authenticated']));
}

// Include database connection
include '../settings/connection.php';

// Retrieve data from POST request
$tripID = $_POST['tripID'];
$userID = $_SESSION['user_id'];

// Check if the current user is the creator of the trip
$selectQuery = "SELECT UserID FROM Trips WHERE TripID = ?";
$stmt = $con->prepare($selectQuery);
$stmt->bind_param('i', $tripID);
$stmt->execute();
$stmt->bind_result($tripCreatorID);
$stmt->fetch();
$stmt->close();

if (!$tripCreatorID) {
    http_response_code(404); // Not found
    exit(json_encode(['error' => 'Trip not found']));
}

if ($userID == $tripCreatorID) {
    // User is the creator of the trip, update TripStatus to 'Deleted' in Trips table
    $updateQuery = "UPDATE Trips SET TripStatus = 'Deleted' WHERE TripID = ?";
} else {
    // User is not the creator, change the Status of TripRequests with the same tripID
    $updateQuery = "UPDATE TripRequests SET Status = 'Deleted' WHERE TripID = ?";
}

// Execute the update query
$stmt = $con->prepare($updateQuery);
$stmt->bind_param('i', $tripID);
$result = $stmt->execute();
$stmt->close();

if ($result) {
    http_response_code(200); // OK
    exit(json_encode(['success' => true]));
} else {
    http_response_code(500); // Internal server error
    exit(json_encode(['error' => 'Failed to delete trip']));
}
?>
