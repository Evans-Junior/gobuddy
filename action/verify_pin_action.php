<?php
// Include the connection file
session_start();
include '../settings/connection.php';

// $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

if (isset($_POST['verify_pin'])) {
    // Get the email and PIN from the form
    $email = $_SESSION['email']; // Assuming you have stored the email in a session variable
    $pin =  $_SESSION['pin'];
    $username=$_SESSION['username'];
    $role_id=$_SESSION['role_id'];
    $hashed_password=$_SESSION['hashed_password'];
    $bio=$_SESSION['bio'];
    echo "Hey there". $bio;
    echo $email;
    echo "I am here";

    //


    // Prepare and execute the SQL query to check if the email and PIN exist in the VerifiablePins table
    $query = "SELECT * FROM VerifiablePins WHERE email = '$email' AND pin = '$pin'";
    $result = $con->query($query);

    // Check if a row is returned
    if ($result->num_rows > 0) {
        echo "  Pin exists";
        // For demonstration purposes, let's just echo a success message
        // Execute the query
        $query = "INSERT INTO Users (user_id, username, password, email, role_id,has_room,bio) VALUES(0, '$username', '$hashed_password', '$email', '$role_id',0,'$bio')";
        $result = $con->query($query); 
        if ($con->query($query) === TRUE) {
            // Redirect to login page on successful registration
            echo "New record created successfully";
            header("Location: ../login/login_view.php?registration=success");
            exit();
        }else {
            // Display error message on register page
            echo "Error: " . $query . "<br>" . $con->error;
        }
    } else {       
        // For demonstration purposes, let's just echo an error message
        header("Location: ../login/register_view.php?``registration``=failed");
        exit();
    }
} else {
    // PIN is not set, do something (e.g., redirect to an error page)
    // For demonstration purposes, let's just echo an error message
    // echo "PIN is not set. Please try again.";
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Verification</title>
</head>
<body>

    <script type="text/javascript">
        setTimeout(function() {
            // Use AJAX to make a request to execute_after_delay.php after 2 minutes
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "../functions/clear_data.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.responseText); // Log the response from execute_after_delay.php
                }
            };
            xhr.send();
        }, 120000); // 2 minutes in milliseconds
    </script>

</body>
</html>