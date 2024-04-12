<?php
// Start session
session_start();
// Include the connection file
include_once '../settings/connection.php';

// Function to check for login and session expiration
function checkLogin() {
    // Check if user ID session exists
    if (!isset($_SESSION['user_id'])) {
        // If it doesn't exist, redirect to login_view page
        header("Location: ../view/index.html");
        // Terminate script execution after redirection
        die();
    } else {
        // Check the time when the session was last accessed
        $currentTime = time();
        $lastActivityTime = isset($_SESSION['last_activity']) ? $_SESSION['last_activity'] : 0;
        $elapsedTime = $currentTime - $lastActivityTime;
        
        // If the session has been inactive for more than a minute (60 seconds), redirect to welcome page
        if ($elapsedTime >= 60) { // Change 60 to the desired number of seconds
            // Redirect to the login page  
            header("Location: ../view/home.php");
            // Terminate script execution after redirection
            die();
        } else {
            // Update the last activity time to the current time
            $_SESSION['last_activity'] = $currentTime;
            header("Location: ../view/index.html");
            die();
        }
    }
}

// Call the function to check for login and session expiration
checkLogin();
?>
