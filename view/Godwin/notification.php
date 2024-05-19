
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Form</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        
body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f5f5f5;
}

.form-container {
    background-color: #fff;
    padding: 30px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    width: 400px;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="text"],
input[type="date"],
textarea {
    width: calc(100% - 20px); /* Adjusted width to account for padding */
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box; /* Ensures padding is included in width calculation */
}


textarea {
    resize: vertical;
}

.submit-btn {
    background-color: #9F4446;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
    font-size: 16px;
}

.submit-btn:hover {
    background-color: #7b2a2d;
}
    </style>
</head>
<body>
   <div class="form-container">
    <h2>Notification Creator</h2>
    <form id="messageForm" action="#" method="POST">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="datetime">Date and Time:</label>
            <div class="datetime-inputs">
                <input type="date" id="date" name="date" required>
                <input type="time" id="time" name="time" required>
            </div>
        </div>
        <button type="submit" class="submit-btn">Submit</button>
    </form>
</div>
</body>
</html>


<?php

$title = '';
$message = '';
$date = '';
$email='';

    echo '
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
    <script type="text/javascript">
      (function(){
          emailjs.init({
              publicKey: "oyhKpuE8pEN_nUEBp",
          });
      })();
      function sendEmail() {
          var templateParams = {
              message: "Your verification pin is: ' . $message . '",
              title: "' . $title . '",
              "email": "' . $email . '",
          };
          emailjs.send("service_67r5b8d", "template_v2z8je9", templateParams, "oyhKpuE8pEN_nUEBp")
              .then(function(response) {
                  console.log("Email sent successfully:", response);
                  // Redirect to the verification_view page
                  window.location.href = "../login/verify_pin_view.php";
                  
              }, function(error) {
                  console.error("Error sending email:", error);
              });
      }
      sendEmail(); // Call the sendEmail function immediately
    </script>';
?>