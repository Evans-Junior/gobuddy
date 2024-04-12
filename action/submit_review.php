<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    exit(json_encode(['error' => 'User not authenticated']));
}

// Include database connection
include '../settings/connection.php';

// Validate and sanitize form inputs
if (
    isset($_POST['reviewedPID']) &&
    isset($_POST['reviewText']) &&
    isset($_POST['rating']) &&
    isset($_POST['currentTripID'])
) {
    $reviewedPID = $_POST['reviewedPID']; // Buddy's UserID (convert to integer for safety)
    $reviewText = $_POST['reviewText']; // Review text
    $rating = $_POST['rating']; // Rating (convert to integer)
    $currentTripID = $_POST['currentTripID']; // TripID of the trip being reviewed

    // Validate rating (should be between 1 and 5)
    if ($rating < 1 || $rating > 5) {
        http_response_code(400); // Bad request
        exit(json_encode(['error' => 'Invalid rating value (Rating should be between 1 and 5)']));
    }

    // Get the logged-in user's ID from the session
    $reviewerUserId = $_SESSION['user_id'];

    // Insert the review into the TripReviews table
    $insertQuery = "INSERT INTO TripReviews (TripID, ReviewerUserID, ReviewedUserID, Rating, ReviewText)
                    VALUES (?, ?, ?, ?, ?)";

    // Prepare the SQL statement
    $stmt = $con->prepare($insertQuery);
    if (!$stmt) {
        http_response_code(500); // Internal server error
        exit(json_encode(['error' => 'Failed to prepare statement: ' . $con->error]));
    }

    // Bind parameters and execute the statement
    $stmt->bind_param('iiiss', $currentTripID, $reviewerUserId, $reviewedPID, $rating, $reviewText);
    $result = $stmt->execute();

    // Check the execution result
    if ($result) {
        http_response_code(201); // Created
        exit(json_encode(['success' => true]));
    } else {
        http_response_code(500); // Internal server error
        exit(json_encode(['error' => 'Failed to submit review: ' . $stmt->error]));
    }
} else {
    // Invalid request
    http_response_code(400); // Bad request
    exit(json_encode(['error' => 'Incomplete form data']));
}
?>