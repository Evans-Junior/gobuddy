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
    $usernamesQuery = "SELECT DISTINCT u.UserID AS RequesterUserID, u.Username AS RequesterUsername, 
        t.UserID AS TripUserID, t.Username AS TripUsername
    FROM Users u
    JOIN TripRequests tr ON u.UserID = tr.RequesterUserID
    JOIN Trips t ON tr.TripID = t.TripID
    WHERE tr.Status IN ('Accepted', 'Completed', 'Deleted') AND tr.TripID IN (".implode(",", $tripIds).")";
    $stmtUsernames = $con->prepare($usernamesQuery);
    $stmtUsernames->execute();
    $resultUsernames = $stmtUsernames->get_result();
    

    while ($rowUsernames = $resultUsernames->fetch_assoc()) {
        // Check if TripUserID is not equal to the session user ID
        if ($rowUsernames['TripUserID'] != $_SESSION['user_id']) {
            // Add TripUserID and its corresponding username to the array
            $usernamesByUserId[$rowUsernames['TripUserID']] = $rowUsernames['TripUsername'];
        }
        // Add RequesterUserID and its corresponding username to the array
        $usernamesByUserId[$rowUsernames['RequesterUserID']] = $rowUsernames['RequesterUsername'];
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