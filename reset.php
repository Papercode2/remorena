<!DOCTYPE html>
<html>
<head>
  <title>Password Reset</title>
</head>
<body style="background-color:powderblue;">
  <h2>Password Reset</h2>
  <form action="reset.php" method="post">
    <label for="email">Enter your email:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="password">New Password:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <label for="confirm_password">Confirm Password:</label>
    <input type="password" id="confirm_password" name="confirm_password" required>
    <br>
    <input type="submit" value="Reset Password">
  </form>
  
  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $email = $_POST["email"];
      $password = $_POST["password"];
      $confirm_password = $_POST["confirm_password"];
      
      // Validation checks
      if ($password !== $confirm_password) {
          echo "<p>Passwords do not match.</p>";
      } else {
          // Database connection (replace with your actual connection details)
          $connection = mysqli_connect("localhost", "root", "", "remorena");
          if (!$connection) {
              die("Database connection failed: " . mysqli_connect_error());
          }
          
          // Sanitize and escape email
          $email = mysqli_real_escape_string($connection, $email);
          
          // Hash the password
          $hashed_password = password_hash($password, PASSWORD_BCRYPT);
          
          // Update password in the database
          $update_query = "UPDATE users SET password='$hashed_password' WHERE email='$email'";
          $result = mysqli_query($connection, $update_query);
          
          if ($result) {
              echo "<p>Password updated successfully!</p>";
          } else {
              echo "<p>Error updating password: " . mysqli_error($connection) . "</p>";
          }
          
          // Close the database connection
          mysqli_close($connection);
      }
  }
  ?>
</body>
</html>