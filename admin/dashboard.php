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
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            width: 250px;
            height: 100%;
            background-color: #853E3E;
            position: fixed;
            left: 0;
            top: 0;
            overflow-x: hidden;
            padding-top: 100px;
        }

        .sidebar a {
            padding: 15px 15px 30px 15px;
            text-decoration: none;
            font-size: 15px;
            color: #f0f0f0;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background-color: rgba(0, 0, 0, 0.1);
            font-weight: bolder;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

               .hide-sidebar {
            left: -250px; /* Hide sidebar */
        }


        @media (max-width: 768px) {
            .sidebar {
                left: -250px; /* Hide sidebar by default on small screens */
            }
            .content {
                margin-left: 0;
            }
        }


        .card {
            width: 300px;
            height: 200px;
            background-color: #853E3E;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            margin: 20px;
            color: #f0f0f0;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .title {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .subtitle {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .button {
            background-color: #ccc;
            border: none;
            color: #333;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #666;
            color: #f0f0f0;
        }

        .navbar-brand {
            font-size: 25px;
            font-weight: bolder;
            z-index: 9999;
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

    <div class="sidebar" id= 'sidebar'>
        <a href="../admin/dashboard.php">Dashboard</a>
        <a href="../admin/user.php">Users</a>
        <a href="../admin/halls.php">Halls</a>
        <!-- <a href="../admin/announcement.php">Announcements</a> -->
        <!-- <a href="#">Reports</a> -->
        <a href="../admin/request.php">Requests</a>

    </div>

    <div class="content">
        <div class="card">
            <div class="title">Analytics</div>
            <div class="subtitle">Track your website's performance</div>
            <a href="#" class="button">View Analytics</a>
        </div>
        <div class="card">
            <div class="title">Messages</div>
            <div class="subtitle">Manage your inbox</div>
            <a href="#" class="button">View Messages</a>
        </div>
        <div class="card">
            <div class="title">Settings</div>
            <div class="subtitle">Update your account settings</div>
            <a href="#" class="button">View Settings</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered mt-5">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Activity</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Logged in</td>
                        <td>October 15, 2023</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Added new user</td>
                        <td>October 14, 2023</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>Updated settings</td>
                        <td>October 12, 2023</td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>Generated report</td>
                        <td>October 10, 2023</td>
                    </tr>
                    <tr>
                        <th scope="row">5</th>
                        <td>Deleted user</td>
                        <td>October 8, 2023</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('.sidebar').addEventListener('click', function () {
              var sidebar = document.getElementById('sidebar');
              if (sidebar.style.display !== 'none') {
                sidebar.style.display = 'none';
              } 
            });
        }
    </script>
</body>

</html>
