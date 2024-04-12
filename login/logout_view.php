<?php
// Start session
session_start();

// Unset session variables
unset($_SESSION['user_id']);
unset($_SESSION['role_id']);
unset($_SESSION['username']);
unset($_SESSION['email']);


// Redirect to login_view page
header("Location: ../login/login_view.php");
exit();
?>
