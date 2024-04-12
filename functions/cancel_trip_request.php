<?php
include '../settings/connection.php';

// Check if the request is a POST request and contains 'requestID'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['requestID'])) {
    $requestID = $_POST['requestID'];

    // Delete TripRequest from the database
    $sql = "DELETE FROM TripRequests WHERE RequestID = ?";

    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $requestID); // 'i' indicates integer type for the parameter

    if ($stmt->execute()) {
        // Send success response
        echo json_encode(['success' => true]);
    } else {
        // Send error response
        echo json_encode(['success' => false, 'error' => 'Failed to cancel trip request']);
    }
} else {
    // Invalid request
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>