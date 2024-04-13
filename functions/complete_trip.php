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

    if ($stmtTrip->execute() && $stmtTrip->affected_rows > 0) {
        $stmtTrip->close();
        return true;
    } else {
        $stmtTrip->close();
        return false;
    }
}

function updateTripRequestsStatus($tripID) {
    global $con;

    // Update TripRequests status to 'Completed' for the specified trip in TripRequests table
    $updateRequestsQuery = "UPDATE TripRequests 
                            SET Status = 'Completed' 
                            WHERE TripID = ? 
                            AND Status = 'Accepted'";

    $stmtRequests = $con->prepare($updateRequestsQuery);
    $stmtRequests->bind_param('i', $tripID);

    if ($stmtRequests->execute() && $stmtRequests->affected_rows > 0) {
        $stmtRequests->close();
        return true;
    } else {
        $stmtRequests->close();
        return false;
    }
}

// Check if tripID is provided in the POST request
if (isset($_POST['tripID'])) {
    $tripID = $_POST['tripID'];

    $tripUpdated = updateTripStatus($tripID);
    if ($tripUpdated) {
        $requestsUpdated = updateTripRequestsStatus($tripID);
        if ($requestsUpdated) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error updating TripRequests']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'No trip found with the specified ID']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Trip ID not provided']);
}

$con->close();
?>
