<?php
session_start();
include '../settings/connection.php';

// Initialize associative array to store UserIDs and corresponding usernames for each trip ID
$usernamesByTripId = [];

try {
    // Verify session user ID
    if (!isset($_SESSION['user_id'])) {
        throw new Exception("Session user ID not set");
    }

    $userId = $_SESSION['user_id'];

    // Step 1: Get all trip IDs for trips the user is involved in either as creator or requester
    $tripIdsQuery = "SELECT DISTINCT t.TripID
                     FROM Trips t
                     JOIN TripRequests tr ON t.TripID = tr.TripID
                     WHERE t.UserID = ? OR tr.RequesterUserID = ?";

    $stmtTripIds = $con->prepare($tripIdsQuery);
    $stmtTripIds->bind_param('ii', $userId, $userId);
    $stmtTripIds->execute();
    $resultTripIds = $stmtTripIds->get_result();

    $tripIds = [];
    while ($rowTripIds = $resultTripIds->fetch_assoc()) {
        $tripIds[] = $rowTripIds['TripID'];
    }
    $stmtTripIds->close();

    // Step 2: Get usernames associated with the obtained trip IDs
    foreach ($tripIds as $tripId) {
        $usernamesQuery = "SELECT DISTINCT u.UserID, u.Username
                           FROM Users u
                           JOIN TripRequests tr ON u.UserID = tr.RequesterUserID
                           WHERE tr.Status IN ('Accepted', 'Completed', 'Deleted') AND tr.TripID = ?";

        $stmtUsernames = $con->prepare($usernamesQuery);
        $stmtUsernames->bind_param('i', $tripId);
        $stmtUsernames->execute();
        $resultUsernames = $stmtUsernames->get_result();

        $usernamesForTrip = [];
        while ($rowUsernames = $resultUsernames->fetch_assoc()) {
            $usernamesForTrip[$rowUsernames['UserID']] = $rowUsernames['Username'];
        }

        // Store usernames for the current trip ID
        $usernamesByTripId[$tripId] = $usernamesForTrip;

        $stmtUsernames->close();
    }

    // Prepare response with success flag and the associative array of TripIDs and associated UserIDs with usernames
    $response = [
        'success' => true,
        'usernames' => $usernamesByTripId
    ];

    echo json_encode($response);
} catch (Exception $e) {
    // Handle exceptions
    $errorResponse = ['success' => false, 'error' => $e->getMessage()];
    echo json_encode($errorResponse);
}
?>
