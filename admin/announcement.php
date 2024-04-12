<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcement Page</title>
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

        .navbar-nav .nav-link {
            margin-right: 15px;
        }

        .container {
            padding: 20px;
        }

        .announcement-form {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            margin-top: 50px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            border: 1px solid #ccc;
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
            background-color: #853E3E;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #6d2c2c;
        }

        .back-btn {
            margin-top: 20px;
        }

        /* Sidebar styles */
        .sidebar {
            margin-top: 4rem;
            width: 280px;
            height: 100%;
            background-color: #6d2c2c;
            color: white;
            position: fixed;
            right: 0;
            top: 0;
            overflow-x: hidden;
            padding-top: 20px;
            padding-left: 20px;
        }

        .sidebar a {
            padding: 30px 10px 10px 10px;
            text-decoration: none;
            font-size: 16px;
            color: #f0f0f0;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background-color: #ccc;
            color: black;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="../view/homepage.php">ASBED</a>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"><?php echo "Welcome, " . $_SESSION['username']; ?></a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Announcements</h2>
        <!-- Add your list of announcements here -->
        <a href="#">Announcement title 1</a>
        <a href="#">Announcement title 2</a>
        <a href="#">Announcement title 3</a>
        <!-- Add more announcements as needed -->
    </div>

    <div class="container" style="margin-left: 250px;">
        <h1 class="text-center">Announcement Page</h1>
        <div class="announcement-form">
            <form action="#" class="form">
                <div class="form-group">
                    <div class="select-group">
                        <label for="target">Send To:</label>
                        <select id="role" name="role_id[]" style='width:100%;' multiple required>
        <?php foreach ($roles as $role): ?>
            <option value="<?php echo $role['role_id']; ?>"><?php echo $role['role_name']; ?></option>
        <?php endforeach; ?>
    </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="message">Announcement Message:</label>
                    <textarea id="message" name="message" class="form-control" rows="5"></textarea>
                </div>
                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </div>
        <a href="../admin/dashboard.php" class="btn btn-secondary back-btn">Back</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
