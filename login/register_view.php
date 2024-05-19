<?php
session_start();
include '../functions/select_role_fxn.php';

// if (isset($_SESSION['role_id']) && $_SESSION['role_id'] !== 1) {
//   echo '<script type="text/javascript">alert("You have been logged out."); window.location.href = "../login/logout_view.php";</script>';
//   exit();
// }

if (isset($_GET['registration']) && $_GET['registration'] == 'fail') {
  echo '<script type="text/javascript">alert("Registration unsuccessful!"); window.location.href = "login_view.php";</script>';
  exit();
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $passwd = $_POST['password'];
  $phone = $_POST['phone'];
  $bio = $_POST['bio'];
  $_SESSION['email'] = $email;
  $_SESSION['username'] = $username;
  $_SESSION['phone'] = $phone;
  $_SESSION['bio'] = $bio;


  // Encrypt password
  $hashed_password = password_hash($passwd, PASSWORD_DEFAULT);
  $_SESSION['hashed_password'] = $hashed_password;

  // Check if the email already exists
  $emailCheckQuery = "SELECT COUNT(*) as count FROM Users WHERE email = '$email'";
  $emailCheckResult = $con->query($emailCheckQuery);
  $emailCheckData = $emailCheckResult->fetch_assoc();

  if ($emailCheckData['count'] > 0) {
    echo '<script type="text/javascript">alert("An account with this email already exists."); window.location.href = "register_view.php";</script>';
  } else {
    echo '<script type="text/javascript">alert("Loading...");</script>';
    // Generate a random 6-digit pin
    $pin = mt_rand(100000, 999999);

    // Prepare the SQL query to insert the pin into the verificationPin table
    $insertPinQuery = "INSERT INTO VerifiablePins (pin, email) VALUES ('$pin', '$email')";
    $_SESSION['pin'] = $pin;

    // Execute the query to insert the pin
    if ($con->query($insertPinQuery) === TRUE) {
      // Send email using EmailJS
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
                  message: "Your verification pin is: ' . $pin . '",
                  "email": "' . $email . '",
                  "username": "' . $username . '",
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
    } else {
      echo "<script type='text/javascript'>console.log('Error: " . $con->error . "');</script>";
      echo "Error: " . $con->error;
    }
  }




}
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BuddyGo - Sign Up</title>
<link rel="stylesheet" href="../css/signup.css">
<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
  function validateForm(e) {
    var username = document.getElementById("username").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var role = document.getElementById("role").value;
    e.preventDefault();
    var usernameRegex = /^[a-zA-Z0-9_ ]{3,20}$/;
    var emailRegex = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,}$/;
    var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/;
    
    if (!username.match(usernameRegex)) {
      Swal.fire({
                    icon: 'error',
                    title: 'Error with username',
                    text: 'Username must be alphanumeric and between 3 to 20 characters.',
                    showConfirmButton: false,
            });
      // alert("Username must be alphanumeric and between 3 to 20 characters.");
      return false;
    }
    
    if (!email.match(emailRegex)) {
      Swal.fire({
                    icon: 'error',
                    title: 'Error with email',
                    text: 'Email must be in the format example@ashesi.edu.gh.',
                    showConfirmButton: false,
            });
      // alert("Email must be in the format example@ashesi.edu.gh");
      return false;
    }
    
    if (!password.match(passwordRegex)) {
      Swal.fire({
                    icon: 'error',
                    title: 'Error with password',
                    text: 'Password must contain at least one uppercase letter, one lowercase letter, one digit, and be at least 8 characters long.',
                    showConfirmButton: false,
            });

      // alert("Password must contain at least one uppercase letter, one lowercase letter, one digit, and be at least 8 characters long.");
      return false;
    }
    
    return true;
  }
  
  function togglePassword() {
    var passwordInput = document.getElementById("password");
    var icon = document.getElementById("password-toggle-icon");
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      icon.classList.remove("fa-eye-slash");
      icon.classList.add("fa-eye");
    } else {
      passwordInput.type = "password";
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
    }
  }

  document.getElementById("send_mail").addEventListener("submit", function() {
    document.getElementById("submitBtn").disabled = true;
  });

</script>
</head>
<body>
<div class="container">
        <h1>Join BuddyGo</h1>
        <p>Sign up now to start sharing rides and saving costs!</p>
        <form id='submitForm' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <input type="text" name="username" id="username" placeholder="Username" pattern="^[a-zA-Z0-9_\s]{3,20}$" title="Invalid username (alphanumeric, underscores, and spaces only, 3-20 characters)" required>
    <input type="email" name="email" pattern="^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$" placeholder="Email" required title="Invalid email address">
    <input type="tel" name="phone" pattern="^\+(?:[0-9] ?){6,14}[0-9]$" placeholder="Phone Number" title="Invalid phone number (use international format)" required>
    <div class="input-group">
      <textarea  type="text" name="bio" placeholder="Bio" required pattern="^[a-zA-Z0-9\s\-',.!?:;\(\)&$%@#]*$"></textarea>
    <input type="password" id="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$" name="password" placeholder="Password" title="Invalid password (at least one lowercase letter, one uppercase letter, one number and atleast a special character." required>
        <i id="password-toggle-icon" class="fas fa-eye-slash" onclick="togglePassword()"></i>
    </div>
    <button type="submit">Sign Up</button>
</form>
        <p>Already have an account? <a href="login_view.php">Sign in</a></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>
</html>