php
Copy code
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

    // Check if tripID is provided via POST
    if (!isset($_POST['tripID'])) {
        throw new Exception("Trip ID not provided");
    }

    $userId = $_SESSION['user_id'];
    $tripId = $_POST['tripID'];

    // Step 1: Find UserIDs of trip creators for accepted trips in TripRequests
    $tripCreatorQuery = "SELECT DISTINCT u.UserID, u.Username
                         FROM Users u
                         JOIN Trips t ON u.UserID = t.UserID
                         JOIN TripRequests tr ON t.TripID = tr.TripID
                         WHERE (tr.Status = 'Accepted' OR tr.Status = 'Completed') AND tr.TripID = ?";

    $stmtTripCreator = $con->prepare($tripCreatorQuery);
    $stmtTripCreator->bind_param('i', $tripId);
    $stmtTripCreator->execute();
    $resultTripCreator = $stmtTripCreator->get_result();

    while ($rowTripCreator = $resultTripCreator->fetch_assoc()) {
        $usernamesByUserId[$rowTripCreator['UserID']] = $rowTripCreator['Username'];
    }

    // Step 2: Find UserIDs whose trip requests have been accepted for the specified trip
    $acceptedRequestsQuery = "SELECT DISTINCT u.UserID, u.Username
                              FROM Users u
                              JOIN TripRequests tr ON u.UserID = tr.RequesterUserID
                              WHERE tr.Status = 'Completed' AND tr.TripID = ?";

    $stmtAcceptedRequests = $con->prepare($acceptedRequestsQuery);
    $stmtAcceptedRequests->bind_param('i', $tripId);
    $stmtAcceptedRequests->execute();
    $resultAcceptedRequests = $stmtAcceptedRequests->get_result();

    while ($rowAcceptedRequests = $resultAcceptedRequests->fetch_assoc()) {
        $usernamesByUserId[$rowAcceptedRequests['UserID']] = $rowAcceptedRequests['Username'];
    }

    // Step 3: Find other requesters of the same trip for the specified trip
    $tripRequestersQuery = "SELECT DISTINCT u.UserID, u.Username
                            FROM Users u
                            JOIN TripRequests tr ON u.UserID = tr.RequesterUserID
                            WHERE tr.Status = 'Completed' AND tr.TripID = ? AND tr.RequesterUserID != ?";

    $stmtTripRequesters = $con->prepare($tripRequestersQuery);
    $stmtTripRequesters->bind_param('ii', $tripId, $userId);
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