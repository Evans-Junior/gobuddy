<?php
session_start();
include '../settings/connection.php';

// Check if tripID and requesterUserID are provided
if (isset($_POST['tripID'])) {
    // Retrieve tripID and requesterUserID from the POST data
    $tripID = $_POST['tripID'];
    $requesterUserID = $_SESSION['user_id'];

    // Prepare the SQL statement with a prepared statement
    $insertQuery = "INSERT INTO TripRequests (TripID, RequesterUserID) VALUES (?, ?)";
    $statement = mysqli_prepare($con, $insertQuery);

    // Bind parameters and execute the statement
    mysqli_stmt_bind_param($statement, "ii", $tripID, $requesterUserID);
    $result = mysqli_stmt_execute($statement);

    if ($result) {
        echo "Trip request sent successfully";
    } else {
        echo "Error: " . mysqli_error($con);
    }

    // Close the prepared statement
    mysqli_stmt_close($statement);
} else {
    echo "Error: Missing tripID";
}

// Close the database connection
mysqli_close($con);
?>