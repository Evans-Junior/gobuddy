<?php
// Include the necessary files and functions
include '../settings/connection.php';
include '../functions/get_hall_id_fxn.php';
include '../functions/get_students_without_rooms.php';
include '../functions/get_students_with_rooms.php';
session_start();
if(!isset($_GET['hall_name']) || !isset($_GET['capacity'])){
    $_GET['hall_name']=$_SESSION['hall_name'];
     $_GET['capacity']=$_SESSION['capacity'];
}else{
    $_SESSION['hall_name'] = $_GET['hall_name'];
    $_SESSION['capacity'] = $_GET['capacity'];
}

$hall_id=search_hall_id( $_GET['hall_name'],  $_GET['capacity']);
include '../functions/get_all_rooms.php';
include '../functions/get_rooms_from_halls.php';
// $roomMates
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Hall Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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

        h1, h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .btn-back {
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            color: #333;
        }

        input[type="text"],
        input[type="number"] {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            width: 100%;
        }

        button[type="submit"] {
            background-color: #853E3E;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #6d2c2c;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            color: #333;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-text {
            color: #666;
            margin-bottom: 15px;
        }

        .btn-edit {
            background-color: #853E3E;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 8px 15px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-edit:hover {
            background-color: #6d2c2c;
        }

        .btn-add-room {
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-add-room:hover {
            background-color: #666;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="../view/home.php">
            <!-- <img src="asbed_logo.png" width="30" height="30" class="d-inline-block align-top" alt=""> -->
            ASBED
        </a>
        
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
        <h1>Edit <?php
            echo $_GET['hall_name'];
        ?></h1>
        <div class="btn-back d-flex justify-content-between">
            <a href="../admin/halls.php" class="btn btn-secondary">Back</a>
            <?php if (strtolower($_SESSION['role_id']) == 1): ?>
            <button class="btn btn-success btn-add-room" id='btn-add-room'>Add New Room</button>
            <a href="../action/delete_all_rooms_actions.php?hall_id=<?php echo urlencode($hall_id); ?>" class="btn btn-success btn-add-room" >Delete All Rooms</a>
            <a href="../action/delete_all_students_from_rooms_action.php" class="btn btn-danger btn-rm-students-to-room" id='btn-add-room'>Remove Students</a>
            <?php endif; ?>
            <button class="btn btn-danger btn-rm-student-fm-room" id='btn-rm-student-fm-room'>Remove Student</button>
            <a class="btn btn-success btn-add-student-to-room" id='btn-add-student-to-room'>Give Out Room</a>
        </div>
        <?php if (strtolower($_SESSION['role_id']) == 1): ?>
        <form action="../action/update_hall_action.php" method="post">
            <div class="form-group">
                <label for="hallName">Hall Name:</label>
                <input type="text" class="form-control" id="hallName" name="hallName" placeholder="Enter new hall name">
            </div>
            <div class="form-group">
                <label for="capacity">Capacity:</label>
                <input type="hidden" name="hall_id" value="<?php echo $hall_id; ?>">
                <input type="number" class="form-control" id="capacity" name="capacity" placeholder="Enter new capacity">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
        <?php endif; ?>
        <h2 style='margin-top:50px'>All Rooms</h2>
        <div class="row justify-content-center flex-wrap">
            <?php
            // Check if there are rooms available
            if (!empty($rooms)) {
                // Loop through each room and display as card
                foreach ($rooms as $room) {
            ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-title"><?php echo $room['room_name']; ?></h5>
                                <p class="card-text">Capacity: <?php echo $room['capacity']; ?></p>
                                <a href="#" class="btn btn-primary btn-edit" data-toggle="modal" data-target="#editRoomModal_<?php echo $room['room_id']; ?>">Edit Room</a>
                            </div>
                        </div>
                    </div>
                     <!-- Modal for editing room -->
            <div class="modal fade" id="editRoomModal_<?php echo $room['room_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editRoomModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editRoomModalLabel">Edit Room</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form to edit room details -->
                            <form action="../action/edit_room_action.php" method="post">
                                <div class="form-group">
                                    <label for="editRoomName">Room Name:</label>
                                    <input type="text" class="form-control" id="editRoomName" name="editRoomName" value="<?php echo $room['room_name']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="editRoomCapacity">Capacity:</label>
                                    <input type="number" class="form-control" id="editRoomCapacity" name="editRoomCapacity" value="<?php echo $room['capacity']; ?>" required>
                                </div>
                                <input type="hidden" id='roomId' name="roomId" value="<?php echo $room['room_id']; ?>">
                                <button type="button" class="btn btn-secondary d-flex justify-content-center view-roommates-btn" onclick="getRoomates(<?php echo $room['room_id']; ?>)" data-roomid="<?php echo $room['room_id']; ?>">View room-mates</button>
                                <div id='rommmates'></div>
                                <div class="modal-footer">
                                <a href="../action/delete_room_actions.php?room_id=<?php echo urlencode($room['room_id']); ?>" class="btn btn-danger" >Delete Room</a>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>
            <?php
                }
            } else {
                // Display a message if no rooms are available
                echo "<div class='col-md-12 text-center'><p>No rooms created</p></div>";
            }
            ?>
        
      <!-- Modal for adding a new room -->
<div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRoomModalLabel">Add New Room</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add the action attribute to submit the form to add_room__action.php -->
                <form id="addRoomForm" action="../action/add_room_action.php?capacity=.$_SESSION['capacity']." method="post">
                    <div class="form-group">
                        <label for="roomName">Room Name:</label>
                        <input type="text" class="form-control" id="roomName" name="roomName" placeholder="Enter room name" required>
                    </div>
                    <div class="form-group">
                        <label for="roomCapacity">Capacity:</label>
                        <input type="number" class="form-control" id="roomCapacity" name="roomCapacity" placeholder="Enter capacity" required>
                    </div>
                    <input type="hidden" id="hallId" name="hallId" value="<?php echo $hall_id; ?>">
                    <div class="modal-footer">
                <button type="button" class="btn btn-secondary close_room" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="addRoomBtn">Add Room</button>
            </div>
                </form>
            </div>
            
        </div>
    </div>
</div>

<!-- Dialog box HTML -->
<div class="modal fade" id="roomDialog" tabindex="-1" role="dialog" aria-labelledby="roomDialogLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roomDialogLabel">Give Out Room</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="roomForm" method="post" action="../action/add_student_to_room.php">
                    <div class="form-group">
                        <label for="roomSelect">Select Room:</label>
                        <select id="roomSelect" class="form-control" name="room_name">
                            <?php foreach ($hroomsa as $room) : ?>
                                <option  value="<?php echo $room['room_name']; ?>"><?php echo $room['room_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="userInput">Search Users:</label>
                        <input type="text" id="userInput" name="userInput" class="form-control" oninput="searchUsers(this.value)" onkeydown="stopSuggestions(event)">
                        <div id="userSuggestions"></div>
                    </div>
                    <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
                </form>
            </div>
            
        </div>
    </div>
</div>

<!-- Pop-up Dialog -->
<div class="modal fade" id="userInputDialog" tabindex="-1" role="dialog" aria-labelledby="userInputDialogLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userInputDialogLabel">Remove Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="userInputForm" action="../action/rm_student_fm_room.php" method="post">
                    <div class="form-group">
                        <label for="userInput">Search Users:</label>
                        <input type="text" id="userInput2" name="userInput2" class="form-control" oninput="searchUsers2(this.value)" onkeydown="stopSuggestions(event)">
                        <div id="userSuggestions2" class="suggestions-container"></div> <!-- Use the correct suggestions container -->
                    </div>
                    <input type="hidden" id='student_id'  name='student_id'/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger" id="removeUserBtn">Remove</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    </div>

    <script>

function updateRoommates(roomId, roommates) {
    // Select the appropriate modal and its room-mates element
    var modal = $("#editRoomModal_" + roomId);
    var roommatesContainer = modal.find("#rommmates");
    
    // Check if room-mates data is available
    if (roommates.length > 0) {
        // Create an unordered list to display room-mates
        var roommatesList = $("<ul>");
        
        // Iterate over each room-mate and append to the list
        roommates.forEach(function(roommate) {
            var listItem = $("<li>").text(roommate);
            roommatesList.append(listItem);
        });
        
        // Replace the room-mates content with the updated list
        roommatesContainer.html(roommatesList);
    } else {
        // If no room-mates are found, display a message
        roommatesContainer.html("<p>No room-mates found.</p>");
    }
}

function getRoomates(roomId) {
    $.ajax({
        type: "GET",
        url: "../functions/get_room_mates.php",
        data: { room_id: roomId },
        success: function(response) {

            var lines = response.split('<br>');
            
            // Initialize an array to store room-mates
            var roommates = [];
            
            // Extract room-mates' usernames from each line
            lines.forEach(function(line) {
                if (line.includes('Username:')) {
                    var username = line.split('Username: ')[1].trim();
                    roommates.push(username);
                }
            });
            
            // Update room-mates information in the modal
            updateRoommates(roomId, roommates);
        },
        error: function(xhr, status, error) {
            // Handle errors
            console.error(xhr.responseText);
        }
    });
}

function stopSuggestions(event) {
    event.stopPropagation();
}

        // Assuming $rooms is the array containing rooms data
    var rooms = <?php echo json_encode($rooms); ?>;
    var capacity = <?php echo $_SESSION['capacity']; ?>;

    // Get the button element
    var addButton = document.getElementById('btn-add-room');

    // Check if the count of rooms is equal to the capacity
    if (rooms.length === capacity) {
        // If it is, disable the button
        addButton.disabled = true;
    } else {
        // If it isn't, enable the button
        addButton.disabled = false;
        document.getElementById('btn-add-room').addEventListener('click', function() {
        $('#addRoomModal').modal('show');
    });
    }
    
    document.getElementById('btn-add-student-to-room').addEventListener('click', function() {
        console.log('clicked');
        $('#roomDialog').modal('show');
    });
    document.getElementById('btn-rm-student-fm-room').addEventListener('click', function() {
        console.log('clicked');
        $('#userInputDialog').modal('show');
    });

    
    function selectSuggestion(suggestion) {
        document.getElementById('userInput').value = suggestion;
        // Clear the suggestions container
        document.getElementById('userSuggestions').innerHTML = '';
    }

    // Function to handle user input and suggest options
    function searchUsers(inputValue) {
        // Clear previous suggestions
        document.getElementById('userSuggestions').innerHTML = '';

        // Filter suggestions based on input value
        var filteredSuggestions = <?php echo json_encode($userswithoutrooms); ?>.filter(function(user) {
            return user.username.toLowerCase().includes(inputValue.toLowerCase());
        });

        // Populate suggestions into the suggestions container
        filteredSuggestions.forEach(function(user) {
            var suggestionElement = document.createElement('div');
            suggestionElement.classList.add('suggestion');
            suggestionElement.textContent = user.username;
            suggestionElement.addEventListener('click', function() {
                selectSuggestion(user.username);
            });
            document.getElementById('userSuggestions').appendChild(suggestionElement);
        });
    }
    function selectSuggestion2(suggestion) {
    document.getElementById('userInput2').value = suggestion;
    // Clear the suggestions container
    document.getElementById('userSuggestions2').innerHTML = ''; // Use the correct suggestions container
}

// Function to handle user input and suggest options
function searchUsers2(inputValue) {
    // Clear previous suggestions
    document.getElementById('userSuggestions2').innerHTML = ''; // Use the correct suggestions container
    
    // Filter suggestions based on input value
    var filteredSuggestions = <?php echo json_encode($userswithrooms); ?>.filter(function(user) {
        return user.username.toLowerCase().includes(inputValue.toLowerCase());
    });

    // Populate suggestions into the suggestions container
    filteredSuggestions.forEach(function(user) {
        var suggestionElement = document.createElement('div');
        suggestionElement.classList.add('suggestion');
        suggestionElement.textContent = user.username;
        suggestionElement.addEventListener('click', function() {
            console.log('User: ',user.username)
            selectSuggestion2(user.username);
            document.getElementById('student_id').value=user.user_id;
            console.log(user.user_id)

            console.log('clicked')
        });
        document.getElementById('userSuggestions2').appendChild(suggestionElement); // Use the correct suggestions container
    });
}
</script>
</body>
</html>
