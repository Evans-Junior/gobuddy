<?php
session_start();
include '../settings/connection.php';

// Check if user_id is set in the session
if (isset($_SESSION['user_id'])) {
    // Get the user ID from the session
    $currentUserId = $_SESSION['user_id'];

    // Get the user ID to fetch messages for (e.g., from AJAX request)
    $targetUserId = isset($_POST['userId']) ? intval($_POST['userId']) : null;

    // if ($targetUserId !== null) {
        // Prepare and execute the SQL query to fetch messages between the users
        $query = "SELECT message, created_at, sendersID 
                  FROM messages 
                  WHERE (sendersID = ? AND receiversID = ?) 
                     OR (sendersID = ? AND receiversID = ?) 
                  ORDER BY created_at";

        $stmt = $con->prepare($query);
        $stmt->bind_param('iiii', $currentUserId, $targetUserId, $targetUserId, $currentUserId);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            $messages = [];
            while ($row = $result->fetch_assoc()) {
                // Store message details in an array
                $message = [
                    'message' => $row['message'],
                    'created_at' => $row['created_at'],
                    'sendersID' => $row['sendersID']
                ];
                $messages[] = $message;
            }

            // Prepare response as JSON
            $response = [
                'success' => true,
                'messages' => $messages
            ];

            echo json_encode($response);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error executing SQL query']);
        }
    // }
    //  else {
    //     echo json_encode(['success' => false, 'error' => 'Invalid target user ID']);
    // }
} else {
    echo json_encode(['success' => false, 'error' => 'User session not found']);
}
?>
