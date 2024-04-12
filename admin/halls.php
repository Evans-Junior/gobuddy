<?php
// Start session
session_start();
if (!isset($_SESSION['role_id'])) {
    header('Location: ../login/logout_view.php?error=unauthorized_user');
    exit();
}
else if($_SESSION['role_id'] != 2 && $_SESSION['role_id'] != 1){
    header('Location: ../login/logout_view.php?error=unauthorized_user');
    exit();
}
// get all halls
include '../functions/get_halls_fxn.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halls Management - Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .navbar-brand {
            font-size: 25px;
            font-weight: bolder;
        }

        .container {
            padding: 20px;
        }

        .card {
            margin-bottom: 20px;
            padding: 20px;
        }

        .table-responsive {
            margin-top: 20px;
        }
        .search-form {
            display: flex;
            align-items: center;
        }

        .search-input {
            flex: 1;
            margin-right: 10px;
        }

        @media (max-width: 576px) {
            .search-form {
                flex-direction: column;
                align-items: stretch;
            }

            .search-input {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="position: sticky;">
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

    <div class="container">
        <div class="mt-3 mb-3">
            <a href="../admin/dashboard.php" class="btn btn-secondary">< Back</a>
        </div>
        <div class="row mb-3">
            <div class="col-md-6 offset-md-3">
                <form class="search-form">
                    <input type="text" class="form-control search-input" placeholder="Search for a hall or a room">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
        <h2 class="mt-4 text-center">Halls Management</h2>

        <?php if (strtolower($_SESSION['role_id']) == 1): ?>

        <div class="card">
            <h4>Add New Hall</h4>
            <form action="../action/add_hall_action.php" method="POST">
                <div class="form-group">
                    <label for="hallName">Hall Name:</label>
                    <input type="text" class="form-control" id="hallName" name='hallName' placeholder="Enter hall name">
                </div>
                <div class="form-group">
                    <label for="capacity">Capacity:</label>
                    <input type="number" class="form-control" id="capacity" name="capacity" placeholder="Enter capacity">
                </div>

                <div class="form-group">
                        <label for="role">Role</label>
                        <div class="radio-group">
                            <input type="radio" id="onCampus" name="location" value="onCampus">
                            <label for="onCampus">On Campus</label>
                            <input type="radio" id="offCampus" name="location" value="offCampus">
                            <label for="offCampus">Off Campus</label>
                    </div>
                <button type="submit" class="btn btn-primary">Add Hall</button>
            </form>
        </div>
        <?php endif; ?>
        <div class="card">
    <h4 style="text-align: center;">Manage Halls</h4>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Hall Name</th>
                    <th>Capacity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through each hall and populate table rows
                foreach ($hallData as $hall) {
                    echo "<tr>";
                    echo "<td>" . $hall['hall_name'] . "</td>";
                    echo "<td>" . $hall['capacity'] . "</td>";
                    echo "<td>";
                    echo "<a class='btn btn-sm btn-primary btn-edit' style='margin-right:20px' href='hall.php?hall_name=" . urlencode($hall['hall_name']) . "&capacity=" . urlencode($hall['capacity']) . "'>Edit</a>";
                    if (strtolower($_SESSION['role_id']) == 1):
                    echo "<a class='btn btn-sm btn-danger' href='../action/delete_hall_action.php?hall_name=" . urlencode($hall['hall_name']) . "&capacity=" . urlencode($hall['capacity']) . "'>Delete</a>";
                    endif;
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Room Modal -->
<div class="modal fade" id="addRoomModal" tabindex="-1" role="dialog" aria-labelledby="addRoomModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRoomModalLabel">Add Room</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addRoomForm">
                    <div class="form-group">
                        <label for="roomNumber">Room Number:</label>
                        <input type="text" class="form-control" id="roomNumber" placeholder="Enter room number" required>
                    </div>
                    <!-- Add more input fields for other details -->
                    <div class="form-group">
                        <label for="capacity">Capacity:</label>
                        <input type="number" class="form-control" id="capacity" placeholder="Enter capacity" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Room</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // JavaScript to handle form submission
    document.getElementById('addRoomForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission
        // Here you can add code to handle the form submission, such as sending data to the server
        // You can access form fields using document.getElementById('roomNumber').value, etc.
        // After successful submission, you can close the modal using $('#addRoomModal').modal('hide');
        // Example:
        // $('#addRoomModal').modal('hide');
    });
</script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<script>

</script>


</html>
