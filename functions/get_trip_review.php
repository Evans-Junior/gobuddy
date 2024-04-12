<?php
include '../settings/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['userID'])) {
    $userID = $_GET['userID'];

    // Query to fetch user reviews
    $query = "
        SELECT tr.ReviewID, tr.ReviewerUserID, u.Username AS ReviewerName, tr.ReviewText, tr.ReviewDate
        FROM TripReviews tr
        JOIN Users u ON tr.ReviewerUserID = u.UserID
        WHERE tr.ReviewedUserID = ?
    ";

    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    $reviews = [];

    while ($row = $result->fetch_assoc()) {
        $reviews[] = [
            'ReviewID' => $row['ReviewID'],
            'ReviewerName' => $row['ReviewerName'],
            'ReviewText' => $row['ReviewText'],
            'ReviewDate' => $row['ReviewDate']
        ];
    }

    echo json_encode(['reviews' => $reviews]);
} else {
    // Invalid request
    echo json_encode(['error' => 'Invalid request']);
}
?>