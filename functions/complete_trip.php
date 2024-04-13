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

function updateTripRequestsStatus($tripID) {
    global $con;

    // Update TripRequests status to 'Completed' for the specified trip in TripRequests table
    $updateRequestsQuery = "UPDATE TripRequests 
                            SET Status = 'Completed' 
                            WHERE TripID = ? 
                            AND Status = 'Accepted'";

    $stmtRequests = $con->prepare($updateRequestsQuery);
    $stmtRequests->bind_param('i', $tripID);

    if (!$stmtRequests->execute()) {
        // Error occurred during statement execution
        return $stmtRequests->error;
    }

    $affectedRows = $stmtRequests->affected_rows;
    $stmtRequests->close();

    return $affectedRows;
}

// Check if tripID is provided in the POST request
if (isset($_POST['tripID']) && !empty($_POST['tripID'])) {
    $tripID = $_POST['tripID'];

    $tripUpdated = updateTripStatus($tripID);
    if (is_numeric($tripUpdated)) {
        if ($tripUpdated > 0) {
            // Trip status updated successfully, proceed to update trip requests
            $requestsUpdated = updateTripRequestsStatus($tripID);
            if (is_numeric($requestsUpdated)) {
                if ($requestsUpdated > 0) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'No trip requests found for the specified trip']);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'Error updating TripRequests: ' . $requestsUpdated]);
            }
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