<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Page Not Found</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .container {
      text-align: center;
    }
    h1 {
      font-size: 48px;
      color: #333;
    }
    p {
      font-size: 24px;
      color: #666;
    }
    a {
      color: #5c48ee;
      text-decoration: none;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="container">
  <h1>404 ERROR!</h1>
  <p>Oops! The page you're looking for doesn't exist.</p>
  <p><a href="#" id="goBackLink">Go back to the previous page</a></p>
</div>

<script>
  // Add event listener to the anchor tag
  document.getElementById("goBackLink").addEventListener("click", function(event) {
    // Prevent the default action of the anchor tag
    event.preventDefault();
    
    // Navigate back to the previous page
    history.back();
  });
</script>


</body>
</html>
