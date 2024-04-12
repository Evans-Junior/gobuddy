<?php
include '../settings/connection.php';

// Assuming you have established a database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['requestID']) && isset($_POST['status'])) {
    $requestID = $_POST['requestID'];
    $newStatus = $_POST['status'];

    // Update TripRequest status in the database
    $sqlUpdateRequest = "UPDATE TripRequests SET Status = ? WHERE RequestID = ?";
    $stmtUpdateRequest = $con->prepare($sqlUpdateRequest);
    $stmtUpdateRequest->bind_param('si', $newStatus, $requestID);

    // Check if the new status is 'Accepted'
    if ($newStatus === 'Accepted') {
        // Retrieve TripID and UserID associated with this TripRequest
        $sqlGetTripInfo = "SELECT TripID FROM TripRequests WHERE RequestID = ?";
        $stmtGetTripInfo = $con->prepare($sqlGetTripInfo);
        $stmtGetTripInfo->bind_param('i', $requestID);
        $stmtGetTripInfo->execute();
        $stmtGetTripInfo->bind_result($tripID);
        $stmtGetTripInfo->fetch();
        $stmtGetTripInfo->close();

        // Update the SeatsAvailable for the corresponding Trip
        $sqlUpdateSeats = "UPDATE Trips SET SeatsAvailable = SeatsAvailable - 1 WHERE TripID = ?";
        $stmtUpdateSeats = $con->prepare($sqlUpdateSeats);
        $stmtUpdateSeats->bind_param('i', $tripID);
        $stmtUpdateSeats->execute();
        $stmtUpdateSeats->close();
    }
    if ($newStatus === 'Cancelled') {
        // Retrieve TripID and UserID associated with this TripRequest
        $sqlGetTripInfo = "SELECT TripID FROM TripRequests WHERE RequestID = ?";
        $stmtGetTripInfo = $con->prepare($sqlGetTripInfo);
        $stmtGetTripInfo->bind_param('i', $requestID);
        $stmtGetTripInfo->execute();
        $stmtGetTripInfo->bind_result($tripID);
        $stmtGetTripInfo->fetch();
        $stmtGetTripInfo->close();

        // Update the SeatsAvailable for the corresponding Trip
        $sqlUpdateSeats = "UPDATE Trips SET SeatsAvailable = SeatsAvailable + 1 WHERE TripID = ?";
        $stmtUpdateSeats = $con->prepare($sqlUpdateSeats);
        $stmtUpdateSeats->bind_param('i', $tripID);
        $stmtUpdateSeats->execute();
        $stmtUpdateSeats->close();
    }

    // Execute the TripRequest status update
    if ($stmtUpdateRequest->execute()) {
        // Success response
        echo json_encode(['success' => true]);
    } else {
        // Error response
        echo json_encode(['success' => false, 'error' => 'Failed to update status']);
    }

    $stmtUpdateRequest->close();
} else {
    // Invalid request
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>