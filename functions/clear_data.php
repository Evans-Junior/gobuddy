<?php
// Include the connection file
// session_start();
include '../settings/connection.php';

function deleteExpiredPins() {

    global $con;

    // Calculate the timestamp 5 minutes ago
    // $expiryTimestamp = date('Y-m-d H:i:s', strtotime('-6 minutes'));

    // Prepare and execute the SQL query to delete expired pins
    $query = "DELETE FROM VerifiablePins WHERE email = '{$_SESSION['email']}'";
    $result = $con->query($query);

    if ($result === TRUE) {
        echo "<script type='text/javascript'>console.log('Expired pins have been successfully deleted.')</script>";
    } else {
        echo "Error deleting expired pins: " . $con->error;
    }
}

// Call the function to delete expired pins
deleteExpiredPins();

$con->close();
?>
