<?php
include '../settings/connection.php';

// Check if tripID is provided via POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tripID'])) {
    $tripID = $_POST['tripID'];

    // Delete related records from TripRequests table
    $deleteTripRequests = "DELETE FROM TripRequests WHERE TripID = ?";
    $stmtRequests = $con->prepare($deleteTripRequests);
    $stmtRequests->bind_param('i', $tripID);
    $stmtRequests->execute();

    // Delete related records from TripReviews table
    $deleteTripReviews = "DELETE FROM TripReviews WHERE TripID = ?";
    $stmtReviews = $con->prepare($deleteTripReviews);
    $stmtReviews->bind_param('i', $tripID);
    $stmtReviews->execute();

    // Delete the TripID from the Trips table
    $deleteTrip = "DELETE FROM Trips WHERE TripID = ?";
    $stmtTrip = $con->prepare($deleteTrip);
    $stmtTrip->bind_param('i', $tripID);

    if ($stmtTrip->execute()) {
        // Trip deleted successfully
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to delete trip']);
    }
} else {
    // Invalid request
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>