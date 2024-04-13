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

    // Step 1: Find UserIDs of trip creators for accepted trips in TripRequests
    $tripCreatorQuery = "SELECT DISTINCT u.UserID, u.Username
                         FROM Users u
                         JOIN Trips t ON u.UserID = t.UserID
                         JOIN TripRequests tr ON t.TripID = tr.TripID
                         WHERE  tr.Status = 'Accepted' or tr.Status = 'Completed'";

    $stmtTripCreator = $con->prepare($tripCreatorQuery);
    $stmtTripCreator->execute();
    $resultTripCreator = $stmtTripCreator->get_result();

    while ($rowTripCreator = $resultTripCreator->fetch_assoc()) {
        $usernamesByUserId[$rowTripCreator['UserID']] = $rowTripCreator['Username'];
    }

    // Step 2: Find UserIDs whose trip requests have been accepted by the session user
    $acceptedRequestsQuery = "SELECT DISTINCT u.UserID, u.Username
                              FROM Users u
                              JOIN TripRequests tr ON u.UserID = tr.RequesterUserID
                              WHERE tr.Status = 'Completed' AND tr.TripID IN (
                                  SELECT t.TripID
                                  FROM Trips t
                                  WHERE t.UserID = ?
                              )";

    $stmtAcceptedRequests = $con->prepare($acceptedRequestsQuery);
    $stmtAcceptedRequests->bind_param('i', $userId);
    $stmtAcceptedRequests->execute();
    $resultAcceptedRequests = $stmtAcceptedRequests->get_result();

    while ($rowAcceptedRequests = $resultAcceptedRequests->fetch_assoc()) {
        $usernamesByUserId[$rowAcceptedRequests['UserID']] = $rowAcceptedRequests['Username'];
    }

    // Step 3: Find other requesters of the same trip for the session user
    $tripRequestersQuery = "SELECT DISTINCT u.UserID, u.Username
                            FROM Users u
                            JOIN TripRequests tr ON u.UserID = tr.RequesterUserID
                            WHERE tr.Status = 'Completed' AND tr.TripID IN (
                                SELECT tr2.TripID
                                FROM TripRequests tr2
                                WHERE tr2.RequesterUserID = ?
                            )";

    $stmtTripRequesters = $con->prepare($tripRequestersQuery);
    $stmtTripRequesters->bind_param('i', $userId);
    $stmtTripRequesters->execute();
    $resultTripRequesters = $stmtTripRequesters->get_result();

    while ($rowTripRequester = $resultTripRequesters->fetch_assoc()) {
        $usernamesByUserId[$rowTripRequester['UserID']] = $rowTripRequester['Username'];
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