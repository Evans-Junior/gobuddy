<?php
session_start();
include '../settings/connection.php';

function updateTripStatus($tripID) {
    global $con;

    // Update the TripStatus and TimeCreated for the specified trip in Trips table
    $updateTripQuery = "UPDATE Trips 
                        SET TripStatus = 'Completed', 
                            TimeCreated = CURRENT_TIMESTAMP
                        WHERE TripID = ?";

    $stmtTrip = $con->prepare($updateTripQuery);
    $stmtTrip->bind_param('i', $tripID);

    if (!$stmtTrip->execute()) {
        // Error occurred during statement execution
        return $stmtTrip->error;
    }

    $affectedRows = $stmtTrip->affected_rows;
    $stmtTrip->close();

    return $affectedRows;
}

// Check if tripID is provided in the POST request
if (isset($_POST['tripID']) && !empty($_POST['tripID'])) {
    $tripID = $_POST['tripID'];

    $tripUpdated = updateTripStatus($tripID);
    if (is_numeric($tripUpdated)) {
        if ($tripUpdated > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No trip found with the specified ID']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Error updating TripStatus: ' . $tripUpdated]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Trip ID not provided']);
}

$con->close();
?>