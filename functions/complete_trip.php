<?php
session_start(); // Start the session if not already started
include '../settings/connection.php';

// Check if tripID is provided in the POST request
if (isset($_POST['tripID'])) {
    $tripID = $_POST['tripID'];

    // Update the TripStatus and TimeCreated for the specified trip in Trips table
    $updateTripQuery = "UPDATE Trips 
                        SET TripStatus = 'Completed', 
                            TimeCreated = CURRENT_TIMESTAMP
                        WHERE TripID = ?";
    
    // Use prepared statement to prevent SQL injection for Trips table
    $stmtTrip = $con->prepare($updateTripQuery);
    $stmtTrip->bind_param('i', $tripID);

    // Execute the update query for Trips
    if ($stmtTrip->execute()) {
        // Check if any rows were affected (query was successful)
        if ($stmtTrip->affected_rows > 0) {
            // Update TripRequests status to 'Completed' for the specified trip in TripRequests table
            $updateRequestsQuery = "UPDATE TripRequests 
                                    SET Status = 'Completed' 
                                    WHERE TripID = ?";
            
            // Use prepared statement for TripRequests table
            $stmtRequests = $con->prepare($updateRequestsQuery);
            $stmtRequests->bind_param('i', $tripID);

            // Execute the update query for TripRequests
            if ($stmtRequests->execute()) {
                // Send success response back to the frontend
                echo json_encode(['success' => true]);
            } else {
                // Error occurred while updating TripRequests
                echo json_encode(['success' => false, 'error' => 'Error updating TripRequests']);
            }

            // Close TripRequests statement
            $stmtRequests->close();
        } else {
            // No rows were updated (tripID not found or no changes made)
            echo json_encode(['success' => false, 'error' => 'No trip found with the specified ID']);
        }
    } else {
        // Error occurred while updating Trips
        echo json_encode(['success' => false, 'error' => 'Error updating trip status']);
    }

    // Close the database connection and Trips statement
    $stmtTrip->close();
    $con->close();
} else {
    // tripID was not provided in the POST request
    echo json_encode(['success' => false, 'error' => 'Trip ID not provided']);
}
?>