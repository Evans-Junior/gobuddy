<?php
include '../settings/connection.php';

function getTripsWithUserData() {
    global $con;

    $trips = array();

    // Get the user ID from the session
    $userId = $_SESSION['user_id'];

    // Query to fetch trip details with associated user's username
    $selectQuery = "
        SELECT Trips.*, Users.Username 
        FROM Trips
        JOIN Users ON Trips.UserID = Users.UserID
        WHERE (
            (Trips.UserID = $userId AND Trips.TripStatus = 'Completed') -- Trips created by the user
            OR (
                Trips.TripID IN (
                    SELECT TripID 
                    FROM TripRequests
                    WHERE RequesterUserID = $userId 
                    AND Status = 'Completed'
                )
                AND Trips.UserID <> $userId -- Trips where user is a requester and not the creator
            )
        )
        AND TimeCreated < NOW() -- Only consider trips that have passed creation time
        ORDER BY Trips.TripID DESC
    ";

    $result = mysqli_query($con, $selectQuery);

    if ($result) {
        // Fetch data from the result set
        while ($row = mysqli_fetch_assoc($result)) {
            // Add the trip details along with associated username to the trips array
            $tripDetails = array(
                'Destination' => $row['Destination'],
                'Date' => $row['Date'],
                'Location' => $row['Location'],
                'Username' => $row['Username'], // Username from the Users table
                'Start' => $row['Start'],
                'End' => $row['End'],
                'SeatsAvailable' => $row['SeatsAvailable'],
                'UserID' => $row['UserID'],
                'TripID' => $row['TripID']
            );
            $trips[] = $tripDetails;
        }

        // Free result set
        mysqli_free_result($result);
    } else {
        echo "Error: " . mysqli_error($con);
    }

    return $trips;
}

// Example usage:
$trips = getTripsWithUserData();

// echo json_encode($trips);

?>
