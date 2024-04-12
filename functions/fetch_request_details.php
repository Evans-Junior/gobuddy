<?php
// Include the connection file
include '../settings/connection.php';

// Check if the request ID is set and valid
if (isset($_POST['request_id']) && is_numeric($_POST['request_id'])) {
    // Sanitize the input to prevent SQL injection
    $requestId = mysqli_real_escape_string($con, $_POST['request_id']);
    
    // Query to fetch request details from the database
    $query = "SELECT r.request_date, r.request_text,r.is_resolved, r.student_id, u.username,u.has_room 
              FROM Requests r
              INNER JOIN Users u ON r.student_id = u.user_id
              WHERE r.request_id = $requestId";
    $result = mysqli_query($con, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the request details
        $row = mysqli_fetch_assoc($result);
        // Prepare the response data
        $response = array(
            'success' => true,
            'request_date' => $row['request_date'],
            'message' => $row['request_text'],
            'username' => $row['username'],
            'is_resolved' => $row['is_resolved']
        );
    } else {
        // If the query fails or no rows returned, prepare an error response
        $response = array(
            'success' => false
        );
    }
} else {
    // If request ID is not set or invalid, prepare an error response
    $response = array(
        'success' => false
    );
}

// Send the response as JSON
echo json_encode($response);
?>
