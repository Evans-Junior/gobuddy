<?php
// Include database connection code (assuming you have a db_connect.php file)
include '../settings/connection.php';

$sql = "SELECT 
TripRequests.RequestID, 
TripRequests.TimeCreated, 
TripRequests.Status,
Trips.Destination, 
Trips.Location, 
Trips.Date, 
Trips.Start, 
RequesterUser.Username AS RequesterName,
TripOwnerUser.Username AS TripOwnerName,
TripRequests.RequesterUserID,
Trips.UserID AS TripOwnerID
FROM 
TripRequests
JOIN 
Trips ON TripRequests.TripID = Trips.TripID
JOIN 
Users AS RequesterUser ON TripRequests.RequesterUserID = RequesterUser.UserID
JOIN 
Users AS TripOwnerUser ON Trips.UserID = TripOwnerUser.UserID
WHERE 
TripRequests.TimeCreated < NOW() 
AND Trips.TripStatus = 'Active' and (TripRequests.Status = 'Pending' or TripRequests.Status = 'Rejected' or TripRequests.Status = 'Accepted' )
ORDER BY 
TripRequests.TimeCreated DESC;" ;

$result = mysqli_query($con, $sql);

$tripRequests = array();
while ($row = mysqli_fetch_assoc($result)) { 
    $tripRequests[] = $row;
}

// Close database connection
mysqli_close($con);



// Output trip request data as JSON
header('Content-Type: application/json');
echo json_encode($tripRequests);
?>
