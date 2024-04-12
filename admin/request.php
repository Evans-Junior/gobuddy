<?php
session_start();
if (!isset($_SESSION['role_id'])) {
    header('Location: ../login/logout_view.php?error=unauthorized_user');
    exit();
}
else if($_SESSION['role_id'] != 2 && $_SESSION['role_id'] != 1){
    header('Location: ../login/logout_view.php?error=unauthorized_user');
    exit();
}
include '../functions/get_requests.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa; /* Light gray background */
    margin: 0;
    padding: 0;
}

.navbar-brand {
    font-size: 25px;
    font-weight: bold;
}

.navbar-nav .nav-link {
    margin-right: 15px;
}

.container {
    padding: 20px;
}

.announcement-form {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-top: 50px;
}

.form-group {
    margin-bottom: 20px;
}

.form-control {
    border: 1px solid #ced4da; /* Light gray border */
    border-radius: 5px;
    padding: 10px;
    width: 100%;
}

.select-group {
    display: flex;
    align-items: center;
}

.select-group label {
    margin-right: 10px;
}

.submit-btn {
    background-color: #007bff; /* Blue submit button */
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.submit-btn:hover {
    background-color: #0056b3; /* Darker blue on hover */
}

.back-btn {
    margin-top: 20px;
}

.sidebar {
    margin-top: 4rem;
    width: 280px;
    height: 100%;
    background-color: #343a40; /* Dark sidebar background */
    color: #fff;
    position: fixed;
    right: 0;
    top: 0;
    overflow-x: hidden;
    padding-top: 20px;
    padding-left: 20px;
}

.sidebar a {
    padding: 15px;
    text-decoration: none;
    font-size: 16px;
    color: #fff;
    display: block;
    transition: 0.3s;
}

.sidebar a:hover {
    background-color: #495057; /* Darker background on hover */
}

h1,
h2,
h3,
h4,
h5,
h6 {
    font-weight: bold;
}


    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="../view/home.php">ASBED</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Welcome, <?php
                        echo $_SESSION['username'];
                        ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Profile</a>
                        <a class="dropdown-item" href="#">Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../login/logout_view.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Requests</h2>
        <?php
        // Assuming $requests is an array of requests fetched from the database
        foreach ($requests as $request) {
            // Display each request as a clickable link with subject as title
            echo "<a href='#' onclick='showRequest(" . $request['request_id'] . ")'>" . $request['title'] . "</a>";
        }
        ?>
    </div>

    <div class="container" style="margin-left: 250px;">
        <h1 class="text-center">Request Details</h1>
        <div id="request-details" class="announcement-form">
            <!-- Request details will be dynamically filled here -->
        </div>
        <a href="../admin/dashboard.php" class="btn btn-secondary back-btn">Back</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Function to fetch and display request details when clicked
        function showRequest(requestId) {
    // Make an AJAX request to fetch request details based on requestId
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../functions/fetch_request_details.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Parse the response JSON
            var response = JSON.parse(xhr.responseText);
            // Check if request details were fetched successfully
            if (response.success) {
                // Construct the HTML to display request details
                var isResolved = response.is_resolved==1 ? "Resolved" : "Not Resolved";

                var requestDetailsHTML = "<p><strong>Request Date:</strong> " + response.request_date + "</p>";
                var requestDetailsHTML = "<p><strong id='re_'>Request :</strong> " + isResolved + "</p>";
                requestDetailsHTML += "<p><strong>Requested By:</strong> " + response.username + "</p>";
                // Check if user has a room and include room name if available
                // if (response.room_name) {
                //     requestDetailsHTML += "<p><strong>Room Name:</strong> " + response.room_name + "</p>";
                // }
                requestDetailsHTML += "<p><strong>Message:</strong> " + response.message + "</p>";
                requestDetailsHTML += "<button class='btn-secondary' onclick='unresolveIssue(" + requestId + ")'>Unresolved Issue</button>";
                requestDetailsHTML += "<button class='btn-secondary' onclick='resolveIssue(" + requestId + ")'>Resolve Issue</button>";


                // Display the fetched request details
                document.getElementById("request-details").innerHTML = requestDetailsHTML;
            } else {
                // Display an error message if request details couldn't be fetched
                document.getElementById("request-details").innerHTML = "<p>Error fetching request details.</p>";
            }
        }
    };
    // Send the request ID to the server-side script
    xhr.send("request_id=" + requestId);
}


// Function to resolve the issue
function unresolveIssue(requestId) {
    // Make an AJAX request to update is_resolved in the database
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../functions/unresolved_issue.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Parse the response JSON
            var response = JSON.parse(xhr.responseText);
            // Check if the issue was resolved successfully
            if (response.success) {
                // Update the UI or show a success message
                alert("Issue unresolved successfully!");
                location.reload();

                // Optionally, you can reload the page or perform other actions here
            } else {
                // Display an error message if the issue couldn't be resolved
                alert("Failed to resolve the issue.");
            }
        }
    };
    // Send the request ID to the server-side script
    xhr.send("request_id=" + requestId);
}

// Function to resolve the issue
function resolveIssue(requestId) {
    // Make an AJAX request to update is_resolved in the database
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../functions/resolve_issue.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Parse the response JSON
            var response = JSON.parse(xhr.responseText);
            // Check if the issue was resolved successfully
            if (response.success) {
                // Update the UI or show a success message
                alert("Issue resolved successfully!");
                location.reload();
                // Optionally, you can reload the page or perform other actions here
            } else {
                // Display an error message if the issue couldn't be resolved
                alert("Failed to resolve the issue.");
            }
        }
    };
    // Send the request ID to the server-side script
    xhr.send("request_id=" + requestId);
}



    </script>
</body>

</html>
