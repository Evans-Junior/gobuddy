<?php
include '../settings/connection.php';

function getUserInfo($userID, $con) {
    // Initialize an array to store the user information
    $userInfo = array();

    // SQL query to retrieve Username, Bio, and Stars of the user
    $query = "SELECT Username, Bio, Stars FROM Users WHERE UserID = $userID";

    // Execute the query
    $result = mysqli_query($con, $query);

    // Check if the query was successful
    if ($result) {
        // Fetch the row containing the user information
        $row = mysqli_fetch_assoc($result);

        // Add the Username, Bio, and Stars to the userInfo array
        $userInfo['Username'] = $row['Username'];
        $userInfo['Bio'] = $row['Bio'];
        $userInfo['Stars'] = $row['Stars'];

        // Return the user information as JSON
        echo json_encode($userInfo);
    } else {
        // Handle the case where the query fails
        echo json_encode(array('error' => 'Failed to fetch user information'));
    }
}

// Check if the userID is provided in the request
if (isset($_GET['userID'])) {
    // Retrieve the userID from the request
    $userID = $_GET['userID'];

    // Call the getUserInfo function to fetch user information
    getUserInfo($userID, $con);
} else {
    // Handle the case where userID is not provided in the request
    echo json_encode(array('error' => 'UserID is not provided'));
}

// Close the database connection
mysqli_close($con);
?>