<?php
// Assuming you have established a database connection
include '../settings/connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $destination = $_POST["tripName"];
    $location = $_POST["location"];
    $date = date('Y-m-d', strtotime($_POST["date"])); // Format date as YYYY-MM-DD
    $start = $_POST["begin"];
    $end = $_POST["end"];
    $seatsAvailable = $_POST["seats"];

    // Combine date and time parts into a single datetime value
    $startDateTime = $date . ' ' . $start;
    $endDateTime = $date . ' ' . $end;
    $userID = $_SESSION['user_id'];
    $query = "INSERT INTO Trips (UserID, Destination, Location, Date, Start, End, SeatsAvailable)
              VALUES ('$userID', '$destination', '$location', '$date', '$startDateTime', '$endDateTime', '$seatsAvailable')";

    if (mysqli_query($con, $query)) {
        echo "Trip information inserted successfully.";
    } else {
        echo "Error inserting trip information: " . mysqli_error($con);
    }

    // Close the database connection
    mysqli_close($con);
}
?>