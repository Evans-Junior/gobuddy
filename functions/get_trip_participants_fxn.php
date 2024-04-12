<?php
include '../settings/connection.php';

function getTripParticipants($tripID, $con) {
    // Initialize an empty array to store the participants
    $participants = [];

    // SQL query to retrieve UserID from the Trips table
    $tripQuery = "SELECT UserID FROM Trips WHERE TripID = $tripID";
    $tripResult = mysqli_query($con, $tripQuery);

    if ($tripResult) {
        // Fetch the UserID from the Trips table
        $tripRow = mysqli_fetch_assoc($tripResult);
        $adminUserID = $tripRow['UserID']; // UserID from the Trips table (admin of the trip)

        // Add the admin UserID to the participants array
        $participants[] = $adminUserID;

        // SQL query to retrieve RequesterUserID from the TripRequests table
        $requestQuery = "SELECT RequesterUserID FROM TripRequests WHERE TripID = $tripID AND Status = 'Accepted'";
        $requestResult = mysqli_query($con, $requestQuery);

        if ($requestResult) {
            // Fetch all RequesterUserIDs from the TripRequests table and add them to the participants array
            while ($row = mysqli_fetch_assoc($requestResult)) {
                $participants[] = $row['RequesterUserID'];
            }
        } else {
            echo "Error: " . mysqli_error($con);
        }
    } else {
        echo "Error: " . mysqli_error($con);
    }

    return $participants;
}

// Example usage:
$tripID = 1; // Specify the TripID for which you want to get the participants
$participants = getTripParticipants($tripID, $conn); // $con is your database con

// Now $participants will conntain an array of UserIDs representing the participants of the trip
print_r($participants);

?>
