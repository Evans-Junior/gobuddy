<?php
session_start();
include '../settings/connection.php';

// Check if the required POST data is present
if (isset($_POST['sendersID'], $_POST['receiversID'], $_POST['message'])) {
    $sendersID = $_POST['sendersID'];
    $receiversID = $_POST['receiversID'];
    $message = $_POST['message'];

    // Prepare and execute SQL query to insert the message into the messages table
    $insertQuery = "INSERT INTO messages (sendersID, receiversID, message) VALUES (?, ?, ?)";
    $stmt = $con->prepare($insertQuery);
    $stmt->bind_param('iis', $sendersID, $receiversID, $message);

    if ($stmt->execute()) {
        // Message inserted successfully
        $response = ['success' => true];
    } else {
        // Failed to insert message
        $response = ['success' => false, 'error' => 'Failed to insert message into database'];
    }
} else {
    // Required POST data is missing
    $response = ['success' => false, 'error' => 'Missing required data'];
}

header('Content-Type: application/json');
echo json_encode($response);
?>