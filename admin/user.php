<?php
 session_start();
    include '../functions/select_role_fxn.php';
    include '../functions/get_all_users.php';

    if (!isset($_SESSION['role_id'])) {
        header('Location: ../login/logout_view.php?error=unauthorized_user');
        exit();
    }
    else if($_SESSION['role_id'] != 2 && $_SESSION['role_id'] != 1){
        header('Location: ../login/logout_view.php?error=unauthorized_user');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Dashboard</title>
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
        }

        .table-responsive {
            margin-top: 20px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .radio-group label {
            margin-right: 20px;
        }

        .radio-group input[type="radio"] {
            margin-right: 5px;
        }

        .radio-group label {
            color: #333;
        }

        .radio-group input[type="radio"]:checked + label {
            color: #853E3E;
            font-weight: bold;
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

        .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1000; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0,0,0,0.5); /* Black background with opacity */
  }

  /* Modal Content/Box */
  .modal-content {
    background-color: #fefefe;
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 80%; /* Could be more or less, depending on screen size */
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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
                           echo $_SESSION['username']
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
                <a href="../login/register_view.php" class="btn btn-secondary"> Create Admin Account</a>

        </div>
        <div class="row mb-3">
            <div class="col-md-6 offset-md-3">
                <form action='#' class="search-form">
                    <input type="text" class="form-control search-input" placeholder="Search for a user">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
        <h2 class="mt-4">User Management</h2>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Add New User</h5>
                <form id="addUserForm"> 
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control"  id="email"  name="email">
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <div class="radio-group">
                        <?php foreach ($roles as $role): ?>
                            <?php if (strtolower($role['role_name']) !== 'student'): ?>
                                <?php if ($_SESSION['role_id'] === 1 ): ?>
                                    <input type="radio" id="role-<?php echo strtolower($role['role_name']); ?>" name="role_id" value="<?php echo $role['role_id']; ?>">
                                    <label for="role-<?php echo strtolower($role['role_name']); ?>"><?php echo $role['role_name']; ?></label>
                                <?php endif; ?>
                                <?php if ($_SESSION['role_id'] === 2 && strtolower($role['role_name']) !== 'admin'): ?>
                                    <input type="radio" id="role-<?php echo strtolower($role['role_name']); ?>" name="role_id" value="<?php echo $role['role_id']; ?>">
                                    <label for="role-<?php echo strtolower($role['role_name']); ?>"><?php echo $role['role_name']; ?></label>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <button type="submit" class="btn btn-primary">Add User</button>
                </form>
            </div>
        </div>

        <div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Edit UserName</h2>
    <form id="editChoreForm" method="POST" action="../action/edit_Username_actions.php">
      <label for="editNameLabel">Name:</label>
      <input type="text" id="editName" name="userName" placeholder="Enter users' name" required pattern="[a-zA-Z\s]+">
      <input type="hidden" id="editUserId" name="userId">
      <button type="submit" name="editNameBtn">Save</button>
    </form>
  </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">User List</h5>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                    <?php if (strtolower($_SESSION['role_id']) == 1): ?>

                        <th>#</th>
                        <?php endif; ?>

                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id='choreTable'>
                    <!-- Loop through the fetched users and display them -->
                    <?php if (strtolower($_SESSION['role_id']) == 1): ?>
                    <?php 
                    if (is_array($users) && !empty($users)): ?>
                        <?php foreach ($users as $index => $us): ?>
                            <tr id="<?php echo $index + 1; ?>">
                                <td><?php echo $index + 1;; ?></td>
                                <td><?php echo $us['username']; ?></td>
                                <td><?php echo $us['email']; ?></td>
                                <td>
                                <?php 
                                    if ($us['role_id'] == 1) {
                                        echo 'Admin';
                                    } elseif ($us['role_id'] == 2) {
                                        echo 'Manager';
                                    } else {
                                        echo 'Student';
                                    }
                                    ?>    
                                </td>
                                <td class="actions">
                                    <button class="btn btn-success btn-sm" onclick="openEditPopup(<?php echo $us['user_id']; ?>, '<?php echo $us['username']; ?>')">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteUser(<?php echo $us['user_id']; ?>,'<?php echo $us['role_id']; ?>','<?php echo $us['email']; ?>',<?php echo $index + 1; ?>)">Delete</button>
                                </td>
                            </tr>
                            
                        <?php

                    endforeach; ?>
                        
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No users found.</td>
                        </tr>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php if (strtolower($_SESSION['role_id']) == 2): ?>
                    <?php 
                    if (is_array($users) && !empty($users)): ?>
                        <?php foreach ($users as $index => $us): ?>
                            <?php if ($us['role_id'] == 3): ?> <!-- Add this condition -->
                                <tr id="<?php echo $index + 1; ?>">
                                <?php if (strtolower($_SESSION['role_id']) == 1): ?>

                                    <td><?php echo $index + 1; ?></td>
                                    <?php endif; ?>

                                    <td><?php echo $us['username']; ?></td>
                                    <td><?php echo $us['email']; ?></td>
                                    <td>
                                        <?php 
                                        if ($us['role_id'] == 1) {
                                            echo 'Admin';
                                        } elseif ($us['role_id'] == 2) {
                                            echo 'Manager';
                                        } else {
                                            echo 'Student';
                                        }
                                        ?>    
                                    </td>
                                    <td class="actions">
                                        <button class="btn btn-success btn-sm" onclick="openEditPopup(<?php echo $us['user_id']; ?>, '<?php echo $us['username']; ?>')">Edit</button>
                                        <button class="btn btn-danger btn-sm" onclick="deleteUser(<?php echo $us['user_id']; ?>,'<?php echo $us['role_id']; ?>','<?php echo $us['email']; ?>',<?php echo $index + 1; ?>)">Delete</button>
                                    </td>
                                </tr>
                            <?php endif; ?> <!-- End of condition -->
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No users found.</td>
                        </tr>
                    <?php endif; ?>
                <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Wait for the document to load
    $(document).ready(function() {
        // Attach an event listener to the form submission
        $('#addUserForm').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Serialize the form data
            var formData = $(this).serialize();
            
            // Send an AJAX request
            $.ajax({
                type: 'POST',
                url: '../action/add_user_action.php',
                data: formData,
                success: function(response) {
                    // Check if the response contains 'successfully added'
                    if (response.includes('successfully added')) {
                        alert('User successfully added');
                    } else {
                        alert('Failed to add user');
                    }
                },
                error: function() {
                    alert('Error occurred while processing the request');
                }
            });
        });
    });


    
function openEditPopup(userId, userName) {
    document.getElementById('editUserId').value = userId;
    document.getElementById('editName').value = userName;
    // Display the modal
    document.getElementById('myModal').style.display = 'block';
}

// Function to close the modal
function closeEditPopup() {
    // Hide the modal
    document.getElementById('myModal').style.display = 'none';
}

// Close the modal when the close button is clicked
document.getElementsByClassName('close')[0].addEventListener('click', closeEditPopup);

// Close the modal when clicking outside the modal content
window.onclick = function(event) {
    var modal = document.getElementById('myModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

function deleteUser(userId, roleId, email,c) {
    // AJAX request to delete_user_actions.php or appropriate backend endpoint
    $.ajax({
        type: "POST",
        url: "../action/delete_user_actions.php",
        data: { userId: userId, role_id: roleId, email: email },
        success: function(response) {
            // Check if the response is 'success'
            if (response.trim() == 'success') {
                // Remove the row from the table
                $('#' + c).remove();
                alert("User deleted successfully.");
            } else {
                // Display an error message
                alert("Failed to delete user.");
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert("An error occurred while deleting the user.");
        }
    });
}


    </script>


</script>

</body>

</html>
