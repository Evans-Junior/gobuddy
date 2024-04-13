<?php
session_start();
include '../settings/connection.php';

// Initialize associative array to store UserIDs and corresponding usernames
$usernamesByUserId = [];

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
    $usernamesQuery = "SELECT DISTINCT u.UserID, u.Username
                       FROM Users u
                       JOIN TripRequests tr ON u.UserID = tr.RequesterUserID
                       WHERE tr.Status IN ('Accepted', 'Completed', 'Deleted') AND tr.TripID IN (".implode(",", $tripIds).")";

    $stmtUsernames = $con->prepare($usernamesQuery);
    $stmtUsernames->execute();
    $resultUsernames = $stmtUsernames->get_result();

    while ($rowUsernames = $resultUsernames->fetch_assoc()) {
        // Assign usernames to the associative array using UserID as key
        $usernamesByUserId[$rowUsernames['UserID']] = $rowUsernames['Username'];
    }

    // Prepare response with success flag and the associative array of UserIDs and usernames
    $response = [
        'success' => true,
        'usernames' => $usernamesByUserId
    ];

    echo json_encode($response);
} catch (Exception $e) {
    // Handle exceptions
    $errorResponse = ['success' => false, 'error' => $e->getMessage()];
    echo json_encode($errorResponse);
}
?>