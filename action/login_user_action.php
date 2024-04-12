<?php
// Start session
session_start();

// Include the connection file
include_once '../settings/connection.php';

// Check if login button was clicked
if (!isset($_POST['signinBtn'])) {
    // Redirect to login page with appropriate message
    header("Location: ../login_view.php?error=login_button_not_clicked");
    exit();
} else {
    // Collect form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Write a query to SELECT a record from the people table using the email
    $sql = "SELECT * FROM Users WHERE email = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any row was returned
    if ($result->num_rows == 0) {
        // Redirect to login page with appropriate message
        // echo 'user not registered';
        echo '<script type="text/javascript">alert("User not registered."); window.location.href = "../login/login_view.php";</script>';
    } else {
        // Fetch the record
        $row = $result->fetch_assoc();

        // Verify password
        if (!password_verify($password, $row['Password'])) {
            // echo 'incorrect password';
            // Redirect to login page with appropriate message
            echo '<script type="text/javascript">alert("Incorrect password."); window.location.href = "../login/login_view.php";</script>';
        } else {
            // Create session variables
            $_SESSION['user_id'] = $row['UserID'];
            $_SESSION['role_id'] = $row['role_id'];
            $_SESSION['username'] = $row['Username'];
            $_SESSION['email'] = $row['Email'];

            // Redirect to homepage
            // echo 'login successful';
            echo '<script type="text/javascript">alert("Login successful."); window.location.href = "../view/home.php";</script>';
        }
    }
}
?>
