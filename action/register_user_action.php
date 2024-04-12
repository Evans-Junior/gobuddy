<?php
session_start();
include '../settings/connection.php';
// require_once '../functions/send_mail.php';
ini_set("SMTP", "smtp.gmail.com");
ini_set("smtp_port", "587");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username =$_POST['username'] ;
    $role_id=$_POST['role_id'];
    $email =$_POST['email'];
    $passwd =$_POST['password'];
    

    // Encrypt password
    $_SESSION['hashed_password']= password_hash($passwd, PASSWORD_DEFAULT);
    // Check if the email already exists
    $emailCheckQuery = "SELECT COUNT(*) as count FROM Users WHERE email = '$email'";
    $emailCheckResult = $con->query($emailCheckQuery);
    $emailCheckData = $emailCheckResult->fetch_assoc();

     // Generate a random 6-digit pin
     $pin = mt_rand(100000, 999999);

     // Prepare the SQL query to insert the pin into the database
     $query = "INSERT INTO VerifiablePins (pin, email) VALUES ('$pin', '$email')";

     // Execute the SQL query
     if ($con->query($query) === TRUE) {
         echo "Pin generated and saved successfully.";
     } else {
         echo "Error: " . $con->error;
         return false;
     }

     $message = "Your verification pin is:  $pin";

    // Prepare the SQL query to insert the user into the database
    echo '
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
<script type="text/javascript">
console.log("Hello");
   (function(){
      emailjs.init({
        publicKey: "oyhKpuE8pEN_nUEBp",
      });
   })();

   function sendEmail() {
      // Get user input
      var userEmail = "evans.kumi@ashesi.edu.gh";
      var toEmail = document.getElementById("email").value;
        console.log(pin);
      // Compose the email parameters
      var templateParams = {
         message: "Your verification pin is:  $pin"
         // Add more parameters as needed
      };

      // Send the email using EmailJS
      emailjs.send(\'service_67r5b8d\', \'template_v2z8je9\', templateParams)
         .then(function(response) {
            console.log(\'Email sent successfully:\', response);
            // Reset the form or show success message
         }, function(error) {
            console.error(\'Error sending email:\', error);
            // Show error message to the user
         });
         sendEmail();
   }
   
</script>';

    if ($emailCheckData['count'] > 0) {
        echo '<script type="text/javascript">console.log("An account with this email already exists.");</script>';
    } 
    else {
        echo "Error: " . $con->error;
    }
}
?>



