<?php
// Include the connection file
session_start();
include '../settings/connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email and PIN from the form
    $email = $_SESSION['email'];
    $pin = $_POST['pin'] ;
    $username = $_SESSION['username'];
    $phone = $_SESSION['phone'];
    $hashed_password = $_SESSION['hashed_password'];
    $bio = $_SESSION['bio'];

        // Encrypt password
    // Prepare and execute the SQL query to check if the email and PIN exist in the VerifiablePins table
    $query = "SELECT * FROM VerifiablePins WHERE email = '$email' AND pin = '$pin'";
    $result = $con->query($query);

    // Check if a row is returned
    if ($result->num_rows > 0) {
        // For demonstration purposes, let's just echo a success message
        echo "Verification successful!";
        
        // Execute the query to insert user data into the Users table
        $query = "INSERT INTO Users (role_id, Username, Password, Email, PhoneNumber,Bio) VALUES (2, '$username', '$hashed_password', '$email', '$phone','$bio')";
        if ($con->query($query) === TRUE) {
            // Redirect to login page on successful registration
            echo "New record created successfully";
            header("Location: ../login/login_view.php");
            exit();
        } else {
            // Display error message on register page
            echo "Error: " . $query . "<br>" . $con->error;
        }
    } else {       
        // For demonstration purposes, let's just echo an error message
        echo "Invalid verification PIN. Please try again.";
        header("Location: ../login/register_view.php");
        exit();
    }
} else {
    // PIN is not set, do something (e.g., redirect to an error page)
    // For demonstration purposes, let's just echo an error message
    // echo "PIN is not set. Please try again.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification</title>
    <link rel="stylesheet" href="../css/verify.css">
</head>
<body>
    <div class="navbar">
        <div class="logo">GoBuddy</div>
    </div>
    <div class="wrapper">
        <h1>Verify PIN</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="input-group">
                <label for="pin">Verification PIN</label>
                <input type="text" id="pin" name="pin" required>
            </div>
            <button type="submit" name="verify_pin">Verify</button>
        </form>
    </div>

    <script type="text/javascript">
        function setTimer() {
            setTimeout(function() {
                // Use AJAX to make a request to clear_data.php after 2 minutes
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "../functions/clear_data.php", true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        console.log(xhr.responseText); // Log the response from clear_data.php
                    }
                };
                xhr.send();
            }, 120000); // 2 minutes in milliseconds
        }

        // Call the setTimer function when the page loads
        window.onload = function() {
            setTimer();
        };
    </script>
</body>
</html>
